<?php
    /* @var $this CatalogTreeController */
    /* @var $model CatalogTree */
    /* @var $form Model */
?>

<div class="form catalog-tree-form-form">

    <?php $form=$this->beginWidget('BsActiveForm',
        array(
            'id'=>'catalog-tree-form-form',
            'enableAjaxValidation'=>false,
        )
    );
?>
    <div class="form-group">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="form-group">
<?php
        echo $form->labelEx($model,'text');

        $this->widget('application.widgets.ImperaviRedactorWidget',
            array(
                'model' => $model,
                'attribute' => 'text',
                'plugins' => array(
                    'imagemanager' => array(
                        'js' => array('imagemanager.js',),
                    ),
                    'filemanager' => array(
                        'js' => array('filemanager.js',),
                    ),
                    'fullscreen' => array(
                        'js' => array('fullscreen.js'),
                    ),
                    'table' => array(
                        'js' => array('table.js'),
                    ),
                ),
                'options' => array(
                    'lang' => Yii::app()->language,
                    'imageUpload' => $this->createUrl('admin/imageImperaviUpload'),
                    'imageManagerJson' => $this->createUrl('admin/imageImperaviJson'),
                    'fileUpload' => $this->createUrl('admin/fileImperaviUpload'),
                    'fileManagerJson' => $this->createUrl('admin/fileImperaviJson'),
                    'uploadFileFields' => array(
                        'name' => '#redactor-filename'
                    ),
                    'changeCallback' => 'js:function()
                    {
                        viewSubmitButton(this.$element[0]);
                    }',
                    'buttonSource' => true,
                ),
            )
        );
        echo $form->error($model,'text');
?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',$model->getStatus()); ?>
        <?php echo $form->error($model,'status'); ?>
    </div>

    <h3><?php echo Yii::t('app','Seo tags'); ?></h3>

    <div class="form-group">
        <?php echo $form->labelEx($model,'seo_title'); ?>
        <?php echo $form->textField($model,'seo_title'); ?>
        <?php echo $form->error($model,'seo_title'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'seo_keywords'); ?>
        <?php echo $form->textField($model,'seo_keywords'); ?>
        <?php echo $form->error($model,'seo_keywords'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'seo_description'); ?>
        <?php echo $form->textArea($model,'seo_description'); ?>
        <?php echo $form->error($model,'seo_description'); ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form --> 