<?php
/**
 * Добавления нового Email аккаунта.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class CreateAction extends CAction
{
    /**
     * @param int $cid Идентификатор компании
     * @param int $uid Идентификатор юзера
     */
    public function run($cid, $uid)
    {
        try {
            $company = Company::model()->findByPk($cid);
            if ($company === null){
                throw new CException('Не найдена компания.');
            }
            if (empty($company->sites)){
                throw new CException('Для компании не заданы сайты.');
            }
            $user = User::model()->findByPk($uid);
            if ($user === null){
                throw new CException('Не найден пользователь.');
            }

            $model = new UserEmail();
            $model->setScenario('create');
            $model->user_id = $user->primaryKey;

            $model->validatorList->add(
                CValidator::createValidator('in', $model, 'site_id', array(
                    'range' => array_keys(CHtml::listData($company->sites, 'id', 'name'))
                ))
            );

            $data = Yii::app()->request->getPost(get_class($model));
            if($data) {
                $model->attributes = $data;
                if($model->save()){
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
                        'company' => $company,
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