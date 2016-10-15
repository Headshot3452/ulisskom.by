<?php

ob_start();
$this->widget('system.web.widgets.CTreeView', array(
    'data'=>$this->getLeftMenuModal(),
    'id'=>'modal_tree'
));
$content = ob_get_contents();
ob_clean();

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_copy_products',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Выбор папки",
    'content' => $content,
));



$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_delete',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Удаление товара",
    'content' => "Вы действительно хотите удалить товар ?",
    'footer'  => '<button type="button" data-status="'.GalleryImages::STATUS_DELETED.'" class="btn btn-danger delete" data-dismiss="modal">Удалить</button>
        <button type="button" class="">Отмена</button>',
));


$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_not_active',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Скрытие товаров",
    'content' => "Вы действительно хотите скрыть товары ?",
    'footer'  => '<button type="button" data-status="'.GalleryImages::STATUS_NOT_ACTIVE.'" class="btn btn-danger change_status" data-dismiss="modal">Скрыть</button>
        <button type="button" class="">Отмена</button>',
));

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_active',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Показ товаров",
    'content' => "Вы действительно хотите показать товары ?",
    'footer'  => '<button type="button" data-status="'.GalleryImages::STATUS_OK.'" class="btn btn-danger change_status" data-dismiss="modal">Показать</button>
        <button type="button" class="">Отмена</button>',
));
?>
