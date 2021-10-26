/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : atlas

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2020-04-26 13:37:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `union_module_atlas_group`
-- ----------------------------
DROP TABLE IF EXISTS `union_module_atlas_group`;
CREATE TABLE `union_module_atlas_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `type` varchar(30) DEFAULT '' COMMENT '用户类型， general_admin 普通管理员，merchant=商家，general_admin_default 默认普通管理员，merchant_default=默认商家',
  `group_name` varchar(20) NOT NULL DEFAULT '' COMMENT '权限组名称',
  `role_id` text COMMENT '权限id',
  `create_at` varchar(12) DEFAULT '' COMMENT '创建时间',
  `update_at` varchar(12) DEFAULT '' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='权限组';

-- ----------------------------
-- Records of union_module_atlas_group
-- ----------------------------
INSERT INTO `union_module_atlas_group` VALUES ('3', 'member_default', '默认用户', '1,18', '1583119415', '1583909796');
