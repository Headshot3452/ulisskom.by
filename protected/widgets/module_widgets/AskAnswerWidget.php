<?php
class AskAnswerWidget extends StructureWidget
{
    public $view='ask_answer';
    protected $_data=array();

    public function setData()
    {
        $categories=AskAnswer::model()->active()->language($this->controller->getCurrentLanguage()->id)->findAll();

        foreach($categories as $category)
        {
            $this->_data[]=array('category'=>$category,'ask'=>AskAnswer::model()->active()->findAllByAttributes(array('group_id'=>$category->id)));
        }
        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view);
    }
}