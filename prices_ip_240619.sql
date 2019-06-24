-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: prices_ip
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `allnames`
--

DROP TABLE IF EXISTS `allnames`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allnames` (
  `nameid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`nameid`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allnames`
--

LOCK TABLES `allnames` WRITE;
/*!40000 ALTER TABLE `allnames` DISABLE KEYS */;
INSERT INTO `allnames` VALUES (1,'Улитов Сергей Викторович'),(2,'Сызранская Керамика'),(3,'ЧИРОЛ'),(4,'СУПЕРКОНТ'),(5,'ПЭК'),(6,'СОЖ Avantin 361 I-N (18 кг) в шт'),(7,'Наш Партнер'),(8,'СТС Люкс'),(9,'Саминтех (Би Питрон)'),(10,'ООО Дикомп-Классик'),(11,'Прогресс'),(12,'Стройиндустрия'),(13,'ВиК'),(14,'ООО АМ-Ойл'),(15,'ПРОМ ТЭК 272-56-48 / 266-84-35'),(16,'АО МЕДХИМ'),(17,'ТК Химэкспресс '),(18,'ЕвроСмаз (495) 730-64-15'),(19,'ДВК ТД'),(20,'Shell Tonna S3 M68 (20 л) масло для направляющих в шт'),(21,'КС-19 (216,5/180 кг) - масло компрессорное  в шт'),(22,'Castrol Magnatec 5w-40 (4 л) в шт'),(23,'Смазка Литол-24 (2 кг) в шт'),(24,'Масло Berusynth H1 220 (20л.) в шт');
/*!40000 ALTER TABLE `allnames` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `byers`
--

DROP TABLE IF EXISTS `byers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `byers` (
  `byers_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `byers_nameid` mediumint(8) unsigned NOT NULL,
  `ov_firstobp` float(5,2) unsigned DEFAULT NULL,
  `ov_tp` float(5,2) unsigned DEFAULT NULL,
  `ov_wt` float(4,2) unsigned DEFAULT NULL,
  `comment` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `onec_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `byers_uid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`byers_id`),
  UNIQUE KEY `byers_uid` (`byers_uid`),
  KEY `byer_nameid` (`byers_nameid`),
  CONSTRAINT `byers_ibfk_1` FOREIGN KEY (`byers_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `byers`
--

LOCK TABLES `byers` WRITE;
/*!40000 ALTER TABLE `byers` DISABLE KEYS */;
INSERT INTO `byers` VALUES (1,1,NULL,NULL,NULL,NULL,'﻿000000002','60e14d10-448f-11e8-8d93-50465d50a210'),(2,2,NULL,NULL,NULL,NULL,'000000007','50b0f68e-600d-11e8-a735-50465d50a210'),(3,7,NULL,NULL,NULL,NULL,'000000011','35a0ec13-6b16-11e8-908a-50465d50a210'),(4,8,NULL,NULL,NULL,NULL,'000000013','c77ccd19-744b-11e8-a626-50465d50a210'),(5,9,NULL,NULL,NULL,NULL,'000000014','c6d13880-7471-11e8-a626-50465d50a210'),(6,10,NULL,NULL,NULL,NULL,'000000022','e78314ca-832d-11e8-80b6-50465d50a210'),(7,11,NULL,NULL,NULL,NULL,'000000031','d2547c60-b820-11e8-b988-6c626df87d4c'),(8,12,NULL,NULL,NULL,NULL,'000000041','6d6a84af-9101-11e9-aee5-50465d50a210');
/*!40000 ALTER TABLE `byers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `giveaways`
--

DROP TABLE IF EXISTS `giveaways`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `giveaways` (
  `given_away` date NOT NULL,
  `giveaways_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `giveaway_sum` float(14,2) unsigned NOT NULL,
  `requestid` mediumint(8) unsigned NOT NULL,
  `byersid` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`giveaways_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `giveaways`
--

LOCK TABLES `giveaways` WRITE;
/*!40000 ALTER TABLE `giveaways` DISABLE KEYS */;
/*!40000 ALTER TABLE `giveaways` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `options_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'general',
  `ga_period` enum('year','quarter','month') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'year'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `payed` date NOT NULL,
  `payments_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `onec_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payments_uid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `number` smallint(5) unsigned NOT NULL,
  `sum` float(14,2) unsigned NOT NULL,
  `requestid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`payments_id`),
  UNIQUE KEY `payments_uid` (`payments_uid`),
  KEY `requestid` (`requestid`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`requestid`) REFERENCES `requests` (`requests_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pricings`
--

DROP TABLE IF EXISTS `pricings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pricings` (
  `pricingid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `positionid` smallint(5) unsigned NOT NULL,
  `tradeid` smallint(5) unsigned NOT NULL,
  `sellerid` smallint(5) unsigned DEFAULT NULL,
  `zak` float unsigned DEFAULT NULL,
  `kol` smallint(5) unsigned NOT NULL,
  `tzr` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tzrknam` smallint(5) unsigned NOT NULL DEFAULT '0',
  `tzrkpok` smallint(5) unsigned NOT NULL DEFAULT '0',
  `wtime` float unsigned DEFAULT NULL,
  `fixed` smallint(5) unsigned NOT NULL,
  `op` float(9,2) unsigned NOT NULL,
  `tp` float(8,2) unsigned DEFAULT NULL,
  `opr` float unsigned NOT NULL,
  `tpr` float unsigned DEFAULT NULL,
  `firstobp` float unsigned DEFAULT NULL,
  `firstobpr` float unsigned DEFAULT NULL,
  `firstoh` float unsigned DEFAULT NULL,
  `marge` float unsigned DEFAULT NULL,
  `margek` float unsigned DEFAULT NULL,
  `rop` float unsigned DEFAULT NULL,
  `realop` float unsigned DEFAULT NULL,
  `rtp` float unsigned DEFAULT NULL,
  `realtp` float unsigned DEFAULT NULL,
  `clearp` float(9,2) unsigned DEFAULT NULL,
  `obp` float unsigned DEFAULT NULL,
  `oh` smallint(5) unsigned DEFAULT NULL,
  `price` float(14,3) unsigned NOT NULL,
  `rent` float unsigned NOT NULL,
  `winner` smallint(5) unsigned DEFAULT NULL,
  `wtr` float unsigned NOT NULL DEFAULT '0',
  `wtimeday` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`pricingid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pricings`
--

LOCK TABLES `pricings` WRITE;
/*!40000 ALTER TABLE `pricings` DISABLE KEYS */;
/*!40000 ALTER TABLE `pricings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `req_positions`
--

DROP TABLE IF EXISTS `req_positions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `req_positions` (
  `req_positionid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `winnerid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `requestid` mediumint(8) unsigned NOT NULL,
  `line_num` tinyint(2) unsigned NOT NULL,
  `giveaway` tinyint(1) DEFAULT NULL,
  `queen` tinyint(1) DEFAULT NULL,
  `ov_op` float(5,2) unsigned DEFAULT NULL,
  `ov_tp` float(5,2) unsigned DEFAULT NULL,
  `ov_firstobp` float(5,2) unsigned DEFAULT NULL,
  `ov_wt` float(4,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`req_positionid`),
  KEY `requestid` (`requestid`),
  CONSTRAINT `req_positions_ibfk_1` FOREIGN KEY (`requestid`) REFERENCES `requests` (`requests_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `req_positions`
--

LOCK TABLES `req_positions` WRITE;
/*!40000 ALTER TABLE `req_positions` DISABLE KEYS */;
/*!40000 ALTER TABLE `req_positions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requests`
--

DROP TABLE IF EXISTS `requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requests` (
  `created` date NOT NULL,
  `requests_id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `requests_uid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `requests_nameid` mediumint(8) unsigned DEFAULT NULL,
  `req_rent` float unsigned DEFAULT '0',
  `byersid` smallint(5) unsigned NOT NULL,
  `req_sum` float(14,2) DEFAULT NULL,
  `1c_num` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ov_op` float(5,2) unsigned DEFAULT NULL,
  `ov_firstobp` float(5,2) unsigned DEFAULT NULL,
  `ov_tp` float(5,2) unsigned DEFAULT NULL,
  `ov_wt` float(4,2) unsigned DEFAULT NULL,
  `r1_hidden` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`requests_id`),
  UNIQUE KEY `requests_uid` (`requests_uid`),
  KEY `req_nameid` (`requests_nameid`),
  KEY `1c_num` (`1c_num`),
  CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`requests_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requests`
--

LOCK TABLES `requests` WRITE;
/*!40000 ALTER TABLE `requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sellers`
--

DROP TABLE IF EXISTS `sellers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sellers` (
  `sellers_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `sellers_nameid` mediumint(8) unsigned NOT NULL,
  `onec_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sellers_uid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`sellers_id`),
  UNIQUE KEY `sellers_uid` (`sellers_uid`),
  KEY `seller_nameid` (`sellers_nameid`),
  CONSTRAINT `sellers_ibfk_1` FOREIGN KEY (`sellers_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sellers`
--

LOCK TABLES `sellers` WRITE;
/*!40000 ALTER TABLE `sellers` DISABLE KEYS */;
INSERT INTO `sellers` VALUES (1,3,'000000006','69ff2139-59be-11e8-8e61-50465d50a210'),(2,4,'000000010','f8fc4c99-6a54-11e8-bdde-50465d50a210'),(3,5,'000000040','f4ebacb0-7aee-11e9-9bc3-6c626df87d4c'),(4,13,'000000012','35a0ec1b-6b16-11e8-908a-50465d50a210'),(5,14,'000000016','e6156b5e-7ab8-11e8-b6fa-50465d50a210'),(6,15,'000000023','1036d380-88eb-11e8-bb0d-50465d50a210'),(7,16,'000000025','424ec46a-9575-11e8-a1c1-50465d50a210'),(8,17,'000000027','6b4d142b-9bab-11e8-9ea5-50465d50a210'),(9,18,'000000029','59e8e372-b5bd-11e8-bb45-6c626df87d4c'),(10,19,'000000030','59e8e377-b5bd-11e8-bb45-6c626df87d4c');
/*!40000 ALTER TABLE `sellers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trades`
--

DROP TABLE IF EXISTS `trades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trades` (
  `trades_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `trades_uid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `trades_nameid` mediumint(8) unsigned NOT NULL,
  `tare` enum('штука','банка','канистра','бочка') COLLATE utf8_unicode_ci NOT NULL,
  `onec_id` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`trades_id`),
  UNIQUE KEY `trades_uid` (`trades_uid`),
  KEY `trade_nameid` (`trades_nameid`),
  CONSTRAINT `trades_ibfk_1` FOREIGN KEY (`trades_nameid`) REFERENCES `allnames` (`nameid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trades`
--

LOCK TABLES `trades` WRITE;
/*!40000 ALTER TABLE `trades` DISABLE KEYS */;
INSERT INTO `trades` VALUES (1,'82ef333b-49ec-11e8-a1f3-50465d50a210',6,'канистра','00000000006'),(2,'47e877a7-9260-11e9-b2c8-50465d50a210',20,'канистра','00000000053'),(3,'6d6a84b3-9101-11e9-aee5-50465d50a210',21,'бочка','00000000052'),(4,'7c8d742e-7710-11e9-91e5-6c626df87f88',22,'банка','00000000050'),(5,'d19f02a5-757d-11e9-bf9e-6c626df87f88',23,'банка','00000000048'),(6,'a538c7dd-6b3d-11e9-a8a5-6c626df87f88',24,'канистра','00000000047');
/*!40000 ALTER TABLE `trades` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-24 18:44:26
