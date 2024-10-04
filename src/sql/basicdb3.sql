-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 04:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `activity_id` int(11) NOT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `activity_name` varchar(255) NOT NULL,
  `total_score` int(11) NOT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `quarter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activity_id`, `gradesheet_id`, `activity_name`, `total_score`, `activity_type`, `quarter`) VALUES
(71, 37, 'Assignment #1', 50, 'Written Work', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `username`, `password`) VALUES
(2, 'raymart', '$2y$10$kBjc2MNVXwhUcFyHi6jPDexKDcz40jKzV2XRMq48nXcFO.7wGynGa');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `is_archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `teacher_id`, `is_archived`) VALUES
(3, 'Bruh', NULL, 1),
(4, 'Bruh', NULL, 1),
(5, 'Bruh', NULL, 0),
(6, 'bru', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE `gradesheet` (
  `gradesheet_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradesheet`
--

INSERT INTO `gradesheet` (`gradesheet_id`, `section_id`, `subject`) VALUES
(1, 26, 'Filipino'),
(2, 26, 'English'),
(3, 26, 'Mathematics'),
(4, 26, 'Science'),
(5, 26, 'Home Economics'),
(6, 26, 'Araling Panlipunan'),
(7, 26, 'Edukasyon sa Pagpapakatao'),
(8, 26, 'TLE'),
(9, 26, 'Music'),
(10, 26, 'Arts'),
(11, 26, 'PE'),
(12, 26, 'Health'),
(13, 27, 'Filipino'),
(14, 27, 'English'),
(15, 27, 'Mathematics'),
(16, 27, 'Science'),
(17, 27, 'Home Economics'),
(18, 27, 'Araling Panlipunan'),
(19, 27, 'Edukasyon sa Pagpapakatao'),
(20, 27, 'TLE'),
(21, 27, 'Music'),
(22, 27, 'Arts'),
(23, 27, 'PE'),
(24, 27, 'Health'),
(25, 28, 'Filipino'),
(26, 28, 'English'),
(27, 28, 'Mathematics'),
(28, 28, 'Science'),
(29, 28, 'Home Economics'),
(30, 28, 'Araling Panlipunan'),
(31, 28, 'Edukasyon sa Pagpapakatao'),
(32, 28, 'TLE'),
(33, 28, 'Music'),
(34, 28, 'Arts'),
(35, 28, 'PE'),
(36, 28, 'Health'),
(37, 29, 'Filipino'),
(38, 29, 'English'),
(39, 29, 'Mathematics'),
(40, 29, 'Science'),
(41, 29, 'Home Economics'),
(42, 29, 'Araling Panlipunan'),
(43, 29, 'Edukasyon sa Pagpapakatao'),
(44, 29, 'TLE'),
(45, 29, 'Music'),
(46, 29, 'Arts'),
(47, 29, 'PE'),
(48, 29, 'Health');

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `parent_id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `contact.no` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`parent_id`, `username`, `password`, `first_name`, `last_name`, `contact.no`, `email`, `student_id`) VALUES
(1, 'nmontesa', 'bruh', NULL, NULL, NULL, NULL, NULL),
(2, 'nielmontesa', 'burat', NULL, NULL, NULL, NULL, NULL),
(3, 'bruh', 'bruh', NULL, NULL, NULL, NULL, NULL);

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
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `grade_level`, `section_name`, `is_archived`) VALUES
(22, 7, 'Bonifacio', 1),
(23, 7, 'Rizal', 1),
(24, 10, 'Lapu-lapu', 1),
(25, 8, 'Bonifacio', 1),
(26, 7, 'Rizal', 1),
(27, 8, 'Lapu-lapu', 0),
(28, 10, 'Gomez', 0),
(29, 7, 'Luna', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `section_ID` int(11) DEFAULT NULL,
  `akap_status` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `is_archived` tinyint(1) NOT NULL,
  `LRN` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `section_ID`, `akap_status`, `email`, `gender`, `is_archived`, `LRN`) VALUES
(23, 'Niel Ivan', 'Montesa', 24, 'Inactive', 'nmontesa@gmail.com', 'Male', 1, '543543543543'),
(24, 'Fran', 'Custodio', 24, 'Solved', 'fcustodio@gmail.com', 'Female', 1, '123772136127'),
(25, 'Alex', 'Berdera', 24, 'Solved', 'aberdera@gmail.com', 'Male', 1, '132123213213'),
(27, 'Marco', 'Montesa', 24, 'Solved', 'mmontesa@gmail.com', 'Male', 1, '348237523423'),
(28, 'Noemi', 'Montesa', 24, 'Inactive', 'nmontesa@gmail.com', 'Female', 1, '242342342342'),
(29, 'Noemi', 'Montesa', 24, 'Inactive', 'nmontesa@gmail.com', 'Female', 1, '242342342342'),
(30, 'Niel', 'Montesa', 27, 'Active', 'nmontesa@gmail.com', 'Male', 1, '141313221321'),
(31, 'Alex Bading', 'Berdera', 27, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '123772136127'),
(32, 'Fran', 'Custodio', 27, 'Solved', 'fcustodio@gmail.com', 'Female', 1, '2021102643'),
(33, 'dsadasd', 'asdasdasd', 27, 'Active', 'asdas@gmail.com', 'Male', 1, '123772136127'),
(34, 'Niel', 'Montesa', 29, 'Inactive', 'nirumontesa@gmail.com', 'Male', 0, '321312321321'),
(35, 'Rhen', 'Fernandez', 29, 'Inactive', 'rfernandez@gmail.com', 'Male', 0, '432432432432'),
(36, 'Ash Siebert', 'Joloan', 29, 'Inactive', 'ajoloan@gmail.com', 'Male', 0, '241323123123'),
(37, 'Jayrald', 'Pelegrino', 29, 'Inactive', 'jpelegrino@gmail.com', 'Male', 0, '413243245435'),
(38, 'Alex', 'Berdera', 29, 'Active', 'aberdera@gmail.com', 'Female', 0, '312312321321');

-- --------------------------------------------------------

--
-- Table structure for table `student_activity_score`
--

CREATE TABLE `student_activity_score` (
  `score_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `activity_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_activity_score`
--

INSERT INTO `student_activity_score` (`score_id`, `student_id`, `activity_id`, `score`) VALUES
(26, 38, 71, 25),
(27, 34, 71, 15),
(28, 35, 71, 35),
(29, 36, 71, 50),
(30, 37, 71, 25);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `username`, `password`, `first_name`, `last_name`, `email`, `department_id`) VALUES
(1, 'aberdera', 'bruh', NULL, NULL, NULL, NULL),
(2, 'nmontesa', 'bruh', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `gradesheet_id` (`gradesheet_id`);

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
  ADD KEY `section_id` (`section_id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`parent_id`),
  ADD KEY `fk_students` (`student_id`);

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
  ADD PRIMARY KEY (`section_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `fk_sections` (`section_ID`);

--
-- Indexes for table `student_activity_score`
--
ALTER TABLE `student_activity_score`
  ADD PRIMARY KEY (`score_id`),
  ADD UNIQUE KEY `student_id` (`student_id`,`activity_id`),
  ADD KEY `activity_id` (`activity_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `fk_departments` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gradesheet`
--
ALTER TABLE `gradesheet`
  MODIFY `gradesheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report_card`
--
ALTER TABLE `report_card`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `student_activity_score`
--
ALTER TABLE `student_activity_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`) ON DELETE CASCADE;

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `fk_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `student_activity_score`
--
ALTER TABLE `student_activity_score`
  ADD CONSTRAINT `student_activity_score_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `student_activity_score_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
