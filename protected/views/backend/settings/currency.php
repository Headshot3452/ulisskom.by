<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'currency-form',
            'enableAjaxValidation' => false,
            'action' => array('settings/currency'),
        )
    );
?>
    <div class="row labels">
        <div class="col-xs-2"><?php echo BsHtml::label('Название валюты (код ISO)','') ;?></div>
        <div class="col-xs-2"><?php echo BsHtml::label('Обозначение','') ;?></div>
        <div class="col-xs-3"><?php echo BsHtml::label('Курс конверсии','') ;?></div>
        <div class="col-xs-3"><?php echo BsHtml::label('Вид на сайте','') ;?></div>
    </div>

    <div id="currency_container">
<?php
    foreach ($items as $key=>$item)
    {
?>
        <div class="row one_item" id="<?php echo $item->id ;?>">
            <div class="col-xs-2 no-left">
                <div class="status <?php echo ($item->status) ? 'active' : 'not_active'; ?>">
                    <?php echo BsHtml::dropDownList('currency['.$item->id.']', 'currency', ($item->currencyName->basic) ? SettingsCurrencyList::getCurrencyBasic() : SettingsCurrencyList::getListCurrencyNotBasic(), array('empty' => '-', 'options' => array($item->currency_name => array('selected' => true)))); ?>
                </div>
            </div>
            <div class="col-xs-2">
                <div class="icon">
                    <span class="<?php echo $item->currencyName->icon; ?>"></span>
                </div>
            </div>
<?php
            if(!$item->currencyName->basic)
            {
?>
                <div class="col-xs-3">
                    <div class="cource">
                        <div class="one">1</div>
                        <?php echo BsHtml::label('=', 'one'); ?>
                        <?php echo $form->textField($model, 'course['.$item->id.']', array('class'=> 'course', 'value' => $item->course)); ?>
                    </div>
                </div>
<?php
            }
            else
            {
?>
                <div class="col-xs-3">
                    <div class="course">
                        <p>Основная валюта</p>
                    </div>
                </div>
<?php
            }
?>
            <div class="col-xs-2">
                <div class="kind">
                    <?php echo ($item->format) ? number_format(99999,2,'.', ' ') : number_format(99999,0,'.', ' '); ?>
                    <?php echo ($item->format_icon) ? '<span class="'.$item->currencyName->icon.'"></span>' : $item->currency_name; ?>
                </div>
            </div>

            <div class="col-xs-2 text-right">
                <div>
                    <span class="dropdown">
                        <a href="javascript:void(0)" data-toggle="dropdown" data-target="#" role="button" class="btn btn-small"><span class="icon-admin-catalog-menu"></span></a>
                        <ul class="dropdown-menu nav" role="menu" id="yw1">
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('/admin/settings/update_currency/').'?action=format_icon&id='.$item->id;?>"><?php echo ($item->format_icon) ? 'Отобразить цену в ISO' : 'Отобразить цену в значках' ;?></a></li>
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('/admin/settings/update_currency/').'?action=format&id='.$item->id;?>"><?php echo ($item->format) ? 'Не выводить копейки' : 'Выводить копейки' ;?></a></li>
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('/admin/settings/update_currency/').'?action=status&id='.$item->id;?>"><?php echo ($item->status) ? 'Отключить' : 'Включить' ;?></a></li>
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('/admin/settings/update_currency/').'?action=delete&id='.$item->id;?>">Удалить</a></li>
                            <li><a tabindex="-1" href="<?php echo $this->createUrl('/admin/settings/update_currency/').'?action=basic&id='.$item->id;?>">Сделать основной валютой</a></li>
                        </ul>
                    </span>
                </div>
            </div>
            <div class="col-xs-1 text-center"><img class="sort" src="/images/drag_drop.png" alt="Тяни меня" title="Тяни меня"/></div>
        </div>
<?php
    }
?>
    </div>
    <div class="form-group buttons">
        <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color'=>BsHtml::BUTTON_COLOR_PRIMARY)); ?>
        <span>Отмена</span>
    </div>

    <div class="template" style="display: none;">
        <div class="child">
<?php
            $curency = new SettingsCurrency();
            echo $curency->getFormChild('777', $form);
?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

<?php

    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile("/js/jquery.mjs.nestedSortable.js");

    $products_sortable =
                '$("div#currency_container").nestedSortable(
                {
                    items: ".one_item",
                    listType: "div",
                    tabSize : 15,
                    maxLevels: 0,

                    update:function( event, ui )
                    {
                        $.ajax(
                        {
                            type: "POST",
                            url:" '.$this->createUrl("settings/products_sort").'",
                            data:{
                                id : $(ui.item).attr("id"),
                                index : parseInt($(ui.item).index())+parseInt(1),
                            },
                            success: function(data)
                            {
                                console.log(data);
                            }
                        });
                    }
                });';

    $items =
        "function prepareAttrs(item, idNumber)
        {
            item.attr('name', item.attr('name').replace(/\[\d+\]/, '['+idNumber+']'));
            item.attr('id', item.attr('id').replace(/_\d+/, '_'+idNumber));
        }

        function initNewInputs(divs, idNumber)
        {
            divs.find('input').each(function(index)
            {
                prepareAttrs($(this), idNumber);
            })

            divs.find('select').each(function(index)
            {
                prepareAttrs($(this), idNumber);

                $(this).find('option:selected').removeAttr('selected');
            })
        }

        $('body').on('click', '.add_currency', function()
        {
            div = $('.template .child').clone();
            key = $('.row.one_item').length;
            initNewInputs(div, key);
            $('#currency_container').append(div.html());
        });

        $('body').on('click', '.del-form', function()
        {
            $(this).closest('.item').parent().remove();
        });";

        $cs->registerPackage('jquery')->registerScript('items',$items);
        $cs->registerScript("products_sortable",$products_sortable);
?>