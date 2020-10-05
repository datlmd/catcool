
DROP TABLE IF EXISTS `layout`;

#
# Table structure for table 'layout'
#
CREATE TABLE `layout` (
  `layout_id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255),
  PRIMARY KEY (`layout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `layout_module`;

#
# Table structure for table 'layout_module'
#
CREATE TABLE `layout_module` (
  `layout_module_id` int unsigned NOT NULL AUTO_INCREMENT,
  `layout_id` int not null,
  `code` varchar(64) NOT NULL,
  `position` varchar(16) NOT NULL,
  `sort_order` int(3) NULL DEFAULT 0,
  PRIMARY KEY (`layout_module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `layout_route`;

#
# Table structure for table 'layout_route'
#
CREATE TABLE `layout_route` (
  `layout_route_id` int unsigned NOT NULL AUTO_INCREMENT,
  `layout_id` int not null,
  `store_id` int NOT NULL DEFAULT 0,
  `route` varchar(100) NOT NULL,
  PRIMARY KEY (`layout_route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;