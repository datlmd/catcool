DROP TABLE IF EXISTS `configs`;

#
# Table structure for table 'configs'
#

CREATE TABLE `configs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `config_key` varchar(255) NOT NULL DEFAULT '',
  `config_value` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL DEFAULT '',
  `user_id` int NULL,
  `published` enum('yes','no') NOT NULL DEFAULT 'yes',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
