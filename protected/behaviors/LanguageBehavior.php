<?php
class LanguageBehavior extends ActiveRecordBehavior
{
    public function beforeSave($event)
    {
        $owner=$this->getOwner();
        if($owner->hasAttribute('language_id') && $owner->language_id===null)
        {
            $owner->language_id = Yii::app()->controller->getCurrentLanguage()->id;
        }
    }
}

?>