DROP TABLE IF EXISTS `dummy`;

#
# Table structure for table 'dummy'
#

CREATE TABLE `dummy` (
  `dummy_id` int unsigned NOT NULL AUTO_INCREMENT,
  `sort_order` int(3) NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dummy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `dummy_description`;

#
# Table structure for table 'dummy_description'
#

CREATE TABLE `dummy_description` (
  `dummy_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NULL,
  PRIMARY KEY (`dummy_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;