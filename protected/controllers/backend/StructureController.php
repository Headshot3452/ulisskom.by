<?php
    class StructureController extends ModuleController
    {
        public $layout_in = 'backend_left_tree';

        protected $_categories = array();

        public $_active_category_id = null;
        public $_active_category = null;

        public $active_category = null;

        public function filters()
        {
            return array_merge(
                      parent::filters(),
                      array('ajaxOnly + treeUpdate')
            );
        }

        public static function getModuleName()
        {
            return Yii::t('app', 'Structure');
        }

        public function actionAjax()
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                if(isset($_POST['widget_id']))
                {
                    $widget = Widgets::model()->findByPk($_POST['widget_id']);
                    $model = $widget->module->model;

                    $data_view = Yii::app()->getWidgetFactory()->createWidget($this, "application.widgets.module_widgets.".$widget->name);

//                    формирование категорий данных
                    $data=StructureWidgets::getCategoryData($data_view, $model, $this->getCurrentLanguage()->id);

                    $str_tree='';
                    foreach($data as $key=>$item)
                    {
                        $str_tree.='<option value="'.$key.'">'.$item.'</option>';
                    }
                    if($str_tree=='')
                    {
                        $str_tree = '<option></option>';
                    }

//                    формирование списка представлений
                    $data_view = $data_view::getView();

                    $str_view='';
                    foreach($data_view as $key=>$item)
                    {
                        $str_view.='<option value="'.$key.'">'.$item.'</option>';
                    }

                    echo CJSON::encode(array(
                        'tree'=>$str_tree,
                        'view'=>$str_view
                    ));
                }
                Yii::app()->end();
            }
        }

        public function actions()
        {
            $actions = parent::actions();
            return CMap::mergeArray($actions,
                array(
                    'index' => array(
                        'class' => 'actionsBackend.Structure.NestedUpdateAction',
                        'scenario' => 'insert',
                        'View' => 'create',
                    ),
                    'create' => array(
                        'class' => 'actionsBackend.Structure.NestedUpdateAction',
                        'scenario' => 'insert',
                    ),
                    'update' => array(
                        'class' => 'actionsBackend.Structure.NestedUpdateAction',
                        'scenario' => 'update',
                    ),
                    'upload' => 'actionsBackend.UploadAction',
                    'up' => array(
                        'class' => 'actionsBackend.Nested.NestedUpAction',
                        'scenario' => 'update',
                    ),
                    'down'=>array(
                        'class' => 'actionsBackend.Nested.NestedDownAction',
                        'scenario' => 'update',
                    ),
                    'tree_update' => array(
                        'class' => 'actionsBackend.Nested.NestedMoveTreeAction',
                    ),
                    'active' => array(
                        'class' => 'actionsBackend.Nested.NestedActiveAction',
                    ),
                    'delete' => array(
                        'class' => 'actionsBackend.Nested.NestedDeleteAction',
                    ),
                )
            );
        }

        protected function beforeRender($view)
        {
            if(!parent::beforeRender($view))
            {
                return false;
            }

            $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('admin/siteManagement'));
            $this->pageTitleBlock .=
                                '<div class="img-cont">
                                    <a href="'.$this->createUrl("admin/siteManagement").'">
                                        <img src="/images/icon-admin/structure.png" alt="" title="">
                                    </a>
                                </div>';
            $this->pageTitleBlock .= '<span class="pull-left title">'.Yii::t('app', 'Structure').'</span>';

            return true;
        }

        public function getLeftMenu()
        {
            $categories = $this->getCategories();

            if(!$this->_active_category && $this->_active_category_id)
            {
                $this->_active_category = Structure::model()->findByPk($this->_active_category_id);
            }
            return array_merge(
                NestedSetHelper::nestedToTreeViewWithOptions($categories, 'id', $this->getTreeOptions(), $this->_active_category_id)
            );
        }

        public function getCategories()
        {
            if (empty($this->_categories))
            {
                $this->_categories = Structure::getTreeForMenu($this->getCurrentLanguage()->id);
            }
            return $this->_categories;
        }

        public function getTreeOptions()
        {
            return array(
                array('icon'=>'icon', 'title'=>'title', 'url' => $this->createUrl('update').'?id='),
            );
        }
    }