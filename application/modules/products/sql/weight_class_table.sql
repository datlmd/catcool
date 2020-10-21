DROP TABLE IF EXISTS `weight_class`;

#
# Table structure for table 'weight_class'
#
CREATE TABLE `weight_class` (
  `weight_class_id` int unsigned NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '	0.00000000',
  PRIMARY KEY (`weight_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `weight_class_description`;

#
# Table structure for table 'weight_class_description'
#

CREATE TABLE `weight_class_description` (
  `weight_class_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`weight_class_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;