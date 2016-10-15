<?php

class LastArticlesWidget extends StructureWidget
{
    public $count;
    protected $_items=array();


    public function setData()
    {
        $this->_items=Articles::getLastArticles($this->count,$this->owner->getCurrentLanguage()->id);

        if (empty($this->_items))
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