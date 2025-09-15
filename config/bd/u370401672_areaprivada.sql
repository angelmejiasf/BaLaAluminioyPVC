-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-09-2025 a las 14:37:31
-- Versión del servidor: 10.11.10-MariaDB-log
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u370401672_areaprivada`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `precio` decimal(12,2) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `adjunto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `concepto`, `precio`, `fecha`, `adjunto`) VALUES
(10, 'gasolina', 60.00, '2025-08-20', '1755849898_4-10-4-10-4.pdf'),
(11, 'ventanas', 60.00, '2025-08-04', '1755689721_66.1NE-16Ar-44.1.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero_factura` varchar(50) NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `descripcion` text DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('pendiente','pagada','atrasada') NOT NULL DEFAULT 'pendiente',
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `id_usuario`, `numero_factura`, `fecha`, `descripcion`, `monto`, `estado`, `pdf`) VALUES
(18, 20, '2025001', '2025-07-15', 'Factura de prueba', 100.00, 'pagada', '001_Cargar y configurar plantilla de máquina en PrefGest.pdf'),
(19, 20, '2025002', '2025-08-19', 'otra factura', 150.00, 'pagada', 'WP2008.1.002 - Etiquetado CE Paso 1.pdf'),
(20, 20, '2025003', '2025-08-19', 'factura otra prueba', 250.00, 'pendiente', 'CORTIZO - Presupuestado, Albaranado, Facturación _Incial_.pdf'),
(21, 20, '2025004', '2025-06-12', 'factura con fecha', 150.00, 'pagada', '4(mate)-14Ar-44.1NE.pdf'),
(23, 20, '2025007', '2025-06-11', 'factura antigua', 200.00, 'atrasada', '4-16-4.pdf'),
(24, 26, '2025010', '2025-08-22', 'Factura nueva', 200.00, 'pendiente', '4(mate)-14Ar-44.1NE.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `id_presupuesto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `numero_presupuesto` varchar(50) NOT NULL,
  `fecha` date DEFAULT curdate(),
  `descripcion` text DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `estado` enum('enviado','aceptado','rechazado') DEFAULT 'enviado',
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `presupuestos`
--

INSERT INTO `presupuestos` (`id_presupuesto`, `id_usuario`, `numero_presupuesto`, `fecha`, `descripcion`, `monto`, `estado`, `pdf`) VALUES
(9, 20, '2025001', '2025-07-28', 'Presupuesto de prueba', 150.00, 'aceptado', 'Guión formaciones de PrefSuite.pdf'),
(11, 21, '2025003', '2025-08-20', 'presupuesto de prueba', 200.00, 'rechazado', 'FAQ0040 - Variables en escandallos.pdf'),
(15, 26, '2025006', '2025-08-22', 'nuevo presupuesto', 200.00, 'enviado', '4-14-4.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido1` varchar(50) NOT NULL,
  `apellido2` varchar(50) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `creado_en` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `apellido1`, `apellido2`, `telefono`, `email`, `usuario`, `contrasena`, `creado_en`) VALUES
(1, 'BaLaAdmin', 'adminbala', NULL, '636481331', 'balaaluminioypvc.sl@gmail.com', 'BaLaAdmin', '$2y$10$RWZd/LZCNNWZ5XSrUtH6oeLEdLwiyBZ/Q71faVYgu9IRjkwjpCRGG', '2025-05-30 16:26:06'),
(20, 'Prueba', 'Prueba', 'Prueba', '678908765', 'prueba@gmail.com', 'Usuario1', '$2y$10$QrjuMkEZOLlaskeskh/yU.EdyuFME5661V9Ji1u7DQxf4RDPjp50G', '2025-08-19 09:59:47'),
(21, 'Prueba2', 'Otra', 'Prueba', '658987456', 'otraprueba@gmail.com', 'Usuario2', '$2y$10$QVqicZGXh5kF52vY7LB/FOgqaO3s5CylXdC1vQdWTvIifAX5QOi2y', '2025-08-20 05:23:18'),
(26, 'Ángel', 'Mejías', 'Figueras', '616212210', 'angelmejiasfigueras2002@gmail.com', 'AngelMejias', '$2y$10$jbYwajBi/xj9AmGtYgYwd.kEp1Ojabyixax65H5ehpyw250JZXVpS', '2025-08-22 08:36:43'),
(34, 'Ander', 'Barrenetxea', 'r', '666555444', 'prueba@gmail.com', 'prueba', '$2y$10$Lkdxs5bwtnq6NLSOSHbW6OV7x3/8fXTxnvZfiuaNrMV2VwTnah.7W', '2025-08-22 11:16:50');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`),
  ADD UNIQUE KEY `unique_numero_factura` (`numero_factura`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`id_presupuesto`),
  ADD UNIQUE KEY `unique_numero_presupuesto` (`numero_presupuesto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `facturas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD CONSTRAINT `presupuestos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
