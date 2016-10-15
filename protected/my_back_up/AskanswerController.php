<?php
class AskanswerController extends BackendController
{
    public static function getModuleName()
    {
        return Yii::t('app','Ask Answer');
    }

    public function actions()
    {
        return array(
            'index'=>array(
                'class'=>'actionsBackend.ListAction',
                'Model'=>'AskAnswer',
                'scenario'=>'search',
            ),
            'list'=>array(
                'class'=>'actionsBackend.ListAction',
                'Model'=>'AskAnswer',
                'scenario'=>'search',
            ),
            'view'=>'actionsBackend.ViewAction',
            'create'=>array(
                'class'=>'actionsBackend.UpdateAction',
                'Model'=>'AskAnswer',
                'scenario'=>'insert',
            ),
            'update'=>array(
                'class'=>'actionsBackend.UpdateAction',
                'Model'=>'AskAnswer',
                'scenario'=>'update',
            ),
            'create_group'=>array(
                'class'=>'actionsBackend.UpdateAction',
                'Model'=>'AskAnswerGroups',
                'scenario'=>'insert',
            ),
            'list_group'=>array(
                'class'=>'actionsBackend.ListAction',
                'Model'=>'AskAnswerGroups',
                'scenario'=>'search',
            ),
            'active' => 'actionsBackend.ActiveAction',
            'delete' => 'actionsBackend.DeleteAction',
            'upload' => 'actionsBackend.UploadAction',
            'settings' => 'actionsBackend.SettingsAction',
        );
    }
}