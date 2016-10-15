<?php
    class CartForm extends CFormModel
    {
        public $cart;
        public $products;
        public $step;

        public function rules()
        {
            return array(
                array('cart, step', 'safe'),
                array('products', 'length', 'min' => '3', 'tooShort' => 'Добавьте хотя бы один продукт в корзину'),
            );
        }

        public function getTotalProductsSum()
        {
            $value = CJSON::decode($this->products);
            $sum = 0;

            if (!empty($value))
            {
                foreach($value as $item)
                {
                    $sum += $item['count'] * $item['price'];
                }
            }
            return $sum;
        }
    }