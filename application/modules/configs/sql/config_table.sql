DROP TABLE IF EXISTS `config`;

#
# Table structure for table 'config'
#

CREATE TABLE `config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(255) NOT NULL DEFAULT '',
  `config_value` text NOT NULL DEFAULT '',
  `description` varchar(255) NULL DEFAULT '',
  `user_id` int NULL,
  `group_id` int NOT NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `config_group`;

#
# Table structure for table 'config_group'
#
CREATE TABLE `config_group` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;