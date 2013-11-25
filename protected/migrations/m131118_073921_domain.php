<?php

class m131118_073921_domain extends CDbMigration
{
	public function up()
	{
        $this->execute('
            ALTER TABLE `templates` CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;
            ALTER TABLE `templates` CHANGE COLUMN `name` `name` VARCHAR(100) NOT NULL  , CHANGE COLUMN `external_name` `external_name` VARCHAR(100) NOT NULL  ;
        ');

        $this->execute('
            CREATE TABLE `domain` (
                `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                `company_id` int(11) unsigned NOT NULL COMMENT "ID компании",
                `template_id` int(11) unsigned NOT NULL COMMENT "ID шаблона",
                `domain` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT "Поддомен",
                `name` varchar(50) CHARACTER SET utf8 NOT NULL COMMENT "Внутренее название сайта",

                UNIQUE INDEX `domain` (`domain` ASC),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        ');

        $this->execute('
            ALTER TABLE `domain`
                ADD CONSTRAINT `fk_company_id`
                FOREIGN KEY (`company_id` )
                REFERENCES `company` (`id` )
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
                ADD INDEX `fk_company_id_idx` (`company_id` ASC) ;
        ');

        $this->execute('
            ALTER TABLE `domain`
              ADD CONSTRAINT `fk_template_id`
              FOREIGN KEY (`template_id` )
              REFERENCES `templates` (`id` )
              ON DELETE NO ACTION
              ON UPDATE NO ACTION
            , ADD INDEX `fk_template_id_idx` (`template_id` ASC) ;
        ');

        /**
         * Страницы сайта
         */
        $this->execute("
            CREATE  TABLE IF NOT EXISTS `domain_page` (
              `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
              `domain_id` INT UNSIGNED NOT NULL COMMENT 'Поддомен' ,
              `kind` CHAR(10) NOT NULL COMMENT 'Тип страницы' ,
              `is_show` TINYINT(1) UNSIGNED NOT NULL COMMENT 'Показывать страницу' ,
              `page_title` VARCHAR(100) NOT NULL COMMENT 'Заголовок страницы' ,
              `window_title` VARCHAR(100) NOT NULL COMMENT 'Заголовок окна' ,
              `content` TEXT NOT NULL DEFAULT '' COMMENT 'Содержимое страницы' ,
              `banner` VARCHAR(250) NOT NULL DEFAULT '' COMMENT 'Баннер',
              `logo` VARCHAR(250) NULL DEFAULT NULL COMMENT 'Логотип' ,
              `email` VARCHAR(100) NULL DEFAULT NULL ,
              `adress` VARCHAR(200) NULL DEFAULT NULL ,
              `map` ENUM('yandex','google') NULL DEFAULT NULL ,
              PRIMARY KEY (`id`) ,
              INDEX `kind` (`kind` ASC) ,
              INDEX `site` (`domain_id` ASC) )
            ENGINE = InnoDB
            AUTO_INCREMENT=1
            DEFAULT CHARACTER SET = utf8
            COLLATE = utf8_general_ci
            COMMENT = 'Страница для отображения информации в поддомене компании';
        ");

        $this->execute('
            ALTER TABLE `domain_page`
            ADD CONSTRAINT `fk_domain_page`
            FOREIGN KEY (`domain_id` )
            REFERENCES `domain` (`id` )
            ON DELETE NO ACTION
            ON UPDATE NO ACTION;
        ');
	}

	public function down()
	{
		$this->dropTable('domain');
		$this->dropTable('domain_page');
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