-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.34-log - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para uptask_mvc
CREATE DATABASE IF NOT EXISTS `uptask_mvc` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `uptask_mvc`;

-- Volcando estructura para tabla uptask_mvc.proyectos
CREATE TABLE IF NOT EXISTS `proyectos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proyecto` varchar(60) DEFAULT NULL,
  `url` varchar(32) DEFAULT NULL,
  `propietarioId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_idx` (`propietarioId`),
  CONSTRAINT `usuarios` FOREIGN KEY (`propietarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask_mvc.proyectos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id`, `proyecto`, `url`, `propietarioId`) VALUES
	(1, ' UpTask', '9a8cc665cecc597a2df46f10b9479672', 9),
	(2, ' Tienda Virtual', 'bc79d1d2515d9f3b5c808590dd78fb67', 9);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla uptask_mvc.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `token` varchar(15) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask_mvc.usuarios: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `token`, `confirmado`) VALUES
	(1, ' Julio Cervantes', 'admin@solucioncb.com', '$2y$10$XtI4DTPJS2MVb9Lsm3/CqeKPYBG4jylSjBLmfhr0qsdsmXPd62Fta', '', 1),
	(8, 'Rematepc', 'rematepc@gmail.com', '$2y$10$FALr3I4SeesaUevQUfIN2uqYDPh/fmrLMFcAKLy4vBLXnYjMUi8uq', '', 1),
	(9, ' Julio César Cervantes', 'imjcervantes@gmail.com', '$2y$10$sLroqbhGUcBIaRWcgpzEd.sdjHezRS7Th9U9tWleCTysUFsEp2SpG', '', 1),
	(10, ' Julio', 'correo@correo.com', '$2y$10$HW8h33hPg4rQuymRMvxwnuZ0ihnZEvZambuvkyABqQ/9UeLarycfO', '', 1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
