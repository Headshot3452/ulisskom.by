<?php
return array(
    'form'=>array(
        'title'=>'Выбор способа доставки',
        'class'=>'form-horizontal center',
        'activeForm'=> array(
            'class' => 'CActiveForm',
            'enableClientValidation'=>true,
            'clientOptions'=> array(
                'validateOnSubmit' =>true,
                'validateOnChange' => true,
            ),
        ),
        'showErrorSummary'=>true,
        'elements'=>array(
            'type_delivery'=>array(
                'type'=>'dropdownlist',
                'items'=>Orders::getTypeDelivery(),
                'prompt'=>'Выберите способ доставки',
                'class'=>'form-control',
            ),
            'address_id'=>array(
                'type'=>'hidden'
            ),
            'address'=>array(
                'type'=>'string',
            ),
            'step'=>array('type'=>'hidden','value'=>'delivery'),
        ),
        'buttons'=>array(
            'back'=>array('type'=>'submit','value'=>'Назад','class'=>'btn btn-link'),
            'step'=>array('type'=>'submit','value'=>'Вперед','class'=>'btn btn-primary'),
        ),
    ),
    'rules'=> array(
        array('type_delivery','required'),
        array('addresses,address_id,step','safe'),
        array('address_id','required','on'=>'to_address','message'=>'Выберите адрес')
    ),
    'attributesLabels'=>array(
        'type_delivery'=>'Тип доставки'
    ),
);
?>