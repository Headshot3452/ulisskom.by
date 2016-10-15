<?php
class FeedbackController extends ModuleController
{
    public $layout_in='backend_left_tree_with_buttons';

    public $_active_category_id = null;
    private $_active_category = null;

    public $active_category = null;

    public $count = 10;

    public function init()
    {
        parent::init();

        $this->addButtonsLeftMenu('create', array(
                'url'=>$this->createUrl('create_category').'?parent='.$this->_active_category_id
            )
        );
    }

    public function actionIndex()
    {
        $model = new Feedback();

        if(Yii::app()->request->isAjaxRequest)
        {
            if(!empty($_POST['checkbox'])) {
                $products  = $_POST['checkbox'];

                $model = $model::model();
                $criteria=new CDbCriteria();
                $criteria->addInCondition('id',$products);

                $model->updateAll(array('status' => $_POST['status']), $criteria);
            }
            Yii::app()->end();
        }
        //период в unixtime
        $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
        $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));
        $tree_id = Yii::app()->request->getParam('tree_id');

        $this->count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 10;
        $this->layout_in='backend_one_block';

        $this->pageTitleBlock = $this->renderPartial('_filter', array(), true);

        $status = Yii::app()->request->getParam('status');
        $count_item = Feedback::model()->notDeleted()->count();

        $dataProducts = Feedback::getFeedbackProvider($this->count, $date_from, $date_to, $status, 't.id', 'DESC', $tree_id);
        
        $this->render('products',array('model'=>$model,
                                        'count'=>$this->count, 
                                        'dataProducts' => $dataProducts,
                                        'status'=>$status,
                                        'count_item'=>$count_item
                        ));

    }

    public static function getModuleName()
    {
        return Yii::t('app','FeedbackTree');
    }

    public function actionProducts($category_id)
    {
        $this->redirect($this->createUrl('settings').'?category_id='.$category_id);
    }

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
            'update_params' => array(
                'class'=>'actionsBackend.Feedback.SettingsFeedbackUpdateAction',
                'Model'=>'SettingsFeedback',
            ),
            'create_category'=>array(
                'class'=>'actionsBackend.Feedback.FeedbackRootUpdateAction',
                'Model'=>'FeedbackTree',
                'scenario'=>'insert',
                'View'=>'category'
            ),
            'update_category'=>array(
                'class'=>'actionsBackend.Feedback.FeedbackRootUpdateAction',
                'Model'=>'FeedbackTree',
                'scenario'=>'update',
                'View'=>'category'
            ),
            'delete_category'=>array(
                'class'=>'actionsBackend.Feedback.FeedbackDeleteAction',
                'Model'=>'FeedbackTree',
                'scenario'=>'update',
            ),
            'up_category'=>array(
                'class'=>'actionsBackend.Nested.NestedUpAction',
                'Model'=>'FeedbackTree',
            ),
            'down_category'=>array(
                'class'=>'actionsBackend.Nested.NestedDownAction',
                'Model'=>'FeedbackTree',
            ),
            'tree_update'=>array(
                'class'=>'actionsBackend.Nested.NestedMoveTreeAction',
                'Model'=>'FeedbackTree',
            ),
            'tree_status'=>array(
                'class'=>'actionsBackend.Nested.NestedActiveAction',
                'Model'=>'FeedbackTree',
            ),
            'feedback_sort'=> array(
                'class'=>'actionsBackend.Tree.SortAction',
                'Model'=>'Feedback',
            ),
            'upload' => 'actionsBackend.UploadAction',
            'update'=>array(
                'class'=>'actionsBackend.Feedback.FeedbackUpdateAction',
                'scenario'=>'update',
                'Model'=>'Feedback',
                'View'=>'product'
            ),
            'settings'=>array('class'=>'actionsBackend.SettingsAction'),

            'params_sort'=> array(
                'class'=>'actionsBackend.Feedback.SortAction',
                'Model'=>'SettingsFeedback',
            ),
            'status_products'=> array(
                'class'=>'actionsBackend.Feedback.FeedbackStatusAction',
                'Model'=>'Feedback',
            ),
        );
    }

    public function getLeftMenu()
    {
        if(!$this->_active_category && $this->_active_category_id)
        {
            $this->_active_category = FeedbackTree::model()->findByPk($this->_active_category_id);
        }

        $model=new FeedbackTree();
        $categories = $model::getAllTree($this->getCurrentLanguage()->id);
        return array_merge(
            array(array('text' => CHtml::link('<img class="root-folder-orange add_list" src="/images/icon-admin/add_list.png">'.Yii::t('app','Create root category'),array('create_category')),'children'=>array())
            ),
            NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptions(), $this->_active_category_id)
        );
    }

    public function getTreeOptions()
    {
        return array(
            array('catalog_icon'=>'icon','title'=>'title','url'=>$this->createUrl('products').'?category_id='),
        );
    }

    public function getLeftMenuModal()
    {
        if(!$this->_active_category && $this->_active_category_id)
        {
            $this->_active_category = FeedbackTree::model()->findByPk($this->_active_category_id);
        }

        $model=new FeedbackTree();

        $categories = $model::getAllTree($this->getCurrentLanguage()->id);
        return array_merge(
            array(
                array('text'=>CHtml::link('',array('create_category')),'children'=>array())
            ),
            NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptionsModal())
        );
    }

    public function getTreeOptionsModal()
    {
        return array(
            array('catalog_icon'=>'icon','title'=>'title','url'=>'', 'data-id'=>'')
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
        $this->layout_in='backend_left_tree_with_buttons';

        $this->_active_category_id = $category_id;

        if($category_id!=null)
        {
            $this->addButtonsLeftMenu('create', array(
                    'url'=>$this->createUrl('create_category').'?parent='.$this->_active_category_id
                )
            );
        }
        else
        {
            $this->addButtonsLeftMenu('create', array(
                    'url'=>$this->createUrl('create_category')
                )
            );
        }

        if($this->_active_category_id)
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
                    'active'=>(FeedbackTree::model()->findByPk( $this->_active_category_id)->status == FeedbackTree::STATUS_OK) ? true : false,
                )
            );
        }

        $this->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), '/admin/feedback').self::getModuleName(),'/admin/feedback');
        
        $model = new SettingsFeedback();

        if(isset($_GET['category_id']))
        {
            $criteria = new CDbCriteria();
            $criteria->compare('tree_id', $category_id);

            $data = $model->active()->bySort()->findAll($criteria);

            $criteria = new CDbCriteria();
            $criteria->select = 'MAX(`id`) as `id`';
            $id = $model->model()->find($criteria);
            $id = $id->id + 1;

            $this->render('index', array('model'=>$model, 'data' => $data, 'id'=>$id));
        }
        else
        {
            $this->render('index', array('model'=>$model));
        }
    }

    protected  function strToTime($str)
    {
        if($str)
        {
            $date = explode('.',$str);
            if(count($date) == 3)
            {
                return mktime(0,0,0,$date[1],$date[0],$date[2]);
            }

        }

        return '';
    }

    public function UrlTopPagination($count_item, $module_name)
    {
        $page = $module_name.'_page';

        $count_page = ceil($count_item/$this->count);

        if($count_page>1)
        {
            $prev = (isset($_GET[$page]) && $_GET[$page]>1)?$_GET[$page]-1:'1';
            $link_prev = '?'.$page.'='.$prev;

            if(isset($_GET[$page]))
                $next = ($_GET[$page]<$count_page)?$_GET[$page]+1:$count_page;
            else
                $next = '2';
            $link_next = '?'.$page.'='.$next;

            $str=   '<div class="btn-group group-pager">
                        <a href="'.$link_prev.'" id="btn-next-prev" class="btn-prev">
                            <i class="fa fa-angle-left fa-lg"></i>
                        </a>
                        <button type="button" class="btn btn-pager" data-toggle="dropdown" aria-expanded="false">';
            $str.=          isset($_GET[$page])?$_GET[$page]:'1';
            $str.=          '<span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="dropdown-page" role="menu">';
                            for($i=1;$i<=$count_page;$i++) 
                            {
                                $str.= '<li><a href="?'.$page.'='.$i.'">'.$i.'</li>';
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
            'index' => array('label' => static::getModuleName(), 'parent'=>'admin/sitemanagement'),
            'create_category' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'settings' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'update' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
        );
    }
}