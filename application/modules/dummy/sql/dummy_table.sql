DROP TABLE IF EXISTS `dummy`;

#
# Table structure for table 'dummy'
#

CREATE TABLE `dummy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NULL DEFAULT '',
  `language` varchar(30) NULL DEFAULT 'vn',
  `sort_order` int(3) NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;