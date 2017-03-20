/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 100121
Source Host           : localhost:3306
Source Database       : zadanie1

Target Server Type    : MYSQL
Target Server Version : 100121
File Encoding         : 65001

Date: 2017-03-20 14:07:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for devicechangelogs
-- ----------------------------
DROP TABLE IF EXISTS `devicechangelogs`;
CREATE TABLE `devicechangelogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `device_id` int(11) DEFAULT NULL,
  `flag_id` int(255) DEFAULT '0',
  `ipaddr` varchar(16) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `device_id` (`device_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of devicechangelogs
-- ----------------------------
INSERT INTO `devicechangelogs` VALUES ('45', '37', '0', '127.0.0.1', '2017-03-20 11:59:41');
INSERT INTO `devicechangelogs` VALUES ('46', '37', '1', '127.0.0.1', '2017-03-20 12:04:19');
INSERT INTO `devicechangelogs` VALUES ('47', '37', '0', '127.0.0.1', '2017-03-20 12:05:19');
INSERT INTO `devicechangelogs` VALUES ('48', '37', '1', '127.0.0.1', '2017-03-20 12:06:36');
INSERT INTO `devicechangelogs` VALUES ('49', '37', '0', '127.0.0.1', '2017-03-20 12:08:46');
INSERT INTO `devicechangelogs` VALUES ('50', '37', '1', '127.0.0.1', '2017-03-20 12:11:20');
INSERT INTO `devicechangelogs` VALUES ('51', '37', '4', '127.0.0.1', '2017-03-20 12:11:55');

-- ----------------------------
-- Table structure for devices
-- ----------------------------
DROP TABLE IF EXISTS `devices`;
CREATE TABLE `devices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(255) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_time` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `ipaddr` varchar(16) DEFAULT NULL,
  `last_state` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`serial_number`),
  UNIQUE KEY `serial_number` (`serial_number`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of devices
-- ----------------------------
INSERT INTO `devices` VALUES ('37', '190', '2017-03-20 10:21:26', '2017-03-20 12:11:55', '127.0.0.1', '4');
INSERT INTO `devices` VALUES ('38', '91', '2017-03-20 10:21:27', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('39', '39', '2017-03-20 10:21:28', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('40', '161', '2017-03-20 10:21:30', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('41', '86', '2017-03-20 10:21:31', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('42', '7', '2017-03-20 10:21:32', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('58', '194', '2017-03-20 10:36:44', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('60', '171', '2017-03-20 10:40:43', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('61', '147', '2017-03-20 10:40:45', '0000-00-00 00:00:00', '127.0.0.1', null);
INSERT INTO `devices` VALUES ('62', '67', '2017-03-20 10:40:47', '0000-00-00 00:00:00', '127.0.0.1', null);

-- ----------------------------
-- Table structure for flags
-- ----------------------------
DROP TABLE IF EXISTS `flags`;
CREATE TABLE `flags` (
  `id` tinyint(3) unsigned NOT NULL,
  `name` varchar(21) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of flags
-- ----------------------------
INSERT INTO `flags` VALUES ('0', 'DEKOMPLETACJA');
INSERT INTO `flags` VALUES ('1', 'TESTOWANIE_USZKODZONY');
INSERT INTO `flags` VALUES ('2', 'TESTOWANIE_SPRAWNY');
INSERT INTO `flags` VALUES ('3', 'WYMIANA_OBUDOWY');
INSERT INTO `flags` VALUES ('4', 'PAKOWANIE_USZKODZONY');
INSERT INTO `flags` VALUES ('5', 'CZYSZCZENIE');
INSERT INTO `flags` VALUES ('6', 'PAKOWANIE');

-- ----------------------------
-- Table structure for process_tree
-- ----------------------------
DROP TABLE IF EXISTS `process_tree`;
CREATE TABLE `process_tree` (
  `id` int(11) DEFAULT NULL,
  `process_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of process_tree
-- ----------------------------
INSERT INTO `process_tree` VALUES ('0', '-1');
INSERT INTO `process_tree` VALUES ('1', '0');
INSERT INTO `process_tree` VALUES ('2', '0');
INSERT INTO `process_tree` VALUES ('3', '2');
INSERT INTO `process_tree` VALUES ('4', '1');
INSERT INTO `process_tree` VALUES ('5', '2');
INSERT INTO `process_tree` VALUES ('6', '3');
INSERT INTO `process_tree` VALUES ('6', '5');
INSERT INTO `process_tree` VALUES ('6', '-1');
SET FOREIGN_KEY_CHECKS=1;
