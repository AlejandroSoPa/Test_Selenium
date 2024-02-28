-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: localhost    Database: project_vota
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
-- Table structure for table `Answers`
--

DROP TABLE IF EXISTS `Answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Answers` (
  `ID` int NOT NULL,
  `Text` varchar(255) DEFAULT NULL,
  `PollID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Answers_Poll` (`PollID`),
  CONSTRAINT `Answers_Poll` FOREIGN KEY (`PollID`) REFERENCES `Polls` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Answers`
--

LOCK TABLES `Answers` WRITE;
/*!40000 ALTER TABLE `Answers` DISABLE KEYS */;
/*!40000 ALTER TABLE `Answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Countries`
--

DROP TABLE IF EXISTS `Countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Countries` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `CountryName` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Countries`
--

LOCK TABLES `Countries` WRITE;
/*!40000 ALTER TABLE `Countries` DISABLE KEYS */;
INSERT INTO `Countries` VALUES (1,'Australia'),(2,'Austria'),(3,'Azerbaiyán'),(4,'Anguilla'),(5,'Argentina'),(6,'Armenia'),(7,'Bielorrusia'),(8,'Belice'),(9,'Bélgica'),(10,'Bermudas'),(11,'Bulgaria'),(12,'Brasil'),(13,'Reino Unido'),(14,'Hungría'),(15,'Vietnam'),(16,'Haiti'),(17,'Guadalupe'),(18,'Alemania'),(19,'Países Bajos, Holanda'),(20,'Grecia'),(21,'Georgia'),(22,'Dinamarca'),(23,'Egipto'),(24,'Israel'),(25,'India'),(26,'Irán'),(27,'Irlanda'),(28,'España'),(29,'Italia'),(30,'Kazajstán'),(31,'Camerún'),(32,'Canadá'),(33,'Chipre'),(34,'Kirguistán'),(35,'China'),(36,'Costa Rica'),(37,'Kuwait'),(38,'Letonia'),(39,'Libia'),(40,'Lituania'),(41,'Luxemburgo'),(42,'México'),(43,'Moldavia'),(44,'Mónaco'),(45,'Nueva Zelanda'),(46,'Noruega'),(47,'Polonia'),(48,'Portugal'),(49,'Reunión'),(50,'Rusia'),(51,'El Salvador'),(52,'Eslovaquia'),(53,'Eslovenia'),(54,'Surinam'),(55,'Estados Unidos'),(56,'Tadjikistan'),(57,'Turkmenistan'),(58,'Islas Turcas y Caicos'),(59,'Turquía'),(60,'Uganda'),(61,'Uzbekistán'),(62,'Ucrania'),(63,'Finlandia'),(64,'Francia'),(65,'República Checa'),(66,'Suiza'),(67,'Suecia'),(68,'Estonia'),(69,'Corea del Sur'),(70,'Japón'),(71,'Croacia'),(72,'Rumanía'),(73,'Hong Kong'),(74,'Indonesia'),(75,'Jordania'),(76,'Malasia'),(77,'Singapur'),(78,'Taiwan'),(79,'Bosnia y Herzegovina'),(80,'Bahamas'),(81,'Chile'),(82,'Colombia'),(83,'Islandia'),(84,'Corea del Norte'),(85,'Macedonia'),(86,'Malta'),(87,'Pakistán'),(88,'Papúa-Nueva Guinea'),(89,'Perú'),(90,'Filipinas'),(91,'Arabia Saudita'),(92,'Tailandia'),(93,'Emiratos árabes Unidos'),(94,'Groenlandia'),(95,'Venezuela'),(96,'Zimbabwe'),(97,'Kenia'),(98,'Algeria'),(99,'Líbano'),(100,'Botsuana'),(101,'Tanzania'),(102,'Namibia'),(103,'Ecuador'),(104,'Marruecos'),(105,'Ghana'),(106,'Siria'),(107,'Nepal'),(108,'Mauritania'),(109,'Seychelles'),(110,'Paraguay'),(111,'Uruguay'),(112,'Congo (Brazzaville)'),(113,'Cuba'),(114,'Albania'),(115,'Nigeria'),(116,'Zambia'),(117,'Mozambique'),(119,'Angola'),(120,'Sri Lanka'),(121,'Etiopía'),(122,'Túnez'),(123,'Bolivia'),(124,'Panamá'),(125,'Malawi'),(126,'Liechtenstein'),(127,'Bahrein'),(128,'Barbados'),(130,'Chad'),(131,'Man, Isla de'),(132,'Jamaica'),(133,'Malí'),(134,'Madagascar'),(135,'Senegal'),(136,'Togo'),(137,'Honduras'),(138,'República Dominicana'),(139,'Mongolia'),(140,'Irak'),(141,'Sudáfrica'),(142,'Aruba'),(143,'Gibraltar'),(144,'Afganistán'),(145,'Andorra'),(147,'Antigua y Barbuda'),(149,'Bangladesh'),(151,'Benín'),(152,'Bután'),(154,'Islas Virgenes Británicas'),(155,'Brunéi'),(156,'Burkina Faso'),(157,'Burundi'),(158,'Camboya'),(159,'Cabo Verde'),(164,'Comores'),(165,'Congo (Kinshasa)'),(166,'Cook, Islas'),(168,'Costa de Marfil'),(169,'Djibouti, Yibuti'),(171,'Timor Oriental'),(172,'Guinea Ecuatorial'),(173,'Eritrea'),(175,'Feroe, Islas'),(176,'Fiyi'),(178,'Polinesia Francesa'),(180,'Gabón'),(181,'Gambia'),(184,'Granada'),(185,'Guatemala'),(186,'Guernsey'),(187,'Guinea'),(188,'Guinea-Bissau'),(189,'Guyana'),(193,'Jersey'),(195,'Kiribati'),(196,'Laos'),(197,'Lesotho'),(198,'Liberia'),(200,'Maldivas'),(201,'Martinica'),(202,'Mauricio'),(205,'Myanmar'),(206,'Nauru'),(207,'Antillas Holandesas'),(208,'Nueva Caledonia'),(209,'Nicaragua'),(210,'Níger'),(212,'Norfolk Island'),(213,'Omán'),(215,'Isla Pitcairn'),(216,'Qatar'),(217,'Ruanda'),(218,'Santa Elena'),(219,'San Cristobal y Nevis'),(220,'Santa Lucía'),(221,'San Pedro y Miquelón'),(222,'San Vincente y Granadinas'),(223,'Samoa'),(224,'San Marino'),(225,'San Tomé y Príncipe'),(226,'Serbia y Montenegro'),(227,'Sierra Leona'),(228,'Islas Salomón'),(229,'Somalia'),(232,'Sudán'),(234,'Swazilandia'),(235,'Tokelau'),(236,'Tonga'),(237,'Trinidad y Tobago'),(239,'Tuvalu'),(240,'Vanuatu'),(241,'Wallis y Futuna'),(242,'Sáhara Occidental'),(243,'Yemen'),(246,'Puerto Rico');
/*!40000 ALTER TABLE `Countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Poll_Admins`
--

DROP TABLE IF EXISTS `Poll_Admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Poll_Admins` (
  `UserID` int DEFAULT NULL,
  `PollID` int DEFAULT NULL,
  UNIQUE KEY `Poll_Admins_unique` (`UserID`,`PollID`),
  KEY `Poll_Admins_Poll` (`PollID`),
  CONSTRAINT `Poll_Admins_Admin` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`),
  CONSTRAINT `Poll_Admins_Poll` FOREIGN KEY (`PollID`) REFERENCES `Polls` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Poll_Admins`
--

LOCK TABLES `Poll_Admins` WRITE;
/*!40000 ALTER TABLE `Poll_Admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `Poll_Admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Poll_InvitedUsers`
--

DROP TABLE IF EXISTS `Poll_InvitedUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Poll_InvitedUsers` (
  `UserID` int DEFAULT NULL,
  `PollID` int DEFAULT NULL,
  UNIQUE KEY `Poll_InvitedUsers_unique` (`UserID`,`PollID`),
  KEY `Poll_InvitedUsers_Poll` (`PollID`),
  CONSTRAINT `Poll_InvitedUsers_Poll` FOREIGN KEY (`PollID`) REFERENCES `Polls` (`ID`),
  CONSTRAINT `Poll_InvitedUsers_User` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Poll_InvitedUsers`
--

LOCK TABLES `Poll_InvitedUsers` WRITE;
/*!40000 ALTER TABLE `Poll_InvitedUsers` DISABLE KEYS */;
/*!40000 ALTER TABLE `Poll_InvitedUsers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Polls`
--

DROP TABLE IF EXISTS `Polls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Polls` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Question` varchar(255) DEFAULT NULL,
  `CreationDate` datetime DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `State` enum('active','blocked','not_begun','finished') DEFAULT NULL,
  `QuestionVisibility` enum('public','private','hidden') DEFAULT NULL,
  `ResultsVisibility` enum('public','private','hidden') DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  `Link` varchar(255) DEFAULT NULL,
  `CreatorID` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `FK_PollCreator` (`CreatorID`),
  CONSTRAINT `FK_PollCreator` FOREIGN KEY (`CreatorID`) REFERENCES `Users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Polls`
--

LOCK TABLES `Polls` WRITE;
/*!40000 ALTER TABLE `Polls` DISABLE KEYS */;
/*!40000 ALTER TABLE `Polls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User_Vote`
--

DROP TABLE IF EXISTS `User_Vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `User_Vote` (
  `UserID` int DEFAULT NULL,
  `AnswerID` int DEFAULT NULL,
  UNIQUE KEY `User_Vote_unique` (`UserID`,`AnswerID`),
  KEY `User_Vote_Answer` (`AnswerID`),
  CONSTRAINT `User_Vote_Answer` FOREIGN KEY (`AnswerID`) REFERENCES `Answers` (`ID`),
  CONSTRAINT `User_Vote_User` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Vote`
--

LOCK TABLES `User_Vote` WRITE;
/*!40000 ALTER TABLE `User_Vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `User_Vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `City` varchar(255) DEFAULT NULL,
  `PostalCode` int DEFAULT NULL,
  `IsAuthenticated` tinyint(1) DEFAULT NULL,
  `ValidationToken` int DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'eri','Aa12345678!','123456789','test@mail.com','España','Cataluña',8940,NULL,NULL),(2,'eri','32643a91f369dc930c2cacd22b365fd5f93695ae24489b3fe6729121046e0a312d76ae48f76bda66570534730738b012dd14c473e174ed253519332fe53bf953','123456789','test@mail.com','España','Cataluña',8940,NULL,NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-01-22 17:03:42
