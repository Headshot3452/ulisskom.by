<?php
class CatalogTreeViewWidget extends StructureWidget
{
    public $category_id;
    protected $_data=array();

    public function setData()
    {
        if ($this->category_id == 'index')
        {
            $trees = CatalogTree::model()->roots()->active()->findAll();
        }
        else
        {
            $category = CatalogTree::model()->findByPk($this->category_id);

            if (!$category)
            {
                return false;
            }

            $trees = $category->children()->active()->findAll();
            $products = CatalogProducts::model()->getDataProviderForCategory($this->category_id);

            $this->_data['dataProducts'] = $products;
        }

        $this->_data['trees'] = $trees;

        return true;
    }

    public function renderContent()
    {
        $this->controller->renderPartial('//catalog/tree',$this->_data);
    }
}