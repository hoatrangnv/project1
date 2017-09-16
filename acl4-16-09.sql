/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-16 16:43:22
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
  `leftOpen` int(10) NOT NULL,
  `rightOpen` int(10) NOT NULL,
  `settled` int(10) DEFAULT NULL,
  `bonus` int(10) DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`,`userId`,`weeked`),
  UNIQUE KEY `weekYear_uid` (`userId`,`weekYear`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_binary
-- ----------------------------
INSERT INTO `bonus_binary` VALUES ('2', '2017-08-21 06:58:58', '2017-08-21 07:07:51', '1', '34', '2017', '2000', '0', '0', '0', null, null, '201737');
INSERT INTO `bonus_binary` VALUES ('3', '2017-08-21 07:07:51', '2017-08-21 07:07:51', '4', '34', '2017', '1000', '0', '0', '0', null, null, '201734');

-- ----------------------------
-- Table structure for bonus_faststart
-- ----------------------------
DROP TABLE IF EXISTS `bonus_faststart`;
CREATE TABLE `bonus_faststart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `userId` int(10) NOT NULL,
  `generation` smallint(6) NOT NULL,
  `partnerId` int(10) NOT NULL,
  `amount` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`,`partnerId`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_faststart
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_02_20_233057_create_permission_tables', '1');
INSERT INTO `migrations` VALUES ('4', '2017_02_22_171712_create_posts_table', '1');

-- ----------------------------
-- Table structure for model_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES ('1', '3', 'App\\User');
INSERT INTO `model_has_permissions` VALUES ('2', '3', 'App\\User');
INSERT INTO `model_has_permissions` VALUES ('3', '3', 'App\\User');

-- ----------------------------
-- Table structure for model_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('1', '1', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '2', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('2', '3', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '13', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '14', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '15', 'App\\User');

-- ----------------------------
-- Table structure for packages
-- ----------------------------
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` smallint(6) NOT NULL,
  `token` smallint(6) NOT NULL,
  `replication_time` smallint(6) DEFAULT '0',
  `bonus` double DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `price` (`price`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES ('1', 'vip 1', '2017-08-16 07:06:07', '2017-08-16 08:08:47', null, '100', '1000', '0', '0.1');
INSERT INTO `packages` VALUES ('2', 'vip 2', '2017-08-16 07:06:33', '2017-08-16 07:06:33', null, '500', '500', '0', '0.2');
INSERT INTO `packages` VALUES ('3', 'vip 3', '2017-08-16 07:58:10', '2017-08-16 07:58:10', null, '1000', '1000', '0', '0.3');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
INSERT INTO `password_resets` VALUES ('namhong1983@gmail.com', '$2y$10$p538WLBeIDAUbyJkAeRoI.nZIDzD/NUjVecyVU23sUcg0dZBJbdRG', '2017-09-06 08:25:49');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'view_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('2', 'add_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('3', 'edit_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('4', 'delete_users', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('5', 'view_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('6', 'add_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('7', 'edit_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('8', 'delete_roles', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('21', 'view_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('22', 'add_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('23', 'edit_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');
INSERT INTO `permissions` VALUES ('24', 'delete_packages', 'web', '2017-09-14 04:24:27', '2017-09-14 04:24:27');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Admin', 'web', '2017-09-05 08:55:03', '2017-09-05 08:55:03');
INSERT INTO `roles` VALUES ('2', 'User', 'web', '2017-09-05 08:55:04', '2017-09-05 08:55:04');
INSERT INTO `roles` VALUES ('3', 'view_abc', 'web', '2017-09-05 09:00:15', '2017-09-05 09:00:15');
INSERT INTO `roles` VALUES ('4', 'Member', 'web', '2017-09-08 05:01:29', '2017-09-08 05:01:29');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('1', '1');
INSERT INTO `role_has_permissions` VALUES ('2', '1');
INSERT INTO `role_has_permissions` VALUES ('3', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '1');
INSERT INTO `role_has_permissions` VALUES ('5', '1');
INSERT INTO `role_has_permissions` VALUES ('6', '1');
INSERT INTO `role_has_permissions` VALUES ('7', '1');
INSERT INTO `role_has_permissions` VALUES ('8', '1');
INSERT INTO `role_has_permissions` VALUES ('21', '1');
INSERT INTO `role_has_permissions` VALUES ('22', '1');
INSERT INTO `role_has_permissions` VALUES ('23', '1');
INSERT INTO `role_has_permissions` VALUES ('24', '1');

-- ----------------------------
-- Table structure for sales
-- ----------------------------
DROP TABLE IF EXISTS `sales`;
CREATE TABLE `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `sales_id` int(11) DEFAULT NULL,
  `price_in_btc` float(11,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sales
-- ----------------------------

-- ----------------------------
-- Table structure for users
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
  `active` tinyint(1) NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `passport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', 'Su3hag2IbFRbRLOWCt3KZYVX73oyPayrqlDsWApwfVd6Micma1E9Z3Vatug3', '2017-08-12 05:47:39', '2017-09-15 08:22:03', '1', 'Nguyen', 'Hong', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '2N8RNXCGHTWkdimArM27XW9EzUAmri5uVe1', 'Profile', null, null, null, '', null, null);
INSERT INTO `users` VALUES ('3', 'Edit post', 'namhong19831@gmail.com', '$2y$10$wqZRXikpWIculBupnn0JqeXI7XyRdMmqM8Ftjv84dFNX6r1O7q67i', null, '2017-08-16 04:41:36', '2017-08-21 07:07:51', '1', null, null, null, '0', null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('4', 'member 1', 'namhong192283@gmail.com', '$2y$10$PSN.TnxxjUC4Jf6yvv996e4Ndjup.Mv2mDrBFWYZ.W98B6C4IEfui', null, '2017-08-18 09:21:31', '2017-08-21 07:07:51', '1', null, null, null, '0', null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('5', 'namhong1983', 'namhong19832@gmail.com', '$2y$10$QOdCapR4ku2yJwEEOUeMC.QV6DKQOP73PMJZFp4sccj5bqnX.C.N2', 'jfwHWhsH1AmNnueaqyqANj0lWNRr2Ldf83KZdFXGsOACjWChg02R7BnoRRXI', '2017-08-23 08:35:48', '2017-08-23 08:35:48', '0', 'nam', 'hong', '12345678', '0', null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('6', 'namhong19832', 'namhong198322@gmail.com', '$2y$10$sEm5sZyyEAPpM5Q0InTKjeQ4xs7GQdW4f0pf8Fwx0ZrQGXXo7ujCq', null, '2017-08-23 08:38:30', '2017-08-23 08:38:30', '0', 'namh', 'hong', '12345678', '0', null, null, '1', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('7', 'namhong19831', 'namhong198223@gmail.com', '$2y$10$4tF4nvQ3OfbaqFSTMNUkCeeUk7or0.YcyClgOKETXrtEEM3wApeCK', null, '2017-08-23 08:45:32', '2017-08-23 08:45:32', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('8', 'namhong198312', 'namhong1982232@gmail.com', '$2y$10$HI4Do8kjywbr1UxfOKOSfe4aQBvXKLugvsMlqKhb8ZxvuQDiZGNnO', null, '2017-08-23 08:46:13', '2017-08-23 08:46:13', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('9', 'namhong1983123', 'namhong19822323@gmail.com', '$2y$10$368NgBjaBceYZYBOOERj9.inmTdrMHx0Sduv.Ft0Cux2RvtfjvjQ6', null, '2017-08-23 08:47:07', '2017-08-23 08:47:07', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('10', 'namhong19831232', 'namhong198223223@gmail.com', '$2y$10$/8Cprs.B6wQ9ZWWV/WM/c.lFIt6ID9HTt9X1FpTFs2dozwg184wmq', null, '2017-08-23 08:48:16', '2017-08-23 08:48:16', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('11', 'namhong198312322', 'namhong1982232232@gmail.com', '$2y$10$1xv97CBbsZC/GkhliKDzm.BSUbfqhD5XcGSB0cNgSTrTNIR4EYREO', null, '2017-08-23 08:48:56', '2017-08-23 08:48:56', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('12', 'namhong1983123222', 'namhong19822322322@gmail.com', '$2y$10$Q/lrbrxCADFjbYHESDeMqe7fqfD9L2oxel7l/W8qtQvQlYLWJAXa.', null, '2017-08-23 08:49:25', '2017-08-23 08:49:25', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('13', 'namhong19831232221', 'namhong198223223221@gmail.com', '$2y$10$BIPFHbaM9H76WG2WUstmgO6jp/19lRrXDMHMZgFihDpVpc5peVdDi', null, '2017-08-23 08:50:55', '2017-08-23 08:50:55', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('14', 'namhong198312322212', 'namhong1982232232212@gmail.com', '$2y$10$ZUpxgxXT8FFPCQWGc7rI4O1tS9l/jo.fdSf3OTTGZm.2nXQ43q9DC', '0kDymWgD50KGFvl5AhECSCwF8o7PrZY5g64PCfvpuqCuVmJH5Zk3glwU2wz0', '2017-08-23 08:52:13', '2017-08-23 08:52:13', '0', 'nam', 'hong', '12345678', '0', '1', null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('15', 'namhong1983111', 'namhong198113@gmail.com', '$2y$10$.LyZ0nu2fj3R/ABrpiSfPeNngC/WAMYUp4js.TaN9EDBd6MmKzBQi', 'DkvI5Tqaq6hXaROgJdpuMhesown3pDUWCeg5LKPjfyR2A6ZJBZJRhwbYxchE', '2017-08-24 09:02:29', '2017-08-24 09:02:29', '0', 'sda', 'sdas', '12345678', '0', null, null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('40', 'giangdt', 'giangitman@gmail.com', '$2y$10$AxZJTAAO0XjNY5ELxDkJZOeAxqVpyYCkjVOcD7HOjrwuQRu/Dee9q', null, '2017-09-07 09:33:12', '2017-09-07 09:33:12', '0', 'Giang', 'Do', '0978708981', '0', null, null, '0', null, null, null, null, null, null, null, null);
INSERT INTO `users` VALUES ('41', 'huydk', 'huydk1@gmail.com', '$2y$10$ebT.xwcB0MP5aqJP/dgo8OAUUDXSvoqoBHnpCfF4uOi66IV1Z4bee', null, '2017-09-08 10:08:31', '2017-09-11 03:09:26', '0', 'Nguyen', 'Huy', '1657810999', '0', null, null, '1', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for users_loyalty
-- ----------------------------
DROP TABLE IF EXISTS `users_loyalty`;
CREATE TABLE `users_loyalty` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) NOT NULL,
  `isSilver` tinyint(1) DEFAULT '0',
  `isGold` tinyint(1) DEFAULT '0',
  `isPear` tinyint(1) DEFAULT '0',
  `isEmerald` tinyint(1) DEFAULT '0',
  `isDiamond` tinyint(1) DEFAULT '0',
  `f1Left` int(10) DEFAULT '0',
  `f1Right` int(10) DEFAULT '0',
  `collectSilver` tinyint(1) DEFAULT '0',
  `refererId` int(10) DEFAULT NULL,
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`,`userId`),
  KEY `userId` (`userId`),
  KEY `isSilver` (`isSilver`),
  KEY `isGold` (`isGold`),
  KEY `isPear` (`isPear`),
  KEY `isEmerald` (`isEmerald`),
  KEY `isDiamond` (`isDiamond`),
  KEY `refererId` (`refererId`),
  KEY `leftRight` (`leftRight`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_loyalty
-- ----------------------------
INSERT INTO `users_loyalty` VALUES ('1', '3', '1', '0', '0', '0', '0', '0', '0', '0', '1', 'left');
INSERT INTO `users_loyalty` VALUES ('3', '4', '1', '0', '0', '0', '0', '0', '0', '0', '1', 'left');
INSERT INTO `users_loyalty` VALUES ('4', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for user_coins
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
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_coins
-- ----------------------------
INSERT INTO `user_coins` VALUES ('1', '1GGmXKpWxhnewFshqw7fKKdnMEAf7wjzSy', 'c9750047-5a1e-57aa-95ca-f72a7bd721cc', '0.6', '400', '300.5', '220.2350001', null);
INSERT INTO `user_coins` VALUES ('3', '', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('4', '1JHqPatsSPUskqWp7CQ5RTFBKGdUdBpXCc', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('13', null, '09110c22-b885-5f0f-a0c0-96100356f2e1', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('14', null, 'c74a2b3d-f2db-52cb-b1c8-96a26e65727d', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('15', null, '22b5b1e2-770f-55fc-9f1a-e2c434f70bcc', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('32', null, '8a94958e-4548-561b-8663-aa7dedac6f27', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('33', null, 'e2d1aa72-1f9b-593c-bda3-46f970ce2eb4', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('36', null, '522891a7-0805-58b4-9485-d206be6b01a1', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('37', null, '59a7a357-3882-5895-9353-a3674e65c4be', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('38', '\"14118awchSmiRRmdDm1WiZF9xYgz5ozyQT\"', '9c2e8b92-9660-5598-8afb-67b13bbebb5a', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('39', null, 'e2350748-479d-5fd0-afb6-70f1acaf6d1a', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('40', null, '6b8c9478-db74-55e4-9cd4-bf51bfc589ea', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('41', '2Mt47h823UrKSrnYADJBaeo6jTUJffLirGg', '2Mt47h823UrKSrnYADJBaeo6jTUJffLirGg', '0', '0', '0', '0', '{\"wallet\":{},\"userKeychain\":{\"xpub\":\"xpub661MyMwAqRbcG5C8uJ2zvejYkiT4XBUHPkTakXsg8yTHAJnFWzmwXUNeKEKtvoinPLMzj32j2h3qumpBBcEHkTvBuf4xjqZeWUwPWFMZqrL\",\"xprv\":\"xprv9s21ZrQH143K3b7foGVzZWnpCgca7ikS2XXyx9U4advJHWT6yTTgyg4ATxQvws2rCjAwFMfr6DmEgQKsbAjDxk8eLxUuEUAgD1LGq7kyXHz\",\"ethAddress\":\"0x06b654764e831ee97e8757e805a2a3fc91455d9c\",\"encryptedXprv\":\"{\\\"iv\\\":\\\"HbqtUR2yBQW9Mf\\/sCStfeg==\\\",\\\"v\\\":1,\\\"iter\\\":10000,\\\"ks\\\":256,\\\"ts\\\":64,\\\"mode\\\":\\\"ccm\\\",\\\"adata\\\":\\\"\\\",\\\"cipher\\\":\\\"aes\\\",\\\"salt\\\":\\\"EZm1ccoMrak=\\\",\\\"ct\\\":\\\"SqwFo7JlB9k8MPs3ZT\\/VPjN144iaPZVyOXQPZYyn5C0YwF6l97uKAKtIsAbbL5hsHN39M4Y4AsWcwXOU1FNMPXo04NRfaioXECTyUnDK0agzVdTUezFXgZsr1PcWggG1EQopQVLsWDusYmvoDWWyz36WkGbnDV0=\\\"}\"},\"backupKeychain\":{\"xpub\":\"xpub661MyMwAqRbcGQrc549v6q9pAzBparoMAAY7WfzHNEQziFDSTTbwCq3YC6rJ1gUD2SDYJqoTifjjRXKmZmGYumqLp6zdGxRKHxQMA77djmE\",\"xprv\":\"xprv9s21ZrQH143K3vn8y2cujhD5cxMLBQ5VnwcWiHafott1qStHuvHgf2j4LotBRso3NhLeC7eWYifJs6uPE8RUbWeEhL1W6pYHwF5ePXFsHFo\",\"ethAddress\":\"0xfab59bc4b4ce80e59df96bd6b123c3e4d91d09ac\"},\"bitgoKeychain\":{\"xpub\":\"xpub661MyMwAqRbcEbWLjmtBXQeCuQvCnVR6Atqh52KBCjLXfm6pgDywgRYRV14xd3QVnyTWBaZbHkJU8J7ZyjCDWiJRp6PtnWonNzmb9K8ALqQ\",\"ethAddress\":\"0x8e64b51a163ef7f505b32495b84ebabf49a31090\",\"isBitGo\":true,\"path\":\"m\"},\"warning\":\"Be sure to backup the backup keychain -- it is not stored anywhere else!\"}');

-- ----------------------------
-- Table structure for user_datas
-- ----------------------------
DROP TABLE IF EXISTS `user_datas`;
CREATE TABLE `user_datas` (
  `userId` int(10) unsigned NOT NULL,
  `refererId` int(10) DEFAULT '0',
  `packageId` smallint(6) DEFAULT '0',
  `packageDate` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `walletAddress` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `accountCoinBase` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalBonus` int(10) DEFAULT '0',
  `isBinary` tinyint(1) DEFAULT '0',
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalBonusLeft` int(10) DEFAULT '0',
  `totalBonusRight` int(10) DEFAULT '0',
  `binaryUserId` int(10) DEFAULT '0',
  `lastUserIdLeft` int(10) DEFAULT '0',
  `lastUserIdRight` int(10) DEFAULT '0',
  `leftMembers` int(10) DEFAULT '0',
  `rightMembers` int(10) DEFAULT '0',
  `totalMembers` int(10) DEFAULT '0',
  `loyaltyId` tinyint(2) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  UNIQUE KEY `userId` (`userId`),
  KEY `referrerId` (`refererId`),
  KEY `packageId` (`packageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_datas
-- ----------------------------
INSERT INTO `user_datas` VALUES ('1', '0', '1', '2017-09-16 11:00:07', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', null, '2100', '600', '0', '4', '0', '1', '0', '1', '0', '1');
INSERT INTO `user_datas` VALUES ('3', '1', '2', '2017-09-16 10:59:28', '', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', '', '0', '100', '0', '0', '0', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('4', '1', '1', '2017-09-16 11:00:07', '1JHqPatsSPUskqWp7CQ5RTFBKGdUdBpXCc', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '1000', '0', '1', '4', '4', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('13', '1', '0', null, null, '09110c22-b885-5f0f-a0c0-96100356f2e1', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('14', '1', '0', null, null, 'c74a2b3d-f2db-52cb-b1c8-96a26e65727d', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('15', null, '0', null, null, '22b5b1e2-770f-55fc-9f1a-e2c434f70bcc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('16', null, '0', null, null, 'a7f702c0-13cc-50ea-ae29-79c8efef3c29', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('17', null, '0', null, null, '8c48ceac-928f-5fb0-9bf8-109d61f14840', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('18', null, '0', null, null, 'a1316e99-7de9-5758-837a-3f04727f7b92', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('19', null, '0', null, null, '469e8182-f8ff-55dd-8adf-073c7e22c646', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('20', null, '0', null, null, 'df042440-7b62-592d-9d75-27c46d9aa23f', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('21', null, '0', null, null, '4e1bf5ac-2638-53a3-9cc2-e6aaea850dfe', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('22', null, '0', null, null, 'da01d05c-98cd-5ec6-ac1e-8f9090d575cb', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('23', null, '0', null, null, '4361ab31-69a6-52bd-8e18-b91924a7633c', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('24', null, '0', null, null, '44102297-cf67-5592-8348-338d4e372226', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('25', null, '0', null, null, '4f9e693d-9c71-5cbc-93f6-abbbf82f090e', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('26', null, '0', null, null, 'bb33fd9e-c695-5546-b37f-8f8b2a88e2bc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('27', null, '0', null, null, 'bf384451-ca91-5e12-9f02-39a5b8036457', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('28', null, '0', null, null, '5940befa-d291-50b6-8fb9-a9d8bf150aef', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('29', null, '0', null, null, 'de76ae86-fa8f-57fc-b900-36bbc870bafc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('30', null, '0', null, null, '83c5c57f-1167-55c4-8100-6bbc88b92cab', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('31', null, '0', null, null, '92896cd8-db47-5f21-913b-e4e8dc302bec', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('32', null, '0', null, null, '8a94958e-4548-561b-8663-aa7dedac6f27', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('33', null, '0', null, null, 'e2d1aa72-1f9b-593c-bda3-46f970ce2eb4', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('36', null, '0', null, null, '522891a7-0805-58b4-9485-d206be6b01a1', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('37', null, '0', null, null, '59a7a357-3882-5895-9353-a3674e65c4be', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('38', null, '0', null, null, '9c2e8b92-9660-5598-8afb-67b13bbebb5a', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('39', null, '0', null, null, 'e2350748-479d-5fd0-afb6-70f1acaf6d1a', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('40', null, '0', null, null, '6b8c9478-db74-55e4-9cd4-bf51bfc589ea', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('41', null, '0', null, '2Mt47h823UrKSrnYADJBaeo6jTUJffLirGg', '2Mt47h823UrKSrnYADJBaeo6jTUJffLirGg', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for user_packages
-- ----------------------------
DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages` (
  `userId` int(10) unsigned NOT NULL,
  `packageId` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `userId` (`userId`) USING BTREE,
  KEY `packageId` (`packageId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_packages
-- ----------------------------
INSERT INTO `user_packages` VALUES ('1', '3', '2017-09-15 10:49:56', '2017-09-15 10:49:56');

-- ----------------------------
-- Table structure for wallets
-- ----------------------------
DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletType` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1:usd; 2:btc; 3:clp; 4:reinvest;',
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;3:bonus day;4: bounus f1;5:bonus week',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double unsigned DEFAULT '0',
  PRIMARY KEY (`id`,`type`,`inOut`,`walletType`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wallets
-- ----------------------------
INSERT INTO `wallets` VALUES ('1', null, '2017-08-25 07:56:36', '2017-08-25 07:56:36', '1', '1', null, 'out', '1', '0');
INSERT INTO `wallets` VALUES ('2', null, '2017-08-25 07:56:36', '2017-08-25 07:56:36', '3', '1', null, 'out', '1', '0');
INSERT INTO `wallets` VALUES ('3', null, '2017-08-25 08:01:21', '2017-08-25 08:01:21', '1', '1', null, 'out', '1', '0');
INSERT INTO `wallets` VALUES ('4', null, '2017-08-25 08:01:21', '2017-08-25 08:01:21', '3', '1', null, 'in', '1', '0');
INSERT INTO `wallets` VALUES ('5', null, '2017-08-25 08:09:47', '2017-08-25 08:09:47', '1', '1', null, 'out', '1', '0.1');
INSERT INTO `wallets` VALUES ('6', null, '2017-08-25 08:09:47', '2017-08-25 08:09:47', '3', '1', null, 'in', '1', '0.1');
INSERT INTO `wallets` VALUES ('7', null, '2017-08-25 08:27:55', '2017-08-25 08:27:55', '1', '1', null, 'out', '1', '0.2');
INSERT INTO `wallets` VALUES ('8', null, '2017-08-25 08:27:55', '2017-08-25 08:27:55', '3', '1', null, 'in', '1', '0.2');
INSERT INTO `wallets` VALUES ('9', null, '2017-08-25 08:28:29', '2017-08-25 08:28:29', '1', '1', null, 'out', '1', '0.2');
INSERT INTO `wallets` VALUES ('10', null, '2017-08-25 08:28:29', '2017-08-25 08:28:29', '3', '1', null, 'in', '1', '0.2');
INSERT INTO `wallets` VALUES ('11', null, '2017-08-25 08:54:24', '2017-08-25 08:54:24', '2', '2', null, 'out', '1', '0.2');
INSERT INTO `wallets` VALUES ('12', null, '2017-08-25 08:54:24', '2017-08-25 08:54:24', '3', '2', null, 'in', '1', '0.2');
INSERT INTO `wallets` VALUES ('13', null, '2017-08-25 09:01:48', '2017-08-25 09:01:48', '2', '2', null, 'in', '1', '0.2');
INSERT INTO `wallets` VALUES ('14', null, '2017-08-25 09:01:48', '2017-08-25 09:01:48', '3', '2', null, 'out', '1', '0.2');
INSERT INTO `wallets` VALUES ('15', null, '2017-08-25 09:02:21', '2017-08-25 09:02:21', '2', '2', null, 'in', '1', '0.2');
INSERT INTO `wallets` VALUES ('16', null, '2017-08-25 09:02:21', '2017-08-25 09:02:21', '3', '2', null, 'out', '1', '0.2');
INSERT INTO `wallets` VALUES ('17', null, '2017-08-25 09:04:25', '2017-08-25 09:04:25', '2', '2', null, 'out', '1', '0.1');
INSERT INTO `wallets` VALUES ('18', null, '2017-08-25 09:04:25', '2017-08-25 09:04:25', '3', '2', null, 'in', '1', '0.1');
INSERT INTO `wallets` VALUES ('19', null, '2017-09-13 08:33:19', '2017-09-13 08:33:19', '1', '3', null, 'in', '1', '60');
INSERT INTO `wallets` VALUES ('20', null, '2017-09-13 08:33:19', '2017-09-13 08:33:19', '4', '3', null, 'in', '1', '40');
INSERT INTO `wallets` VALUES ('21', null, '2017-09-13 08:33:48', '2017-09-13 08:33:48', '1', '3', null, 'in', '1', '60');
INSERT INTO `wallets` VALUES ('22', null, '2017-09-13 08:33:48', '2017-09-13 08:33:48', '4', '3', null, 'in', '1', '40');

-- ----------------------------
-- Table structure for withdraws
-- ----------------------------
DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE `withdraws` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(34) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) NOT NULL,
  `amountUSD` int(10) DEFAULT NULL,
  `amountBTC` int(10) DEFAULT NULL,
  `fee` smallint(6) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`walletAddress`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of withdraws
-- ----------------------------
INSERT INTO `withdraws` VALUES ('1', '2017-08-16 07:06:07', '2017-08-16 08:08:47', '', '0', null, null, null, '0');
INSERT INTO `withdraws` VALUES ('2', '2017-08-16 07:06:33', '2017-08-16 07:06:33', '', '0', null, null, null, '0');
INSERT INTO `withdraws` VALUES ('3', '2017-08-16 07:58:10', '2017-08-16 07:58:10', '', '0', null, null, null, '0');
