<?php
    /* @var $this UsersController */
    /* @var $model Users */
    /* @var $form BsActiveForm */
?>

<h2>
    <?php echo Yii::t('app', 'Change Password') ;?>
</h2>
<div class="clearfix"></div>

<div class="form row col-md-6">

<?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm',
        array(
            'id' => 'users-changePassword-form',
            'enableAjaxValidation' => false,
        )
    );
?>

    <div class="form-group row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'password', array('label' => 'Текущий пароль')); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($model, 'password', array('class' => 'form-control', 'placeholder' => 'Текущий пароль', 'value' => '')); ?>
            <?php echo $form->error($model, 'password'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'new_password'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($model, 'new_password', array('class' => 'form-control', 'placeholder' => 'Новый пароль', 'value' => '')); ?>
            <?php echo $form->error($model, 'new_password'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'password_confirm'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($model, 'password_confirm', array('class' => 'form-control', 'placeholder' => 'Подтвердите пароль', 'value' => '')); ?>
            <?php echo $form->error($model, 'password_confirm'); ?>
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

</div>