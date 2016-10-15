<?php

class FeedbackController extends FrontendController
{
    public $root_id;

    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'testLimit' => 1,
                'padding' => 1,
                'backColor' => 0xFFFFFF,
                'maxLength' => 3,
                'minLength' => 3,
                'foreColor' => 0x727272,
                'width' => '98',
                'height' => '38',
            ),
            'upload' => 'actionsBackend.UploadAction'
        );
    }

    public function init()
    {
        parent::init();
        $this->root_id = 1;
    }

    public function actionIndex()
    {
        $this->setPageForUrl(Yii::app()->getRequest()->getPathInfo());
        $model=new Feedback();

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

        $this->render('index',array('model'=>$model));
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