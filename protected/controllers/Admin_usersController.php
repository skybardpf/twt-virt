<?php

class Admin_usersController extends CmsController
{
	public function actions()
	{
		return array(
			'create'=>array(
				'class'=>'ext.admin_actions.CreateAction',
				'model'=> new User(),
			),
			'update'=>array(
				'class'=>'ext.admin_actions.UpdateAction',
				'model'=> User::model(),
			),
			'delete'=>array(
				'class'=>'ext.admin_actions.DeleteAction',
				'model'=> User::model(),
			)
		);
	}
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider(User::model());
		$this->render('index', array('dataProvider' => $dataProvider));
	}

	public function actionView()
	{
		$this->redirect(array('index'));

	}
}