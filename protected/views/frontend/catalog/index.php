<div class="container catalog-first bt-mrg70">
    <h1 class="bt-mrg30"><?php echo $this->pageTitle ;?> Улисском</h1>
<?php
    for($i = 0; $i < 2; $i++) {
        if($i == 0) {
            $image = $categories[$i]->getOneFile('big');
            echo '
            <div class="row">
                <div class="col-xs-12">
                    <div class="cat-part cat-part-wide cat-flex clearfix">
                        <div class="cat-part-left">
                            <h3>'.$categories[$i]['title'].'</h3>
                            '.$categories[$i]['text'].'
                            <a href="'.$categories[$i]['name'].'" class="btn btn-lg btn-red tp-mrg30">Смотреть в каталоге</a>
                        </div>
                        <div class="cat-part-right hidden-xs">
                            <img style="height:480px;" src="/'.$image.'"/>
                        </div>
                    </div>
                </div>
            </div>';
        }
        elseif($i == 1) {
            $image_1 = $categories[$i]->getOneFile('big');
            $image_2 = $categories[$i + 1]->getOneFile('big');
            echo '
            <div class="row tp-mrg30">
                <div class="col-xs-6">
                    <div class="cat-part cat-part-wide cat-flex clearfix">
                        <div class="cat-part-left">
                            <h3 style="min-height: 70px;">'.$categories[$i]['title'].'</h3>
                            '.$categories[$i]['text'].'
                            <a href="'.$categories[$i]['name'].'" class="btn btn-lg btn-red tp-mrg30">Смотреть в каталоге</a>
                        </div>
                        <div class="cat-part-right hidden-xs">
                            <img style="height:480px;" src="/'.$image_1.'"/>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="cat-part cat-part-wide cat-flex clearfix">
                        <div class="cat-part-left">
                            <h3 style="min-height: 70px;">'.$categories[$i + 1]['title'].'</h3>
                            '.$categories[$i + 1]['text'].'
                            <a href="'.$categories[$i]['name'].'" class="btn btn-lg btn-red tp-mrg30">Смотреть в каталоге</a>
                        </div>
                        <div class="cat-part-right hidden-xs">
                            <img style="height:480px;" src="/'.$image_2.'"/>
                        </div>
                    </div>
                </div>
            </div>';
        }
    }
?>
</div>
<div class="container-fluid container-info-bnr bt-mrg70">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-xs-3">
                    <img src="/images/try-door.png">
                </div>
                <div class="col-xs-6">
                    <h1 class="tp-mrg30">Примерь новую дверь</h1>
                    <p>Вы можете <span class="red_col">примерить понравившуюся дверь</span> прямо у нас на сайте</p>
                </div>
                <div class="col-xs-3">
                    <a href="#" class="btn btn-lg btn-red tp-mrg50">Попробовать сейчас</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container bt-mrg70">
    <div class="catalog-seo">
        <?php echo $this->text ;?>
    </div>
</div>

<div class="container tp-mrg50 bt-mrg50 special_offer_wrap">
    <div class="row">
        <div class="col-xs-9"><h3>Спецпредложение</h3></div>
        <div class="col-xs-3 text-right">
            <span class="owl-carousel-np-controls special_offer_prev owl-carousel-np-controls__sm owl-carousel-np-controls-before"></span>
            <span class="owl-carousel-np-controls special_offer_next owl-carousel-np-controls__sm owl-carousel-np-controls-after"></span>
        </div>
    </div>
    <div id="special_offer_catalog" class="special_offer tp-mrg30">
<?php
        foreach($spec as $spec_item) {
            $image = $spec_item->getOneFile('big');
            echo
            '<div class="special_offer-one">
                <div class="prod">
                    <a class="prod-name text-center">'.$spec_item->title.'</a>
                    <p class="prod-type text-center">'.$this->pageTitle.'</p>
                    <div class="prod-image">
                        <img src="/'.$image.'">
                    </div>
                    <div class="prod-prices">
                        <div class="prod-no-prices">
                            <p class="prod-prices-first">Уточняйте цену</p>
                            <p class="prod-prices-second">по телефону</p>
                        </div>
                    </div>
                    <div class="prod-btns">
                        <a href="#" class="btn btn-lg btn-red">Подробнее</a>
                        <span class="fa fa-heart-o pull-right"></span>
                    </div>
                </div>
            </div>';
        }
?>
    </div>
</div>