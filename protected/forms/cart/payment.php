<?php
return array(
    'form'=>array(
        'title'=>'Выбор способа оплаты',
        'class'=>'form-horizontal center',
        'activeForm'=> array(
            'class' => 'CActiveForm',
            'enableClientValidation'=>true,
            'id'=> 'companyEdit',
            'clientOptions'=> array(
                'validateOnSubmit' =>true,
                'validateOnChange' => true,
            ),
        ),
        'elements'=>array(
            'type_payment'=>array(
                'type'=>'dropdownlist',
                'items'=>Orders::getTypePayment(),
                'class'=>'form-control',
            ),
            'step'=>array('type'=>'hidden','value'=>'cart'),
        ),
        'buttons'=>array(
            'back'=>array('type'=>'submit','value'=>'Назад','class'=>'btn btn-link'),
            'step'=>array('type'=>'submit','value'=>'Вперед','class'=>'btn btn-primary'),
        ),
    ),
    'rules'=> array(
        array('type_payment','required'),
        array('step','safe'),
    ),
    'attributesLabels'=>array(
            'type_payment'=>'Оплата'
    ),
);
?>