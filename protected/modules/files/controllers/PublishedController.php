<?php
/**
 * User: Forgon
 * Date: 04.02.13
 */

class PublishedController extends Controller
{
	public $layout = '/layouts/published';

	/**
	 * Получает (по идентификатору и директории, на которую изначально создана временная ссылка) директорию, являющуюся поддиректорией директории, на которую изначально создана временная ссылка
	 * @param null $root_dir - директории, на которую изначально создана временная ссылка
	 * @param null $dir_id - идентификатор директории, которую надо получить
	 * @return mixed
	 */
	private function getDir($root_dir, $dir_id = NULL) {
		if ($root_dir) {
			if ($dir_id) {
				$criteria = new CDbCriteria();
				$criteria->condition = 'is_dir = 1';
				$criteria->addCondition('id = :id');
				$criteria->params = array(':id' => $dir_id);
				$dir = $root_dir->descendants()->find($criteria);
				if ($dir) {
					return $dir;
				} else {
					throw new CHttpException(404, 'Временная ссылка недействительна.');
				}
			} else {
				return $root_dir;
			}
		}
	}

	/**
	 * Показ простому пользователю содержимого временной ссылки
	 *
	 * Отдача файла если временная ссылка на файл и листинг директории - если на директорию.
	 * @param null $key
	 *
	 * @throws CHttpException
	 */
	public function actionShow($key = NULL, $dir_id = NULL) {
		$link = $this->CheckLink($key);
		$file = $this->getDir($link->file, $dir_id);
		if ($link->edate < date('Y-m-d H:i:s', time())) {
			$this->render('error', array('message' => 'Время действия временной ссылки истекло.'));
		} else {
			if ($file->is_dir) {
				$this->render('show', array('link' => $link, 'dir' => $file, 'ancestors' => $file->getAncestors()));
			} else {
				if ($file->is_recycle) {
					$this->render('error', array('message' => 'Извините, запрошенный файл был удален.'));
				} elseif (file_exists($file->file)) {
					Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
				} else {
					Yii::log('Запрошенного файла нет физически id:'.$file->id, CLogger::LEVEL_ERROR, 'files');
					$this->render('error', array('message' => 'Приносим свои извинения, произошла ошибка. Ее исправлением уже занимаются.'));
				}
			}
		}
	}

	/**
	 * Скачивание архива файлов или одного файла из опубликованной папки
	 * @param null $key
	 * @param null $file_id
	 *
	 * @throws CHttpException
	 */
	public function actionDownload($key = NULL, $dir_id = NULL, $file_id = NULL) {
		$link = $this->CheckLink($key);
		$dir = $this->getDir($link->file, $dir_id);
		if ($link->edate < date('Y-m-d H:i:s', time())) {
			$this->render('error', array('message' => 'Время действия временной ссылки истекло.'));
		} else {
			if (empty($_POST['Files']) && $file_id) {
				// Запросили конкретный файл из опубликованной директории.
				$file = $dir->descendants()->findByPk($file_id);
				if (!$file) {
					$this->render('error', array('message' => 'Извините, запрошенный файл был удален.'));
				}
				elseif (file_exists($file->file))  {
					Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
				}
				else {
					Yii::log('Запрошенного файла нет физически id:'.$dir->id, CLogger::LEVEL_ERROR, 'files');
					$this->render('error', array('message' => 'Приносим свои извинения, произошла ошибка. Ее исправлением уже занимаются.'));
				}
			} elseif (!empty($_POST['Files']['id'])) {
				// Запросили архив файлов из опубликованной директории.
				$criteria = new CDbCriteria();
				$criteria->addInCondition('id', $_POST['Files']['id']);
				$files = $dir->descendants()->findAll($criteria);
				if (!$files) {
					$this->render('error', array('message' => 'Извините, один из запрошенных файлов был удален, попробуйте еще раз.'));
					return;
				}

				// Проверим, все ли запрошенные файлы есть в папке.
				$ids = array();
				foreach ($files as $f) { $ids[] = $f->id; }
				if (array_diff($_POST['Files']['id'], $ids)) {
					$this->render('error', array('message' => 'Извините, один из запрошенных файлов был удален, попробуйте еще раз.'));
					return;
				}

				// Создадим, отправим и сотрем архив с файлами.
				$archive = new ZipArchive();
				$dir_name = Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR;
				if (!file_exists($dir_name)) { mkdir($dir_name, 0777, true); }
				$arch_name = tempnam($dir_name, 'yfa');

				// Уже использованные имена файлов и счетчик-имя для файлов, имена которых не получается сконвертировать в cp866
				$files_names = array(); $i = 1;

				if ($archive->open($arch_name , ZipArchive::CREATE) === true) {
					$error = 0;
					try {
						foreach ($files as $file) {

							$string = $file->name; // Имя файла
							$from = mb_strrpos($string, '.'); // начало расширения
							$f_name = $from ? @iconv('utf-8', 'cp866//IGNORE', mb_substr($string, 0, $from)) : ''; // Перекодированное имя файла
							$extension = $from ? @iconv('utf-8', 'cp866//IGNORE', mb_substr($string, $from+1)) : ''; // Перекодированное расширение
							if (!$extension) $extension = '1';

							// Подбор незанятого имени файла
							while(in_array($f_name.'('.$i.').'.$extension, $files_names)) {
								$i++;
							}
							// Регистрация выбранного имени файла как занятого
							$files_names[] = $file_name = $f_name.'('.$i.').'.$extension;

							// Наконец то добавим файл в архив
							if (!$file->is_dir && file_exists($file->file))
								$archive->addFile(realpath($file->file), $file_name);
							elseif ($file->is_dir) {
								throw new FilesException('Произошла ошибка, попробуйте еще раз.');
							} else {
								Yii::log('Запрошенного файла нет физически id:'.$file->id, CLogger::LEVEL_ERROR, 'files');
								throw new FilesException('Приносим свои извинения, произошла ошибка. Ее исправлением уже занимаются.');
							}
						}
					} catch (FilesException $e) {
						$error = 1;
						$this->render('error', array('message' => $e->getMessage));
					} catch (Exception $e) {
						$error = 1;
						$this->render('error', array('message' => 'При создании архива произошла ошибка. Приносим свои извинения.'));
					}
					$archive->close();
					if (!$error) Yii::app()->request->sendFile($dir->name.'.zip', file_get_contents($arch_name), NULL, false);
					unlink($arch_name);
					if (!$error) Yii::app()->end();
					return;
				} else {
					$this->render('error', array('message' => 'При создании архива произошла ошибка. Приносим свои извинения.'));
				}
			} else {
				$this->render('error', array('message' => 'Произошла ошибка, попробуйте еще раз.'));
			}
		}
	}

	/** Проверим доступность временной ссылки
	 * @param $key
	 *
	 * @return FLinks
	 * @throws CHttpException
	 */
	protected function CheckLink($key) {
		if (!$key) throw new CHttpException(404, 'Временная ссылка недействительна.');
		$link = FLinks::model()->with('file')->findByAttributes(array('key' => $key));
		if (!$link) throw new CHttpException(404, 'Временная ссылка недействительна.');
		return $link;
	}

	public function accessRules()
	{
		return array();
	}
}