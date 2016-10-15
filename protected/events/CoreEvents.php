<?php
class CoreEvents extends CModelEvent
{
    public static function onLogin($event)
    {
        $sender=$event->sender;

        $UserSession=UsersSessions::model()->findByPk(Yii::app()->session->getSessionId());
        $UserSession->user_id=$sender->id;
        $UserSession->save();


        $Users = Users::model()->findByPk($sender->id);
        $Users->last_ip = CHttpRequest::getUserHostAddress();
        $Users->setScenario('login');

        $Users->update(true, 'last_ip');

        $check = UsersCheckAction::model()->not_active();
        $check->deleteAll($check->getDbCriteria());

        Core::clearTempDir();
    }

    public static function onUserRegister($event)
    {
        $sender=$event->sender;

        UsersCheckAction::insertAction($sender->id, UsersCheckAction::TYPE_REGISTRATION);

        $body=Yii::app()->controller->renderEmail('user_register',array('model'=>$sender));

        Core::sendAdminMessage($sender->email,$body,Yii::t('app','Register a new user'));
    }

	public static function onUserCheckAction($event)
    {
        $sender=$event->sender;

        $type=$sender->getTypeAction($sender->type_action);

        $body=Yii::app()->controller->renderEmail($type['view_email'],array('model'=>$sender,'action'=>$type['action']));

        Core::sendFromAdminMessage($sender->user->email,$body,$type['subject'].' '.$_SERVER['HTTP_HOST']);
    }

    public static function onNewOrder($event)
    {
        $sender = $event->sender;

        $body = Yii::app()->controller->renderEmail('new_order', array('model' => $sender));

        if(!isset($sender->email))
        {
            $info = unserialize($sender->user_info);
            $email = $info['email'];
        }
        else
        {
            $email = $sender->email;
        }
        Core::sendAdminMessage($email, $body, Yii::t('app', 'Issued a new order'));
    }

    public static function onAddModule($event)
    {
        $sender = $event->sender;

        $generator = new UrlManagerGenerator();

        $home = Structure::model()->roots()->language(Yii::app()->controller->getCurrentLanguage()->id)->find(); //find home id
        $generator->addModuleToStruct($sender->structure_id, $sender->structure->findUrlForItem('name', false, $home->id).$sender->structure->name, $sender->module->name);

        $config = Core::getConfigForModule($sender->module->name);
        $sender->structure->addModulePages($config['actions']);
    }

    public static function onDeleteModule($event)
    {
        $sender=$event->sender;

        $generator = new UrlManagerGenerator();
        $generator->deleteModuleFromStruct($sender->structure_id);

        $config=Core::getConfigForModule($sender->module->name);
        $sender->structure->removeModulePages($config['actions']);
    }

}
?>