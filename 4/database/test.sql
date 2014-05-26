-- MySQL dump 10.13  Distrib 5.6.12, for Win64 (x86_64)
--
-- Host: localhost    Database: test
-- ------------------------------------------------------
-- Server version	5.6.12-log

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
-- Table structure for table `address_book`
--

DROP TABLE IF EXISTS `address_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `calle` varchar(60) DEFAULT NULL,
  `colonia` varchar(60) DEFAULT NULL,
  `ciudad` varchar(60) DEFAULT NULL,
  `codigo_postal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address_book`
--

LOCK TABLES `address_book` WRITE;
/*!40000 ALTER TABLE `address_book` DISABLE KEYS */;
INSERT INTO `address_book` VALUES (1,1,'Rotograbados ','20 de Noviembre','Monterrey',89293),(2,2,'','','',0);
/*!40000 ALTER TABLE `address_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cards_book`
--

DROP TABLE IF EXISTS `cards_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_book` (
  `stripe_card_id` varchar(60) NOT NULL DEFAULT '',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `date_created` date DEFAULT NULL,
  PRIMARY KEY (`stripe_card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards_book`
--

LOCK TABLES `cards_book` WRITE;
/*!40000 ALTER TABLE `cards_book` DISABLE KEYS */;
INSERT INTO `cards_book` VALUES ('',2,'2014-05-25'),('card_1046Mc4UfLC5IwHMTIpJjRlf',1,'2014-05-25');
/*!40000 ALTER TABLE `cards_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `padre_hijo`
--

DROP TABLE IF EXISTS `padre_hijo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `padre_hijo` (
  `padre` varchar(50) NOT NULL DEFAULT '',
  `hijo` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`padre`,`hijo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `padre_hijo`
--

LOCK TABLES `padre_hijo` WRITE;
/*!40000 ALTER TABLE `padre_hijo` DISABLE KEYS */;
INSERT INTO `padre_hijo` VALUES ('Josue','Carlos'),('Josue','Maria'),('Juan','Pedro'),('Pedro','Jesus'),('Raul','Josue');
/*!40000 ALTER TABLE `padre_hijo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `price` float(8,2) DEFAULT NULL,
  `description` text,
  `image` varchar(60) DEFAULT NULL,
  `stripe_plan_id` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Mix 1',135.78,'El auténtico mix 1 con 16 productos','images/Gift-Box.png','mix_1'),(2,'Mix 2',158.13,'Fabuloso mix 2 con 18 productos','images/Gift-Box.png','mix_2'),(3,'Mix 3',199.99,'El supremo y valioso mix 3, ahora con 24 productos','images/Gift-Box.png','mix_3');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stripe_subscription_id` varchar(60) NOT NULL DEFAULT '',
  `stripe_card_id` varchar(60) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  PRIMARY KEY (`id`,`stripe_subscription_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscriptions`
--

LOCK TABLES `subscriptions` WRITE;
/*!40000 ALTER TABLE `subscriptions` DISABLE KEYS */;
INSERT INTO `subscriptions` VALUES (1,'sub_46McyH6emhS68d','card_1046Mc4UfLC5IwHMTIpJjRlf',1,1,2,'2014-05-25');
/*!40000 ALTER TABLE `subscriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(60) DEFAULT NULL,
  `username` varchar(60) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `default_address_id` int(11) DEFAULT NULL,
  `stripe_customer_id` varchar(60) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'judoca_9117@hotmail.com','judoca','$2a$10$cbd99a404da48f5d2afe5uTpbNUYOytlBEHg8KiW1xOf3qwlmLsDm',NULL,'cus_46Mc7onMxbBJrv','2014-05-25'),(2,'','','$2a$10$06d7a5a431fe27f15a2c9uqYdlOuS5/CunXKnwnAvy6rphVinQ5N.',NULL,'cus_46Mm7xhlSh51zT','2014-05-25');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-05-25 18:41:03
