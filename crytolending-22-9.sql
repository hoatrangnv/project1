/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-22 16:14:00
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
  `leftNew` double NOT NULL,
  `rightNew` double NOT NULL,
  `leftOpen` double DEFAULT '0',
  `rightOpen` double DEFAULT '0',
  `settled` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `bonus_tmp` double DEFAULT NULL,
  `weekYear` int(10) NOT NULL,
  PRIMARY KEY (`id`,`weeked`,`userId`),
  UNIQUE KEY `weekYear_uid` (`userId`,`weekYear`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_binary
-- ----------------------------

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
  `amount` double DEFAULT NULL,
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
  `bonus` float DEFAULT '0',
  `pack_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`),
  UNIQUE KEY `price` (`price`),
  UNIQUE KEY `pack_id` (`pack_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of packages
-- ----------------------------
INSERT INTO `packages` VALUES ('1', 'vip 1', '2017-08-16 07:06:07', '2017-09-18 04:14:44', null, '100', '0.1', '1');
INSERT INTO `packages` VALUES ('2', 'vip 2', '2017-08-16 07:06:33', '2017-09-18 04:14:48', null, '500', '0.2', '2');
INSERT INTO `packages` VALUES ('3', 'vip 3', '2017-08-16 07:58:10', '2017-09-18 04:14:55', null, '1000', '0.3', '3');
INSERT INTO `packages` VALUES ('4', 'vip 4', null, null, null, '2000', '0.4', '4');
INSERT INTO `packages` VALUES ('5', 'vip 5', null, null, null, '5000', '0.5', '5');
INSERT INTO `packages` VALUES ('6', 'vip 6', null, null, null, '10000', '0.6', '6');

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
  `uid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  UNIQUE KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', '5cZLo0pCAQ5ZEHXs671vRWa12vhWp8OdsNkmtuWnw4mf5PzjOtGmMyaZrejp', '2017-08-12 05:47:39', '2017-09-15 08:22:03', '1', 'Nguyen', 'Hong', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '2N8RNXCGHTWkdimArM27XW9EzUAmri5uVe1', 'Profile', null, null, null, '', null, null, null);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_loyalty
-- ----------------------------

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
INSERT INTO `user_coins` VALUES ('1', '1GGmXKpWxhnewFshqw7fKKdnMEAf7wjzSy', 'c9750047-5a1e-57aa-95ca-f72a7bd721cc', '0.6', '500', '300.5', '220.2350001', null);

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
  `totalBonus` double DEFAULT '0',
  `isBinary` tinyint(1) DEFAULT '0',
  `leftRight` enum('right','left') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `totalBonusLeft` double DEFAULT '0',
  `totalBonusRight` double DEFAULT '0',
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
INSERT INTO `user_datas` VALUES ('1', '0', '3', '2017-09-21 17:26:38', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '0', null, '2100', '600', '0', '3', '4', '1', '2', '3', '0', '1');

-- ----------------------------
-- Table structure for user_packages
-- ----------------------------
DROP TABLE IF EXISTS `user_packages`;
CREATE TABLE `user_packages` (
  `userId` int(10) unsigned NOT NULL,
  `packageId` int(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `amount_increase` int(10) NOT NULL,
  `buy_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `release_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  KEY `userId` (`userId`) USING BTREE,
  KEY `packageId` (`packageId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_packages
-- ----------------------------

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wallets
-- ----------------------------

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
  `amountCLP` double DEFAULT NULL,
  `amountBTC` double DEFAULT NULL,
  `fee` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`walletAddress`,`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of withdraws
-- ----------------------------
