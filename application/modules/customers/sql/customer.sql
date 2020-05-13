


DROP TABLE IF EXISTS `customer`;

#
# Table structure for table 'customer'
#
CREATE TABLE `customer` (
  `customer_id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `fax` varchar(32) DEFAULT NULL,
  `address_id` int DEFAULT 0,
  `dob` DATE NULL,
  `gender` tinyint(1) DEFAULT 1,
  `image` varchar(255) NULL,
  `salt` varchar(9) NULL,
  `cart` text NOT NULL,
  `wishlist` text NOT NULL,
  `custom_field` text NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `login_type` varchar(10) DEFAULT NULL,
  `safe` tinyint(1) DEFAULT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int unsigned DEFAULT NULL,
  `last_login` int unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT '0',
  `language_id` int NOT NULL,
  `group_id` int NOT NULL DEFAULT '0',
  `store_id` int NOT NULL DEFAULT '0',
  `ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `uc_username` UNIQUE (`username`),
  CONSTRAINT `uc_email` UNIQUE (`email`),
  CONSTRAINT `uc_activation_selector` UNIQUE (`activation_selector`),
  CONSTRAINT `uc_forgotten_password_selector` UNIQUE (`forgotten_password_selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# Dumping data for table 'customer'
#

INSERT INTO `customer` (`customer_id`, `ip`, `username`, `password`, `email`, `activation_code`, `forgotten_password_code`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
  ('1','127.0.0.1','admin@admin.com','$2y$10$bAJgn39Fdx6gB9tikSkI5.hU3o/Yk0HhElN3HKc/9CSJKUtuQ2.cC','admin@admin.com','',NULL,'1268889823','1', 'Admin','istrator','ADMIN','0');




DROP TABLE IF EXISTS `customer_login_attempt`;

#
# Table structure for table 'customer_login_attempt'
#

CREATE TABLE `customer_login_attempt` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `login` varchar(100) NOT NULL,
  `time` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `customer_token`;

#
# Table structure for table 'customer_token'
#
CREATE TABLE `customer_token` (
  `customer_id` int unsigned NOT NULL,
  `remember_selector` varchar(255) NOT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `ip` varchar(40) NULL DEFAULT '0.0.0.0',
  `agent` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`customer_id`, `remember_selector`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


