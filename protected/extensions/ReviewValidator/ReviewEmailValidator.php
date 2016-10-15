<?php

/**
 * Created by PhpStorm.
 * User: IWL20-PR
 * Date: 05.04.2016
 * Time: 16:28
 */
class ReviewEmailValidator extends CValidator
{

    protected function validateAttribute($object, $attribute)
    {
        $set = ReviewSetting::model()->findAll();
        if ($set[2]->status == 0 and $set[4]->status == 1 and $object->$attribute == '' and Yii::app()->user->isGuest)
        {
            $this->addError($object,$attribute, Yii::t('app', 'Error'));
        }
    }

    /**
     * Returns the JavaScript needed for performing client-side validation.
     * @param CModel $object the data object being validated
     * @param string $attribute the name of the attribute to be validated.
     * @return string the client-side validation script.
     * @see CActiveForm::enableClientValidation
     */
    public function clientValidateAttribute($object, $attribute)
    {
        $set = ReviewSetting::model()->findAll();
        $p="/^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/";
        $condition=($set[2]->status == 0 and $set[4]->status == 1)?'false':'true';
        return "if((".$condition."&& jQuery.trim(value)=='' && !value.match(".$p."))||(jQuery.trim(value)=='')) {messages.push(" . CJSON::encode(Yii::t('app', 'Error')) . ");}";
    }
} 