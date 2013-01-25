<?php
class UsersController extends Controller
{
	public function actionIndex()
	{
		if (!Yii::app()->user->data->isAdmin) {
			throw new CHttpException(403);
		}
		$users = User::model()->findAll(array(
			'condition'=>'companies.admin_user_id = :admin_user_id',
			'params'=>array(':admin_user_id' => Yii::app()->user->id),
		));


		$this->render('index', array('users' => $users));
	}

	public function actionUpdate($id)
	{
		/** @var $model User */
		$model = User::model()->find(array(
			'condition'=>'t.id = :user_id AND companies.admin_user_id = :admin_user_id',
			'params'=>array(':user_id' => $id, ':admin_user_id' => Yii::app()->user->id),
		));
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
			if ($model->save()) {
				$this->redirect($this->createUrl('index', array('id' => $model->id)));
			}
		}

		$this->render('update', array('model' => $model));
	}

	public function actionCreate()
	{
		if (!Yii::app()->user->data->isAdmin) {
			throw new CHttpException(403);
		}

		$model = new User();
		$model->setScenario('owner_update');
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

		$this->render('update', array('model' => $model));
	}
}