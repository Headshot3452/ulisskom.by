<?php
$cs = Yii::app()->getClientScript();
$header_popovers = '
    $(".status span.active").tooltip();
    ';
$cs->registerScript("header_popovers", $header_popovers);
?>
<div class="order">
    <div class="row title-one-order flex-center">
        <div class="col-md-4 flex-center">
            <a class="btn btn-default" href="/profileorder/index"><span class="fa fa-chevron-left"></span></a>

            <h2><?php echo Yii::t('app','Order')?> #123</h2>
        </div>
        <div class="col-md-8 all-sum text-right">
                <span class="fa-stack gray-color" title="К оплате" data-toggle="tooltip" data-placement="top">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-usd fa-stack-1x fa-inverse"></span>
                </span>
            <span class="sum primary-color"><b>12 123 123</b></span> <span
                class="currency text-uppercase">BYR</span></div>
    </div>
    <div class="clearfix"></div>
    <div class="row order-info">
        <h5 class="text-uppercase col-md-12 gray-color"><?php echo Yii::t('app','Process Order Processing')?></h5>

        <div class="col-md-4">
            <label class="gray-color"><?php echo Yii::t('app','Order status')?></label>

            <div class="status">
                <span class="fa fa-plus-circle gray-color fa-2x" title="Принят" data-toggle="tooltip" data-placement="top"></span>
                    <span class="process fa-stack fa-lg gray-color active" title="В обработке" data-toggle="tooltip" data-placement="top">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-refresh fa-stack-1x fa-inverse"></span>
                    </span>
                    <span class="cart fa-stack fa-lg gray-color" title="На комплектации" data-toggle="tooltip" data-placement="top">
                         <span class="fa fa-circle fa-stack-2x"></span>
                         <span class="fa fa-cart-arrow-down fa-stack-1x fa-inverse"></span>
                    </span>
                    <span class="plane fa-stack fa-lg gray-color" title="В процессе доставки" data-toggle="tooltip" data-placement="top">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-plane fa-stack-1x fa-inverse"></span>
                    </span>
                <span class="fa fa-check-circle fa-2x gray-color" title="Заказ выполнен" data-toggle="tooltip"
                      data-placement="top"></span>
            </div>
        </div>
        <div class="col-md-4">
            <label class="gray-color"><?php echo Yii::t('app','Delivery date')?></label>

            <div>12.12.1212, 12:12 - 12:12</div>
        </div>
        <div class="col-md-4">
            <label class="gray-color"><?php echo Yii::t('app','Rate order')?></label>

            <div>
                <span class="fa-stack gray-color">
                        <span class="fa fa-circle fa-stack-2x"></span>
                        <span class="fa fa-star fa-stack-1x fa-inverse"></span>
                </span>
                <a href="/profileorder/estimate"><?php echo Yii::t('app','Rate order')?></a>

<!--                    Позитивная-->
<!--                    <span class="smile fa-stack fa-lg green-color">-->
<!--                        <span class="fa fa-circle fa-stack-2x"></span>-->
<!--                        <span class="fa fa-smile-o fa-stack-1x fa-inverse"></span>-->
<!--                    </span>-->
<!--                    Негативная-->
<!--                    <span class="smile fa-stack fa-lg red-color">-->
<!--                        <span class="fa fa-circle fa-stack-2x"></span>-->
<!--                        <span class="fa fa-frown-o fa-stack-1x fa-inverse"></span>-->
<!--                    </span>-->
<!--                    Нейтральная-->
<!--                    <span class="smile fa-stack fa-lg gray-color">-->
<!--                        <span class="fa fa-circle fa-stack-2x"></span>-->
<!--                        <span class="fa fa-meh-o fa-stack-1x fa-inverse"></span>-->
<!--                    </span>-->
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row orders">
        <div class="col-md-12">
            <table class="table table-hover products border-bottom">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Вид</th>
                    <th>Наименование товара</th>
                    <th>Цена / Скидка</th>
                    <th>Кол-во</th>
                    <th>Сумма</th>
                </tr>
                </thead>
                <tbody>
                <?php
                for ($i = 0; $i <= 5; $i++) {
                    $this->renderPartial('_one-product');
                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4 pull-right">
            <table  class="table table-hover summary border-bottom">
                <tbody>
                <tr>
                    <td><?php echo Yii::t('app','Total products')?>:</td>
                    <td>123</td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app','Delivery')?>:</td>
                    <td>0 <span class="text-uppercase">Byr</span></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app','Discount')?>:</td>
                    <td class="red-color">-123 123 <span class="text-uppercase">Byr</span></td>
                </tr>
                <tr>
                    <td><?php echo Yii::t('app','Total amount')?>:</td>
                    <td><b class="primary-color">123 123 123</b> <span class="text-uppercase">Byr</span></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>