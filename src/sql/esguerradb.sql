-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 02:59 PM
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
(198, 97, 'Assignment #2', 100, 'Written Work', 1),
(227, 97, 'Assignment #3', 70, 'Written Work', 1),
(228, 97, 'Exercise #2', 100, 'Performance Task', 1),
(230, 97, 'Assignment #4', 100, 'Written Work', 1),
(231, 97, 'Assignment #6', 100, 'Written Work', 1),
(232, 97, 'Assignment #7', 100, 'Written Work', 1),
(233, 97, 'Attendance', 25, 'Written Work', 1),
(235, 97, 'Assignment #1', 100, 'Written Work', 2),
(236, 97, 'Exercise #1', 100, 'Performance Task', 2),
(237, 97, 'Exam #1', 100, 'Quarterly Assessment', 2),
(238, 97, 'Assignment #1', 100, 'Written Work', 3),
(239, 97, 'Exercise #1', 100, 'Performance Task', 3),
(240, 97, 'Assignment #1', 100, 'Written Work', 4),
(241, 97, 'Exercise #1', 100, 'Performance Task', 4),
(242, 97, 'Exam #1', 100, 'Quarterly Assessment', 4),
(246, 97, 'Exam #2', 100, 'Quarterly Assessment', 3),
(247, 99, 'Assignment #1', 100, 'Written Work', 1),
(248, 99, 'Exercise #1', 100, 'Performance Task', 1),
(249, 99, 'Exam #1', 100, 'Quarterly Assessment', 1),
(250, 99, 'Assignment #1', 20, 'Written Work', 2),
(251, 99, 'Exercise #1', 100, 'Performance Task', 2),
(252, 99, 'Exam #1', 100, 'Quarterly Assessment', 2),
(253, 99, 'Assignment #1', 100, 'Performance Task', 3),
(254, 99, 'Assignment #1', 50, 'Written Work', 3),
(255, 99, 'Exam #1', 100, 'Quarterly Assessment', 3),
(256, 99, 'Assignment #1', 100, 'Written Work', 4),
(257, 99, 'Exercise #1', 100, 'Performance Task', 4),
(258, 99, 'Exam #1', 100, 'Quarterly Assessment', 4);

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
(6, 'bru', NULL, 0),
(7, 'WOHOI', NULL, 0),
(8, 'Bruh', NULL, 0);

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
(39, 50, 97, 1, 65.65, 78),
(40, 50, 97, 2, 95.40, 97),
(41, 50, 97, 3, 85.50, 90),
(42, 50, 97, 4, 85.50, 90),
(43, 50, 98, 1, 82.60, 89),
(44, 52, 97, 1, 86.79, 91),
(45, 52, 97, 2, 91.90, 94),
(46, 52, 97, 3, 91.70, 94),
(47, 52, 97, 4, 86.10, 91),
(48, 52, 99, 1, 90.00, 93),
(49, 52, 99, 2, 89.60, 93),
(50, 52, 99, 3, 80.70, 87),
(51, 52, 99, 4, 78.70, 87),
(52, 50, 99, 1, 83.20, 89),
(53, 50, 99, 2, 74.70, 84),
(54, 50, 99, 3, 87.50, 92),
(55, 50, 99, 4, 86.00, 91),
(56, 51, 97, 1, 88.43, 92),
(57, 51, 97, 2, 83.10, 89),
(58, 51, 97, 3, 92.30, 95),
(59, 51, 97, 4, 85.60, 91),
(60, 51, 99, 1, 94.30, 96),
(61, 51, 99, 2, 88.90, 93),
(62, 51, 99, 3, 77.90, 86),
(63, 51, 99, 4, 81.10, 88),
(64, 54, 97, 1, 88.91, 93),
(65, 54, 97, 2, 73.30, 83),
(66, 54, 97, 3, 88.20, 92),
(67, 54, 97, 4, 83.60, 89);

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
(98, 34, 'English', 1),
(99, 34, 'Mathematics', 1),
(100, 34, 'Science', 1),
(101, 34, 'Home Economics', 1),
(102, 34, 'Araling Panlipunan', 1),
(103, 34, 'Edukasyon sa Pagpapakatao', 1),
(104, 34, 'TLE', 1),
(105, 34, 'Music', 1),
(106, 34, 'Arts', 1),
(107, 34, 'PE', 1),
(108, 34, 'Health', 1),
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
(120, 35, 'Health', 0),
(121, 36, 'Filipino', 0),
(122, 36, 'English', 0),
(123, 36, 'Mathematics', 0),
(124, 36, 'Science', 0),
(125, 36, 'Home Economics', 0),
(126, 36, 'Araling Panlipunan', 0),
(127, 36, 'Edukasyon sa Pagpapakatao', 0),
(128, 36, 'TLE', 0),
(129, 36, 'Music', 0),
(130, 36, 'Arts', 0),
(131, 36, 'PE', 0),
(132, 36, 'Health', 0),
(133, 37, 'Filipino', 0),
(134, 37, 'English', 0),
(135, 37, 'Mathematics', 0),
(136, 37, 'Science', 0),
(137, 37, 'Home Economics', 0),
(138, 37, 'Araling Panlipunan', 0),
(139, 37, 'Edukasyon sa Pagpapakatao', 0),
(140, 37, 'TLE', 0),
(141, 37, 'Music', 0),
(142, 37, 'Arts', 0),
(143, 37, 'PE', 0),
(144, 37, 'Health', 0),
(145, 38, 'Filipino', 0),
(146, 38, 'English', 0),
(147, 38, 'Mathematics', 0),
(148, 38, 'Science', 0),
(149, 38, 'Home Economics', 0),
(150, 38, 'Araling Panlipunan', 0),
(151, 38, 'Edukasyon sa Pagpapakatao', 0),
(152, 38, 'TLE', 0),
(153, 38, 'Music', 0),
(154, 38, 'Arts', 0),
(155, 38, 'PE', 0),
(156, 38, 'Health', 0),
(157, 39, 'Filipino', 0),
(158, 39, 'English', 0),
(159, 39, 'Mathematics', 0),
(160, 39, 'Science', 0),
(161, 39, 'Araling Panlipunan', 0),
(162, 39, 'Edukasyon sa Pagpapakatao', 0),
(163, 39, 'TLE', 0),
(164, 39, 'Music', 0),
(165, 39, 'Arts', 0),
(166, 39, 'PE', 0),
(167, 39, 'Health', 0),
(168, 40, 'Filipino', 0),
(169, 40, 'English', 0),
(170, 40, 'Mathematics', 0),
(171, 40, 'Science', 0),
(172, 40, 'Araling Panlipunan', 0),
(173, 40, 'Edukasyon sa Pagpapakatao', 0),
(174, 40, 'TLE', 0),
(175, 40, 'Music', 0),
(176, 40, 'Arts', 0),
(177, 40, 'PE', 0),
(178, 40, 'Health', 0),
(179, 41, 'Filipino', 0),
(180, 41, 'English', 0),
(181, 41, 'Mathematics', 0),
(182, 41, 'Science', 0),
(183, 41, 'Araling Panlipunan', 0),
(184, 41, 'Edukasyon sa Pagpapakatao', 0),
(185, 41, 'TLE', 0),
(186, 41, 'Music', 0),
(187, 41, 'Arts', 0),
(188, 41, 'PE', 0),
(189, 41, 'Health', 0);

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
-- Table structure for table `score_change_logs`
--

CREATE TABLE `score_change_logs` (
  `log_id` int(11) NOT NULL,
  `score_id` int(11) DEFAULT NULL,
  `edited_by` varchar(255) DEFAULT NULL,
  `edited_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `score_change_logs`
--

INSERT INTO `score_change_logs` (`log_id`, `score_id`, `edited_by`, `edited_at`) VALUES
(1, 173, 'Unknown User', '2024-10-05 19:58:02'),
(2, 174, 'Unknown User', '2024-10-05 19:58:08'),
(3, 175, 'Unknown User', '2024-10-05 19:58:11'),
(4, 176, 'Unknown User', '2024-10-05 19:58:14'),
(5, 177, 'Unknown User', '2024-10-05 19:58:33'),
(6, 178, 'Unknown User', '2024-10-05 19:58:34'),
(7, 179, 'raymart', '2024-10-05 20:00:07'),
(8, 180, 'raymart', '2024-10-05 20:47:49'),
(9, 181, 'raymart', '2024-10-05 20:48:55'),
(10, 182, 'raymart', '2024-10-05 20:48:58'),
(11, 183, 'raymart', '2024-10-05 20:49:00'),
(12, 184, 'raymart', '2024-10-05 20:49:02'),
(13, 185, 'raymart', '2024-10-05 20:49:04'),
(14, 186, 'raymart', '2024-10-05 20:49:06'),
(15, 114, 'raymart', '2024-10-05 20:49:10'),
(16, 187, 'raymart', '2024-10-05 20:49:11'),
(17, 188, 'raymart', '2024-10-05 20:49:12'),
(18, 189, 'raymart', '2024-10-05 20:49:14'),
(19, 190, 'raymart', '2024-10-05 20:49:17'),
(20, 191, 'raymart', '2024-10-05 20:49:18'),
(21, 192, 'raymart', '2024-10-05 20:49:19'),
(22, 193, 'raymart', '2024-10-05 20:49:31'),
(23, 194, 'raymart', '2024-10-05 20:49:33'),
(24, 195, 'raymart', '2024-10-05 20:49:34'),
(25, 196, 'raymart', '2024-10-05 20:49:37'),
(26, 197, 'raymart', '2024-10-05 20:49:39'),
(27, 198, 'raymart', '2024-10-05 20:49:40'),
(28, 199, 'raymart', '2024-10-05 20:49:43'),
(29, 200, 'raymart', '2024-10-05 20:49:47'),
(30, 201, 'raymart', '2024-10-05 20:49:48'),
(31, 202, 'raymart', '2024-10-05 20:49:49'),
(32, 203, 'raymart', '2024-10-05 20:49:52'),
(33, 204, 'raymart', '2024-10-05 20:49:56'),
(34, 205, 'raymart', '2024-10-05 20:49:56'),
(35, 206, 'raymart', '2024-10-05 20:49:58'),
(36, 207, 'raymart', '2024-10-05 20:49:59'),
(37, 208, 'raymart', '2024-10-05 20:50:08'),
(38, 209, 'raymart', '2024-10-05 20:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL,
  `grade_level` int(11) DEFAULT NULL,
  `section_name` varchar(255) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `school_year` varchar(9) NOT NULL,
  `adviser_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `grade_level`, `section_name`, `is_archived`, `school_year`, `adviser_id`) VALUES
(22, 7, 'Bonifacio', 1, '', NULL),
(23, 7, 'Rizal', 1, '', NULL),
(24, 10, 'Lapu-lapu', 1, '', NULL),
(25, 8, 'Bonifacio', 1, '', NULL),
(26, 7, 'Rizal', 1, '', NULL),
(27, 8, 'Lapu-lapu', 1, '', NULL),
(28, 10, 'Gomez', 1, '', NULL),
(29, 7, 'Luna', 1, '', NULL),
(30, 7, 'Rizal', 1, '', NULL),
(31, 7, 'Bonifacio', 1, '', NULL),
(32, 7, 'Test', 1, '', NULL),
(33, 7, 'Gomez', 1, '', NULL),
(34, 7, 'Lapu-lapu', 0, '2024-2025', 1),
(35, 7, 'Gomez', 1, '', NULL),
(36, 7, 'Berdera', 1, '', NULL),
(37, 8, 'Luna', 0, '', NULL),
(38, 7, 'Montesa', 1, '', NULL),
(39, 7, 'Crisostomo', 1, '2024-', 1),
(40, 7, 'Ibarra', 1, '2024-2025', 2),
(41, 7, 'Bonifacio', 0, '2024-2025', 1);

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
  `LRN` varchar(12) NOT NULL,
  `teacher_remarks` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `first_name`, `last_name`, `section_ID`, `akap_status`, `email`, `gender`, `is_archived`, `LRN`, `teacher_remarks`) VALUES
(34, 'Niel Ivan', 'Montesa', 29, 'Solved', 'nirumontesa@gmail.com', 'Male', 1, '321312321321', ''),
(35, 'Rhen', 'Fernandez', 29, 'Inactive', 'rfernandez@gmail.com', 'Male', 1, '432432432432', ''),
(36, 'Ash Siebert', 'Joloan', 29, 'Inactive', 'ajoloan@gmail.com', 'Male', 1, '241323123123', ''),
(37, 'Jayrald', 'Pelegrino', 29, 'Inactive', 'jpelegrino@gmail.com', 'Female', 1, '413243245435', ''),
(38, 'Alex', 'Berdera', 29, 'Active', 'aberdera@gmail.com', 'Male', 1, '312312321321', ''),
(39, 'David', 'Acosta', 29, 'Inactive', 'dacosta@gmail.com', 'Male', 1, '312321321312', ''),
(40, 'Alex', 'Berdera', 29, 'Active', 'aberdera@gmail.com', 'Female', 1, '218273129308', ''),
(41, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308', ''),
(42, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308', ''),
(43, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308', ''),
(44, 'Alex', 'Berdera', 29, 'Inactive', 'aberdera@gmail.com', 'Male', 1, '218273129308', ''),
(45, 'David', 'Acosta', 33, 'Inactive', 'dacosta@gmail.com', 'Male', 1, '123772136127', ''),
(46, 'David', 'Acosta', 33, 'Inactive', 'dacosta@gmail.com', 'Male', 1, '123772136127', ''),
(47, 'Niel', 'Montesa', 34, 'Active', 'nirumontesa@gmail.com', 'Male', 1, '123772136127', ''),
(48, 'Niel', 'Montesa', 34, 'Active', 'nirumontesa@gmail.com', 'Male', 1, '123772136127', ''),
(49, 'Niel', 'Montesa', 34, 'Active', 'nirumontesa@gmail.com', 'Male', 1, '123772136127', ''),
(50, 'David', 'Acosta', 34, 'Inactive', 'dacosta@gmail.com', 'Male', 0, '343254984742', ''),
(51, 'Niel', 'Montesa', 34, 'Inactive', 'nirumontesa@gmail.com', 'Male', 0, '421124554635', ''),
(52, 'Alexander', 'Berdera', 34, 'Solved', 'aberdera@gmail.com', 'Female', 0, '423432432432', ''),
(53, 'Marco', 'Montesa', 34, 'Solved', 'mmontesa@gmail.com', 'Male', 0, '123772136134', ''),
(54, 'Ara Franchesca', 'Custodio', 34, 'Active', 'fcustodio@gmail.com', 'Female', 0, '739183721983', '');

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
(69, 50, 188, 25),
(71, 50, 193, 32),
(72, 50, 194, 50),
(73, 50, 195, 90),
(74, 50, 196, 40),
(75, 50, 197, 78),
(76, 50, 198, 60),
(77, 50, 227, 58),
(78, 50, 228, 75),
(79, 51, 188, 45),
(80, 52, 188, 42),
(81, 51, 198, 84),
(82, 52, 198, 96),
(83, 52, 227, 42),
(84, 51, 227, 64),
(85, 51, 193, 42),
(86, 52, 193, 42),
(87, 51, 228, 96),
(88, 52, 228, 98),
(89, 51, 194, 85),
(90, 52, 194, 82),
(91, 50, 233, 12),
(92, 50, 230, 54),
(93, 52, 230, 52),
(94, 51, 230, 85),
(95, 50, 231, 76),
(96, 50, 232, 78),
(97, 52, 231, 90),
(98, 52, 232, 85),
(99, 51, 232, 75),
(100, 51, 231, 86),
(101, 52, 233, 24),
(102, 51, 233, 23),
(103, 50, 235, 97),
(104, 50, 236, 95),
(105, 50, 237, 94),
(106, 51, 235, 85),
(107, 52, 235, 85),
(108, 52, 236, 96),
(109, 51, 236, 78),
(110, 52, 237, 92),
(111, 51, 237, 93),
(112, 50, 238, 85),
(113, 52, 238, 89),
(114, 51, 238, 85),
(115, 50, 239, 86),
(116, 52, 239, 92),
(117, 51, 239, 93),
(118, 50, 240, 84),
(119, 50, 241, 85),
(120, 50, 242, 89),
(121, 52, 240, 79),
(122, 52, 241, 86),
(123, 52, 242, 97),
(124, 51, 242, 89),
(125, 51, 241, 84),
(126, 51, 240, 86),
(133, 50, 246, 85),
(134, 52, 246, 95),
(135, 51, 246, 100),
(136, 50, 247, 74),
(137, 50, 248, 85),
(138, 50, 249, 90),
(139, 52, 247, 90),
(140, 52, 248, 90),
(141, 52, 249, 90),
(142, 51, 247, 95),
(143, 51, 248, 94),
(144, 51, 249, 94),
(145, 50, 250, 15),
(146, 52, 250, 19),
(147, 51, 250, 20),
(148, 50, 251, 75),
(149, 52, 251, 89),
(150, 51, 251, 85),
(151, 50, 252, 74),
(152, 52, 252, 85),
(153, 51, 252, 83),
(154, 50, 253, 89),
(155, 52, 253, 84),
(156, 51, 253, 83),
(157, 50, 254, 42),
(158, 52, 254, 41),
(159, 51, 254, 40),
(160, 50, 255, 89),
(161, 52, 255, 75),
(162, 51, 255, 69),
(163, 50, 256, 89),
(164, 52, 256, 69),
(165, 51, 256, 95),
(166, 50, 257, 74),
(167, 52, 257, 70),
(168, 51, 257, 73),
(169, 50, 258, 99),
(170, 52, 258, 100),
(171, 51, 258, 78),
(172, 53, 188, 42),
(173, 53, 198, 78),
(174, 53, 227, 70),
(175, 53, 230, 84),
(176, 53, 231, 83),
(177, 53, 232, 87),
(178, 53, 233, 24),
(179, 53, 193, 42),
(180, 54, 188, 45),
(181, 54, 235, 65),
(182, 54, 236, 74),
(183, 53, 235, 89),
(184, 53, 236, 89),
(185, 53, 237, 78),
(186, 54, 237, 84),
(187, 54, 238, 85),
(188, 53, 238, 86),
(189, 53, 239, 89),
(190, 54, 239, 87),
(191, 53, 246, 96),
(192, 54, 246, 96),
(193, 53, 240, 92),
(194, 54, 240, 76),
(195, 54, 241, 86),
(196, 53, 241, 89),
(197, 53, 242, 68),
(198, 54, 242, 89),
(199, 54, 198, 96),
(200, 54, 227, 65),
(201, 54, 230, 74),
(202, 54, 231, 74),
(203, 54, 232, 89),
(204, 53, 228, 86),
(205, 53, 194, 86),
(206, 54, 194, 86),
(207, 54, 228, 96),
(208, 54, 233, 24),
(209, 54, 193, 42);

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
  `department_id` int(11) DEFAULT NULL,
  `teacher_idnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `username`, `password`, `first_name`, `last_name`, `email`, `department_id`, `teacher_idnum`) VALUES
(1, 'aberdera', 'bruh', 'Alex', 'Berdera', NULL, NULL, 0),
(2, 'nmontesa', 'bruh', 'Niel', 'Montesa', NULL, NULL, 0);

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
-- Indexes for table `score_change_logs`
--
ALTER TABLE `score_change_logs`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `score_id` (`score_id`);

--
-- Indexes for table `section`
--
ALTER TABLE `section`
  ADD PRIMARY KEY (`section_id`),
  ADD KEY `fk_adviser` (`adviser_id`);

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
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

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
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `final_grades`
--
ALTER TABLE `final_grades`
  MODIFY `final_grade_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `gradesheet`
--
ALTER TABLE `gradesheet`
  MODIFY `gradesheet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

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
-- AUTO_INCREMENT for table `score_change_logs`
--
ALTER TABLE `score_change_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `section`
--
ALTER TABLE `section`
  MODIFY `section_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `student_activity_score`
--
ALTER TABLE `student_activity_score`
  MODIFY `score_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

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
-- Constraints for table `score_change_logs`
--
ALTER TABLE `score_change_logs`
  ADD CONSTRAINT `score_change_logs_ibfk_1` FOREIGN KEY (`score_id`) REFERENCES `student_activity_score` (`score_id`);

--
-- Constraints for table `section`
--
ALTER TABLE `section`
  ADD CONSTRAINT `fk_adviser` FOREIGN KEY (`adviser_id`) REFERENCES `teachers` (`teacher_id`);

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