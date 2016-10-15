<?php
/* @var $this BannersController */
/* @var $model Banners */
/* @var $form BsActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=>'banners-_form-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

    <div class="form-group">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description'); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url'); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<div class="row image">
		<?php

       //определяем какую аватарку отдать
        $images = @unserialize($model->image);
        $ava_result = $images&& is_array($images);
        if($ava_result)
        {
            $image_value = $images[0]['path'].$images[0]['name'];
        }

        $image_attr_name = $model->getFilesAttrName();
        $model_class = get_class($model);
        if(isset($_POST[$model_class][$image_attr_name][0]))
        {
            $post_image = $_POST[$model_class][$image_attr_name][0];
        }

        if ($ava_result&&(!$model->hasErrors()||(isset($post_image)&&$post_image==$image_value)))
        {
            $image=array('img'=>$images[0]['path'].'small/'.$images[0]['name'],
                                'value'=>$image_value
                                );
        }
        elseif(isset($post_image)) //attr_items это имя поля, где лежит tmp путь к картинке
        {
            $image=array('img'=>$post_image,
                        'value'=>$post_image
                        );
        }

        if (isset($image) && is_array($image))
        {
            echo $model->gridImage($image['img'],'',array('width'=>'200')).
                    '<input type="hidden" name="'.$model_class.'['.$model->getFilesAttrName().'][]" value="'.$image['value'].'">';

        }


        $this->widget('application.extensions.EFineUploader.EFineUploader',
            array(
                'id'=>'FineUploader',
                'config'=>array(
                                'autoUpload'=>true,
                                'request'=>array(
                                    'endpoint'=>$this->createUrl($this->id.'/upload'),
                                    'params'=>array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                                                ),
                                'retry'=>array('enableAuto'=>true,'preventRetryResponseProperty'=>true),
                                'chunking'=>array('enable'=>true,'partSize'=>100),//bytes
                                'callbacks'=>array(
                                            'onComplete'=>"js:function(id, name, response){
                                                                var parent = $('#FineUploader').parent();
                                                                parent.find('input[type=hidden]').remove();
                                                                parent.find('img').remove();
                                                                parent.prepend('<img width=200 src=\"/'+response['folder']+response['filename']+'\"/><input type=\"hidden\" name=\"".get_class($model).'['.  SliderImages::model()->getFilesAttrName()."][]\" value=\"'+response['folder']+response['filename']+'\">');
                                                                }",
                                            'onError'=>"js:function(id, name, errorReason){ alert(errorReason); }",
                                                    ),
                                'validation'=>array(
                                            'allowedExtensions'=>array('jpg','jpeg','png'),
                                            'sizeLimit'=>10 * 1024 * 1024,//maximum file size in bytes
                                            ),
                                )
                ));

        ?>
	</div>


	<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->