-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-10-2025 a las 19:26:10
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

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
(32, 39, '2025001', '2025-07-16', 'Ventanas correderas para sótano', 250.00, 'atrasada', 'Presupuesto-2025-07-08-PRESUPUESTOS00000109.pdf'),
(33, 40, '2025002', '2025-09-08', 'Puertas para el porche', 550.00, 'pagada', 'Presupuesto-2025-07-08-PRESUPUESTOS00000109.pdf'),
(34, 39, '2025003', '2025-06-19', 'Puertas para el jardín', 678.00, 'pagada', 'Presupuesto-2025-07-08-PRESUPUESTOS00000109.pdf'),
(35, 38, '2025004', '2025-04-17', 'Ventanas correderas cocina', 150.00, 'atrasada', 'Presupuesto-2025-07-08-PRESUPUESTOS00000109.pdf'),
(36, 38, '2025005', '2025-09-22', 'Cerramiento de porche', 340.00, 'pendiente', 'Presupuesto-2025-07-08-PRESUPUESTOS00000109.pdf');

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
(19, 39, '2025001', '2025-09-11', 'Presupuesto ventanas correderas sótano', 50.00, 'enviado', 'presupuesto (2).pdf'),
(21, 38, '2025003', '2025-09-18', 'Presupuesto de puertas porche', 550.00, 'enviado', 'presupuesto (2).pdf'),
(22, 38, '2025004', '2025-08-22', 'Presupuesto puertas de jardín', 300.00, 'aceptado', 'presupuesto (2).pdf'),
(23, 40, '2025005', '2025-09-19', 'Presupuesto para puertas del patio', 560.00, 'aceptado', 'presupuesto (2).pdf');

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
(38, 'Miguel Ángel', 'Ballesteros', 'Huelves', '678543456', 'miguelangel1992@gmail.com', 'MiguelAngel', '$2y$10$ZB2xfIHpCD.flQ5RExqfGOOAdw9hy6zZO/OUVcqU0Tyjrd6aaItlG', '2025-09-18 17:06:22'),
(39, 'Ángel', 'Mejías', 'Figueras', '616212210', 'angelmejiasfigueras2002@gmail.com', 'AngelMejias', '$2y$10$jCtMvoBgaoQ0i5e5/g/q6uWjV.OCtw6RZzSYuZan1h9QYgwFFXUVy', '2025-09-18 17:07:26'),
(40, 'Jessica', 'Mejías', 'Figueras', '658251345', 'jessicamejias1992@gmail.com', 'JessicaMejias', '$2y$10$Pm.A/DlZgNjgFYTcp/CNweBtwEE.sYhzHb7QwEme6m308nr7oX4zi', '2025-09-18 17:09:38');

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
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  MODIFY `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
