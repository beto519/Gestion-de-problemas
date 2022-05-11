-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: bkcx10cn1dpbf3cc0liw-mysql.services.clever-cloud.com    Database: bkcx10cn1dpbf3cc0liw
-- ------------------------------------------------------
-- Server version	8.0.22-13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'a05a675a-1414-11e9-9c82-cecd01b08c7e:1-491550428,
a38a16d0-767a-11eb-abe2-cecd029e558e:1-135971211';

--
-- Table structure for table `Soluciones`
--

DROP TABLE IF EXISTS `Soluciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Soluciones` (
  `idSoluciones` int NOT NULL AUTO_INCREMENT,
  `clave` varchar(250) DEFAULT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `detalles` text,
  `idProblema` varchar(250) DEFAULT NULL,
  `fechaS` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idSoluciones`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Soluciones`
--

LOCK TABLES `Soluciones` WRITE;
/*!40000 ALTER TABLE `Soluciones` DISABLE KEYS */;
INSERT INTO `Soluciones` VALUES (23,'001','Maquina reparada','Error encontrado en unos circuitos quemados, ya fueron comprados y cambiados.','001','09-05-2022'),(24,'002','Solución del sistema operativo','Se envió a una copia de seguridad atrás el sistema y se encontraron algunas aplicaciones con versiones muy viejas, por lo cual ya se genero la solución, favor de generar otro ticket en caso de que encuentre otro fallo.','002','10-05-2022'),(25,'003','Problemas de luminosidad en almacen','Se realizaron cambios pertinentes de las lamparas y se reviso que funcionaran perfectamente, problema resuelto.','004','10-05-2022'),(26,'004','Instalación de software office','Se reinstalo office y se pago otro año ya que había vencido.','005','10-05-2022'),(27,'005','Cinta de produccion','La cina se encontraba atascada y se le coloco algunos aceites y limpieza.','003','10-05-2022');
/*!40000 ALTER TABLE `Soluciones` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-09 19:45:48
