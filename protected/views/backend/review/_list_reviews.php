<div class="review_list items">

<?php
    if($status!=ReviewItem::STATUS_ARCHIVE)
    {
        $title =
            '<div class="title col-xs-3">Список отзывов темы</div>
                <div class="col-xs-5 no-padding">'.
                    CHtml::dropDownList('theme', $theme, ReviewThemesTree::getAllTreeFilter(),array('empty'=>'Все темы отзывов'))
                .'</div>';
    }
    else
    {
        $title = '<div class="title col-xs-8">Архив</div>';
    }

    $cs = Yii::app()->getClientScript();
    $themes = '
        $("body").on("change","#theme",function()
        {
            $.cookie("theme",$(this).val(),{expires: 3600, path: "/"});
            window.location.reload();
        });
    ';

    $cs->registerPackage("cookie")->registerScript('themes', $themes);
    $table =
        '<div class="row">
            <div class="buttons_group col-xs-1">
            <div class="btn-group checkbox">
                <button type="button" class="btn checkbox-action">-</button>
                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#modal_moderate" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В обработке</a></li>
                    <li><a href="#modal_answer" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Ответили</a></li>
                    <li><a href="#modal_archive" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В архив</a></li>
                    <li><a href="#modal_delete" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Удалить</a></li>
                </ul>
            </div>
        </div>'.
        $title
        .'</div>

            <div class="list-title row">
                <div class="col-xs-1 text-center">#/Дата</div>
                <div class="col-xs-3 no-padding">Клиент</div>
                <div class="col-xs-2">Тема</div>
                <div class="col-xs-6">Вопрос</div>
            </div>
        <div class="row">
            <ul id="table-review">';
    $typeCatalog = 'small';
    $item_count = $model->getTotalItemCount();
    $pages = new CPagination($item_count);
    $page_size = $count;
    $pages->setPageSize($page_size);
    $page_count = ceil($item_count / $page_size);
    if ($page_count > 1) {
        echo
        '<div class="pag-cont">
                <ul class="pagination">
                    <li><a href="" id="left_page"><i class="fa fa-angle-left"></i>
                        </a>
                    </li>';

        $this->widget('CListPager', array(
                'currentPage' => $pages->currentPage,
                'itemCount' => $item_count,
                'pageSize' => $page_size,
                'header' => '',
                'htmlOptions' => array(
                    'class' => 'selectpicker'
                )
            )
        );
        echo
        '<li>
                        <a href="" id="right_page">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>';
    }

    $archive = $status != ReviewItem::STATUS_ARCHIVE ? "<a href='?status=".ReviewItem::STATUS_ARCHIVE."' class='btn btn-gray archive'>Архив</a>":"<a href='".$this->createUrl('review/index')."' class='btn btn-default archive'>Назад</a>";

    $this->widget('application.widgets.ProductListViewAdmin', array(
            'id' => 'products-list',
            'htmlOptions' => array(
                'class' => $typeCatalog . ' reviews-list'
            ),
            'typeCatalog' => $typeCatalog,
            'itemView' => '_one_review',
            'dataProvider' => $model,
            'ajaxUpdate' => false,
            'template' => "{CounterUsers}" . $table . "{mainItems}\n</ul>$archive</div><div class='row text-center'>{pager}</div>",
            'pager' => array(
                'class' => 'bootstrap.widgets.BsPager',
                'firstPageLabel' => '1',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'lastPageLabel' => $page_count,
            ),
            'counter' => $count,
        )
    );
    $this->renderPartial('_modal_windows'); ?>
</div>

<form method="POST" class="copy" data-module="review">

</form>

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