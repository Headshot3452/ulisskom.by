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
            Восстановление пароля
        </h4>
    </div>

    <div class="body row">

        <div class="form-group">
            <div class="col-md-12">
                <?php echo $form->labelEx($model, 'password'); ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->textField($model, 'password', array('value' => '', 'class' => 'form-control', 'placeholder' => 'Новый пароль')); ?>
                <?php echo $form->error($model, 'password'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <?php echo $form->labelEx($model, 'password_confirm'); ?>
            </div>
            <div class="col-md-12">
                <?php echo $form->textField($model, 'password_confirm', array('class' => 'form-control', 'placeholder' => 'Повторите новый пароль')); ?>
                <?php echo $form->error($model, 'password_confirm'); ?>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <?php
                echo BsHtml::submitButton(Yii::t('app', 'Save'), array('class' => 'btn btn-success'));
                echo CHtml::link('Отмена', '/',array('class'=>'cancel_link'));
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->