<?php

/**
 *
 * example
 *  'SortUpDownBehavior'=>array(
 *       'class' => 'behaviors.SortUpDownBehavior',
 *       'same_attributes'=>array(
 *                           'language_id'
 *                    ),
 *   )
 */
class SortUpDownBehavior extends CActiveRecordBehavior
{
    const SIGN_UP='<';
    const SIGN_DOWN='>';

    public $sort_attribute='sort';
    public $same_attributes=array();

    public function moveUp()
    {
        $this->moveItem(self::SIGN_UP);
    }

    public function moveDown()
    {
        $this->moveItem(self::SIGN_DOWN);
    }

    public function moveItem($sign)
    {
        $owner=$this->getOwner();

        $same=$this->findFollow($sign);

        if ($same)
        {
            $prev=$same->{$this->sort_attribute};
            $same->sort($owner->{$this->sort_attribute});
            $owner->sort($prev);
        }
    }

    public function findFollow($sign)
    {
        $owner=$this->getOwner();

        $criteria=new CDbCriteria();
        $criteria->condition='`t`.`'.$this->sort_attribute.'`'.$sign.''.$owner->{$this->sort_attribute};

        if (!empty($this->same_attributes))
        {
            foreach($this->same_attributes as $key=>$value)
            {
                if ($owner->{$value} != null)
                {
                   $criteria->addCondition('`t`.`'.$value.'`='.$owner->{$value});
                }
                else
                {
                    $criteria->addCondition('`t`.`'.$value.'` IS NULL');
                }
            }
        }
        $criteria->order='`t`.`'.$this->sort_attribute.'` '.(($sign==self::SIGN_UP) ? 'DESC' : '');

        return $owner::model()->active()->find($criteria);
    }


    public function sort($sort)
    {
        $owner=$this->getOwner();

        $owner->{$this->sort_attribute}=$sort;
        $owner->update($this->sort_attribute);
    }

    public function beforeSave($event)
    {
        $owner=$this->getOwner();

        if($owner->isNewRecord)
        {
            //установить сортировочный аттрибут
            $criteria=new CDbCriteria;
            $criteria->select='MAX('.$this->sort_attribute.') AS '.$this->sort_attribute;
            $max = $owner::model()->find($criteria);
            $owner->{$this->sort_attribute}=$max->{$this->sort_attribute}+1;
        }
    }
}