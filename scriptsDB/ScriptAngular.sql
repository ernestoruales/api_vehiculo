-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
-- ------------------------------------------------------
-- Server version	5.7.23-23

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
-- Table structure for table `ang_cliente`
--

DROP TABLE IF EXISTS `ang_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ang_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ang_cliente`
--

LOCK TABLES `ang_cliente` WRITE;
/*!40000 ALTER TABLE `ang_cliente` DISABLE KEYS */;
INSERT INTO `ang_cliente` VALUES (1,'ERNESTO','RUALES','0969766664','ernesto.ruales@epico.gob.ec','2023-03-07 13:32:27','2023-03-07 13:32:27');
/*!40000 ALTER TABLE `ang_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ang_vehiculo`
--

DROP TABLE IF EXISTS `ang_vehiculo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ang_vehiculo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(45) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `foto` varchar(200) DEFAULT NULL,
  `anio` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL DEFAULT '1',
  `fecha_creacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_modificacion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ang_vehiculo`
--

LOCK TABLES `ang_vehiculo` WRITE;
/*!40000 ALTER TABLE `ang_vehiculo` DISABLE KEYS */;
INSERT INTO `ang_vehiculo` VALUES (1,'001','CHEVROLET','SAIL 1.5','https://tuautoencasa.com/img/galeria/1619475914.jpg',2023,4,'2023-03-06 19:29:00','2023-03-06 21:46:26'),(2,'002','CHEVROLET','ONIX','https://img.remediosdigitales.com/858e8a/chevrolet-onix-2023-precio-mexico_/840_560.jpg',2023,3,'2023-03-06 19:29:00','2023-03-06 19:29:00'),(3,'003','NISSAN','Sentra','https://www.ccarprice.com/products/Nissan_Sentra_S_2022_1.jpg',2023,4,'2023-03-06 19:29:00','2023-03-06 19:29:00'),(4,'004','TOYOTA','Corolla','https://mma.prnewswire.com/media/1923543/2023_Corolla_Sedan_001H.jpg',2023,5,'2023-03-06 19:29:00','2023-03-06 19:29:00'),(5,'005','HIUNDAY','Electra','https://media.primicias.ec/2021/08/03140218/port-1.jpg',2023,5,'2023-03-06 19:29:00','2023-03-06 19:29:00'),(6,'006','NISSAN','Versa','https://www.nissan-cdn.net/content/dam/Nissan/ec/vehicles/Versa_MY20/launch/especificaciones/advance-cvt-spec.png.ximg.l_3_m.smart.png',2023,4,'2023-03-06 19:29:00','2023-03-06 19:29:00');
/*!40000 ALTER TABLE `ang_vehiculo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-03-07 14:02:10
