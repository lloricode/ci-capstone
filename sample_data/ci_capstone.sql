-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2017 at 11:02 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_capstone`
--

-- --------------------------------------------------------

--
-- Table structure for table `controllers`
--

CREATE TABLE `controllers` (
  `controller_id` mediumint(8) UNSIGNED NOT NULL,
  `controller_name` enum('home','curriculums','create-curriculum','create-curriculum-subject','create-requisite','students','create-student','edit-student','create-student-subject','subjects','create-subject','subject-offers','create-subject-offer','open-enrollment','educations','create-education','courses','create-course','rooms','create-room','users','create-user','groups','create-group','edit-group','deactivate','edit-user','database','log','permissions','last-logins','') NOT NULL,
  `controller_description` varchar(50) NOT NULL,
  `controller_admin_only` tinyint(1) NOT NULL DEFAULT '0',
  `controller_enrollment_open` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `controllers`
--

INSERT INTO `controllers` (`controller_id`, `controller_name`, `controller_description`, `controller_admin_only`, `controller_enrollment_open`, `created_at`) VALUES
(1, 'home', 'Home Description', 0, 0, '1491052870'),
(2, 'curriculums', 'Curriculums Description', 0, 0, '1491052870'),
(3, 'create-curriculum', 'Create Curriculum Description', 0, 1, '1491052870'),
(4, 'create-curriculum-subject', 'Create Curriculum Subject Description', 0, 1, '1491052870'),
(5, 'create-requisite', 'Create Requisite Description', 0, 1, '1491052870'),
(6, 'students', 'Students Description', 0, 0, '1491052871'),
(7, 'create-student', 'Create Student Description', 0, 1, '1491052871'),
(8, 'edit-student', 'Edit Student Description', 0, 0, '1491052871'),
(9, 'create-student-subject', 'Create Student Subject Description', 0, 1, '1491052871'),
(10, 'subjects', 'Subjects Description', 0, 0, '1491052871'),
(11, 'create-subject', 'Create Subject Description', 0, 1, '1491052871'),
(12, 'subject-offers', 'Subject Offers Description', 0, 0, '1491052871'),
(13, 'create-subject-offer', 'Create Subject Offer Description', 0, 1, '1491052871'),
(14, 'open-enrollment', 'Open Enrollment Description', 1, 0, '1491052871'),
(15, 'educations', 'Educations Description', 0, 0, '1491052871'),
(16, 'create-education', 'Create Education Description', 0, 1, '1491052871'),
(17, 'courses', 'Courses Description', 0, 0, '1491052871'),
(18, 'create-course', 'Create Course Description', 0, 1, '1491052871'),
(19, 'rooms', 'Rooms Description', 0, 0, '1491052871'),
(20, 'create-room', 'Create Room Description', 0, 1, '1491052871'),
(21, 'users', 'Users Description', 0, 0, '1491052871'),
(22, 'create-user', 'Create User Description', 1, 0, '1491052871'),
(23, 'groups', 'Groups Description', 0, 0, '1491052871'),
(24, 'create-group', 'Create Group Description', 1, 0, '1491052871'),
(25, 'edit-group', 'Edit Group Description', 1, 0, '1491052871'),
(26, 'deactivate', 'Deactivate Description', 1, 0, '1491052871'),
(27, 'edit-user', 'Edit User Description', 1, 0, '1491052871'),
(28, 'database', 'Database Description', 1, 0, '1491052871'),
(29, 'log', 'Log Description', 1, 0, '1491052872'),
(30, 'permissions', 'Permissions Description', 1, 0, '1491052872'),
(31, 'last-logins', 'Last Logins Description', 1, 0, '1491052872'),
(32, '', 'Default Controller Description', 0, 0, '1491052872');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(8) UNSIGNED NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_icon` varchar(20) NOT NULL,
  `course_color` varchar(20) NOT NULL,
  `course_description` varchar(50) NOT NULL,
  `course_code_id` varchar(5) NOT NULL,
  `education_id` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_code`, `course_icon`, `course_color`, `course_description`, `course_code_id`, `education_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'BEED', 'book', 'ly', 'BEED description', '20', 1, '1491052870', 5, NULL, NULL, NULL, NULL),
(2, 'HRM', 'fire', 'ls', 'HRM description', '30', 1, '1491052870', 3, NULL, NULL, NULL, NULL),
(3, 'Paramedical', 'user-md', 'lg', 'Paramedical  description', '40', 1, '1491052870', 2, NULL, NULL, NULL, NULL),
(4, 'ICT', 'tasks', 'lo', 'ICT description', '50', 1, '1491052870', 4, NULL, NULL, NULL, NULL),
(5, 'High School', 'briefcase', 'lb', 'High School Department', '60', 2, '1491052870', 2, NULL, NULL, NULL, NULL),
(6, 'AMT', 'beaker', 'lv', 'AMT description', '70', 1, '1491052870', 2, NULL, NULL, NULL, NULL),
(7, 'TESDA', 'group', 'ly', 'Tesda Courses', '80', 1, '1491052870', 6, NULL, NULL, NULL, NULL),
(8, 'CME', 'tint', 'ls', 'CME description', '90', 1, '1491052870', 5, NULL, NULL, NULL, NULL),
(9, 'Cross Enroll', 'move', 'lg', 'Cross Enroll description', '01', 1, '1491052870', 6, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `curriculums`
--

CREATE TABLE `curriculums` (
  `curriculum_id` int(8) UNSIGNED NOT NULL,
  `curriculum_description` varchar(50) NOT NULL,
  `curriculum_effective_school_year` varchar(9) NOT NULL,
  `curriculum_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `course_id` int(11) UNSIGNED NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `curriculums`
--

INSERT INTO `curriculums` (`curriculum_id`, `curriculum_description`, `curriculum_effective_school_year`, `curriculum_status`, `course_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'Two Year Aircraft Maintenance & Technology', '2016-2017', 1, 6, '1490272433', 1, NULL, NULL, NULL, NULL),
(2, 'Bachelor Science Elementary Education', '2015-2016', 1, 1, '1490272501', 1, NULL, NULL, NULL, NULL),
(3, 'Bachelor of Science in Hotel Restaurant Management', '2016-2017', 1, 2, '1490272821', 1, NULL, NULL, NULL, NULL),
(4, 'Bachelor of Science in Computer Science', '2015-2016', 1, 4, '1490273333', 1, NULL, NULL, NULL, NULL),
(5, 'paramedical', '2016-2017', 1, 3, '1491115358', 1, NULL, NULL, NULL, NULL),
(6, 'HS', '2016-2017', 1, 5, '1491115397', 1, NULL, NULL, NULL, NULL),
(7, 'tesda', '2016-2017', 1, 7, '1491115417', 1, NULL, NULL, NULL, NULL),
(8, 'cme', '2016-2017', 1, 8, '1491115432', 1, NULL, NULL, NULL, NULL),
(9, 'cross enroll', '2016-2017', 1, 9, '1491115451', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `curriculum_subjects`
--

CREATE TABLE `curriculum_subjects` (
  `curriculum_subject_id` int(8) UNSIGNED NOT NULL,
  `curriculum_subject_year_level` tinyint(11) UNSIGNED NOT NULL,
  `curriculum_subject_semester` enum('first','second','summer') NOT NULL,
  `curriculum_subject_units` tinyint(11) UNSIGNED NOT NULL,
  `curriculum_subject_lecture_hours` tinyint(11) UNSIGNED NOT NULL,
  `curriculum_subject_laboratory_hours` tinyint(11) UNSIGNED NOT NULL,
  `curriculum_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

CREATE TABLE `educations` (
  `education_id` int(8) UNSIGNED NOT NULL,
  `education_code` varchar(50) NOT NULL,
  `education_description` varchar(50) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `educations`
--

INSERT INTO `educations` (`education_id`, `education_code`, `education_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'collge', 'College', '1491052870', 5, NULL, NULL, NULL, NULL),
(2, 'high school', 'High School', '1491052870', 3, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `enrollment_id` int(8) UNSIGNED NOT NULL,
  `student_id` tinyint(11) NOT NULL,
  `course_id` tinyint(11) NOT NULL,
  `curriculum_id` tinyint(11) NOT NULL,
  `enrollment_school_year` varchar(10) NOT NULL,
  `enrollment_semester` enum('first','second','summer') NOT NULL,
  `enrollment_year_level` tinyint(11) NOT NULL,
  `enrollment_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `curriculum_id`, `enrollment_school_year`, `enrollment_semester`, `enrollment_year_level`, `enrollment_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 1, 4, 4, '2013-2014', 'second', 1, 0, '1490342599', 1, NULL, NULL, '1491121166', 1),
(2, 2, 2, 3, '2014-2015', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(3, 3, 2, 3, '2013-2014', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(4, 4, 8, 8, '2013-2014', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(5, 5, 4, 4, '2013-2014', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(6, 6, 6, 1, '2013-2014', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(7, 7, 9, 9, '2014-2015', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(8, 8, 6, 1, '2013-2014', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(9, 9, 3, 5, '2014-2015', 'second', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(10, 10, 8, 8, '2015-2016', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(11, 11, 7, 7, '2015-2016', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(12, 12, 3, 5, '2014-2015', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(13, 13, 2, 3, '2015-2016', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(14, 14, 5, 6, '2013-2014', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(15, 15, 8, 8, '2013-2014', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(16, 16, 9, 9, '2014-2015', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(17, 17, 3, 5, '2013-2014', 'second', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(18, 18, 7, 7, '2014-2015', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(19, 19, 3, 5, '2013-2014', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(20, 20, 5, 6, '2015-2016', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(21, 21, 8, 8, '2013-2014', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(22, 22, 5, 6, '2013-2014', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(23, 23, 3, 5, '2015-2016', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(24, 24, 1, 2, '2013-2014', 'first', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(25, 25, 1, 2, '2015-2016', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(26, 26, 9, 9, '2013-2014', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(27, 27, 8, 8, '2013-2014', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(28, 28, 3, 5, '2015-2016', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(29, 29, 1, 2, '2015-2016', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(30, 30, 9, 9, '2014-2015', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(31, 31, 9, 9, '2014-2015', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(32, 32, 5, 6, '2013-2014', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(33, 33, 2, 3, '2014-2015', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(34, 34, 8, 8, '2014-2015', 'first', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(35, 35, 2, 3, '2013-2014', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(36, 36, 7, 7, '2013-2014', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(37, 37, 6, 1, '2014-2015', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(38, 38, 4, 4, '2014-2015', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(39, 39, 3, 5, '2015-2016', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(40, 40, 3, 5, '2013-2014', 'second', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(41, 41, 9, 9, '2015-2016', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(42, 42, 4, 4, '2015-2016', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(43, 43, 3, 5, '2014-2015', 'first', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(44, 44, 8, 8, '2013-2014', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(45, 45, 9, 9, '2014-2015', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(46, 46, 8, 8, '2014-2015', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(47, 47, 5, 6, '2015-2016', 'first', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(48, 48, 4, 4, '2015-2016', 'second', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(49, 49, 4, 4, '2015-2016', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(50, 50, 1, 2, '2014-2015', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(51, 51, 5, 6, '2015-2016', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(52, 52, 4, 4, '2015-2016', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(53, 53, 1, 2, '2013-2014', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(54, 54, 9, 9, '2014-2015', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(55, 55, 9, 9, '2013-2014', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(56, 56, 8, 8, '2014-2015', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(57, 57, 3, 5, '2013-2014', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(58, 58, 8, 8, '2013-2014', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(59, 59, 6, 1, '2013-2014', 'second', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(60, 60, 4, 4, '2013-2014', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(61, 61, 5, 6, '2013-2014', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(62, 62, 8, 8, '2015-2016', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(63, 63, 6, 1, '2015-2016', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(64, 64, 6, 1, '2014-2015', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(65, 65, 4, 4, '2014-2015', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(66, 66, 5, 6, '2013-2014', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(67, 67, 4, 4, '2014-2015', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(68, 68, 7, 7, '2013-2014', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(69, 69, 8, 8, '2013-2014', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(70, 70, 5, 6, '2014-2015', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(71, 71, 6, 1, '2013-2014', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(72, 72, 5, 6, '2014-2015', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(73, 73, 2, 3, '2014-2015', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(74, 74, 3, 5, '2015-2016', 'second', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(75, 75, 5, 6, '2014-2015', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(76, 76, 1, 2, '2013-2014', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(77, 77, 7, 7, '2013-2014', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(78, 78, 2, 3, '2015-2016', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(79, 79, 1, 2, '2014-2015', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(80, 80, 8, 8, '2014-2015', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(81, 81, 6, 1, '2015-2016', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(82, 82, 4, 4, '2013-2014', 'first', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(83, 83, 5, 6, '2014-2015', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(84, 84, 5, 6, '2014-2015', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(85, 85, 7, 7, '2015-2016', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(86, 86, 3, 5, '2015-2016', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(87, 87, 1, 2, '2014-2015', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(88, 88, 5, 6, '2013-2014', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(89, 89, 8, 8, '2014-2015', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(90, 90, 6, 1, '2013-2014', 'second', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(91, 91, 5, 6, '2013-2014', 'first', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(92, 92, 1, 2, '2013-2014', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(93, 93, 4, 4, '2013-2014', 'second', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(94, 94, 4, 4, '2014-2015', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(95, 95, 2, 3, '2014-2015', 'summer', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(96, 96, 1, 2, '2015-2016', 'summer', 2, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(97, 97, 7, 7, '2014-2015', 'summer', 3, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(98, 98, 3, 5, '2013-2014', 'summer', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(99, 99, 7, 7, '2014-2015', 'second', 4, 0, '1490342599', 1, NULL, NULL, NULL, NULL),
(100, 100, 1, 2, '2014-2015', 'first', 1, 0, '1490342599', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment_status`
--

CREATE TABLE `enrollment_status` (
  `status` tinyint(1) UNSIGNED NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enrollment_status`
--

INSERT INTO `enrollment_status` (`status`, `created_at`, `created_user_id`) VALUES
(1, '1491098498', 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'faculty', 'General User'),
(3, 'registrar', 'Registrar'),
(4, 'dean', 'Dean'),
(5, 'accounting', 'Accounting'),
(6, 'sso', 'Support Service Office');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(8) UNSIGNED NOT NULL,
  `errno` int(2) NOT NULL,
  `errtype` varchar(32) NOT NULL,
  `errstr` text NOT NULL,
  `errfile` varchar(255) NOT NULL,
  `errline` int(4) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(20170316191620);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(8) UNSIGNED NOT NULL,
  `controller_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES
(10, 10, 1, '1489668863', NULL, NULL),
(11, 11, 1, '1489668863', NULL, NULL),
(14, 14, 1, '1489668863', NULL, NULL),
(15, 15, 1, '1489668863', NULL, NULL),
(18, 18, 1, '1489668864', NULL, NULL),
(20, 20, 1, '1489668864', NULL, NULL),
(21, 21, 1, '1489668864', NULL, NULL),
(22, 22, 1, '1489668864', NULL, NULL),
(23, 23, 1, '1489668864', NULL, NULL),
(24, 24, 1, '1489668864', NULL, NULL),
(25, 25, 1, '1489668864', NULL, NULL),
(26, 26, 1, '1489668864', NULL, NULL),
(27, 27, 1, '1489668864', NULL, NULL),
(28, 28, 1, '1489668864', NULL, NULL),
(29, 29, 1, '1489668864', NULL, NULL),
(30, 30, 1, '1489668864', NULL, NULL),
(43, 19, 1, '1490947031', NULL, 8),
(55, 1, 1, '1490947147', NULL, 8),
(56, 1, 2, '1490947147', NULL, 8),
(57, 1, 3, '1490947147', NULL, 8),
(58, 1, 4, '1490947148', NULL, 8),
(59, 1, 5, '1490947148', NULL, 8),
(60, 1, 6, '1490947148', NULL, 8),
(68, 12, 1, '1490947463', NULL, 8),
(69, 12, 4, '1490947463', NULL, 8),
(77, 3, 1, '1490947935', NULL, 1),
(78, 3, 4, '1490947935', NULL, 1),
(79, 4, 1, '1490953414', NULL, 1),
(80, 4, 4, '1490953414', NULL, 1),
(81, 5, 1, '1490953421', NULL, 1),
(82, 5, 4, '1490953421', NULL, 1),
(83, 7, 1, '1490953429', NULL, 1),
(84, 7, 3, '1490953429', NULL, 1),
(85, 9, 1, '1490953435', NULL, 1),
(86, 9, 4, '1490953435', NULL, 1),
(87, 13, 1, '1490953573', NULL, 1),
(88, 13, 4, '1490953573', NULL, 1),
(89, 2, 1, '1490953578', NULL, 1),
(90, 2, 4, '1490953578', NULL, 1),
(91, 8, 1, '1490953584', NULL, 1),
(92, 8, 4, '1490953584', NULL, 1),
(102, 17, 1, '1491110314', NULL, 1),
(103, 17, 2, '1491110314', NULL, 1),
(104, 17, 3, '1491110314', NULL, 1),
(105, 17, 4, '1491110314', NULL, 1),
(106, 17, 6, '1491110314', NULL, 1),
(107, 32, 1, '1491110372', NULL, 1),
(108, 32, 2, '1491110372', NULL, 1),
(109, 32, 3, '1491110372', NULL, 1),
(110, 32, 4, '1491110372', NULL, 1),
(111, 32, 5, '1491110372', NULL, 1),
(112, 32, 6, '1491110372', NULL, 1),
(113, 6, 1, '1491110498', NULL, 1),
(114, 6, 3, '1491110498', NULL, 1),
(115, 6, 4, '1491110499', NULL, 1),
(116, 6, 5, '1491110499', NULL, 1),
(117, 31, 1, '1491110799', NULL, 1),
(118, 16, 1, '1491111142', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `requisites`
--

CREATE TABLE `requisites` (
  `requisite_id` int(8) UNSIGNED NOT NULL,
  `requisite_type` enum('co','pre') NOT NULL,
  `curriculum_subject_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(8) UNSIGNED NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_number`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, '105', '1490344975', 1, NULL, NULL, NULL, NULL),
(2, '123', '1490858612', 1, NULL, NULL, NULL, NULL),
(3, '321', '1490858631', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(8) UNSIGNED NOT NULL,
  `student_firstname` varchar(100) NOT NULL,
  `student_image` varchar(50) DEFAULT NULL,
  `student_middlename` varchar(50) NOT NULL,
  `student_lastname` varchar(50) NOT NULL,
  `student_gender` enum('male','female') NOT NULL,
  `student_birthdate` varchar(50) NOT NULL,
  `student_birthplace` varchar(50) NOT NULL,
  `student_civil_status` varchar(50) NOT NULL,
  `student_nationality` varchar(50) NOT NULL,
  `student_guardian_fullname` varchar(50) NOT NULL,
  `student_permanent_address` varchar(250) NOT NULL,
  `student_address_town` varchar(250) DEFAULT NULL,
  `student_address_region` varchar(250) DEFAULT NULL,
  `student_guardian_address` varchar(50) DEFAULT NULL,
  `student_personal_contact_number` varchar(50) DEFAULT NULL,
  `student_guardian_contact_number` varchar(50) DEFAULT NULL,
  `student_personal_email` varchar(50) DEFAULT NULL,
  `student_guardian_email` varchar(50) DEFAULT NULL,
  `student_school_id` varchar(9) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_firstname`, `student_image`, `student_middlename`, `student_lastname`, `student_gender`, `student_birthdate`, `student_birthplace`, `student_civil_status`, `student_nationality`, `student_guardian_fullname`, `student_permanent_address`, `student_address_town`, `student_address_region`, `student_guardian_address`, `student_personal_contact_number`, `student_guardian_contact_number`, `student_personal_email`, `student_guardian_email`, `student_school_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'Julianne', '764cd2000c437a9f4782315c883dc461.jpg', 'Mueller', 'Dibbert', 'female', '12-14-1972', '277 Corwin RoadsDouglasfort, WI 11979-6154', 'Marriage', 'Filipino', 'Lonnie Ankunding', '33310 Araceli Park Suite 503\r\nNorth Cordie, IL 75592', 'Lolahaven', 'region2______', '83688 Etha Locks', '+2466123850788', '(866) 548-4350', 'schmitt.beulah@yahoo.com', 'michale37@example.net', '50-1', '1491112002', 1, NULL, NULL, '1491121166', 1),
(2, 'Tessie', NULL, 'Schulist', 'Macejkovic', 'female', '10-29-1952', '89949 Beahan Viaduct Apt. 084\r\nPort Graciela, WI 4', 'Single', 'Filipino', 'Emmie Ferry', '691 Rogers Avenue\r\nHirthefurt, CA 20617-8713', 'North Veronahaven', 'region2', '328 Jamir Walk Suite 906', '+6786417782053', '1-877-978-3429', 'rritchie@yahoo.com', 'dangelo.breitenberg@example.com', '30-2', '1491112002', 1, NULL, NULL, NULL, NULL),
(3, 'Anabel', NULL, 'Tromp', 'Renner', 'female', '02-15-1975', '900 Pollich Parks\r\nHomenickstad, VT 62573', 'Marriage', 'Other', 'Miguel Cronin', '22869 Nader Courts Suite 601\r\nSkilesmouth, UT 41190-8160', 'North Hershelport', 'region3', '2267 Colin Hill', '+7230318762972', '877.951.9658', 'ruecker.archibald@medhurst.info', 'walter.brianne@example.net', '30-3', '1491112002', 1, NULL, NULL, NULL, NULL),
(4, 'Raven', NULL, 'Pollich', 'Klocko', 'female', '12-12-1953', '738 Jefferey Estates\r\nSalvadorchester, DE 74284-58', 'Single', 'Other', 'Joshuah Satterfield', '9703 Ezra Ford Apt. 572\r\nMarquardtside, NE 36984-5708', 'East Geovanny', 'region4', '1173 Fay Alley Apt. 825', '+4317546824876', '888-506-0184', 'tanya65@hotmail.com', 'antwan.conroy@example.net', '90-4', '1491112002', 1, NULL, NULL, NULL, NULL),
(5, 'Roslyn', NULL, 'Reynolds', 'Bayer', 'male', '05-08-1920', '3749 Harber Springs Suite 782\r\nLake Anika, KY 5943', 'Single', 'Filipino', 'Dr. Dalton O Hara MD', '6889 Carole Canyon Apt. 627\r\nAubreybury, AL 59341-1329', 'New Ernesto', 'rgion1', '841 Gerlach Path', '+5219857160801', '844-746-5054', 'cruickshank.edmund@prosacco.com', 'wiza.lurline@example.com', '50-5', '1491112002', 1, NULL, NULL, NULL, NULL),
(6, 'Eunice', NULL, 'Kozey', 'Bechtelar', 'male', '09-11-1951', '512 Rosenbaum Rue Suite 867\r\nLemuelbury, VT 47362-', 'Marriage', 'Other', 'Dr. Valentina Wolff', '40593 Jovan Route\r\nRaumouth, AR 55502', 'Hectorfurt', 'rgion1', '38833 Lakin Fall', '+4512843718630', '1-888-614-1890', 'wyman.garth@johnson.com', 'walker.savanna@example.net', '70-6', '1491112002', 1, NULL, NULL, NULL, NULL),
(7, 'Davonte', NULL, 'Hilpert', 'Grimes', 'male', '09-22-1981', '7223 Anahi Fields Suite 714\r\nNorth Sadiebury, VA 3', 'Single', 'Other', 'Larissa Shields', '842 Uriel Spur Suite 577\r\nBrannonbury, OH 05839-1992', 'Hoegerside', 'rgion1', '785 Murazik Fords', '+9563275106480', '866-836-8144', 'jbecker@hotmail.com', 'leonard91@example.com', '01-7', '1491112002', 1, NULL, NULL, NULL, NULL),
(8, 'Dennis', NULL, 'Bashirian', 'Eichmann', 'male', '04-27-1970', '73424 Kovacek Crest\r\nSouth Adriennefurt, NC 68360-', 'Single', 'Other', 'Alycia Wiza', '515 Marty Passage Suite 827\r\nLake Issac, SD 56540', 'Stefanview', 'region2', '2013 Adelle Corners', '+3724703562674', '877-308-9836', 'malcolm08@hyatt.net', 'carter.ludwig@example.net', '70-8', '1491112002', 1, NULL, NULL, NULL, NULL),
(9, 'Monserrat', NULL, 'Schmitt', 'Adams', 'male', '07-19-1952', '5648 Donnelly Fields\r\nGradyport, WY 80422', 'Single', 'Other', 'Nicole Ratke', '5658 Hector Forks Apt. 757\r\nNorth Molly, NH 90289', 'Tremblayside', 'region2', '6959 Lucius Roads', '+1503434010548', '888.961.1200', 'adeline.stracke@lang.org', 'lazaro.jones@example.net', '40-9', '1491112002', 1, NULL, NULL, NULL, NULL),
(10, 'Anabel', NULL, 'Collins', 'Marquardt', 'male', '10-17-1957', '1794 Walton Cliffs\r\nDarrinchester, ID 20779', 'Single', 'Other', 'Prof. Franco Gerhold IV', '591 Aubrey Square\r\nReymundohaven, OR 42776-3192', 'Port Zolafurt', 'region4', '1014 Benny Spurs', '+6358723041099', '(866) 846-4484', 'bkeebler@gmail.com', 'nina.grant@example.com', '90-10', '1491112002', 1, NULL, NULL, NULL, NULL),
(11, 'Merritt', NULL, 'Stracke', 'Legros', 'female', '07-24-1979', '943 Rohan Court Apt. 432\r\nLake Electaport, SD 6891', 'Single', 'Filipino', 'Mr. Linwood Walker MD', '91707 Schroeder Lake\r\nReillyhaven, FL 82011-4847', 'Lake Katlynnmouth', 'rgion1', '673 Jacques Square', '+9742438734498', '(800) 516-0119', 'mohammad.larkin@sauer.org', 'benedict.mertz@example.com', '80-11', '1491112002', 1, NULL, NULL, NULL, NULL),
(12, 'Cordia', NULL, 'Aufderhar', 'Kassulke', 'female', '05-17-1943', '519 Murray Common Apt. 014\r\nSouth Alysaton, IN 100', 'Single', 'Filipino', 'Prof. Loma Will DDS', '609 Pearline Manors\r\nMarjoryview, RI 86033', 'Waelchiland', 'region4', '2189 Christian Overpass Suite 527', '+4676653430957', '800-951-9508', 'ewell92@yahoo.com', 'kelli83@example.net', '40-12', '1491112002', 1, NULL, NULL, NULL, NULL),
(13, 'Andres', NULL, 'Weimann', 'Kohler', 'female', '06-27-1998', '829 Talia Drives Apt. 801\r\nNorth Nigelton, ID 8600', 'Marriage', 'Filipino', 'Marlon Willms', '642 Jalyn Fall Suite 981\r\nLubowitzbury, NM 89770', 'Sybleland', 'region2', '2887 Schmidt Lakes', '+8617443736419', '1-800-997-2351', 'ullrich.greta@price.org', 'velma90@example.org', '30-13', '1491112002', 1, NULL, NULL, NULL, NULL),
(14, 'Ken', NULL, 'Stroman', 'Hartmann', 'female', '01-13-1944', '107 Kira Radial\r\nVidabury, VA 52768-1729', 'Single', 'Other', 'Maida Gibson IV', '490 Von Shores Apt. 970\r\nShadport, MI 31188-1016', 'South Theo', 'region4', '86170 Johanna Ports Apt. 139', '+4042072969365', '877.493.8071', 'kessler.abigale@wisoky.com', 'wuckert.kathlyn@example.net', '60-14', '1491112002', 1, NULL, NULL, NULL, NULL),
(15, 'Lionel', NULL, 'Runte', 'Breitenberg', 'male', '03-28-1933', '2197 Zachery Mall Suite 602\r\nMayerfurt, WY 39220-8', 'Single', 'Other', 'Maurice Hoeger', '443 Laney Trace\r\nEast Gustview, ME 88594-8248', 'West Maxieton', 'region4', '478 Graciela Plains Suite 245', '+7591355985646', '1-844-555-5517', 'jasper.hessel@johnston.com', 'marian.christiansen@example.com', '90-15', '1491112002', 1, NULL, NULL, NULL, NULL),
(16, 'Tyree', NULL, 'Watsica', 'Strosin', 'female', '07-08-1984', '674 Padberg Courts\r\nLake Stacy, VA 09317', 'Marriage', 'Other', 'Rachelle Simonis', '90818 Wilkinson Mall\r\nSouth Nannie, UT 26231', 'Nataliashire', 'region3', '400 O Hara Cape Suite 866', '+4934628047560', '(855) 599-3771', 'phauck@mccullough.info', 'edna37@example.org', '01-16', '1491112002', 1, NULL, NULL, NULL, NULL),
(17, 'Emmitt', NULL, 'Nitzsche', 'Mills', 'female', '06-26-1933', '434 Balistreri Square\r\nSouth Bernhardfort, FL 3186', 'Marriage', 'Filipino', 'Ola Auer', '82161 Wilburn Cliff Suite 792\r\nLake Virginiafurt, IN 80742', 'Cartwrightborough', 'region4', '2284 Emard Mall', '+6922812785792', '888.437.3109', 'cassandra04@yahoo.com', 'nikki.legros@example.net', '40-17', '1491112002', 1, NULL, NULL, NULL, NULL),
(18, 'Rosetta', NULL, 'Koepp', 'Dietrich', 'male', '10-18-2006', '372 Hyatt Corner Suite 528\r\nSouth Robb, ME 54667-9', 'Marriage', 'Other', 'Willis Lesch', '78471 Amaya Burg Apt. 849\r\nMargeton, WV 51052', 'New Delphia', 'region2', '9770 Freeda Brooks Suite 802', '+2696779699527', '844.748.7872', 'dullrich@hotmail.com', 'hermina.hickle@example.org', '80-18', '1491112002', 1, NULL, NULL, NULL, NULL),
(19, 'Brad', NULL, 'Hackett', 'Baumbach', 'female', '08-29-2009', '5941 Zechariah Islands Apt. 255\r\nWest Rosaliahaven', 'Marriage', 'Filipino', 'Dario Olson', '323 Murphy Lights Suite 189\r\nNew Josiah, NJ 67684', 'North Feliciaville', 'region2', '2439 Christiansen Prairie', '+5122734143634', '844-868-0584', 'pmante@predovic.com', 'anahi.hackett@example.com', '40-19', '1491112002', 1, NULL, NULL, NULL, NULL),
(20, 'Fermin', NULL, 'Powlowski', 'Quigley', 'female', '09-03-1943', '4930 Langosh Corners Suite 923\r\nConroyville, SD 52', 'Single', 'Filipino', 'Whitney Treutel', '32239 Borer Trafficway Suite 650\r\nPort Gregoriashire, AR 60929', 'North Stone', 'region2', '435 Aracely Walks Suite 303', '+5396416007280', '1-844-419-3108', 'leola.okuneva@hahn.com', 'murphy.dorris@example.org', '60-20', '1491112002', 1, NULL, NULL, NULL, NULL),
(21, 'Palma', NULL, 'Tromp', 'Schoen', 'male', '11-06-1928', '6245 Mariam Orchard\r\nSouth Rowland, VA 25125', 'Single', 'Filipino', 'Bridie Bartoletti', '2786 Winifred Path Apt. 021\r\nNew Brennanside, VT 28569-1759', 'Stoltenbergfurt', 'rgion1', '39019 Rau Squares', '+7180762231226', '1-800-540-5636', 'reagan37@haley.com', 'ybednar@example.com', '90-21', '1491112002', 1, NULL, NULL, NULL, NULL),
(22, 'Verner', NULL, 'Nitzsche', 'Weimann', 'female', '11-04-1945', '2209 Fatima Walk\r\nEast Emmetmouth, TN 93125-4852', 'Marriage', 'Filipino', 'Mitchel Legros', '523 Spinka Inlet\r\nLake Ruthie, KS 46078', 'Port Russell', 'region2', '4347 Labadie Greens Suite 973', '+3673051143343', '(800) 257-6693', 'ismael.feeney@schmidt.com', 'keebler.rupert@example.com', '60-22', '1491112002', 1, NULL, NULL, NULL, NULL),
(23, 'Violet', NULL, 'King', 'Gottlieb', 'female', '05-30-2006', '785 Abdullah Green Apt. 687\r\nTatumburgh, CO 97342-', 'Single', 'Other', 'Megane Kuhic', '25278 Jordy Landing Apt. 708\r\nDickensview, AK 51057-5960', 'Wisokyland', 'rgion1', '447 Batz Lodge Apt. 591', '+8706182062216', '888-918-5590', 'fatima.mcdermott@hotmail.com', 'layla.adams@example.net', '40-23', '1491112002', 1, NULL, NULL, NULL, NULL),
(24, 'Mozell', NULL, 'Kris', 'Gottlieb', 'male', '11-18-1934', '61730 Adeline Parks\r\nZboncakville, IL 37641-0746', 'Marriage', 'Filipino', 'Dr. Delaney Witting III', '36795 Serenity Land Apt. 868\r\nDenesikfurt, WY 55966', 'Hildegardshire', 'region4', '626 Kutch River Apt. 892', '+7017265217224', '(888) 336-2926', 'akoch@windler.biz', 'umarquardt@example.org', '20-24', '1491112002', 1, NULL, NULL, NULL, NULL),
(25, 'Derek', NULL, 'Padberg', 'Flatley', 'female', '12-03-1986', '86492 Luna Terrace Suite 145\r\nWest Sandyfort, MD 4', 'Marriage', 'Other', 'Mr. Mallory Carter Sr.', '85432 Gudrun Lights\r\nLake Zariamouth, IA 35162-8595', 'North Daren', 'region2', '62041 Lydia Camp Apt. 696', '+8223271264442', '877-822-8202', 'lamont.krajcik@feeney.net', 'jeramy53@example.org', '20-25', '1491112002', 1, NULL, NULL, NULL, NULL),
(26, 'Rowland', NULL, 'Schuster', 'Ferry', 'male', '02-14-1958', '335 Judy Course\r\nSouth Christmouth, VA 17116', 'Marriage', 'Other', 'Ramiro Brakus I', '71736 McCullough Ville\r\nJovannymouth, NE 27268-5450', 'Lake Anthonyhaven', 'rgion1', '44900 Mozell Plaza Apt. 397', '+4194571329106', '(855) 492-5033', 'jakob.ullrich@gmail.com', 'jameson26@example.com', '01-26', '1491112002', 1, NULL, NULL, NULL, NULL),
(27, 'Adelia', NULL, 'McKenzie', 'Leannon', 'female', '12-21-1945', '13602 Ledner Views Suite 730\r\nNew Corrine, OH 7038', 'Single', 'Other', 'Rosemarie Hudson', '759 Geo Road\r\nNorth Willytown, MT 50429', 'Macejkovicstad', 'region2', '13180 Ankunding Spur Apt. 677', '+3951117749626', '800.842.5268', 'kertzmann.raoul@kirlin.net', 'ykeebler@example.net', '90-27', '1491112002', 1, NULL, NULL, NULL, NULL),
(28, 'Amari', NULL, 'Rau', 'Langworth', 'male', '07-19-2002', '2808 Rudy Flat Apt. 265\r\nIsabelleside, WV 42260', 'Marriage', 'Other', 'Dr. Florian Flatley', '1477 Sipes Plain Apt. 680\r\nWest Lacyport, OR 28754-6086', 'Grantmouth', 'rgion1', '93624 Bergstrom Knolls', '+9226624600301', '866-339-0598', 'arnoldo04@yahoo.com', 'lukas60@example.org', '40-28', '1491112002', 1, NULL, NULL, NULL, NULL),
(29, 'Misael', NULL, 'Hagenes', 'Willms', 'male', '11-10-1992', '396 Lee Port\r\nNorth Arvelview, MS 32253', 'Single', 'Other', 'Palma Cruickshank', '879 Barton Run\r\nSouth Justonshire, GA 99889-0623', 'Wilfredton', 'rgion1', '641 Roberts Radial', '+9640438920654', '(888) 800-7192', 'jadon04@yahoo.com', 'kaitlyn59@example.net', '20-29', '1491112002', 1, NULL, NULL, NULL, NULL),
(30, 'Maybelle', NULL, 'Hagenes', 'Ziemann', 'female', '09-04-1944', '2356 Barton Keys Apt. 547\r\nNew Ianfurt, PA 65407', 'Marriage', 'Other', 'Ashlynn Hartmann', '1801 Lang Expressway Apt. 191\r\nNorth Taylormouth, VA 39280', 'Lake Maevefort', 'region4', '63179 Patricia Rest', '+2164407362199', '877.649.2069', 'asa64@hotmail.com', 'aniyah.trantow@example.net', '01-30', '1491112002', 1, NULL, NULL, NULL, NULL),
(31, 'Jaren', NULL, 'Graham', 'Boyle', 'female', '11-25-2009', '345 Orn Underpass\r\nJordanmouth, WA 89184', 'Marriage', 'Filipino', 'Jaydon Balistreri', '91459 Chelsey Lock\r\nHumbertofort, OK 58972', 'Maximoberg', 'region4', '428 Javier Camp', '+6075653350929', '1-888-750-4403', 'ahickle@windler.com', 'rhaag@example.org', '01-31', '1491112002', 1, NULL, NULL, NULL, NULL),
(32, 'Lorenza', NULL, 'Thiel', 'Murray', 'female', '12-31-2008', '1499 Gleason Fall\r\nEast Emmanuelleton, RI 90003', 'Single', 'Filipino', 'Ashly Schoen', '147 Maybell Wells\r\nQuitzonstad, TX 92285-1217', 'Shainaside', 'region4', '211 Heber Valleys', '+8200469213924', '(855) 612-0750', 'alind@dubuque.org', 'bernie97@example.com', '60-32', '1491112002', 1, NULL, NULL, NULL, NULL),
(33, 'Rasheed', NULL, 'Douglas', 'Quitzon', 'female', '09-08-2015', '34663 Israel Avenue\r\nNew Gregmouth, MT 39597-9309', 'Marriage', 'Other', 'Lennie Erdman', '58219 Pietro Spurs Suite 564\r\nSouth Alberta, CA 06138', 'Monahanton', 'region2', '61130 Herzog Manors', '+9809827055705', '1-800-514-0093', 'marley63@hotmail.com', 'jlind@example.com', '30-33', '1491112002', 1, NULL, NULL, NULL, NULL),
(34, 'Torey', NULL, 'Kulas', 'Schneider', 'female', '10-14-1967', '1701 Esperanza Overpass Suite 065\r\nLavernamouth, M', 'Marriage', 'Other', 'Francisco Hansen Sr.', '62319 Delia Common\r\nRutherfordland, MA 63232', 'Carterburgh', 'region4', '13710 Abernathy Landing Suite 095', '+2427620580662', '800-209-9707', 'bgusikowski@hotmail.com', 'raleigh41@example.net', '90-34', '1491112002', 1, NULL, NULL, NULL, NULL),
(35, 'Roselyn', NULL, 'Erdman', 'Bechtelar', 'male', '04-29-1919', '694 Hilpert Parks\r\nNew Ahmad, AK 11767-2970', 'Single', 'Other', 'Mr. Rosendo Gerlach II', '4808 Kunde Skyway\r\nSouth Oranmouth, NH 41033-4644', 'Lake Finn', 'region3', '9255 Casper Mountain', '+1964528477665', '877-806-7696', 'roderick.kemmer@gmail.com', 'schuster.leonard@example.net', '30-35', '1491112002', 1, NULL, NULL, NULL, NULL),
(36, 'Eliseo', NULL, 'Rodriguez', 'Bernhard', 'male', '03-22-1993', '41907 Jordy Fort Apt. 206\r\nBashiriantown, UT 22299', 'Marriage', 'Other', 'Candido Labadie', '4821 Goldner Camp\r\nHellerfort, IN 54710-1955', 'South Lorine', 'region2', '241 Fahey Springs Apt. 713', '+4381139582411', '(877) 666-1843', 'walker.marta@hotmail.com', 'elvie.shanahan@example.com', '80-36', '1491112002', 1, NULL, NULL, NULL, NULL),
(37, 'Glenda', NULL, 'Hane', 'Ferry', 'male', '04-15-1969', '35045 Adella Shoals\r\nPort Jalyn, IL 52230', 'Single', 'Filipino', 'Renee Jast', '611 Nicolas Course Suite 398\r\nSouth Urbanland, VT 41511-7170', 'West Tressie', 'region4', '8231 Koss Route', '+8481023842658', '(800) 912-4812', 'dmitchell@hotmail.com', 'xgibson@example.com', '70-37', '1491112002', 1, NULL, NULL, NULL, NULL),
(38, 'Amir', NULL, 'Pfeffer', 'Tillman', 'female', '08-05-1977', '842 Bednar Terrace Suite 990\r\nBahringermouth, WV 4', 'Marriage', 'Other', 'Eleanora Stracke', '993 Coby Court\r\nSashaborough, AK 27783-5150', 'Brownland', 'rgion1', '420 Barton Tunnel', '+5502799624778', '(877) 300-7017', 'murazik.delores@dare.com', 'alivia68@example.org', '50-38', '1491112002', 1, NULL, NULL, NULL, NULL),
(39, 'Nat', NULL, 'Berge', 'Funk', 'female', '07-31-1961', '5297 Daugherty Point Suite 702\r\nGinatown, WV 71437', 'Single', 'Other', 'Corene Powlowski IV', '74427 Einar Common Apt. 928\r\nNorth Isidro, CA 06965-0439', 'East Macie', 'region3', '74160 O Connell Pines Apt. 369', '+7634265418983', '855.686.8379', 'amira50@hotmail.com', 'gusikowski.brock@example.com', '40-39', '1491112002', 1, NULL, NULL, NULL, NULL),
(40, 'Amani', NULL, 'Schmitt', 'Parker', 'male', '07-04-1995', '4495 Kylee Shoals Apt. 854\r\nDeckowville, MO 19873-', 'Marriage', 'Other', 'Furman Aufderhar', '359 Winona Shoals\r\nNew Tomas, VT 48972-3763', 'Ryanport', 'region3', '3595 Frami Avenue', '+4455778324113', '1-800-826-4766', 'ahuels@nolan.com', 'glover.lionel@example.net', '40-40', '1491112002', 1, NULL, NULL, NULL, NULL),
(41, 'Jamarcus', NULL, 'Jacobs', 'Lynch', 'female', '07-03-1977', '4970 Andreane Locks\r\nEast Joelle, MI 74350-2421', 'Marriage', 'Other', 'Mireille Terry', '3294 Goldner Lodge Suite 404\r\nNew Emmittburgh, IA 13510-3205', 'Lynchborough', 'region2', '576 McLaughlin Light', '+8266695808298', '(844) 523-2160', 'legros.raymundo@hotmail.com', 'lcasper@example.org', '01-41', '1491112002', 1, NULL, NULL, NULL, NULL),
(42, 'Taya', NULL, 'Rohan', 'Flatley', 'female', '09-26-1977', '27929 Waelchi Green Suite 931\r\nConnhaven, VT 67789', 'Single', 'Filipino', 'Keegan Rolfson Jr.', '384 Dina Lodge Suite 268\r\nSouth Sabinaville, AR 19924-6759', 'Port Lessiefort', 'region4', '1144 Veronica Square', '+5757707275988', '1-800-568-8910', 'ellen.upton@breitenberg.com', 'ijacobson@example.org', '50-42', '1491112002', 1, NULL, NULL, NULL, NULL),
(43, 'Kathryne', NULL, 'McLaughlin', 'Kunde', 'female', '01-04-1945', '4159 Elenor Corner\r\nNorth Andyhaven, RI 53469', 'Single', 'Other', 'Heidi Okuneva', '6037 Esteban Springs Apt. 795\r\nNew Cristina, SD 84580', 'Lake Savanna', 'rgion1', '840 Swaniawski Street Suite 172', '+7424002329490', '1-844-821-5598', 'bernard.walker@gmail.com', 'maria43@example.net', '40-43', '1491112002', 1, NULL, NULL, NULL, NULL),
(44, 'Queen', NULL, 'Ullrich', 'Zboncak', 'female', '03-04-1957', '6432 Tommie Rest Apt. 267\r\nEast Freda, CA 98001', 'Single', 'Filipino', 'Kameron Hickle', '392 Delmer River\r\nPort Wilhelmine, IL 52361', 'South Elmerborough', 'rgion1', '2247 Morar Walk Suite 287', '+6715714899203', '800.599.0627', 'jordan.aufderhar@hettinger.net', 'daniella35@example.org', '90-44', '1491112002', 1, NULL, NULL, NULL, NULL),
(45, 'Brett', NULL, 'Leannon', 'Bergstrom', 'male', '09-17-1996', '19930 Rocky Junctions Suite 086\r\nWillmsfort, LA 99', 'Marriage', 'Filipino', 'Thurman Stroman', '370 Lilla Hills Apt. 821\r\nEast Trystan, WI 16302-4162', 'Lake Aglaeview', 'region2', '221 Smith Wall', '+3329256911927', '1-888-877-7111', 'nayeli.brakus@conn.com', 'huels.danial@example.org', '01-45', '1491112002', 1, NULL, NULL, NULL, NULL),
(46, 'Anderson', NULL, 'Lehner', 'Hauck', 'female', '11-28-2002', '812 DuBuque Flats Suite 295\r\nLueilwitzshire, SD 58', 'Marriage', 'Other', 'Veronica Paucek', '66063 Wolf Route\r\nLake Meaganborough, MS 05573-6355', 'Hamillshire', 'rgion1', '8513 Schneider Circles', '+6168297241266', '800-792-1834', 'xlegros@gmail.com', 'lizzie49@example.org', '90-46', '1491112002', 1, NULL, NULL, NULL, NULL),
(47, 'Veronica', NULL, 'Smitham', 'Donnelly', 'female', '06-01-1971', '492 Skiles Hill\r\nJohnsonside, OH 87274-2651', 'Single', 'Filipino', 'Moshe Durgan II', '3296 Quentin Common Suite 461\r\nEast Deannafurt, IL 15425-5123', 'New Halle', 'region4', '6668 Jacynthe Forge Suite 009', '+3844454684102', '1-844-219-8148', 'natalie.goodwin@gmail.com', 'irving83@example.org', '60-47', '1491112002', 1, NULL, NULL, NULL, NULL),
(48, 'Edgar', NULL, 'Corwin', 'Emard', 'male', '03-13-1941', '753 Kendrick Spur Suite 749\r\nMaryjaneborough, PA 3', 'Single', 'Filipino', 'Ayden Koepp III', '823 Jerry Corner\r\nWhitneyland, DC 74773-4282', 'Nadiamouth', 'region3', '401 Bartell Corners Suite 082', '+6817405939864', '800-523-1345', 'rosie.hirthe@hotmail.com', 'annette.mccullough@example.net', '50-48', '1491112002', 1, NULL, NULL, NULL, NULL),
(49, 'Julie', NULL, 'Bayer', 'Cronin', 'female', '12-17-2016', '139 Alan Cliffs\r\nReinatown, AK 92965-5667', 'Single', 'Filipino', 'Aleen Blick I', '2392 America Lane\r\nWest Cleostad, DC 94043', 'Monicamouth', 'rgion1', '5967 Marcelino Rue Suite 699', '+4987013872914', '(877) 750-6709', 'franecki.glen@jakubowski.org', 'will.rubye@example.net', '50-49', '1491112002', 1, NULL, NULL, NULL, NULL),
(50, 'Kaylie', NULL, 'Friesen', 'Corkery', 'female', '03-16-1953', '97412 Lynch Freeway\r\nEast Birdieville, SD 77821-56', 'Single', 'Filipino', 'Jeremie Christiansen', '25589 Balistreri Isle\r\nBednarfort, NJ 20737-8274', 'South Abdielport', 'region2', '76654 Eleanora Stream Apt. 986', '+1616147252505', '(888) 484-5381', 'qritchie@schaefer.info', 'sking@example.com', '20-50', '1491112002', 1, NULL, NULL, NULL, NULL),
(51, 'Madaline', NULL, 'Dietrich', 'Yost', 'male', '08-13-1958', '76528 Harris Ferry Suite 314\r\nSouth Orloshire, IA ', 'Marriage', 'Filipino', 'Hayden Sipes', '803 Reynolds Trafficway Suite 896\r\nLeuschkeport, OH 83236', 'Handside', 'region3', '51915 Brown Rapids Apt. 587', '+8686523626196', '866-365-3194', 'jannie69@gmail.com', 'aniya03@example.com', '60-51', '1491112002', 1, NULL, NULL, NULL, NULL),
(52, 'Amaya', NULL, 'Walsh', 'Langworth', 'male', '08-02-1972', '592 Niko Drive\r\nWisokyshire, NY 52695', 'Single', 'Filipino', 'Newton Schulist', '2603 Reese Ramp\r\nLake Bertha, OH 69414-5063', 'Port Jaquan', 'region3', '645 Lowell Knoll', '+8095686014573', '1-800-842-5735', 'cmorissette@yahoo.com', 'ggutkowski@example.com', '50-52', '1491112002', 1, NULL, NULL, NULL, NULL),
(53, 'Donnie', NULL, 'Jerde', 'Muller', 'female', '11-21-1997', '84792 Hahn Lakes Suite 855\r\nColtonside, LA 34102', 'Single', 'Other', 'Isadore Blick', '18949 Geovany Glens\r\nReedmouth, NV 30186-5857', 'Vandervortmouth', 'region3', '7645 Padberg Mountains Apt. 975', '+9018711802308', '1-855-607-8509', 'hodkiewicz.kaylie@luettgen.net', 'tyshawn.jacobi@example.org', '20-53', '1491112002', 1, NULL, NULL, NULL, NULL),
(54, 'Shana', NULL, 'Dare', 'Wilkinson', 'female', '11-15-2016', '7336 Swift Coves\r\nNew Helenatown, OK 28115', 'Marriage', 'Other', 'Janie Volkman', '4298 Cronin Extension Apt. 629\r\nLubowitzview, MA 52568', 'Wendyshire', 'rgion1', '55110 McKenzie Fords', '+4731883411372', '1-888-908-4621', 'virgie.jaskolski@yahoo.com', 'hulda.frami@example.com', '01-54', '1491112002', 1, NULL, NULL, NULL, NULL),
(55, 'Kevin', NULL, 'Herman', 'Weissnat', 'female', '12-22-1986', '1242 Gregory Shores\r\nSimonisshire, WY 46293-4941', 'Single', 'Filipino', 'Dr. Grover Hudson DVM', '420 Ebert Road\r\nMontyburgh, CO 49495', 'Reingerborough', 'region4', '5971 Lucious Islands Suite 163', '+4119427976581', '1-800-570-8319', 'kunze.reba@littel.com', 'sylvia64@example.com', '01-55', '1491112002', 1, NULL, NULL, NULL, NULL),
(56, 'Pascale', NULL, 'Collier', 'Legros', 'male', '02-28-1975', '289 Kozey Junctions\r\nPort Else, SD 48468', 'Marriage', 'Filipino', 'Werner Emard', '45915 Glover Mall\r\nNorth Kaiaville, HI 91194', 'New Toney', 'rgion1', '503 Sawayn Valley', '+2330995948946', '(866) 976-6498', 'jerod.mertz@gmail.com', 'gregorio.mante@example.com', '90-56', '1491112002', 1, NULL, NULL, NULL, NULL),
(57, 'Tony', NULL, 'Crooks', 'Mante', 'male', '08-13-2014', '234 Abbott Mountains Apt. 661\r\nHartmannport, AR 39', 'Marriage', 'Filipino', 'Prof. Novella Bruen DVM', '21775 Kamryn Light\r\nLake Penelope, MA 06490', 'East Nevaport', 'region4', '2488 Hermiston Radial Apt. 254', '+1229379996832', '(888) 912-4977', 'curt.grady@hotmail.com', 'waelchi.marcella@example.net', '40-57', '1491112002', 1, NULL, NULL, NULL, NULL),
(58, 'Edwardo', NULL, 'Mraz', 'Carter', 'male', '02-21-1926', '78811 Annette Drive Apt. 728\r\nKundeview, SD 38174', 'Marriage', 'Filipino', 'Rubie Borer', '803 Gleason Cliff\r\nPort Lenny, SC 98418', 'Keelingville', 'region2', '57798 Baumbach Underpass', '+6881270845687', '844-727-9259', 'karlee.hahn@hotmail.com', 'dortha86@example.com', '90-58', '1491112002', 1, NULL, NULL, NULL, NULL),
(59, 'Cheyenne', NULL, 'Batz', 'Pfeffer', 'female', '03-25-1974', '59020 Melisa Radial\r\nChynaberg, MD 33557', 'Marriage', 'Other', 'Leilani Turcotte DVM', '571 Simonis Dam\r\nLindaville, NM 61786', 'Faustinoport', 'region3', '67894 Kory Park Suite 546', '+1034965186605', '866.917.6987', 'bshanahan@hotmail.com', 'johnathan.erdman@example.com', '70-59', '1491112002', 1, NULL, NULL, NULL, NULL),
(60, 'Mya', NULL, 'Homenick', 'Armstrong', 'male', '12-05-1999', '500 Niko Square\r\nWest Gretchen, PA 71592-9154', 'Marriage', 'Other', 'Miss Martina Sporer', '5743 Marks Dale Apt. 183\r\nEast Zellafurt, OR 08467', 'Ethylview', 'region4', '202 Kertzmann Glens', '+2025947638327', '844-883-1875', 'vivien90@gmail.com', 'maudie67@example.org', '50-60', '1491112002', 1, NULL, NULL, NULL, NULL),
(61, 'Austen', NULL, 'Ward', 'Brekke', 'female', '09-11-1931', '858 Cassin Views Apt. 154\r\nMayertmouth, GA 61366-8', 'Marriage', 'Other', 'Augusta Gottlieb', '13845 Corwin Ville Suite 172\r\nKerlukechester, RI 67624', 'Lake Fidel', 'region2', '919 Howe Parkways Suite 543', '+3140853299687', '(844) 703-7463', 'hane.lonzo@gmail.com', 'osawayn@example.org', '60-61', '1491112002', 1, NULL, NULL, NULL, NULL),
(62, 'Amely', NULL, 'Vandervort', 'Cruickshank', 'male', '02-24-1966', '91235 Grant Ridge Suite 232\r\nAuerburgh, MO 75225-6', 'Single', 'Filipino', 'Megane Kautzer DVM', '52268 Mohr Island Suite 634\r\nMaeberg, MT 32256-1658', 'South Jarrett', 'region2', '32189 McLaughlin Points Apt. 238', '+9243410647236', '1-877-703-0163', 'raoul.rolfson@gmail.com', 'colleen27@example.org', '90-62', '1491112002', 1, NULL, NULL, NULL, NULL),
(63, 'Jackeline', NULL, 'Quitzon', 'Paucek', 'female', '02-12-1921', '20037 Kilback Isle Apt. 296\r\nAnkundingtown, MT 496', 'Marriage', 'Other', 'Chaya Monahan', '74692 Brody Grove Suite 667\r\nNew Bryana, VT 88317-3152', 'Dietrichfort', 'region2', '64378 Shana Locks', '+9228435092441', '844.708.0873', 'laurianne.kautzer@paucek.com', 'vivienne.turner@example.com', '70-63', '1491112002', 1, NULL, NULL, NULL, NULL),
(64, 'Newton', NULL, 'Gleason', 'Boyer', 'male', '03-09-1950', '266 Quigley Isle Apt. 475\r\nEast Kiel, OK 03944', 'Marriage', 'Filipino', 'Dr. Maverick Okuneva', '38767 Upton Forges\r\nNorth Helen, WV 30797-4451', 'Gusikowskiview', 'region3', '14358 Kilback Lane Apt. 666', '+7435281582838', '844-441-8049', 'filomena.romaguera@gmail.com', 'kassulke.winnifred@example.com', '70-64', '1491112002', 1, NULL, NULL, NULL, NULL),
(65, 'Gonzalo', NULL, 'Paucek', 'Kuhlman', 'female', '09-04-1924', '46884 Rosa Loop\r\nWest Arlene, IL 26681', 'Single', 'Filipino', 'Dr. Damaris Treutel DVM', '3004 Altenwerth Plains Apt. 892\r\nO Connellport, MA 33917', 'Port Kaylie', 'region2', '69975 Quigley Flats', '+5920961197492', '(800) 919-1135', 'mcruickshank@heaney.com', 'houston06@example.org', '50-65', '1491112002', 1, NULL, NULL, NULL, NULL),
(66, 'Roscoe', NULL, 'Farrell', 'Turner', 'male', '01-18-1970', '2876 Bashirian Run\r\nCecileville, ND 30286-1236', 'Marriage', 'Filipino', 'Nicolas Leuschke', '414 Hillary Forest Suite 983\r\nTorpburgh, NV 96418-4552', 'Majorside', 'region4', '9398 Donnelly Island', '+9290776135836', '1-888-354-8459', 'ashlee01@schmeler.info', 'padberg.amya@example.com', '60-66', '1491112002', 1, NULL, NULL, NULL, NULL),
(67, 'Kellie', NULL, 'Spencer', 'Braun', 'female', '02-15-2014', '8974 Beatty Locks\r\nWest Maryam, WV 80390', 'Single', 'Other', 'Hester Schiller', '914 Bergstrom Extensions Apt. 196\r\nIvorytown, CO 81576', 'Mortonchester', 'region3', '7003 Kailee Bridge', '+6470174747056', '800-494-5832', 'ashley.blick@yahoo.com', 'spencer.cicero@example.com', '50-67', '1491112002', 1, NULL, NULL, NULL, NULL),
(68, 'Barbara', NULL, 'Parker', 'Lang', 'female', '10-29-1954', '713 Gleason Vista Apt. 362\r\nBergstromfort, TN 8814', 'Marriage', 'Filipino', 'Magnolia Boehm II', '30676 Jeanie Mount\r\nLake Winnifred, WY 21686-3223', 'East Aliza', 'region3', '3127 Steuber Pine', '+4757373127865', '(844) 440-2772', 'hmiller@hotmail.com', 'beier.brandon@example.net', '80-68', '1491112002', 1, NULL, NULL, NULL, NULL),
(69, 'Maurine', NULL, 'Goyette', 'Kohler', 'male', '11-07-1932', '3128 Reichel Glens\r\nWest Rosella, SD 23569', 'Marriage', 'Other', 'Lonnie Murray', '752 Salvatore Green Apt. 096\r\nLemkeview, MT 89826', 'Ondrickashire', 'rgion1', '6433 Malachi Motorway Suite 269', '+2048998046470', '888.832.4502', 'jamey69@hotmail.com', 'deonte.windler@example.org', '90-69', '1491112002', 1, NULL, NULL, NULL, NULL),
(70, 'Pattie', NULL, 'Satterfield', 'Collins', 'female', '09-22-1988', '877 Herman Dale Suite 308\r\nSatterfieldfurt, WI 295', 'Single', 'Other', 'Dr. Jacynthe Crist DVM', '81237 Ullrich River\r\nAshlynnfurt, MD 42329', 'New Sigurd', 'region2', '2626 Fay Turnpike Apt. 457', '+4421111180474', '1-844-308-7320', 'frodriguez@yahoo.com', 'lelah.ondricka@example.net', '60-70', '1491112002', 1, NULL, NULL, NULL, NULL),
(71, 'Katelin', NULL, 'Homenick', 'Klein', 'female', '08-04-1953', '5183 Dibbert Circles\r\nGibsonton, VT 03496', 'Single', 'Other', 'Emory Hyatt', '79509 Modesto Center Suite 941\r\nEast Kylaberg, OR 58152', 'Blickfort', 'region4', '204 Feest Rapids Apt. 875', '+1720902291467', '800.320.5647', 'ubahringer@mckenzie.com', 'koelpin.gabriel@example.org', '70-71', '1491112002', 1, NULL, NULL, NULL, NULL),
(72, 'Deon', NULL, 'Johnson', 'Lind', 'female', '09-02-1988', '646 Tabitha Mews\r\nEast Petratown, VA 83459-7423', 'Single', 'Other', 'Roma Huels', '5684 Legros Locks Suite 382\r\nOscarfurt, AK 61669', 'Treutelstad', 'region3', '5000 Davis Park Suite 414', '+4944999891743', '877.219.4008', 'guiseppe.mckenzie@kunde.org', 'andreane46@example.net', '60-72', '1491112002', 1, NULL, NULL, NULL, NULL),
(73, 'Sonny', NULL, 'Senger', 'Williamson', 'male', '09-24-1997', '27111 Claude Turnpike Apt. 360\r\nWest Gregorio, WA ', 'Single', 'Filipino', 'Prof. Annamarie Rice II', '972 Kilback Passage\r\nNew Royceview, AK 19942-1493', 'North Alda', 'region2', '188 Nia Stravenue', '+2718964066527', '855-474-9384', 'kaden83@lockman.com', 'egutkowski@example.org', '30-73', '1491112002', 1, NULL, NULL, NULL, NULL),
(74, 'Olaf', NULL, 'Reinger', 'Abernathy', 'female', '03-03-1970', '40953 Schowalter Curve Suite 861\r\nLake Ianburgh, W', 'Single', 'Filipino', 'Madie Friesen IV', '59617 Cummerata Ridge\r\nEast Ursula, OH 43307-0763', 'Rolfsonshire', 'region3', '492 April Club', '+9865408275544', '866.482.1245', 'zkunde@yahoo.com', 'alex36@example.com', '40-74', '1491112002', 1, NULL, NULL, NULL, NULL),
(75, 'Rahsaan', NULL, 'Lindgren', 'Cronin', 'male', '12-28-2003', '8147 Donnelly Viaduct Suite 804\r\nPort Rhiannon, WY', 'Single', 'Other', 'Sebastian Bechtelar', '54964 Lyda Ports\r\nPort Maurine, MN 75255-9023', 'North Zaneshire', 'region3', '5438 Bechtelar Isle', '+9218260366517', '877-395-0560', 'oda41@hotmail.com', 'vergie.morissette@example.net', '60-75', '1491112002', 1, NULL, NULL, NULL, NULL),
(76, 'Jennie', NULL, 'Purdy', 'Kerluke', 'female', '10-16-1989', '2933 Leannon Streets\r\nWest Zacktown, MO 73278-3453', 'Single', 'Filipino', 'Miss Tomasa Klein II', '74020 Logan Forges Apt. 898\r\nPort Adolf, SD 48686', 'New Davion', 'rgion1', '2727 Gladyce Valley', '+9215364511789', '(888) 494-4412', 'hlittle@ernser.biz', 'ilynch@example.com', '20-76', '1491112002', 1, NULL, NULL, NULL, NULL),
(77, 'Lincoln', NULL, 'Shields', 'Koepp', 'male', '11-16-1949', '5104 Heaney Valleys\r\nNoemiborough, LA 51223-4090', 'Single', 'Other', 'Prof. Clement Heidenreich MD', '497 Ashly Ramp Apt. 794\r\nLake Nathanialfurt, OR 96925-9897', 'Port Carissaberg', 'region2', '207 Osinski Mission Suite 534', '+2684761052683', '855.248.6837', 'hwilderman@gutmann.com', 'orn.kenton@example.com', '80-77', '1491112002', 1, NULL, NULL, NULL, NULL),
(78, 'Alessia', NULL, 'Pagac', 'Cassin', 'female', '12-17-1985', '283 Metz Crossing\r\nGrahamview, TN 69419-6466', 'Single', 'Other', 'Ava Raynor', '6369 Kris Brooks\r\nSouth Alanside, CT 12155-0304', 'East Aylinville', 'region4', '9947 Rozella Forest', '+5098714090174', '877-420-9378', 'howe.braden@hotmail.com', 'kassulke.teresa@example.org', '30-78', '1491112002', 1, NULL, NULL, NULL, NULL),
(79, 'Halie', NULL, 'Crooks', 'Reilly', 'male', '09-18-1985', '88225 Lemke Forks\r\nLake Flaviomouth, CO 82906-6076', 'Single', 'Filipino', 'Mr. Mervin Donnelly', '2184 Sawayn Ferry Suite 381\r\nNorth Giuseppeberg, CT 86876', 'Skylarport', 'region3', '951 Fletcher Coves Apt. 852', '+9139698081614', '800-532-3090', 'noemy.lindgren@yahoo.com', 'lonnie05@example.net', '20-79', '1491112002', 1, NULL, NULL, NULL, NULL),
(80, 'Raul', NULL, 'Marquardt', 'King', 'male', '08-09-1983', '924 Kris Way\r\nMonahanborough, DC 00961-3360', 'Single', 'Filipino', 'Christian Wolff', '3954 Bayer Throughway\r\nLake Sallieborough, NM 16499', 'North Sophietown', 'region2', '78646 Monserrate Mountain Suite 367', '+8501814935007', '1-844-442-3419', 'alessia.boyle@moen.info', 'zmann@example.com', '90-80', '1491112002', 1, NULL, NULL, NULL, NULL),
(81, 'Nathaniel', NULL, 'Kiehn', 'Stanton', 'male', '10-12-1924', '4965 Winona Neck\r\nPort Scarlett, DC 13561', 'Marriage', 'Filipino', 'Casimir Gulgowski', '46603 Kreiger Prairie\r\nJoshuafurt, HI 61232', 'Durganborough', 'region4', '973 Francesca Fords Suite 329', '+5320471331277', '877.748.4537', 'xlakin@wisozk.com', 'gibson.gretchen@example.com', '70-81', '1491112002', 1, NULL, NULL, NULL, NULL),
(82, 'Keith', NULL, 'Jacobson', 'Hettinger', 'female', '11-26-1947', '15698 Yolanda Mall Apt. 221\r\nSouth Adolfo, SC 8453', 'Single', 'Filipino', 'Madison Dietrich', '97901 Stiedemann Avenue\r\nLake Domingo, MO 21749-5598', 'New Arvelstad', 'region4', '802 Murphy Cape Suite 957', '+2171256401624', '(866) 741-6768', 'frami.velma@yahoo.com', 'gerardo48@example.com', '50-82', '1491112002', 1, NULL, NULL, NULL, NULL),
(83, 'Lamont', NULL, 'Feest', 'Smitham', 'male', '07-18-1954', '7224 Violet Fork\r\nEast Napoleonhaven, DE 64049-831', 'Single', 'Other', 'Maggie Crooks', '86918 Gislason Rue Apt. 968\r\nLake Javon, AZ 30218-1845', 'West Moises', 'rgion1', '49958 Leora Drives', '+5374038421667', '877.402.0521', 'qbernhard@hotmail.com', 'vkiehn@example.net', '60-83', '1491112002', 1, NULL, NULL, NULL, NULL),
(84, 'Fleta', NULL, 'Koch', 'Hickle', 'female', '04-10-1982', '86621 Braulio Viaduct Suite 358\r\nLake Vivianne, OK', 'Marriage', 'Other', 'Alysson McCullough', '7497 Howe Drive\r\nShanahanmouth, TN 80923', 'North Solonbury', 'region4', '846 Maryjane Brook', '+1231219165947', '888.537.1672', 'dannie04@yahoo.com', 'omuller@example.net', '60-84', '1491112002', 1, NULL, NULL, NULL, NULL),
(85, 'Jaydon', NULL, 'Kling', 'Harris', 'female', '04-25-1918', '585 Dedrick Forest Apt. 712\r\nWelchshire, NM 33421', 'Marriage', 'Filipino', 'Breana Carter Jr.', '7197 VonRueden Radial\r\nSydniport, MN 85173-5503', 'South Ansleyhaven', 'region4', '507 Schiller Road Suite 484', '+9134498081654', '(855) 624-8404', 'brown.ruth@gmail.com', 'keebler.dee@example.org', '80-85', '1491112002', 1, NULL, NULL, NULL, NULL),
(86, 'Camden', NULL, 'Pfeffer', 'Rempel', 'male', '12-01-1948', '6883 Lubowitz Row Apt. 933\r\nEast Suzanneberg, MT 1', 'Marriage', 'Other', 'Prof. Tina Mueller I', '74260 Skiles Harbors Apt. 028\r\nNew Aniyaberg, NM 64883-0613', 'East Braeden', 'region2', '99330 Rosanna Corners', '+5699211681416', '1-888-670-4573', 'lawson.pollich@hahn.com', 'abshire.freddy@example.net', '40-86', '1491112002', 1, NULL, NULL, NULL, NULL),
(87, 'Muhammad', NULL, 'Quitzon', 'McDermott', 'female', '05-05-1924', '90109 Wilderman Valleys Suite 683\r\nNorth Rosemary,', 'Marriage', 'Filipino', 'Gwen Strosin', '99247 Marquardt Terrace\r\nHahnville, AZ 83299', 'Lake Frederique', 'region2', '699 Jayda Hollow Suite 748', '+3726098231944', '855.896.1212', 'luisa16@hirthe.com', 'felton.jacobs@example.com', '20-87', '1491112002', 1, NULL, NULL, NULL, NULL),
(88, 'Autumn', NULL, 'Hagenes', 'Hermann', 'male', '07-30-1955', '15654 Mertz Row Suite 733\r\nTrudieberg, UT 47669', 'Marriage', 'Filipino', 'Lexie Dibbert', '5979 Alec Canyon\r\nKaitlynville, AL 50014', 'Schneiderberg', 'region3', '153 Schiller Falls', '+7536257888150', '866.837.9202', 'armstrong.keyon@smith.com', 'baron01@example.org', '60-88', '1491112002', 1, NULL, NULL, NULL, NULL),
(89, 'Ilene', NULL, 'Runte', 'Brekke', 'female', '05-13-1921', '52990 Amy Centers\r\nGusikowskiland, ND 77553-6619', 'Marriage', 'Other', 'Cecil Hamill DDS', '7170 Ferry Ports Apt. 995\r\nCarolannefort, MS 83477', 'Port Donato', 'region2', '718 Bernier Manor Suite 143', '+8608887410779', '888-639-8667', 'dankunding@yahoo.com', 'ramon34@example.net', '90-89', '1491112002', 1, NULL, NULL, NULL, NULL),
(90, 'Vernie', NULL, 'Davis', 'Hettinger', 'male', '08-25-1964', '4509 Moore Light\r\nAriberg, NM 31383', 'Marriage', 'Filipino', 'Quinten Ebert PhD', '2007 Feest Park\r\nGiovannyfurt, MO 00246', 'Fabianbury', 'rgion1', '56819 Schaefer Harbors', '+8409018213688', '(888) 316-7576', 'ymertz@yahoo.com', 'bednar.orie@example.net', '70-90', '1491112002', 1, NULL, NULL, NULL, NULL),
(91, 'Ewell', NULL, 'Simonis', 'Osinski', 'male', '08-29-1991', '23846 Christ Prairie Apt. 463\r\nRippinland, NM 5903', 'Marriage', 'Other', 'Dell Stracke', '9434 Kaden Highway\r\nLorenaberg, FL 53187-4235', 'North Valentina', 'region2', '16404 Wilkinson Overpass', '+3595796818169', '1-855-448-4068', 'maybell.dubuque@kub.biz', 'hermann.zetta@example.org', '60-91', '1491112002', 1, NULL, NULL, NULL, NULL),
(92, 'Quincy', NULL, 'Hintz', 'Reilly', 'male', '06-23-1996', '63210 Beahan Mews\r\nSouth Claudiestad, VA 64992', 'Marriage', 'Other', 'Marilyne Ruecker', '731 Liliane Square\r\nJakubowskiland, NM 42221-4191', 'Larkinview', 'region2', '375 Shakira Mission', '+6566176281200', '800-495-0494', 'mills.osvaldo@cruickshank.com', 'hope97@example.org', '20-92', '1491112002', 1, NULL, NULL, NULL, NULL),
(93, 'Samara', NULL, 'Renner', 'Williamson', 'male', '07-24-1921', '5232 Mya Lakes Suite 224\r\nNew Johnson, PA 07337', 'Marriage', 'Other', 'Miss Gwen Lang', '1664 Kautzer Meadow Apt. 202\r\nWest Santos, IN 17587', 'McKenziestad', 'region2', '4759 Floyd Shoals Suite 803', '+6697088027536', '888-224-0258', 'stark.jorge@ohara.info', 'tyra85@example.com', '50-93', '1491112002', 1, NULL, NULL, NULL, NULL),
(94, 'Ollie', NULL, 'Stark', 'Auer', 'female', '06-07-1964', '6529 Hoeger Squares Suite 276\r\nYoshikoton, MO 1089', 'Single', 'Other', 'Ezequiel Mosciski', '35069 Emiliano Passage\r\nEast Presley, WV 67672', 'New Nealmouth', 'region2', '4063 Lavada Islands Apt. 048', '+9715883490551', '844-306-3769', 'lhessel@hotmail.com', 'jlynch@example.com', '50-94', '1491112002', 1, NULL, NULL, NULL, NULL),
(95, 'Therese', NULL, 'Hackett', 'Erdman', 'female', '05-31-2009', '9131 Rogahn Shoals\r\nNorth Izabellahaven, VA 93768-', 'Marriage', 'Other', 'Mrs. Elyssa Rosenbaum MD', '86842 Rippin Mission Suite 179\r\nLake Tessie, DE 52313-9144', 'South Cicerostad', 'region3', '633 Mariam Lakes Suite 665', '+8154711707715', '1-866-721-0341', 'egrady@yahoo.com', 'nestor.emmerich@example.com', '30-95', '1491112002', 1, NULL, NULL, NULL, NULL),
(96, 'Adeline', NULL, 'Rowe', 'Reynolds', 'female', '12-15-1919', '623 Phyllis Radial\r\nPort Louie, NV 09256-8538', 'Single', 'Filipino', 'Benton Bergnaum', '79956 Corkery Key Apt. 379\r\nNorth Jennieville, MD 04079-5695', 'South Rafael', 'rgion1', '53323 Daryl Parkways Suite 734', '+7797630168836', '888-383-1665', 'ckiehn@yahoo.com', 'nmarks@example.com', '20-96', '1491112002', 1, NULL, NULL, NULL, NULL),
(97, 'Lonie', NULL, 'Deckow', 'Hermann', 'female', '09-20-1933', '889 Murray Landing\r\nPort Karliebury, RI 71909', 'Marriage', 'Other', 'Johann Aufderhar', '60493 Lorena Knolls\r\nIvafurt, MA 70227-2694', 'East Brennonmouth', 'region4', '5663 Ursula Inlet Apt. 830', '+2613117839178', '866-209-6572', 'ogleason@hotmail.com', 'louvenia.koss@example.com', '80-97', '1491112002', 1, NULL, NULL, NULL, NULL),
(98, 'Pablo', NULL, 'Schroeder', 'Ankunding', 'female', '04-13-1981', '156 Medhurst Stravenue\r\nBergnaumchester, GA 06914-', 'Single', 'Other', 'Domingo Thompson', '5254 Genesis Points\r\nDickifort, VA 28805-0030', 'West Moniqueport', 'region4', '73284 Clare Estates', '+1399696283753', '(877) 874-5510', 'maida.farrell@gmail.com', 'tluettgen@example.com', '40-98', '1491112002', 1, NULL, NULL, NULL, NULL),
(99, 'Beau', NULL, 'Berge', 'Dach', 'male', '06-21-2011', '21498 Edwardo Falls\r\nStammland, VT 93026-5842', 'Single', 'Other', 'Prof. William Powlowski MD', '878 Jon Lights\r\nNew Brenna, LA 27206-1236', 'Briaville', 'region3', '7105 Zoie Rapid Apt. 734', '+7884392282999', '877.743.0554', 'hartmann.garnett@kassulke.com', 'genevieve.rolfson@example.net', '80-99', '1491112002', 1, NULL, NULL, NULL, NULL),
(100, 'Maynard', NULL, 'Schowalter', 'Huel', 'male', '08-28-1996', '19398 Jammie Park Apt. 011\r\nRudolphville, MO 97978', 'Single', 'Other', 'Simone Blick', '1163 Landen Mill\r\nMillsborough, AR 22180', 'Port Suzanne', 'region2', '49942 Frami Union Apt. 948', '+3234532164336', '877.947.1721', 'htoy@hegmann.info', 'moses02@example.net', '20-100', '1491112002', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students_subjects`
--

CREATE TABLE `students_subjects` (
  `student_subject_id` int(8) UNSIGNED NOT NULL,
  `enrollment_id` int(11) NOT NULL,
  `subject_offer_id` int(11) NOT NULL,
  `student_subject_enroll_status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `students_subjects`
--

INSERT INTO `students_subjects` (`student_subject_id`, `enrollment_id`, `subject_offer_id`, `student_subject_enroll_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(27, 7, 6, 1, '1491101213', 1, NULL, NULL, '1491106324', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(8) UNSIGNED NOT NULL,
  `subject_code` varchar(50) NOT NULL,
  `subject_description` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'Engl 111', 'Communication Arts', '1490273057', 1, NULL, NULL, NULL, NULL),
(2, 'IT 111', 'It Fundamentals', '1490273080', 1, NULL, NULL, NULL, NULL),
(3, 'AMT 111', 'Fundamentals of Aero Math', '1490273531', 1, NULL, NULL, NULL, NULL),
(4, 'AMT 112', 'Theory of Flight', '1490273558', 1, NULL, NULL, NULL, NULL),
(5, 'AMT 113', 'Mechanical Drawing & Blueprints', '1490273607', 1, NULL, NULL, NULL, NULL),
(6, 'AMT 114', 'A/C Power plant I (Reciprocating Engine)', '1490277785', 1, NULL, NULL, NULL, NULL),
(7, 'AMT 115', 'A/C Materials Construction & Repair', '1490277981', 1, NULL, NULL, NULL, NULL),
(8, 'P.E. 111', 'Physical Ecducation I', '1490279027', 1, NULL, NULL, NULL, NULL),
(9, 'NSTP 111', 'National Service Training Program', '1490279067', 1, NULL, NULL, NULL, NULL),
(10, 'Engl 121', 'English Grammar & Composition II', '1490279159', 1, NULL, NULL, NULL, NULL),
(11, 'IT 121', 'Introduction to Internet Web-Base Programming', '1490279201', 1, NULL, NULL, NULL, NULL),
(12, 'AMT 121', 'Pnedraulics', '1490279251', 1, NULL, NULL, NULL, NULL),
(13, 'AMT 122', 'Aircraft Propellers', '1490279293', 1, NULL, NULL, NULL, NULL),
(14, 'AMT 123', 'A/C Fuels & Fuels System', '1490279487', 1, NULL, NULL, NULL, NULL),
(15, 'AMT 124', 'A/C Electricity & Ignition System', '1490279530', 1, NULL, NULL, NULL, NULL),
(16, 'P.E. 121', 'Physical Ecducation II', '1490279565', 1, NULL, NULL, NULL, NULL),
(18, 'NSTP 121', 'National Service Training Program II', '1490279727', 1, NULL, NULL, NULL, NULL),
(19, 'AMT 211', 'Civil Arts Laws & Labor Laws', '1490279784', 1, NULL, NULL, NULL, NULL),
(20, 'AMT 212', 'Economics of Air Transfortation', '1490279816', 1, NULL, NULL, NULL, NULL),
(21, 'AMT 213', 'A/C Powers Plants II (Turbo, Prop & Gas Turbine Engine)', '1490279900', 1, NULL, NULL, NULL, NULL),
(22, 'AMT 214', 'Helicopter, Principle & Operations', '1490279970', 1, NULL, NULL, NULL, NULL),
(23, 'AMT 215', 'Aircraft Instruments', '1490280172', 1, NULL, NULL, NULL, NULL),
(24, 'Pol. Sci. 211', 'Phil. Gov"t & New Constitution', '1490280244', 1, NULL, NULL, NULL, NULL),
(25, 'P.E. 211', 'Physical Ecducation III', '1490280310', 1, NULL, NULL, NULL, NULL),
(26, 'W.E. 211', 'Social Values', '1490280339', 1, NULL, NULL, NULL, NULL),
(27, 'AMT 221', 'Basic Supervision & Shop Management', '1490280458', 1, NULL, NULL, NULL, NULL),
(28, 'AMT 222', 'Airframe Maintenance & Servicing', '1490280492', 1, NULL, NULL, NULL, NULL),
(29, 'AMT 223', 'A/C Auxiliary System, Maintenance & Servicing', '1490280566', 1, NULL, NULL, NULL, NULL),
(30, 'AMT 224', 'Power plant Maintenance Servicing', '1490280621', 1, NULL, NULL, NULL, NULL),
(31, 'AMT 225', 'On The Job Training Review', '1490280659', 1, NULL, NULL, NULL, NULL),
(32, 'W.E. 221', 'Industrials Values', '1490280870', 1, NULL, NULL, NULL, NULL),
(33, 'Cur ls 221', 'Seminar on Drug Abuse, Water & Air Polution & Family Planing', '1490281083', 1, NULL, NULL, NULL, NULL),
(34, 'P.E. 221', 'Physical Ecducation IV', '1490281131', 1, NULL, NULL, NULL, NULL),
(35, 'Practicum', 'On The Job Training 3 units', '1490281157', 1, NULL, NULL, NULL, NULL),
(36, 'HRM 1', 'Housekeeping Procedures', '1490360278', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_offers`
--

CREATE TABLE `subject_offers` (
  `subject_offer_id` int(8) UNSIGNED NOT NULL,
  `subject_offer_semester` enum('first','second','summer') NOT NULL,
  `subject_offer_school_year` varchar(9) NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_offers`
--

INSERT INTO `subject_offers` (`subject_offer_id`, `subject_offer_semester`, `subject_offer_school_year`, `user_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, 'second', '2016-2017', 3, 5, '1490345025', 1, NULL, NULL, NULL, NULL),
(2, 'second', '2016-2017', 2, 36, '1490360370', 1, NULL, NULL, NULL, NULL),
(3, 'second', '2016-2017', 2, 4, '1490384892', 1, NULL, NULL, NULL, NULL),
(4, 'second', '2016-2017', 5, 1, '1490385078', 1, NULL, NULL, NULL, NULL),
(5, 'second', '2016-2017', 2, 32, '1490385155', 1, NULL, NULL, NULL, NULL),
(6, 'summer', '2016-2017', 1, 3, '1491100028', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_offer_line`
--

CREATE TABLE `subject_offer_line` (
  `subject_offer_line_id` int(8) UNSIGNED NOT NULL,
  `subject_offer_line_start` time NOT NULL,
  `subject_offer_line_end` time NOT NULL,
  `subject_offer_line_monday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_tuesday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_wednesday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_thursday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_friday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_saturday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_sunday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `subject_id` int(11) UNSIGNED NOT NULL,
  `room_id` tinyint(11) UNSIGNED NOT NULL,
  `subject_offer_semester` enum('first','second','summer') NOT NULL,
  `subject_offer_school_year` varchar(9) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) UNSIGNED NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) UNSIGNED DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subject_offer_line`
--

INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES
(1, '06:00:00', '07:00:00', 1, 1, 0, 0, 0, 0, 0, 1, 1, 5, 1, 'second', '2016-2017', '1490345025', 1, NULL, NULL, NULL, NULL),
(2, '06:00:00', '06:30:00', 0, 0, 1, 0, 0, 0, 0, 2, 2, 36, 1, 'second', '2016-2017', '1490360370', 1, NULL, NULL, NULL, NULL),
(3, '06:30:00', '08:00:00', 0, 0, 0, 0, 0, 0, 1, 3, 2, 5, 1, 'second', '2016-2017', '1490384892', 1, NULL, NULL, NULL, NULL),
(4, '06:30:00', '07:00:00', 0, 0, 0, 1, 0, 0, 0, 4, 5, 1, 1, 'second', '2016-2017', '1490385078', 1, NULL, NULL, NULL, NULL),
(5, '07:00:00', '07:30:00', 0, 1, 0, 0, 0, 0, 0, 4, 1, 5, 1, 'second', '2016-2017', '1490385078', 1, NULL, NULL, NULL, NULL),
(6, '08:00:00', '08:30:00', 0, 0, 0, 0, 1, 0, 0, 5, 2, 32, 1, 'second', '2016-2017', '1490385155', 1, NULL, NULL, NULL, NULL),
(7, '06:00:00', '07:30:00', 0, 0, 0, 0, 0, 0, 1, 6, 1, 3, 1, 'summer', '2016-2017', '1491100028', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `updated_at` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES
(1, 0x7f000001, 'administrator', '$2y$08$m8P3WHDASe.hDP4Jn6J9iut/YsshOKD3xuzuVpjiTKeFf146Mfgoi', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1491115317, 1, 'super', 'user', '', '', 1490348530),
(2, 0x3a3a31, 'username1', '$2y$08$CurDtH07bZ2qI4MK/IKiwuHElRHbR8tnxG5cgH9mBxyj8Qojg5K9O', '4II4l4nDOhYK2twbd4bUdu', 'emailxnnt1@gmail.com', NULL, NULL, NULL, NULL, 1490272230, NULL, 1, 'Firstbk', 'Lastsg', 'Companymoqix', '+63968-835-8305', NULL),
(3, 0x3a3a31, 'username2', '$2y$08$RZzWXUW494MR.4VBHg3GK.fWn6Q6Ngdo3bITGoQGU6MvLNYmiU.7O', 'ilTTwaOTekKQCZ2GYM01SO', 'emailuihu2@gmail.com', NULL, NULL, NULL, NULL, 1490272230, NULL, 1, 'Firstslb', 'Lastjn', 'Companyqve', '+63952-418-1097', NULL),
(4, 0x3a3a31, 'username3', '$2y$08$TbpuTV7J9xn.iXKAHsJj4OJcVmo/eByKDcEwHYi29xQO5OPGPQO3W', 'Oikn6LKD2I5m9KZpqcKWse', 'emailwdwa3@gmail.com', NULL, NULL, NULL, NULL, 1490272230, NULL, 1, 'Firstspjf', 'Lastjm', 'Companyxh', '+63909-421-0432', NULL),
(5, 0x3a3a31, 'username4', '$2y$08$sdieY.SDQcn8xQyFLWmWveTjXqKG5Gl7ShEsqWBHZd7XuXbmD/kiy', 'RYmEsaGEZMIakTFeS3U0SO', 'emailvzudc4@gmail.com', NULL, NULL, NULL, NULL, 1490272230, NULL, 1, 'Firsty', 'Lastw', 'Companyqujk', '+63907-812-8291', NULL),
(6, 0x3a3a31, 'username5', '$2y$08$LbKuE.UzqpsLKPtEjz94SOxZhrif7/EUQiEWK/dq/gaen.8NHUpaK', 'ld6OuPOowQBMtwqbC89XO.', 'emailbxx5@gmail.com', '74518a1c282f256322a7465a0b2a1f8572558ec7', NULL, NULL, NULL, 1490272231, NULL, 0, 'aaaaaaaa', 'sssssssssss', 'Companymytbz', '+63915-086-2075', 1490347675),
(8, 0x3139322e3136382e3130302e32, 'lloricode', '$2y$08$jblxESQxQWtFZgerF..I9.xI5GILZXgtTAqVjOZZYLKiApiWtunLO', '5y8m2uGOmeS5ONX6lgXdJ.', 'aa@aa.aa', NULL, NULL, NULL, NULL, 1490945783, 1490945872, 1, 'Lloric', 'Garcia', '', '', 1490945856),
(9, 0x3139322e3136382e3130302e33, 'faculty', '$2y$08$Z6dtQlxxrNp1IL.qo1w0TeRP/QW2MBVhItZW9HG2inrFp15Vuvewe', 'Ex0LgR2Fs.DL.gn.L1IIwO', 'aaa@ssa.adas', NULL, NULL, NULL, NULL, 1490946657, 1490947164, 1, 'faculty', 'im', '', '', 1490946990),
(11, 0x3139322e3136382e3130302e33, 'registrar', '$2y$08$i7BG9JYImhTJ95tFxpcnyOv1LiTTU/bmrhsUbRVnP2mE8J2whzXLe', '5/s5G0ZN7xQwxtRJo.HFuO', 'dsgsd@gmail.com', NULL, NULL, NULL, NULL, 1490946763, 1490947309, 1, 'registrar', 'im', '', '', 1490946979),
(12, 0x3139322e3136382e3130302e33, 'dean', '$2y$08$/HBKfc.L3OPgSff5qE3lGu6bxRvyQO8ljLZlS0.TWZ6qfPVVWfov6', 'Xv7fQhfUonkVce625q4bXu', 'dean@gmail.com', NULL, NULL, NULL, NULL, 1490946789, 1491115322, 1, 'dean', 'im', '', '', 1490946969),
(13, 0x3139322e3136382e3130302e33, 'accounting', '$2y$08$.Q4hxCil3CpQqjOFFkSY5efXVkENedfAZ0IdTWk5o5R6lwHlivXLC', 'Kb8gGKwuIcbwKcnU4XIL9e', 'accounting@gmail.com', NULL, NULL, NULL, NULL, 1490946814, 1491104275, 1, 'accounting', 'im', '', '', 1490946961),
(14, 0x3139322e3136382e3130302e33, 'sso', '$2y$08$h70mYRZSedkaLTnA.f/76OSckG7tXu.dRRKCxvAYuWPLz9gNBDnb.', 'ZgjYnOjq0PIAYERV9Fjn1.', 'sso@gmail.com', NULL, NULL, NULL, NULL, 1490946854, 1491106405, 1, 'sso', 'im', '', '', 1490946951);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `user_id` mediumint(8) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 3, 2),
(5, 4, 2),
(6, 5, 2),
(7, 6, 2),
(8, 7, 2),
(12, 8, 1),
(13, 8, 2),
(19, 14, 6),
(20, 13, 5),
(21, 12, 4),
(22, 11, 3),
(23, 9, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users_last_logins`
--

CREATE TABLE `users_last_logins` (
  `users_last_login_id` int(8) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `ip_address` varbinary(16) NOT NULL,
  `agent` varchar(100) NOT NULL,
  `platform` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_last_logins`
--

INSERT INTO `users_last_logins` (`users_last_login_id`, `user_id`, `ip_address`, `agent`, `platform`, `created_at`) VALUES
(1, 1, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491052886'),
(2, 1, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491054081'),
(3, 1, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491096626'),
(4, 12, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491103849'),
(5, 13, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491104275'),
(6, 12, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491105111'),
(7, 12, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491105213'),
(8, 1, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491105548'),
(9, 14, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491106405'),
(10, 1, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491110252'),
(11, 1, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491115317'),
(12, 12, 0x3a3a31, 'Firefox 52.0', 'Linux', '1491115322');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `controllers`
--
ALTER TABLE `controllers`
  ADD PRIMARY KEY (`controller_id`),
  ADD UNIQUE KEY `controller_name` (`controller_name`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_code` (`course_code`),
  ADD UNIQUE KEY `course_description` (`course_description`),
  ADD UNIQUE KEY `course_code_id` (`course_code_id`);

--
-- Indexes for table `curriculums`
--
ALTER TABLE `curriculums`
  ADD PRIMARY KEY (`curriculum_id`);

--
-- Indexes for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  ADD PRIMARY KEY (`curriculum_subject_id`);

--
-- Indexes for table `educations`
--
ALTER TABLE `educations`
  ADD PRIMARY KEY (`education_id`),
  ADD UNIQUE KEY `education_code` (`education_code`),
  ADD UNIQUE KEY `education_description` (`education_description`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`enrollment_id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `login` (`login`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address` (`ip_address`),
  ADD KEY `user_agent` (`user_agent`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `requisites`
--
ALTER TABLE `requisites`
  ADD PRIMARY KEY (`requisite_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD UNIQUE KEY `student_school_id` (`student_school_id`),
  ADD UNIQUE KEY `student_personal_email` (`student_personal_email`),
  ADD UNIQUE KEY `student_guardian_email` (`student_guardian_email`);

--
-- Indexes for table `students_subjects`
--
ALTER TABLE `students_subjects`
  ADD PRIMARY KEY (`student_subject_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD UNIQUE KEY `subject_code` (`subject_code`),
  ADD UNIQUE KEY `subject_description` (`subject_description`);

--
-- Indexes for table `subject_offers`
--
ALTER TABLE `subject_offers`
  ADD PRIMARY KEY (`subject_offer_id`);

--
-- Indexes for table `subject_offer_line`
--
ALTER TABLE `subject_offer_line`
  ADD PRIMARY KEY (`subject_offer_line_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_last_logins`
--
ALTER TABLE `users_last_logins`
  ADD PRIMARY KEY (`users_last_login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `controllers`
--
ALTER TABLE `controllers`
  MODIFY `controller_id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `curriculums`
--
ALTER TABLE `curriculums`
  MODIFY `curriculum_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `curriculum_subjects`
--
ALTER TABLE `curriculum_subjects`
  MODIFY `curriculum_subject_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `educations`
--
ALTER TABLE `educations`
  MODIFY `education_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `enrollment_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;
--
-- AUTO_INCREMENT for table `requisites`
--
ALTER TABLE `requisites`
  MODIFY `requisite_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- AUTO_INCREMENT for table `students_subjects`
--
ALTER TABLE `students_subjects`
  MODIFY `student_subject_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `subject_offers`
--
ALTER TABLE `subject_offers`
  MODIFY `subject_offer_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `subject_offer_line`
--
ALTER TABLE `subject_offer_line`
  MODIFY `subject_offer_line_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `users_last_logins`
--
ALTER TABLE `users_last_logins`
  MODIFY `users_last_login_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;