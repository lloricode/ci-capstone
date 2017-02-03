-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 03, 2017 at 04:56 PM
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
-- Table structure for table `admin_preferences`
--

CREATE TABLE `admin_preferences` (
  `id` tinyint(1) NOT NULL,
  `user_panel` tinyint(1) NOT NULL DEFAULT '0',
  `sidebar_form` tinyint(1) NOT NULL DEFAULT '0',
  `messages_menu` tinyint(1) NOT NULL DEFAULT '0',
  `notifications_menu` tinyint(1) NOT NULL DEFAULT '0',
  `tasks_menu` tinyint(1) NOT NULL DEFAULT '0',
  `user_menu` tinyint(1) NOT NULL DEFAULT '1',
  `ctrl_sidebar` tinyint(1) NOT NULL DEFAULT '0',
  `transition_page` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_preferences`
--

INSERT INTO `admin_preferences` (`id`, `user_panel`, `sidebar_form`, `messages_menu`, `notifications_menu`, `tasks_menu`, `user_menu`, `ctrl_sidebar`, `transition_page`) VALUES
(1, 0, 0, 0, 0, 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bgcolor` char(7) NOT NULL DEFAULT '#607D8B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `bgcolor`) VALUES
(1, 'admin', 'Administrator', '#F44336'),
(2, 'members1', 'General User', '#2196F3'),
(3, 'mygroupname', 'my group descc', '#607D8B'),
(4, 'admin1', 'Administrator', '#F44336'),
(5, 'members2', 'General User', '#2196F3'),
(6, 'a_a', 'a aa  a', '#607D8B');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `language_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `language_value` varchar(10) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`language_id`, `user_id`, `language_value`, `updated_at`, `added_at`) VALUES
(1, 1, 'english', '2017-02-02 13:48:37', '2016-12-18 14:51:07');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(4, '::1', 'admin@admin.com', 1486089952),
(5, '::1', 'admin@admin.com', 1486089966),
(6, '::1', 'grandmasbestdipolog@gmail.com', 1486134182),
(7, '::1', 'admin', 1486134344),
(8, '::1', 'admin@admin.com', 1486136364);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `errno` int(2) NOT NULL,
  `errtype` varchar(32) NOT NULL,
  `errstr` text NOT NULL,
  `errfile` varchar(255) NOT NULL,
  `errline` int(4) NOT NULL,
  `user_agent` varchar(120) NOT NULL,
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `errno`, `errtype`, `errstr`, `errfile`, `errline`, `user_agent`, `ip_address`, `time`) VALUES
(1, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(2, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(3, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(4, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(5, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(6, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(7, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(8, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(9, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(10, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(11, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(12, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(13, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(14, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(15, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(16, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(17, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(18, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(19, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(20, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(21, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(22, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(23, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(24, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(25, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(26, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(27, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(28, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(29, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(30, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00'),
(31, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '0000-00-00 00:00:00'),
(32, 32, 'asd', 'qwrd', 'qwe', 2, 'awe', '0', '2012-12-03 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `public_preferences`
--

CREATE TABLE `public_preferences` (
  `id` int(1) NOT NULL,
  `transition_page` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `public_preferences`
--

INSERT INTO `public_preferences` (`id`, `transition_page`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `student_firstname` varchar(50) NOT NULL,
  `student_lastname` varchar(50) NOT NULL,
  `student_middlename` varchar(50) NOT NULL,
  `student_school_id` varchar(9) NOT NULL,
  `student_gender` varchar(6) NOT NULL,
  `student_permanent_address` varchar(250) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_year_level` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `deleted_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `student_enrolled` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `student_firstname`, `student_lastname`, `student_middlename`, `student_school_id`, `student_gender`, `student_permanent_address`, `course_id`, `student_year_level`, `created_at`, `deleted_at`, `updated_at`, `student_enrolled`) VALUES
(1, 'fffffffffff', 'llllllllllllllllllll', 'mmmmmmmmmmmmm', 'siddddd', 'gggggg', 'padreeeeeeeee', 0, 0, '2017-02-03 21:32:02', '', '', 0),
(2, 'aaaaaaaaaaaa', 'aaaaaaaaaaaa', 'aaaaaaaaaaa', 'aaaaaaaaa', 'aaaaaa', 'aaaaaaaaaaaa', 0, 0, '2017-02-03 21:35:26', '', '', 0),
(3, 'lloric', 'garcia', 'Mayuah', '1234-1234', 'male', 'qweqweqweweq', 1, 4, '2017-02-03 22:22:56', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2y$08$m8P3WHDASe.hDP4Jn6J9iut/YsshOKD3xuzuVpjiTKeFf146Mfgoi', '', 'admin@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1486134334, 1, 'Im Admin', 'ci capstone', 'ADMIN', '0'),
(14, '::1', '222222', '$2y$08$JHyBxZm7CZyD4JGtrje2B.qgZld.BqusIfeaca1BRhev32/cMI1Py', NULL, 'wre@ase.sef', '8c7ffb9b11d7db8ccb687e6301e0ab854f9ec4ce', NULL, NULL, NULL, 1485858823, NULL, 0, 'qewexxxxxxxxxxxx', 'qweqwexxxxxxxxxxxx', '', ''),
(15, '::1', '33333333333333', '$2y$08$qH1QQCCBO18oErLM5khd3uDqHedsCqvpAdaJiJpHdks5mI3UaJVOm', NULL, '', '9c487a8615059174acc7a18ea8a5078adf665408', NULL, NULL, NULL, 1485865702, NULL, 0, 'qwe', 'qew', '', 'qwe'),
(16, '::1', '4444444444444444', '$2y$08$naeeOL0Tgo/Mfa1vcC6NZO2v0a6WhY/l2C5Y4uB1fogbbKIfCyCr6', NULL, '', NULL, NULL, NULL, NULL, 1485865743, NULL, 1, 'qweasdasefs', 'qweasefs', '', ''),
(17, '::1', '5555555555', '$2y$08$ihajBvDu9MB3cJGWStfEfOwMA7mEHWlx9WvbdtZohhw9fvvpESXvW', NULL, '', NULL, NULL, NULL, NULL, 1485865763, NULL, 1, 'qweasdefs', 'serfsrfs', '', ''),
(18, '::1', '6', '$2y$08$ihajBvDu9MB3cJGWStfEfOwMA7mEHWlx9WvbdtZohhw9fvvpESXvW', NULL, '', NULL, NULL, NULL, NULL, 1485865763, NULL, 1, 'qweasdefs', 'serfsrfs', '', ''),
(19, '::1', '7', '$2y$08$JHyBxZm7CZyD4JGtrje2B.qgZld.BqusIfeaca1BRhev32/cMI1Py', NULL, 'wre@ase.sef', NULL, NULL, NULL, NULL, 1485858823, NULL, 1, 'qewe', 'qweqwe', '', ''),
(20, '::1', '8', '$2y$08$qH1QQCCBO18oErLM5khd3uDqHedsCqvpAdaJiJpHdks5mI3UaJVOm', NULL, '', NULL, NULL, NULL, NULL, 1485865702, NULL, 1, 'qwe', 'qew', '', 'qwe'),
(21, '::1', '9', '$2y$08$naeeOL0Tgo/Mfa1vcC6NZO2v0a6WhY/l2C5Y4uB1fogbbKIfCyCr6', NULL, '', NULL, NULL, NULL, NULL, 1485865743, NULL, 1, 'qweasdasefszzzzzzzzzzzz', 'qweasefs', '', ''),
(22, '::1', '10', '$2y$08$ihajBvDu9MB3cJGWStfEfOwMA7mEHWlx9WvbdtZohhw9fvvpESXvW', NULL, '', NULL, NULL, NULL, NULL, 1485865763, NULL, 1, 'qweasdefs', 'serfsrfs', '', ''),
(23, '::1', '11', '$2y$08$ihajBvDu9MB3cJGWStfEfOwMA7mEHWlx9WvbdtZohhw9fvvpESXvW', NULL, '', '2a7cc728b418189e57d36bba2eb86a1ee64532c8', NULL, NULL, NULL, 1485865763, NULL, 0, 'qweasdefs', 'serfsrfs', '', ''),
(24, '::1', 'aaaaaaaaaaaaaa1', '$2y$08$h8LDd6prALgOTeoEI5VpiO.SX9oK/wPS1IXZM6BIoLgs/AyHSnhF6', NULL, '', 'adf0e25fb7ce68dd732137a4e504274982c3beef', NULL, NULL, NULL, 1486032921, NULL, 0, 'aaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaafffffffff', '', ''),
(25, '::1', 'onyok123', '$2y$08$DJB/.dm/qdRPcdD0MWiC8OXNlWrXy0iSTdFIX8Nvb72f86pLZXKc6', NULL, '', NULL, NULL, NULL, NULL, 1486043240, 1486089049, 1, 'onyokss', 'embradoss', '', ''),
(26, '::1', 'aaa121123', '$2y$08$lC1MP99VvcK2aUOe/ycVqe68iKQVSkKSjrbioMSRHw8T9RRIBkjHO', NULL, '', NULL, NULL, NULL, NULL, 1486045613, NULL, 1, 'aaaaaa', 'aaaa', '', ''),
(27, '::1', 'aaaaaaaaaaaa1', '$2y$08$TpoD03ouFnJ7k/JH3nCUiumg8B6IGwQmZf4LbkmPTUOMUB4Lbf5Om', NULL, '', NULL, NULL, NULL, NULL, 1486127723, NULL, 1, '0', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(76, 1, 1),
(77, 1, 2),
(88, 14, 3),
(50, 15, 1),
(61, 16, 1),
(55, 17, 1),
(56, 17, 2),
(89, 18, 2),
(60, 24, 1),
(75, 25, 2),
(69, 26, 1),
(90, 27, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`,`ip_address`,`user_agent`);

--
-- Indexes for table `public_preferences`
--
ALTER TABLE `public_preferences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_preferences`
--
ALTER TABLE `admin_preferences`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `public_preferences`
--
ALTER TABLE `public_preferences`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
