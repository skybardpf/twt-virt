<?php

class m130902_050842_files_to_utf8 extends CDbMigration
{
	public function up()
	{
		$this->execute("alter table `files` convert to character set utf8 collate utf8_unicode_ci");
	}

	public function down()
	{
		echo "m130902_050842_files_to_utf8 does not support migration down.\n";
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