<?php

class Admin_supportController extends CmsController
{
	public function actionIndex()
	{
		$condition = new CDbCriteria();
		$condition->order = 'l_message.cdate DESC';
		$requests = SRequest::model()->with('l_message', 'user')->findAll($condition);
		//CVarDumper::dump($requests, 3, 1);
		$this->render('index', array('requests' => $requests));
	}

	public function actionClose($id) {
		/** @var $model SRequest */
		$model = SRequest::model()->findByPk($id);
		if ($model) {
			$model->opened = 0;
			if ($model->save()) {
				echo 0;
			} else {
				echo 'Не удалось обновить статус запроса.';
			}
		} else {
			echo 'Такого запроса нет.';
		}
		Yii::app()->end();
	}

	public function actionView($id) {
		$request = SRequest::model()->findByPk($id);
		$message = new SMessage();
		$message->request_id = $request->id;
		if (isset($_POST['SMessage'])) {
			$message->attributes = $_POST['SMessage'];
			$message->to_admin = 0;
			if ($message->save()) {
				$message = new SMessage();
				$message->request_id = $request->id;
			}
		}
		$this->render('view', array('request' => $request, 'message' => $message));
	}
}