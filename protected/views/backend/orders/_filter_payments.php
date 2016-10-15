<div class="form top-filter">

<?php
    $form = $this->beginWidget('BsActiveForm',
        array(
            'id' => 'orders-filter-payments',
            'method' => 'get',
            'enableAjaxValidation' => false,
            'action' => array('orders/payments'),
        )
    );
?>
    <div class="row">
        <div class="col-xs-2 o-status">
            <div class="filter-title">
                Статус заказов:
            </div>
            <?php echo BsHtml::dropDownList('status', Yii::app()->request->getParam('status'), OrderPayments::getStatus(), array('empty' => '-', 'class' => 'selectpicker', 'id' => 'status-filter')) ;?>
        </div>

        <div class="col-xs-3">
            <div class="filter-title">
                Период:
            </div>
            <div class="period">
<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'language' => 'ru',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'dd.mm.yy',
                        ),
                        'value' => Yii::app()->request->getParam('date_from'),
                        'htmlOptions' => array(
                            'class'=>'date_from form-control',
                            'name'=>'date_from'
                        ),
                    )
                );
?>
                &nbsp;-&nbsp;
<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'language' => 'ru',
                        'options' => array(
                            'showAnim' => 'fold',
                            'dateFormat' => 'dd.mm.yy',
                        ),
                        'value' => Yii::app()->request->getParam('date_to'),
                        'htmlOptions' => array(
                            'class' => 'date_to form-control',
                            'name' => 'date_to'
                        ),
                    )
                );
?>
            </div>
        </div>

        <div class="col-xs-4">
            <div class="filter-title">
                Сортировать по:
            </div>
            <?php echo BsHtml::dropDownList('sort',Yii::app()->request->getParam('sort'), $sort_list, array('empty' => '-', 'class' => 'selectpicker')) ;?>
        </div>

        <div class="col-xs-2 buttons-block">
            <?php
                $hidden = (isset($_GET) && !empty($_GET)) ? '' : 'hidden';
                echo BsHtml::submitButton('', array('icon' => BsHtml::GLYPHICON_SEARCH, 'title' => 'Фильтр', 'data-toggle' => 'tooltip', 'class' => 'hint--bottom hint--rounded',  'data-hint' => "Фильтр"));
                echo BsHtml::submitButton('<span class="fa fa-level-up fa-rotate-270"></span>', array('class' => 'reset pull-right '.$hidden.' hint--bottom hint--rounded', 'title' => 'Сбросить фильтр', 'data-hint' => "Сбросить фильтр"));
            ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div>
<?php
    $cs = Yii::app()->getClientScript();

    $filter_payments = '
        $(document).ready(function()
        {
            $(".buttons-block .reset").click(function()
            {
                $("#orders-filter-payments input, #orders-filter-payments select").val(null);
            });

            $("#orders-filter-payments input, #orders-filter-payments select").change(function()
            {
                $(".buttons-block .reset").removeClass("hidden");
            });
        })
    ';

    $cs->registerPackage('hint')->registerScript("filter_payments", $filter_payments);