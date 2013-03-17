<?php

class DefaultController extends Controller
{
	public $layout = '/layouts/owner';

	/**
	 * Вывод содержимого папки компании или любой вложенной в ней папки и вызов обработчика создания папки/загрузки файла
	 *
	 * @param null $dir_id
	 */
	public function actionIndex($dir_id = NULL) {
		/** @var $dir Files */
		$dir = NULL;
		$this->get_cur_dir($dir, $dir_id);

		$new_file = NULL; /** @var $new_file Files */
		$new_dir = NULL; /** @var $new_dir Files */
		$this->new_file($new_file, $new_dir, $dir);

		// Получим список временных ссылок для списка
		$files_list = $dir->listDirectory();
		$ids = array();
		if ($files_list) { foreach($files_list as $tmp) {
			$ids[] = $tmp->id;
		} }
		$criteria = new CDbCriteria();
		$criteria->addInCondition('file_id', $ids);
		$criteria->addCondition('user_id = :user_id');
		$criteria->addCondition('edate >= :edate');
		$criteria->params[':user_id'] = Yii::app()->user->id;
		$criteria->params['edate'] = date('Y-m-d H:i:s');
		$links_tmp = FLinks::model()->findAll($criteria);
		$links = array();
		if ($links_tmp) { foreach ($links_tmp as $link) {
			$links[$link->file_id] = $link;
		} }
		unset($links_tmp, $ids, $tmp, $criteria, $link);

		$this->render(
			'index',
			array(
				'dir'       => $dir,
				'files'     => $files_list,
				'new_file'  => $new_file,
				'new_dir'   => $new_dir,
				'links'     => $links,
				'ancestors' => $dir->getAncestors()
			)
		);
	}

	/**
	 * Вывод содержимого пользовательской папки или любой вложенной в ней папки и вызов обработчика создания папки/загрузки файла
	 *
	 * @param null $dir_id
	 */
	public function actionUser($dir_id = NULL) {
		$dir = NULL;
		$this->get_cur_dir($dir, $dir_id, true);

		$new_file = NULL;
		$new_dir = NULL;
		$this->new_file($new_file, $new_dir, $dir, true);

		// Получим список временных ссылок для списка
		$files_list = $dir->listDirectory();
		$ids = array();
		if ($files_list) { foreach($files_list as $tmp) {
			$ids[] = $tmp->id;
		} }
		$criteria = new CDbCriteria();
		$criteria->addInCondition('file_id', $ids);
		$criteria->addCondition('user_id = :user_id');
		$criteria->addCondition('edate >= :edate');
		$criteria->params[':user_id'] = Yii::app()->user->id;
		$criteria->params['edate'] = date('Y-m-d H:i:s');
		$links_tmp = FLinks::model()->findAll($criteria);
		$links = array();
		if ($links_tmp) { foreach ($links_tmp as $link) {
			$links[$link->file_id] = $link;
		} }
		unset($links_tmp, $ids, $tmp, $criteria, $link);

		$this->render(
			'user',
			array(
				'dir'       => $dir,
				'files'     => $dir->listDirectory(),
				'new_file'  => $new_file,
				'new_dir'   => $new_dir,
				'links'     => $links,
				'ancestors' => $dir->getAncestors()
			)
		);
	}

	/**
	 * Вывод содержимого корзины компании или любой вложенной в ней папки
	 * @param null $dir_id
	 */
	public function actionRecycle($dir_id = NULL) {
		/** @var $dir Files */
		$dir = NULL;
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

	/**
	 * Вывод содержимого пользовательской корзины или любой вложенной в ней папки
	 * @param null $dir_id
	 */
	public function actionUser_recycle($dir_id = NULL) {
		/** @var $dir Files */
		$dir = NULL;
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

	/**
	 * AJAX метод переименования файла/папки
	 *
	 * возвращает JSON encoded результат,
	 * error = 0 если все ОК
	 * иначе error = <код ошибки> и message = <описание ошибки>
	 * @param null $file_id
	 *
	 * @throws CHttpException
	 */
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

	/**
	 * Скачивание файла из интерфейса авторизованного пользователя.
	 * @param null $file_id
	 *
	 * @throws CHttpException
	 */
	public function actionGet_file($file_id = NULL) {
		if (!$file_id) throw new CHttpException(404, 'Указанного файла не существует.');
		$file = Files::model()->findByPk($file_id);
		if (!$file) throw new CHttpException(404, 'Указанного файла не существует.');
		Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
	}

	/**
	 * Публикация ссылки на файл/папку
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

	/**
	 * AJAX метод удаления временной ссылки
	 * @param null $file_id
	 */
	public function actionDelete_link($file_id = NULL) {
		$ret = array('ret' => 0);
		if (!$file_id = intval($file_id)) {
			$ret['ret'] = 1;
			$ret['error'] = 'Указанного файла не существует';
			$this->ajaxReturn($ret);
		}
		$criteria = new CDbCriteria();
		$criteria->addCondition('file_id = :file_id');
		$criteria->addCondition('user_id = :user_id');
		$criteria->params[':file_id'] = $file_id;
		$criteria->params[':user_id'] = Yii::app()->user->id;
		/** @var $link FLinks */
		$link = FLinks::model()->find($criteria);
		if (!$link) {
			$ret['ret'] = 2;
			$ret['error'] = 'Ссылки на указанный файл не существует';
		} elseif ($link->edate < date('Y-m-d H:i:s')) {
			$ret['ret'] = 3;
			$ret['error'] = 'Срок действия ссылки на указанный файл истек.';
		} elseif ($link->delete()) {
			$ret['message'] = 'Временная ссылка удалена.';
		} else {
			$ret['ret'] = 4;
			$ret['error'] = 'При удалении временной ссылки произошла ошибка.';
		}
		return $this->ajaxReturn($ret);
	}

	/**
	 * AJAX метод перемещения файлов/папок в корзину
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

	/**
	 * AJAX метод восстановления файла/папки из корзины
	 * @param null $file_id
	 *
	 * @return int
	 * @throws FilesException
	 */
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

	/**
	 * AJAX метод окончательного удаления файла/папки из <b>пользовательской</b> корзины
	 * @param null $file_id
	 *
	 * @return int
	 */
	public function actionRemove($file_id = NULL) {
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

	/**
	 * AJAX метод очищения пользовательской корзины
	 * @return int
	 */
	public function actionRemove_all($user_dir = true) {
		$ret = array('ret' => 0);
		$user_dir = (boolean)$user_dir;

		if (!$user_dir && Yii::app()->user->id != $this->company->admin_user_id) {
			$ret['error'] = 'Вы не являетесь администратором данной компании и не можете удалять файлы из ее корзины.';
			$ret['ret'] = 1;
			return $this->ajaxReturn($ret);
		}

		$dir = NULL;
		$this->get_cur_dir($dir, NULL, $user_dir, true);
		$files = $dir->descendants()->findAll();
		$transaction = Yii::app()->db->beginTransaction();
		try {
			$dir->deleteNode();
		} catch (Exception $e) {
			$transaction->rollback();
			$ret['error'] = 'Ошибка при удалении файла/папки.';
			$ret['ret'] = 1;
			$ret['err_desc'] = $e->getMessage();
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

	public function actionMove($file_id = NULL) {
		$ret = array('ret' => 0);
		if (!$file_id) {
			$ret['ret'] = 1;
			$ret['error'] = 'Выбранного файла/директории не существует.';
			return $this->ajaxReturn($ret);
		}

		/** @var $file Files */
		$file = Files::model()->findByPk($file_id);
		if (!$file) {
			$ret['ret'] = 2;
			$ret['error'] = 'Выбранного файла/директории не существует.';
			return $this->ajaxReturn($ret);
		}
		if ($file->is_recycle) {
			$ret['ret'] = 3;
			$ret['error'] = 'Выбранный файл был удален. Обновите пожалуйста страницу.';
			return $this->ajaxReturn($ret);
		}

		/** @var $dir Files */
		$dir = NULL;
		try {
			$this->get_cur_dir($dir, NULL, (boolean)$file->user_id, false);
		} catch (Exception $e) {
			$ret['ret'] = 4;
			$ret['error'] = $e->getMessage();
			return $this->ajaxReturn($ret);
		}
		if (!$dir) {
			$ret['ret'] = 5;
			Yii::log('Ошибка при получении/создании корневого элемента company_id:'.$file->company_id.' user_id:'.$file->user_id.' recycle:false', CLogger::LEVEL_ERROR);
			$ret['error'] = 'Произошла ошибка. Приносим свои извинения. Мы уже работаем над ее исправлением.';
			return $this->ajaxReturn($ret);
		}

		$values = array(
			':dir_lft'  => $dir->lft,
			':dir_rgt'  => $dir->rgt,
			':dir_root' => $dir->root,
			':file_lft' => $file->lft,
			':file_rgt' => $file->rgt,
		);
		$query = 'SELECT t.id as id, t.name as name, t.lft as lft, t.rgt as rgt, t.lvl as lvl, t2.id as pid
			 FROM f_files t
			 LEFT OUTER JOIN f_files as t2 ON t2.root = t.root AND t2.lft < t.lft AND t2.rgt > t.rgt AND t2.lvl = t.lvl - 1
			 WHERE t.lft > :dir_lft AND t.rgt < :dir_rgt AND t.root = :dir_root AND t.is_dir = 1 AND (t.lft < :file_lft OR t.rgt > :file_rgt)
			 ORDER BY t.lvl ASC, t.name ASC';
		$command = Yii::app()->db->createCommand($query)->bindValues($values);
		try {
			$structure = $command->queryAll(true);
		} catch (Exception $e) {
			$ret['ret'] = 6;
			Yii::log('Ошибка при получении структуры каталогов. Запрос: '.$query.' параметры: '.var_export($values, true), CLogger::LEVEL_ERROR);
			$ret['error'] = 'Произошла ошибка. Приносим свои извинения. Мы уже работаем над ее исправлением.';
			return $this->ajaxReturn($ret);
		}

		if (!$structure) {
			$ret['ret'] = 5;
			$ret['error'] = 'К сожалению, некуда переносить данный файл/папку.';
			return $this->ajaxReturn($ret);
		}
		// Это будет структура каталогов в корневым каталогом в самом верху.
		$struct = array(1 => array('id' => $dir->id, 'lvl' => $dir->lvl, 'pid' => 0, 'name' => $dir->user_id ? 'Личная папка' : 'Папка компании'));
		// Зависимости id и пути в массиве
		$dependencies = array($dir->id => array());
		$i = 2;
		foreach ($structure as $str) {
			$dest = &$struct[1]; // Место назначения элемента (на основе пути до родителя)
			$path = $dependencies[$str['pid']]; // Путь до предка
			if ($path) {
				foreach ($path as $p) {
					$dest = &$dest['childrens'][$p]; // Место назначения элемента (на основе пути до родителя)
				}
			}
			$dest['childrens'][$i] = $str; // Добавим элемент
			$path[] = $i; // Укажем путь к элементу
			$dependencies[$str['id']] = $path; // Добавим в пути
			$i++;
			unset($dest);
		}
		$ret['structure'] = $struct;
		$ret = array(
			'ret'    => 0,
			'title'  => 'Переместить в:',
			'html'   => $this->renderPartial('Move', array('struct' => $struct, 'file' => $file), 1),
			'footer' => $this->renderPartial('MoveFooter', array('file' => $file), 1),
		);
		return $this->ajaxReturn($ret);
	}

	public function actionMove_to($file_id = NULL) {
		$ret = array('ret' => 0);
		// Нет файла
		if (!$file_id) {
			$ret['ret'] = 1;
			$ret['error'] = 'Выбранного файла/директории не существует.';
			return $this->ajaxReturn($ret);
		}

		/** @var $file Files */
		$file = Files::model()->findByPk($file_id);
		// Нет файла
		if (!$file) {
			$ret['ret'] = 2;
			$ret['error'] = 'Выбранного файла/директории не существует.';
			return $this->ajaxReturn($ret);
		}
		// Файл в корзине
		if ($file->is_recycle) {
			$ret['ret'] = 3;
			$ret['error'] = 'Выбранный файл был удален. Обновите пожалуйста страницу.';
			return $this->ajaxReturn($ret);
		}

		// Нет цели
		if (empty($_POST['target_id'])) {
			$ret['ret'] = 4;
			$ret['error'] = 'Папки назначения не существует.';
			return $this->ajaxReturn($ret);
		}
		/** @var $target Files */
		$target = Files::model()->findByPk($_POST['target_id']);
		// Нет цели
		if (!$target) {
			$ret['ret'] = 5;
			$ret['error'] = 'Выбранной папки назначения не существует.';
			return $this->ajaxReturn($ret);
		}
		// Цель в корзине
		if ($target->is_recycle) {
			$ret['ret'] = 6;
			$ret['error'] = 'Выбранная папка назначение была удалена. Обновите пожалуйста страницу.';
			return $this->ajaxReturn($ret);
		}
		// Файл и цель в разных рутах
		if ($target->root != $file->root) {
			$ret['ret'] = 7;
			$ret['error'] = 'Нельзя перемещать файлы/папки между разными компаниями и/или из личной папки в папку компании.';
			return $this->ajaxReturn($ret);
		}
		// Цель - не папка
		if (!$target->is_dir) {
			$ret['ret'] = 8;
			$ret['error'] = 'Нельзя перемещать файлы/папки в файл.';
			return $this->ajaxReturn($ret);
		}
		$check = $target->children()->findByAttributes(array('name' => $file->name));
		if ($check) {
			$ret['ret'] = 9;
			$ret['error'] = 'В выбранной папке уже есть файл/папка с таким именем.';
			return $this->ajaxReturn($ret);
		}
		try {
			$file->moveAsLast($target);
		} catch (Exception $e) {
			$ret['ret'] = 10;
			Yii::log('Ошибка при попытке перенести файл/папку id: '.$file->id.' в папку id: '.$target->id, CLogger::LEVEL_ERROR);
			$ret['error'] = 'Во время перемещения файла/папки произошла ошибка. Приносим свои извинения. Мы уже работаем над ее исправлением.';
			return $this->ajaxReturn($ret);
		}

		// Сообщение об успешном переносе с путем к файлу/папке и ссылкой.
		$path = array($target->user_id ? 'Личная папка' : 'Папка компании');
		foreach($target->ancestors()->findAll() as $ancestor) {
			if ($ancestor->lvl != 1) {
				$path[] = $ancestor->name;
			}
		}
		$ret['message'] = 'Файл/папка был успешно перенесен в '.implode(' / ', $path);
		$ret['link'] = $this->createAbsoluteUrl($target->user_id ? 'user' : 'index', array('company_id' => $target->company_id, 'dir_id' => $target->id));
		return $this->ajaxReturn($ret);
	}

	/**
	 * Создание новой ссылки
	 * @param $file
	 *
	 * @return int
	 */
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

	/**
	 * Показ временной ссылки
	 * @param $link FLinks
	 *
	 * @return int
	 */
	protected function ShowLink($link) {
		$ret = array(
			'ret'         => 0,
			'new'         => 0,
			'link'        => $this->createAbsoluteUrl('//files/published/show', array('key' => $link->key)),
			'remove_link' => '<li><a data-action="delete_link" class="link_delete" href="'.$this->createUrl('delete_link', array('file_id' => $link->file_id, 'company_id' => $this->company->id)).'"><i class="icon-remove"></i>&nbsp;Удалить временную ссылку</a></li>',
			'file_id'     => $link->file_id,
		);
		return $this->ajaxReturn($ret);
	}

	/**
	 * Обработка AJAX запроса - вернуть JSON представление ответа, если включен дебаг - сгенерировать нормальный вывод
	 * @param $ret
	 *
	 * @return int
	 * @throws CHttpException
	 */
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

	/**
	 * Создание моделей для новой папки и файла и обработка POST для их сохранения
	 * @param $new_file
	 * @param $new_dir
	 * @param $dir
	 * @param bool $user_files
	 */
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

	/**
	 * Генерация представления папок в модальном окне для диалога перемещения файла/папки
	 * @param $struct
	 * @param int $lvl
	 *
	 * @return string
	 */
	public function RenderDirs($struct, $lvl = 0) {
		// <ul> или <ul class="dir_hidden"> если уровень род. папки больше 1
		$ret = '<ul class="dir_list'.($lvl > 1 ? ' dir_hidden': '').'">';
		foreach($struct as $str) {
			$ret .= '<li>';
			// Если у папки есть дети, то нужна иконка плюса или минуса (плюс для скрытых папок, минус для раскрытых)

			$ret .= '<i class="'.((isset($str['childrens']) && !empty($str['childrens'])) ? 'dir_expand' : '').
				(($lvl > 0 && isset($str['childrens']) && !empty($str['childrens'])) ? ' icon-folder-close' : ' icon-folder-open').
				'"></i>';

			$ret .= '<span class="dir_target" data-id="'.$str['id'].'">'.$str['name'].'</span>';
			if (isset($str['childrens']) && !empty($str['childrens'])) {
				$ret.= $this->RenderDirs($str['childrens'], $str['lvl']);
			}
			$ret .='</li>';
		}

		$ret .= '</ul>';
		return $ret;
	}
}