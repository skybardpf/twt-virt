<?php
/**
 * User: Forgon
 * Date: 04.02.13
 */

class PublishedController extends Controller
{
	public $layout = '/layouts/published';

	public function actionShow($key = NULL) {
		$link = $this->CheckLink($key);

		if ($link->file->is_dir) {
			$this->render('show', array('link' => $link));
		} else {
			if (file_exists($link->file->file))
				Yii::app()->request->sendFile($link->file->name, file_get_contents($link->file->file));
			else
				throw new CHttpException(404, 'Файла нет на месте.');
		}
	}

	public function actionDownload($key = NULL, $file_id = NULL) {
		$link = $this->CheckLink($key);

		if (empty($_POST['Files']) && $file_id) {
			// Запросили конкретный файл из опубликованной директории.
			$file = $link->file->children()->findByPk($file_id);
			if (!$file) throw new CHttpException(404, 'Временная ссылка недействительна.');
			if (file_exists($file->file)) Yii::app()->request->sendFile($file->name, file_get_contents($file->file));
			else throw new CHttpException(404, 'Файла нет на месте.');
		} elseif (!empty($_POST['Files']['id'])) {
			// Запросили архив файлов из опубликованной директории.
			$criteria = new CDbCriteria();
			$criteria->addInCondition('id', $_POST['Files']['id']);
			$files = $link->file->children()->findAll($criteria);
			if (!$files) throw new CHttpException(404, 'Временная ссылка недействительна.');

			// Создадим, отправим и сотрем архив с файлами.
			$archive = new ZipArchive();
			$dir_name = Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR;
			if (!file_exists($dir_name)) { mkdir($dir_name, 0777, true); }
			$arch_name = tempnam($dir_name, 'yfa');

			// Уже использованные имена файлов и счетчик-имя для файлов, имена которых не получается сконвертировать в cp866
			$files_names = array(); $i = 1;
			if ($archive->open($arch_name , ZipArchive::CREATE) === true) {
				foreach ($files as $file) {
					$f_name = @iconv('utf-8', 'cp866', $file->name);
					if (!$f_name) {
						// Заменим имя файла на первое доступное.
						$from = strrpos($file->name, '.');
						$extension = substr($file->name, $from);
						if (!@iconv('utf-8', 'cp866', $extension)) {
							$extension = '.1';
						}
						while(in_array($i.$extension, $files_names)) {
							$i++;
						}
						$files_names[] = $f_name = $i.$extension;
					} else {
						$files_names[] = $file->name;
					}
					// Наконец то добавим файл в архив
					if (!$file->is_dir && file_exists($file->file))
						$archive->addFile(realpath($file->file), iconv('utf-8', 'cp866', $f_name));
				}
				$archive->close();
				Yii::app()->request->sendFile($link->file->name.'.zip', file_get_contents($arch_name), null, false);
				unlink($arch_name);
				exit;
			} else {
				throw new CHttpException(404, 'При создании архива произошла ошибка. Приносим свои извинения.');
			}
		} else {
			throw new CHttpException(404, 'Временная ссылка недействительна.');
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
		if ($link->edate < date('Y-m-d H:i:s', time())) throw new CHttpException(404, 'Время действия ссылки истекло.');
		return $link;
	}

	public function accessRules()
	{
		return array();
	}
}