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
    'id' => 'modal_archive',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "В архив",
    'content' => "Вы действительно хотите сменить статус ?",
    'footer'  => '<button type="button" data-status="'.Feedback::STATUS_ARCHIVE.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
        <button type="button" class="">Отмена</button>',
));


$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_answer',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Ответили",
    'content' => "Вы действительно хотите сменить статус ?",
    'footer'  => '<button type="button" data-status="'.Feedback::STATUS_ANSWER.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
        <button type="button" class="">Отмена</button>',
));

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_new',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Новый",
    'content' => "Вы действительно хотите сменить статус ?",
    'footer'  => '<button type="button" data-status="'.Feedback::STATUS_NEW.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
        <button type="button" class="">Отмена</button>',
));

$this->widget('ext.bootstrap.widgets.BsModal', array(
    'id' => 'modal_delete',
    'htmlOptions'=>array(
        'class'=>'modal'
    ),
    'header'  => "Удалить",
    'content' => "Вы действительно хотите удалить?",
    'footer'  => '<button type="button" data-status="'.Feedback::STATUS_DELETED.'" class="btn btn-danger delete" data-dismiss="modal">Удалить</button>
        <button type="button" class="">Отмена</button>',
));
?>
