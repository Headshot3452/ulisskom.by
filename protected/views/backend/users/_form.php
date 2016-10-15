<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form BsActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=>'users-_form-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="form-group">
		<?php echo $form->labelEx($model,'login'); ?>
		<?php echo $form->textField($model,'login'); ?>
		<?php echo $form->error($model,'login'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>20,'maxlength'=>50,'value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'password_confirm'); ?>
		<?php echo $form->passwordField($model,'password_confirm',array('size'=>20,'maxlength'=>50,'value'=>'')); ?>
		<?php echo $form->error($model,'password_confirm'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model, 'role', $model->getRole()); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', $model->getStatus()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>


	<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->