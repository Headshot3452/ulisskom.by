<div class="frontend_review_list">
    <div class="container">
        <div class='row'>
            <div class="col-md-8">
                <h1>
                    Отзывы
                </h1>
                <?php
                $typeCatalog = 'small';
                $item_count = $model->getTotalItemCount();
                $pages = new CPagination($item_count);
                $page_size = $count;
                $pages->setPageSize($page_size);
                $page_count = ceil($item_count / $page_size);

                $this->widget('application.widgets.ProductListViewAdmin', array(
                        'id' => 'products-list',
                        'itemsTagName'=>'ul',
                        'itemsCssClass'=>'list-unstyled',
                        'emptyText'=>'<h4 class="text-center">Пока нет ни одного отзыва.</h4>',
                        'htmlOptions' => array(
                            'class' => $typeCatalog . ' reviews-list'
                        ),
                        'typeCatalog' => $typeCatalog,
                        'itemView' => '_one_review',
                        'dataProvider' => $model,
                        'ajaxUpdate' => false,
                        'template' => "<div class='items'>{mainItems}</div><div class=\"text-left\">{pager}</div>",
                        'pager' => array(
                            'class' => 'application.widgets.PagerWidget',
//                            изменила виджет
                            'firstPageLabel' => '1',
                            'prevPageLabel' => '<',
                            'nextPageLabel' => '>',
                            'lastPageLabel' => $page_count,
//                'hideFirstAndLast'=>true,
                        ),
                        'counter' => $count,
                    )
                ); ?>
            </div>

            <div class="col-md-4 side-bar">

                <div class="col-md-12 widget">
                    <div class="title row">
                        <h4>Информация</h4>
                    </div>
                    <div class="row menu-widget">
                        [[w:MenuWidget|id=5]]
                    </div>
                </div>

                <div class="col-md-12 widget">
                    [[w:ReviewWidget]]
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(function () {
        $('#left_page').on('click', function () {
            if ($(this).find('.fa-angle-left').length && <?php echo $pages->currentPage ;?> != 0) {
                location.href = $(".pagination.pagination-sm li").eq(0).find('a').attr('href');
            }
            if ($(this).find('.fa-angle-right').length && <?php echo $pages->currentPage .' < '.$page_size;?>) {
                location.href = $(".pagination.pagination-sm li:last").find('a').attr('href');
            }
            return false;
        });

        $('#right_page').on('click', function () {
            if ($(this).find('.fa-angle-right').length && <?php echo $pages->currentPage + 1 .' < '.$page_size ;?>) {
                location.href = $(".pagination.pagination-sm li:last").find('a').attr('href');
            }
            return false;
        });
    });
</script>