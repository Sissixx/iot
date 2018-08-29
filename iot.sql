/*
Navicat MySQL Data Transfer

Source Server         : phptp5
Source Server Version : 50721
Source Host           : localhost:3306
Source Database       : iot

Target Server Type    : MYSQL
Target Server Version : 50721
File Encoding         : 65001

Date: 2018-08-13 10:46:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `iot_admin`
-- ----------------------------
DROP TABLE IF EXISTS `iot_admin`;
CREATE TABLE `iot_admin` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '管理员ID',
  `admin_name` varchar(20) NOT NULL COMMENT '管理员账号',
  `admin_password` varchar(32) NOT NULL COMMENT '管理员密码',
  `admin_nickname` varchar(20) NOT NULL COMMENT '管理员昵称',
  `admin_role` enum('1','0') NOT NULL DEFAULT '0' COMMENT '0普通管理员 1超级管理员',
  `admin_telephone` char(11) NOT NULL COMMENT '管理员手机号',
  `admin_email` varchar(50) NOT NULL COMMENT '管理员邮箱',
  `admin_status` enum('2','1','0') NOT NULL DEFAULT '1' COMMENT '0 禁用 1正常 2异常',
  `create_time` bigint(20) NOT NULL COMMENT '创建时间',
  `update_time` bigint(20) DEFAULT NULL COMMENT '更新时间',
  `delete_time` bigint(20) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_admin
-- ----------------------------
INSERT INTO `iot_admin` VALUES ('1', 'admin01', '1', 'admin1111', '1', '15159291818', '123456@qq.com', '1', '1', '1534092915', null);
INSERT INTO `iot_admin` VALUES ('7', '2', '2', '2123123', '1', '2123', '1212', '1', '1', '1533954749', '1533954751');
INSERT INTO `iot_admin` VALUES ('9', '1', '2', 'admin12', '0', '15159292020', '1154524309@qq.com', '1', '1533790601', '1534090704', null);
INSERT INTO `iot_admin` VALUES ('10', '121212', '1', '1', '0', '15159291818', '904880789@qq.com', '1', '1533791067', '1534090748', null);
INSERT INTO `iot_admin` VALUES ('11', '123', '123', '123123', '1', '123123', '1154524309@qq.com', '1', '1533866195', '1533869492', '1533953245');
INSERT INTO `iot_admin` VALUES ('12', '124', '124', '124', '1', '15159291018', '1154524309@qq.com', '1', '1533866321', '1534091211', '1534093584');
INSERT INTO `iot_admin` VALUES ('13', '125', '125', '125', '1', '125', '12', '1', '1', null, '1533953252');
INSERT INTO `iot_admin` VALUES ('15', '126', '125', '125', '0', '125', '12', '1', '1', null, '1534081606');
INSERT INTO `iot_admin` VALUES ('16', '127', '123', '123', '0', '123', '123', '1', '123', null, '1534081520');
INSERT INTO `iot_admin` VALUES ('17', '129', '123', '123', '1', '15159291818', '123@qq.com', '1', '1533885443', '1533885443', '1533953284');
INSERT INTO `iot_admin` VALUES ('18', '131', '131', '131', '1', '15159291819', '904880780@qq.com', '1', '1533953319', '1533953319', null);
INSERT INTO `iot_admin` VALUES ('19', '132', '132', '132', '0', '15159291820', '904880720@qq.com', '0', '1533953440', '1533953440', '1534081505');
INSERT INTO `iot_admin` VALUES ('20', '133', '133', '133', '1', '15159291821', '904880721@qq.com', '1', '1533953539', '1533953539', '1534128135');
INSERT INTO `iot_admin` VALUES ('25', '123', '123', '12', '0', '15159291818', '15@qq.com', '1', '1534082432', '1534090695', null);
INSERT INTO `iot_admin` VALUES ('26', '141', '141', '141', '0', '15159291818', '99@qq.com', '1', '1534091279', '1534091279', null);

-- ----------------------------
-- Table structure for `iot_device`
-- ----------------------------
DROP TABLE IF EXISTS `iot_device`;
CREATE TABLE `iot_device` (
  `device_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '设备ID',
  `supplier_id` int(10) NOT NULL COMMENT '外键',
  `device_name` varchar(50) NOT NULL COMMENT '设备名称',
  `device_location` varchar(100) DEFAULT NULL COMMENT '设备所在地点',
  `device_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '0离线 1在线',
  `device_agreement` varchar(100) DEFAULT '' COMMENT '协议',
  `create_time` bigint(20) NOT NULL COMMENT '创建时间',
  `update_time` bigint(20) DEFAULT NULL COMMENT '更新时间',
  `delete_time` bigint(20) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`device_id`),
  KEY `FK_ID` (`supplier_id`),
  CONSTRAINT `iot_device_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `iot_supplier` (`supplier_id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_device
-- ----------------------------
INSERT INTO `iot_device` VALUES ('2', '1', '12', '12', '0', '12', '1533810782', '1533810782', '1533811056');
INSERT INTO `iot_device` VALUES ('4', '1', '12', '12', '0', '1', '1533869609', '1533869609', '1533869612');
INSERT INTO `iot_device` VALUES ('5', '1', '1', '1', '0', '1', '1533869625', '1533869625', null);
INSERT INTO `iot_device` VALUES ('6', '1', '2', '2', '0', '2', '1533869632', '1533869632', null);
INSERT INTO `iot_device` VALUES ('7', '1', '3', '3', '0', '3', '1533869637', '1533869637', '1533870771');
INSERT INTO `iot_device` VALUES ('10', '1', '4', '4', '0', '4', '1533869648', '1533869648', '1533870776');
INSERT INTO `iot_device` VALUES ('11', '1', '12', '12', '0', '12', '1533879776', '1533879776', null);

-- ----------------------------
-- Table structure for `iot_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `iot_supplier`;
CREATE TABLE `iot_supplier` (
  `supplier_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '设备ID',
  `supplier_name` varchar(50) NOT NULL COMMENT '设备名称',
  `contact_name` varchar(20) NOT NULL COMMENT '联系人名称',
  `contact_email` varchar(50) DEFAULT NULL COMMENT '联系人邮箱',
  `contact_tel` char(11) DEFAULT NULL COMMENT '联系人手机号',
  `contact_phone` varchar(12) DEFAULT NULL COMMENT '联系人电话',
  `create_time` bigint(20) NOT NULL COMMENT '创建时间',
  `update_time` bigint(20) DEFAULT NULL COMMENT '更新时间',
  `delete_time` bigint(20) DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iot_supplier
-- ----------------------------
INSERT INTO `iot_supplier` VALUES ('1', '1', '1', '1', '1', '1', '1', null, null);
INSERT INTO `iot_supplier` VALUES ('2', '1233123', '2', '2', '2', '2', '2', '1533919259', null);
INSERT INTO `iot_supplier` VALUES ('3', '3', '3', '3', '3', '3', '3', null, null);
