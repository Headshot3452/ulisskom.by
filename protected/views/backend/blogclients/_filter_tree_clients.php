<?php
$this->header .=  '<div class="client-blog-spisok">Список клиентов</div>';

$this->header .= $this->UrlTopPagination($count_item, 'Users');

$this->header .=  '<div class="row title-feedback client-blog-title">
                <div class="col-xs-1">
                    <div class="buttons_group spisok-question">
                        <div class="btn-group checkbox">
                            <button type="button" class="btn checkbox-action">-</button>
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#modal_answer" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Добавить заказ</a></li>
                                <li><a href="#modal_new" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Отправить сообщение</a></li>
                                <li><a href="#modal_archive" role="button" data-toggle="modal" rel="javascript" class="remove-ip action-ip">Заблокировать</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xs-5">
                    <span>Клиент</span>
                </div>
                <div class="col-xs-2">
                    <span>Рейтинг</span>
                </div>
                <div class="col-xs-1 posts">
                    <span>Постов</span>
                </div>
                <div class="col-xs-2 comments">
                    <span>Комментариев</span>
                </div>
                <div class="col-xs-1 status">
                    <span>Статус</span>
                </div>
            </div>';

$tree_id="
    $('.dropdown.tree-blog li a').on('click', function(){
        var value = $(this).attr('id');

        $('.dropdown.tree-blog button').html($(this).html()+'<span class=\"caret\"></span>');
        $('.dropdown.tree-blog button i').css('color', '#0849e1');

        if(value!='')
            $('input#tree_id').val(value);
        else
            $('input#tree_id').val('');
    });

    $('.dropdown.tree-blog li a').hover(function(){
        $(this).find('i').css('color', '#fff');
    },
    function(){
        $(this).find('i').css('color', '#0849e1');
    });
";

$cs=Yii::app()->getClientScript();
$cs->registerPackage('jquery')->registerScript('tree_id',$tree_id);

?>