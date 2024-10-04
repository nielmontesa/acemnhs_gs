-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 12:26 PM
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
(188, 97, 'Assignment #1', 50, 'Written Work', 1),
(193, 97, 'Exercise #1', 50, 'Performance Task', 1),
(194, 97, 'Exam #1', 100, 'Quarterly Assessment', 1),
(195, 98, 'Assignment #1', 100, 'Written Work', 1),
(196, 98, 'Exercise #1', 50, 'Performance Task', 1),
(197, 98, 'Exam #1', 100, 'Quarterly Assessment', 1),
(198, 97, 'Assignment #2', 100, 'Written Work', 1);

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
-- Table structure for table `final_grades`
--

CREATE TABLE `final_grades` (
  `final_grade_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `quarter` int(11) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL,
  `transmuted_grade` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `final_grades`
--

INSERT INTO `final_grades` (`final_grade_id`, `student_id`, `gradesheet_id`, `quarter`, `final_grade`, `transmuted_grade`) VALUES
(33, 50, 97, 1, 70.00, 81),
(34, 50, 98, 1, 82.60, 89);

-- --------------------------------------------------------

--
-- Table structure for table `gradesheet`
--

CREATE TABLE `gradesheet` (
  `gradesheet_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `is_finalized` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradesheet`
--

INSERT INTO `gradesheet` (`gradesheet_id`, `section_id`, `subject`, `is_finalized`) VALUES
(97, 34, 'Filipino', 0),
(98, 34, 'English', 0),
(99, 34, 'Mathematics', 0),
(100, 34, 'Science', 0),
(101, 34, 'Home Economics', 0),
(102, 34, 'Araling Panlipunan', 0),
(103, 34, 'Edukasyon sa Pagpapakatao', 0),
(104, 34, 'TLE', 0),
(105, 34, 'Music', 0),
(106, 34, 'Arts', 0),
(107, 34, 'PE', 0),
(108, 34, 'Health', 0),
(109, 35, 'Filipino', 0),
(110, 35, 'English', 0),
(111, 35, 'Mathematics', 0),
(112, 35, 'Science', 0),
(113, 35, 'Home Economics', 0),
(114, 35, 'Araling Panlipunan', 0),
(115, 35, 'Edukasyon sa Pagpapakatao', 0),
(116, 35, 'TLE', 0),
(117, 35, 'Music', 0),
(118, 35, 'Arts', 0),
(119, 35, 'PE', 0),
(120, 35, 'Health', 0);

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
  `report_card_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `gradesheet_id` int(11) DEFAULT NULL,
  `quarter` int(11) DEFAULT NULL,
  `final_grade` decimal(5,2) DEFAULT NULL
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
(27, 8, 'Lapu-lapu', 1),
(28, 10, 'Gomez', 1),
(29, 7, 'Luna', 1),
(30, 7, 'Rizal', 1),
(31, 7, 'Bonifacio', 1),
(32, 7, 'Test', 1),
(33, 7, 'Gomez', 1),
(34, 7, 'Lapu-lapu', 0),
(35, 7, 'Gomez', 0);

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
(34, 'Niel Ivan', 'Montesa', 29, 'Solved', 'nirumontesa@gmail.com', 'Male', 1, '321312321321'),
(35, 'Rhen', 'Fernandez', 29, 'Inactive', 'rfernandez@gmail.com', 'Male', 1, '432432432432'),
(36, 'Ash Siebert', 'Joloan', 29, 'Inactive', 'ajoloan@gmail.com', 'Male', 1, '241323123123'),
(37, 'Jayrald', 'Pelegrino', 29, 'Inactive', 'jpelegrino@gmail.com', 'Female', 1, '413243245435'),
(38, 'Alex', 'Berdera', 29, 'Active', 'aberdera@gmail.com', 'Male', 1, '312312321321'),
(39, 'David', 'Acosta', 29, 'Inactive', 'dacosta@gmail.com', 'Male', 1, '312321321312'),
(40, 'Alex', 'Berdera', 29, 'Active', 'aberdera@gmail.com', 'Female', 1, '218273129308'),
(41, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308'),
(42, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308'),
(43, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308'),
(44, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308'),
(45, 'David', 'Acosta', 33, 'Inactive', 'dacosta@gmail.com', 'Male', 1, '123772136127'),
(46, 'David', 'Acosta', 33, 'Inactive', 'dacosta@gmail.com', 'Male', 1, '123772136127'),
(47, 'Niel', 'Montesa', 34, 'Active', 'nirumontesa@gmail.com', 'Male', 1, '123772136127'),
(48, 'Niel', 'Montesa', 34, 'Active', 'nirumontesa@gmail.com', 'Male', 1, '123772136127'),
(49, 'Niel', 'Montesa', 34, 'Active', 'nirumontesa@gmail.com', 'Male', 1, '123772136127'),
(50, 'David', 'Acosta', 34, 'Inactive', 'dacosta@gmail.com', 'Male', 0, '343254984742');

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
(69, 50, 188, 37),
(71, 50, 193, 32),
(72, 50, 194, 78),
(73, 50, 195, 90),
(74, 50, 196, 40),
(75, 50, 197, 78),
(76, 50, 198, 75);

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
-- Indexes for table `final_grades`
--
ALTER TABLE `final_grades`
  ADD PRIMARY KEY (`final_grade_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `gradesheet_id` (`gradesheet_id`);

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
  ADD PRIMARY KEY (`report_card_id`),
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
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

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
-- AUTO_INCREMENT for table `final_grades`
--
ALTER TABLE `final_grades`
  MODIFY `final_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `gradesheet`
--
ALTER TABLE `gradesheet`
  MODIFY `gradesheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `parent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `report_card`
--
ALTER TABLE `report_card`
  MODIFY `report_card_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `student_activity_score`
--
ALTER TABLE `student_activity_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

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
-- Constraints for table `final_grades`
--
ALTER TABLE `final_grades`
  ADD CONSTRAINT `final_grades_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `final_grades_ibfk_2` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`);

--
-- Constraints for table `parents`
--
ALTER TABLE `parents`
  ADD CONSTRAINT `fk_students` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `report_card`
--
ALTER TABLE `report_card`
  ADD CONSTRAINT `report_card_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `report_card_ibfk_2` FOREIGN KEY (`gradesheet_id`) REFERENCES `gradesheet` (`gradesheet_id`);

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
