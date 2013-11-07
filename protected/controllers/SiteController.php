<?php

class SiteController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('error'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('login'),
                'users'=>array('?'),
            ),
            array('allow',
                'actions'=>array(
                    'logout',
                    'index'
                ),
                'roles' => array(User::ROLE_COMPANY_ADMIN, User::ROLE_USER),
            ),

            array('deny',
                'users'=>array('*'),
            ),
        );
    }

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        echo Yii::app()->user->role;

		Yii::app()->getModule('files');
		$this->render(
            'index',
            array(
                'companies' => Yii::app()->user->data->companies,
                'mails' => $this->countMails(),
            )
        );
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

    /**
     * @return array
     */
    private function countMails()
	{
//        $user_data = Yii::app()->user->getData();
//        if (!$user_data->isAdmin){
//            $sql .= ' AND ue.user_id=:user_id';
//            $params[':user_id'] = $user_data->primaryKey;
//        }
        $ret = array(
            'unseen' => 0,
            'all' => 0,
        );
        return $ret;
	}

    /**
     * @var UserEmail $user_email
     * @return array
     */
    private function countMailsByAccount(UserEmail $user_email)
    {
        $ret = array(
            'unseen' => 0,
            'all' => 0,
        );
        Yii::import('ext.EImap.EIMap', true);
        $imap_inbox = '{'.Yii::app()->params->IMAPHost.':'.Yii::app()->params->IMAPPort.'/imap/novalidate-cert}INBOX';
        $imap = new EIMap($imap_inbox, $user_email->getFullDomain(), $user_email->password);

        if($imap->connect()){
            $all = $imap->searchmails( EIMap::SEARCH_ALL);
            $unseen = $imap->searchmails( EIMap::SEARCH_UNSEEN);
            $ret['unseen'] = count($unseen);
            $ret['all'] = count($all);

            $imap->close();
        }
        return $ret;
    }
}