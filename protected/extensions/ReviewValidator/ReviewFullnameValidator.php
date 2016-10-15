<?php

/**
 * Created by PhpStorm.
 * User: IWL20-PR
 * Date: 05.04.2016
 * Time: 16:28
 */
class ReviewFullnameValidator extends CValidator
{

    protected function validateAttribute($object, $attribute)
    {
        $set = ReviewSetting::model()->findAll();
        if ($set[2]->status == 0 and $set[3]->status == 1 and Yii::app()->user->isGuest and $object->$attribute == '')
        {
        $this->addError($object, $attribute, Yii::t('app', 'Error'));
        }
        else
        {
            $object->fullname = $object->$attribute;
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
        $condition=($set[2]->status == 0 and $set[3]->status == 1 and Yii::app()->user->isGuest);
        return "if(".$condition." && value=='') {messages.push(" . CJSON::encode(Yii::t('app', 'Error')) . ");}";
    }
} 