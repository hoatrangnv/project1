/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : acl4

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-22 17:45:02
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of bonus_binary
-- ----------------------------
INSERT INTO `bonus_binary` VALUES ('1', '2017-09-22 17:44:07', '2017-09-22 17:44:11', '2', '38', '2017', '100', '500', '0', '0', '100', null, '0', '201738');
INSERT INTO `bonus_binary` VALUES ('2', '2017-09-22 17:44:34', '2017-09-22 17:44:37', '5', '38', '2017', '2000', '5000', '0', '0', '2000', null, '0', '201738');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$Iq70C4JgBBqhiuXBsb0RfOmBwalioGDjHMFs7JYcNsuxSPcnkzpn.', 'SISbq2Ljbrr8WDSlpYEMOvziaTFhJ6NvcjcqmR8wxqnQ4EFBu4jZ2yAbCUr9', '2017-08-12 05:47:39', '2017-09-15 08:22:03', '1', 'Nguyen', 'Hong', '012312423asdasd', '0', null, 'RE7S5LKYXTPCOMXF', '1', '2N8RNXCGHTWkdimArM27XW9EzUAmri5uVe1', 'Profile', null, null, null, '', null, null, null);
INSERT INTO `users` VALUES ('2', 'root', 'root@gmail.com', '$2y$10$bvHYiVB0zslAXAKnm/s9f.bpR9yb0.Wghs6d/ODVoDWL9TkTuxM4m', null, '2017-09-22 16:17:18', '2017-09-22 16:17:18', '0', 'root', 'Do', '0978788999', '0', '1', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('3', 'member1', 'member1@gmail.com', '$2y$10$rUAgleT3Ty/OYWJuS6DpQuEewCjPBg0duWxo4kGe17YZcmoX3Bc1S', 'qDsLXLmsfZtgZkEyQVOlcXQlw0htMNFgo7a2O0iBuh2tgfoinwMdYnBHH4oa', '2017-09-22 16:17:52', '2017-09-22 16:17:52', '0', 'member1', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('4', 'member2', 'member2@gmail.com', '$2y$10$pcnJOoocVDPqVFBBZSTbLuZVkQlYX1C1naf9IQ942lga9vFP9F1Q2', 'TUU1VVxiVXHhIA6bJBC0fdieZLeaVao4tmaGufU2z1H7UpBqxOqQ9XxDmPJS', '2017-09-22 16:18:09', '2017-09-22 16:18:09', '0', 'member2', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
INSERT INTO `users` VALUES ('5', 'member3', 'member3@gmail.com', '$2y$10$knE5WcDP.hvmgaPDFmCFaOHgSF.lFzvPXDZqgZLxpYFUXw737syZ.', 'PZb1H5L6wXmg2hac20D7zPnpBLnoChwn9g0DGkldh8POxmPWCOltHkxmEM2X', '2017-09-22 16:18:20', '2017-09-22 16:18:20', '0', 'member3', 'Do', '0978788999', '0', '2', 'test', '1', null, null, null, null, null, '704', null, null, null);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users_loyalty
-- ----------------------------
INSERT INTO `users_loyalty` VALUES ('1', '2', '0', '0', '0', '0', '0', '100', '11500', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('2', '3', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('3', '4', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('4', '5', '0', '0', '0', '0', '0', '2000', '5000', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('5', '7', '0', '0', '0', '0', '0', '0', '0', '0', null, null);
INSERT INTO `users_loyalty` VALUES ('6', '6', '0', '0', '0', '0', '0', '0', '0', '0', null, null);

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
INSERT INTO `user_coins` VALUES ('1', '1GGmXKpWxhnewFshqw7fKKdnMEAf7wjzSy', 'c9750047-5a1e-57aa-95ca-f72a7bd721cc', '0.6', '500', '439.2', '292.8', null);
INSERT INTO `user_coins` VALUES ('2', 'test', 'test', '0', '15535.714285714286', '780', '520', null);
INSERT INTO `user_coins` VALUES ('3', 'test', 'test', '0', '19910.714285714286', '0', '0', null);
INSERT INTO `user_coins` VALUES ('4', 'test', 'test', '0', '19553.571428571428', '0', '0', null);
INSERT INTO `user_coins` VALUES ('5', 'test', 'test', '0', '19107.14285714286', '420', '280', null);
INSERT INTO `user_coins` VALUES ('6', 'test', 'test', '0', '18214.285714285714', '0', '0', null);
INSERT INTO `user_coins` VALUES ('7', 'test', 'test', '0', '15535.714285714286', '0', '0', null);
INSERT INTO `user_coins` VALUES ('8', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('9', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('10', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('11', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('12', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('13', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('14', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('15', 'test', 'test', '0', '11071.428571428572', '0', '0', null);
INSERT INTO `user_coins` VALUES ('16', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('17', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('18', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('19', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('20', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('21', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('22', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('23', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('24', 'test', 'test', '0', '20000', '0', '0', null);
INSERT INTO `user_coins` VALUES ('25', 'test', 'test', '0', '20000', '0', '0', null);

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
INSERT INTO `user_datas` VALUES ('1', '0', '3', '2017-09-22 17:42:01', '\"1DUUCG9FtRgm9dkJi2YVnbxSz4ZoLL5sBD\"', '0af3e334-9dac-5b20-beab-9c45c79a9611', '1466', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('2', '1', '5', '2017-09-22 17:44:11', 'test', 'test', '1300', '0', null, '100', '500', '0', '3', '4', '1', '1', '2', '0', '1');
INSERT INTO `user_datas` VALUES ('3', '2', '1', '2017-09-22 17:44:07', 'test', 'test', '0', '1', 'left', '0', '0', '2', '3', '3', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('4', '2', '2', '2017-09-22 17:44:11', 'test', 'test', '0', '1', 'right', '0', '0', '2', '4', '4', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('5', '2', '3', '2017-09-22 17:44:37', 'test', 'test', '700', '0', '', '2000', '5000', '0', '6', '7', '1', '1', '2', '0', '1');
INSERT INTO `user_datas` VALUES ('6', '5', '4', '2017-09-22 17:44:37', 'test', 'test', '0', '1', 'left', '0', '0', '5', '6', '6', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('7', '5', '5', '2017-09-22 17:44:34', 'test', 'test', '0', '1', 'right', '0', '0', '5', '7', '7', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('8', '6', '0', '2017-09-22 17:38:17', 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('9', '7', '0', '2017-09-22 17:38:23', 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('10', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('11', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('12', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('13', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('14', '11', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('15', '2', '6', '2017-09-22 17:42:01', 'test', 'test', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1');
INSERT INTO `user_datas` VALUES ('16', '9', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('17', '12', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('18', '2', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('19', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('20', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('21', '20', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('22', '20', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('23', '21', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('24', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('25', '5', '0', null, 'test', 'test', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
