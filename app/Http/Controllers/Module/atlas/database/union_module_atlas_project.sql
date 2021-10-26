/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50718
Source Host           : localhost:3306
Source Database       : atlas

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2020-04-26 13:37:20
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `union_module_atlas_project`
-- ----------------------------
DROP TABLE IF EXISTS `union_module_atlas_project`;
CREATE TABLE `union_module_atlas_project` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `tig` varchar(30) NOT NULL DEFAULT '' COMMENT '项目标识',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '项目名称',
  `describe` text COMMENT '项目描述',
  `create_at` datetime DEFAULT NULL COMMENT '创建时间',
  `update_at` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='项目表';

-- ----------------------------
-- Records of union_module_atlas_project
-- ----------------------------
INSERT INTO `union_module_atlas_project` VALUES ('1', 'alcohol', '全国酒水', '<p>全国酒水项目流程图</p><p><br></p>', '2020-04-26 11:03:13', '1587870914');
