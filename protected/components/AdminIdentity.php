<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class AdminIdentity extends CUserIdentity
{
	private $id;
	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		/** @var $admin AdminUser */
		$admin = AdminUser::Model()->findByAttributes(array('block' => 0, 'login' => $this->username));
		if(!empty($admin) && AdminUser::createHash($this->password, $admin->salt) === $admin->password) {
			$this->id = $admin->id;
			$this->setState('username', $admin->login);
			$this->errorCode = self::ERROR_NONE;
		} else {
			$this->errorMessage = 'Неправильное сочетание логин/пароль';
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->id;
	}
}