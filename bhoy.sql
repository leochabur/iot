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
-- Table structure for table `light`.`rrhh_propietario`
--

DROP TABLE IF EXISTS `rrhh_propietario`;
CREATE TABLE `rrhh_propietario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuit` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`rrhh_propietario`
--

/*!40000 ALTER TABLE `rrhh_propietario` DISABLE KEYS */;
/*!40000 ALTER TABLE `rrhh_propietario` ENABLE KEYS */;


--
-- Table structure for table `light`.`seg_vial_opciones_tipo_unidad`
--

DROP TABLE IF EXISTS `seg_vial_opciones_tipo_unidad`;
CREATE TABLE `seg_vial_opciones_tipo_unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E0D2263A702D1D47` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`seg_vial_opciones_tipo_unidad`
--

/*!40000 ALTER TABLE `seg_vial_opciones_tipo_unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `seg_vial_opciones_tipo_unidad` ENABLE KEYS */;


--
-- Table structure for table `light`.`seg_vial_unidades`
--

DROP TABLE IF EXISTS `seg_vial_unidades`;
CREATE TABLE `seg_vial_unidades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interno` int(11) NOT NULL,
  `chasisMarca` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chasisModelo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `carroceriaMarca` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `carroceriaModelo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `capacidadReal` int(11) NOT NULL,
  `dominioAnterior` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
  `dominioNuevo` varchar(9) COLLATE utf8_unicode_ci DEFAULT NULL,
  `anioModelo` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`seg_vial_unidades`
--

/*!40000 ALTER TABLE `seg_vial_unidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `seg_vial_unidades` ENABLE KEYS */;


--
-- Table structure for table `light`.`seg_vialopciones_calidad_unidad`
--

DROP TABLE IF EXISTS `seg_vialopciones_calidad_unidad`;
CREATE TABLE `seg_vialopciones_calidad_unidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `calidad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`seg_vialopciones_calidad_unidad`
--

/*!40000 ALTER TABLE `seg_vialopciones_calidad_unidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `seg_vialopciones_calidad_unidad` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_frecuencia_turnos`
--

DROP TABLE IF EXISTS `trafico_frecuencia_turnos`;
CREATE TABLE `trafico_frecuencia_turnos` (
  `id_turno` int(11) NOT NULL,
  `id_frecuencia` int(11) NOT NULL,
  PRIMARY KEY (`id_turno`,`id_frecuencia`),
  KEY `IDX_926FC8D59122652` (`id_turno`),
  KEY `IDX_926FC8D573269F44` (`id_frecuencia`),
  CONSTRAINT `FK_926FC8D573269F44` FOREIGN KEY (`id_frecuencia`) REFERENCES `trafico_opciones_frecuencia_turno` (`id`),
  CONSTRAINT `FK_926FC8D59122652` FOREIGN KEY (`id_turno`) REFERENCES `trafico_turnos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_frecuencia_turnos`
--

/*!40000 ALTER TABLE `trafico_frecuencia_turnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_frecuencia_turnos` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_opciones_frecuencia_servicio`
--

DROP TABLE IF EXISTS `trafico_opciones_frecuencia_servicio`;
CREATE TABLE `trafico_opciones_frecuencia_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `frecuencia` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A7389A18D6AC1F93` (`frecuencia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_opciones_frecuencia_servicio`
--

/*!40000 ALTER TABLE `trafico_opciones_frecuencia_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_opciones_frecuencia_servicio` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_opciones_frecuencia_turno`
--

DROP TABLE IF EXISTS `trafico_opciones_frecuencia_turno`;
CREATE TABLE `trafico_opciones_frecuencia_turno` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `diaSemana` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_42C736883A909126` (`nombre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_opciones_frecuencia_turno`
--

/*!40000 ALTER TABLE `trafico_opciones_frecuencia_turno` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_opciones_frecuencia_turno` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_opciones_sentido_servicio`
--

DROP TABLE IF EXISTS `trafico_opciones_sentido_servicio`;
CREATE TABLE `trafico_opciones_sentido_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F86102A0702D1D47` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_opciones_sentido_servicio`
--

/*!40000 ALTER TABLE `trafico_opciones_sentido_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_opciones_sentido_servicio` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_opciones_tipo_servicio`
--

DROP TABLE IF EXISTS `trafico_opciones_tipo_servicio`;
CREATE TABLE `trafico_opciones_tipo_servicio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_79F00BEA702D1D47` (`tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_opciones_tipo_servicio`
--

/*!40000 ALTER TABLE `trafico_opciones_tipo_servicio` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_opciones_tipo_servicio` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_opciones_turno_cliente`
--

DROP TABLE IF EXISTS `trafico_opciones_turno_cliente`;
CREATE TABLE `trafico_opciones_turno_cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `turno` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A2AF31C8E7976762` (`turno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_opciones_turno_cliente`
--

/*!40000 ALTER TABLE `trafico_opciones_turno_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_opciones_turno_cliente` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_servicios`
--

DROP TABLE IF EXISTS `trafico_servicios`;
CREATE TABLE `trafico_servicios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) DEFAULT NULL,
  `id_orgien` int(11) DEFAULT NULL,
  `id_origen` int(11) DEFAULT NULL,
  `id_sentido` int(11) DEFAULT NULL,
  `id_tipo_servicio` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `IDX_72A1911B2A813255` (`id_cliente`),
  KEY `IDX_72A1911BBE32F6C6` (`id_orgien`),
  KEY `IDX_72A1911B5473ACFF` (`id_origen`),
  KEY `IDX_72A1911B9F8DFE73` (`id_sentido`),
  KEY `IDX_72A1911BA36B7986` (`id_tipo_servicio`),
  CONSTRAINT `FK_72A1911BA36B7986` FOREIGN KEY (`id_tipo_servicio`) REFERENCES `trafico_opciones_tipo_servicio` (`id`),
  CONSTRAINT `FK_72A1911B2A813255` FOREIGN KEY (`id_cliente`) REFERENCES `ventas_clientes` (`id`),
  CONSTRAINT `FK_72A1911B5473ACFF` FOREIGN KEY (`id_origen`) REFERENCES `ventas_ciudad` (`id`),
  CONSTRAINT `FK_72A1911B9F8DFE73` FOREIGN KEY (`id_sentido`) REFERENCES `trafico_opciones_sentido_servicio` (`id`),
  CONSTRAINT `FK_72A1911BBE32F6C6` FOREIGN KEY (`id_orgien`) REFERENCES `ventas_ciudad` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_servicios`
--

/*!40000 ALTER TABLE `trafico_servicios` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_servicios` ENABLE KEYS */;


--
-- Table structure for table `light`.`trafico_turnos`
--

DROP TABLE IF EXISTS `trafico_turnos`;
CREATE TABLE `trafico_turnos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_servicio` int(11) DEFAULT NULL,
  `id_turno` int(11) DEFAULT NULL,
  `horaInicial` time NOT NULL,
  `horaFinal` time NOT NULL,
  `kmRecorrido` int(11) NOT NULL,
  `duracion` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6E9BB0639B5D1EBF` (`id_servicio`),
  KEY `IDX_6E9BB0639122652` (`id_turno`),
  CONSTRAINT `FK_6E9BB0639122652` FOREIGN KEY (`id_turno`) REFERENCES `trafico_opciones_turno_cliente` (`id`),
  CONSTRAINT `FK_6E9BB0639B5D1EBF` FOREIGN KEY (`id_servicio`) REFERENCES `trafico_servicios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`trafico_turnos`
--

/*!40000 ALTER TABLE `trafico_turnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `trafico_turnos` ENABLE KEYS */;


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
 (2,'admin','$2y$13$C/T3OjQzHTK74gldTDojO..GFwj3UZV9OUTuitWtmBiNlKRaUTcMa','431','[\"ROLE_RESPONSABLE_DIAGRAMACION\"]',1,1);
/*!40000 ALTER TABLE `users_system` ENABLE KEYS */;


--
-- Table structure for table `light`.`ventas_ciudad`
--

DROP TABLE IF EXISTS `ventas_ciudad`;
CREATE TABLE `ventas_ciudad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_provincia` int(11) DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_empresa` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DB8A58E853AF4E34` (`id_provincia`),
  KEY `IDX_DB8A58E8664AF320` (`id_empresa`),
  CONSTRAINT `FK_DB8A58E8664AF320` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`),
  CONSTRAINT `FK_DB8A58E853AF4E34` FOREIGN KEY (`id_provincia`) REFERENCES `ventas_provincia` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`ventas_ciudad`
--

/*!40000 ALTER TABLE `ventas_ciudad` DISABLE KEYS */;
INSERT INTO `ventas_ciudad` (`id`,`id_provincia`,`nombre`,`id_empresa`) VALUES 
 (9,2,'Zarate',1),
 (11,2,'campana',1);
/*!40000 ALTER TABLE `ventas_ciudad` ENABLE KEYS */;


--
-- Table structure for table `light`.`ventas_clientes`
--

DROP TABLE IF EXISTS `ventas_clientes`;
CREATE TABLE `ventas_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `domicilioFiscal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cuit` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `id_empresa` int(11) DEFAULT NULL,
  `contacto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3C41A1E2B9BA4881` (`cuit`),
  KEY `IDX_3C41A1E2664AF320` (`id_empresa`),
  CONSTRAINT `FK_3C41A1E2664AF320` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`ventas_clientes`
--

/*!40000 ALTER TABLE `ventas_clientes` DISABLE KEYS */;
INSERT INTO `ventas_clientes` (`id`,`razonSocial`,`telefono`,`domicilioFiscal`,`cuit`,`activo`,`id_empresa`,`contacto`) VALUES 
 (1,'toyota sa','223439308','ruta 210 km 68','30-70986951-1',1,1,'leo'),
 (2,'toyota corporation','02223444640','ruta 210 km 68','30-70986951-4',1,1,NULL);
/*!40000 ALTER TABLE `ventas_clientes` ENABLE KEYS */;


--
-- Table structure for table `light`.`ventas_provincia`
--

DROP TABLE IF EXISTS `ventas_provincia`;
CREATE TABLE `ventas_provincia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_854589963A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `light`.`ventas_provincia`
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
