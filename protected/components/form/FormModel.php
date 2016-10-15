<?php
    class FormModel extends CFormModel
    {
        public $attributes = array();
        public $labels = array();
        protected $_formConfig  =  array();
        protected $_formClass = 'Form';
        protected $_form = null;
        protected $_model = null;

        public function __construct($scenario = '', $config = array())
        {
            parent::__construct($scenario);
            $this->configure($config);
        }

        public function rules()
        {
            return $this->getRules();
        }

        public function attributeLabels()
        {
                return $this->labels;
        }

        public function configure($config)
        {
            if(is_string($config))
            {
                $config = require(Yii::getPathOfAlias($config).'.php');
            }

            if (is_array($config) && isset($config['form']))
            {
                $this->setFormConfig($config);
                $this->insertAttributes($config['form']);
                if (isset($config['attributesLabels']))
                {
                    $this->labels = $config['attributesLabels'];
                }
            }
        }

        public function setFormConfig($config)
        {
            $this->_formConfig=$config;
        }

        public function getForm()
        {
            if ($this->_form === null && !empty($this->_formConfig))
            {
                $this->_form = new $this->_formClass($this->_formConfig['form'], $this);
            }
            return $this->_form;
        }

        public function setRules($rules=array())
        {
            $this->_formConfig['rules']=$rules;
        }

        public function getRules()
        {
            if (isset($this->_formConfig['rules']))
            {
                return $this->_formConfig['rules'];
            }
            return array();
        }

        function getModel()
        {
            if ($this->_model=== null)
            {
                $this->_model= get_class($this);
            }
            return $this->_model;
        }

        public function insertAttributes($config)
        {
            if (isset($config['elements']))
            {
                foreach ($config['elements'] as $key=>$value)
                {
                    if (isset($value['type']) && $value['type']!='form' && $value['type']!='string')
                    {
                        $this->attributes[$key]='';
                    }
                    if (isset($value['label']))
                    {
                        $this->labels[$key]=$value['label'];
                    }
                    if (isset($value['elements']))
                    {
                        $this->insertAttributes($value);
                    }
                }
            }
        }

        public function __set($name, $value)
        {
            $method='set'.$name;
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
            else
            {
                $this->attributes[$name]=$value;
            }
        }

        public function __get($name)
        {
            $method='get'.$name;
            if (method_exists($this, $method))
            {
                return $this->$method();
            }
            else if (key_exists($name, $this->attributes))
            {
                return $this->attributes[$name];
            }
            else
            {
                throw new CException(Yii::t('yii','Property "{class}.{property}" is not defined.',
                    array('{class}'=>get_class($this), '{property}'=>$name)));
            }
        }
    }
