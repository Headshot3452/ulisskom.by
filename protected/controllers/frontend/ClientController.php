<?php
class ClientController extends FrontendController
{
    public $layout = 'frontend_user_login';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users'=>array('@'),
                'actions'=>array('register','loginuser','passwordreset','passwordresetcheck'),
            ),
            array('allow',
                'users'=>array('@'),
            ),
            array('allow',
                'users'=>array('*'),
                'actions'=>array('register','passwordreset','passwordresetcheck','usercheck','loginuser','captcha'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionLoginUser()
    {
        $model = new Users('login');

        $this->layout = 'frontend_lk';

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if ($model->validate())
            {
                $UserSession = UsersSessions::model()->findByPk(Yii::app()->session->getSessionId());
                $UserSession->user_id = Yii::app()->user->id;
                $UserSession->save();

                $this->redirect(Yii::app()->user->returnUrl && Yii::app()->user->returnUrl != '/' ? Yii::app()->user->returnUrl : $this->createUrl('profile/index'));
            }
        }
        $this->render('login',array('model'=>$model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('site/index'));
    }

    public function actionPasswordReset()
    {
        $model= new Users('userfront_check');

        $this->layout = 'frontend_lk';

        if(isset($_POST['Users']))
        {
            $model->attributes = $_POST['Users'];
            if ($model->validate())
            {
                $user=$model::model()->findByAttributes(array('email'=>$model->email));
                if ($user)
                {
                    $result=UsersCheckAction::insertAction($user->id,UsersCheckAction::TYPE_CLIENT_RECOVER_PASSWORD);
                    if ($result)
                    {
                        $this->render('user_check_ok');
                    }
                    else
                        throw new CException('Error');
                }
                else
                {
                    $model->addError('email', Yii::t('app','Not found user'));
                }
            }
        }
        $this->render('user_check',array('model'=>$model));
    }

    public function actionPasswordResetCheck($hash)
    {
        $item = UsersCheckAction::getItem(UsersCheckAction::TYPE_CLIENT_RECOVER_PASSWORD, $hash);
        if ($item)
        {
            $this->layout = 'frontend_lk';

            $model = Users::model()->findByPk($item->user_id);
            $model->scenario='password_reset';
            if (isset($_POST['Users']))
            {
                $model->attributes=$_POST['Users'];
                $model->status=Users::STATUS_OK;
                if ($model->validate())
                {
                    $model->save(false);
                    $item->delete();

                    Yii::app()->user->setFlash('alert-swal', array(
                        'header' => 'Пароль успешно изменен',
                        'content' => 'Вы можете авторизоваться',
                    ));
                    $this->redirect(array('/userlogin'));
                }
            }
            $this->render('password_reset',array('model'=>$model));
        }
        else
            throw new CHttpException(404,'Not found');
    }

    public function actionChangePassword()
    {
        $model=Users::model()->findByPk(Yii::app()->user->id);
        $model->scenario='change_password';
        if (isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if ($model->validate())
            {
                $model->password=$model->new_password;
                $model->save(false,array('salt','password'));
                Yii::app()->user->setFlash('modal','Password changed');
                $this->refresh();
            }
        }
        $this->render('change_password',array('model'=>$model));
    }

    public function actionChangeEmail()
    {
        $model=Users::model()->findByPk(Yii::app()->user->id);
        $model->scenario='change_email';
        $model->new_email=$model->email;
        if (isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if ($model->validate())
            {
                $model->scenario='update';
                $model->email=$model->new_email;

                $model->save(true,array('email'));

                Yii::app()->user->login = $model->email;

                Yii::app()->user->setFlash('modal','E-mail changed');
                $this->refresh();
            }
        }
        $this->render('change_email',array('model'=>$model));
    }

    public function actionRepeatConfirm()
    {
        $user = Users::model()->not_active()->findByPk(Yii::app()->user->id);

        if (!$user)
        {
            throw new CHttpException(404);
        }

        UsersCheckAction::insertAction($user->id, UsersCheckAction::TYPE_REGISTRATION);
        Yii::app()->user->setFlash('modal',Yii::t('app','Message sended'));

        $this->render('confirm', array('message'=>$this->getConfirmationMessage()));
    }

    public function actionIndex()
    {
        $model = Users::model()->findByPk(Yii::app()->user->id);

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if($model->validate())
            {
                $model->save(false);
                Yii::app()->user->setFlash('modal',Yii::t('app','Profile saved'));
            }
        }
        $this->render('index', array('model'=>$model));
    }

    private function getConfirmationMessage()
    {
        return Yii::t('app','We have sent you a confirmation email. Please confirm your email. If you haven\'t received a email '.CHtml::link('click here',array('repeatConfirm')));
    }
}
?>
