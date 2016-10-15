<?php
$total_price=0;
$count=0;
$delivery=0;
?>
<div class="order-info">
    <div class="title" style="margin-left: 0;">Список товаров</div>
</div>
<div class="orders-list">
    <div class="row header">
        <div class="col-xs-1">№</div>
        <div class="col-xs-2">Вид</div>
        <div class="col-xs-4">Наименование товара</div>
        <div class="col-xs-2">Цена</div>
        <div class="col-xs-1">Кол-во</div>
        <div class="col-xs-2">Сумма</div>
    </div>
    <?php

    foreach($products as $key=>$item)
    {
        $price=$item->getItemPrice();

        if (isset($item['image'])) //последний шаг корзины - render array
        {
            $image=$item['image'];
        }
        else
        {
            $image=null;
            if (isset($item->product))
            {
                $image=$item->product->getOneFile('small');
            }
            if (!$image)
            {
                $image=Yii::app()->params['noimage'];
            }
        }

        echo '<div class="row order">
            <div class="col-xs-1"><div class="cell">'.($key+1).'</div></div>
            <div class="col-xs-2"><img src="/'.$image.'" class="img-responsive height"></div>
            <div class="col-xs-4"><div class="cell text-left">'.CHtml::encode($item['title']).'</div></div>
            <div class="col-xs-2"><div class="cell text-right"><b>'. Yii::app()->format->formatNumber($item['price']).'</b> руб./'.$item->getUnit().'</div></div>
            <div class="col-xs-1"><div class="cell">'.$item->getViewCount().' '.$item->getUnit().'</div></div>
            <div class="col-xs-2"><div class="cell text-right"><b>'. Yii::app()->format->formatNumber($price).'</b> руб.</div></div>
        </div>';
        
        $total_price+=$price;
        $count+=$item->getItemCount();
    }
    ?>
    <div class="row footer">
        <div class="col-xs-8">
        </div>
        <div class="col-xs-4 right">
            <div class="count row">
                <div class="label col-xs-6">Количество</div>
                <div class="value col-xs-6 text-right"><b><?php echo $count; ?></b></div>
            </div>
            <div class="price row">
                <div class="label col-xs-6">Сумма</div>
                <div class="value col-xs-6 text-right"><b><?php echo Yii::app()->format->formatNumber($total_price); ?></b> руб.</div>
            </div>
            <div class="delivery row">
                <?php
                    if ($sum_delivery!=0)
                    {
                        $delivery_block='<b>'.Yii::app()->format->formatNumber($sum_delivery).'</b> руб.';
                    }
                    else
                    {
                        $delivery_block='<b>Бесплатно</b>';
                    }
                ?>
                <div class="label col-xs-6">Доставка</div>
                <div class="value col-xs-6 text-right"><?php echo $delivery_block; ?></div>
            </div>
        </div>
    </div>
    <div class="result">
        <div class="col-xs-4 col-xs-offset-8">
            <div class="total_price">
                <div class="label col-xs-6">Итого</div>
                <div class="value col-xs-6 text-right"><b><?php echo  Yii::app()->format->formatNumber($total_price+$sum_delivery); ?></b> руб.</div>
            </div>
        </div>
    </div>
</div>