<?php
use application\models\Mail as M;

/**
 * Редактирование Email аккаунта.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class UpdateAction extends CAction
{
    /**
     * @param int $id Идентификатор Email-аккаунта
     */
    public function run($id)
    {
        try {
            /**
             * @var UserEmail $model
             */
            $model = UserEmail::model()->findByPk($id);
            if ($model === null){
                throw new CException('Не найден Email аккаунт.');
            }
            $model->setScenario('update');
            $model->old_password = $model->password;
            $model->password = '';

            $old_email = $model->login_email.'@'.$model->site->domain.'.'.Yii::app()->params->httpHostName;

            /**
             * @var Sites $site
             */
            $site = Sites::model()->findByPk($model->site_id);
            if ($site === null){
                throw new CException('Не найдена площадка.');
            }
            $model->validatorList->add(
                CValidator::createValidator('in', $model, 'site_id', array(
                    'range' => array_keys(CHtml::listData($site->company->sites, 'id', 'name'))
                ))
            );

            $data = Yii::app()->request->getPost(get_class($model));
            if($data) {
                $model->attributes = $data;
                if($model->validate()){
                    $model->save(false);

                    if ($model->site_id != $site->primaryKey){
                        $site = Sites::model()->findByPk($model->site_id);
                        if ($site === null){
                            throw new CException('Не найдена площадка.');
                        }
                        $model->site = $site;
                    }

                    /**
                     * Изменяем email и/или пароль на Devecot.
                     */
                    $user = new M\User();
                    $new_email = $model->login_email.'@'.$model->site->domain.'.'.Yii::app()->params->httpHostName;
                    $condition = array();
                    $params = array();
                    if ($old_email != $new_email){
                        $condition[] = 'email=:email';
                        $params[':email'] = $new_email;
                    }
                    if ($model->password != $model->old_password){
                        $condition[] = 'password=ENCRYPT(:password)';
                        $params[':password'] = $model->password;
                    }
                    if (!empty($condition)){
                        $condition = implode(',', $condition);
                        $params[':old_email'] = $old_email;
                        $cmd = $user->getDbConnection()->createCommand('
                            UPDATE '.$user->tableName().' SET '.$condition.'
                            WHERE email=:old_email
                        ');
                        $cmd->execute($params);
                    }

                    echo CJSON::encode(array(
                        'result' => 'added',
                        'html' => $this->controller->renderPartial(
                            '_form_row',
                            array(
                                'model' => $model,
                            ),
                            true
                        ),
                    ));
                    exit;
                }
            }

            echo CJSON::encode(array(
                'result' => 'show_form',
                'html' => $this->controller->renderPartial(
                    '_form',
                    array(
                        'model' => $model,
                        'company' => $site->company,
                    ),
                    true
                ),
            ));

        } catch(CException $e) {
            echo CJSON::encode(array(
                'result' => 'error',
                'message' => $e->getMessage(),
            ));
        }
    }
}