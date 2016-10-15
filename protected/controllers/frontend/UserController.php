<?php
class UserController extends FrontendController
{
    public $layout = 'frontend_user_login';

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
                'height' => '34',
            ),
        );
    }

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
                'actions'=>array('register','login','passwordreset','passwordresetcheck'),
            ),
            array('allow',
                'users'=>array('@'),
            ),
            array('allow',
                'users'=>array('*'),
                'actions'=>array('register','passwordreset','passwordresetcheck','usercheck','login','captcha'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionLogin()
    {
        $model = new Users('login');

        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if ($model->validate())
            {
                $UserSession=UsersSessions::model()->findByPk(Yii::app()->session->getSessionId());
                $UserSession->user_id=Yii::app()->user->id;
                $UserSession->save();

                Yii::app()->user->removeCaptcha();
                $this->redirect( Yii::app()->user->returnUrl&&Yii::app()->user->returnUrl!='/' ? Yii::app()->user->returnUrl : $this->createUrl('/admin/admin'));
            }
        }
        $this->render('login',array('model'=>$model));
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('user/login'));
    }
	
	public function actionRegister()
    {
        $user = new Users('register');
        $user_info = new UserInfo();
        $address = new Address();

        Yii::app()->user->addCaptcha();

        $this->layout = 'frontend_lk';

        if(Yii::app()->params['site']['allow_register'] && isset($_POST['Users']) && isset($_POST['UserInfo']) && isset($_POST['Address']))
        {
            $user->attributes = $_POST['Users'];
            $user_info->attributes = $_POST['UserInfo'];
            $address->attributes = $_POST['Address'];

            $address->user_name = $user_info->getFullName();
            $address->phone = $user_info->phone;

            $user_valid = $user->validate();
            $userinfo_valid = $user_info->validate();
            $address_valid = $address->validate();

            if($user_valid && $userinfo_valid && $address_valid)
            {
                $user->user_info = $user_info;
                $user->addresses = $address;

                $user->login = $user->email;

                $user->status = Users::STATUS_NOT_ACTIVE;
                $user->role = Users::ROLE_USER;

                $user->save(false);

                Yii::app()->user->setFlash('alert-swal', array(
                    'header' => 'Спасибо за регистрацию!',
                    'content' => 'На адрес вашей электронной почты отправлено письмо. Для завершения регистрации перейдите по ссылке указанной в письме ',
                ));

                $this->refresh();
            }
        }
        $this->render('registration',array('user'=>$user, 'user_info'=>$user_info, 'address'=>$address));
    }
    
    public function actionPasswordReset()
    {
        $model= new Users('user_check');
        if(isset($_POST['Users']))
        {
            $model->attributes=$_POST['Users'];
            if ($model->validate())
            {
               $user=$model::model()->findByAttributes(array('email'=>$model->email));
               if ($user)
               {
                   $result=UsersCheckAction::insertAction($user->id,UsersCheckAction::TYPE_RECOVER_PASSWORD);
                   if ($result)
                   {
                       Yii::app()->user->removeCaptcha();
                       Yii::app()->user->setFlash('modal',Yii::t('app','Further instructions have been sent to the specified email'));
                       $this->refresh();
                   }
                   else
                       throw new CException('Error');
               }
               else
               {
                    $model->addError('email', Yii::t('app','Not found user'));
               }
            }
            Yii::app()->user->addCaptcha();
        }
        $this->render('user_check',array('model'=>$model));
    }
    
    public function actionPasswordResetCheck($hash)
    {
        $item=UsersCheckAction::getItem(UsersCheckAction::TYPE_RECOVER_PASSWORD, $hash);
        if ($item)
        {
            $model=Users::model()->findByPk($item->user_id);
            $model->scenario='password_reset';
            if (isset($_POST['Users']))
            {
                $model->attributes=$_POST['Users'];
                $model->status=Users::STATUS_OK;
                if ($model->validate())
                {
                    $model->save(false);
                    $item->delete();
                    
                    Yii::app()->user->setFlash('modal',Yii::t('app','Password Reset Check ok'));
                    $this->redirect('/');
                }
            }
            $this->render('password_reset',array('model'=>$model));
        }
        else
            throw new CHttpException(404,'Not found');
    }

    public function actionUserCheck($hash)
    {
        $item=UsersCheckAction::getItem(UsersCheckAction::TYPE_REGISTRATION, $hash);

        if ($item)
        {
            $model=Users::model()->findByPk($item->user_id);
            $model->scenario='user_check_register';
            $model->status=Users::STATUS_OK;
            if ($model->save())
            {
                $item->delete();

                Yii::app()->user->setFlash('alert-swal', array(
                    'header' => 'E-mail успешно подтвержден',
                    'content' => 'Вы можете авторизоваться',
                ));
                $this->redirect('/');
            }
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
//                $this->refresh();
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
