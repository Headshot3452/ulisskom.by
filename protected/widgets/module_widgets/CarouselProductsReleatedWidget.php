<?php
    class CarouselProductsReleatedWidget extends StructureWidget
    {
        public $title = 'Сопутствующие товары';
        public $count_items = '5';
        public $product_id = null;
        protected $_data = array();

        public function setData()
        {
            $model = CatalogProducts::model()->findByPk($this->product_id);

            foreach ($model->productsReleateds as $rel)
            {
                $this->_data[] = $rel->releated;
            }

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