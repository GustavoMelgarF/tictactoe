-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-08-2019 a las 17:04:49
-- Versión del servidor: 10.1.39-MariaDB
-- Versión de PHP: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `tres_en_raya`
--
CREATE DATABASE IF NOT EXISTS `tres_en_raya` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tres_en_raya`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tablero`
--

CREATE TABLE `tablero` (
  `id` int(11) NOT NULL,
  `casilla1` tinyint(1) NOT NULL DEFAULT '0',
  `casilla2` tinyint(1) NOT NULL DEFAULT '0',
  `casilla3` tinyint(1) NOT NULL DEFAULT '0',
  `casilla4` tinyint(1) NOT NULL DEFAULT '0',
  `casilla5` tinyint(1) NOT NULL DEFAULT '0',
  `casilla6` tinyint(1) NOT NULL DEFAULT '0',
  `casilla7` tinyint(1) NOT NULL DEFAULT '0',
  `casilla8` tinyint(1) NOT NULL DEFAULT '0',
  `casilla9` tinyint(1) NOT NULL DEFAULT '0',
  `partida_terminada` tinyint(1) NOT NULL DEFAULT '0',
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices para tablas volcadas
--

--
-- Indices de la tabla `tablero`
--
ALTER TABLE `tablero`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tablero`
--
ALTER TABLE `tablero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
