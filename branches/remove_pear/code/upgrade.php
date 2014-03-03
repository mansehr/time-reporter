<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * --
-- Tabellstruktur `user_login`
--
 */
$sql = "
CREATE TABLE IF NOT EXISTS `user_login` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `authstr` varchar(32) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;"

        
ALTER TABLE `user` DROP PRIMARY KEY;

ALTER TABLE `user` ADD `userid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

INSERT INTO `user_login`(`username`, `password`, `userid`) select login, password, userid from `user` where 1;

ALTER TABLE `user`
  DROP `login`,
  DROP `password`;
