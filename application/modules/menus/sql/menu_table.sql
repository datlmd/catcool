DROP TABLE IF EXISTS `menu`;

#
# Table structure for table 'menu'
#

CREATE TABLE `menu` (
  `menu_id` int unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL DEFAULT '',
  `icon` varchar(100) NULL DEFAULT '',
  `context` varchar(100) NULL DEFAULT '',
  `nav_key` varchar(100) NULL DEFAULT '',
  `label` varchar(100) NULL DEFAULT '',
  `attributes` varchar(255) NULL,
  `selected` varchar(255) NULL DEFAULT '',
  `sort_order` int(3) NULL DEFAULT 0,
  `user_id` int NOT NULL,
  `parent_id` int NOT NULL,
  `is_admin` enum('yes', 'no') NOT NULL DEFAULT 'no',
  `hidden` enum('yes', 'no') NOT NULL DEFAULT 'no',
  `published` enum('yes', 'no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `menu_description`;

#
# Table structure for table 'menu_description'
#

CREATE TABLE `menu_description` (
  `menu_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NULL,
  PRIMARY KEY (`menu_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;