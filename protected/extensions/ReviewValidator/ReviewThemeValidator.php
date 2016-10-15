<?php

/**
 * Created by PhpStorm.
 * User: IWL20-PR
 * Date: 05.04.2016
 * Time: 16:28
 */
class ReviewThemeValidator extends CValidator
{

    protected function validateAttribute($object, $attribute)
    {
        $set = ReviewSetting::model()->findAll();
        if ($set[0]->status == 1 and $object->$attribute == '')
        {
        $this->addError($object, $attribute, Yii::t('app', 'Error'));
        }
        else
        {
            $object->parent_id = $object->$attribute;
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
        $condition=($set[0]->status == 1);
        return "if(".$condition." && value=='') {messages.push(" . CJSON::encode(Yii::t('app', 'Error')) . ");}";
    }
} 