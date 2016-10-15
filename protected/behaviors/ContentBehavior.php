<?php
class ContentBehavior extends ActiveRecordBehavior
{
	public function setAuthor()
	{
            $owner=$this->getOwner();
            if ($owner->author_id!=null)
            {
                return $owner->author_id;
            }
            else
            {
                return Yii::app()->user->id;
            }
	}
	
	
	public function setName()
	{
            $owner=$this->getOwner();
            if (($name=$owner->name)==null)
            {
                $name=Core::strToUrl($owner->title); //translit title
            }
            return $name;
	}
		
	public function beforeSave($event)
	{
            $owner=$this->getOwner();

            if ($owner->hasAttribute('author_id'))
                $owner->author_id=$this->setAuthor();

            if ($owner->hasAttribute('name'))
                $owner->name=$this->setName();
	}
	
	
	
}

?>