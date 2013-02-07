<?php

class DefaultController extends Controller
{
	public function actionIndex($page = 1)
	{
		$condition = new CDbCriteria();
		$condition->addCondition('uid = :uid');
		$condition->params[':uid'] = Yii::app()->user->id;
		$condition->order = 'l_message.cdate DESC';

		$pager = new CPagination(SRequest::model()->with('l_message')->count($condition));
		$pager->setPageSize(50);
		$pager->setCurrentPage($page-1);
		$pager->applyLimit($condition);

		$requests = SRequest::model()->with('l_message')->findAll($condition);
		//CVarDumper::dump($requests, 3, 1);
		$this->render('index', array('requests' => $requests, 'pager' => $pager));
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

	public function actionView($id, $page = 1) {
		/** @var $request SRequest */
		$request = SRequest::model()->findByPk($id);
		if (!$request->readed) {
			$request->readed = 1;
			$request->save();
		};

		$condition = new CDbCriteria();
		$condition->addCondition('request_id = :rid');
		$condition->params[':rid'] = $request->id;
		$condition->order = 'cdate DESC';

		$pager = new CPagination(SMessage::model()->count($condition));
		$pager->setPageSize(50);
		$pager->setCurrentPage($page-1);
		$pager->applyLimit($condition);

		$messages = SMessage::model()->findAll($condition);

		// Создание нового сообщения
		$message = new SMessage();
		$message->request_id = $request->id;
		if (isset($_POST['SMessage'])) {
			$message->attributes = $_POST['SMessage'];
			$message->to_admin = 1;
			if ($message->save()) {
				// Поставим запросу статус "открыт"
				$request->opened = 1;
				$request->save();

				// Новое сообщение от пользователя, т.к. мы на той же странице
				$message = new SMessage();
				$message->request_id = $request->id;
			}
		}
		$this->render('view', array(
			'request'  => $request,
			'message'  => $message,
			'messages' => $messages,
			'pager'    => $pager));
	}
}