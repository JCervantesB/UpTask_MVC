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
  `fecha` date DEFAULT NULL,
  `propietarioId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarios_idx` (`propietarioId`),
  CONSTRAINT `usuarios` FOREIGN KEY (`propietarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask_mvc.proyectos: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`id`, `proyecto`, `url`, `fecha`, `propietarioId`) VALUES
	(1, ' UpTask', '9a8cc665cecc597a2df46f10b9479672', '2021-11-06', 9),
	(2, ' Tienda Virtual', 'bc79d1d2515d9f3b5c808590dd78fb67', '2021-11-08', 9),
	(3, ' HRMS en Odoo', '06afb76b24603ae4d8297f3e81bd0c01', '2021-11-08', 9),
	(4, ' WebSite AppSalon', 'c8577816d2122d182135c1d933dc4ea6', '2021-11-09', 9),
	(5, ' Programas', '07d4d0dd248fa6b75c3010bcb43b9c98', '2021-11-09', 9);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

-- Volcando estructura para tabla uptask_mvc.tareas
CREATE TABLE IF NOT EXISTS `tareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `proyectoId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proyectoId_idx` (`proyectoId`),
  CONSTRAINT `proyectoId` FOREIGN KEY (`proyectoId`) REFERENCES `proyectos` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla uptask_mvc.tareas: ~18 rows (aproximadamente)
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` (`id`, `nombre`, `estado`, `proyectoId`) VALUES
	(1, ' Configurar Cuenta PayPal', 0, 2),
	(2, ' Investigar un Hosting Apropiado', 1, 2),
	(3, ' Configurar Cuenta Stripe', 0, 2),
	(4, ' Crear un API', 1, 1),
	(5, ' Crear modelo de Tareas', 1, 1),
	(6, ' Crear barra de progreso en proyectos', 0, 1),
	(7, ' Generar catalogo de productos', 0, 2),
	(9, 'Consultar los requerimientos del cliente', 0, 3),
	(10, ' Elegir la version de Odoo a utilizar', 0, 3),
	(11, ' Seleccionar un VPS adecuado al proyecto', 0, 3),
	(12, ' Desplegar Servidor de Desarrollo', 0, 3),
	(13, 'Buscar un tema de WooComerce', 0, 2),
	(15, ' Mostrar tareas en el proyecto', 1, 1),
	(16, ' Crear el modelo de Proyectos', 1, 1),
	(17, ' Añadir Virtual DOM al crear una Tarea', 1, 1),
	(22, ' Descargar Architectural en Español', 0, 5),
	(23, ' Descargar Revit 2019', 0, 5),
	(29, 'Añadir botones para cambiar de estado', 1, 1);
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;

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
