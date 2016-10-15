<?php
    class AskanswerController extends ModuleController
    {
        public $layout_in='backend_left_tree_with_buttons';

        private $_active_category_id = null;
        private $_active_category = null;

        public $active_category = null;

        private $count = 20;
        public $root = false;

        public function init()
        {
            parent::init();
        }

        public function actionIndex()
        {
            $count_tree = AskAnswerTree::model()->count();

            if($count_tree>0)
            {
                $root = AskAnswerTree::model()->find('name = :name', array(':name' => 'root'));
                $this->redirect($this->createUrl('answers', array('category_id' => $root->id)));
            }
            else
            {
                $this->redirect($this->createUrl('create_category'));
            }
        }

        public static function getModuleName()
        {
            return Yii::t('app','AskAnswerTree');
        }

        public function actionAnswers($category_id)
        {
            $this->_active_category_id = $category_id;

            if(! $this->_active_category_id || !($this->_active_category = AskAnswerTree::model()->findByPk( $this->_active_category_id)))
            {
                throw new CHttpException('404');
            }

            $parent=AskAnswerTree::model()->findByPk($category_id);

            if($parent->level < 4)
            {
                $this->addButtonsLeftMenu('create', array(
                        'url'=>$this->createUrl('create_category').'?parent='.$this->_active_category_id
                    )
                );
            }

            if($this->_active_category_id && $category_id != AskAnswerTree::model()->find('name=:name', array(':name'=>'root'))->id)
            {
                $this->addButtonsLeftMenu('update', array(
                        'url'=>$this->createUrl('update_category').'?id='.$this->_active_category_id
                    )
                );
                $this->addButtonsLeftMenu('delete', array(
                        'url'=>$this->createUrl('delete_category').'?id='.$this->_active_category_id
                    )
                );
                $this->addButtonsLeftMenu('active', array(
                        'url'=>$this->createUrl('tree_status').'?id='.$this->_active_category_id,
                        'active'=>(AskAnswerTree::model()->findByPk( $this->_active_category_id)->status == AskAnswerTree::STATUS_OK) ? true : false,
                    )
                );
            }

            $this->count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 20;

            if($this->_active_category_id && $category_id != AskAnswerTree::model()->find('name=:name', array(':name'=>'root'))->id)
            {
                $count_item = AskAnswer::model()->notDeleted()->count(array('condition'=>'parent_id=:parent_id',
                                                                                'params'=>array(':parent_id'=>$this->_active_category_id))
                                                                        );
            }
            else
            {
                $count_item = AskAnswer::model()->notDeleted()->count();
            }

            $model = AskAnswer::model()->notDeleted()->parent($this->_active_category_id);
            $dataProducts = $model->language($this->getCurrentLanguage()->id)->search($this->count);

            $this->render('products',array('dataProducts'=>$dataProducts,
                                            'category_id'=>$category_id,
                                            'count'=>$this->count,
                                            'count_item'=>$count_item
            ));
        }

        public function actions()
        {
            return array(
                'captcha'=>array(
                    'class'=>'CCaptchaAction',
                ),
                'create_category'=>array(
                    'class'=>'actionsBackend.Nested.NestedUpdateAction',
                    'Model'=>'AskAnswerTree',
                    'scenario'=>'insert',
                    'View'=>'category'
                ),
                'update_category'=>array(
                    'class'=>'actionsBackend.Nested.NestedUpdateAction',
                    'Model'=>'AskAnswerTree',
                    'scenario'=>'update',
                    'View'=>'category'
                ),
                'delete_category'=>array(
                    'class'=>'actionsBackend.Nested.NestedDeleteAction',
                    'Model'=>'AskAnswerTree',
                    'scenario'=>'update',
                ),
                'up_category'=>array(
                    'class'=>'actionsBackend.Nested.NestedUpAction',
                    'Model'=>'AskAnswerTree',
                ),
                'down_category'=>array(
                    'class'=>'actionsBackend.Nested.NestedDownAction',
                    'Model'=>'AskAnswerTree',
                ),
                'tree_update'=>array(
                    'class'=>'actionsBackend.Nested.NestedMoveTreeAction',
                    'Model'=>'AskAnswerTree',
                ),
                'tree_status'=>array(
                    'class'=>'actionsBackend.Nested.NestedActiveAction',
                    'Model'=>'AskAnswerTree',
                ),
                'upload' => 'actionsBackend.UploadAction',
                'create_product'=>array(
                    'class'=>'actionsBackend.AskAnswer.AskAnswerUpdateAction',
                    'scenario'=>'insert',
                    'Model'=>'AskAnswer',
                    'View'=>'product'
                ),
                'update'=>array(
                    'class'=>'actionsBackend.AskAnswer.AskAnswerUpdateAction',
                    'scenario'=>'update',
                    'Model'=>'AskAnswer',
                    'View'=>'product'
                ),
                'delete' => array(
                    'class'=>'actionsBackend.DeleteAction',
                    'Model'=>'AskAnswer',
                ),
                'settings'=>array('class'=>'actionsBackend.SettingsAction'),

                'products_sort'=> array(
                    'class'=>'actionsBackend.AskAnswer.SortAction',
                    'Model'=>'AskAnswer',
                ),

                'copy_product'=> array(
                    'class'=>'actionsBackend.Tree.CopyMoveAction',
                    'Model'=>'AskAnswer',
                ),
                'status_products'=> array(
                    'class'=>'actionsBackend.Tree.StatusAction',
                    'Model'=>'AskAnswer',
                ),
                'update_status'=>array(
                    'class'=>'actionsBackend.ActiveAction',
                    'Model'=>'AskAnswer',
                    'View'=>'product'
                ),
            );
        }

        public function getLeftMenu()
        {
            if(!$this->_active_category && $this->_active_category_id)
            {
                $this->_active_category = AskAnswerTree::model()->findByPk($this->_active_category_id);
            }

            $model=new AskAnswerTree();

            $categories = $model::getAllTree($this->getCurrentLanguage()->id);

            return array_merge(
                    array(
                        array('text' => CHtml::link('<img class="root-folder-orange" src="/images/icon-admin/add_folder.png">'.Yii::t('app','Create root category'),array('create_category')),'children'=>array())
                    ),NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptions(), $this->_active_category_id)
            );
        }

        public function getTreeOptions()
        {
            return array(
                array('catalog_icon' => 'icon','title' => 'title','url' => $this->createUrl('answers').'?category_id=', 'root' => false),
            );
        }

        protected function beforeRender($view)
        {
            if (!parent::beforeRender($view))
            {
                return false;
            }

            $this->pageTitleBlock = '<img src="/images/icon-admin/askanswer.png">'.BackendHelper::htmlTitleBlockDefault(self::getModuleName(),$this->createUrl('admin/siteManagement'));

            return true;
        }

        public function getLeftMenuModal()
        {
            if(!$this->_active_category && $this->_active_category_id)
            {
                $this->_active_category = AskAnswerTree::model()->findByPk($this->_active_category_id);
            }

            $model = new AskAnswerTree();

            $categories = $model::getAllTree($this->getCurrentLanguage()->id);
            return array_merge(
                array(
                    array(
                        'text' => CHtml::link('<img class="root-folder-orange" src="/images/icon-admin/folder-orange.png"><span class="modal_first">'.
                        Yii::t('app', 'The root level directory').'</span>', array('create_category'), array('class' => 'active root')),'children' => array()
                    )
                ),
                NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptionsModal())
            );
        }

        public function getTreeOptionsModal()
        {
            return array(
                array('catalog_icon' => 'icon', 'title' => 'title', 'url' => '', 'data-id' => '', 'root' => false)
            );
        }

        /**
         * @return null
         */
        public function getActiveCategoryId()
        {
            return $this->_active_category_id;
        }

        /**
         * @param null $active_category_id
         */
        public function setActiveCategoryId($active_category_id)
        {
            $this->_active_category_id = $active_category_id;
        }

        public function finfUrlForItem($id, $name)
        {
            $url=Yii::app()->request->getHostInfo();

            $parent=AskAnswerTree::model()->findByPk($id);
            $ancestors=$parent->ancestors()->findAll();

            foreach ($ancestors as $key => $value) {
                $url.='/'.$value->name;
            }

            $url.='/'.$parent->name.'/'.$name.'/';

            return $url;
        }

        public static function SubStr($str, $count)
        {
            if(strlen($str) > $count)
                    {
                      $str = substr($str, 0, $count);
                      $str = substr($str, 0, strrpos($str, ' ')) . '...';
                    }
            return strip_tags($str);
        }

        public function UrlTopPagination($count_item)
        {
            $count_page = ceil($count_item/$this->count);

            if($count_page>1)
            {
                $prev = (isset($_GET['page']) && $_GET['page'] > 1) ? $_GET['page'] - 1 : '1';
                $link_prev = $this->createUrl('answers').'?category_id='.$this->_active_category_id.'&page='.$prev;

                if(isset($_GET['page']))
                {
                    $next = ($_GET['page'] < $count_page) ? $_GET['page'] + 1 : $count_page;
                }
                else
                {
                    $next = '2';
                }

                $link_next = $this->createUrl('answers').'?category_id='.$this->_active_category_id.'&page='.$next;

                $str=   '<div class="btn-group group-pager">
                            <a href="'.$link_prev.'" id="btn-next-prev" class="btn-prev">
                                <i class="fa fa-angle-left fa-lg"></i>
                            </a>
                            <button type="button" class="btn btn-pager" data-toggle="dropdown" aria-expanded="false">';
                $str.=          isset($_GET['page']) ? $_GET['page'] : '1';
                $str.=          '<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" id="dropdown-page" role="menu">';
                                for($i = 1; $i <= $count_page; $i++)
                                {
                                    $str.= '<li><a href="'.$this->createUrl('answers').'?category_id='.$this->_active_category_id.'&page='.$i.'">'.$i.'</li>';
                                }
                $str.=     '</ul>
                            <a href="'.$link_next.'" id="btn-next-prev" class="btn-next">
                                <i class="fa fa-angle-right fa-lg"></i>
                            </a>
                        </div>';
                return $str;
            }
        }

        public static function getActionsConfig()
        {
            return array(
                'index'             => array('label' => 'Вопрос ответ', 'parent' => 'main_modules'),
                'answers'           => array('label' => 'Вопрос ответ', 'parent' => 'index'),
                'update'            => array('label' => 'Вопрос ответ', 'parent' => 'answers'),
                'askanswer'         => array('label' => 'Вопрос ответ', 'parent' => 'answers'),
                'create_product'    => array('label' => 'Вопрос ответ', 'parent' => 'answers'),
                'create_category'   => array('label' => Yii::t('app', 'Create a new category'), 'parent' => 'answers'),
                'update_category'   => array('label' => Yii::t('app', 'Update category'), 'parent' => 'answers'),
            );
        }
    }