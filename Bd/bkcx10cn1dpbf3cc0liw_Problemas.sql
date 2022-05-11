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
a38a16d0-767a-11eb-abe2-cecd029e558e:1-135971244';

--
-- Table structure for table `Problemas`
--

DROP TABLE IF EXISTS `Problemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Problemas` (
  `idProblemas` int NOT NULL AUTO_INCREMENT,
  `claveProblemas` varchar(250) DEFAULT NULL,
  `nombreP` varchar(250) DEFAULT NULL,
  `fecha` varchar(45) DEFAULT NULL,
  `detalles` text,
  `estadoP` varchar(45) DEFAULT NULL,
  `idDepartamento` varchar(150) DEFAULT NULL,
  `idCentroTrabajo` varchar(150) DEFAULT NULL,
  `idEmpleado` varchar(150) DEFAULT NULL,
  `Prioridad` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idProblemas`),
  KEY `idEmpleado_idx` (`idEmpleado`),
  KEY `idCentrosTrabajo_idx` (`idCentroTrabajo`),
  KEY `idDepartamentos_idx` (`idDepartamento`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Problemas`
--

LOCK TABLES `Problemas` WRITE;
/*!40000 ALTER TABLE `Problemas` DISABLE KEYS */;
INSERT INTO `Problemas` VALUES (32,'001','La maquina cuenta con fallas','09-05-2022','La maquina con numero de serie #523654 del departamento se encuentra funcionando por un corto periodo de tiempo, favor de revisarla con la brevedad posible','Realizado','003','001','0001','Media'),(33,'002','Computadora de compatibilidad software','09-05-2022','La computadora de escritorio del puesto de empleado #23 se encuentra dando reinicios del sistema, favor de revisar el estado y mantener la información que contiene.','Realizado','001','001','0001','Baja'),(34,'004','La luminosidad del área de almacén','09-05-2022','En el almacén de piezas para motores se encuentra fallando la luz del fondo a la derecha, no contamos con forma de subir, favor de revisarlo.','Realizado','002','004','0003','Urgente'),(35,'005','Software de office en contabilidad','09-05-2022','El día de hoy el office de las 5 computadoras del departamento de contabilidad dejaron de funcionar, favor de venir con la brevedad posible.','Realizado','001','003','0003','Alta'),(36,'003','Maquinaria de produccion cinta','10-05-2022','La cinta del departamento de produccion #2 no se encuentra funcionando.','Realizado','002','001','0001','Urgente');
/*!40000 ALTER TABLE `Problemas` ENABLE KEYS */;
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

-- Dump completed on 2022-05-09 19:46:08
