<?php
    class Action extends CAction
    {
        public $pk_id;
        public $Model;
        public $View;
        private $_modelName;
        private $_view;
        public $scenario = 'update';

        public function redirect($actionId = null)
        {
            if ($actionId === null)
            {
                $actionId = $this->controller->defaultAction;
            }
            $this->controller->redirect(array($actionId));
        }

        public function render($data, $return = false)
        {
            if ($this->_view === null)
            {
                if ($this->View===null)
                {
                    $this->_view=$this->id;
                }
                else
                {
                    $this->_view=$this->View;
                }
            }
           return $this->controller->render($this->_view,$data,$return);
        }

        public function renderPartial($view,$data,$return=false)
        {
           return $this->controller->renderPartial($view,$data,$return);
        }


        public function getModelName()
        {
            if ($this->_modelName===null)
            {
                if ($this->Model===null)
                {
                    $this->_modelName=ucfirst($this->controller->id);
                }
                else
                {
                    $this->_modelName=$this->Model;
                }
            }
            return $this->_modelName;
        }


        public function getModel($scenario=null)
        {
            if ($scenario!==null)
            {
                $this->scenario=$scenario;
            }

            $id=Yii::app()->request->getQuery('id',$this->pk_id);

            if ($this->scenario=='insert' || $this->scenario=='search')
            {
                $model= new $this->modelName($this->scenario); //Create empty model
            }
            elseif($id===null)
            {
                throw new CHttpException(404,Yii::t('base','The specified record cannot be found.'));
            }
            elseif (($model=CActiveRecord::model($this->modelName)->resetScope()->findByPk($id))===null) //model !empty
            {
                throw new CHttpException(404,Yii::t('base','The specified record cannot be found.'));
            }
            return $model;
        }

        public function refresh()
        {
            $this->controller->refresh();
        }
    }
