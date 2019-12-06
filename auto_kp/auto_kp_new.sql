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
INSERT INTO `food_greases` VALUES (1,'Berusil P 140 Spray','Bechem','Силиконовый спрей для пищевой и фармацевтической промышленности','Бесцветная, прозрачная жидкость с нейтральным запахом и вкусом','от -20 °C до +120 °C',NULL),(2,'Berulub Sihaf 2','Bechem','Смазка бело-кремового цвета для уплотнений, на базе силиконового масла.','Производства продуктов питания и напитков в воздушных и ротационных распределителях разливочных машин и керамических уплотнителях смесителей.','от -40 °C до +160 °C',NULL),(3,'Berulub FB 34','Bechem','Светлая, с нейтральными запахом и вкусом пищевая смазка.Пригоден для централизованных систем смазки','Универсальная смазка с пищевым допуском','от –40 °C до +160 °C',NULL),(4,'Berulub FA 46','Bechem','Смазка светлого цвета, с нейтральным запахом и вкусом','Универсальный смазочный материал для пищевой промышленности','от -20 °C до +120 °C',NULL),(5,'Berutemp 500 T2','Bechem','Смазка для экстремально высоких температур (до +280 °C) и скоростей в условиях вакуума. Исключительная стабильность к термическому и химическому разложению','Полностью синтетическая высокотемпературная смазка с допуском H1','от -20 +260 °C',NULL),(6,'NEVASTANE AW','Total','Предназначено для смазывания гидравлических систем оборудования пищевой промышленности. Это гидравлические системы под давлением и/или ротационные винтовые компрессоры.','Белое минеральное масло, H1 допуск','Вязкость:22,32,46,68',NULL),(7,'NEVASTANE SH','Total','Предназначены для смазывания оборудования пищевой промышленности (воздушные компрессоры, вакуумные насосы и гидравлические системы), в особенности, работающего при низких температурах.','100% синтетика ПАО, H1 допуск','Вязкость:32, 46,68,100',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `food_oils`
--

LOCK TABLES `food_oils` WRITE;
/*!40000 ALTER TABLE `food_oils` DISABLE KEYS */;
INSERT INTO `food_oils` VALUES (1,'\nBerulub Fluid W+B','Bechem','	Смазочное масло для пищевой промышленности','Прозрачное, смазочное масло, не имеющее в своем составе смолу и кислоту. Растворяет грязь и ржавчину.Пригоден для централизованных систем смазки','от –40 °C до +160 °C',NULL),(2,'Plantfluid','Bechem','Применяется для смазки ленточных транспортёров и цепей в печах непрерывного действия для хлеба и хлебобулочных изделий.','Природный прозрачный термостойкий смазочный материал для крупных пекарен.','от 0 °C до +290 °C',''),(4,'Berusynth 15 H1 - 1000 H1','Bechem','гидравлика, редуктор, циркуляционная система, вентилятор, компрессор, пневмоблок, транспортные и приводные цепи, централизованное смазывание','Универсальное масло. Выступает в роли гидравлического (для вязкостей 15-150 HLP), компрессорного (для вязкостей 32-150 VDL), редукторного (для вязкостей 15-1000 CLP).','15	-60+120°C<br>\n32-68	-50+140°C<br>\n100-220	-45+160°C<br>\n320,460	-35+160°C<br>\n680,1000	-25+180°C','');
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
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
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
  `brand` enum('Bechem','Shell','Mobil','Castrol','Agip','Fuchs','Лукойл','Роснефть','Газпромнефть','Total') COLLATE utf8_unicode_ci NOT NULL,
  `application` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metalworking_specliqs`
--

LOCK TABLES `metalworking_specliqs` WRITE;
/*!40000 ALTER TABLE `metalworking_specliqs` DISABLE KEYS */;
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

-- Dump completed on 2019-12-07  0:43:28
