<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/owner';
	public function actionIndex($dir_id = NULL) {
		$dir = NULL;
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

		$new_file = NULL;
		$new_dir = NULL;

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
	public function actionUser($dir_id = NULL) {
		$dir = NULL;
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

		$new_file = NULL;
		$new_dir = NULL;

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
	public function actionRecycle() {

	}

	public function actionRename($file_id = NULL) {
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
				echo json_encode(array('error' => 1, 'message' => $file->errors));
				Yii::app()->end();
			}
		}

	}
	public function actionGet_file($file_id = NULL) {
		if (!$file_id) throw new CHttpException(404, 'Указанного файла не существует.');
		$file = Files::model()->findByPk($file_id);
		if (!$file) throw new CHttpException(404, 'Указанного файла не существует.');
		Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
	}
	public function actionPublish_link($file_id = NULL) {
		$ret = array('ret' => 0);
		if (!$file_id) {
			$ret['ret'] = 1;
			$ret['error'] = 'Указанного файла не существует';
			$this->ajaxReturn($ret);
		}

		$file = Files::model()->with('links')->findByPk($file_id);
		if (!$file) {
			$ret['ret'] = 2;
			$ret['error'] = 'Указанного файла не существует';
			return $this->ajaxReturn($ret);
		}

		if (!$file->links) {
			// Диалог создания новой ссылки
			return $this->CreateLink($file);
		} else{
			$compare_date = date('Y-m-d H:i:s', time());
			foreach($file->links as $link) {
				if ($link->user_id == Yii::app()->user->id && $link->edate > $compare_date) {
					return $this->ShowLink($link);
				}
			}
			$this->CreateLink($file);
		}

	}

	/** Создание новой ссылки */
	protected function CreateLink($file) {
		$model = new FLinks('create');
		if (isset($_POST['FLinks'])) {
			$model->attributes = $_POST['FLinks'];
			if ($model->validate()) {
				$model->edate   = date('Y-m-d H:i:s', time()+$model->duration);
				$model->user_id = Yii::app()->user->id;
				$model->file_id = $file->id;
				$model->key     = $model->generateKey();
				if ($model->save()) {
					return $this->ShowLink($model);
				}
			}
		}

		$ret = array(
			'ret'    => 0,
			'new'    => 1,
			'title'  => 'Создать временную ссылку:',
			'html'   => $this->renderPartial('LinkCreate', array('model' => $model), 1),
			'footer' => $this->renderPartial('LinkCreateFooter', array('model' => $model), 1),
		);
		return $this->ajaxReturn($ret);
	}
	/** Показ временной ссылки */
	protected function ShowLink($link) {
		$ret = array(
			'ret'    => 0,
			'new'    => 0,
			'link'   => $this->createAbsoluteUrl('//files/published/show', array('key' => $link->key))
		);
		return $this->ajaxReturn($ret);
	}

	/** Обработка AJAX запроса - вернуть JSON представление ответа, если включен дебаг - сгенерировать нормальный вывод */
	protected function ajaxReturn($ret) {
		if (Yii::app()->request->isAjaxRequest) {
			echo json_encode($ret);
			Yii::app()->end();
		} elseif (YII_DEBUG) {
			CVarDumper::dump($ret, 3, 1);
			$this->renderText('Вывод сгенерирован для разработчика. Отключите директиву YII_DEBUG если вы не хотите видеть это сообщение.');
			return 0;
		}
		throw new CHttpException(404, 'Доступно только через AJAX запрос');
	}

	protected function get_cur_dir(&$dir, $dir_id = NULL, $user_files = false) {
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
			$dir = new Files('insert', 1);
			$dir->company_id = $this->company->id;
			if ($user_files) $dir->user_id = Yii::app()->user->id;
			$dir->is_dir = 1;
			$dir->name = $this->company->name;
			if (!$dir->saveNode()) throw new CHttpException(404, 'Не получилось создать корневой элемент.');
		} elseif (!$dir) throw new CHttpException(404, 'Запрошенной директории нет, возможно ее удалили.');
	}

	protected function new_file(&$new_file, &$new_dir, $dir, $user_files = false) {
		$new_file = new Files();
		$new_dir = new Files('new_dir');
		$new_dir->is_dir = 1;

		$new_file->description = 'new_file';
		$new_dir->description = 'new_dir';

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