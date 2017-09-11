/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-11 15:51:06
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

-- ----------------------------
-- Table structure for `permissions`
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
-- Table structure for `posts`
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
-- Table structure for `role_has_permissions`
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
-- Table structure for `roles`
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
-- Table structure for `sales`
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
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_coins
-- ----------------------------
INSERT INTO `user_coins` VALUES ('1', '2N5tprWy7NWoqQaeYp2YBHj5aboaax1Mvk6', '2N5tprWy7NWoqQaeYp2YBHj5aboaax1Mvk6', '0.6', '0.3999999999999999', '0.49999999999999994', '0.2350001', null);
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
-- Table structure for `user_datas`
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
INSERT INTO `user_datas` VALUES ('1', '0', '2', '2N5tprWy7NWoqQaeYp2YBHj5aboaax1Mvk6', '2N5tprWy7NWoqQaeYp2YBHj5aboaax1Mvk6', '0', '0', null, '2000', '0', '0', '3', '0', '2', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('3', '1', '2', '', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '0', '0', '4', '3', '3', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('4', '1', '1', '1JHqPatsSPUskqWp7CQ5RTFBKGdUdBpXCc', '0af3e334-9dac-5b20-beab-9c45c79a9611', '0', '1', 'left', '1000', '0', '1', '3', '4', '1', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('13', '1', '0', null, '09110c22-b885-5f0f-a0c0-96100356f2e1', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('14', '1', '0', null, 'c74a2b3d-f2db-52cb-b1c8-96a26e65727d', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('15', null, '0', null, '22b5b1e2-770f-55fc-9f1a-e2c434f70bcc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('16', null, '0', null, 'a7f702c0-13cc-50ea-ae29-79c8efef3c29', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('17', null, '0', null, '8c48ceac-928f-5fb0-9bf8-109d61f14840', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('18', null, '0', null, 'a1316e99-7de9-5758-837a-3f04727f7b92', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('19', null, '0', null, '469e8182-f8ff-55dd-8adf-073c7e22c646', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('20', null, '0', null, 'df042440-7b62-592d-9d75-27c46d9aa23f', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('21', null, '0', null, '4e1bf5ac-2638-53a3-9cc2-e6aaea850dfe', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('22', null, '0', null, 'da01d05c-98cd-5ec6-ac1e-8f9090d575cb', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('23', null, '0', null, '4361ab31-69a6-52bd-8e18-b91924a7633c', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('24', null, '0', null, '44102297-cf67-5592-8348-338d4e372226', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('25', null, '0', null, '4f9e693d-9c71-5cbc-93f6-abbbf82f090e', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('26', null, '0', null, 'bb33fd9e-c695-5546-b37f-8f8b2a88e2bc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('27', null, '0', null, 'bf384451-ca91-5e12-9f02-39a5b8036457', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('28', null, '0', null, '5940befa-d291-50b6-8fb9-a9d8bf150aef', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('29', null, '0', null, 'de76ae86-fa8f-57fc-b900-36bbc870bafc', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('30', null, '0', null, '83c5c57f-1167-55c4-8100-6bbc88b92cab', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('31', null, '0', null, '92896cd8-db47-5f21-913b-e4e8dc302bec', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('32', null, '0', null, '8a94958e-4548-561b-8663-aa7dedac6f27', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('33', null, '0', null, 'e2d1aa72-1f9b-593c-bda3-46f970ce2eb4', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('36', null, '0', null, '522891a7-0805-58b4-9485-d206be6b01a1', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('37', null, '0', null, '59a7a357-3882-5895-9353-a3674e65c4be', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('38', null, '0', null, '9c2e8b92-9660-5598-8afb-67b13bbebb5a', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('39', null, '0', null, 'e2350748-479d-5fd0-afb6-70f1acaf6d1a', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('40', null, '0', null, '6b8c9478-db74-55e4-9cd4-bf51bfc589ea', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('41', null, '0', '2Mt47h823UrKSrnYADJBaeo6jTUJffLirGg', '2Mt47h823UrKSrnYADJBaeo6jTUJffLirGg', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `user_has_permissions`
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
-- Table structure for `user_has_roles`
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$fxdquKC5P.4VqMpadQK2xO/bTr0XrfvOXlJFAjDYEfa6F73Xx5rC2', 'h68fvOG0yaIxHd5RM1YFiuQSL4f0YdnIQa9ZgS91Rr3EAGe00hekVl385ZON', '2017-08-12 05:47:39', '2017-08-30 02:23:57', '1', 'Nguyen', 'Hong', '012312423', '1', null, 'RE7S5LKYXTPCOMXF', '0');
INSERT INTO `users` VALUES ('5', 'namhong1983', 'namhong19832@gmail.com', '$2y$10$QOdCapR4ku2yJwEEOUeMC.QV6DKQOP73PMJZFp4sccj5bqnX.C.N2', 'jfwHWhsH1AmNnueaqyqANj0lWNRr2Ldf83KZdFXGsOACjWChg02R7BnoRRXI', '2017-08-23 08:35:48', '2017-08-23 08:35:48', '0', 'nam', 'hong', '12345678', '0', null, null, '0');
INSERT INTO `users` VALUES ('6', 'namhong19832', 'namhong198322@gmail.com', '$2y$10$sEm5sZyyEAPpM5Q0InTKjeQ4xs7GQdW4f0pf8Fwx0ZrQGXXo7ujCq', null, '2017-08-23 08:38:30', '2017-08-23 08:38:30', '0', 'namh', 'hong', '12345678', '0', null, null, '0');
INSERT INTO `users` VALUES ('7', 'namhong19831', 'namhong198223@gmail.com', '$2y$10$4tF4nvQ3OfbaqFSTMNUkCeeUk7or0.YcyClgOKETXrtEEM3wApeCK', null, '2017-08-23 08:45:32', '2017-08-23 08:45:32', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('8', 'namhong198312', 'namhong1982232@gmail.com', '$2y$10$HI4Do8kjywbr1UxfOKOSfe4aQBvXKLugvsMlqKhb8ZxvuQDiZGNnO', null, '2017-08-23 08:46:13', '2017-08-23 08:46:13', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('9', 'namhong1983123', 'namhong19822323@gmail.com', '$2y$10$368NgBjaBceYZYBOOERj9.inmTdrMHx0Sduv.Ft0Cux2RvtfjvjQ6', null, '2017-08-23 08:47:07', '2017-08-23 08:47:07', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('10', 'namhong19831232', 'namhong198223223@gmail.com', '$2y$10$/8Cprs.B6wQ9ZWWV/WM/c.lFIt6ID9HTt9X1FpTFs2dozwg184wmq', null, '2017-08-23 08:48:16', '2017-08-23 08:48:16', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('11', 'namhong198312322', 'namhong1982232232@gmail.com', '$2y$10$1xv97CBbsZC/GkhliKDzm.BSUbfqhD5XcGSB0cNgSTrTNIR4EYREO', null, '2017-08-23 08:48:56', '2017-08-23 08:48:56', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('12', 'namhong1983123222', 'namhong19822322322@gmail.com', '$2y$10$Q/lrbrxCADFjbYHESDeMqe7fqfD9L2oxel7l/W8qtQvQlYLWJAXa.', null, '2017-08-23 08:49:25', '2017-08-23 08:49:25', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('13', 'namhong19831232221', 'namhong198223223221@gmail.com', '$2y$10$BIPFHbaM9H76WG2WUstmgO6jp/19lRrXDMHMZgFihDpVpc5peVdDi', null, '2017-08-23 08:50:55', '2017-08-23 08:50:55', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('14', 'namhong198312322212', 'namhong1982232232212@gmail.com', '$2y$10$ZUpxgxXT8FFPCQWGc7rI4O1tS9l/jo.fdSf3OTTGZm.2nXQ43q9DC', '0kDymWgD50KGFvl5AhECSCwF8o7PrZY5g64PCfvpuqCuVmJH5Zk3glwU2wz0', '2017-08-23 08:52:13', '2017-08-23 08:52:13', '0', 'nam', 'hong', '12345678', '0', '1', null, '0');
INSERT INTO `users` VALUES ('15', 'namhong1983111', 'namhong198113@gmail.com', '$2y$10$.LyZ0nu2fj3R/ABrpiSfPeNngC/WAMYUp4js.TaN9EDBd6MmKzBQi', 'DkvI5Tqaq6hXaROgJdpuMhesown3pDUWCeg5LKPjfyR2A6ZJBZJRhwbYxchE', '2017-08-24 09:02:29', '2017-08-24 09:02:29', '0', 'sda', 'sdas', '12345678', '0', null, null, '0');
INSERT INTO `users` VALUES ('40', 'giangdt', 'giangitman@gmail.com', '$2y$10$AxZJTAAO0XjNY5ELxDkJZOeAxqVpyYCkjVOcD7HOjrwuQRu/Dee9q', null, '2017-09-07 09:33:12', '2017-09-07 09:33:12', '0', 'Giang', 'Do', '0978708981', '0', null, null, '0');
INSERT INTO `users` VALUES ('41', 'huydk', 'huydk1@gmail.com', '$2y$10$ebT.xwcB0MP5aqJP/dgo8OAUUDXSvoqoBHnpCfF4uOi66IV1Z4bee', null, '2017-09-08 10:08:31', '2017-09-11 03:09:26', '0', 'Nguyen', 'Huy', '1657810999', '0', null, null, '1');

-- ----------------------------
-- Table structure for `users_copy`
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_loyalty
-- ----------------------------
INSERT INTO `users_loyalty` VALUES ('1', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('3', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('4', '0', '0', '0', '0', '0', '0', '0', '0', '0', null, null);

-- ----------------------------
-- Table structure for `wallets`
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
-- Table structure for `withdraws`
-- ----------------------------
DROP TABLE IF EXISTS `withdraws`;
CREATE TABLE `withdraws` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `walletAddress` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(10) NOT NULL,
  `amountUSD` int(10) DEFAULT NULL,
  `amountBTC` double(10,5) DEFAULT NULL,
  `fee` double(20,7) DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`walletAddress`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of withdraws
-- ----------------------------
INSERT INTO `withdraws` VALUES ('1', '2017-08-16 07:06:07', '2017-08-16 08:08:47', '', '0', null, null, null, null, '0');
INSERT INTO `withdraws` VALUES ('2', '2017-08-16 07:06:33', '2017-08-16 07:06:33', '', '0', null, null, null, null, '0');
INSERT INTO `withdraws` VALUES ('3', '2017-08-16 07:58:10', '2017-08-16 07:58:10', '', '0', null, null, null, null, '0');
INSERT INTO `withdraws` VALUES ('4', '2017-09-11 07:03:45', '2017-09-11 07:03:45', '2N7kzyjXmmVEMJPFPfnjmHfjdX7SinPTPVi', '1', null, null, '101663.0000000', null, '1');
INSERT INTO `withdraws` VALUES ('5', '2017-09-11 07:17:56', '2017-09-11 07:17:56', '2N62M7GyxEbcZ7yLoYuhEtvipgSmjwMuXQc', '1', null, null, '116857.0000000', '{\"status\":\"accepted\",\"tx\":\"0100000001cc60f5c93816ceaf8252462a02a38b5f282cc425f1175ac81735196e7a45679b00000000fdfe0000483045022100c7d4957928a640e5465f2b30eed1cbe6d2be765d0c9ff6efb2d495ad324b2fa202201adbd97fb6a1c1f2c2775636c3b7374e873ada4217b27d9805a7ec8e65e3338501483045022100d6a2ea5f29c0bdfac5d157afb1b05e2f5f9511eac82bb4f51778c157d16b0bf402205c1eb040d51168e4bebb58c37eeaa9c143120d95765d72cd0e019fdbc4996617014c69522103233b2dcb5eda82487ad008528c6608c7a69e2500fed5b05f609e4431d5b438862103298c0db19f3a54a83fa26cd7a1c36382e1362f61cdf50435fc5b5c33294ae6962103dcdccf22a93d0d5b3e63aaa934926e1593cf39050c9f8e18071e0b16d93520f553aeffffffff024798d0110000000017a914399d4af2bf2ad43683c096a5aac50d2e6d0cbc908740420f000000000017a9148c2a2befe1e93be7c7b6010054d698e72de972608700000000\",\"hash\":\"6ead7c0d812d9fdbb5a9d4cce660e215545cffd999404a294ecbf2a405ffe46c\",\"instant\":true,\"instantId\":\"59b638a4c09f02ab07fbd2dfcffce9ea\",\"fee\":116857,\"feeRate\":313288,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('6', '2017-09-11 07:41:27', '2017-09-11 07:41:27', '2N1FwK91t46UxJ4C1UXMfF3S8mNwVcoomXR', '1', null, null, '96527.0000000', '{\"status\":\"accepted\",\"tx\":\"010000000001016ce4ff05a4f2cb4e294a4099d9ff5c5415e260e6ccd4a9b5db9f2d810d7cad6e0000000023220020420899abdde0d04ad7f209c2cd39aebe6437c48ebe037f6a5c46f01c0cd11362ffffffff02f8dcbf110000000017a914e0c9edf5132c8ab219d1fe6f12e4523bc48e4cab8740420f000000000017a91457e380b1fb3554f032e107105130d178516c1e4b87040047304402206a7d75bfb0b9368d0d06bea848a27b734c0ddc037cf1e145adab0bfbf731024b02201447ad39126a0aab47477876314fc2daaaeaf23fb8b3b7e259e9f0be5b71166e0147304402207aa1fbc92c9a5ef146f1ed86e9f18a02a555a7836440cf14ac588f011724a1d402204b13e08a99cd65a44b3a4423f8823f56be2954a1ff2b5bf6b91d306f2d5ccd9901695221026a8baf583df5e4a0f66e35c6de3cc445c1dc35eafc3417bc74e0dffd593bfda72102ac72aa527b27fb7ef9f33cf95c113983ea59285befacc953171e0dc2eb888e702102a417a804b88774dc06853c5812a3bbefc9e1eade5339c7ce0b4185aedaeeca1a53ae00000000\",\"hash\":\"6f1241aea73dd120249122cacf20812b734433ca31b0c1c7879199950af3efb0\",\"instant\":true,\"instantId\":\"59b63e27a72de9b4078bdc9de9a5fdce\",\"fee\":96527,\"feeRate\":442783,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('7', '2017-09-11 07:43:55', '2017-09-11 07:43:55', '2N1FwK91t46UxJ4C1UXMfF3S8mNwVcoomXR', '1', null, null, '96533.0000000', '{\"status\":\"accepted\",\"tx\":\"01000000000101b0eff30a95999187c7c1b031ca3344732b8120cfca22912420d13da7ae41126f0000000023220020940942680f3c05b1a24ee7773bf604b43389c115b9de49ffa71b599e5ff9809affffffff0240420f000000000017a91457e380b1fb3554f032e107105130d178516c1e4b87a321af110000000017a91497728542e321ee05b6954705794f0e4aff3fa2928704004830450221009e1aa6f8e42ca1f221e03f16c974726709b74a744f1d036ad1f26573c116506902206c78a4e1db32b1171f7f0213ca6089b4c18d8b00c0a5bcae89bd5434b004733701473044022012a46d81615588dbadf4c5f669f2d158eb233595bcb91ac582d5c6658f70361502205b6bb0e94f14e603e65b44c4e7d03ea43334e8adb9d7eb1b28cb5540b8d4a1db0169522103b791ecb2e4f1d32c75b25deb7703984b67ac47965852cda8a9b802cb1df241e821024612947fee7d68442c7fa0691fc1c65dc0fd93f8a003fac7a6e45f53b54e6ab0210294ec6cb9e010740e9fee2a1c2c9f946ba1ecef6b6b3db9efde3ca26884e8ee8453ae00000000\",\"hash\":\"9c99db13ddcf21c4df3910aa34e7d3d4a3ce7daf300116c9ea2c283589c87d18\",\"instant\":false,\"fee\":96533,\"feeRate\":442808,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('8', '2017-09-11 07:53:32', '2017-09-11 07:53:32', '2N5Ar8aEniJfZFmaEUFHvAmh9a6YAzqn2Mo', '1', null, '10000000.00000', '2180.0000000', '{\"status\":\"accepted\",\"tx\":\"01000000000101187dc88935282ceac9160130af7dcea3d4d3e734aa1039dfc421cfdd13db999c01000000232200200996018444e797a51670f54b2b73d18069c230c4cf5ec6b7db964ec1b3774a0cffffffff029f8216110000000017a9147ff6a135792e7782ed755ad41d7d02189c8a0ac487809698000000000017a91482cd99a65de05b66b404dae1c1cd9a0172e7d89c870400483045022100ef98c44c1bc0dedb8e2c6e9844b7b75bb7662f240edefd53e9aa6712aa15801f02200bcef4f7b2c6b4dddda43757d5baafd712af0c6995a9fdd3669f37e7ada00db0014830450221008c6e0668602cf66b9de0f6d3c5a18f3392b249763185de2ea67e3d2efc71576602201c8c4dd621e59b31ed2fe38de0966042d02ee7e5c5c28e0ff8e53dd2fbd64a8301695221027ee4cb90a651954b3e33b1265b912c95c89f1657d61e07d668c656e00401f6342103555f9bf23fd527d133e0b51af522d2cc6d1048569d768dec82f01c71ec6c295e21021b0856dd37f4cf5f0dcb3885e097d95402d4c9b2315a46396a7f1cdec543d03553ae00000000\",\"hash\":\"34672d518638151c3f93de60958b7913f3937be4e74fe366394db4754b488ebc\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('9', '2017-09-11 08:02:18', '2017-09-11 08:02:18', '2NDD8bRhmxm7HFvh2bxwFZkAFsd4uRosHpa', '1', null, '0.00000', '0.0000000', '{\"status\":\"accepted\",\"tx\":\"01000000000101bc8e484b75b44d3966e34fe7e47b93f313798b9560de933f1c153886512d673400000000232200205949236334b45729de8562517b4bf3674a1e67eea392654c9779a73c503df779ffffffff029be37d100000000017a914ffa61493efc78b8d42fde5eb31a7880a5e969f0987809698000000000017a914dafd2e5584372e731f6e9dc713800765e17a7f8a87040047304402206b6f24becb1aa663f476fb8c5f96a915934b3bd1a01c86733e0fde07d408ce2a022061ee399bf3d2754b0ba5605c0e1003ce2e65c846e81f6231668401ba021e9e1c014730440220687b62065ed7395b68da935d467e6efb5a1229deb0f15c7f1dc10447cd61ef8f0220500f9e3cdeb2a12aa8b0bcd133b16ce960c4a96c007b472802c29547dfa314510169522103e392632cf5bddb4767a0605f14907671f554bf5d4dc1cb8df9f0b6a5f3808db721039a2c9fc1b47529455ce02ca3b8bbd711f9c3aefa89aa14a08c0769fb352108ce2103b995ed4c244d9002a045478fd16a4ac7e7172191391beb4404286c2a6406cf9553ae00000000\",\"hash\":\"eb02a0533a61b0091e2774ab60415cf082344ae00c8e602b460aff2c6751419f\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('10', '2017-09-11 08:03:50', '2017-09-11 08:03:50', '2NAsrcXrtWU6V4T6tyykCvArpPkiSguE9U2', '1', null, '0.00000', '0.0000000', '{\"status\":\"accepted\",\"tx\":\"010000000001019f4151672cff0a462b608e0ce04a3482f05c4160ab74271e09b0613a53a002eb000000002322002029f180f5045e106865f5a398a488150999b6a737e68318c622591c50d9fe2ad6ffffffff0217ae4c0f0000000017a9149547a2afd9e165ad0c05394029ee7196ea20d1e587002d31010000000017a914c167af9a011c65631f87365edc854d7b31fc897c870400473044022006c1e439cdfafc1d8e7a12aeee6e937626ffc6dfd7fba5c0647787d265e4a14a02202872fa58d7994c776e2747128e2a02592cdbef2c22d14f90a73943556905892e014830450221009aed5b5f6e09b54d6f017fe4d8d47121d4e9a98f45ce377dfc899e9ffc633a8b022024f9bde234e9cd4461fddd4d31b517de2025f9d341abd81dda3115b5b6ca924e0169522103bfffac07b9ed1ebbf14ce75745def0c96ec3c437806f49231395ad9bd5dc71c221028ea3ec873dba9bc907fba4e08939e268093cde553d45c076f01e86b00a3845b2210377d9a524af47f43c57f47d4f7c2a9988ecbe0a2b48e94bb1113aebfe494ba5df53ae00000000\",\"hash\":\"f6ce72f6e6cd12baba0f7e1976ed205feedad2a1408afb76f7c4a5f6c45f8203\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('11', '2017-09-11 08:05:20', '2017-09-11 08:05:20', '2N2awxMbdpB7Xi3FgtJ5BZdJetfwDDyHBbN', '1', null, '0.20000', '0.0000200', '{\"status\":\"accepted\",\"tx\":\"0100000000010103825fc4f6a5c4f776fb8a40a1d2daee5f20ed76197e0fbaba12cde6f672cef600000000232200202e114d52149417235155e9477c1dc2cf7810ab8dc914057516776121a7b780aaffffffff02002d31010000000017a91466741142065f19d907424fab57bd90c232b296888793781b0e0000000017a91492df9ae176a7c57ea1f96821da8e4c052fcf700e870400483045022100d60f9838ea3c241a5d102b7ddab93535da4900fe9b158c8d641f4c304cafa7e302203cae16df4bb6e24ec1c97c36bf0223238e50ba34948e4df5a5f258f7e778c99b0147304402207c1d0f57cdbca90206b0f0b728d807a2e78f1d636795582f7e59dcb8d948145d022052919b9cd3102659732e9ec49f85f1ff7b6287e15c76eb9f1f0063c1b62c14770169522103d7c3bd436f31bdc8f7d0b68956ba9b5afa9a0e7302daec10abcf626d10886af62103c29e9c33eb8a1399f2326f6bc7c50cd84bff7184966d1611f526620428379f8b2103aee348bc0f0b8b2c2dcb3a32f5a58b9151c4dea25beac04ff734bfba96fd7f8653ae00000000\",\"hash\":\"68c71c630604f7412e8d63ed31aaccb19b1260759a7c96b5b6358b1f6b729004\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('12', '2017-09-11 08:08:39', '2017-09-11 08:08:39', '2MuDWaMkTmtcX8KsqSS8Qx7pyAKRcVmewuZ', '1', null, '0.21000', '2180.0000000', '{\"status\":\"accepted\",\"tx\":\"010000000001010490726b1f8b35b6b5967c9a7560129bb1ccaa31ed638d2e41f70406631cc768010000002322002063958bb8bd590d4623822dea288057e3f18dd9f1d9732e5f252a2263fa646ab1ffffffff02cf00db0c0000000017a9143d09e613375033b67992177bffc5adc82aca096e87406f40010000000017a914159d4424c5580472fde54e520a03784518ba4a4987040047304402201166c06b0ab5c986fa2e9e2d7841272d7b41151fde9a59d2f15968a2ab59e05c022019b3e0a529ca0054c3e128e7a2c04bda89b3d838f6f68581087b1340f2f095fa01473044022050a2b8f3992ce83c8ee82c5bfdc01754e3ba148d27d96bffa0d4e9e2ca637d13022013b800905fee8583313efa81e5d8072482c2ad856263a206e1e8c71a48f6f849016952210370723d3ca5a534cd6008174e3e39c007f68c3caaa2fa1cbdddb63d573d3360d921032972bbc456eec1e630d1e0111367af0aa61cd6a91a4be8e5f516a40dea2017b32103dcb13cc92b04a2c16a8b6ac4b604a333752874f2213f95f7c421fcd92d560af853ae00000000\",\"hash\":\"a4d181fb60e9b81db23c6f1c505499c777d726bc5c147f401bba46a175755d19\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('13', '2017-09-11 08:10:46', '2017-09-11 08:10:46', '2Mz2f7vnddeig4GUQFz9Kfkj24KYNn1EnTy', '1', null, '0.23000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101195d7575a146ba1b407f145cbc26d777c79954501c6f3cb21db8e960fb81d1a40000000023220020e4d48ca3ae15692f6d0845a9881d2730aa89a1941c97e0b77e043652bd343272ffffffff028b047c0b0000000017a9149ccbabbad91d22ecc0490193a82df7023311bcd887c0f35e010000000017a9144a6873b30bae6d0ea6b9ff884e6669c58262b9ab87040047304402202e88cc37b790897bf8dc2dbe6698d59de6a3187905078791dffe5d7d1ca3a07802202326e77ca9150bfd510b1351b627ebab5539f7477c10a0f0fb256c766752564f01483045022100961884576b0744553caa37db6b084593ab1f2f8be7082d006e5e1ce8ff19c60702201b92b4ab15c2a086af709875322598962a80182eb4050c2d0dfed0209bf084bc0169522103b9472bb6418d1d4502ed4c080f8a2a0e9224fb5d642608a1a2befdd6c56c39482102b2691f81817d7298550cc4fd84f33fbeabf13edb45e0f9ac3effd8f58aefc2522103f8f1ded7b71f7fb383ebd2e1d4061a755101ecf61ecc1824334d15e718efeca853ae00000000\",\"hash\":\"bf643d63a19e68009df8c2fb6a547c916d0d19b30dd0fb2450f1add30a0570d4\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('14', '2017-09-11 08:12:21', '2017-09-11 08:12:21', '2N3PXX3asLt76cGkMLpyMnnYsGGXdAwxPuA', '1', null, '0.23100', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101d470050ad3adf15024fbd00db3190d6d917c546afbc2f89d00689ea1633d64bf0000000023220020b515303aadc87daad06f9f6d1d0f88b2331207d95e17e7dd155e6ab23fecbbabffffffff02607a60010000000017a9146f43381a0ad175adef43392f6ec276eb6c5831b987a7811b0a0000000017a91437947555252384aa4bad1622d5f0a0a43f8e3590870400483045022100b40ea7f09f9f3d92ff96565a5fcb59b1e126b1c02eb333082b5ec0fdf2b5abf802200419c57a7ec05abf581cb81aa034ba1cbd3d1888cafbfc248b4d0fac9c92c4f101473044022068ce539da3346bafc6a1dda23c0207e681e61eea781fedfdb521fcbfe32685b70220343680438c1549f732dd2d296df4609498f5053d49702c5ac4de7f68cffcf47a0169522103f1c343c29dae03f365df9d753f3029e258638996accc056b194a1936456be9362102bbff27485d65776364435e2a41847db6500c263bd77a545e7e96f53d7df5402c210276ec4ae1e842ba1ebf96a681e9f12ecd9d20940b42ca0a7310051617172e0e1a53ae00000000\",\"hash\":\"323d688a142048c503a14eb9c4ab0ecee47e04b9dec533f6dcc30f19b70c2eba\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
