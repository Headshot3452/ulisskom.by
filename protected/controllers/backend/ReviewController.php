<?php
    class ReviewController extends ModuleController
    {
        public $layout_in = 'backend_left_tree_with_buttons';

        private $_active_category_id = null;
        private $_active_category = null;

        public $active_category = null;


        public function init()
        {
            parent::init();

            $this->addButtonsLeftMenu('create', array(
                    'url' => $this->createUrl('create_category') . '?parent=' . $this->_active_category_id
                )
            );
        }

        public function actionIndex($id = null)
        {
            $model = new ReviewItem();

            //период в unixtime

            $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
            $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));
            $status = Yii::app()->request->getParam('status');

            $count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 10;
            $theme = (!empty($_COOKIE['theme'])) ? $_COOKIE['theme'] : 0;
            $this->layout_in = 'backend_one_block';
            if ($id) {
                $review = $model->findByPk(CHtml::encode($_GET['id']));
                if($review==null)
                    throw new CHttpException('404');
                $review->scenario = 'moderate';

                if (Yii::app()->request->isAjaxRequest && isset($_GET['id_status']))
                {
                    $review->status = $_GET['id_status'];
                    $review->save();
                    Yii::app()->end();
                }

                if(isset($_POST['ReviewItem']))
                {
                    $review->scenario='moderate';
                    $review->attributes = $_POST['ReviewItem'];
                    if($review->validate()){
                        $review->update();
                    }
                }
                $this->pageTitleBlock = BackendHelper::htmlTitleBlockDefault('', $this->createUrl('review/index'));
                array_pop($this->_breadcrumbs);
                $this->pageTitleBlock.= $this->renderPartial('_one_review_title', array('model'=>$review), true);
                $this->render('review', array('model'=>$review));
            }
            else
            {
                $this->pageTitleBlock.= $this->renderPartial('_filter', array('status' => $status), true);
                $dataProducts = $model->getReviewProvider($count, $date_from, $date_to, $status, $theme);
                $this->render('reviews', array('count' => $count, 'model' => $dataProducts, 'theme' => $theme, 'status' => $status));
            }
        }

        public static function getModuleName()
        {
            return Yii::t('app', 'Review');
        }

        public function actions()
        {
            return array(
                'update_params' => array(
                    'class' => 'actionsBackend.Review.ReviewSettingsUpdateAction',
                    'Model' => 'ReviewSettings',
                ),
                'delete_category' => array(
                    'class' => 'actionsBackend.Review.ReviewDeleteAction',
                    'Model' => 'ReviewThemesTree',
                    'scenario' => 'update',
                ),
                'up_category' => array(
                    'class' => 'actionsBackend.Nested.NestedUpAction',
                    'Model' => 'ReviewThemesTree',
                ),
                'down_category' => array(
                    'class' => 'actionsBackend.Nested.NestedDownAction',
                    'Model' => 'ReviewThemesTree',
                ),
                'tree_update' => array(
                    'class' => 'actionsBackend.Nested.NestedMoveTreeMaxLevelAction',
                    'Model' => 'ReviewThemesTree',
                ),
                'tree_status' => array(
                    'class' => 'actionsBackend.Nested.NestedActiveAction',
                    'Model' => 'ReviewThemesTree',
                ),
                'upload' => 'actionsBackend.UploadAction',
                'delete' => array(
                    'class' => 'actionsBackend.DeleteAction',
                    'Model' => 'ReviewItem',
                ),

                'settings' => array('class' => 'actionsBackend.SettingsAction'),

                'status_products' => array(
                    'class' => 'actionsBackend.Tree.StatusAction',
                    'Model' => 'ReviewItem',
                ),
            );
        }

        public function getLeftMenu()
        {
            if (!$this->_active_category && $this->_active_category_id)
            {
                $this->_active_category = ReviewThemesTree::model()->findByPk($this->_active_category_id);
            }

            $model = new ReviewThemesTree();
            $categories = $model::getAllTree($this->getCurrentLanguage()->id);
            return array_merge(
                array(//                array('text'=>CHtml::link(Yii::t('app','Create root category'),array('create_category')),'children'=>array())
                ),
                NestedSetHelper::nestedToTreeViewWithOptions($categories, 'id', $this->getTreeOptions(), $this->_active_category_id)
            );
        }

        public function getTreeOptions()
        {
            return array(
                array('catalog_icon' => 'icon', 'title' => 'title', 'url' => $this->createUrl('settings') . '?category_id=', 'class' => 'status'),
            );
        }

        public function getLeftMenuModal()
        {
            if (!$this->_active_category && $this->_active_category_id)
            {
                $this->_active_category = ReviewThemesTree::model()->findByPk($this->_active_category_id);
            }

            $model = new ReviewThemesTree();

            $categories = $model::getAllTree($this->getCurrentLanguage()->id);
            return array_merge(
                array(
                    array('text' => CHtml::link('', array('create_category')), 'children' => array())
                ),
                NestedSetHelper::nestedToTreeViewWithOptions($categories, 'id', $this->getTreeOptionsModal())
            );
        }

        public function getTreeOptionsModal()
        {
            return array(
                array('catalog_icon' => 'icon', 'title' => 'title', 'url' => '', 'data-id' => '')
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

        public function actionSettings($category_id = null)
        {
            $edit=null;
            $new=null;
            $this->_active_category_id = $category_id;
            if ($category_id)
            {
                $edit = ReviewThemesTree::model()->findByPk($this->_active_category_id);
                $edit->scenario = 'update';
                $new = new ReviewThemesTree('insert');
                $new->level = $edit->level + 1;
            }

            $this->addButtonsLeftMenu('create',
                array(
                    'url' => '#create_category',
                    'toggle' => 'modal',
                )
            );

            if ($this->_active_category_id)
            {
                $this->addButtonsLeftMenu('update',
                    array(
                        'url' => '#update_category',
                        'toggle' => 'modal',
                    )
                );
                $this->addButtonsLeftMenu('delete',
                    array(
                        'url' => $this->createUrl('delete_category') . '?id=' . $this->_active_category_id
                    )
                );
                $this->addButtonsLeftMenu('active',
                    array(
                        'url' => $this->createUrl('tree_status') . '?id=' . $this->_active_category_id,
                        'active' => (ReviewThemesTree::model()->findByPk($this->_active_category_id)->status == ReviewThemesTree::STATUS_OK) ? true : false,
                    )
                );
            }
            $model = new ReviewSetting();
            $data = $model->findAll();
            $this->render('index', array('model' => $model, 'data' => $data, 'edit' => $edit, 'new' => $new));
        }

        public function actionUpdateTheme($id = null)
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $model = ReviewThemesTree::model()->findByPk($id);
                if (isset($_POST['ReviewThemesTree']))
                {
                    $model->attributes = $_POST['ReviewThemesTree'];
                    if ($model->validate())
                    {
                        echo $model->validate();
                        $model->saveNode();
                        Yii::app()->end();
                    }
                    else
                    {
                        echo CActiveForm::validate($model);
                    }
                }
                Yii::app()->end();
            }
            else
            {
                throw new CHttpException(404, 'Указанная запись не найдена');
            }
        }

        public function actionCreateTheme($id_parent = null)
        {
            if (Yii::app()->request->isAjaxRequest)
            {
                $model = new ReviewThemesTree();
                if (isset($_POST['ReviewThemesTree']))
                {
                    $model->attributes = $_POST['ReviewThemesTree'];
                    $parent = $model::model()->findByPk($id_parent);
                    if ($parent)
                    {
                        $model->level = $parent->level + 1;
                        if ($model->validate())
                        {
                            echo $model->validate();
                            $model->appendTo($parent);
                            $model->saveNode();
                            Yii::app()->end();
                        }
                        else
                        {
                            echo $model->validate();
                        }
                    }
                }
                Yii::app()->end();
            }
            else
            {
                throw new CHttpException(404, 'Указанная запись не найдена');
            }
        }

        protected function strToTime($str)
        {
            if ($str)
            {
                $date = explode('.', $str);
                if (count($date) == 3)
                {
                    return mktime(0, 0, 0, $date[1], $date[0], $date[2]);
                }
            }
            return '';
        }
    }