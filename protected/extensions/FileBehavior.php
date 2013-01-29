<?php
/**
 * @method CActiveRecord getOwner
 */
class FileBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string название атрибута, хранящего в себе имя файла и файл
	 */
	public $filePathAttributeName = 'file';
	public $fileNameAttributeName = 'name';
	public $fileSizeAttributeName = 'size';

	/**
	 * @var string алиас директории, куда будем сохранять файлы
	 */
	public $savePathAlias = 'userfiles';
	/**
	 * @var array сценарии валидации к которым будут добавлены правила валидации загрузки файлов
	 */
	public $scenarios = array('insert', 'update', 'add', 'edit');
	/**
	 * @var string типы файлов, которые можно загружать (нужно для валидации)
	 */
	public $fileTypes = 'txt,rtf,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,bmp,jpeg,jpg,png,gif,mp4,avi,swf,mkv,wmv,mp3,wav,ogg,wma';

	/**
	 * @var int размер файла
	 */
	public $maxSize = 10485760;

	/**
	 * Шорткат для Yii::getPathOfAlias($this->savePathAlias).DIRECTORY_SEPARATOR. Возвращает путь к директории,
	 * в которой будут сохраняться файлы.
	 * @return string путь к директории, в которой сохраняем файлы
	 */
	public function getSavePath()
	{
		return $this->savePathAlias . DIRECTORY_SEPARATOR;
	}

	/**
	 * Получаем путь до веб-расположения файла
	 * @return string
	 */
	public function getWebPath()
	{
		return Yii::app()->baseUrl.str_replace('.', '/', $this->savePathAlias).'/';
	}

	/**
	 * В атаче припкрепляем валидатор
	 * @param CActiveRecord $owner
	 */
	public function attach($owner)
	{
		parent::attach($owner);

		if (in_array($owner->getScenario(), $this->scenarios)) {
			// добавляем валидатор файла, не забываем в параметрах валидатора указать значение safe как false
			$fileValidator = CValidator::createValidator('file', $owner, $this->filePathAttributeName, array(
				'types' => $this->fileTypes,
				'maxSize' => $this->maxSize,
				'allowEmpty' => false,
				'safe' => false,
			));
			$owner->validatorList->add($fileValidator);
			$lengthValidator = CValidator::createValidator('length', $owner, $this->fileNameAttributeName, array(
				'max' => 120
			));
			$owner->validatorList->add($lengthValidator);
		}
	}

	/**
	 * Сохраняем файл перед сохранением в БД
	 * @param CModelEvent $event
	 * @return bool|void
	 */
	public function beforeSave($event)
	{
		$owner = $this->getOwner();
		if ($file = CUploadedFile::getInstance($this->getOwner(), $this->filePathAttributeName)) {
			// старый файл удалим, потому что загружаем новый
			$this->deleteFile();
			//создадим директорию, если ее нет
			$this->createDir($this->getSavePath());
			//получаем имя файла
			$fileName = $this->resolveFileName($this->getSavePath(), $file->getName());
			// Создаем вложенные папки для файла
			$dir = $this->getSavePath().$this->resolveDir($fileName);

			$owner->setAttribute($this->filePathAttributeName, $dir.$fileName);
			$owner->setAttribute($this->fileNameAttributeName, $file->getName());
			$owner->setAttribute($this->fileSizeAttributeName, $file->getSize());

			if (!$owner->validate(array($this->fileNameAttributeName, $this->fileSizeAttributeName))) {
				$event->isValid = false;
				return false;
			}

			$this->createDir($dir);
			//сохраняем файл
			$this->saveFile($file, $dir.$fileName);
			//выставляем аттрибут у модели
		}
		return true;
	}

	/**
	 * Удаляем файл перед удалением из БД
	 * @param CEvent $event
	 */
	public function beforeDelete($event)
	{
		$this->deleteFile();
	}

	/**
	 * Удаляем файл
	 */
	protected function deleteFile()
	{
		$file = $this->getOwner()->getAttribute($this->filePathAttributeName);
		if (is_file($this->getSavePath().$file)) unlink($this->getSavePath().$file);
	}

	/**
	 * Создание директории
	 * @param $dir
	 * @throws CException
	 */
	protected function createDir($dir)
	{
		if (!is_dir($dir)) {
			if (!mkdir($dir, 0755, true)) {
				throw new CException('Не могу создать директорию для сохранения файла');
			}
		}
	}

	/**
	 * Рекурсивный метод, разрешающий дубликаты файлов.
	 *
	 * @param string $dir
	 * @param string $fileName
	 * @return string
	 */
	protected function resolveFileName($dir, $fileName)
	{
		$file = pathinfo($fileName);
		$fileName = md5($fileName . '_copy_' . time() . '_' . rand() ). '.' . $file['extension'];
		if (file_exists($dir . $this->resolveDir($fileName).$fileName)) {
			$fileName = $this->resolveFileName($dir, $fileName);
		}
		return $fileName;
	}

	/**
	 * Получение вложенных папок для файла по 2 символа на папку, количеством $lvl
	 * Например для файла c4ca4238a0b923820dcc509a6f75849b с $lvl = 2 вернет "c4/ca"
	 *
	 * @param $fileName
	 * @param int $lvl
	 *
	 * @return string
	 */
	protected function resolveDir($fileName, $lvl = 2) {
		$str = array();
		for ($i = 0; $i < $lvl; $i++) {
			$str[] = substr($fileName, $i*2, 2);
		}
		return implode('/', $str).'/';
	}

	/**
	 * Сохраняем файд
	 * @param CUploadedFile $file
	 * @param string $path_to_save
	 * @return bool
	 */
	public function saveFile($file, $path_to_save)
	{
		return $file->saveAs($path_to_save);
	}
}