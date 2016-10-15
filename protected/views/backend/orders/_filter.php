<div class="form top-filter">

    <?php $form=$this->beginWidget('BsActiveForm', array(
        'id'=>'orders-filter',
        'method' => 'get',
        'enableAjaxValidation'=>false,
        'action' => array('orders/index'),
    )); ?>

    <div class="row">
    <div class="col-xs-2 o-status">
        <div class="filter-title">
            Статус заказов:
        </div>
        <?php
           echo BsHtml::dropDownList('status',Yii::app()->request->getParam('status'),Orders::getStatusForFilter(),array('encode'=>false,'empty'=>'-','class'=>'selectpicker'));
        ?>
    </div>

    <div class="col-xs-3">
        <div class="filter-title">
            Период:
        </div>
        <div class="period">
            <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                    // additional javascript options for the date picker plugin
                    'options'=>array(
                        'showAnim'=>'fold',
                        'dateFormat'=>'dd.mm.yy',
                    ),
                    'value'=>Yii::app()->request->getParam('date_from'),
                    'htmlOptions'=>array(
                        'class'=>'date_from form-control',
                        'name'=>'date_from'
                    ),
                ));
            ?>
            &nbsp;-&nbsp;
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                // additional javascript options for the date picker plugin
                'options'=>array(
                    'showAnim'=>'fold',
                    'dateFormat'=>'dd.mm.yy',
                ),
                'value'=>Yii::app()->request->getParam('date_to'),
                'htmlOptions'=>array(
                    'class'=>'date_to form-control',
                    'name'=>'date_to'
                ),
            ));
            ?>
        </div>
    </div>

    <div class="col-xs-2">
        <div class="filter-title">
            Сотрудники:
        </div>
        <?php
            echo BsHtml::dropDownList('worker',Yii::app()->request->getParam('worker'),$workers,array('empty'=>'-'));
        ?>
    </div>

    <div class="col-xs-1 labels">
        <div class="filter-title">
            Ярлыки:
        </div>
        <?php
        echo BsHtml::dropDownList('label',1,array('primary'=>'primary','orange'=>'orange','red'=>'red','green'=>'green'),array('encode'=>false,'empty'=>'-','class'=>'selectpicker'));
        ?>
    </div>

    <div class="col-xs-2">
        <div class="filter-title">
            Сортировать по:
        </div>
        <?php
            echo BsHtml::dropDownList('sort',Yii::app()->request->getParam('sort'),$sort_list,array('empty'=>'-'));
        ?>
    </div>

    <div class="col-xs-2 buttons-block">
        <?php
            echo BsHtml::submitButton('',array('icon'=>BsHtml::GLYPHICON_SEARCH, 'title'=>'Фильтр', 'class' => 'pull-right hint--bottom hint--rounded', 'data-hint' => "Фильтр"));
            echo BsHtml::submitButton('<span class="fa fa-level-up fa-rotate-270"></span>',array('class'=>'reset pull-right hidden','title'=>'Сбросить фильтр'));
        ?>
    </div>
    </div>

    <?php $this->endWidget(); ?>

</div>

<script type="text/javascript" src="/js/jqueryui/datepicker-ru.js"></script>

<?php
    $src = '
        var getUrlParameter = function getUrlParameter(sParam)
        {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split("&"),
            sParameterName,
            i;

            for (i = 0; i < sURLVariables.length; i++)
            {
                sParameterName = sURLVariables[i].split("=");

                if (sParameterName[0] === sParam)
                {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };

        $( document ).ready(function()
        {
            $(\'[data-toggle="tooltip"]\').tooltip();

            $("#orders-filter .o-status button ").find("[class*=order-status]").remove();
            $("#orders-filter .o-status button ").find(".filter-option").removeClass("pull-left");
            $("#orders-filter .o-status button ").prepend( "<span class=\'order-status"+(getUrlParameter("status"))+"\'></span>" );

            $("#orders-filter .labels button ").find(".fa").remove();
            $("#orders-filter .labels button ").prepend( "<span class=\'fa fa-lg fa-star color-"+getUrlParameter("label")+"\'></span>" );

            $("#orders-filter .o-status li .text").each(function()
            {
                $( this ).prepend( "<div class=\'order-status"+($(this).parent().parent().attr("data-original-index")-4)+"\'></div>" );
            });

            $("#orders-filter .labels li .text").each(function()
            {
                $( this ).prepend( "<span class=\'fa fa-lg fa-star color-"+$(this).text()+"\'></span>" );
            });

            $("#orders-filter .labels li a").click(function()
            {
                $("#orders-filter .labels button ").find(".fa").remove();
                $("#orders-filter .labels button ").prepend( "<span class=\'fa fa-lg fa-star color-"+$(this).text()+"\'></span>" );
            });

            $("#orders-filter .o-status li a").click(function()
            {
                $("#orders-filter .o-status button ").find("[class*=order-status]").remove();
                $("#orders-filter .o-status button ").find(".filter-option").removeClass("pull-left");
                $("#orders-filter .o-status button ").prepend( "<span class=\'order-status"+($(this).parent().attr("data-original-index")-4)+"\'></span>" );
            });
        });

        $(".selectpicker").selectpicker();

        $(".buttons-block .reset").click(function()
        {
            $("#orders-filter input, #orders-filter select").val(null);
        });

        $("#orders-filter input, #orders-filter select").change(function()
        {
            $(".buttons-block .reset").removeClass("hidden");
        });

        $.datepicker.setDefaults($.extend($.datepicker.regional["ru"])
        );

        $("date_from, #date_to").datepicker({dateFormat: "dd.mm.yy", showOtherMonths: true});';

        $cs = Yii::app()->getClientScript();
        $cs->registerScript("datepicker", $src);
?>