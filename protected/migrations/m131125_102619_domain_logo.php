<?php

class m131125_102619_domain_logo extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `domain` ADD COLUMN `logo` VARCHAR(250) NOT NULL DEFAULT ''  AFTER `name` ;
        ");
	}

	public function down()
	{
		echo "m131125_102619_domain_logo does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}