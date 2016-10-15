<?php
    /* @var $this CatalogTreeController */
    /* @var $model CatalogTree */
    /* @var $form Model */
?>

<div class="form">

<?php
    $cs = Yii::app()->getClientScript();

    $cs->registerPackage('boot-select');

    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'catalog-tree-form-form',
            'enableAjaxValidation' => false,
        )
    );

    $categorys = $model::getAllTree($this->getCurrentLanguage()->id);

    $data = array();

    foreach($categorys as $category)
    {
        if ($category['id'] != $model->id)
        {
            $data['class'][$category['id']] = 'circle-'.($category['level'] - 1);
            $data['title'][$category['id']] = $category['title'];
        }
    }

    if($model['level'] != 1 && $model->parent()->lft)
    {
        $model_id = $model->parent()->find()->id;
        $model_type = $model->parent()->find()->type;
    }
    elseif(isset($_GET['parent']))
    {
        $model_id = $_GET['parent'];
    }
?>

<?php
    if(isset($model_id))
    {
?>
        <div class="form-group">
            <?php echo CHtml::label('Родительская папка:*', ''); ?>

            <select class="selectpicker form-control" id="parent" name="parent">
<?php
                foreach($data['title'] as $key => $value)
                {
                    $selected = ($model_id == $key) ? 'selected' : '';
                    echo '<option '.$selected.' class="'.$data['class'][$key].'" value="'.$key.'">'.$value.'</option>';
                }
?>
            </select>
        </div>
<?php
    }
?>
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

    <div class="form-group">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownlist($model, 'type', $model->getType()); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="form-group">
<?php
        echo $form->labelEx($model, 'text');

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

        echo $form->error($model, 'text');
?>
    </div>

    <div class="form-group">
<?php
        echo $form->labelEx($model, 'images', array('label' => Yii::t('app', 'Upload images')));

        $this->widget('application.extensions.EFineUploader.EFineUploader',
            array(
                'id' => 'FineUploaderLogo',
                'config' => array(
                    'button' => "js:$('.download_image')[0]",
                    'autoUpload' => true,
                    'request' => array(
                        'endpoint' => $this->createUrl($this->id.'/upload'),
                        'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
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
                        'uploadButton' => Yii::t('app', 'Upload a file'),
                        'dragZone' => Yii::t('app', 'Drop files here to upload') . '<br/><br/> или',
                    ),
                )
            )
        );

        Yii::app()->getClientScript()->registerScript("remove_image",
        "$('body').on('click','.images-block .fa-close', function()
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

    <div class="form-group">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="form-group"><div class="seo-title"><?php echo Yii::t('app', 'Seo tags'); ?></div></div>

    <div class="form-group seo-text">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_title'); ?>:
            <div>Осталось символов: <span><?php echo 255-strlen($model->seo_title); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_title'); ?>
        <?php echo $form->error($model, 'seo_title'); ?>
    </div>

    <div class="form-group seo-text">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_keywords'); ?>:
            <div>Осталось символов: <span><?php echo 255-strlen($model->seo_keywords); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_keywords'); ?>
        <?php echo $form->error($model, 'seo_keywords'); ?>
    </div>

    <div class="form-group seo-text">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_description'); ?>:
            <div>Осталось символов: <span><?php echo 255-strlen($model->seo_description); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_description'); ?>
        <?php echo $form->error($model, 'seo_description'); ?>
    </div>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app', 'Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

</div>