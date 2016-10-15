<?php
class CatalogTreeWidget extends StructureWidget
{
    protected $_items=array();
    public $view;

    public function setData()
    {
        $model = new CatalogTree();
        $categories = Yii::app()->db->createCommand("
            SELECT `t`.`id`, `t`.`title`, `t`.`name`, `t`.`level`, `t`.`status`, `t`.`images`
            FROM `".$model->tableName()."` `t`
            WHERE `t`.`status`!=3 AND `t`.`language_id`='".$this->controller->getCurrentLanguage()->id."'
            ORDER BY  t.`root`,t.`lft` ")->queryAll();
        $this->_items = NestedSetHelper::nestedToTreeViewWithOptions($categories, 'name', array(array('title' => 'title')));

        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view, array('items' => $this->_items));

    }
}