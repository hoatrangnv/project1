/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-26 15:32:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for withdraw_confirm
-- ----------------------------
DROP TABLE IF EXISTS `withdraw_confirm`;
CREATE TABLE `withdraw_confirm` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(34) COLLATE utf8mb4_unicode_ci NOT NULL,
  `withdrawAmount` double DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `type` enum('clp','btc') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`walletAddress`,`userId`),
  KEY `type` (`type`),
  KEY `userId` (`userId`),
  KEY `updated_at` (`updated_at`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
