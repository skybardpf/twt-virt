<?php
use application\modules\telephony\models as M;

/**
 * Удаление пункта голосового меню.
 *
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class DeleteAction extends CAction
{
    /**
     * @param integer $id
     */
    public function run($id)
    {
        if (Yii::app()->request->isAjaxRequest){
            try {
                if(!Yii::app()->user->checkAccess('deleteIvrMenuTelephony')) {
                    throw new CException(Yii::t('app', 'Доступ запрещен'));
                }
                /**
                 * @var application\modules\telephony\controllers\Ivr_menuController $controller
                 */
                $controller = $this->controller;
                $controller->pageTitle = Yii::app()->name .' | Телефония | Удаление пункта голосового меню';

                $model = new M\FormIvrMenu();
                if (!$model->delete()){
                    throw new CException(Yii::t('app', 'Не удалось удалить пункт меню'));
                }

                echo CJSON::encode(array(
                    'success' => true,
                ));

            } catch (CException $e){
                echo CJSON::encode(array(
                   'success' => false,
                    'message' => $e->getMessage(),
                ));
            }
        }
    }
}