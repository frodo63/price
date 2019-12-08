-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: auto_kp
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.16.04.2

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
-- Table structure for table `express_kp`
--

DROP TABLE IF EXISTS `express_kp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `express_kp` (
  `id` tinyint(3) NOT NULL,
  `name` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `header` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `html` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `express_kp`
--

LOCK TABLES `express_kp` WRITE;
/*!40000 ALTER TABLE `express_kp` DISABLE KEYS */;
INSERT INTO `express_kp` VALUES (1,'ekp_oil_hydraulic','Гидравлика',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Bechem</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">STAROIL</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">TELLUS</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Total</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">AZOLLA | EQUIVIS</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">DTE | NUTO | SHC</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Castrol</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">HYSPIN</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Agip</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">TELIUM | BLASIA</td>\n  </tr>\n  <tr>\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Fuchs</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">RENOLIN</td>\n  </tr>\n </table>'),(2,'ekp_oil_reductor','Редукторы','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">OMALA</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">MOBILGEAR 600 XP</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Total</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">DACNIS | NEVASTANE</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Agip</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">TELIUM | BLASIA</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Castrol</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">ALPHASYN | OPTIGEAR</td>\n  </tr>\n </table>'),(3,'ekp_oil_compressor','Компрессоры','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">OMALA</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">RARUS, SHC</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Total</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">CARTER | NEVASTANE</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Agip</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">DICREA</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Castrol</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Aircol</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">FUCHS</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">RENOLIN</td>\n  </tr>\n </table>'),(4,'ekp_oil_transmission','Трансмиссия','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">ATF | Mobilfluid | Mobilube</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Spirax</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">FUCHS</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Titan</td>\n  </tr>\n\n </table>'),(5,'ekp_oil_diesel','Дизельные двигатели','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">М10ДМ, М8ДМ</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">М10Г2К, М8Г2К</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">М10Г2К, М8Г2К</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Delvac | Pegasus</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Spirax</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">CASTROL </td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Elixion | Enduron</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">FUCHS</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Titan</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Agip</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">i-Sigma</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">FUCHS</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Titan</td>\n  </tr>\n\n </table>'),(6,'ekp_oil_guideline','Направляющие','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">BECHEM</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">STAROIL CGLP</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Tonna</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Vactra №2</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">CASTROL</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Magna | Magnaglide</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">FUCHS</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">RENEP CGLP</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Agip</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">ENI EXIDIA HG</td>\n  </tr>\n\n </table>'),(7,'ekp_oil_chain','Цепи','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">BECHEM</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Berusynth | Berudraw</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Chain Oil</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Pyrolube | Chainsaw Oil</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">CASTROL</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Chain Spary O-R</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Agip</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">ENI Chain Lube</td>\n  </tr>\n\n </table>\n\n <p style=\'font-size: 20px; font-weight: bold; text-align: left\'>А также, масла:</p>\n <table>\n  <tr><td  style=\"font-size: 20px\">- с пищевым допуском</td></tr>\n  <tr><td  style=\"font-size: 20px\">- трансформаторные</td></tr>\n  <tr><td  style=\"font-size: 20px\">- биологически разлагающиеся</td></tr>\n  <tr><td  style=\"font-size: 20px\">- масла-теплоносители</td></tr>\n </table>'),(8,'ekp_gr_universal','Смазки Универсальные',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Литол-24</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Солидол Ж</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Смазка Графитовая</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Nano</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Grey Multipurpose</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Газпромнефть</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Gazpromneft L EP 2, 00</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Лукойл</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Термофлекс, Полифлекс</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Castrol</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Tribol RG 2 EP</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Kluber</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">CENTOPLEX 2 EP</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mannol</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">MP 2</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Mobilux, Mobilgrease</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Gadus</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">SKF</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">LGEV 2</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">WURTH</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Multi</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">AGIP</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">GR MU EP 00</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">TUTELA</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">ZETA 2</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Motorex</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Universal 190 EP</td>\n  </tr>\n\n </table>'),(9,'ekp_gr_highsustain','Смазки,устойчивые к воздействию сред и с длительным сроком службы','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">МС-70</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">АМС-3, АМС-1</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobilith</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">SCH</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">OKS</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">422</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Interflon</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Grease LS 2</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Total</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Lube #911</td>\n </tr>\n</table>'),(10,'ekp_gr_lowtemp','Смазки для низких температур и высоких скоростей','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Циатим-203, 202, 201</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Лита</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">МЗ</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Смазка Пушечная ПВК</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">МС-70</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Divinol</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Synthogrease LF 1</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Molykote</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">33 Medium</td>\n </tr>\n</table>'),(11,'ekp_gr_hightemp','Смазки для высоких температур','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Kluber</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">CENTOPLEX CX 4/375</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Stamina Grease R</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">SKF</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">LGHP 2</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">WURTH</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">HHS 5000</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Elcalub</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">FLC 400</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">OKS</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">422</td>\n </tr>\n</table>'),(12,'ekp_gr_food','Смазочные материалы для пищевой промышленности',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">BECHEM</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Berulub FB 34, FA 46</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">BECHEM</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Berulub FG-H 2 EP</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">BECHEM</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Berutemp 500 T2</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">ROCOL</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Foodlube Universal 2</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">CASTROL</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Optileb F&D Spray</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">SKF</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">LGFP 2</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">FUCHS</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">CASSIDA EPS 2</td>\n  </tr>\n\n </table>'),(13,'ekp_gr_gear','Трансмиссионные смазочные материалы','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Kluber</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">CENTOPLEX CX 4/375</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Total</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Nevastane 220 EP</td>\n </tr>\n\n</table>'),(14,'ekp_gr_silicone','Силиконовые смазочные материалы','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Kerry</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">KR-941</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Si-M</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">ИнтерАвто</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">SG-400</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">ПМС-400</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mannol</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Siliconespay Antistatic</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Molykote</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">33 Medium</td>\n </tr>\n\n</table>'),(15,'ekp_gr_electrocontact','Смазочные материалы для электроконтактов','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">ЭПС-98</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Bechem</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Berulub FK 30,60,97 E </td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Bechem</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">CERITOL CA 2 HELL\n  </td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Bechem</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">CERITOL SV 2 KF\n  </td>\n </tr>\n\n</table>'),(16,'ekp_gr_chain','Смазочные материалы для цепей','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Mannol</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">7901 Chain lube</td>\n </tr>\n\n</table>'),(17,'ekp_gr_composition','Резьбовые и монтажные смазки',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Berulub</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Antiseize 932</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Molykote</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">1000</td>\n  </tr>\n </table>'),(18,'ekp_gr_rope','Канатные смазки',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Смазка 39 У</td>\n  </tr>\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Торсиол-35</td>\n  </tr>\n </table>'),(19,'ekp_gr_guideline','Смазочные материалы для направляющих','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Divinol</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Lithogrease 000</td>\n </tr>\n\n</table>'),(20,'ekp_gr_support','Смазки для суппортов',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">ВМП АВТО</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">МС-1600</td>\n  </tr>\n\n </table>'),(21,'ekp_gr_polymer','Смазочные материалы для синтетических, полимерных материалов',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Bechem</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">	Berulub FR 16,43,57 EP</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Bechem</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">CERITOL PK 1 SOFT</td>\n  </tr>\n\n</table>'),(22,'ekp_gr_vniinp','СМАЗКИ ВНИИНП',' <br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">ВНИИНП</td>\n   <td style=\"width: 300px; border: 1px solid black; border-top:none; border-right: none\">207,225,231,232,235,273,274,275,279,282,286-М,501</td>\n  </tr>\n\n </table>'),(23,'ekp_gr_opengear','Адгезионные смазочные материалы для открытых передач','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Shell</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Gadus S3 Wirerope T</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">FUCHS</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">RENOLIT LZR 000</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Molykote</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">1122</td>\n </tr>\n\n</table>'),(24,'ekp_sl_sog','СОЖ для металлообработки','<br>\n<table style=\"border-collapse: collapse; font-size: 20px;\">\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">BECHEM</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Avantin 361, 402</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Mobil</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Mobilcut | Mobilmet</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\">Blaser</td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Blasocut | Vasco</td>\n </tr>\n\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">ВЭЛС-1М</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">МР-7</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Укринол</td>\n </tr>\n <tr style=\"border-bottom: none\">\n  <td style=\"width: 150px\"></td>\n  <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none; border-bottom: none\"></td>\n  <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none; border-bottom: none\">Эмульсол</td>\n </tr>\n\n</table>'),(25,'ekp_sl_cleaner','Очистители','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Kerry</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">KR-968</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Kerry</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Очиститель поверхности двигателя</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Очиститель парогенераторов ЛЕНИС</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Очиститель системы охлаждения Coolstream</td>\n  </tr>\n\n </table>'),(26,'ekp_sl_dissolver','Растворители','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Ацетон</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Керосин КО-25, РТ</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Нефрас С2-80-120</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Растворитель 646</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Спирт изопропиловый</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Уайт-спирит</td>\n  </tr>\n\n </table>'),(27,'ekp_sl_tosols','Тосолы, антифризы','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Тосол-А 40 М</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Антифриз G-11 (зеленый)</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Антифриз G-12 (красный)</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Coolstream</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">HDR</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Coolstream</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Optima Red</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Sintec</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Unlimited G12++</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\">Felix</td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Carbox G-12</td>\n  </tr>\n </table>'),(28,'ekp_sl_heattransfer','Теплоносители','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Барс ECO</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Барс ECO Extreme</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">Термолан</td>\n  </tr>\n </table>'),(29,'ekp_sl_brakes','Жидкости для тормозной системы','<br>\n <table style=\"border-collapse: collapse; font-size: 20px;\">\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">ДОТ-4</td>\n  </tr>\n\n  <tr style=\"border-bottom: none\">\n   <td style=\"width: 150px\"></td>\n   <td style=\"width: 80px; border: 1px solid black; border-top:none; border-left: none\"></td>\n   <td style=\"width: 250px; border: 1px solid black; border-top:none; border-right: none\">РОСДОТ</td>\n  </tr>\n </table>');
/*!40000 ALTER TABLE `express_kp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food_greases`
--

DROP TABLE IF EXISTS `food_greases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food_greases` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Total','Rocol','Matrix') COLLATE utf8_unicode_ci NOT NULL,
  `application` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `working_temp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `packing_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_greases`
--

LOCK TABLES `food_greases` WRITE;
/*!40000 ALTER TABLE `food_greases` DISABLE KEYS */;
INSERT INTO `food_greases` VALUES (1,'Berusil P 140 Spray','Bechem','Силиконовый спрей для пищевой и фармацевтической промышленности','Бесцветная, прозрачная жидкость с нейтральным запахом и вкусом','от -20 °C до +120 °C',NULL),(2,'Berulub Sihaf 2','Bechem','Смазка бело-кремового цвета для уплотнений, на базе силиконового масла.','Производства продуктов питания и напитков в воздушных и ротационных распределителях разливочных машин и керамических уплотнителях смесителей.','от -40 °C до +160 °C',NULL),(3,'Berulub FB 34','Bechem','Светлая, с нейтральными запахом и вкусом пищевая смазка.Пригоден для централизованных систем смазки','Универсальная смазка с пищевым допуском','от –40 °C до +160 °C',NULL),(4,'Berulub FA 46','Bechem','Смазка светлого цвета, с нейтральным запахом и вкусом','Универсальный смазочный материал для пищевой промышленности','от -20 °C до +120 °C',NULL),(5,'Berutemp 500 T2','Bechem','Смазка для экстремально высоких температур (до +280 °C) и скоростей в условиях вакуума. Исключительная стабильность к термическому и химическому разложению','Полностью синтетическая высокотемпературная смазка с допуском H1','от -20 +260 °C',NULL);
/*!40000 ALTER TABLE `food_greases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food_oils`
--

DROP TABLE IF EXISTS `food_oils`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food_oils` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Total','Rocol','Matrix') COLLATE utf8_unicode_ci NOT NULL,
  `application` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `working_temp` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `packing_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_oils`
--

LOCK TABLES `food_oils` WRITE;
/*!40000 ALTER TABLE `food_oils` DISABLE KEYS */;
INSERT INTO `food_oils` VALUES (1,'\nBerulub Fluid W+B','Bechem','	Смазочное масло для пищевой промышленности','Прозрачное, смазочное масло, не имеющее в своем составе смолу и кислоту. Растворяет грязь и ржавчину.Пригоден для централизованных систем смазки','от –40 °C до +160 °C',NULL),(2,'Plantfluid','Bechem','Применяется для смазки ленточных транспортёров и цепей в печах непрерывного действия для хлеба и хлебобулочных изделий.','Природный прозрачный термостойкий смазочный материал для крупных пекарен.','от 0 °C до +290 °C',''),(4,'Berusynth 15 H1 - 1000 H1','Bechem','гидравлика, редуктор, циркуляционная система, вентилятор, компрессор, пневмоблок, транспортные и приводные цепи, централизованное смазывание','Универсальное масло. Выступает в роли гидравлического (для вязкостей 15-150 HLP), компрессорного (для вязкостей 32-150 VDL), редукторного (для вязкостей 15-1000 CLP).','15	-60+120°C<br>\n32-68	-50+140°C<br>\n100-220	-45+160°C<br>\n320,460	-35+160°C<br>\n680,1000	-25+180°C',''),(5,'NEVASTANE AW','Total','Предназначено для смазывания гидравлических систем оборудования пищевой промышленности. Это гидравлические системы под давлением и/или ротационные винтовые компрессоры.','Белое минеральное масло, H1 допуск','Вязкость:22,32,46,68',NULL),(6,'NEVASTANE SH','Total','Предназначены для смазывания оборудования пищевой промышленности (воздушные компрессоры, вакуумные насосы и гидравлические системы), в особенности, работающего при низких температурах.','100% синтетика ПАО, H1 допуск','Вязкость:32, 46,68,100',NULL);
/*!40000 ALTER TABLE `food_oils` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `food_specliqs`
--

DROP TABLE IF EXISTS `food_specliqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `food_specliqs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Total','Rocol','Matrix') COLLATE utf8_unicode_ci NOT NULL,
  `application` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `packing_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_specliqs`
--

LOCK TABLES `food_specliqs` WRITE;
/*!40000 ALTER TABLE `food_specliqs` DISABLE KEYS */;
/*!40000 ALTER TABLE `food_specliqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_chain`
--

DROP TABLE IF EXISTS `general_greases_chain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_chain` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_chain`
--

LOCK TABLES `general_greases_chain` WRITE;
/*!40000 ALTER TABLE `general_greases_chain` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_chain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_composition`
--

DROP TABLE IF EXISTS `general_greases_composition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_composition` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_composition`
--

LOCK TABLES `general_greases_composition` WRITE;
/*!40000 ALTER TABLE `general_greases_composition` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_composition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_highsustain`
--

DROP TABLE IF EXISTS `general_greases_highsustain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_highsustain` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_highsustain`
--

LOCK TABLES `general_greases_highsustain` WRITE;
/*!40000 ALTER TABLE `general_greases_highsustain` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_highsustain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_hightemp`
--

DROP TABLE IF EXISTS `general_greases_hightemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_hightemp` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_hightemp`
--

LOCK TABLES `general_greases_hightemp` WRITE;
/*!40000 ALTER TABLE `general_greases_hightemp` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_hightemp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_lowtemp`
--

DROP TABLE IF EXISTS `general_greases_lowtemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_lowtemp` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_lowtemp`
--

LOCK TABLES `general_greases_lowtemp` WRITE;
/*!40000 ALTER TABLE `general_greases_lowtemp` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_lowtemp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_silicone`
--

DROP TABLE IF EXISTS `general_greases_silicone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_silicone` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_silicone`
--

LOCK TABLES `general_greases_silicone` WRITE;
/*!40000 ALTER TABLE `general_greases_silicone` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_silicone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_greases_universal`
--

DROP TABLE IF EXISTS `general_greases_universal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_greases_universal` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_greases_universal`
--

LOCK TABLES `general_greases_universal` WRITE;
/*!40000 ALTER TABLE `general_greases_universal` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_greases_universal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_chain`
--

DROP TABLE IF EXISTS `general_oils_chain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_chain` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_chain`
--

LOCK TABLES `general_oils_chain` WRITE;
/*!40000 ALTER TABLE `general_oils_chain` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_oils_chain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_compressor`
--

DROP TABLE IF EXISTS `general_oils_compressor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_compressor` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_compressor`
--

LOCK TABLES `general_oils_compressor` WRITE;
/*!40000 ALTER TABLE `general_oils_compressor` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_oils_compressor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_guideline`
--

DROP TABLE IF EXISTS `general_oils_guideline`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_guideline` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_guideline`
--

LOCK TABLES `general_oils_guideline` WRITE;
/*!40000 ALTER TABLE `general_oils_guideline` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_oils_guideline` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_hydraulic`
--

DROP TABLE IF EXISTS `general_oils_hydraulic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_hydraulic` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total','Troy') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` tinyint(3) NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_hydraulic`
--

LOCK TABLES `general_oils_hydraulic` WRITE;
/*!40000 ALTER TABLE `general_oils_hydraulic` DISABLE KEYS */;
INSERT INTO `general_oils_hydraulic` VALUES (1,'Staroil NR 10 (G 10)','Bechem','BECHEM STAROIL NR применяется в гидравлических установках в качестве жидкости, передающей энергию. При их эксплуатации приходится обращать особое внимание на антикоррозионную защиту, для насосов и гидромоторов этих установок, из-за их конструктивного исполнения или условий эксплуатации, требуются масла с добавками для уменьшения износа при смешанном трении.','Защита от коррозии \nЗначительные перепады температуры \nЛегко отделяет воду ',10,'20л - 5000р<br>208л - 50000р'),(2,'Azolla ZS 10','Total','Основной узел применения продукта: Гидравлические системы, работающие в наиболее сложных эксплуатационных условиях: металлорежущие станки, формовочные машины для литья под давлением (методом впрыска) или методом инжекционного прессования, прессовальное и другое промышленное стационарное или мобильное оборудование.','Защита от износа \nЗащита от коррозии \nОкислительная стабильность \nЗначительные перепады температуры \nЛегко отделяет воду \nДлительный срок службы ',10,'20л - 5000р<br>208л - 50000р'),(3,'Tellus S3 V 32','Shell','Высокоэффективная гидравлическая жидкость, созданная с использованием эксклюзивного беззольного пакета противоизносных и вязкостных присадок, устойчивых к сдвиговым нагрузкам. Стабильная вязкость и защита при тяжелых механических нагрузках, термическом и химическом воздействии во всем диапазоне рабочих температур. ','Обеспечивает превосходную защиту и стабильную работу гидравлических систем мобильной и прочей техники, эксплуатируемой в широком диапазоне температур окружающей среды или рабочих температур в гидравлической системе.',32,'20л - 5000р<br>208л - 50000р');
/*!40000 ALTER TABLE `general_oils_hydraulic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_motor`
--

DROP TABLE IF EXISTS `general_oils_motor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_motor` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_motor`
--

LOCK TABLES `general_oils_motor` WRITE;
/*!40000 ALTER TABLE `general_oils_motor` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_oils_motor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_reductor`
--

DROP TABLE IF EXISTS `general_oils_reductor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_reductor` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_reductor`
--

LOCK TABLES `general_oils_reductor` WRITE;
/*!40000 ALTER TABLE `general_oils_reductor` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_oils_reductor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_oils_transmission`
--

DROP TABLE IF EXISTS `general_oils_transmission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_oils_transmission` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `viscosity` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_oils_transmission`
--

LOCK TABLES `general_oils_transmission` WRITE;
/*!40000 ALTER TABLE `general_oils_transmission` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_oils_transmission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_specliqs_cleaners`
--

DROP TABLE IF EXISTS `general_specliqs_cleaners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_specliqs_cleaners` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_specliqs_cleaners`
--

LOCK TABLES `general_specliqs_cleaners` WRITE;
/*!40000 ALTER TABLE `general_specliqs_cleaners` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_specliqs_cleaners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_specliqs_dissolvers`
--

DROP TABLE IF EXISTS `general_specliqs_dissolvers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_specliqs_dissolvers` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_specliqs_dissolvers`
--

LOCK TABLES `general_specliqs_dissolvers` WRITE;
/*!40000 ALTER TABLE `general_specliqs_dissolvers` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_specliqs_dissolvers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_specliqs_heattransfer`
--

DROP TABLE IF EXISTS `general_specliqs_heattransfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_specliqs_heattransfer` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_specliqs_heattransfer`
--

LOCK TABLES `general_specliqs_heattransfer` WRITE;
/*!40000 ALTER TABLE `general_specliqs_heattransfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_specliqs_heattransfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `general_specliqs_tosols`
--

DROP TABLE IF EXISTS `general_specliqs_tosols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `general_specliqs_tosols` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `general_specliqs_tosols`
--

LOCK TABLES `general_specliqs_tosols` WRITE;
/*!40000 ALTER TABLE `general_specliqs_tosols` DISABLE KEYS */;
/*!40000 ALTER TABLE `general_specliqs_tosols` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metalworking_soges`
--

DROP TABLE IF EXISTS `metalworking_soges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metalworking_soges` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Mol') COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `operations` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `metal_types` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `concentration` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `packing_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metalworking_soges`
--

LOCK TABLES `metalworking_soges` WRITE;
/*!40000 ALTER TABLE `metalworking_soges` DISABLE KEYS */;
INSERT INTO `metalworking_soges` VALUES (1,'Avantin 361 I-N','Bechem','Хорошая совместимость с кожей и отличные качества для обработки резанием, прежде всего при процессах обработки, при которых требуется повышенная смазывающая способность для инструмента. Подходит для любого качества воды, не пенится','Резание, Шлифование','Алюминий, Цветные металлы, Сталь','Резание алюминия: 7 - 10%, Резание стали: 5 - 7%','20л - 11000 р.<br>200л - 102000 р.'),(2,'Avantin 320 S','Bechem','Очень хорошая защита от коррозии и превосходные моющие свойства. Данный продукт беcпроблемно применяется в воде, имеющей жесткость от 3°dH. Он обладает высокой стабильностью эмульсии и, исходя из этого, длительными сроками службы эмульсии.','Резание, Шлифование','Сталь низколегированная, Чугун','Общее резание: 3-6%, Сложное резание: 5-10%','20л - 8100 р.<br>200л - 78300р.'),(3,'Avantin 402','Bechem','Не содержащий минерального масла водосмешиваемый концентрат СОЖ с хорошими антикоррозионными свойствами. Благодаря специальному аддитивированию BECHEM Avantin 402 успешно применяется при обработке резанием стальных и чугунных материалов и при нарезке резьбы. Cтороннее масло не эмульгируется, поэтому не возникает задымления.','Резание, Шлифование','Сталь, Чугун','Общее резание: 6-10%, Шлифование: 4-5%','20л - 10000р.<br>\n200л - 99100р.');
/*!40000 ALTER TABLE `metalworking_soges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metalworking_specliqs`
--

DROP TABLE IF EXISTS `metalworking_specliqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metalworking_specliqs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total','Troy') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci,
  `description` text COLLATE utf8_unicode_ci,
  `package_price` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metalworking_specliqs`
--

LOCK TABLES `metalworking_specliqs` WRITE;
/*!40000 ALTER TABLE `metalworking_specliqs` DISABLE KEYS */;
INSERT INTO `metalworking_specliqs` VALUES (1,'Bakterizid RH','Bechem','Идеально раскрывает свое бактерицидное\nдействие при последующей консервации смешанных с водой\nСОЖ и очистителей.','Bakterizid RH техническое средство для\nконсервации с очень высоким действием против\nбактерий и грибков на базе изотиазолинонов',NULL),(2,'Troyshield FF5','Troy','При применении средства происходит удаление неприятно пахнущей биомассы и отложений. Кроме того, удаляется\nгрибковый налет в паровой зоне системы, и обеспечивается чистота\nустановки до следующего заполнения новой жидкостью.','Комбинация поверхностно-активных веществ и\nактивных бактерицидов и фунгицидов. Средство специально разработано\nдля промывки загрязненных систем со смазочно-охлаждающей жидкостью\n(СОЖ) и обеспечивает отличный результат как в центральных системах,\nтак и станках с отдельным заполнением.',NULL);
/*!40000 ALTER TABLE `metalworking_specliqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tails`
--

DROP TABLE IF EXISTS `tails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tails` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` enum('marina','sergey','timur','dima') COLLATE utf8_unicode_ci NOT NULL,
  `html` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tails`
--

LOCK TABLES `tails` WRITE;
/*!40000 ALTER TABLE `tails` DISABLE KEYS */;
INSERT INTO `tails` VALUES (1,'marina','-- <br>\nС уважением,<br>\nБаева Марина Юрьевна<br>\nДиректор ООО \"Лубритэк\"<br>\nhttps://лубритэк.рф/<br>\n<br>\n(846) 931-42-60, факс 931-03-57,<br>\nмоб. +7-927-653-23-56,<br> +7-996-736-37-87'),(2,'dima','-- <br>\nС уважением,<br>\nБаев Дмитрий Вадимович<br>\nЮрисконсульт ООО \"Лубритэк\"<br>\n\nhttps://лубритэк.рф/<br>\n(846) 931-42-60, факс931-03-57,<br> моб. 8-927-687-24-51<br>'),(3,'timur','-- <br>\nС уважением,<br>\nНабиев Тимур Александрович<br>\nВедущий специалист Отдела Развития<br>\nООО \"Лубритэк\"<br>\n\nhttps://лубритэк.рф/<br>\n(846) 931-42-60, факс 931-03-57,<br> моб. 8-927-694-63-14<br>'),(4,'sergey','-- <br>\nС уважением,<br>\n\nУлитов Сергей Викторович<br>\n\nТехнический директор ООО \"Лубритэк\"<br>\n\nhttps://лубритэк.рф/<br>\n(846) 931-42-60, факс 931-03-57,<br> моб. 8-927-749-43-68');
/*!40000 ALTER TABLE `tails` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-12-08 19:53:20
