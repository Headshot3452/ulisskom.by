<?php
foreach($this->getCategories() as $category)
{
    if ($category['id']!=$model->id)
    {
        $data[$category['id']]=str_repeat('<i class="fa fa-circle"></i>',$category['level']).' '.$category['title'];
    }
}

$str_tree='';

if(isset($data))
foreach($data as $key=>$item)
{
    $str_tree.='<li><a id="'.$key.'">'.$item.'</a></li>';
}
?>
<h2>Создание поста</h2><button id="out-preview" class="pull-right btn btn-default">Выйти из предпросмотра</button>

<div class="form row form-blog">

        <?php $form=$this->beginWidget('BsActiveForm', array(
            'id'=>'add-post',
            'enableAjaxValidation'=>false,
            'htmlOptions'=>array('class'=>'form-horizontal')
        )); ?>
        <div class="col-md-4 col-md-push-8">
            <label>Изображение поста*</label><span class="fa fa-question-circle" data-container="body"
                                               data-toggle="popover" data-placement="left"
                                               data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
                                               data-original-title="Изображение поста"></span>
            <?php
                $this->widget('ext.EFineUploader.EFineUploader', array(
                        'id'     => 'FineUploaderLogo',
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
                                        . '$(".avatar #avatar").append("<input type=\"hidden\" name=\"' . get_class($model) . '[' . $model->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\">");
                                        $(".avatar").append("<div class=\"box-photo\"><p><img class=\"close-img fa-close\" src=\"/images/icon-admin/close_photo.png\"></p></div>");
                                        $(".avatar #avatar").show();
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
                        $('.avatar #avatar').hide();
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
                    $avatar = array('img'   => $avatars[0]['path'] . $avatars[0]['name'],
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
                    $avatar_block .= $model->gridImage(substr($avatar['img'], 1), '', array('id' => 'avatar', 'width' => '70')) .
                        '<input type="hidden" name="' . get_class($model) . '[' . $model->getFilesAttrName() . '][]" value="' . $avatar['value'] . '">
                        <div class="box-photo">
                            <p>
                                <img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                            </p>
                        </div>';
                }
                else
                {
                    $avatar_block .= '<img src="" id="avatar" width="70" style="display: none;"/>';
                }

                $avatar_block .=
                    '<div class="row photo-company">
                        <div class="row">
                            <div class="film">
                                <p>Перетащите картинку сюда<br><br>или<br><br>
                                    <a href="#" id="load_from_disk" class="btn btn-primary">Загрузите</a>
                                </p>
                            </div>
                        </div>
                    </div>';

                $avatar_block .= '</div>';

                echo $avatar_block;
            ?>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-8 col-md-pull-4">

            <div class="form-group">
                <div class="col-md-12">
                    <label for="" class="required">Заголовок поста: <span class="required">*</span></label><span
                        class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right"
                        data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
                        data-original-title="Заголовок поста"></span>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textArea($model,'title', array('class'=>'form-control', 'placeholder'=>'Введите текст заголовка', 'rows'=>7)); ?>
                    <?php echo $form->error($model,'title'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="" class="required">Категория: <span class="required">*</span></label><span
                        class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right"
                        data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
                        data-original-title="Категория поста"></span>
                </div>
                <div class="col-md-12">
                    <div class="dropdown tree-blog">
                        <button type="button" class="btn btn-dropdown" data-toggle="dropdown" aria-expanded="false">
                            <?php echo (!empty($model->parent_id))?$data[$model->parent_id]:'Выберите категорию для размещения'; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <?php echo $str_tree; ?>
                        </ul>
                        <?php echo $form->hiddenField($model,'parent_id'); ?>
                        <?php echo $form->error($model,'parent_id'); ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="form-group">
                <div class="col-md-12">
                    <label for="" class="required">Содержание поста: <span class="required">*</span></label><span
                        class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right"
                        data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus."
                        data-original-title="Содержание поста"></span>
                </div>
                <div class="col-md-12">
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
                            'changeCallback'=>'js:function()
                            {
                                viewSubmitButton(this.$element[0]);
                            }',
                            'buttonSource'=> true,
                        ),
                    ));
                    ?>
                    <?php echo $form->error($model,'text'); ?>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="form-group">
                <div class="col-md-12">
                    <label for="" class="required">Метки поста: <span class="required">*</span></label><span
                        class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right"
                        data-content="Метки нужно разделять запятой. Например: путешествие, Honda, модель мотоцикла, мотоновость, фотоотчёт"
                        data-original-title="Метки поста"></span>
                </div>
                <div class="col-md-12">
                    <?php echo $form->textField($model,'tags', array('class'=>'form-control', 'placeholder'=>'Введите метки поста')); ?>
                    <?php echo $form->error($model,'tags'); ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>


        <div class="col-md-12 buttons">
            <div class="row">
                <div class="col-md-6 text-left">
                    <?php echo BsHtml::submitButton('Опубликовать', array('class'=>'btn btn-primary')); ?>
                    <a class="" href="<?php echo $this->createUrl('profileblog/index'); ?>">Отмена</a>
                </div>
                <div class="col-md-6 text-right">
                    <a class="btn btn-default" id="btn-preview">Предпросмотр</a>
                    <button type="submit" class="btn btn-default" name="draft">Сохранить в черновики</button>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
</div>

<div class="row preview-blog" id="add-post">
    <div class="col-md-12">
        <div class="border preview col-md-12 no-padding">
            <h2 class="col-md-12"></h2>
            <div class="col-md-12 breadcr">
            </div>
            <div class="col-md-12 text">
                <img src="/images/logo.png">
            </div>
            <div class="labels col-md-12">
                <span class="fa fa-tag"></span>
            </div>
        </div>
    </div>
    <div class="col-md-12 buttons">
        <div class="row">
            <div class="col-md-6 text-left">
                <button class="btn btn-primary" type="submit" name="">Опубликовать</button>
                <a class="" href="<?php echo $this->createUrl('profileblog/index'); ?>">Отмена</a>
            </div>
            <div class="col-md-6 text-right">
                <button type="submit" class="btn btn-default" name="draft">Сохранить в черновики</button>
            </div>
        </div>
    </div>
</div>

<?php

$cs = Yii::app()->getClientScript();
$header_popovers = "
            $('.fa.fa-question-circle').popover();

            $('.dropdown.tree-blog li a').on('click', function(){
            var value = $(this).attr('id');

            $('.dropdown.tree-blog button').html($(this).html()+'<span class=\"caret\"></span>');
            $('.dropdown.tree-blog button i').css('color', '#0849e1');

            if(value!='')
                $('input#Blog_parent_id').val(value);
            else
                $('input#Blog_parent_id').val('');
            });

            $('.dropdown.tree-blog li a').hover(function(){
                $(this).find('i').css('color', '#fff');
            },
            function(){
                $(this).find('i').css('color', '#0849e1');
            });

// переход в режим превью
            $('#btn-preview').on('click', function(){
                $('.form-blog').hide();
                $('.preview-blog').show();
                $('button#out-preview').show();

                $('.preview-blog h2').text($('.form-blog #Blog_title').val());

                var parent_id = $('input#Blog_parent_id').val();
                $.ajax({
                    type: 'POST',
                    data: {parent_id:parent_id},
                    success: function(data){
                        $('.preview-blog .breadcr').html('<span class=\"fa fa-folder-open\"></span> '+data);
                    }
                });

                var img = $('.form-blog img#avatar').attr('src');

                if(img != '/images/noavatar.png' && img != '')
                {
                    $('.preview-blog .text img:first').attr('src', img);
                    $('.preview-blog .text img:first').show();
                }
                else
                {
                    $('.preview-blog .text img:first').hide();
                }

                var text = $('.form-blog .redactor-editor').html();
                $('.preview-blog .text').append(text);

                var tags = $('input#Blog_tags').val();
                $('.preview-blog .labels').append(tags);
            });

            $('.preview-blog button.btn-primary').on('click', function(){
                $('.form-blog .buttons button:first').trigger('click');
            });
            $('.preview-blog button.btn-default').on('click', function(){
                $('.form-blog .buttons button:last').trigger('click');
            });

// выход из режима превью
            $('button#out-preview').on('click', function(){
                $('.form-blog').show();
                $('.preview-blog').hide();
                $('button#out-preview').hide();
            });
        ";
$cs->registerScript("header_popovers", $header_popovers);