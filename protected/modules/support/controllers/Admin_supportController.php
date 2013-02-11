<?php

class Admin_supportController extends CmsController
{
	public function actionIndex($page = 1)
	{
		$condition = new CDbCriteria();
		$condition->order = 'opened DESC, l_message.cdate DESC';

		$pager = new CPagination(SRequest::model()->with('l_message')->count($condition));
		$pager->setPageSize(50);
		$pager->setCurrentPage($page-1);
		$pager->applyLimit($condition);

		$requests = SRequest::model()->with('l_message', 'user')->findAll($condition);
		//CVarDumper::dump($requests, 3, 1);
		$this->render('index', array('requests' => $requests, 'pager' => $pager));
	}

	public function actionClose_switch($id) {
		/** @var $model SRequest */
		$model = SRequest::model()->findByPk($id);
		if ($model) {
			$model->opened = $model->opened ? 0 : 1;
			if ($model->save()) {
				echo json_encode(array('error' => 0, 'opened' => $model->opened));
			} else {
				echo json_encode(array('error' => 1, 'message'=> 'Не удалось обновить статус запроса.'));
			}
		} else {
			echo json_encode(array('error' => 1, 'message'=> 'Такого запроса нет.'));
		}
		Yii::app()->end();
	}

	public function actionView($id) {
		/** @var $request SRequest */
		$request = SRequest::model()->findByPk($id);
		$message = new SMessage();
		$message->request_id = $request->id;
		if (isset($_POST['SMessage'])) {
			$message->attributes = $_POST['SMessage'];
			$message->to_admin = 0;
			if ($message->save()) {
				$this->refresh();
			}
		}
		$this->render('view', array('request' => $request, 'message' => $message));
	}
}