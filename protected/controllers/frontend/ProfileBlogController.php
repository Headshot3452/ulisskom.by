<?php

class ProfileBlogController extends FrontendController
{
    public $layout = 'profile_left_menu';
    public $menu_title = 'Blog';

    public $_categories=array();
    public $setting = array();

    public $user_id;
    public $module_id = 18;

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
                'roles' => array(Users::ROLE_USER),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function init()
    {
        parent::init();
        $this->user_id = Yii::app()->user->id;

        $this->setting = BlogSetting::getSettingModuleBlog();
    }

    public function actionIndex()
    {
        $model = new Blog();

        $status = Yii::app()->request->getParam('status');

        $dataProvider = $model::getBlogProvider(10, '', '', $status, 't.id', 'DESC', '', '', $this->user_id);

        $this->render('index', array('model'=>$model, 'dataProvider'=>$dataProvider));
    }

    public function actionCreatePost()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['parent_id']))
            {
                echo BlogTree::CreatePathForTree($_POST['parent_id']);
            }
            Yii::app()->end();
        }

        $tags_old = '';

        if(isset($_GET['id']))
        {
            $model = Blog::model()->findByPk($_GET['id']);
            $tags_old = implode(',',TagItems::getTagsForUpdatePost($model->id, $this->module_id));

            $model->tags = $tags_old;
        }
        else
        {
            $model = new Blog();
        }

        if(isset($_POST['Blog']))
        {
            if(!isset($_POST['draft']))
            {
                $model->scenario = 'create';

                $model->attributes = $_POST['Blog'];
                if ($model->validate())
                {
                    $model->time = time();

                    if($this->setting['dont_place_post']==1) {
                        $model->status = Blog::STATUS_MODERETION;
                    }
                    else{
                        $model->status = Blog::STATUS_PLACEMENT;
                    }

                    $model->user_id = $this->user_id;
                    $model->language_id = $this->getCurrentLanguage()->id;

                    if ($filez = $this->uploadMultifile(unserialize($model->images))) {
                        $model->images = serialize($filez);
                    }

                    if (empty($filez)) {
                        $model->images = serialize(array());
                    }

                    $model->save(false);

                    Tags::saveTags($model->tags, $this->module_id, $model->parent_id, $model->id, $tags_old);

                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );
                    $this->redirect($this->createUrl('profileblog/index'));
                }
            }
            else
            {
                $model->scenario = 'draft';

                $model->attributes = $_POST['Blog'];
                if ($model->validate())
                {
                    $model->time = time();
                    $model->status = Blog::STATUS_DRAFT;
                    $model->user_id = $this->user_id;
                    $model->language_id = $this->getCurrentLanguage()->id;

                    if ($filez = $this->uploadMultifile(unserialize($model->images))) {
                        $model->images = serialize($filez);
                    }

                    if (empty($filez)) {
                        $model->images = serialize(array());
                    }

                    $model->save(false);

                    Tags::saveTags($model->tags, $this->module_id, $model->parent_id, $model->id, $tags_old);

                    Yii::app()->user->setFlash('alert-swal',
                        array(
                            'header' => 'Выполнено',
                            'content' => 'Данные успешно сохранены!',
                        )
                    );
                    $this->redirect($this->createUrl('profileblog/drafts'));
                }
            }
        }

        $this->render('add', array('model'=>$model));
    }

    public function actionMyComments()
    {
        $dataProvider = Comments::getCommentsProvider(10, '', '', '', 't.id', 'DESC', '', '', $this->user_id);

        $this->render('mycomments', array('dataProvider'=>$dataProvider));
    }

    public function actionMyReaderShips()
    {
        $dataProvider = Followers::getFollowerProvider($this->user_id, 10);
        $dataProvider_new = Followers::getNewFollower($this->user_id, 10);

        $this->render('myreaderships', array('dataProvider'=>$dataProvider,
                                            'dataProvider_new'=>$dataProvider_new
        ));
    }

    public function actionFavoritePosts()
    {
        $model = new Blog();

        $dataProvider = $model::getBlogProvider(10, '', '', Blog::STATUS_PLACEMENT, 't.id', 'DESC', '', '', $this->user_id, Favourite::getFavouritePostId($this->module_id));

        $this->render('favoriteposts', array('model'=>$model, 'dataProvider'=>$dataProvider));
    }

    public function actionFavoriteComments()
    {
        $dataProvider = Comments::getCommentsProvider(10, '', '', Comments::STATUS_PLACEMENT, 't.id', 'DESC', '', '', '', Favourite::getFavouritePostId(Comments::MODULE_ID));

        $this->render('favoritecomments', array('dataProvider'=>$dataProvider));
    }

    public function actionRead()
    {
        $dataProvider = Followers::getFollowerProvider($this->user_id, 10, true);
        $dataProvider_new = Followers::getNewPostForFollower($this->user_id, 10);

        $this->render('read', array('dataProvider'=>$dataProvider,
                                    'dataProvider_new'=>$dataProvider_new
        ));
    }

    public function actionDrafts()
    {
        $dataProvider = Blog::getBlogProvider(10, '', '', Blog::STATUS_DRAFT, 't.id', 'DESC', '', '', $this->user_id);

        $this->render('drafts', array('dataProvider'=>$dataProvider));
    }

    public function actionNotification()
    {
        $model = UserSettings::model()->find('user_id=:user_id', array(':user_id'=>$this->user_id));

        if(isset($_POST['UserSettings']))
        {
            $model->attributes = $_POST['UserSettings'];
            if($model->save())
            {
                Yii::app()->user->setFlash('alert-swal',
                    array(
                        'header' => 'Выполнено',
                        'content' => 'Данные успешно сохранены!',
                    )
                );
            }
        }

        $this->render('notifications', array('model'=>$model));
    }

    public function getLeftMenu()
    {
        return array(
            array('label' =>  Yii::t('app','Favorites posts'), 'url' => array('profileblog/favoriteposts'), 'class' => in_array($this->action->id, array('favoriteposts')) ? 'active' : ''),
            array('label' =>  Yii::t('app','Favorites comments'), 'url' => array('profileblog/favoritecomments'), 'class' => in_array($this->action->id, array('favoritecomments')) ? 'active' : ''),
            array('label' =>  Yii::t('app','My posts'), 'url' => array('profileblog/index'), 'class' => in_array($this->action->id, array('index','createpost','preview')) ? 'active' : ''),
            array('label' =>  Yii::t('app','My Comments'), 'url' => array('profileblog/mycomments'), 'class' => $this->action->id == 'mycomments' ? 'active' : ''),
            array('label' =>  Yii::t('app','My readers').' <span class="badge pull-right">'.$this->getMyReaders().'</span>', 'url' => array('profileblog/myreaderships'), 'class' => $this->action->id == 'myreaderships' ? 'active' : ''),
            array('label' =>  Yii::t('app','I read').' <span class="badge pull-right">'.$this->getIRead().'</span>', 'url' => array('profileblog/read'), 'class' => $this->action->id == 'read' ? 'active' : ''),
            array('label' =>  Yii::t('app','Draft posts'), 'url' => array('profileblog/drafts'), 'class' => $this->action->id == 'drafts' ? 'active' : ''),
            array('label' => Yii::t('app','Notifications'), 'url' => array('profileblog/notification'), 'class' => $this->action->id == 'notification' ? 'active' : ''),
        );
    }

    private function getMyReaders()
    {
        $count = count(Followers::getNewFollower($this->user_id)->getData());

        if ($count > 0) {
            return '+' . $count;
        } else {
            return '';
        }
    }

    public function getIRead()
    {
        $follower = Followers::getNewPostForFollower($this->user_id);
        if ($follower) {
            $follower = $follower->getData();

            $count = 0;
            foreach ($follower as $value) {
                $count += $value->view;
            }

            if ($count > 0) {
                return '+' . $count;
            } else {
                return '';
            }
        }
        return '';
    }

    public function getCategories()
    {
        if (empty($this->_categories))
        {
            $this->_categories=BlogTree::getTreeForBlog($this->getCurrentLanguage()->id);
        }
        return $this->_categories;
    }

    /**
     * @param $images_old
     * @return array
     */
    public function uploadMultifile($images_old)
    {
        if(!file_exists(Yii::getPathOfAlias('webroot').'/data/blog/'))
        {
            mkdir(Yii::getPathOfAlias('webroot').'/data/blog/', 0700, true);
        }

        $ffile=array();

        if(isset($_POST['Blog']['item_file']))
            if($sfile=$_POST['Blog']['item_file'])
            {
                foreach ($sfile as $i=>$file)
                {
                    if(!empty($file))
                    {
                        $path = pathinfo($file);
                        $ffile[]=array('name'=>$path['basename'], 'path'=>'/data/blog/');

                        copy(Yii::getPathOfAlias('webroot') . '/' . $file, Yii::getPathOfAlias('webroot') . '/data/blog/' . $path['basename']);

                        if(file_exists(Yii::getPathOfAlias('webroot').'/data/temp/'.$path['basename']))
                        {
                            unlink(Yii::getPathOfAlias('webroot') . '/' . $file);
                        }
                    }
                    else
                    {
                        unlink(Yii::getPathOfAlias('webroot') . $images_old[0]['path'].'/'.$images_old[0]['name']);
                    }
                }

                if(!empty($file))
                {
                    if (isset($images_old[0]['name']) && $images_old[0]['name'] != $ffile[0]['name'])
                    {
                        unlink(Yii::getPathOfAlias('webroot') . $images_old[0]['path'] . '/' . $images_old[0]['name']);
                    }
                }
            }

        return $ffile;
    }

    public function SubStr($str, $count)
    {
        if(strlen($str) > $count)
        {
            $str = substr($str, 0, $count);
            $str = substr($str, 0, strrpos($str, ' ')) . '...';
        }
        return strip_tags($str);
    }
}

?>