<?php
class AskAnswerSearchWidget extends StructureWidget
{
    public $view='view';
    protected $_data=array();

    public function setData()
    {
        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view);
    }
}
