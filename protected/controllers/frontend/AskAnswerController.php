<?php

class AskanswerController extends FrontendController
{
    public $root_id;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'padding' => 1,
                'backColor' => 0xFFFFFF,
                'maxLength' => 4,
                'minLength' => 4,
                'foreColor' => 0x727272,
                'width' => '98',
                'height' => '35',
            ),
        );
    }

    public function init()
    {
        parent::init();
        $this->root_id = 1;

        $this->getPageModule();
    }

    public function actionIndex()
    {
        $askanswer_tree = AskAnswerTree::model()->active()->roots()->find('root = :root', array('root' => $this->root_id))->id;

        if(Yii::app()->request->isAjaxRequest)
        {
            if(isset($_POST['id']))
            {
                $tree = AskAnswerTree::model()->notDeleted()->findByPk($_POST['id']);
                $tree_other = $tree->descendants()->notDeleted()->findAll();

                $str_tree = '<option value="">Выберите группу</option>';
                foreach($tree_other as $value)
                {
                    $str_tree.='<option value="'.$value->id.'">'.$value->title.'</option>';
                }
                echo $str_tree;
            }
            Yii::app()->end();
        }

        if(isset($_GET['name']))
        {
            if(isset($_GET['ask_group']) && !empty($_GET['ask_group']))
            {
                $model = AskAnswer::model()->notDeleted()->parent($_GET['ask_group']);
            }
            else
            {
                if (isset($_GET['ask_category']) && !empty($_GET['ask_category']))
                    $model = AskAnswer::model()->notDeleted()->parent($_GET['ask_category']);
                else
                    $model = AskAnswer::model()->notDeleted()->parent($askanswer_tree);
           }

            $dataProvider = $model->language($this->getCurrentLanguage()->id)->search(10, $_GET['name']);
            $popular = $model->language($this->getCurrentLanguage()->id)->search(5, $_GET['name'], true);
        }
        else
        {
            $model = AskAnswer::model()->notDeleted()->parent($askanswer_tree);
            $dataProvider = $model->language($this->getCurrentLanguage()->id)->search(10);
            $popular = $model->language($this->getCurrentLanguage()->id)->search(5, '', true);
        }

        $this->render('index', array('dataProvider'=>$dataProvider, 'popular'=>$popular));
    }

    public function actionItem($name)
    {
        $model=AskAnswer::getAskAnswerByName($name, $this->getCurrentLanguage()->id);
        if (!$model)
        {
            throw new CHttpException(404);
        }
        $model->hits += 1;
        $model->save(false);

        $this->getPageModule('item');

        $this->setPageTitle($model->title);
        $this->breadcrumbs[]=$model->title;

        $this->render('item',array('model'=>$model));
    }

    public function actionFeedback()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            $model = new ContactsForm('insert');

            if(isset($_POST['ajax']) && ($_POST['ajax']==='feedback-form'))
            {
                $model->setScenario('ajax');
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            if(isset($_POST['ContactsForm'])) {
                $model->attributes = $_POST['ContactsForm'];
                if ($model->validate()) {
                    $feedback = new Feedback();
                    $criteria = new CDbCriteria();
                    $criteria->select = 'MAX(`sort`) as `sort`';
                    $sort = $feedback->find($criteria);
                    $sort = $sort->sort + 1;

                    $language = $this->getCurrentLanguage()->id;

                    if($filez=$this->uploadMultifile())
                    {
                        $feedback->files=serialize($filez);
                    }

                    $feedback->language_id = $language;
                    $feedback->sort = $sort;
                    $feedback->status = Feedback::STATUS_NEW;
                    $feedback->parent_id = $model->parent_id;
                    $feedback->time = time();
                    $feedback->ask = $model->ask;
                    $feedback->save(false);

                    $user = Users::model()->findByPk(Yii::app()->user->id);

                    $feedback_answer = new FeedbackAnswers();
                    $feedback_answer->language_id = $language;
                    $feedback_answer->feedback_id = $feedback->id;
                    $feedback_answer->settings_feedback_id = 1;
                    $feedback_answer->value = $model->name;
                    $feedback_answer->save(false);

                    $feedback_answer = new FeedbackAnswers();
                    $feedback_answer->language_id = $language;
                    $feedback_answer->feedback_id = $feedback->id;
                    $feedback_answer->settings_feedback_id = 2;
                    if(Yii::app()->user->isGuest)
                        $feedback_answer->value = $model->phone;
                    else
                        $feedback_answer->value = $user->user_info->phone;
                    $feedback_answer->save(false);

                    $feedback_answer = new FeedbackAnswers();
                    $feedback_answer->language_id = $language;
                    $feedback_answer->feedback_id = $feedback->id;
                    $feedback_answer->settings_feedback_id = 3;
                    $feedback_answer->value = $model->email;
                    $feedback_answer->save(false);

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

    public function uploadMultifile ()
    {
        if(!file_exists(Yii::getPathOfAlias('webroot').'/data/feedback/'))
        {
            mkdir(Yii::getPathOfAlias('webroot').'/data/feedback/', 0700, true);
        }

        $ffile=array();
        
        if(isset($_POST['ContactsForm']['item_file']))
            if($sfile=$_POST['ContactsForm']['item_file'])
            {
                foreach ($sfile as $i=>$file)
                {
                    $path = pathinfo($file);

                    copy(Yii::getPathOfAlias('webroot').'/'.$file, Yii::getPathOfAlias('webroot').'/data/feedback/'.$path['basename']);
                    unlink(Yii::getPathOfAlias('webroot').'/'.$file);

                    $ffile[]=array('name'=>$path['basename'], 'path'=>'/feedback/');
                }
            }

        return $ffile;
    }
}