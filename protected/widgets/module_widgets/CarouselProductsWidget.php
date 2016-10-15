<?php
    class CarouselProductsWidget extends StructureWidget
    {
        public $type = 'sale';
        public $title = '';
        public $count_items = '5';
        public $category_id = null;
        protected $_data;

        public function setData()
        {
            $model = CatalogProducts::model();

            $method = ucfirst($this->type);
            call_user_func(array($model, 'type'.$method));

            $model->active();

            if(!is_null($this->category_id))
            {
                $model->parent($this->category_id);
            }

            $this->_data = $model->findAll(array('select' => 'id, images, parent_id, title, price, sale_info, name'));

            if (empty($this->_data))
            {
                return false;
            }
            return true;
        }

        public function renderContent()
        {
            if (!empty($this->_data))
            {
                $this->render(get_class().'/'.$this->view);
            }
        }
    }