<div class="row one-order-title">
    <div class="href-back">
        <a href="<?php echo Yii::app()->createUrl('orders/index') ?>">
            <span class="fa fa-angle-left"></span>
        </a>
    </div>
    <div class="col-md-3">
        <div class="title pull-left">Заказ № <?php echo $order->id; ?></div>
        <div class="font-12 pull-left">
            <?php echo $order->f_create_time ;?>
        </div>
    </div>
    <div class="col-md-9 row order-info">
        <div class="col-md-4 paid">
            <span class="cursor-pointer fa-stack fa-lg color-<?php echo $order->paid ? "green" : "gray"; ?>"
                  title="<?php echo $order->paid ? "Оплачено" : "Не оплачено"; ?>" data-toggle="tooltip"
                  data-placement="bottom">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-usd fa-stack-1x fa-inverse"></span>
            </span>
            <span class="sum color-primary">
                <b>
<?php
                    $formatter = new CFormatter;
                    $formatter->numberFormat = array('decimals' => '2', 'decimalSeparator'=>'.', 'thousandSeparator' => ' ');
                    echo $formatter->number($order->sum);
?>
                </b>
            </span>
            <span class="currency text-uppercase color-gray"><?php echo $this->currency_ico_view ;?></span>
        </div>
        <div class="labels col-md-3">
            <span class="font-12 color-gray label-title">
                Ярлыки
            </span>

            <div>
<?php
                for($i = 1; $i < 5; $i++)
                {
                    $note = "note".$i;
                    $_note = $order->$note ? unserialize($order->$note) : "";

                    if($_note)
                    {
                        echo
                            '<span  class="cursor-pointer fa fa-star fa-lg color-'.$_note["label"].'"
                                    title="'.$_note["text"].'" data-toggle="tooltip"
                                    data-placement="top"></span>';
                    }
                }
?>
            </div>
        </div>
        <div class="col-md-4 o-status">
            <span class="color-gray font-12 status-title">
                <?php echo Yii::t('app', 'Order status') ;?>:
            </span>
            <div>
<?php
                echo CHtml::dropDownList('status', $order->status, Orders::getStatus(), array('class' => 'form-control selectpicker'));
?>
            </div>
        </div>
        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                    data-toggle="dropdown">
                <span class="fa fa-bars"></span>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Печать</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Отправить счет</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Копировать заказ</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Удалить заказ</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Ссылка на оплату</a></li>
            </ul>
        </div>
    </div>
</div>
<?php
    Yii::app()->clientScript->registerPackage('boot-select');
    Yii::app()->getClientScript()->registerScript('changestatus_drop',
        '
        $(".selectpicker").selectpicker();

        $(document).ready(function(){
            $(".one-order-title .o-status button ").find(".filter-option").removeClass("pull-left");
            $(".one-order-title .o-status button").prepend("<div class=\'order-status"+($("#status option:selected").val())+"\'></div>");

            $(".one-order-title .o-status li .text").each(function(){
                $( this ).prepend( "<div class=\'order-status"+($(this).parent().parent().attr("data-original-index")-3)+"\'></div>" );
            });

            $(\'[data-toggle="tooltip"]\').tooltip();

            $("#status").change(function()
            {
                if(confirm("Вы уверены, что хотите сменить статус?"))
                {
                    var id = $(this).find("option:selected").val();
                    $.ajax(
                    {
                        type: "POST",
                        url: "' . $this->createUrl('changeStatus') . '?id=' . $order->id . '&status="+id,
                        success: function(msg){
                            window.location.reload();
                        }
                    });
                }
                return false;
            });
        });
    ');