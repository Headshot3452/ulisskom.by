<?php
class Portlet extends CWidget
{
    public $title;
    public $visible=true;
    
    public function init()
    {
        if ($this->visible)
        {
            
        }
    }
    
    public function run()
    {
        if ($this->visible)
        {
            $this->renderContent();
        }
    }
    
    protected function renderContent()
    {
        
    }
}
?>
