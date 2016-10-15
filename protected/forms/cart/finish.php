<?php
return array(
    'form'=>array(
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
            'finish'=>array(
                'type'=>'string',
            ),
            'step'=>array('type'=>'hidden','value'=>'finish'),
        ),
        'buttons'=>array(
            'back'=>array('type'=>'submit','value'=>'Назад','class'=>'btn btn-link'),
            'step'=>array('type'=>'submit','value'=>'Подтвердить','class'=>'btn btn-danger'),
        ),
    ),
    'rules'=> array(
        array('cart,products,step','safe'),
    ),
    'attributesLabels'=>array(),
);
?>