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
INSERT INTO `task_members_tbl` VALUES (11,6),(11,7);
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
  `task_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks_tbl`
--

LOCK TABLES `tasks_tbl` WRITE;
/*!40000 ALTER TABLE `tasks_tbl` DISABLE KEYS */;
INSERT INTO `tasks_tbl` VALUES (4,'A New Task','Tasky',1,NULL),(5,'Test Task Number 2','Another Test Task',2,NULL),(6,'Hellooooo','Hello Task',3,NULL),(7,'Omaygot','Ambatunat',4,NULL),(11,'Deersicle','._.',2,'1780300825_271896231_4612278378871284_3144924739189579948_n.jpg');
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
INSERT INTO `users_tbl` VALUES (5,'Joshua Smith','joshsmith','joshsmith@email.com','$2y$10$hIi7a/1HZXfxoDVhAKNiNOyvsVQ7NRRfvUOQaJZEeYtEv/WVX7Yq2',1,'houoyoyo','uploads/profiles/user_5_1780251807.png'),(6,'Mark Unremarkable','unremarkable','unremarkable@mail.com','$2y$10$sO190L0WuthS//le3wrbU.S2cjnws81AQ7JahLJyX8z2YoilEYm9q',2,'hii','uploads/profiles/user_6_1780251951.png'),(7,'Mark Edward Fischbach','markiplier','mynameiswelcome@yahoo.com','$2y$10$SzppkHZa5glGDrXyVuvcMuLDWo6X3d4Gh950CP3yVWGdvaKAQgWZG',2,'im dead','uploads/profiles/user_7_1780252012.png'),(8,'Emu otori','emu','taeko@gmail.com','$2y$10$jaeLQfCvXhJNLL.2X0zcaec.dTaYs.bhOML0A2/9QR/9ofsxkPPfq',1,'hii','uploads/profiles/user_8_1780282683.jpg');
/*!40000 ALTER TABLE `users_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'task_management'
--
