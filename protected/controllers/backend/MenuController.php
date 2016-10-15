<?php
class MenuController extends ModuleController
{
    public $layout_in='backend_left_tree';

    public $_active_category_id = null;
    private $_active_category = null;

    protected $_categories=array();

    public function filters()
    {
        return array(
            'ajaxOnly + create'
        );
    }

    public static function getModuleName()
    {
        return Yii::t('app','Menu');
    }

    public function actions()
    {
        return array(
            'update'=>array(
                'class'=>'actionsBackend.Menu.UpdateAction',
                'scenario'=>'update',
                'Model'=>'MenuItem',
                'View'=>'menu'
            ),
            'up'=>array(
                'class'=>'actionsBackend.Nested.NestedUpAction',
                'scenario'=>'update',
                'Model'=>'MenuItem'
            ),
            'down'=>array(
                'class'=>'actionsBackend.Nested.NestedUpAction',
                'scenario'=>'update',
                'Model'=>'MenuItem'
            ),
            'tree_update'=>array(
                'class'=>'actionsBackend.Menu.NestedMoveTreeAction',
                'Model'=>'MenuItem'
            ),
            'active'=>array(
                    'class'=>'actionsBackend.Nested.NestedActiveAction',
                    'Model'=>'MenuItem'
             ),
             'delete'=>array(
                            'class'=>'actionsBackend.Nested.NestedDeleteAction',
                            'Model'=>'MenuItem'
             ),
            'settings'=>array('class'=>'actionsBackend.SettingsAction'),
        );
    }

    public function actionIndex()
    {
        $this->redirect($this->createUrl('update'));
    }

    public function getLeftMenu()
    {
        $categories=$this->getCategories();

        return array_merge(
            array(array('text' => CHtml::link('<img class="root-folder-orange add_list" src="/images/icon-admin/add_list.png">'.Yii::t('app', 'Create menu'), array('update')), 'children' => array())
            ), NestedSetHelper::nestedToTreeViewWithOptions($categories, 'id', $this->getTreeOptions(), $this->_active_category_id)
        );

    }

    public function getCategories()
    {
        if (empty($this->_categories))
        {
            $this->_categories=MenuItem::getTreeForMenu($this->getCurrentLanguage()->id);
        }
        return $this->_categories;
    }

    protected function beforeRender($view)
    {
        if (!parent::beforeRender($view))
        {
            return false;
        }

        $this->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/menu.png'), $this->createUrl('admin/siteManagement')).self::getModuleName(),$this->createUrl('admin/siteManagement'));
        
        return true;
    }

    public function getTreeOptions()
    {
        return array(
            array('icon'=>'icon','title'=>'title','url'=>$this->createUrl('update').'?id='),
        );
    }

}

?>
