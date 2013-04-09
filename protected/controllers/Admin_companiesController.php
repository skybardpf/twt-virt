<?php

class Admin_companiesController extends CmsController
{
	public function runAction($action)
	{
		Yii::app()->getModule('files');
		parent::runAction($action);
	}

	public function actions()
	{
		return array(
			'create'=>array(
				'class'=>'ext.admin_actions.CreateAction',
				'model'=> new Company(),
			),
			'update'=>array(
				'class'=>'ext.admin_actions.UpdateAction',
				'model'=> Company::model(),
			),
			'delete'=>array(
				'class'=>'ext.admin_actions.DeleteAction',
				'model'=> Company::model(),
			)
		);
	}
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider(Company::model());
		$this->render('index', array('dataProvider' => $dataProvider));
	}

	public function actionView()
	{
		$this->redirect(array('index'));

	}

	public function actionUpdate_account($company_id = 0, $resident = 0, $account_id = null) {
		$account = null;
		if ($account_id) {
			$account = CBankAccount::model()->findByPk($account_id);
		}
		if(!$account) {
			$account = new CBankAccount();
			$is_new = true;
		} else {
			$is_new = false;
		}

		if ($_POST) {
			$account->attributes = $_POST['CBankAccount'];
			$account->resident = $resident;
			$account->company_id = $company_id;
			if ($company_id) {
				if( $account->save()) {
					$ret = array(
						'code' => 'Ok',
						'account_id' => $account->id,
						'new_link' => $this->renderPartial('/accounts/new_link', array('bank_account' => $account, 'company_id' => $company_id , 'company_resident' => $resident), 1),
					);
				} else {
					$error_text = '';
					foreach($account->errors as $err) {
						$error_text .= current($err);
					}
					$ret = array(
						'code' => 'error',
						'message' => $error_text,
					);
				}
			} else {
				$ret = array(
					'code' => 'Ok',
					'account_id' => $account->id,
					'hidden_fields' => $this->renderPartial('/accounts/hidden_fields', array('bank_account' => $account, 'company_id' => $company_id , 'company_resident' => $resident), 1),
					'new_link' => $this->renderPartial('/accounts/new_link', array('bank_account' => $account, 'company_id' => $company_id , 'company_resident' => $resident), 1),
				);
			}
		} else {
			$ret = array(
				'code'      => 'form_show',
				'title'     => ($is_new) ? 'Добавление банковского счета': 'Редактирование банковского счета',
				'html'      => $this->renderPartial('/accounts/form', array('bank_account' => $account, 'resident' => $resident), 1),
				'footer'    => $this->renderPartial('/accounts/footer', array('company_id' => $company_id, 'resident' => $resident, 'account_id' => $account->id), 1),
			);
		}
		return $this->ajaxReturn($ret);
	}

	public function actionDelete_account($account_id = 0) {
		$account = array();
		if ($account_id) {
			$account = CBankAccount::model()->findByPk($account_id);
		}
		if ($account) {
			if( $account->delete()) {
				$ret = array(
					'code' => 'Ok',
				);
			} else {
				$error_text = '';
				foreach($account->errors as $err) {
					$error_text .= current($err);
				}
				$ret = array(
					'code' => 'error',
					'message' => $error_text,
				);
			}
		} else {
			$ret = array(
				'code' => 'error',
				'message' => 'Ошибка',
			);
		}
		return $this->ajaxReturn($ret);
	}

	/**
	 * Обработка AJAX запроса - вернуть JSON представление ответа, если включен дебаг - сгенерировать нормальный вывод
	 * @param $ret
	 *
	 * @return int
	 * @throws CHttpException
	 */
	protected function ajaxReturn($ret) {
		if (Yii::app()->request->isAjaxRequest) {
			echo json_encode($ret);
			Yii::app()->end();
		} elseif (YII_DEBUG) {
			return 0;
		}
		throw new CHttpException(404, 'Доступно только через AJAX запрос');
	}
}