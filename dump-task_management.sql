-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: task_management
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `roles_tbl`
--

DROP TABLE IF EXISTS `roles_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles_tbl` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_tbl`
--

LOCK TABLES `roles_tbl` WRITE;
/*!40000 ALTER TABLE `roles_tbl` DISABLE KEYS */;
INSERT INTO `roles_tbl` VALUES (1,'Admin'),(2,'Member');
/*!40000 ALTER TABLE `roles_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags_tbl`
--

DROP TABLE IF EXISTS `tags_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags_tbl` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags_tbl`
--

LOCK TABLES `tags_tbl` WRITE;
/*!40000 ALTER TABLE `tags_tbl` DISABLE KEYS */;
INSERT INTO `tags_tbl` VALUES (2,'Front End'),(3,'Back End'),(4,'Top Priority'),(5,'Low Priority'),(6,'Medium Priority');
/*!40000 ALTER TABLE `tags_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_members_tbl`
--

DROP TABLE IF EXISTS `task_members_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_members_tbl` (
  `task_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `task_members_tbl_users_tbl_FK` (`user_id`),
  KEY `task_members_tbl_tasks_tbl_FK` (`task_id`),
  CONSTRAINT `task_members_tbl_tasks_tbl_FK` FOREIGN KEY (`task_id`) REFERENCES `tasks_tbl` (`task_id`) ON DELETE CASCADE,
  CONSTRAINT `task_members_tbl_users_tbl_FK` FOREIGN KEY (`user_id`) REFERENCES `users_tbl` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_members_tbl`
--

LOCK TABLES `task_members_tbl` WRITE;
/*!40000 ALTER TABLE `task_members_tbl` DISABLE KEYS */;
INSERT INTO `task_members_tbl` VALUES (22,7),(19,6),(19,7),(11,6),(11,7),(7,7);
/*!40000 ALTER TABLE `task_members_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_status_tbl`
--

DROP TABLE IF EXISTS `task_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_status_tbl` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_status_tbl`
--

LOCK TABLES `task_status_tbl` WRITE;
/*!40000 ALTER TABLE `task_status_tbl` DISABLE KEYS */;
INSERT INTO `task_status_tbl` VALUES (1,'Pending'),(2,'In-Progress'),(3,'Complete'),(4,'Incomplete');
/*!40000 ALTER TABLE `task_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `task_tags_tbl`
--

DROP TABLE IF EXISTS `task_tags_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_tags_tbl` (
  `task_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `task_tag_tbl_tasks_tbl_FK` (`task_id`),
  KEY `task_tag_tbl_tags_tbl_FK` (`tag_id`),
  CONSTRAINT `task_tag_tbl_tags_tbl_FK` FOREIGN KEY (`tag_id`) REFERENCES `tags_tbl` (`tag_id`) ON DELETE CASCADE,
  CONSTRAINT `task_tag_tbl_tasks_tbl_FK` FOREIGN KEY (`task_id`) REFERENCES `tasks_tbl` (`task_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_tags_tbl`
--

LOCK TABLES `task_tags_tbl` WRITE;
/*!40000 ALTER TABLE `task_tags_tbl` DISABLE KEYS */;
INSERT INTO `task_tags_tbl` VALUES (22,2),(22,4),(19,3),(19,4),(11,3),(11,6),(7,3),(7,4);
/*!40000 ALTER TABLE `task_tags_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks_tbl`
--

DROP TABLE IF EXISTS `tasks_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks_tbl`
--

LOCK TABLES `tasks_tbl` WRITE;
/*!40000 ALTER TABLE `tasks_tbl` DISABLE KEYS */;
INSERT INTO `tasks_tbl` VALUES (4,'A New Task','Tasky',4,NULL,'',NULL,NULL,NULL),(5,'Test Task Number 2','Another Test Task',2,NULL,'',NULL,NULL,NULL),(6,'Hellooooo','Hello Task',3,NULL,'',NULL,NULL,NULL),(7,'Omaygot','Ambatunat',4,'1780564274_bitches_be_like.gif','',NULL,NULL,NULL),(11,'Deersicle','._.',3,'','1780425688_zz.jpg','hello po','Mark Unremarkable','2026-06-03 02:41:28'),(19,'Give me Wonderhoi!!','SMIILLEEEEEEEEEe',1,'','1780488171_smayyllll.jpg','HANLOOO IM EMU TORI!!!','Mark Unremarkable','2026-06-03 20:02:51'),(22,'k','Letter k',1,'','',NULL,'',NULL);
/*!40000 ALTER TABLE `tasks_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_tbl`
--

DROP TABLE IF EXISTS `users_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_tbl`
--

LOCK TABLES `users_tbl` WRITE;
/*!40000 ALTER TABLE `users_tbl` DISABLE KEYS */;
INSERT INTO `users_tbl` VALUES (5,'Joshua Smith','joshsmith','joshsmith@email.com','$2y$10$qB8QbYFVEvVjP5Z2LzIVX.EzuAVeHE3EI2zj1tveo8iFqoO1u2/BC',1,'houoyoyo','user_5_1780567856.png'),(6,'Mark Unremarkable','unremarkable','unremarkable@mail.com','$2y$10$qWHTcuaDvYjguctTpvbXD.Lm1i9klWeLh1O9Jz32c/SWphPPQ.va6',2,'hiiii','user_6_1780552713.png'),(7,'Mark Edward Fischbach','markiplier','mynameiswelcome@yahoo.com','$2y$10$SzppkHZa5glGDrXyVuvcMuLDWo6X3d4Gh950CP3yVWGdvaKAQgWZG',2,'im dead','user_7_1780552723.png'),(8,'Emu otori','emu','taeko@gmail.com','$2y$10$aIinf8tfTtJmv.2aPztPsujmzHtyFnHXY15OcRtBCBIWyABSsAfg2',1,'hii','user_8_1780552705.jpg');
/*!40000 ALTER TABLE `users_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'task_management'
--
