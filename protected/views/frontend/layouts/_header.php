<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans|PT+Sans+Caption:400,700|Roboto:400,700&subset=cyrillic" rel="stylesheet">
    <!--[if lt IE 9]jquery-3.1.0.min>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<?php
    $cs = Yii::app()->getClientScript();
    $css_path = Yii::getPathOfAlias('webroot.css');
    $js_path = Yii::getPathOfAlias('webroot.js');
    $cs->registerCoreScript('jquery', CClientScript::POS_END);
    $cs->registerPackage('bootstrap_frontend');
    $cs->registerPackage('owlcarousel');
    $cs->registerPackage('cart');
    $cs->registerCssFile(
        Yii::app()->assetManager->publish($css_path . '/style_uk.css')
    );
    $cs->registerCssFile(
        Yii::app()->assetManager->publish($css_path . '/general_class.css')
    );
    $cs->registerCssFile(
        Yii::app()->assetManager->publish($css_path . '/default_styles.css')
    );
    $cs->registerCssFile(
        Yii::app()->assetManager->publish($css_path . '/media.css')
    );
    $cs->registerCssFile(
        Yii::app()->assetManager->publish($css_path . '/font-awesome.min.css')
    );
    $cs->registerCssFile(
        Yii::app()->assetManager->publish($css_path . '/style_h.css')
    );
    $search = '
        $(".glyphicon-search").on("click", function ()
        {
            $("#searchsubmit").submit();
        });
    ';
    $cs->registerScript('search' . $this->id, $search);
?>
    <title><?php echo $this->seo['title']; ?></title>
    <meta name="keywords" content="<?php echo $this->seo['keywords']; ?>"/>
    <meta name="description" content="<?php echo $this->seo['description']; ?>"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" />
</head>
<body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>
<div class="wrapper">
    <header>
        <div class="hdr-top">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6"><span>Входные, межкомнатные двери и фурнитура в Могилеве</span></div>
                    <div class="col-xs-6">
                        <ul class="hdr-top__menu pull-right">
                            [[w:MenuWidget|id=2;menu_type=custom;]]
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="hdr-mid">
            <div class="container">
                <div class="row">
                    <div class="col-xs-2">
                        <a href="/"><img src="/images/logo.png"></a>
                    </div>
                    <div class="col-xs-3 col-xs-offset-1 tp-mrg10">
                        <p>Закажите дверь</p>
                        <span class="hdr-phone__pre-number"><?php echo $this->phones[0]['code'] ;?></span>
                        <span class="hdr-phone__number"><?php echo $this->phones[0]['number'] ;?></span>
                    </div>
                    <div class="col-xs-3 tp-mrg10 slopBefore">
                        <p>Или узнайте про фурнитуру</p>
                        <div class="hdr-phone">
                            <span class="hdr-phone__pre-number"><?php echo $this->phones[1]['code'] ;?></span>
                            <span class="hdr-phone__number"><?php echo $this->phones[1]['number'] ;?></span>
                        </div>
                        <a href="#" class="more-contacts">Больше контактов</a>
                    </div>
                    <div class="col-xs-2 col-xs-offset-1 text-right tp-mrg30">
                        <button class="btn btn-lg btn-red">Перезвоните мне</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="hdr-third">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="hdr-menu pull-left">
                            [[w:MenuWidget|id=1;menu_type=custom;]]
<!--                            <li><a data-block="0" href="#">Главная</a></li>-->
<!--                            <li><a data-block="1" href="#">Входные двери</a></li>-->
<!--                            <li><a data-block="2" href="#">Межкомнатные двери</a>-->
<!---->
<!--                            </li>-->
<!--                            <li><a data-block="3" href="#">Фурнитура</a></li>-->
<!--                            <li><a data-block="4" href="#">Где купить</a></li>-->
<!--                            <li><a data-block="5" href="#">Акции</a></li>-->
<!--                            <li><a data-block="6" href="#">Услуги</a></li>-->
                        </ul>
                        <div class="liked-and-search pull-right">
                            <span class="fa fa-search-img pull-left"></span>
                            <span class="fa fa-heart-o pull-left"></span>
                        </div>
                    </div>
                </div>
            </div>
<!--            <div class="hdr-third hrd-hiddens">-->
<!--                <div data-block="0" class="container">-->
<!--                    <div class="row">-->
<!--                        <div class="col-xs-12">-->
<!--                            <ul class="hdr-menu pull-left">-->
<!--                                <li><a href="#">Главная</a></li>-->
<!--                                <li><a href="#">Входные двери</a></li>-->
<!--                                <li><a href="#">Межкомнатные двери</a></li>-->
<!--                                <li><a href="#">Фурнитура</a></li>-->
<!--                                <li><a href="#">Где купить</a></li>-->
<!--                                <li><a href="#">Акции</a></li>-->
<!--                                <li><a href="#">Услуги</a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div data-block="1" class="container">-->
<!--                    <div class="row">-->
<!--                        <div class="col-xs-12">-->
<!--                            <ul class="hdr-menu pull-left">-->
<!--                                <li><a href="#">Главная</a></li>-->
<!--                                <li><a href="#">Входные двери</a></li>-->
<!--                                <li><a href="#">Межкомнатные двери</a></li>-->
<!--                                <li><a href="#">Фурнитура</a></li>-->
<!--                                <li><a href="#">Где купить</a></li>-->
<!--                                <li><a href="#">Акции</a></li>-->
<!--                                <li><a href="#">Услуги</a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div data-block="2" class="container">-->
<!--                    <div class="row">-->
<!--                        <div class="col-xs-12">-->
<!--                            <ul class="hdr-menu pull-left">-->
<!--                                <li><a href="#">Главная</a></li>-->
<!--                                <li><a href="#">Входные двери</a></li>-->
<!--                                <li><a href="#">Межкомнатные двери</a></li>-->
<!--                                <li><a href="#">Фурнитура</a></li>-->
<!--                                <li><a href="#">Где купить</a></li>-->
<!--                                <li><a href="#">Акции</a></li>-->
<!--                                <li><a href="#">Услуги</a></li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <script>
            $(document).ready(function() {
                $('.hdr-menu > li > a').hover(function() {
                    $('.hdr-third.hrd-hiddens').find('[data-block='+$(this).attr('data-block')+']').show();
                }, function () {
                    $('.hdr-third.hrd-hiddens').find('[data-block='+$(this).attr('data-block')+']').hide();
                })
                $('.hdr-third.hrd-hiddens .container').hover(function() {
                    $(this).show();
                }, function () {
                    $(this).hide();
                })
            })
        </script>

        <div class="hdr-third hdr-fixed hidden">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="hdr-menu pull-left">
                            [[w:MenuWidget|id=14;menu_type=custom;]]
                            <li>
                                <a href="#" class="hdr__bar-btn dropdown dropdown-toggle"
                                   type="button" id="hdrDropMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="hdr__bar-wrap">
                                    <span class="hdr-bar"></span>
                                    <span class="hdr-bar"></span>
                                    <span class="hdr-bar"></span>
                                </span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="hdrDropMenu">
                                    [[w:MenuWidget|id=18;menu_type=custom;]]
                                </ul>
                            </li>
                            <li class="hrd__phones hrd__phones-pad">
                                <p>Двери</p>
                                <span class="hdr-phone__pre-number"><?php echo $this->phones[0]['code'] ;?></span>
                                <span class="hdr-phone__number"><?php echo $this->phones[0]['number'] ;?></span>
                            </li>
                            <li class="hrd__phones">
                                <p>Фурнитура</p>
                                <span class="hdr-phone__pre-number"><?php echo $this->phones[1]['code'] ;?></span>
                                <span class="hdr-phone__number"><?php echo $this->phones[1]['number'] ;?></span>
                            </li>
                        </ul>
                        <div class="liked-and-search pull-right">
                            <span class="fa fa-search-img pull-left"></span>
                            <span class="fa fa-heart-o pull-left"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
