-- MariaDB dump 10.17  Distrib 10.4.8-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cuestionario
-- ------------------------------------------------------
-- Server version	10.4.8-MariaDB

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
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` int(11) NOT NULL,
  `test_number` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `answers`
--

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partials`
--

DROP TABLE IF EXISTS `partials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `abbreviation` varchar(250) NOT NULL,
  `comment` varchar(250) NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partials`
--

LOCK TABLES `partials` WRITE;
/*!40000 ALTER TABLE `partials` DISABLE KEYS */;
INSERT INTO `partials` VALUES (1,'2020-03-09','2020-03-11','2020-1','Partial for students',1),(7,'2020-07-29','2020-07-27','2020-1','Semester phd',1);
/*!40000 ALTER TABLE `partials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `question` text NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,2,'Puntual','it\'s on time in the class room?',1),(3,2,'Puntual','Is helpfull?',1),(12,8,'Productivity','Waste time',1);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) NOT NULL,
  `career` varchar(250) NOT NULL,
  `grade` varchar(50) NOT NULL,
  `groupp` int(11) NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Artificial Intelligence','Systems','9',3,1),(3,'Intranets','Systems','4',2,1),(10,'Processors','Software','7',4,1);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `comment` text NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES (2,'Evaluation 1 semester','Comment',1),(8,'Evaluation 2 Semester','Students Phd',1);
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `fathers_last_name` varchar(50) NOT NULL,
  `mothers_last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,'123456','John','Doe','Johnson','johndoe@email.com',1),(22,'45986315-55','Sammy','Smithers','Does','samsmith@email.com',1);
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tests`
--

DROP TABLE IF EXISTS `tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `partial_id` int(11) NOT NULL,
  `questionnaires_total` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tests`
--

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` VALUES (1,2,1,1,1,31,'AE50S5',1),(10,2,1,1,1,11,'3698EA',1);
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(250) NOT NULL,
  `mothers_last_name` varchar(50) NOT NULL,
  `fathers_last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `last_change` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'15','$argon2i$v=19$m=65536,t=4,p=1$alp5Qm1pd2dvSkM0M0xSRQ$w+ipqvaKrIYu3xyKL4wPzetNkiBvdQQGCc24B/ZdXnc','Johnathan','Smith','Doe','johnatan_doe@email.es','superadmin',0),(2,'5451-5','$argon2i$v=19$m=65536,t=4,p=1$MzRGQjZGTWpDU0VTV250NQ$EU/FDzOcYsTJacpgfRDgYbmk6yWgepLHMU4fUGytAis','Sam','Gonzales','Melendez','admin@admin.com','admin',1),(8,'121950450-13','$argon2i$v=19$m=65536,t=4,p=1$d0ZNVjB3Lmoya01BZ2wwMQ$lh27eZRm49auy/Yq243AapmphTNb0SCVU3P0iX9LIeQ','Stephen','Tesla','Edison','email@emai.com','editor',1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-01 20:54:25
