-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2021 a las 14:44:21
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `usuarios_test`
--
CREATE DATABASE IF NOT EXISTS `usuarios_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `usuarios_test`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `clave` varchar(8) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL,
  `foto` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sueldo` double UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id`, `correo`, `clave`, `nombre`, `id_perfil`, `foto`, `sueldo`) VALUES
(1, 'pedro@mail.com', '123', 'pedro', 2, './backend/empleados/fotos/pedro.022111.jpg', 25000),
(2, 'juana@mail.com', '123', 'juana', 2, './backend/empleados/fotos/juana.024247.jpg', 25700);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfiles`
--

CREATE TABLE `perfiles` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfiles`
--

INSERT INTO `perfiles` (`id`, `descripcion`) VALUES
(1, 'administrador'),
(2, 'empleado'),
(3, 'supervisor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `clave` varchar(8) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nombre` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `id_perfil` int(10) UNSIGNED NOT NULL COMMENT 'fk a perfiles.id'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `clave`, `nombre`, `id_perfil`) VALUES
(1, 'admin@admin.com', 'admin123', 'juan', 1),
(2, 'emple@emple.com', 'emple123', 'pedro', 2),
(3, 'emple02@emple.com', 'emple002', 'maria', 2),
(4, 'pedro@pedro.com', '123', 'pedro', 3),
(5, 'pedro_modif@pedro.com', '123_modi', 'pedro_modif', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `perfiles`
--
ALTER TABLE `perfiles`
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
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `perfiles`
--
ALTER TABLE `perfiles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
