<?php
    class FrontendController extends Controller
    {
        public $layout = 'frontend';
        public $url = array();
        public $menu = array();
        public $breadcrumbs = array();
        protected $_home = null;
        public $page_id = null; //активная страница structure
        protected $_active_ids = array(); //массив активных id по моделям
        public $active_id = null; //модуля
        public $text = ''; //наполнение страницы
        public $seo = array(
            'title' => '',
            'keywords' => '',
            'description' => ''
        );

        public $blocks_widgets = array();
        public $settings = null; //object настроек
        public $phones = [];

        public function init()
        {
            if (Yii::app()->request->getParam('language'))
            {
                $language = Yii::app()->request->getParam('language');
                Yii::app()->language = $language;
            }

            $this->settings = Settings::getSettings(Yii::app()->params['settings_id']);
            $phones = ContactsPhone::model()->findAll();

            $re = '/([0-9 +()]+) ([0-9-]+)/';
            foreach($phones as $phone) {
                preg_match_all($re, $phone['number'], $matches);
                $this->phones[] = [
                    'code' => $matches[1][0],
                    'number' => $matches[2][0],
                ];
            }
            parent::init();
        }

        /*
         * возвращает пункты меню для меню
         * */
        public function getMenu($menu_id, $items_key = 'children')
        {
            $array = array();

            if(!isset($this->menu[$menu_id]))
            {
                $menu_items = MenuItem::getItemsByMenuId($menu_id,
                    't.`title`, t.`parent_id`, t.`url`, t.`level`',
                    'structure.`id`, structure.`lft`, structure.`rgt`,
                    structure.`level`, structure.`root`, structure.`name`'
                );

                foreach($menu_items as $item)
                {
                    if($item->structure && $this->hasActive($item->structure->id,'structure')) {
                        $active = true;
                    } else {
                        $active = false;
                    }

                    $url = '';

                    if($item->url != '') {
                        $url = $item->url;
                    } elseif($item->structure) {
                        $url = $this->createUrl('site/page', array('url' => $this->findUrl($item->structure)));
                    }

                    $array[] = array('label' => $item->title,
                        'url' => $url,
                        'level' => $item->level,
                        'active' => $active,
                        'parent_id' => $item->parent_id,
                        'id' => $item->id,
                    );
                }

                $this->menu[$menu_id] = Core::getTreeForField($array, 'parent_id', $items_key);
            }

            return $this->menu[$menu_id];
        }

        protected function getPage($id)
        {
            $this->page_id = $id;
            $this->addActiveId($id);
            $page = Structure::model()->with('widgets')->findByPk($id);

            if (!$page)
                throw new CHttpException(404);

            //смена layout

            if (!empty($page->layout) && $page->layout!=$this->layout)
            {
                $this->layout=$page->layout;
            }

            //добавление widget-ов на страницу

            if (!empty($page->widgets))
            {
                foreach($page->widgets as $widget)
                {
                    if (!isset($this->blocks_widgets[$widget->block]))
                    {
                        $this->blocks_widgets[$widget->block] = array();
                    }
                    $this->blocks_widgets[$widget->block][] = $widget;
                }
            }

            if ($this->getHomeId() != $page->id)
            {
                $this->breadcrumbs[] = $page->title;
            }

            $this->setPageTitle($page->title);
            $this->setSeoTags($page);
            $this->setText($page);
        }

        /**
         * Получение структуры для модуля
         * @param null $action
         * @param null $module
         * @throws CHttpException
         */

        protected function getPageModule($action = null, $module = null)
        {
            $breadcrumbs = array();
            $structure_last = true;

            if (!$module)
            {
                $module = $this->id;
            }

            $id = $this->getStructureIdForModule($module, Yii::app()->request->getPathInfo()); //id page

            $this->addActiveId($id);
            if (!$id)
            {
                throw new CHttpException(404);
            }

            $structure = Structure::model()->findByPk($id);

            if ($action) //тогда ищим action в структуре
            {
                $structure_action = $structure->children()->find('name = :name',array(':name' => $action));

                if (!$structure_action)
                {
                    throw new CHttpException(404);
                }

                $structure_id = $structure_action->id;
            }
            else
            {
                $structure_id = $id;
                $structure_last = false;
            }

            $ancestors = $structure->ancestors()->findAll(array('select'=> 't.id, t.name, t.title', 'condition' => 't.level != 1')); //без root

            $url = '/';
            foreach($ancestors as $item)
            {
                $this->addActiveId($item->id); //добавляем в активные

                $temp = $item->attributes;
                $url .= $temp['name'];
                $temp['url'] = $url;
                $breadcrumbs[$item->title] = array($url); //добавляем в крошки

                $url .= '/';
            }

            if ($structure_last)
            {
                $breadcrumbs[$structure->title] = array($url.$structure->name.'/');
            }
            else
            {
                $breadcrumbs[]=$structure->title;
            }

            $this->breadcrumbs=$breadcrumbs;

            $this->getPage($structure_id);

            array_pop($this->breadcrumbs); //убираем не нужный последний элимент
        }

        protected function findPage($pages)
        {
            //выбираем корень
            $root=$this->getHome();

            if (!is_object($root))
            {
                throw new CHttpException(404,'Not found');
            }

            //получаем массив данных о странице
            return $root->findPath('name',$pages);
        }

        protected function setBreadcrumbs($array,$action,$title='title',$url='url')
        {
            $count=count($array)-1;
            for ($i=0;$i<$count;$i++)
            {
                $this->breadcrumbs[$array[$i][$title]]=array($action,'url'=>$array[$i][$url]);
            }
        }

        protected function setSeoTags($object,$title='seo_title',$keywords='seo_keywords',$description='seo_description')
        {
            $this->seo = array('title' => $object->{$title},
                            'keywords' => $object->{$keywords},
                            'description' => $object->{$description});
        }

        protected function setText($object,$text='text')
        {
            $this->text=$object->{$text};
        }

        /**
         * Поиск страницы по url-у
         * @param $url
         * @throws CHttpException
         */

        public function setPageForUrl($url)
        {
            $pages=explode('/',$url);

            $path=$this->findPage($pages);

            if (!empty($path['item']) && count($path['breadcrumbs'])==count($pages))
            {
                if (!empty($path['breadcrumbs']))
                {
                    $this->setBreadcrumbs($path['breadcrumbs'],'site/page');
                }

                if (!empty($path['active_ids']))
                {
                    $this->setActiveIds($path['active_ids']);
                }

                $this->getPage($path['item']['id']);
            }
            else
                throw new CHttpException(404,'Not found');
        }

        public function actions()
        {
            return array(
                'captcha'=>array(
                    'class'=>'CCaptchaAction',
                    'foreColor'=>0x119423
                ),
                'upload'=>array(
                    'class'=>'application.actions.backend.UploadAction',
                )
            );
        }

        public function behaviors()
        {
            return CMap::mergeArray(
                parent::behaviors(),
                array(
                    'StringToWidgetBehavior'=>array(
                        'class'=>'application.behaviors.StringToWidgetBehavior',
                        'location'=>'application.widgets.module_widgets',
                        'allowWidgets'=>Yii::app()->params['allowWidgets'],
                    ),
                    'BlocksToWidgetsBehavior'=>array(
                        'class'=>'application.behaviors.BlocksToWidgetsBehavior',
                        'location'=>'application.widgets.module_widgets',
                    ),
                )
            );
        }

        public function afterRender($view, &$output)
        {
            parent::afterRender($view, $output);

            $output=$this->decodeWidgets($output); //заменяем виджеты


            $this->setBlockWidgets($this->blocks_widgets); //добавить позиции с виджетами
            $output=$this->decodeBlocks($output); //заменяем блоки
        }

        public function getStructureIdForModule($module, $url)
        {
            $generator = new UrlManagerGenerator();
            return $generator->getStructIdForRule($module, $url);
        }

        /**
         * Записываем группу активных id
         * @param $array массив ids
         * @param string $type модель
         */

        public function setActiveIds($array,$type='structure')
        {
            $this->_active_ids[$type]=$array;
        }

        /**
         * Добавляем элимент в модель
         * @param $id
         * @param string $type модель
         */

        public function addActiveId($id,$type='structure')
        {
            $this->_active_ids[$type][$id]=true;
        }

        /**
         * Проверяем есть ли id в активных
         * @param $id
         * @param string $type модель
         * @return bool
         */

        public function hasActive($id,$type='structure')
        {
            if (isset($this->_active_ids[$type][$id]))
            {
                return true;
            }
            return false;
        }

        public function createUrl($route,$params=array(),$ampersand='&')
        {
            if (Yii::app()->params['multi_language'] && !isset($params['not_auto_language'])) // если включина мультиязычность
            {
                if ($this->getCurrentLanguage()->status!=Language::STATUS_OK && !isset($params['language'])) //если не дефолтный и нет параметра язык
                {
                    $params['language']=$this->getCurrentLanguage()->code;
                }
            }

            if (isset($params['not_auto_language']))
            {
                unset($params['not_auto_language']);
            }

            return parent::createUrl($route,$params,$ampersand);
        }
    }
?>
