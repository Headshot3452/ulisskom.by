<?php
/* @var $this TextBlocksController */
/* @var $model TextBlocks */
/* @var $form BsActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=>'text-blocks-_form-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of BsActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'text'); ?>
        <?php
            $this->widget('application.widgets.ImperaviRedactorWidget',array(
                'model'=>$model,
                'attribute'=>'text',
                'plugins' => array(
                    'imagemanager' => array(
                        'js' => array('imagemanager.js',),
                    ),
                    'filemanager' => array(
                        'js' => array('filemanager.js',),
                    ),
                    'fullscreen'=>array(
                        'js'=>array('fullscreen.js'),
                    ),
                    'table'=>array(
                        'js'=>array('table.js'),
                    ),
                ),
                'options'=>array(
                    'lang'=>Yii::app()->language,
                    'imageUpload'=>$this->createUrl('admin/imageImperaviUpload'),
                    'imageManagerJson'=>$this->createUrl('admin/imageImperaviJson'),
                    'fileUpload'=>$this->createUrl('admin/fileImperaviUpload'),
                    'fileManagerJson'=>$this->createUrl('admin/fileImperaviJson'),
                    'uploadFileFields'=>array(
                        'name'=>'#redactor-filename'
                    ),
                    'changeCallback'=>'js:function()
                    {
                        viewSubmitButton(this.$element[0]);
                    }',
                    'buttonSource'=> true,
                ),
            ));
        ?>
		<?php echo $form->error($model,'text'); ?>
	</div>


	<div class="form-group buttons">
		<?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->