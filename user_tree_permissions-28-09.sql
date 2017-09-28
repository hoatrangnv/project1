/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-28 10:01:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for user_tree_permissions
-- ----------------------------
DROP TABLE IF EXISTS `user_tree_permissions`;
CREATE TABLE `user_tree_permissions` (
  `userId` int(10) unsigned NOT NULL,
  `binary` text COLLATE utf8mb4_unicode_ci,
  `genealogy` text COLLATE utf8mb4_unicode_ci,
  `binary_total` int(11) DEFAULT '0',
  `genealogy_total` int(11) DEFAULT '0',
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
