/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-23 09:40:10
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_binary
-- ----------------------------
INSERT INTO `bonus_binary` VALUES ('1', '2017-09-22 17:44:07', '2017-09-22 18:03:49', '2', '38', '2017', '1100', '13100', '0', '0', '1100', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('2', '2017-09-22 17:44:34', '2017-09-22 18:03:49', '5', '38', '2017', '3000', '16600', '0', '0', '3000', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('3', '2017-09-22 17:45:18', '2017-09-22 18:03:49', '4', '38', '2017', '1000', '12600', '0', '0', '1000', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('4', '2017-09-22 17:45:32', '2017-09-22 18:03:44', '7', '38', '2017', '0', '11600', '0', '0', '0', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('5', '2017-09-22 17:47:22', '2017-09-22 18:03:44', '15', '38', '2017', '0', '1600', '0', '0', '0', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('6', '2017-09-22 17:53:58', '2017-09-22 18:03:49', '6', '38', '2017', '1000', '0', '0', '0', '0', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('7', '2017-09-22 17:54:59', '2017-09-22 18:03:44', '18', '38', '2017', '0', '1100', '0', '0', '0', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('8', '2017-09-22 18:03:44', '2017-09-22 18:03:44', '9', '38', '2017', '0', '1000', '0', '0', '0', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('9', '2017-09-22 18:03:49', '2017-09-22 18:03:49', '8', '38', '2017', '500', '0', '0', '0', '0', null, '0', '201738');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `bonus_faststart` VALUES ('16', '2017-09-22 17:48:52', '2017-09-22 17:48:52', '6', '1', '8', '50');
INSERT INTO `bonus_faststart` VALUES ('17', '2017-09-22 17:48:52', '2017-09-22 17:48:52', '5', '2', '8', '10');
INSERT INTO `bonus_faststart` VALUES ('18', '2017-09-22 17:48:52', '2017-09-22 17:48:52', '2', '3', '8', '5');
INSERT INTO `bonus_faststart` VALUES ('19', '2017-09-22 17:49:24', '2017-09-22 17:49:24', '7', '1', '9', '10');
INSERT INTO `bonus_faststart` VALUES ('20', '2017-09-22 17:49:24', '2017-09-22 17:49:24', '5', '2', '9', '2');
INSERT INTO `bonus_faststart` VALUES ('21', '2017-09-22 17:49:24', '2017-09-22 17:49:24', '2', '3', '9', '1');
INSERT INTO `bonus_faststart` VALUES ('22', '2017-09-22 17:58:56', '2017-09-22 17:58:56', '4', '1', '26', '100');
INSERT INTO `bonus_faststart` VALUES ('23', '2017-09-22 17:58:57', '2017-09-22 17:58:57', '2', '2', '26', '20');
INSERT INTO `bonus_faststart` VALUES ('24', '2017-09-22 17:59:24', '2017-09-22 17:59:24', '4', '1', '27', '50');
INSERT INTO `bonus_faststart` VALUES ('25', '2017-09-22 17:59:24', '2017-09-22 17:59:24', '2', '2', '27', '10');

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
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', 'SISbq2Ljbrr8WDSlpYEMOvziaTFhJ6NvcjcqmR8wxqnQ4EFBu4jZ2yAbCUr9', '2017-08-12 05:47:39', '2017-09-15 08:22:03', '1', 'Nguyen', 'Hong', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '2N8RNXCGHTWkdimArM27XW9EzUAmri5uVe1', 'Profile', null, null, null, '', null, null, null);
INSERT INTO `users` VALUES ('2', 'root', 'root@gmail.com', '$2y$10$bvHYiVB0zslAXAKnm/s9f.bpR9yb0.Wghs6d/ODVoDWL9TkTuxM4m', null, '2017-09-22 16:17:18', '2017-09-22 16:17:18', '0', 'root', 'Do', '0978788999', '0', '1', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('3', 'member1', 'member1@gmail.com', '$2y$10$rUAgleT3Ty/OYWJuS6DpQuEewCjPBg0duWxo4kGe17YZcmoX3Bc1S', 'qDsLXLmsfZtgZkEyQVOlcXQlw0htMNFgo7a2O0iBuh2tgfoinwMdYnBHH4oa', '2017-09-22 16:17:52', '2017-09-22 16:17:52', '0', 'member1', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('4', 'member2', 'member2@gmail.com', '$2y$10$pcnJOoocVDPqVFBBZSTbLuZVkQlYX1C1naf9IQ942lga9vFP9F1Q2', 'TUU1VVxiVXHhIA6bJBC0fdieZLeaVao4tmaGufU2z1H7UpBqxOqQ9XxDmPJS', '2017-09-22 16:18:09', '2017-09-22 16:18:09', '0', 'member2', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('5', 'member3', 'member3@gmail.com', '$2y$10$knE5WcDP.hvmgaPDFmCFaOHgSF.lFzvPXDZqgZLxpYFUXw737syZ.', 't9C5gd9NedH8fyi2cSGAZZF6KpNSyxfo6z0RVNLAikTKvwWR6rcAWkiFv2Gh', '2017-09-22 16:18:20', '2017-09-22 16:18:20', '0', 'member3', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('6', 'member4', 'member4@gmail.com', '$2y$10$vgvkjmqSse/WLX21MnZJIej5DJgOnCLpBb1eDz9uTGdh0kym7Y3.C', '4X8mPzM6xHxzlqsbxWM34sQYuyWVOv2K4nWi0fubXsthvxEKDQVZC5v23I4Y', '2017-09-22 16:19:18', '2017-09-22 16:19:18', '0', 'member4', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('7', 'member5', 'member5@gmail.com', '$2y$10$38MEFbHhoDlZSChVc82DG.2Lf5hFRQfPx0StjYdyNNM1gG.nAuaee', 'OXGrgFBHXbhbJeqa9KFKLdrQfcSWB9GRnEacYPufhPz6J7O1E821z9nqew3o', '2017-09-22 16:19:31', '2017-09-22 16:19:31', '0', 'member5', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('8', 'member6', 'member6@gmail.com', '$2y$10$B3.iV9NVlELRG4yb2u2XLuwRrztWJiHigx.Aki5oPiXsAffeNjZAO', 'k1WzrkFPk0JzX1z7NFjqGbMtEpWb2CjtBNkQNc5hOQhJ3eWdtxYBrVWGLKx7', '2017-09-22 16:19:38', '2017-09-22 16:19:38', '0', 'member6', 'Do', '0978788999', '0', '6', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('9', 'member7', 'member7@gmail.com', '$2y$10$ODxJ4Fk6tRj38Jtb6CjH8.Kzn73aEtS9THKgktzDc8zm56PyDF.DS', 'wAeqsieqDFSN2snxLS2eK24jIEOsUb7La5CKqxiamF9u1bqR7o0aNqvOfdiu', '2017-09-22 16:19:47', '2017-09-22 16:19:47', '0', 'member7', 'Do', '0978788999', '0', '7', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('10', 'member8', 'member8@gmail.com', '$2y$10$4Ot3ODxb2CwnK03wp5TSMeD3MSLrLceZpz9hgZt5MDnZFkc0rwktS', null, '2017-09-22 16:19:56', '2017-09-22 16:19:56', '0', 'member8', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('11', 'member9', 'member9@gmail.com', '$2y$10$KRwuqz9dKftGst0cyAlPt.rtemTRNaD4jmIv1o5R3Kgi9AF7ijeaC', null, '2017-09-22 16:20:03', '2017-09-22 16:20:03', '0', 'member9', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('12', 'member10', 'member10@gmail.com', '$2y$10$WRwoU7SVvzm/MRiDB3XJzODCaoOIrnw6D4/gdb9EptXNS9kjXBZW.', null, '2017-09-22 16:20:11', '2017-09-22 16:20:11', '0', 'member10', 'Do', '0978788999', '0', '11', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('13', 'member11', 'member11@gmail.com', '$2y$10$vBvx7ndHMdwsxUqdL8set.kpXpu0sLEv9KSiVvA9/r.PmhKGbocp.', null, '2017-09-22 16:20:23', '2017-09-22 16:20:23', '0', 'member11', 'Do', '0978788999', '0', '11', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('14', 'member12', 'member12@gmail.com', '$2y$10$xzzr0wphlpJHaeiHPT8Q3uCLa.6RjLouuIK/uUprVPu6RhAF4neg2', null, '2017-09-22 16:20:33', '2017-09-22 16:20:33', '0', 'member12', 'Do', '0978788999', '0', '11', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('15', 'member13', 'member13@gmail.com', '$2y$10$enuQRp6UMrNEZSr/EcEkA.VHY27893FTZVbqJrnAYHc9D.spJAq3a', 'IgbRaPjL4AlbSSLRqUiupdqLIztN2ACNOW7V6PSAniX7C0UhqZ3F06wdzGQL', '2017-09-22 16:20:48', '2017-09-22 16:20:48', '0', 'member13', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('16', 'member14', 'member14@gmail.com', '$2y$10$Jz0Nnk2QEAKvZXEF90JkruTrI1I5l85xlmumMUyw1qW2fj3uUakNS', null, '2017-09-22 16:20:55', '2017-09-22 16:20:55', '0', 'member14', 'Do', '0978788999', '0', '9', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('17', 'member15', 'member15@gmail.com', '$2y$10$GdctBsn1Ohaz9FYokW.CXez6FBGBb0bdKSWYgKD54ZGZTLwITC/YO', null, '2017-09-22 16:21:06', '2017-09-22 16:21:06', '0', 'member15', 'Do', '0978788999', '0', '12', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('18', 'member16', 'member16@gmail.com', '$2y$10$L6n/aBgYYT/LofKRT4W9i.CTTjnhg84Mwvini.XWoWR8.oScnjRle', 'Rstn1LwnzkohkNb33OZz6zNdd2RyE9uaKTkfvC6I8BksiEgkpGphSUXJRtkn', '2017-09-22 16:21:13', '2017-09-22 16:21:13', '0', 'member16', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('19', 'member17', 'member17@gmail.com', '$2y$10$Ygsnt6.IPzP4jqhBdqVGWeTQCXpagBMQymVRENAwXmUvsB3nlh.eC', null, '2017-09-22 16:21:22', '2017-09-22 16:21:22', '0', 'member17', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('20', 'member18', 'member18@gmail.com', '$2y$10$lJdKGXrUdHYH/nut07c0aOO.QyZfDo1Q/cMGjCpAypyLo98JEIeKm', null, '2017-09-22 16:21:30', '2017-09-22 16:21:30', '0', 'member18', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('21', 'member19', 'member19@gmail.com', '$2y$10$ZDsiY9lwdcNasdVASZUMweV1L80vG6tW7XRKm6bRgxg7wJW/r87ka', null, '2017-09-22 16:21:38', '2017-09-22 16:21:38', '0', 'member19', 'Do', '0978788999', '0', '20', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('22', 'member20', 'member20@gmail.com', '$2y$10$RTUiTpWrx2ORg5bWwNRA8.YXT7NVDNPAwz.R2I3YGKDgx8.dAJWdm', null, '2017-09-22 16:21:45', '2017-09-22 16:21:45', '0', 'member20', 'Do', '0978788999', '0', '20', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('23', 'member21', 'member21@gmail.com', '$2y$10$Stq6ZcRfzUq6Aqj4/KlUCew66DgkhNM18GSQ.flmYVvaWerRjTMcy', null, '2017-09-22 16:21:55', '2017-09-22 16:21:55', '0', 'member21', 'Do', '0978788999', '0', '21', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('24', 'member22', 'member22@gmail.com', '$2y$10$mbrTe1rsYMZTzw3UWjCFOO.en3/bZbja8fxt7XMEJARX2Bshgq20y', null, '2017-09-22 16:22:01', '2017-09-22 16:22:01', '0', 'member22', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('25', 'member23', 'member23@gmail.com', '$2y$10$JJ7PiuccK8UTNnw7qJo6N.em/cy5w536pW./Ru844UqWJqff93HdK', null, '2017-09-22 16:22:09', '2017-09-22 16:22:09', '0', 'member23', 'Do', '0978788999', '0', '5', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('26', 'member24', 'member24@gmail.com', '$2y$10$y3UtL1dZmvHncrI5oiKjyuP/LPTpczmRFyufJ8TCFeygLhQx0/6zG', 'fqg43bhDxSjN3LBb62Wzqa0X6SOWBFOEVkLwExOVdqRlRTppY9xA3iSEvAJP', '2017-09-22 17:57:39', '2017-09-22 17:57:39', '0', 'member24', 'Do', '0978788999', '0', '4', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('27', 'member25', 'member25@gmail.com', '$2y$10$wx11UT6TC7UI3/YFZxX/TeY8WZ4hGz/bVz16TyYC6AhDmq430Y0CK', 'N2evFiQ7wDG3PYU5n6gvUdKukrbrMiHJMTabskPherC8cH65iWrGGVAtSPmW', '2017-09-22 17:57:57', '2017-09-22 17:57:57', '0', 'member25', 'Do', '0978788999', '0', '4', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('28', 'member26', 'member26@gmail.com', '$2y$10$UoMVKA1WvKQbUXfpSPLkPOzhX8/FmqgahUW8R09fCsmGNBdfJDedC', null, '2017-09-22 17:58:11', '2017-09-22 17:58:11', '0', 'member26', 'Do', '0978788999', '0', '26', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('29', 'member27', 'member27@gmail.com', '$2y$10$UJdCSTAAI0okL9mnA1F4se0iq8N31OKc5Wpe0CfPDnAiwndBpV3HG', null, '2017-09-22 17:58:17', '2017-09-22 17:58:17', '0', 'member27', 'Do', '0978788999', '0', '26', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('30', 'member28', 'member28@gmail.com', '$2y$10$KISvGamoSBa.2aXV.Z/UxOQCzIMYj7Mxe05bfrLkn4szp2oDvfdWu', null, '2017-09-22 17:58:27', '2017-09-22 17:58:27', '0', 'member28', 'Do', '0978788999', '0', '28', 'test', '1', null, null, null, null, null, '704', null, null, null);

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_loyalty
-- ----------------------------
INSERT INTO `users_loyalty` VALUES ('1', '2', '0', '0', '0', '0', '0', '100', '12000', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('2', '3', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('3', '4', '0', '0', '0', '0', '0', '500', '1000', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('4', '5', '0', '0', '0', '0', '0', '2000', '5000', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('5', '7', '0', '0', '0', '0', '0', '0', '100', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('6', '6', '0', '0', '0', '0', '0', '500', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('7', '15', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('8', '18', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('9', '8', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('10', '9', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('11', '26', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('12', '27', '0', '0', '0', '0', '0', '0', '0', '0', null, null);

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
INSERT INTO `user_coins` VALUES ('1', '1GGmXKpWxhnewFshqw7fKKdnMEAf7wjzSy', 'c9750047-5a1e-57aa-95ca-f72a7bd721cc', '0.6', '500', '445.2', '296.8', null);
INSERT INTO `user_coins` VALUES ('2', 'test', 'test', '0', '15535.714285714286', '831.6', '554.4', null);
INSERT INTO `user_coins` VALUES ('3', 'test', 'test', '0', '19910.714285714286', '0', '0', null);
INSERT INTO `user_coins` VALUES ('4', 'test', 'test', '0', '19553.571428571428', '90', '60', null);
INSERT INTO `user_coins` VALUES ('5', 'test', 'test', '0', '19107.14285714286', '427.2', '284.8', null);
INSERT INTO `user_coins` VALUES ('6', 'test', 'test', '0', '18214.285714285714', '30', '20', null);
INSERT INTO `user_coins` VALUES ('7', 'test', 'test', '0', '15535.714285714286', '6', '4', null);
INSERT INTO `user_coins` VALUES ('8', 'test', 'test', '0', '19553.571428571428', '0', '0', null);
INSERT INTO `user_coins` VALUES ('9', 'test', 'test', '0', '19910.714285714286', '0', '0', null);
INSERT INTO `user_coins` VALUES ('10', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('11', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('12', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('13', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('14', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('15', 'test', 'test', '0', '11071.428571428572', '0', '0', null);
INSERT INTO `user_coins` VALUES ('16', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('17', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('18', 'test', 'test', '0', '19553.571428571428', '0', '0', null);
INSERT INTO `user_coins` VALUES ('19', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('20', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('21', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('22', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('23', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('24', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('25', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('26', 'test', 'test', '0', '19107.14285714286', '0', '0', null);
INSERT INTO `user_coins` VALUES ('27', 'test', 'test', '0', '19553.571428571428', '0', '0', null);
INSERT INTO `user_coins` VALUES ('28', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('29', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('30', 'test', 'test', '0', '20000', '0', '0', null);

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
INSERT INTO `user_datas` VALUES ('1', '0', '3', '2017-09-22 17:46:48', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '1476', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('2', '1', '5', '2017-09-22 18:03:49', 'test', 'test', '1386', '0', null, '1100', '13100', '0', '27', '26', '3', '6', '9', '0', '1');
INSERT INTO `user_datas` VALUES ('3', '2', '1', '2017-09-22 17:44:07', 'test', 'test', '0', '1', 'left', '0', '0', '2', '3', '3', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('4', '2', '2', '2017-09-22 18:03:49', 'test', 'test', '150', '1', 'right', '1000', '12600', '2', '27', '26', '2', '5', '7', '0', '1');
INSERT INTO `user_datas` VALUES ('5', '2', '3', '2017-09-22 18:03:49', 'test', 'test', '712', '1', 'right', '3000', '16600', '4', '27', '26', '3', '5', '8', '0', '1');
INSERT INTO `user_datas` VALUES ('6', '5', '4', '2017-09-22 18:03:49', 'test', 'test', '50', '1', 'left', '1000', '0', '5', '27', '6', '2', '0', '2', '0', '1');
INSERT INTO `user_datas` VALUES ('7', '5', '5', '2017-09-22 18:03:44', 'test', 'test', '10', '1', 'right', '0', '11600', '5', '7', '26', '0', '4', '4', '0', '1');
INSERT INTO `user_datas` VALUES ('8', '6', '2', '2017-09-22 18:03:49', 'test', 'test', '0', '1', 'left', '500', '0', '6', '27', '8', '1', '0', '1', '0', '1');
INSERT INTO `user_datas` VALUES ('9', '7', '1', '2017-09-22 18:03:44', 'test', 'test', '0', '1', 'right', '0', '1000', '18', '9', '26', '0', '1', '1', '0', '1');
INSERT INTO `user_datas` VALUES ('10', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('11', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('12', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('13', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('14', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('15', '2', '6', '2017-09-22 18:03:44', 'test', 'test', '0', '1', 'right', '0', '1600', '7', '15', '26', '0', '3', '3', '0', '1');
INSERT INTO `user_datas` VALUES ('16', '9', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('17', '12', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('18', '2', '2', '2017-09-22 18:03:44', 'test', 'test', '0', '1', 'right', '0', '1100', '15', '18', '26', '0', '2', '2', '0', '1');
INSERT INTO `user_datas` VALUES ('19', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('20', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('21', '20', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('22', '20', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('23', '21', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('24', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('25', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('26', '4', '3', '2017-09-22 18:03:44', 'test', 'test', '0', '1', 'right', '0', '0', '9', '26', '26', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('27', '4', '2', '2017-09-22 18:03:49', 'test', 'test', '0', '1', 'left', '0', '0', '8', '27', '27', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('28', '26', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('29', '26', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('30', '28', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

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
INSERT INTO `user_packages` VALUES ('3', '1', '2017-09-22 17:40:05', '2017-09-22 17:40:05', '100', '2017-09-22 17:40:05', '2018-03-21 17:40:05');
INSERT INTO `user_packages` VALUES ('4', '2', '2017-09-22 17:40:31', '2017-09-22 17:40:31', '500', '2017-09-22 17:40:31', '2018-03-21 17:40:31');
INSERT INTO `user_packages` VALUES ('5', '3', '2017-09-22 17:40:50', '2017-09-22 17:40:50', '1000', '2017-09-22 17:40:50', '2018-03-21 17:40:50');
INSERT INTO `user_packages` VALUES ('2', '5', '2017-09-22 17:41:04', '2017-09-22 17:41:04', '5000', '2017-09-22 17:41:04', '2018-03-21 17:41:04');
INSERT INTO `user_packages` VALUES ('6', '4', '2017-09-22 17:41:23', '2017-09-22 17:41:23', '2000', '2017-09-22 17:41:23', '2018-03-21 17:41:23');
INSERT INTO `user_packages` VALUES ('7', '5', '2017-09-22 17:41:42', '2017-09-22 17:41:42', '5000', '2017-09-22 17:41:42', '2018-03-21 17:41:42');
INSERT INTO `user_packages` VALUES ('15', '6', '2017-09-22 17:42:01', '2017-09-22 17:42:01', '10000', '2017-09-22 17:42:01', '2018-03-21 17:42:01');
INSERT INTO `user_packages` VALUES ('18', '2', '2017-09-22 17:46:48', '2017-09-22 17:46:48', '500', '2017-09-22 17:46:48', '2018-03-21 17:46:48');
INSERT INTO `user_packages` VALUES ('8', '2', '2017-09-22 17:48:52', '2017-09-22 17:48:52', '500', '2017-09-22 17:48:52', '2018-03-21 17:48:52');
INSERT INTO `user_packages` VALUES ('9', '1', '2017-09-22 17:49:24', '2017-09-22 17:49:24', '100', '2017-09-22 17:49:24', '2018-03-21 17:49:24');
INSERT INTO `user_packages` VALUES ('26', '3', '2017-09-22 17:58:56', '2017-09-22 17:58:56', '1000', '2017-09-22 17:58:56', '2018-03-21 17:58:56');
INSERT INTO `user_packages` VALUES ('27', '2', '2017-09-22 17:59:24', '2017-09-22 17:59:24', '500', '2017-09-22 17:59:24', '2018-03-21 17:59:24');

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
) ENGINE=InnoDB AUTO_INCREMENT=411 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of wallets
-- ----------------------------
INSERT INTO `wallets` VALUES ('1', null, '2017-09-22 17:40:05', '2017-09-22 17:40:05', '1', '1', 'member1 Register Package', 'in', '2', '6');
INSERT INTO `wallets` VALUES ('2', null, '2017-09-22 17:40:05', '2017-09-22 17:40:05', '4', '1', 'member1 Register Package', 'in', '2', '4');
INSERT INTO `wallets` VALUES ('3', null, '2017-09-22 17:40:05', '2017-09-22 17:40:05', '1', '1', 'member1 Register Package', 'in', '1', '1.2');
INSERT INTO `wallets` VALUES ('4', null, '2017-09-22 17:40:05', '2017-09-22 17:40:05', '4', '1', 'member1 Register Package', 'in', '1', '0.8');
INSERT INTO `wallets` VALUES ('5', null, '2017-09-22 17:40:31', '2017-09-22 17:40:31', '1', '1', 'member2 Register Package', 'in', '2', '30');
INSERT INTO `wallets` VALUES ('6', null, '2017-09-22 17:40:31', '2017-09-22 17:40:31', '4', '1', 'member2 Register Package', 'in', '2', '20');
INSERT INTO `wallets` VALUES ('7', null, '2017-09-22 17:40:31', '2017-09-22 17:40:31', '1', '1', 'member2 Register Package', 'in', '1', '6');
INSERT INTO `wallets` VALUES ('8', null, '2017-09-22 17:40:31', '2017-09-22 17:40:31', '4', '1', 'member2 Register Package', 'in', '1', '4');
INSERT INTO `wallets` VALUES ('9', null, '2017-09-22 17:40:50', '2017-09-22 17:40:50', '1', '1', 'member3 Register Package', 'in', '2', '60');
INSERT INTO `wallets` VALUES ('10', null, '2017-09-22 17:40:50', '2017-09-22 17:40:50', '4', '1', 'member3 Register Package', 'in', '2', '40');
INSERT INTO `wallets` VALUES ('11', null, '2017-09-22 17:40:51', '2017-09-22 17:40:51', '1', '1', 'member3 Register Package', 'in', '1', '12');
INSERT INTO `wallets` VALUES ('12', null, '2017-09-22 17:40:51', '2017-09-22 17:40:51', '4', '1', 'member3 Register Package', 'in', '1', '8');
INSERT INTO `wallets` VALUES ('13', null, '2017-09-22 17:41:04', '2017-09-22 17:41:04', '1', '1', 'root Register Package', 'in', '1', '300');
INSERT INTO `wallets` VALUES ('14', null, '2017-09-22 17:41:04', '2017-09-22 17:41:04', '4', '1', 'root Register Package', 'in', '1', '200');
INSERT INTO `wallets` VALUES ('15', null, '2017-09-22 17:41:23', '2017-09-22 17:41:23', '1', '1', 'member4 Register Package', 'in', '5', '120');
INSERT INTO `wallets` VALUES ('16', null, '2017-09-22 17:41:23', '2017-09-22 17:41:23', '4', '1', 'member4 Register Package', 'in', '5', '80');
INSERT INTO `wallets` VALUES ('17', null, '2017-09-22 17:41:23', '2017-09-22 17:41:23', '1', '1', 'member4 Register Package', 'in', '2', '24');
INSERT INTO `wallets` VALUES ('18', null, '2017-09-22 17:41:23', '2017-09-22 17:41:23', '4', '1', 'member4 Register Package', 'in', '2', '16');
INSERT INTO `wallets` VALUES ('19', null, '2017-09-22 17:41:42', '2017-09-22 17:41:42', '1', '1', 'member5 Register Package', 'in', '5', '300');
INSERT INTO `wallets` VALUES ('20', null, '2017-09-22 17:41:42', '2017-09-22 17:41:42', '4', '1', 'member5 Register Package', 'in', '5', '200');
INSERT INTO `wallets` VALUES ('21', null, '2017-09-22 17:41:42', '2017-09-22 17:41:42', '1', '1', 'member5 Register Package', 'in', '2', '60');
INSERT INTO `wallets` VALUES ('22', null, '2017-09-22 17:41:42', '2017-09-22 17:41:42', '4', '1', 'member5 Register Package', 'in', '2', '40');
INSERT INTO `wallets` VALUES ('23', null, '2017-09-22 17:42:01', '2017-09-22 17:42:01', '1', '1', 'member13 Register Package', 'in', '2', '600');
INSERT INTO `wallets` VALUES ('24', null, '2017-09-22 17:42:01', '2017-09-22 17:42:01', '4', '1', 'member13 Register Package', 'in', '2', '400');
INSERT INTO `wallets` VALUES ('25', null, '2017-09-22 17:42:01', '2017-09-22 17:42:01', '1', '1', 'member13 Register Package', 'in', '1', '120');
INSERT INTO `wallets` VALUES ('26', null, '2017-09-22 17:42:01', '2017-09-22 17:42:01', '4', '1', 'member13 Register Package', 'in', '1', '80');
INSERT INTO `wallets` VALUES ('27', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('28', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('29', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('30', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('31', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('32', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('33', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('34', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('35', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('36', null, '2017-09-22 17:44:11', '2017-09-22 17:44:11', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('37', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('38', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('39', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('40', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('41', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('42', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('43', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('44', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('45', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('46', null, '2017-09-22 17:44:37', '2017-09-22 17:44:37', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('47', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('48', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('49', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('50', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('51', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('52', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('53', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('54', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('55', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('56', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('57', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('58', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('59', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('60', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('61', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('62', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('63', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('64', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('65', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('66', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('67', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('68', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('69', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('70', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('71', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('72', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('73', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('74', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('75', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('76', null, '2017-09-22 17:45:18', '2017-09-22 17:45:18', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('77', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'silver', 'in', '7', '3000');
INSERT INTO `wallets` VALUES ('78', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'silver', 'in', '7', '2000');
INSERT INTO `wallets` VALUES ('79', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'gold', 'in', '7', '6000');
INSERT INTO `wallets` VALUES ('80', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'gold', 'in', '7', '4000');
INSERT INTO `wallets` VALUES ('81', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'pear', 'in', '7', '12000');
INSERT INTO `wallets` VALUES ('82', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'pear', 'in', '7', '8000');
INSERT INTO `wallets` VALUES ('83', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'emerald', 'in', '7', '30000');
INSERT INTO `wallets` VALUES ('84', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'emerald', 'in', '7', '20000');
INSERT INTO `wallets` VALUES ('85', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'diamond', 'in', '7', '60000');
INSERT INTO `wallets` VALUES ('86', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'diamond', 'in', '7', '40000');
INSERT INTO `wallets` VALUES ('87', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('88', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('89', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('90', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('91', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('92', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('93', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('94', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('95', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('96', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('97', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('98', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('99', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('100', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('101', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('102', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('103', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('104', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('105', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('106', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('107', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('108', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('109', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('110', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('111', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('112', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('113', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('114', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('115', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('116', null, '2017-09-22 17:45:32', '2017-09-22 17:45:32', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('117', null, '2017-09-22 17:46:48', '2017-09-22 17:46:48', '1', '1', 'member16 Register Package', 'in', '2', '30');
INSERT INTO `wallets` VALUES ('118', null, '2017-09-22 17:46:48', '2017-09-22 17:46:48', '4', '1', 'member16 Register Package', 'in', '2', '20');
INSERT INTO `wallets` VALUES ('119', null, '2017-09-22 17:46:48', '2017-09-22 17:46:48', '1', '1', 'member16 Register Package', 'in', '1', '6');
INSERT INTO `wallets` VALUES ('120', null, '2017-09-22 17:46:48', '2017-09-22 17:46:48', '4', '1', 'member16 Register Package', 'in', '1', '4');
INSERT INTO `wallets` VALUES ('121', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'silver', 'in', '15', '3000');
INSERT INTO `wallets` VALUES ('122', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'silver', 'in', '15', '2000');
INSERT INTO `wallets` VALUES ('123', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'gold', 'in', '15', '6000');
INSERT INTO `wallets` VALUES ('124', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'gold', 'in', '15', '4000');
INSERT INTO `wallets` VALUES ('125', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'pear', 'in', '15', '12000');
INSERT INTO `wallets` VALUES ('126', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'pear', 'in', '15', '8000');
INSERT INTO `wallets` VALUES ('127', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'emerald', 'in', '15', '30000');
INSERT INTO `wallets` VALUES ('128', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'emerald', 'in', '15', '20000');
INSERT INTO `wallets` VALUES ('129', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'diamond', 'in', '15', '60000');
INSERT INTO `wallets` VALUES ('130', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'diamond', 'in', '15', '40000');
INSERT INTO `wallets` VALUES ('131', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'silver', 'in', '7', '3000');
INSERT INTO `wallets` VALUES ('132', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'silver', 'in', '7', '2000');
INSERT INTO `wallets` VALUES ('133', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'gold', 'in', '7', '6000');
INSERT INTO `wallets` VALUES ('134', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'gold', 'in', '7', '4000');
INSERT INTO `wallets` VALUES ('135', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'pear', 'in', '7', '12000');
INSERT INTO `wallets` VALUES ('136', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'pear', 'in', '7', '8000');
INSERT INTO `wallets` VALUES ('137', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'emerald', 'in', '7', '30000');
INSERT INTO `wallets` VALUES ('138', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'emerald', 'in', '7', '20000');
INSERT INTO `wallets` VALUES ('139', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'diamond', 'in', '7', '60000');
INSERT INTO `wallets` VALUES ('140', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'diamond', 'in', '7', '40000');
INSERT INTO `wallets` VALUES ('141', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('142', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('143', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('144', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('145', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('146', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('147', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('148', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('149', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('150', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('151', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('152', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('153', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('154', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('155', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('156', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('157', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('158', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('159', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('160', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('161', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('162', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('163', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('164', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('165', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('166', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('167', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('168', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('169', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('170', null, '2017-09-22 17:47:22', '2017-09-22 17:47:22', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('171', null, '2017-09-22 17:48:52', '2017-09-22 17:48:52', '1', '1', 'member6 Register Package', 'in', '6', '30');
INSERT INTO `wallets` VALUES ('172', null, '2017-09-22 17:48:52', '2017-09-22 17:48:52', '4', '1', 'member6 Register Package', 'in', '6', '20');
INSERT INTO `wallets` VALUES ('173', null, '2017-09-22 17:48:52', '2017-09-22 17:48:52', '1', '1', 'member6 Register Package', 'in', '5', '6');
INSERT INTO `wallets` VALUES ('174', null, '2017-09-22 17:48:52', '2017-09-22 17:48:52', '4', '1', 'member6 Register Package', 'in', '5', '4');
INSERT INTO `wallets` VALUES ('175', null, '2017-09-22 17:48:52', '2017-09-22 17:48:52', '1', '1', 'member6 Register Package', 'in', '2', '3');
INSERT INTO `wallets` VALUES ('176', null, '2017-09-22 17:48:52', '2017-09-22 17:48:52', '4', '1', 'member6 Register Package', 'in', '2', '2');
INSERT INTO `wallets` VALUES ('177', null, '2017-09-22 17:49:24', '2017-09-22 17:49:24', '1', '1', 'member7 Register Package', 'in', '7', '6');
INSERT INTO `wallets` VALUES ('178', null, '2017-09-22 17:49:24', '2017-09-22 17:49:24', '4', '1', 'member7 Register Package', 'in', '7', '4');
INSERT INTO `wallets` VALUES ('179', null, '2017-09-22 17:49:24', '2017-09-22 17:49:24', '1', '1', 'member7 Register Package', 'in', '5', '1.2');
INSERT INTO `wallets` VALUES ('180', null, '2017-09-22 17:49:24', '2017-09-22 17:49:24', '4', '1', 'member7 Register Package', 'in', '5', '0.8');
INSERT INTO `wallets` VALUES ('181', null, '2017-09-22 17:49:24', '2017-09-22 17:49:24', '1', '1', 'member7 Register Package', 'in', '2', '0.6');
INSERT INTO `wallets` VALUES ('182', null, '2017-09-22 17:49:24', '2017-09-22 17:49:24', '4', '1', 'member7 Register Package', 'in', '2', '0.4');
INSERT INTO `wallets` VALUES ('183', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'silver', 'in', '6', '3000');
INSERT INTO `wallets` VALUES ('184', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'silver', 'in', '6', '2000');
INSERT INTO `wallets` VALUES ('185', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'gold', 'in', '6', '6000');
INSERT INTO `wallets` VALUES ('186', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'gold', 'in', '6', '4000');
INSERT INTO `wallets` VALUES ('187', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'pear', 'in', '6', '12000');
INSERT INTO `wallets` VALUES ('188', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'pear', 'in', '6', '8000');
INSERT INTO `wallets` VALUES ('189', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'emerald', 'in', '6', '30000');
INSERT INTO `wallets` VALUES ('190', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'emerald', 'in', '6', '20000');
INSERT INTO `wallets` VALUES ('191', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'diamond', 'in', '6', '60000');
INSERT INTO `wallets` VALUES ('192', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'diamond', 'in', '6', '40000');
INSERT INTO `wallets` VALUES ('193', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('194', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('195', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('196', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('197', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('198', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('199', null, '2017-09-22 17:53:58', '2017-09-22 17:53:58', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('200', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('201', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('202', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('203', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('204', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('205', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('206', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('207', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('208', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('209', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('210', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('211', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('212', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('213', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('214', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('215', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('216', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('217', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('218', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('219', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('220', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('221', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('222', null, '2017-09-22 17:53:59', '2017-09-22 17:53:59', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('223', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'silver', 'in', '18', '3000');
INSERT INTO `wallets` VALUES ('224', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'silver', 'in', '18', '2000');
INSERT INTO `wallets` VALUES ('225', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'gold', 'in', '18', '6000');
INSERT INTO `wallets` VALUES ('226', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'gold', 'in', '18', '4000');
INSERT INTO `wallets` VALUES ('227', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'pear', 'in', '18', '12000');
INSERT INTO `wallets` VALUES ('228', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'pear', 'in', '18', '8000');
INSERT INTO `wallets` VALUES ('229', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'emerald', 'in', '18', '30000');
INSERT INTO `wallets` VALUES ('230', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'emerald', 'in', '18', '20000');
INSERT INTO `wallets` VALUES ('231', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'diamond', 'in', '18', '60000');
INSERT INTO `wallets` VALUES ('232', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'diamond', 'in', '18', '40000');
INSERT INTO `wallets` VALUES ('233', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'silver', 'in', '15', '3000');
INSERT INTO `wallets` VALUES ('234', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'silver', 'in', '15', '2000');
INSERT INTO `wallets` VALUES ('235', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'gold', 'in', '15', '6000');
INSERT INTO `wallets` VALUES ('236', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'gold', 'in', '15', '4000');
INSERT INTO `wallets` VALUES ('237', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'pear', 'in', '15', '12000');
INSERT INTO `wallets` VALUES ('238', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'pear', 'in', '15', '8000');
INSERT INTO `wallets` VALUES ('239', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'emerald', 'in', '15', '30000');
INSERT INTO `wallets` VALUES ('240', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'emerald', 'in', '15', '20000');
INSERT INTO `wallets` VALUES ('241', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'diamond', 'in', '15', '60000');
INSERT INTO `wallets` VALUES ('242', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'diamond', 'in', '15', '40000');
INSERT INTO `wallets` VALUES ('243', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'silver', 'in', '7', '3000');
INSERT INTO `wallets` VALUES ('244', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'silver', 'in', '7', '2000');
INSERT INTO `wallets` VALUES ('245', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'gold', 'in', '7', '6000');
INSERT INTO `wallets` VALUES ('246', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'gold', 'in', '7', '4000');
INSERT INTO `wallets` VALUES ('247', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'pear', 'in', '7', '12000');
INSERT INTO `wallets` VALUES ('248', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'pear', 'in', '7', '8000');
INSERT INTO `wallets` VALUES ('249', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'emerald', 'in', '7', '30000');
INSERT INTO `wallets` VALUES ('250', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'emerald', 'in', '7', '20000');
INSERT INTO `wallets` VALUES ('251', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'diamond', 'in', '7', '60000');
INSERT INTO `wallets` VALUES ('252', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'diamond', 'in', '7', '40000');
INSERT INTO `wallets` VALUES ('253', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('254', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('255', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('256', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('257', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('258', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('259', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('260', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('261', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('262', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('263', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('264', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('265', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('266', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('267', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('268', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('269', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('270', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('271', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('272', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('273', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('274', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('275', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('276', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('277', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('278', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('279', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('280', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('281', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('282', null, '2017-09-22 17:54:59', '2017-09-22 17:54:59', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('283', null, '2017-09-22 17:58:56', '2017-09-22 17:58:56', '1', '1', 'member24 Register Package', 'in', '4', '60');
INSERT INTO `wallets` VALUES ('284', null, '2017-09-22 17:58:56', '2017-09-22 17:58:56', '4', '1', 'member24 Register Package', 'in', '4', '40');
INSERT INTO `wallets` VALUES ('285', null, '2017-09-22 17:58:57', '2017-09-22 17:58:57', '1', '1', 'member24 Register Package', 'in', '2', '12');
INSERT INTO `wallets` VALUES ('286', null, '2017-09-22 17:58:57', '2017-09-22 17:58:57', '4', '1', 'member24 Register Package', 'in', '2', '8');
INSERT INTO `wallets` VALUES ('287', null, '2017-09-22 17:59:24', '2017-09-22 17:59:24', '1', '1', 'member25 Register Package', 'in', '4', '30');
INSERT INTO `wallets` VALUES ('288', null, '2017-09-22 17:59:24', '2017-09-22 17:59:24', '4', '1', 'member25 Register Package', 'in', '4', '20');
INSERT INTO `wallets` VALUES ('289', null, '2017-09-22 17:59:24', '2017-09-22 17:59:24', '1', '1', 'member25 Register Package', 'in', '2', '6');
INSERT INTO `wallets` VALUES ('290', null, '2017-09-22 17:59:24', '2017-09-22 17:59:24', '4', '1', 'member25 Register Package', 'in', '2', '4');
INSERT INTO `wallets` VALUES ('291', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '9', '3000');
INSERT INTO `wallets` VALUES ('292', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '9', '2000');
INSERT INTO `wallets` VALUES ('293', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '9', '6000');
INSERT INTO `wallets` VALUES ('294', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '9', '4000');
INSERT INTO `wallets` VALUES ('295', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '9', '12000');
INSERT INTO `wallets` VALUES ('296', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '9', '8000');
INSERT INTO `wallets` VALUES ('297', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '9', '30000');
INSERT INTO `wallets` VALUES ('298', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '9', '20000');
INSERT INTO `wallets` VALUES ('299', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '9', '60000');
INSERT INTO `wallets` VALUES ('300', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '9', '40000');
INSERT INTO `wallets` VALUES ('301', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '18', '3000');
INSERT INTO `wallets` VALUES ('302', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '18', '2000');
INSERT INTO `wallets` VALUES ('303', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '18', '6000');
INSERT INTO `wallets` VALUES ('304', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '18', '4000');
INSERT INTO `wallets` VALUES ('305', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '18', '12000');
INSERT INTO `wallets` VALUES ('306', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '18', '8000');
INSERT INTO `wallets` VALUES ('307', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '18', '30000');
INSERT INTO `wallets` VALUES ('308', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '18', '20000');
INSERT INTO `wallets` VALUES ('309', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '18', '60000');
INSERT INTO `wallets` VALUES ('310', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '18', '40000');
INSERT INTO `wallets` VALUES ('311', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '15', '3000');
INSERT INTO `wallets` VALUES ('312', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '15', '2000');
INSERT INTO `wallets` VALUES ('313', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '15', '6000');
INSERT INTO `wallets` VALUES ('314', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '15', '4000');
INSERT INTO `wallets` VALUES ('315', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '15', '12000');
INSERT INTO `wallets` VALUES ('316', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '15', '8000');
INSERT INTO `wallets` VALUES ('317', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '15', '30000');
INSERT INTO `wallets` VALUES ('318', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '15', '20000');
INSERT INTO `wallets` VALUES ('319', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '15', '60000');
INSERT INTO `wallets` VALUES ('320', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '15', '40000');
INSERT INTO `wallets` VALUES ('321', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '7', '3000');
INSERT INTO `wallets` VALUES ('322', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '7', '2000');
INSERT INTO `wallets` VALUES ('323', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '7', '6000');
INSERT INTO `wallets` VALUES ('324', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '7', '4000');
INSERT INTO `wallets` VALUES ('325', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '7', '12000');
INSERT INTO `wallets` VALUES ('326', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '7', '8000');
INSERT INTO `wallets` VALUES ('327', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '7', '30000');
INSERT INTO `wallets` VALUES ('328', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '7', '20000');
INSERT INTO `wallets` VALUES ('329', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '7', '60000');
INSERT INTO `wallets` VALUES ('330', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '7', '40000');
INSERT INTO `wallets` VALUES ('331', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('332', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('333', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('334', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('335', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('336', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('337', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('338', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('339', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('340', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('341', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('342', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('343', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('344', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('345', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('346', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('347', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('348', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('349', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('350', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('351', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('352', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('353', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('354', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('355', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('356', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('357', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('358', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('359', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('360', null, '2017-09-22 18:03:44', '2017-09-22 18:03:44', '4', '4', 'diamond', 'in', '2', '40000');
INSERT INTO `wallets` VALUES ('361', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'silver', 'in', '8', '3000');
INSERT INTO `wallets` VALUES ('362', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'silver', 'in', '8', '2000');
INSERT INTO `wallets` VALUES ('363', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'gold', 'in', '8', '6000');
INSERT INTO `wallets` VALUES ('364', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'gold', 'in', '8', '4000');
INSERT INTO `wallets` VALUES ('365', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'pear', 'in', '8', '12000');
INSERT INTO `wallets` VALUES ('366', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'pear', 'in', '8', '8000');
INSERT INTO `wallets` VALUES ('367', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'emerald', 'in', '8', '30000');
INSERT INTO `wallets` VALUES ('368', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'emerald', 'in', '8', '20000');
INSERT INTO `wallets` VALUES ('369', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'diamond', 'in', '8', '60000');
INSERT INTO `wallets` VALUES ('370', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'diamond', 'in', '8', '40000');
INSERT INTO `wallets` VALUES ('371', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'silver', 'in', '6', '3000');
INSERT INTO `wallets` VALUES ('372', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'silver', 'in', '6', '2000');
INSERT INTO `wallets` VALUES ('373', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'gold', 'in', '6', '6000');
INSERT INTO `wallets` VALUES ('374', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'gold', 'in', '6', '4000');
INSERT INTO `wallets` VALUES ('375', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'pear', 'in', '6', '12000');
INSERT INTO `wallets` VALUES ('376', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'pear', 'in', '6', '8000');
INSERT INTO `wallets` VALUES ('377', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'emerald', 'in', '6', '30000');
INSERT INTO `wallets` VALUES ('378', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'emerald', 'in', '6', '20000');
INSERT INTO `wallets` VALUES ('379', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'diamond', 'in', '6', '60000');
INSERT INTO `wallets` VALUES ('380', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'diamond', 'in', '6', '40000');
INSERT INTO `wallets` VALUES ('381', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'silver', 'in', '5', '3000');
INSERT INTO `wallets` VALUES ('382', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'silver', 'in', '5', '2000');
INSERT INTO `wallets` VALUES ('383', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'gold', 'in', '5', '6000');
INSERT INTO `wallets` VALUES ('384', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'gold', 'in', '5', '4000');
INSERT INTO `wallets` VALUES ('385', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'pear', 'in', '5', '12000');
INSERT INTO `wallets` VALUES ('386', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'pear', 'in', '5', '8000');
INSERT INTO `wallets` VALUES ('387', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'emerald', 'in', '5', '30000');
INSERT INTO `wallets` VALUES ('388', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'emerald', 'in', '5', '20000');
INSERT INTO `wallets` VALUES ('389', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'diamond', 'in', '5', '60000');
INSERT INTO `wallets` VALUES ('390', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'diamond', 'in', '5', '40000');
INSERT INTO `wallets` VALUES ('391', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'silver', 'in', '4', '3000');
INSERT INTO `wallets` VALUES ('392', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'silver', 'in', '4', '2000');
INSERT INTO `wallets` VALUES ('393', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'gold', 'in', '4', '6000');
INSERT INTO `wallets` VALUES ('394', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'gold', 'in', '4', '4000');
INSERT INTO `wallets` VALUES ('395', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'pear', 'in', '4', '12000');
INSERT INTO `wallets` VALUES ('396', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'pear', 'in', '4', '8000');
INSERT INTO `wallets` VALUES ('397', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'emerald', 'in', '4', '30000');
INSERT INTO `wallets` VALUES ('398', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'emerald', 'in', '4', '20000');
INSERT INTO `wallets` VALUES ('399', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'diamond', 'in', '4', '60000');
INSERT INTO `wallets` VALUES ('400', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'diamond', 'in', '4', '40000');
INSERT INTO `wallets` VALUES ('401', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'silver', 'in', '2', '3000');
INSERT INTO `wallets` VALUES ('402', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'silver', 'in', '2', '2000');
INSERT INTO `wallets` VALUES ('403', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'gold', 'in', '2', '6000');
INSERT INTO `wallets` VALUES ('404', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'gold', 'in', '2', '4000');
INSERT INTO `wallets` VALUES ('405', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'pear', 'in', '2', '12000');
INSERT INTO `wallets` VALUES ('406', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'pear', 'in', '2', '8000');
INSERT INTO `wallets` VALUES ('407', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'emerald', 'in', '2', '30000');
INSERT INTO `wallets` VALUES ('408', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'emerald', 'in', '2', '20000');
INSERT INTO `wallets` VALUES ('409', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '1', '4', 'diamond', 'in', '2', '60000');
INSERT INTO `wallets` VALUES ('410', null, '2017-09-22 18:03:49', '2017-09-22 18:03:49', '4', '4', 'diamond', 'in', '2', '40000');

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
