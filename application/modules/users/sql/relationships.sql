DROP TABLE IF EXISTS `relationships`;

#
# Table structure for table 'relationships'
#
CREATE TABLE `relationships` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `candidate_table` varchar(100) NOT NULL,
  `candidate_key` INT NOT NULL,
  `foreign_table` varchar(100) NOT NULL,
  `foreign_key` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `fuel_relationships`
--
ALTER TABLE `relationships`
ADD UNIQUE KEY `unique_key` (`candidate_table`,`candidate_key`,`foreign_table`,`foreign_key`),
ADD KEY `candidate_table` (`candidate_table`,`candidate_key`),
ADD KEY `foreign_table` (`foreign_table`,`foreign_key`);