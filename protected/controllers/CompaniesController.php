<?php

class CompaniesController extends Controller
{
	public $layout = '//layouts/company';

	public function runAction($action) {
		Yii::app()->getModule('files');
		return parent::runAction($action);
	}

	public function actionUpdate($company_id)
	{
		/** @var $model Company */
		$model = $this->company;
		if (empty($model)) throw new CHttpException(404);
		if (!$model->isAdmin(Yii::app()->user->id)) {
			throw new CHttpException(403, 'Вы не являетесь администратором компании');
		}
		$model->setScenario('admin_update');

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if ($model->save()) {
				$this->redirect($this->createUrl('view', array('company_id' => $model->id)));
			}
		}
		$this->render('update', array('model' => $model));
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
				'code'      => 'form_show',
				'title'     => ($is_new) ? 'Добавление банковского счета': 'Редактирование банковского счета',
				'html'      => $this->renderPartial('/accounts/form', array('bank_account' => $account, 'resident' => $resident), 1),
				'footer'    => $this->renderPartial('/accounts/footer', array('company_id' => $account->company_id, 'resident' => $account->resident, 'account_id' => $account->id), 1),
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

	public function actionView($company_id)
	{
		$company = $this->company;
		if (empty($company)) throw new CHttpException(404);
		if (!in_array($company->id, Yii::app()->user->data->companies_ids)) {
			throw new CHttpException(403, 'У вас нет доступа к данной компании');
		}

		$this->render('view', array('company' => $company));
	}

	public function actionDelete($company_id)
	{
		/** @var $company Company */
		$company = $this->company;
		if (empty($company)) throw new CHttpException(404);
		if (!$company->isAdmin(Yii::app()->user->id)) {
			throw new CHttpException(403, 'Вы не являетесь администратором компании');
		}

		if (isset($_POST['result'])) {
			switch ($_POST['result']) {
				case 'yes':
					if ($company->markDeleted()) {
						$this->redirect(Yii::app()->homeUrl);
					} else {
						throw new CException('Не удалось удалить команию');
					}
					break;
				default:
					$this->redirect($this->createUrl('view', array('company_id' => $company_id)));
					break;
			}
		}

		$this->render('delete', array('company' => $company));
	}
}