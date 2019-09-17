DROP TABLE IF EXISTS `menus`;

#
# Table structure for table 'menus'
#

CREATE TABLE `menus` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL,
  `icon` varchar(100) NULL DEFAULT '',
  `context` varchar(100) NULL DEFAULT '',
  `nav_key` varchar(100) NULL DEFAULT '',
  `label` varchar(100) NULL DEFAULT '',
  `attributes` varchar(255) NULL,
  `selected` varchar(255) NULL DEFAULT '',
  `language` varchar(30) NULL DEFAULT 'vn',
  `precedence` int NULL,
  `user_id` int NOT NULL,
  `parent_id` int NOT NULL,
  `is_admin` enum('yes', 'no') NOT NULL DEFAULT 'no',
  `hidden` enum('yes', 'no') NOT NULL DEFAULT 'no',
  `published` enum('yes', 'no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;