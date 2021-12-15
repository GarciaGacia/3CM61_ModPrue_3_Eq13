-- MySQL dump 10.19  Distrib 10.3.29-MariaDB, para debian-linux-gnu (x86_64)
-- Host: localhost    Database: eb_v1_0_2
-- ------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Base de datos actual: `eb_v1_0_2`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `eb_v1_0_2` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `eb_v1_0_2`;

--
-- Estructura de la tabla para las categorías de la tabla
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--datos para la tabla `categorías`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (5,'Mujeres'),(1,'Hombres'),(2,'Faldas'),(3,'Unisex');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Estructura de la tabla para la tabla "ingresos"
--

DROP TABLE IF EXISTS `incomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incomes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `price` decimal(25,2) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--datos para la tabla "ingresos" 
--

LOCK TABLES `incomes` WRITE;
/*!40000 ALTER TABLE `incomes` DISABLE KEYS */;
/*!40000 ALTER TABLE `incomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Estructura de la tabla para la tabla `media
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--datos para la tabla `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'ropa1.jpg','image/jpeg'),(3,'ropa2.png','image/png'),(4,'ropa4.jpg','image/jpeg'),(5,'ropa5.jpg','image/jpeg'),(6,'ropa6.jpeg','image/jpeg'),(7,'ropa7.jpeg','image/jpeg'),(8,'ropa8.jpeg','image/jpeg'),(9,'ropa9.jpeg','image/jpeg'),(10,'ropa10.jpeg','image/jpeg'),(11,'ropa11.jpeg','image/jpeg'),(12,'ropa12.jpeg','image/jpeg'),(13,'ropa13.jpeg','image/jpeg'),(14,'ropa14.jpeg','image/jpeg'),(15,'ropa15.jpeg','image/jpeg'),(16,'ropa16.jpeg','image/jpeg'),(17,'ropa17.jpeg','image/jpeg'),(18,'ropa18.jpeg','image/jpeg'),(19,'ropa19.jpeg','image/jpeg');
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Estructura de la mesa para la mesa `productos`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `partNo` varchar(60) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `buy_price` decimal(25,2) DEFAULT 0.00,
  `sale_price` decimal(25,2) DEFAULT 0.00,
  `categorie_id` int(10) unsigned NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `media_id` int(10) unsigned DEFAULT 0,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `partNo` (`partNo`),
  KEY `categorie_id` (`categorie_id`),
  KEY `media_id` (`media_id`),
  CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_products2` FOREIGN KEY (`media_id`) REFERENCES `media` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--datos para la tabla `productos`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Blusa verde','BLU_VER',94,150.00,250.00,1,'X1',5,'2017-06-16 07:03:16'),(2,'chamarra de cuero ','cham_c',23,200.00,340.00,5,'A1',3,'2019-03-01 07:03:16'),(3,'Playera Apletada','PLA_APL',25,200.00,400.00,1,'A2',4,'2019-03-01 07:03:16'),(4,'pantalon caqui','PAN_Ca',94,200.00,300.00,3,'X2',5,'2019-03-01 07:03:16'),(5,'Pantalon Blanco','PAN_BLA',83,250.00,510.00,5,'A1',6,'2019-03-02 07:05:23'),(6,'Falda Azul','Fal_Azul',90,250.00,450.00,5,'A2',7,'2019-03-02 07:05:34'),(7,'Pantalon Negro','PAN_NEG',89,250.00,450.00,3,'X2',8,'2019-03-02 07:06:02'),(8,'Falda Negra/Blanca','FAL_N/B',85,250.00,450.00,2,'X4',9,'2019-03-02 07:06:10'),(9,'Pantalon_Azul','PAN_AZU',86,250.00,450.00,3,'X4',10,'2019-03-02 07:06:15'),(10,'Chamarra_cafe','CHA_CAF',101,250.00,450.00,5,'X4',11,'2019-03-02 07:06:21'),(11,'Vestido completo','VES_COM',80,300.00,520.00,5,'A1',12,'2020-06-05 17:04:14'),(14,'Vestido Arcoiris','VES_ARC',50,290.00,530.00,5,'A1',13,'2020-06-11 14:20:26'),(21,'Falda cafe mini','FAL_CAF_Min',102,100.00,130.00,2,'AA2',14,'2021-03-31 12:30:06');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

UNLOCK TABLES;

--
-- Estructura de la tabla para la tabla "ventas"
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `buy_price` decimal(25,2) DEFAULT 0.00,
  `sale_price` decimal(25,2) DEFAULT 0.00,
  `total_sale` decimal(25,2) DEFAULT 0.00,
  `profit` decimal(25,2) DEFAULT 0.00,
  `destination` varchar(255) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `SK` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Datos para la tabla `ventas
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,7,6,250.00,450.00,2700.00,1200.00,'Pedro','2021-11-10 00:00:00');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Estructura de la tabla para la tabla `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_level` (`group_level`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
--datos para la tabla `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES (1,'Admin',1,1),(2,'Special',2,1),(3,'User',3,1);
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Estructura de la tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(11) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `user_level` (`user_level`),
  CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',1,'h9onhi9g17.jpg',1,'2021-11-28 15:47:11'),(3,'Normal User','user','b14361404c078ffd549c03db443c3fede2f3e534d73f78f77301ed97d4a436a9fd9db05ee8b325c0ad36438b43fec8510c204fc1c1edb21d0941c00e9e2c1ce2',3,'h9onhi9g17.jpg',1,'2021-11-27 17:04:51'),(17,'Special User','special','98d5f28f0c604d7e34ea730e8dd61a644cf839bd1a56539bbaba0bba78c5529e3eb7002c3985ac7ad5ada28651fa88532b45717729c7cd9958e0e17415e1fcea',2,'h9onhi9g17.jpg',1,'2021-11-27 17:04:58');
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

