<div id="items-products">
    <div class="items-list">
        <div class="row header">
            <div class="c-num">№</div>
            <div class="c-image">Вид</div>
            <div class="c-title">Наименование товара</div>
            <div class="c-price">Цена / скидка</div>
            <div class="c-count">Количество</div>
            <div class="c-sum">Сумма</div>
            <div class="c-status">Статус</div>
            <div class=""></div>
        </div>
        <?php
            foreach($products as $key=>$data)
            {
                if($data->product_id)
                {
                    $product = $data->product;
                    $image = $data->product->getOneFile('small');
                    if(!$image)
                    {
                        $image = Yii::app()->params['noimage'];
                    }
                }
                else
                {
                    $product = $data;
                    $image = Yii::app()->params['noimage'];
                }
                echo
                    '<div class="row order">
                        <div class="c-num"><div class="cell">'.($key+1).'</div></div>
                        <div class="c-image"><div class="cell"><img src="/'.$image.'"/></div></div>
                        <div class="c-title"><div class="cell">'.$data->title.'</div></div>
                        <div class="c-price"><div class="cell">'.Yii::app()->format->formatNumber($data->price).'</div></div>
                        <div class="c-count">
                            <div class="cell">
                                <span class="input">'.$data->getCount().'</span>
                            </div>
                        </div>
                        <div class="c-sum"><div class="cell">'.Yii::app()->format->formatNumber($data->getItemPrice()).'</div></div>
                        <div class="c-status">
                            <div class="cell">
                            </div>
                        </div>
                    </div>';
            }
        ?>
        <div class="row footer">
            <div class="col-xs-8">
            </div>
            <div class="col-xs-4 right">
                <div class="count row">
                    <div class="label col-xs-6">Количество товаров:</div>
                    <div class="value col-xs-6 text-right"><b><?php echo Yii::app()->format->formatNumber($order->count); ?></b></div>
                </div>
                <div class="count row">
                    <div class="label col-xs-6">Сумма:</div>
                    <div class="value col-xs-6 text-right"><b><?php echo Yii::app()->format->formatNumber($order->sum); ?></b> <span>BYR</span></div>
                </div>
                <div class="delivery row">
                    <div class="label col-xs-6">Доставка:</div>
                    <div class="value col-xs-6 text-right"><b><?php echo Yii::app()->format->formatNumber($order->sum_delivery); ?></b> <span>BYR</span></div>
                </div>
            </div>
        </div>
        <div class="result row">
            <div class="col-xs-8">
            </div>
            <div class="col-xs-4">
                <div class="total_price">
                    <div class="label col-xs-6">Итого:</div>
                    <div class="value col-xs-6 text-right"><b><?php echo Yii::app()->format->formatNumber($order->sum+$order->sum_delivery); ?></b> <span>BYR</span></div>
                </div>
            </div>
        </div>
    </div>
</div>