/*
Navicat MySQL Data Transfer

Source Server         : localhost_3307
Source Server Version : 110409
Source Host           : localhost:3307
Source Database       : task_management

Target Server Type    : MYSQL
Target Server Version : 110409
File Encoding         : 65001

Date: 2026-06-01 07:22:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `roles_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `roles_tbl`;
CREATE TABLE `roles_tbl` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of roles_tbl
-- ----------------------------
INSERT INTO `roles_tbl` VALUES ('1', 'Admin');
INSERT INTO `roles_tbl` VALUES ('2', 'Member');

-- ----------------------------
-- Table structure for `tasks_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `tasks_tbl`;
CREATE TABLE `tasks_tbl` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(100) NOT NULL,
  `task_description` varchar(100) NOT NULL,
  `task_status` int(11) NOT NULL DEFAULT 1,
  `task_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of tasks_tbl
-- ----------------------------
INSERT INTO `tasks_tbl` VALUES ('4', 'A New Task', 'Tasky', '1', null);
INSERT INTO `tasks_tbl` VALUES ('5', 'Test Task Number 2', 'Another Test Task', '2', null);
INSERT INTO `tasks_tbl` VALUES ('6', 'Hellooooo', 'Hello Task', '3', null);
INSERT INTO `tasks_tbl` VALUES ('7', 'Omaygot', 'Ambatunat', '4', null);
INSERT INTO `tasks_tbl` VALUES ('11', 'Deersicle', '._.', '1', null);
INSERT INTO `tasks_tbl` VALUES ('12', 'GAYVIN BASKETBALL', 'sjihais;kahSAKnaKND.MAN,MNDA,', '2', '1780269383_2024_Acer_Consumer_Default_3840x2400.jpg');

-- ----------------------------
-- Table structure for `task_members_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `task_members_tbl`;
CREATE TABLE `task_members_tbl` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `task_members_tbl_users_tbl_FK` (`user_id`),
  KEY `task_members_tbl_tasks_tbl_FK` (`task_id`),
  CONSTRAINT `task_members_tbl_tasks_tbl_FK` FOREIGN KEY (`task_id`) REFERENCES `tasks_tbl` (`task_id`) ON DELETE CASCADE,
  CONSTRAINT `task_members_tbl_users_tbl_FK` FOREIGN KEY (`user_id`) REFERENCES `users_tbl` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of task_members_tbl
-- ----------------------------
INSERT INTO `task_members_tbl` VALUES ('11', '6');
INSERT INTO `task_members_tbl` VALUES ('11', '7');
INSERT INTO `task_members_tbl` VALUES ('12', '6');
INSERT INTO `task_members_tbl` VALUES ('12', '7');

-- ----------------------------
-- Table structure for `task_status_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `task_status_tbl`;
CREATE TABLE `task_status_tbl` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of task_status_tbl
-- ----------------------------
INSERT INTO `task_status_tbl` VALUES ('1', 'Pending');
INSERT INTO `task_status_tbl` VALUES ('2', 'In-Progress');
INSERT INTO `task_status_tbl` VALUES ('3', 'Complete');
INSERT INTO `task_status_tbl` VALUES ('4', 'Incomplete');

-- ----------------------------
-- Table structure for `users_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `users_tbl`;
CREATE TABLE `users_tbl` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
  `bio` varchar(255) DEFAULT NULL,
  `profile` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of users_tbl
-- ----------------------------
INSERT INTO `users_tbl` VALUES ('5', 'Joshua Smith', 'joshsmith', 'joshsmith@email.com', '$2y$10$hIi7a/1HZXfxoDVhAKNiNOyvsVQ7NRRfvUOQaJZEeYtEv/WVX7Yq2', '1', 'test', 'uploads/profiles/user_5_1780251807.png');
INSERT INTO `users_tbl` VALUES ('6', 'Mark Unremarkable', 'unremarkable', 'unremarkable@mail.com', '$2y$10$sO190L0WuthS//le3wrbU.S2cjnws81AQ7JahLJyX8z2YoilEYm9q', '2', 'test', 'uploads/profiles/user_6_1780251951.png');
INSERT INTO `users_tbl` VALUES ('7', 'Mark Edward Fischbach', 'markiplier', 'mynameiswelcome@yahoo.com', '$2y$10$SzppkHZa5glGDrXyVuvcMuLDWo6X3d4Gh950CP3yVWGdvaKAQgWZG', '2', 'test', 'uploads/profiles/user_7_1780252012.png');
