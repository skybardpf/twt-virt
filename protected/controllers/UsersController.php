<?php
class UsersController extends Controller
{
	/**
	 * @param $company_id - Компания
	 *
	 * @throws CHttpException
	 */
	public function actionIndex($company_id)
	{
		// Не администраторы не могут делать что либо с пользователями.
		if (!Yii::app()->user->data->isAdmin) {
			throw new CHttpException(403);
		}

		$prev_company = Company::model()->findByPk($company_id);
		if (!$prev_company) {
			throw new CHttpException(404);
		}

		$company_ids = array();
		if (Yii::app()->user->data->adminCompanies) {
			foreach (Yii::app()->user->data->adminCompanies as $company) {
				$company_ids[] = $company->id;
			}
		}
		// Пользователи, работающие в компаниях, администрируемых текущим пользователем в порядке возрастания Email
		$users = User::model()->findAll(array(
			'condition' => 'companies.id IN(:company_ids) AND t.id != :admin_user_id',
			'order'     => 't.email',
			'params'    => array(':company_ids' => implode(', ', $company_ids), ':admin_user_id' => Yii::app()->user->id),
		));

		$this->render('index', array('users' => $users, 'company' => $prev_company));
	}

	public function actionUpdate($id, $company_id)
	{
		/** @var $model User */
		$company_ids = array();
		if (Yii::app()->user->data->adminCompanies) {
			foreach (Yii::app()->user->data->adminCompanies as $company) {
				$company_ids[] = $company->id;
			}
		}

		$model = User::model()->find(array(
			'condition' => 't.id = :user_id AND companies.id IN (:company_ids) AND t.id != :admin_user_id',
			'params'    => array(
				':user_id'       => $id,
				':company_ids'   => implode(', ', $company_ids),
				':admin_user_id' => Yii::app()->user->id),
			)
		);

		// Пользователь по данным критериям не найден - редирект на список пользователей
		if (!$model) {
			Yii::app()->request->redirect($this->createUrl('/users/index'));
		}

		if ($model->create_user_id == Yii::app()->user->id) {
			$model->setScenario('owner_update');
		} else {
			$model->setScenario('only_company');
		}

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if (empty($_POST[get_class($model)]['companies_ids'])) {
				$model->companies_ids = array();
			}
			if ($model->save()) {
				$this->redirect($this->createUrl('index'));
			}
		}
		$this->render('update', array('model' => $model, 'company_id' => $company_id));
	}

	public function actionCreate($company_id)
	{
		if (!Yii::app()->user->data->isAdmin) {
			throw new CHttpException(403);
		}

		$model = new User();
		$model->setScenario('owner_create');
		$model->create_user_id = Yii::app()->user->id;

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if ($model->save()) {
				$this->redirect($this->createUrl('index', array('id' => $model->id)));
			}
		}

		$this->render('update', array('model' => $model, 'company_id' => $company_id));
	}

	public function actionProfile()
	{
		$this->render('profile', array('user' => Yii::app()->user->data));
	}

	public function actionProfile_edit()
	{
		$model = Yii::app()->user->data;
		$model->setScenario('profile');

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if ($model->save()) {
				$this->redirect($this->createUrl('profile'));
			}
		}

		$this->render('profile_edit', array('model' => $model));
	}

	public function actionChange_pass()
	{
		$model = clone Yii::app()->user->data;
		$model->password = NULL;
		$model->setScenario('change_pass');

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if (User::createHash($model->old_password, Yii::app()->user->data->salt)== Yii::app()->user->data->password) {
				if ($model->save()) {
					$this->redirect($this->createUrl('profile'));
				}
			} else {
				$model->addError('old_password', 'Старый пароль введен неверно');
			}
		}

		$this->render('change_pass', array('model' => $model));
	}
}