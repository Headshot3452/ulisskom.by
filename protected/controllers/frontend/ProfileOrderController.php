<?php

class ProfileOrderController extends FrontendController
{
    public $layout = 'profile_left_menu';

    protected $order_periods = array('7' => 'Неделя', '30' => 'Месяц', '0' => 'Все');
    public $menu_title = 'My orders';

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
        $this->render('index');
    }

    public function actionOrder()
    {
        $this->render('one-order');
    }

    public function actionEstimate()
    {
        $this->render('estimate');
    }

    public function actionArchive()
    {
        $this->render('archive');
    }

    public function actionNotification()
    {
        $this->render('notifications');
    }

    public function getLeftMenu()
    {
        return array(
            array('label' => Yii::t('app', 'History of orders'), 'url' => array('profileorder/index'), 'class' => in_array($this->action->id, array('index', 'order', 'estimate')) ? 'active' : ''),
            array('label' => Yii::t('app', 'Archive'), 'url' => array('profileorder/archive'), 'class' => in_array($this->action->id, array('archive')) ? 'active' : ''),
            array('label' => Yii::t('app', 'Notifications'), 'url' => array('profileorder/notification'), 'class' => $this->action->id == 'notification' ? 'active' : ''),
        );
    }

}

?>