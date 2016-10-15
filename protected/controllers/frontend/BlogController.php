<?php

class BlogController extends FrontendController
{
    public $root_id;
    public $module_id = 18;

    public $setting = array();

    public function init()
    {
        parent::init();
        $this->root_id = 35;

        $this->getPageModule();
        $this->setting = BlogSetting::getSettingModuleBlog();
    }

    public function actionIndex()
    {
//        Поиск тэгов по букве (для модального окна)
        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['title']))
            {
                $tags = Tags::getAllTags($_POST['category_id'], $this->module_id, $_POST['title']);

                $category = isset($_POST['category'])?$_POST['category']:'';
                $prev = isset($_POST['prev'])?$_POST['prev']:'&prev=';

                $str = '';
                foreach($tags as $value)
                {
                    $str .= '<a href="'.$this->createUrl('blog/index').'?tag_id='.$value->id.$category.$prev.'">'.$value->title.'</a>';
                }
                echo $str;
            }
            Yii::app()->end();
        }

        $tree = new BlogTree();
        $prev_tree = new BlogTree();

//        Для выборки по тэгу
        if(isset($_GET['tag_id']))
        {
            $tags = TagItems::getPostsForTag($_GET['tag_id']);
        }
        else
        {
            $tags = '';
        }

//        Для выборки лучших записей
        if(isset($_GET['well']))
        {
            $well = true;
        }
        else
        {
            $well = false;
        }

        if(isset($_GET['category_id']))
        {
            $tree = BlogTree::model()->findByPk($_GET['category_id']);

            if(isset($_GET['prev'])) {
                $prev_tree = BlogTree::model()->findByPk($_GET['prev']);
            }

            $tree_menu = $tree->active()->children()->findAll();

            $model = Blog::model()->notDeleted()->parent($tree->id);
            $dataProvider = $model->active()->language($this->getCurrentLanguage()->id)->search(10, '', $tags, $well);
        }
        else
        {
            $tree_menu = BlogTree::model()->active()->roots()->findAll();

            $model = new Blog();
            $dataProvider = $model->active()->language($this->getCurrentLanguage()->id)->search(10, 'id DESC', $tags, $well);

        }

        $this->render('index', array('dataProvider'=>$dataProvider,
                                    'tree_menu'=>$tree_menu,
                                    'tree'=>$tree,
                                    'prev_tree'=>$prev_tree
        ));
    }

    public function actionPost($name)
    {
        $post=Blog::getBlogByName($name, $this->getCurrentLanguage()->id);

        if(Yii::app()->request->isAjaxRequest)
        {
//            Добавление в избранные
            if(isset($_POST['post_id']) && $_POST['type']=='create')
            {
                $model = new Favourite();
                $model->user_id = Yii::app()->user->id;
                $model->item_id = $_POST['post_id'];
                $model->module_id = $_POST['module_id'];

                $model->save();

                Yii::app()->end();
            }

//            Удаление из избранных
            if(isset($_POST['post_id']) && $_POST['type']=='remove')
            {
                $model = new Favourite();
                $model = $model::model()->find('item_id=:item_id AND module_id=:module_id AND user_id=:user_id',
                    array(':item_id'=>$_POST['post_id'], ':module_id'=>$_POST['module_id'], ':user_id'=>Yii::app()->user->id));

                if($model)
                {
                    $model->delete();
                }
                Yii::app()->end();
            }

//            Добавление рейтинга
            if(isset($_POST['post_id']) && ($_POST['type']=='plus' || $_POST['type']=='minus'))
            {
                if(isset($_POST['model']) && $_POST['model']=='blog')
                {
                    $post = Blog::model()->findByPk($_POST['post_id']);
                }

                $model = new Rating();

                if($_POST['check'] == 'create')
                {
                    $model->post_id = $_POST['post_id'];
                    $model->module_id = $_POST['module_id'];
                    $model->user_id = Yii::app()->user->id;

                    if ($post)
                        $post->scenario = 'update_status';

                    if ($_POST['type'] == 'plus')
                    {
                        $model->value = 1;
                        if ($post)
                            $post->rating += 1;
                    }
                    else
                    {
                        $model->value = -1;
                        if ($post)
                            $post->rating -= 1;
                    }
                    $model->save();
                    if ($post)
                        $post->save(false);
                }

                if($_POST['check'] == 'remove')
                {
                    $model = $model::model()->find('post_id=:post_id AND module_id=:module_id AND user_id=:user_id',
                        array(':post_id'=>$_POST['post_id'], ':module_id'=>$_POST['module_id'],
                            ':user_id'=>Yii::app()->user->id));

                    if($model)
                    {
                        if ($post) {
                            $post->rating -= $model->value;
                            $post->save(false);
                        }

                        $model->delete();
                    }
                }
                Yii::app()->end();
            }
        }

        $this->getPageModule('post');

        $this->setPageTitle($post->title);
        $this->breadcrumbs[]=$post->title;

        $post->scenario = 'update_status';
        $post->view +=1;
        $post->save(false);

        if(isset($_GET['category_id'])) {
            $tree = BlogTree::model()->findByPk($_GET['category_id']);
            $tree_menu = $tree->active()->children()->findAll();
        }

        if($tree->level!=1) {
            $prev_tree = $tree->parent()->find();
        }
        else{
            $prev_tree = '';
        }

        $this->render('post', array('model'=>$post,
                                    'tree_menu'=>$tree_menu,
                                    'tree'=>$tree,
                                    'prev_tree'=>$prev_tree,
        ));
    }

    public function actionComment()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model = new Comments();

            if(isset($_POST['ajax']) && ($_POST['ajax']==='comment-form'))
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if(isset($_POST['Comments']))
            {
                $model->attributes = $_POST['Comments'];

                if(Yii::app()->user->isGuest)
                {
                    $model->scenario = 'guest';
                }

                if ($model->validate())
                {
                    $model->time = time();
                    $model->language_id = $this->getCurrentLanguage()->id;
                    $model->post_id = $_POST['post_id'];
                    $model->module_id = $this->module_id;

                    if(!Yii::app()->user->isGuest)
                    {
                        $model->user_id = Yii::app()->user->id;
                    }

                    if($this->setting['dont_place_comment'] == 1) {
                        $model->status = Comments::STATUS_MODERETION;
                    }
                    else{
                        $model->status = Comments::STATUS_PLACEMENT;
                    }

                    $model->parent_id = $_POST['parent_id'];

                    $model->save(false);

//                    отправка сообщения на почту
                    if($this->setting['send_mail'] == 0)
                    {
                        $post = Blog::model()->findByPk($model->post_id);

                        $bodyEmail=$this->renderEmail('comment_post',array('model'=>$model, 'post'=>$post));
                        $mail=Yii::app()->mailer->isHtml(true)->setFrom($this->settings->email);
                        $mail->send($post->user->email,'Subject',$bodyEmail);
                    }

                    if (Yii::app()->request->isAjaxRequest) {
                        if($this->setting['dont_place_comment'] == 0) {
                            echo CJSON::encode(array('status' => 'success', 'comment' => $this->renderPartial('_comment', array('model' => $model), true)));
                        }
                        else{
                            echo CJSON::encode(array('status' => 'success', 'comment' => ''));
                        }
                        Yii::app()->end();
                    }
                }
                else
                {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($model);
                        if ($error != '[]')
                            echo $error;

                        Yii::app()->end();
                    }
                }
            }
            Yii::app()->end();
        }
    }

    public function actionComplaint()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model = new Complaints();

            if(isset($_POST['ajax']) && (($_POST['ajax']==='complaint-form') || ($_POST['ajax']==='complaint-comment-form')))
            {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if(isset($_POST['Complaints']))
            {
                $model->attributes = $_POST['Complaints'];
                if ($model->validate())
                {
                    $model->time = time();
                    $model->language_id = $this->getCurrentLanguage()->id;
                    $model->post_id = $_POST['post_id'];
                    $model->module_id = $_POST['module_id'];
                    $model->user_id = Yii::app()->user->id;

                    if($model->module_id == $this->module_id) {
                        $post = Blog::model()->findByPk($model->post_id);
                        $type = 'пост';
                    }
                    else {
                        $post = Comments::model()->findByPk($model->post_id);
                        $type = 'комментарий';
                    }

//                    отправка сообщения о жалобе
                    if(UserSettings::getUserSetting($post->user_id)->send_complaint == 1)
                    {
                        $bodyEmail = $this->renderEmail('complaint', array('model' => $model, 'post' => $post, 'type'=>$type));
                        $mail = Yii::app()->mailer->isHtml(true)->setFrom($this->settings->email);
                        $mail->send($post->user->email, 'Subject', $bodyEmail);
                    }

                    $model->save(false);

                    if (Yii::app()->request->isAjaxRequest) {
                        echo CJSON::encode(array('status' => 'success'));

                        Yii::app()->end();
                    }
                }
                else
                {
                    if (Yii::app()->request->isAjaxRequest) {
                        $error = CActiveForm::validate($model);
                        if ($error != '[]')
                            echo $error;

                        Yii::app()->end();
                    }
                }
            }
            Yii::app()->end();
        }
    }

    public function actionUser($id)
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['user_id']))
            {
                $follower = new Followers();

                if($_POST['type'] == 'create')
                {
                    $follower->user_id = $_POST['user_id'];
                    $follower->follower_id = Yii::app()->user->id;
                    $follower->time = time();

                    $follower->save();

                    Yii::app()->end();
                }

                if($_POST['type'] == 'remove')
                {
                    $follower = Followers::model()->find('user_id=:user_id AND follower_id=:follower_id',
                        array(':user_id'=>$_POST['user_id'], ':follower_id'=>Yii::app()->user->id));

                    if($follower)
                    {
                        $follower->delete();
                    }
                    Yii::app()->end();
                }
            }
        }

        $dataProvider = Blog::getBlogProvider(10, '', '', Blog::STATUS_PLACEMENT, 't.id', 'DESC', '', '', $id);
        $data_reader = Followers::getFollowerProvider($id, 10);
        $data_comments = Comments::getCommentsProvider(10, '', '', Comments::STATUS_PLACEMENT, 't.id', 'DESC', '', '', $id);

        $model = Users::model()->findByPk($id);

        $this->render('user', array('model'=>$model,
                                    'dataProvider'=>$dataProvider,
                                    'data_reader'=>$data_reader,
                                    'data_comments'=>$data_comments
        ));
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