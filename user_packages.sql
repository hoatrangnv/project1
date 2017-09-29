/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-29 15:52:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user_packages`
-- ----------------------------
DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `packageId` int(10) NOT NULL,
  `amount_increase` int(10) NOT NULL,
  `buy_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `release_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `withdraw` tinyint(1) DEFAULT '0',
  `weekYear` int(10) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`) USING BTREE,
  KEY `packageId` (`packageId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_packages
-- ----------------------------
INSERT INTO `user_packages` VALUES ('1', '1', '3', '1000', '2017-09-27 15:13:26', '2018-03-27 15:13:26', '0', '0', '2017-09-29 12:10:44', '2017-09-27 15:13:26');
INSERT INTO `user_packages` VALUES ('2', '1', '5', '4000', '2017-09-27 15:17:14', '2018-03-27 15:17:14', '0', '0', '2017-09-29 12:10:44', '2017-09-27 15:17:14');
INSERT INTO `user_packages` VALUES ('3', '54', '2', '500', '2017-09-20 22:39:59', '2018-03-19 22:39:59', '0', '0', '2017-09-20 22:39:59', '2017-09-20 22:39:59');
INSERT INTO `user_packages` VALUES ('4', '56', '6', '10000', '2017-09-20 22:40:26', '2018-03-19 22:40:26', '0', '0', '2017-09-20 22:40:26', '2017-09-20 22:40:26');
INSERT INTO `user_packages` VALUES ('5', '53', '6', '10000', '2017-09-20 22:48:36', '2018-03-19 22:48:36', '0', '0', '2017-09-20 22:48:36', '2017-09-20 22:48:36');
INSERT INTO `user_packages` VALUES ('6', '57', '4', '2000', '2017-09-20 22:55:35', '2018-03-19 22:55:35', '0', '0', '2017-09-20 22:55:35', '2017-09-20 22:55:35');
INSERT INTO `user_packages` VALUES ('7', '58', '5', '5000', '2017-09-20 22:56:50', '2018-03-19 22:56:50', '0', '0', '2017-09-20 22:56:50', '2017-09-20 22:56:50');
INSERT INTO `user_packages` VALUES ('8', '58', '5', '5000', '2017-09-20 23:00:35', '2018-03-19 23:00:35', '0', '0', '2017-09-20 23:00:35', '2017-09-20 23:00:35');
INSERT INTO `user_packages` VALUES ('9', '62', '6', '10000', '2017-09-20 23:03:52', '2018-03-19 23:03:52', '0', '0', '2017-09-20 23:03:52', '2017-09-20 23:03:52');
