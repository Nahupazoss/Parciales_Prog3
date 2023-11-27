-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2022 a las 12:21:38
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
-- Base de datos: `jugueteria_bd`
--
CREATE DATABASE IF NOT EXISTS `jugueteria_bd` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `jugueteria_bd`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juguetes`
--

CREATE TABLE `juguetes` (
  `id` int(10) UNSIGNED NOT NULL,
  `marca` varchar(50) NOT NULL,
  `precio` double NOT NULL,
  `path_foto` varchar(50) NOT NULL DEFAULT '---'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` varchar(50) NOT NULL,
  `clave` varchar(8) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `foto` varchar(80) NOT NULL,
  `perfil` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `clave`, `nombre`, `apellido`, `foto`, `perfil`) VALUES
(1, 'prop@prop.com', '123456', 'propie', 'tario', './../fotos/prop@prop.com.jpg', 'propietario'),
(2, 'emple@emple.com', '123456', 'emple', 'ado', './../fotos/emple@emple.com.jpg', 'empleado'),
(3, 'super@super.com', '123456', 'super', 'visor', './../fotos/super@super.com.jpg', 'supervisor'),
(4, 'marcelo@gallardo.com', '123456', 'marcelo', 'gallardo', './../fotos/marcelo@gallardo.com.jpg', 'propietario');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `juguetes`
--
ALTER TABLE `juguetes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `juguetes`
--
ALTER TABLE `juguetes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
