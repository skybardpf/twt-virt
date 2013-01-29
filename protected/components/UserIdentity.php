<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;

	const ERROR_BLOCK = 3;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/** @var $record User */
		$record = User::model()->find(array(
			'select'=>'id, active, password, salt',
			'condition'=>'t.email=:email',
			'params'=>array(':email' => $this->username),
		));

		if ($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
			$this->errorMessage = 'Не получается авторизоваться. Проверьте правильность ввода адреса электронной почты и пароля.';
		} elseif ($record->active == 0) {
			$this->errorCode = self::ERROR_BLOCK;
			$this->errorMessage = 'Ваш аккаунт заблокирован';
		} else if ($record->password !== User::createHash($this->password, $record->salt)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
			$this->errorMessage = 'Не получается авторизоваться. Проверьте правильность ввода адреса электронной почты и пароля.';
		}
		else {
			$this->_id = $record->id;
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}