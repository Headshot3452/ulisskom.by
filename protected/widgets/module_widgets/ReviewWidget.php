<?php
class ReviewWidget extends StructureWidget
{
    public $view='view';
    public $settings;
    public $model;

    public function setData()
    {
        $this->model = new ReviewItem('insert');
        $this->settings= ReviewSetting::model()->findAll(array('select' => 'id, status'));
        return true;
    }

    public function renderContent()
    {
        $this->render(get_class().'/'.$this->view,array('review'=>$this->model,'setting'=>$this->settings));
    }
}