
<?php
$form=$this->beginWidget('BsActiveForm', array(
    'id'=>'catalog-products-product-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // See class documentation of BsActiveForm for details on this,
    // you need to use the performAjaxValidation()-method described there.
    'enableAjaxValidation'=>false,
));
?>
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
        <?php
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
                        'onComplete'=>'js:function(id, name, response){
                        if (response["success"])
                        {
                            $("#new_image").html("<input type=\"hidden\" name=\"'.get_class($model).'['.$model->getFilesAttrName().'][]\" value=\""+response["folder"]+response["filename"]+"\"><img src=\"/"+response["folder"]+response["filename"]+"\" width=\"140\"/></i>")
                        }
                    }',
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

    <div id="new_image" class="form-group">
        <?php
            $image_attr_name =  $model->getFilesAttrName();;
            $form_class = get_class($model);

            if (isset($_POST[$form_class][$image_attr_name]))
            {
                $image = $_POST[$form_class][$image_attr_name];
                echo '<input type="hidden" name="'.$form_class.'['.$image_attr_name.'][]" value="'.$image[0].'">'.
                    $model->gridImage($image[0],'',array('width'=>'140'));
            }
        ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY)) ?>
    </div>
<?php $this->endWidget(); ?>


<div class="line"></div>

<div class="images">
    <?php
    if($images)
    {

        foreach( $images as $key=>$image)
        {
            $img = unserialize($image->images);
            $img = $img[0];

            ?>
            <div class="col-xs-3">
                <div class="header_image">

                <span class="image_edit"  title="<?php echo Yii::t('app','Edit'); ?>" href="#" style="margin-left: 10px;cursor: pointer" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-edit"></i>
                    <input type="hidden" name="image_id" value="<?php echo $image->id; ?>"/>
                    <input type="hidden" name="image_title"  value="<?php echo $image->title; ?>"/>
                    <input type="hidden" name="image_description" value="<?php echo $image->description; ?>" />
                </span>

                <a class="close" title="<?php echo Yii::t('app','Delete'); ?>" onclick="javascript:return confirm(<?php echo Yii::t('app','Are you sure you want to delete the image?'); ?>);"
                    href="<?php echo Yii::app()->createUrl('gallery/delete-image',array('id'=>$image->id)) ?>">&times;</a>
                </div>
                <a href="<?php echo  '/'.$img['path'].'big/'.$img['name']; ?>" class="thumbnail" rel="tooltip" data-title="" data-original-title="" title="">
                    <img src="<?php echo '/'.$img['path'].'small/'.$img['name']; ?>" alt="">
                </a>
            </div>
        <?php
        }

    }
    ?>
</div>


<script>
    $(document).ready(function(){
        $('.image_edit').click(function(){

            var title = $(this).find('input[name=image_title]').eq(0).val();
            var description = $(this).find('input[name=image_description]').eq(0).val();
            var id = $(this).find('input[name=image_id]').eq(0).val();

            $('#myModal').find('input[name=id]').val(id);
            $('#myModal').find('textarea[name=description]').html(description);
            $('#myModal').find('input[name=title]').val(title);
        });
    });
</script>

<?php $this->widget('bootstrap.widgets.BsModal', array(
    'id' => 'myModal',
    'header' => Yii::t('app','Edit description'),
    'content' => BsHtml::form(Yii::app()->createUrl('gallery/editImage'),'post',array()).
                    CHtml::hiddenField('id').
        '<div class="form-group">'.BsHtml::label($model->getAttributeLabel('title'),'title').BsHtml::textField('title', '').'</div>'.
        '<div class="form-group">'.BsHtml::label($model->getAttributeLabel('description'), 'description').BsHtml::textArea('description', '').'</div>'.
        BsHtml::submitButton(Yii::t('app','Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY)).
        BsHtml::button(Yii::t('app','Cancel'), array('data-dismiss' => 'modal')).
        CHtml::endForm(),
)); ?>