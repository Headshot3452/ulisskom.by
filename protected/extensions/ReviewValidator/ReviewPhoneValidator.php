<?php

/**
 * Created by PhpStorm.
 * User: IWL20-PR
 * Date: 05.04.2016
 * Time: 16:28
 */
class ReviewPhoneValidator extends CValidator
{

    protected function validateAttribute($object, $attribute)
    {

        $set = ReviewSetting::model()->findAll();
        if ($set[2]->status == 0 and $set[5]->status == 1 and $object->$attribute == '' and Yii::app()->user->isGuest)
        {
            $this->addError($object, $attribute, Yii::t('app', 'Error'));
        }
        elseif($set[2]->status == 0 and $set[5]->status == 1 and Yii::app()->user->isGuest and preg_match('/^\+[0-9]{5,25}$/', $object->$attribute) != 1)
        {
            $this->addError($object, $attribute, Yii::t('app', 'Invalid format'));
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
        $pattern='/^\+[0-9]{5,25}$/';
        $condition=($set[2]->status == 0 and $set[5]->status == 1 and Yii::app()->user->isGuest);
//        return "if(".$condition." && value=='') {messages.push(" . CJSON::encode(Yii::t('app', 'Error')) . ");}";
            return "{if(".$condition." && value=='') {messages.push(" . CJSON::encode(Yii::t('app', 'Error')) . ");}
                    if(".$condition." && !value.match(".$pattern.")) {messages.push(" . CJSON::encode('Неверный формат') . ");}}";

//        elseif(preg_match(, $object->$attribute) != 1)
//        {
//            return "messages.push(" . CJSON::encode(Yii::t('app', 'Invalid format')) . ");";
//        }
    }
} 