<?php
class BlocksController extends ModuleController
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
        return Yii::t('app','Blocks');
    }

    public function actions()
    {
        return array(
            'index'=>array(
                            'class'=>'actionsBackend.ListAction',
                            'Model'=>'TextBlocks',
                            'View'=>'list',
                            'scenario'=>'search'
                    ),
            'update'=>array(
                            'class'=>'actionsBackend.UpdateAction',
                            'scenario'=>'update',
                            'Model'=>'TextBlocks',
                            'View'=>'block'
                    ),
            'create'=>array(
                            'class'=>'actionsBackend.UpdateAction',
                            'scenario'=>'insert',
                            'Model'=>'TextBlocks',
                            'View'=>'block'
                    ),
            'settings'=>array('class'=>'actionsBackend.SettingsAction'),
            'delete'=> array(
                    'class'=>'actionsBackend.DeleteAction',
                    'Model'=>'TextBlocks',
            ),
        );
    }
}
?>
