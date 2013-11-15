<?php
class UsersController extends Controller
{
    public $tab_menu = 'profile';

    public function actions()
    {
        return array();
    }

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
			'condition' => 'companies.id IN('.implode(', ', $company_ids).') AND t.id != :admin_user_id',
			'order'     => 't.email',
			'params'    => array(':admin_user_id' => Yii::app()->user->id),
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
			'condition' => 't.id = :user_id AND companies.id IN ('.implode(', ', $company_ids).') AND t.id != :admin_user_id',
			'params'    => array(
				':user_id'       => $id,
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
				$this->redirect($this->createUrl('index', array('company_id' => $company_id)));
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
				$this->redirect($this->createUrl('index', array('company_id' => $company_id)));
			}
		}

		$this->render('update', array('model' => $model, 'company_id' => $company_id));
	}

    /**
     * Просмотр профиля
     */
	public function actionProfile()
	{
        $this->tab_menu = 'profile';
        $this->breadcrumbs = array(
            'Профиль'
        );
        $this->pageTitle = 'Просмотр профиля';

        $user =  Yii::app()->user->data;

        $this->render('/users/menu', array(
                'content' => $this->renderPartial('/users/profile',
                    array(
                        'user' => $user,
                    ), true),
                'user' => $user,
            )
        );
	}

    /**
     * Редактирование профиля
     */
    public function actionProfile_edit()
	{
        $this->tab_menu = 'profile';
        $this->breadcrumbs=array(
            'Профиль'=>array('users/profile'),
            'Редактирование',
        );
        $this->pageTitle = 'Редактирование профиля';

        /**
         * @var User $model
         */
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

        $this->render('/users/menu', array(
                'content' => $this->renderPartial('/users/profile_edit',
                    array(
                        'model' => $model,
                    ), true),
                'user' => $model,
            )
        );
	}

    /**
     * Смена пароля для профиля
     */
	public function actionChange_pass()
	{
        $this->tab_menu = 'profile';
        $this->breadcrumbs=array(
            'Профиль'=>array('users/profile'),
            'Смена пароля',
        );
        $this->pageTitle = 'Смена пароля';

        /**
         * @var User $model
         */
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

        $this->render('/users/menu', array(
                'content' => $this->renderPartial('/users/change_pass',
                    array(
                        'model' => $model,
                    ), true),
                'user' => $model,
            )
        );
	}
}