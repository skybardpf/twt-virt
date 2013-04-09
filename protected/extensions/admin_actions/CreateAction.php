<?php
class CreateAction extends CAction
{
	/**
	 * @var CActiveRecord|callable
	 */
	public $model = null;

	public $view = 'create';

	public function run()
	{
		if (is_callable($this->model)) {
			$model = call_user_func($this->model);
		} else {
			$model = $this->model;
		}

		if(isset($_POST['ajax']) && $_POST['ajax']==='model-form-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$model->attributes=$_POST[get_class($model)];
			if ($model->save()) {
				// Сохранение банковских счетов, при создании новой компании
				if ($_POST['CBankAccount']) {
					foreach ($_POST['CBankAccount']['account'] as $k => $v) {
						$account = new CBankAccount();
						$account->attributes = $v;
						$account->resident = $model->resident;
						$account->company_id = $model->id;
						$account->save();
					}
				}
				$this->controller->redirect($this->controller->createUrl('view', array('id' => $model->id)));
			}
		}
		$this->controller->render($this->view, array('model' => $model));
	}
}