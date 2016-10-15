<?php
/* @var $order Orders */
?>
<div class="item-order">
    <div class="main-title"><span>Заказ №<?php echo $order->id ?></span> <span class="icon-site-status-paid-inactive"></span> <span class="price"><span><?php echo number_format($order->sum,0,',',' '); ?></span> BYR</span><div class="clearfix"></div> </div>

    <div class="order-info">
        <div style="margin-left: 0;" class="title">Процесс обработки заказа</div>
        <div class="row">
            <div class="col-xs-4 info-block">
                <div class="title">Статус заказа</div>
                <div>
                    <div class="status">
                        <?php
                        Yii::app()->getClientScript()->registerScript('tooltipstatus', '$(document).ready(function(){

                                                $(".status>div").tooltip();

                                           });');

                        if($order->status <= 0)
                        {
                            echo '<div data-toggle="tooltip" data-placement="bottom" title="'.Orders::getStatus($order->status).'" class="order-status'.$order->status.'"></div>';
                        }
                        elseif($order->status == Orders::STATUS_COMPLETED)
                        {
                            echo '<div data-toggle="tooltip" data-placement="bottom" title="'.Orders::getStatus($order->status).'" class="order-status'.$order->status.' '.$order->status.'"></div>';
                        }
                        else
                        {
                            for($i = Orders::STATUS_OK; $i <= Orders::STATUS_COMPLETED; $i++)
                            {
                                echo '<div data-toggle="tooltip" data-placement="bottom" title="'.Orders::getStatus($i).'" class="order-status'.$i.' '.($i>$order->status ? 'inactive' : '').'"></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-2 info-block">
                <div class="title">Осталось</div>
                <div>
                    <?php
                        echo $order->f_delivery_end;
                    ?>
                </div>
            </div>
            <div class="col-xs-3 info-block">
                <div class="title">Время доставки</div>
                <div>
                    <?php echo $order->f_delivery_time; ?> <?php echo $order->delivery_hours; ?>
                </div>
            </div>
            <div class="col-xs-3 info-block">
                <div class="title">Оценка заказа</div>
                <a href="<?php echo $this->createUrl('orderRating',array('id'=>$order->id)); ?>"><i class="icon-site-star" style="float: left;"></i><span style="float: left; margin: 10px">Оценить заказ</span></a>
                <div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $this->renderPartial('_order_table',array('products'=>$order->orderItems,'sum_delivery'=>$order->sum_delivery));
    ?>

    <div class="payment order-info">
        <div class="title">Способ оплаты</div>
        <div class="value">
            <div class="item dl-lists">
                <dl class="dl-horizontal">
                    <dt>Оплата</dt>
                    <dd><?php echo Orders::getTypePayment($order->type_payments); ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="delivery order-info">
        <div class="title">Способ доставки</div>
        <div class="value">
            <?php
            switch($order->type_delivery)
            {
                case Orders::ORDER_DELIVERY_NOT_ADDRESS: echo 'Самовывоз'; break;
                case Orders::ORDER_DELIVERY_TO_ADDRESS:
                    $address=new Address();
                    if (!empty($order->address_info))
                    {
                        $address->attributes=$order->address_info;
                        $this->renderPartial('_address_item',array('data'=>$address));
                    }
                    break;
            }
            ?>
            <div class="item dl-lists">
                <dl class="dl-horizontal">
                    <dt>Комментарий</dt>
                    <dd><?php echo CHtml::encode($order->comment); ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>