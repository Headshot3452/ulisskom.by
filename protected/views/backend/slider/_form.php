<?php
    /* @var $this SliderController */
    /* @var $model Slider */
    /* @var $form BsActiveForm */
?>

<div class="clearfix"></div>
<div class="form news-_form-form">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
	        'id' => 'news-_form-form',
	        'enableAjaxValidation' => false,
        )
    );
?>
    <div class="form-group row">
        <div class="col-xs-3 no-right">
            <?php echo $form->labelEx($model, 'time'); ?>
<?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'language' => 'ru',
                    'model' => $model,
                    'attribute' => 'time',
                    'options' => array(
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'class' => 'form-control',
                        'value' => (!empty($model->time)) ? date("d.m.Y", $model->time) : date("d.m.Y", time()),
                    ),
                )
            );
            echo $form->error($model, 'time');
?>
        </div>
        <div class="col-xs-6 col-xs-offset-3">
            <?php echo $form->labelEx($model, 'author_id'); ?>
            <?php echo $form->dropDownList($model, 'author_id', Users::getUserList(array(1, 4)), array('empty' => 'Администратор')); ?>
            <?php echo $form->error($model, 'author_id'); ?>
        </div>
    </div>

	<div class="form-group">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
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
                    'js'=>array('fullscreen.js'),
                ),
                'table' => array(
                    'js'=>array('table.js'),
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
                                            $(".images .thumbnails").append("<li class=\"image\" style=\"float: left;\"><input type=\"hidden\" name=\"'.get_class($model).'['.$model->getFilesAttrName().'][]\" value=\""+response["folder"]+response["filename"]+"\"><img src=\"/"+response["folder"]+response["filename"]+"\" width=\"130\" height=\"130\" /><img class=\"close-img fa-close\" src=\"/images/icon-admin/close_photo.png\"></li>")
                                            }
                                        }',
                    ),
                    'validation' => array(
                        'allowedExtensions' => array('jpg', 'jpeg', 'png'),
                        'sizeLimit' => 3 * 1024 * 1024,
                    ),
                    'text' => array(
                        'uploadButton' => Yii::t('app','Upload a file'),
                        'dragZone' => Yii::t('app','Drop files here to upload') . '<br/><br/> или',
                    ),
                )
            )
        );

        Yii::app()->getClientScript()->registerScript("remove_image",
            "$('body').on('click','.images-block .fa-close',function()
            {
                $(this).closest('.image').remove();
            });
        ");

        $images_for_key = array(); //для проверки по ключу, наличия картинки
        $images = @unserialize($model->images);

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
                                    '<li class="image" style="float: left;">'.$model->gridImage($images[$i]['path'], '', array('width' => '130', 'height' => '130')).
                                        '<input type="hidden" name="'.$form_class.'['.$image_attr_name.'][]" value="'.$images[$i]['name'].'"><img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                                    </li>';
                            }
                            else
                            {
                                echo '<img style="position: absolute;" src="/'.Yii::app()->params['no-image'].'" id="avatar" width="130" />';
                            }
                        }
                    }
                    else
                    {
                        echo '<img style="position: absolute;" src="/'.Yii::app()->params['no-image'].'" id="avatar" width="130" />';
                    }
            echo
                '</ul>
            </div>
        </div>';
?>
    </div>

	<div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
	</div>

    <?php $this->endWidget(); ?>

</div>

<div class="form-group">
    <?php echo $form->labelEx($model, 'name'); ?>
    <?php echo $form->textField($model, 'name', array('placeholder'=>'URL')); ?>
    <?php echo $form->error($model, 'name'); ?>
</div>