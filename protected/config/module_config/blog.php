<?php
return array(
    'urlManager'=>array(
        ''=>'blog/index',
        'comment'=>'blog/comment',
        'complaint'=>'blog/complaint',
        'user'=>'blog/user',
        '<name:([\w-]+)>/'=>'blog/post',
    ),
    'actions'=>array(
        'post'=>'Пост',
    ),
);