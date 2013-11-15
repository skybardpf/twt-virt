<?php
/**
 * Настройки прав доступа для управления сайтами компании.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
return array(

    'listSites' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр списка площадок',
        'bizRule' => null,
        'data' => null
    ),
    'settingsSite' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Настройки сайта',
        'bizRule' => null,
        'data' => null
    ),
    'deleteSite' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление сайта',
        'bizRule' => null,
        'data' => null
    ),
    'createSite' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Создание сайта',
        'bizRule' => null,
        'data' => null
    ),

    /**
     * Роли в сайтах
     */
    'roleAdminSites' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Управление сайтами',
        'bizRule' => null,
        'data' => null,
        'children' => array(
            'listSites',
            'settingsSite',
            'deleteSite',
            'createSite',
        ),
    ),
);