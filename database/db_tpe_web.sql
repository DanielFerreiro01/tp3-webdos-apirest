-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-10-2023 a las 04:03:17
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
  `fechaEnvio` date DEFAULT NULL,
  `producto` varchar(255) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `repartidorId` int(11) DEFAULT NULL,
  `tipoEnvioId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permiso`
--

CREATE TABLE `permiso` (
  `rolld` int(11) NOT NULL,
  `tipoPermiso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `repartidor`
--

CREATE TABLE `repartidor` (
  `repartidorId` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `vehiculo` varchar(255) DEFAULT NULL,
  `disponibilidad` tinyint(1) DEFAULT NULL,
  `numeroPedido` int(11) DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(3, 'Same Day Delivery', 'CABA y Gran Buenos Aires', 1, 'Hasta tipo 3'),
(4, 'Envio Urgente', 'CABA y Gran Buenos Aires', 0, 'Hasta tipo 3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usuarioId` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rolId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  ADD PRIMARY KEY (`repartidorId`),
  ADD KEY `usuarioId` (`usuarioId`),
  ADD KEY `numeroPedido` (`numeroPedido`);

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
-- AUTO_INCREMENT de la tabla `tipodeenvio`
--
ALTER TABLE `tipodeenvio`
  MODIFY `tipoEnvioId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Filtros para la tabla `repartidor`
--
ALTER TABLE `repartidor`
  ADD CONSTRAINT `repartidor_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuario` (`usuarioId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `repartidor_ibfk_2` FOREIGN KEY (`numeroPedido`) REFERENCES `pedido` (`numeroPedido`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rolId`) REFERENCES `permiso` (`rolld`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
