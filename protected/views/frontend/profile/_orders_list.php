<div class="orders-list">
    <div class="row header">
        <div class="col-xs-1">№ заказа</div>
        <div class="col-xs-2">Осталось</div>
        <div class="col-xs-1">Кол-во</div>
        <div class="col-xs-2">Итоговая сумма</div>
        <div class="col-xs-3">Время доставки</div>
        <div class="col-xs-3">Статус</div>
    </div>
    <?php

    $this->widget('bootstrap.widgets.BsListView',array(
        'dataProvider'=>$orders,
        'emptyText'=>'За этот период у Вас нет заказов',
        'itemView'=>'_order_item',
        'template'=>"{items}\n<div class=\"row\"><div class=\"col-xs-12 text-center\">{pager}</div></div>",
        'ajaxUpdate'=>false,
        'pager'=>array(
            'class'=>'bootstrap.widgets.BsPager',
            'nextPageLabel'=>'&raquo;',
            'prevPageLabel'=>'&laquo;',
            'hideFirstAndLast'=>true,
        ),
    ));
    ?>
    <div class="clearfix"></div>
</div>