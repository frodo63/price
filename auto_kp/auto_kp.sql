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
-- Table structure for table `hydraulics`
--

DROP TABLE IF EXISTS `hydraulics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hydraulics` (
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
-- Dumping data for table `hydraulics`
--

LOCK TABLES `hydraulics` WRITE;
/*!40000 ALTER TABLE `hydraulics` DISABLE KEYS */;
INSERT INTO `hydraulics` VALUES (1,'Staroil NR 10 (G 10)','Bechem','BECHEM STAROIL NR применяется в гидравлических установках в качестве жидкости, передающей энергию. При их эксплуатации приходится обращать особое внимание на антикоррозионную защиту, для насосов и гидромоторов этих установок, из-за их конструктивного исполнения или условий эксплуатации, требуются масла с добавками для уменьшения износа при смешанном трении.','Защита от коррозии \nЗначительные перепады температуры \nЛегко отделяет воду ',10,'20л - 5000р<br>208л - 50000р'),(2,'Azolla ZS 10','Total','Основной узел применения продукта: Гидравлические системы, работающие в наиболее сложных эксплуатационных условиях: металлорежущие станки, формовочные машины для литья под давлением (методом впрыска) или методом инжекционного прессования, прессовальное и другое промышленное стационарное или мобильное оборудование.','Защита от износа \nЗащита от коррозии \nОкислительная стабильность \nЗначительные перепады температуры \nЛегко отделяет воду \nДлительный срок службы ',10,'20л - 5000р<br>208л - 50000р'),(3,'Tellus S3 V 32','Shell','Обеспечивает превосходную защиту и стабильную работу гидравлических систем мобильной и прочей техники, эксплуатируемой в широком диапазоне температур окружающей среды или рабочих температур в гидравлической системе.','Shell Tellus S3 V – высокоэффективная гидравлическая жидкость, созданная с использованием эксклюзивного беззольного пакета противоизносных и вязкостных присадок, устойчивых к сдвиговым нагрузкам. Стабильная вязкость и защита при тяжелых механических нагрузках, термическом и химическом воздействии во всем диапазоне рабочих температур. ',32,'20л - 5000р<br>208л - 50000р');
/*!40000 ALTER TABLE `hydraulics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `soges`
--

DROP TABLE IF EXISTS `soges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `soges` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `brand` enum('Bechem','Fuchs','Mol','Mobil') COLLATE utf8_unicode_ci NOT NULL,
  `operations` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `metal_types` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `concentration` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `package_price` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `soges`
--

LOCK TABLES `soges` WRITE;
/*!40000 ALTER TABLE `soges` DISABLE KEYS */;
INSERT INTO `soges` VALUES (1,'Avantin 361 I-N','Bechem','Резание, Шлифование','Хорошая совместимость с кожей и отличные качества для обработки резанием, прежде всего при процессах обработки, при которых требуется повышенная смазывающая способность для инструмента. Подходит для любого качества воды, не пенится','Алюминий, Цветные металлы, Сталь','Резание алюминия: 7 - 10%, Резание стали: 5 - 7%','Канистра 20л - 11000 руб. с НДС\n\nБочка 200л - 102000 руб. с НДС'),(2,'Avantin 320 S','Bechem','Резание, Шлифование','Очень хорошая защита от коррозии и превосходные моющие свойства. Данный продукт беcпроблемно применяется в воде, имеющей жесткость от 3°dH. Он обладает высокой стабильностью эмульсии и, исходя из этого, длительными сроками службы эмульсии.','Сталь низколегированная, Чугун','Общее резание: 3-6%, Сложное резание: 5-10%','Канистра 20л - 8100 руб. с НДС\n\nБочка 200л - 78300 руб. с НДС'),(3,'Avantin 402','Bechem','Резание, Шлифование','Не содержащий минерального масла водосмешиваемый концентрат СОЖ с хорошими антикоррозионными свойствами. Благодаря специальному аддитивированию BECHEM Avantin 402 успешно применяется при обработке резанием стальных и чугунных материалов и при нарезке резьбы. Cтороннее масло не эмульгируется, поэтому не возникает задымления.','Сталь, Чугун','Общее резание: 6-10%, Шлифование: 4-5%','Канистра 20л - 10000 руб. с НДС\n\nБочка 200л - 99100 руб. с НДС');
/*!40000 ALTER TABLE `soges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tails`
--

DROP TABLE IF EXISTS `tails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tails` (
  `id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,
  `name` enum('Марина','Сергей','Тимур','Дима') COLLATE utf8_unicode_ci NOT NULL,
  `html` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tails`
--

LOCK TABLES `tails` WRITE;
/*!40000 ALTER TABLE `tails` DISABLE KEYS */;
INSERT INTO `tails` VALUES (1,'Марина','-- \r\nС уважением,\r\nБаева Марина Юрьевна\r\nДиректор ООО \"Лубритэк\"\r\nhttps://лубритэк.рф/\r\n\r\n(846) 931-42-60, факс 931-03-57,\r\nмоб. +7-927-653-23-56, +7-996-736-37-87'),(2,'Дима','-- \r\nС уважением,\r\nБаев Дмитрий Вадимович\r\nЮрисконсульт ООО \"Лубритэк\"\r\n\r\nhttps://лубритэк.рф/\r\n(846) 931-42-60, факс931-03-57, моб. 8-927-687-24-51'),(3,'Тимур','-- \r\nС уважением,\r\nНабиев Тимур Александрович\r\nВедущий специалист Отдела Развития\r\nООО \"Лубритэк\"\r\n\r\nhttps://лубритэк.рф/\r\n(846) 931-42-60, факс 931-03-57, моб. 8-927-694-63-14'),(4,'Сергей','-- \r\nС Уважением,\r\n\r\nУлитов Сергей Викторович\r\n\r\nТехнический директор ООО \"Лубритэк\"\r\n\r\nhttps://лубритэк.рф/\r\n(846) 931-42-60, факс 931-03-57, моб. 8-927-749-43-68');
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

-- Dump completed on 2019-12-04 21:51:28
