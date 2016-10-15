<div id="product_review_container" class="col-xs-12">
<?php
    $header_review  =
    '<div class="buttons_group">
        <div class="btn-group checkbox">
            <button type="button" class="btn checkbox-action">-</button>
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#modal_moderate" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В обработке</a></li>
                <li><a href="#modal_answer" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Ответили</a></li>
                <li><a href="#modal_delete" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Удалить</a></li>
            </ul>
        </div>
    </div>';

    $header_review .= $this->UrlTopPagination($count_item);

    $reviews_sortable = '
        $(".items ul").nestedSortable(
        {
            items: "li",
            listType: "ul",
            tabSize : 15,
            maxLevels: 0,

            update:function(event, ui)
            {
                $.ajax(
                {
                    type: "POST",
                    url: "'.$this->createUrl("reviews_sort").'",
                    data:
                    {
                        id: $(ui.item).attr("id"),
                        index: $(ui.item).index(),
                    },
                });
            }
        });
    ';

    $cs = Yii::app()->getClientScript();
    $cs->registerScript("reviews_sortable", $reviews_sortable);

    $typeCatalog = 'small review-item';

    $this->widget('application.widgets.ProductListViewAdmin',
        array(
            'id' => 'products-list',
            'htmlOptions' => array(
                'class' => $typeCatalog,
            ),
            'typeCatalog' => $typeCatalog,
            'itemView' => '_review_one_for_list',
            'emptyText' => '"Отзывы - отсутствуют!"',
            'dataProvider' => $products_review,
            'ajaxUpdate' => false,
            'template' => $header_review."{counter}\n{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center pager-item\">{pager}</div></div>",
            'pager' => array(
                'class' => 'bootstrap.widgets.BsPager',
                'firstPageLabel' => '<<',
                'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
                'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
                'lastPageLabel' => '>>',
                'hideFirstAndLast' => true,
            ),
            'counter' => $count_item,
        )
    );
?>
</div>