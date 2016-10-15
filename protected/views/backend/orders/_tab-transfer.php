<?php
/* @var $order Orders */
?>
    <div class="row transfer-info">
<!--        если заказ был перенесен-->
        <div class="col-md-12 old-date">
            <div class="form-group row">
                <div class="col-md-3 text-right color-gray">
                    <span>Старая дата заказа:</span>
                </div>
                <div class="col-md-3 color-gray">
                    <span>12.12.2016, 14:00-16:00</span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 text-right color-gray">
                    <span>Текущая дата заказа:</span>
                </div>
                <div class="col-md-3">
                    <span>12.12.2016, 14:00-16:00</span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="block-title">Выберите новую дату для переноса заказа:</div>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="date" class="col-md-3 control-label text-right">Дата заказа:</label>

                    <div class="col-md-3">
                        <?php
                        $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array(
                                'options' => array(
                                    'showAnim' => 'fold',
                                    'dateFormat' => 'dd.mm.yy',
                                ),
                                'value' => Yii::app()->request->getParam('date_from'),
                                'htmlOptions' => array(
                                    'class' => 'from form-control',
                                    'name' => 'date',
                                    'value' => '12.12.2016',
                                ),
                            )
                        );
                        ?>
                        <span class="fa fa-calendar"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="time1" class="col-md-3 control-label text-right">Время доставки:</label>

                    <div class="col-md-3">
                        <select class="form-control" id="time1">
                            <option>14:00-16:00</option>
                            <option>14:00-16:00</option>
                            <option>14:00-16:00</option>
                        </select>
                    </div>
                </div>
                <div class="form-group buttons">
                    <?php echo BsHtml::Button(Yii::t('app', 'Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'data-toggle' => 'modal', 'data-target' => '#modal_transfer')); ?>
                    <span>Отмена</span>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/js/jqueryui/datepicker-ru.js"></script>
    <script>

        $(function () {

            $.datepicker.setDefaults(
                $.extend($.datepicker.regional["ru"])
            );
            $('#date').datepicker({
                dateFormat: "dd.mm.yy",
                showOtherMonths: true
            });
        });

    </script>
<?php

$this->widget('ext.bootstrap.widgets.BsModal',
    array(
        'id' => 'modal_transfer',
        'htmlOptions' => array(
            'class' => 'modal'
        ),
        'header' => "Перенос заказа",
        'content' => "<span class='fa fa-exclamation-triangle color-yellow'></span>  Вы действительно хотите перенести заказ?",
        'footer' => '<button type="button" data-status="' . CatalogProducts::STATUS_DELETED . '" class="btn btn-danger" data-dismiss="modal">Отмена</button>
                <a class="color-gray underline" href="#">Перенести</a>',
    )
);
