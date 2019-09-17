DROP TABLE IF EXISTS `categories`;

#
# Table structure for table 'categories'
#

CREATE TABLE `categories` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` text NULL,
  `context` varchar(100) NULL DEFAULT '',
  `language` varchar(30) NULL DEFAULT 'vn',
  `precedence` int NULL,
  `parent_id` int NOT NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
