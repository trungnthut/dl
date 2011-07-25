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
