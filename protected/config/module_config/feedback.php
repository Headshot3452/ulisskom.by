<?php
return array(
    'urlManager'=>array(
        ''=>'feedback/index',
        'upload'=>'feedback/upload',
        '<name:([\w-]+)>/'=>'feedback/item',
    ),
    'actions'=>array(
        'item'=>'Сообщение',
    ),
);