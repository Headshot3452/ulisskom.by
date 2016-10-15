<?php
    /* @var $this UsersController */
    /* @var $model Users */
    /* @var $form BsActiveForm */
?>

<div class="form">

<?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm',
        array(
            'id' => 'users-login-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('class' => 'form-horizontal'),
        )
    );
?>
    <div class="form-group text-center title">
        <?php echo Yii::t('app', 'Member Login') ;?>
    </div>

	<div class="form-group">
        <div class="col-xs-12">
            <?php echo $form->textField($model, 'email'); ?>
            <?php echo $form->error($model, 'email', array('class' => 'errorMessage', 'placeholder' => 'E-mail')); ?>
        </div>
	</div>

	<div class="form-group">
        <div class="col-xs-12">
            <?php echo $form->passwordField($model, 'password'); ?>
            <?php echo $form->error($model, 'password', array('class' => 'errorMessage', 'placeholder' => 'Пароль')); ?>
        </div>

	</div>
	<div class="buttons form-group">
        <div class="col-xs-12">
<?php
            if (Yii::app()->params['site']['allow_register_admin'])
            {
                echo BsHtml::link(Yii::t('app','Register'), array('user/register'));
            }

            echo BsHtml::submitButton(Yii::t('app','Enter'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY));
            echo BsHtml::checkBox('checkbox', false, array('class' => 'checkbox group'));
            echo BsHtml::label(Yii::t('app','Remember Me'), 'checkbox', false, array('class' => 'checkbox'));
            echo BsHtml::link(Yii::t('app','Get new password'), $this->createUrl('user/passwordreset'), array('class' => 'passwordreset') );
?>
        </div>
	</div>

    <?php $this->endWidget(); ?>

</div>