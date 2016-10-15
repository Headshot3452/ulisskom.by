<?php
    $image = $item->getOneFile('original');
    if (!$image)
    {
        $image = Yii::app()->params['noimage'];
    }
?>

<div id="user_setting">
    <div class="row">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab">Профиль</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="profile">
                <div class="col-xs-12 no-all">
<?php
                    $form = $this->beginWidget('BsActiveForm',
                        array(
                            'id' => 'profil_form',
                            'enableAjaxValidation' => false,
                            'htmlOptions' => array(
                                'class' => 'form-horizontal',
                            ),
                        )
                    );
?>
                    <div class="col-xs-7 no-left">
                        <div class="form-group">
                            <?php echo $form->label($item->user_info, 'last_name', array('label' => 'Фамилия:*', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->textField($item->user_info, 'last_name', array('class' => 'form-control', "placeholder"=>"")); ?>
                                <?php echo $form->error($item->user_info,'last_name'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($item->user_info, 'name', array('label' => 'Имя:*', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->textField($item->user_info, 'name', array('class' => 'form-control', "placeholder"=>"")); ?>
                                <?php echo $form->error($item->user_info,'name'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($item->user_info, 'patronymic', array('label' => 'Отчество:', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->textField($item->user_info, 'patronymic', array('class' => 'form-control', "placeholder"=>"")); ?>
                                <?php echo $form->error($item->user_info,'patronymic'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($item, 'email', array('label' => 'E-mail:*', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->emailField($item, 'email', array('class' => 'form-control', "placeholder"=>"")); ?>
                                <?php echo $form->error($item,'email'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($item, 'password', array('label' => 'Пароль:', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->passwordField($item, 'password', array('class' => 'form-control', 'placeholder' => '')); ?>
                                <?php echo $form->error($item, 'password'); ?>
                                <a href="#modal_smena_parolya" role="button" class="btn pad-left" id="changePsw" data-toggle="modal"></a>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($item->user_info, 'phone', array('label' => 'Телефон:*', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->textField($item->user_info, 'phone', array('class' => 'form-control', "placeholder"=>"")); ?>
                                <?php echo $form->error($item->user_info,'phone'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?php echo $form->label($item->user_info, 'birth', array('label' => 'Дата рождения:*', 'class' => 'control-label col-xs-4')); ?>
                            <div class="col-xs-6">
                                <?php echo $form->textField($item->user_info, 'birth', array('class' => 'form-control', 'value' => $item->user_info->getBirthDay(), 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-4 no-right">
                        <div class="avatar">
<?php
                            $this->widget('ext.EFineUploader.EFineUploader',
                                array(
                                    'id'     => 'FineUploader',
                                    'config' => array(
                                        'button'     => "js:$('#load_from_disk')[0]",
                                        'autoUpload' => true,
                                        'text'       => array('dragZone' => ''),
                                        'request'    => array(
                                            'endpoint' => $this->createUrl($this->id . '/upload'),
                                            'params'   => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                                        ),
                                        'retry'      => array('enableAuto' => true, 'preventRetryResponseProperty' => true),
                                        'chunking'   => array('enable' => true, 'partSize' => 100),//bytes
                                        'callbacks'  => array(
                                            'onComplete' => 'js:function(id, name, response)
                                            {
                                                if (response["success"])
                                                {
                                                    $("#avatar").attr("src","/"+response["folder"]+response["filename"]).attr("width","70"); '
                                                    . '$(".avatar").find("input[type=hidden]").remove();
                                                    $(".avatar").find("i").remove();'
                                                    . '$(".avatar #avatar").append("<input type=\"hidden\" name=\"' . get_class($item) . '[' . $item->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\">")
                                                }
                                                $("#avatar-form").submit();
                                            }',
                                        ),
                                        'validation' => array(
                                            'allowedExtensions' => array('jpg', 'jpeg', 'png'),
                                            'sizeLimit'         => 3 * 1024 * 1024,//maximum file size in bytes
                                        ),
                                    )
                                )
                            );

                            Yii::app()->getClientScript()->registerScript(
                                "removeavatar", " $('body').on('click','.close-img',function()
                                {
                                    $('#avatar').attr('src','/" . Yii::app()->params['noavatar'] . "');
                                    $('.avatar').find('input[type=hidden]').val('');
                                    $(this).remove();
                                });"
                            );

                            $avatars = @unserialize($item->avatar);
                            $ava_result = $avatars && is_array($avatars);
                            if ($ava_result)
                            {
                                $avatar_value = $avatars[0]['path'] . $avatars[0]['name'];
                            }

                            $image_attr_name = $item->getFilesAttrName();
                            $form_class = get_class($item);

                            if (isset($_POST[$form_class][$image_attr_name][0]))
                            {
                                $post_avatar = $_POST[$form_class][$image_attr_name][0];
                            }


                            if ($ava_result && (!$item->hasErrors() || (isset($post_avatar) && $post_avatar == $avatar_value)))
                            {
                                $avatar = array('img'   => $avatars[0]['path'] . 'small/' . $avatars[0]['name'],
                                                'value' => $avatar_value
                                );
                            }
                            elseif (isset($post_avatar)) //attr_items это имя поля, где лежит tmp путь к картинке
                            {
                                $avatar = array('img'   => $post_avatar,
                                                'value' => $post_avatar
                                );
                            }

                            $avatar_block = '<div class="avatar">';

                            if (isset($avatar) && is_array($avatar) && $avatar["img"] != '')
                            {
                                $avatar_block .= $item->gridImage($avatar['img'], '', array('id' => 'avatar', 'width' => '70')) .
                                '<input type="hidden" name="' . get_class($item) . '[' . $item->getFilesAttrName() . '][]" value="' . $avatar['value'] . '">
                                <div class="box-photo">
                                    <p>
                                        <img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                                    </p>
                                </div>';
                            }
                            else
                            {
                                $avatar_block .= '<img src="/'.Yii::app()->params['noavatar'].'" id="avatar" width="70" />';
                            }

                            $avatar_block .=
                                '<div class="row photo-company">
                                    <label for="copypassport" class="control-label photo-label col-xs-6" style="text-align: right;">
                                        Фото:
                                    </label>

                                    <div class="col-xs-6 ">
                                        <div class="row">
                                            <div class="film">
                                                <p>Перетащите сюда <br>фотографию<br><br> или<br><br>
                                                    <a href="#" id="load_from_disk" class="btn btn-primary">Загрузите</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                            $avatar_block .= '</div>';

                            echo $avatar_block;
?>
                            <div class="information col-xs-12">
                                <div class="form-group">
                                    <label for="dateregistration" class="control-label col-xs-6">Дата регистрации:</label>

                                    <div class="col-xs-6 inf">
                                        <?php echo Yii::app()->dateFormatter->format('dd.MM.yyyy, HH:mm', $item->create_time); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastenter" class="control-label col-xs-6">Последний раз в системе:</label>

                                    <div class="col-xs-6 inf">
                                        <?php echo isset($item->usersSession->id) ? 'В сети' : Yii::app()->dateFormatter->format('dd.MM.yyyy, HH:mm', $item->update_time); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dateregistration" class="control-label col-xs-6">Последний IP:</label>

                                    <div class="col-xs-6 inf">
                                        <?php echo $item->last_ip; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group comment">
                        <?php echo $form->label($item->user_info, 'comment', array('label' => 'Комментарий:', 'class' => 'control-label col-xs-2')); ?>
                        <div class="col-xs-9">
                            <?php echo $form->textArea($item->user_info, 'comment', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="col-xs-7 no-left">
                        <h3 class=" col-xs-12">Адрес доставки</h3>
<?php
                        if (isset($item->addresses))
                        {
                            foreach ($item->addresses as $key => $value)
                            {
                                echo '<h5 class="col-xs-8 col-xs-offset-4">Адрес '. ++$key .'</h5>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]country", array("label" => "Страна:*", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->dropDownList($value, "[".$value['id']."]country", $this->getCountryFromAPI(), array("class" => "form-control", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]country") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]index", array("label" => "Индекс:", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]index", array("class" => "form-control", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]index") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]city", array("label" => "Город:*", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]city", array("class" => "form-control", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]city") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]street", array("label" => "Улица:*", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]street", array("class" => "form-control", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]street") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]house", array("label" => "Дом:*", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]house", array("class" => "form-control", "value" => "$value[house]", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]house") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]apartment", array("label" => "Квартира / офис:", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]apartment", array("class" => "form-control", "value" => "$value[apartment]", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]apartment") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]user_name", array("label" => "Контактное лицо:", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]user_name", array("class" => "form-control", "value" => "$value[user_name]", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]user_name") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        ' . $form->label($value, "[".$value['id']."]phone", array("label" => "Телефон:", "class" => "control-label col-xs-4")) . '
                                        <div class="col-xs-6">
                                            ' . $form->textField($value, "[".$value['id']."]phone", array("class" => "form-control", "value" => "$value[phone]", "placeholder"=>"")) . '
                                            ' . $form->error($value, "[".$value['id']."]phone") . '
                                        </div>
                                    </div>';

                                echo
                                    '<div class="form-group">
                                        <div class="col-xs-4">
                                            ' . $form->hiddenField($value, "[".$value['id']."]id", array("class" => "form-control")) . '
                                        </div>
                                    </div>';
                            }
                        }
                        $this->renderPartial('_modal_windows');
?>
                    </div>
                    <div class="form-group buttons">
                        <?php echo BsHtml::submitButton(Yii::t('app', 'Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
                        <?php echo CHtml::link('Отмена', array('settings/permission', 'id' => $item->id)) ;?>
                    </div>
                </div>
                <?php $this->endWidget(); ?>

                <form method="POST" class="copy" data-module="users">

                </form>
            </div>
        </div>
    </div>
</div>

<script>

    $(function()
    {
        function str_rand()
        {
            var result       = '';
            var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            var max_position = words.length - 1;
            for( i = 0; i < 10; ++i )
            {
                position = Math.floor ( Math.random() * max_position );
                result = result + words.substring(position, position + 1);
            }
            return result;
        }

        $("#changePsw").on('click', function()
        {
            $("#Users_password").attr('type', 'text').val(str_rand());
        });

        $("#Users_password").on('change keypress', function()
        {
            if($(this).attr('type') != 'text')
            {
                $(this).attr('type', 'text').val("");
            }
        });

    })

</script>