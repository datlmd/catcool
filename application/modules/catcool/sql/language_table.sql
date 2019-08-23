DROP TABLE IF EXISTS `languages`;

#
# Table structure for table 'languages'
#

CREATE TABLE `languages` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `code` varchar(100) NOT NULL DEFAULT '',
  `user_id` int NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '00-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;