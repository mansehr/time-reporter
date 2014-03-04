<?php

require_once ('config.php');
require_once ('functions.php');



function update($newVersion, $sql) {
    $sitedata = new Sitedata(0);
    if($sitedata->version < $newVersion) {
        echo "Upgrading from version: $sitedata->version <br/>";
        $status = runSQLUpdate($sitedata, $newVersion, $sql);
        $sitedata->version = $newVersion;
        $sitedata->save();
        if($status) {
            echo "Updated to version: $sitedata->version <br/>";
        } else {
            echo "UPDATE FAILED.<br/>";
        }
    } else {
        echo "Up to date! Feel free to remove this script! <br/>".'<a href="./">HOME</a>';
    }
}

function runSQLUpdate($sitedata, $newVersion, $sql) {
    $status = true;
    $handler = new DbHandler();
    for($i = $sitedata->version; $i <= $newVersion; $i++) {
        foreach ($sql[$i] as $sql_str) {
            if(!$handler->query($sql_str)) {
                echo "FAILED: '$sql_str'<br/>"; 
                $status = false;
            } else {
                echo "OK<br/>";
            }
        }
    }
    return $status;
}

/// =============== Version 1 ====================
/*
 * --
-- Tabellstruktur `user_login`
--
 */
$sql[1][] = "
CREATE TABLE IF NOT EXISTS `user_login` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `authstr` varchar(32) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
$sql[1][] = "ALTER TABLE `user` DROP PRIMARY KEY;";
$sql[1][] = "ALTER TABLE `user` ADD `userid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
$sql[1][] = "ALTER TABLE `user_login` ADD `administrator` TINYINT NOT NULL DEFAULT '0' ;";
$sql[1][] = "INSERT INTO `user_login`(`username`, `password`, `userid`, `administrator`) select login, password, userid, administrator from `user` where 1;";
$sql[1][] = "ALTER TABLE `user` DROP `login`, DROP `password`, DROP `administrator`;";
$sql[1][] = "ALTER TABLE `sitedata` ADD `version` INT NOT NULL DEFAULT '1' ;";
$sql[1][] = "ALTER TABLE `sitedata` ADD `id` INT NOT NULL DEFAULT '0' FIRST, ADD UNIQUE (`id`)";

$newVersion = 2;

update($newVersion, $sql);