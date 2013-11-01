#!/usr/bin/env php
<?php
/**
 * Скрипт вызова консольной команды с любым конфигом, конфиг задается первым параметром без ".php"
 * ./yiic_morph config command action
 * Например ./yiic_morph development migrate create some_new_migration
 *
 * Соответствующий файл конфига config_name.php должен лежать в папке protected/config/console
 */
echo PHP_EOL;
if (isset($_SERVER['argv'][1])) {
	//
	$conf_name = $_SERVER['argv'][1];
	array_splice($_SERVER['argv'], 1, 1);

	$config = dirname(__FILE__).'/config/console/'.$conf_name.'.php';
	if (!file_exists($config)) {
		echo 'Указанного конфига не существует: '.$config.PHP_EOL.PHP_EOL;
    } else {
		require_once('yiic.php');
	}
} else {
	echo 'Использование: php -f yiic_morph <conf_name> [command] [action]'.PHP_EOL.'Или ./yiic_morph ...'.PHP_EOL.PHP_EOL;
}
