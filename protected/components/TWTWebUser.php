<?php
/**
 * @property User $data Пользователь системы
 */
class TWTWebUser extends CWebUser
{
	/**
	 * @var User
	 */
	private $_data = null;

	/**
	 * Получаем пользователя
	 * @return User
	 */
	public function getData()
	{
		if (!$this->_data && $this->getId()) {
			$data = User::model()->findByPk($this->getId());
			if (!$data) {
				$this->logout(true);
				Yii::app()->request->redirect(Yii::app()->homeUrl);
			}
			$this->_data = $data;
		}
		return $this->_data;
	}

	/**
	 * Функция выполняется при каждой инициализации (каждый заход на страницу)
	 */
	public function init()
	{
		parent::init();
		// Если пользователь заблокирован, выбрасываем его
		if ($this->data && !$this->data->active) {
			$this->logout();
		}
	}
}