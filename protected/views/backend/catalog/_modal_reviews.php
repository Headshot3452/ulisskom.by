<?php
    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_answer',
            'htmlOptions' => array(
                'class' => 'modal'
            ),
            'header'  => "Ответили",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_ANSWERED.'" class="btn btn-success change_status" data-dismiss="modal">Изменить</button>
                        <button type="button" data-dismiss="modal" class="">Отмена</button>',
        )
    );

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_moderate',
            'htmlOptions' => array(
                'class' => 'modal'
            ),
            'header'  => "В обработке",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_MODERATE.'" class="btn btn-warning change_status" data-dismiss="modal">Изменить</button>
                        <button type="button" data-dismiss="modal" class="">Отмена</button>',
        )
    );

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_delete',
            'htmlOptions' => array(
                'class' => 'modal'
            ),
            'header'  => "Удалить",
            'content' => "Вы действительно хотите удалить?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_DELETED.'" class="btn btn-danger change_status delete" data-dismiss="modal">Удалить</button>
                        <button type="button" data-dismiss="modal" class="">Отмена</button>',
        )
    );