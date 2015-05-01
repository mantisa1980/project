-- MySQL dump 10.13  Distrib 5.5.37, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: car
-- ------------------------------------------------------
-- Server version	5.5.37-0ubuntu0.12.10.1

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
-- Table structure for table `buy_order`
--

DROP TABLE IF EXISTS `buy_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buy_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paid` int(10) unsigned NOT NULL,
  `created_on` datetime NOT NULL,
  `note` text,
  `customer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_buy_order__customer_id` (`customer_id`),
  CONSTRAINT `fk_buy_order__customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_order`
--

LOCK TABLES `buy_order` WRITE;
/*!40000 ALTER TABLE `buy_order` DISABLE KEYS */;
INSERT INTO `buy_order` VALUES (1,0,'2014-06-08 21:44:13','買入訂單備註',1);
/*!40000 ALTER TABLE `buy_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `buy_order_item`
--

DROP TABLE IF EXISTS `buy_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buy_order_item` (
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `unit_amount` int(10) unsigned NOT NULL,
  `final_per_unit_price` int(10) unsigned NOT NULL,
  KEY `fk_buy_order_item__order_id` (`order_id`),
  KEY `fk_buy_order_item__item_id` (`item_id`),
  KEY `fk_buy_order_item__unit_id` (`unit_id`),
  CONSTRAINT `fk_buy_order_item__item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_buy_order_item__order_id` FOREIGN KEY (`order_id`) REFERENCES `buy_order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_buy_order_item__unit_id` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `buy_order_item`
--

LOCK TABLES `buy_order_item` WRITE;
/*!40000 ALTER TABLE `buy_order_item` DISABLE KEYS */;
INSERT INTO `buy_order_item` VALUES (1,1,1,9,123),(1,2,2,4,456);
/*!40000 ALTER TABLE `buy_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `company` varchar(128) NOT NULL,
  `vat` varchar(16) NOT NULL,
  `address` varchar(256) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `cellphone` varchar(16) DEFAULT NULL,
  `cellphone2` varchar(16) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customer__group_id` (`group_id`),
  KEY `name` (`name`),
  CONSTRAINT `fk_customer__group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'許功蓋','TSMC','12345678','板橋市','0492902176','0911223344','0911223344','abc@123.com','2014-06-08 21:44:13',1),(2,'吳明峰','FOXCONN','234567891','新莊市','0229103333','0933334444','0933334444','xyz@456.com','2014-06-08 21:44:13',1),(3,'楊立群','HTC','345678912','Keelung','0229103333','0955556666','0955556666','zzz@456.com','2014-06-08 21:44:13',2);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `name_2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'草民'),(2,'貴賓');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` VALUES (2,'銀'),(1,'銅');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price`
--

DROP TABLE IF EXISTS `price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price` (
  `group_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `buy_price` int(10) unsigned NOT NULL DEFAULT '0',
  `sell_price` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`group_id`,`item_id`,`unit_id`),
  KEY `fk_group_price__item_id` (`item_id`),
  KEY `fk_group_price__unit_id` (`unit_id`),
  CONSTRAINT `fk_group_price__group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_group_price__item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_group_price__unit_id` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price`
--

LOCK TABLES `price` WRITE;
/*!40000 ALTER TABLE `price` DISABLE KEYS */;
INSERT INTO `price` VALUES (1,1,1,99,100),(1,1,2,199,200),(1,2,1,299,300),(1,2,2,599,600),(2,1,1,89,90),(2,1,2,179,180),(2,2,1,269,270),(2,2,2,539,540);
/*!40000 ALTER TABLE `price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_order`
--

DROP TABLE IF EXISTS `sell_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sell_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paid` int(10) unsigned NOT NULL,
  `created_on` datetime NOT NULL,
  `note` text,
  `customer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_sell_order__customer_id` (`customer_id`),
  CONSTRAINT `fk_sell_order__customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_order`
--

LOCK TABLES `sell_order` WRITE;
/*!40000 ALTER TABLE `sell_order` DISABLE KEYS */;
INSERT INTO `sell_order` VALUES (1,0,'2014-06-08 21:44:13','賣出訂單備註',1);
/*!40000 ALTER TABLE `sell_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell_order_item`
--

DROP TABLE IF EXISTS `sell_order_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sell_order_item` (
  `order_id` int(10) unsigned NOT NULL,
  `item_id` int(10) unsigned NOT NULL,
  `unit_id` int(10) unsigned NOT NULL,
  `unit_amount` int(10) unsigned NOT NULL,
  `final_per_unit_price` int(10) unsigned NOT NULL,
  KEY `fk_sell_order_item__order_id` (`order_id`),
  KEY `fk_sell_order_item__item_id` (`item_id`),
  KEY `fk_sell_order_item__unit_id` (`unit_id`),
  CONSTRAINT `fk_sell_order_item__item_id` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sell_order_item__order_id` FOREIGN KEY (`order_id`) REFERENCES `sell_order` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sell_order_item__unit_id` FOREIGN KEY (`unit_id`) REFERENCES `unit` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell_order_item`
--

LOCK TABLES `sell_order_item` WRITE;
/*!40000 ALTER TABLE `sell_order_item` DISABLE KEYS */;
INSERT INTO `sell_order_item` VALUES (1,1,1,10,444),(1,2,2,5,555);
/*!40000 ALTER TABLE `sell_order_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `name_2` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit`
--

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;
INSERT INTO `unit` VALUES (1,'噸'),(2,'車');
/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `account` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('justplay','justplay');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-06-12 17:35:12
