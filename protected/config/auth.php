<?php
    return array(
        '1' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Developer',
            'children' => array(
                '2',
            ),
            'bizRule' => null,
            'data' => null
        ),
        '2' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Administrator',
            'children' => array(
                '3',
            ),
            'bizRule' => null,
            'data' => null
        ),
        '3' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Moderator',
            'children' => array(
                '4',
            ),
            'bizRule' => null,
            'data' => null
        ),
        '4' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'User',
            'children' => array(),
            'bizRule' => null,
            'data' => null
        ),
        '5' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Manager',
            'children' => array(
                '4'
            ),
            'bizRule' => null,
            'data' => null
        ),
        '6' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Content manager',
            'children' => array(
                '4'
            ),
            'bizRule' => null,
            'data' => null
        ),
        'guest' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Guest',
            'bizRule' => null,
            'data' => null
        ),
        '' => array(
            'type' => CAuthItem::TYPE_ROLE,
            'description' => 'Guest',
            'bizRule' => null,
            'data' => null
        ),
    );
