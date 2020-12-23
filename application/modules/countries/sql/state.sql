DROP TABLE IF EXISTS `country_state`;

#
# Table structure for table 'country_state'
#
CREATE TABLE `country_state` (
  `state_id` int unsigned NOT NULL AUTO_INCREMENT,
  `zone_id` int not null,
  `name` varchar(128),
  `code` varchar(32),
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`state_id`),
  KEY (`zone_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
