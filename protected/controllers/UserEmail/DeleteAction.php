<?php
/**
 * Удаление Email аккаунта.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class DeleteAction extends CAction
{
    public function run($id)
    {
        try {
            $model = UserEmail::model()->findByPk($id);
            if ($model === null){
                throw new CException('Не найден Email аккаунт.');
            }
            if (!$model->delete()){
                throw new CException('Не удалось удалить Email аккаунт.');
            }

            echo CJSON::encode(array(
                'success' => true,
            ));

        } catch(CException $e) {
            echo CJSON::encode(array(
                'success' => false,
                'message' => $e->getMessage(),
            ));
        }
    }
}