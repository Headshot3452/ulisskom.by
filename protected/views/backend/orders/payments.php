<?php
    $item_count = $dataProvider->getTotalItemCount();
    $pages = new CPagination($item_count);
    $page_size = $count;
    $pages->setPageSize($page_size);
    $page_count = ceil($item_count / $page_size);
    $formatter = new CFormatter;
    $formatter->numberFormat = array('decimals' => '2', 'decimalSeparator'=>'.', 'thousandSeparator' => ' ');
?>
    <div class="row orders-info">
        <h4 class="col-md-2">Платежи</h4>

        <div class="col-md-2 col-md-offset-7 pag-cont">
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
    $header1 =
    '</div>
</div>
<div class="row">
    <table class="table table-striped table-hover order-list">
        <thead>
        <tr class="color-gray">
            <th class="text-center">Дата</th>
            <th class="col-md-5">Платежная система</th>
            <th class="text-left">#Заказа / IDT</th>
            <th class="text-left">Статус</th>
            <th class="text-right">Сумма</th>
        </tr>
        </thead>
        <tbody>';

            $this->widget('application.widgets.ProductListViewAdmin',
                array(
                    'dataProvider' => $dataProvider,
                    'itemView' => '_payment_item',
                    'template' => $header . '{counterUsers} '. $header1 .'{items}</tbody></table><div class="row"><div class="col-xs-12 text-center">{pager}</div></div>',
                    'pager' => array(
                        'class' => 'application.widgets.PagerWidget',
                        'nextPageLabel' => '&raquo;',
                        'firstPageLabel' => '1',
                        'lastPageLabel' => $page_count,
                        'prevPageLabel' => '&laquo;',
                        'hideFirstAndLast' => false,
                    ),
                )
            );
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