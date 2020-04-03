DROP TABLE IF EXISTS `user_group`;

#
# Table structure for table 'group'
#
CREATE TABLE `user_group` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user`;

#
# Table structure for table 'user'
#
CREATE TABLE `user` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) NULL,
  `dob` DATE NULL,
  `gender` tinyint(1) DEFAULT 1,
  `image` varchar(255) NULL,
  `super_admin` tinyint(1) unsigned DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int unsigned DEFAULT NULL,
  `last_login` int unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(30) NULL DEFAULT 'vn',
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `uc_username` UNIQUE (`username`),
  CONSTRAINT `uc_email` UNIQUE (`email`),
  CONSTRAINT `uc_activation_selector` UNIQUE (`activation_selector`),
  CONSTRAINT `uc_forgotten_password_selector` UNIQUE (`forgotten_password_selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user_group_relationship`;

#
# Table structure for table 'user_group_relationship'
#

CREATE TABLE `user_group_relationship` (
  `user_id` int unsigned NOT NULL,
  `group_id` int unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `fk_user_group_users1_idx` (`user_id`),
  KEY `fk_user_group_groups1_idx` (`group_id`),
  CONSTRAINT `fk_user_group_users1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_group_groups1` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table 'user'
#

INSERT INTO `user` (`id`, `user_ip`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
  ('1','127.0.0.1','admin','$2y$10$bAJgn39Fdx6gB9tikSkI5.hU3o/Yk0HhElN3HKc/9CSJKUtuQ2.cC','admin@admin.com','',NULL,'1268889823','1', 'Admin','istrator','ADMIN','0');


#
# Dumping data for table 'group'
#
INSERT INTO `user_group` (`id`, `name`, `description`) VALUES
  (1,'admin','Administrator'),
  (2,'members','General User');

INSERT INTO `user_group_relationship` (`user_id`, `group_id`) VALUES
     (1,1),
     (1,2);


DROP TABLE IF EXISTS `user_login_attempt`;

#
# Table structure for table 'user_login_attempt'
#

CREATE TABLE `user_login_attempt` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `login` varchar(100) NOT NULL,
  `time` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `user_token`;

#
# Table structure for table 'user_token'
#
CREATE TABLE `user_token` (
  `user_id` int unsigned NOT NULL,
  `remember_selector` varchar(255) NOT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `user_ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `agent` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`, `remember_selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
