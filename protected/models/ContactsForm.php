<?php
class ContactsForm extends CFormModel
{
    public $name;
    public $phone;
    public $email;
    public $ask;
    public $message;
    public $captcha;
    public $parent_id;
    public $files;

    const PathImage='data/feedback/';

    public $item_file='';

    public function rules()
    {
        return array(
            array('name, email, phone, ask, message', 'filter', 'filter'=>'trim'),
            array('name, email, ask, parent_id', 'required', 'on'=>'insert'),
            array('email', 'email'),
            array('phone', 'match', 'pattern'=>Yii::app()->params['phone']['regexp']),
            array('captcha', 'captcha', 'allowEmpty'=>!extension_loaded('gd'), 'on'=>'insert'),
            array('files', 'safe', 'on'=>'search')
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>Yii::t('app','Your name'),
            'phone'=>Yii::t('app','Phone'),
            'email'=>Yii::t('app','Your e-mail'),
            'ask'=>Yii::t('app','Subject'),
            'message'=>Yii::t('app','Message'),
            'parent_id'=>Yii::t('app','Parent'),
            'captcha'=>'Введите символы'
        );
    }

    public function behaviors()
    {
        return array(
            'ImageBehavior'=>array(
                'class'=>'application.behaviors.ImageBehavior',
                'path'=>self::PathImage,
                'files_attr_model'=>'files',
                'sizes'=>array('small'=>array('250','250'),'big'=>array('1000','1000')),
                'quality'=>100
            ),
        );
    }

    public function onbeforeSave()
    {
        parent::onbeforeSave();
    }
}