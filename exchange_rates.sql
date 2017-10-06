/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-04 17:34:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `exchange_rates`
-- ----------------------------
DROP TABLE IF EXISTS `exchange_rates`;
CREATE TABLE `exchange_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_currency` char(30) NOT NULL,
  `exchrate` double NOT NULL,
  `to_currency` char(30) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exchange_rates
-- ----------------------------
INSERT INTO `exchange_rates` VALUES ('1', 'clp', '1.12', 'usd', '2017-10-04 17:34:33', '2017-10-04 17:34:33', null);
INSERT INTO `exchange_rates` VALUES ('2', 'btc', '4210', 'usd', '2017-10-04 17:34:33', '2017-10-04 17:34:33', null);
INSERT INTO `exchange_rates` VALUES ('3', 'clp', '0.0002660332541567696', 'btc', '2017-10-04 17:34:33', '2017-10-04 17:34:33', null);
