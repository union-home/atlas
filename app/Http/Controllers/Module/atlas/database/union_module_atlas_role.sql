/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : atlas

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2020-04-26 13:37:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `union_module_atlas_role`
-- ----------------------------
DROP TABLE IF EXISTS `union_module_atlas_role`;
CREATE TABLE `union_module_atlas_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '用户uid',
  `group_id` int(11) NOT NULL COMMENT '权限组id',
  `time` varchar(12) DEFAULT '' COMMENT '时间戳',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户权限表';

-- ----------------------------
-- Records of union_module_atlas_role
-- ----------------------------
