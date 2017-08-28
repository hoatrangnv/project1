/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-08-28 10:07:26
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
INSERT INTO `bonus_binary` VALUES ('2', '2017-08-21 06:58:58', '2017-08-21 07:07:51', '1', '34', '2017', '2000', '0', '0', '0', null, null, '201734');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_faststart
-- ----------------------------
INSERT INTO `bonus_faststart` VALUES ('1', '2017-08-16 07:06:07', '2017-08-16 08:08:47', '1', '0', '1', null);
INSERT INTO `bonus_faststart` VALUES ('2', '2017-08-16 07:06:33', '2017-08-16 07:06:33', '1', '0', '1', null);
INSERT INTO `bonus_faststart` VALUES ('3', '2017-08-16 07:58:10', '2017-08-16 07:58:10', '1', '0', '1', null);
INSERT INTO `bonus_faststart` VALUES ('4', '2017-08-21 03:46:32', '2017-08-21 03:46:32', '1', '1', '1', '100');
INSERT INTO `bonus_faststart` VALUES ('5', '2017-08-21 03:46:32', '2017-08-21 03:46:32', '1', '1', '1', '20');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `price` (`price`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES ('1', 'vip 1', '2017-08-16 07:06:07', '2017-08-16 08:08:47', null, '100', '1000', '0');
INSERT INTO `packages` VALUES ('2', 'vip 2', '2017-08-16 07:06:33', '2017-08-16 07:06:33', null, '500', '500', '0');
INSERT INTO `packages` VALUES ('3', 'vip 3', '2017-08-16 07:58:10', '2017-08-16 07:58:10', null, '1000', '1100', '0');

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

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('2', 'Create Post1', '2017-08-12 05:53:17', '2017-08-15 08:51:26');
INSERT INTO `permissions` VALUES ('4', 'Administer roles & permissions', '2017-08-12 05:55:56', '2017-08-12 05:55:56');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of posts
-- ----------------------------
INSERT INTO `posts` VALUES ('1', '1111', '2222', '2017-08-12 05:57:26', '2017-08-12 05:57:26');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'Admin', '2017-08-12 05:53:53', '2017-08-12 05:53:53');
INSERT INTO `roles` VALUES ('2', 'nam hong', '2017-08-15 04:53:42', '2017-08-15 04:53:42');

-- ----------------------------
-- Table structure for role_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------
INSERT INTO `role_has_permissions` VALUES ('2', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '2');

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$kHPtvLZMMyNteBPq1D6vW.e8Hc.5So/aiYCHlefiRGeDND6mZJxES', '2NeMoQkIUqpN6d7BvKuvDbtAU38K7Fvdtnvm1cfVet4wXkoDTN50YkJOAa2b', '2017-08-12 05:47:39', '2017-08-22 08:49:15', '1', null, null, null, '1', null, 'RE7S5LKYXTPCOMXF');
INSERT INTO `users` VALUES ('3', 'Edit post', 'namhong19831@gmail.com', '$2y$10$wqZRXikpWIculBupnn0JqeXI7XyRdMmqM8Ftjv84dFNX6r1O7q67i', null, '2017-08-16 04:41:36', '2017-08-21 07:07:51', '1', null, null, null, '0', null, null);
INSERT INTO `users` VALUES ('4', 'member 1', 'namhong192283@gmail.com', '$2y$10$PSN.TnxxjUC4Jf6yvv996e4Ndjup.Mv2mDrBFWYZ.W98B6C4IEfui', null, '2017-08-18 09:21:31', '2017-08-21 07:07:51', '1', null, null, null, '0', null, null);
INSERT INTO `users` VALUES ('5', 'namhong1983', 'namhong19832@gmail.com', '$2y$10$QOdCapR4ku2yJwEEOUeMC.QV6DKQOP73PMJZFp4sccj5bqnX.C.N2', 'jfwHWhsH1AmNnueaqyqANj0lWNRr2Ldf83KZdFXGsOACjWChg02R7BnoRRXI', '2017-08-23 08:35:48', '2017-08-23 08:35:48', '0', 'nam', 'hong', '12345678', '0', null, null);
INSERT INTO `users` VALUES ('6', 'namhong19832', 'namhong198322@gmail.com', '$2y$10$sEm5sZyyEAPpM5Q0InTKjeQ4xs7GQdW4f0pf8Fwx0ZrQGXXo7ujCq', null, '2017-08-23 08:38:30', '2017-08-23 08:38:30', '0', 'namh', 'hong', '12345678', '0', null, null);
INSERT INTO `users` VALUES ('7', 'namhong19831', 'namhong198223@gmail.com', '$2y$10$4tF4nvQ3OfbaqFSTMNUkCeeUk7or0.YcyClgOKETXrtEEM3wApeCK', null, '2017-08-23 08:45:32', '2017-08-23 08:45:32', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('8', 'namhong198312', 'namhong1982232@gmail.com', '$2y$10$HI4Do8kjywbr1UxfOKOSfe4aQBvXKLugvsMlqKhb8ZxvuQDiZGNnO', null, '2017-08-23 08:46:13', '2017-08-23 08:46:13', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('9', 'namhong1983123', 'namhong19822323@gmail.com', '$2y$10$368NgBjaBceYZYBOOERj9.inmTdrMHx0Sduv.Ft0Cux2RvtfjvjQ6', null, '2017-08-23 08:47:07', '2017-08-23 08:47:07', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('10', 'namhong19831232', 'namhong198223223@gmail.com', '$2y$10$/8Cprs.B6wQ9ZWWV/WM/c.lFIt6ID9HTt9X1FpTFs2dozwg184wmq', null, '2017-08-23 08:48:16', '2017-08-23 08:48:16', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('11', 'namhong198312322', 'namhong1982232232@gmail.com', '$2y$10$1xv97CBbsZC/GkhliKDzm.BSUbfqhD5XcGSB0cNgSTrTNIR4EYREO', null, '2017-08-23 08:48:56', '2017-08-23 08:48:56', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('12', 'namhong1983123222', 'namhong19822322322@gmail.com', '$2y$10$Q/lrbrxCADFjbYHESDeMqe7fqfD9L2oxel7l/W8qtQvQlYLWJAXa.', null, '2017-08-23 08:49:25', '2017-08-23 08:49:25', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('13', 'namhong19831232221', 'namhong198223223221@gmail.com', '$2y$10$BIPFHbaM9H76WG2WUstmgO6jp/19lRrXDMHMZgFihDpVpc5peVdDi', null, '2017-08-23 08:50:55', '2017-08-23 08:50:55', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('14', 'namhong198312322212', 'namhong1982232232212@gmail.com', '$2y$10$ZUpxgxXT8FFPCQWGc7rI4O1tS9l/jo.fdSf3OTTGZm.2nXQ43q9DC', '0kDymWgD50KGFvl5AhECSCwF8o7PrZY5g64PCfvpuqCuVmJH5Zk3glwU2wz0', '2017-08-23 08:52:13', '2017-08-23 08:52:13', '0', 'nam', 'hong', '12345678', '0', '1', null);
INSERT INTO `users` VALUES ('15', 'namhong1983111', 'namhong198113@gmail.com', '$2y$10$.LyZ0nu2fj3R/ABrpiSfPeNngC/WAMYUp4js.TaN9EDBd6MmKzBQi', 'DkvI5Tqaq6hXaROgJdpuMhesown3pDUWCeg5LKPjfyR2A6ZJBZJRhwbYxchE', '2017-08-24 09:02:29', '2017-08-24 09:02:29', '0', 'sda', 'sdas', '12345678', '0', null, null);

-- ----------------------------
-- Table structure for users_copy
-- ----------------------------
DROP TABLE IF EXISTS `users_copy`;
CREATE TABLE `users_copy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `refererId` int(10) DEFAULT '0',
  `packageId` smallint(6) DEFAULT '0',
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
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `leftMembers` int(10) DEFAULT '0',
  `rightMembers` int(10) DEFAULT '0',
  `totalMembers` int(10) DEFAULT '0',
  `loyaltyId` tinyint(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `referrerId` (`refererId`),
  KEY `packageId` (`packageId`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_copy
-- ----------------------------
INSERT INTO `users_copy` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$kHPtvLZMMyNteBPq1D6vW.e8Hc.5So/aiYCHlefiRGeDND6mZJxES', 'Pwdf3zzB32pDQBVu6yBbeihCGupineoN9EYam42ORIiIt8jKlZTHgstdt1Hx', '2017-08-12 05:47:39', '2017-08-22 08:49:15', '0', '2', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', null, '2000', '0', '0', '3', '0', '1', '2', '0', '0', '0');
INSERT INTO `users_copy` VALUES ('3', 'Edit post', 'namhong19831@gmail.com', '$2y$10$wqZRXikpWIculBupnn0JqeXI7XyRdMmqM8Ftjv84dFNX6r1O7q67i', null, '2017-08-16 04:41:36', '2017-08-21 07:07:51', '1', '2', '', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '0', '0', '4', '3', '3', '1', '0', '0', '0', '0');
INSERT INTO `users_copy` VALUES ('4', 'member 1', 'namhong192283@gmail.com', '$2y$10$PSN.TnxxjUC4Jf6yvv996e4Ndjup.Mv2mDrBFWYZ.W98B6C4IEfui', null, '2017-08-18 09:21:31', '2017-08-21 07:07:51', '1', '1', '1JHqPatsSPUskqWp7CQ5RTFBKGdUdBpXCc', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '1000', '0', '1', '3', '4', '1', '1', '0', '0', '0');

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
INSERT INTO `users_loyalty` VALUES ('1', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('3', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
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
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_coins
-- ----------------------------
INSERT INTO `user_coins` VALUES ('1', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0.6', '0.3999999999999999', '0.49999999999999994', '0.2350001');
INSERT INTO `user_coins` VALUES ('3', '', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', '0', '0');
INSERT INTO `user_coins` VALUES ('4', '1JHqPatsSPUskqWp7CQ5RTFBKGdUdBpXCc', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', '0', '0');
INSERT INTO `user_coins` VALUES ('13', null, '09110c22-b885-5f0f-a0c0-96100356f2e1', '0', '0', '0', '0');
INSERT INTO `user_coins` VALUES ('14', null, 'c74a2b3d-f2db-52cb-b1c8-96a26e65727d', '0', '0', '0', '0');
INSERT INTO `user_coins` VALUES ('15', null, '22b5b1e2-770f-55fc-9f1a-e2c434f70bcc', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for user_datas
-- ----------------------------
DROP TABLE IF EXISTS `user_datas`;
CREATE TABLE `user_datas` (
  `userId` int(10) unsigned NOT NULL,
  `refererId` int(10) DEFAULT '0',
  `packageId` smallint(6) DEFAULT '0',
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
INSERT INTO `user_datas` VALUES ('1', '0', '2', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', null, '2000', '0', '0', '3', '0', '2', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('3', '1', '2', '', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '0', '0', '4', '3', '3', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('4', '1', '1', '1JHqPatsSPUskqWp7CQ5RTFBKGdUdBpXCc', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '1000', '0', '1', '3', '4', '1', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('13', '1', '0', null, '09110c22-b885-5f0f-a0c0-96100356f2e1', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('14', '1', '0', null, 'c74a2b3d-f2db-52cb-b1c8-96a26e65727d', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('15', null, '0', null, '22b5b1e2-770f-55fc-9f1a-e2c434f70bcc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for user_has_permissions
-- ----------------------------
DROP TABLE IF EXISTS `user_has_permissions`;
CREATE TABLE `user_has_permissions` (
  `user_id` int(10) unsigned NOT NULL,
  `permission_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `user_has_permissions_permission_id_foreign` (`permission_id`),
  CONSTRAINT `user_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_has_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for user_has_roles
-- ----------------------------
DROP TABLE IF EXISTS `user_has_roles`;
CREATE TABLE `user_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `user_has_roles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_has_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_has_roles
-- ----------------------------
INSERT INTO `user_has_roles` VALUES ('2', '1');

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
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double unsigned DEFAULT '0',
  PRIMARY KEY (`id`,`type`,`inOut`,`walletType`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
