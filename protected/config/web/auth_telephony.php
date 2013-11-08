<?php
/**
 * Настройки прав доступа для телефонии.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
return array(
    /**
     * Операции с телефонией
     */
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
    'readIvrTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр голосового меню',
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
     * Роли в телефонии
     */
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