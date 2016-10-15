<?php
    $url = trim($product->parent->findUrlForItem('name', false, $this->root_id), '/');
    $currency = SettingsCurrencyList::getCurrencyBasic();

    $sale_type = '';

    $cs = Yii::app()->getClientScript();
    $src = '
        $("body").on("click","#count-dec",function()
        {
            if($("#product-count").val() > 1)
            {
                $("#product-count").val($("#product-count").val()-1);
            }
        });

        $("body").on("click","#count-inc",function()
        {
            if($("#product-count").val() < ' . $product->count . ')
            {
                $("#product-count").val(parseInt($("#product-count").val())+1);
            }
        });

        $("#product-count").keydown(function (e)
        {
            return false;
        });
    ';
    $cs->registerScript('counts', $src);

    $sale = CatalogProducts::model()->getSalePrice($product->price, $product->sale_info, 2);

    $image = $product->getOneFile('small');

    if (!$image or !file_exists($image))
    {
        $image = Yii::app()->params['noimage'];
    }

    $sale_cart = ($sale != $product->price && $sale != 0) ? $product->price - $sale : 0;

    $price = ($sale != $product->price && $sale != 0) ? $sale : number_format($product->price, 2, '.', ' ');
?>

<div class="catalog">
    <div class="container">
        <div class="row">
            <div class="col-md-9 product">
                <h1><?php echo $this->getPageTitle(); ?></h1>

                <div class="row">
                    <div class="images col-md-5">
                        <?php $this->renderPartial('slider_product', array('product' => $product)) ?>
                        <div class="article">Код товара: #<?php echo $product->article ?></div>
                    </div>
                    <div class="col-md-7 price-descr">
                        <div class="row">
                            <label class="col-md-12">Цена</label>

                            <div class="col-md-6">
                                <div class="price text-shadow">
                                    <b><?php echo $price; ?></b> <span
                                        class="currency"><?php echo key($currency); ?></span>
                                </div>
<?php
                                if ($sale)
                                {
                                    echo
                                        '<div class="price-old text-shadow">
                                            <b><del>' . number_format($product->price, 2, '.', ' ') . '</del></b>
                                            <span class="currency">' . key($currency) . '</span>
                                        </div>';
                                }
?>
                            </div>
                            <div class="col-md-6 action text-uppercase">
<?php
                                if ($product->sale)
                                {
                                    echo '<div class="sale"><i class="fa fa-bookmark"></i> Акция</div>';
                                }
                                if ($product->popular)
                                {
                                    echo '<div class="popular"><i class="fa fa-bookmark"></i> Распродажа</div>';
                                }
                                if ($product->new)
                                {
                                    echo '<div class="new"><i class="fa fa-bookmark"></i> Новинка</div>';
                                }
?>
                            </div>
                            <label class="col-md-12">Количество</label>

                            <div class="col-md-12 count">
                                <button id="count-dec" class="btn btn-default">-</button>
<?php
                                if($sale)
                                {
                                    $sale_type = $product->getSaleType();
                                }
                                echo CHtml::numberField('product-count', 1, array('min' => '1', 'class' => 'count', 'max' => $product->count));
?>
                                <button id="count-inc" class="btn btn-default">+</button>
                                <span><?php echo CatalogParams::model()->getUnitType($product->unit_id) ;?></span>
                            </div>
                            <div class="in-cart col-md-12">
                                <button class="btn btn-primary addProduct"
                                        data-id="<?php echo $product->id ;?>"
                                        data-price="<?php echo number_format($product->price, 2, '.', '') ;?>"
                                        data-title="<?php echo $product->title ;?>"
                                        data-image="<?php echo $image ;?>"
                                        data-sale="<?php echo str_replace(" ", "", $sale) ;?>"
                                        data-type="<?php echo $sale_type ;?>"
                                    >В корзину
                                </button>
                                <?php echo CHtml::link(Yii::t('app', 'Add to favorites')); ?>
                            </div>

                            <div class="in-cart col-md-12">
                                <span class="green-color"><i class="fa fa-check-circle"></i> В наличии</span>
<!--                                <span class="orange-color"><i class="fa fa-history fa-flip-horizontal"></i> Под заказ(до 7 дней)</span>-->
                            </div>

                            <div class="delivery col-md-12">
                                <label>Доставка</label>
                                <?php echo CHtml::link(Yii::t('app', 'Read more'), '#'); ?>
                                <table class="table table-hover">
                                    <tr>
                                        <td>Самовывоз</td>
                                        <td>Бесплатно</td>
                                    </tr>

                                    <tr>
                                        <td>Курьером</td>
                                        <td>15 BYR</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tabbable">
                    <ul class="nav nav-tabs text-uppercase">
                        <li class="active">
                            <a href="#tab1" data-toggle="tab"><?php echo Yii::t('app', 'Characteristics') ?></a>
                        </li>
                        <li>
                            <a href="#tab2" data-toggle="tab"><?php echo Yii::t('app', 'Description') ?></a>
                        </li>
                        <li>
                            <a href="#tab3" data-toggle="tab"><?php echo Yii::t('app', 'Review') ?></a>
                        </li>
                        <li>
                            <a href="#tab4" data-toggle="tab"><?php echo Yii::t('app', 'Delivery & Payment') ?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active parameters" id="tab1">
<?php
                            $params = $product->parameters_uniq;
                            $id_group = array();
                            foreach ($product->parameters_uniq as $p)
                            {
                                $id_group[$p->params->parent_id] = $p->params->parent->title;
                            }
                            foreach ($id_group as $key => $group)
                            {
                                echo '<h3 class="table-caption">' . $group . '</h3>';
                                echo '<table class="table table-hover table-striped">';
                                foreach ($params as $p)
                                {
                                    if (($p->params->parent_id == $key) AND ($p->value !== NULL))
                                    {
                                        echo
                                            '<tr>
                                                <td>' . $p->params->title . '</td>
                                                <td>';
                                                    if ($p->params->type == CatalogParams::TYPE_CHECKBOX)
                                                    {
                                                        foreach ($p->getParamsValues() as $pCheck)
                                                        {
                                                            echo $pCheck->value->value . ' ';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo $p->value->value;
                                                    }
                                        echo
                                                '</td>
                                            </tr>';
                                    }
                                }
                                echo '</table>';
                            }
?>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="text-content">
                                <h3><?php echo Yii::t('app', 'Product description'); ?></h3>
                                <?php echo empty($product->text) ? '' : $product->text; ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="text-content">
<?php
                                $mReview = ReviewItem::model()->getReviewProvider(2, '', '', ReviewItem::STATUS_PLACEMENT, null, 't.id', 'DESC', 2);

                                $this->widget('application.widgets.ProductListViewAdmin',
                                    array(
                                        'id' => 'products-list',
                                        'itemsTagName' => 'ul',
                                        'itemsCssClass' => 'list-unstyled',
                                        'emptyText' => '<h4 class="text-center">Пока нет ни одного отзыва.</h4>',
                                        'htmlOptions' => array(
                                            'class' => ' reviews-list'
                                        ),
                                        'typeCatalog' => '',
                                        'itemView' => '//review/_one_review',
                                        'dataProvider' => $mReview,
                                        'ajaxUpdate' => false,
                                        'template' => "<div class='items'>{mainItems}</div>",
                                    )
                                );

                                echo CHtml::link('Больше отзывов', array('review/index'), array('class' => 'more', 'target' => '_blank'))?>

                                <div class="col-md-12 widget">
                                    [[w:ReviewWidget]]
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <div class="text-content delivery">
                                <?php $this->renderPartial('delivery', array()); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 releated">
                        [[w:CarouselProductsReleatedWidget|product_id=<?php echo $product->id ?>]]
                    </div>
                </div>

            </div>
            <div class="col-md-3 side-bar">
                <?php echo CHtml::link('<span class="fa fa-long-arrow-left"></span> Вернуться к товарам', array('catalog/tree', 'url' => $url . '/' . $product->parent->name), array('class' => 'btn btn-default col-md-12 back')) ?>
            </div>
        </div>
    </div>
</div>


