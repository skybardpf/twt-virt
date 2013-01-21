<?php

class Admin_companiesController extends CmsController
{
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
}