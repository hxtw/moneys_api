/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : localhost:3306
 Source Schema         : my_money

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 21/06/2019 18:06:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for my_article
-- ----------------------------
DROP TABLE IF EXISTS `my_article`;
CREATE TABLE `my_article`  (
  `artl_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章id',
  `artl_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `artl_subheading` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '副标题',
  `artl_content` varchar(6000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '内容',
  `artl_simg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '竖图 头图',
  `artl_himg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '横图  长图',
  `artl_isstate` tinyint(4) DEFAULT 1 COMMENT '状态  1=未审核 2=通过 3=未通过',
  `artl_adduesr` int(11) DEFAULT NULL COMMENT '添加人',
  `artl_addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`artl_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_article
-- ----------------------------
INSERT INTO `my_article` VALUES (1, '谭玮', '啊伟大伟大', '11111111111', '20190509/68e77bb05558b8d18c9e646be29ce66112.jpg', '20190509/0f679eeb524b2194e5ee47c348e4b9b68.jpg', 1, 1, 1557399989);
INSERT INTO `my_article` VALUES (2, '11', '22', '33', '20190511/b824f71444d995e452bf2f3b72743de85.jpg', '20190511/234b8e79e5c6eac232be5be8f28fab3411.jpg', 1, 1, 1557554539);
INSERT INTO `my_article` VALUES (3, '12', '12', '123', '20190610/6d41b243e93cd923a218ca57a9fd08cb70d8a9b331.jpg', '20190610/7f72a1a536d66ee477b7c79886fb16334216792577.jpg', 1, 1, 1560140993);

-- ----------------------------
-- Table structure for my_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `my_auth_group`;
CREATE TABLE `my_auth_group`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `rules` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Table structure for my_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `my_auth_group_access`;
CREATE TABLE `my_auth_group_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_auth_group_access
-- ----------------------------
INSERT INTO `my_auth_group_access` VALUES (1, 'Eqx,Article');

-- ----------------------------
-- Table structure for my_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `my_auth_rule`;
CREATE TABLE `my_auth_rule`  (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` char(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `title` char(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `condition` char(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `name`(`name`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of my_auth_rule
-- ----------------------------
INSERT INTO `my_auth_rule` VALUES (1, 'Eqx', '易企秀', 1, 1, '');
INSERT INTO `my_auth_rule` VALUES (2, 'Artice', '文章', 1, 1, '');
INSERT INTO `my_auth_rule` VALUES (3, 'Video', '视频', 1, 1, '');
INSERT INTO `my_auth_rule` VALUES (4, 'Dubbing', '音频', 1, 1, '');

-- ----------------------------
-- Table structure for my_dubbing
-- ----------------------------
DROP TABLE IF EXISTS `my_dubbing`;
CREATE TABLE `my_dubbing`  (
  `du_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '配音id',
  `du_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `du_subheading` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '副标题',
  `du_content` varchar(6000) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '提示内容',
  `du_video` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '配音',
  `du_assig_type` tinyint(4) DEFAULT 1 COMMENT '指派状态  1=待操作 2=已操作',
  `du_isstate` tinyint(4) DEFAULT 1 COMMENT '状态  1=未审核 2=通过 3=未通过',
  `du_adduesr` int(11) DEFAULT NULL COMMENT '添加人',
  `du_addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  `du_assignor` int(11) DEFAULT NULL COMMENT '指派给谁',
  `du_edittime` int(11) DEFAULT NULL COMMENT '分配修改时间',
  PRIMARY KEY (`du_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_dubbing
-- ----------------------------
INSERT INTO `my_dubbing` VALUES (1, '3', '4', NULL, '', 1, 1, 1, 1557473864, 1, 1557473864);
INSERT INTO `my_dubbing` VALUES (2, '12', NULL, NULL, '20190511/51edb6bb3d1562fea225af5021c3545b9.mp3', 1, 1, 1, 1557555278, 1, 1557555278);
INSERT INTO `my_dubbing` VALUES (8, '12', NULL, NULL, '20190519/925612d44539bf632b92f5027213e5169.mp3', 2, 1, 1, 1558251542, 1, 1558251542);
INSERT INTO `my_dubbing` VALUES (9, '谭玮###$&lt;b style=&quot;color:#cc3300&quot;&gt;❤❤', NULL, NULL, '20190519/6d7b190f85a12dcbc1687a41d4b676855.mp3', 2, 1, 1, 1558251757, 1, 1558251757);

-- ----------------------------
-- Table structure for my_eqx
-- ----------------------------
DROP TABLE IF EXISTS `my_eqx`;
CREATE TABLE `my_eqx`  (
  `eqx_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '易企秀id',
  `eqx_eqxid` int(11) UNSIGNED DEFAULT NULL COMMENT '易企秀的id',
  `eqx_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `eqx_subheading` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '副标题',
  `eqx_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'url',
  `eqx_industry` tinyint(11) DEFAULT NULL COMMENT '行业',
  `eqx_type` tinyint(11) DEFAULT NULL COMMENT '类型',
  `eqx_code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'code',
  `eqx_simg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '竖图',
  `eqx_himg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '横图',
  `eqx_isstate` tinyint(4) DEFAULT 1 COMMENT '状态  1=未审核 2=通过 3=未通过',
  `eqx_adduesr` int(11) DEFAULT NULL COMMENT '添加人',
  `eqx_addtime` int(11) NOT NULL COMMENT '添加时间',
  `eqx_publishtime` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`eqx_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 32 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_eqx
-- ----------------------------
INSERT INTO `my_eqx` VALUES (1, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1557717957, '12');
INSERT INTO `my_eqx` VALUES (2, NULL, '1', '2', '14', 1, 11, '1', '20190511/c85a4d7247af5f5f1c639a9e36da4a9c6.jpg', '20190511/a12b1bb1ea1f9720860a87969ca35a9c13.jpg', 1, 1, 1557631557, '2');
INSERT INTO `my_eqx` VALUES (3, NULL, '111111', '2222222222', 'http://www.baiu.com', 1, 11, '2444444444444', '20190511/408ad977a272bf30d6fb3e65df5028a912.jpg', '20190511/25610420b66f68680c8ff939ac9475175.jpg', 2, 1, 1557545157, '3555555555');
INSERT INTO `my_eqx` VALUES (4, NULL, '111111', '2222222222', 'http://www.baiu.com', 1, 11, '2444444444444', '20190511/408ad977a272bf30d6fb3e65df5028a912.jpg', '20190511/25610420b66f68680c8ff939ac9475175.jpg', 2, 1, 1557458757, '3555555555');
INSERT INTO `my_eqx` VALUES (5, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1557372357, '12');
INSERT INTO `my_eqx` VALUES (6, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1557285957, '12');
INSERT INTO `my_eqx` VALUES (7, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1557199557, '12');
INSERT INTO `my_eqx` VALUES (8, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1557113157, '12');
INSERT INTO `my_eqx` VALUES (9, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1557026757, '12');
INSERT INTO `my_eqx` VALUES (10, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1556940357, '12');
INSERT INTO `my_eqx` VALUES (11, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1556853957, '12');
INSERT INTO `my_eqx` VALUES (12, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1556767557, '12');
INSERT INTO `my_eqx` VALUES (13, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 2, 1, 1556681157, '12');
INSERT INTO `my_eqx` VALUES (14, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1554089157, '12');
INSERT INTO `my_eqx` VALUES (15, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1551410757, '12');
INSERT INTO `my_eqx` VALUES (16, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1548991557, '12');
INSERT INTO `my_eqx` VALUES (17, NULL, '1211111111111111', '12', 'http://www.baidu.com', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1546313157, '12');
INSERT INTO `my_eqx` VALUES (18, NULL, '12', '12', '12', NULL, NULL, NULL, NULL, NULL, 1, 1, 1557717957, '');
INSERT INTO `my_eqx` VALUES (19, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1554089157, '12');
INSERT INTO `my_eqx` VALUES (20, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1554089157, '12');
INSERT INTO `my_eqx` VALUES (21, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1557717957, '12');
INSERT INTO `my_eqx` VALUES (22, NULL, '12', '12', '12', 1, 11, '12', '20190509/fe9f4da66b21b64fa91d9a882721475d12.jpg', '20190509/96b3994155d1ea34a870c2e2b4db685a6.jpg', 1, 1, 1557717957, '12');
INSERT INTO `my_eqx` VALUES (23, NULL, '11111水水水水水水', '122222222', 'http://www.cawd.com', 1, 11, '123', '20190518/c9f18e26e18d9d2eb8868501274a58a55.jpg', '20190518/5cab079a53686fe9eb4cfcff4cccb61510.jpg', 1, 1, 1558174009, '3123');
INSERT INTO `my_eqx` VALUES (24, NULL, '谭玮###$&lt;b style=\\\'color:#cc3300\\\'&gt;', '123', 'https://www.cvasd.com', 1, 11, '微软发生大的发', '20190518/1114e095172c4717f7668db74184590d8.jpg', '20190518/e0b2ce7a29c5c3f23a46d240381c7bc09.jpg', 1, 1, 1558174698, '213213aa');
INSERT INTO `my_eqx` VALUES (25, NULL, '1231', '123', 'http://www.vao.cn', 2, 44, '12312', '20190519/00166e7cda52620efa5168ebac37e4126.jpg', '20190519/30fc065b1e2895e61f5df70925db1c7a5.jpg', 1, 1, 1558262195, '12');
INSERT INTO `my_eqx` VALUES (26, 1111, '&lt;b&gt;Test&lt;/b&gt;', '1', 'http://www.baidu.com', 1, 11, '1232423', '20190519/799ba965b59d66b92e29bab5afe9fd1612.jpg', '20190519/42dc790f6c1320372708c43476128a779.jpg', 1, 1, 1558264980, '12323s');
INSERT INTO `my_eqx` VALUES (27, 11111111, '怄气', '达瓦', 'http://www.baidu.com', 1, 11, '2222222222', 'http://my-moneys.oss-cn-beijing.aliyuncs.com/A1/dfe029cdf8239e68fc3194cc17b3722d622096f26.jpg', 'http://my-moneys.oss-cn-beijing.aliyuncs.com/A1/c59fe29f7438da6bd86b1681d8d974f2ff02ecd539.jpg', 1, 1, 1559281900, '333333');
INSERT INTO `my_eqx` VALUES (28, 1, '1', '1', 'https://bbs.aliyun.com/read/312193.html?fpage=6', 3, 11, '2', 'A1/4973d7c2d7a69f5e135e1ca8ac37b8c662dbf24984.jpg', 'A1/093077d31d11b2a8cdaff63500162fcdb4bea5bd47.jpg', 1, 1, 1559722706, '2');
INSERT INTO `my_eqx` VALUES (29, 12312, '123', '123123', 'https://blog.csdn.net/msqinlei/article/details/88637911', 1, 11, '3123', '20190610/177db2f211c1ca74eb4e2e82fd4be267b15b0d9164.jpg', '20190610/41b856c6c3eba2993b29159736602d92acf4109135.jpg', 1, 1, 1559727064, '12312');
INSERT INTO `my_eqx` VALUES (30, 1241, '1', '212', 'https://blog.csdn.net/wildwolf_001/article/details/83275924', 1, 11, '24124', '20190610/177db2f211c1ca74eb4e2e82fd4be267b15b0d9164.jpg', '20190610/41b856c6c3eba2993b29159736602d92acf4109135.jpg', 1, 1, 1560136291, '124124');
INSERT INTO `my_eqx` VALUES (31, 112, '测试1', '撒网', 'http://www.thinkphp.cn/code/4209.html', 1, 11, '1231', '20190610/bdbbfa836218116568507633d88a0fe53689373899.jpg', '20190610/e8f89780ab03fc07bc4d998726b0bcdce426071515.jpg', 1, 1, 1560139171, '23123');

-- ----------------------------
-- Table structure for my_user
-- ----------------------------
DROP TABLE IF EXISTS `my_user`;
CREATE TABLE `my_user`  (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `number` char(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `password` char(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '密码',
  `isstatus` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1=正常  2=关闭',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `lastlogintime` datetime DEFAULT NULL COMMENT '最后登录时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Fixed;

-- ----------------------------
-- Records of my_user
-- ----------------------------
INSERT INTO `my_user` VALUES (1, '18610210070', 'e10adc3949ba59abbe56e057f20f883e', 1, '2019-05-05 14:05:00', '2019-05-05 14:05:03');

-- ----------------------------
-- Table structure for my_user_access
-- ----------------------------
DROP TABLE IF EXISTS `my_user_access`;
CREATE TABLE `my_user_access`  (
  `uid` mediumint(8) UNSIGNED NOT NULL,
  `group_id` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  UNIQUE INDEX `uid_group_id`(`uid`, `group_id`) USING BTREE,
  INDEX `uid`(`uid`) USING BTREE,
  INDEX `group_id`(`group_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_user_access
-- ----------------------------
INSERT INTO `my_user_access` VALUES (1, 'Eqx,Article,Video,Dubbing');

-- ----------------------------
-- Table structure for my_video
-- ----------------------------
DROP TABLE IF EXISTS `my_video`;
CREATE TABLE `my_video`  (
  `vde_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '视频id',
  `vde_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `vde_subheading` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '副标题',
  `vde_simg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '竖图 头图',
  `vde_himg` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '横图  长图',
  `vde_video` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '视频',
  `vde_isstate` tinyint(4) DEFAULT 1 COMMENT '状态  1=未审核 2=通过 3=未通过',
  `vde_adduesr` int(11) DEFAULT NULL COMMENT '添加人',
  `vde_addtime` int(11) DEFAULT NULL COMMENT '添加时间',
  PRIMARY KEY (`vde_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of my_video
-- ----------------------------
INSERT INTO `my_video` VALUES (7, '11', '22', '20190511/5bfe59c0376a9e006bbd96d5d9b75ffd5.jpg', '20190511/0dbd339798f1e62ebb70a7030045d7178.jpg', '20190511/638ca71f77809254eb8db7ffc159ddff13.mp4', 1, 1, 1557554974);
INSERT INTO `my_video` VALUES (6, '', '', '20190510/0f4058637888a75c67ae920e554052f39.jpg', '20190510/bc4008b300ff5f76b93b617a16fa21bb12.jpg', '20190510/a4141d19c9a4cebd5da4062da17e07a915.mp4', 1, 1, 1557469844);
INSERT INTO `my_video` VALUES (5, '1', '2', '20190510/efb5b8c6408d8e362fbc8f173cea781d11.jpg', '20190510/17ff80093a4616f93d614a711a3bc6f88.jpg', '20190510/933a9a272a30611b8dd19744a2dd0ae811.mp4', 1, 1, 1557462368);
INSERT INTO `my_video` VALUES (8, '123', '123', '20190610/18776a8c70bdb029d52e1494a8ce068c65fceaf772.jpg', '20190610/1649240783e5841b221d2fdbadc318b370d6b59570.jpg', '20190610/cc1aeec5e57b42e8e715f6a4d170839d5.mp4', 1, 1, 1560141102);

SET FOREIGN_KEY_CHECKS = 1;
