<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form BsActiveForm */
?>

<h2>
    Смена e-mail
</h2>
<div class="clearfix"></div>

<div class="form row col-md-6">

    <?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
        'id'=>'users-changeEmail-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
    )); ?>

    <div class="form-group row">
        <div class="col-md-12">
            <label>Текущий e-mail:</label>
        </div>
        <div class="col-md-12">
            <?php echo $model->email; ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model,'new_email', array('label'=>'Новый е-mail:')); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($model,'new_email', array('class'=>'form-control', 'placeholder'=>'', 'value'=>'')); ?>
            <?php echo $form->error($model,'new_email'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model,'password', array('label'=>'Текущий пароль:')); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($model,'password', array('class'=>'form-control', 'placeholder'=>'', 'value'=>'')); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-12 row submit-buttons">
        <?php
        echo BsHtml::submitButton('Сохранить',
            array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'class' => ''));
        echo CHtml::link('Отмена', array('profile/index'), array('class' => 'cancel_link'));
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->