# ************************************************************
# Sequel Pro SQL dump
# Versión 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.4.21-MariaDB)
# Base de datos: prueba_red5G
# Tiempo de Generación: 2024-03-06 05:22:40 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Volcado de tabla comentarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `comentarios`;

CREATE TABLE `comentarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comentario` text DEFAULT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;

INSERT INTO `comentarios` (`id`, `comentario`, `estado`, `fecha_creacion`)
VALUES
	(1,'el mejor libro, me encanto le doy 10 estrellas, muy completo el libro, recomendado',1,'2024-03-06 00:17:10');

/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla noticias
# ------------------------------------------------------------

DROP TABLE IF EXISTS `noticias`;

CREATE TABLE `noticias` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) unsigned NOT NULL,
  `titulo` varchar(30) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` int(11) DEFAULT 1 COMMENT '1:activo, 0:desactivado',
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `noticias` WRITE;
/*!40000 ALTER TABLE `noticias` DISABLE KEYS */;

INSERT INTO `noticias` (`id`, `id_usuario`, `titulo`, `descripcion`, `estado`, `fecha_creacion`)
VALUES
	(1,1,'prueba actualizacion','hola como vas?',1,'2024-03-06 00:14:38'),
	(2,1,'Crepusculo','el mejor libro de la saga de los vamprios mas famosos del mundo',0,'2024-03-06 00:15:17');

/*!40000 ALTER TABLE `noticias` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuario
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL DEFAULT '',
  `correo` varchar(50) NOT NULL DEFAULT '',
  `contrasenia` text NOT NULL,
  `direccion` varchar(50) NOT NULL DEFAULT '',
  `telefono` varchar(50) NOT NULL DEFAULT '',
  `fecha_nacimiento` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `estado` int(11) NOT NULL DEFAULT 1 COMMENT '1: Activo, 0: Inactivo',
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;

INSERT INTO `usuario` (`id`, `nombre`, `correo`, `contrasenia`, `direccion`, `telefono`, `fecha_nacimiento`, `estado`, `fecha_creacion`)
VALUES
	(1,'Andrea','andreaPaba@gmail.com','633de8b34bd3dc66daf44e2932bff7aea5c6aa0db2e9e46ede2f3eae317e9c93','cra 20 #1-43','30048492','2002-02-09 00:00:00',1,'2024-03-06 00:13:24');

/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;


# Volcado de tabla usuario_comentarios
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usuario_comentarios`;

CREATE TABLE `usuario_comentarios` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) unsigned NOT NULL,
  `id_noticia` int(11) unsigned NOT NULL,
  `id_comentario` int(11) unsigned NOT NULL,
  `estado` int(11) DEFAULT 1,
  `fecha_sistema` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_noticia` (`id_noticia`),
  KEY `id_comentario` (`id_comentario`),
  CONSTRAINT `usuario_comentarios_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `usuario_comentarios_ibfk_2` FOREIGN KEY (`id_noticia`) REFERENCES `noticias` (`id`),
  CONSTRAINT `usuario_comentarios_ibfk_3` FOREIGN KEY (`id_comentario`) REFERENCES `comentarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `usuario_comentarios` WRITE;
/*!40000 ALTER TABLE `usuario_comentarios` DISABLE KEYS */;

INSERT INTO `usuario_comentarios` (`id`, `id_usuario`, `id_noticia`, `id_comentario`, `estado`, `fecha_sistema`)
VALUES
	(1,1,1,1,1,'2024-03-06 00:17:10');

/*!40000 ALTER TABLE `usuario_comentarios` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
