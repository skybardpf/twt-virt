<?php

class m131125_081045_drop_old_tables extends CDbMigration
{
	public function up()
	{
        $this->dropTable('company2sites');

        $this->execute('
            ALTER TABLE `templates` RENAME TO  `template` ;
        ');
	}

	public function down()
	{
		echo "m131125_081045_drop_old_tables does not support migration down.\n";
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