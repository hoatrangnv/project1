/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-22 11:00:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for bonus_binary
-- ----------------------------
DROP TABLE IF EXISTS `bonus_binary`;
CREATE TABLE `bonus_binary` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `weeked` int(10) NOT NULL,
  `year` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leftNew` int(10) NOT NULL,
  `rightNew` int(10) NOT NULL,
  `leftOpen` int(10) DEFAULT '0',
  `rightOpen` int(10) DEFAULT '0',
  `settled` int(10) DEFAULT NULL,
  `bonus` int(10) DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  `bonus_tmp` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`,`userId`,`weeked`),
  UNIQUE KEY `weekYear_uid` (`userId`,`weekYear`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
