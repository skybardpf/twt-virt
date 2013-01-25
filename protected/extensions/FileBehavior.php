<?php
/**
 * @method CActiveRecord getOwner
 */
class FileBehavior extends CActiveRecordBehavior
{
	/**
	 * @var string название атрибута, хранящего в себе имя файла и файл
	 */
	public $attributeName = 'file';
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
			$fileValidator = CValidator::createValidator('file', $owner, $this->attributeName, array(
				'types' => $this->fileTypes,
				'maxSize' => $this->maxSize,
				'allowEmpty' => true,
				'safe' => false,
			));
			$owner->validatorList->add($fileValidator);
		}
	}

	/**
	 * Сохраняем файл перед сохранением в БД
	 * @param CModelEvent $event
	 * @return bool|void
	 */
	public function beforeSave($event)
	{
		if ($file = CUploadedFile::getInstance($this->getOwner(), $this->attributeName)) {
			// старый файл удалим, потому что загружаем новый
			$this->deleteFile();
			//создадим директорию, если ее нет
			$this->createDir($this->getSavePath());
			//получаем имя файла
			$fileName = $this->resolveFileName($this->getSavePath(), $file->getName());
			//сохраняем файл
			$this->saveFile($file, $this->getSavePath() . $fileName);
			//выставляем аттрибут у модели
			$this->getOwner()->setAttribute($this->attributeName, $this->getWebPath() . $fileName);
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
		$file = $this->getOwner()->getAttribute($this->attributeName);
		if (is_file($file)) unlink($file);
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
	 * В случае совпадения, добавляет _copy_time()_rand()
	 * @todo Переписать, так чтобы не было бесконечного количества _copy_time()_rand()_copy_time()_rand()_copy_time()_rand()
	 * @param string $dir
	 * @param string $fileName
	 * @return string
	 */
	protected function resolveFileName($dir, $fileName)
	{
		if (file_exists($dir . $fileName)) {
			$file = pathinfo($fileName);
			$fileName = $this->resolveFileName($dir, $file['filename'] . '_copy_' . time() . '_' . rand() . '.' . $file['extension']);
		}
		return $fileName;
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