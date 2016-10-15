<?php
    class CartDeliveryForm  extends CFormModel
    {
        public $step;
        public $type_delivery;
        public $fio;
        public $phone;
        public $address;
        public $comment;
        public $city;
        public $email;

        public function rules()
        {
            return array(
                array('type_delivery, fio, phone, email', 'required'),
                array('step, city, address, comment', 'safe'),
                array('email', 'email'),
                array('city, address', 'required', 'on' => 'to_address')
            );
        }

        public function attributeLabels()
        {
            return array(
                'type_delivery' => 'Тип доставки',
                'fio' => 'Ф.И.О.',
                'phone' => 'Телефон',
                'address' => 'Адрес',
                'comment' => 'Примечание',
                'city' => 'Населенный пункт',
                'email' => 'E-mail',
            );
        }
    }