<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$condition = new CDbCriteria();
		$condition->addCondition('uid = :uid');
		$condition->params[':uid'] = Yii::app()->user->id;
		$condition->order = 'l_message.cdate DESC';

		$requests = SRequest::model()->with('l_message')->findAll($condition);
		//CVarDumper::dump($requests, 3, 1);
		$this->render('index', array('requests' => $requests));
	}

	public function actionCreate() {
		/**
		 * @var $request SRequest
		 * @var $message SMessage
		 */
		$request = new SRequest();
		$request->uid = Yii::app()->user->id;

		$message = new SMessage();
		$message->to_admin = 1;

		if (isset($_POST['SMessage']) || isset($_POST['SRequest'])) {
			$message->attributes=$_POST['SMessage'];
			$request->attributes=$_POST['SRequest'];

			$message->validate();
			$request->validate();

			$transaction = Yii::app()->db->beginTransaction();
			if ($request->save()) {
				$message->request_id = $request->id;
				if ($message->save()) {
					$transaction->commit();
					$this->redirect($this->createUrl('/support/'));
					Yii::app()->end();
				}
			}
			$transaction->rollback();
		}
		$this->render('create', array('request' => $request, 'message' => $message));
	}

	public function actionView($id) {
		$request = SRequest::model()->findByPk($id);
		$message = new SMessage();
		$message->request_id = $request->id;
		if (isset($_POST['SMessage'])) {
			$message->attributes = $_POST['SMessage'];
			$message->to_admin = 1;
			if ($message->save()) {
				$message = new SMessage();
				$message->request_id = $request->id;
			}
		}
		$this->render('view', array('request' => $request, 'message' => $message));
	}
}