DROP TABLE IF EXISTS `articles`;

#
# Table structure for table 'articles'
#

CREATE TABLE `articles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL,
  `content` text NOT NULL DEFAULT '',
  `seo_title` varchar(255) NULL,
  `seo_description` varchar(255) NULL,
  `seo_keyword` varchar(255) NULL,
  `publish_date` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `images` varchar(255) NULL,
  `categories` varchar(255) NULL,
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
  `language` varchar(30) NULL DEFAULT 'vn',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  INDEX publish_date (publish_date),
  INDEX published (published, is_delete)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
