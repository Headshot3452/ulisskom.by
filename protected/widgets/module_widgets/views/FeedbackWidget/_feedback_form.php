<?php $user = Users::model()->findByPk(Yii::app()->user->id); ?>
<?php $form=$this->beginWidget('BsActiveForm', array(
    'id'=>'feedback-form',
    'htmlOptions'=>array(
        'role'=>'form',
        'class'=>'form',
    ),
    'enableAjaxValidation'=>false,
    'enableClientValidation'=>true,
)); ?>

    <div class="form-group col-md-12">
        <label>Тема вопроса*</label>
        <?php echo $form->dropdownList($model, 'parent_id', CHtml::listData(FeedbackTree::model()->findAll(), 'id', 'title'), array('class'=>'form-control')); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>
    <div class="form-group col-md-12">
        <label>
            Текст сообщения*
        </label>
        <?php echo $form->textArea($model, 'ask', array('placeholder'=>'Введите ваше сообщение', 'class'=>'form-control')); ?>
        <?php echo $form->error($model, 'ask'); ?>
    </div>
    <div style="display: <?php echo (!Yii::app()->user->isGuest)?'none':'block'; ?>">
    <div class="form-group col-md-12">
        <label>
            Ф.И.О.*
        </label>
        <?php
            if(!Yii::app()->user->isGuest)
                if(isset($user->user_info))
                {
                    $full_name = $user->user_info->getFullName();
                    if(!empty($full_name))
                    {
                        echo $form->textField($model, 'name', array('placeholder'=>'Введите имя', 'value'=>$full_name));
                    }
                }
                else
                {
                    echo $form->textField($model, 'name', array('placeholder'=>'Введите имя', 'value'=>'admin'));
                }
            else
                echo $form->textField($model, 'name', array('placeholder'=>'Введите имя'));
        ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
    <div class="form-group col-md-12">
        <label>
            Ваш e-mail*
        </label>
        <?php echo $form->textField($model, 'email', array('placeholder'=>'Введите email', 'value'=>(!Yii::app()->user->isGuest)?$user->email:'')); ?>
        <?php echo $form->error($model, 'email'); ?>
    </div>

    <div class="form-group col-md-12">
        <label>
            Ваш номер телефона
        </label>
        <?php
        $this->widget('CMaskedTextField', array(
            'model' => $model,
            'attribute' => 'phone',
            'mask' => Yii::app()->params['phone']['mask'],
            'htmlOptions'=>array(
                'class'=>'form-control',
                'placeholder'=>'Введите телефон'
            )
        ));
        ?>
        <?php echo $form->error($model, 'phone'); ?>
    </div>
    </div>
<?php
if($this->settings['load_file_feedback']==1){
    ?>

    <div class="form-group col-xs-12" id="upload-file-feedback">
        <label>Добавление файлов</label>
        <?php
        $this->widget('application.extensions.EFineUploader.EFineUploader',
            array(
                'id' => 'FineUploaderLogo',
                'config' => array(
                    'button' => "js:$('.download_image')[0]",
                    'autoUpload' => true,
                    'request' => array(
                        'endpoint' => $this->createUrl($this->id.'/upload'),
                        'params' => array('YII_CSRF_TOKEN'=>Yii::app()->request->csrfToken),
                    ),
                    'retry' => array('enableAuto' => true, 'preventRetryResponseProperty' => true),
                    'chunking' => array('enable' => true, 'partSize' => 100),
                    'callbacks' => array(
                        'onComplete' => 'js:function(id, name, response)
                        {
                            if (response["success"])
                            {
                                var top = $(".images .thumbnails li:last").css("top");
                                $(".images .thumbnails").append("<li class=\"image\"><input type=\"hidden\" name=\"'.get_class($model).'['.$model->getFilesAttrName().'][]\" value=\""+response["folder"]+response["filename"]+"\"><span class=\"file-name\"><i class=\"fa fa-file\" aria-hidden=\"true\"></i>"+response["filename"]+"</span></span><span class=\"close-file\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span></li>")
                            }
                        }',
                    ),
                    'validation' => array(
                        'allowedExtensions' => array('jpg', 'jpeg', 'png'),
                        'sizeLimit'=>3 * 1024 * 1024,
                    ),
                    'text' => array(
                        'uploadButton' => '+ Добавить файл',
                        'dragZone' => Yii::t('app','Drop files here to upload') . '<br/><br/> или',
                    ),
                )
            )
        );

        Yii::app()->getClientScript()->registerScript("remove_image",
            "$('body').on('click','.close-file',function()
            {
                var index = $(this).index()
                $('.qq-upload-list > li').eq(index).hide();
                $(this).closest('.image').remove();
            });
        ");

        $images_for_key = array(); //для проверки по ключу, наличия картинки
        $images = @unserialize($model->files);

        $image_result = $images && is_array($images);
        $image_attr_name =  $model->getFilesAttrName();;
        $form_class = get_class($model);

        if ($image_result)
        {
            $count = count($images);
            for ($i = 0; $i < $count; $i++)
            {
                $images[$i] = array(
                    'path' => $images[$i]['path'].'small/'.$images[$i]['name'], //для отображение в теге img
                    'name' => $images[$i]['path'].$images[$i]['name'] //сама картинка без учета размера
                );

                $images_for_key[$images[$i]['name']] = $images[$i];
            }
        }

        if(isset($_POST[$form_class][$image_attr_name]))
        {
            $images = $_POST[$form_class][$image_attr_name];
            $count = count($images);
            for ($i = 0; $i < $count; $i++)
            {
                $images[$i] = array(
                    'path' => ((isset($images_for_key[$images[$i]])) ? $images_for_key[$images[$i]]['path'] : $images[$i]), // проверка если нет в массиве, то это новая картинка
                    'name' => $images[$i],
                );
            }
            $image_result = $images && is_array($images);
        }

        echo
        '<div class="images-block">
                <div class="images">
                    <ul class="thumbnails row">';

        if ($image_result)
        {
            $count = count($images);

            for ($i = 0; $i < $count; $i++)
            {
                if(isset($images[$i]['path']) && is_file($images[$i]['path']))
                {
                    echo
                        '<li class="image" style="float: left;">'.
                        '<input type="hidden" name="'.$form_class.'['.$image_attr_name.'][]" value="'.$images[$i]['name'].'"><span class=\"close-file\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></span>
                                        </li>';
                }
            }
        }
        echo
        '</ul>
            </div>
        </div>';
        ?>
    </div>
<?php } ?>
    <div class="clearfix"></div>

<?php
if (CCaptcha::checkRequirements()) {
    ?>
    <div class="form-group captcha col-md-12">
        <label>Я не робот*</label>

        <div>
            <div class="row col-md-12 captcha">
                <?php $this->widget('CCaptcha', array(
                    'clickableImage' => true,
                    'buttonLabel' => '<span class="fa fa-refresh"></span>',
                    'buttonOptions' => array('class' => 'captcha-refresh blue_link')
                )); ?>
                <?php echo $form->textField($model, 'captcha', array('placeholder'=>'Введите символ')); ?>
                <?php echo $form->error($model,'captcha'); ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
<?php
}
?>

    <div class="form-group col-md-12">
        <?php echo BsHtml::ajaxSubmitButton(Yii::t('app','Отправить'), $this->createUrl('feedback/index'), array(
                'dataType'=>'json',
                'type'=>'POST',
                'success'=>'function(data)
                            {
                                if(data.status=="success")
                                {
                                    $("#modalOkF").modal("show");
                                    $("#feedback-form")[0].reset();

                                    $(".captcha img").attr({"src": "/review/captcha/refresh/?"+Math.floor(Math.random()*(98)) + 1});
                                    $(".images .thumbnails li").remove();
                                }
                                else
                                {
                                    $.each(data, function(key, val)
                                    {
                                        $("#feedback-form").find("#"+key+"_em_").text(val).show();
                                    });
                                    $(".captcha img:first").trigger("click");
                                }
                            }',
            ),
            array('class'=>'btn-primary')); ?>
    </div>
<?php $this->endWidget(); ?>

<!-- Modal OK-->
<div class="modal fade" id="modalOkF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Отправка завершена</h4>
            </div>
            <div class="modal-body send">
                <p class="text-uppercase"><b>Спасибо!</b></p>

                <p>
                    Ваше сообщение отправлено.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Готово</button>
            </div>
        </div>
    </div>
</div>