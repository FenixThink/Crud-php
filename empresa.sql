-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-09-2022 a las 16:15:04
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
-- Base de datos: `empresa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `idAdmin` varchar(10) NOT NULL,
  `nombreAdmin` varchar(100) DEFAULT NULL,
  `emailAdmin` varchar(100) DEFAULT NULL,
  `contraseña` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`idAdmin`, `nombreAdmin`, `emailAdmin`, `contraseña`) VALUES
('UqfjK4yjlI', 'FenixThink', 'brayanxdvanegas@hotmail.com', '1234');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargos`
--

CREATE TABLE `cargos` (
  `idCargo` varchar(10) NOT NULL,
  `CarNombre` varchar(50) DEFAULT NULL,
  `CarSueldo` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cargos`
--

INSERT INTO `cargos` (`idCargo`, `CarNombre`, `CarSueldo`) VALUES
('zDROFgBT2a', 'Gerente', 5000000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `idEmpleado` varchar(10) NOT NULL,
  `Emplidentificacion` varchar(15) DEFAULT NULL,
  `empNombre` varchar(50) DEFAULT NULL,
  `empFechaingreso` date DEFAULT NULL,
  `empCorreo` varchar(100) DEFAULT NULL,
  `empGenero` enum('Femenino','Masculino') DEFAULT NULL,
  `empCargo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`idEmpleado`, `Emplidentificacion`, `empNombre`, `empFechaingreso`, `empCorreo`, `empGenero`, `empCargo`) VALUES
('b1JqRQMdIO', 'SmIGWubKg1', 'Bryan Vanegas', '2020-12-20', 'brayan@hotmail.com', 'Masculino', 'zDROFgBT2a');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` varchar(10) NOT NULL,
  `usuLogin` varchar(15) NOT NULL,
  `UsuPassword` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuLogin`, `UsuPassword`) VALUES
('b1JqRQMdIO', 'FenixThink', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`idCargo`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`idEmpleado`),
  ADD KEY `empCargo` (`empCargo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuLogin`),
  ADD UNIQUE KEY `idUsuario` (`idUsuario`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`empCargo`) REFERENCES `cargos` (`idCargo`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `empleados` (`idEmpleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
