-- MySQL dump 10.13  Distrib 8.0.36, for Linux (x86_64)
--
-- Host: localhost    Database: project_vota
-- ------------------------------------------------------
-- Server version	8.0.36-0ubuntu0.22.04.1

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
  `ID` int NOT NULL AUTO_INCREMENT,
  `Text` varchar(255) DEFAULT NULL,
  `PollID` int DEFAULT NULL,
  `ImagePath` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `Answers_Poll` (`PollID`),
  CONSTRAINT `Answers_Poll` FOREIGN KEY (`PollID`) REFERENCES `Polls` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Answers`
--

LOCK TABLES `Answers` WRITE;
/*!40000 ALTER TABLE `Answers` DISABLE KEYS */;
INSERT INTO `Answers` VALUES (1,'1',1,NULL),(2,'2',1,NULL),(3,'1',2,NULL),(4,'2',2,NULL),(5,'1',3,NULL),(6,'2',3,NULL);
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
  `PhoneCode` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=247 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Countries`
--

LOCK TABLES `Countries` WRITE;
/*!40000 ALTER TABLE `Countries` DISABLE KEYS */;
INSERT INTO `Countries` VALUES (1,'Australia','+61'),(2,'Austria','+43'),(3,'Azerbaiyán','+994'),(4,'Anguilla','+1-264'),(5,'Argentina','+54'),(6,'Armenia','+374'),(7,'Bielorrusia','+375'),(8,'Belice','+501'),(9,'Bélgica','+32'),(10,'Bermudas','+1-441'),(11,'Bulgaria','+359'),(12,'Brasil','+55'),(13,'Reino Unido','+44'),(14,'Hungría','+36'),(15,'Vietnam','+84'),(16,'Haiti','+509'),(17,'Guadalupe','+590'),(18,'Alemania','+49'),(19,'Países Bajos, Holanda','+31'),(20,'Grecia','+30'),(21,'Georgia','+995'),(22,'Dinamarca','+45'),(23,'Egipto','+20'),(24,'Israel','+972'),(25,'India','+91'),(26,'Irán','+98'),(27,'Irlanda','+353'),(28,'España','+34'),(29,'Italia','+39'),(30,'Kazajstán','+7'),(31,'Camerún','+237'),(32,'Canadá','+1'),(33,'Chipre','+357'),(34,'Kirguistán','+996'),(35,'China','+86'),(36,'Costa Rica','+506'),(37,'Kuwait','+965'),(38,'Letonia','+371'),(39,'Libia','+218'),(40,'Lituania','+370'),(41,'Luxemburgo','+352'),(42,'México','+52'),(43,'Moldavia','+373'),(44,'Mónaco','+377'),(45,'Nueva Zelanda','+64'),(46,'Noruega','+47'),(47,'Polonia','+48'),(48,'Portugal','+351'),(49,'Reunión','+262'),(50,'Rusia','+7'),(51,'El Salvador','+503'),(52,'Eslovaquia','+421'),(53,'Eslovenia','+386'),(54,'Surinam','+597'),(55,'Estados Unidos','+1'),(56,'Tadjikistan','+992'),(57,'Turkmenistan','+993'),(58,'Islas Turcas y Caicos','+1-649'),(59,'Turquía','+90'),(60,'Uganda','+256'),(61,'Uzbekistán','+998'),(62,'Ucrania','+380'),(63,'Finlandia','+358'),(64,'Francia','+33'),(65,'República Checa','+420'),(66,'Suiza','+41'),(67,'Suecia','+46'),(68,'Estonia','+372'),(69,'Corea del Sur','+82'),(70,'Japón','+81'),(71,'Croacia','+385'),(72,'Rumanía','+40'),(73,'Hong Kong','+852'),(74,'Indonesia','+62'),(75,'Jordania','+962'),(76,'Malasia','+60'),(77,'Singapur','+65'),(78,'Taiwan','886'),(79,'Bosnia y Herzegovina','+387'),(80,'Bahamas','+1-242'),(81,'Chile','+56'),(82,'Colombia','+57'),(83,'Islandia','+354'),(84,'Corea del Norte','+850'),(85,'Macedonia','+389'),(86,'Malta','+356'),(87,'Pakistán','+92'),(88,'Papúa-Nueva Guinea','+675'),(89,'Perú','+51'),(90,'Filipinas','+63'),(91,'Arabia Saudita','+966'),(92,'Tailandia','+66'),(93,'Emiratos árabes Unidos','+971'),(94,'Groenlandia','+299'),(95,'Venezuela','58'),(96,'Zimbabwe','+263'),(97,'Kenia','+254'),(98,'Algeria','+213'),(99,'Líbano','+961'),(100,'Botsuana','+267'),(101,'Tanzania','+255'),(102,'Namibia','+264'),(103,'Ecuador','+593'),(104,'Marruecos','+212'),(105,'Ghana','+233'),(106,'Siria','+963'),(107,'Nepal','+977'),(108,'Mauritania','+222'),(109,'Seychelles','+248'),(110,'Paraguay','+595'),(111,'Uruguay','+598'),(112,'Congo (Brazzaville)','+242'),(113,'Cuba','+53'),(114,'Albania','+355'),(115,'Nigeria','+234'),(116,'Zambia','+260'),(117,'Mozambique','+258'),(119,'Angola','+244'),(120,'Sri Lanka','+94'),(121,'Etiopía','+251'),(122,'Túnez','+216'),(123,'Bolivia','+591'),(124,'Panamá','+507'),(125,'Malawi','+265'),(126,'Liechtenstein','+423'),(127,'Bahrein','+973'),(128,'Barbados','+1246'),(130,'Chad','+235'),(131,'Man, Isla de','+44 1624'),(132,'Jamaica','+1876'),(133,'Malí','+223'),(134,'Madagascar','+261'),(135,'Senegal','+221'),(136,'Togo','+228'),(137,'Honduras','+504'),(138,'República Dominicana','+1809'),(139,'Mongolia','+976'),(140,'Irak','+964'),(141,'Sudáfrica','+27'),(142,'Aruba','+297'),(143,'Gibraltar','+350'),(144,'Afganistán','+93'),(145,'Andorra','+376'),(147,'Antigua y Barbuda','+1268'),(149,'Bangladesh','+880'),(151,'Benín','+229'),(152,'Bután','+975'),(154,'Islas Vírgenes Británicas','+1284'),(155,'Brunéi','+673'),(156,'Burkina Faso','+226'),(157,'Burundi','+257'),(158,'Camboya','+855'),(159,'Cabo Verde','+238'),(164,'Comores','+269'),(165,'Congo (Kinshasa)','+243'),(166,'Cook, Islas','+682'),(168,'Costa de Marfil','+225'),(169,'Djibouti, Yibuti','+253'),(171,'Timor Oriental','+670'),(172,'Guinea Ecuatorial','+240'),(173,'Eritrea','+291'),(175,'Feroe, Islas','+298'),(176,'Fiyi','+679'),(178,'Polinesia Francesa','+689'),(180,'Gabón','+241'),(181,'Gambia','+220'),(184,'Granada','+1473'),(185,'Guatemala','+502'),(186,'Guernsey','+44 1481'),(187,'Guinea','+224'),(188,'Guinea-Bissau','+245'),(189,'Guyana','+592'),(193,'Jersey','+44 1534'),(195,'Kiribati','+686'),(196,'Laos','+856'),(197,'Lesotho','+266'),(198,'Liberia','+231'),(200,'Maldivas','+960'),(201,'Martinica','+596'),(202,'Mauricio','+230'),(205,'Myanmar','+95'),(206,'Nauru','+674'),(207,'Antillas Holandesas','+599'),(208,'Nueva Caledonia','+687'),(209,'Nicaragua','+505'),(210,'Níger','+227'),(212,'Norfolk Island','+672'),(213,'Omán','+968'),(215,'Isla Pitcairn','+64'),(216,'Qatar','+974'),(217,'Ruanda','+250'),(218,'Santa Elena','+290'),(219,'San Cristobal y Nevis','+1869'),(220,'Santa Lucía','+1758'),(221,'San Pedro y Miquelón','+508'),(222,'San Vincente y Granadinas','+1784'),(223,'Samoa','+685'),(224,'San Marino','+378'),(225,'San Tomé y Príncipe','+239'),(226,'Serbia y Montenegro','+381'),(227,'Sierra Leona','+232'),(228,'Islas Salomón','+677'),(229,'Somalia','+252'),(232,'Sudán','+249'),(234,'Swazilandia','+268'),(235,'Tokelau','+690'),(236,'Tonga','+676'),(237,'Trinidad y Tobago','+1868'),(239,'Tuvalu','+688'),(240,'Vanuatu','+678'),(241,'Wallis y Futuna','+681'),(242,'Sáhara Occidental','+212'),(243,'Yemen','+967'),(246,'Puerto Rico','+1787');
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
  `tokenQuestion` varchar(255) DEFAULT NULL,
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
INSERT INTO `Poll_InvitedUsers` VALUES (1,1,'NBUColhaePVP3vwbZG2QvvY2lZ75dttkT4DIw2jL'),(2,1,'UejpLskm2SmQToBFNBiAvBbWYRB6Ay71KFgqdd9V');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Polls`
--

LOCK TABLES `Polls` WRITE;
/*!40000 ALTER TABLE `Polls` DISABLE KEYS */;
INSERT INTO `Polls` VALUES (1,'test','2024-02-06 16:12:10','1111-11-01 11:11:00','2222-02-22 22:22:00','blocked','hidden','hidden',NULL,NULL,1),(2,'test','2024-02-06 17:57:10','2222-11-11 11:11:00','2323-11-01 22:22:00','not_begun','hidden',NULL,NULL,NULL,1),(3,'test','2024-02-06 17:59:58','1111-11-11 11:01:00','2222-02-22 11:01:00','not_begun','hidden',NULL,NULL,NULL,1);
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
  `Vote` varchar(255) DEFAULT NULL,
  `PollID` int DEFAULT NULL,
  UNIQUE KEY `User_Vote_unique` (`UserID`,`Vote`),
  KEY `User_Vote_Answer` (`Vote`),
  KEY `PollID` (`PollID`),
  CONSTRAINT `user_vote_ibfk_1` FOREIGN KEY (`PollID`) REFERENCES `Polls` (`ID`),
  CONSTRAINT `User_Vote_User` FOREIGN KEY (`UserID`) REFERENCES `Users` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User_Vote`
--

LOCK TABLES `User_Vote` WRITE;
/*!40000 ALTER TABLE `User_Vote` DISABLE KEYS */;
INSERT INTO `User_Vote` VALUES (1,'cSnCQqi8F0roSfWPS6oXJmtqamtEpOVtKvbM5kRB',1);
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
  `ValidationToken` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Erik','babfaf13d4a8b78b8a73520c5c6b549b5a8ae46ef532117bd1686eadfd58a29f5aa9dd42ae0543c702007238387125bda83018cede4c832d6cc13a231b91b62c','+34123456789','eriktamano@gmail.com','España','Cornellá',8940,1,'BldHIgNixWA3FIdllUeb8CSmK5TKpsHqG0HDnUdq'),(2,NULL,NULL,NULL,'etamanosantos.cf@iesesteveterradas.cat',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Votes`
--

DROP TABLE IF EXISTS `Votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Votes` (
  `VoteHash` varchar(255) DEFAULT NULL,
  `AnswerID` int DEFAULT NULL,
  UNIQUE KEY `Votes_Unique` (`VoteHash`,`AnswerID`),
  KEY `Vote_Answer` (`AnswerID`),
  CONSTRAINT `Vote_Answer` FOREIGN KEY (`AnswerID`) REFERENCES `Answers` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Votes`
--

LOCK TABLES `Votes` WRITE;
/*!40000 ALTER TABLE `Votes` DISABLE KEYS */;
INSERT INTO `Votes` VALUES ('Dpgow9qSqdi+iTk1mfZf6hgo8mMcoYimcUwl9/+WfWOBguOPxxnKoRUBwxFQ/kSf',2);
/*!40000 ALTER TABLE `Votes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_queue`
--

DROP TABLE IF EXISTS `email_queue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_queue` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `PollID` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_queue`
--

LOCK TABLES `email_queue` WRITE;
/*!40000 ALTER TABLE `email_queue` DISABLE KEYS */;
/*!40000 ALTER TABLE `email_queue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_recovery_requests`
--

DROP TABLE IF EXISTS `password_recovery_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_recovery_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_general_ci NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_recovery_requests`
--

LOCK TABLES `password_recovery_requests` WRITE;
/*!40000 ALTER TABLE `password_recovery_requests` DISABLE KEYS */;
INSERT INTO `password_recovery_requests` VALUES (2,'eriktamano@gmail.com','arbRKYeyQtQBAoeZOqTAQ1KbLRCqlevVKAnuanD5','2024-02-06 15:26:40');
/*!40000 ALTER TABLE `password_recovery_requests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-06 18:22:03