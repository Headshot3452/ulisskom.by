<div class="col-xs-12">
    <a class="btn btn-primary pull-right" id="printOrder">
        Печать
    </a>
</div>
<div id="print" style="display: none;">
    <div id="items-products-print">
        <?php
        $count=count($products);
        $limit=15;

        $pages=ceil($count/$limit);
        for ($i=0;$i<$pages;$i++)
        {
            ?>
            <div class="page">
                <div class="head-block">
                    <div class="row">
                        <div class="col-xs-11" style="padding: 15px 0 5px 0;">
                            <div class="col-xs-6">
                                <div class="col-xs-5">
                                    <div class="title">Заказ № <span><?php echo $order->id; ?></span></div>
                                    <div class="date"><?php echo $order->f_create_time; ?></div>
                                </div>
                                <div class="col-xs-7 price">
                                    (Итого: <span><?php echo Yii::app()->format->formatNumber($order->sum); ?></span> BYR)
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class="label">Для комплектовшика:</div>
                                <div class="value"><?php echo (isset($order->picker) ? $order->picker->name : ""); ?></div>
                            </div>
                            <div class="col-xs-3">
                                <div class="label">Доставка:</div>
                                <div class="value"><?php echo $order->f_delivery_time; ?></div>
                            </div>
                        </div>
                        <div class="col-xs-1 page-num">
                            <?php echo $i+1; ?>
                        </div>
                    </div>
                </div>
                <div class="items-list">
                    <div class="row header">
                        <div class="c-num">№</div>
                        <div class="c-title" style="width:180px;">Наименование товара</div>
                        <div class="c-price">Цена / скидка</div>
                        <div class="c-count">Количество</div>
                        <div class="c-sum">Сумма</div>
                        <div class="c-barcode">Шртих-код</div>
                        <div class="c-status">Статус</div>
                    </div>
                    <?php
                    $first=$limit*$i;
                    $last=($i+1)*$limit;
                    for ($y=$first;$y<$last;$y++)
                    {
                        if (isset($products[$y]))
                        {
                            ?>
                            <div class="row order">
                                <div class="c-num"><div class="cell"><?php echo $y+1; ?></div></div>
                                <div class="c-title" style="width:180px;"><div class="cell"><?php echo $products[$y]->title; ?></div></div>
                                <div class="c-price"><div class="cell"><?php echo Yii::app()->format->formatNumber($products[$y]->price); ?></div></div>
                                <div class="c-count">
                                    <?php echo $products[$y]->getCount(); ?>
                                </div>
                                <div class="c-sum"><div class="cell"><?php echo Yii::app()->format->formatNumber($products[$y]->getItemPrice()); ?></div></div>
                                <div class="c-barcode barcode">
                                    <?php
                                        if (isset($products[$y]->product) && is_object($products[$y]->product))
                                        {
                                            echo $products[$y]->product->barcode;
                                        }
                                    ?>
                                </div>
                                <div class="c-status">
                                </div>
                            </div>
                        <?php
                        }
                        else
                        {
                            break;
                        }
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-xs-5 label text-left">
                        Комплектовщик: <span><?php echo (isset($order->picker) ? $order->picker->name : ""); ?></span>
                    </div>
                    <div class="col-xs-7 label text-left">
                        Подпись
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<div id="print-header" style="display: none;">

</div>

<div id="print-style" style="display: none;">
</div>

<?php
$cs=Yii::app()->getClientScript();

$print_order='
            $("#printOrder").on("click",function()
            {
                if ($("#input-products-list").val()=="")
                {
                   printOrder();
                   return false;
                }
                else
                {
                    sweetAlert("Для печати требуется сохранить заказ", "В заказе есть не сохраненные изменения", "error");
                }
            });
            function printOrder()
            {
                pr = document.getElementById("print").innerHTML;
                prh = document.head.innerHTML;
                prs = document.getElementById("print-style").innerHTML;
                newWin=window.open("","printWindow","Toolbar=0,Location=0,Directories=0,Status=0,Menubar=0,Scrollbars=0,Resizable=0");
                newWin.document.open();
                newWin.document.write(prs + "<div class=\"block-header \">" + prh + "</div><div class=\"order-block\">" + pr + "</div>");
                newWin.document.close();
                newWin.onload=function()
                {
                    newWin.print();
                }
            }

    ';
$cs->registerPackage('jquery')->registerScript("print_order",$print_order);

$cs->registerCssFile(
    Yii::app()->assetManager->publish(Yii::getPathOfAlias('webroot.css').'/font-barcode.css')
);
?>