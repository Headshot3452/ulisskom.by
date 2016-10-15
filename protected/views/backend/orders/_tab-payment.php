<?php
    /* @var $order Orders */
?>
<div class="row payment-info">
    <div class="col-md-12">
        <div class="form-group">
            <?php echo $form->label($order, "type_payments", array("class" => "col-md-3 control-label text-right color-gray")) ;?>
            <div class="col-md-3 input">
                <?php echo $form->dropDownList($order, 'type_payments', $order->getTypePayment()) ;?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <label for="sum" class="col-md-3 control-label text-right color-gray">Сумма</label>
            <div class="col-md-3 input">
                <?php echo $form->textField($order, 'f_sum', array('readonly' => 'readonly', 'class' => 'text-right')) ;?><span class="text-uppercase"><?php echo $this->currency_ico_view ;?></span>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <?php echo $form->label($order, "sum_paid", array("class" => "col-md-3 control-label text-right color-gray")) ;?>
            <div class="col-md-3 input">
                <?php echo $form->textField($order, 'sum_paid', array('class' => 'text-right', 'value' => $order->f_sum_paid)) ;?><span class="text-uppercase"><?php echo $this->currency_ico_view ;?></span>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <label for="time1" class="col-md-3 control-label text-right color-gray">Передача от клиента</label>
            <div class="col-md-3 input time">
                <input type="text" class="form-control text-center pull-left" id="time1" value="12.12.2016">
                <input type="text" class="form-control text-center pull-right" id="time2" value="12:12">
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="form-group">
            <label for="time3" class="col-md-3 control-label text-right color-gray">Принято у курьера:</label>
            <div class="col-md-3 input time">
                <input type="text" class="form-control text-center pull-left" id="time3" value="12.12.2016">
                <input type="text" class="form-control text-center pull-right" id="time4" value="12:21">
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group buttons">
            <?php echo BsHtml::submitButton(Yii::t('app','Save'),array('color' => BsHtml::BUTTON_COLOR_PRIMARY)); ?>
            <span>Отмена</span>
        </div>
    </div>
</div>

<?php
    $cs = Yii::app()->getClientScript();

    $sum_paid = '

        $(function()
        {
            $("body").on("keyup", "#Orders_sum_paid", function(event)
            {
                proverka(this);
                $(this).val( number_format_on_input ( $(this).val() ) );
            });
        });
    ';

    $cs->registerScript("sum_paid", $sum_paid);
?>
