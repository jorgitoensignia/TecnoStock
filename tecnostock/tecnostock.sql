-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2026 a las 23:24:54
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
(11, '2026-11-19 22:17:02', 'salida', 2, 'Prueba de alerta de stock bajo.', 4, 1),
(12, '2026-11-20 22:40:08', 'entrada', 8, 'Prueba de entrada.', 4, 1),
(13, '2026-11-20 22:40:36', 'entrada', 20, 'Stock inicial', 10, 1),
(14, '2026-11-20 22:40:41', 'salida', 19, 'Ajuste de stock al editar producto', 10, 1),
(15, '2026-11-20 22:40:51', 'entrada', 10, 'WDASDAWD', 10, 1),
(16, '2026-11-20 23:27:32', 'entrada', 1, 'Ajuste de stock al editar producto', 10, 1),
(17, '2026-11-22 15:11:38', 'salida', 8, 'Prueba de venta.', 5, 1),
(18, '2026-11-22 15:12:09', 'entrada', 20, 'Prueba.', 5, 1),
(19, '2026-11-22 16:01:51', 'entrada', 20, 'Stock inicial', 11, 1),
(20, '2026-11-22 16:04:12', 'entrada', 40, 'Stock inicial', 12, 1),
(21, '2026-11-22 16:06:44', 'entrada', 20, 'Stock inicial', 14, 1),
(22, '2026-11-22 16:11:08', 'entrada', 10, 'Stock inicial', 15, 1),
(23, '2026-11-22 16:16:08', 'entrada', 10, 'Stock inicial', 16, 1),
(24, '2026-11-22 16:23:47', 'entrada', 10, 'Stock inicial', 17, 1),
(25, '2026-11-22 16:25:11', 'salida', 2, 'Ajuste de stock al editar producto', 17, 1),
(26, '2026-11-22 16:26:35', 'entrada', 2, '', 17, 1),
(27, '2026-11-22 16:26:56', 'salida', 6, '', 17, 1),
(28, '2026-11-22 16:32:08', 'entrada', 8, 'Stock inicial', 18, 1),
(29, '2026-11-22 16:38:19', 'entrada', 8, 'Stock inicial', 19, 1),
(30, '2026-11-22 16:39:53', 'entrada', 2, 'Aumento de stock.', 19, 1),
(31, '2026-11-22 16:40:20', 'salida', 2, 'Venta de productos.', 19, 1),
(32, '2026-11-22 16:40:39', 'salida', 6, 'Venta de productos.', 19, 1),
(33, '2026-11-22 16:41:06', 'entrada', 10, 'Aumento de stock.', 19, 1),
(34, '2026-11-22 17:21:33', 'entrada', 8, 'Stock inicial', 20, 1),
(35, '2026-11-22 17:24:19', 'entrada', 6, 'Ajuste de stock al editar producto', 17, 1),
(36, '2026-11-22 17:26:14', 'entrada', 8, 'Stock inicial', 22, 1),
(37, '2026-11-22 17:29:30', 'entrada', 8, 'Stock inicial', 25, 1),
(38, '2026-11-22 17:55:54', 'entrada', 2, 'Mas stock.', 22, 1),
(39, '2026-11-22 17:56:58', 'salida', 8, 'Venta de producto.', 22, 1),
(40, '2026-11-22 17:58:11', 'entrada', 10, 'Llegada de nuevo stock.', 22, 1),
(41, '2026-11-22 20:00:02', 'entrada', 8, 'Stock inicial', 26, 1),
(42, '2026-11-22 20:03:16', 'entrada', 8, 'Stock inicial', 27, 1),
(43, '2026-11-22 20:07:20', 'entrada', 10, 'Aumento de stock.', 5, 1),
(44, '2026-11-22 20:07:50', 'salida', 5, 'Venta de producto.', 26, 1),
(45, '2026-11-22 20:09:07', 'salida', 10, 'Venta.', 2, 1),
(46, '2026-11-22 20:09:21', 'salida', 1, 'Otra venta.', 2, 1),
(47, '2026-11-22 20:09:47', 'entrada', 10, 'Aumento de stock.', 2, 1),
(48, '2026-11-22 20:10:15', 'entrada', 10, 'Aumento de stock.', 26, 1),
(49, '2026-11-22 20:15:19', 'entrada', 8, 'Stock inicial', 28, 1),
(50, '2026-11-22 20:18:39', 'entrada', 8, 'Stock inicial', 29, 1),
(51, '2026-11-22 20:22:40', 'entrada', 10, 'Aumento de stock.', 29, 1),
(52, '2026-11-22 20:23:42', 'salida', 16, 'Venta.', 29, 1),
(53, '2026-11-22 20:24:30', 'entrada', 2, '', 29, 1),
(54, '2026-11-22 20:24:42', 'entrada', 2, 'aumento de stock', 29, 1),
(55, '2026-11-22 20:30:47', 'entrada', 8, 'Stock inicial', 30, 1),
(56, '2026-11-22 20:34:16', 'entrada', 10, 'Aumento de stock.', 10, 1),
(57, '2026-11-22 20:34:49', 'salida', 20, 'Venta de producto.', 10, 1),
(58, '2026-11-22 20:35:32', 'salida', 4, 'Venta.', 30, 1),
(59, '2026-11-22 20:36:11', 'entrada', 100, '', 10, 1);

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
(2, 'TEC002', 'Teclado mecánico Redragon K552', 'Teclado mecánico USB con iluminación LED.', 29990.00, 14, 5, 1, '2026-11-19 21:52:23', 4),
(3, 'TEC003', 'Pendrive Kingston 64GB', 'Memoria USB de 64 GB para almacenamiento de archivos.', 6990.00, 30, 10, 1, '2026-11-19 21:54:27', 2),
(4, 'TEC004', 'Cable HDMI 2 metros', 'Cable HDMI para conexión de audio y video.', 4990.00, 11, 5, 1, '2026-11-19 21:55:05', 3),
(5, 'TEC005', 'Audífonos JBL Tune 510BT', 'Audífonos inalámbricos con conexión Bluetooth.', 1.00, 32, 3, 1, '2026-11-19 21:56:06', 5),
(6, 'TEC006', 'Memoria RAM Kingston 8GB DDR4', 'Memoria RAM DDR4 de 8 GB para computador.', 19990.00, 12, 4, 1, '2026-11-19 21:57:27', 6),
(10, 'TEC007', 'Parlante JBL Flip 6 Bluetooth', 'Parlante portátil inalámbrico con conexión Bluetooth, resistencia al agua IP67 y batería de hasta 12 horas.', 89990.00, 102, 4, 1, '2026-11-20 22:40:36', 5),
(11, 'Z0002', 'Z0002', 'producto de prueba', 25000.00, 20, 10, 1, '2026-11-22 16:01:51', 2),
(12, 'Z0005', 'Z0005', 'producto de prueba.', 30000.00, 40, 20, 1, '2026-11-22 16:04:12', 1),
(14, 'Z0004', 'Z0004', 'producto de prueba.', 15000.00, 20, 10, 1, '2026-11-22 16:06:44', 1),
(15, 'Z0001', 'Z0001', 'PRODUCTO DE PRUEBA PARA VIDEO.', 7000.00, 10, 8, 1, '2026-11-22 16:11:08', 1),
(16, 'Z0003', 'Z0003', 'PRODUCTO DE PRUEBA PARA VIDEO.', 10000.00, 10, 6, 1, '2026-11-22 16:16:08', 1),
(17, 'Z0006', 'Z0006', 'Producto de prueba creado para probar el sistema de inventario.', 12000.00, 10, 6, 1, '2026-11-22 16:23:47', 1),
(18, 'Z0008', 'Z0008', 'Producto de prueba para video.', 15000.00, 8, 5, 1, '2026-11-22 16:32:08', 1),
(19, 'Z0009', 'Z0009', 'Producto de prueba para video.', 12000.00, 12, 5, 1, '2026-11-22 16:38:19', 1),
(20, 'Z0007', 'Z0007', 'PRODUCTO DE PRUEBA PARA EL VIDEO.', 15000.00, 8, 5, 1, '2026-11-22 17:21:33', 1),
(22, 'Z00011', 'Z00011', 'Producto de prueba para mi video.', 10000.00, 12, 5, 1, '2026-11-22 17:26:14', 5),
(25, 'Z00010', 'Z00010', 'Prueba dos.', 25000.00, 8, 5, 1, '2026-11-22 17:29:30', 1),
(26, 'ZZZ0', 'ZZZ0', 'Prueba.', 10000.00, 13, 5, 1, '2026-11-22 20:00:02', 4),
(27, 'PRODUCTO02', 'PRODUCTO DE PRUEBA 2', 'PRUEBA.', 10000.00, 8, 5, 0, '2026-11-22 20:03:16', 3),
(28, 'PRODUCTO03', 'PRUEBA DE PRODUCTO', 'Prueba de video.', 25000.00, 8, 5, 1, '2026-11-22 20:15:19', 6),
(29, 'PRODUCTO04', 'PRUEBA DE PRODUCTO', 'PRUEBA DE VIDEO.', 10000.00, 6, 5, 1, '2026-11-22 20:18:39', 2),
(30, 'PRODUCTO01', 'PRODUCTO DE PRUEBA', 'PRUEBA DE VIDEO.', 90000.00, 4, 5, 1, '2026-11-22 20:30:47', 4);

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
