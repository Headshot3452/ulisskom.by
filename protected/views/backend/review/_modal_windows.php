<?php
    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_archive',
            'htmlOptions' => array(
                'class'=>'modal modal_review'
            ),
            'header'  => "В архив",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_ARCHIVE.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
                <button type="button" class="">Отмена</button>',
        )
    );

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_answer',
            'htmlOptions' => array(
                'class' => 'modal modal_review'
            ),
            'header'  => "Ответили",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_ANSWERED.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
                <button type="button" class="">Отмена</button>',
        )
    );

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_moderate',
            'htmlOptions' => array(
                'class' => 'modal modal_review'
            ),
            'header'  => "В обработке",
            'content' => "Вы действительно хотите сменить статус ?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_MODERATE.'" class="btn btn-danger change_status" data-dismiss="modal">Изменить</button>
                <button type="button" class="">Отмена</button>',
        )
    );

    $this->widget('ext.bootstrap.widgets.BsModal',
        array(
            'id' => 'modal_delete',
            'htmlOptions' => array(
                'class' => 'modal modal_review'
            ),
            'header'  => "Удалить",
            'content' => "Вы действительно хотите удалить?",
            'footer'  => '<button type="button" data-status="'.ReviewItem::STATUS_DELETED.'" class="btn btn-danger change_status delete" data-dismiss="modal">Удалить</button>
                <button type="button" class="">Отмена</button>',
        )
    );