<?php

class m130822_103153_new extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE files ADD page_kind varchar (50);");
	}

	public function down()
	{
		echo "m130822_103153_new does not support migration down.\n";
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