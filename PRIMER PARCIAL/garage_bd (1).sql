-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-10-2022 a las 00:34:31
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `garage_bd`
--
CREATE DATABASE IF NOT EXISTS `garage_bd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `garage_bd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autos`
--

CREATE TABLE `autos` (
  `patente` varchar(30) NOT NULL,
  `marca` varchar(30) NOT NULL,
  `color` varchar(15) NOT NULL,
  `precio` double NOT NULL,
  `foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `autos`
--

INSERT INTO `autos` (`patente`, `marca`, `color`, `precio`, `foto`) VALUES
('AYF714', 'Renault', 'gris', 150000, NULL),
('TOC623', 'Fiat', 'blanco', 198000, NULL),
('AB555DC', 'Ford', 'verde', 256900, './AB555DC.105905.jpg'),
('AA666AA', 'Chevrolet', 'rojo', 323200, './AA666AA.105905.jpg');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
