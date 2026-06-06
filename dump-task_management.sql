/*
Navicat MySQL Data Transfer

Source Server         : localhost_3307
Source Server Version : 110409
Source Host           : localhost:3307
Source Database       : task_management

Target Server Type    : MYSQL
Target Server Version : 110409
File Encoding         : 65001

Date: 2026-06-06 09:56:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `mails_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `mails_tbl`;
CREATE TABLE `mails_tbl` (
  `mail_id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `receiver_id` int(11) NOT NULL,
  PRIMARY KEY (`mail_id`),
  KEY `mails_sender_idx` (`sender_id`),
  KEY `mails_receiver_idx` (`receiver_id`),
  KEY `mails_task_idx` (`task_id`),
  KEY `mails_created_at_idx` (`created_at`),
  CONSTRAINT `mails_receiver_fk` FOREIGN KEY (`receiver_id`) REFERENCES `users_tbl` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `mails_sender_fk` FOREIGN KEY (`sender_id`) REFERENCES `users_tbl` (`user_id`) ON DELETE CASCADE,
  CONSTRAINT `mails_task_fk` FOREIGN KEY (`task_id`) REFERENCES `tasks_tbl` (`task_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of mails_tbl
-- ----------------------------
INSERT INTO `mails_tbl` VALUES ('5', '6', '19', 'Haro! Aimu emu otori! Emu izu miiningu sumairu!', '1', '2026-06-05 22:00:29', '2026-06-05 21:58:58', '8');
INSERT INTO `mails_tbl` VALUES ('6', '8', '6', 'Say hi nibba', '0', null, '2026-06-05 22:12:03', '9');
INSERT INTO `mails_tbl` VALUES ('8', '8', '19', 'YOKOZOO!!', '1', '2026-06-06 01:13:30', '2026-06-05 22:17:42', '6');
INSERT INTO `mails_tbl` VALUES ('11', '8', '19', '⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣀⣀⣤⣄⣄⣠⣤⢄⣀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⢀⣠⣴⠿⠒⠛⠉⠉⠉⠉⠉⠛⠚⠯⣔⣢⢄⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⢀⣴⠷⠋⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠉⠳⣕⢄⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⣰⡿⠁⠀⠀⣠⠂⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⢷⣣⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⣼⡟⠀⠀⠀⣽⡇⢀⡏⠀⠀⠀⠀⠀⠀⢸⡀⢠⠀⠀⠀⠀⠀⢻⣧⠀⠀⠀⠀\r\n⠀⠀⢀⣼⡿⠀⠀⡀⡼⢹⢠⣿⢥⠀⠀⠀⣰⢀⡇⣼⣧⢈⡇⠀⠀⠀⠀⠈⣿⡆⠀⠀⠀\r\n⢯⣽⡟⢋⡤⠀⠀⣿⠃⣘⣉⣸⠀⠀⠀⢠⣟⣼⡿⠃⢸⣠⣿⠀⠀⠀⠀⠀⣹⣷⠀⠀⠀\r\n⠀⠙⢛⣿⠃⠀⠸⣿⣶⣿⠻⣿⡷⠀⠀⠈⠉⣙⣧⣦⣌⡉⢸⡄⠀⠀⠀⡀⠻⣟⣦⡀⠀\r\n⠀⠀⢸⣿⢠⠀⢀⣿⠃⢺⡟⢳⡿⠀⠀⠀⠀⣾⣩⡿⣾⢳⣼⡅⠀⡀⠀⣷⣦⣬⣽⣿⡇\r\n⠀⠀⠀⢿⣏⣇⠀⢿⡄⠀⠉⠉⠀⠀⠀⠀⠀⠻⣍⣉⡟⠘⣹⠀⢀⡇⠀⣿⣼⣷⠈⠁⠀\r\n⠀⠀⠀⠈⠻⣿⣆⠸⣿⣦⣀⠀⠀⢀⡀⠀⠀⠀⠈⠁⠀⣠⠇⢀⡼⠁⣰⣿⣿⠃⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠉⠯⢗⣿⣟⣿⣿⣶⣶⣬⠥⢤⣤⣴⣶⣾⠏⣠⣾⣱⣾⣿⠟⠁⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠉⣿⣿⣷⣿⣈⡙⣹⡿⣿⣿⣿⡾⢿⠿⠿⠋⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⢀⣾⢿⣯⢿⣿⣯⣿⣿⣿⡟⣽⢻⣧⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⢠⣿⣛⣾⡃⣹⣿⣷⣿⣿⡏⢻⣎⢯⢿⣦⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⣴⠿⣍⣽⣿⠹⣿⣿⣿⣿⣻⣯⠽⣻⣞⢯⣽⡆⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠘⠒⠋⣹⡿⣤⣟⣹⣿⣶⣾⣿⡤⣝⣿⣯⣨⡇⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠛⠿⠶⡟⠛⠛⢻⡟⢿⣽⣮⣽⡟⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢷⠀⠀⣻⡇⠀⠀⣿⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⠦⡴⣿⣧⣤⣤⡟⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀\r\n⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠘⠲⠾⣏⡿⣤⣼⠇⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀', '1', '2026-06-06 01:29:54', '2026-06-06 01:25:41', '6');

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
-- Table structure for `tags_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `tags_tbl`;
CREATE TABLE `tags_tbl` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of tags_tbl
-- ----------------------------
INSERT INTO `tags_tbl` VALUES ('2', 'Front End');
INSERT INTO `tags_tbl` VALUES ('3', 'Back End');
INSERT INTO `tags_tbl` VALUES ('4', 'Top Priority');
INSERT INTO `tags_tbl` VALUES ('5', 'Low Priority');
INSERT INTO `tags_tbl` VALUES ('6', 'Medium Priority');
INSERT INTO `tags_tbl` VALUES ('8', 'Project Management');

-- ----------------------------
-- Table structure for `tasks_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `tasks_tbl`;
CREATE TABLE `tasks_tbl` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(100) NOT NULL,
  `task_description` varchar(100) NOT NULL,
  `task_status` int(11) NOT NULL DEFAULT 1,
  `task_attachment` varchar(255) DEFAULT NULL,
  `task_submit` varchar(255) DEFAULT NULL,
  `submission_text` text DEFAULT NULL,
  `submitted_by` varchar(255) DEFAULT '',
  `submitted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of tasks_tbl
-- ----------------------------
INSERT INTO `tasks_tbl` VALUES ('4', 'A New Task', 'Tasky', '3', null, '', null, null, null);
INSERT INTO `tasks_tbl` VALUES ('5', 'Test Task Number 2', 'Another Test Task', '2', '1780642895_442065560617091072.png', null, null, null, null);
INSERT INTO `tasks_tbl` VALUES ('6', 'Hellooooo', 'Hello Task', '3', null, '', null, null, null);
INSERT INTO `tasks_tbl` VALUES ('7', 'Omaygot', 'Ambatunat', '4', '1780564274_bitches_be_like.gif', '', null, null, null);
INSERT INTO `tasks_tbl` VALUES ('11', 'Deersicle', '._.', '1', '1780643052_ravenscriptprogrammer.png', null, 'Ambatukamuuuuu', 'Mark Unremarkable', '2026-06-06 09:54:36');
INSERT INTO `tasks_tbl` VALUES ('19', 'Give me Wonderhoi!!', 'SMIILLEEEEEEEEEe', '1', '', '1780488171_smayyllll.jpg', 'HANLOOO IM EMU TORI!!!', 'Mark Unremarkable', '2026-06-03 20:02:51');
INSERT INTO `tasks_tbl` VALUES ('22', 'k', 'Letter k', '1', '', '', null, '', null);

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
INSERT INTO `task_members_tbl` VALUES ('22', '7');
INSERT INTO `task_members_tbl` VALUES ('19', '6');
INSERT INTO `task_members_tbl` VALUES ('19', '7');
INSERT INTO `task_members_tbl` VALUES ('7', '7');
INSERT INTO `task_members_tbl` VALUES ('5', '6');
INSERT INTO `task_members_tbl` VALUES ('5', '9');
INSERT INTO `task_members_tbl` VALUES ('11', '6');
INSERT INTO `task_members_tbl` VALUES ('11', '7');
INSERT INTO `task_members_tbl` VALUES ('11', '10');
INSERT INTO `task_members_tbl` VALUES ('6', '9');
INSERT INTO `task_members_tbl` VALUES ('4', '10');

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
-- Table structure for `task_tags_tbl`
-- ----------------------------
DROP TABLE IF EXISTS `task_tags_tbl`;
CREATE TABLE `task_tags_tbl` (
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `task_tag_tbl_tasks_tbl_FK` (`task_id`),
  KEY `task_tag_tbl_tags_tbl_FK` (`tag_id`),
  CONSTRAINT `task_tag_tbl_tags_tbl_FK` FOREIGN KEY (`tag_id`) REFERENCES `tags_tbl` (`tag_id`) ON DELETE CASCADE,
  CONSTRAINT `task_tag_tbl_tasks_tbl_FK` FOREIGN KEY (`task_id`) REFERENCES `tasks_tbl` (`task_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of task_tags_tbl
-- ----------------------------
INSERT INTO `task_tags_tbl` VALUES ('22', '2');
INSERT INTO `task_tags_tbl` VALUES ('22', '4');
INSERT INTO `task_tags_tbl` VALUES ('19', '3');
INSERT INTO `task_tags_tbl` VALUES ('19', '4');
INSERT INTO `task_tags_tbl` VALUES ('7', '3');
INSERT INTO `task_tags_tbl` VALUES ('7', '4');
INSERT INTO `task_tags_tbl` VALUES ('5', '6');
INSERT INTO `task_tags_tbl` VALUES ('5', '8');
INSERT INTO `task_tags_tbl` VALUES ('11', '3');
INSERT INTO `task_tags_tbl` VALUES ('11', '6');
INSERT INTO `task_tags_tbl` VALUES ('6', '2');
INSERT INTO `task_tags_tbl` VALUES ('6', '4');
INSERT INTO `task_tags_tbl` VALUES ('6', '8');
INSERT INTO `task_tags_tbl` VALUES ('4', '5');
INSERT INTO `task_tags_tbl` VALUES ('4', '8');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of users_tbl
-- ----------------------------
INSERT INTO `users_tbl` VALUES ('5', 'Joshua Smith', 'joshsmith', 'joshsmith@email.com', '$2y$10$qB8QbYFVEvVjP5Z2LzIVX.EzuAVeHE3EI2zj1tveo8iFqoO1u2/BC', '1', 'houoyoyo', 'user_5_1780576110.png');
INSERT INTO `users_tbl` VALUES ('6', 'Mark Unremarkable', 'unremarkable', 'unremarkable@mail.com', '$2y$10$qWHTcuaDvYjguctTpvbXD.Lm1i9klWeLh1O9Jz32c/SWphPPQ.va6', '2', 'hiiii', 'user_6_1780552713.png');
INSERT INTO `users_tbl` VALUES ('7', 'Mark Edward Fischbach', 'markiplier', 'mynameiswelcome@yahoo.com', '$2y$10$SzppkHZa5glGDrXyVuvcMuLDWo6X3d4Gh950CP3yVWGdvaKAQgWZG', '2', 'im dead', 'user_7_1780552723.png');
INSERT INTO `users_tbl` VALUES ('8', 'Emu otori', 'emu', 'taeko@gmail.com', '$2y$10$aIinf8tfTtJmv.2aPztPsujmzHtyFnHXY15OcRtBCBIWyABSsAfg2', '1', 'hii', 'user_8_1780552705.jpg');
INSERT INTO `users_tbl` VALUES ('9', 'Clark Kent', 'clark1990', 'furnitureguy@gmail.com', '$2y$10$32jItM47DD/zXVrnK2HlSuxUgLvPPuIE2PDzHgpkiEm9kg/my0IBu', '2', 'Rahhhh', 'user_9_1780642847.jpg');
INSERT INTO `users_tbl` VALUES ('10', 'Sheldon Cooper', 'sheldonc', 'hotdensestate@gmail.com', '$2y$10$sdykjjYnYnMbGsPX90MMNetNd6/yMAIQZimjqEAw9gZei1Y5zwCX2', '2', 'The Big Bang Theory', 'user_10_1780648351.png');
