<?php
class Admin_userController extends CmsController
{
	public function actionCreate()
	{
		$this->edit(new AdminUser(), 'create');
	}

	public function actionDelete($id)
	{
		$admin = AdminUser::model()->findByPk($id);
		if (isset($_POST['result'])) {
			switch ($_POST['result']) {
				case 'yes':
					if ($admin->delete()) {
						$this->redirect($this->createUrl('/admin/admin_user'));
					} else {
						throw new CException('Не удалось удалить администратора');
					}
				break;
				default:
					$this->redirect($this->createUrl('/admin/admin_user'));
				break;
			}
		}
		$this->render('delete', array('admin' => $admin));
	}

	public function actionUpdate($id)
	{
		/** @var $admin AdminUser */
		$admin = AdminUser::model()->findByPk($id);
		$admin->setScenario('update');
		$this->edit($admin, 'update');
	}

	public function actionChange_password($id)
	{
		/** @var $admin AdminUser */
		$admin = AdminUser::model()->findByPk($id);
		$admin->setScenario('ch_pass');
		$model = new AdminUser('ch_pass');

		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-change_password-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST['AdminUser'])) {
			$admin->attributes=$_POST['AdminUser'];
			$model->attributes=$_POST['AdminUser'];
			if ($model->validate() && $admin->save(true, array('salt', 'password'))) {
				$this->redirect($this->createUrl('/admin/admin_user'));
			}
		}

		$this->render('change_password', array('model' => $model, 'admin' => $admin));
	}


	public function actionIndex()
	{
		$adminsDataProvider = new CActiveDataProvider('AdminUser');
		$this->render('index', array('adminsDataProvider' => $adminsDataProvider));
	}

	public function actionView($id)
	{
		$admin = AdminUser::model()->findByPk($id);
		if (empty($admin)) throw new CHttpException(404, 'Данного администратора не существует');
		$this->render('view', array('admin' => $admin));
	}

	public function edit(AdminUser $admin, $view)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='admin-form-form') {
			echo CActiveForm::validate($admin);
			Yii::app()->end();
		}

		if (isset($_POST['AdminUser'])) {
			$admin->attributes=$_POST['AdminUser'];
			if ($admin->save()) {
				$this->redirect($this->createUrl('/admin/admin_user'));
			}
		}
		$this->render($view, array('admin' => $admin));
	}

	public function actionLogin()
	{
		if (!Yii::app()->admin->isGuest) {
			$this->redirect($this->createUrl('/admin/admin_user/'));
		}
		$admin=new AdminUser('login');
		if(isset($_POST['AdminUser'])) {
			$admin->attributes=$_POST['AdminUser'];
			if ($admin->validate()) {
				$identity=new AdminIdentity($admin->login, $admin->password);
				if ($identity->authenticate()) {
					$duration = 3600*24*30;
					if ($admin->notRememberSession) {
						Yii::app()->admin->allowAutoLogin = false;
						$duration = 0;
					}
					if (Yii::app()->admin->login($identity, $duration)) {
						if ($this->module->startPage) {
							$returnUrl = $this->module->startPage;
						} else {
							$returnUrl = !Yii::app()->admin->returnUrl ? '/admin/' : Yii::app()->admin->returnUrl;
						}
						$this->redirect($returnUrl);
					}
				} else {
					$admin->addError(null, $identity->errorMessage);
					$admin->addError('login', '');
					$admin->addError('password', '');
				}
			}
		}
		$this->render('login', array('admin'=>$admin));
	}

	public function actionLogout()
	{
		Yii::app()->admin->logout();
		$this->redirect(Yii::app()->admin->returnUrl == '/index.php'? Yii::app()->homeUrl : Yii::app()->admin->returnUrl);
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions'=>array('login'), 'users'=>array('?')),
			array('deny', 'users'=>array('?'))
		);
	}
}