<?php
class ContactsController extends ModuleController
{
	public $layout_in='backend_one_block';

	public function init()
    {
        parent::init();
    }

    public static function getModuleName()
    {
        return Yii::t('app','Contacts');
    }

    public function actions()
   	{
       return array(
                    'update'=>array(
                        'class'=>'actionsBackend.Contacts.ContactsUpdateAction',
                        'scenario'=>'update',
                    ),
                    'params_sort'=> array(
                        'class'=>'actionsBackend.Contacts.SortAction',
                        'Model'=>'ContactsPhone',
                    ),
                );
   	}

   	public function actionIndex()
    {
        $model_phone = new ContactsPhone();
        $model_address = new ContactsAddress();

        $criteria = new CDbCriteria();
        $criteria->order = 'sort ASC';

        $data_phone = $model_phone::model()->findAll($criteria);
        $data_address = $model_address::model()->findAll();

        $setting = Settings::model()->find();

        $this->render('index', array('model_phone'=>$model_phone,
                                     'model_address'=>$model_address,
                                     'data_phone'=>$data_phone,
                                     'data_address'=>$data_address,
                                     'setting'=>$setting
                                    ));
    }

    protected function beforeRender($view)
    {
        if(!parent::beforeRender($view))
        {
            return false;
        }

        $this->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/news.png'), $this->createUrl('admin/siteManagement')).self::getModuleName(),$this->createUrl('admin/siteManagement'));

        return true;
    }
}