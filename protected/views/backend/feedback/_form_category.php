<?php
/* @var $this CatalogTreeController */
/* @var $model CatalogTree */
/* @var $form Model */
?>

<div class="form form-structure">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'catalog-tree-form-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation'=>false,
    )); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model,'title'); ?></div>
        <?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model,'name'); ?></div>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="form-group">
        <div class="label-block"><?php echo $form->labelEx($model,'text'); ?></div>
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

    <div class="form-group"><div class="seo-title"><?php echo Yii::t('app','Seo tags'); ?></div></div>

        <div class="form-group seo-text">
            <div class="label-block">
                <?php echo $form->labelEx($model,'seo_title'); ?>:
                <div>Осталось символов: <span><?php echo 255-strlen($model->seo_title); ?></span></div>
            </div>
            <?php echo $form->textArea($model,'seo_title'); ?>
            <?php echo $form->error($model,'seo_title'); ?>
        </div>

        <div class="form-group seo-text">
            <div class="label-block">
                <?php echo $form->labelEx($model,'seo_keywords'); ?>:
                <div>Осталось символов: <span><?php echo 255-strlen($model->seo_title); ?></span></div>
            </div>
            <?php echo $form->textArea($model,'seo_keywords'); ?>
            <?php echo $form->error($model,'seo_keywords'); ?>
        </div>

        <div class="form-group seo-text">
            <div class="label-block">
                <?php echo $form->labelEx($model,'seo_description'); ?>:
                <div>Осталось символов: <span><?php echo 255-strlen($model->seo_title); ?></span></div>
            </div>
            <?php echo $form->textArea($model,'seo_description'); ?>
            <?php echo $form->error($model,'seo_description'); ?>
        </div>


    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form --> 