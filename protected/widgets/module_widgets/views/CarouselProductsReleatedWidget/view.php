<?php
    $cs = Yii::app()->getClientScript();
    $cs->registerPackage('owlcarousel');

    $carousel =
        'var owl = $("#' . $this->id . '").owlCarousel(
        {
            margin : 28,
            items : ' . $this->count_items . ',
            autoPlay : true,
            stopOnHover : true,
            nav : true,
            loop : true,
            navText: [ \'<span class="fa fa-angle-left"></span>\', \'<span class="fa fa-angle-right"></span>\' ],
            responsive:
            {
                0:{
                    items : 1
                },
                600:{
                    items:3
                },
                1000:{
                    items:3
                }
            }
        });

        $(".owl-next").click(function()
        {
            owl.trigger("owl.next");
            return false;
        });

        $(".owl-prev").click(function()
        {
            owl.trigger("owl.prev");
            return false;
        });
    ';

    $cs->registerScript("carousel-" . $this->id, $carousel);

    $currency = SettingsCurrencyList::getCurrencyBasic();

    echo
        '<div class="catalog-carousel">
            <div class="title-block">
                <h2 class="title">' . $this->title . '</h2>
            </div>
        <div>

        <div class="owl-container">
            <div id="' . $this->id . '" class="owlCarousel">';

                foreach ($this->_data as $item)
                {
                    $image = $item->getOneFile('small');
                    if ($image == '' or !file_exists($image))
                    {
                        $image = Yii::app()->params['noimage'];
                    }
                    $url = $this->controller->createUrl('catalog/tree', array('url' => $item->getUrlForItem($item->parent->root)));

                    $sale = CatalogProducts::model()->getSalePrice($item->price, $item->sale_info, 2);

                    $price = ($sale != $item->price && $sale != 0) ? $sale : number_format($item->price, 2, '.', ' ');

                    echo
                        '<div class="carousel-block catalog-product text-left border">
                            <div class="image action text-uppercase">
                                <a href="' . $url . '" style="background: #fff url(/'.$image.') center center no-repeat; background-size: contain;"></a>';

                                if ($item->sale)
                                {
                                    echo '<div class="sale"><i class="fa fa-bookmark"></i> Акция</div>';
                                }
                                if ($item->popular)
                                {
                                    echo '<div class="popular"><i class="fa fa-bookmark"></i> Распродажа</div>';
                                }
                                if ($item->new)
                                {
                                    echo '<div class="new"><i class="fa fa-bookmark"></i> Новинка</div>';
                                }
                        echo
                            '</div>
                            <div class="description-block">
                                <div class="title">
                                    <a href="' . $url . '">' . $item->title . '</a>
                                </div>
                                <div class="price text-shadow">
                                    <b>' . $price . '</b> <span class="currency">' . key($currency) . '</span>
                                </div>';

                                if($sale)
                                {
                                    echo
                                        '<div class="price-old text-shadow">
                                            <b><del>' . number_format($item->price, 2, '.', ' ') . '</del></b> <span class="currency">' . key($currency) . '</span>
                                        </div>';
                                }
                        echo
                            '</div>
                            <div class="in-cart">
                                <button class="btn btn-primary">В корзину</button>
                            </div>
                        </div>';
                }
        echo
            '</div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>';