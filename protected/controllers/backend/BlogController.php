<?php
class BlogController extends ModuleController
{
    public $module_id = 18;

    public $layout_in='backend_left_tree_with_buttons';

    private $_categories = array();
    public $header='';

    public $_active_category_id = null;
    private $_active_category = null;
    public $active_category = null;

    private $count = 10;

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
        $model = new Blog();

        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['complaint_id']))
            {
                Complaints::removeComplaint($_POST['complaint_id']);
            }

            if(isset($_POST['tag_id']))
            {
                TagItems::removeTags($_POST['tag_id']);
            }
            Yii::app()->end();
        }
        //период в unixtime
        $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
        $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));
        $tree_id = Yii::app()->request->getParam('tree_id');
        $title = Yii::app()->request->getParam('search');

        $this->count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 10;
        $this->layout_in='backend_one_block';

        $this->pageTitleBlock = $this->renderPartial('_filter', array(), true);

        $status = Yii::app()->request->getParam('status');

        $dataProducts = Blog::getBlogProvider($this->count, $date_from, $date_to, $status, 't.id', 'DESC', $tree_id, $title);
        $count_item = count($dataProducts->getData());

        $typeView = '_product_one_for_list';

        $this->render('products',array('model'=>$model,
                                        'count'=>$this->count, 
                                        'dataProducts' => $dataProducts,
                                        'status'=>$status,
                                        'count_item'=>$count_item,
                                        'typeView' => $typeView
                        ));

    }

    public function actionComments()
    {
        $model = new Comments();

        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['status']))
            {
                $model = $model::model()->findByPk($_POST['id']);
                $model->status = $_POST['status'];
                if($model->save())
                {
                    if(UserSettings::getUserSetting($model->user_id)->send_block == 1 && $model->status == Comments::STATUS_DONT_PLACEMENT)
                    {
                        $bodyEmail = $this->renderEmail('block', array('model' => $model, 'type'=>'комментарий'));
                        $mail = Yii::app()->mailer->isHtml(true)->setFrom(Settings::getSettings(Yii::app()->params['settings_id'])->email);
                        $mail->send($model->user->email, 'Subject', $bodyEmail);
                    }
                }
            }
            Yii::app()->end();
        }
        //период в unixtime
        $date_from = $this->strToTime(Yii::app()->request->getParam('date_from'));
        $date_to = $this->strToTime(Yii::app()->request->getParam('date_to'));
        $tree_id = Yii::app()->request->getParam('tree_id');
        $title = Yii::app()->request->getParam('search');

        $this->count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 10;
        $this->layout_in='backend_one_block';

        $this->pageTitleBlock = $this->renderPartial('_filter', array(), true);

        $status = Yii::app()->request->getParam('status');

        $dataProducts = Comments::getCommentsProvider($this->count, $date_from, $date_to, $status, 't.id', 'DESC', $tree_id, $title);
        $count_item = count($dataProducts->getData());

        $typeView = '_product_one_for_comments';

        $this->render('products',array('model'=>$model,
            'count'=>$this->count,
            'dataProducts' => $dataProducts,
            'status'=>$status,
            'count_item'=>$count_item,
            'typeView' => $typeView
        ));

    }

    public static function getModuleName()
    {
        return Yii::t('app','BlogTree');
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
                'class'=>'actionsBackend.Blog.SettingsBlogUpdateAction',
                'Model'=>'SettingsFeedback',
            ),
            'create_category'=>array(
                'class'=>'actionsBackend.Blog.BlogRootUpdateAction',
                'Model'=>'BlogTree',
                'scenario'=>'insert',
                'View'=>'category'
            ),
            'update_category'=>array(
                'class'=>'actionsBackend.Blog.BlogRootUpdateAction',
                'Model'=>'BlogTree',
                'scenario'=>'update',
                'View'=>'category'
            ),
            'delete_category'=>array(
                'class'=>'actionsBackend.Blog.FeedbackDeleteAction',
                'Model'=>'BlogTree',
                'scenario'=>'update',
            ),
            'up_category'=>array(
                'class'=>'actionsBackend.Nested.NestedUpAction',
                'Model'=>'BlogTree',
            ),
            'down_category'=>array(
                'class'=>'actionsBackend.Nested.NestedDownAction',
                'Model'=>'BlogTree',
            ),
            'tree_update'=>array(
                'class'=>'actionsBackend.Nested.NestedMoveTreeAction',
                'Model'=>'BlogTree',
            ),
            'tree_status'=>array(
                'class'=>'actionsBackend.Nested.NestedActiveAction',
                'Model'=>'BlogTree',
            ),
            'feedback_sort'=> array(
                'class'=>'actionsBackend.Tree.SortAction',
                'Model'=>'Blog',
            ),
            'upload' => 'actionsBackend.UploadAction',
            'update'=>array(
                'class'=>'actionsBackend.Blog.BlogUpdateAction',
                'scenario'=>'update',
                'Model'=>'Blog',
                'View'=>'product'
            ),
            'settings'=>array('class'=>'actionsBackend.SettingsAction'),

            'params_sort'=> array(
                'class'=>'actionsBackend.Blog.SortAction',
                'Model'=>'SettingsFeedback',
            ),
            'status_products'=> array(
                'class'=>'actionsBackend.Blog.FeedbackStatusAction',
                'Model'=>'Blog',
            ),
            'update_status'=> array(
                'class'=>'actionsBackend.Blog.StatusAction',
                'Model'=>'Blog',
            ),
        );
    }

    public function getLeftMenu()
    {
        if(!$this->_active_category && $this->_active_category_id)
        {
            $this->_active_category = BlogTree::model()->findByPk($this->_active_category_id);
        }

        $model=new BlogTree();

        $categories = $model::getAllTree($this->getCurrentLanguage()->id);
        return array_merge(
            array(array('text' => CHtml::link('<img class="root-folder-orange" src="/images/icon-admin/folder-orange.png">'.Yii::t('app','Create root category'),array('create_category')),'children'=>array())
            ),
            NestedSetHelper::nestedToTreeViewWithOptions($categories,'id',$this->getTreeOptions(), $this->_active_category_id)
        );
    }

    public function getTopMenu()
    {
        return array(
            array('label'=>Yii::t('app','Posts'), 'url'=>array('blog/index')),
            array('label'=>Yii::t('app','Comments'), 'url'=>array('blog/comments')),
            array('label'=>Yii::t('app','Client'), 'url'=>array('blogclients/index')),
        );
    }

    public function getTreeOptions()
    {
        return array(
            array('catalog_icon'=>'icon','title'=>'title','url'=>$this->createUrl('products').'?category_id='),
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
                    'active'=>(BlogTree::model()->findByPk( $this->_active_category_id)->status == BlogTree::STATUS_OK) ? true : false,
                )
            );
        }

        $this->pageTitleBlock=BackendHelper::htmlTitleBlockDefault(CHtml::link(CHtml::image('/images/icon-admin/feedback.png'), '/admin/blog').
            'Настойки "'.self::getModuleName().'"','/admin/blog').CHtml::link('Метки', '/admin/tags/blog' , array('class'=>'btn btn-primary btn-tags-blog'));
        
        $model = new BlogSetting();

        $data = $model::model()->findAll();

        $this->render('index', array('model'=>$model, 'data' => $data));
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

    public function getCategories()
    {
        if (empty($this->_categories))
        {
            $this->_categories=BlogTree::getTreeForBlog($this->getCurrentLanguage()->id);
        }
        return $this->_categories;
    }

    public static function getActionsConfig()
    {
        return array(
            'index' => array('label' => static::getModuleName(), 'parent'=>'admin/sitemanagement'),
            'create_category' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'update_category' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'settings' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'update' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'comments' => array('label' => static::getModuleName(), 'parent'=>'admin/sitemanagement'),
        );
    }
}