/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-10-05 15:40:43
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `firstname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is2fa` tinyint(1) DEFAULT '0',
  `refererId` int(10) DEFAULT NULL,
  `google2fa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'henry@cryptolending.org', '$2y$10$jdITI1BMns2uVkgCvOWzheW.8k6vmfeX5sQL2euGEGWwl4hiVdLti', 'BGIwu2dV5AE26Y2A9UFWQHK3M17DDWjVJ68LdpHoWuGh3SPIm2xIGkPPGag7', '2017-08-12 05:47:39', '2017-10-03 13:31:50', '1', 'Henry', 'Ford', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '2N8RNXCGHTWkdimArM27XW9EzUAmri5uVe1', 'Profile', null, null, null, null, '', null, null, '1');
INSERT INTO `users` VALUES ('2', 'huydk', 'huydk1@gmail.com', '$2y$10$JRIVFl42NpIIMiWwd5gsLuaLpePhGgLs79D/0jEcEHBRoVHejuhRe', null, '2017-10-05 15:29:47', '2017-10-05 15:29:47', '0', 'Nguyen', 'Huy', '+841657810999', '0', '1', 'H6CDA5NIIZSY37QE', '0', null, null, null, null, null, null, '84', null, null, '344576');
