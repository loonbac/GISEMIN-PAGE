-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-02-2026 a las 23:39:48
-- Versión del servidor: 10.11.13-MariaDB-0ubuntu0.24.04.1
-- Versión de PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `laravel`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

-- CREATE TABLE `certificados` (
--   `id` bigint(20) UNSIGNED NOT NULL,
--   `nombre` varchar(255) NOT NULL,
--   `dni` varchar(255) NOT NULL,
--   `curso` varchar(255) NOT NULL,
--   `fecha_emision` date NOT NULL,
--   `codigo` varchar(255) NOT NULL,
--   `fecha_vencimiento` date DEFAULT NULL,
--   `estado` enum('vigente','expirado','cancelado') NOT NULL DEFAULT 'vigente',
--   `drive_link` varchar(255) DEFAULT NULL,
--   `observaciones` text DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `certificados`
--

INSERT INTO `certificados` (`id`, `nombre`, `dni`, `curso`, `fecha_emision`, `codigo`, `fecha_vencimiento`, `estado`, `drive_link`, `observaciones`, `created_at`, `updated_at`) VALUES
(40, 'dsa', '31231', 'Derechos y obligaciones del trabajador en SST', '2026-02-06', 'CERT-2026-026275', '2027-02-06', 'vigente', NULL, NULL, '2026-02-06 18:59:28', '2026-02-06 20:29:35'),
(41, 'dsa', '31231', 'Brigadas de Emergencia', '2026-02-06', 'CERT-2026-3F00B3', '2027-02-06', 'vigente', NULL, NULL, '2026-02-06 18:59:31', '2026-02-06 18:59:31'),
(42, 'dsa', '31231', 'Búsqueda y Rescate Básico', '2026-02-06', 'CERT-2026-8EA0B9', '2027-02-06', 'vigente', NULL, NULL, '2026-02-06 18:59:36', '2026-02-06 18:59:36'),
(43, 'dsa', '31231', 'Bioseguridad', '2026-02-06', 'CERT-2026-857A99', '2027-02-06', 'vigente', NULL, NULL, '2026-02-06 19:08:08', '2026-02-06 19:08:08'),
(44, 'dsa', '31231', 'Estrés laboral', '2026-02-06', 'CERT-2026-6ED2CC', '2027-02-06', 'vigente', NULL, NULL, '2026-02-06 19:08:22', '2026-02-06 20:29:50'),
(45, 'dsa', '31231', 'Comité de SST / Supervisor de SST', '2026-02-06', 'CERT-2026-9055DF', '2027-02-06', 'vigente', NULL, NULL, '2026-02-06 19:14:33', '2026-02-06 19:14:33'),
(46, 'dsa', '31231', 'Control de Hemorragias', '2024-12-02', 'CERT-2026-CDA4DB', '2025-12-02', 'vigente', NULL, NULL, '2026-02-06 19:18:36', '2026-02-06 20:36:06'),
(47, 'dsa', '31231', 'Control de Derrames', '2024-12-02', 'CERT-2026-F78AAB', '2025-12-02', 'vigente', NULL, NULL, '2026-02-06 19:18:39', '2026-02-06 20:32:07'),
(48, 'dsa', '31231', 'Auditorías internas en SST', '2024-11-06', 'CERT-2026-44A367', '2025-11-06', 'vigente', NULL, NULL, '2026-02-06 19:18:44', '2026-02-06 20:30:23'),
(53, 'Dan Ramos', '123456', 'Bioseguridad', '2026-02-06', 'CERT-2026-78FDD9', '2027-02-06', 'vigente', 'https://drive.google.com/drive/folders/1B2Be-VHjeBwlTwy1gbh4iqdHMG7coYxx', NULL, '2026-02-06 21:49:43', '2026-02-06 21:49:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

-- CREATE TABLE `cursos` (
--   `id` bigint(20) UNSIGNED NOT NULL,
--   `nombre` varchar(255) NOT NULL,
--   `categoria` varchar(255) DEFAULT NULL,
--   `descripcion` text DEFAULT NULL,
--   `uso_count` int(11) NOT NULL DEFAULT 0,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `nombre`, `categoria`, `descripcion`, `uso_count`, `created_at`, `updated_at`) VALUES
(1, 'Inducción en Seguridad y Salud en el Trabajo', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(2, 'Política y Reglamento Interno de SST', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(3, 'Identificación de Peligros, Evaluación de Riesgos y Controles (IPERC)', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(4, 'IPERC Continuo / IPERC de tareas críticas', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(5, 'Comité de SST / Supervisor de SST', 'obligatorias', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 19:14:33'),
(6, 'Derechos y obligaciones del trabajador en SST', 'obligatorias', NULL, 1, '2026-02-01 00:07:06', '2026-02-06 19:18:44'),
(7, 'Investigación de incidentes y accidentes de trabajo', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(8, 'Reporte de actos y condiciones subestándar', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(9, 'Auditorías internas en SST', 'obligatorias', NULL, 9, '2026-02-01 00:07:06', '2026-02-06 18:59:28'),
(10, 'Inspecciones de seguridad', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(11, 'Legislación en SST (Ley 29783 y su reglamento)', 'obligatorias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(12, 'Trabajo en Altura', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(13, 'Rescate en Altura', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(14, 'Trabajo en Espacios Confinados', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(15, 'Rescate en Espacios Confinados', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(16, 'Trabajo en Caliente (soldadura, oxicorte, esmerilado)', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(17, 'Trabajo con Energías Peligrosas (LOTO)', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(18, 'Trabajo en Excavaciones y Zanjas', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(19, 'Trabajo en Izaje de Cargas', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(20, 'Señalero / Rigger', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(21, 'Trabajo en Proximidad a Líneas Eléctricas', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(22, 'Trabajos con Sustancias Peligrosas', 'alto_riesgo', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(23, 'Primeros Auxilios Básicos', 'emergencias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(24, 'Primeros Auxilios Industriales', 'emergencias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(25, 'Soporte Básico de Vida (RCP y uso de DEA)', 'emergencias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(26, 'Control de Hemorragias', 'emergencias', NULL, 1, '2026-02-01 00:07:06', '2026-02-06 18:56:52'),
(27, 'Manejo de Quemaduras', 'emergencias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(28, 'Plan de Respuesta ante Emergencias', 'emergencias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(29, 'Brigadas de Emergencia', 'emergencias', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 18:59:31'),
(30, 'Brigada contra Incendios', 'emergencias', NULL, 6, '2026-02-01 00:07:06', '2026-02-06 21:50:18'),
(31, 'Uso y Manejo de Extintores', 'emergencias', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(32, 'Evacuación y Simulacros', 'emergencias', NULL, 1, '2026-02-01 00:07:06', '2026-02-06 19:18:48'),
(33, 'Búsqueda y Rescate Básico', 'emergencias', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 18:59:36'),
(34, 'Seguridad en el Uso de Herramientas Manuales', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(35, 'Seguridad en el Uso de Herramientas Eléctricas', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(36, 'Operación Segura de Montacargas', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(37, 'Operación Segura de Plataformas Elevadoras (Manlift)', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(38, 'Operación de Grúas (según alcance de la consultora)', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(39, 'Seguridad en Maquinaria Industrial', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(40, 'Mantenimiento Seguro (permiso de trabajo)', 'equipos', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(41, 'Ergonomía en el Trabajo', 'salud', NULL, 1, '2026-02-01 00:07:06', '2026-02-06 18:37:18'),
(42, 'Ergonomía Administrativa (oficina / home office)', 'salud', NULL, 1, '2026-02-01 00:07:06', '2026-02-06 18:39:56'),
(43, 'Manejo Manual de Cargas', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(44, 'Fatiga y Riesgos Psicosociales', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(45, 'Estrés laboral', 'salud', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 19:19:03'),
(46, 'Ruido ocupacional', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(47, 'Vibraciones', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(48, 'Iluminación en el trabajo', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(49, 'Exposición a agentes químicos', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(50, 'Exposición a agentes biológicos', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(51, 'Enfermedades ocupacionales', 'salud', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(52, 'Manejo de Residuos Sólidos', 'ambiente', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(53, 'Residuos Peligrosos', 'ambiente', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(54, 'Control de Derrames', 'ambiente', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 19:18:39'),
(55, 'Buenas Prácticas Ambientales', 'ambiente', NULL, 1, '2026-02-01 00:07:06', '2026-02-06 19:08:22'),
(56, 'Plan de Contingencias Ambientales', 'ambiente', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(57, 'Seguridad, Salud y Medio Ambiente (SSOMA)', 'ambiente', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(58, 'Cultura de Seguridad', 'cultura', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 19:55:24'),
(59, 'Observación de Conductas Seguras (BBS)', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(60, 'Liderazgo en Seguridad', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(61, 'Seguridad Basada en el Comportamiento', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(62, 'Orden y Limpieza – Metodología 5S', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(63, 'Fatiga y Somnolencia', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(64, 'Alcohol y Drogas en el Trabajo', 'cultura', NULL, 7, '2026-02-01 00:07:06', '2026-02-06 19:18:36'),
(65, 'Seguridad Vial / Conducción Segura', 'cultura', NULL, 2, '2026-02-01 00:07:06', '2026-02-06 02:38:01'),
(66, 'Trabajo Seguro en Oficina', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(67, 'Teletrabajo Seguro', 'cultura', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(68, 'SST en Construcción Civil', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(69, 'SST en Minería (básico)', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(70, 'SST en Industria', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(71, 'SST en Clínicas y Centros de Salud', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(72, 'Bioseguridad', 'sectores', NULL, 11, '2026-02-01 00:07:06', '2026-02-06 21:49:43'),
(73, 'Manipulación de Alimentos', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(74, 'Seguridad en Laboratorios', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(75, 'SST para Contratistas', 'sectores', NULL, 0, '2026-02-01 00:07:06', '2026-02-01 00:07:06'),
(92, 'NUEVO CERTIFICADOo', 'obligatorias', NULL, 0, '2026-02-06 21:55:43', '2026-02-06 21:56:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reclamaciones`
--

-- CREATE TABLE `reclamaciones` (
--   `id` bigint(20) UNSIGNED NOT NULL,
--   `nombre_completo` varchar(255) NOT NULL,
--   `dni` varchar(8) NOT NULL,
--   `telefono` varchar(20) NOT NULL,
--   `email` varchar(255) NOT NULL,
--   `detalle_reclamo` text NOT NULL,
--   `pedido` text NOT NULL,
--   `estado` enum('pendiente','en_proceso','resuelto','rechazado') NOT NULL DEFAULT 'pendiente',
--   `respuesta` text DEFAULT NULL,
--   `fecha_respuesta` timestamp NULL DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL
--) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reclamaciones`
--

INSERT INTO `reclamaciones` (`id`, `nombre_completo`, `dni`, `telefono`, `email`, `detalle_reclamo`, `pedido`, `estado`, `respuesta`, `fecha_respuesta`, `created_at`, `updated_at`) VALUES
(1, 'dasddas', '12312321', '12312321321', 'danramos12931@gmail.com', 'dasdasda', 'dsasadas', 'resuelto', 'Marcado como leído', '2026-02-06 04:59:14', '2026-02-05 05:41:20', '2026-02-06 04:59:14'),
(2, 'zxxcasdxxxxx', '21312321', '12312312321', 'danramos@gmail.com', 'dasdasdasdsada', 'dasdsaadasddasda', 'resuelto', 'Marcado como leído', '2026-02-06 17:58:04', '2026-02-06 17:53:46', '2026-02-06 17:58:04');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `certificados`
--
-- ALTER TABLE `certificados`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `certificados_codigo_unique` (`codigo`);

--
-- Indices de la tabla `cursos`
--
-- ALTER TABLE `cursos`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `cursos_nombre_unique` (`nombre`);

--
-- Indices de la tabla `reclamaciones`
--
-- ALTER TABLE `reclamaciones`
--   ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `certificados`
--
-- ALTER TABLE `certificados`
--   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
-- ALTER TABLE `cursos`
--   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT de la tabla `reclamaciones`
--
-- ALTER TABLE `reclamaciones`
--   MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
