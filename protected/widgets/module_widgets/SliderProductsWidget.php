<?php
class SliderProductsWidget extends StructureWidget
{
    public $view='slider';
    public $view_product=4;
    public $root_id=1;
    public $limit=15;
    protected $_data=array();

    public function setData()
    {
        $this->_data=CatalogProducts::model()->active()->findAll(array('limit'=>$this->limit,'order'=>'RAND()','condition'=>'t.parent_id IS NOT NULL and t.`images`!="" and t.`images`!="a:{}" and t.`stock`="1"'));

        if (empty($this->_data))
        {
            return false;
        }
        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view);
    }
}