

#
# TABLE STRUCTURE FOR: curriculum_subjects
#

DROP TABLE IF EXISTS `curriculum_subjects`;

CREATE TABLE `curriculum_subjects` (
  `curriculum_subject_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `curriculum_subject_year_level` tinyint(11) unsigned NOT NULL,
  `curriculum_subject_semester` enum('first','second','summer') NOT NULL,
  `curriculum_subject_units` tinyint(11) unsigned NOT NULL,
  `curriculum_subject_lecture_hours` tinyint(11) unsigned NOT NULL,
  `curriculum_subject_laboratory_hours` tinyint(11) unsigned NOT NULL,
  `curriculum_id` int(11) unsigned NOT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`curriculum_subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('1', '1', 'first', '3', '3', '0', '1', '1', '1490281868', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', '1', 'first', '3', '3', '0', '1', '2', '1490281955', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', '1', 'first', '3', '2', '0', '1', '3', '1490281986', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('4', '1', 'first', '3', '3', '0', '1', '4', '1490282053', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('5', '1', 'first', '3', '0', '6', '1', '5', '1490282118', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('6', '1', 'first', '3', '3', '9', '1', '6', '1490282172', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('7', '1', 'first', '3', '3', '8', '1', '7', '1490282205', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('8', '1', 'first', '3', '3', '8', '1', '8', '1490282246', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('9', '1', 'second', '3', '3', '0', '1', '10', '1490283851', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('10', '1', 'second', '3', '2', '3', '1', '11', '1490283879', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('11', '1', 'second', '3', '2', '4', '1', '12', '1490283913', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('12', '1', 'second', '3', '3', '4', '1', '13', '1490283950', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('13', '1', 'second', '3', '3', '4', '1', '14', '1490284004', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('14', '1', 'second', '3', '3', '5', '1', '15', '1490284031', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('15', '1', 'second', '3', '3', '5', '1', '16', '1490284072', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('16', '1', 'second', '3', '0', '0', '1', '18', '1490284134', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('17', '2', 'first', '3', '3', '0', '1', '19', '1490284186', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('18', '2', 'first', '3', '2', '0', '1', '20', '1490284204', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('19', '2', 'first', '3', '3', '8', '1', '21', '1490284226', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('20', '2', 'first', '3', '2', '8', '1', '22', '1490284363', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('21', '2', 'first', '3', '2', '4', '1', '23', '1490284388', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('22', '2', 'first', '3', '3', '0', '1', '24', '1490284416', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('23', '2', 'first', '3', '1', '1', '1', '25', '1490284460', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('24', '2', 'first', '3', '1', '0', '1', '26', '1490284487', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('25', '2', 'second', '3', '2', '0', '1', '27', '1490330896', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('26', '2', 'second', '3', '2', '6', '1', '28', '1490330929', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('27', '2', 'second', '3', '2', '0', '1', '29', '1490330948', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('28', '2', 'second', '3', '2', '7', '1', '30', '1490330969', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('29', '2', 'second', '3', '5', '1', '1', '31', '1490330992', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('30', '2', 'second', '3', '2', '0', '1', '33', '1490331075', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('31', '2', 'second', '3', '1', '0', '1', '32', '1490331101', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('32', '2', 'second', '3', '0', '2', '1', '34', '1490331208', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('33', '2', 'second', '3', '0', '0', '1', '35', '1490331225', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculum_subjects` (`curriculum_subject_id`, `curriculum_subject_year_level`, `curriculum_subject_semester`, `curriculum_subject_units`, `curriculum_subject_lecture_hours`, `curriculum_subject_laboratory_hours`, `curriculum_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('34', '1', 'first', '3', '2', '3', '3', '36', '1490360318', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: curriculums
#

DROP TABLE IF EXISTS `curriculums`;

CREATE TABLE `curriculums` (
  `curriculum_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `curriculum_description` varchar(50) NOT NULL,
  `curriculum_effective_school_year` varchar(9) NOT NULL,
  `curriculum_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `course_id` int(11) unsigned NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`curriculum_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

INSERT INTO `curriculums` (`curriculum_id`, `curriculum_description`, `curriculum_effective_school_year`, `curriculum_status`, `course_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('1', 'Two Year Aircraft Maintenance & Technology', '2016-2017', '1', '6', '1490272433', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculums` (`curriculum_id`, `curriculum_description`, `curriculum_effective_school_year`, `curriculum_status`, `course_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', 'Bachelor Science Elementary Education', '2015-2016', '1', '1', '1490272501', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculums` (`curriculum_id`, `curriculum_description`, `curriculum_effective_school_year`, `curriculum_status`, `course_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', 'Bachelor of Science in Hotel Restaurant Management', '2016-2017', '1', '2', '1490272821', '1', NULL, NULL, NULL, NULL);
INSERT INTO `curriculums` (`curriculum_id`, `curriculum_description`, `curriculum_effective_school_year`, `curriculum_status`, `course_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('4', 'Bachelor of Science in Computer Science', '2015-2016', '1', '4', '1490273333', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: enrollments
#

DROP TABLE IF EXISTS `enrollments`;

CREATE TABLE `enrollments` (
  `enrollment_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` tinyint(11) NOT NULL,
  `course_id` tinyint(11) NOT NULL,
  `curriculum_id` tinyint(11) NOT NULL,
  `enrollment_school_year` varchar(10) NOT NULL,
  `enrollment_semester` enum('first','second','summer') NOT NULL,
  `enrollment_year_level` tinyint(11) NOT NULL,
  `enrollment_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`enrollment_id`),
  UNIQUE KEY `student_id` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `curriculum_id`, `enrollment_school_year`, `enrollment_semester`, `enrollment_year_level`, `enrollment_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('7', '2', '6', '1', '2016-2017', 'second', '1', '0', '1490342599', '1', NULL, NULL, '1490381930', '1');
INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `curriculum_id`, `enrollment_school_year`, `enrollment_semester`, `enrollment_year_level`, `enrollment_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('10', '3', '1', '2', '2016-2017', 'second', '2', '0', '1490357937', '1', NULL, NULL, '1490381058', '1');
INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `curriculum_id`, `enrollment_school_year`, `enrollment_semester`, `enrollment_year_level`, `enrollment_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('11', '4', '2', '3', '2016-2017', 'second', '1', '0', '1490360620', '1', NULL, NULL, '1490381548', '1');
INSERT INTO `enrollments` (`enrollment_id`, `student_id`, `course_id`, `curriculum_id`, `enrollment_school_year`, `enrollment_semester`, `enrollment_year_level`, `enrollment_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('12', '5', '6', '1', '2016-2017', 'second', '2', '0', '1490385680', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: rooms
#

DROP TABLE IF EXISTS `rooms`;

CREATE TABLE `rooms` (
  `room_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `room_number` varchar(50) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  UNIQUE KEY `room_number` (`room_number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `rooms` (`room_id`, `room_number`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('1', '105', '1490344975', '1', NULL, NULL, NULL, NULL);
INSERT INTO `rooms` (`room_id`, `room_number`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', '123', '1490858612', '1', NULL, NULL, NULL, NULL);
INSERT INTO `rooms` (`room_id`, `room_number`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', '321', '1490858631', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: students
#

DROP TABLE IF EXISTS `students`;

CREATE TABLE `students` (
  `student_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
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
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `student_school_id` (`student_school_id`),
  UNIQUE KEY `student_personal_email` (`student_personal_email`),
  UNIQUE KEY `student_guardian_email` (`student_guardian_email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `students` (`student_id`, `student_firstname`, `student_image`, `student_middlename`, `student_lastname`, `student_gender`, `student_birthdate`, `student_birthplace`, `student_civil_status`, `student_nationality`, `student_guardian_fullname`, `student_permanent_address`, `student_address_town`, `student_address_region`, `student_guardian_address`, `student_personal_contact_number`, `student_guardian_contact_number`, `student_personal_email`, `student_guardian_email`, `student_school_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', 'Lloric', '35983a2445aeffbff7b67c3de0edef6a.jpeg', 'Mayuga', 'Garcia', 'male', '03-15-1990', 'Caloocan City', 'Single', 'Filipino', 'Mary Grace Rodas', 'FTI, Taguig City', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '70-1', '1490342599', '1', NULL, NULL, '1490381930', '1');
INSERT INTO `students` (`student_id`, `student_firstname`, `student_image`, `student_middlename`, `student_lastname`, `student_gender`, `student_birthdate`, `student_birthplace`, `student_civil_status`, `student_nationality`, `student_guardian_fullname`, `student_permanent_address`, `student_address_town`, `student_address_region`, `student_guardian_address`, `student_personal_contact_number`, `student_guardian_contact_number`, `student_personal_email`, `student_guardian_email`, `student_school_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', 'sdfsdfsdfsdfsd', '33f8df475b167581f0cf6eeaf1796246.jpg', 'sdfsdfsdfsdf', 'sdfsdfsdfsdf', 'male', '01-28-1992', 'dfgdsfgdsfgsdfg', 'gdfgdsfgdsfg', 'dsfgdsfgdsf', 'dfgdsfgdsfgdsfg', 'sfgvsdgsdgsdgdsgdsfg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '20-2', '1490357937', '1', NULL, NULL, '1490381058', '1');
INSERT INTO `students` (`student_id`, `student_firstname`, `student_image`, `student_middlename`, `student_lastname`, `student_gender`, `student_birthdate`, `student_birthplace`, `student_civil_status`, `student_nationality`, `student_guardian_fullname`, `student_permanent_address`, `student_address_town`, `student_address_region`, `student_guardian_address`, `student_personal_contact_number`, `student_guardian_contact_number`, `student_personal_email`, `student_guardian_email`, `student_school_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('4', 'hrm stude', '1d9d6296d2d236b0d99577c6260a0ea9.jpg', 'hhrrmm', 'sdfsdfsdf', 'male', '03-08-2017', 'sdfsdfsdf', 'dfsdfsdf', 'sfsdfsdfs', 'ewfsdfsdfsdfsdfs', 'sfsdfsdf desfsdfsdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30-3', '1490360620', '1', NULL, NULL, '1490381548', '1');
INSERT INTO `students` (`student_id`, `student_firstname`, `student_image`, `student_middlename`, `student_lastname`, `student_gender`, `student_birthdate`, `student_birthplace`, `student_civil_status`, `student_nationality`, `student_guardian_fullname`, `student_permanent_address`, `student_address_town`, `student_address_region`, `student_guardian_address`, `student_personal_contact_number`, `student_guardian_contact_number`, `student_personal_email`, `student_guardian_email`, `student_school_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('5', 'sadasd', NULL, 'sadasdLL', 'sdasdasd', 'male', '02-28-2017', 'asdsaasdasdasdsad', 'sdasdasdasd', 'sadasdasd', 'sadasdasdasdsad', 'asdasdasdsdsdasd', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '70-4', '1490385680', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: students_subjects
#

DROP TABLE IF EXISTS `students_subjects`;

CREATE TABLE `students_subjects` (
  `student_subject_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `enrollment_id` int(11) NOT NULL,
  `subject_offer_id` int(11) NOT NULL,
  `student_subject_enroll_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`student_subject_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

INSERT INTO `students_subjects` (`student_subject_id`, `enrollment_id`, `subject_offer_id`, `student_subject_enroll_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('16', '7', '4', '0', '1490791772', '1', NULL, NULL, NULL, NULL);
INSERT INTO `students_subjects` (`student_subject_id`, `enrollment_id`, `subject_offer_id`, `student_subject_enroll_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('17', '7', '1', '0', '1490792956', '1', NULL, NULL, NULL, NULL);
INSERT INTO `students_subjects` (`student_subject_id`, `enrollment_id`, `subject_offer_id`, `student_subject_enroll_status`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('18', '7', '3', '0', '1490793239', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: subject_offer_line
#

DROP TABLE IF EXISTS `subject_offer_line`;

CREATE TABLE `subject_offer_line` (
  `subject_offer_line_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `subject_offer_line_start` time NOT NULL,
  `subject_offer_line_end` time NOT NULL,
  `subject_offer_line_monday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_tuesday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_wednesday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_thursday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_friday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_saturday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_line_sunday` tinyint(1) NOT NULL DEFAULT '0',
  `subject_offer_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  `room_id` tinyint(11) unsigned NOT NULL,
  `subject_offer_semester` enum('first','second','summer') NOT NULL,
  `subject_offer_school_year` varchar(9) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`subject_offer_line_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('1', '06:00:00', '07:00:00', '1', '1', '0', '0', '0', '0', '0', '1', '1', '5', '1', 'second', '2016-2017', '1490345025', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', '06:00:00', '06:30:00', '0', '0', '1', '0', '0', '0', '0', '2', '2', '36', '1', 'second', '2016-2017', '1490360370', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', '06:30:00', '08:00:00', '0', '0', '0', '0', '0', '0', '1', '3', '2', '5', '1', 'second', '2016-2017', '1490384892', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('4', '06:30:00', '07:00:00', '0', '0', '0', '1', '0', '0', '0', '4', '5', '1', '1', 'second', '2016-2017', '1490385078', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('5', '07:00:00', '07:30:00', '0', '1', '0', '0', '0', '0', '0', '4', '1', '5', '1', 'second', '2016-2017', '1490385078', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offer_line` (`subject_offer_line_id`, `subject_offer_line_start`, `subject_offer_line_end`, `subject_offer_line_monday`, `subject_offer_line_tuesday`, `subject_offer_line_wednesday`, `subject_offer_line_thursday`, `subject_offer_line_friday`, `subject_offer_line_saturday`, `subject_offer_line_sunday`, `subject_offer_id`, `user_id`, `subject_id`, `room_id`, `subject_offer_semester`, `subject_offer_school_year`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('6', '08:00:00', '08:30:00', '0', '0', '0', '0', '1', '0', '0', '5', '2', '32', '1', 'second', '2016-2017', '1490385155', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: subject_offers
#

DROP TABLE IF EXISTS `subject_offers`;

CREATE TABLE `subject_offers` (
  `subject_offer_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `subject_offer_semester` enum('first','second','summer') NOT NULL,
  `subject_offer_school_year` varchar(9) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `subject_id` int(11) unsigned NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`subject_offer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `subject_offers` (`subject_offer_id`, `subject_offer_semester`, `subject_offer_school_year`, `user_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('1', 'second', '2016-2017', '3', '5', '1490345025', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offers` (`subject_offer_id`, `subject_offer_semester`, `subject_offer_school_year`, `user_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', 'second', '2016-2017', '2', '36', '1490360370', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offers` (`subject_offer_id`, `subject_offer_semester`, `subject_offer_school_year`, `user_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', 'second', '2016-2017', '2', '4', '1490384892', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offers` (`subject_offer_id`, `subject_offer_semester`, `subject_offer_school_year`, `user_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('4', 'second', '2016-2017', '5', '1', '1490385078', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subject_offers` (`subject_offer_id`, `subject_offer_semester`, `subject_offer_school_year`, `user_id`, `subject_id`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('5', 'second', '2016-2017', '2', '32', '1490385155', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: subjects
#

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `subject_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `subject_code` varchar(50) NOT NULL,
  `subject_description` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `created_user_id` int(11) unsigned NOT NULL,
  `deleted_at` varchar(100) DEFAULT NULL,
  `deleted_user_id` int(11) unsigned DEFAULT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`subject_id`),
  UNIQUE KEY `subject_code` (`subject_code`),
  UNIQUE KEY `subject_description` (`subject_description`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('1', 'Engl 111', 'Communication Arts', '1490273057', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('2', 'IT 111', 'It Fundamentals', '1490273080', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('3', 'AMT 111', 'Fundamentals of Aero Math', '1490273531', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('4', 'AMT 112', 'Theory of Flight', '1490273558', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('5', 'AMT 113', 'Mechanical Drawing & Blueprints', '1490273607', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('6', 'AMT 114', 'A/C Power plant I (Reciprocating Engine)', '1490277785', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('7', 'AMT 115', 'A/C Materials Construction & Repair', '1490277981', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('8', 'P.E. 111', 'Physical Ecducation I', '1490279027', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('9', 'NSTP 111', 'National Service Training Program', '1490279067', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('10', 'Engl 121', 'English Grammar & Composition II', '1490279159', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('11', 'IT 121', 'Introduction to Internet Web-Base Programming', '1490279201', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('12', 'AMT 121', 'Pnedraulics', '1490279251', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('13', 'AMT 122', 'Aircraft Propellers', '1490279293', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('14', 'AMT 123', 'A/C Fuels & Fuels System', '1490279487', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('15', 'AMT 124', 'A/C Electricity & Ignition System', '1490279530', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('16', 'P.E. 121', 'Physical Ecducation II', '1490279565', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('18', 'NSTP 121', 'National Service Training Program II', '1490279727', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('19', 'AMT 211', 'Civil Arts Laws & Labor Laws', '1490279784', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('20', 'AMT 212', 'Economics of Air Transfortation', '1490279816', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('21', 'AMT 213', 'A/C Powers Plants II (Turbo, Prop & Gas Turbine Engine)', '1490279900', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('22', 'AMT 214', 'Helicopter, Principle & Operations', '1490279970', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('23', 'AMT 215', 'Aircraft Instruments', '1490280172', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('24', 'Pol. Sci. 211', 'Phil. Gov\"t & New Constitution', '1490280244', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('25', 'P.E. 211', 'Physical Ecducation III', '1490280310', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('26', 'W.E. 211', 'Social Values', '1490280339', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('27', 'AMT 221', 'Basic Supervision & Shop Management', '1490280458', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('28', 'AMT 222', 'Airframe Maintenance & Servicing', '1490280492', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('29', 'AMT 223', 'A/C Auxiliary System, Maintenance & Servicing', '1490280566', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('30', 'AMT 224', 'Power plant Maintenance Servicing', '1490280621', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('31', 'AMT 225', 'On The Job Training Review', '1490280659', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('32', 'W.E. 221', 'Industrials Values', '1490280870', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('33', 'Cur ls 221', 'Seminar on Drug Abuse, Water & Air Polution & Family Planing', '1490281083', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('34', 'P.E. 221', 'Physical Ecducation IV', '1490281131', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('35', 'Practicum', 'On The Job Training 3 units', '1490281157', '1', NULL, NULL, NULL, NULL);
INSERT INTO `subjects` (`subject_id`, `subject_code`, `subject_description`, `created_at`, `created_user_id`, `deleted_at`, `deleted_user_id`, `updated_at`, `updated_user_id`) VALUES ('36', 'HRM 1', 'Housekeeping Procedures', '1490360278', '1', NULL, NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `updated_at` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('1', '\0\0', 'administrator', '$2y$08$m8P3WHDASe.hDP4Jn6J9iut/YsshOKD3xuzuVpjiTKeFf146Mfgoi', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, '1268889823', '1490952111', '1', 'super', 'user', '', '', '1490348530');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('2', '::1', 'username1', '$2y$08$CurDtH07bZ2qI4MK/IKiwuHElRHbR8tnxG5cgH9mBxyj8Qojg5K9O', '4II4l4nDOhYK2twbd4bUdu', 'emailxnnt1@gmail.com', NULL, NULL, NULL, NULL, '1490272230', NULL, '1', 'Firstbk', 'Lastsg', 'Companymoqix', '+63968-835-8305', NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('3', '::1', 'username2', '$2y$08$RZzWXUW494MR.4VBHg3GK.fWn6Q6Ngdo3bITGoQGU6MvLNYmiU.7O', 'ilTTwaOTekKQCZ2GYM01SO', 'emailuihu2@gmail.com', NULL, NULL, NULL, NULL, '1490272230', NULL, '1', 'Firstslb', 'Lastjn', 'Companyqve', '+63952-418-1097', NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('4', '::1', 'username3', '$2y$08$TbpuTV7J9xn.iXKAHsJj4OJcVmo/eByKDcEwHYi29xQO5OPGPQO3W', 'Oikn6LKD2I5m9KZpqcKWse', 'emailwdwa3@gmail.com', NULL, NULL, NULL, NULL, '1490272230', NULL, '1', 'Firstspjf', 'Lastjm', 'Companyxh', '+63909-421-0432', NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('5', '::1', 'username4', '$2y$08$sdieY.SDQcn8xQyFLWmWveTjXqKG5Gl7ShEsqWBHZd7XuXbmD/kiy', 'RYmEsaGEZMIakTFeS3U0SO', 'emailvzudc4@gmail.com', NULL, NULL, NULL, NULL, '1490272230', NULL, '1', 'Firsty', 'Lastw', 'Companyqujk', '+63907-812-8291', NULL);
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('6', '::1', 'username5', '$2y$08$LbKuE.UzqpsLKPtEjz94SOxZhrif7/EUQiEWK/dq/gaen.8NHUpaK', 'ld6OuPOowQBMtwqbC89XO.', 'emailbxx5@gmail.com', '74518a1c282f256322a7465a0b2a1f8572558ec7', NULL, NULL, NULL, '1490272231', NULL, '0', 'aaaaaaaa', 'sssssssssss', 'Companymytbz', '+63915-086-2075', '1490347675');






#
# TABLE STRUCTURE FOR: groups
#

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('1', 'admin', 'Administrator');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('2', 'faculty', 'General User');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('3', 'registrar', 'Registrar');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('4', 'dean', 'Dean');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('5', 'accounting', 'Accounting');
INSERT INTO `groups` (`id`, `name`, `description`) VALUES ('6', 'sso', 'Support Service Office');



#
# TABLE STRUCTURE FOR: permissions
#

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `controller_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  `updated_user_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8;

INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('10', '10', '1', '1489668863', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('11', '11', '1', '1489668863', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('14', '14', '1', '1489668863', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('15', '15', '1', '1489668863', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('18', '18', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('20', '20', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('21', '21', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('22', '22', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('23', '23', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('24', '24', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('25', '25', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('26', '26', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('27', '27', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('28', '28', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('29', '29', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('30', '30', '1', '1489668864', NULL, NULL);
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('39', '17', '1', '1490946782', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('43', '19', '1', '1490947031', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('48', '31', '1', '1490947123', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('49', '31', '2', '1490947124', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('50', '31', '3', '1490947124', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('51', '31', '4', '1490947124', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('52', '31', '5', '1490947124', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('53', '31', '6', '1490947124', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('55', '1', '1', '1490947147', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('56', '1', '2', '1490947147', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('57', '1', '3', '1490947147', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('58', '1', '4', '1490947148', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('59', '1', '5', '1490947148', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('60', '1', '6', '1490947148', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('61', '6', '1', '1490947171', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('62', '6', '3', '1490947171', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('63', '6', '4', '1490947171', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('64', '6', '5', '1490947171', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('68', '12', '1', '1490947463', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('69', '12', '4', '1490947463', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('70', '16', '1', '1490947522', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('71', '16', '2', '1490947522', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('72', '16', '3', '1490947522', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('73', '16', '4', '1490947522', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('74', '16', '6', '1490947522', NULL, '8');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('77', '3', '1', '1490947935', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('78', '3', '4', '1490947935', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('79', '4', '1', '1490953414', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('80', '4', '4', '1490953414', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('81', '5', '1', '1490953421', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('82', '5', '4', '1490953421', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('83', '7', '1', '1490953429', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('84', '7', '3', '1490953429', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('85', '9', '1', '1490953435', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('86', '9', '4', '1490953435', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('87', '13', '1', '1490953573', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('88', '13', '4', '1490953573', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('89', '2', '1', '1490953578', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('90', '2', '4', '1490953578', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('91', '8', '1', '1490953584', NULL, '1');
INSERT INTO `permissions` (`permission_id`, `controller_id`, `group_id`, `created_at`, `updated_at`, `updated_user_id`) VALUES ('92', '8', '4', '1490953584', NULL, '1');
















INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('8', '192.168.100.2', 'lloricode', '$2y$08$jblxESQxQWtFZgerF..I9.xI5GILZXgtTAqVjOZZYLKiApiWtunLO', '5y8m2uGOmeS5ONX6lgXdJ.', 'aa@aa.aa', NULL, NULL, NULL, NULL, '1490945783', '1490945872', '1', 'Lloric', 'Garcia', '', '', '1490945856');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('9', '192.168.100.3', 'faculty', '$2y$08$Z6dtQlxxrNp1IL.qo1w0TeRP/QW2MBVhItZW9HG2inrFp15Vuvewe', 'Ex0LgR2Fs.DL.gn.L1IIwO', 'aaa@ssa.adas', NULL, NULL, NULL, NULL, '1490946657', '1490947164', '1', 'faculty',  'im','', '', '1490946990');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('11', '192.168.100.3', 'registrar', '$2y$08$i7BG9JYImhTJ95tFxpcnyOv1LiTTU/bmrhsUbRVnP2mE8J2whzXLe', '5/s5G0ZN7xQwxtRJo.HFuO', 'dsgsd@gmail.com', NULL, NULL, NULL, NULL, '1490946763', '1490947309', '1', 'registrar', 'im', '', '', '1490946979');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('12', '192.168.100.3', 'dean', '$2y$08$/HBKfc.L3OPgSff5qE3lGu6bxRvyQO8ljLZlS0.TWZ6qfPVVWfov6', 'Xv7fQhfUonkVce625q4bXu', 'dean@gmail.com', NULL, NULL, NULL, NULL, '1490946789', '1490947192', '1',  'dean','im', '', '', '1490946969');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('13', '192.168.100.3', 'accounting', '$2y$08$.Q4hxCil3CpQqjOFFkSY5efXVkENedfAZ0IdTWk5o5R6lwHlivXLC', 'Kb8gGKwuIcbwKcnU4XIL9e', 'accounting@gmail.com', NULL, NULL, NULL, NULL, '1490946814', '1490947500', '1',  'accounting','im', '', '', '1490946961');
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `updated_at`) VALUES ('14', '192.168.100.3', 'sso', '$2y$08$h70mYRZSedkaLTnA.f/76OSckG7tXu.dRRKCxvAYuWPLz9gNBDnb.', 'ZgjYnOjq0PIAYERV9Fjn1.', 'sso@gmail.com', NULL, NULL, NULL, NULL, '1490946854', '1490947002', '1',  'sso','im', '', '', '1490946951');



#
# TABLE STRUCTURE FOR: users_groups
#

DROP TABLE IF EXISTS `users_groups`;

CREATE TABLE `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('1', '1', '1');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('2', '1', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('3', '2', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('4', '3', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('5', '4', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('6', '5', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('7', '6', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('8', '7', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('12', '8', '1');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('13', '8', '2');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('19', '14', '6');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('20', '13', '5');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('21', '12', '4');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('22', '11', '3');
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES ('23', '9', '2');

