<?php
/**
 * Настройки прав доступа для телефонии.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
return array(

    'readTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр информации',
        'bizRule' => null,
        'data' => null
    ),
    'readCallLogsTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр логов звонков',
        'bizRule' => null,
        'data' => null
    ),

    /**
     * Управление SIP
     */
    'readSipTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр SIP',
        'bizRule' => null,
        'data' => null
    ),
    'updateSipTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование SIP',
        'bizRule' => null,
        'data' => null
    ),


    'readFaxTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр факса',
        'bizRule' => null,
        'data' => null
    ),
    'sendFaxTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Отправка факса',
        'bizRule' => null,
        'data' => null
    ),
    'readInternalNumbersTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр настройек внутреннего номера',
        'bizRule' => null,
        'data' => null
    ),
    'updateInternalNumbersTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование настройек внутреннего номера',
        'bizRule' => null,
        'data' => null
    ),

    'readBindPhonesTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр привязки внутренних номеров',
        'bizRule' => null,
        'data' => null
    ),

    /**
     * Управление голосовым меню
     */
    'readIvrMenuTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр голосового меню',
        'bizRule' => null,
        'data' => null
    ),
    'createIvrMenuTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Добавление пункта голосового меню',
        'bizRule' => null,
        'data' => null
    ),
    'updateIvrMenuTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование пункта голосового меню',
        'bizRule' => null,
        'data' => null
    ),
    'deleteIvrMenuTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление пункта голосового меню',
        'bizRule' => null,
        'data' => null
    ),

    /**
     * Управление голосовыми командами
     */
    'readIvrCommandTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр голосовых команд',
        'bizRule' => null,
        'data' => null
    ),



    /**
     * Роли в телефонии
     */
    'role_telephony_sip' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Управление SIP',
        'bizRule' => null,
        'data' => null,
        'children' => array(
            'readSipTelephony',
            'updateSipTelephony',
        ),
    ),
    'role_telephony_ivr_menu' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Управление голосовым меню',
        'bizRule' => null,
        'data' => null,
        'children' => array(
            'readIvrMenuTelephony',
            'createIvrMenuTelephony',
            'updateIvrMenuTelephony',
            'deleteIvrMenuTelephony',
        ),
    ),
    'role_telephony_ivr_command' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Управление голосовыми командами',
        'bizRule' => null,
        'data' => null,
        'children' => array(
            'readIvrCommandTelephony',
        ),
    ),
    'role_telephony_company' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Общие права по телефонии компании',
        'bizRule' => null,
        'data' => null,
        'children' => array(
            'readTelephony',
            'readCallLogsTelephony',

            'readFaxTelephony',
            'sendFaxTelephony',

            'readInternalNumbersTelephony',
            'updateInternalNumbersTelephony',
        ),
    ),
);