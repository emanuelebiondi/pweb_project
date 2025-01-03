-- Progettazione Web 
DROP DATABASE if exists biondi_616596; 
CREATE DATABASE biondi_616596; 
USE biondi_616596; 
-- MySQL dump 10.13  Distrib 5.7.28, for Win64 (x86_64)
--
-- Host: localhost    Database: biondi_616596
-- ------------------------------------------------------
-- Server version	5.7.28

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `house_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (51,'Bollette',67),(52,'Tasse',67),(53,'Detersivi',67),(54,'Cucina',67),(55,'Bagno',67),(56,'Manutenzione',67),(57,'Altro',67),(59,'Spesa',71),(61,'Detersivi',71),(62,'Altro',71),(70,'Altro',68);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `category` char(100) NOT NULL,
  `amount` float NOT NULL,
  `descr` char(100) NOT NULL,
  `date` date NOT NULL,
  `forusers` json DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=113 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (81,28,67,'Detersivi',1.7,'Sapone mani','2024-09-01','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:39:57'),(82,28,67,'Detersivi',3.55,'Sapone piatti','2024-09-04','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:40:20'),(83,28,67,'Bagno',8.5,'Carta igienica','2024-09-20','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:40:49'),(84,28,67,'Bagno',1.6,'Gabbiette WC','2024-09-20','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:41:22'),(85,27,67,'Bollette',87.55,'Bolletta Acqua','2024-10-16','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:42:21'),(86,31,67,'Tasse',355.76,'I rata Tari','2024-10-23','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:42:56'),(87,31,67,'Bollette',28,'Bolletta Internet','2024-09-30','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:43:32'),(88,31,67,'Bollette',28,'Bolletta Internet','2024-10-30','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:44:13'),(89,27,67,'Bollette',147.33,'Bolletta Gas','2024-10-31','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:44:59'),(90,27,67,'Bollette',367.56,'Bolletta Luce','2024-11-04','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:45:28'),(91,27,67,'Cucina',1.89,'Spugnette','2024-11-01','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:46:06'),(92,28,67,'Bagno',2.55,'Candeggina','2024-11-12','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:46:34'),(93,31,67,'Cucina',4.55,'Profumatore','2024-11-13','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:47:04'),(94,28,67,'Detersivi',3,'Sapone pavimento','2024-11-15','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:47:51'),(95,31,67,'Detersivi',4.8,'Anti-calcare','2024-11-23','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:48:26'),(96,31,67,'Cucina',3.65,'Carta Stagnola','2024-11-26','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:49:11'),(97,27,67,'Cucina',2.75,'Detersivo piatti','2024-12-01','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:00:00'),(98,28,67,'Bagno',5.25,'Shampoo','2024-12-02','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:01:00'),(99,31,67,'Bollette',120.45,'Bolletta Gas','2024-12-05','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:02:00'),(100,28,67,'Tasse',200.3,'II rata Tari','2024-12-10','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:03:00'),(101,27,67,'Detersivi',2.4,'Detersivo pavimenti','2024-12-12','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:04:00'),(102,31,67,'Cucina',1.99,'Spugne per piatti','2024-12-15','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:05:00'),(103,27,67,'Bollette',75.5,'Bolletta Acqua','2024-12-17','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:06:00'),(104,28,67,'Detersivi',6.1,'Detersivo WC','2024-12-20','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:07:00'),(105,31,67,'Bagno',3.45,'Sapone','2024-12-22','{\"users\": [\"27\", \"28\", \"31\"]}','2024-12-28 17:08:00'),(106,28,67,'Cucina',8.99,'Frullatore','2024-12-25','{\"users\": [\"27\", \"28\"]}','2024-12-28 17:09:00'),(108,34,71,'Detersivi',18.99,'Detersivi casa','2025-01-01','{\"users\": [\"33\", \"34\"]}','2025-01-02 17:42:43'),(109,33,71,'Altro',190.44,'Bolletta Gas','2025-01-03','{\"users\": [\"33\", \"34\"]}','2025-01-02 17:43:04'),(110,28,67,'Manutenzione',60,'Revisione Caldaia','2025-01-03','{\"users\": [\"27\", \"28\", \"31\"]}','2025-01-03 11:05:51'),(111,35,68,'Altro',120,'Test','2025-01-03','{\"users\": [\"29\", \"30\", \"35\"]}','2025-01-03 14:37:38'),(112,31,67,'Altro',7.5,'Zerbino','2025-01-04','{\"users\": [\"27\", \"28\"]}','2025-01-03 14:53:16');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `houses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `join_code` char(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `houses`
--

LOCK TABLES `houses` WRITE;
/*!40000 ALTER TABLE `houses` DISABLE KEYS */;
INSERT INTO `houses` VALUES (67,'House of Gabriela','ac1611'),(68,'Via Roma 19','d21464'),(71,'I ragazzi di Via Po','4598d8');
/*!40000 ALTER TABLE `houses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL,
  `id_user_from` int(11) NOT NULL,
  `id_user_to` int(11) NOT NULL,
  `date` date NOT NULL,
  `amount` float NOT NULL,
  `payment_method` char(100) NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (5,67,28,31,'2024-10-16',45,'Cash','2024-12-28 17:50:09'),(6,67,28,31,'2024-10-02',55,'PayPal','2024-12-28 17:50:33'),(7,67,28,27,'2024-12-28',229.1,'Cash','2024-12-28 17:52:55'),(8,67,31,27,'2024-12-28',33.55,'Prepaid Card','2024-12-28 17:53:01'),(9,67,31,28,'2024-10-16',130,'PayPal','2024-12-28 18:02:26'),(10,67,28,31,'2024-12-28',130,'Satispay','2024-12-28 18:02:40'),(12,71,34,33,'2024-12-03',130,'PayPal','2025-01-02 17:43:32');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reminders`
--

DROP TABLE IF EXISTS `reminders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reminders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(240) DEFAULT NULL,
  `house_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reminders`
--

LOCK TABLES `reminders` WRITE;
/*!40000 ALTER TABLE `reminders` DISABLE KEYS */;
INSERT INTO `reminders` VALUES (113,'Prima di partire ricordiamoci di spegnere i termosifoni',67),(114,'Lunedi - Indifferenziata\nMartedi - Umido\nGiovedi - Plastica\nVenerdi - Carta',67),(115,'il 12/01/2025 viene il tecnico della caldaia alle ore 12:30.',67),(116,'Comprare la carta igienica che sta finendo',67),(122,'Write something cool!',71);
/*!40000 ALTER TABLE `reminders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` char(100) NOT NULL,
  `password` char(255) NOT NULL,
  `name` char(100) NOT NULL,
  `surname` char(100) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `joinedAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (27,'gianluca.berni@gmail.com','$2y$10$GEFDGePzX0UG.Ox8SSGEB.ANFy53y/T63qBCOspK0kGewTBomZ79G','Gianluca','Berni',67,'2024-12-28 18:03:44'),(28,'luca.rovazzi@gmail.com','$2y$10$bd6nVeaitkcK2HI7KZNOGenkSpxwu0.TMmxzXxkznanZlTqOdRpQW','Luca','Rovazzi',67,'2024-12-28 18:50:54'),(29,'franco.de.lucia@gmail.com','$2y$10$dXsI3VbONJ0GpHuwpTHqKeDzMysCdIZpLbdDCyxlPJ/SguDwmjUYu','Franco','De lucia',68,'2024-12-28 19:01:26'),(30,'giuseppino190@gmail.com','$2y$10$/CHpvAQpZjaCptqYRo40Ge4N68EIf2cyCTPuyKhlQI8LB6u5T3dfO','Giuseppe','Francini',68,'2024-12-28 19:05:53'),(31,'emanuelebiondi@cohabitat.it','$2y$10$/EefabIplGrOxDnkZxeKmejCJViSn0zr9NDsaeHlcbcDiOI5VTgT6','Emanuele','Biondi',67,'2024-12-28 19:06:49'),(32,'filippo.rossi@gmail.com','$2y$10$iwUPVOqPtrxQZvnBUN3sHOv1V9SPO085eWozYBxWjn1wFdKMSW3eO','Filippo','Rossi',0,'2025-01-03 16:39:03'),(33,'francesco_beltrani@gmail.com','$2y$10$gO8sjPT9HTmNxNOCbu9CZejEgwUYHt7xaBVUWOK1WDIhQrNDJf2LS','Francesco','Beltrani',71,'2025-01-02 19:16:40'),(34,'carola.bellini@icloud.it','$2y$10$ePb.HS91C2vzw9rTYsIiWOIcJFmH/zT5K/wd.7QkkP2pC64ADeAEu','Carola','Bellini',71,'2025-01-02 19:40:54'),(35,'marco.ruta@gmail.com','$2y$10$08uPx.Z8eAF1Q9T7O3km8O6OYP8EC7fG/2TdwxRlfshMXBvT6zCHe','Marco','Ruta',68,'2025-01-03 13:23:15');
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

-- Dump completed on 2025-01-03 15:56:18
