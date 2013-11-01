<?php

class m131101_093633_user_email extends CDbMigration
{
	public function up()
	{
        $this->execute('
            CREATE TABLE IF NOT EXISTS `user_emails` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
              `user_id` int(11) unsigned NOT NULL,
              `site_id` int(11) unsigned NOT NULL,
              `login_email` varchar(100) NOT NULL,
              `password` varchar(30) NOT NULL,
              PRIMARY KEY (`id`),
              UNIQUE KEY `uniq_email` (`user_id`,`site_id`,`login_email`),
              KEY `user_id` (`user_id`),
              KEY `site_id` (`site_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8

        ');
	}

	public function down()
	{
		$this->dropTable('user_emails');
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