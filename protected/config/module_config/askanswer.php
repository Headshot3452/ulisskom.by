<?php
return array(
    'urlManager'=>array(
        ''=>'askanswer/index',
        'feedback'=>'askanswer/feedback',
        '<name:([\w-]+)>/'=>'askanswer/item',
    ),
    'actions'=>array(
        'item'=>'Вопрос',
    ),
);