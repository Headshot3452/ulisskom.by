<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form BsActiveForm */
?>

<div class="form widget col-md-6 col-md-offset-3">

    <?php $form = $this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id' => 'users-login-form',
        'enableAjaxValidation' => false,
    )); ?>
    <div class="title row border-bottom">
        <h4>
            <?php
            echo Yii::t('app', 'Password recovery');
            ?>
        </h4>
    </div>
    <div class="body row">

        <div class="info col-md-12">
            <span class="fa fa-info-circle"></span>
            <span class="notice">Для восстановления пароля укажите ваш e-mail.</span>
        </div>

        <div class="clearfix"></div>

        <div class="form-group">
            <div class="col-md-12">
                <?php echo $form->labelEx($model, 'email', array('label' => Yii::t('app', 'Your e-mail'))); ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->textField($model, 'email', array('class' => 'form-control', 'placeholder' => 'Введите свой e-mail')); ?>
                <?php echo $form->error($model, 'email', array('class' => 'errorMessage')); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="buttons">
            <div class="col-md-12">
                <?php echo BsHtml::submitButton(Yii::t('app', 'Send'), array('id' => 'reset', 'color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
                <?php echo BsHtml::link(Yii::t('app', 'Cancel'), $this->createUrl('/userlogin'), array('class' => 'blue_link pull-right cancel_link')); ?>
            </div>

            <div class="clearfix"></div>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->