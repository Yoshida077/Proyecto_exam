-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2025 a las 03:42:27
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
-- Base de datos: `gestion_patios`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteRegistro` (IN `registro_id` INT)   BEGIN
    DELETE FROM registros WHERE id = registro_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteVehiculo` (IN `vehiculo_placa` VARCHAR(7))   BEGIN
    DELETE FROM vehiculos WHERE placa = vehiculo_placa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllRegistros` ()   BEGIN
    SELECT r.id, r.vehiculo_placa, v.modelo_id, v.chasis, v.estado, r.tipo, r.fecha, r.detalles, u.nombre as usuario
    FROM registros r
    LEFT JOIN vehiculos v ON r.vehiculo_placa = v.placa
    LEFT JOIN usuarios u ON r.usuario_id = u.id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetAllVehiculos` ()   BEGIN
    SELECT 
        v.placa, 
        v.chasis, 
        v.estado, 
        m.nombre AS modelo, 
        ma.nombre AS marca, 
        p.nombre AS propietario
    FROM vehiculos v
    LEFT JOIN modelos m ON v.modelo_id = m.id
    LEFT JOIN marcas ma ON m.marca_id = ma.id
    LEFT JOIN propietarios p ON v.propietario_cedula = p.cedula;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetRegistroById` (IN `registro_id` INT)   BEGIN
    SELECT * FROM registros WHERE id = registro_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetVehiculoByPlaca` (IN `vehiculo_placa` VARCHAR(7))   BEGIN
    SELECT * FROM vehiculos WHERE placa = vehiculo_placa;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertRegistro` (IN `vehiculo_placa` VARCHAR(7), IN `tipo` ENUM('Liberación','Baja','Custodia'), IN `detalles` TEXT, IN `usuario_id` INT)   BEGIN
    INSERT INTO registros (vehiculo_placa, tipo, detalles, usuario_id)
    VALUES (vehiculo_placa, tipo, detalles, usuario_id);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertVehiculo` (IN `vehiculo_placa` VARCHAR(7), IN `vehiculo_modelo_id` INT, IN `vehiculo_chasis` VARCHAR(50), IN `vehiculo_cant_puertas` INT, IN `vehiculo_propietario_cedula` VARCHAR(10), IN `vehiculo_estado` VARCHAR(20))   BEGIN
    INSERT INTO vehiculos (placa, modelo_id, chasis, cant_puertas, propietario_cedula, estado)
    VALUES (vehiculo_placa, vehiculo_modelo_id, vehiculo_chasis, vehiculo_cant_puertas, vehiculo_propietario_cedula, vehiculo_estado);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertVehiculoRegistro` (IN `vehiculo_placa` VARCHAR(7), IN `tipo` ENUM('Liberación','Baja','Custodia'), IN `detalles` TEXT, IN `usuario_id` INT, IN `infraccion_id` INT, IN `patio_id` INT)   BEGIN
    -- Insertar en registros
    INSERT INTO registros (vehiculo_placa, tipo, detalles, usuario_id) 
    VALUES (vehiculo_placa, tipo, detalles, usuario_id);

    -- Registrar la infracción si existe
    IF infraccion_id IS NOT NULL THEN
        INSERT INTO vehiculo_infraccion (vehiculo_placa, infraccion_id, fecha) 
        VALUES (vehiculo_placa, infraccion_id, NOW());
    END IF;

    -- Asignar el vehículo a un patio si existe
    IF patio_id IS NOT NULL THEN
        INSERT INTO vehiculo_patio (vehiculo_placa, patio_id, fecha_ingreso) 
        VALUES (vehiculo_placa, patio_id, NOW());
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateRegistro` (IN `reg_id` INT, IN `reg_detalles` TEXT, IN `reg_fecha_salida` DATETIME)   BEGIN
    -- Si la fecha de salida es NULL, solo actualiza detalles en registros
    IF reg_fecha_salida IS NULL THEN
        UPDATE registros 
        SET detalles = reg_detalles
        WHERE id = reg_id;
    ELSE
        -- Si se proporciona fecha de salida, actualizar detalles
        UPDATE registros 
        SET detalles = reg_detalles
        WHERE id = reg_id;

        -- Actualizar la fecha_salida en vehiculo_patio
        UPDATE vehiculo_patio 
        SET fecha_salida = reg_fecha_salida
        WHERE vehiculo_placa = (SELECT vehiculo_placa FROM registros WHERE id = reg_id)
        AND fecha_salida IS NULL;

        -- Cambiar el estado del vehículo a 'inactivo' (0)
        UPDATE vehiculos 
        SET estado = 'Inactivo'
        WHERE placa = (SELECT vehiculo_placa FROM registros WHERE id = reg_id);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateVehiculo` (IN `vehiculo_placa` VARCHAR(7), IN `vehiculo_modelo_id` INT, IN `vehiculo_chasis` VARCHAR(50), IN `vehiculo_cant_puertas` INT, IN `vehiculo_propietario_cedula` VARCHAR(10), IN `vehiculo_estado` VARCHAR(20))   BEGIN
    UPDATE vehiculos 
    SET modelo_id = vehiculo_modelo_id, 
        chasis = vehiculo_chasis, 
        cant_puertas = vehiculo_cant_puertas, 
        propietario_cedula = vehiculo_propietario_cedula, 
        estado = vehiculo_estado
    WHERE placa = vehiculo_placa;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `infracciones`
--

CREATE TABLE `infracciones` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `multa` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `infracciones`
--

INSERT INTO `infracciones` (`id`, `descripcion`, `multa`) VALUES
(1, 'Exceso de velocidad', 500.00),
(2, 'mal estacionado', 250.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`) VALUES
(6, 'Chery'),
(5, 'Nissan');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelos`
--

CREATE TABLE `modelos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `marca_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelos`
--

INSERT INTO `modelos` (`id`, `nombre`, `marca_id`) VALUES
(3, 'X-trail', 5),
(4, 'Tiggo2', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `patios`
--

CREATE TABLE `patios` (
  `id` int(11) NOT NULL,
  `codigo` varchar(10) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `capacidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `patios`
--

INSERT INTO `patios` (`id`, `codigo`, `direccion`, `capacidad`) VALUES
(1, '0001', 'San isidro', 500);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `nombre`) VALUES
(11, 'crear_infraccion'),
(22, 'crear_marca'),
(26, 'crear_modelo'),
(40, 'crear_patio'),
(33, 'crear_propietario'),
(18, 'crear_registro'),
(7, 'crear_vehiculo'),
(12, 'editar_infraccion'),
(23, 'editar_marca'),
(27, 'editar_modelo'),
(41, 'editar_patio'),
(34, 'editar_propietario'),
(19, 'editar_registro'),
(8, 'editar_vehiculo'),
(13, 'eliminar_infraccion'),
(24, 'eliminar_marca'),
(28, 'eliminar_modelo'),
(42, 'eliminar_patio'),
(35, 'eliminar_propietario'),
(20, 'eliminar_registro'),
(9, 'eliminar_vehiculo'),
(5, 'gestionar_infracciones'),
(21, 'gestionar_marcas'),
(25, 'gestionar_modelos'),
(6, 'gestionar_patios'),
(4, 'gestionar_propietarios'),
(3, 'gestionar_registros'),
(2, 'gestionar_vehiculos'),
(1, 'ver_dashboard'),
(10, 'ver_infracciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `propietarios`
--

CREATE TABLE `propietarios` (
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `propietarios`
--

INSERT INTO `propietarios` (`cedula`, `nombre`, `apellido`, `telefono`, `email`) VALUES
('1721970522', 'Juan', 'Perez', '023456789', 'jperez@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `vehiculo_placa` varchar(7) DEFAULT NULL,
  `tipo` enum('Liberación','Baja','Custodia') NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `detalles` text DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `registros`
--

INSERT INTO `registros` (`id`, `vehiculo_placa`, `tipo`, `fecha`, `detalles`, `usuario_id`) VALUES
(3, 'pdc123', 'Liberación', '2025-02-06 01:56:23', '123', 4),
(4, 'ppp123', 'Custodia', '2025-02-06 02:31:05', 'es liberado', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(3, 'Cliente'),
(2, 'Operador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol_permiso`
--

CREATE TABLE `rol_permiso` (
  `rol_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol_permiso`
--

INSERT INTO `rol_permiso` (`rol_id`, `permiso_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 33),
(1, 34),
(1, 35),
(1, 40),
(1, 41),
(1, 42),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 7),
(2, 8),
(2, 9),
(2, 18),
(2, 19),
(2, 20),
(2, 33),
(2, 34),
(2, 35),
(3, 1),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol_id`) VALUES
(4, 'Admin', 'admin@example.com', '$2y$10$bQgI5TTgDoF6J0amNMaU3eYR7nqv5y9zx8optWSYOS97446.xHAzq', 1),
(5, 'Juan', 'jperez@gmail.com', '$2y$10$JrCmCVMqzXFUNOlUCGUkc.OXSijlGwz2ScbFmW1I5ep8mdydfc2V.', 2),
(6, 'Jhonnathan', 'chalapujhonnatan@gmail.com', '$2y$10$mO/1Hxf/r1.9C23aLaOBKuItpUcp0UWC1.pSe6iJFaLtpbYZHyjFq', 3),
(7, 'Juan Cevallos', 'jcevallos@gmail.com', '$2y$10$vI.EjaqLWxe5cMOgvRCuFOo.FaHhZNUqeq/PGebrIsVvbtAIGzwq2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculos`
--

CREATE TABLE `vehiculos` (
  `placa` varchar(7) NOT NULL,
  `modelo_id` int(11) DEFAULT NULL,
  `chasis` varchar(50) NOT NULL,
  `cant_puertas` int(11) NOT NULL,
  `propietario_cedula` varchar(10) DEFAULT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculos`
--

INSERT INTO `vehiculos` (`placa`, `modelo_id`, `chasis`, `cant_puertas`, `propietario_cedula`, `estado`) VALUES
('pdc123', 3, '1213212', 5, '1721970522', '1'),
('ppp123', 4, '12312313123', 5, '1721970522', 'Inactivo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_infraccion`
--

CREATE TABLE `vehiculo_infraccion` (
  `vehiculo_placa` varchar(7) NOT NULL,
  `infraccion_id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_infraccion`
--

INSERT INTO `vehiculo_infraccion` (`vehiculo_placa`, `infraccion_id`, `fecha`) VALUES
('pdc123', 1, '2025-02-06 01:56:23'),
('ppp123', 2, '2025-02-06 02:31:05');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_patio`
--

CREATE TABLE `vehiculo_patio` (
  `vehiculo_placa` varchar(7) NOT NULL,
  `patio_id` int(11) NOT NULL,
  `fecha_ingreso` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_salida` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_patio`
--

INSERT INTO `vehiculo_patio` (`vehiculo_placa`, `patio_id`, `fecha_ingreso`, `fecha_salida`) VALUES
('pdc123', 1, '2025-02-06 01:56:23', NULL),
('ppp123', 1, '2025-02-06 02:31:05', '2025-02-08 02:31:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `infracciones`
--
ALTER TABLE `infracciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marca_id` (`marca_id`);

--
-- Indices de la tabla `patios`
--
ALTER TABLE `patios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `propietarios`
--
ALTER TABLE `propietarios`
  ADD PRIMARY KEY (`cedula`);

--
-- Indices de la tabla `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_placa` (`vehiculo_placa`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD PRIMARY KEY (`rol_id`,`permiso_id`),
  ADD KEY `permiso_id` (`permiso_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD PRIMARY KEY (`placa`),
  ADD KEY `modelo_id` (`modelo_id`),
  ADD KEY `propietario_cedula` (`propietario_cedula`);

--
-- Indices de la tabla `vehiculo_infraccion`
--
ALTER TABLE `vehiculo_infraccion`
  ADD PRIMARY KEY (`vehiculo_placa`,`infraccion_id`,`fecha`),
  ADD KEY `infraccion_id` (`infraccion_id`);

--
-- Indices de la tabla `vehiculo_patio`
--
ALTER TABLE `vehiculo_patio`
  ADD PRIMARY KEY (`vehiculo_placa`,`patio_id`,`fecha_ingreso`),
  ADD KEY `patio_id` (`patio_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `infracciones`
--
ALTER TABLE `infracciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `modelos`
--
ALTER TABLE `modelos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `patios`
--
ALTER TABLE `patios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `modelos_ibfk_1` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`vehiculo_placa`) REFERENCES `vehiculos` (`placa`) ON DELETE CASCADE,
  ADD CONSTRAINT `registros_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `rol_permiso`
--
ALTER TABLE `rol_permiso`
  ADD CONSTRAINT `rol_permiso_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rol_permiso_ibfk_2` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `vehiculos`
--
ALTER TABLE `vehiculos`
  ADD CONSTRAINT `vehiculos_ibfk_1` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculos_ibfk_3` FOREIGN KEY (`propietario_cedula`) REFERENCES `propietarios` (`cedula`) ON DELETE SET NULL;

--
-- Filtros para la tabla `vehiculo_infraccion`
--
ALTER TABLE `vehiculo_infraccion`
  ADD CONSTRAINT `vehiculo_infraccion_ibfk_1` FOREIGN KEY (`vehiculo_placa`) REFERENCES `vehiculos` (`placa`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculo_infraccion_ibfk_2` FOREIGN KEY (`infraccion_id`) REFERENCES `infracciones` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `vehiculo_patio`
--
ALTER TABLE `vehiculo_patio`
  ADD CONSTRAINT `vehiculo_patio_ibfk_1` FOREIGN KEY (`vehiculo_placa`) REFERENCES `vehiculos` (`placa`) ON DELETE CASCADE,
  ADD CONSTRAINT `vehiculo_patio_ibfk_2` FOREIGN KEY (`patio_id`) REFERENCES `patios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
