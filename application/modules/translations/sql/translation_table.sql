DROP TABLE IF EXISTS `translations`;

#
# Table structure for table 'translations'
#

CREATE TABLE `translations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `lang_key` varchar(100) NOT NULL DEFAULT '',
  `lang_value` varchar(100) NOT NULL DEFAULT '',
  `lang_id` int NULL,
  `module_id` int NULL,
  `user_id` int NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lang_key` (`lang_key`,`module_id`,`lang_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;