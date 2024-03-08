-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2024 a las 00:48:57
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblcliente`
--

CREATE TABLE `tblcliente` (
  `idCliente` int(11) NOT NULL,
  `nombre1` varchar(20) NOT NULL,
  `nombre2` varchar(20) DEFAULT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `movil` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblcliente`
--

INSERT INTO `tblcliente` (`idCliente`, `nombre1`, `nombre2`, `apellido1`, `apellido2`, `direccion`, `movil`, `email`) VALUES
(55, 'Andres', 'Felipe', 'Villada', 'Ramirez', 'Rionegro', '3205225271', 'andres.villada@prointimo.co'),
(56, 'Camilo', '', 'Muñoz', 'Osorio', 'El Carmen de Viboral', '123456789', 'mail@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblperfil`
--

CREATE TABLE `tblperfil` (
  `idPerfil` int(11) NOT NULL,
  `nombrePerfil` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblperfil`
--

INSERT INTO `tblperfil` (`idPerfil`, `nombrePerfil`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tblusuario`
--

CREATE TABLE `tblusuario` (
  `idUsuario` int(11) NOT NULL,
  `nombreUsuario` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `idPerfil` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tblusuario`
--

INSERT INTO `tblusuario` (`idUsuario`, `nombreUsuario`, `password`, `idPerfil`) VALUES
(4, 'admin', '123', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tblcliente`
--
ALTER TABLE `tblcliente`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indices de la tabla `tblperfil`
--
ALTER TABLE `tblperfil`
  ADD PRIMARY KEY (`idPerfil`);

--
-- Indices de la tabla `tblusuario`
--
ALTER TABLE `tblusuario`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idPerfil - Usuario` (`idPerfil`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tblcliente`
--
ALTER TABLE `tblcliente`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `tblperfil`
--
ALTER TABLE `tblperfil`
  MODIFY `idPerfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `tblusuario`
--
ALTER TABLE `tblusuario`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tblusuario`
--
ALTER TABLE `tblusuario`
  ADD CONSTRAINT `tblusuario_ibfk_1` FOREIGN KEY (`idPerfil`) REFERENCES `tblperfil` (`idPerfil`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Estructura de tabla para la tabla `tblmascota`
CREATE TABLE `tblmascota` (
  `idMascota` int(11) NOT NULL,
  `nombreMascota` varchar(20) NOT NULL,
  `edadMascota` int(11) NOT NULL,
  `tipoMascota` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Volcado de datos para la tabla `tblmascota`
INSERT INTO `tblmascota` (`idMascota`, `nombreMascota`, `edadMascota`, `tipoMascota`) VALUES
(1, 'Firulais', 3, 'Perro'),
(2, 'Michi', 2, 'Gato');

-- Índices para tablas volcadas
-- Indices de la tabla `tblmascota`
ALTER TABLE `tblmascota`
  ADD PRIMARY KEY (`idMascota`);

-- AUTO_INCREMENT de las tablas volcadas
-- AUTO_INCREMENT de la tabla `tblmascota`
ALTER TABLE `tblmascota`
  MODIFY `idMascota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
