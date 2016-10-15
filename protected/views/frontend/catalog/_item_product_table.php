<?php
    $currency = SettingsCurrencyList::getCurrencyBasic();

    $link = $this->createUrl('catalog/tree', array('url' => $data->getUrlForItem($data->parent->root)));

    $sale_type = '';

    $image = $data->getOneFile('small');

    if (!$image or !file_exists($image))
    {
        $image = Yii::app()->params['noimage'];
    }
    $sale = CatalogProducts::model()->getSalePrice($data->price, $data->sale_info, 2);
    $price = ($sale != $data->price && $sale != 0) ? $sale : number_format($data->price, 2, '.', ' ');
?>
<div class="one-product view-table col-md-4">
    <div class="col-md-12 border">
        <div class="image row text-center action text-uppercase">
            <a href="<?php echo $link ?>" style="background:#fff url(/<?php echo $image; ?>) center center no-repeat; background-size: contain;">
<!--                <img align="top" src="/--><?php //echo $image; ?><!--" class="border">-->
            </a>
<?php
                if ($data->sale)
                {
                    echo '<div class="sale"><i class="fa fa-bookmark"></i> Акция</div>';
                }
                if ($data->popular)
                {
                    echo '<div class="popular"><i class="fa fa-bookmark"></i> Распродажа</div>';
                }
                if ($data->new)
                {
                    echo '<div class="new"><i class="fa fa-bookmark"></i> Новинка</div>';
                }
?>
        </div>
        <div class="description-block">
            <div class="title row">
                <a href="<?php echo $link; ?>">
                    <b><?php echo $data->title; ?></b>
                </a>
            </div>
            <div class="info row">
                <div class="price-group col-md-12 no-padding">
                    <div class="price text-shadow">
                        <b><?php echo $price ;?></b> <span
                            class="currency"><?php echo key($currency); ?></span>
                    </div>
<?php
                    if ($sale)
                    {
                        echo
                            '<div class="price-old text-shadow">
                                <b><del>' . number_format($data->price, 2, '.', ' ') . '</del></b>
                                <span class="currency">' . key($currency) . '</span>
                            </div>';

                        $sale_type = $data->getSaleType();
                    }
?>
                </div>
                <div class="col-md-12 text-left no-padding availability">
<!--                    <span class="green-color"><i class="fa fa-check-circle"></i> В наличии</span>-->
                                                    <span class="orange-color"><i class="fa fa-history fa-flip-horizontal"></i> Под заказ (до 7 дней)</span>
                </div>
            </div>
        </div>
        <div class="in-cart text-left row no-padding">
            <button class="btn btn-primary addProduct"
                    data-id="<?php echo $data->id ;?>"
                    data-price="<?php echo number_format($data->price, 2, '.', '') ;?>"
                    data-title="<?php echo $data->title ;?>"
                    data-image="<?php echo $image ;?>"
                    data-sale="<?php echo str_replace(" ", "", $sale) ;?>"
                    data-type="<?php echo $sale_type ;?>"
                >В корзину
            </button>
        </div>
    </div>
</div>