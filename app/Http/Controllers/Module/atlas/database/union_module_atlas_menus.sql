/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : atlas

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2020-04-26 13:42:59
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `union_module_atlas_menus`
-- ----------------------------
DROP TABLE IF EXISTS `union_module_atlas_menus`;
CREATE TABLE `union_module_atlas_menus` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` tinyint(1) DEFAULT '1' COMMENT '权限 1=需要权限  2=不用权限  ',
  `title` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '题目',
  `controller` varchar(50) CHARACTER SET utf8 DEFAULT '' COMMENT '控制器',
  `action` varchar(50) CHARACTER SET utf8 DEFAULT '' COMMENT '方法',
  `url` varchar(120) CHARACTER SET utf8 DEFAULT '' COMMENT 'url 连接',
  `is_hide` tinyint(4) DEFAULT '0' COMMENT '是否隐藏(2=不隐藏，1=隐藏)',
  `icon` varchar(25) CHARACTER SET utf8 DEFAULT '' COMMENT '顶级菜单图标',
  `pid` int(11) DEFAULT '0' COMMENT '上级菜单id',
  `orders` tinyint(4) DEFAULT '1' COMMENT '排序顺序',
  `create_at` varchar(12) DEFAULT '' COMMENT '创建时间',
  `update_at` varchar(12) DEFAULT '' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of union_module_atlas_menus
-- ----------------------------
INSERT INTO `union_module_atlas_menus` VALUES ('1', '1', '首页', 'Index', 'index', 'index', '2', 'icon-home4', '0', '30', '1577095222', '1587868772');
INSERT INTO `union_module_atlas_menus` VALUES ('2', '1', '系统设置', 'Setting', '#', '#', '2', 'icon-gear', '0', '20', '1577095407', '1586828919');
INSERT INTO `union_module_atlas_menus` VALUES ('3', '1', '菜单导航', 'Setting', 'menu/menuList', 'menu/menuList', '2', null, '2', '0', '1577095482', '1577095482');
INSERT INTO `union_module_atlas_menus` VALUES ('8', '1', '菜单添加', 'Setting', 'menu/menuList', 'menu/menuAdd', '1', null, '2', '0', '1577257186', '1577257186');
INSERT INTO `union_module_atlas_menus` VALUES ('9', '1', '菜单编辑', 'Setting', 'menu/menuList', 'menu/menuEdit', '1', null, '2', '0', '1577257217', '1577257217');
INSERT INTO `union_module_atlas_menus` VALUES ('10', '1', '菜单删除', 'Setting', 'menu/menuList', 'menu/menuDelete', '1', null, '2', '0', '1577257246', '1583909751');
INSERT INTO `union_module_atlas_menus` VALUES ('13', '1', '权限组', 'Group', 'group/groupList', 'group/groupList', '2', null, '14', '0', '1577095530', '1577257608');
INSERT INTO `union_module_atlas_menus` VALUES ('14', '1', '权限管理', 'Group', '#', '#', '2', 'icon-make-group', '0', '19', '1577257590', '1586828933');
INSERT INTO `union_module_atlas_menus` VALUES ('15', '1', '权限组添加', 'Group', 'group/groupList', 'group/groupAdd', '1', null, '14', '0', '1577258129', '1578552544');
INSERT INTO `union_module_atlas_menus` VALUES ('16', '1', '权限组编辑', 'Group', 'group/groupList', 'group/groupEdit', '1', null, '14', '0', '1577258162', '1578552547');
INSERT INTO `union_module_atlas_menus` VALUES ('17', '1', '权限组删除', 'Group', 'group/groupList', 'group/groupDelete', '1', null, '14', '0', '1577258191', '1578552550');
INSERT INTO `union_module_atlas_menus` VALUES ('18', '1', '我的信息', 'Info', 'user/info', 'user/info', '2', 'icon-user-plus', '0', '0', '1577260204', '1582973622');
INSERT INTO `union_module_atlas_menus` VALUES ('37', '1', '权限组分配权限', 'Group', 'group/groupList', 'group/assignPermissions', '1', null, '14', '0', '1578555525', '1578555525');
INSERT INTO `union_module_atlas_menus` VALUES ('38', '1', '权限组成员', 'Group', 'group/groupList', 'group/groupUsers', '1', null, '14', '0', '1578555561', '1578555561');
INSERT INTO `union_module_atlas_menus` VALUES ('39', '1', '权限组分配成员', 'Group', 'group/groupList', 'group/groupAddUser', '1', null, '14', '0', '1578555593', '1578555593');
INSERT INTO `union_module_atlas_menus` VALUES ('114', '1', '项目管理', 'Project', '#', '#', '2', 'icon-stack3', '0', '29', '1587868837', '1587868837');
INSERT INTO `union_module_atlas_menus` VALUES ('115', '1', '项目列表', 'Project', 'project/list', 'project/list', '2', null, '114', '0', '1587868871', '1587868871');
INSERT INTO `union_module_atlas_menus` VALUES ('116', '1', '项目添加', 'Project', 'project/list', 'project/add', '1', null, '114', '0', '1587879691', '1587879691');
INSERT INTO `union_module_atlas_menus` VALUES ('117', '1', '项目编辑', 'Project', 'project/list', 'project/edit', '1', null, '114', '0', '1587879713', '1587879713');
INSERT INTO `union_module_atlas_menus` VALUES ('118', '1', '删除项目', 'Project', 'project/list', 'project/delete', '1', null, '114', '0', '1587879739', '1587879739');
INSERT INTO `union_module_atlas_menus` VALUES ('119', '1', '上传项目界面稿', 'Project', 'project/list', 'project/updateInterfaceDraft', '1', null, '114', '0', '1587879770', '1587879770');
