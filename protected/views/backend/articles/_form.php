<?php
/* @var $this ArticlesController */
/* @var $model Articles */
/* @var $form BsActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('BsActiveForm', array(
	'id'=>'articles-form',
	'enableAjaxValidation'=>false,
)); ?>


	<?php
        echo $form->errorSummary($model);
        ob_start();
    ?>

    <div class="form-title"><?php echo Yii::t('app','Main') ?></div>
    <div class="group-input">


        <div class="form-group row">
            <div class="col-md-5 col-lg-3">
                <a class="popover-button" data-container="body" data-toggle="popover" data-placement="left" data-content="empty">
                    <i class="icon-admin-help"></i>
                </a>
                <?php echo $form->labelEx($model,'title'); ?></div>
            <div class="col-md-7 col-lg-9">
                <?php echo $form->textField($model,'title'); ?>
                <?php echo $form->error($model,'title'); ?>
            </div>
        </div>

        <div class="form-group row">
            <a data-toggle="collapse" class="dashed_link" href="#collapseOne" >
                <?php echo  Yii::t('app','Change URL')?>
            </a>
            <div class="collapse" id="collapseOne" >
                <div class="col-md-5 col-lg-3">
                    <a class="popover-button" data-container="body" data-toggle="popover" data-placement="left" data-content="empty">
                        <i class="icon-admin-help"></i>
                    </a>
                    <?php echo $form->labelEx($model,'name'); ?></div>
                <div class="col-md-7 col-lg-9">
                    <?php echo $form->textField($model,'name'); ?>
                    <?php echo $form->error($model,'name'); ?>
                </div>
            </div>
        </div>

    </div>


    <div class="form-title"><?php echo Yii::t('app','Text') ?></div>
    <div class="group-input">
        <div class="form-group">
            <?php echo $form->labelEx($model,'preview'); ?>
            <?php echo $form->textArea($model,'preview'); ?>
            <?php echo $form->error($model,'preview'); ?>
        </div>

        <div class="form-group">
            <?php echo $form->labelEx($model,'text'); ?>
            <?php
                $this->widget('application.widgets.ImperaviRedactorWidget',array(
                    'model'=>$model,
                    'attribute'=>'text',
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
                        'buttonSource'=> true,
                    ),
                ));
            ?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </div>

    <div class="form-title"><?php echo Yii::t('app', 'Images'); ?></div>
    <div class="group-input">
        <div class="form-group">
            <?php
            Yii::app()->getClientScript()->registerScript("remove_image"," $('body').on('click','.images-block .glyphicon-remove',function(){
                                                                            $(this).closest('.thumbnail').remove();
                                                                    });");


            $images_for_key=array(); //для проверки по ключу, наличия картинки
            $images = @unserialize($model->images);
            $image_result = $images && is_array($images);

            $image_attr_name =  $model->getFilesAttrName();;
            $form_class = get_class($model);

            if ($image_result)
            {
                $count=count($images);
                for ($i=0; $i<$count; $i++)
                {
                    $images[$i]=array(
                        'path'=>$images[$i]['path'].'small/'.$images[$i]['name'], //для отображение в теге img
                        'name'=>$images[$i]['path'].$images[$i]['name'] //сама картинка без учета размера
                    );

                    $images_for_key[$images[$i]['name']]=$images[$i];
                }
            }

            if(isset($_POST[$form_class][$image_attr_name]))
            {
                $images = $_POST[$form_class][$image_attr_name];
                $count=count($images);
                for ($i=0; $i<$count; $i++)
                {
                    $images[$i]=array(
                        'path'=>((isset($images_for_key[$images[$i]])) ? $images_for_key[$images[$i]]['path'] : $images[$i]), // проверка если нет в массиве, то это новая картинка
                        'name'=>$images[$i],
                    );
                }
                $image_result = $images && is_array($images);
            }

            echo '<div class="images-block"><ul class="row thumbnails">';

            if ($image_result)
            {
                $count=count($images);
                for ($i=0; $i<$count; $i++)
                {
                    echo '<li class="col-xs-2 thumbnail">'.$model->gridImage($images[$i]['path'],'').
                        '<input type="hidden" name="'.$form_class.'['.$image_attr_name.'][]" value="'.$images[$i]['name'].'"><i class="glyphicon glyphicon-remove"></i>
                        </li>';
                }
            }

            echo '</ul></div>';


            $this->widget('application.extensions.EFineUploader.EFineUploader',
                array(
                    'id'=>'FineUploaderLogo',
                    'config'=>array(
                        'text'=>array('uploadButton'=>Yii::t('app','Upload image')),
                        'button'=>"js:$('.download_image')[0]",
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
                                $(".images-block .thumbnails").append("<li class=\"col-xs-2 thumbnail\"><input type=\"hidden\" name=\"'.get_class($model).'['.$model->getFilesAttrName().'][]\" value=\""+response["folder"]+response["filename"]+"\"><img src=\"/"+response["folder"]+response["filename"]+"\" width=\"140\"/><i class=\"glyphicon glyphicon-remove\"></i></li>")
                            }
                        }',
                            //'onError'=>"js:function(id, name, errorReason){ }",
                        ),
                        'validation'=>array(
                            'allowedExtensions'=>array('jpg','jpeg','png'),
                            'sizeLimit'=>2 * 1024 * 1024,//maximum file size in bytes
                            //'minSizeLimit'=>2*1024*1024,// minimum file size in bytes
                        ),
                        /*'messages'=>array(
                                          'tooManyItemsError'=>'Too many items error',
                                          'typeError'=>"Файл {file} имеет неверное расширение. Разрешены файлы только с расширениями: {extensions}.",
                                          'sizeError'=>"Размер файла {file} велик, максимальный размер {sizeLimit}.",
                                          'minSizeError'=>"Размер файла {file} мал, минимальный размер {minSizeLimit}.",
                                          'emptyError'=>"{file} is empty, please select files again without it.",
                                          'onLeave'=>"The files are being uploaded, if you leave now the upload will be cancelled."
                                         ),*/
                    )
                ));


            ?>
        </div>
    </div>


    <div class="form-title"><?php echo Yii::t('app','Meta-tags'); ?></div>
    <div class="group-input">
        <div class="form-group row">
            <div class="col-md-5 col-lg-3">
                <a class="popover-button" data-container="body" data-toggle="popover" data-placement="left" data-content="">
                    <i class="icon-admin-help"></i>
                </a>
                <?php echo $form->labelEx($model,'seo_title'); ?>
            </div>
            <div class="col-md-7 col-lg-9">
                <?php echo $form->textField($model,'seo_title'); ?>
                <?php echo $form->error($model,'seo_title'); ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-5 col-lg-3">
                <a class="popover-button" data-container="body" data-toggle="popover" data-placement="left" data-content="">
                    <i class="icon-admin-help"></i>
                </a>
                <?php echo $form->labelEx($model,'seo_keywords'); ?>
            </div>
            <div class="col-md-7 col-lg-9">
                <?php echo $form->textField($model,'seo_keywords'); ?>
                <?php echo $form->error($model,'seo_keywords'); ?>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-5 col-lg-3">
                <a class="popover-button" data-container="body" data-toggle="popover" data-placement="left" data-content="">
                    <i class="icon-admin-help"></i>
                </a>
                <?php echo $form->labelEx($model,'seo_description'); ?>
            </div>
            <div class="col-md-7 col-lg-9">
                <?php echo $form->textArea($model,'seo_description'); ?>
                <?php echo $form->error($model,'seo_description'); ?>
            </div>
        </div>
    </div>

	<div class="row buttons text-center">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
	</div>

<?php
    $this->endWidget();
    $tab_1=ob_get_contents();
    ob_end_clean();

    $this->widget('bootstrap.widgets.BsNavs',array(
        'items'=>array(
            array(
                'label'=>'Наполнение',
                'content'=>$tab_1,
                'active'=>true
            ),
        )
    ));
?>

</div><!-- form -->