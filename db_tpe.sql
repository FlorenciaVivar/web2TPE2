-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2022 a las 01:35:41
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_tpe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aerolinea`
--

CREATE TABLE `aerolinea` (
  `id_aerolinea` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `imagenAerolinea` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `aerolinea`
--

INSERT INTO `aerolinea` (`id_aerolinea`, `nombre`, `imagenAerolinea`) VALUES
(4, 'Qatar Airways', 'imgs/aerolineas/634d9c97cea37.jpg'),
(6, 'Iberia', 'imgs/aerolineas/634cbd76d62bb.jpg'),
(7, 'Latam Airlines', 'imgs/aerolineas/634cbd6c92603.jpg'),
(15, 'air france', 'imgs/aerolineas/634cbd5c841db.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paquete`
--

CREATE TABLE `paquete` (
  `id_paquete` int(11) NOT NULL,
  `destino` varchar(100) NOT NULL,
  `hotel` varchar(100) NOT NULL,
  `comida` varchar(100) NOT NULL,
  `fecha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paquete`
--

INSERT INTO `paquete` (`id_paquete`, `destino`, `hotel`, `comida`, `fecha`) VALUES
(1, 'Barcelona', 'Mulen Hotel', 'Todo Incluido', '01/01/23'),
(2, 'Cancun', 'Mulen Hotel', 'Desayuno', '01/01/23'),
(3, 'Hawai', 'Mulen Hotel', 'Cena', '01/01/23'),
(5, 'Mar del plata', 'Mulen Hotel', 'Cena', '01/01/23'),
(7, 'Tandil', 'Mulen Hotel', 'Cena', '01/01/23'),
(8, 'Buenos Aires', 'Libertador Hotel', 'Merienda', '01/01/23'),
(9, 'Buenos Aires', 'Libertador Hotel', 'Merienda', '01/10/24'),
(10, 'Buenos Aires', 'Qatar Hotel', 'Cena', '01/10/24'),
(11, 'Paris', 'Mulen Hotel', 'Cena', '01/01/23'),
(12, 'Paris', 'Mulen Hotel', 'Cena', '01/01/23'),
(13, 'Paris', 'Mulen Hotel', 'Cena', '01/01/23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.com', '$2a$12$.DU7ULIWYZYllVACZyfsLOiCcVE9Aw4FKxz4J2tqMB.xkDBZh5o3e');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viaje`
--

CREATE TABLE `viaje` (
  `id` int(11) NOT NULL,
  `destino` varchar(200) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `precio` int(200) NOT NULL,
  `imagenViaje` varchar(500) NOT NULL,
  `descripcionDestino` varchar(500) NOT NULL,
  `id_aerolinea_fk` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `viaje`
--

INSERT INTO `viaje` (`id`, `destino`, `fecha`, `precio`, `imagenViaje`, `descripcionDestino`, `id_aerolinea_fk`) VALUES
(50, 'Barcelona', '12/5/22', 150000, 'imgs/viajes/635300992ace8.jpg', 'Cancún está ubicado en la esquina noreste de la Península de Yucatán en México. Esta ciudad está situada en la costa del Mar Caribe a 11 metros por encima del nivel del mar, a 21.17 grados de latitud y a -86.85 de longitud.', 7),
(51, 'Barcelona', '12/5/22', 150000, 'imgs/viajes/635300b805653.jpg', 'Cancún está ubicado en la esquina noreste de la Península de Yucatán en México. Esta ciudad está situada en la costa del Mar Caribe a 11 metros por encima del nivel del mar, a 21.17 grados de latitud y a -86.85 de longitud.', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aerolinea`
--
ALTER TABLE `aerolinea`
  ADD PRIMARY KEY (`id_aerolinea`);

--
-- Indices de la tabla `paquete`
--
ALTER TABLE `paquete`
  ADD PRIMARY KEY (`id_paquete`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_aerolinea_fk` (`id_aerolinea_fk`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aerolinea`
--
ALTER TABLE `aerolinea`
  MODIFY `id_aerolinea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `paquete`
--
ALTER TABLE `paquete`
  MODIFY `id_paquete` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `viaje`
--
ALTER TABLE `viaje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `viaje`
--
ALTER TABLE `viaje`
  ADD CONSTRAINT `viaje_ibfk_1` FOREIGN KEY (`id_aerolinea_fk`) REFERENCES `aerolinea` (`id_aerolinea`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
