<?php

ob_start();

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_archive',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "В архив",
    'content' => "Вы действительно хотите сменить статус ?",
    'footer'  => '<button type="button" data-status="'.Blog::STATUS_ARCHIVE.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
        <button type="button" class="">Отмена</button>',
));


$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_answer',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "На модерации",
    'content' => "Вы действительно хотите сменить статус ?",
    'footer'  => '<button type="button" data-status="'.Blog::STATUS_MODERETION.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
        <button type="button" class="">Отмена</button>',
));

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_new',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Разместить",
    'content' => "Вы действительно хотите сменить статус ?",
    'footer'  => '<button type="button" data-status="'.Blog::STATUS_PLACEMENT.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
        <button type="button" class="">Отмена</button>',
));

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_delete',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Удалить",
    'content' => "Вы действительно хотите удалить?",
    'footer'  => '<button type="button" data-status="'.Blog::STATUS_DELETED.'" class="btn btn-danger delete" data-dismiss="modal">Удалить</button>
        <button type="button" class="">Отмена</button>',
));
?>
