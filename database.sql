-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: localhost    Database: conaffex
-- ------------------------------------------------------
-- Server version	8.0.23

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

--
-- Table structure for table `colaborador_fex`
--

DROP TABLE IF EXISTS `colaborador_fex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colaborador_fex` (
  `NUMERO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(150) DEFAULT NULL,
  `IDENTIFICACION` int DEFAULT NULL,
  `TELEFONO` int DEFAULT NULL,
  `NUM_TARJETA` bigint DEFAULT NULL,
  `OBSERVACIONES` text,
  `TIPO` varchar(50) DEFAULT NULL,
  `GENERO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`NUMERO`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colaborador_fex`
--

LOCK TABLES `colaborador_fex` WRITE;
/*!40000 ALTER TABLE `colaborador_fex` DISABLE KEYS */;
INSERT INTO `colaborador_fex` VALUES (1,'Daniel Navarro',7788,85647898,1234123456789875,'eed','Nacional','Hombre'),(2,'Ernesto Ilama',17,61884176,7676545432321234,'soltero','Extranjero','Hombre'),(3,'Daniel Romero',23,85647898,1234123456789876,'','Nacional','Hombre'),(4,'Daniel Navarro',0,85647898,1234123456789876,'','Nacional','Hombre'),(5,'Nano romero',0,85647898,1234123456789876,'','Nacional','Hombre'),(6,'Gerardo',303900456,89624962,1122334455667788,'','Extranjero','Hombre'),(7,'uhffd',432432,32423,32423,'','Extranjero','Mujer'),(8,'sfsfsd',432432,34223,32423,'fdssd','Nacional','Hombre'),(9,'Sara Elizondo',125631456,89902154,2563145698784163,'probando actualizacion','Nacional','Mujer'),(10,'Mary Navarro',432432,34223,32423,'fdssd','Nacional','Mujer'),(11,'Felipe Luis',34543,76875456,34543,'casa azul','Nacional','Hombre'),(12,'Jose Luis',4543567,52353,3434565676765454,'soltero','Extranjero','Hombre'),(13,'Nano Navarro',53534543,43543,43543,'del llano','Nacional','Hombre'),(14,'eretre',4353,3453,34534,'','Nacional','Hombre'),(15,'Daniel Navarro',435345,43543534,4354345,'casado','Nacional','Hombre'),(16,'Vladimir',35,33445566,1122334455667788,'Origen de panamá','Extranjero','Hombre'),(17,'Beto Navarro',2432,33445566,3243243243243242,'','Nacional','Hombre'),(18,'Francisco',12,223322,54354364343,'Mexico','Nacional','Hombre'),(19,'Franco Reyes',302800485,85964565,1425142545453636,'ewrwerwe','Nacional','Hombre'),(20,'Franco Reyes',302800484,85964565,142514254545363,'ewrwerwe','Nacional','Hombre');
/*!40000 ALTER TABLE `colaborador_fex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fincas_fex`
--

DROP TABLE IF EXISTS `fincas_fex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fincas_fex` (
  `NUMERO` int NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(150) DEFAULT NULL,
  `TAMANO` float DEFAULT NULL,
  `UBICACION` text,
  `NUM_PROPIETARIO` int DEFAULT NULL,
  PRIMARY KEY (`NUMERO`),
  KEY `NUM_PROPIETARIO` (`NUM_PROPIETARIO`),
  CONSTRAINT `fincas_fex_ibfk_1` FOREIGN KEY (`NUM_PROPIETARIO`) REFERENCES `usuarios_fex` (`NUMERO`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fincas_fex`
--

LOCK TABLES `fincas_fex` WRITE;
/*!40000 ALTER TABLE `fincas_fex` DISABLE KEYS */;
INSERT INTO `fincas_fex` VALUES (1,'Patricio 2',5,'Caragral del Guarco',2),(2,'Rio Conejo Beneficio',3,'Rio Conejo, Cartago',1),(3,'La Canoa',6,'Llano los Ángeles, Corralillo',1),(4,'La Pascuala',4.5,'San Gabriel de Aserrí',3);
/*!40000 ALTER TABLE `fincas_fex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios_fex`
--

DROP TABLE IF EXISTS `usuarios_fex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios_fex` (
  `NUMERO` int NOT NULL AUTO_INCREMENT,
  `IDENTIFICACION` bigint DEFAULT NULL,
  `NOMBRE` varchar(150) DEFAULT NULL,
  `CORREO` varchar(150) DEFAULT NULL,
  `CONTRASENA` varchar(255) DEFAULT NULL,
  `TIPO_USUARIO` int DEFAULT NULL,
  `ESTADO` int DEFAULT NULL,
  PRIMARY KEY (`NUMERO`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios_fex`
--

LOCK TABLES `usuarios_fex` WRITE;
/*!40000 ALTER TABLE `usuarios_fex` DISABLE KEYS */;
INSERT INTO `usuarios_fex` VALUES (1,304900948,'José Daniel Navarro','navrojd77@gmail.com','jupiter',1,1),(2,302800485,'Maricelly Navarro','marynavarro114@gmail.com','jupiter',2,1),(3,303300876,'José Luis Navarro','josenavarro17@gmail.com','jupiter',2,1);
/*!40000 ALTER TABLE `usuarios_fex` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-08 22:48:44
