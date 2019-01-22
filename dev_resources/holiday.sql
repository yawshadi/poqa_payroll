/*
 Navicat Premium Data Transfer

 Source Server         : home
 Source Server Type    : MySQL
 Source Server Version : 50633
 Source Host           : localhost:3306
 Source Schema         : payroll

 Target Server Type    : MySQL
 Target Server Version : 50633
 File Encoding         : 65001

 Date: 22/01/2019 21:06:55
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for holiday
-- ----------------------------
DROP TABLE IF EXISTS `holiday`;
CREATE TABLE `holiday`  (
  `holidayid` int(11) NOT NULL AUTO_INCREMENT,
  `holidayname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `holidaydate` date DEFAULT NULL,
  PRIMARY KEY (`holidayid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of holiday
-- ----------------------------
INSERT INTO `holiday` VALUES (1, 'New Year\'s Day', '2019-01-01');
INSERT INTO `holiday` VALUES (2, 'Constitution Day', '2019-01-07');
INSERT INTO `holiday` VALUES (3, 'Indepdendence Day', '2019-03-06');
INSERT INTO `holiday` VALUES (4, 'Good Friday', '2019-03-30');
INSERT INTO `holiday` VALUES (5, 'Easter Sunday', '2019-04-01');
INSERT INTO `holiday` VALUES (6, 'Easter Monday', '2019-04-02');
INSERT INTO `holiday` VALUES (7, 'May Day', '2019-05-01');
INSERT INTO `holiday` VALUES (8, 'African Union Day', '2019-05-25');
INSERT INTO `holiday` VALUES (9, 'Id ul Fitr', '2019-06-15');
INSERT INTO `holiday` VALUES (10, 'Republic Day', '2019-07-01');
INSERT INTO `holiday` VALUES (11, 'Id ul Adha', '2019-08-21');
INSERT INTO `holiday` VALUES (12, 'Founder\'s Day', '2019-09-01');
INSERT INTO `holiday` VALUES (13, 'Farmer\'s Day', '2019-09-07');
INSERT INTO `holiday` VALUES (14, 'Christmas Day', '2019-12-25');
INSERT INTO `holiday` VALUES (15, 'Boxing Day', '2019-12-26');

SET FOREIGN_KEY_CHECKS = 1;
