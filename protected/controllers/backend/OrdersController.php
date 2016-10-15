<?php
    class OrdersController extends ModuleController
    {
        public $layout_in = 'backend_one_block';
        public $tabMenu = array();
        public $currency_ico = null;
        public $currency_ico_view = null;
        public $fio;
        public $email;
        public $phone;
        private $_active_category_id = null;
        private $_active_category = null;
        private $count = 20;

        public function init()
        {
            parent::init();

            $this->currency_ico = SettingsCurrency::model()->active()->with('currencyName')->find('currencyName.basic = :basic', array(':basic' => 1));
            $this->currency_ico_view = ($this->currency_ico->format_icon == 0) ? $this->currency_ico["currency_name"] : '<span class="'.$this->currency_ico->currencyName->icon.'">';

            $this->count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;
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
                array('deny',
                    'roles' => array(Users::ROLE_SEO),
                ),
            );
        }

        public static function getModuleName()
        {
            return Yii::t('app', 'Orders');
        }

        public static function getActionsConfig()
        {
            return array(
                'index' => array('label' => static::getModuleName(),'parent' => 'main_orders'),
                'order' => array('label' => Yii::t('app', 'Order'), 'parent' => 'index'),
                'payments' => array('label' => Yii::t('app', 'Payments'), 'parent' => 'index')
            );
        }

        public function actionOrder($id)
        {
            $order = Orders::model()->findByPk($id);

            $refresh = false;

            if(!$order)
            {
                throw new CHttpException('404');
            }

            $order_items = array_combine(CHtml::listData($order->orderItems, 'id', 'id'), $order->orderItems);

            if(isset($_POST))
            {
                for($i = 1; $i < 5; $i++)
                {
                    $note = "note".$i;
                    if(isset($_POST[$note]) && !empty($_POST[$note]))
                    {
                        $order->$note = ($_POST[$note]["text"] && $_POST[$note]["label"]) ? serialize($_POST[$note]) : '';
                        $refresh = true;
                    }
                }
            }

            if(isset($_POST['OrderItems']))
            {
                $sum = 0;
                $count = 0;

                foreach($_POST['OrderItems']["count_edit"] as $key => $value)
                {
                    $order_items[$key]->count_edit = $value;
                    $order_items[$key]->save();

                    $sum += ($order_items[$key]->discount) ? $order_items[$key]->getItemDiscount() : $order_items[$key]->getItemPrice();
                    $count += $order_items[$key]->getCount();
                }

                $order->sum = $sum;
                $order->count = $count;

                $order->save();

                $refresh = true;
            }

            if(isset($_POST['order_user']))
            {
                $user_info = unserialize($order->user_info);
                if(isset($_POST['order_user']['fio']))
                {
                    $new_fio = explode(' ', $_POST['order_user']['fio']);
                    $user_info['name'] = isset($new_fio[1]) ? $new_fio[1] : $user_info['name'];
                    $user_info['last_name'] = isset($new_fio[0]) ? $new_fio[0] : $user_info['last_name'];
                    $user_info['patronymic'] = isset($new_fio[2]) ? $new_fio[2] : $user_info['patronymic'];
                }

                if($_POST['order_user']['manager_id'])
                {
                    $order->manager_id = CHtml::encode($_POST['order_user']['manager_id']);
                }

                $user_info['email'] = $_POST['order_user']['email'];
                $user_info['phone'] = $_POST['order_user']['phone'];

                $order->user_info = serialize($user_info);

                $refresh = true;

                $order->save();
            }

            if (!empty($_POST['products']))
            {
                $data = CJSON::decode($_POST['products']);
                if (!empty($data))
                {
                    $products = $order->orderItems;
                    $oldProducts = array_combine(array_keys(CHtml::listData($products,'id','id')),$products);
                    $count = count($data);

                    for ($i = 0; $i < $count; $i++)
                    {
                        $id = $data[$i]['id'];
                        if (isset($oldProducts[$id]))
                        {
                            if ($oldProducts[$id]->count_edit != $data[$i]['countEdit'] || $oldProducts[$id]->status != $data[$i]['status'])
                            {
                                $oldProducts[$id]->count_edit = $data[$i]['countEdit'];
                                $oldProducts[$id]->status = $data[$i]['status'];
                                $oldProducts[$id]->save();
                            }
                            unset($oldProducts[$id]);
                        }
                        else
                        {
                            $product = new OrderItems();
                            $product->attributes = $data[$i];
                            $product->order_id = $order->id;
                            $product->count_edit = $data[$i]['countEdit'];
                            $product->product_type_add = $data[$i]['type'];
                            $product->save();
                        }
                    }

                    foreach($oldProducts as $item)
                    {
                        if ($item->product_type_add == OrderItems::ADMIN_ADD_PRODUCT)
                        {
                            $item->delete();
                        }
                    }

                    $sum = 0;
                    $count = 0;
                    $products = $order->getRelated('orderItems', true);
                    foreach($products as $product)
                    {
                        if ($product->status == OrderItems::STATUS_OK)
                        {
                            $sum += ($product->discount) ? $product->getItemDiscount() : $product->getItemPrice();
                            $count += $product->getCount();

                        }
                    }
                    $order->count = $count;
                    $order->sum = $sum;
                    if ($order->sum > $order->getDeliveryLimit())
                    {
                        $order->sum_delivery = 0;
                    }
                    $order->save();

                    $this->refresh();
                }
            }

            $managers = Users::model()->findAllByAttributes(array('role' => Users::ROLE_MODER), array('with' => 'user_info'));
            $workers = Workers::model()->findAll();

            $this->pageTitleBlock = $this->renderPartial('_order_bar', array('order' => $order), true);

            if(isset($_POST['Orders']))
            {
                $order->attributes = $_POST['Orders'];
                $refresh = true;

                $order->sum = str_replace(" ", "", $order->sum);
                $order->sum_paid = str_replace(" ", "", $order->sum_paid);

                if($order->sum_paid > 0)
                {
                    if($order->sum_paid < $order->sum)
                    {
                        $order->paid = Orders::ORDER_PARTIALLY;
                    }
                    elseif($order->sum_paid == $order->sum)
                    {
                        $order->paid = Orders::ORDER_PAID;
                    }
                    else
                    {
                        $order->paid = Orders::ORDER_EXCEEDED;
                    }
                }
                else
                {
                    $order->paid = Orders::ORDER_NOT_PAID;
                }

                $order->save();
            }


            if($refresh)
            {
                Yii::app()->user->setFlash('alert-swal',
                    array(
                        'header' => 'Выполнено',
                        'content' => 'Данные успешно сохранены!',
                    )
                );

                $this->refresh();
            }

            $this->render('order',
                array(
                    'order' => $order,
                    'managers' => $managers,
                    'workers' => $workers,
                    'products' => $order->orderItems
                )
            );
        }

        public function actionIndex()
        {
            $managers = Users::model()->findAllByAttributes(array('role' => Users::ROLE_MODER), array('with' => 'user_info'));
            $picker = Workers::model()->findAllByAttributes(array('role' => Workers::ROLE_PICKER));
            $executor = Workers::model()->findAllByAttributes(array('role' => Workers::ROLE_EXECUTOR));

            $managers_list = array();
            foreach($managers as $item)
            {
                $managers_list['m_'.$item->id] = $item->getFullName();
            }

            $workers = array(
                'Менеджеры' => $managers_list,
                'Сборщики' => $this->setKeyPrefix($picker, 'id', 'name', 'w_'),
                'Исполнители' => $this->setKeyPrefix($executor, 'id', 'name', 'w_'),
            );

            //поля соортировки

            $sort_list = array(
                'delivery_time' => 'По оставшемуся времени',
                'user_id' => 'По клиенту',
                'sum_asc' => 'По сумме (возрастание)',
                'sum_desc' => 'По сумме (убывание)',
                'count' => 'По количеству товаров в заказе',
            );

            //период в unixtime

            $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
            $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));

            //определяем по кому фильтруем, по менеджеру или работникам

            $manager_id = '';
            $worker_id = '';
            if($worker = Yii::app()->request->getParam('worker'))
            {
                $worker_data = explode('_',$worker);

                if(count($worker_data) == 2)
                {
                    //у менеджера префикс m, у работника w

                    if($worker_data[0] == 'm')
                    {
                        $manager_id = $worker_data[1];
                    }
                    elseif($worker_data[0] == 'w')
                    {
                        $worker_id = $worker_data[1];
                    }
                }
            }

            //сортировка

            $order = 'DESC';
            $sort = 't.id';
            if(($sort_param = Yii::app()->request->getParam('sort')) && isset($sort_list[$sort_param]))
            {
                //если есть постфикс _desc или _asc
                if(strpos($sort_param,'_desc') !== false)
                {
                    $sort = 't.'.str_replace('_desc','',$sort_param);
                }
                elseif(strpos($sort_param,'_asc') !== false)
                {
                    $sort = 't.'.str_replace('_asc','',$sort_param);
                    $order = 'ASC';
                }
                else
                {
                    $sort = 't.'.$sort_param;
                }
            }

            $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 10;

            $this->pageTitleBlock = $this->renderPartial('_filter', array('workers' => $workers, 'sort_list' => $sort_list), true);
            $provider = Orders::getAdminOrdersProvider($count, '', Yii::app()->request->getParam('status'), $manager_id, $worker_id, $date_from, $date_to, $sort, $order);
            $this->render('index', array('dataProvider' => $provider, 'count' => $count));
        }

        public function actionPayments()
        {
            $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
            $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));

            $model = new OrderPayments();

            $sort_list = array(
                'create_time_asc' => 'По времени (возрастание)',
                'create_time_desc' => 'По времени (убывание)',
                'order_id_asc' => 'По заказу (возрастание)',
                'order_id_desc' => 'По заказу (убывание)',
            );

            //сортировка

            $order = 'DESC';
            $sort = 't.id';
            if(($sort_param = Yii::app()->request->getParam('sort')) && isset($sort_list[$sort_param]))
            {
                if(strpos($sort_param, '_desc') !== false)
                {
                    $sort = 't.'.str_replace('_desc', '', $sort_param);
                }
                elseif(strpos($sort_param, '_asc') !== false)
                {
                    $sort = 't.'.str_replace('_asc', '', $sort_param);
                    $order = 'ASC';
                }
                else
                {
                    $sort = 't.'.$sort_param;
                }
            }

            $dataProvider = $model->getAdminPaymentsProvider($this->count, $date_from, $date_to, $sort, $order);

            $this->pageTitleBlock = $this->renderPartial('_filter_payments', array('sort_list' => $sort_list), true);

            $this->render('payments', array('dataProvider' => $dataProvider, 'count' => $this->count));

        }

        public function actionChangeStatus($status,$id)
        {
            $order = Orders::model()->findByPk($id);

            if(!$order) throw new CHttpException('404');

            try{
                Orders::getStatus($status);

                $order->status = $status;

                $order->save();

            }
            catch(Exception $ex){
                echo $ex->getMessage();
            }

            Yii::app()->end();
        }

        protected function setKeyPrefix($array,$key_attr,$val_attr,$pref='')
        {
            $new_array = array();
            foreach($array as $item)
            {
                $new_array[$pref.$item->{$key_attr}] = $item->{$val_attr};
            }

            return $new_array;
        }

        protected  function strToTime($str)
        {
            if($str)
            {
                $date = explode('.', $str);
                if(count($date) == 3)
                {
                    return mktime(0, 0, 0, $date[1], $date[0], $date[2]);
                }
            }
            return '';
        }

        public function getLeftMenuModal()
        {
            $model = new CatalogTree();

            $categories = $model::getAllTree($this->getCurrentLanguage()->id);
                return array_merge(
                array(
                    array(
                        'text' => CHtml::link('<img class="root-folder-orange" src="/images/icon-admin/folder-orange.png">
                        <span class="modal_first"></span>', array('create_category'), array('class' => 'active root')), 'children' => array()
                    )
                ),
                NestedSetHelper::nestedToTreeViewWithOptions($categories, 'id', $this->getTreeOptionsModal())
            );
        }

        public function getTreeOptionsModal()
        {
            return array(
                array('catalog_icon' => 'icon', 'title' => 'title', 'url' => '', 'data-id' => '')
            );
        }

        public static function getTopMenu()
        {
            return array(
                'orders' => array('label' => Yii::t('app', 'Orders'), 'url' => array('orders/index')),
                'payments' => array('label' => Yii::t('app', 'Payments'), 'url' => array('orders/payments')),
            );
        }

        public function actions()
        {
            return array(
                'orders_add_products' => array(
                    'class' => 'actionsBackend.Orders.OrdersAddProductsAction',
                    'Model' => 'OrdersItem',
                ),
                'add_products_save' => array(
                    'class' => 'actionsBackend.Orders.OrdersAddProductsSaveAction',
                    'Model' => 'Orders',
                ),
            );
        }
    }
