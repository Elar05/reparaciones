-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 08-11-2023 a las 22:32:39
-- Versión del servidor: 8.0.31
-- Versión de PHP: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reparaciones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `idmodelo` int NOT NULL,
  `idunidad` int NOT NULL,
  `n_serie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_c` decimal(10,2) NOT NULL,
  `precio_v` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `stock_min` int NOT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `descripcion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `f_registro` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` char(1) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  `destino` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `idmodelo`, `idunidad`, `n_serie`, `precio_c`, `precio_v`, `stock`, `stock_min`, `foto`, `descripcion`, `f_registro`, `estado`, `destino`) VALUES
(1, 56, 8, 'TRD', '40.00', '50.00', 100, 20, 'public/img/productos/abendicion.jpg', '', '2023-11-06 22:13:57', '1', '1'),
(2, 36, 8, 'S20101', '400.00', '500.00', 20, 5, 'public/img/productos/abendicion.jpg', '', '2023-11-07 15:41:57', '1', '1');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
