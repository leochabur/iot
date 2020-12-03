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
-- Create schema light
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ light;
USE light;

--
-- Table structure for table `light`.`empresa`
--

DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuit` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` int(11) NOT NULL,
  `activa` tinyint(1) NOT NULL,
  `fechaAlta` datetime NOT NULL,
  `contacto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B8D75A50B9BA4881` (`cuit`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`empresa`
--

/*!40000 ALTER TABLE `empresa` DISABLE KEYS */;
INSERT INTO `empresa` (`id`,`razonSocial`,`cuit`,`codigo`,`activa`,`fechaAlta`,`contacto`,`telefono`,`email`,`direccion`) VALUES 
 (1,'Flecha Bus','12345678901',431,1,'2020-01-01 00:00:00','','','','');
/*!40000 ALTER TABLE `empresa` ENABLE KEYS */;


--
-- Table structure for table `light`.`users_system`
--

DROP TABLE IF EXISTS `users_system`;
CREATE TABLE `users_system` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `codigoEmpresa` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)',
  `id_empresa` int(11) DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `IDX_C6AA9F1B664AF320` (`id_empresa`),
  CONSTRAINT `FK_C6AA9F1B664AF320` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`users_system`
--

/*!40000 ALTER TABLE `users_system` DISABLE KEYS */;
INSERT INTO `users_system` (`id`,`username`,`password`,`codigoEmpresa`,`roles`,`id_empresa`,`activo`) VALUES 
 (1,'leochabur','$2y$13$RFymcPSA2IqhaURN0CzbNuLauS5gVMMdDNIIn4xYjTEhlxL.RmePa','392','[\"ROLE_CREATOR\"]',NULL,1),
 (2,'admin','$2y$13$C/T3OjQzHTK74gldTDojO..GFwj3UZV9OUTuitWtmBiNlKRaUTcMa','431','[\"ROLE_USER\"]',1,1);
/*!40000 ALTER TABLE `users_system` ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
