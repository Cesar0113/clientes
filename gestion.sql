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
  -- Base de datos: `aplicacion`
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
    `correo` VARCHAR(50) NOT NULL;
    `codigo_recuperacion` VARCHAR(255) NOT NULL
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


  /*TABLAS DE MASCOTAS Y RAZAS*/;

  -- Estructura de tabla para la tabla `tblraza`
  CREATE TABLE `tblraza` (
    `idRaza` int(11) NOT NULL,
    `nombreRaza` varchar(50) NOT NULL,
    PRIMARY KEY (`idRaza`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Volcado de datos para la tabla `tblraza`
  INSERT INTO `tblraza` (`idRaza`, `nombreRaza`) VALUES
  (1, 'Labrador Retriever'),
  (2, 'Siamese');

 CREATE TABLE `tblmascota` (
  `idMascota` int(11) NOT NULL,
  `nombreMascota` varchar(20) NOT NULL,
  `edadMascota` int(11) NOT NULL,
  `tipoMascota` varchar(20) NOT NULL,
  `raza_id` int(11) NOT NULL,
  `idCliente` int(11) NOT NULL,  -- Nueva columna para relacionar con tblcliente
  PRIMARY KEY (`idMascota`),
  INDEX `idx_raza_id` (`raza_id`), -- Añade un índice a la columna raza_id
  INDEX `idx_cliente` (`idCliente`), -- Añade un índice a la columna idCliente
  FOREIGN KEY (`raza_id`) REFERENCES `tblraza` (`idRaza`),
  FOREIGN KEY (`idCliente`) REFERENCES `tblcliente` (`idCliente`)  -- Nueva relación con tblcliente
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


/*TABLA DE PRODUCTOS*/
CREATE TABLE `tblproducto` (
    `idProducto` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(50) NOT NULL,
    `precio` decimal(10, 2) NOT NULL,
    `descripcion` TEXT NOT NULL,
    `imagen` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Añade una nueva tabla para las compras
CREATE TABLE `tblcompra` (
    `idCompra` int(11) NOT NULL AUTO_INCREMENT,
    `idProducto` int(11) NOT NULL,
    `idCliente` int(11) NOT NULL,
    `precio` decimal(10, 2) NOT NULL,
    PRIMARY KEY (`idCompra`),
    FOREIGN KEY (`idProducto`) REFERENCES `tblproducto` (`idProducto`),
    FOREIGN KEY (`idCliente`) REFERENCES `tblcliente` (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  -- Añade una nueva columna para la cantidad en la tabla tblcompra
ALTER TABLE `tblcompra` ADD `cantidad` int(11) NOT NULL AFTER `precio`;
ALTER TABLE tblcompra ADD tipoPago VARCHAR(10) NOT NULL AFTER precio;
