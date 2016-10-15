<?php
return array(
    'form'=>array(
        'title'=>'Контактные данные',
        'class'=>'',
        'activeForm'=> array(
            'class' => 'BsActiveForm',
            'enableClientValidation'=>true,
            'id'=> 'contactsData',
            'clientOptions'=> array(
                'validateOnSubmit' =>true,
                'validateOnChange' => true,
            ),
        ),
        'elements'=>array(
            'company'=>array(
                'type'=>'text',
            ),
            'ynn'=>array(
                'type'=>'text',
            ),
            'name'=>array(
                'type'=>'text',
            ),
            'phone'=>array(
                'type'=>'text',
            ),
            'email'=>array(
                'type'=>'text',
            ),
            'message'=>array(
                'type'=>'textarea',
            ),
            'step'=>array('type'=>'hidden','value'=>'info'),
        ),
        'buttons'=>array(
            'back'=>array('type'=>'submit','value'=>'Назад','class'=>'btn btn-link'),
            'step'=>array('type'=>'submit','value'=>'Вперед','class'=>'btn btn-primary'),
        ),
    ),
    'rules'=> array(
        array('email,phone','required'),
        array('email','email'),
        array('step,company,ynn,name,message','safe'),
    ),
    'attributesLabels'=>array(
            'company'=>'Название организации',
            'ynn'=>'УНН',
            'name'=>'Контактное лицо',
            'phone'=>'Контактный телефон',
            'email'=>'E-mail',
            'message'=>'Дополнительная информация'
    ),
);
?>