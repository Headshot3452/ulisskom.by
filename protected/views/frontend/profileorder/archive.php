<?php
$cs = Yii::app()->getClientScript();
$header_popovers = '
    $(".status span").tooltip();
    ';
$cs->registerScript("header_popovers", $header_popovers);
?>
<div class="row title-orders">
    <div class="col-md-4"><h2>Архив заказов</h2></div>
    <div class="col-md-4 all-orders text-right">Всего товаров: <span>12</span></div>
    <div class="col-md-4 all-sum text-right">Общая сумма: <span class="sum"><b>12 123 123</b></span> <span
            class="currency text-uppercase">BYR</span></div>
</div>
<div class="clearfix"></div>
<div class="row filter-orders">
    <div class="col-md-4">
        <select>
            <option>Все</option>
            <option>Неделя</option>
            <option>Месяц</option>
        </select>
    </div>
    <div class="col-md-8 text-right">
        <label>Период</label>

        <div class="calendar">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'name' => 'time',
                    'options' => array(
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Выберите дату',
                        'class' => 'form-control',
                    ),
                )
            );
            ?>
            <span class="fa fa-calendar"></span>
        </div>
        —
        <div class="calendar">
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker',
                array(
                    'name' => 'time1',
                    'options' => array(
                        'showAnim' => 'fold',
                    ),
                    'htmlOptions' => array(
                        'placeholder' => 'Выберите дату',
                        'class' => 'form-control',
                    ),
                )
            );
            ?>
            <span class="fa fa-calendar"></span>
        </div>
        <button class="btn btn-default search"><span class="fa fa-search"></span></button>
        <button class="btn btn-default" id="reset-date" disabled><span class="fa fa-level-up fa-rotate-270 fa-lg"></span></button>
    </div>
</div>
<div class="clearfix"></div>

<div class="row profileorders">

    <div class="col-md-12 orders">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#Заказа</th>
                <th>Кол-во</th>
                <th>Сумма</th>
                <th>Дата доставки</th>
                <th>Статус</th>
            </tr>
            </thead>
            <tbody>
            <tr class="one-order" onclick="location.href='/profileorder/order'">
                <td>
                    123
                </td>
                <td>
                    2
                </td>
                <td class="all-sum">
                    <span class="sum"><b>12 123 123</b></span> <span
                        class="currency text-uppercase">BYR</span>
                </td>
                <td>
                    <b>12.12.1212</b><br>
                    14:00 - 16:00
                </td>
                <td class="status">
                    <span class="fa fa-times-circle red-color fa-2x" title="Отказ от заказа" data-toggle="tooltip"
                          data-placement="top"></span>
                </td>
            </tr>
            <tr class="one-order" onclick="location.href='/profileorder/order'">
                <td>
                    123
                </td>
                <td>
                    2
                </td>
                <td class="all-sum">
                    <span class="sum"><b>12 123 123</b></span> <span
                        class="currency text-uppercase">BYR</span>
                </td>
                <td>
                    <b>12.12.1212</b><br>
                    14:00 - 16:00
                </td>
                <td class="status">
                                <span class="fa-stack fa-lg red-color" title="Удален"
                                      data-toggle="tooltip" data-placement="top">
                                        <span class="fa fa-circle fa-stack-2x"></span>
                                        <span class="fa fa-trash-o fa-stack-1x fa-inverse"></span>
                                </span>
                </td>
            </tr>
            <tr class="one-order" onclick="location.href='/profileorder/order'">
                <td>
                    123
                </td>
                <td>
                    2
                </td>
                <td class="all-sum">
                    <span class="sum"><b>12 123 123</b></span> <span
                        class="currency text-uppercase">BYR</span>
                </td>
                <td>
                    <b>12.12.1212</b><br>
                    14:00 - 16:00
                </td>
                <td class="status">
                                <span class="fa-stack fa-lg red-color" title="Возврат товара"
                                      data-toggle="tooltip" data-placement="top">
                                        <span class="fa fa-circle fa-stack-2x"></span>
                                        <span class="fa fa-plane fa-stack-1x fa-inverse fa-rotate-180"></span>
                                </span>
                </td>
            </tr>
            <tr class="one-order" onclick="location.href='/profileorder/order'">
                <td>
                    123
                </td>
                <td>
                    2
                </td>
                <td class="all-sum">
                    <span class="sum"><b>12 123 123</b></span> <span
                        class="currency text-uppercase">BYR</span>
                </td>
                <td>
                    <b>12.12.1212</b><br>
                    14:00 - 16:00
                </td>
                <td class="status">
                                <span class="fa-stack fa-lg red-color" title="Просрочена доставка"
                                      data-toggle="tooltip" data-placement="top">
                                        <span class="fa fa-circle fa-stack-2x"></span>
                                        <span class="fa fa-clock-o fa-stack-1x fa-inverse"></span>
                                </span>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript" src="/js/jqueryui/datepicker-ru.js"></script>
<script>

    $(function () {
        $('#reset-date').on('click', function () {
            $('#time, #time1').datepicker("setDate", null);
//            $("#form").submit();
            $("#reset-date").attr("disabled", "disabled");
        });

        $(".filter-orders input").on('change', function () {
            $("#reset-date").removeAttr("disabled");
        });

        $.datepicker.setDefaults(
            $.extend($.datepicker.regional["ru"])
        );
        $('#Users_create_time, #Users_update_time').datepicker({
            dateFormat: "dd.mm.yy",
            showOtherMonths: true
        });
    });

</script>
