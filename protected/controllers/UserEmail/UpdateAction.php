<?php
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