<h2>Редактирование профиля</h2>

<?php
$image = $user->getOneFile('small');

if (!file_exists($image)) {
    $image = Yii::app()->params['noavatar'];
}
?>

<div class="form row">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'user-info-index-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'htmlOptions' => array(
        'class' => "form-horizontal",
    ),
));

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
                          $("#avatar").css({"background":"url(/"+response["folder"]+response["filename"]+") center center no-repeat"}).css({"background-size":"contain"});'
                       . '$(".avatar").find("input[type=hidden]").remove();
                          $(".avatar").find("i").remove().append(\'<img class="close-img fa-close" src="/images/icon-admin/close_photo.png">\');'
                       . '$(".avatar").append("<input type=\"hidden\" name=\"' . get_class($user) . '[' . $user->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\">")
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
                                    $('#avatar').css({'background':'url(/" . Yii::app()->params['noimage'] . ") center center no-repeat'}).css({'background-size':'contain'});
                                    $('.avatar').find('input[type=hidden]').val('');
                                    $(this).remove();
                                });"
);

$avatars = @unserialize($user->avatar);
$ava_result = $avatars && is_array($avatars);
if ($ava_result) {
    $avatar_value = $avatars[0]['path'] . $avatars[0]['name'];
}

$image_attr_name = $user->getFilesAttrName();
$form_class = get_class($user);

if (isset($_POST[$form_class][$image_attr_name][0])) {
    $post_avatar = $_POST[$form_class][$image_attr_name][0];
}


if ($ava_result && (!$user->hasErrors() || (isset($post_avatar) && $post_avatar == $avatar_value))) {
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
    $image_block .= '<div id="avatar" style="background: url(/' . $avatar['img'] . ') center center no-repeat; background-size:contain;"></div>' .
        '<input type="hidden" name="' . get_class($user) . '[avatar][]" value="' . $avatar['value'] . '">
<img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                                ';
} else {
//    $image_block .= '<img src="/' . Yii::app()->params['noimage'] . '" id="avatar"/>';
    $image_block .= '<div id="avatar" style="background: url(/' . Yii::app()->params['noimage'] . '); background-size:contain;"></div>';
}

$image_block .=
    '<div class="col-md-12 profile-avatar">
                                            <div class="film text-center">
                                                <p><br><br><br><br>
                                                    Перетащите картинку<br>сюда<br><br> или<br>
                                                    <a href="#" id="load_from_disk" class="btn btn-primary">Загрузите</a>
                                                </p>
                                            </div>
                                </div>';

$image_block .= '</div>';
?>

<div class="col-md-4 col-md-push-6">
    <div class="text-uppercase label-title">Фотография профиля</div>
    <div class="col-md-12 row">
        <div class=""><?php echo $image_block; ?></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="col-md-6 col-md-pull-4">
    <div class="text-uppercase label-title">Личные данные</div>
    <div class="form-group">
        <div class="col-md-12">
            <?php echo $form->labelEx($user_info, 'name'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($user_info, 'name', array('class' => 'form-control', 'placeholder' => '')); ?>
            <?php echo $form->error($user_info, 'name'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <?php echo $form->labelEx($user_info, 'last_name'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($user_info, 'last_name', array('class' => 'form-control', 'placeholder' => '')); ?>
            <?php echo $form->error($user_info, 'last_name'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <?php echo $form->labelEx($user_info, 'patronymic'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($user_info, 'patronymic', array('class' => 'form-control', 'placeholder' => '')); ?>
            <?php echo $form->error($user_info, 'patronymic'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <?php echo $form->labelEx($user_info, 'nickname'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($user_info, 'nickname', array('class' => 'form-control', 'placeholder' => '')); ?>
            <?php echo $form->error($user_info, 'nickname'); ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <?php echo $form->labelEx($user_info, 'birth'); ?>
        </div>
        <div class="col-md-12 all date-block">
            <div class="col-md-4">
                <?php echo $form->dropDownList($user_info, 'birth_day', array_combine(range(1, 31), range(1, 31)), array('class' => "form-control")); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->dropDownList($user_info, 'birth_month', array_combine(range(1, 12), range(1, 12)), array('class' => "form-control")); ?>
            </div>
            <div class="col-md-4">
                <?php echo $form->dropDownList($user_info, 'birth_year', array_combine(range(date('Y') - 18, 1910), range(date('Y') - 18, 1910)), array('class' => "form-control")); ?>
            </div>
            <div class="col-md-12"> <?php echo $form->error($user_info, 'birth'); ?></div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
        <div class="col-md-12">
            <?php echo $form->labelEx($user_info, 'phone'); ?>
        </div>
        <div class="col-md-12">
            <?php echo $form->textField($user_info, 'phone', array('class' => 'form-control', 'placeholder' => '')); ?>
            <?php echo $form->error($user_info, 'phone'); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-6 submit-buttons">
    <?php
    echo BsHtml::submitButton(Yii::t('app','Save'),
        array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'class' => ''));
    echo CHtml::link(Yii::t('app','Cancel'), array('profile/settings'), array('class' => 'cancel_link'));
    ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->