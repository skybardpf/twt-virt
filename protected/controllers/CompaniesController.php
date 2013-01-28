<?php

class CompaniesController extends Controller
{
	public function actionUpdate($company_id)
	{
		/** @var $model Company */
		$model = $this->company;
		if (empty($model)) throw new CHttpException(404);
		if ($model->admin_user_id != Yii::app()->user->id) {
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
		if ($company->admin_user_id != Yii::app()->user->id) {
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