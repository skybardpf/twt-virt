<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/owner';
	public function actionIndex($dir_id = null) {
		$dir = null;
		$this->get_cur_dir($dir, $dir_id);

		// Файлы директории
		$criteria = new CDbCriteria();
		$criteria->order = 'is_dir DESC, name ASC';
		$files = $dir->children()->findAll($criteria);

		// Путь до директории
		$criteria = new CDbCriteria();
		$criteria->order = 'lft ASC';
		$criteria->condition = 'is_dir = 1';
		$ancestors = $dir->ancestors()->findAll($criteria);

		$new_file = null;
		$new_dir = null;

		$this->new_file($new_file, $new_dir, $dir);

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
		$dir = null;
		$this->get_cur_dir($dir, $dir_id, true);

		// Файлы директории
		$criteria = new CDbCriteria();
		$criteria->order = 'is_dir DESC, name ASC';
		$files = $dir->children()->findAll($criteria);

		// Путь до директории
		$criteria = new CDbCriteria();
		$criteria->order = 'lft ASC';
		$criteria->condition = 'is_dir = 1';
		$ancestors = $dir->ancestors()->findAll($criteria);

		$new_file = null;
		$new_dir = null;

		$this->new_file($new_file, $new_dir, $dir, true);

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
	public function actionRename($file_id = null) {
		if (!$file_id) throw new CHttpException(404, 'Указанного файла не существует.');

		if ($_POST['ajax'] && $_POST['ajax'] == 'index_rename') {
			$file = Files::model()->findByPk($file_id);
			$file->setScenario('rename');
			if (!$file) {
				echo json_encode(array('error' => 1, 'message' => 'Указанного файла не существует.'));
				Yii::app()->end();
			}
			$file->name = trim($_POST['name']);
			$dir = $file->parent()->find();
			if ($file->saveNode()) {
				echo json_encode(array('error' => 0, 'link' => $this->createUrl($file->user_id?'user':'index', array('company_id' => $file->company_id, 'dir_id' => $dir->id))));
				Yii::app()->end();
			} else {
				echo json_encode(array('error' => 1, 'message' => $file->errors['name']));
				Yii::app()->end();
			}
		}

	}
	public function actionGet_file($file_id = null) {
		if (!$file_id) throw new CHttpException(404, 'Указанного файла не существует.');
		$file = Files::model()->findByPk($file_id);
		if (!$file) throw new CHttpException(404, 'Указанного файла не существует.');
		Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
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

	protected function new_file(&$new_file, &$new_dir, $dir, $user_files = false) {
		$new_file = new Files();
		$new_dir = new Files('insert', 1);

		$new_dir->setScenario('new_dir');
		$new_file->setScenario('new_file');
		$new_dir->company_id = $new_file->company_id = $this->company->id;
		if ($user_files) $new_dir->user_id = $new_file->user_id = Yii::app()->user->id;

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
			$elem->parent_elem = $dir;
			if ($elem->appendTo($dir)) {
				$this->redirect($this->createUrl($user_files ? 'user' : 'index', array('company_id' => $this->company->id, 'dir_id' => $dir->id)));
			}
		}
	}
}