DROP TABLE IF EXISTS `photo`;

#
# Table structure for table 'photo'
#

CREATE TABLE `photo` (
  `photo_id` int unsigned NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`photo_id`),
  INDEX `album_id` (`album_id`),
  INDEX `user_id` (`user_id`),
  INDEX `ctime` (`ctime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Table structure for table 'photo_description'
#
DROP TABLE IF EXISTS `photo_description`;
CREATE TABLE `photo_description` (
  `photo_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL DEFAULT '',
  `meta_title` varchar(255) NULL,
  `meta_description` varchar(255) NULL,
  `meta_keyword` varchar(255) NULL,
  PRIMARY KEY (`photo_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



#
# Table structure for table 'photo_album'
#
DROP TABLE IF EXISTS `photo_album`;
CREATE TABLE `photo_album` (
  `album_id` int unsigned NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NULL,
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int NOT NULL DEFAULT 0,
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `sort_order` int(3) NULL DEFAULT 0,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`album_id`),
  INDEX `user_id` (`user_id`),
  INDEX `ctime` (`ctime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Table structure for table 'photo_album_description'
#
DROP TABLE IF EXISTS `photo_album_description`;
CREATE TABLE `photo_album_description` (
  `album_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` varchar(255) NULL DEFAULT '',
  `meta_title` varchar(255) NULL,
  `meta_description` varchar(255) NULL,
  `meta_keyword` varchar(255) NULL,
  PRIMARY KEY (`album_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;