<?php
    class FeedbackWidget extends StructureWidget
    {
        public $model;
        public $view = 'view';
        public $settings;

        public function setData()
        {
            $this->model = new ContactsForm();
            $this->settings = Settings::model()->find();
            return true;
        }

        public function renderContent()
        {
            $this->render(get_class().'/'.$this->view,array('model'=>$this->model, 'settings'=>$this->settings));
        }

        public static function getView()
        {
            return array('view'=>'По умолчанию');
        }
    }