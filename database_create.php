<?php
include_once 'pdo_connect.php';

$query = "

CREATE TABLE IF NOT EXISTS `allnames` (
`nameid` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
`name` VARCHAR(255) NOT NULL UNIQUE,
 PRIMARY KEY(`nameid`)
);

CREATE TABLE IF NOT EXISTS `trades` (
`tradeid` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`trades_nameid` MEDIUMINT UNSIGNED NOT NULL,
 PRIMARY KEY (`tradeid`),
 FOREIGN KEY (`trades_nameid`) REFERENCES `allnames`(`nameid`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `byers` (
`byers_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`byers_nameid` MEDIUMINT UNSIGNED NOT NULL,
`clearp` FLOAT(2) UNSIGNED,
`obnal` SMALLINT UNSIGNED,
`wtime` FLOAT(2) UNSIGNED,
 PRIMARY KEY (`byers_id`),
 FOREIGN KEY (`byers_nameid`) REFERENCES `allnames`(`nameid`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `sellers` (
`sellers_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`sellers_nameid` MEDIUMINT UNSIGNED NOT NULL,
 PRIMARY KEY (`sellers_id`),
 FOREIGN KEY (`sellers_nameid`) REFERENCES `allnames`(`nameid`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `requests` (
`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`requests_id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
`requests_nameid` MEDIUMINT UNSIGNED NOT NULL,
`req_comment` VARCHAR(255),
`req_rent` FLOAT(3) UNSIGNED,
`byersid` SMALLINT UNSIGNED NOT NULL,
`payment` BOOLEAN NULL,
`req_sum` INT NOT NULL,
`1c_num` TINYINT NULL
 PRIMARY KEY (`requests_id`),
 FOREIGN KEY (`requests_nameid`) REFERENCES `allnames`(`nameid`),
 FOREIGN KEY (`byersid`) REFERENCES `byers`(`byers_id`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `req_positions` (
`req_positionid` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`pos_name` VARCHAR(255) NOT NULL,
`winnerid`  SMALLINT UNSIGNED NOT NULL,
`requestid` MEDIUMINT UNSIGNED NOT NULL,
`giveaway` BOOLEAN NULL,
 PRIMARY KEY (`req_positionid`),
 FOREIGN KEY (`requestid`) REFERENCES `requests`(`requests_id`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `payments` (
`payed` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`payments_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`number` SMALLINT UNSIGNED NOT NULL,
`comment` VARCHAR(255) NULL,
`amount` FLOAT(2) UNSIGNED NOT NULL,
`requestid` MEDIUMINT UNSIGNED NOT NULL,
 PRIMARY KEY (`payments_id`),
 FOREIGN KEY (`requestid`) REFERENCES `requests`(`requests_id`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `giveaways` (
`given_away` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`giveaways_id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`comment` VARCHAR(255) NULL DEFAULT NULL,
`giveaway_sum` FLOAT(2) UNSIGNED NOT NULL,
`requestid` MEDIUMINT UNSIGNED NOT NULL,
 PRIMARY KEY (`giveaways_id`),
 FOREIGN KEY (`requestid`) REFERENCES `requests`(`requests_id`)
 ON UPDATE CASCADE
 ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS `pricings` (
`pricingid` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
`positionid` SMALLINT UNSIGNED NOT NULL,
    `tradeid` SMALLINT UNSIGNED NOT NULL,
    `sellerid` SMALLINT UNSIGNED NOT NULL,
    `zak` FLOAT(3) UNSIGNED NOT NULL,
    `kol` SMALLINT UNSIGNED NOT NULL,
    `tzr` SMALLINT UNSIGNED,
    `wtime` SMALLINT UNSIGNED,
    `fixed` SMALLINT UNSIGNED NOT NULL,
    `op` FLOAT(2) UNSIGNED NOT NULL,
    `tp` FLOAT(2) UNSIGNED NOT NULL,
    `opr` FLOAT(2) UNSIGNED NOT NULL,
    `tpr` FLOAT(2) UNSIGNED NOT NULL,
    `firstobp` FLOAT(2) UNSIGNED NOT NULL,
    `firstobpr` FLOAT(2) UNSIGNED NOT NULL,
    `firstoh` FLOAT(2) UNSIGNED NOT NULL,
    `marge` FLOAT(2) UNSIGNED NOT NULL,
    `margek` FLOAT(2) UNSIGNED NOT NULL,
    `rop` FLOAT(2) UNSIGNED NOT NULL,
    `realop` FLOAT(2) UNSIGNED NOT NULL,
    `rtp` FLOAT(2) UNSIGNED NOT NULL,
    `realtp` FLOAT(2) UNSIGNED NOT NULL,
    `clearp` FLOAT(2) UNSIGNED NOT NULL,
    `obp`FLOAT(2) UNSIGNED NOT NULL,
    `oh` SMALLINT UNSIGNED NOT NULL,
    `price` FLOAT(2) UNSIGNED NOT NULL,
    `rent` FLOAT(3) UNSIGNED NOT NULL,
    `winner` SMALLINT UNSIGNED,
    `datetime` TIMESTAMP(6),
     PRIMARY KEY (`pricingid`),
     FOREIGN KEY (`sellerid`) REFERENCES `sellers`(`sellers_id`)
)
CREATE TABLE IF NOT EXISTS `payments`
";

$connected = $pdo->query($query);
if ($connected){
    echo "<p id='db_status'>It's all right, man, the DB is there</p>";
} else {echo "<p id='db_status'>Where are you? man???</p>";};