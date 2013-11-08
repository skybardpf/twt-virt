<?php
/**
 * Настройки прав доступа.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
return array(
    /**
     * Операции с профайлом
     */
    'readProfile' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр профайла',
        'bizRule' => null,
        'data' => null
    ),
    'updateProfile' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование профайла',
        'bizRule' => null,
        'data' => null
    ),
    'changePassProfile' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Сменить пароль в профайле',
        'bizRule' => null,
        'data' => null
    ),
    'changeLoginEmailsProfile' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Пароли к Email аккаунтам',
        'bizRule' => null,
        'data' => null
    ),

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
    'readFaxTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр факса',
        'bizRule' => null,
        'data' => null
    ),
    'readInternalNumbersTelephony' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Просмотр настройек внутреннего номера',
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
     * Роли
     */
    'role_profile' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Управление профайлом',
        'bizRule' => null,
        'data' => null,
        'children' => array(
            'readProfile',
            'updateProfile',
            'changePassProfile',
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
            'readInternalNumbersTelephony',
        ),
    ),

    'role_guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    User::ROLE_USER => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'role_guest',

            'role_profile',
            'changeLoginEmailsProfile',

            'role_telephony_company',
            'readSipTelephony',
        ),
        'bizRule' => null,
        'data' => null
    ),
    User::ROLE_COMPANY_ADMIN => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Company administrator',
        'children' => array(
            'role_guest',

            'role_profile',

            'role_telephony_company',
            'readIvrTelephony',
            'readBindPhonesTelephony',
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