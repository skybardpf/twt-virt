<?php

class AdminModule extends CWebModule
{
	public $defaultController='admin_user';

	public $startPage = null;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}

	public function getSetting($name)
	{
		if ($this->settings_value === null) {
			$this->settings_value = Settings::model()->getValues();
		}
		if (array_key_exists($name, $this->settings_value) && !empty($this->settings_value[$name])) {
			return $this->settings_value[$name];
		}
		if (array_key_exists($name, $this->settings) && isset($this->settings[$name]['default'])) {
			return $this->settings[$name]['default'];
		}
		return '';
	}
}
