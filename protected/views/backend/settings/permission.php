<div class="user_list">
    <h2 class="title">Список пользователей <a href=""> Архив</a> </h2>
    <a href="/admin/<?php echo CHtml::normalizeUrl('settings/register') ;?>" id="add_user">Добавить нового пользователя</a>
<?php
    $table =
        '<table id="table-sotrudniki" class="table table-hover items">
            <thead>
                <tr>
                    <td>
                        <div class="btn-group checkbox">
                            <button type="button" class="btn checkbox-action">-</button>
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#modal_active" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Показать</a></li>
                                <li><a href="#modal_not_active" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Скрыть</a></li>
                                <li><a href="#modal_delete" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Удалить</a></li>
                                <li><a href="#modal_archiv" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">В архив</a></li>
                            </ul>
                        </div>
                    </td>
                    <td>Сотрудник</td>
                    <td>Создание / редактирование</td>
                    <td>Права доступа</td>
                    <td>Статус</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>';

    $typeCatalog = 'small';
    $item_count = $model->getTotalItemCount();
    $pages = new CPagination($item_count);
    $page_size =  $count;
    $pages->setPageSize($page_size);
    $page_count = ceil($item_count/$page_size);
    if($page_count > 1)
    {
        echo
            '<div class="pag-cont">
                <ul class="pagination">
                    <li><a href="" id="left_page"><i class="fa fa-angle-left"></i>
                        </a>
                    </li>';

                    $this->widget('CListPager',
                        array(
                            'currentPage' => $pages->getCurrentPage(),
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

    $this->widget('application.widgets.ProductListViewAdmin', array(
        'id' => 'users-list',
            'htmlOptions'=>array(
                'class'=>$typeCatalog
            ),
            'typeCatalog'=>$typeCatalog,
            'itemView' => '_list_users',
            'dataProvider' => $model,
            'ajaxUpdate' => false,
            'emptyText' => '',
            'template' => "{CounterUsers}".$table."{mainItems}\n</tbody></table><div class=\"row\"><div class=\"col-md-5 col-md-offset-3 col-lg-5 col-lg-offset-3\">{pager}</div></div>",
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

    $this->renderPartial('_modal_windows');
?>
</div>

<form method="POST" class="copy" data-module="users">

</form>

<script>

    $(function()
    {
        $('#left_page').on('click', function()
        {
            if($(this).find('.fa-angle-left').length && <?php echo $pages->currentPage ;?> != 0)
            {
                location.href = $(".pagination.pagination-sm li").eq(0).find('a').attr('href');
            }
            if($(this).find('.fa-angle-right').length && <?php echo $pages->currentPage .' < '.$page_size;?>)
            {
                location.href = $(".pagination.pagination-sm li:last").find('a').attr('href');
            }
            return false;
        });

        $('#right_page').on('click', function()
        {
            if($(this).find('.fa-angle-right').length && <?php echo $pages->currentPage + 1 .' < '.$page_size ;?>)
            {
                location.href = $(".pagination.pagination-sm li:last").find('a').attr('href');
            }
            return false;
        });
    });

</script>