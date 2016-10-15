<?php
    class NewsLastWidget extends StructureWidget
    {
        public $view = '3col+img'; //4col+img | 2col+img | 4col
        public $count = 3;
        public $dateFormat = 'd.m.Y';
        protected $_items = array();


        public function setData()
        {
            $this->_items=News::getLastNews($this->count, $this->owner->getCurrentLanguage()->id);

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

        public static function getView()
        {
            return array(
                'last_news' => 'По умолчанию',
                '2col+img'  => '2 колонки с изображением',
                '3col+img'  => '3 колонки с изображением',
                '4col+img'  => '4 колонки с изображением',
                '4col'      => '4 колонки',
            );
        }
    }