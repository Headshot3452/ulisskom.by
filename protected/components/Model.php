<?php
    class Model extends CActiveRecord
    {
        const STATUS_OK = 1;
        const STATUS_NOT_ACTIVE = 2;
        const STATUS_DELETED = 3;

        /**
         * array(
         *       'basic_entity_id'  (null) ?  Yii::app()->user->basic_entity_id,
         *       'content'=>array(); Required
         *        'type', Required
         *  );
         * @var array
         */

        protected $_journal = array();

        public function init()
        {
            parent::init();
            $this->onJournalSave = array('CoreEvents', 'onJournalSave');
        }

        public static function getStatus($key=null)
        {
            $array = array(
                self::STATUS_OK => Yii::t('app','Active'),
                self::STATUS_NOT_ACTIVE => Yii::t('app','Not active'),
                self::STATUS_DELETED => Yii::t('app','Deleted')
            );

            return $key === null ? $array : self::getArrayItem($array, $key);
        }

        public function getCriteriaAlias()
        {
            $alias=$this->getTableAlias();
            $criteria=$this->getDbCriteria();
            return array('alias'=>$alias,'criteria'=>$criteria);
        }

        public function active()
        {
            if ($this->hasAttribute('status'))
            {
                $array=$this->getCriteriaAlias();
                $array['criteria']->mergeWith(array(
                        'condition'=>'`'.$array['alias'].'`.`status`='.self::STATUS_OK
                        )
                );
            }
            return $this;
        }

        public function not_active()
        {
            if ($this->hasAttribute('status'))
            {
                $array=$this->getCriteriaAlias();
                $array['criteria']->mergeWith(array(
                        'condition'=>'`'.$array['alias'].'`.`status`='.self::STATUS_NOT_ACTIVE
                        )
                );
            }
            return $this;
        }

        public function deleted()
        {
            if ($this->hasAttribute('status'))
            {
                $array=$this->getCriteriaAlias();
                $array['criteria']->mergeWith(array(
                        'condition'=>'`'.$array['alias'].'`.`status`='.self::STATUS_DELETED
                        )
                );
            }
            return $this;
        }

        public function language($id)
        {
            if ($this->hasAttribute('language_id'))
            {
                $array=$this->getCriteriaAlias();
                $array['criteria']->mergeWith(array(
                        'condition'=>'`'.$array['alias'].'`.`language_id`='.$id
                    )
                );
            }
            return $this;
        }

        public function notDeleted()
        {
            if ($this->hasAttribute('status'))
            {
                 $array=$this->getCriteriaAlias();
                 $array['criteria']->mergeWith(array(
                         'condition'=>'`'.$array['alias'].'`.`status`!='.self::STATUS_DELETED
                         )
                 );
            }
            return $this;
        }

        protected function beforeDelete()
        {
            if (parent::beforeDelete())
            {
                if ($this->hasAttribute('status'))
                {
                    $this->status = self::STATUS_DELETED;
                    $this->save(false, 'status');
                    return false;
                }
                return true;
            }
            else
                return false;
        }

        public function getType($key = null)
        {
            $array = array(
                1 => 'Розница',
                2 => 'Опт',
                3 => 'Опт + Розница',
                4 => 'Услуга',
            );
            return ($key === null) ? $array : $this->getArrayItem($array, $key);
        }

        public function getUnitType($key = null)
        {
            $array = array(
                0 => '',
                1 => 'шт',
                2 => 'кг',
                3 => 'м',
                4 => 'с',
                5 => 'л',
                6 => 'см',
                7 => 'день',
                8 => 'месяц',
                9 => 'год',
                10 => 'упаковка'
            );

            if($key == null && isset($this->unit_id))
            {
                return $this->getArrayItem($array, $this->unit_id);
            }

            return ($key === null) ? $array : $this->getArrayItem($array, $key);
        }

        public function isAttributeRequired($attribute)
        {
        return parent::isAttributeRequired(preg_replace('/(\[\w+\|?])?(\w+)/', '$2', $attribute));
        }

        public function isAttributeSafe($attribute)
        {
            return parent::isAttributeSafe(preg_replace('/(\[\w+\])?(\w+)/', '$2', $attribute));
        }

        public static function getArrayItem($array, $key)
        {
            if (!is_array($array))
            {
                throw new CException('not Array');
            }
            if (!isset($array[$key]))
            {
               throw new CException("Not key - ".$key." in Array");
            }
            else
                return $array[$key];
        }

        public function afterSave()
        {
            parent::afterSave();
            if (!empty($this->_journal) and isset($this->_journal['content']) and isset($this->_journal['type']))
            {
                if ($this->hasEvent('onJournalSave'))
                {
                    $event=new CEvent($this);
                    $this->onJournalSave($event);
                }
            }
        }

        public function onJournalSave($event)
        {
            $this->raiseEvent('onJournalSave',$event);
        }

        public function getJournal()
        {
            return $this->_journal;
        }

        public function getInstanceRelation($relation_id,$scenario='insert')
        {
            $relations=$this->relations();
            if (isset($relations[$relation_id]) && isset($relations[$relation_id][1]))
            {
                return new $relations[$relation_id][1]($scenario);
            }
            throw new CException('Not relation - '.$relation_id.' in class '.get_class($this));
        }

        public function __clone()
        {
            $this->primaryKey = null;
            $this->oldPrimaryKey = null;
            $this->isNewRecord = true;
            $this->detachBehaviors();
        }
    }
