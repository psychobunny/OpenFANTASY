
CREATE TABLE IF NOT EXISTS `apps` (
  `appKey` varchar(255) NOT NULL,
  `appSecret` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  PRIMARY KEY (`namespace`),
  UNIQUE KEY `appKey` (`appKey`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;