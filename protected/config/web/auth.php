<?php
/**
 * Настройки прав доступа.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    User::ROLE_USER => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest', // унаследуемся от гостя
        ),
        'bizRule' => null,
        'data' => null
    ),
    User::ROLE_COMPANY_ADMIN => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Company administrator',
        'children' => array(
            User::ROLE_USER,
        ),
        'bizRule' => null,
        'data' => null
    ),
    User::ROLE_ADMIN => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
//        'children' => array(
//            'moderator',         // позволим админу всё, что позволено модератору
//        ),
        'bizRule' => null,
        'data' => null
    ),
);