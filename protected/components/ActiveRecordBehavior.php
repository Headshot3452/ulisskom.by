<?php
    class ActiveRecordBehavior extends CActiveRecordBehavior
    {
       protected function getOwnerCriteriaAlias()
       {
           $owner = $this->getOwner();
           $criteria = $owner->getDbCriteria();
           $alias = $owner->getTableAlias();
           return array('owner' => $owner, 'criteria' => $criteria, 'alias' => $alias);
       }
    }
