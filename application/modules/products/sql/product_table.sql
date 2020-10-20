DROP TABLE IF EXISTS `product`;

#
# Table structure for table 'product'
#
CREATE TABLE `product` (
  `product_id` int unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int not null,
  `model` varchar(64) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `upc` varchar(12) NOT NULL,
  `ean` varchar(14) NOT NULL,
  `jan` varchar(13) NOT NULL,
  `isbn` varchar(17) NOT NULL,
  `mpn` varchar(64) NOT NULL,
  `location` varchar(128) NOT NULL,
  `variant` text NOT NULL,
  `override` text NOT NULL,
  `quantity` int NOT NULL DEFAULT 0,
  `stock_status_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `manufacturer_id` int NOT NULL,
  `shipping` tinyint(1) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `points` int NOT NULL DEFAULT 0,
  `tax_class_id` int NOT NULL,
  `date_available` DATE NOT NULL DEFAULT '0000-00-00',
  `weight` decimal(15,8) NOT NULL DEFAULT '	0.00000000',
  `weight_class_id` int NOT NULL DEFAULT 0,
  `length` decimal(15,8) NOT NULL DEFAULT '	0.00000000',
  `length_class_id` int NOT NULL DEFAULT 0,
  `width` decimal(15,8) NOT NULL DEFAULT '	0.00000000',
  `height` decimal(15,8) NOT NULL DEFAULT '	0.00000000',
  `subtract` tinyint(1) NOT NULL DEFAULT 1,
  `minimum` int NOT NULL DEFAULT 1,
  `sort_order` int NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `viewed` int NOT NULL DEFAULT 0,
  `is_comment` tinyint(1) NOT NULL DEFAULT '1',
  `ctime` DATETIME NOT NULL DEFAULT '0000-00-00 00\:00\:00',
  `mtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_description`;

#
# Table structure for table 'product_description'
#

CREATE TABLE `product_description` (
  `product_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(255) NOT NULL DEFAULT '',
  `description` text NULL,
  `tag` text NULL,
  `meta_title` varchar(255) NULL,
  `meta_description` text NULL,
  `meta_keyword` text NULL,
  PRIMARY KEY (`product_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_attribute`;

#
# Table structure for table 'product_attribute'
#

CREATE TABLE `product_attribute` (
  `product_id` int NOT NULL,
  `attribute_id` int NOT NULL,
  `language_id` int NOT NULL,
  `text` text NULL,
  PRIMARY KEY (`product_id`, `attribute_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_discount`;

#
# Table structure for table 'product_discount'
#

CREATE TABLE `product_discount` (
  `product_discount_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `customer_group_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT 0,
  `priority` int NOT NULL DEFAULT 1,
  `price` decimal(15,4)	 NOT NULL DEFAULT '0.00000',
  `date_start` DATE NOT NULL DEFAULT '0000-00-00',
  `date_end` DATE NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_discount_id`),
  KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_filter`;

#
# Table structure for table 'product_filter'
#

CREATE TABLE `product_filter` (
  `product_id` int NOT NULL,
  `filter_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_image`;

#
# Table structure for table 'product_image'
#

CREATE TABLE `product_image` (
  `product_image_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_image_id`),
  KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_option`;

#
# Table structure for table 'product_option'
#

CREATE TABLE `product_option` (
  `product_option_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  `value` text NOT NULL,
  `required` 	tinyint(1) NOT NULL,
  PRIMARY KEY (`product_option_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_option_value`;

#
# Table structure for table 'product_option_value'
#

CREATE TABLE `product_option_value` (
  `product_option_value_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_option_id` int NOT NULL,
  `product_id` int NOT NULL,
  `option_id` int NOT NULL,
  `option_value_id` int NOT NULL,
  `quantity` int NOT NULL,
  `subtract` 	tinyint(1) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `price_prefix` varchar(1) NOT NULL,
  `points` int NOT NULL,
  `points_prefix` varchar(1) NOT NULL,
  `weight` decimal(15,8) NOT NULL,
  `weight_prefix` varchar(1) NOT NULL,
  PRIMARY KEY (`product_option_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_recurring`;

#
# Table structure for table 'product_recurring'
#

CREATE TABLE `product_recurring` (
  `product_id` int NOT NULL,
  `recurring_id` int NOT NULL,
  `customer_group_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `recurring_id`, `customer_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_related`;

#
# Table structure for table 'product_related'
#

CREATE TABLE `product_related` (
  `product_id` int NOT NULL,
  `related_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `related_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_reward`;

#
# Table structure for table 'product_reward'
#

CREATE TABLE `product_reward` (
  `product_reward_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL DEFAULT 0,
  `customer_group_id` int NOT NULL DEFAULT 0,
  `points` int NOT NULL DEFAULT 0,
  PRIMARY KEY (`product_reward_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_special`;

#
# Table structure for table 'product_special'
#

CREATE TABLE `product_special` (
  `product_special_id` int unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL DEFAULT 0,
  `customer_group_id` int NOT NULL,
  `priority` int NOT NULL DEFAULT 1,
  `price` decimal(15,4)	 NOT NULL DEFAULT '0.00000',
  `date_start` DATE NOT NULL DEFAULT '0000-00-00',
  `date_end` DATE NOT NULL DEFAULT '0000-00-00',
  PRIMARY KEY (`product_special_id`),
  KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_to_category`;

#
# Table structure for table 'product_to_category'
#

CREATE TABLE `product_to_category` (
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `category_id`),
  KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_to_download`;

#
# Table structure for table 'product_to_download'
#

CREATE TABLE `product_to_download` (
  `product_id` int NOT NULL,
  `download_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `download_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_to_layout`;

#
# Table structure for table 'product_to_layout'
#

CREATE TABLE `product_to_layout` (
  `product_id` int NOT NULL,
  `store_id` int NOT NULL,
  `layout_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `product_to_store`;

#
# Table structure for table 'product_to_store'
#

CREATE TABLE `product_to_store` (
  `product_id` int NOT NULL,
  `store_id` int NOT NULL,
  PRIMARY KEY (`product_id`, `store_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
