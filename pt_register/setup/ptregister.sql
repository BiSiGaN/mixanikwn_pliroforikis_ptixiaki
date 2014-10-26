CREATE TABLE IF NOT EXISTS `prefix_pt_register` (
  `uni_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `university` varchar(20) NOT NULL,
  `pt_username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `username` varchar(32) NOT NULL,
  PRIMARY KEY (`uni_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;