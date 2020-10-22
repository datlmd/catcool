DROP TABLE IF EXISTS `stock_status`;

#
# Table structure for table 'stock_status'
#
CREATE TABLE `stock_status` (
  `stock_status_id` int unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`stock_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `stock_status_description`;

#
# Table structure for table 'stock_status_description'
#

CREATE TABLE `stock_status_description` (
  `stock_status_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`stock_status_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;