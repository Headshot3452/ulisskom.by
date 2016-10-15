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
            'htmlOptions' => array('class' => 'center'),
        )
    );
?>

	<div class="row control-group">
        <div class="col-xs-12">
            <?php echo $form->labelEx($model, 'password', array('class' => 'control-label')); ?>
            <?php echo $form->passwordField($model, 'password', array('value' => '')); ?>
            <?php echo $form->error($model, 'password', array('class' => 'errorMessage')); ?>
        </div>
	</div>

    <div class="row control-group">
		<?php echo $form->labelEx($model, 'password_confirm', array('class' => 'control-label')); ?>
		<?php echo $form->passwordField($model, 'password_confirm', array('value' => '')); ?>
		<?php echo $form->error($model, 'password_confirm', array('class' => 'errorMessage')); ?>
	</div>

	<div class="row buttons control-group">
        <?php echo BsHtml::submitButton(Yii::t('app', 'Continue'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>

    <?php $this->endWidget(); ?>

</div>