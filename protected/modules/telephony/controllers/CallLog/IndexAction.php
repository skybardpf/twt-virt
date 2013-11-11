<?php
use application\modules\telephony\models as M;

/**
 * @author Skibardin Andrey <webprofi1983@gmail.com>
 */
class IndexAction extends CAction
{
    public function run($uid = null)
    {
        $params = array('user_id'=>$uid);
        if(!Yii::app()->user->checkAccess('readCallLogsTelephony', $params)) {
            throw new CHttpException('403', Yii::t('app', 'Доступ запрещен'));
        }

        /**
         * @var application\modules\telephony\controllers\DefaultController $controller
         */
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name .' | Телефония | Логи звонков';

        $users = User::model()->with('user2company')->findAll(
            'user2company.company_id=:company_id AND role=:role',
            array(
                ':company_id' => $controller->company->primaryKey,
                ':role' => User::ROLE_USER,
            )
        );

        $model = new M\FormCallLog();
        $model->user_id = $uid;

        $range = array_keys(CHtml::listData($users, 'id', 'name'));
        $range[''] = '';
        $model->validatorList->add(
            CValidator::createValidator('in', $model, 'user_id', array(
                'range' => $range,
            ))
        );

        $post = Yii::app()->request->getPost(get_class($model));
        if ($post){
            $model->attributes = $post;
            if ($model->validate()){
                if ($model->user_id){
                    $redirect = $controller->createUrl('call_log/index', array(
                        'cid' => $controller->company->primaryKey,
                        'uid' => $model->user_id,
                    ));
                } else {
                    $redirect = $controller->createUrl('call_log/index', array(
                        'cid' => $controller->company->primaryKey,
                    ));
                }
                $controller->redirect($redirect);
            }
        }

        if ($model->user_id){
            $found_user = false;
            foreach ($users as $u){
                if ($u->primaryKey == $model->user_id){
                    $found_user = true;
                    break;
                }
            }
            if (!$found_user){
                throw new CHttpException('404', Yii::t('app', 'Пользователь не найден'));
            }
        }

        $data = array();

        $controller->render(
            '/default/tabs',
            array(
                'content' => $controller->renderPartial(
                    'index',
                    array(
                        'data' => $data,
                        'model' => $model,
                        'users' => $users,
                    ),
                    true
                )
            )
        );
    }
}