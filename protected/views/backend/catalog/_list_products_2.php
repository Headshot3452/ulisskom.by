<?php
    /* @var $this CatalogProductsController */
    /* @var $model CatalogProducts */

    $header  = '<div class="buttons_group">';
    $header .= '<div class="btn-group checkbox">
                    <button type="button" class="btn checkbox-action">-</button>
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#modal_active" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Показать</a></li>
                        <li><a href="#modal_not_active" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Скрыть</a></li>
                        <li><a href="#modal_delete" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Удалить</a></li>
                    </ul>
                </div>';
    $header .= '<a data-placement="bottom" title="Добавить товар" href="'.$this->createUrl('create_product').'?tree_id='.$category_id.'" class="btn btn-action"><span class="icon-admin-add-product"></span></a>';
    $header .= '<a data-placement="bottom" title="Копировать товар" href="#modal_copy_products" role="button" data-toggle="modal" style="display: none;" class="btn btn-action copy_products"><span class="icon-admin-copy-product"></span></a>';
    $header .= '<a data-placement="bottom" title="Переместить товар" href="#modal_copy_products" role="button" data-toggle="modal" style="display: none;" class="btn btn-action move_products"><span class="icon-admin-move-product"></span></a>';

    $header .= $this->UrlTopPagination($count_item);

    $header .= '</div>';

    $header_popovers = ' $(".buttons_group .btn-action").tooltip();';
    $cs=Yii::app()->getClientScript();
    $cs->registerScript("header_popovers", $header_popovers);

    if(!$sorter)
    {
        $order = 'parent_id';
    }
    else
    {
        switch($sorter)
        {
            case 'price_asc':
                $order = 'price';
                break;
            case 'price_desc':
                $order = 'price DESC';
                break;
            case 'title_asc':
                $order = 't.`title`';
                break;
            case 'title_desc':
                $order = 't.`title` DESC';
                break;
            case 'sort_asc':
                $order = 'parent_id, t.`sort`';
                break;
            default:
                $order = 'parent_id';
                break;
        }
    }

    $dataProducts = $model->language($this->getCurrentLanguage()->id)->search($count, $order);

    $typeCatalog = 'small';

    $products_sortable = '
        $("#products-list ul").nestedSortable(
        {
            items: "li",
            listType: "ul",
            tabSize : 15,
            maxLevels: 0,

            update:function( event, ui )
            {
                $.ajax(
                {
                    type:"POST",
                    url:"'.$this->createUrl("products_sort").'",
                    data:{
                            id:$(ui.item).attr("id"),
                            index:$(ui.item).index(),
                    },
                    success: function(data)
                    {

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
                'class' => $typeCatalog
            ),
            'emptyText' => Yii::t('app', 'There are no products'),
            'typeCatalog' => $typeCatalog,
            'itemView' => '_product_one_for_list',
            'dataProvider' => $dataProducts,
            'ajaxUpdate' => false,
            'template' => $header."{counter}\n{mainSorter}\n{mainItems}\n<div class=\"row\"><div class=\"col-xs-12 text-center\">{pager}</div></div>",
            'pager' => array(
                'class' => 'bootstrap.widgets.BsPager',
                'firstPageLabel' => '<<',
                'prevPageLabel' => '<',
                'nextPageLabel' => '>',
                'lastPageLabel' => '>>',
                'hideFirstAndLast' => true,
            ),
            'counter' => $count,
            'sorter' => $sorter
        )
    );

    $this->renderPartial('_modal_windows');
?>

<form method="POST" class="copy" data-module="catalog">

</form>