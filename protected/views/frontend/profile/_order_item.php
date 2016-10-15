<?php
    /* @var $data Orders */
?>
<a href=" <?php echo Yii::app()->createUrl('profile/order',array('id'=>$data->id)) ?>" class="order">
    <div class="col-xs-1"><div class="cell"><?php echo $data->id; ?></div></div>
    <div class="col-xs-2"><div class="cell text-center"><?php echo $data->f_delivery_end; ?></div></div>
    <div class="col-xs-1"><div class="cell"><?php echo $data->count; ?></div></div>
    <div class="col-xs-2"><div class="cell text-right"><b><?php echo Yii::app()->format->formatNumber($data->sum+$data->sum_delivery); ?></b> руб.</div></div>
    <div class="col-xs-3"><div class="cell"><?php echo $data->f_delivery_time; ?><br> <?php echo $data->delivery_hours; ?></div></div>
    <div class="col-xs-3"><div class="cell status"><div class="order-status<?php echo $data->status.'"></div><div>'.$data->getStatus($data->status) ?></div></div></div>
    <div class="clearfix"></div>
</a>