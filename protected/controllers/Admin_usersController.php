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

	public function actionView()
	{
		$this->redirect(array('index'));

	}
}