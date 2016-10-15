<?php
    /* @var $this SettingsController */
    /* @var $model Settings */
    /* @var $form CActiveForm */
?>

<div class="form basic_settings">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'settings-index-form',
            'enableAjaxValidation' => false,
        )
    );
?>
    <div class="col-xs-7 no-left">

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'site_name'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'site_name', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'site_name'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'company'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'company', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'company'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'email', array('label' => 'Email суперадминистратора для восстановления пароля:', 'style' => 'padding-left: 10px; margin-top: 0;')); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'email', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <h3>Оповещения на e-mail</h3>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'email_order'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'email_order', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'email_order'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'email_comment'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'email_comment', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'email_comment'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'email_callback'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'email_callback', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'email_callback'); ?>
            </div>
        </div>

        <h3>Социальные сети</h3>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'vk'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'vk', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'vk'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'facebook'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'facebook', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'facebook'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'odnoklasniki'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'odnoklasniki', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'odnoklasniki'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'google'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'google', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'google'); ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-5 no-left">
                <?php echo $form->labelEx($model, 'twitter'); ?>
            </div>
            <div class="col-xs-7">
                <?php echo $form->textField($model, 'twitter', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'twitter'); ?>
            </div>
        </div>

    </div>

    <div class="col-xs-5 no-right">
        <div class="row form-group">
            <div class="col-xs-3">
                <?php echo CHtml::label('Favicon.ico', ''); ?>
            </div>

            <div class="form-group col-xs-6 image">
<?php
                $this->widget('ext.EFineUploader.EFineUploader',
                    array(
                        'id' => 'FineUploader',
                        'config' => array(
                            'multiple' => false,
                            'button' => "js:$('#load_from_disk')[0]",
                            'text' => array('dragZone' => ''),
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
                                        $("#avatar").css({"background":"url(/"+response["folder"]+response["filename"]+") center center no-repeat"}).css({"background-size":"cover"});'
                                        . '$(".avatar").find("input[type=hidden]").remove();
                                        $(".avatar").find("i").remove();'
                                        . '$(".avatar").append("<input type=\"hidden\" name=\"' . get_class($model) . '[' . $model->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\">")
                                    }

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
                if ($ava_result)
                {
                    $avatar_value = $avatars[0]['path'] . $avatars[0]['name'];
                }

                $image_attr_name = $model->getFilesAttrName();
                $form_class = get_class($model);

                if (isset($_POST[$form_class][$image_attr_name][0]))
                {
                    $post_avatar = $_POST[$form_class][$image_attr_name][0];
                }

                if ($ava_result && (!$model->hasErrors() || (isset($post_avatar) && $post_avatar == $avatar_value)))
                {
                    $avatar = array(
                        'img' => $avatars[0]['path'] . 'original/' . $avatars[0]['name'],
                        'value' => $avatar_value
                    );
                }
                elseif (isset($post_avatar))
                {
                    $avatar = array(
                        'img' => $post_avatar,
                        'value' => $post_avatar
                    );
                }

                $image_block = '<div class="avatar">';

                    if (isset($avatar) && is_array($avatar) && $avatar["img"] != '')
                    {
                        $image_block .=
                            '<div id="avatar" style="background: url(/'.$avatar['img'].') center center no-repeat; background-size: cover;"></div>'.
                            '<input type="hidden" name="' . get_class($model) . '[' . $model->getFilesAttrName() . '][]" value="' . $avatar['value'] . '">
                            <img class="close-img fa-close" src="/images/icon-admin/close_photo.png">';
                    }
                    else
                    {
                        $image_block .= '<div id="avatar" style="background: url(/' . Yii::app()->params['noimage'] .'); background-size:cover;"></div>';
                    }

                    $image_block .=
                            '<div class="col-xs-6 ">
                                    <div class="row">
                                        <div class="film">
                                            <p><br>
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
        </div>

        <div class="clearfix"></div>

        <div class="row form-group">
            <div class="col-xs-3 no-left">
                <?php echo $form->labelEx($model, 'info', array('style' => 'margin-left: -8px;')); ?>
            </div>
            <div class="col-xs-9">
                <?php echo $form->textArea($model, 'info', array('placeholder' => '', 'style' => 'margin-left: -8px;')); ?>
                <?php echo $form->error($model, 'info'); ?>
            </div>
        </div>

        <div class="form-group buttons">
            <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
            <span>Отмена</span>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->