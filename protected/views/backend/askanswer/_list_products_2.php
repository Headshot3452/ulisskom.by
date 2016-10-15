<?php
    /* @var $this CatalogProductsController */
    /* @var $model CatalogProducts */

    $header  =
    '<div class="buttons_group">
        <div class="btn-group checkbox">
            <button type="button" class="btn checkbox-action">-</button>
            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#modal_active" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Отобразить на сайте</a></li>
                <li><a href="#modal_not_active" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Скрыть на сайте</a></li>
                <li><a href="#modal_delete" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Удалить</a></li>
            </ul>
        </div>';

    if($category_id != AskAnswerTree::model()->find('name=:name', array(':name'=>'root'))->id)
    {
        $header .= '<a data-placement="bottom" title="Добавить вопрос" href="'.$this->createUrl('create_product').'?tree_id='.$category_id.'" class="btn btn-action"><span class="icon-admin-add-product"></span></a>';
    }

    $header .= '<a data-placement="bottom" title="Копировать вопрос" href="#modal_copy_products" role="button" data-toggle="modal" class="btn btn-action copy_products" style="display:none;"><span class="icon-admin-copy-product"></span></a>';
    $header .= '<a data-placement="bottom" title="Переместить вопрос" href="#modal_copy_products" role="button" data-toggle="modal" class="btn btn-action move_products" style="display:none;"><span class="icon-admin-move-product"></span></a>';

    $header .= '</div>';

    $header .= $this->UrlTopPagination($count_item);

    $header_popovers = ' $(".buttons_group .btn-action").tooltip();';
    $cs = Yii::app()->getClientScript();
    $cs->registerScript("header_popovers", $header_popovers);

    $typeCatalog = 'small askanswer-item';

    $products_sortable = '
        $(".items ul").nestedSortable(
        {
            items: "li",
            listType: "ul",
            tabSize : 15,
            maxLevels: 0,

            update:function( event, ui )
            {
                $.ajax(
                {
                    type: "POST",
                    url: "'.$this->createUrl("products_sort").'",
                    data:
                    {
                        id: $(ui.item).attr("id"),
                        index: $(ui.item).index(),
                    }
                });
            }
        });
    ';

    $cs->registerScript("products_sortable", $products_sortable);

    $this->widget('application.widgets.ProductListViewAdmin',
        array(
            'id' => 'products-list',
            'htmlOptions' => array(
                'class' => $typeCatalog,
            ),
            'typeCatalog' => $typeCatalog,
            'itemView' => '_product_one_for_list',
            'emptyText' => ' "Вопросы ответы - отсутствуют!"',
            'dataProvider' => $dataProducts,
            'ajaxUpdate' => false,
            'template' => $header."{counter}\n{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center pager-item\">{pager}</div></div>",
            'pager' => array(
                'class' => 'bootstrap.widgets.BsPager',
                'firstPageLabel' => '<<',
                'prevPageLabel' => '<i class="fa fa-angle-left fa-lg"></i>',
                'nextPageLabel' => '<i class="fa fa-angle-right fa-lg"></i>',
                'lastPageLabel' => '>>',
                'hideFirstAndLast'=>true,
            ),
            'counter' => $count,
        )
    );

    $this->renderPartial('_modal_windows');
?>

<form method="POST" class="copy" data-module="askanswer">

</form>