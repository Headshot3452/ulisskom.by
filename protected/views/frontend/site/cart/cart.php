<div class="form col-md-12">
    <div class="table-responsive">
        <?php echo $model->cart ;?>
    </div>
    <div class="row">
        <div class="table-responsive col-md-5">
            <table class="table table-hover border-bottom all">
                <tr>
                    <td class="gray-color">Всего товаров:</td>
                    <td class="count-product">12</td>
                </tr>
                <tr>
                    <td class="gray-color">Доставка:</td>
                    <td>0 <span class="gray-color text-uppercase">Byr</span></td>
                </tr>
                <tr>
                    <td class="gray-color">Скидка:</td>
                    <td><span class="red-color sale-product">0</span> <span class="gray-color text-uppercase">Byr</span></td>
                </tr>
                <tr>
                    <td class="gray-color">Общая сумма:</td>
                    <td class="result-sum"><b class="total-price">1 123.00</b> <span class="gray-color text-uppercase">Byr</span></td>
                </tr>
            </table>
            <div class="no-padding col-md-12">
                <a href="/cartInfo" class="btn btn-primary pull-left">Оформить заказ</a>
                <a href="/" class="btn btn-default pull-right">Отмена</a>
            </div>
        </div>
        <div class="col-md-7 other-links">
            <a class="pull-right clear-cart" href="#">
                <span class="fa fa-trash"></span> Очистить корзину
            </a>
        </div>
    </div>
</div>
