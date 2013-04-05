<?php
/**
 * Форма создания / редактирования банковского счета
 */
class BankAccountEditWidget extends CWidget
{
	/**
	 * @var CBankAccount Уведомление, которое нужно вывести
	 */
	public $bank_account = null;
	/**
	 * @var string CSS класс или набор классов через пробел, которые можно дописать к блоку
	 */
	public $class   = '';

	public function run()
	{
		return $this->render('bank_account_edit', array(
			'bank_account' => $this->bank_account,
			'class' => $this->class
		));
	}
}

