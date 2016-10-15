<?php
    class SettingsController extends ModuleController
    {
        public $layout_in = 'backend_one_block';

        public function actionIndex()
        {
            $menu = array(
                array('title' => 'Общие настройки', 'url' => $this->createUrl('generalSettings'), 'image' => Yii::app()->params['icons']['main_settings']),
                array('title' => 'Сотрудники, права доступа', 'url' => $this->createUrl('permission'), 'image' => Yii::app()->params['icons']['permission']),
                array('title' => 'Настройки ярлыков', 'url' => $this->createUrl('settingsLabel'), 'image' => 'images/icon-admin/settings-label.png'),
                array('title' => 'Настройка "Тэги"', 'url' => $this->createUrl('tags/blog'), 'image' => 'images/icon-admin/settings-label.png'),
                array('title' => 'Настройки статуса клиента в форуме', 'url' => $this->createUrl('statusForum'), 'image' => 'images/icon-admin/settings-label.png')
            );

            $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('admin/'));
            $this->pageTitleBlock .= '<span class="pull-left title">'.Yii::t('app', 'The settings of all modules').'</span>';

            $this->render('//admin/menu_list', array('menu' => $menu));
        }

        public function filters()
        {
            return array(
                'accessControl',
            );
        }

        public function accessRules()
        {
            return array(
                array('allow',
                    'roles' => array(Users::ROLE_ADMIN),
                ),
                array('deny',
                    'roles' => array(Users::ROLE_MODER, Users::ROLE_MANAGER, Users::ROLE_SEO),
                ),
            );
        }

        public function actionRegister()
        {
            $user = new Users('register_admin');
            $user_info = new UserInfo();
            $address = new Address();

            if(Yii::app()->params['site']['allow_register'] && isset($_POST['Users']) && isset($_POST['UserInfo']) && isset($_POST['Address']))
            {
                $user->attributes = $_POST['Users'];
                $user_info->attributes = $_POST['UserInfo'];
                $address->attributes = $_POST['Address'];

                $address->user_name = $user_info->getFullName();
                $address->phone = $user_info->phone;

                $user_valid = $user->validate();
                $userinfo_valid = $user_info->validate();
                $address_valid = $address->validate();

                if($user_valid && $userinfo_valid && $address_valid)
                {
                    $user->user_info = $user_info;
                    $user->addresses = $address;

                    $user->login = $user->email;

                    $user->status = Users::STATUS_NOT_ACTIVE;
                    $user->role = Users::ROLE_USER;

                    $user->save(false);
                    $this->refresh();
                }
            }
            $this->render('registration', array('user' => $user, 'user_info' => $user_info, 'address' => $address));
        }

        public function actionGeneralSettings()
        {
            $menu = array(
                array('title' => 'Базовые настройки сайта', 'url' => $this->createUrl('basicSettings'), 'image'=>'images/icon-admin/base-settings.png'),
                array('title' => 'Валюта', 'url' => $this->createUrl('currency'), 'image'=>'images/icon-admin/currency.png'),
            );

            $this->render('//admin/menu_list',array('menu' => $menu));
        }

        public function actionPermission()
        {
            $model = new Users('permission');

            $address_val = true;

            if(isset($_GET['id']))
            {
                $item = $model->findByPk(CHtml::encode($_GET['id']));
                $item->scenario = 'settings_user';

                if (Yii::app()->request->isAjaxRequest && isset($_GET['id_role']))
                {
                    $item->role = $_GET['id_role'];
                    $item->save();
                    Yii::app()->end();
                }

                if(isset($_POST['Users']) && isset($_POST['UserInfo']) && isset($_POST['Address']))
                {
                    $update = array();

                    $item->user_info->scenario = 'settings_user';

                    $item->_oldPass = $item->password;

                    $item->attributes = $_POST['Users'];
                    $item->user_info->attributes = $_POST['UserInfo'];

                    $user_val = $item->validate();
                    $info_val = $item->user_info->validate();

                    $db = $item->addresses;

                    if ($db)
                    {
                        $items = array_combine(CHtml::listData($db,'id','id'), $db);
                    }

                    foreach($_POST['Address'] as $key=>$value)
                    {
                        if (isset($items[$value['id']]))
                        {
                            $temp = $items[$value['id']];
                            $temp->attributes = $value;
                            if($temp->validate())
                            {
                                $update[] = $temp;
                            }
                            unset($items[$item['id']]);
                        }
                    }

                    if($user_val && $info_val && $address_val)
                    {
                        if($item->_oldPass != $_POST['Users']['password'])
                        {
                            $item->password = CPasswordHelper::hashPassword($_POST['Users']['password']);
                            $body = Yii::app()->controller->renderEmail('new_password', array('pass' => $_POST['Users']['password']));
                            Core::sendFromAdminMessage($item->email, $body, Yii::t('app', 'New password').' '.$_SERVER['HTTP_HOST']);
                        }
                        else
                        {
                            $item->password = $item->_oldPass;
                        }

                        $item->update();
                        $item->user_info->update();

                        if (!empty($update))
                        {
                            foreach($update as $upd)
                            {
                                $upd->update();
                            }
                        }

                        Yii::app()->user->setFlash('alert-swal',
                            array(
                                'header' => 'Выполнено',
                                'content' => 'Данные профиля сохранены!',
                            )
                        );

                        $this->refresh();
                    }
                }

                $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('settings/permission'));
                array_pop($this->_breadcrumbs);
                $this->_breadcrumbs[] = $item->user_info->getFullName();
                $this->pageTitleBlock.= $this->renderPartial('_users_page_title', array('model' => $item), true);
                $this->render('users_page', array('item' => $item));
            }
            else
            {
                $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;

                if(isset($_POST['Users']))
                {
                    $model->attributes = $_POST['Users'];
                    $items = $model->notDeleted()->getDataProviderForUsers($model, $count);
                }
                else
                {
                    $items = $model->notDeleted()->search($count);
                }

                $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('index'));
                $this->pageTitleBlock .= $this->renderPartial('_all_users_page_title', array('model'=>$model), true);

                $this->render('permission', array('model' => $items, 'count' => $count));
            }
        }

        public function actionCurrency()
        {
            $model = new SettingsCurrency();

            if(!empty($_POST['currency']))
            {
                foreach($_POST['currency'] as $key => $value)
                {
                    if($value)
                    {
                        $model_update = new SettingsCurrency();
                        $item = ($model_update->findByPk($key)) ?: $model_update;
                        $item->currency_name = $value;
                        $item->course = (isset($_POST['SettingsCurrency']['course'][$key])) ? $_POST['SettingsCurrency']['course'][$key] : 1;

                        if($item->isNewRecord)
                        {
                            $criteria = new CDbCriteria();
                            $criteria->select = 'MAX(`sort`) as `sort`';
                            $sort = SettingsCurrency::model()->active()->find($criteria);
                            $item->sort = $sort->sort + 1;
                        }

                        if($item->save())
                        {
                            unset($item);
                            unset($model_update);
                        }
                    }
                }
            }

            $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('settings/generalsettings'));
            $this->pageTitleBlock .=
                                '<div class="img-cont">
                                    <a href="'.$this->createUrl("settings/generalsettings").'">
                                        <img src="/images/icon-admin/currency.png" alt="" title="">
                                    </a>
                                </div>';
            $this->pageTitleBlock .= '<span class="pull-left title">'.Yii::t('app', 'Currency').'</span>';

            $this->pageTitleBlock .= $this->renderPartial('_currency_page_title', array(), true);

            $items = $model->notDeleted()->findAll(array('with' => 'currencyName', 'order' => 'sort'));
            $this->render('currency', array('items' => $items, 'model' => $model));
        }

        public function actionCurrencyIcon()
        {
            $model = new SettingsCurrencyList();
            $item = $model->findByPk($_POST['id']);
            echo $item->icon;
        }

        public function actionCurrencyOneItem()
        {
            $model = new SettingsCurrencyList();
            $this->renderPartial('_currency_one_item_ajax',array('item' => $model));
        }

        public function actionSettingslabel()
        {
            $model = Modules::model()->active()->findAll();

            if(isset($_POST['Modules']))
            {
                foreach($model as $item)
                {
                    $item->on_main = $_POST['Modules'][$item->id]['on_main'];
                    $item->save(false, 'on_main');
                }
            }

            $this->render('labels',array('item' => $model));
        }

        public function actionNotification()
        {
            $menu = array();

            $this->render('//admin/menu_list',array('menu' => $menu));
        }

        public function actionStatusForum()
        {
            $model = new ForumStatus();
            $data = ForumStatus::model()->findAll();

            $this->pageTitleBlock=BackendHelper::htmlTitleBlockDefault('Настройки статуса клиента в форуме','/admin/settings');

            $this->render('status_forum', array('model'=>$model, 'data'=>$data));
        }

        public static function getActionsConfig()
        {
            return array(
                    'index'             => array('label' => 'Настройки всех модулей','parent'=>'main_settings'),
                    'generalsettings'   => array('label' => 'Общие настройки','parent'=>'index'),
                    'basicsettings'     => array('label' => 'Базовые настройки сайта', 'parent' => 'generalsettings'),
                    'currency'          => array('label' => 'Валюта','parent'=>'generalsettings'),
                    'notification'      => array('label' => 'Оповещения','parent'=>'generalsettings'),
                    'permission'        => array('label' => 'Все пользователи','parent'=>'index'),
                    'register'          => array('label' => 'Добавление нового пользователя', 'parent'=>'permission'),
                    'settingslabel'     => array('label' => 'Настройки ярлыков','parent'=>'index'),
                    'statusforum'     => array('label' => 'Настройки статуса клиента в форуме','parent'=>'index')
            );
        }

        public function actions()
        {
            return array(
                'basicsettings' => array(
                    'class' => 'actionsBackend.UpdateAction',
                    'pk_id' => 1,
                    'View' => 'index',
                    'scenario' => 'update',
                ),
                'update_currency' => array(
                    'class'=>'actionsBackend.Settings.CurrencyUpdateAction',
                ),
                'update_label' => array(
                    'class'     => 'actionsBackend.UpdateAction',
                    'scenario'  => 'update',
                    'View'      => 'labels',
                    'Model'     => 'Modules',
                ),
                'upload' => 'actionsBackend.UploadAction',
                'active' => array(
                    'class' => 'actionsBackend.ActiveAction',
                    'scenario' => 'update_status',
                    'Model' => 'Users',
                ),
                'delete_user' => array(
                    'class' => 'actionsBackend.DeleteAction',
                    'Model' => 'Users',
                    'scenario' => 'update_status',
                ),
                'products_sort' => array(
                    'class' => 'actionsBackend.Tree.SortAction',
                    'Model' => 'SettingsCurrency',
                ),
                'status_products' => array(
                    'class' => 'actionsBackend.Tree.StatusAction',
                    'Model' => 'Users',
                ),
                'update_forum_status' => array(
                    'class' => 'actionsBackend.Settings.ForumStatusUpdateAction',
                    'Model' => 'ForumStatus',
                ),
            );
        }
    }