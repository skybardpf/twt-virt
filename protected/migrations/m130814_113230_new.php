<?php

class m130814_113230_new extends CDbMigration
{
	public function up()
	{
		$this->execute("/*
Navicat MySQL Data Transfer

Source Server         : luxgen
Source Server Version : 50531
Source Host           : 192.168.0.205:3306
Source Database       : twt-virt-office

Target Server Type    : MYSQL
Target Server Version : 50531
File Encoding         : 65001

Date: 2013-08-14 15:30:34
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_create` datetime NOT NULL,
  `date_edit` datetime NOT NULL,
  `login` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `email` tinytext NOT NULL,
  `block` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `auth_token` (`block`,`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', '2012-08-30 00:14:38', '2012-12-20 16:52:22', 'admin', 'd7be18247b2f8eb1f5f268f305d06bf9', 'bb7ecdb275dcb74434bbc2ef7d3a94e8', 'webmaster@example.com', '0');

-- ----------------------------
-- Table structure for `admin2company`
-- ----------------------------
DROP TABLE IF EXISTS `admin2company`;
CREATE TABLE `admin2company` (
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`company_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `admin2company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `admin2company_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin2company
-- ----------------------------
INSERT INTO `admin2company` VALUES ('1', '1');
INSERT INTO `admin2company` VALUES ('3', '1');
INSERT INTO `admin2company` VALUES ('5', '2');

-- ----------------------------
-- Table structure for `cbank_account`
-- ----------------------------
DROP TABLE IF EXISTS `cbank_account`;
CREATE TABLE `cbank_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `resident` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `account_number` tinytext NOT NULL,
  `bank` tinytext NOT NULL,
  `swift` tinytext,
  `iban` tinytext,
  `bik` tinytext,
  `correspondent` tinytext,
  PRIMARY KEY (`id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `cbank_account_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cbank_account
-- ----------------------------
INSERT INTO `cbank_account` VALUES ('1', '2', '0', '154575374456768757', 'Raiffeisen Bank', 'DJEU45786', '4564654 54df78  5', 'bik1', 'corr1');
INSERT INTO `cbank_account` VALUES ('2', '2', '1', 'acc_num2', 'bank2', 'swift2', 'iban2', 'bik2', 'corr2');
INSERT INTO `cbank_account` VALUES ('6', '2', '0', 'new', 'new_bank', 'new_swift', 'new_iban', null, null);
INSERT INTO `cbank_account` VALUES ('7', '2', '0', '5', '5', '5', '5', null, null);
INSERT INTO `cbank_account` VALUES ('11', '2', '1', 'ddds', 'adwsd', 'qr3rq', 'afwsfw', null, null);
INSERT INTO `cbank_account` VALUES ('15', '1', '1', 'erqwq67555', '3q2467', '241421', '21242', '67', '67');
INSERT INTO `cbank_account` VALUES ('16', '1', '0', 'f', 'f', null, null, null, null);
INSERT INTO `cbank_account` VALUES ('17', '1', '0', 'ytryuy', 'trtretrer', null, null, null, null);
INSERT INTO `cbank_account` VALUES ('18', '1', '0', 'fdfdfsd', 'fdsfdfdf', null, null, null, null);
INSERT INTO `cbank_account` VALUES ('20', '1', '0', 'a', 'a', 'a', 'a', null, null);
INSERT INTO `cbank_account` VALUES ('21', '1', '0', 'b', 'b', 'b', 'b', null, null);
INSERT INTO `cbank_account` VALUES ('22', '1', '1', 'ff', 'ff', 'ff', 'ff', null, null);
INSERT INTO `cbank_account` VALUES ('23', '1', '0', '151654654687654654', 'Дойче Банк', 'пвап', 'впвап', null, null);
INSERT INTO `cbank_account` VALUES ('24', '1', '1', '546666', 'rerfegtg', 'gfgfdgh', 'fgfdgfgd', '6yuuy', 'yuyu');
INSERT INTO `cbank_account` VALUES ('25', '1', '1', 'yy', 'yy', null, null, 'yy', 'yy');
INSERT INTO `cbank_account` VALUES ('26', '1', '0', 'y', 'y', 'y', 'y', null, null);
INSERT INTO `cbank_account` VALUES ('27', '2', '1', 'new', 'new', null, null, '111', '111');
INSERT INTO `cbank_account` VALUES ('28', '2', '1', '6', '6', null, null, '6', '6');
INSERT INTO `cbank_account` VALUES ('29', '9', '0', '33', '33', '33', '33', null, null);
INSERT INTO `cbank_account` VALUES ('37', '25', '1', '222346', '22346', null, null, '22346', '22346');
INSERT INTO `cbank_account` VALUES ('38', '25', '1', '4456', '4456', null, null, '4456', '4456');
INSERT INTO `cbank_account` VALUES ('39', '25', '1', '6', '6', null, null, '656', '6');
INSERT INTO `cbank_account` VALUES ('40', '25', '1', '76', '76', null, null, '76', '76');
INSERT INTO `cbank_account` VALUES ('41', '25', '1', '77', '77', null, null, '77', '77');

-- ----------------------------
-- Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `inn` tinytext,
  `kpp` tinytext,
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `deleted_date` datetime DEFAULT NULL,
  `legal_address` tinytext,
  `actual_address` tinytext,
  `phone` tinytext,
  `email` tinytext,
  `resident` tinyint(3) unsigned DEFAULT NULL,
  `okopf` tinytext,
  `ogrn` tinytext,
  `account_number` tinytext,
  `bank` tinytext,
  `bik` tinytext,
  `correspondent_account` tinytext,
  `vat` tinytext,
  `registration_number` tinytext,
  `registration_date` tinytext,
  `registration_country` tinytext,
  `swift` tinytext,
  `iban` tinytext,
  `position_name1` tinytext,
  `position_owner1` tinytext,
  `position_name2` tinytext,
  `position_owner2` tinytext,
  `position_name3` tinytext,
  `position_owner3` tinytext,
  `f_quote` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', '123123', '123123', '123123', '0', null, '', '', '', '', '1', '', '', '', '', null, null, '', '', '', '', '', '', '', '', '', '', '', '', '50');
INSERT INTO `company` VALUES ('2', 'asdasd', 'asdasd', 'asdasd', '0', null, '', '', '', '', '0', null, null, '', '', null, null, '', '', '', '', '', '', 'Директор', 'Максим', '', '', '', '', '100');
INSERT INTO `company` VALUES ('9', 'qweqwe', 'qweqwe', 'qweqwe', '0', null, '', '', '', '', '0', null, null, '', '', null, null, '', '', '', '', '', '', '', '', '', '', '', '', '0');
INSERT INTO `company` VALUES ('10', 'tyrty', 'reteyrty', 'tryrty', '0', null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, '0');
INSERT INTO `company` VALUES ('25', '11', '', '', '0', null, '', '', '', '', '1', '', '', null, null, null, null, null, null, null, null, null, null, '', '', '', '', '', '', '50');

-- ----------------------------
-- Table structure for `company2sites`
-- ----------------------------
DROP TABLE IF EXISTS `company2sites`;
CREATE TABLE `company2sites` (
  `company_id` int(11) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of company2sites
-- ----------------------------
INSERT INTO `company2sites` VALUES ('2', '1');
INSERT INTO `company2sites` VALUES ('2', '2');
INSERT INTO `company2sites` VALUES ('2', '3');
INSERT INTO `company2sites` VALUES ('2', '4');
INSERT INTO `company2sites` VALUES ('2', '5');
INSERT INTO `company2sites` VALUES ('2', '6');

-- ----------------------------
-- Table structure for `f_files`
-- ----------------------------
DROP TABLE IF EXISTS `f_files`;
CREATE TABLE `f_files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `root` int(10) unsigned NOT NULL DEFAULT '0',
  `lft` int(10) unsigned NOT NULL,
  `rgt` int(10) unsigned NOT NULL,
  `lvl` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `is_recycle` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `recycled_pid` int(10) unsigned DEFAULT NULL,
  `name` tinytext NOT NULL,
  `cdate` datetime NOT NULL,
  `mdate` datetime NOT NULL,
  `deldate` datetime DEFAULT NULL,
  `file` tinytext,
  `size` bigint(20) unsigned NOT NULL DEFAULT '0',
  `is_dir` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `company_id` (`company_id`),
  KEY `root` (`root`),
  KEY `lft` (`lft`,`rgt`),
  KEY `lvl` (`lvl`),
  CONSTRAINT `f_files_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`),
  CONSTRAINT `f_files_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_files
-- ----------------------------
INSERT INTO `f_files` VALUES ('1', '1', '1', '64', '1', '1', null, '0', null, '123123', '2013-01-28 16:30:52', '2013-01-28 16:30:52', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('2', '1', '25', '46', '3', '1', null, '0', null, '12123', '2013-01-28 16:32:08', '2013-01-29 13:26:57', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('3', '1', '2', '3', '2', '1', null, '0', null, 'Не получается.PNG', '2013-01-28 16:32:15', '2013-01-28 16:32:15', null, 'userfiles\\c7/18/c718bf29cd3c00871ef4c56df253d70f.PNG', '450646', '0');
INSERT INTO `f_files` VALUES ('4', '1', '4', '5', '2', '1', null, '0', null, 'newfile.ddd', '2013-01-28 16:32:22', '2013-01-28 17:50:49', null, 'userfiles\\5f/3d/5f3d1a96e319ee66edcd11fb1afd37be.png', '22226', '0');
INSERT INTO `f_files` VALUES ('5', '1', '6', '7', '2', '1', null, '0', null, 'pics-028.jpg', '2013-01-28 16:32:31', '2013-01-28 16:32:31', null, 'userfiles\\d0/35/d035ccfc6e285e4561b6d11a4739b7e1.jpg', '34374', '0');
INSERT INTO `f_files` VALUES ('6', '1', '8', '19', '2', '1', null, '0', null, 'zzzxcz', '2013-01-28 16:32:42', '2013-02-05 14:58:14', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('7', '1', '36', '37', '6', '1', null, '0', null, 'киризантемум.jpg', '2013-01-28 16:32:59', '2013-01-28 17:48:53', null, 'userfiles\\e9/09/e909aab35d052186bc93caee700c7a38.jpg', '879394', '0');
INSERT INTO `f_files` VALUES ('8', '1', '20', '21', '2', '1', null, '0', null, 'world3.png', '2013-01-28 16:34:04', '2013-01-28 16:34:04', null, 'userfiles\\65/60/65601475417df7a6c4acfa8f2ca9ad49.png', '1210730', '0');
INSERT INTO `f_files` VALUES ('9', '9', '1', '6', '1', '1', '1', '0', null, '123123', '2013-01-28 17:51:23', '2013-01-28 17:51:23', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('10', '1', '58', '59', '2', '1', '1', '0', null, 'asdasd2', '2013-01-28 17:51:30', '2013-02-06 14:52:27', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('11', '1', '60', '61', '2', '1', '1', '0', null, 'asdasda', '2013-01-28 19:15:51', '2013-01-28 19:15:51', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('14', '1', '44', '45', '4', '1', null, '0', null, 'DHL_v2.2_df_34_07.zip', '2013-01-29 12:43:17', '2013-01-29 12:43:17', null, 'userfiles\\84/81/8481b6eb8cc86d2908ce04aed24c3516.zip', '11374', '0');
INSERT INTO `f_files` VALUES ('16', '1', '29', '30', '5', '1', null, '0', null, 'DHL_v2.2_df_34_07.zip', '2013-01-29 12:48:17', '2013-01-29 12:48:17', null, 'userfiles\\e2/f0/e2f0eb460542a195a68a836404adcff1.zip', '11374', '0');
INSERT INTO `f_files` VALUES ('17', '1', '39', '40', '5', '1', null, '0', null, 'DHL_v2.2_df_34_07.zip', '2013-01-29 12:48:24', '2013-01-29 12:48:24', null, 'userfiles\\5c/36/5c36f367f44599789d3022d0290b7c04.zip', '11374', '0');
INSERT INTO `f_files` VALUES ('18', '1', '34', '35', '6', '1', null, '0', null, 'DHL_v2.2_df_34_07.zip', '2013-01-29 12:54:24', '2013-01-29 12:54:24', null, 'userfiles\\b7/1e/b71ebacef7b4645ed5d26c71c40a88c9.zip', '11374', '0');
INSERT INTO `f_files` VALUES ('19', '1', '22', '23', '2', '1', null, '0', null, 'DHL_v2.2_df_34_07.zip', '2013-01-29 13:03:19', '2013-01-29 13:03:19', null, 'userfiles\\e1/27/e1271639a0703bca4f73620ffbac23e0.zip', '11374', '0');
INSERT INTO `f_files` VALUES ('26', '1', '24', '47', '2', '1', null, '0', null, 'ad', '2013-01-29 15:02:55', '2013-01-29 15:02:55', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('27', '1', '27', '28', '5', '1', null, '0', null, 'asd', '2013-01-29 15:13:23', '2013-01-29 15:13:23', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('28', '1', '48', '51', '2', '1', null, '0', null, '1', '2013-01-29 15:15:26', '2013-02-05 15:40:40', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('29', '1', '52', '53', '2', '1', null, '0', null, 'world31.png', '2013-01-29 15:15:43', '2013-01-29 15:15:43', null, 'userfiles\\1f/55/1f555b792a849d2098adbac9e28b64c8.png', '1210730', '0');
INSERT INTO `f_files` VALUES ('30', '1', '42', '43', '4', '1', null, '0', null, 'right_mainrubrics.php', '2013-02-04 17:00:17', '2013-02-04 17:00:17', null, 'userfiles\\3d/c7/3dc7da12d8a144d8fb88bdcba87993e4.php', '3057', '0');
INSERT INTO `f_files` VALUES ('32', '1', '26', '31', '4', '1', null, '0', null, 'asd', '2013-02-04 17:18:35', '2013-02-04 17:18:35', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('33', '1', '32', '41', '4', '1', null, '0', null, 'asdasd', '2013-02-04 17:19:07', '2013-02-04 17:19:07', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('34', '1', '56', '57', '2', '1', null, '0', null, 'bb01.gif', '2013-02-05 14:58:29', '2013-02-05 14:58:29', null, 'userfiles\\28/07/2807b0c34e5608efd6d78d0f72a51850.gif', '6182', '0');
INSERT INTO `f_files` VALUES ('35', '1', '33', '38', '5', '1', null, '0', null, 'фыв', '2013-02-05 15:04:04', '2013-02-05 15:04:04', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('36', '1', '54', '55', '2', '1', null, '0', null, 'fffdfsf', '2013-02-05 15:04:34', '2013-02-05 15:04:34', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('60', '60', '1', '2', '1', '1', '1', '1', null, '123123', '2013-02-06 17:28:51', '2013-02-06 17:28:51', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('61', '9', '2', '5', '2', '1', '1', '0', null, 'ads', '2013-02-07 15:07:28', '2013-02-07 15:07:28', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('62', '9', '3', '4', '3', '1', '1', '0', null, 'asda', '2013-02-07 15:21:22', '2013-02-07 15:21:22', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('63', '1', '62', '63', '2', '1', null, '0', null, 'dfg_34_11_win.zip', '2013-02-08 14:26:57', '2013-02-08 14:26:57', null, 'userfiles\\21/95/21956d9017c9ee927b48245f7cccf688.zip', '8120402', '0');
INSERT INTO `f_files` VALUES ('64', '1', '49', '50', '3', '1', null, '0', null, 'DHL_v2.2_df_34_07.zip', '2013-02-08 14:39:37', '2013-02-08 14:39:37', null, 'userfiles\\9d/b9/9db9f52ecaefec5869165255e7d45545.zip', '11374', '0');
INSERT INTO `f_files` VALUES ('67', '67', '1', '2', '1', '1', null, '1', null, '123123', '2013-03-17 11:28:54', '2013-03-17 11:28:54', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('69', '1', '9', '10', '3', '1', null, '0', null, '2.jpg', '2013-03-28 13:22:50', '2013-03-28 13:22:50', null, 'userfiles\\0f/49/0f4904e2c8e575e087e84ad467a95349.jpg', '780831', '0');
INSERT INTO `f_files` VALUES ('70', '1', '11', '12', '3', '1', null, '0', null, 'Jellyfish.jpg', '2013-03-28 13:23:03', '2013-03-28 13:23:03', null, 'userfiles\\b9/39/b9396d66bdc906bddda49f2bc1aa0d23.jpg', '775702', '0');
INSERT INTO `f_files` VALUES ('71', '1', '13', '18', '3', '1', null, '0', null, 'еще папка', '2013-03-28 13:23:18', '2013-03-28 13:23:18', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('72', '1', '14', '15', '4', '1', null, '0', null, 'Lighthouse.jpg', '2013-03-28 13:24:16', '2013-03-28 13:24:16', null, 'userfiles\\c2/d4/c2d4b62f2acebd5ad310b69f4864f9d7.jpg', '561276', '0');
INSERT INTO `f_files` VALUES ('73', '1', '16', '17', '4', '1', null, '0', null, 'Tulips.jpg', '2013-03-28 13:24:40', '2013-03-28 13:24:40', null, 'userfiles\\80/92/80923e67369219a1832f3fb7ef591076.jpg', '620888', '0');
INSERT INTO `f_files` VALUES ('79', '79', '1', '16', '1', '2', null, '0', null, 'asdasd', '2013-04-01 13:01:11', '2013-04-01 13:01:11', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('80', '79', '2', '3', '2', '2', null, '0', null, 'ActiveDateSelect.zip', '2013-04-01 13:01:56', '2013-04-01 13:01:56', null, 'userfiles\\44/c8/44c86e31abe25e08c764cb197c7bdfbc.zip', '4793', '0');
INSERT INTO `f_files` VALUES ('83', '83', '1', '2', '1', '2', null, '1', null, 'asdasd', '2013-04-01 15:05:40', '2013-04-01 15:05:40', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('84', '84', '1', '2', '1', '9', null, '0', null, 'qweqwe', '2013-04-01 15:05:44', '2013-04-01 15:05:44', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('86', '79', '4', '5', '2', '2', null, '0', null, 'Jellyfish.jpg', '2013-04-04 15:49:45', '2013-04-04 15:49:45', null, 'userfiles\\2e/c7/2ec700673ea283283ae721837a32478f.jpg', '775702', '0');
INSERT INTO `f_files` VALUES ('87', '79', '6', '15', '2', '2', null, '0', null, 'Вложенная 1', '2013-04-04 15:50:07', '2013-04-04 15:50:07', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('88', '79', '7', '8', '3', '2', null, '0', null, 'Lighthouse.jpg', '2013-04-04 15:50:22', '2013-04-04 15:50:22', null, 'userfiles\\07/28/0728baeeb74d7719f41b42a56dc5f557.jpg', '561276', '0');
INSERT INTO `f_files` VALUES ('89', '79', '9', '14', '3', '2', null, '0', null, 'Вложенная 2', '2013-04-04 15:50:34', '2013-04-04 15:50:34', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('90', '79', '10', '13', '4', '2', null, '0', null, 'Вложенная 3', '2013-04-04 15:51:31', '2013-04-04 15:51:31', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('91', '79', '11', '12', '5', '2', null, '0', null, 'Вложенная 4', '2013-04-04 15:51:45', '2013-04-04 15:51:45', null, null, '0', '1');
INSERT INTO `f_files` VALUES ('92', '92', '1', '2', '1', '2', '5', '0', null, 'asdasd', '2013-08-12 09:28:30', '2013-08-12 09:28:30', null, null, '0', '1');

-- ----------------------------
-- Table structure for `f_links`
-- ----------------------------
DROP TABLE IF EXISTS `f_links`;
CREATE TABLE `f_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `cdate` datetime NOT NULL,
  `edate` datetime NOT NULL,
  `file_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `file_id` (`file_id`),
  KEY `user_id` (`user_id`),
  KEY `key` (`key`),
  KEY `edate` (`edate`),
  CONSTRAINT `f_links_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `f_files` (`id`),
  CONSTRAINT `f_links_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of f_links
-- ----------------------------
INSERT INTO `f_links` VALUES ('13', 'dcb9569888dfe582de6471e4fe48ac4a', '2013-03-15 18:45:54', '2013-03-15 21:45:54', '34', '1');
INSERT INTO `f_links` VALUES ('44', '4ab65304d07850f5bc605d0fceb2a005', '2013-03-28 15:49:38', '2013-03-28 16:49:38', '72', '5');
INSERT INTO `f_links` VALUES ('46', '520b0ea76b30ec2890fbeb584359a5f7', '2013-03-28 16:31:38', '2013-03-28 19:31:38', '71', '5');
INSERT INTO `f_links` VALUES ('52', '3b010c7ae566b911dbb9ff96a107405f', '2013-03-28 17:30:30', '2013-03-28 18:30:30', '3', '5');
INSERT INTO `f_links` VALUES ('53', 'efde815c237994960b5154a4d4c411ff', '2013-03-28 17:36:01', '2013-03-28 18:36:01', '29', '5');
INSERT INTO `f_links` VALUES ('54', 'd30129075230c98ebec073ae038a6ebc', '2013-03-28 17:36:16', '2013-03-28 18:36:16', '8', '5');
INSERT INTO `f_links` VALUES ('55', '1fdf7203fed56799d2e6c1e0763658c7', '2013-03-28 18:35:23', '2013-03-28 19:35:23', '6', '5');
INSERT INTO `f_links` VALUES ('60', '7a9eec7aa82a11efe9e7f9732c2e8537', '2013-03-29 11:13:47', '2013-03-29 12:13:47', '8', '5');
INSERT INTO `f_links` VALUES ('62', '300b44bef20bd01320a5eff477463bf1', '2013-04-04 15:50:48', '2013-04-04 21:50:48', '87', '5');

-- ----------------------------
-- Table structure for `files`
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(250) DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES ('1', '/upload/map.html', '2');
INSERT INTO `files` VALUES ('2', '/upload/Compressor_of_the_future.gif_ac0054767_187.gif', '2');
INSERT INTO `files` VALUES ('3', '/upload/Reklamnoe_mesto_svobodno_220x137.png', '1');
INSERT INTO `files` VALUES ('4', '/upload/googlemap', '1');
INSERT INTO `files` VALUES ('8', '/upload/googlemap1', '1');

-- ----------------------------
-- Table structure for `images`
-- ----------------------------
DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of images
-- ----------------------------
INSERT INTO `images` VALUES ('5', '/banners/1_page_main');
INSERT INTO `images` VALUES ('6', '/banners/1_page_about');
INSERT INTO `images` VALUES ('7', '/banners/1_page_services');
INSERT INTO `images` VALUES ('8', '/banners/1_page_partners');
INSERT INTO `images` VALUES ('9', '/banners/2_page_main');
INSERT INTO `images` VALUES ('10', '/banners/2_page_about');
INSERT INTO `images` VALUES ('11', null);
INSERT INTO `images` VALUES ('12', null);
INSERT INTO `images` VALUES ('13', null);
INSERT INTO `images` VALUES ('14', null);
INSERT INTO `images` VALUES ('15', null);
INSERT INTO `images` VALUES ('16', null);
INSERT INTO `images` VALUES ('17', '/banners/4_page_main');
INSERT INTO `images` VALUES ('18', null);
INSERT INTO `images` VALUES ('19', null);
INSERT INTO `images` VALUES ('20', null);
INSERT INTO `images` VALUES ('21', null);
INSERT INTO `images` VALUES ('22', null);
INSERT INTO `images` VALUES ('23', null);
INSERT INTO `images` VALUES ('24', null);
INSERT INTO `images` VALUES ('25', null);
INSERT INTO `images` VALUES ('26', null);
INSERT INTO `images` VALUES ('27', null);
INSERT INTO `images` VALUES ('28', null);

-- ----------------------------
-- Table structure for `page_about`
-- ----------------------------
DROP TABLE IF EXISTS `page_about`;
CREATE TABLE `page_about` (
  `show` enum('no','yes') DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `content` text,
  `banner` varchar(250) DEFAULT NULL,
  `title_page` varchar(50) DEFAULT NULL,
  `title_window` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_about
-- ----------------------------
INSERT INTO `page_about` VALUES ('yes', '1', '<p>Контент about</p>', '6', '', 'qq', '1');
INSERT INTO `page_about` VALUES ('yes', '2', '<p>Контент домена d2, страница О компанииdrgdfgf</p>', '10', '', '', '2');
INSERT INTO `page_about` VALUES ('yes', '3', null, '14', null, null, '3');
INSERT INTO `page_about` VALUES ('yes', '4', null, '18', null, null, '4');
INSERT INTO `page_about` VALUES ('no', '5', null, '22', null, null, '5');
INSERT INTO `page_about` VALUES ('no', '6', null, '26', null, null, '6');

-- ----------------------------
-- Table structure for `page_contacts`
-- ----------------------------
DROP TABLE IF EXISTS `page_contacts`;
CREATE TABLE `page_contacts` (
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_contacts
-- ----------------------------
INSERT INTO `page_contacts` VALUES (null, null, 'Петрозаводск', 'yandex', 'yes', '1', '<p>Контент Контакты</p>', 'asd', 'asdasd', '1');
INSERT INTO `page_contacts` VALUES (null, null, 'Смирновская д.3', 'google', 'yes', '2', '<p>content</p>', '', '', '2');
INSERT INTO `page_contacts` VALUES (null, null, null, null, 'yes', '3', null, null, null, '3');
INSERT INTO `page_contacts` VALUES (null, null, null, null, 'no', '4', null, null, null, '4');
INSERT INTO `page_contacts` VALUES (null, null, null, null, 'no', '5', null, null, null, '5');
INSERT INTO `page_contacts` VALUES (null, null, null, null, 'no', '6', null, null, null, '6');

-- ----------------------------
-- Table structure for `page_main`
-- ----------------------------
DROP TABLE IF EXISTS `page_main`;
CREATE TABLE `page_main` (
  `show` enum('no','yes') DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `content` text,
  `banner` varchar(250) DEFAULT NULL,
  `title_page` varchar(50) DEFAULT NULL,
  `title_window` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_main
-- ----------------------------
INSERT INTO `page_main` VALUES ('yes', '1', '<p>Контент.</p>', '5', 'Заголовок страницы', 'Заголовок окна.', '1');
INSERT INTO `page_main` VALUES ('yes', '2', '', '9', '', '', '2');
INSERT INTO `page_main` VALUES ('yes', '3', null, '13', null, null, '3');
INSERT INTO `page_main` VALUES ('yes', '4', '', '17', '', 'dfgf', '4');
INSERT INTO `page_main` VALUES ('yes', '5', null, '21', null, null, '5');
INSERT INTO `page_main` VALUES ('yes', '6', null, '25', null, null, '6');

-- ----------------------------
-- Table structure for `page_partners`
-- ----------------------------
DROP TABLE IF EXISTS `page_partners`;
CREATE TABLE `page_partners` (
  `show` enum('no','yes') DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `content` text,
  `banner` varchar(250) DEFAULT NULL,
  `title_page` varchar(50) DEFAULT NULL,
  `title_window` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_partners
-- ----------------------------
INSERT INTO `page_partners` VALUES ('yes', '1', '<p>Контант Партнеры</p>', '8', 'we', 'we', '1');
INSERT INTO `page_partners` VALUES ('yes', '2', null, '12', null, null, '2');
INSERT INTO `page_partners` VALUES ('yes', '3', null, '16', null, null, '3');
INSERT INTO `page_partners` VALUES ('no', '4', null, '20', null, null, '4');
INSERT INTO `page_partners` VALUES ('no', '5', null, '24', null, null, '5');
INSERT INTO `page_partners` VALUES ('no', '6', null, '28', null, null, '6');

-- ----------------------------
-- Table structure for `page_services`
-- ----------------------------
DROP TABLE IF EXISTS `page_services`;
CREATE TABLE `page_services` (
  `show` enum('no','yes') DEFAULT NULL,
  `site_id` int(11) DEFAULT NULL,
  `content` text,
  `banner` varchar(250) DEFAULT NULL,
  `title_page` varchar(50) DEFAULT NULL,
  `title_window` varchar(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_services
-- ----------------------------
INSERT INTO `page_services` VALUES ('no', '1', '<p>Контент Услуги</p>', '7', '', '', '1');
INSERT INTO `page_services` VALUES ('yes', '2', null, '11', null, null, '2');
INSERT INTO `page_services` VALUES ('yes', '3', null, '15', null, null, '3');
INSERT INTO `page_services` VALUES ('yes', '4', null, '19', null, null, '4');
INSERT INTO `page_services` VALUES ('no', '5', null, '23', null, null, '5');
INSERT INTO `page_services` VALUES ('no', '6', null, '27', null, null, '6');

-- ----------------------------
-- Table structure for `s_message`
-- ----------------------------
DROP TABLE IF EXISTS `s_message`;
CREATE TABLE `s_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `request_id` int(10) unsigned NOT NULL,
  `to_admin` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `cdate` datetime NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `request_id` (`request_id`),
  CONSTRAINT `s_message_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `s_request` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of s_message
-- ----------------------------
INSERT INTO `s_message` VALUES ('1', '1', '1', '2013-01-23 18:43:27', 'Test request message');
INSERT INTO `s_message` VALUES ('2', '1', '0', '2013-01-24 19:12:10', 'Second message');
INSERT INTO `s_message` VALUES ('3', '2', '1', '2013-01-22 19:12:48', 'First request');
INSERT INTO `s_message` VALUES ('4', '2', '0', '2013-01-25 19:12:59', 'New request');
INSERT INTO `s_message` VALUES ('5', '3', '1', '2013-01-24 17:49:53', 'Ну что, техпод, поговорим?');
INSERT INTO `s_message` VALUES ('6', '2', '1', '2013-01-25 11:44:46', 'Отправляем новое сообщение');
INSERT INTO `s_message` VALUES ('7', '2', '1', '2013-01-25 12:00:58', 'Проверка связи. Как слышно? принем!');
INSERT INTO `s_message` VALUES ('8', '2', '0', '2013-01-25 13:43:27', 'Отвечаю, принем нормальный.');
INSERT INTO `s_message` VALUES ('9', '2', '0', '2013-01-28 14:56:04', 'test');
INSERT INTO `s_message` VALUES ('10', '2', '0', '2013-01-28 14:56:10', 'test');
INSERT INTO `s_message` VALUES ('11', '2', '1', '2013-01-28 14:57:11', 'test');
INSERT INTO `s_message` VALUES ('12', '3', '1', '2013-02-07 17:48:45', 'adasd');
INSERT INTO `s_message` VALUES ('13', '1', '0', '2013-02-07 18:11:21', 'Смотри у меня!');
INSERT INTO `s_message` VALUES ('14', '1', '0', '2013-02-07 18:12:34', 'Лучше смотри!');
INSERT INTO `s_message` VALUES ('15', '1', '0', '2013-02-07 18:14:59', 'Совсем круто смотри!');
INSERT INTO `s_message` VALUES ('16', '1', '0', '2013-02-07 18:16:27', 'Сообщение должно остаться новым');
INSERT INTO `s_message` VALUES ('17', '3', '1', '2013-02-08 15:26:23', 'поговорим?');
INSERT INTO `s_message` VALUES ('18', '3', '1', '2013-02-08 15:26:35', 'Чиго?');
INSERT INTO `s_message` VALUES ('19', '3', '1', '2013-02-08 15:31:08', 'еуые');
INSERT INTO `s_message` VALUES ('20', '3', '1', '2013-02-08 15:32:48', 'test');
INSERT INTO `s_message` VALUES ('21', '2', '1', '2013-02-08 15:33:03', 'tetette');
INSERT INTO `s_message` VALUES ('22', '4', '1', '2013-02-11 14:33:26', 'asdasd');
INSERT INTO `s_message` VALUES ('23', '5', '1', '2013-02-11 14:35:55', 'te2');
INSERT INTO `s_message` VALUES ('24', '6', '1', '2013-04-01 14:10:46', 'фывфыв');

-- ----------------------------
-- Table structure for `s_request`
-- ----------------------------
DROP TABLE IF EXISTS `s_request`;
CREATE TABLE `s_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned NOT NULL,
  `opened` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `readed` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cdate` datetime NOT NULL,
  `title` tinytext NOT NULL,
  `l_message_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `l_message_id` (`l_message_id`),
  CONSTRAINT `s_request_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`id`),
  CONSTRAINT `s_request_ibfk_2` FOREIGN KEY (`l_message_id`) REFERENCES `s_message` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of s_request
-- ----------------------------
INSERT INTO `s_request` VALUES ('1', '1', '0', '0', '2013-01-23 18:43:27', 'Test request', '16');
INSERT INTO `s_request` VALUES ('2', '1', '1', '1', '2013-01-22 19:12:34', 'Old request', '21');
INSERT INTO `s_request` VALUES ('3', '1', '0', '1', '2013-01-24 17:49:53', 'Проверяем запрос', '20');
INSERT INTO `s_request` VALUES ('4', '1', '1', '0', '2013-02-11 14:33:26', 'asdasd', '22');
INSERT INTO `s_request` VALUES ('5', '1', '1', '1', '2013-02-11 14:35:55', 'te2', '23');
INSERT INTO `s_request` VALUES ('6', '1', '1', '1', '2013-04-01 14:10:46', 'Здарова', '24');

-- ----------------------------
-- Table structure for `sites`
-- ----------------------------
DROP TABLE IF EXISTS `sites`;
CREATE TABLE `sites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `domain` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `template` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sites
-- ----------------------------
INSERT INTO `sites` VALUES ('1', 'n1', 'd1', '1');
INSERT INTO `sites` VALUES ('2', 'n2', 'd2', '1');
INSERT INTO `sites` VALUES ('3', 'n3', 'd3', '1');
INSERT INTO `sites` VALUES ('4', 'n4', 'd4', '2');
INSERT INTO `sites` VALUES ('5', 'sdfsf', 'sdfsdf', '1');
INSERT INTO `sites` VALUES ('6', 'asdasd', '0sss', '1');

-- ----------------------------
-- Table structure for `templates`
-- ----------------------------
DROP TABLE IF EXISTS `templates`;
CREATE TABLE `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT '',
  `external_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of templates
-- ----------------------------
INSERT INTO `templates` VALUES ('1', 'templ_1', 'Шаблон 1');
INSERT INTO `templates` VALUES ('2', 'templ_2', 'Шаблон 2');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` tinytext NOT NULL,
  `salt` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` tinytext NOT NULL,
  `surname` tinytext NOT NULL,
  `phone` tinytext,
  `active` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `create_user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `create_user_id` (`create_user_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`create_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'asdasd@asdasd.ru', '3a464f90bc5589477014918771d86011', 'f687752eb2ac46251d375f4a6d5ebed7', 'asd', 'asdasd', '5465465487978', '1', null);
INSERT INTO `user` VALUES ('2', 'asdasdasd@asdasd.ru', 'cf7438e8150468c189a37d80e4ae820f', '790b037150265dbf8ab6075000438b13', 'asdasdasd', '234234234', '234234', '1', null);
INSERT INTO `user` VALUES ('3', 'asdfsdfs@asdasd.ru', '21a511ae917c30b07d1d151e1916f1ff', 'd44261376ac8a9695fe8b292a036cf13', 'asdasdq', 'weqwe132a', 'qweqw1423123', '1', null);
INSERT INTO `user` VALUES ('4', 'dfgdfg@asdasd.ru', 'd4f239f9af5ba32d06058df8c2cd3254', '0a28d14bf7f57516ce11797d36550045', 'dfgdfg', 'dfgdfg', 'asdasdasd', '1', null);
INSERT INTO `user` VALUES ('5', 'user1@example.com', 'bb7ecdb275dcb74434bbc2ef7d3a94e8', 'd7be18247b2f8eb1f5f268f305d06bf9', 'user', 'user', '1', '1', null);
INSERT INTO `user` VALUES ('6', 'deleteme@now.u', '16afca464796027f57df3e7aa4461174', 'e33b83fe0b6c49fbf515658e85cc4ee5', 'delete', 'me', '1151551', '1', null);
INSERT INTO `user` VALUES ('10', '11@11.11', '1a3869f0fe5d618479bc7b0621585a1f', '8711666e5837e9b3fa543141ae9d8c3d', '11', '11', '1', '1', null);
INSERT INTO `user` VALUES ('16', 'aa@aa.aa', 'a2b19ecb63a3c15d9840e86d041805c0', '37211ebddb23bbd8bc09ba4e0dff7348', 'aaa', 'aa', '22222222222222', '1', null);

-- ----------------------------
-- Table structure for `user2company`
-- ----------------------------
DROP TABLE IF EXISTS `user2company`;
CREATE TABLE `user2company` (
  `user_id` int(10) unsigned NOT NULL,
  `company_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`company_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `user2company_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `user2company_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user2company
-- ----------------------------
INSERT INTO `user2company` VALUES ('1', '1');
INSERT INTO `user2company` VALUES ('3', '1');
INSERT INTO `user2company` VALUES ('10', '1');
INSERT INTO `user2company` VALUES ('1', '2');
INSERT INTO `user2company` VALUES ('3', '2');
INSERT INTO `user2company` VALUES ('4', '2');
INSERT INTO `user2company` VALUES ('5', '2');
INSERT INTO `user2company` VALUES ('16', '2');
INSERT INTO `user2company` VALUES ('1', '9');
INSERT INTO `user2company` VALUES ('10', '9');
				");
	}

	public function down()
	{
		
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