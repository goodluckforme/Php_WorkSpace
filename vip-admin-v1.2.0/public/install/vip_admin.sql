/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50547
Source Host           : localhost:3306
Source Database       : vip_admin

Target Server Type    : MYSQL
Target Server Version : 50547
File Encoding         : 65001

Date: 2017-05-02 21:07:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for vip_gather
-- ----------------------------
DROP TABLE IF EXISTS `vip_gather`;
CREATE TABLE `vip_gather` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '昵称',
  `money` double NOT NULL COMMENT '金额',
  `time` date NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of vip_gather
-- ----------------------------
INSERT INTO `vip_gather` VALUES ('5', 'vip-ad***', '49', '2017-03-17');

-- ----------------------------
-- Table structure for vip_must_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_auth_group`;
CREATE TABLE `vip_must_auth_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='权限组表';

-- ----------------------------
-- Records of vip_must_auth_group
-- ----------------------------
INSERT INTO `vip_must_auth_group` VALUES ('1', '超级管理组', '1', '100,101,102,103,104,105,107,108,109,110,111,112,113');
INSERT INTO `vip_must_auth_group` VALUES ('2', '普通管理员', '1', '100,102,103,104,105,109,111,112,113');

-- ----------------------------
-- Table structure for vip_must_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_auth_group_access`;
CREATE TABLE `vip_must_auth_group_access` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `sid` smallint(8) unsigned NOT NULL COMMENT '系统权限用户id',
  `gid` smallint(8) unsigned NOT NULL COMMENT '权限规则id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户权限组规则表';

-- ----------------------------
-- Records of vip_must_auth_group_access
-- ----------------------------
INSERT INTO `vip_must_auth_group_access` VALUES ('1', '1', '1');
INSERT INTO `vip_must_auth_group_access` VALUES ('2', '2', '2');

-- ----------------------------
-- Table structure for vip_must_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_auth_rule`;
CREATE TABLE `vip_must_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(20) NOT NULL COMMENT '节点名称',
  `url` varchar(100) NOT NULL COMMENT '链接url',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父id',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `icon` varchar(50) DEFAULT NULL COMMENT '图标',
  `order` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `note` char(100) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1002 DEFAULT CHARSET=utf8 COMMENT='必要规则表';

-- ----------------------------
-- Records of vip_must_auth_rule
-- ----------------------------
INSERT INTO `vip_must_auth_rule` VALUES ('107', '菜单管理', 'admin/Nav/index', '101', '1', '#xe621;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('108', '权限组', 'admin/System/auth', '101', '1', '#xe621;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('109', '普通用户', 'admin/User/index', '102', '1', '#xe621;', '0', null, '0');
INSERT INTO `vip_must_auth_rule` VALUES ('110', '系统用户', 'admin/SystemUser/index', '102', '1', '#xe621;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('111', '修改密码', 'admin/SystemUser/edit_password', '102', '1', '#xe621;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('112', '日志记录', 'admin/Log/index', '103', '1', '#xe621;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('113', '数据库备份', 'admin/Bak/index', '104', '1', '#xe621;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('100', '系统配置', '', '0', '1', '#xe631;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('101', '系统管理', '', '0', '1', '#xe620;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('102', '用户管理', '', '0', '1', '#xe612;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('103', '日志管理', '', '0', '1', '#xe60a;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('104', '数据库管理', '', '0', '1', '#xe632;', '0', null, '1');
INSERT INTO `vip_must_auth_rule` VALUES ('105', '后台配置', 'admin/System/config', '100', '1', '#xe621;', '0', null, '1');

-- ----------------------------
-- Table structure for vip_must_back_sql
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_back_sql`;
CREATE TABLE `vip_must_back_sql` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `url` varchar(250) NOT NULL COMMENT '备份文件地址',
  `time` datetime NOT NULL COMMENT '备份时间',
  `status` smallint(6) NOT NULL COMMENT '状态 1正常 0删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='数据库备份表';

-- ----------------------------
-- Records of vip_must_back_sql
-- ----------------------------

-- ----------------------------
-- Table structure for vip_must_config
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_config`;
CREATE TABLE `vip_must_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config` text NOT NULL COMMENT '配置',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='配置';

-- ----------------------------
-- Records of vip_must_config
-- ----------------------------
INSERT INTO `vip_must_config` VALUES ('1', '{\"title\":\"vip-admin \\u7ba1\\u7406\\u7cfb\\u7edf\",\"version\":\"v1.2.0\",\"copy\":\"Copyright \\u00a92017 [\\u4f7f\\u7528\\u8005\\u7f51\\u7ad9] Powered By [\\u7f51\\u7ad9\\u7a0b\\u5e8f\\u540d\\u79f0] Version 1.1.0\",\"icp\":\"\\u67d0ICP\\u5907xxxxxxxx\\u53f7\",\"code\":\"javascript:baidutongji();\"}');

-- ----------------------------
-- Table structure for vip_must_system_log
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_system_log`;
CREATE TABLE `vip_must_system_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `us_id` int(11) DEFAULT NULL COMMENT '普通用户id/系统用户id',
  `operation_position` varchar(100) NOT NULL COMMENT '操作位置',
  `operation_ip` char(20) NOT NULL COMMENT '操作ip地址',
  `operation_ip_area` char(50) NOT NULL COMMENT 'ip地址',
  `is_mobile` varchar(6) NOT NULL COMMENT '是否是手机访问',
  `time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2128 DEFAULT CHARSET=utf8 COMMENT='用户操作日志记录表';

-- ----------------------------
-- Records of vip_must_system_log
-- ----------------------------

-- ----------------------------
-- Table structure for vip_must_system_user
-- ----------------------------
DROP TABLE IF EXISTS `vip_must_system_user`;
CREATE TABLE `vip_must_system_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员用户名',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(20) DEFAULT NULL COMMENT '最后登录IP',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态 1:启用 0:禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of vip_must_system_user
-- ----------------------------
INSERT INTO `vip_must_system_user` VALUES ('1', 'admin', '39b06ad92d56e6445a58096d77b39f48', '2017-05-02 20:33:14', '0.0.0.0', '2016-10-18 15:28:37', '1');
INSERT INTO `vip_must_system_user` VALUES ('2', 'root', '39b06ad92d56e6445a58096d77b39f48', '2017-05-02 20:30:27', '0.0.0.0', '2017-02-23 16:10:53', '1');
