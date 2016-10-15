<?php
    class BackendController extends Controller
    {
        public $layout = 'backend';
        public $layout_in = 'backend_left_menu';

        public $menu = array();
        public $pageTitleBlock; //кусок верстки для загловка в правом блоке страницы

        protected $_activeActions = array();
        protected  $_topMenuTitle = ''; //заголовок самого верхнего самого главного выпадающего меню

        protected $_breadcrumbs = array();

        public function getLeftMenu()
        {
            return $this->getMenuByActionsConfig();
        }

        public static function getActionsConfig()
        {
            return array();
        }

        public function getLeftDroplist()
        {
            return array();
        }

        public function filters()
        {
            return array(
                'accessControl',
              );
        }

        public function accessRules()
        {
            return array(
                array('allow',
                    'roles' => array(Users::ROLE_MODER, Users::ROLE_SEO),
                ),
                array('deny',
                    'actions' => array('siteManagement'),
                    'roles' => array(Users::ROLE_MANAGER),
                ),
                array('allow',
                    'controllers' => array('admin', 'orders', 'catalog'),
                    'roles' => array(Users::ROLE_MANAGER),
                ),
                array('deny',
                    'users' => array('*'),
                ),
            );
        }

        public function beforeAction($action)
        {
            if(!parent::beforeAction($action))
            {
                return false;
            }

            $crumbs = array();

            $config = static::getActionsConfig();
            $controller = get_class($this);
            $this->addActiveAction($action->id,$controller);

            //если есть в экшен в конфиге, то генерим крошки по конфигу

            if(!empty($config[$action->id]))
            {
                $item = $config[$action->id];

                $title = (isset($item['title'])) ? $item['title'] : $item['label'];
                $crumbs[] = $title;
                $this->setPageTitle($title);

                //проходим по цепочке родителей, добавляя их в крошки

                while(!empty($item['parent']))
                {
                    $exp=explode('/',$item['parent']); //проверям может нужно с другого контроллера подгрузить
                    if (isset($exp[1]))
                    {
                        $controller=ucfirst($exp[0]).'Controller';
                        Yii::import('application.controllers.backend.'.$controller); //импортируем контроллер
                        $item['parent'] = $exp[1];
                        $config=$controller::getActionsConfig(); //выгружаем новый конфиг
                    }

                    //если есть родитель в _actionsConfig,то продолжаем обход, иначе ищем родителя в getTopMenuItems и завершаем

                    if(!empty($config[$item['parent']]))
                    {
                        $this->addActiveAction($item['parent'],$controller);

                        $action_id = $item['parent'];
                        $item = $config[$item['parent']];

                        $title=(isset($item['title'])) ? $item['title'] : $item['label'];
                        $crumbs[$title] = array($this->id.'/'.$action_id);

                    }
                    else
                    {
                        $top = $this->getTopMenuItems();
                        if(!empty($top[$item['parent']]))
                        {
                            $this->addActiveAction($item['parent'],''); //добавим ключ в меню

                            $parent = $top[$item['parent']];
                            $count=count($crumbs);
                            array_pop($crumbs);
                            if ($count>1)
                            {
                                $crumbs[$parent['label']] = $parent['url'];
                            }
                            else
                            {
                                $crumbs[]=$parent['label'];
                            }
                            $this->_topMenuTitle = $parent['label'];
                        }
                        break;
                    }

                }
                //сливаем с реверсным массивом, т.к просматривали с конца
                $this->_breadcrumbs = array_merge($this->_breadcrumbs,  array_reverse($crumbs));
            }
            else
            {
                $this->_breadcrumbs[] = $action->id;
            }

            return true;
        }

        protected function beforeRender($view)
        {
            if (!parent::beforeRender($view))
            {
                return false;
            }

            if ($this->pageTitleBlock === null)
            {
                $this->pageTitleBlock = $this->getPageTitleBlockDefault();
            }

            return true;
        }

        public function getBreadcrumbs()
        {
            return $this->_breadcrumbs;
        }

        public function setLastBreadcrumb($title)
        {
            array_pop($this->_breadcrumbs);
            $this->_breadcrumbs[] = $title;
        }

        /**
         * $this->$_actionsConfig to array() for menu
         * @param type $active_action string - key active action
         * @param type $type string
         * @return type array menu
         */

        public function getMenuByActionsConfig($active_action=null,$type=null)
        {
            $menu = array();

            if ($active_action === null)
            {
                $active_action = Yii::app()->controller->action->id;
            }

            foreach (static::getActionsConfig() as $key => $item)
            {
                $add = false;
                if ($type && isset($item['type']))
                {
                    if (in_array($type, explode(',', $item['type'])))
                    {
                        $add = true;
                    }
                }
                elseif(!$type)
                {
                    $add = true;
                }
                if ($add)
                {
                    $menu[] = array(
                        'label' => (isset($item['label'])) ? $item['label'] : '',
                        'url' => (isset($item['url'])) ? $item['url'] : $this->createUrl($key),
                        'description' => (isset($item['description'])) ? $item['description'] : '',
                        'active' => (isset($item['active'])) ? $item['active'] : ($active_action == $key ? 1 : 0),
                    );
                }
            }
            return $menu;
        }

        public function getTreeDataMenu($data, $parentUrl, $deleteParentUrl = '', $childUrl = '', $deleteChildUrl = '')
        {
            $treeData = array();

            foreach($data as $key => $val)
            {
                $item = array();
                $item['text'] = CHtml::link($val['text'], $this->createUrl($parentUrl, array('id' => $key))).
                               ($childUrl ? CHtml::link('<i class="glyphicon glyphicon-plus-sign"></i>', $this->createUrl($childUrl, array('parent_id' => $key)), array('class' => 'action', 'rel' => 'tooltip', 'data-title' => Yii::t('app', 'Add'))) : '').
                                ($deleteParentUrl ? CHtml::link('<i class="glyphicon glyphicon-remove-circle"></i>', $this->createUrl($deleteParentUrl, array('id' => $key)), array('class' => 'action', 'rel' => 'tooltip', 'data-title' => Yii::t('app', 'Delete'))) : '');

                $item['children'] = array();
                if($val['children'])
                {
                    foreach($val['children'] as $c_key => $c_val)
                    {
                        $m_item = array();
                        $m_item['text'] = CHtml::link($c_val, $this->createUrl($childUrl, array('id' => $c_key))).
                                            ($deleteChildUrl ? CHtml::link('<i class="glyphicon glyphicon-remove-circle"></i>', $this->createUrl($deleteChildUrl, array('id' => $c_key)), array('class' => 'action', 'rel' => 'tooltip', 'data-title' => Yii::t('app', 'Delete'))) : '');
                        $item['children'][] = $m_item;
                    }
                }
                $treeData[] = $item;
            }

            return $treeData;
        }

        public function setLanguage()
        {
            $user=Yii::app()->user;
            if ($user->hasState('language') && Yii::app()->language!=$user->language)
            {
                Yii::app()->language = $user->language;
            }
        }

        /**
         * Возвращает список для главного верхнего меню
         * @return array
         */

        public static function getTopMenuItems()
        {
            return array(
                'main_orders'=>array('label'=>Yii::t('app','Work with orders'), 'url'=>array('orders/index'), 'visible' => (!in_array(Yii::app()->user->role, array(Users::ROLE_SEO)))),
                'main_catalog'=>array('label'=>Yii::t('app','Catalog'), 'url'=>array('catalog/index')),
                'main_modules'=>array('label'=>Yii::t('app','Site management'), 'url'=>array('admin/siteManagement'), 'visible' => (!in_array(Yii::app()->user->role, array(Users::ROLE_MANAGER)))),
                'main_settings' => array('label' => Yii::t('app','Global settings'), 'url' => array('settings/index'), 'visible' => (!in_array(Yii::app()->user->role, array(Users::ROLE_MODER, Users::ROLE_MANAGER, Users::ROLE_SEO)))),
            );
        }

        public function getTopMenuItemsWithActive()
        {
            $items = self::getTopMenuItems();

            foreach($items as $key => $item)
            {
                $active = false;
                if ($this->hasActiveAction($key, ''))
                {
                    $active = true;
                }
                $items[$key]['active'] = $active;
            }
            return $items;
        }

        public function getTopMenuTitle()
        {
            return $this->_topMenuTitle ? $this->_topMenuTitle : $this->pageTitle;
        }

        public function addActiveAction($action,$controller=null)
        {
            if ($controller===null)
            {
                $controller=get_class($this);
            }
            $this->_activeActions[$controller.'/'.strtolower($action)]=true;
        }

        public function hasActiveAction($action,$controller=null)
        {
            if ($controller===null)
            {
                $exp=explode('/',$action); // example 'controller/action'
                if (isset($exp[1]))
                {
                    $controller=ucfirst($exp[0]).'Controller';
                    $action=$exp[1];
                }
                else // example 'action'
                {
                    $controller=get_class($this);
                }
            }

            if (isset($this->_activeActions[$controller.'/'.strtolower($action)]))
            {
                return true;
            }
            return false;
        }


        public function getPageTitleBlockDefault()
        {
            $count = count($this->_breadcrumbs);
            $link = null;

            if ($count >= 2)
            {
                $slice = array_slice($this->_breadcrumbs,$count-2,1);
                $tmp = array_values($slice);
                $link = $tmp[0];
            }

            return BackendHelper::htmlTitleBlockDefault($this->pageTitle,$link);
        }

        protected function _getFullClassName($class)
        {
            return $this->location.'.'.$class.$this->classSuffix;
        }
    }
