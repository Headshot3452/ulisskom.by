<?php
/* @var $this CatalogProductsController */
/* @var $model CatalogProducts */
/* @var $form BsActiveForm */


echo "<h2>Редактировать Фото #$model->id </h2>";?>

<div class="form-group col-xs-6 image">
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
                                                    $("#avatar").css({"background":"url(/"+response["folder"]+response["filename"]+") center center no-repeat"}).css({"background-size":"contain"});
                                                   '//$("#avatar").attr("src","/"+response["folder"]+response["filename"]);
                    . '$(".avatar").find("input[type=hidden]").remove();
                                                    $(".avatar").find("i").remove();'
                    . '$(".avatar").append("<input type=\"hidden\" name=\"' . get_class($model) . '[' . $model->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\">")
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
                                    $('#avatar').css({'background':'url(/" . Yii::app()->params['noimage'] .") center center no-repeat'}).css({'background-size':'contain'});
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

$image_block = '<div class="avatar">';

if (isset($avatar) && is_array($avatar) && $avatar["img"] != '') {
    $image_block .= '<div id="avatar" style="background: url(/'.$avatar['img'].') center center no-repeat; background-size:contain;"></div>'.
        '<input type="hidden" name="' . get_class($model) . '[' . $model->getFilesAttrName() . '][]" value="' . $avatar['value'] . '">
<img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                                ';
} else {
//    $image_block .= '<img src="/' . Yii::app()->params['noimage'] . '" id="avatar"/>';
    $image_block .= '<div id="avatar" style="background: url(/' . Yii::app()->params['noimage'] .'); background-size:contain;"></div>';
}

$image_block .=
    '<div class="row gallery-avatar">
                                    <div class="col-xs-6 ">
                                        <div class="row">
                                            <div class="film">
                                                <p><br><br><br><br><br><br><br><br><br>
                                                    Перетащите картинку<br>сюда<br><br> или<br>
                                                    <a href="#" id="load_from_disk" class="btn btn-primary">Загрузите</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

$image_block .= '</div>';

echo $image_block;
?>
</div>

<div class="form-group col-xs-4">
    <?php echo $form->labelEx($model,'create_time'); ?>
    <?php echo $form->textField($model, 'create_time', array('placeholder'=>'', 'class' => 'form-control', 'value' =>Yii::app()->dateFormatter->format('dd MMMM yyyy', $model->create_time?:time()), 'readonly' => true)); ?>
    <?php echo $form->error($model,'create_time'); ?>
</div>

<div class="form-group col-xs-5">
    <?php echo $form->labelEx($model,'author_id');?>
    <?php echo $form->dropDownList($model, 'author_id', Users::model()->getUserList()); ?>
<!--    --><?php //echo $form->textField($model->author->user_info,'name', array('placeholder'=>'')); ?>
    <?php echo $form->error($model,'title'); ?>
</div>

<div class="form-group col-xs-5">
    <?php echo $form->labelEx($model->parent,'big_width'); ?><br>
    <label><?php echo $model->parent->big_width ?></label>
</div>


<div class="form-group col-xs-5">
    <?php echo $form->labelEx($model->parent,'small_width'); ?><br>
    <label><?php echo $model->parent->small_width ?></label>
</div>

<div class="form-group col-xs-12">
    <?php echo $form->labelEx($model,'title'); ?>
    <?php echo $form->textField($model,'title', array('placeholder'=>'')); ?>
    <?php echo $form->error($model,'title'); ?>
</div>

<div class="form-group col-xs-12">
    <?php echo $form->labelEx($model,'description', array('placeholder'=>'')); ?>
    <?php
        $this->widget('application.widgets.ImperaviRedactorWidget',array(
            'model'=>$model,
            'attribute'=>'description',
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
    <?php echo $form->error($model,'description'); ?>

</div>

<div class="form-group col-xs-12">
    <?php echo $form->labelEx($model,'url'); ?>
    <?php echo $form->textField($model,'url', array('placeholder'=>'')); ?>
    <?php echo $form->error($model,'url'); ?>
</div>
