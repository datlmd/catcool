DROP TABLE IF EXISTS `modules`;

#
# Table structure for table 'modules'
#

CREATE TABLE `modules` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL DEFAULT '',
  `sub_module` varchar(100) NULL DEFAULT '',
  `user_id` int NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
