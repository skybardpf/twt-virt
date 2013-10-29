<?php
/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 *
 * @var UsersController $this
 * @var UserEmail $model
 */
?>
<td><?= $model->primaryKey; ?></td>
<td><?= CHtml::link( $model->login_email, "#", array(
        "class" => "update-login-email",
        "data-url" => Yii::app()->controller->createUrl("user_email/update", array("id" => $model->primaryKey)),
    ));
    ?>
<td><?= $model->site_id; ?></td>
<td>
    <?php
    echo Yii::app()->controller->widget("bootstrap.widgets.TbButton",
        array(
            "label" => "Удалить",
            "type" => "success",
            "size" => "normal",
            "url" => "#",
            "htmlOptions" => array(
                "class" => "delete-login-email",
                "data-url" => Yii::app()->controller->createUrl("user_email/delete", array("id" => $model->primaryKey)),
            )
        ),
        true
    );
    ?>
</td>