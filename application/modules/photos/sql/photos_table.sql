DROP TABLE IF EXISTS `photos`;

#
# Table structure for table 'photos'
#

CREATE TABLE `photos` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NULL DEFAULT '',
  `image` varchar(255) NOT NULL,
  `album_id` int NULL DEFAULT 0,
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `tags` varchar(255) NULL,
  `user_id` int NOT NULL DEFAULT 0,
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `sort_order` int(3) NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `album_id` (`album_id`),
  INDEX `user_id` (`user_id`),
  INDEX `ctime` (`ctime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `photo_albums`;

#
# Table structure for table 'photo_albums'
#

CREATE TABLE `photo_albums` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL DEFAULT '',
  `image` varchar(255) NULL,
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int NOT NULL DEFAULT 0,
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `sort_order` int(3) NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  INDEX `user_id` (`user_id`),
  INDEX `ctime` (`ctime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;