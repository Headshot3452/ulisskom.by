<div class="container cart">
    <div class="row main-title flex-baseline">
        <h1 class="col-md-4"><?php echo $this->getPageTitle(); ?></h1>
        <div class="col-md-4 text-right"><span class="gray-color">Всего товаров:</span> <b class="count-product">0</b></div>
        <div class="col-md-4 text-right"><span class="gray-color">Общая сумма:</span> <b class="total-price">0</b> <span
                class="text-uppercase gray-color">Byr</span></div>
    </div>
    <div class="row">
        <div class="text">
<?php
            echo $content;
?>
        </div>
    </div>
</div>