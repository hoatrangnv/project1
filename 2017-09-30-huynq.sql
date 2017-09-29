/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-29 11:02:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bonus_binary`
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_binary
-- ----------------------------
INSERT INTO `bonus_binary` VALUES ('1', '2017-09-22 17:44:07', '2017-09-22 17:45:32', '2', '38', '2017', '100', '11500', '0', '0', '100', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('2', '2017-09-22 17:44:34', '2017-09-22 17:45:32', '5', '38', '2017', '2000', '15000', '0', '0', '2000', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('3', '2017-09-22 17:45:18', '2017-09-22 17:45:32', '4', '38', '2017', '0', '11000', '0', '0', '0', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('4', '2017-09-22 17:45:32', '2017-09-22 17:45:32', '7', '38', '2017', '0', '10000', '0', '0', '0', null, '0', '201738');

-- ----------------------------
-- Table structure for `bonus_faststart`
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_faststart
-- ----------------------------
INSERT INTO `bonus_faststart` VALUES ('1', '2017-09-22 17:40:05', '2017-09-22 17:40:05', '2', '1', '3', '10');
INSERT INTO `bonus_faststart` VALUES ('2', '2017-09-22 17:40:05', '2017-09-22 17:40:05', '1', '2', '3', '2');
INSERT INTO `bonus_faststart` VALUES ('3', '2017-09-22 17:40:31', '2017-09-22 17:40:31', '2', '1', '4', '50');
INSERT INTO `bonus_faststart` VALUES ('4', '2017-09-22 17:40:31', '2017-09-22 17:40:31', '1', '2', '4', '10');
INSERT INTO `bonus_faststart` VALUES ('5', '2017-09-22 17:40:50', '2017-09-22 17:40:50', '2', '1', '5', '100');
INSERT INTO `bonus_faststart` VALUES ('6', '2017-09-22 17:40:51', '2017-09-22 17:40:51', '1', '2', '5', '20');
INSERT INTO `bonus_faststart` VALUES ('7', '2017-09-22 17:41:04', '2017-09-22 17:41:04', '1', '1', '2', '500');
INSERT INTO `bonus_faststart` VALUES ('8', '2017-09-22 17:41:23', '2017-09-22 17:41:23', '5', '1', '6', '200');
INSERT INTO `bonus_faststart` VALUES ('9', '2017-09-22 17:41:23', '2017-09-22 17:41:23', '2', '2', '6', '40');
INSERT INTO `bonus_faststart` VALUES ('10', '2017-09-22 17:41:42', '2017-09-22 17:41:42', '5', '1', '7', '500');
INSERT INTO `bonus_faststart` VALUES ('11', '2017-09-22 17:41:42', '2017-09-22 17:41:42', '2', '2', '7', '100');
INSERT INTO `bonus_faststart` VALUES ('12', '2017-09-22 17:42:01', '2017-09-22 17:42:01', '2', '1', '15', '1000');
INSERT INTO `bonus_faststart` VALUES ('13', '2017-09-22 17:42:01', '2017-09-22 17:42:01', '1', '2', '15', '200');
INSERT INTO `bonus_faststart` VALUES ('14', '2017-09-22 17:46:48', '2017-09-22 17:46:48', '2', '1', '18', '50');
INSERT INTO `bonus_faststart` VALUES ('15', '2017-09-22 17:46:48', '2017-09-22 17:46:48', '1', '2', '18', '10');

-- ----------------------------
-- Table structure for `migrations`
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
-- Table structure for `model_has_permissions`
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
-- Table structure for `model_has_roles`
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
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` smallint(6) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_desc` text COLLATE utf8mb4_unicode_ci,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `public_at` datetime DEFAULT NULL,
  `created_by` int(10) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `views` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('24', '1231233', '1', null, '1', '<p>1</p>', null, '1', '0', null, null, '2017-09-26 13:44:46', null);
INSERT INTO `news` VALUES ('25', '1', '1', null, '1', '<p>1</p>', null, '1', '0', null, '2017-09-26 13:50:19', '2017-09-26 13:50:19', null);

-- ----------------------------
-- Table structure for `packages`
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
-- Table structure for `password_resets`
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
-- Table structure for `permissions`
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
-- Table structure for `role_has_permissions`
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
-- Table structure for `roles`
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
INSERT INTO `user_coins` VALUES ('1', '1GGmXKpWxhnewFshqw7fKKdnMEAf7wjzSy', 'c9750047-5a1e-57aa-95ca-f72a7bd721cc', '0.6', '668.8739999999998', '10000', '304.2', null, '19');
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

-- ----------------------------
-- Table structure for `user_datas`
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
INSERT INTO `user_datas` VALUES ('1', '0', '3', '2017-09-22 17:46:48', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '1476', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('2', '1', '5', '2017-09-22 17:46:48', 'test', 'test', '1350', '0', null, '100', '11500', '0', '3', '15', '1', '3', '4', '0', '1');
INSERT INTO `user_datas` VALUES ('3', '2', '1', '2017-09-22 17:44:07', 'test', 'test', '0', '1', 'left', '0', '0', '2', '3', '3', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('4', '2', '2', '2017-09-22 17:45:32', 'test', 'test', '0', '1', 'right', '0', '11000', '2', '4', '15', '0', '2', '2', '0', '1');
INSERT INTO `user_datas` VALUES ('5', '2', '3', '2017-09-22 17:45:32', 'test', 'test', '700', '1', 'right', '2000', '15000', '4', '6', '15', '1', '2', '3', '0', '1');
INSERT INTO `user_datas` VALUES ('6', '5', '4', '2017-09-22 17:44:37', 'test', 'test', '0', '1', 'left', '0', '0', '5', '6', '6', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('7', '5', '5', '2017-09-22 17:45:32', 'test', 'test', '0', '1', 'right', '0', '10000', '5', '7', '15', '0', '1', '1', '0', '1');
INSERT INTO `user_datas` VALUES ('8', '6', '0', '2017-09-22 17:38:17', 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('9', '7', '0', '2017-09-22 17:38:23', 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('10', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('11', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('12', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('13', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('14', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('15', '2', '6', '2017-09-22 17:45:32', 'test', 'test', '0', '1', 'right', '0', '0', '7', '15', '15', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('16', '9', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('17', '12', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('18', '2', '2', '2017-09-22 17:46:48', 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('19', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('20', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('21', '20', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('22', '20', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('23', '21', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('24', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('25', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

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
INSERT INTO `user_packages` VALUES ('1', '1', '3', '1000', '2017-09-27 15:13:26', '2018-03-27 15:13:26', '1', '0', '2017-09-27 15:33:59', '2017-09-27 15:13:26');
INSERT INTO `user_packages` VALUES ('2', '1', '5', '4000', '2017-09-27 15:17:14', '2018-03-27 15:17:14', '1', '0', '2017-09-27 15:34:00', '2017-09-27 15:17:14');
INSERT INTO `user_packages` VALUES ('3', '54', '2', '500', '2017-09-20 22:39:59', '2018-03-19 22:39:59', '0', '0', '2017-09-20 22:39:59', '2017-09-20 22:39:59');
INSERT INTO `user_packages` VALUES ('4', '56', '6', '10000', '2017-09-20 22:40:26', '2018-03-19 22:40:26', '0', '0', '2017-09-20 22:40:26', '2017-09-20 22:40:26');
INSERT INTO `user_packages` VALUES ('5', '53', '6', '10000', '2017-09-20 22:48:36', '2018-03-19 22:48:36', '0', '0', '2017-09-20 22:48:36', '2017-09-20 22:48:36');
INSERT INTO `user_packages` VALUES ('6', '57', '4', '2000', '2017-09-20 22:55:35', '2018-03-19 22:55:35', '0', '0', '2017-09-20 22:55:35', '2017-09-20 22:55:35');
INSERT INTO `user_packages` VALUES ('7', '58', '5', '5000', '2017-09-20 22:56:50', '2018-03-19 22:56:50', '0', '0', '2017-09-20 22:56:50', '2017-09-20 22:56:50');
INSERT INTO `user_packages` VALUES ('8', '58', '5', '5000', '2017-09-20 23:00:35', '2018-03-19 23:00:35', '0', '0', '2017-09-20 23:00:35', '2017-09-20 23:00:35');
INSERT INTO `user_packages` VALUES ('9', '62', '6', '10000', '2017-09-20 23:03:52', '2018-03-19 23:03:52', '0', '0', '2017-09-20 23:03:52', '2017-09-20 23:03:52');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', 'SISbq2Ljbrr8WDSlpYEMOvziaTFhJ6NvcjcqmR8wxqnQ4EFBu4jZ2yAbCUr9', '2017-08-12 05:47:39', '2017-09-28 15:05:08', '1', 'Nguyen', 'Hong', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '2N8RNXCGHTWkdimArM27XW9EzUAmri5uVe1', 'Profile', null, null, null, '', null, null, null);
INSERT INTO `users` VALUES ('2', 'root', 'root@gmail.com', '$2y$10$bvHYiVB0zslAXAKnm/s9f.bpR9yb0.Wghs6d/ODVoDWL9TkTuxM4m', null, '2017-09-22 16:17:18', '2017-09-22 16:17:18', '0', 'root', 'Do', '0978788999', '0', '1', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('3', 'member1', 'member1@gmail.com', '$2y$10$rUAgleT3Ty/OYWJuS6DpQuEewCjPBg0duWxo4kGe17YZcmoX3Bc1S', 'qDsLXLmsfZtgZkEyQVOlcXQlw0htMNFgo7a2O0iBuh2tgfoinwMdYnBHH4oa', '2017-09-22 16:17:52', '2017-09-22 16:17:52', '0', 'member1', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('4', 'member2', 'member2@gmail.com', '$2y$10$pcnJOoocVDPqVFBBZSTbLuZVkQlYX1C1naf9IQ942lga9vFP9F1Q2', 'TUU1VVxiVXHhIA6bJBC0fdieZLeaVao4tmaGufU2z1H7UpBqxOqQ9XxDmPJS', '2017-09-22 16:18:09', '2017-09-22 16:18:09', '0', 'member2', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('5', 'member3', 'member3@gmail.com', '$2y$10$knE5WcDP.hvmgaPDFmCFaOHgSF.lFzvPXDZqgZLxpYFUXw737syZ.', 'kxmiBb74lW1mYbKAsOoPFizF9Nt9yY7aeBhryDx0r142Oqz3wWb24WGYHKcf', '2017-09-22 16:18:20', '2017-09-22 16:18:20', '0', 'member3', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('6', 'member4', 'member4@gmail.com', '$2y$10$vgvkjmqSse/WLX21MnZJIej5DJgOnCLpBb1eDz9uTGdh0kym7Y3.C', 'f4EUDWRwfYCS4BqRBfa0234mGWvRzP0FGfebcf5GrckQcT342XDehSGlszjo', '2017-09-22 16:19:18', '2017-09-22 16:19:18', '0', 'member4', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('7', 'member5', 'member5@gmail.com', '$2y$10$38MEFbHhoDlZSChVc82DG.2Lf5hFRQfPx0StjYdyNNM1gG.nAuaee', 'A32F94rzvbTvTPI8ArSOam4xZ3uI0oUVhFcFxgjmHwXjS4GPpKEhoqykExG8', '2017-09-22 16:19:31', '2017-09-22 16:19:31', '0', 'member5', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('8', 'member6', 'member6@gmail.com', '$2y$10$B3.iV9NVlELRG4yb2u2XLuwRrztWJiHigx.Aki5oPiXsAffeNjZAO', 'fndhKOvBrPss6A8gxJMKSbLuAtLxmCSYiLaKusluvT9QGCwVWA4nBty33dJ0', '2017-09-22 16:19:38', '2017-09-22 16:19:38', '0', 'member6', 'Do', '0978788999', '0', '6', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('9', 'member7', 'member7@gmail.com', '$2y$10$ODxJ4Fk6tRj38Jtb6CjH8.Kzn73aEtS9THKgktzDc8zm56PyDF.DS', 'GSaXmqZqCFffHQ2WiKU3evwHcLQl1g31LJO7qXMjl09UsbRqhg21bREMIaS8', '2017-09-22 16:19:47', '2017-09-22 16:19:47', '0', 'member7', 'Do', '0978788999', '0', '7', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('10', 'member8', 'member8@gmail.com', '$2y$10$4Ot3ODxb2CwnK03wp5TSMeD3MSLrLceZpz9hgZt5MDnZFkc0rwktS', null, '2017-09-22 16:19:56', '2017-09-22 16:19:56', '0', 'member8', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('11', 'member9', 'member9@gmail.com', '$2y$10$KRwuqz9dKftGst0cyAlPt.rtemTRNaD4jmIv1o5R3Kgi9AF7ijeaC', null, '2017-09-22 16:20:03', '2017-09-22 16:20:03', '0', 'member9', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('12', 'member10', 'member10@gmail.com', '$2y$10$WRwoU7SVvzm/MRiDB3XJzODCaoOIrnw6D4/gdb9EptXNS9kjXBZW.', null, '2017-09-22 16:20:11', '2017-09-22 16:20:11', '0', 'member10', 'Do', '0978788999', '0', '11', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('13', 'member11', 'member11@gmail.com', '$2y$10$vBvx7ndHMdwsxUqdL8set.kpXpu0sLEv9KSiVvA9/r.PmhKGbocp.', null, '2017-09-22 16:20:23', '2017-09-22 16:20:23', '0', 'member11', 'Do', '0978788999', '0', '11', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('14', 'member12', 'member12@gmail.com', '$2y$10$xzzr0wphlpJHaeiHPT8Q3uCLa.6RjLouuIK/uUprVPu6RhAF4neg2', null, '2017-09-22 16:20:33', '2017-09-22 16:20:33', '0', 'member12', 'Do', '0978788999', '0', '11', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('15', 'member13', 'member13@gmail.com', '$2y$10$enuQRp6UMrNEZSr/EcEkA.VHY27893FTZVbqJrnAYHc9D.spJAq3a', 'IgbRaPjL4AlbSSLRqUiupdqLIztN2ACNOW7V6PSAniX7C0UhqZ3F06wdzGQL', '2017-09-22 16:20:48', '2017-09-22 16:20:48', '0', 'member13', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('16', 'member14', 'member14@gmail.com', '$2y$10$Jz0Nnk2QEAKvZXEF90JkruTrI1I5l85xlmumMUyw1qW2fj3uUakNS', null, '2017-09-22 16:20:55', '2017-09-22 16:20:55', '0', 'member14', 'Do', '0978788999', '0', '9', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('17', 'member15', 'member15@gmail.com', '$2y$10$GdctBsn1Ohaz9FYokW.CXez6FBGBb0bdKSWYgKD54ZGZTLwITC/YO', null, '2017-09-22 16:21:06', '2017-09-22 16:21:06', '0', 'member15', 'Do', '0978788999', '0', '12', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('18', 'member16', 'member16@gmail.com', '$2y$10$L6n/aBgYYT/LofKRT4W9i.CTTjnhg84Mwvini.XWoWR8.oScnjRle', null, '2017-09-22 16:21:13', '2017-09-22 16:21:13', '0', 'member16', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('19', 'member17', 'member17@gmail.com', '$2y$10$Ygsnt6.IPzP4jqhBdqVGWeTQCXpagBMQymVRENAwXmUvsB3nlh.eC', null, '2017-09-22 16:21:22', '2017-09-22 16:21:22', '0', 'member17', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('20', 'member18', 'member18@gmail.com', '$2y$10$lJdKGXrUdHYH/nut07c0aOO.QyZfDo1Q/cMGjCpAypyLo98JEIeKm', null, '2017-09-22 16:21:30', '2017-09-22 16:21:30', '0', 'member18', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('21', 'member19', 'member19@gmail.com', '$2y$10$ZDsiY9lwdcNasdVASZUMweV1L80vG6tW7XRKm6bRgxg7wJW/r87ka', null, '2017-09-22 16:21:38', '2017-09-22 16:21:38', '0', 'member19', 'Do', '0978788999', '0', '20', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('22', 'member20', 'member20@gmail.com', '$2y$10$RTUiTpWrx2ORg5bWwNRA8.YXT7NVDNPAwz.R2I3YGKDgx8.dAJWdm', null, '2017-09-22 16:21:45', '2017-09-22 16:21:45', '0', 'member20', 'Do', '0978788999', '0', '20', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('23', 'member21', 'member21@gmail.com', '$2y$10$Stq6ZcRfzUq6Aqj4/KlUCew66DgkhNM18GSQ.flmYVvaWerRjTMcy', null, '2017-09-22 16:21:55', '2017-09-22 16:21:55', '0', 'member21', 'Do', '0978788999', '0', '21', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('24', 'member22', 'member22@gmail.com', '$2y$10$mbrTe1rsYMZTzw3UWjCFOO.en3/bZbja8fxt7XMEJARX2Bshgq20y', null, '2017-09-22 16:22:01', '2017-09-22 16:22:01', '0', 'member22', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('25', 'member23', 'member23@gmail.com', '$2y$10$JJ7PiuccK8UTNnw7qJo6N.em/cy5w536pW./Ru844UqWJqff93HdK', null, '2017-09-22 16:22:09', '2017-09-22 16:22:09', '0', 'member23', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);

-- ----------------------------
-- Table structure for `users_loyalty`
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_loyalty
-- ----------------------------
INSERT INTO `users_loyalty` VALUES ('1', '2', '0', '0', '0', '0', '0', '100', '11500', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('2', '3', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('3', '4', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('4', '5', '0', '0', '0', '0', '0', '2000', '5000', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('5', '7', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('6', '6', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('7', '15', '0', '0', '0', '0', '0', '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for `wallets`
-- ----------------------------
DROP TABLE IF EXISTS `wallets`;
CREATE TABLE `wallets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `walletType` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1:usd; 2:btc; 3:clp; 4:reinvest;',
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;3:bonus day;4: bounus f1;5:bonus week',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double unsigned DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `release_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`,`type`,`inOut`,`walletType`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wallets
-- ----------------------------
INSERT INTO `wallets` VALUES ('1', null, '1', '1', 'member1 Register Package', 'in', '2', '6', '2017-09-22 17:40:05', '2017-09-22 17:40:05', null);
INSERT INTO `wallets` VALUES ('2', null, '4', '1', 'member1 Register Package', 'out', '2', '4', '2017-09-22 17:40:05', '2017-09-22 17:40:05', '2017-09-27 17:40:05');
INSERT INTO `wallets` VALUES ('3', null, '1', '1', 'member1 Register Package', 'in', '1', '1.2', '2017-09-22 17:40:05', '2017-09-23 17:40:05', '2017-09-27 17:40:05');
INSERT INTO `wallets` VALUES ('4', null, '4', '1', 'member1 Register Package', 'in', '2', '0.8', '2017-09-22 17:40:05', '2017-09-22 17:40:05', '2017-09-27 17:40:05');
INSERT INTO `wallets` VALUES ('5', null, '1', '1', 'member2 Register Package', 'in', '2', '30', '2017-09-22 17:40:31', '2017-09-22 17:40:31', null);
INSERT INTO `wallets` VALUES ('6', null, '4', '1', 'member2 Register Package', 'in', '2', '20', '2017-09-22 17:40:31', '2017-09-22 17:40:31', null);
INSERT INTO `wallets` VALUES ('7', null, '1', '1', 'member2 Register Package', 'in', '1', '6', '2017-09-22 17:40:31', '2017-09-22 17:40:31', '2017-09-27 17:40:05');
INSERT INTO `wallets` VALUES ('8', null, '4', '1', 'member2 Register Package', 'in', '1', '4', '2017-09-22 17:40:31', '2017-09-22 17:40:31', null);
INSERT INTO `wallets` VALUES ('9', null, '1', '1', 'member3 Register Package', 'in', '2', '60', '2017-09-22 17:40:50', '2017-09-22 17:40:50', null);
INSERT INTO `wallets` VALUES ('10', null, '4', '1', 'member3 Register Package', 'in', '2', '40', '2017-09-22 17:40:50', '2017-09-22 17:40:50', null);
INSERT INTO `wallets` VALUES ('11', null, '1', '1', 'member3 Register Package', 'in', '1', '12', '2017-09-22 17:40:51', '2017-09-22 17:40:51', null);
INSERT INTO `wallets` VALUES ('12', null, '4', '1', 'member3 Register Package', 'in', '1', '8', '2017-09-22 17:40:51', '2017-09-22 17:40:51', null);
INSERT INTO `wallets` VALUES ('13', null, '1', '1', 'root Register Package', 'in', '1', '300', '2017-09-22 17:41:04', '2017-09-22 17:41:04', null);
INSERT INTO `wallets` VALUES ('14', null, '4', '1', 'root Register Package', 'in', '1', '200', '2017-09-22 17:41:04', '2017-09-22 17:41:04', null);
INSERT INTO `wallets` VALUES ('15', null, '1', '1', 'member4 Register Package', 'in', '5', '120', '2017-09-22 17:41:23', '2017-09-22 17:41:23', null);
INSERT INTO `wallets` VALUES ('16', null, '4', '1', 'member4 Register Package', 'in', '5', '80', '2017-09-22 17:41:23', '2017-09-22 17:41:23', null);
INSERT INTO `wallets` VALUES ('17', null, '1', '1', 'member4 Register Package', 'in', '2', '24', '2017-09-22 17:41:23', '2017-09-22 17:41:23', '0000-00-00 00:00:00');
INSERT INTO `wallets` VALUES ('18', null, '4', '1', 'member4 Register Package', 'in', '2', '16', '2017-09-22 17:41:23', '2017-09-22 17:41:23', null);
INSERT INTO `wallets` VALUES ('19', null, '1', '1', 'member5 Register Package', 'in', '5', '300', '2017-09-22 17:41:42', '2017-09-22 17:41:42', null);
INSERT INTO `wallets` VALUES ('20', null, '4', '1', 'member5 Register Package', 'in', '5', '200', '2017-09-22 17:41:42', '2017-09-22 17:41:42', null);
INSERT INTO `wallets` VALUES ('21', null, '1', '1', 'member5 Register Package', 'in', '2', '60', '2017-09-22 17:41:42', '2017-09-22 17:41:42', null);
INSERT INTO `wallets` VALUES ('22', null, '4', '1', 'member5 Register Package', 'in', '2', '40', '2017-09-22 17:41:42', '2017-09-22 17:41:42', null);
INSERT INTO `wallets` VALUES ('23', null, '1', '1', 'member13 Register Package', 'in', '2', '600', '2017-09-22 17:42:01', '2017-09-22 17:42:01', null);
INSERT INTO `wallets` VALUES ('24', null, '4', '1', 'member13 Register Package', 'in', '2', '400', '2017-09-22 17:42:01', '2017-09-22 17:42:01', null);
INSERT INTO `wallets` VALUES ('25', null, '1', '1', 'member13 Register Package', 'in', '1', '120', '2017-09-22 17:42:01', '2017-09-22 17:42:01', null);
INSERT INTO `wallets` VALUES ('26', null, '4', '1', 'member13 Register Package', 'in', '1', '80', '2017-09-22 17:42:01', '2017-09-22 17:42:01', null);
INSERT INTO `wallets` VALUES ('27', null, '1', '4', 'silver', 'in', '2', '3000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('28', null, '4', '4', 'silver', 'in', '2', '2000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('29', null, '1', '4', 'gold', 'in', '2', '6000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('30', null, '4', '4', 'gold', 'in', '2', '4000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('31', null, '1', '4', 'pear', 'in', '2', '12000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('32', null, '4', '4', 'pear', 'in', '2', '8000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('33', null, '1', '4', 'emerald', 'in', '2', '30000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('34', null, '4', '4', 'emerald', 'in', '2', '20000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('35', null, '1', '4', 'diamond', 'in', '2', '60000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('36', null, '4', '4', 'diamond', 'in', '2', '40000', '2017-09-22 17:44:11', '2017-09-22 17:44:11', null);
INSERT INTO `wallets` VALUES ('37', null, '1', '4', 'silver', 'in', '5', '3000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('38', null, '4', '4', 'silver', 'in', '5', '2000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('39', null, '1', '4', 'gold', 'in', '5', '6000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('40', null, '4', '4', 'gold', 'in', '5', '4000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('41', null, '1', '4', 'pear', 'in', '5', '12000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('42', null, '4', '4', 'pear', 'in', '5', '8000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('43', null, '1', '4', 'emerald', 'in', '5', '30000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('44', null, '4', '4', 'emerald', 'in', '5', '20000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('45', null, '1', '4', 'diamond', 'in', '5', '60000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('46', null, '4', '4', 'diamond', 'in', '5', '40000', '2017-09-22 17:44:37', '2017-09-22 17:44:37', null);
INSERT INTO `wallets` VALUES ('47', null, '1', '4', 'silver', 'in', '4', '3000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('48', null, '4', '4', 'silver', 'in', '4', '2000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('49', null, '1', '4', 'gold', 'in', '4', '6000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('50', null, '4', '4', 'gold', 'in', '4', '4000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('51', null, '1', '4', 'pear', 'in', '4', '12000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('52', null, '4', '4', 'pear', 'in', '4', '8000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('53', null, '1', '4', 'emerald', 'in', '4', '30000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('54', null, '4', '4', 'emerald', 'in', '4', '20000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('55', null, '1', '4', 'diamond', 'in', '4', '60000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('56', null, '4', '4', 'diamond', 'in', '4', '40000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('57', null, '1', '4', 'silver', 'in', '2', '3000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('58', null, '4', '4', 'silver', 'in', '2', '2000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('59', null, '1', '4', 'gold', 'in', '2', '6000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('60', null, '4', '4', 'gold', 'in', '2', '4000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('61', null, '1', '4', 'pear', 'in', '2', '12000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('62', null, '4', '4', 'pear', 'in', '2', '8000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('63', null, '1', '4', 'emerald', 'in', '2', '30000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('64', null, '4', '4', 'emerald', 'in', '2', '20000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('65', null, '1', '4', 'diamond', 'in', '2', '60000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('66', null, '4', '4', 'diamond', 'in', '2', '40000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('67', null, '1', '4', 'silver', 'in', '5', '3000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('68', null, '4', '4', 'silver', 'in', '5', '2000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('69', null, '1', '4', 'gold', 'in', '5', '6000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('70', null, '4', '4', 'gold', 'in', '5', '4000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('71', null, '1', '4', 'pear', 'in', '5', '12000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('72', null, '4', '4', 'pear', 'in', '5', '8000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('73', null, '1', '4', 'emerald', 'in', '5', '30000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('74', null, '4', '4', 'emerald', 'in', '5', '20000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('75', null, '1', '4', 'diamond', 'in', '5', '60000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('76', null, '4', '4', 'diamond', 'in', '5', '40000', '2017-09-22 17:45:18', '2017-09-22 17:45:18', null);
INSERT INTO `wallets` VALUES ('77', null, '1', '4', 'silver', 'in', '7', '3000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('78', null, '4', '4', 'silver', 'in', '7', '2000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('79', null, '1', '4', 'gold', 'in', '7', '6000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('80', null, '4', '4', 'gold', 'in', '7', '4000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('81', null, '1', '4', 'pear', 'in', '7', '12000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('82', null, '4', '4', 'pear', 'in', '7', '8000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('83', null, '1', '4', 'emerald', 'in', '7', '30000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('84', null, '4', '4', 'emerald', 'in', '7', '20000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('85', null, '1', '4', 'diamond', 'in', '7', '60000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('86', null, '4', '4', 'diamond', 'in', '7', '40000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('87', null, '1', '4', 'silver', 'in', '5', '3000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('88', null, '4', '4', 'silver', 'in', '5', '2000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('89', null, '1', '4', 'gold', 'in', '5', '6000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('90', null, '4', '4', 'gold', 'in', '5', '4000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('91', null, '1', '4', 'pear', 'in', '5', '12000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('92', null, '4', '4', 'pear', 'in', '5', '8000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('93', null, '1', '4', 'emerald', 'in', '5', '30000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('94', null, '4', '4', 'emerald', 'in', '5', '20000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('95', null, '1', '4', 'diamond', 'in', '5', '60000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('96', null, '4', '4', 'diamond', 'in', '5', '40000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('97', null, '1', '4', 'silver', 'in', '4', '3000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('98', null, '4', '4', 'silver', 'in', '4', '2000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('99', null, '1', '4', 'gold', 'in', '4', '6000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('100', null, '4', '4', 'gold', 'in', '4', '4000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('101', null, '1', '4', 'pear', 'in', '4', '12000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('102', null, '4', '4', 'pear', 'in', '4', '8000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('103', null, '1', '4', 'emerald', 'in', '4', '30000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('104', null, '4', '4', 'emerald', 'in', '4', '20000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('105', null, '1', '4', 'diamond', 'in', '4', '60000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('106', null, '4', '4', 'diamond', 'in', '4', '40000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('107', null, '1', '4', 'silver', 'in', '2', '3000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('108', null, '4', '4', 'silver', 'in', '2', '2000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('109', null, '1', '4', 'gold', 'in', '2', '6000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('110', null, '4', '4', 'gold', 'in', '2', '4000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('111', null, '1', '4', 'pear', 'in', '2', '12000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('112', null, '4', '4', 'pear', 'in', '2', '8000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('113', null, '1', '4', 'emerald', 'in', '2', '30000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('114', null, '4', '4', 'emerald', 'in', '2', '20000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('115', null, '1', '4', 'diamond', 'in', '2', '60000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('116', null, '4', '4', 'diamond', 'in', '2', '40000', '2017-09-22 17:45:32', '2017-09-22 17:45:32', null);
INSERT INTO `wallets` VALUES ('117', null, '1', '1', 'member16 Register Package', 'in', '2', '30', '2017-09-22 17:46:48', '2017-09-22 17:46:48', null);
INSERT INTO `wallets` VALUES ('118', null, '4', '1', 'member16 Register Package', 'in', '2', '20', '2017-09-22 17:46:48', '2017-09-22 17:46:48', null);
INSERT INTO `wallets` VALUES ('119', null, '1', '1', 'member16 Register Package', 'in', '1', '6', '2017-09-22 17:46:48', '2017-09-22 17:46:48', null);
INSERT INTO `wallets` VALUES ('120', null, '4', '1', 'member16 Register Package', 'in', '1', '4', '2017-09-22 17:46:48', '2017-09-22 17:46:48', null);
INSERT INTO `wallets` VALUES ('129', null, '4', '6', 'Tranfert from Reinvest wallet to CLP wallet', 'out', '1', '1', null, null, null);
INSERT INTO `wallets` VALUES ('130', null, '3', '6', 'Tranfert from Clp wallet to USD wallet', 'in', '1', '0.8928571428571428', null, null, null);
INSERT INTO `wallets` VALUES ('131', null, '4', '6', 'Tranfert from Reinvest wallet to CLP wallet', 'out', '1', '1', null, null, null);
INSERT INTO `wallets` VALUES ('132', null, '3', '6', 'Tranfert from Clp wallet to USD wallet', 'in', '1', '0.8928571428571428', null, null, null);
INSERT INTO `wallets` VALUES ('133', null, '4', '6', 'Tranfert from Reinvest wallet to CLP wallet', 'out', '1', '1', '2017-09-29 10:54:53', null, null);
INSERT INTO `wallets` VALUES ('134', null, '3', '6', 'Tranfert from Clp wallet to USD wallet', 'in', '1', '0.8928571428571428', '2017-09-29 10:54:53', null, null);
INSERT INTO `wallets` VALUES ('135', null, '4', '6', 'Tranfert from Reinvest wallet to CLP wallet', 'out', '1', '1', '2017-09-29 10:55:49', '2017-09-29 10:55:49', null);
INSERT INTO `wallets` VALUES ('136', null, '3', '6', 'Tranfert from Clp wallet to USD wallet', 'in', '1', '0.8928571428571428', '2017-09-29 10:55:49', '2017-09-29 10:55:49', null);

-- ----------------------------
-- Table structure for `withdraws`
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
