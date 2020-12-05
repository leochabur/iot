-- MySQL Administrator dump 1.4
--
-- ------------------------------------------------------
-- Server version	5.5.59


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


--
-- Create schema traficov2
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ traficov2;
USE traficov2;

--
-- Table structure for table `traficov2`.`ventas_provincia`
--

DROP TABLE IF EXISTS `ventas_provincia`;
CREATE TABLE `ventas_provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_854589963A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `traficov2`.`ventas_provincia`
--

/*!40000 ALTER TABLE `ventas_provincia` DISABLE KEYS */;
INSERT INTO `ventas_provincia` (`id`,`nombre`) VALUES 
 (2,'Buenos Aires'),
 (1,'CABA'),
 (3,'Catamarca'),
 (4,'Chaco'),
 (13,'Chubut'),
 (20,'Cordoba'),
 (23,'Corrientes'),
 (6,'Entre Rios'),
 (22,'Formosa'),
 (7,'Jujuy'),
 (16,'La Pampa'),
 (18,'La Rioja'),
 (9,'Mendoza'),
 (5,'Misiones'),
 (10,'Neuquen'),
 (11,'Rio Negro'),
 (14,'Salta'),
 (17,'San Luis'),
 (12,'Santa Cruz'),
 (15,'Santa Fe'),
 (21,'Santiago del Estero'),
 (24,'Tierra del Fuego'),
 (19,'Tucuman');
/*!40000 ALTER TABLE `ventas_provincia` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
