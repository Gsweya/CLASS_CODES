-- MySQL dump 10.13  Distrib 8.4.9, for Linux (x86_64)
--
-- Host: localhost    Database: db_Bsc_CS_group01
-- ------------------------------------------------------
-- Server version	8.4.9

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `company_Bsc_CS_group01`
--

DROP TABLE IF EXISTS `company_Bsc_CS_group01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_Bsc_CS_group01` (
  `company_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_Bsc_CS_group01`
--

LOCK TABLES `company_Bsc_CS_group01` WRITE;
/*!40000 ALTER TABLE `company_Bsc_CS_group01` DISABLE KEYS */;
INSERT INTO `company_Bsc_CS_group01` VALUES (1,'Gizmo-Works','Dar es Salaam'),(2,'TechOne','Arusha'),(3,'SoftLab','Dodoma'),(4,'BitPlus','Mwanza'),(5,'MakTech','Morogoro');
/*!40000 ALTER TABLE `company_Bsc_CS_group01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log_Bsc_CS_group01`
--

DROP TABLE IF EXISTS `log_Bsc_CS_group01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `log_Bsc_CS_group01` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` varchar(100) DEFAULT NULL,
  `timestamp` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log_Bsc_CS_group01`
--

LOCK TABLES `log_Bsc_CS_group01` WRITE;
/*!40000 ALTER TABLE `log_Bsc_CS_group01` DISABLE KEYS */;
INSERT INTO `log_Bsc_CS_group01` VALUES (1,'group01_database_created','2026-05-31 17:03:01'),(2,'group01_data_inserted','2026-05-31 17:03:01'),(3,'group01_queries_executed','2026-05-31 17:03:01');
/*!40000 ALTER TABLE `log_Bsc_CS_group01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_Bsc_CS_group01`
--

DROP TABLE IF EXISTS `person_Bsc_CS_group01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `person_Bsc_CS_group01` (
  `person_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_Bsc_CS_group01`
--

LOCK TABLES `person_Bsc_CS_group01` WRITE;
/*!40000 ALTER TABLE `person_Bsc_CS_group01` DISABLE KEYS */;
INSERT INTO `person_Bsc_CS_group01` VALUES (1,'SALIM AMIRI SALIM','Dodoma','0764123456'),(2,'BHOKE MARWA MTATIRO','Arusha','0764234567'),(3,'MUKSINI ISMAIL BUSHIRI','Mwanza','0764345678'),(4,'RAYMOND JESTONE MAKUKA','Mbeya','0764456789'),(5,'INNOCENT CHARLES MKOI','Morogoro','0764567890'),(6,'BRIAN SOCRAFI MUNISI','Dodoma','0764678901'),(7,'JOHN MLYATU MSHANGI','Arusha','0764789012'),(8,'GALANDA JOHN SWEYA','Mwanza','0764890123'),(9,'MECKTILDA MANGASINI KATUNDU','Mbeya','0764901234'),(10,'JOHN YOHANA CHIBAGO','Morogoro','0764012345');
/*!40000 ALTER TABLE `person_Bsc_CS_group01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_Bsc_CS_group01`
--

DROP TABLE IF EXISTS `product_Bsc_CS_group01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_Bsc_CS_group01` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `company_id` int DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `product_Bsc_CS_group01_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `company_Bsc_CS_group01` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_Bsc_CS_group01`
--

LOCK TABLES `product_Bsc_CS_group01` WRITE;
/*!40000 ALTER TABLE `product_Bsc_CS_group01` DISABLE KEYS */;
INSERT INTO `product_Bsc_CS_group01` VALUES (1,'SmartGadget','Gadgets',55000.00,1),(2,'PowerBox','Gadgets',30000.00,1),(3,'CleanVac','Household',65000.00,2),(4,'PhotoSnap','Photography',72000.00,3),(5,'EcoFan','Household',48000.00,4);
/*!40000 ALTER TABLE `product_Bsc_CS_group01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_Bsc_CS_group01`
--

DROP TABLE IF EXISTS `purchase_Bsc_CS_group01`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `purchase_Bsc_CS_group01` (
  `purchase_id` int NOT NULL AUTO_INCREMENT,
  `person_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `store` varchar(100) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  PRIMARY KEY (`purchase_id`),
  KEY `person_id` (`person_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `purchase_Bsc_CS_group01_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `person_Bsc_CS_group01` (`person_id`),
  CONSTRAINT `purchase_Bsc_CS_group01_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_Bsc_CS_group01` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_Bsc_CS_group01`
--

LOCK TABLES `purchase_Bsc_CS_group01` WRITE;
/*!40000 ALTER TABLE `purchase_Bsc_CS_group01` DISABLE KEYS */;
INSERT INTO `purchase_Bsc_CS_group01` VALUES (1,1,5,'Ilazo Market',2,'2025-05-15'),(2,2,4,'Ilazo Market',1,'2025-05-01'),(3,3,1,'CityCenter',3,'2025-05-20'),(4,4,3,'TechStreet',2,'2025-05-01'),(5,5,4,'WestZone',3,'2025-05-19');
/*!40000 ALTER TABLE `purchase_Bsc_CS_group01` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `view_purchases_Bsc_CS_group01`
--

DROP TABLE IF EXISTS `view_purchases_Bsc_CS_group01`;
/*!50001 DROP VIEW IF EXISTS `view_purchases_Bsc_CS_group01`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_purchases_Bsc_CS_group01` AS SELECT 
 1 AS `buyer_name`,
 1 AS `product_name`,
 1 AS `store`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_purchases_Bsc_CS_group01`
--

/*!50001 DROP VIEW IF EXISTS `view_purchases_Bsc_CS_group01`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_purchases_Bsc_CS_group01` AS select `p`.`name` AS `buyer_name`,`pr`.`name` AS `product_name`,`pu`.`store` AS `store` from ((`purchase_Bsc_CS_group01` `pu` join `person_Bsc_CS_group01` `p` on((`pu`.`person_id` = `p`.`person_id`))) join `product_Bsc_CS_group01` `pr` on((`pu`.`product_id` = `pr`.`product_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-31 17:11:09
