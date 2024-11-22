CREATE DATABASE  IF NOT EXISTS `esguerradb` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `esguerradb`;
-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: esguerradb
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attendance`
--

DROP TABLE IF EXISTS `attendance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendance` (
  `attendance_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendance`
--

LOCK TABLES `attendance` WRITE;
/*!40000 ALTER TABLE `attendance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attendance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  PRIMARY KEY (`department_id`),
  KEY `fk_teacher` (`teacher_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gradesheet`
--

DROP TABLE IF EXISTS `gradesheet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gradesheet` (
  `gradesheet_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `section_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `written_work_id` int DEFAULT NULL,
  `performance_task_id` int DEFAULT NULL,
  `quaterassessment_id` int DEFAULT NULL,
  `attendance_id` int DEFAULT NULL,
  `quarter_status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`gradesheet_id`),
  KEY `student_id` (`student_id`),
  KEY `section_id` (`section_id`),
  KEY `department_id` (`department_id`),
  KEY `written_work_id` (`written_work_id`),
  KEY `performance_task_id` (`performance_task_id`),
  KEY `quaterassessment_id` (`quaterassessment_id`),
  KEY `attendance_id` (`attendance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gradesheet`
--

LOCK TABLES `gradesheet` WRITE;
/*!40000 ALTER TABLE `gradesheet` DISABLE KEYS */;
/*!40000 ALTER TABLE `gradesheet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parents`
--

DROP TABLE IF EXISTS `parents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `parents` (
  `parent_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NULL,
  `contact.no` int NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NULL,
  `student_id` int NULL,
  PRIMARY KEY (`parent_id`),
  KEY `fk_students` (`student_id`),
  CONSTRAINT `fk_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parents`
--

LOCK TABLES `parents` WRITE;
/*!40000 ALTER TABLE `parents` DISABLE KEYS */;
/*!40000 ALTER TABLE `parents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performancetask`
--

DROP TABLE IF EXISTS `performancetask`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `performancetask` (
  `performance_task_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `gradesheet_id` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `max_score` int DEFAULT NULL,
  PRIMARY KEY (`performance_task_id`),
  KEY `student_id` (`student_id`),
  KEY `department_id` (`department_id`),
  KEY `gradesheet_id` (`gradesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performancetask`
--

LOCK TABLES `performancetask` WRITE;
/*!40000 ALTER TABLE `performancetask` DISABLE KEYS */;
/*!40000 ALTER TABLE `performancetask` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `performancetask_final`
--

DROP TABLE IF EXISTS `performancetask_final`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `performancetask_final` (
  `pfinal_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  PRIMARY KEY (`pfinal_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `performancetask_final`
--

LOCK TABLES `performancetask_final` WRITE;
/*!40000 ALTER TABLE `performancetask_final` DISABLE KEYS */;
/*!40000 ALTER TABLE `performancetask_final` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quarterassessment`
--

DROP TABLE IF EXISTS `quarterassessment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quarterassessment` (
  `quaterassessment_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `gradesheet_id` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `max_score` int DEFAULT NULL,
  PRIMARY KEY (`quaterassessment_id`),
  KEY `student_id` (`student_id`),
  KEY `department_id` (`department_id`),
  KEY `gradesheet_id` (`gradesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quarterassessment`
--

LOCK TABLES `quarterassessment` WRITE;
/*!40000 ALTER TABLE `quarterassessment` DISABLE KEYS */;
/*!40000 ALTER TABLE `quarterassessment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `quarterassessment_final`
--

DROP TABLE IF EXISTS `quarterassessment_final`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quarterassessment_final` (
  `qafinal_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  PRIMARY KEY (`qafinal_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quarterassessment_final`
--

LOCK TABLES `quarterassessment_final` WRITE;
/*!40000 ALTER TABLE `quarterassessment_final` DISABLE KEYS */;
/*!40000 ALTER TABLE `quarterassessment_final` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_card`
--

DROP TABLE IF EXISTS `report_card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `report_card` (
  `report_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `gradesheet_id` int DEFAULT NULL,
  `final_grades` decimal(3,2) DEFAULT NULL,
  PRIMARY KEY (`report_id`),
  KEY `student_id` (`student_id`),
  KEY `gradesheet_id` (`gradesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_card`
--

LOCK TABLES `report_card` WRITE;
/*!40000 ALTER TABLE `report_card` DISABLE KEYS */;
/*!40000 ALTER TABLE `report_card` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section`
--

DROP TABLE IF EXISTS `section`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `section` (
  `section_id` int NOT NULL AUTO_INCREMENT,
  `grade_level` int DEFAULT NULL,
  `section_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `teacher_id` int DEFAULT NULL,
  PRIMARY KEY (`section_id`),
  KEY `fk_teachers` (`teacher_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section`
--

LOCK TABLES `section` WRITE;
/*!40000 ALTER TABLE `section` DISABLE KEYS */;
/*!40000 ALTER TABLE `section` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `student_id` int NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci NULL,
  `section_ID` int NULL,
  `akap_status` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `parent_id` int NULL,
  PRIMARY KEY (`student_id`),
  KEY `fk_sections` (`section_ID`),
  KEY `fk_parents` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `teacher_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  PRIMARY KEY (`teacher_id`),
  KEY `fk_departments` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `writtenwork`
--

DROP TABLE IF EXISTS `writtenwork`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `writtenwork` (
  `written_work_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `gradesheet_id` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `max_score` int DEFAULT NULL,
  `final_score` int DEFAULT NULL,
  PRIMARY KEY (`written_work_id`),
  KEY `student_id` (`student_id`),
  KEY `department_id` (`department_id`),
  KEY `gradesheet_id` (`gradesheet_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `writtenwork`
--

LOCK TABLES `writtenwork` WRITE;
/*!40000 ALTER TABLE `writtenwork` DISABLE KEYS */;
/*!40000 ALTER TABLE `writtenwork` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `writtenwork_final`
--

DROP TABLE IF EXISTS `writtenwork_final`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `writtenwork_final` (
  `wwfinal_id` int NOT NULL AUTO_INCREMENT,
  `student_id` int DEFAULT NULL,
  PRIMARY KEY (`wwfinal_id`),
  KEY `student_id` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `writtenwork_final`
--

LOCK TABLES `writtenwork_final` WRITE;
/*!40000 ALTER TABLE `writtenwork_final` DISABLE KEYS */;
/*!40000 ALTER TABLE `writtenwork_final` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-19  7:07:40
