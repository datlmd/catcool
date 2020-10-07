DROP TABLE IF EXISTS `article`;

#
# Table structure for table 'article'
#

CREATE TABLE `article` (
  `article_id` int unsigned NOT NULL AUTO_INCREMENT,
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
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`article_id`),
  INDEX publish_date (publish_date),
  INDEX published (published, is_delete)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `article_description`;

#
# Table structure for table 'article_description'
#

CREATE TABLE `article_description` (
  `article_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL,
  `content` text NOT NULL DEFAULT '',
  `meta_title` varchar(255) NULL,
  `meta_description` text NULL,
  `meta_keyword` text NULL,
  PRIMARY KEY (`article_id`,`language_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;