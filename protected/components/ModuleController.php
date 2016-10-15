<?php
class ModuleController extends BackendController
{
    public $buttons_left_menu=array();

    public $buttons_right_menu=array();

    public static function getModuleName()
    {
        return Yii::t('app','Module');
    }

    public function actions()
    {
        return array(
            'index'=>array(
                          'class'=>'actionsBackend.ListAction',
                          'scenario'=>'search',
                    ),
            'list'=>array(
                          'class'=>'actionsBackend.ListAction',
                          'scenario'=>'search',
                    ),
            'view'=>'actionsBackend.ViewAction',
            'create'=>array(
                          'class'=>'actionsBackend.UpdateAction',
                          'scenario'=>'insert',
                    ),
            'update'=>array(
                            'class'=>'actionsBackend.UpdateAction',
                            'scenario'=>'update',
                    ),
            'active' => 'actionsBackend.ActiveAction',
            'delete' => 'actionsBackend.DeleteAction',
            'upload' => 'actionsBackend.UploadAction',
            'settings' => 'actionsBackend.SettingsAction',
        );
    }

    public static function getActionsConfig()
    {
        return array(
            'index'=>array('label'=>static::getModuleName(),'parent'=>'admin/sitemanagement'),
              'list'=>array('label'=>Yii::t('app','List'),'parent'=>'index'),
              'view'=>array('label'=>Yii::t('app','View'),'parent'=>'index'),
              'create'=>array('label'=>Yii::t('app','Create'),'parent'=>'index'),
              'update'=>array('label'=>Yii::t('app','Update'),'parent'=>'index'),
              'settings'=>array('label'=>Yii::t('app','Settings'). ' ' .static::getModuleName(),'parent'=>'settings/index'),
        );
    }

    /**
     * @param $type - type Button
     * @param $params
     */
    public function addButtonsLeftMenu($type, $params)
    {
        $this->buttons_left_menu[$type] = $params;
    }

    public function hasButtonsLeftMenu($type)
    {
        if (isset($this->buttons_left_menu[$type]))
        {
            return $this->buttons_left_menu[$type];
        }

        return false;
    }

    /**
     * @param $type - type Button
     * @param $params
     */
    public function addButtonsRightMenu($type,$params)
    {
        $this->buttons_right_menu[$type]=$params;
    }

    public function hasButtonsRightMenu($type)
    {
        if (isset($this->buttons_right_menu[$type]))
        {
            return $this->buttons_right_menu[$type];
        }

        return false;
    }
}
?>