DROP TABLE IF EXISTS `module`;

#
# Table structure for table 'module'
#

CREATE TABLE `module` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `module` varchar(100) NOT NULL DEFAULT '',
  `sub_module` varchar(100) NULL DEFAULT '',
  `user_id` int NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
