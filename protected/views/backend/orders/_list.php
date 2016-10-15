<?php
    $item_count = $dataProvider->getTotalItemCount();

    $pages = new CPagination($item_count);
    $page_size = $count;
    $pages->setPageSize($page_size);
    $page_count = ceil($item_count / $page_size);

    $total = 0;

    $array = $dataProvider->getData();
    foreach($array as $val)
    {
        $total += $val['sum'];
    }

    $formatter = new CFormatter;
    $formatter->numberFormat = array('decimals' => '2', 'decimalSeparator'=>'.', 'thousandSeparator' => ' ');

    $total = $formatter->number($total); //сумма заказа
?>

<div class="row orders-info">
    <h4 class="col-md-2">Список заказов</h4>

    <div class="col-md-1"><a class="color-primary underline archive" href="#">Архив</a></div>
    <div class="col-md-6 all-info">
        <span class="count-orders">
        <span class="color-gray">Количество заказов:</span> <?php echo $item_count;?>
        </span>
        <span>
        <span class="color-gray">На сумму:</span> <span class="color-primary"><?php echo $total ;?></span> <span class="text-uppercase">Byr</span>
        </span>
    </div>
    <div class="col-md-2 pag-cont">
<?php
        if ($page_count > 1)
        {
            echo
            '<ul class="pagination">
                <li><a href="" id="left_page"><i class="fa fa-angle-left"></i>
                    </a>
                </li>';

                $this->widget('CListPager',
                    array(
                        'currentPage' => (Yii::app()->request->getParam('page') - 1),
                        'itemCount' => $item_count,
                        'pageSize' => $page_size,
                        'header' => '',
                        'htmlOptions' => array(
                            'class' => ''
                        )
                    )
                );

            echo
                '<li>
                    <a href="" id="right_page">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </li>
            </ul>';
        }

    $header =
    '</div>
</div>
    <div class="col-md-1 counter-orders">';

        $header1 = '</div>
</div>
<div class="row">
    <table class="table table-striped table-hover order-list">
        <thead>
        <tr class="color-gray">
            <th class="">№ заказа</th>
            <th class="text-center">Дата</th>
            <th>Клиент</th>
            <th class="text-right">Товар-услуга / сумма</th>
            <th>Менеджер / Комплектовщик / Исполнитель</th>
            <th class="col-md-2 col-info">Статус</th>
        </tr>
        </thead>
        <tbody>';

        $this->widget('application.widgets.ProductListViewAdmin',
            array(
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'template' => $header . '{counterUsers}' . $header1 . '{items}</tbody></table><div class="row"><div class="col-xs-12 text-center">{pager}</div></div>',
                'pager' => array(
                    'class' => 'bootstrap.widgets.BsPager',
                    'firstPageLabel' => '<<',
                    'prevPageLabel' => '<',
                    'nextPageLabel' => '>',
                    'lastPageLabel' => '>>',
                    'hideFirstAndLast' => true,
                ),
                'counter' => $count,
            )
        );

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_status',
            'htmlOptions' => array(
                'class'=>'modal'
            ),
            'header'  => "Смена статуса",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_MODERATE.'" new-status="0" order="0" class="btn btn-danger change_status">Изменить</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>',
        )
    );
?>
    </div>
<?php
    $cs = Yii::app()->getClientScript();

    $cs->registerScript('orderslist', '
        $(function ()
        {
            $(\'[data-toggle="tooltip"]\').tooltip()
        })
    ');

    $cs->registerScript('changestatus',

        '$("#modal_status .change_status").on("click", function()
        {
            var id = $(this).attr("order");
            var status = $(this).attr("new-status");

            $.ajax(
            {
                type: "POST",
                url: "' . $this->createUrl('changeStatus') . '?id="+id+"&status="+status,
                success: function(msg)
                {
                    window.location.reload();
                }
            });
            return false;
        });
    ');
?>

<script>
    $(function ()
    {
        $('#left_page').on('click', function ()
        {
            if ($(this).find('.fa-angle-left').length && <?php echo $pages->currentPage ;?> != 0)
            {
                location.href = $(".pagination.pagination-sm li").eq(0).find('a').attr('href');
            }
            if ($(this).find('.fa-angle-right').length && <?php echo $pages->currentPage .' < '.$page_size;?>)
            {
                location.href = $(".pagination.pagination-sm li:last").find('a').attr('href');
            }
            return false;
        });

        $('#right_page').on('click', function ()
        {
            if ($(this).find('.fa-angle-right').length && <?php echo $pages->currentPage + 1 .' < '.$page_size ;?>)
            {
                location.href = $(".pagination.pagination-sm li:last").find('a').attr('href');
            }
            return false;
        });
    });
</script>