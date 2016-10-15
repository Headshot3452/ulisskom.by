<?php
class PromotionsController extends ModuleController
{
    public function init()
    {
        parent::init();

        $this->addButtonsLeftMenu('create', array(
                'url'=>$this->createUrl('create')
            )
        );
    }

    public static function getModuleName()
    {
        return Yii::t('app','Banners');
    }

	public function actions()
    {
        return array(
            'index'=>array(
                            'class'=>'actionsBackend.ListAction',
                            'Model'=>'Banners',
                            'View'=>'list',
                            'scenario'=>'search'
                    ),
            'update'=>array(
                            'class'=>'actionsBackend.UpdateAction',
                            'scenario'=>'update',
                            'Model'=>'Banners',
                            'View'=>'banner'
                    ),
             'create'=>array(
                            'class'=>'actionsBackend.UpdateAction',
                            'scenario'=>'insert',
                            'Model'=>'Banners',
                            'View'=>'banner'
                    ),
            'upload'=>array('class'=>'actionsBackend.UploadAction'),
            'settings'=>array('class'=>'actionsBackend.SettingsAction')
        );
    }
}
?>