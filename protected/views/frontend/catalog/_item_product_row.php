<?php
    $currency = SettingsCurrencyList::getCurrencyBasic();

    $link = $this->createUrl('catalog/tree', array('url' => $data->getUrlForItem($data->parent->root)));

    $image = $data->getOneFile('small');

    $sale_type = '';

    if (!$image or !file_exists($image))
    {
        $image = Yii::app()->params['noimage'];
    }

    $sale = CatalogProducts::model()->getSalePrice($data->price, $data->sale_info, 2);

    $price = ($sale != $data->price && $sale != 0) ? $sale : number_format($data->price, 2, '.', ' ');
?>
<div class="one-product view-row row border-bottom">
    <div class="image col-md-3 text-center">
        <a href="<?php echo $link ?>">
            <img align="top" src="/<?php echo $image; ?>" class="border">
        </a>
    </div>
    <div class="description-block col-md-9">
        <div class="title row">
            <a href="<?php echo $link; ?>"><b><?php echo $data->title; ?></b></a>
        </div>
        <div class="info row">
            <div class="price-group col-md-6 no-padding">
                <div class="price text-shadow">
                    <b><?php echo $price; ?></b> <span
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
                }
?>
            </div>
            <div class="action text-uppercase col-md-3">
<?php
                if($sale)
                {
                    $sale_type = $data->getSaleType();
                }
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
            <div class="in-cart text-right col-md-3 no-padding">
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
        <div class="id row">
            <div class="col-md-12 text-left no-padding availability">
                <span class="green-color"><i class="fa fa-check-circle"></i> В наличии</span>
<!--                                                <span class="orange-color"><i class="fa fa-history fa-flip-horizontal"></i> Под заказ (до 7 дней)</span>-->
            </div>
            <div class="col-md-6 text-left no-padding">
                <?php echo CHtml::link(Yii::t('app', 'Add to favorites')); ?>
            </div>
            <div class="col-md-6 text-right no-padding id">#<?php echo $data->id; ?></div>
        </div>
    </div>
</div>