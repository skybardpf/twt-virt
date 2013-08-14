<?php

class m130814_105205_create_db extends CDbMigration
{
	public function up()
	{
		$this->createCommand("CREATE TABLE `templates` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `name` varchar(100) DEFAULT '',
							  `external_name` varchar(100) DEFAULT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
		
		$this->createCommand("INSERT INTO `templates` VALUES ('1', 'templ_1', 'Шаблон 1')");
		$this->createCommand("INSERT INTO `templates` VALUES ('2', 'templ_2', 'Шаблон 2')");
		
		$this->createCommand("CREATE TABLE `files` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `file` varchar(250) DEFAULT NULL,
							  `site_id` int(11) DEFAULT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `images` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `file` varchar(250) DEFAULT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `page_about` (
							  `show` enum('no','yes') DEFAULT NULL,
							  `site_id` int(11) DEFAULT NULL,
							  `content` text,
							  `banner` varchar(250) DEFAULT NULL,
							  `title_page` varchar(50) DEFAULT NULL,
							  `title_window` varchar(50) DEFAULT NULL,
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `page_contacts` (
							  `banner` int(11) DEFAULT NULL,
							  `email` varchar(50) DEFAULT NULL,
							  `address` varchar(200) DEFAULT NULL,
							  `map` enum('yandex','google') DEFAULT NULL,
							  `show` enum('no','yes') DEFAULT NULL,
							  `site_id` int(11) DEFAULT NULL,
							  `content` text,
							  `title_page` varchar(50) DEFAULT NULL,
							  `title_window` varchar(50) DEFAULT NULL,
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `page_main` (
							  `show` enum('no','yes') DEFAULT NULL,
							  `site_id` int(11) DEFAULT NULL,
							  `content` text,
							  `banner` varchar(250) DEFAULT NULL,
							  `title_page` varchar(50) DEFAULT NULL,
							  `title_window` varchar(50) DEFAULT NULL,
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `page_partners` (
							  `show` enum('no','yes') DEFAULT NULL,
							  `site_id` int(11) DEFAULT NULL,
							  `content` text,
							  `banner` varchar(250) DEFAULT NULL,
							  `title_page` varchar(50) DEFAULT NULL,
							  `title_window` varchar(50) DEFAULT NULL,
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `page_services` (
							  `show` enum('no','yes') DEFAULT NULL,
							  `site_id` int(11) DEFAULT NULL,
							  `content` text,
							  `banner` varchar(250) DEFAULT NULL,
							  `title_page` varchar(50) DEFAULT NULL,
							  `title_window` varchar(50) DEFAULT NULL,
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
		
		$this->createCommand("CREATE TABLE `sites` (
							  `id` int(11) NOT NULL AUTO_INCREMENT,
							  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
							  `domain` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
							  `template` int(11) DEFAULT NULL,
							  PRIMARY KEY (`id`)
							) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8");
	}

	public function down()
	{
		echo "m130814_105205_create_db does not support migration down.\n";
		
		$this->createCommand("DROP TABLE IF EXISTS `files`");
		$this->createCommand("DROP TABLE IF EXISTS `templates`");
		$this->createCommand("DROP TABLE IF EXISTS `images`");
		$this->createCommand("DROP TABLE IF EXISTS `page_about`");
		$this->createCommand("DROP TABLE IF EXISTS `page_main`");
		$this->createCommand("DROP TABLE IF EXISTS `page_partners`");
		$this->createCommand("DROP TABLE IF EXISTS `page_services`");
		$this->createCommand("DROP TABLE IF EXISTS `page_contacts`");
		$this->createCommand("DROP TABLE IF EXISTS `sites`");
		
		return true;
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