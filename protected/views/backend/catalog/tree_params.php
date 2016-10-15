<?php
    /* @var $this CatalogParamsController */
    /* @var $model CatalogParams */
    /* @var $form BsActiveForm */
?>

<div class="form paramsform form-inline">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'catalog-params-form-form',
            'enableAjaxValidation' => false,
        )
    );
?>
    <h3><?php echo $tree_title ;?></h3>

    <div class="head_param">
        <span>Параметр</span> <span>Тип</span> <span>Значение</span>
    </div>

    <div class="clearfix"></div>

    <div class="items">
<?php
        $temp_sub = array();

        foreach ($forms as $key => $item)
        {
            if ($item->parent_id === null) //родительский элимент
            {
                if (!isset($temp_sub[$item->id]))
                {
                    $temp_sub[$item->id] = array('child' => '', 'item' => '');
                }
                $temp_sub[$item->id]['item'] = $item;
            }
            else
            {
                if (!isset($temp_sub[$item->parent_id]))
                {
                    $temp_sub[$item->parent_id] = array('child' => '','item' => '');
                }
                $temp_sub[$item->parent_id]['child'] .= $item->getSubFormChild($item->id, $form, $tree_id);
            }
        }
        foreach($temp_sub as $sub)
        {
            $item = $sub['item'];

            if(is_object($item))
            {
                echo $item->getSubForm($item->id, $form, $tree_id, $sub['child']);
            }
        }
?>
    </div>

    <a href="javascript:void(0)" class="add-sub-form">+ <?php echo Yii::t('app', 'Add group'); ?></a>

    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <?php $this->endWidget(); ?>

    <div class="template" style="display: none">
        <div class="sub-form">
            <?php echo $model->getSubForm('777', $form);?>
        </div>
        <div class="sub-form-child">
            <?php echo $model->getSubFormChild('777', $form);?>
        </div>
        <div class="sub-form-child-value">
<?php
            $empty = new CatalogParamsVal('empty');
            $empty->id = 777;
            echo $model->getValueForm($empty, $form);
?>
        </div>
    </div>
</div>

<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");

    $sub_forms = "
        function prepareAttrs(item,idNumber)
        {
            item.attr('name', item.attr('name').replace(/\[\d+\]/, '['+idNumber+']'));
            item.attr('id', item.attr('id').replace(/_\d+_/, '_'+idNumber+'_'));
        }

        function initNewInputs(divs, idNumber )
        {
             divs.find('input').each(function(index)
             {
                prepareAttrs($(this),idNumber);
             })

             divs.find('select').each(function(index)
             {
                prepareAttrs($(this),idNumber);

                $(this).find('option:selected').removeAttr('selected');
             })
        }

        $('#catalog-params-form-form .value').nestedSortable(
        {
            items: 'div',
            listType: 'div',
            update: function( event, ui )
            {
                $.ajax(
                {
                    type: 'POST',
                    url: '".$this->createUrl('params_sort_value')."',
                    data:
                    {
                        id: $(ui.item).attr('id'),
                        prev: $(ui.item).prev().attr('id'),
                        next: $(ui.item).next().attr('id'),
                        index: $(ui.item).index(),
                    },
                    success:function()
                    {
                    }
                });
            }
        });

        $('#catalog-params-form-form .child').nestedSortable(
        {
            items: 'div',
            listType: 'div',
            update: function( event, ui )
            {
                $.ajax(
                {
                    type: 'POST',
                    url: '".$this->createUrl('params_sort')."',
                    data:
                    {
                        id: $(ui.item).attr('id'),
                        prev: $(ui.item).prev().attr('id'),
                        next: $(ui.item).next().attr('id'),
                        index: $(ui.item).index(),
                    },
                    success:function()
                    {
                    }
                });
            }
        });

        $('body').on('click', '.add-sub-form', function()
        {
            div = $('.template .sub-form').clone();
            key = $('.paramsform .items .item').length;
            initNewInputs(div, 'p'+key);
            $(this).parent().find('.items').append(div.html());
        });

        $('body').on('click', '.add-sub-form-child', function()
        {
            div = $('.template .sub-form-child').clone();
            key = $('.paramsform .items .item').length;

            initNewInputs(div,'c'+key);

            parent_id = $(this).closest('.item').find('input').eq(0).attr('name').match(/\[(\d+|p\d+)\]/);
            div.find('input[id$=parent_id]').val(parent_id[1]);

            $(this).closest('.item').find('.child').append(div.html());
        });

        $('body').on('click', '.del-form', function()
        {
            viewSubmitButton(this);
            $(this).closest('.item').parent().remove();
        });

        $('body').on('change', 'select[id$=type]', function()
        {
            var value = $(this).val();
            var element = $(this).parent().find('.values');
            if (value>".CatalogParams::TYPE_YES_NO.")
            {
                element.show();
            }
            else
            {
                element.hide();
            }
        });

        $('body').on('click', '.add-value', function()
        {
            div = $('.template .sub-form-child-value').clone();
            key = 'p'+$(this).parent().find('.value > div').length;
            initNewInputs(div, key);
            parent_id = $(this).closest('.item').find('input[id$=title]').attr('name').match(/\[(\d+|c\d+)\]/);
            elem = div.find('input[id$=value]');
            elem.attr('name', elem.attr('name').replace(/\[\]/, parent_id[0]))
            $(this).closest('.values').find('.value').append(div.html());
        });

        $('body').on('click', '.del-value', function()
        {
            viewSubmitButton(this);
            $(this).parent().remove();
        });
    ";

    $cs->registerPackage('jquery')->registerScript('sub_forms', $sub_forms);
?>