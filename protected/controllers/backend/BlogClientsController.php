<?php
class BlogClientsController extends ModuleController
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
        $model = new Users();

        $model->email = Yii::app()->request->getParam('search');
        $model->status = Yii::app()->request->getParam('status');

        $this->count = (!empty($_COOKIE['count'])) ? $_COOKIE['count'] : 10;
        $this->layout_in='backend_one_block';

        $this->pageTitleBlock = $this->renderPartial('_filter_clients', array(), true);

        $dataProducts = $model->getDataProviderForUsers($model, $this->count);
        $count_item = count($dataProducts->getData());

        $this->render('clients',array('model'=>$model,
            'count'=>$this->count,
            'dataProducts' => $dataProducts,
            'count_item'=>$count_item,
        ));

    }

    public function actionBlog($id)
    {
        $model = new Blog();

        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['user_id']))
            {
                $user = Users::model()->findByPk($_POST['user_id']);
                $user->status = $_POST['status'];
                $user->save(false);

                Yii::app()->end();
            }

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

        $this->pageTitleBlock = $this->renderPartial('_filter', array('model'=>Users::model()->findByPk($id)), true);

        $status = Yii::app()->request->getParam('status');

        $dataProducts = Blog::getBlogProvider($this->count, $date_from, $date_to, $status, 't.id', 'DESC', $tree_id, $title, $id);
        $count_item = count($dataProducts->getData());

        $typeView = '_product_one_for_list';

        $this->render('products',array('model'=>$model,
                                        'count'=>$this->count, 
                                        'dataProducts' => $dataProducts,
                                        'status'=>$status,
                                        'count_item'=>$count_item,
                                        'typeView' => $typeView,
                                        'user_id' => $id
                        ));

    }

    public function actionComments($id)
    {
        $model = new Comments();

        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['user_id']))
            {
                $user = Users::model()->findByPk($_POST['user_id']);
                $user->status = $_POST['status'];
                $user->save(false);

                Yii::app()->end();
            }

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

        $this->pageTitleBlock = $this->renderPartial('_filter', array('model'=>Users::model()->findByPk($id)), true);

        $status = Yii::app()->request->getParam('status');

        $dataProducts = Comments::getCommentsProvider($this->count, $date_from, $date_to, $status, 't.id', 'ASC', $tree_id, $title, $id);
        $count_item = count($dataProducts->getData());

        $typeView = '_product_one_for_comments';

        $this->render('products',array('model'=>$model,
            'count'=>$this->count,
            'dataProducts' => $dataProducts,
            'status'=>$status,
            'count_item'=>$count_item,
            'typeView' => $typeView,
            'user_id' => $id
        ));

    }

    public static function getModuleName()
    {
        return Yii::t('app','BlogClients');
    }

    public function actions()
    {
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
            'upload' => 'actionsBackend.UploadAction',
            'update'=>array(
                'class'=>'actionsBackend.Blog.BlogUpdateAction',
                'scenario'=>'update',
                'Model'=>'Blog',
                'View'=>'product'
            ),
            'update_status'=> array(
                'class'=>'actionsBackend.Blog.StatusAction',
                'Model'=>'Blog',
            ),
            'update_status_client'=> array(
                'class'=>'actionsBackend.Blog.StatusAction',
                'Model'=>'Users',
            ),
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
            'blog' => array('label' => '', 'parent'=>'blogclients/index'),
            'update' => array('label' => 'Редактирование групп', 'parent'=>'main_modules'),
            'comments' => array('label' => '', 'parent'=>'blogclients/index'),
        );
    }
}