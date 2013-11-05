<?php
/**
 * Class MailController
 */
class MailController extends Controller
{
	public $layout = '/layouts/owner';
	public $controller_name = "mail";

    /**
     * @param int $company_id
     */
    public function actionChange_auth($company_id)
	{
        $sql = 'SELECT ue.id, ue.login_email, s.domain
            FROM company c, user2company uc, user_emails ue, sites s
            WHERE c.id = :company_id AND uc.company_id=c.id AND ue.user_id=uc.user_id AND s.id=ue.site_id';
        $params = array(
            ':company_id' => $company_id,
        );
        $user_data = Yii::app()->user->getData();
        if (!$user_data->isAdmin){
            $sql .= ' AND ue.user_id=:user_id';
            $params[':user_id'] = $user_data->primaryKey;
        }

        $cmd = Yii::app()->db->createCommand($sql);
        $tmp = $cmd->queryAll(true, $params);
        $emails = array();
        foreach ($tmp as $val){
            $emails[$val['id']] = $val['login_email'].'@'.$val['domain'].'.'.Yii::app()->params->httpHostName;
        }

        $model = new FormAuthMail();
        $model->validatorList->add(
            CValidator::createValidator('in', $model, 'user_email_id', array(
                'range' => array_keys($emails)
            ))
        );

        $data = Yii::app()->request->getPost(get_class($model));
        if($data) {
            $model->attributes = $data;
            if($model->validate()){
                $this->redirect($this->createUrl('layout', array('company_id' => $company_id, 'id' => $model->user_email_id)));
            }
        }

        $this->render(
            'change_auth',
            array(
                'data' => $emails,
                'model' => $model,
            )
        );
	}

    /**
     * Загружаем в iframe roundcube. С указанным email для авторизации.
     * @param int $company_id
     * @param int $id
     * @throws CHttpException
     */
    public function actionLayout($company_id, $id)
    {
        $model = UserEmail::model()->findByPk($id);
        if ($model === null){
            throw new CHttpException(404, 'Не найден Email аккаунт');
        }
        $this->render(
            'layout',
            array(
                'model' => $model,
            )
        );
    }
}