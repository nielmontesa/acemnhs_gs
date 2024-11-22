-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 12, 2024 at 01:45 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `esguerradb`
--
CREATE DATABASE IF NOT EXISTS `esguerradb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `esguerradb`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(50) NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE `gradesheet` (
  `gradesheet_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `written_work_id` int(11) DEFAULT NULL,
  `performance_task_id` int(11) DEFAULT NULL,
  `quaterassessment_id` int(11) DEFAULT NULL,
  `attendance_id` int(50) DEFAULT NULL,
  `quarter_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_ID` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact.no` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performancetask`
--

CREATE TABLE `performancetask` (
  `performance_task_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `max_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performancetask_final`
--

CREATE TABLE `performancetask_final` (
  `pfinal_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quarterassessment`
--

CREATE TABLE `quarterassessment` (
  `quaterassessment_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `max_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quarterassessment_final`
--

CREATE TABLE `quarterassessment_final` (
  `qafinal_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_card`
--

CREATE TABLE `report_card` (
  `report_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `final_grades` decimal(3,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `grade_level` int(11) DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `section_ID` int(11) NOT NULL,
  `akap_status` tinyint(1) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` int(11) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `writtenwork`
--

CREATE TABLE `writtenwork` (
  `written_work_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `max_score` int(11) DEFAULT NULL,
  `final_score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `writtenwork_final`
--

CREATE TABLE `writtenwork_final` (
  `wwfinal_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`),
  ADD KEY `fk_teacher` (`teacher_id`) USING BTREE;

--
-- Indexes for table `gradesheet`
--
ALTER TABLE `gradesheet`
  ADD PRIMARY KEY (`gradesheet_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `written_work_id` (`written_work_id`),
  ADD KEY `performance_task_id` (`performance_task_id`),
  ADD KEY `quaterassessment_id` (`quaterassessment_id`),
  ADD KEY `attendance_id` (`attendance_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_ID`),
  ADD KEY `fk_students` (`student_id`);

--
-- Indexes for table `performancetask`
--
ALTER TABLE `performancetask`
  ADD PRIMARY KEY (`performance_task_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `gradesheet_id` (`gradesheet_id`);

--
-- Indexes for table `performancetask_final`
--
ALTER TABLE `performancetask_final`
  ADD PRIMARY KEY (`pfinal_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `quarterassessment`
--
ALTER TABLE `quarterassessment`
  ADD PRIMARY KEY (`quaterassessment_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `gradesheet_id` (`gradesheet_id`);

--
-- Indexes for table `quarterassessment_final`
--
ALTER TABLE `quarterassessment_final`
  ADD PRIMARY KEY (`qafinal_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `report_card`
--
ALTER TABLE `report_card`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `gradesheet_id` (`gradesheet_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `fk_teachers` (`teacher_id`) USING BTREE;

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_sections` (`section_ID`),
  ADD KEY `fk_parents` (`parent_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `fk_departments` (`department_id`);

--
-- Indexes for table `writtenwork`
--
ALTER TABLE `writtenwork`
  ADD PRIMARY KEY (`written_work_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `gradesheet_id` (`gradesheet_id`);

--
-- Indexes for table `writtenwork_final`
--
ALTER TABLE `writtenwork_final`
  ADD PRIMARY KEY (`wwfinal_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `department`
--
ALTER TABLE `department`
  ADD CONSTRAINT `fk_teacher` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `gradesheet`
--
ALTER TABLE `gradesheet`
  ADD CONSTRAINT `gradesheet_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `gradesheet_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `gradesheet_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `gradesheet_ibfk_4` FOREIGN KEY (`written_work_id`) REFERENCES `writtenwork` (`written_work_id`),
  ADD CONSTRAINT `gradesheet_ibfk_5` FOREIGN KEY (`performance_task_id`) REFERENCES `performancetask` (`performance_task_id`),
  ADD CONSTRAINT `gradesheet_ibfk_6` FOREIGN KEY (`quaterassessment_id`) REFERENCES `quarterassessment` (`quaterassessment_id`),
  ADD CONSTRAINT `gradesheet_ibfk_7` FOREIGN KEY (`attendance_id`) REFERENCES `attendance` (`attendance_id`);

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `fk_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `performancetask`
--
ALTER TABLE `performancetask`
  ADD CONSTRAINT `performancetask_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `performancetask_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `performancetask_ibfk_3` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`);

--
-- Constraints for table `performancetask_final`
--
ALTER TABLE `performancetask_final`
  ADD CONSTRAINT `performancetask_final_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `quarterassessment`
--
ALTER TABLE `quarterassessment`
  ADD CONSTRAINT `quarterassessment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `quarterassessment_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `quarterassessment_ibfk_3` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`);

--
-- Constraints for table `quarterassessment_final`
--
ALTER TABLE `quarterassessment_final`
  ADD CONSTRAINT `quarterassessment_final_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `report_card`
--
ALTER TABLE `report_card`
  ADD CONSTRAINT `report_card_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `report_card_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `report_card_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `report_card_ibfk_4` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `fk_teachers` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_parents` FOREIGN KEY (`parent_id`) REFERENCES `parents` (`parent_ID`),
  ADD CONSTRAINT `fk_section` FOREIGN KEY (`section_ID`) REFERENCES `section` (`section_id`),
  ADD CONSTRAINT `fk_sections` FOREIGN KEY (`section_ID`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `fk_departments` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`);

--
-- Constraints for table `writtenwork`
--
ALTER TABLE `writtenwork`
  ADD CONSTRAINT `writtenwork_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `writtenwork_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `writtenwork_ibfk_3` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`);

--
-- Constraints for table `writtenwork_final`
--
ALTER TABLE `writtenwork_final`
  ADD CONSTRAINT `writtenwork_final_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
