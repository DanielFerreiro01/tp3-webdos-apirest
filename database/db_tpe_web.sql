-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-10-2023 a las 23:12:44
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tpe_web`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `numeroPedido` int(11) NOT NULL,
  `nombreCliente` varchar(255) DEFAULT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) DEFAULT NULL,
  `cp` varchar(255) DEFAULT NULL,
  `fechaEnvio` datetime DEFAULT NULL,
  `producto` varchar(255) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `repartidorId` int(11) NOT NULL,
  `tipoEnvioId` int(11) NOT NULL,
  `estadoPedido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`numeroPedido`, `nombreCliente`, `calle`, `ciudad`, `cp`, `fechaEnvio`, `producto`, `cantidad`, `total`, `repartidorId`, `tipoEnvioId`, `estadoPedido`) VALUES
(12, 'Iglu', 'Avellaneda 1579', 'Tandil', '7000', '2023-10-16 01:30:00', 'Helado', 1, 1456, 1, 21, 1),
(18, 'Iglu', 'Avellaneda 1579', 'Tandil', '7000', '2023-10-17 17:29:00', 'Helado', 1, 1456, 2, 19, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `rolld` int(11) NOT NULL,
  `tipoPermiso` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `permiso`
--

INSERT INTO `permiso` (`rolld`, `tipoPermiso`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidor`
--

CREATE TABLE `repartidor` (
  `repartidorId` int(11) NOT NULL,
  `nombreCompleto` varchar(255) DEFAULT NULL,
  `vehiculo` varchar(255) DEFAULT NULL,
  `disponibilidad` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `repartidor`
--

INSERT INTO `repartidor` (`repartidorId`, `nombreCompleto`, `vehiculo`, `disponibilidad`) VALUES
(1, 'Facundo Perez', 'Utilitaria', 1),
(2, 'Juan Rodriguez', 'Utilitaria', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipodeenvio`
--

CREATE TABLE `tipodeenvio` (
  `tipoEnvioId` int(11) NOT NULL,
  `nombreEnvio` varchar(255) NOT NULL,
  `zonasDisponibles` varchar(255) NOT NULL,
  `premium` tinyint(1) NOT NULL,
  `tipoPaquete` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tipodeenvio`
--

INSERT INTO `tipodeenvio` (`tipoEnvioId`, `nombreEnvio`, `zonasDisponibles`, `premium`, `tipoPaquete`) VALUES
(19, 'OCA', 'CABA', 0, 'Solo tipo 1'),
(21, 'delivery', 'CABA', 0, 'Solo tipo 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuarioId` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rolId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usuarioId`, `nombre`, `email`, `contraseña`, `rolId`) VALUES
(1, 'webadmin', 'webadmin@gmail.com', '$2y$10$cfgw6Trcs3q6YNj4.7wbSuogi0kNP3CEwi0ib9G4qmmRN.3zKUj2u', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`numeroPedido`),
  ADD KEY `repartidorId` (`repartidorId`),
  ADD KEY `tipoPaqueteId` (`tipoEnvioId`),
  ADD KEY `tipoEnvioId` (`tipoEnvioId`);

--
-- Indices de la tabla `permiso`
--
ALTER TABLE `permiso`
  ADD PRIMARY KEY (`rolld`);

--
-- Indices de la tabla `repartidor`
--
ALTER TABLE `repartidor`
  ADD PRIMARY KEY (`repartidorId`);

--
-- Indices de la tabla `tipodeenvio`
--
ALTER TABLE `tipodeenvio`
  ADD PRIMARY KEY (`tipoEnvioId`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usuarioId`),
  ADD KEY `rolId` (`rolId`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `numeroPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `tipodeenvio`
--
ALTER TABLE `tipodeenvio`
  MODIFY `tipoEnvioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`repartidorId`) REFERENCES `repartidor` (`repartidorId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`tipoEnvioId`) REFERENCES `tipodeenvio` (`tipoEnvioId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rolId`) REFERENCES `permiso` (`rolld`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
