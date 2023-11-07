-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-11-2023 a las 20:58:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oswa_inv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actas`
--

CREATE TABLE `actas` (
  `id` int(11) UNSIGNED NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `ticket` varchar(50) NOT NULL,
  `nombrearchivo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `actas`
--

INSERT INTO `actas` (`id`, `titulo`, `ticket`, `nombrearchivo`) VALUES
(2, '2174', '2174', 'Tarjeta SD.PNG'),
(8, 'Prueba', 'Prueba', 'PLAN DE MEJORAMIENTO SOCIAL HUMANISTA 6° - SEGUNDO TRIMESTRE  (1).pdf'),
(9, 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA DE RIESGO.pdf', '', ''),
(10, '1442', '1442', 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA DE RIESGO.pdf'),
(11, '1442', '1442', 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA DE RIESGO.pdf'),
(12, '1442', '1442', 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA DE RIESGO.pdf'),
(13, 'JavaScriptNotesForProfessionals.pdf', '', ''),
(14, '745', '745', 'JavaScriptNotesForProfessionals.pdf'),
(15, '1442', '1442', 'JavaScriptNotesForProfessionals.pdf'),
(16, 'PLAN DE MEJORAMIENTO SOCIAL HUMANISTA 6° - SEGUNDO TRIMESTRE .pdf', '', ''),
(17, '555', '555', 'PLAN DE MEJORAMIENTO SOCIAL HUMANISTA 6° - SEGUNDO TRIMESTRE .pdf'),
(18, '1111', '1111', 'JavaScriptNotesForProfessionals.pdf'),
(19, '2222', '2222', 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA DE RIESGO.pdf'),
(20, '1442', '1442', 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA DE RIESGO.pdf'),
(21, 'CUN - Sitio Web _ Pago.pdf', '', ''),
(22, '0000', '0000', 'CUN - Sitio Web _ Pago.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Disco Duro'),
(5, 'Prueba1'),
(1, 'Repuestos'),
(3, 'Teclado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) UNSIGNED NOT NULL,
  `producto` int(11) UNSIGNED NOT NULL,
  `quantity` int(50) NOT NULL,
  `categorie_id` int(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `ubicacion_id` varchar(50) NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`id`, `name`) VALUES
(3, 'Dañado'),
(2, 'Disponible'),
(4, 'Prestamo'),
(5, 'Repuestos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `kardex`
--

CREATE TABLE `kardex` (
  `id` int(11) UNSIGNED NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(255) NOT NULL,
  `movimiento` varchar(50) NOT NULL,
  `entrada` varchar(50) NOT NULL,
  `salida` varchar(50) NOT NULL,
  `stock` varchar(50) NOT NULL,
  `estados` varchar(50) NOT NULL,
  `ubicacion_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `kardex`
--

INSERT INTO `kardex` (`id`, `codigo`, `date`, `name`, `movimiento`, `entrada`, `salida`, `stock`, `estados`, `ubicacion_id`) VALUES
(3, '7797', '2023-11-03 18:20:44', 'Teclado Genius', 'ENT  150823', '20', '-', '20', 'Disponible', ''),
(4, '694', '2023-11-03 18:21:54', 'Disco Duro', 'ENT  002', '50', '-', '50', 'Prestamo', ''),
(10, '7797', '2023-11-03 20:09:01', '', 'SAL 7208', '-', '1', '19', 'Disponible', 'Bodega TI-1'),
(11, '5723', '2023-11-03 20:19:33', 'repuestos', 'ENT  009', '20', '-', '20', 'Dañado', ''),
(12, '7797', '2023-11-03 21:43:02', '', 'SAL 9735', '-', '1', '18', 'Prestamo', 'Bodega TI-1'),
(13, '7797', '2023-11-07 16:39:31', '', 'SAL 9029', '-', '1', '17', 'Prestamo', 'Bodega TI-1'),
(16, '7797', '2023-11-07 16:44:32', '', 'SAL 6806', '-', '1', '16', 'Dañado', 'Bodega TI-1'),
(17, '7797', '2023-11-07 16:49:44', '', 'SAL 1165', '-', '1', '15', 'Dañado', 'Bodega TI-1'),
(18, '7797', '2023-11-07 16:51:43', '', 'SAL 3546', '-', '1', '14', 'Dañado', 'Bodega TI-1'),
(19, '7797', '2023-11-07 16:58:24', '', 'SAL 1362', '-', '1', '13', 'Dañado', 'Bodega TI-1'),
(20, '7797', '2023-11-07 17:00:40', '', 'SAL 4469', '-', '1', '12', 'Dañado', 'Bodega TI-1'),
(21, '7797', '2023-11-07 17:01:46', '', 'SAL 4444', '-', '1', '11', 'Dañado', 'Bodega TI-1'),
(22, '7797', '2023-11-07 17:04:01', '', 'SAL 7907', '-', '1', '10', 'Dañado', 'Bodega TI-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `file_name`, `file_type`) VALUES
(2, 'Portatil ThinkPad.PNG', 'image/png'),
(6, 'prueba.jpeg', 'image/jpeg'),
(7, 'PLAN DE MEJORAMIENTO SOCIAL HUMANISTA 6° - SEGUNDO TRIMESTRE  (1).pdf', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `factura` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `categorie_id` int(11) UNSIGNED NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `ubicacion_id` varchar(50) NOT NULL,
  `media_id` int(11) DEFAULT 0,
  `date` datetime NOT NULL,
  `entrada` varchar(50) NOT NULL,
  `movimiento` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `estados` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `stock` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `codigo`, `factura`, `name`, `quantity`, `categorie_id`, `modelo`, `serie`, `ubicacion_id`, `media_id`, `date`, `entrada`, `movimiento`, `estado`, `estados`, `usuario`, `stock`) VALUES
(5, '7797', '150823', 'Teclado Genius', '10', 3, 'F2000', 'A000250492', 'Bodega TI-1', 2, '2023-11-03 18:20:44', '20', 'ENT  150823', '1', 'Disponible', 'Admin Users', '10'),
(6, '694', '002', 'Disco Duro', '50', 4, '2502', 'A000250212', 'Bodega TI-1', 2, '2023-11-03 18:21:54', '50', 'ENT  002', '1', 'Prestamo', 'Admin Users', ''),
(7, '5723', '009', 'repuestos', '20', 1, '2589', 'A000250212', 'Bodega TI-2', 2, '2023-11-03 20:19:33', '20', 'ENT  009', '1', 'Dañado', 'Admin Users', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) UNSIGNED NOT NULL,
  `ticket` varchar(50) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `serie` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` decimal(25,2) NOT NULL,
  `date` date NOT NULL,
  `tecnico` varchar(60) NOT NULL,
  `departamento` varchar(50) NOT NULL,
  `colaborador` varchar(50) NOT NULL,
  `movimiento` varchar(50) NOT NULL,
  `ubicacion` varchar(50) NOT NULL,
  `estados` varchar(50) NOT NULL,
  `nombrearchivo` varchar(50) NOT NULL,
  `cant_sal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `ticket`, `codigo`, `modelo`, `serie`, `qty`, `price`, `date`, `tecnico`, `departamento`, `colaborador`, `movimiento`, `ubicacion`, `estados`, `nombrearchivo`, `cant_sal`) VALUES
(1, '', '7797', 'h020202q', 'JJFR220211', 1, 0.00, '2023-11-03', 'Jennifer Lozano', 'Financiera', 'Nelsy Plazas', 'SAL 7208', 'Bodega TI-1', 'Disponible', 'Tarjeta SD.PNG', '1'),
(4, '', '7797', 'Prueba', 'Prueba', 1, 0.00, '2023-11-03', 'Prueba', 'Prueba', 'Prueba', 'SAL 9735', 'Bodega TI-1', 'Prestamo', 'PLAN DE MEJORAMIENTO SOCIAL HUMANISTA 6° - SEGUNDO', '1'),
(5, '1442', '7797', 'h020202q', 'JJFR220211', 1, 0.00, '2023-11-07', 'Daniel Rueda', 'Produccion Textil', 'Diego Medina', 'SAL 9029', 'Bodega TI-1', 'Prestamo', 'EXONERACION DE RESPONSABILIDAD Y ASUNCION EXPRESA ', '1'),
(6, '745', '7797', '250212', '250212', 1, 0.00, '2023-11-07', 'Jennifer Lozano', 'Financiera', 'Nelsy Plazas', 'SAL 6806', 'Bodega TI-1', 'Dañado', 'JavaScriptNotesForProfessionals.pdf', '1'),
(7, '1442', '7797', 'h020202q', '250212', 1, 0.00, '2023-11-07', 'Daniel Rueda', 'Logistica', 'Angie Medina', 'SAL 1165', 'Bodega TI-1', 'Dañado', 'JavaScriptNotesForProfessionals.pdf', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ubicaciones`
--

CREATE TABLE `ubicaciones` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `ubicacion_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `ubicaciones`
--

INSERT INTO `ubicaciones` (`id`, `name`, `ubicacion_id`) VALUES
(1, 'Repuestos', ''),
(2, 'Bodega TI-1', ''),
(4, 'Bodega TI-2', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_level` int(11) NOT NULL,
  `image` varchar(255) DEFAULT 'no_image.jpg',
  `status` int(1) NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `user_level`, `image`, `status`, `last_login`) VALUES
(1, 'Admin Users', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 1, 'c3w574i1.PNG', 1, '2023-11-07 14:42:57'),
(2, 'Special User', 'special', 'ba36b97a41e7faf742ab09bf88405ac04f99599a', 2, 'no_image.jpg', 1, '2017-06-16 07:11:26'),
(3, 'Default User', 'user', '12dea96fec20593566ab75692c9949596833adc9', 3, 'no_image.jpg', 1, '2017-06-16 07:11:03'),
(10, 'Jennifer Mayorga', 'J.Mayorga', '7c4a8d09ca3762af61e59520943dc26494f8941b', 2, 'no_image.jpg', 1, '2023-11-07 14:21:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(150) NOT NULL,
  `group_level` int(11) NOT NULL,
  `group_status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `group_level`, `group_status`) VALUES
(1, 'Admin', 1, 1),
(2, 'Special', 2, 1),
(3, 'User', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actas`
--
ALTER TABLE `actas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`) USING BTREE;

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto` (`producto`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `kardex`
--
ALTER TABLE `kardex`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `media_id` (`media_id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `user_level` (`user_level`);

--
-- Indices de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_level` (`group_level`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actas`
--
ALTER TABLE `actas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `kardex`
--
ALTER TABLE `kardex`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ubicaciones`
--
ALTER TABLE `ubicaciones`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `entradas`
--
ALTER TABLE `entradas`
  ADD CONSTRAINT `SK_entradas` FOREIGN KEY (`producto`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SK_entradasdos` FOREIGN KEY (`id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_products` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_user` FOREIGN KEY (`user_level`) REFERENCES `user_groups` (`group_level`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
