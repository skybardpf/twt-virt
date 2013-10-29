<?php
/**
 * Список Email акканутов для данного юзера.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 *
 * @var UsersController $this
 * @var User $user
 */

Yii::app()->clientScript->registerScriptFile($this->asset_static . '/js/users/login_emails.js');
$this->widget('ext.widgets.loading.LoadingWidget');

;

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'grid-login-emails',
    'type' => 'striped bordered condensed',
    'dataProvider' => new CArrayDataProvider($user->userEmails),
    'template' => "{items} {pager}",
    'columns' => array(
        array(
            'name' => 'id',
            'header' => '#',
        ),
        array(
            'name' => 'login_email',
            'header' => 'Email компании',
            'type' => 'raw',
            'value' => 'CHtml::link($data["login_email"], "#", array(
                "class" => "update-login-email",
                "data-url" => Yii::app()->controller->createUrl("user_email/update", array("id" => $data["id"])),
            ));',
        ),
        array(
            'name' => 'site_id',
            'header' => 'Сайт',
        ),
        array(
            'name' => 'action',
            'header' => 'Действие',
            'type' => 'raw',
            'value' => 'Yii::app()->controller->widget("bootstrap.widgets.TbButton",
                array(
                    "label" => Yii::t("app", "Удалить"),
                    "type"  => "success",
                    "size"  => "normal",
                    "url"   => "#",
                    "htmlOptions" => array(
                        "class" => "delete-login-email",
                        "data-url" => Yii::app()->controller->createUrl("user_email/delete", array("id" => $data["id"])),
                    )
                ),
                true
            );',
        ),
    ),
));

Yii::import('bootstrap.widgets.TbButton');
$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Добавить Email аккаунт',
    'type'  => 'success',
    'buttonType'  => TbButton::BUTTON_BUTTON,
    'size'  => 'normal',
    'htmlOptions' => array(
        'class' => 'create_login_email',
        'data-url' => $this->createUrl('user_email/create',
            array(
                'cid' => $this->company->primaryKey,
                'uid' => $user->primaryKey,
            )
        ),
    ),
));