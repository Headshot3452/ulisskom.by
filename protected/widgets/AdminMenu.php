<?php
class AdminMenu extends Portlet
{
    public $items=array();
            
    public function init()
    {
        $this->title='AdminMenu';
        parent::init();
    }
 
    protected function renderContent()
    {
        $this->render('adminMenu');
    }
}
?>
