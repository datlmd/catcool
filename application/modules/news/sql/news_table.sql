DROP TABLE IF EXISTS `news`;

#
# Table structure for table 'news'
#

CREATE TABLE `news` (
  `news_id` int unsigned NOT NULL AUTO_INCREMENT,
  `publish_date` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `images` varchar(255) NULL,
  `tags` varchar(255) NULL,
  `author` varchar(100) NULL,
  `source` varchar(255) NULL,
  `sort_order` int(3) NULL DEFAULT 0,
  `user_id` int NOT NULL DEFAULT 0,
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `counter_view` int NULL DEFAULT 0,
  `counter_comment` int NULL DEFAULT 0,
  `counter_like` int NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`news_id`),
  INDEX publish_date (publish_date),
  INDEX published (published, is_delete)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `news_description`;

#
# Table structure for table 'news_description'
#

CREATE TABLE `news_description` (
  `news_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NULL DEFAULT '',
  `description` varchar(255) NULL,
  `content` text NOT NULL DEFAULT '',
  `meta_title` varchar(255) NULL,
  `meta_description` text NULL,
  `meta_keyword` text NULL,
  PRIMARY KEY (`news_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;