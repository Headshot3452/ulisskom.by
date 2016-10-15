<?php
    class Controller extends CController
    {
        public $main_menu = array();
        public $pageTitles = array();

        public $url = array();

        protected $_home = null;

        protected  $_languages = array();
        protected $_language = null;

        public function init()
        {
            parent::init();
            if (Yii::app()->request->getIsAjaxRequest())
            {
                $this->layout = 'clear';
                CHtml::$liveEvents = FALSE;
                Yii::app()->clientScript->scriptMap['jquery.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientScript->scriptMap['jquery.yiiactiveform.js'] = false;
            }
        }

        public function setTitle($action)
        {
            if(isset($this->pageTitles[$action->id]))
            {
                $this->setPageTitle($this->pageTitles[$action->id]);
            }
        }

        protected function beforeAction($action)
        {
            if(!parent::beforeAction($action))
            {
                return false;
            }

            $this->setTitle($action);

            $this->setLanguage(); // init application language

            return true;
        }

        public function getLanguages()
        {
            if(!$this->_languages)
            {
                $this->_languages = Language::model()->findAll();
            }
            return $this->_languages;
        }

        /**
         * Возвращает информацию по языку который в базе
         * @return CActiveRecord|null
         * @throws CHttpException
         */

        public function getCurrentLanguage()
        {
            if($this->_language === null)
            {
                $this->_language = Language::getLanguageByCode(Yii::app()->language);

                if(!$this->_language)
                {
                    throw new CHttpException(404, 'Language not found');
                }
            }
            return $this->_language;
        }

        /**
         * Устанавливаем язык приложения для пользоватедя
         * @param $code
         * @return CActiveRecord
         * @throws CHttpException
         */

        public function setCurrentLanguage($code)
        {
            $language = Language::getLanguageByCode($code);

            if(!$language)
            {
                throw new CHttpException(404, 'Language not found');
            }

            $this->_language = $language;

            return $this->_language;
        }

        public function setLanguage()
        {
            return true;
        }

        /**
         * Render email
         * @param $view
         * @param $data
         * @return string
         */

        public function renderEmail($view, $data = array())
        {
            if (!empty($view))
            {
                $file = $this->resolveViewFile('email.'.$view, '', '');
                return $this->renderInternal($file, $data, true);
            }
        }

        public function getHome()
        {
            if ($this->_home === null)
            {
                $home = Structure::getHome($this->getCurrentLanguage()->id);
                if ($home)
                {
                    $this->_home = $home;
                }
                else
                    throw new CHttpException(404);
            }

            return $this->_home;
        }

        public function getHomeId()
        {
            return $this->getHome()->id;
        }

        public function findUrl($item, $type = 'structure')
        {
            if (!isset($this->url[$type][$item->id]))
            {
                $name = '';
                $home_id = null;
                if ($type == 'structure')
                {
                    $home_id = $this->getHomeId();
                    if ($item->id != $home_id)
                    {
                        $name = $item->name;
                    }
                }
                $this->url[$type][$item->id] = $item->findUrlForItem('name', false, $home_id).$name;
            }
            return $this->url[$type][$item->id];
        }

        /**
         * Получить url до страницы
         * @param $id
         * @return mixed
         */

        public function getUrlById($id)
        {
            return $this->findUrl(Structure::model()->findByPk($id, array('select'=>'t.`id`, t.`lft`, t.`rgt`, t.`level`, t.`root`, t.`name`')));
        }

        public function getCountryFromAPI()
        {
            $methodUrl = Yii::app()->basePath.'/data/countries.json';
            $json = file_get_contents($methodUrl, false);
            $arr = json_decode($json, true);

            return(CHtml::listData($arr['response']['items'], 'title', 'title'));
        }
    }