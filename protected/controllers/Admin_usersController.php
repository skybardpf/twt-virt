<?php

class Admin_usersController extends CmsController
{
	public function actions()
	{
		$new = new User();
		$new->admin_action = true;
		$model = User::model();
		$model->admin_action = true;
		return array(
			'create'=>array(
				'class'=>'ext.admin_actions.CreateAction',
				'model'=> $new,
			),
			'delete'=>array(
				'class'=>'ext.admin_actions.DeleteAction',
				'model'=> $model,
			)
		);
	}

	public function actionIndex($company = null)
	{
		$criteria = new CDbCriteria();
		if ($company && $company = Company::model()->findByPk($company)) {
			$criteria->addCondition('user2company.company_id = :company');
			$criteria->params[':company'] = $company->id;
		}
		$companies = array();
		/** @var $tmp Company[] */
		$tmp = Company::model()->findAll();
		if ($tmp) { foreach($tmp as $t) {
			$companies[] = array('label' => $t->name, 'value' => $t->id);
		} }
		unset($t, $tmp);
//		$dataProvider = new CActiveDataProvider($model, $params);
//		$dataProvider->getData();

		$dataProvider = new CArrayDataProvider(User::model()->with('user2company')->findAll($criteria));
		$this->render('index', array('dataProvider' => $dataProvider, 'companies' => $companies, 'company' => $company));
	}

	public function actionUpdate($id) {
		$model = User::model()->findByPk($id);
		$model->admin_action = true;
		if (empty($model)) throw new CHttpException(404);
		$model->setScenario('update');

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if ($model->save()) {
				//$this->redirect($this->createUrl('view', array('id' => $model->id)));
			}
		}
		$this->render('update', array('model' => $model));
	}
	public function actionView()
	{
		$this->redirect(array('index'));

	}
}