<?php
/* @var $this AskanswerController */
/* @var $model AskAnswer */
/* @var $form BsActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=>'askanswer_form-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <?php echo $form->labelEx($model,'group_id'); ?>
        <?php echo $form->dropDownList($model,'group_id',CHtml::listData(AskAnswerGroups::model()->active()->findAll(),'id','title'),array('prompt'=>'Выберите группу')); ?>
        <?php echo $form->error($model,'group_id'); ?>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textArea($model,'text'); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',$model->getStatus()); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

	<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->