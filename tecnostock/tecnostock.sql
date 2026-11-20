-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2026 a las 23:47:55
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnostock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre`, `descripcion`, `estado`) VALUES
(1, 'Accesorios', 'Accesorios tecnologicos', 1),
(2, 'Almacenamiento', 'Discos y memorias', 1),
(3, 'Conectividad', 'Cables y adaptadores', 1),
(4, 'Perifericos', 'Teclados y mouse', 1),
(5, 'Audio', 'Audifonos y parlantes', 1),
(6, 'Computacion', 'Componentes computacionales', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE `movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('entrada','salida') NOT NULL,
  `cantidad` int(11) NOT NULL,
  `observacion` varchar(255) DEFAULT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_movimiento`, `fecha_hora`, `tipo`, `cantidad`, `observacion`, `id_producto`, `id_usuario`) VALUES
(1, '2026-11-19 21:45:02', 'entrada', 25, 'Stock inicial', 1, 1),
(2, '2026-11-19 21:52:23', 'entrada', 15, 'Stock inicial', 2, 1),
(3, '2026-11-19 21:54:27', 'entrada', 30, 'Stock inicial', 3, 1),
(4, '2026-11-19 21:55:05', 'entrada', 3, 'Stock inicial', 4, 1),
(5, '2026-11-19 21:56:06', 'entrada', 10, 'Stock inicial', 5, 1),
(6, '2026-11-19 21:57:27', 'entrada', 12, 'Stock inicial', 6, 1),
(7, '2026-11-19 22:05:26', 'entrada', 10, 'Reposición de mercadería.', 1, 1),
(8, '2026-11-19 22:06:04', 'salida', 7, 'Venta de productos.', 1, 1),
(9, '2026-11-19 22:15:16', 'entrada', 7, '', 4, 1),
(10, '2026-11-19 22:16:26', 'salida', 5, 'Prueba de límite de stock mínimo.', 4, 1),
(11, '2026-11-19 22:17:02', 'salida', 2, 'Prueba de alerta de stock bajo.', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock_actual` int(11) NOT NULL DEFAULT 0,
  `stock_minimo` int(11) NOT NULL DEFAULT 0,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_registro` timestamp NULL DEFAULT current_timestamp(),
  `id_categoria` int(11) NOT NULL
) ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `codigo`, `nombre`, `descripcion`, `precio`, `stock_actual`, `stock_minimo`, `estado`, `fecha_registro`, `id_categoria`) VALUES
(1, 'TEC001', 'Mouse inalámbrico Logitech M185', 'Mouse inalámbrico USB de 2.4 GHz, color negro.', 13990.00, 28, 8, 1, '2026-11-19 21:45:02', 4),
(2, 'TEC002', 'Teclado mecánico Redragon K552', 'Teclado mecánico USB con iluminación LED.', 29990.00, 15, 5, 1, '2026-11-19 21:52:23', 4),
(3, 'TEC003', 'Pendrive Kingston 64GB', 'Memoria USB de 64 GB para almacenamiento de archivos.', 6990.00, 30, 10, 1, '2026-11-19 21:54:27', 2),
(4, 'TEC004', 'Cable HDMI 2 metros', 'Cable HDMI para conexión de audio y video.', 4990.00, 3, 5, 1, '2026-11-19 21:55:05', 3),
(5, 'TEC005', 'Audífonos JBL Tune 510BT', 'Audífonos inalámbricos con conexión Bluetooth.', 39990.00, 10, 3, 0, '2026-11-19 21:56:06', 5),
(6, 'TEC006', 'Memoria RAM Kingston 8GB DDR4', 'Memoria RAM DDR4 de 8 GB para computador.', 19990.00, 12, 4, 1, '2026-11-19 21:57:27', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `clave`, `estado`) VALUES
(1, 'Administrador', 'admin@tecnostock.cl', '$2y$12$GdUBHjkbA/EUjTrSkK/xT.CNpKXrLJUkvNlTNBRzsIbj8UPIqyeMu', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
