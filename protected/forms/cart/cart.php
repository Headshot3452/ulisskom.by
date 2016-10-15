<?php
    return array(
        'form' => array(
            'class' => 'form-horizontal center',
            'activeForm' =>  array(
                'class'  =>  'CActiveForm',
                'enableClientValidation' => true,
                'clientOptions' =>  array(
                    'validateOnSubmit'  => true,
                    'validateOnChange'  =>  true,
                ),
            ),
            'showErrorSummary' => true,
            'elements' => array(
                'cart' => array(
                    'type' => 'string',
                ),
                'products' => array(
                    'type' => 'hidden',
                ),
                'step' => array('type' => 'hidden', 'value' => 'payment'),
            ),
            'buttons' => array(
                'step' => array('type' => 'submit', 'value' => 'Оформить заказ', 'class' => 'btn btn-danger pull-right'),
            ),
        ),
        'rules' =>  array(
            array('cart,step', 'safe'),
            array('products', 'length', 'min' => '3', 'tooShort' => 'Добавьте хотя бы один продукт в корзину'),
            array('products', 'CartProductsValidator')
        ),
        'attributesLabels' => array(),
    );