<?php
    /* @var $this CatalogProductsController */
    /* @var $model CatalogProducts */
    /* @var $form BsActiveForm */

    echo $form->textField($model, 'id', array('style' => 'display: none;', 'id' => 'product_id'));
?>
    <div class="form-group col-xs-12">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('placeholder' => '')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="form-group col-xs-12">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('placeholder' => '')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="form-group col-xs-12">
        <div class="row">
            <div class="col-xs-3 price">
                <?php echo $form->labelEx($model, 'price'); ?>
                <?php echo $form->textField($model, 'price', array('placeholder' => '', 'class' => 'integer', 'data-format' => $this->currency_ico->format)); ?>
                <?php echo $form->error($model, 'price'); ?>
            </div>
            <div class="col-xs-1 mar_t price_ico">
                <label><?php echo $this->currency_ico_view ;?></label>
            </div>
            <div class="col-xs-3">
                <?php echo $form->labelEx($model, 'article'); ?>
                <?php echo $form->textField($model, 'article', array('placeholder' => '')); ?>
                <?php echo $form->error($model, 'article'); ?>
            </div>
            <div class="col-xs-3 count_cont">
                <?php echo $form->labelEx($model, 'count'); ?>
                <?php echo $form->textField($model, 'count', array('placeholder' => '', 'class' => 'integer')); ?>
                <?php echo $form->error($model, 'count'); ?>
            </div>
            <div class="col-xs-2 mar_t">
                <?php echo BsHtml::dropDownList('unit_id', $model->unit_id, CatalogParams::getUnitType()); ?>
            </div>
        </div>
    </div>

    <div class="form-group col-xs-12">
        <div class="row">
            <div class="col-xs-3 type_price" style="width: 28%;">
                <?php echo $form->labelEx($model, 'type'); ?>
                <?php echo $form->dropDownlist($model, 'type', $model->getType(), array('options' => array($model->isNewRecord ? $model->parent->type : $model->type => array('selected' => true)))); ?>
            </div>
            <div class="col-xs-4" style="width: 28%;">
                <?php echo $form->labelEx($model, 'stock'); ?>
                <?php echo BsHtml::dropDownList('stock', $stock[0], array('Есть на складе', 'Нет на складе')); ?>
            </div>
            <div class="col-xs-2" hidden>
                <?php echo BsHtml::label('Дней', 'days'); ?>
                <?php echo BsHtml::textField('days', $stock[1], array('placeholder' => '', 'class' => 'integer form-control')); ?>
            </div>
            <div class="col-xs-3 mar_t" hidden>
                <label>доставки на склад</label>
            </div>
        </div>
    </div>

    <div class="form-group col-xs-12 settings_price">
        <div class="title">Настройки цены</div>
        <div class="add_sale add" <?php if (!empty($sale[0])) echo "hidden" ;?> >
            + Настроить скидку
        </div>
        <div class="sale" <?php if (!empty($sale[0])) echo "style=display:block;" ;?> >
            <div class="row">
                <div class="col-xs-2" style="width: 21%;">
                    <?php echo BsHtml::label('Скидка', 'sale_value'); ?>
                    <?php echo BsHtml::textField('sale_value', $sale[0], array('placeholder' => '', 'class' => 'integer')); ?>
                </div>
                <div class="col-xs-2 mar_t">
                    <?php echo BsHtml::dropDownList('sale_type', $sale[1], array('%', $this->currency_ico["currency_name"])); ?>
                </div>
                <div class="col-xs-5 period">
<?php
                    echo BsHtml::label('Период действия скидки', 'date_from');

                    $this->widget('zii.widgets.jui.CJuiDatePicker',
                        array(
                            'language'    => 'ru',
                            'options'     => array(
                                'showAnim'   => 'fold',
                                'dateFormat' => 'dd.mm.yy',
                            ),
                            'value'       => $sale[2],
                            'htmlOptions' => array(
                                'class' => 'from form-control',
                                'name'  => 'date_from'
                            ),
                        )
                    );
?>
                    &nbsp;-&nbsp;
<?php
                    $this->widget('zii.widgets.jui.CJuiDatePicker',
                        array(
                            'language'    => 'ru',
                            'options'     => array(
                                'showAnim'   => 'fold',
                                'dateFormat' => 'dd.mm.yy',
                            ),
                            'value'       => $sale[3],
                            'htmlOptions' => array(
                                'class' => 'to form-control',
                                'name'  => 'date_to'
                            ),
                        )
                    );
?>
                </div>
                <div class="col-xs-3">
                    <label>Цена со скидкой</label>
                    <div class="sale_price">
                        <?php echo CatalogProducts::getSalePrice($model->price, $model->sale_info, $this->currency_ico->format); ?>
                        <span>
                            <?php echo $this->currency_ico_view; ?>
                        </span>
                    </div>
                    <a id="del_sale_form" href="javascript:void(0)" class="del-form"><span class="icon-admin-delete"></span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-xs-12 settings_price_opt">
        <div class="title">Настройки оптовой цены</div>
        <div class="add_sale add_sale_opt kind">+ Добавить вариант цены</div>
        <div class="sale sale_opt" style=display:block;">
            <div class="row">
                <div class="col-xs-3 opt_price_cont">
                    <?php echo BsHtml::label('Оптовая цена', ''); ?>
                </div>
                <div class="col-xs-2 count_container">
                    <?php echo BsHtml::label('Количество', ''); ?>
                </div>
                <div class="col-xs-2 count_container">
                    <?php echo BsHtml::label('Заказ от', ''); ?>
                </div>
                <div class="col-xs-4 text_cont">
                    <?php echo BsHtml::label('Описание', ''); ?>
                </div>
            </div>
<?php
           foreach($model->opt_price as $key => $value)
           {
               echo $value->getValueForm($value->id, $form, $this->currency_ico_view);
           }
?>
        </div>
    </div>

    <div class="form-group col-xs-12">
        <div class="title">Размещение в группе товаров</div>
        <div class="row">
            <div class="col-xs-4 marker <?php if ($model->new == 1) echo 'active'; ?>" >
                <i class="fa <?php echo ($model->new == 1) ? 'fa-bookmark' : 'fa-bookmark-o'; ?>  fa-rotate-270 new "></i>
                <span>Новинки</span>
                <?php echo $form->checkBox($model, 'new'); ?>
            </div>
            <div class="col-xs-4 marker <?php if ($model->popular == 1) echo 'active'; ?>">
                <i class="fa <?php echo ($model->popular == 1) ? 'fa-bookmark' : 'fa-bookmark-o'; ?>  fa-rotate-270 popular"></i>
                <span>Спецпредложение</span>
                <?php echo $form->checkBox($model, 'popular'); ?>
            </div>
            <div class="col-xs-4 marker <?php if ($model->sale == 1) echo 'active'; ?>">
                <i class="fa <?php echo ($model->sale == 1) ? 'fa-bookmark' : 'fa-bookmark-o'; ?>  fa-rotate-270 sale_product"></i>
                <span>Скидка</span>
                <?php echo $form->checkBox($model, 'sale'); ?>
            </div>
        </div>
    </div>

    <div class="form-group col-xs-12">
        <div class="title">Описательная информация</div>
<?php
        echo
        $form->labelEx($model, 'preview', array('placeholder' => '')).
        $form->TextArea($model, 'preview').
        $form->error($model, 'preview').
    '</div>

    <div class="form-group col-xs-12">';

        echo $form->labelEx($model, 'text', array('placeholder' => ''));

        $this->widget('application.widgets.ImperaviRedactorWidget',
            array(
                'model'     => $model,
                'attribute' => 'text',
                'plugins'   => array(
                    'imagemanager' => array(
                        'js' => array('imagemanager.js',),
                    ),
                    'filemanager'  => array(
                        'js' => array('filemanager.js',),
                    ),
                    'fullscreen'   => array(
                        'js' => array('fullscreen.js'),
                    ),
                    'table'        => array(
                        'js' => array('table.js'),
                    ),
                ),
                'options'   => array(
                    'lang'             => Yii::app()->language,
                    'imageUpload'      => $this->createUrl('admin/imageImperaviUpload'),
                    'imageManagerJson' => $this->createUrl('admin/imageImperaviJson'),
                    'fileUpload'       => $this->createUrl('admin/fileImperaviUpload'),
                    'fileManagerJson'  => $this->createUrl('admin/fileImperaviJson'),
                    'uploadFileFields' => array(
                        'name' => '#redactor-filename'
                    ),
                    'changeCallback'   => 'js:function()
                    {
                        viewSubmitButton(this.$element[0]);
                    }',
                    'buttonSource'     => true,
                ),
            )
        );

        echo $form->error($model, 'text');
?>
    </div>

    <div class="form-group col-xs-12">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="form-group col-xs-12">
        <div class="title"><?php echo Yii::t('app', 'Download product image'); ?></div>
<?php
        $this->widget('application.extensions.EFineUploader.EFineUploader',
            array(
                'id'     => 'FineUploaderLogo',
                'config' => array(
                    'button'     => "js:$('.download_image')[0]",
                    'autoUpload' => true,
                    'request'    => array(
                        'endpoint' => $this->createUrl($this->id . '/upload'),
                        'params'   => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
                    ),
                    'retry'      => array('enableAuto' => true, 'preventRetryResponseProperty' => true),
                    'chunking'   => array('enable' => true, 'partSize' => 100),
                    'callbacks'  => array(
                        'onComplete' => 'js:function(id, name, response)
                                        {
                                            if (response["success"])
                                            {
                                                $(".images .thumbnails").append("<li class=\"image\" style=\"float: left;\"><input type=\"hidden\" name=\"' . get_class($model) . '[' . $model->getFilesAttrName() . '][]\" value=\""+response["folder"]+response["filename"]+"\"><img src=\"/"+response["folder"]+response["filename"]+"\" width=\"130\" height=\"130\" /><img class=\"close-img fa-close\" src=\"/images/icon-admin/close_photo.png\"></li>")
                                            }
                                        }',
                    ),
                    'validation' => array(
                        'allowedExtensions' => array('jpg', 'jpeg', 'png'),
                        'sizeLimit'         => 3 * 1024 * 1024,
                    ),
                    'text'       => array(
                        'uploadButton' => Yii::t('app', 'Upload a file'),
                        'dragZone'     => Yii::t('app', 'Drop files here to upload') . '<br/><br/> или',
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
        $image_attr_name = $model->getFilesAttrName();;
        $form_class = get_class($model);

        if ($image_result)
        {
            $count = count($images);
            for ($i = 0; $i < $count; $i++)
            {
                $images[$i] = array(
                    'path' => $images[$i]['path'] . 'small/' . $images[$i]['name'], //для отображение в теге img
                    'name' => $images[$i]['path'] . $images[$i]['name'] //сама картинка без учета размера
                );

                $images_for_key[$images[$i]['name']] = $images[$i];
            }
        }

        if (isset($_POST[$form_class][$image_attr_name]))
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
                if (isset($images[$i]['path']) && is_file($images[$i]['path']))
                {
                    echo
                        '<li class="image" style="float: left;">' . $model->gridImage($images[$i]['path'], '', array('width' => '130', 'height' => '130')) .
                            '<input type="hidden" name="' . $form_class . '[' . $image_attr_name . '][]" value="' . $images[$i]['name'] . '"><img class="close-img fa-close" src="/images/icon-admin/close_photo.png">
                        </li>';
                }
                else
                {
                    echo '<img style="position: absolute;" src="/' . Yii::app()->params['no-image'] . '" id="avatar" width="130" />';
                }
            }
        }
        else
        {
            echo '<img style="position: absolute;" src="/' . Yii::app()->params['no-image'] . '" id="avatar" width="130" />';
        }
        echo
                '</ul>
            </div>
        </div>';
?>
    </div>

    <div class="form-group col-xs-12">
        <div class="seo-title"><?php echo Yii::t('app', 'Seo tags'); ?></div>
    </div>

    <div class="form-group seo-text col-xs-12">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_title'); ?>:
            <div>Осталось символов: <span><?php echo 255 - strlen($model->seo_title); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_title'); ?>
        <?php echo $form->error($model, 'seo_title'); ?>
    </div>

    <div class="form-group seo-text col-xs-12">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_keywords'); ?>:
            <div>Осталось символов: <span><?php echo 255 - strlen($model->seo_keywords); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_keywords'); ?>
        <?php echo $form->error($model, 'seo_keywords'); ?>
    </div>

    <div class="form-group seo-text col-xs-12">
        <div class="label-block">
            <?php echo $form->labelEx($model, 'seo_description'); ?>:
            <div>Осталось символов: <span><?php echo 255 - strlen($model->seo_description); ?></span></div>
        </div>
        <?php echo $form->textArea($model, 'seo_description'); ?>
        <?php echo $form->error($model, 'seo_description'); ?>
    </div>

    <div class="template" style="display: none">
<?php
        $empty = new OptPrice();
        echo $empty->getValueForm('777', $form, $this->currency_ico_view);
?>
    </div>

<?php
    $cs = Yii::app()->getClientScript();

    $product_price = '

        function prepareAttrs(item, idNumber)
        {
            item.attr("name", item.attr("name").replace(/\[\d+\]/, "["+idNumber+"]"));
            item.attr("id", item.attr("id").replace(/\d+/, idNumber));
        }

        function initNewInputs(divs, idNumber )
        {
            divs.find("input").each(function(index)
            {
                prepareAttrs($(this),idNumber);
            })
        }

        $("body").on("click", ".add_sale_opt", function()
        {
            div = $(".template").clone();
            key = $(".sale_opt .item").length;
            initNewInputs(div, "p"+key);
            $(this).parent().find(".sale_opt").append(div.html());
        });

        $(function()
        {
            var format = $("#CatalogProducts_price").data("format");

            if(format == 0)
            {
                $format_price = number_format($("#CatalogProducts_price").val(), 0, ".", " ");
                $format_sale = number_format($("#sale_value").val(), 0, ".", " ");
            }
            else
            {
                $format_price = number_format($("#CatalogProducts_price").val(), 2, ".", " ");
                $format_sale = number_format($("#sale_value").val(), 2, ".", " ");
            }

            $("#CatalogProducts_price").val($format_price);
            $("#sale_value").val($format_sale);

            if($(".sale_opt .item").length == 0)
            {
                $(".add_sale_opt").click();
            }

            $("#CatalogProducts_count").val( number_format_on_input ( $("#CatalogProducts_count").val() ) );

            $("body").on("keyup", ".integer", function(event)
            {
                proverka(this);
                $(this).val( number_format_on_input ( $(this).val() ) );
            });

            var sel = $(".type_price option:selected").val();

            if(sel == "1" || sel == "4")
            {
                $("#CatalogProducts_price").prop("disabled", false);
                $(".count_cont, #unit_id, .settings_price").show();
                $(".settings_price_opt").hide();
            }

            if(sel == "2")
            {
                $("#CatalogProducts_price").prop("disabled", "true");
                $(".count_cont, #unit_id, .settings_price").hide();
                $(".settings_price_opt").show();
            }

            if(sel == "3")
            {
                $("#CatalogProducts_price").prop("disabled", false);
                $(".count_cont, #unit_id, .settings_price").show();
                $(".settings_price_opt").show();
            }

            $(".type_price select").on("change", function()
            {
                var sel = $(".type_price option:selected").val();

                if(sel == "1" || sel == "4")
                {
                    $("#CatalogProducts_price").prop("disabled", false);
                    $(".count_cont, #unit_id, .settings_price").show();
                    $(".settings_price_opt").hide();
                }

                if(sel == "2")
                {
                    $("#CatalogProducts_price").prop("disabled", "true");
                    $(".count_cont, #unit_id, .settings_price").hide();
                    $(".settings_price_opt").show();
                }

                if(sel == "3")
                {
                    $("#CatalogProducts_price").prop("disabled", false);
                    $(".count_cont, #unit_id, .settings_price").show();
                    $(".settings_price_opt").show();
                }
            });

            $("#del_sale_form").on("click", function()
            {
                $(".settings_price .sale").hide();
                $(".settings_price #sale_value").val("");
                $(".add_sale.add").show();
                viewSubmitButton(this);
            });

            $(".sale_opt .item .icon-admin-delete").on("click", function()
            {
                $(this).closest(".item").remove();
                $("#catalog-products-product-form").find(".form-group.buttons").show(500);
            })
        });
    ';

    $cs->registerScript("product_price", $product_price);