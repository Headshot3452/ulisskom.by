<?php

class ProfileController extends FrontendController
{
    public $layout = 'profile_left_menu';

    protected $order_periods = array('7' => 'Неделя', '30' => 'Месяц', '0' => 'Все');
    public $menu_title = 'My profile';

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
                'roles' => array(Users::ROLE_USER),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $user = Yii::app()->user->getUser();
        $user_info = UserInfo::getForUser($user->id);

        $this->render('settings', array('user_info' => $user_info, 'user' => $user));
    }

    public function actionOrder($id)
    {
        $order = Orders::model()->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->id));
        if (!$order) throw new CHttpException(404);

        $this->render('order', array('order' => $order));
    }

    public function actionOrderRating($id)
    {
        $order = Orders::model()->with('orderRating')->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->id));
        if (!$order) throw new CHttpException(404);

        if (!$order->orderRating) {
            $order->orderRating = new OrdersRating();
        }

        if ($order->orderRating->allowEdit() && !$order->allowEdit()) {
            if (isset($_POST['OrdersRating']) && $order->orderRating->allowEdit()) {
                $order->orderRating->attributes = $_POST['OrdersRating'];
                if ($order->orderRating->validate()) {
                    $order->orderRating->user_id = $order->user_id;
                    $order->orderRating->order_id = $order->id;
                    $order->orderRating->save();

                    Yii::app()->user->setFlash('alert-swal', array(
                        'header' => 'Отзыв сохранен',
                        'content' => 'Нам важно Ваше мнение.',
                    ));

                    $this->refresh();
                }
            }

            $this->render('order_rating_edit', array('order' => $order));
        } else {
            $this->render('order_rating', array('order' => $order));
        }
    }

    public function actionAskAnswer()
    {
        $this->render('ask_answer');
    }

    public function actionSupport()
    {
        $room = Rooms::getClientRoom(Yii::app()->user->id);
        if (!$room) {

        }

        $messages = RoomMessages::getMessagesFromRoom($room->id);

        $this->render('support', array('room' => $room));
    }


    public function actionSettings()
    {
        $user = Yii::app()->user->getUser();
        $user_info = UserInfo::getForUser($user->id);

        $this->render('settings', array('user_info' => $user_info, 'user' => $user));
    }

    public function actionSettingsEdit()
    {
        $user = Yii::app()->user->getUser();
        $user_info = UserInfo::getForUser($user->id);

        if (isset($_POST['UserInfo'])) {
            $user_info->attributes = $_POST['UserInfo'];
            if ($user_info->validate()) {
                if ($user_info->isNewRecord) {
                    $user_info->user_id = $user->id;
                }

                $user->scenario = 'update_avatar';
                $user->attributes = isset($_POST['Users']) ? $_POST['Users'] : array();
                $user->save();

                $user_info->save();

                Yii::app()->user->setFlash('alert-swal', array(
                    'header' => 'Ваши данные сохранены',
                    'content' => '',
                ));
                $this->refresh();
            }
        }

        $this->render('settings_edit', array('user_info' => $user_info, 'user' => $user));
    }

    public function getLeftMenu()
    {
        return array(
            array('label' => Yii::t('app','Profile'), 'url' => array('profile/index'), 'class' => in_array($this->action->id, array('settings', 'settingsedit', 'index')) ? 'active' : ''),
            array('label' => Yii::t('app','Delivery addresses'), 'url' => array('profile/addresses'), 'class' => in_array($this->action->id, array('addresses', 'address')) ? 'active' : ''),
            array('label' => Yii::t('app','Change e-mail'), 'url' => array('profile/changeemail'), 'class' => $this->action->id == 'changeemail' ? 'active' : ''),
            array('label' => Yii::t('app','Change password'), 'url' => array('profile/changepassword'), 'class' => $this->action->id == 'changepassword' ? 'active' : ''),
        );
    }

    public function actionAddresses()
    {
        $address = Address::getUserAddress(Yii::app()->user->id);
        $this->render('address', array('address' => $address));
    }

    public function actionAddress()
    {
        $model = new Address();

        $title = 'Добавление адреса доставки';
        if (isset($_GET['id'])) {
            $title = 'Редактирование адреса доставки';
            $model = $model::getAddressForUser($_GET['id'], Yii::app()->user->id);
            if (!$model) {
                throw new CHttpException(404);
            }
        }

        if (isset($_POST['Address'])) {
            $model->attributes = $_POST['Address'];

            if ($model->validate()) {
                $redirect = false;
                $message = 'Адрес сохранен';

                if ($model->isNewRecord) {
                    $model->user_id = Yii::app()->user->id;
                    $redirect = true;
                    $message = 'Адрес добавлен';
                }

//                if (!$model->city) {
//                    $model->addError('city_id', 'Не корректный населенный пункт');
//                }

                if (!$model->hasErrors() && $model->save(false)) {

                    Yii::app()->user->setFlash('alert-swal', array(
                        'header' => $message,
                        'content' => '',
                    ));
                    if ($redirect) {
                        $this->redirect(array('addresses'));
                    } else {
                        $this->refresh();
                    }
                }
            }
        }
        $this->render('address_save', array('model' => $model, 'title' => $title));
    }

    public function actionDeleteAddress($id)
    {
        $model = Address::getAddressForUser($id, Yii::app()->user->id);
        if (!$model) throw new CHttpException(404);

        $model->delete();
    }

    public function actionSetDefaultAddress($id)
    {
        $model = Address::getAddressForUser($id, Yii::app()->user->id);
        if (!$model) throw new CHttpException(404);

        $model->default = Address::ADDRESS_DEFAULT;
        $model->save();
    }

    public function actionChangePassword()
    {
        $model = Users::model()->findByPk(Yii::app()->user->id);
        $model->scenario = 'change_password';
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->password = $model->new_password;
                $model->save();

                Yii::app()->user->setFlash('alert-swal', array(
                    'header' => 'Пароль успешно изменен',
                    'content' => ''
                ));
                $this->refresh();
            }
        }
        $this->render('//user/change_password', array('model' => $model));
    }

    public function actionChangeEmail()
    {
        $model = Users::model()->findByPk(Yii::app()->user->id);
        $model->scenario = 'change_email';
        $model->new_email = $model->email;
        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->validate()) {
                $model->scenario = 'update';
                $model->email = $model->new_email;

                $model->save(true, array('email'));

                Yii::app()->user->login = $model->email;

                Yii::app()->user->setFlash('alert-swal', array(
                    'header' => 'Email успешно изменен',
                    'content' => ''
                ));
                $this->refresh();
            }
        }
        $this->render('//user/change_email', array('model' => $model));
    }
}

?>