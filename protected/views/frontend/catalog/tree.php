<div class="container catalog-cont-prds tp-mrg40">
    <div class="row">
        <div class="col-xs-3">
            <div class="catalog-left-block">
                <div class="catalog-str">
                    <ul class="catalog-brancs">
                        <li class="catalog-branch">
                            <a class="catalog-branch-title" href="#">Входные двери<span class="fa fa-plus"></span></a>
                            <ul class="catalog-brancs catalog-brancs-second">
                                <li class="catalog-branch">
                                    <a href="#">Каталог 2016 года<span class="fa fa-plus"></span></a>
                                    <ul class="catalog-brancs">
                                        <li class="catalog-branch">
                                            <a href="#">Каталог 2016 года</a>
                                        </li>
                                        <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                        <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                                    </ul>
                                </li>
                                <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                            </ul>
                        </li>
                        <li class="catalog-branch">
                            <a class="catalog-branch-title"  href="#">Межкомнатные двери<span class="fa fa-plus"></span></a>
                            <ul class="catalog-brancs catalog-brancs-second">
                                <li class="catalog-branch">
                                    <a href="#">Каталог 2016 года<span class="fa fa-plus"></span></a>
                                    <ul class="catalog-brancs">
                                        <li class="catalog-branch">
                                            <a href="#">Каталог 2016 года</a>
                                        </li>
                                        <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                        <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                                    </ul>
                                </li>
                                <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                            </ul>
                        </li>
                        <li class="catalog-branch">
                            <a class="catalog-branch-title"  href="#">Фурнитура<span class="fa fa-plus"></span></a>
                            <ul class="catalog-brancs catalog-brancs-second">
                                <li class="catalog-branch">
                                    <a href="#">Каталог 2016 года<span class="fa fa-plus"></span></a>
                                    <ul class="catalog-brancs">
                                        <li class="catalog-branch">
                                            <a href="#">Каталог 2016 года</a>
                                        </li>
                                        <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                        <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                                    </ul>
                                </li>
                                <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                            </ul>
                        </li>
                        <!--<li class="catalog-branch">
                            <a class="catalog-branch-title"  href="#">Межкомнатные двери<span class="fa fa-plus"></span></a>
                            <ul class="catalog-brancs catalog-brancs-second">
                                <li class="catalog-branch">
                                    <a href="#">Каталог 2016 года<span class="fa fa-plus"></span></a>
                                    <ul class="catalog-brancs">
                                        <li class="catalog-branch">
                                            <a href="#">Каталог 2016 года</a>
                                        </li>
                                        <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                        <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                                    </ul>
                                </li>
                                <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                            </ul>
                        </li>
                        <li class="catalog-branch">
                            <a class="catalog-branch-title"  href="#">Межкомнатные двери<span class="fa fa-plus"></span></a>
                            <ul class="catalog-brancs catalog-brancs-second">
                                <li class="catalog-branch">
                                    <a href="#">Каталог 2016 года<span class="fa fa-plus"></span></a>
                                    <ul class="catalog-brancs">
                                        <li class="catalog-branch">
                                            <a href="#">Каталог 2016 года</a>
                                        </li>
                                        <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                        <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                                    </ul>
                                </li>
                                <li class="catalog-branch"><a href="#">Двери для дома</a></li>
                                <li class="catalog-branch"><a href="#">Двери для квартиры</a></li>
                            </ul>
                        </li>-->
                    </ul>
                </div>
                <script>

                    $('.catalog-brancs a').click(function() {
                        if(!$(this).parent().hasClass('active-br')) {
                            $(this).parent().addClass('active-br').find('.fa').first().removeClass('fa-plus').addClass('fa-minus');
                            $(this).parent().find('.catalog-brancs').first().show(150).addClass('active-brs');
                        } else {
                            $(this).parent().removeClass('active-br').find('.fa').first().addClass('fa-plus').removeClass('fa-minus');
                            $(this).parent().find('.catalog-brancs').first().hide(150).removeClass('active-brs');
                        }
                        return false;
                    })

                </script>
                <div class="container-info-bnr">
                    <div>
                        <h4>Примерь новую дверь</h4>
                        <p>Вы можете <span class="red_col">примерить понравившуюся дверь</span> прямо у нас на сайте</p>
                    </div>
                    <div>
                        <img src="/images/try-door.png">
                    </div>

                    <div>
                        <a href="#" class="btn btn-lg btn-red tp-mrg50">Попробовать сейчас</a>
                    </div>
                </div>


            </div>
            <div class="catalog-news bt-mrg50">
                <h4>Новости</h4>
                <div class="catalog-news-one">
                    <p class="catalog-news_date">25.11.2016</p>
                    <a href="#">Новые поступления</a>
                </div>
                <div class="catalog-news-one">
                    <p class="catalog-news_date">25.11.2016</p>
                    <a href="#">Стальные двери от Улисском</a>
                </div>
                <div class="catalog-news-one">
                    <p class="catalog-news_date">25.11.2016</p>
                    <a href="#">Стальные двери не пробиваемые дробью</a>
                </div>
            </div>
        </div>
        <div class="col-xs-9">
            <div class="breadcrumbs ">
                <ol class="breadcrumb">
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">Каталог</a></li>
                    <li class="active">Индекс</li>
                </ol>
            </div>
            <div class="catalog-right-block">
                <h1>Двери Стальная линия</h1>

                <div class="catalog-cont-prds-wrap">
                    <div class="catalog-static-params clearfix tp-mrg30">

                        <div class="dropdown dropdown-ulis pull-left">
                            <button class="btn btn-ulis-fltr btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Сначала дорогие
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">Сначала дорогие</a></li>
                                <li><a href="#">Сначала дешевые</a></li>
                            </ul>
                        </div>

                        <div class="dropdown dropdown-ulis pull-left">
                            <button class="btn btn-ulis-fltr btn-default dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Производитель
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                <li><a href="#">Строммашина</a></li>
                                <li><a href="#">Пикадор</a></li>
                                <li><a href="#">Пандур</a></li>
                            </ul>
                        </div>

                        <div class="dropdown dropdown-ulis pull-left">
                            <button class="btn btn-ulis-fltr btn-default dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Место установки
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                <li><a href="#">В дом</a></li>
                                <li><a href="#">В квартиру</a></li>
                                <li><a href="#">Все модели</a></li>
                            </ul>
                        </div>
                        <div class="prod-view dropdown-ulis-sort prod-view-sq pull-right">
                            <a href="#"><img src="/images/list-view.png"></a>
                        </div>
                        <div class="prod-view dropdown-ulis-sort prod-view-list pull-right">
                            <a href="#"><img src="/images/block-view.png"></a>
                        </div>
                        <div class="dropdown dropdown-ulis dropdown-ulis-count pull-right">
                            <button class="btn btn-ulis-fltr btn-default dropdown-toggle" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                15
                                <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
                                <li><a href="#">30</a></li>
                                <li><a href="#">45</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="catalog-prds-wrap clearfix ">
                        <div class="catalog-prds tp-mrg30">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="catalog-prds-img">
                                        <a rel="tovar1" href="/images/in-doors.png">
                                            <img src="/images/in-doors.png"/>
                                        </a>
                                        <a rel="tovar1" href="/images/2-41big.jpeg"></a>
                                        <a rel="tovar1" href="/images/2-44big.jpeg"></a>
                                        <a rel="tovar1" href="/images/3-41big.jpeg"></a>
                                    </div>

                                </div>
                                <div class="col-xs-9">
                                    <h4>Рафаэль
                                        <span data-toggle="tooltip" data-placement="bottom" title="Акция от производителя" class="uliss-badge uliss-badge__action">Акция</span>
                                        <span data-toggle="tooltip" data-placement="bottom" title="Специальное предложение от производителя" class="uliss-badge uliss-badge__sp">Спецпредложение</span>
                                        <span data-toggle="tooltip" data-placement="bottom" title="Новинка от производителя" class="uliss-badge uliss-badge__new">Новинка</span>
                                        <span data-toggle="tooltip" data-placement="bottom" title="Хит продаж производителя"  class="uliss-badge uliss-badge__hit">Хит продаж</span>
                                        <span data-toggle="tooltip" data-placement="bottom" title="В избранное" class="fa fa-heart-o liked"></span>
                                    </h4>
                                    <p class="catalog-prds-seo tp-mrg10">Небольшое описание товара в 2-4 строки.
                                                                         Можно взять текст или часть текста со страницы товара,
                                                                         если он там есть.
                                                                         Желательно к каждой двери иметь небольшое описание.
                                    </p>
                                    <div class="catalog-prds-prices tp-mrg30 clearfix">
                                        <div class="catalog-prds-prices__byn pull-left">
                                            <div class="old">от 1900 руб.</div>
                                            <div class="tp-mrg10 new">от 2500 руб.</div>
                                        </div>
                                        <div class="catalog-prds-prices__byr pull-left">
                                            <div class="old">от 19 000 000 руб.</div>
                                            <div class="tp-mrg10 new">от 25 000 000 руб.</div>
                                        </div>
                                        <a href="#" class="btn btn-lg btn-red">Подробнее</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="catalog-static-params clearfix tp-mrg30">
                        <ul class="pagination">
                            <li class="active"><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li class="dots">
                                <a href="#">
                                    <span aria-hidden="true">...</span>
                                </a>
                            </li>
                            <li><a href="#">10</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
//    $cs = Yii::app()->getClientScript();
//    $scr = '
//        $("body").on("click", "#view-table",function()
//        {
//            $(this).addClass("pressed");
//            $("#view-row").removeClass("pressed");
//            $("#product-list").removeClass("view-row").addClass("view-table");
//            $.cookie("type_catalog","view-table",{expires: 3600, path: "/"});
//            window.location.reload();
//        });
//
//        $("body").on("click", "#view-row",function()
//        {
//            $(this).addClass("pressed");
//            $("#view-table").removeClass("pressed");
//            $("#product-list").removeClass("view-table").addClass("view-row");
//            $.cookie("type_catalog","view-row",{expires: 3600, path: "/"});
//            window.location.reload();
//        });
//    ';
//    $cs->registerScript('views', $scr);
//
//    $scr = '
//        $("#showall .tab-pane .text-content input[type=checkbox]").change(function ()
//        {
//            var numberOfChecked = $("#showall .tab-pane.active .text-content input:checkbox:checked").length;
//            var totalCheckboxes = $("#showall .tab-pane.active .text-content input[type=checkbox]").length;
//            var numberNotChecked = totalCheckboxes - numberOfChecked;
//            var id = $(this).attr("id");
//            var label=$("label[for="+id+"]").text();
//            if ($(this).prop("checked"))
//            {
//                $("#showall ul li.active a").prepend(\'<i class=\"fa fa-check\"></i>\');
//                $("#showall  #counter").text(parseInt($("#counter").text())+1);
//                $("#showall #labels").append("<label for="+$(this).attr("id")+" class=\'border\'>"+label+"<i class=\"fa fa-times\" aria-hidden=\"true\"></i></label>");
//            }
//            else
//            {
//                $("#showall  #counter").text(parseInt($("#counter").text())-1);
//                $("#showall #labels label[for="+id+"]").remove();
//            }
//            if(numberOfChecked==0)
//            {
//                $("#showall ul li.active a i").remove();
//            }
//            if(numberOfChecked==totalCheckboxes)
//            {
//                $("#showall ul li.active").addClass("checked");
//            }
//            if(numberOfChecked!=totalCheckboxes)
//            {
//                $("#showall ul li.active").removeClass("checked");
//            }
//        });
//
//        $("#label-tab").on("shown.bs.collapse", function ()
//        {
//            $("#showall .tab-content").css("height","340px");
//            var element=$(this).find(".panel-collapse.in");
//            element.parent().addClass("open");
//            element.prev().find("i.fa").removeClass("fa-angle-down").addClass("fa-angle-up");
//        });
//
//        $("#label-tab").on("hidden.bs.collapse", function ()
//        {
//            $("#showall .tab-content").css("height","405px");
//            var element= $(this).find(".panel-collapse").not(".in");
//            element.parent().removeClass("open");
//            element.prev().find("i.fa").removeClass("fa-angle-up").addClass("fa-angle-down");
//        });
//    ';
//
//    $cs->registerScript('checks', $scr);
//
//    if (!isset($url))
//    {
//        $url = '';
//    }
//    if (isset($tree))
//    {
//        $url = trim($tree->findUrlForItem('name', false, $this->root_id), '/');
//    }
//
//    $currency = SettingsCurrencyList::getCurrencyBasic();
//?>
<!---->
<!--<div class="catalog">-->
<!--    <div class="container">-->
<!--        <div class="row">-->
<!--            <div class="col-md-3 side-bar">-->
<?php
//                if ($url == '')
//                {
//                    echo CHtml::link('<span class="fa fa-long-arrow-left"></span> Вернуться в каталог', array('catalog/index'), array('class' => 'btn btn-default col-md-12 back'));
//                }
//                else
//                {
//                    echo CHtml::link('<span class="fa fa-long-arrow-left"></span> Вернуться в категорию', array('catalog/tree', 'url' => $url), array('class' => 'btn btn-default col-md-12 back'));
//                }
//?>
<!--                <div class="col-md-12 widget">-->
<!--                    <div class="title row">-->
<!--                        <div class="caption cat-categories">Категории</div>-->
<!--                    </div>-->
<!--                    <div class="row categories-widget">-->
<?php
//                        $this->widget('bootstrap.widgets.BsNav',
//                            array(
//                                'items' => $menu_items,
//                            )
//                        );
//?>
<!--                    </div>-->
<!--                </div>-->
<?php
//                //параметры фильтрации
//
//                if (empty($trees) and isset($dataProducts) and !empty($params))
//                {
//                    echo CHtml::form($this->createUrl('catalog/tree', array('url' => $url .'/'. $tree->name)), 'get');
//                    foreach ($params as $param)
//                    {
//                        if ($param->type == CatalogParams::TYPE_SELECT)
//                        {
//                            echo
//                                '<div class="col-md-12 widget" >
//                                    <div class="title row" >
//                                        <div class="caption cat-categories">' . $param->title . '</div>
//                                    </div>
//                                    <div class="row body params" >';
//
//                                        $data = array();
//                                        $selected = array();
//
//                                        $values = $param->getValues();
//
//                                        $par_id = $values[0]["params_id"];
//
//                                        if(isset($_GET['m'.$par_id]))
//                                        {
//                                            foreach($_GET['m'.$par_id] as $get_key => $value)
//                                            {
//                                                $selected[] = $value;
//                                            }
//                                        }
//                                        elseif(isset($_GET[$par_id]))
//                                        {
//                                            foreach($_GET[$par_id] as $get_key => $value)
//                                            {
//                                                $selected[] = $value;
//                                            }
//                                        }
//
//                                        foreach ($values as $key => $value)
//                                        {
//                                            if($key == 5)
//                                            {
//                                                break;
//                                            }
//                                            $data[$value->id] = $value->value;
//                                        }
//
//                                        echo CHtml::checkBoxList($param->id, $selected, $data, array('submit' => ''));
//                                echo
//                                    '</div >
//
//                                    <div class="row showall">';
//                                        echo CHtml::link('Показать все', '#', array("data-toggle" => "modal", "data-target" => "#showall"));
//                                echo
//                                    '</div>
//                                </div >';
//                        }
//                    }
//
//                    echo
//                        '<div class="col-md-12 widget">
//                            <div class="title row">
//                                <div class="caption cat-categories">Цена</div>
//                            </div>
//                            <div class="row body price">';
//                                echo '<div class="col-md-6">'.CHtml::label('От', 'price-from').'<br>';
//                                echo CHtml::textField('price-from', isset($_GET['price-from']) ? $_GET['price-from'] : '', array('placeholder' => key($currency))).'</div><div class="dash">-</div>';
//                                echo '<div class="col-md-6">'.CHtml::label('До', 'price-to').'<br>';
//                                echo CHtml::textField('price-to', isset($_GET['price-to']) ? $_GET['price-to'] : '', array('placeholder' => key($currency))).'</div>';
//                    echo
//                            '</div>';
//                    echo CHtml::submitButton(Yii::t("app", "Apply"), array('class' => 'btn btn-success'));
//                    echo
//                            '<div class="clearfix"></div>
//                        </div>';
//                    echo CHtml::endForm();
//                }
//?>
<!---->
<!--            </div>-->
<!--            <div class="col-md-9 categories">-->
<!--                <h1>--><?php //echo $this->pageTitle; ?><!--</h1>-->
<?php
//                //каталоги
//
//                if (isset($trees) and !empty($trees))
//                {
//                    echo
//                        '<div class="slider">
//                            [[w:SliderWidget|id=1;height=320px]]
//                        </div>
//                        <div class="trees row">';
//
//                        if (isset($tree))
//                        {
//                            $url = $tree->findUrlForItem('name', false, $this->root_id) . $tree->name . '/';
//                        }
//
//                        foreach ($trees as $key => $item)
//                        {
//                            $image = $item->getOneFile('small');
//
//                            if (empty($image) or !file_exists($image))
//                            {
//                                $image = Yii::app()->params['noimage'];
//                            }
//
//                            $link = $this->createUrl('catalog/tree', array('url' => $url . $item->name));
//                            echo '<div class="subitem col-md-4 col-xs-12"><div class="sub-block border">';
//                            echo '<div class="image"><a href="' . $link . '" style="background: #fff url(/' . $image . ') center center no-repeat; background-size: contain;"></a></div>';
//                            echo '<div class="title text-left">' . CHtml::link('<b>' . $item->title . '</b>', $link) . '</div>';
//                            echo '</div></div>';
//                        }
//                    echo '</div>';
//                    if (isset($tree))
//                    {
//                        echo '[[w:CarouselProductsWidget|type=popular;count_items=3;category_id=' . $tree->id . ';title=<h2>Популярные товары</h2>]]';
//                    }
//                }
//
//                //товары
//
//                if (empty($trees) and isset($dataProducts))
//                {
//                    $itemView = '';
//                    $typeCatalog = isset(Yii::app()->request->cookies['type_catalog']) ? Yii::app()->request->cookies['type_catalog']->value : '';
//                    $pressRow = '';
//                    $pressTable = '';
//                    $class = '';
//                    $counts = array('10' => '10', '20' => '20', '40' => '40', '50' => '50');
//
//                    switch ($typeCatalog)
//                    {
//                        case 'view-row':
//                            $itemView = '_item_product_row';
//                            $typeCatalog = 'view-row';
//                            $pressRow = ' pressed';
//                            $pressTable = '';
//                            $class = 'col-md-12';
//                            $counts = array('10' => '10', '20' => '20', '40' => '40', '50' => '50');
//                            break;
//                        case 'view-table':
//                            $itemView = '_item_product_table';
//                            $typeCatalog = 'view-table';
//                            $pressTable = ' pressed';
//                            $pressRow = '';
//                            $class = 'row';
//                            $counts = array('9' => '9', '18' => '18', '36' => '36', '54' => '54');
//                            break;
//                        default :
//                            $itemView = '_item_product_row';
//                            $typeCatalog = 'view-row';
//                            $pressRow = ' pressed';
//                            $pressTable = '';
//                            $class = 'col-md-12';
//                            $counts = array('10' => '10','20' => '20','40' => '40','50' => '50');
//                            break;
//                    }
//
//                    $item_count = $dataProducts->getTotalItemCount();
//                    $page_count = ceil($item_count / $count);
//
//                    $this->widget('application.widgets.ProductListView',
//                        array(
//                            'id' => 'products-list',
//                            'htmlOptions' => array(
//                                'class' => $typeCatalog,
//                            ),
//                            'emptyText' => 'В данной категории нет товаров :(',
//                            'typeCatalog' => $typeCatalog,
//                            'itemView' => $itemView,
//                            'dataProvider' => $dataProducts,
//                            'ajaxUpdate' => false,
//                            'counts' => $counts,
//                            'counterCssClass' => 'pull-right counter',
//                            'itemsCssClass' => $typeCatalog.' '.$class.' items',
//                            'template' => "<div class='col-md-12 f-row head-line border text-right'>{mainsorter}<button id='view-table' class='btn btn-default $pressTable'><i class='fa fa-th-large'></i></button><button id='view-row' class='btn btn-default $pressRow'><i class='fa fa-th-list'></i></button></div>{items}\n<div class='col-xs-12 f-row footer-line border'><div class='pull-left'>{pager}</div>{counter}</div>",
//                            'viewData' => array(
//                                'url' => $url,
//                            ),
//                            'pager' => array(
//                                'class' => 'application.widgets.PagerWidget',
//                                'firstPageLabel' => '1',
//                                'prevPageLabel' => '<',
//                                'nextPageLabel' => '>',
//                                'lastPageLabel' => $page_count,
//                            ),
//                        )
//                    );
//                }
//
//                if(!empty($this->seo['title']) and !empty($this->seo['description']))
//                {
//?>
<!--                    <div class="row">-->
<!--                        <div class="col-md-12 seo-block">-->
<!--                            <h2>--><?php //echo $this->seo['title']?><!--</h2>-->
<!--                            --><?php //echo $this->seo['description']?>
<!--                        </div>-->
<!--                    </div>-->
<?php
//                }
//?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div class="modal fade" id="showall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
<!--                <h4 class="modal-title" id="myModalLabel">Настройки фильтрации</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<?php
//                echo CHtml::form($this->createUrl('catalog/tree', array('url' => $url .'/'. $tree->name)), 'get');
//                    $li = '';
//                    $tab = '';
//                    $selected = array();
//
//                    if (empty($trees) and isset($dataProducts) and !empty($params))
//                    {
//                        foreach ($params as $p)
//                        {
//                            $par_array = array();
//                            if ($p->type != CatalogParams::TYPE_TEXT)
//                            {
//                                $par_val = $p->getValues();
//                                if(!empty($par_val))
//                                {
//                                    $par_array = array_combine(CHtml::listData($par_val, 'id', 'id'), $par_val);
//                                }
//
//                                $par_id = isset($par_val[0]) ? $par_val[0]['params_id'] : '';
//
//                                $active = (isset($_GET['m'.$par_id]) || isset($_GET[$par_id])) ? '<i class="fa fa-check"></i>' : '';
//
//                                $li .= '<li class="border-bottom"><a href="#param' . $p->id . '" data-toggle="tab">'.$active . $p->title . '</a></li>';
//                                $data = array();
//
//                                foreach ($par_val as $key => $v)
//                                {
//                                    $data[$v->id] = $v->value;
//
//                                    if(isset($_GET['m'.$par_id]) && !isset($selected['m'.$par_id]))
//                                    {
//                                        foreach($_GET['m'.$par_id] as $get_key => $value)
//                                        {
//                                            if(isset($par_array[$value]->value) && $par_array[$value]->value != '')
//                                            {
//                                                $labels_footer[$par_id][$par_array[$value]->sort - 1] = $par_array[$value]->value;
//                                            }
//
//                                            $selected['m'.$par_id][] = $value;
//                                        }
//                                    }
//                                    elseif(isset($_GET[$par_id]) && !isset($selected['m'.$par_id]))
//                                    {
//                                        foreach($_GET[$par_id] as $get_key => $value)
//                                        {
//                                            if(isset($par_array[$value]->value) && $par_array[$value]->value != '')
//                                            {
//                                                $labels_footer[$par_id][$par_array[$value]->sort - 1] = $par_array[$value]->value;
//                                            }
//
//                                            $selected['m'.$par_id][] = $value;
//                                        }
//                                    }
//                                }
//
//                                $tab .= '<div class="tab-pane" id="param' . $p->id . '"><div class="text-content">' . CHtml::checkBoxList('m' . $p->id, isset($selected['m'.$p->id]) ? $selected['m'.$p->id] : '', $data, array('separator' => '', 'container' => 'div')) . '</div></div>';
//                            }
//                        }
//                    }
//?>
<!--                <div class="col-md-4">-->
<!--                    <ul class="nav row">-->
<!--                        --><?php //echo $li; ?>
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="tab-content col-md-8">-->
<!--                    --><?php //echo $tab; ?>
<!--                </div>-->
<!--                <div class="col-md-8 labels no-padding" role="tablist" id="label-tab">-->
<!--                    <div class="total-count border-bottom text-right">-->
<!--                        <a data-toggle="collapse" href="#labels" class="tab open" aria-expanded="true" aria-controls="collapseOne">Выбрано фильтров (<span id="counter">0</span>) <i class="fa fa-angle-up"></i></a>-->
<!--                    </div>-->
<!--                    <div id="labels" class="panel-collapse collapse b-toggle in" role="tabpanel" aria-labelledby="headingOne">-->
<?php
//                        if(isset($labels_footer))
//                        {
//                            foreach($labels_footer as $key => $value)
//                            {
//                                foreach($value as $k => $v)
//                                {
//                                    echo '<label for="m'.$key.'_'.$k.'" class="border">'.$v.'<i class="fa fa-times" aria-hidden="true"></i></label>';
//                                }
//                            }
//                        }
//?>
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>-->
<!--                <button type="submit" class="btn btn-primary text-uppercase">Применить</button>-->
<!--                --><?php //echo CHtml::endForm() ;?>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<!---->
<!---->
<!---->
<!---->
<!---->
