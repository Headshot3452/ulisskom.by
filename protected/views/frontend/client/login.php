<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form BsActiveForm */
?>

<div class="form widget col-md-6 col-md-offset-3">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'users-login-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('class' => ''),
    )); ?>
    <div class="title row border-bottom">
        <h4>
            <?php
            echo Yii::t('app', 'Your Personal Area');
            ?>
        </h4>
    </div>
    <div class="body row">

        <div class="clearfix"></div>

        <div class="form-group">
            <div class="col-md-12">
                <?php echo $form->labelEx($model, 'email'); ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Введите свой e-mail')); ?>
                <?php echo $form->error($model, 'email', array('class' => 'errorMessage', 'placeholder' => '')); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <?php echo $form->labelEx($model, 'password', array('label' => Yii::t('app', 'Password')));
                echo BsHtml::link(Yii::t('app', 'Forgot your password?'), $this->createUrl('client/passwordreset'), array('class' => 'blue_link pull-right', 'id' => 'forget_password')); ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->passwordField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Введите свой пароль')); ?>
                <?php echo $form->error($model, 'password', array('class' => 'errorMessage', 'placeholder' => 'Пароль')); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="buttons col-md-12">
                <?php
                echo BsHtml::submitButton(Yii::t('app', 'Login'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY));

                if (Yii::app()->params['site']['allow_register']) {
                    echo BsHtml::link(Yii::t('app', 'Register'), array('user/register'), array('class' => 'blue_link', 'id' => 'registry_link'));
                }
 ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->