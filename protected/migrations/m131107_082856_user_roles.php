<?php

class m131107_082856_user_roles extends CDbMigration
{
	public function up()
	{
        $this->execute("
            ALTER TABLE `user`
            ADD COLUMN `role` CHAR(13) NOT NULL DEFAULT 'user'
            AFTER `id`,
            ADD INDEX `role` (`role` ASC);
        ");

        /**
         * Назначаем администратора компании.
         */
        $this->execute("
            UPDATE `user` u, `admin2company` ac SET u.role='company_admin'
            WHERE ac.user_id=u.id;
        ");

        /**
         * Создаем супер администратора.
         */
        $this->insert('user', array(
            'email' => 'admin@ioffice-on.com',
            'role' => 'administrator',
            'salt' => '3a0322546d7b18c4e37f34f61667779a',
            'password' => '9e35259b7d3b9775914615bb6c0be51d',
            'name' => 'Admin',
            'surname' => 'TWT',
        ));
	}

	public function down()
	{
        $this->delete('user', 'role=:role', array(
            ':role' => 'administrator',
        ));
        $this->execute("ALTER TABLE `user` DROP COLUMN `role`, DROP INDEX `role` ;");
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