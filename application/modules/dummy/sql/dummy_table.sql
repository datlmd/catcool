DROP TABLE IF EXISTS `dummy`;

#
# Table structure for table 'dummy'
#

CREATE TABLE `dummy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NULL DEFAULT '',
  `language` varchar(30) NULL DEFAULT 'vn',
  `precedence` int NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;