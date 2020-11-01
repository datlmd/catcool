DROP TABLE IF EXISTS `category`;

#
# Table structure for table 'category'
#

CREATE TABLE `category` (
  `category_id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int NOT NULL DEFAULT '0',
  `image` varchar(255) NULL,
  `context` varchar(100) NULL DEFAULT '',
  `sort_order` int(3) NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`category_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `category_description`;

#
# Table structure for table 'category_description'
#

CREATE TABLE `category_description` (
  `category_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NULL DEFAULT '',
  `description` text NULL,
  `meta_title` varchar(255) NULL,
  `meta_description` text NULL,
  `meta_keyword` text NULL,
  PRIMARY KEY (`category_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;