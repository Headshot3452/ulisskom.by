<?php
    $this->widget('ext.bootstrap.widgets.BsModal', array(
        'id' => 'modal_delete',
        'htmlOptions'=>array(
            'class'=>'modal'
        ),
        'header'  => "Удаление пользователей",
        'content' => "Вы действительно хотите удалить пользователей ?",
        'footer'  => '<button type="button" data-status="'.Users::STATUS_DELETED.'" class="btn btn-danger delete" data-dismiss="modal">Удалить</button>
            <button type="button" class="">Отмена</button>',
    ));

    $this->widget('ext.bootstrap.widgets.BsModal', array(
        'id' => 'modal_not_active',
        'htmlOptions'=>array(
            'class'=>'modal'
        ),
        'header'  => "Скрытие пользователей",
        'content' => "Вы действительно хотите скрыть пользователей ?",
        'footer'  => '<button type="button" data-status="'.Users::STATUS_NOT_ACTIVE.'" class="btn btn-danger change_status" data-dismiss="modal">Скрыть</button>
            <button type="button" class="">Отмена</button>',
    ));

    $this->widget('ext.bootstrap.widgets.BsModal', array(
        'id' => 'modal_active',
        'htmlOptions'=>array(
            'class'=>'modal'
        ),
        'header'  => "Показ пользователей",
        'content' => "Вы действительно хотите показать пользователей ?",
        'footer'  => '<button type="button" data-status="'.Users::STATUS_OK.'" class="btn btn-danger change_status" data-dismiss="modal">Показать</button>
            <button type="button" class="">Отмена</button>',
    ));
?>
