<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/owner';
	public function actionIndex($dir_id = null)
	{
		$this->get_cur_dir($dir, $dir_id);

		// Файлы директории
		$criteria = new CDbCriteria();
		$criteria->order = 'is_dir DESC';
		$files = $dir->children()->findAll($criteria);

		// Путь до директории
		$criteria = new CDbCriteria();
		$criteria->order = 'lft ASC';
		$criteria->condition = 'is_dir = 1';
		$ancestors = $dir->ancestors()->findAll($criteria);

		$new_file = new Files();
		$new_dir = new Files();

		$new_dir->is_dir = 1;
		$new_file->is_dir = 0;
		$new_dir->company_id = $new_file->company_id = $this->company->id;

		if(isset($_POST['ajax']) && $_POST['ajax']==='dir-create-form') {
			echo CActiveForm::validate($new_dir);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-upload-form') {
			echo CActiveForm::validate($new_file);
			Yii::app()->end();
		}

		if (isset($_POST['Files'])) {
			$elem = ($_POST['Files']['is_dir']) ? $new_dir : $new_file;
			$elem->attributes = $_POST['Files'];
			if ($elem->appendTo($dir)) {
				$this->redirect($this->createUrl('index', array('company_id' => $this->company->id, 'dir_id' => $dir_id)));
			}
		}

		$this->render(
			'index',
			array(
				'dir'       => $dir,
				'files'     => $files,
				'new_file'  => $new_file,
				'new_dir'   => $new_dir,
				'ancestors' => $ancestors
			)
		);
	}
	public function actionUser($dir_id = null) {
		$this->get_cur_dir($dir, $dir_id, true);

		// Файлы директории
		$criteria = new CDbCriteria();
		$criteria->order = 'is_dir DESC';
		$files = $dir->children()->findAll($criteria);

		// Путь до директории
		$criteria = new CDbCriteria();
		$criteria->order = 'lft ASC';
		$criteria->condition = 'is_dir = 1';
		$ancestors = $dir->ancestors()->findAll($criteria);

		$new_file = new Files();
		$new_dir = new Files();

		$new_dir->is_dir = 1;
		$new_file->is_dir = 0;
		$new_dir->company_id = $new_file->company_id = $this->company->id;
		$new_dir->user_id = $new_file->user_id = Yii::app()->user->id;

		if(isset($_POST['ajax']) && $_POST['ajax']==='dir-create-form') {
			echo CActiveForm::validate($new_dir);
			Yii::app()->end();
		}
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-upload-form') {
			echo CActiveForm::validate($new_file);
			Yii::app()->end();
		}

		if (isset($_POST['Files'])) {
			$elem = ($_POST['Files']['is_dir']) ? $new_dir : $new_file;
			$elem->attributes = $_POST['Files'];
			if ($elem->appendTo($dir)) {
				$this->redirect($this->createUrl('user', array('company_id' => $this->company->id, 'dir_id' => $dir_id)));
			}
		}

		$this->render(
			'user',
			array(
				'dir'       => $dir,
				'files'     => $files,
				'new_file'  => $new_file,
				'new_dir'   => $new_dir,
				'ancestors' => $ancestors
			)
		);
	}

	protected function get_cur_dir(&$dir, $dir_id = null, $user_files = false) {
		// Получим текущую директорию
		$criteria = new CDbCriteria();

		if ($user_files) {
			// Файлы пользователя
			$criteria->addCondition('user_id = :user_id');
			$criteria->params[':user_id'] = Yii::app()->user->id;
		}
		else $criteria->addCondition('user_id IS NULL'); // Файлы компании

		$criteria->addCondition('company_id = :company_id');
		$criteria->params[':company_id'] = $this->company->id;
		if ($dir_id) {
			$criteria->addCondition('id = :id'); // поддиректория
			$criteria->params[':id'] = $dir_id;
		} else {
			$criteria->addCondition('lvl = 1'); // Корневая директория
		}

		$dir = Files::model()->find($criteria); // Получили директорию

		if (!$dir && !$dir_id) {
			// Если запрашивали корневую директорию и ее нет - попытаемся ее создать
			$dir = new Files();
			$dir->company_id = $this->company->id;
			if ($user_files) $dir->user_id = Yii::app()->user->id;
			$dir->is_dir = 1;
			$dir->name = $this->company->name;
			if (!$dir->saveNode()) throw new CHttpException(404, 'Не получилось создать корневой элемент.');
		} elseif (!$dir) throw new CHttpException(404, 'Запрошенной директории нет, возможно ее удалили.');
	}
}