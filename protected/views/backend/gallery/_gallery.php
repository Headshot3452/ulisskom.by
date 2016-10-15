<?php
/* @var $this MenuController */
/* @var $model Menu */
/* @var $form BsActiveForm */
?>
<div class="form">

    <?php $form = $this->beginWidget('BsActiveForm', array(
        'id' => 'gallery-form',
        'htmlOptions'=>array('class'=>'col-xs-12'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of BsActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    ));
    ?>

    <h2>Редактировать группу</h2>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name'); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
    <h3>Размер фото по ширине</h3>

    <div class="row px">
        <div class="form-group col-xs-4">
            <?php echo $form->labelEx($model, 'big_width'); ?>
            <?php echo $form->textField($model, 'big_width'); ?> <span> px</span>
            <?php echo $form->error($model, 'big_width'); ?>
        </div>
        <div class="form-group col-xs-4">
            <?php echo $form->labelEx($model, 'small_width'); ?>
            <?php echo $form->textField($model, 'small_width'); ?> <span> px</span>
            <?php echo $form->error($model, 'small_width'); ?>
        </div>
    </div>
    <?php
    echo $form->labelEx($model, 'images');
    $this->widget('ext.EFineUploader.EFineUploader', array(
            'id' => 'FineUploader',
            'config' => array(
                'multiple' => false,
                'button' => "js:$('#load_from_disk')[0]",
                'autoUpload' => true,
                'text' => array('dragZone' => ''),
                'request' => array(
                    'endpoint' => $this->createUrl($this->id . '/upload'),
                    'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                ),
                'retry' => array('enableAuto' => true, 'preventRetryResponseProperty' => true),
                'chunking' => array('enable' => true, 'partSize' => 100),//bytes
                'callbacks' => array(
                    'onComplete' => 'js:function(id, name, response)
                                            {
                                                if (response["success"])
                                                {
                                                    $("#avatar").css({"opacity":"1"});
                                                    $("#avatar").attr("src","/"+response["folder"]+response["filename"]).attr("width","70"); '
                                                    . '$(".avatar").find("input[type=hidden]").remove();
                                                    $(".avatar").find("i").remove();
                                                    $(".avatar").append("<img class=\"close-img fa-close\" src=\"/images/icon-admin/close_photo.png\">");
                                                    '
                                                    . '$(".avatar #avatar").append("<input type=\"hidden\" name=\"'
                                                    . get_class($model) . '[' . $model->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\">")
                                                }
                                                $("#avatar-form").submit();
                                            }',
                ),
                'validation' => array(
                    'allowedExtensions' => array('jpg', 'jpeg'),
                    'sizeLimit' => 3 * 1024 * 1024,//maximum file size in bytes
                ),
            )
        )
    );

    Yii::app()->getClientScript()->registerScript(
        "removeavatar", " $('body').on('click','.close-img',function()
                                {
                                    $('#avatar').css({'opacity':'0'});
                                    $('#avatar').attr('src','/" . Yii::app()->params['noimage'] . "');
                                    $('.avatar').find('input[type=hidden]').val('');
                                    $(this).remove();
                                });"
    );

    $avatars = @unserialize($model->images);
    $ava_result = $avatars && is_array($avatars);
    if ($ava_result) {
        $avatar_value = $avatars[0]['path'] . $avatars[0]['name'];
    }

    $image_attr_name = $model->getFilesAttrName();
    $form_class = get_class($model);

    if (isset($_POST[$form_class][$image_attr_name][0])) {
        $post_avatar = $_POST[$form_class][$image_attr_name][0];
    }


    if ($ava_result && (!$model->hasErrors() || (isset($post_avatar) && $post_avatar == $avatar_value))) {
        $avatar = array('img' => $avatars[0]['path'] . 'small/' . $avatars[0]['name'],
            'value' => $avatar_value
        );
    } elseif (isset($post_avatar)) //attr_items это имя поля, где лежит tmp путь к картинке
    {
        $avatar = array('img' => $post_avatar,
            'value' => $post_avatar
        );
    }
    $opacity = isset($avatar['img'])?'1':'0';
    $image_block = '<div class="avatar">';

    if (isset($avatar) && is_array($avatar) && $avatar["img"] != '') {
        $image_block .= $model->gridImage($avatar['img'], '', array('id' => 'avatar', 'width' => '140')) .
            '<input type="hidden" name="' . get_class($model) . '[' . $model->getFilesAttrName() . '][]" value="' . $avatar['value'] . '">
                                <div class="box-photo">
                                     <p>
                                        <img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                                    </p>
                                </div>';
    } else {
        $image_block .= '<img src="/' . Yii::app()->params['noimage'] . '" id="avatar" width="140"  style="opacity:' . $opacity . ';"/>';
    }
    $image_block .=
        '<div class="row gallery-avatar">
                                    <div class="col-xs-6 ">
                                        <div class="row">
                                            <div class="film">
                                                <p>Перетащите картинку<br>сюда<br><br> или<br><br>
                                                    <a href="#" id="load_from_disk" class="btn btn-primary">Загрузите</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

    $image_block .= '</div>';

    echo $image_block;
    ?>

    <div class="form-group">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php
        $this->widget('application.widgets.ImperaviRedactorWidget', array(
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
        ));
        ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app', 'Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
    </div>

    <?php $this->endWidget(); ?>


</div><!-- form -->