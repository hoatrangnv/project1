/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-29 14:07:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `user_coins`
-- ----------------------------
DROP TABLE IF EXISTS `user_coins`;
CREATE TABLE `user_coins` (
  `userId` int(10) unsigned NOT NULL,
  `walletAddress` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountCoinBase` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btcCoinAmount` double unsigned DEFAULT '0',
  `clpCoinAmount` double unsigned DEFAULT '0',
  `usdAmount` double unsigned DEFAULT '0',
  `reinvestAmount` double unsigned DEFAULT '0',
  `backupKey` text COLLATE utf8mb4_unicode_ci,
  `availableAmount` double DEFAULT NULL,
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_coins
-- ----------------------------
INSERT INTO `user_coins` VALUES ('1', '1GGmXKpWxhnewFshqw7fKKdnMEAf7wjzSy', 'c9750047-5a1e-57aa-95ca-f72a7bd721cc', '0.6', '668.8739999999998', '102000', '304.2', null, '19');
INSERT INTO `user_coins` VALUES ('2', 'test', 'test', '0', '15535.714285714286', '810', '533.5999999999999', null, '0');
INSERT INTO `user_coins` VALUES ('3', 'test', 'test', '0', '19910.714285714286', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('4', 'test', 'test', '0', '19553.571428571428', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('5', 'test', 'test', '0', '19107.14285714286', '420', '280', null, null);
INSERT INTO `user_coins` VALUES ('6', 'test', 'test', '0', '18214.285714285714', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('7', 'test', 'test', '0', '15535.714285714286', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('8', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('9', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('10', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('11', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('12', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('13', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('14', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('15', 'test', 'test', '0', '11071.428571428572', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('16', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('17', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('18', 'test', 'test', '0', '19553.571428571428', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('19', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('20', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('21', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('22', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('23', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('24', 'test', 'test', '0', '20000', '0', '0', null, null);
INSERT INTO `user_coins` VALUES ('25', 'test', 'test', '0', '20000', '0', '0', null, null);
