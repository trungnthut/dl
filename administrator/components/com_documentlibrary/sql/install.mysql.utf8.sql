--
-- Table structure for table `#__documents`
--

DROP TABLE IF EXISTS `#__documents`;
CREATE TABLE IF NOT EXISTS `#__documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `original_id` int(11) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `uploader_id` int(11) NOT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `lesson` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `summary` varchar(300) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `question` varchar(300) DEFAULT NULL,
  `uploaded_time` datetime DEFAULT NULL,
  `fileName` varchar(255) NOT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__document_comments`
--

DROP TABLE IF EXISTS `#__document_comments`;
CREATE TABLE IF NOT EXISTS `#__document_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `poster_id` int(11) NOT NULL,
  `original_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `title` varchar(70) DEFAULT NULL,
  `contents` mediumtext,
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__document_downloads`
--

DROP TABLE IF EXISTS `#__document_downloads`;
CREATE TABLE IF NOT EXISTS `#__document_downloads` (
  `download_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `time` datetime NOT NULL,
  PRIMARY KEY (`download_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `#__document_subjects`
--


DROP TABLE IF EXISTS `#__document_subjects`;
CREATE TABLE IF NOT EXISTS `#__document_subjects` (
  `subject_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `in_used` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `#__document_subjects`
--

INSERT INTO `#__document_subjects` (`subject_id`, `name`, `in_used`) VALUES
(1, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_ICT', 1),
(2, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_MATH', 1),
(3, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_PHY', 1),
(4, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_CHEMISCHY', 1),
(5, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_BIO', 1),
(6, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_LITERATURE', 1),
(7, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_HISTORY', 1),
(8, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_GEO', 1),
(9, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_ENG', 1),
(10, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_FRE', 1),
(11, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_GDCD', 1),
(12, 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_KTCN', 1);

-- --------------------------------------------------------

--
-- Table structure for table `#__document_types`
--

DROP TABLE IF EXISTS `#__document_types`;
CREATE TABLE IF NOT EXISTS `#__document_types` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `in_used` tinyint(1) NOT NULL DEFAULT '1',
  `extends` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `#__user_login`
--

DROP TABLE IF EXISTS `#__user_login`;
CREATE TABLE IF NOT EXISTS `#__user_login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login` datetime NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


-- --------------------------------------------------------

--
-- Table structure for table `#__dl_score`
--

DROP TABLE IF EXISTS `#__dl_score`;
CREATE TABLE IF NOT EXISTS `#_dl_score` (
`user_id` INT( 11 ) NOT NULL ,
`score` INT( 11 ) NOT NULL DEFAULT  '0',
PRIMARY KEY (  `user_id` )
) ENGINE = MYISAM;

--
-- Dumping data for table `#__document_types`
--

INSERT INTO `#__document_types` (`type_id`, `name`, `parent_id`, `in_used`, `extends`) VALUES
(1, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_SYLLABUS', 0, 1, 0),
(2, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_LECTURE', 0, 1, 0),
(3, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_EXERCISE', 0, 1, 0),
(4, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_IMAGE', 0, 1, 0),
(5, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_SOFTWARE', 0, 1, 0),
(6, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_VIDEO', 0, 1, 0),
(7, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_ADVANCED_TOPIC', 0, 1, 0),
(8, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TEST', 0, 1, 1),
(9, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_GOOD_STUDENT_EXAM', 0, 1, 1),
(10, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TEST_15', 8, 1, 0),
(11, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TEST_45', 8, 1, 0),
(12, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TEST_TERM_1', 8, 1, 0),
(13, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TEST_TERM_2', 8, 1, 0),
(14, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_GOOD_STUDENT_EXAM_PROVINCE', 9, 1, 0),
(15, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_GOOD_STUDENT_EXAM_COUNTRY', 9, 1, 0),
(16, 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_GOOD_STUDENT_EXAM_INTERNATIONAL', 9, 1, 0);


