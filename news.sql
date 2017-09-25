/*
Navicat MySQL Data Transfer

Source Server         : lms_dev
Source Server Version : 50505
Source Host           : 42.112.28.129:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-09-25 16:55:49
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('1', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('3', '2017_02_20_233057_create_permission_tables', '1');
INSERT INTO `migrations` VALUES ('4', '2017_02_22_171712_create_posts_table', '1');
INSERT INTO `migrations` VALUES ('5', '2017_04_30_012311_create_posts_table', '2');
INSERT INTO `migrations` VALUES ('6', '2017_09_22_112329_create_news_table', '3');

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
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------
INSERT INTO `model_has_permissions` VALUES ('1', '3', 'App\\User');
INSERT INTO `model_has_permissions` VALUES ('2', '3', 'App\\User');
INSERT INTO `model_has_permissions` VALUES ('3', '3', 'App\\User');

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
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------
INSERT INTO `model_has_roles` VALUES ('4', '2', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('2', '3', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '13', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '14', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('4', '15', 'App\\User');
INSERT INTO `model_has_roles` VALUES ('1', '45', 'App\\User');

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO `news` VALUES ('7', 'Ahihihihihihihih', '3', null, 'Bitcoin&nbsp;(k&yacute; hiệu:&nbsp;BTC, XBT,&nbsp;) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, …', '<p><strong>Bitcoin</strong>&nbsp;(k&yacute; hiệu:&nbsp;<strong>BTC, XBT,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%E1%BA%ADp_tin:BitcoinSign.svg\"><img alt=\"BitcoinSign.svg\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/BitcoinSign.svg/9px-BitcoinSign.svg.png\" style=\"height:12px; width:9px\" /></a></strong>) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, được ph&aacute;t h&agrave;nh bởi&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Satoshi_Nakamoto\">Satoshi Nakamoto</a>&nbsp;dưới dạng phần mềm&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ph%E1%BA%A7n_m%E1%BB%81m_ngu%E1%BB%93n_m%E1%BB%9F\">m&atilde; nguồn mở</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-9\">[9]</a>&nbsp;từ năm 2009<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-whitepaper-2\">[2]</a>. Bitcoin c&oacute; thể được trao đổi trực tiếp bằng thiết bị kết nối Internet m&agrave; kh&ocirc;ng cần th&ocirc;ng qua một&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%E1%BB%95_ch%E1%BB%A9c_t%C3%A0i_ch%C3%ADnh\">tổ chức t&agrave;i ch&iacute;nh</a>&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Trung_gian_t%C3%A0i_ch%C3%ADnh\">trung gian</a>&nbsp;n&agrave;o<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-10\">[10]</a>.</p>\r\n\r\n<p>Bitcoin c&oacute; c&aacute;ch hoạt động kh&aacute;c hẳn so với c&aacute;c loại tiền tệ điển h&igrave;nh: Kh&ocirc;ng c&oacute; một&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ng%C3%A2n_h%C3%A0ng_trung_%C6%B0%C6%A1ng\">ng&acirc;n h&agrave;ng trung ương</a>&nbsp;n&agrave;o quản l&yacute; n&oacute; v&agrave; hệ thống hoạt động dựa tr&ecirc;n một giao thức&nbsp;<a href=\"https://vi.wikipedia.org/wiki/M%E1%BA%A1ng_ngang_h%C3%A0ng\">mạng ngang h&agrave;ng</a>&nbsp;tr&ecirc;n Internet<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-Arbitrage-11\">[11]</a>. Sự cung ứng Bitcoin l&agrave; tự động, hạn chế, được ph&acirc;n chia theo lịch tr&igrave;nh định sẵn dựa tr&ecirc;n c&aacute;c&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Thu%E1%BA%ADt_to%C3%A1n\">thuật to&aacute;n</a>. Bitcoin được cấp tới c&aacute;c m&aacute;y t&iacute;nh &quot;đ&agrave;o&quot; Bitcoin để trả c&ocirc;ng cho việc x&aacute;c minh giao dịch Bitcoin v&agrave; ghi ch&uacute;ng v&agrave;o cuốn sổ c&aacute;i được ph&acirc;n t&aacute;n trong mạng ngang h&agrave;ng - được gọi l&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Blockchain\">blockchain</a>. Cuốn&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=S%E1%BB%95_c%C3%A1i&amp;action=edit&amp;redlink=1\">sổ c&aacute;i</a>&nbsp;n&agrave;y sử dụng Bitcoin l&agrave; đơn vị kế to&aacute;n. Mỗi bitcoin c&oacute; thể được chia nhỏ tới 100 triệu đơn vị nhỏ hơn gọi l&agrave; satoshi<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-satoshi_unit-5\">[5]</a>.</p>\r\n\r\n<p><a href=\"https://vi.wikipedia.org/w/index.php?title=Ph%C3%AD_giao_d%E1%BB%8Bch&amp;action=edit&amp;redlink=1\">Ph&iacute; giao dịch</a>&nbsp;c&oacute; thể &aacute;p dụng cho giao dịch mới t&ugrave;y thuộc v&agrave;o nguồn t&agrave;i nguy&ecirc;n của mạng. Ngo&agrave;i ph&iacute; giao dịch, c&aacute;c thợ đ&agrave;o c&ograve;n được trả c&ocirc;ng cho việc m&atilde; ho&aacute; c&aacute;c khối (block) nhật k&yacute; giao dịch. Cứ mỗi 10 ph&uacute;t, một khối mới được tạo ra k&egrave;m theo một lượng Bitcoin được cấp ph&aacute;t. Số bitcoin được cấp cho mỗi khối phụ thuộc v&agrave;o thời gian hoạt động của mạng lưới. V&agrave;o th&aacute;ng 7 năm 2016, 12,5 bitcoin được cấp ph&aacute;t cho mỗi khối mới. Tốc độ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%E1%BA%A1m_ph%C3%A1t\">lạm ph&aacute;t</a>&nbsp;sẽ giảm một nửa c&ograve;n 6,25 bitcoin v&agrave;o th&aacute;ng 7 năm 2020 v&agrave; tiếp tục giảm một nửa sau mỗi chu kỳ 4 năm cho tới khi c&oacute; tổng cộng 21 triệu Bitcoin được ph&aacute;t h&agrave;nh v&agrave;o năm&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=2140&amp;action=edit&amp;redlink=1\">2140</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-whitepaper-2\">[2]</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-Wired:RFB-12\">[12]</a>. Ngo&agrave;i việc đ&agrave;o Bitcoin, người d&ugrave;ng c&oacute; thể c&oacute; Bitcoin bằng c&aacute;ch trao đổi lấy Bitcoin khi b&aacute;n tiền tệ, h&agrave;ng ho&aacute;, hoặc dịch vụ kh&aacute;c.</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('8', '123123', '1', null, '', null, null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('9', '123123', '1', null, '', null, null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('10', '123123', '1', null, '', null, null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('11', '1', '1', null, '', null, null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('12', 'huydk 1', '1', null, '132123123', '<p>132123123</p>', null, '52', '0', null, null, '2017-09-23 10:49:19', null);
INSERT INTO `news` VALUES ('13', '123', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('14', '1', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('15', '1', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('16', '1', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('17', '123123', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('18', '1231', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('19', '1231', '1', null, '123', '<p>123</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('20', '<script>alert(\"123\")</script>', '1', null, 'Bitcoin&nbsp;(k&yacute; hiệu:&nbsp;BTC, XBT,&nbsp;) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, …', null, null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('21', '<script>alert(\"123\");</script>', '1', null, 'Bitcoin&nbsp;(k&yacute; hiệu:&nbsp;BTC, XBT,&nbsp;) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, …', null, null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('22', 'Bitcoin la gi ??', '2', null, 'Bitcoin&nbsp;(k&yacute; hiệu:&nbsp;BTC, XBT,&nbsp;) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, …', '<p><strong>Bitcoin</strong>&nbsp;(k&yacute; hiệu:&nbsp;<strong>BTC, XBT,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%E1%BA%ADp_tin:BitcoinSign.svg\"><img alt=\"BitcoinSign.svg\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/BitcoinSign.svg/9px-BitcoinSign.svg.png\" style=\"height:12px; width:9px\" /></a></strong>) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, được ph&aacute;t h&agrave;nh bởi&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Satoshi_Nakamoto\">Satoshi Nakamoto</a>&nbsp;dưới dạng phần mềm&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ph%E1%BA%A7n_m%E1%BB%81m_ngu%E1%BB%93n_m%E1%BB%9F\">m&atilde; nguồn mở</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-9\">[9]</a>&nbsp;từ năm 2009<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-whitepaper-2\">[2]</a>. Bitcoin c&oacute; thể được trao đổi trực tiếp bằng thiết bị kết nối Internet m&agrave; kh&ocirc;ng cần th&ocirc;ng qua một&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%E1%BB%95_ch%E1%BB%A9c_t%C3%A0i_ch%C3%ADnh\">tổ chức t&agrave;i ch&iacute;nh</a>&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Trung_gian_t%C3%A0i_ch%C3%ADnh\">trung gian</a>&nbsp;n&agrave;o<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-10\">[10]</a>.</p>\r\n\r\n<p>Bitcoin c&oacute; c&aacute;ch hoạt động kh&aacute;c hẳn so với c&aacute;c loại tiền tệ điển h&igrave;nh: Kh&ocirc;ng c&oacute; một&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ng%C3%A2n_h%C3%A0ng_trung_%C6%B0%C6%A1ng\">ng&acirc;n h&agrave;ng trung ương</a>&nbsp;n&agrave;o quản l&yacute; n&oacute; v&agrave; hệ thống hoạt động dựa tr&ecirc;n một giao thức&nbsp;<a href=\"https://vi.wikipedia.org/wiki/M%E1%BA%A1ng_ngang_h%C3%A0ng\">mạng ngang h&agrave;ng</a>&nbsp;tr&ecirc;n Internet<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-Arbitrage-11\">[11]</a>. Sự cung ứng Bitcoin l&agrave; tự động, hạn chế, được ph&acirc;n chia theo lịch tr&igrave;nh định sẵn dựa tr&ecirc;n c&aacute;c&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Thu%E1%BA%ADt_to%C3%A1n\">thuật to&aacute;n</a>. Bitcoin được cấp tới c&aacute;c m&aacute;y t&iacute;nh &quot;đ&agrave;o&quot; Bitcoin để trả c&ocirc;ng cho việc x&aacute;c minh giao dịch Bitcoin v&agrave; ghi ch&uacute;ng v&agrave;o cuốn sổ c&aacute;i được ph&acirc;n t&aacute;n trong mạng ngang h&agrave;ng - được gọi l&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Blockchain\">blockchain</a>. Cuốn&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=S%E1%BB%95_c%C3%A1i&amp;action=edit&amp;redlink=1\">sổ c&aacute;i</a>&nbsp;n&agrave;y sử dụng Bitcoin l&agrave; đơn vị kế to&aacute;n. Mỗi bitcoin c&oacute; thể được chia nhỏ tới 100 triệu đơn vị nhỏ hơn gọi l&agrave; satoshi<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-satoshi_unit-5\">[5]</a>.</p>\r\n\r\n<p><a href=\"https://vi.wikipedia.org/w/index.php?title=Ph%C3%AD_giao_d%E1%BB%8Bch&amp;action=edit&amp;redlink=1\">Ph&iacute; giao dịch</a>&nbsp;c&oacute; thể &aacute;p dụng cho giao dịch mới t&ugrave;y thuộc v&agrave;o nguồn t&agrave;i nguy&ecirc;n của mạng. Ngo&agrave;i ph&iacute; giao dịch, c&aacute;c thợ đ&agrave;o c&ograve;n được trả c&ocirc;ng cho việc m&atilde; ho&aacute; c&aacute;c khối (block) nhật k&yacute; giao dịch. Cứ mỗi 10 ph&uacute;t, một khối mới được tạo ra k&egrave;m theo một lượng Bitcoin được cấp ph&aacute;t. Số bitcoin được cấp cho mỗi khối phụ thuộc v&agrave;o thời gian hoạt động của mạng lưới. V&agrave;o th&aacute;ng 7 năm 2016, 12,5 bitcoin được cấp ph&aacute;t cho mỗi khối mới. Tốc độ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%E1%BA%A1m_ph%C3%A1t\">lạm ph&aacute;t</a>&nbsp;sẽ giảm một nửa c&ograve;n 6,25 bitcoin v&agrave;o th&aacute;ng 7 năm 2020 v&agrave; tiếp tục giảm một nửa sau mỗi chu kỳ 4 năm cho tới khi c&oacute; tổng cộng 21 triệu Bitcoin được ph&aacute;t h&agrave;nh v&agrave;o năm&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=2140&amp;action=edit&amp;redlink=1\">2140</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-whitepaper-2\">[2]</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-Wired:RFB-12\">[12]</a>. Ngo&agrave;i việc đ&agrave;o Bitcoin, người d&ugrave;ng c&oacute; thể c&oacute; Bitcoin bằng c&aacute;ch trao đổi lấy Bitcoin khi b&aacute;n tiền tệ, h&agrave;ng ho&aacute;, hoặc dịch vụ kh&aacute;c.</p>', null, '51', '0', null, null, null, null);
INSERT INTO `news` VALUES ('23', 'Bitcoin la gi ??', '2', null, 'Bitcoin&nbsp;(k&yacute; hiệu:&nbsp;BTC, XBT,&nbsp;) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, …', '<p><strong>Bitcoin</strong>&nbsp;(k&yacute; hiệu:&nbsp;<strong>BTC, XBT,&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%E1%BA%ADp_tin:BitcoinSign.svg\"><img alt=\"BitcoinSign.svg\" src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/b/ba/BitcoinSign.svg/9px-BitcoinSign.svg.png\" style=\"height:12px; width:9px\" /></a></strong>) l&agrave; một loại tiền tệ kỹ thuật số ph&acirc;n cấp, được ph&aacute;t h&agrave;nh bởi&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Satoshi_Nakamoto\">Satoshi Nakamoto</a>&nbsp;dưới dạng phần mềm&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ph%E1%BA%A7n_m%E1%BB%81m_ngu%E1%BB%93n_m%E1%BB%9F\">m&atilde; nguồn mở</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-9\">[9]</a>&nbsp;từ năm 2009<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-whitepaper-2\">[2]</a>. Bitcoin c&oacute; thể được trao đổi trực tiếp bằng thiết bị kết nối Internet m&agrave; kh&ocirc;ng cần th&ocirc;ng qua một&nbsp;<a href=\"https://vi.wikipedia.org/wiki/T%E1%BB%95_ch%E1%BB%A9c_t%C3%A0i_ch%C3%ADnh\">tổ chức t&agrave;i ch&iacute;nh</a>&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Trung_gian_t%C3%A0i_ch%C3%ADnh\">trung gian</a>&nbsp;n&agrave;o<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-10\">[10]</a>.</p>\r\n\r\n<p>Bitcoin c&oacute; c&aacute;ch hoạt động kh&aacute;c hẳn so với c&aacute;c loại tiền tệ điển h&igrave;nh: Kh&ocirc;ng c&oacute; một&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Ng%C3%A2n_h%C3%A0ng_trung_%C6%B0%C6%A1ng\">ng&acirc;n h&agrave;ng trung ương</a>&nbsp;n&agrave;o quản l&yacute; n&oacute; v&agrave; hệ thống hoạt động dựa tr&ecirc;n một giao thức&nbsp;<a href=\"https://vi.wikipedia.org/wiki/M%E1%BA%A1ng_ngang_h%C3%A0ng\">mạng ngang h&agrave;ng</a>&nbsp;tr&ecirc;n Internet<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-Arbitrage-11\">[11]</a>. Sự cung ứng Bitcoin l&agrave; tự động, hạn chế, được ph&acirc;n chia theo lịch tr&igrave;nh định sẵn dựa tr&ecirc;n c&aacute;c&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Thu%E1%BA%ADt_to%C3%A1n\">thuật to&aacute;n</a>. Bitcoin được cấp tới c&aacute;c m&aacute;y t&iacute;nh &quot;đ&agrave;o&quot; Bitcoin để trả c&ocirc;ng cho việc x&aacute;c minh giao dịch Bitcoin v&agrave; ghi ch&uacute;ng v&agrave;o cuốn sổ c&aacute;i được ph&acirc;n t&aacute;n trong mạng ngang h&agrave;ng - được gọi l&agrave;&nbsp;<a href=\"https://vi.wikipedia.org/wiki/Blockchain\">blockchain</a>. Cuốn&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=S%E1%BB%95_c%C3%A1i&amp;action=edit&amp;redlink=1\">sổ c&aacute;i</a>&nbsp;n&agrave;y sử dụng Bitcoin l&agrave; đơn vị kế to&aacute;n. Mỗi bitcoin c&oacute; thể được chia nhỏ tới 100 triệu đơn vị nhỏ hơn gọi l&agrave; satoshi<a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-satoshi_unit-5\">[5]</a>.</p>\r\n\r\n<p><a href=\"https://vi.wikipedia.org/w/index.php?title=Ph%C3%AD_giao_d%E1%BB%8Bch&amp;action=edit&amp;redlink=1\">Ph&iacute; giao dịch</a>&nbsp;c&oacute; thể &aacute;p dụng cho giao dịch mới t&ugrave;y thuộc v&agrave;o nguồn t&agrave;i nguy&ecirc;n của mạng. Ngo&agrave;i ph&iacute; giao dịch, c&aacute;c thợ đ&agrave;o c&ograve;n được trả c&ocirc;ng cho việc m&atilde; ho&aacute; c&aacute;c khối (block) nhật k&yacute; giao dịch. Cứ mỗi 10 ph&uacute;t, một khối mới được tạo ra k&egrave;m theo một lượng Bitcoin được cấp ph&aacute;t. Số bitcoin được cấp cho mỗi khối phụ thuộc v&agrave;o thời gian hoạt động của mạng lưới. V&agrave;o th&aacute;ng 7 năm 2016, 12,5 bitcoin được cấp ph&aacute;t cho mỗi khối mới. Tốc độ&nbsp;<a href=\"https://vi.wikipedia.org/wiki/L%E1%BA%A1m_ph%C3%A1t\">lạm ph&aacute;t</a>&nbsp;sẽ giảm một nửa c&ograve;n 6,25 bitcoin v&agrave;o th&aacute;ng 7 năm 2020 v&agrave; tiếp tục giảm một nửa sau mỗi chu kỳ 4 năm cho tới khi c&oacute; tổng cộng 21 triệu Bitcoin được ph&aacute;t h&agrave;nh v&agrave;o năm&nbsp;<a href=\"https://vi.wikipedia.org/w/index.php?title=2140&amp;action=edit&amp;redlink=1\">2140</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-whitepaper-2\">[2]</a><a href=\"https://vi.wikipedia.org/wiki/Bitcoin#cite_note-Wired:RFB-12\">[12]</a>. Ngo&agrave;i việc đ&agrave;o Bitcoin, người d&ugrave;ng c&oacute; thể c&oacute; Bitcoin bằng c&aacute;ch trao đổi lấy Bitcoin khi b&aacute;n tiền tệ, h&agrave;ng ho&aacute;, hoặc dịch vụ kh&aacute;c.</p>', null, '51', '0', null, null, null, null);

-- ----------------------------
-- Table structure for `notification`
-- ----------------------------
DROP TABLE IF EXISTS `notification`;
CREATE TABLE `notification` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `data` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=370 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notification
-- ----------------------------
INSERT INTO `notification` VALUES ('365', '{\"id\":\"f66cf9fd-8d28-5986-bebb-4e702d691e28\",\"type\":\"wallet:addresses:new-payment\",\"data\":{\"id\":\"a920b169-dd49-571c-9540-0bd7269a3d97\",\"address\":\"1GDbT8DXjsX9Kvi7gg1fMwQZ92BnSsM9KU\",\"name\":null,\"created_at\":\"2017-09-14T10:28:49Z\",\"updated_at\":\"2017-09-14T10:28:49Z\",\"network\":\"bitcoin\",\"resource\":\"address\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/addresses/a920b169-dd49-571c-9540-0bd7269a3d97\"},\"user\":{\"id\":\"1a38299f-14ae-5e73-aeed-13a7be1f01b9\",\"resource\":\"user\",\"resource_path\":\"/v2/users/1a38299f-14ae-5e73-aeed-13a7be1f01b9\"},\"account\":{\"id\":\"b08141b5-1d40-50e9-9af7-ea8f152d331a\",\"resource\":\"account\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a\"},\"delivery_attempts\":0,\"created_at\":\"2017-09-14T10:30:13Z\",\"resource\":\"notification\",\"resource_path\":\"/v2/notifications/f66cf9fd-8d28-5986-bebb-4e702d691e28\",\"additional_data\":{\"hash\":\"ff0920fd881a0f304dffa9d2c855a9605c4bab5387554f82f322335cdd6469a2\",\"amount\":{\"amount\":\"0.00200000\",\"currency\":\"BTC\"},\"transaction\":{\"id\":\"0616d599-ee98-5ab7-bbbd-ab249bc2aa03\",\"resource\":\"transaction\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/transactions/0616d599-ee98-5ab7-bbbd-ab249bc2aa03\"}}}', '1', '2017-09-20 14:41:16', '2017-09-20 14:41:16');
INSERT INTO `notification` VALUES ('366', '{\"id\":\"35707472-3d33-5241-8e9b-3ea38c4b4569\",\"type\":\"wallet:addresses:new-payment\",\"data\":{\"id\":\"176ddc4e-9de3-544d-9fa8-8f4987d5c232\",\"address\":\"1MUyEYDrdY6cLeAZBthtnZjPgWDSx4VoLf\",\"name\":null,\"created_at\":\"2017-09-15T04:05:51Z\",\"updated_at\":\"2017-09-15T04:05:51Z\",\"network\":\"bitcoin\",\"resource\":\"address\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/addresses/176ddc4e-9de3-544d-9fa8-8f4987d5c232\"},\"user\":{\"id\":\"1a38299f-14ae-5e73-aeed-13a7be1f01b9\",\"resource\":\"user\",\"resource_path\":\"/v2/users/1a38299f-14ae-5e73-aeed-13a7be1f01b9\"},\"account\":{\"id\":\"b08141b5-1d40-50e9-9af7-ea8f152d331a\",\"resource\":\"account\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a\"},\"delivery_attempts\":0,\"created_at\":\"2017-09-15T04:22:11Z\",\"resource\":\"notification\",\"resource_path\":\"/v2/notifications/35707472-3d33-5241-8e9b-3ea38c4b4569\",\"additional_data\":{\"hash\":\"1b23631457a6168023a0017a88b8eb8e2200f5e28b28f4b03ec141d5a652ae8b\",\"amount\":{\"amount\":\"0.00100000\",\"currency\":\"BTC\"},\"transaction\":{\"id\":\"02a28379-a7ef-5969-ac08-075eb7bcfadc\",\"resource\":\"transaction\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/transactions/02a28379-a7ef-5969-ac08-075eb7bcfadc\"}}}', '1', '2017-09-20 14:44:01', '2017-09-20 14:44:02');
INSERT INTO `notification` VALUES ('367', '{\"id\":\"fa8fa7aa-85f1-52c0-afc4-720add5e795d\",\"type\":\"wallet:addresses:new-payment\",\"data\":{\"id\":\"1f60c9bd-2428-5021-ae0e-a41ee8ec3008\",\"address\":\"1Km9YgKxmw19QuwuR78pRqBbhrbgTMVqxW\",\"name\":null,\"created_at\":\"2017-09-15T10:44:55Z\",\"updated_at\":\"2017-09-15T10:44:55Z\",\"network\":\"bitcoin\",\"resource\":\"address\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/addresses/1f60c9bd-2428-5021-ae0e-a41ee8ec3008\"},\"user\":{\"id\":\"1a38299f-14ae-5e73-aeed-13a7be1f01b9\",\"resource\":\"user\",\"resource_path\":\"/v2/users/1a38299f-14ae-5e73-aeed-13a7be1f01b9\"},\"account\":{\"id\":\"b08141b5-1d40-50e9-9af7-ea8f152d331a\",\"resource\":\"account\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a\"},\"delivery_attempts\":0,\"created_at\":\"2017-09-15T11:04:35Z\",\"resource\":\"notification\",\"resource_path\":\"/v2/notifications/fa8fa7aa-85f1-52c0-afc4-720add5e795d\",\"additional_data\":{\"hash\":\"fb0f3d079204faca12f4038a1b0e92ccd856880abe21c13c9689f7003bbd3a81\",\"amount\":{\"amount\":\"0.00110000\",\"currency\":\"BTC\"},\"transaction\":{\"id\":\"fba2b822-6fbc-581b-b0d0-144f019fdee8\",\"resource\":\"transaction\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/transactions/fba2b822-6fbc-581b-b0d0-144f019fdee8\"}}}', '1', '2017-09-20 14:43:31', '2017-09-20 14:43:31');
INSERT INTO `notification` VALUES ('368', '{\"id\":\"88ced5a8-beee-5331-8895-c97b1d898a20\",\"type\":\"wallet:addresses:new-payment\",\"data\":{\"id\":\"5f36ed57-17f2-573b-b984-1e76f38747d0\",\"address\":\"13xCcX9dfPWkc77E9fM1jTCSZw4HpX9oWD\",\"name\":null,\"created_at\":\"2017-09-19T02:40:33Z\",\"updated_at\":\"2017-09-19T02:40:33Z\",\"network\":\"bitcoin\",\"resource\":\"address\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/addresses/5f36ed57-17f2-573b-b984-1e76f38747d0\"},\"user\":{\"id\":\"1a38299f-14ae-5e73-aeed-13a7be1f01b9\",\"resource\":\"user\",\"resource_path\":\"/v2/users/1a38299f-14ae-5e73-aeed-13a7be1f01b9\"},\"account\":{\"id\":\"b08141b5-1d40-50e9-9af7-ea8f152d331a\",\"resource\":\"account\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a\"},\"delivery_attempts\":0,\"created_at\":\"2017-09-19T02:54:51Z\",\"resource\":\"notification\",\"resource_path\":\"/v2/notifications/88ced5a8-beee-5331-8895-c97b1d898a20\",\"additional_data\":{\"hash\":\"5ccedc301eb062b29e1d0a9d34b1f084c31e7d6aa7c12a6120f3c761589c8b53\",\"amount\":{\"amount\":\"0.00900000\",\"currency\":\"BTC\"},\"transaction\":{\"id\":\"d118b499-e8d5-5189-aba9-988dca48698e\",\"resource\":\"transaction\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/transactions/d118b499-e8d5-5189-aba9-988dca48698e\"}}}', '1', '2017-09-20 14:43:31', '2017-09-20 14:43:31');
INSERT INTO `notification` VALUES ('369', '{\"id\":\"a3c8d365-38b2-5ff4-b54b-434f38715004\",\"type\":\"wallet:addresses:new-payment\",\"data\":{\"id\":\"5f36ed57-17f2-573b-b984-1e76f38747d0\",\"address\":\"13xCcX9dfPWkc77E9fM1jTCSZw4HpX9oWD\",\"name\":null,\"created_at\":\"2017-09-19T02:40:33Z\",\"updated_at\":\"2017-09-19T02:40:33Z\",\"network\":\"bitcoin\",\"resource\":\"address\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/addresses/5f36ed57-17f2-573b-b984-1e76f38747d0\"},\"user\":{\"id\":\"1a38299f-14ae-5e73-aeed-13a7be1f01b9\",\"resource\":\"user\",\"resource_path\":\"/v2/users/1a38299f-14ae-5e73-aeed-13a7be1f01b9\"},\"account\":{\"id\":\"b08141b5-1d40-50e9-9af7-ea8f152d331a\",\"resource\":\"account\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a\"},\"delivery_attempts\":0,\"created_at\":\"2017-09-19T02:54:51Z\",\"resource\":\"notification\",\"resource_path\":\"/v2/notifications/a3c8d365-38b2-5ff4-b54b-434f38715004\",\"additional_data\":{\"hash\":\"5ccedc301eb062b29e1d0a9d34b1f084c31e7d6aa7c12a6120f3c761589c8b53\",\"amount\":{\"amount\":\"0.00900000\",\"currency\":\"BTC\"},\"transaction\":{\"id\":\"d118b499-e8d5-5189-aba9-988dca48698e\",\"resource\":\"transaction\",\"resource_path\":\"/v2/accounts/b08141b5-1d40-50e9-9af7-ea8f152d331a/transactions/d118b499-e8d5-5189-aba9-988dca48698e\"}}}', '1', '2017-09-20 14:44:01', '2017-09-20 14:44:02');

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
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `permissions` VALUES ('9', 'view_posts', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('10', 'add_posts', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('11', 'edit_posts', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('12', 'delete_posts', 'web', '2017-09-05 08:54:54', '2017-09-05 08:54:54');
INSERT INTO `permissions` VALUES ('13', 'view_articles', 'web', '2017-09-05 09:07:18', '2017-09-05 09:07:18');
INSERT INTO `permissions` VALUES ('14', 'add_articles', 'web', '2017-09-05 09:07:18', '2017-09-05 09:07:18');
INSERT INTO `permissions` VALUES ('15', 'edit_articles', 'web', '2017-09-05 09:07:18', '2017-09-05 09:07:18');
INSERT INTO `permissions` VALUES ('16', 'delete_articles', 'web', '2017-09-05 09:07:18', '2017-09-05 09:07:18');
INSERT INTO `permissions` VALUES ('17', 'view_categories', 'web', '2017-09-05 09:11:59', '2017-09-05 09:11:59');
INSERT INTO `permissions` VALUES ('18', 'add_categories', 'web', '2017-09-05 09:11:59', '2017-09-05 09:11:59');
INSERT INTO `permissions` VALUES ('19', 'edit_categories', 'web', '2017-09-05 09:11:59', '2017-09-05 09:11:59');
INSERT INTO `permissions` VALUES ('20', 'delete_categories', 'web', '2017-09-05 09:11:59', '2017-09-05 09:11:59');

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
INSERT INTO `role_has_permissions` VALUES ('1', '1');
INSERT INTO `role_has_permissions` VALUES ('1', '2');
INSERT INTO `role_has_permissions` VALUES ('1', '3');
INSERT INTO `role_has_permissions` VALUES ('1', '4');
INSERT INTO `role_has_permissions` VALUES ('2', '1');
INSERT INTO `role_has_permissions` VALUES ('2', '2');
INSERT INTO `role_has_permissions` VALUES ('3', '1');
INSERT INTO `role_has_permissions` VALUES ('3', '2');
INSERT INTO `role_has_permissions` VALUES ('4', '1');
INSERT INTO `role_has_permissions` VALUES ('4', '2');
INSERT INTO `role_has_permissions` VALUES ('5', '1');
INSERT INTO `role_has_permissions` VALUES ('5', '2');
INSERT INTO `role_has_permissions` VALUES ('5', '3');
INSERT INTO `role_has_permissions` VALUES ('5', '4');
INSERT INTO `role_has_permissions` VALUES ('6', '1');
INSERT INTO `role_has_permissions` VALUES ('6', '2');
INSERT INTO `role_has_permissions` VALUES ('7', '1');
INSERT INTO `role_has_permissions` VALUES ('7', '2');
INSERT INTO `role_has_permissions` VALUES ('8', '1');
INSERT INTO `role_has_permissions` VALUES ('8', '2');
INSERT INTO `role_has_permissions` VALUES ('9', '1');
INSERT INTO `role_has_permissions` VALUES ('9', '2');
INSERT INTO `role_has_permissions` VALUES ('9', '3');
INSERT INTO `role_has_permissions` VALUES ('9', '4');
INSERT INTO `role_has_permissions` VALUES ('10', '1');
INSERT INTO `role_has_permissions` VALUES ('10', '2');
INSERT INTO `role_has_permissions` VALUES ('11', '1');
INSERT INTO `role_has_permissions` VALUES ('11', '2');
INSERT INTO `role_has_permissions` VALUES ('12', '1');
INSERT INTO `role_has_permissions` VALUES ('12', '2');
INSERT INTO `role_has_permissions` VALUES ('13', '1');
INSERT INTO `role_has_permissions` VALUES ('13', '4');
INSERT INTO `role_has_permissions` VALUES ('14', '1');
INSERT INTO `role_has_permissions` VALUES ('15', '1');
INSERT INTO `role_has_permissions` VALUES ('16', '1');
INSERT INTO `role_has_permissions` VALUES ('17', '1');
INSERT INTO `role_has_permissions` VALUES ('17', '4');
INSERT INTO `role_has_permissions` VALUES ('18', '1');
INSERT INTO `role_has_permissions` VALUES ('19', '1');
INSERT INTO `role_has_permissions` VALUES ('20', '1');

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
INSERT INTO `user_coins` VALUES ('1', '2N6XyP7mS1shEYcvtLseusxmzECiSpPpaUN', '9ff75aca-5e6d-5d5f-96d7-caa2979a439d', '0.9', '2000', '2000', '0.2350001', null);
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
INSERT INTO `user_coins` VALUES ('42', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '0', '0', '0', '0', '{\"wallet\":{},\"userKeychain\":{\"xpub\":\"xpub661MyMwAqRbcFxfVmmd5pASnFzvhETU1aNo6QKy1sp5rK6d2V5dq9xmjaKuxjTwdEfxouTwJAgc56S37SwPdLJfprMuNu29J8JJonAhFpej\",\"xprv\":\"xprv9s21ZrQH143K3Ub2fk65T2W3hy6CpzkAD9sVbwZQKUYsSJHswYKacATFj5xS8LXUfYMBquF6dprrHdhwtvtUKceTURrPgZfSQBViu1WXxgH\",\"ethAddress\":\"0xefec81a853cc6816968146040953e72dcde14d1c\",\"encryptedXprv\":\"{\\\"iv\\\":\\\"rUMqDxAa1ctUWF7626PDdw==\\\",\\\"v\\\":1,\\\"iter\\\":10000,\\\"ks\\\":256,\\\"ts\\\":64,\\\"mode\\\":\\\"ccm\\\",\\\"adata\\\":\\\"\\\",\\\"cipher\\\":\\\"aes\\\",\\\"salt\\\":\\\"9DcdoI27Um4=\\\",\\\"ct\\\":\\\"3PMrOJRwTRxSxGadDeHAOnQ5ytEbKHdcMTdKInqA7LT\\/\\/6j8LCOcT3lwiqqlBhawbGUeAW15\\/2dNj\\/ndRpb6XIZqta7w4znuuk1LbtIlcuE8YJ1RrkO4ZwynV6azlzJQ4T7fsEPKMsmZ27DH9tzQnqiFQoY86Zg=\\\"}\"},\"backupKeychain\":{\"xpub\":\"xpub6GiRC55CSASv2hexv8JbuAFX43oprWCjcVstqbfyTWG5ktPdsTK7vwoxf1ytvZKxHD8gZtkyuK3VhhfKpyu3suig2LErqU8mjM2L8hiMmq3\",\"ethAddress\":\"0xee2ac505bfd291e839254f93314d13c45f857c16\",\"path\":\"m\"},\"bitgoKeychain\":{\"xpub\":\"xpub661MyMwAqRbcF7n1Sui2jrHE9eVNUmupWAvds6fzjZP3drHMSdbWo1S1fTaZJzi4zVe8CQYPM4oWRMVuXcsAqhTX6tEreb6rDWvk3ajDBMK\",\"ethAddress\":\"0xc3483fe43e50b31a67c051087618c695a630d084\",\"isBitGo\":true,\"path\":\"m\"}}');
INSERT INTO `user_coins` VALUES ('44', '2MtAngUGkCeu3sDipzzzAv8BKs6ddr6PUFB', '2MtAngUGkCeu3sDipzzzAv8BKs6ddr6PUFB', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('45', '2MsFH9tMEkKmrt3kP7SdYcGT9GbEWbZTXJj', '2MsFH9tMEkKmrt3kP7SdYcGT9GbEWbZTXJj', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('46', '1Lmth9mf2KAdpCBJcTT4MavMCMnVmfbr9Z', '38d106d3-6d0b-5f6e-9e9f-a64bf614f595', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('47', '1Pw1qm8HQMUcGko1HGbAQNCQ2CcbLX2dKZ', '31916588-a2cf-58c5-be56-0442208df1ab', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('48', '1Q9KLzCN6xfu4fXJcnRGsvEg5UXncSuj8x', '1a0d3f53-ccc1-51e7-ac0a-a9891a35d039', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('49', '1DWonTALfYFgz56W8nMmu527aqyFuoqEt3', 'cd7810be-e80c-5c61-959d-6c60b909b458', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('50', '1EMdGBadER4xUioEGUkFYnmpvK4QGSc1iN', '9ff75aca-5e6d-5d5f-96d7-caa2979a439d', '0', '0', '0', '0', null);
INSERT INTO `user_coins` VALUES ('51', '12iU4tEb6hf6Hx5RjP2ANPAhr7jsjsCEVb', '9ff75aca-5e6d-5d5f-96d7-caa2979a439d', '1000', '1914.1', '85.89999999999998', '0', null);

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
INSERT INTO `user_datas` VALUES ('1', '0', '2', '2N6XyP7mS1shEYcvtLseusxmzECiSpPpaUN', '2N4DNvf5p4fDwtJUJuCeCMiYdTRBQkpQWng', '0', '0', null, '2000', '0', '0', '3', '0', '2', '0', '0', '0', '1');
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
INSERT INTO `user_datas` VALUES ('42', null, '0', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('44', null, '0', '2MtAngUGkCeu3sDipzzzAv8BKs6ddr6PUFB', '2MtAngUGkCeu3sDipzzzAv8BKs6ddr6PUFB', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('45', '1', '0', '2MsFH9tMEkKmrt3kP7SdYcGT9GbEWbZTXJj', '2MsFH9tMEkKmrt3kP7SdYcGT9GbEWbZTXJj', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('46', '1', '0', '1Lmth9mf2KAdpCBJcTT4MavMCMnVmfbr9Z', '38d106d3-6d0b-5f6e-9e9f-a64bf614f595', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('47', '1', '0', '1Pw1qm8HQMUcGko1HGbAQNCQ2CcbLX2dKZ', '31916588-a2cf-58c5-be56-0442208df1ab', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('48', '1', '0', '1Q9KLzCN6xfu4fXJcnRGsvEg5UXncSuj8x', '1a0d3f53-ccc1-51e7-ac0a-a9891a35d039', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('49', '1', '0', '1DWonTALfYFgz56W8nMmu527aqyFuoqEt3', 'cd7810be-e80c-5c61-959d-6c60b909b458', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('50', '1', '0', '1EMdGBadER4xUioEGUkFYnmpvK4QGSc1iN', '9ff75aca-5e6d-5d5f-96d7-caa2979a439d', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');
INSERT INTO `user_datas` VALUES ('51', '1', '0', '12iU4tEb6hf6Hx5RjP2ANPAhr7jsjsCEVb', 'eb46008f-aa67-5765-832f-a10ab6f50be3', '0', '0', null, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0');

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
-- Table structure for `user_packages`
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
INSERT INTO `user_packages` VALUES ('1', '3', '2017-09-15 10:49:56', '2017-09-15 10:49:56', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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
  `refererId` int(10) DEFAULT '0',
  `google2fa_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_name_unique` (`name`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'nam hong', 'namhong1983@gmail.com', '$2y$10$WKi3VkkTNgXK4cCvYYX1uea32zSzaxrWvzcu33VK/J4uaXi7.DNKK\r\n$2a$06$GeXMDz5OAerqVL9EUqHq3.0KEa5m4uuQPJfsB13HDr0iqqlzgSXvW\r\n$2a$06$GeXMDz5OAerqVL9EUqHq3.0KEa5m4uuQPJfsB13HDr0iqqlzgSXvW\r\n$2a$0', 'nyYWMsRUapM2jp1na1EpeKtb8iQ9vHazw18yZiXfz05HfxThYp388E0FIR3l', '2017-08-12 05:47:39', '2017-08-30 02:23:57', '1', 'Nguyen', 'Hong', '012312423', '1', null, 'RE7S5LKYXTPCOMXF', '1');
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
INSERT INTO `users` VALUES ('51', 'huydk', 'huydk1@gmail.com', '$2y$10$kUDrZy6jpsiOswR77EdMLOLuKx/ehrOq025kgNrUxF11tfBuPJVZG', 'wg4Le3928DztuKEnDEJyLuyFX1AaqwnbogZ8VgBf9JzELCJ3Z7Y44ZDSNtjt', '2017-09-15 03:12:08', '2017-09-15 03:12:08', '0', 'Nguyen', 'Huy', '1657810999', '0', '1', 'KUCN65S27LCIWX4G', '1');

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
  `type` tinyint(2) NOT NULL COMMENT '1:buyclp;2:tranfer;3:bonus day;4: bonus f1;5:bonus week',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inOut` enum('out','in') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `userId` int(10) NOT NULL,
  `amount` double unsigned DEFAULT '0',
  PRIMARY KEY (`id`,`type`,`inOut`,`walletType`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `wallets` VALUES ('19', null, null, null, '1', '5', 'Tranfert to CLP wallet', 'out', '51', '100');
INSERT INTO `wallets` VALUES ('20', null, null, null, '1', '5', 'Tranfert from USD wallet', 'in', '51', '100');
INSERT INTO `wallets` VALUES ('21', null, null, null, '1', '5', 'Tranfert to CLP wallet', 'out', '51', '100');
INSERT INTO `wallets` VALUES ('22', null, null, null, '1', '5', 'Tranfert from USD wallet', 'in', '51', '100');
INSERT INTO `wallets` VALUES ('23', null, null, null, '1', '5', 'Tranfert to CLP wallet', 'out', '51', '100');
INSERT INTO `wallets` VALUES ('24', null, '2017-08-25 09:04:25', null, '1', '5', 'Tranfert from USD wallet', 'in', '51', '100');

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
  `amountCLP` int(10) DEFAULT NULL,
  `amountBTC` double(10,5) DEFAULT NULL,
  `fee` double(20,7) DEFAULT NULL,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`walletAddress`,`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
INSERT INTO `withdraws` VALUES ('15', '2017-09-11 10:26:32', '2017-09-11 10:26:32', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"0100000000010158f695a9e1af4a605b3a8fbc74c69782d24c65eefed0c3b75d23c78b0e07cb5f0000000023220020aec04242d35911493ac2c4021e81fccd444bdec29bf1a19e42d879bfa7980d07ffffffff02809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def871fbfcb080000000017a914cf5423ae4aeb3e903ff06d379f58ea0f2b8ff4af870400483045022100e90950fed446a7d144a55ba4ce94e24305bc5d785d1d2b7bf0031cfe00d28e720220231746a7e133bdb319d244ef0ecf8a1a61ad9f038bdc0a4496c3787a01c103c801473044022055e8433a157a1cd74aa87c713d410844b899cd322d11648f257f55ce53425b6802203f8974fd71c54f6b7b5dd5f1544979e64fbaf9effb6fb06a33e048333e89d8b001695221033e992ea3f62d8b1c771509b128ed162f9cf76c8f6b07296c261202c7da448c332103196b30b7aaa326e6577c4643f55a8f0fae07a88903634dd5b8449a587f2d86df2103ddd940d6ad8e9bfe5488cec75431c46e4d8e526c9a6349dd23e4f679cfa450a853ae00000000\",\"hash\":\"de5e9aa1db4ebfb67b0294e54305bb2ae398cfb65188159a421e3e9471c87ce1\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('16', '2017-09-11 10:31:01', '2017-09-11 10:31:01', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101e17cc871943e1e429a158851b6cf98e32abb0543e594027bb6bf4edba19a5ede0100000023220020745c8848923a63e512b5880e3affdb02b05990b07233103d71f03a1654b21324ffffffff021b2033080000000017a914c9aba70977476ab5d38de71d6a8958d4a927005687809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def87040047304402202e3b3019b24e4f62ac02baac51f83b7361c28314757b695dd72c2c654da0ae7a02200daa7ec867a9d95a254b417b9cd3bfd74ba9fb4a491f130e2f0889458103b0ca014730440220444aa5e86858bd8e94c8b6ae625c40e6056ba265ef6dd0f652b238805fc15ae602202602b77ff8a7d83f34ddb9796120beb56cc3567a97c816f6d51f3ab24239572201695221037ee284760b1da950a1ad8080c0c8655badf642fca93a34eb498b371c5b16ad1c2102f22ca80c39fde3c7c9e70a8ea08a5f76ce10db1d9369fbfdcc6359578b45efeb2102d621443738ca63abf1a4418fbb947200da50c154e9f6af6f0900be18a409fa6953ae00000000\",\"hash\":\"79e2cb586f6364c7edc5837482030a6103f29751534e6ccd9d8c3402ae6b9a22\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('17', '2017-09-11 10:35:48', '2017-09-11 10:35:48', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101229a6bae02348c9dcd6c4e535197f203610a03827483c5edc764636f58cbe2790000000023220020e8cb8c1c2178fd2d9b40808a93e6f0f9429dae262402decd942f8f3312160b55ffffffff0217819a070000000017a91424d71ff36a459061ba84b34cdabbbe0771f9e61587809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def87040047304402207400cd0a237554802e44abb45c80ae6d3d4a1ef5d47b0232301c7d0c10a92429022048dc265abcd892112d56a899b50587a3b249daf57ba0b4a441411a236c8bccdf01483045022100d28c0699741c123973d1aacf1252ce345d351af4dacdb4276cbfe69bdb0f200e02202bd27bd69082142f939dc7a341bec1c86bd76f10dfaa41efbf4b952af5e5995f0169522103123f1b22caf2355964d86e2782a874492e58c8dba117b1d283a020f9cc68d6cf2102a04419af459523056c7595b58513d3e51f6684fa39a6003765840653350481df2102ba081461852b7f393c11d2d390da3e99cd3d12f234bf8052fa6cd03fc2f278a053ae00000000\",\"hash\":\"46bac0471b9836522ccfca8d7f28a94c63f28f37585a666ff9c8731a3f845a0f\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('18', '2017-09-11 10:40:43', '2017-09-11 10:40:43', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000354', '{\"status\":\"accepted\",\"tx\":\"010000000001010f5a843f1a73c8f96f665a58378ff2634ca9287f8dcacf2c5236981b47c0ba4600000000232200206be91e1b56cfd23450419c745b29c2f5b3c5d056e690ada24824cfbb54a62817ffffffff0610c533010000000017a914790bc1eeee78bb861c3cd2ea27f398ddc1f7847587809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def878088c4000000000017a9143de716f67bfcd583eba615f72bccc6136d1b25c187d0a95c010000000017a9145625e783acfc7525519a521cd4891292768ed6c287f36a84020000000017a9148308deb2ceaf10ac1b15a90632479e1d0fb0b8be87707a28010000000017a9148c68dd168e3ddb52e14a0d4fed9bf810a29e3864870400473044022050e32944e983b6fcc8eb444f8c66060aa27f3841b0316ce0b1aa6e09a18a85f302205f102d31a9763573ad16f76bfa78bb2ebfdc825be64fa314044a2d029e57846d01483045022100ad71fcc3ece34db8524b56c45ec9bbc3d8d65878c9b85195e3e53f96378ec7a302200a78fe27cbb381e0d8071883ff38bf18bf625b921177700fe170da29be00ccdc01695221038310182ba418108e69acad80ccae3f7a3f5cdfc6527ef9e9e1ec1a7df28c8df421023c6865280b4d72b9f420fca0d279ef816bfa464a13128fc74c0c59550ae006d821028aff7b4920668d69f8d300c272237554304e19d3cadcfd955e6314ae5d58063853ae00000000\",\"hash\":\"6c7a5476c63fb44031a2795e48008b3112a35bb5099aad0d25f91f763c868ffc\",\"instant\":false,\"fee\":3540,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('19', '2017-09-11 10:47:00', '2017-09-11 10:47:00', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101fc8f863c761ff9250dad9a09b55ba312318b00485e79a23140b43fc676547a6c00000000232200202888e3d200074a96ab1fbb7ad94b056f4a609c6d34763b63290663fd360bf745ffffffff02809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def870c269b000000000017a9141e9c85da81322743bdf2430e947871bce5beb8ab870400483045022100fc766216a3b35e20a696e268d52ddf67b3fc544356d883d6169564794831b4b0022007fbb334f7b9695fbb534bbb8bf367cd727bcdd62c3d7c7139637a8c42d47888014730440220156f792412e5d4333ea90c8bb91f78a3fa5ee1ad41d6dc5ed8824937b8e3d0e80220385d8172e487f970139ba4ee7b2143b927973d5bd2f8c47b916a1a69e5eb340e016952210389ef86158e3bddc13bb23332dc7ab37b0c48dd711f1bf699e9907d8ab7abb04621032898504a19046661ce62872e7b1ca587c92cbba511e1585cadd8b516f31895c32102dd5c2a022460cefd0d75cbb63dda965c9b109d37cc3922bf9ac8be86fa61b5d553ae00000000\",\"hash\":\"da9ed8506a4094f58240b42d0a141e13ba7651ed322b19257415485f7182e7e7\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('20', '2017-09-11 10:48:49', '2017-09-11 10:48:49', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101fc8f863c761ff9250dad9a09b55ba312318b00485e79a23140b43fc676547a6c0300000023220020088bc68c0cb9405794b54538fbb2ab02ae0b8ef9e6d80951e48416d6765644d5ffffffff02cc0ac4000000000017a91444c747315bb1f5a3b47e246371f372e75d77215f87809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def870400473044022050e5f9a48986c8104ef0ac94555ed5d40af5cfca28e358ad2493ddd81c9ad90202201e4c83f5ec244e7e4c1eaf480b4b63f4e65f1192632875b30b0eca1885766dec01483045022100cace85885f673b249f5fce618c6c3433ccbbc14626b27382f1b32ae70618374202201242708366508ce2dc3aabc3804e29705732258bfc842ebb9e75ce7124933c5e0169522102fde00aa9e60e07dd0198606e40f99e83aabca8fb3d61a1fa167ee2886a6318eb210361f09c4ed179b66ecdea1e4073c464c1ce35c17e51d35cdead589b749982fe372103d9af5ca89f43b3c43cbcf0664f169f3407c499f3a653b74bcaee3590bc050b2353ae00000000\",\"hash\":\"a6bc4d2a725f8fedd51261e72ec666106057d41dd1abaf24db3a9873a318de26\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('21', '2017-09-11 10:51:42', '2017-09-11 10:51:42', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101fc8f863c761ff9250dad9a09b55ba312318b00485e79a23140b43fc676547a6c040000002322002036f1e1cafce050b39afdcf0bf9aa4f62695dab3795b531062a217c331fb7297cffffffff02efcbeb010000000017a914f4a7371203cb330d34f2c10b12d1bf5bb305a33f87809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def87040047304402202c2b71a2023fa3656f3c72c745da9eb9d49ddd3d281c36c1dca14f7c38ed1cf902202ba74cbcd9e675902282024393c801ce53e982fcb03beb8b5134a70dd72e009c0148304502210083e76610163f7840d407e84ea354b1a485706ea3b805a3a79995bd29accf051f02204da86d6b8ce49d07ebe9778c99432c48acee9f4391e11442f84f3c4f0e2c99f601695221037aff76fa9d26f6dc0c68e6ade916de46d0f0e4b44604e522998f1db2f368bb2421024a1ad087f9209507da776a12d507614c3465364f072ceff579bab9802abfd11e21026aabd4800c4c60da61706348ae2a19d6d32a79713f26ff0523752651a37cb31953ae00000000\",\"hash\":\"83867408507fb24a619d916b174028f38cf0315192fe9c85e03a5d7e405850fc\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('22', '2017-09-11 10:54:07', '2017-09-11 10:54:07', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101fc8f863c761ff9250dad9a09b55ba312318b00485e79a23140b43fc676547a6c0200000023220020d496171850ee4710a53eece7fdf730e5fbc5c38f5e2c2a384ecf18183b6f1ec2ffffffff02809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def877ce92b000000000017a914e8ca9f32abbc5c9723ef1410ab7b447ab77ba2e5870400463043021f0350a91df6309ef50581184fe340a5f15aab955e47c6849b027495dfce19ac022007ae8a366d3ed7b9ad7d87029ff39eb999d59afd15d6d095cc51f9704f29b45b0147304402203d9e23585606e91ee9bc1f5cbf7d9abaa14aff1be59fd90e2909666b4f00ffc402203a7f5a97bae5b1910455132c0dfd32c2036b69fa41ecbdf0ef3bd60e085800040169522103a592ebc3ad808b6f4ea95c580c3dc93959efcf7e89a17ea883d86ea9d8f550bc21033d5170f46377b7daa36c78a37c6714e5492d402de14bdcd062151aae0fb0b9a32103cb74aa9474a75f575bf9056c8fb9bddb7ec5bbc5d730cfd9ec5e800bf1988b3053ae00000000\",\"hash\":\"59a2bfb9bc19e6699afe26fed22acc7700e43392937ca6bbc68939ed77735b2c\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('23', '2017-09-11 10:56:41', '2017-09-11 10:56:41', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101e7e782715f48157425192b32ed5176ba131e140a2db44082f594406a50d89eda0100000023220020bac5f0b155886ea038cd93ef8636fe865d2eb9ba9ba9fa2014882f00815e1347ffffffff02088702000000000017a91416923bb5b3e7c3e8d510abde21e392cca393a25c87809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def8704004830450221008e44d90b4f0d91f3785d99ec279e61cf2c1c714bb7bc1cfea077498786fab85e02205676228e9048db934e33ff63f0379fcb2bf657fd593f9bdb06cef6ccf1478d9901483045022100daaba45af438192e602bd8232292e7287e3631f0bb4b27a0d7dc9254c45c1fa2022008179ac50e9fbc265d5f285a8458e8415034b29ca1a7aa780357973d81e06a8e0169522103642561413b40758c4b7bfefabd4fada36fe54b090d65cfccbd2f8c60be383e0c21036b730131764857f77fe0c771aaeb9e27a31fda460db5348b0ce8d5482f6fd533210265f42ddde75ad5d8e2677e819fc37182c0e8297d243067d075faeb24397f8b9a53ae00000000\",\"hash\":\"a8849ca20e274485e13ca2e69707c56dd6e9f2f784532f1561c68b69a9a41a0b\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('24', '2017-09-11 11:01:31', '2017-09-11 11:01:31', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"0100000000010126de18a373983adb24afabd11dd457601066c62ee76112d5ed8f5f722a4dbca60000000023220020a3bcf786c54c2f9a64440c737d075c0caee1bde86cde57badb564ab0883ba4a7ffffffff02c86b2b000000000017a914693aa4621309108cd9f5e7f951d2464bf69ee85987809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def870400483045022100aa64a90124bd7d6124d6c594c748e5c28e08a7ba3976820e8884632e1f2cf2f502203020f8ec00fdc3957a8c800cde2aea7b4fab7283257dbeda6c60785edc78177e0147304402205c6f7ff552e840cd1ba796e1465abfd276ab26ed2ca9c4625b9d8e274f8199bf0220096fc170ddb98d77e41696cc10226bd1a1be35baae2aa29fc9ac0c9f05425c7a01695221039c22d3d9fae4b647f82500f0189d8957c4281f21c46ecced3b9c7e509bcd2d072103113df1dbf7acf95c3ccb2edf7e5a832df2ba93364e0beb93517ac39e4a2457f321023e4a582102498ae9af152e4c2d000946b205fb46241144f13849800a7fa4439e53ae00000000\",\"hash\":\"93ebfbaecf3664afc51922cca9bbe3e8de132b1581047f17f0f897e558e62d33\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('25', '2017-09-11 11:04:19', '2017-09-11 11:04:19', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101fc5058407e5d3ae0859cfe925131f08cf32840176b919d614ab27f500874868300000000232200208395ff6062a7b266ac1c65f7bb0cf1969c6c6722cc662b78104b2cce2d4bb9c4ffffffff02809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def87eb2c53010000000017a91496dbebd5f58aee366a500d8dd0fb9f4e61a75df8870400483045022100d28a1cd6a0b059d47c466e4eae19e6fa020d7e0e752453d24fbae362fcf18d7e0220232ed8f214874f09c528f0af1bd58201a7366e5220932937c9b67df027f7e116014730440220230eb91613d9badbcbafcc374a48ac127104a8d445135395dbbf9f547536e13b02201b58a6b0cc157423301fd3b09a0313b57f3d59e438512b40ad9a38c1898b27e901695221039e5bccbd48cbc9f6cff69e90c7a7cf11c261ee9422e3a3a0d6811f1d9313963e2103939f44ff5b5aa40293200e0a98e736364bd91400146c5f2df5ca27c7319f70d921032859ec0ec42024509cedb258dfcc28ba78b8da696a117e8270b952f93a6cd0d553ae00000000\",\"hash\":\"7a8d9a939a41580ac2565fed13e211197b07920b699996455c59ec14efc57f77\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('26', '2017-09-11 11:08:00', '2017-09-11 11:08:00', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000357', '{\"status\":\"accepted\",\"tx\":\"010000000001022c5b7377ed3989c6bba67c939233e40077cc2ad2fe26fe9a69e619bcb9bfa25901000000232200208789c4dfc2e552633d66f293cd9b6439c736ee0f9b7e60b12104ade8e95bbb5cfffffffffc8f863c761ff9250dad9a09b55ba312318b00485e79a23140b43fc676547a6c050000002322002008e2c43b8be42c43f5be06650d30f5f153baa9adc0a4f2d18ac79e5e0d66283affffffff02809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def877abfbb000000000017a914d9462c86b5542768e38240278457b1919dfb3af58704004730440220316f90967b2527758adab4480ef944c196ff2f791e04ba48596a4a5ac7486c410220435fb652ca6a633cb8f164722779b347db412d3c7b7a3aabfd406ed7d04ad78801483045022100f5202c337ceb9dd3537f52379824927733dd270915eecf5c8441d21bba4248ce022058333f1f29eccfe62d6a086e38303b252d5f2c4d7f1915b39d6ceabaac6c1b1a016952210235567b1a65e750c600124729e451448e389e2e33f7cbd3cbc08eb16d838ef1d121039ac416096b37e03b032ba60100d1e07642c019c14ab2c808a62e79fab200575221025c51612d6535699892e54d933117be7aff7be153c56bcd7a39160bc06089cb7d53ae04004730440220136ae5da3d67b7ab72bdd41a2fee1e2a7fa69107296ca83873fdfc80fc97153a02201be16537e48f3dd9a467c95bb095dd1b5f527d52867d73d0ed8bc814bbdaa5150147304402206ccae9e9adbb33e5b34ae24511899441d28e6b348b434966179347ed19443a0902205ebedb956771b5605d9812f7aa5da768449c2fda82ca7bd3c0684d2999946e44016952210223cf3ca881d9fc2ac1db2c2c59dde96d64d416847f5676a140f13f0f9814132d2103b53a8c46161b210433d0c598668d99a903defd2fff7c43ce9760b2bbc122475321035e1bf3fe0ae8321e5874c3e7186c5b89ee91bbc99d9d759b7f8ce9347cfc058153ae00000000\",\"hash\":\"e2873e9defdee2f8b3820895e1e048efa0c5db73597fbb4fc8e673fbc9b26978\",\"instant\":false,\"fee\":3570,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('27', '2017-09-11 11:11:44', '2017-09-11 11:11:44', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"01000000000101777fc5ef14ec595c459699690b92077b1911e213ed5f56c20a58419a939a8d7a0100000023220020592ab1470dada6b0fa2e62e93829cc7f00dd2add6fa7b8f380c59fcb2d7bb8efffffffff02e78dba000000000017a9146dfed22879aba4e3773a61b24f735c9e648a845887809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def8704004830450221009dd04715a46d73dd16566750675d3b2be3060909c6f23a061fd484f55e19470f02205a6bb3083e7849a316dfebc720738cb34f3f761c85309ba70d474a4821ee9f5401483045022100e81dcc256659526ebbbf499c55e2739a33634888db950b1254526ef35f78698902204d7a664d0b8802644d78f425ae0c4309ac39b6857a24d3d8dbb2461c41c795e60169522103541fed6952ce46b837ad53bd4606a210809c8a41f0b7f22a046549fa4f9eda542102073ad19d7d810dc6530fc4a2117a7e84e6c8679d654bf926537ecf47fa68bfe42102c4356831322ad8f042f4dcbfd43da08be4d25a32f3c949bd5500072af53b793053ae00000000\",\"hash\":\"4508830119a40d38004573938ad900bb7b3184af0067ad65ac7f631350eefe7a\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('28', '2017-09-11 11:18:52', '2017-09-11 11:18:52', '2NGapGdF7pcqstyoJ6ahMrZVskD9SeUcEJR', '1', null, '0.10000', '0.0000218', '{\"status\":\"accepted\",\"tx\":\"010000000001017afeee5013637fac65ad6700af84317bbb00d98a93734500380da4190183084500000000232200204516e3e3707c4731889e78de9f1c8767558aff50bda5a9daca823f4887854cffffffffff02e3ee21000000000017a914e497c6af16757af9f7c7050956b83c7147e70a4c87809698000000000017a914ffff69cbf2ae71c2f51422ff30168aeddabe0def87040047304402201a7fecc6d0c00add345d89a921e28810ac1fd6119bba50ff8204e67cdcb3fc3a0220409d7d8619cc9b218c01bb0c46394facec680e42d614590d9464436a948fb93601483045022100b98d7215dc57e33e1ef9c24b33256660ced8d906b2ac0aa0d1f7d1e43098ef5d022065b7015ef955255df373fe16cf7cbb7d516d659fd0a011f3178b0cb239f5d7040169522102e516dfae401d14127d445a83bf3a0fe20f8712d62ee51e3e8c217a998f359d202103644cbaf6f7101910e9e41d94ee93544dcc66f307d6d75d594456a5a8cf9c5e652102974e39eced69068e74e62f089cdac11920838d05c52a24905dd238e0a9a23f5353ae00000000\",\"hash\":\"1651d96424325b3f4fb251ea5794525de8f027543dd5b44ca753766fef8cbf6b\",\"instant\":false,\"fee\":2180,\"feeRate\":10000,\"travelInfos\":[]}', '1');
INSERT INTO `withdraws` VALUES ('29', '2017-09-12 03:12:37', '2017-09-12 03:12:37', '2NEyyVT9bPebVcKYfCYoJG621mjLcWo4hXg', '1', null, '0.10000', '0.0004595', '{\"status\":\"accepted\",\"tx\":\"0100000000010103be4e55f4e1e37130eea80f2e4f82577813bac812a3442f4015a47ee6bda3100000000023220020681d94b110a77e5b1555612e654a6dd2eafe9240646cffc706fffc6489ab46a7ffffffff02809698000000000017a914ee706d1e05910ae5a94d5ec47dab638ca4736f9287912b16100000000017a91427084f56beb006fa151338fd2d7177ae0b2b180b87040047304402207503690dbe37a288900c32e4305d39113856054340ec0796d66d898adf094a1002206fa8b94884c64447aac06cfaa7c015b4644c0aa7e4f16a4e19843c96acc6ac2f01483045022100fc35368d4d846920c56451a6c4540ff37083ddf82d42d34291f0e238a7e4b296022070b1a7c49325c11234d1166cc468ec5df6d0c5049417b189b48bec50d1f309030169522103127cc8a2088d3712a44b8a3ff7e2b752b403271358110e3c29c2f31b8f210cc421038d67700ca6e3646bdba92c116fe400d68d9497e749fde34bfa247caa8b684b3721020a437ecc1698982cdc7b44149a7b4cde764f4448219fe52922b2601253d89fe253ae00000000\",\"hash\":\"2e0a7e385c9425775ba818d23df12176e46d163cee4eafb2b39e2fb0eb28cfbd\",\"instant\":false,\"fee\":45953,\"feeRate\":210791,\"travelInfos\":[]}', '1');
