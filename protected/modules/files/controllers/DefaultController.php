<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/owner';
	public function actionIndex($dir_id = null) {
		/** @var $dir Files */
		$dir = NULL;
		$this->get_cur_dir($dir, $dir_id);

		$new_file = NULL;
		$new_dir = NULL;

		$this->new_file($new_file, $new_dir, $dir);

		$this->render(
			'index',
			array(
				'dir'       => $dir,
				'files'     => $dir->listDirectory(),
				'new_file'  => $new_file,
				'new_dir'   => $new_dir,
				'ancestors' => $dir->getAncestors()
			)
		);
	}
	public function actionUser($dir_id = null) {
		$dir = NULL;
		$this->get_cur_dir($dir, $dir_id, true);

		$new_file = NULL;
		$new_dir = NULL;

		$this->new_file($new_file, $new_dir, $dir, true);

		$this->render(
			'user',
			array(
				'dir'       => $dir,
				'files'     => $dir->listDirectory(),
				'new_file'  => $new_file,
				'new_dir'   => $new_dir,
				'ancestors' => $dir->getAncestors()
			)
		);
	}
	public function actionRecycle($dir_id = null) {
		/** @var $dir Files */
		$dir = null;
		$this->get_cur_dir($dir, $dir_id, false, true);

		$this->render(
			'recycle',
			array(
				'dir'       => $dir,
				'files'     => $dir->listDirectory(),
				'ancestors' => $dir->getAncestors()
			)
		);
	}
	public function actionUser_recycle($dir_id = null) {
		/** @var $dir Files */
		$dir = null;
		$this->get_cur_dir($dir, $dir_id, true, true);

		$this->render(
			'user_recycle',
			array(
				'dir'       => $dir,
				'files'     => $dir->listDirectory(),
				'ancestors' => $dir->getAncestors()
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
				echo json_encode(array('error' => 1, 'message' => $file->errors));
				Yii::app()->end();
			}
		}
	}
	/** Скачивание файла */
	public function actionGet_file($file_id = NULL) {
		if (!$file_id) throw new CHttpException(404, 'Указанного файла не существует.');
		$file = Files::model()->findByPk($file_id);
		if (!$file) throw new CHttpException(404, 'Указанного файла не существует.');
		Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
	}

	/** Публикация ссылки на файл/папку
	 * @param null $file_id
	 *
	 * @return int
	 */
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

	/** Перемещение файлов/папок в корзину (AJAX метод)
	 * @param null $file_id
	 *
	 * @return int
	 * @throws FilesException
	 */
	public function actionDelete($file_id = NULL) {
		$ret = array('ret' => 0);
		if (!$file_id) {
			$ret['error'] = 'Указанного файла/папки не существует.';
			$ret['ret'] = 1;
			return $this->ajaxReturn($ret);
		}

		/** @var $file Files */
		$file = Files::model()->findByPk($file_id);
		if (!$file) {
			$ret['error'] = 'Указанного файла/папки не существует.';
			$ret['ret'] = 2;
			return $this->ajaxReturn($ret);
		}

		if ($file->is_recycle) {
			$ret['error'] = 'Файл/папка уже удален(а).';
			$ret['ret'] = 3;
			return $this->ajaxReturn($ret);
		}

		/** @var $recycle Files Папка корзины*/
		$recycle = NULL;
		try {
			$this->get_cur_dir($recycle, NULL, (boolean)$file->user_id, true);
		} catch(Exception $e) {
			$ret['error'] = 'Не удалось получить корзину.';
			$ret['ret'] = 4;
			return $this->ajaxReturn($ret);
		}

		$transaction = Yii::app()->db->beginTransaction();
		try {
			$command = Yii::app()->db->createCommand(
				'UPDATE f_files t
			 LEFT OUTER JOIN f_files as t2 ON t2.root = t.root AND t2.lft < t.lft AND t2.rgt > t.rgt AND t2.lvl = t.lvl - 1
			 SET t.recycled_pid = t2.id, t.is_recycle = 1, t.deldate = :deldate
			 WHERE t.lft >= :file_lft AND t.rgt <= :file_rgt AND t.root = :file_root'
			)->bindValues(array(
				':file_lft'  => $file->lft,
				':file_rgt'  => $file->rgt,
				':file_root' => $file->root,
				':deldate'   => date('Y-m-d H:i:s')
			));
			if (!$command->execute()) {
				throw new FilesException('Ошибка при переносе в корзину.', 5);
			}
			if (!$file->moveAsLast($recycle)) {
				throw new FilesException('Ошибка при переносе в корзину.', 6);
			}
		} catch (Exception $e) {
			$transaction->rollback();
			if (get_class($e) == 'FilesExtension') {
				$ret['ret'] = $e->getCode();
				$ret['error'] = $e->getMessage();
			} else {
				$ret['ret'] = 7;
				$ret['error'] = YII_DEBUG ? 'Ошибка при переносе в корзину.' : $e->getMessage();
			}
			return $this->ajaxReturn($ret);
		}

		$transaction->commit();
		return $this->ajaxReturn($ret);
	}

	public function actionRestore($file_id = NULL) {
		$ret = array('ret' => 0);
		if (!$file_id) {
			$ret['error'] = 'Указанного файла/папки не существует.';
			$ret['ret'] = 1;
			return $this->ajaxReturn($ret);
		}

		/** @var $file Files */
		$file = Files::model()->findByPk($file_id);
		if (!$file) {
			$ret['error'] = 'Указанного файла/папки не существует.';
			$ret['ret'] = 2;
			return $this->ajaxReturn($ret);
		}

		if (!$file->is_recycle) {
			$ret['error'] = 'Файл/папка не в корзине.';
			$ret['ret'] = 3;
			return $this->ajaxReturn($ret);
		}

		/** @var $parent Files */
		$parent = Files::model()->findByPk($file->recycled_pid);
		if (!$parent || $parent->is_recycle) {
			$ret['error'] = $file->is_dir
				? 'Папка не может быть восстановлена, так как папка, в которой она находилась, удалена.'
				: 'Файл не может быть восстановлен, так как папка, в которой он находился, удалена.';
			$ret['ret'] = 4;
			return $this->ajaxReturn($ret);
		}

		if ($parent->children()->findByAttributes(array('name' => $file->name))) {
			$ret['error'] = $file->is_dir
				? 'Папка не может быть восстановлена, так как в папке, в которой она находилась, есть файл/папка с таким же именем.'
				: 'Файл не может быть восстановлен, так как в папке, в которой он находился, есть файл/папка с таким же именем.';
			$ret['ret'] = 5;
			return $this->ajaxReturn($ret);
		}

		$transaction = Yii::app()->db->beginTransaction();
		try {
			$command = Yii::app()->db->createCommand(
				'UPDATE f_files t
			 	SET t.recycled_pid = NULL, t.is_recycle = 0, t.deldate = NULL
			 	WHERE t.lft >= :file_lft AND t.rgt <= :file_rgt AND t.root = :file_root'
			)->bindValues(array(
				':file_lft'  => $file->lft,
				':file_rgt'  => $file->rgt,
				':file_root' => $file->root,
			));
			if (!$command->execute()) {
				throw new FilesException('Ошибка при восстановлении из корзины.', 6);
			}
			if (!$file->moveAsLast($parent)) {
				throw new FilesException('Ошибка при восстановлении из корзины.', 7);
			}
		} catch (Exception $e) {
			$transaction->rollback();
			if (get_class($e) == 'FilesExtension') {
				$ret['ret'] = $e->getCode();
				$ret['error'] = $e->getMessage();
			} else {
				$ret['ret'] = 8;
				$ret['error'] = YII_DEBUG ? 'Ошибка при восстановлении из корзины.' : $e->getMessage();
			}
			return $this->ajaxReturn($ret);
		}

		$transaction->commit();
		return $this->ajaxReturn($ret);
	}
	public function actionRemove($file_id = null) {
		$ret = array('ret' => 0);
		if (!$file_id) {
			$ret['error'] = 'Указанного файла/папки не существует.';
			$ret['ret'] = 1;
			return $this->ajaxReturn($ret);
		}

		/** @var $file Files */
		$file = Files::model()->findByPk($file_id);
		if (!$file) {
			$ret['error'] = 'Указанного файла/папки не существует.';
			$ret['ret'] = 2;
			return $this->ajaxReturn($ret);
		}

		if (!$file->is_recycle) {
			$ret['error'] = 'Файл/папка не в корзине.';
			$ret['ret'] = 3;
			return $this->ajaxReturn($ret);
		}

		$files = $file->descendants()->findAll();
		$files[] = $file;
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$file->deleteNode();
		} catch (Exception $e) {
			$transaction->rollback();
			$ret['error'] = 'Ошибка при удалении файла/папки.';
			$ret['ret'] = 4;
			return $this->ajaxReturn($ret);
		}
		$transaction->commit();
		foreach ($files as $file) {
			if (!$file->is_dir && $file->file) {
				$f_name = realpath($file->file);
				if (file_exists($f_name)) {
					unlink($f_name);
				}
			}
		}
		return $this->ajaxReturn($ret);
	}
	public function actionRemove_all() {
		$ret = array('ret' => 0);

		$dir = null;
		$this->get_cur_dir($dir, null, true, true);
		$files = $dir->descendants()->findAll();
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$dir->deleteNode();
		} catch (Exception $e) {
			$transaction->rollback();
			$ret['error'] = 'Ошибка при удалении файла/папки.';
			$ret['ret'] = 1;
			return $this->ajaxReturn($ret);
		}
		$transaction->commit();
		foreach ($files as $file) {
			if (!$file->is_dir && $file->file) {
				$f_name = realpath($file->file);
				if (file_exists($f_name)) {
					unlink($f_name);
				}
			}
		}
		return $this->ajaxReturn($ret);
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

	/**
	 * Получим текущую директорию в зависимости от окружения (пользовательская/компании, в корзине/нет)
	 *
	 * Если директория корневая (например корневая директория компании или корневая директория пользователя) и ее еще нет в БД - создадим ее и вернем
	 *
	 * @param $dir
	 * @param null $dir_id
	 * @param bool $user_files
	 * @param bool $recycle
	 *
	 * @throws CHttpException
	 */
	protected function get_cur_dir(&$dir, $dir_id = NULL, $user_files = false, $recycle = false) {
		// Получим текущую директорию
		$criteria = new CDbCriteria();

		if ($user_files) {
			// Директория относится к пользовательским
			$criteria->addCondition('user_id = :user_id');
			$criteria->params[':user_id'] = Yii::app()->user->id;
		}
		else $criteria->addCondition('user_id IS NULL'); // Директория компании

		$criteria->addCondition('is_recycle = '.($recycle ? 1 : 0)); // Директория относится к корзине или нет

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
			if ($recycle) $dir->is_recycle = 1;
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

class FilesExtension extends Exception {}