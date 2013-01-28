<?php

class SiteController extends Controller
{
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->render('index', array('companies' => Yii::app()->user->data->companies));
	}

	public function actionFiles($company_id)
	{
		$company = Company::model()->findByPk($company_id);
		if (!$company) throw new CHttpException(404, 'Компания не найдена');
		$this->render('files', array('company' => $company));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!Yii::app()->user->isGuest) {
			$this->redirect(Yii::app()->homeUrl);
		}
		$model=new User('login');

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl ? Yii::app()->user->returnUrl : '/');
		}
		// display the login form
		$this->render('login', array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}