DROP TABLE IF EXISTS `length_class`;

#
# Table structure for table 'length_class'
#
CREATE TABLE `length_class` (
  `length_class_id` int unsigned NOT NULL AUTO_INCREMENT,
  `value` decimal(15,8) NOT NULL DEFAULT '	0.00000000',
  PRIMARY KEY (`length_class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `length_class_description`;

#
# Table structure for table 'length_class_description'
#

CREATE TABLE `length_class_description` (
  `length_class_id` int NOT NULL,
  `language_id` int NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '',
  `unit` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`length_class_id`,`language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;