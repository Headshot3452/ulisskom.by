<div class="form form-structure">
<?php
    $form = $this->beginWidget('bootstrap.widgets.BsActiveForm',
        array(
            'enableAjaxValidation' => false,
            'id' => 'structure-_form-form'
        )
    );

    ob_start();
?>
    <div class="form-group">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'title'); ?>:
        </div>
        <?php echo $form->textField($model, 'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>
<?php
    $data = array();

    foreach($this->getCategories() as $category)
    {
        if ($category['id'] != $model->id)
        {
            $data[$category['id']] = str_repeat('*',$category['level']-1).' '.$category['title'];
        }
    }

    if (!$model->isNewRecord && !$model->isRoot() && $model->system != $model::SYSTEM_PRIVATE)
    {
?>
        <div class="form-group">
            <div class="label-block"><?php echo Yii::t('app','Parent folder'); ?>:</div>
            <?php echo CHtml::dropDownList('parent_id', $model->parent()->find()->id, $data, array('class' => 'form-control')) ?>
        </div>

        <div class="form-group">
            <div class="label-block"><?php echo Yii::t('app','Module'); ?>:</div>
            <?php echo $form->dropDownList($model, 'module[module_id]', CHtml::listData(Modules::model()->public()->active()->findAll(),'id','title'),array('prompt'=>Yii::t('app','Select the link module'))); ?>
            <?php echo $form->error($model, 'module'); ?>
        </div>
<?php
        if(!empty($model->module->module_id))
        {
            $model_module = Modules::model()->public()->active()->findByPk($model->module->module_id);
            $name_model = $model_module->model;
            $new_model = new $name_model();

            if($model_module->name == 'catalog')
            {
                $data_tree = $new_model->active()->language($this->getCurrentLanguage()->id)->findAll();
            }
            else
            if($new_model->hasAttribute('level'))
            {
                $data_tree = $new_model->active()->language($this->getCurrentLanguage()->id)->findAll('level = :level', array('level' => 1));
            }
        }

        if(!empty($data_tree))
        {
            $data = array();
            foreach($data_tree as $category)
            {
                if ($category['id'] != $model->id)
                {
                    $data[$category['id']] = str_repeat('*',$category['level'] - 1).' '.$category['title'];
                }
            }
?>
            <div class="form-group">
                <div class="label-block"><?php echo Yii::t('app','Module Tree'); ?>:</div>
                    <?php echo $form->dropDownList($model, 'module[tree_id]', $data,array('prompt'=>Yii::t('app','Select the link module level'))); ?>
                    <?php echo $form->error($model, 'tree_id'); ?>
            </div>
<?php
        }
?>
        <div class="form-group">
            <div class="label-block"><?php echo $form->labelEx($model,'name'); ?>:</div>
                <?php echo $form->textField($model, 'name'); ?>
                <?php echo $form->error($model, 'name'); ?>
        </div>

        <div class="form-group url-page">
            <div class="col-xs-3 label-block"><?php echo Yii::t('app','Full url of the page'); ?>:</div>
            <div class="col-xs-9 value-block">
                <?php echo Yii::app()->request->getHostInfo(); ?>/<?php echo $model->findUrlForItem('name',false,Structure::findRootForLanguage($this->getCurrentLanguage()->id)->id); ?><?php echo $model->name; ?>
            </div>
        </div>
<?php
    }
    else if($model->isNewRecord && !$model->isRoot() && $model->system!=$model::SYSTEM_PRIVATE)
    {
?>
        <div class="form-group">
            <div class="label-block"><?php echo Yii::t('app','Parent folder'); ?>:</div>
            <?php echo CHtml::dropDownList('parent_id',$model,$data,array('class'=>'form-control')) ?>
        </div>

        <div class="form-group module">
            <div class="label-block"><?php echo Yii::t('app','Module'); ?>:</div>
            <?php echo $form->dropDownList($model,'module[module_id]',CHtml::listData(Modules::model()->public()->active()->findAll(),'id','title'),array('prompt'=>Yii::t('app','Select the link module'))); ?>
            <?php echo $form->error($model,'module'); ?>
        </div>
<?php
    }
?>
    <div class="form-group">
        <div class="title all-desc"><?php echo $form->labelEx($model,'text'); ?></div>
        <div>
<?php
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
?>
            <?php echo $form->error($model,'text'); ?>
        </div>
    </div>

<div class="form-group">
    <div class="title all-desc"><?php echo $form->labelEx($model,'text_more'); ?></div>
    <div>
        <?php
        $this->widget('application.widgets.ImperaviRedactorWidget',
            array(
                'model' => $model,
                'attribute' => 'text_more',
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
        ?>
        <?php echo $form->error($model,'text_more'); ?>
    </div>
</div>
        
    <div class="title">Загрузка изображения</div>
    <div class="form-group col-xs-12 image-file no-right no-left">
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
                            'sizeLimit'=>3 * 1024 * 1024,
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

    <div class="form-group"><div class="seo-title"><?php echo Yii::t('app','Seo tags'); ?></div></div>

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
<?php
    $page = ob_get_contents();
    ob_end_clean();

    ob_start();
?>
    <div class="form-group">
        <div class="title">
            <?php echo Yii::t('app','Widgets'); ?>
        </div>
    </div>

    <div class="widgets">
<?php
        if ($model->isNewRecord)
        {
            echo '<div class="form-group">';
                echo CHtml::checkBox('parent_layout', true);
                echo CHtml::label(Yii::t('app','Apply Parental'), 'parent_layout');
            echo '</div>';
        }
?>
        <div class="form-group">
            <div class="label-block"><?php echo Yii::t('app','Select Layout'); ?></div>
<?php
            echo $form->dropDownList($model, 'layout', Structure::getLayouts(), array('prompt'=>Yii::t('app', 'Choose a template')));
?>
            <?php echo $form->error($model, 'layout'); ?>
        </div>
<?php
        if ($model->isNewRecord)
        {
?>
            <div class="form-group">
<?php
                echo CHtml::checkBox('parent_widgets',true);
                echo CHtml::label(Yii::t('app','Apply parent widgets'),'parent_widgets');
?>
            </div>
<?php
        }
?>
        <div class="form-group form-group-widget">
            <a href="javascript:void(0)" class="add_widget btn btn-primary">
                <i class="fa fa-plus" aria-hidden="true"></i> <?php echo Yii::t('app','Add a widget');?>
            </a>
        </div>

        <div class="items">
<?php
            $all_widgets=CHtml::listData(Widgets::model()->public()->active()->findAll(),'id','title');
            $blocks_layout=$model->getBlocksInLayout();
            foreach($model->widgets as $widget)
            {
                $widget_id = Widgets::model()->findByPk($widget->widget_id);
                $model = $widget_id->module->model;

                $data_view = Yii::app()->getWidgetFactory()->createWidget($this, "application.widgets.module_widgets.".$widget_id->name);

                $data_model=StructureWidgets::getCategoryData($data_view, $model, $this->getCurrentLanguage()->id);
                $data_view = $data_view::getView();

                $widget->getForm($widget->id,$form,$all_widgets,$blocks_layout, $data_model, $data_view);
            }
?>
        </div>
    </div>
<?php
    $widget = ob_get_contents();
    ob_end_clean();

    $this->widget('bootstrap.widgets.BsNavs',
        array(
            'items' => array(
                 array('label' => Yii::t('app','Настройки страницы'), 'content' => $page, 'active' => true),
                 array('label' => Yii::t('app','Widgets'),'content' => $widget)
            )
        )
    );
?>
    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

    <div class="template" style="display: none;">
        <div class="widget">
<?php
            $empty = new StructureWidgets('empty');
            $empty->getForm(777,$form,$all_widgets,$blocks_layout);
?>
        </div>
    </div>
</div>

<?php
    $cs = Yii::app()->getClientScript();

    $sub_forms = "
        function prepareAttrs(item,idNumber)
        {
            item.attr('name', item.attr('name').replace(/\[\d+\]/, '['+idNumber+']'));
            item.attr('id', item.attr('id').replace(/_\d+_/, '_'+idNumber+'_'));
        }

        function initNewInputs(divs, idNumber )
        {
             divs.find('input').each(function(index){
                prepareAttrs($(this),idNumber);
             })

             divs.find('select').each(function(index){
                prepareAttrs($(this),idNumber);
             })

             divs.find('label').each(function(index){
                $(this).attr('for', $(this).prev().attr('id'));
             })
        }

        $('body').on('click','.add_widget',function()
        {
            div=$('.template .widget').clone();
            key=$('.widgets .items .item').length;
            initNewInputs(div,'p'+key);
            $('.widgets .items').append(div.html());

            loadCategory($('.widgets .items .item:last select.form-control.widget_id'));
            $('.widgets .items .item select.form-control.widget_id').on('change', function(){
                loadCategory($(this));
            });
        });

        $('body').on('click','.del-widget',function(){
            $(this).closest('.item').remove();
        });

//        Загрузка категорий для интеграции на страницу
        $('.widgets .items .item select.form-control.widget_id').on('change', function(){
            loadCategory($(this));
        });

        function loadCategory(obj)
        {
            var widget_id = obj.val();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '".$this->createUrl('structure/ajax')."',
                data: {widget_id:widget_id},
                success: function(data){
                    obj.parents('.item:first').find('#tree_id').html(data.tree);
                    obj.parents('.item:first').find('#view_id').html(data.view);
                }
            });
        }
    ";

    $cs->registerPackage('jquery')->registerScript('sub_forms', $sub_forms);
?>
