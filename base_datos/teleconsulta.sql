-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:17:37
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupo_vulnerable`
--

CREATE TABLE `grupo_vulnerable` (
  `idgrupo_vulnerable` int(11) NOT NULL,
  `grupo_vulnerable` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `grupo_vulnerable`
--

INSERT INTO `grupo_vulnerable` (`idgrupo_vulnerable`, `grupo_vulnerable`) VALUES
(1, 'NINGUNA'),
(2, 'SITUACIÓN DE CALLE'),
(3, 'PRIVADO DE LIBERTAD'),
(4, 'PERSONA MIGRANTE');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grupo_vulnerable`
--
ALTER TABLE `grupo_vulnerable`
  ADD PRIMARY KEY (`idgrupo_vulnerable`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grupo_vulnerable`
--
ALTER TABLE `grupo_vulnerable`
  MODIFY `idgrupo_vulnerable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:16:33
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tiempo_ts`
--

CREATE TABLE `tiempo_ts` (
  `idtiempo_ts` int(11) NOT NULL,
  `tiempo_ts` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tiempo_ts`
--

INSERT INTO `tiempo_ts` (`idtiempo_ts`, `tiempo_ts`) VALUES
(1, 'REAL'),
(2, 'DIFERIDO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tiempo_ts`
--
ALTER TABLE `tiempo_ts`
  ADD PRIMARY KEY (`idtiempo_ts`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tiempo_ts`
--
ALTER TABLE `tiempo_ts`
  MODIFY `idtiempo_ts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:15:59
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `via_comunicacion`
--

CREATE TABLE `via_comunicacion` (
  `idvia_comunicacion` int(11) NOT NULL,
  `via_comunicacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `via_comunicacion`
--

INSERT INTO `via_comunicacion` (`idvia_comunicacion`, `via_comunicacion`) VALUES
(1, 'PLATAFORMA DE VIDEOCONFERENCIA'),
(2, 'TELEFONÍA MÓVIL O FIJA'),
(3, 'MENSAJERÍA'),
(4, 'CORREO ELECTRÓNICO'),
(5, 'OTRAS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `via_comunicacion`
--
ALTER TABLE `via_comunicacion`
  ADD PRIMARY KEY (`idvia_comunicacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `via_comunicacion`
--
ALTER TABLE `via_comunicacion`
  MODIFY `idvia_comunicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:14:49
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `diagnostico_teleconsulta`
--

CREATE TABLE `diagnostico_teleconsulta` (
  `iddiagnostico_teleconsulta` int(11) NOT NULL,
  `idatencion_psafci` int(11) DEFAULT NULL,
  `idpatologia` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `diagnostico_teleconsulta`
--
ALTER TABLE `diagnostico_teleconsulta`
  ADD PRIMARY KEY (`iddiagnostico_teleconsulta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `diagnostico_teleconsulta`
--
ALTER TABLE `diagnostico_teleconsulta`
  MODIFY `iddiagnostico_teleconsulta` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:13:57
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `de_ts`
--

CREATE TABLE `de_ts` (
  `idde_ts` int(11) NOT NULL,
  `de_ts` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `de_ts`
--

INSERT INTO `de_ts` (`idde_ts`, `de_ts`) VALUES
(1, 'INSTITUCIONAL'),
(2, 'VISITA COMUNITARIA'),
(3, 'FERIA'),
(4, 'CAMPAÑA'),
(5, 'BRIGADA');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `de_ts`
--
ALTER TABLE `de_ts`
  ADD PRIMARY KEY (`idde_ts`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:11:56
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `atencion_grupo_vulnerable`
--

CREATE TABLE `atencion_grupo_vulnerable` (
  `idatencion_grupo_vulnerable` int(11) NOT NULL,
  `idatencion_psafci` int(11) DEFAULT NULL,
  `idgrupo_vulnerable` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `atencion_grupo_vulnerable`
--
ALTER TABLE `atencion_grupo_vulnerable`
  ADD PRIMARY KEY (`idatencion_grupo_vulnerable`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `atencion_grupo_vulnerable`
--
ALTER TABLE `atencion_grupo_vulnerable`
  MODIFY `idatencion_grupo_vulnerable` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:13:35
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `captacion_ts`
--

CREATE TABLE `captacion_ts` (
  `idcaptacion_ts` int(11) NOT NULL,
  `captacion_ts` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `captacion_ts`
--

INSERT INTO `captacion_ts` (`idcaptacion_ts`, `captacion_ts`) VALUES
(1, 'TELESALUD'),
(2, 'CENTRO COORDINADOR DE EMERGENCIAS DPTAL'),
(3, 'SAFCI-MI SALUD'),
(4, 'BJA'),
(5, 'PPMS'),
(6, 'CDVIR'),
(7, 'SEDES'),
(8, 'RÉGIMEN PENITENCIARIO'),
(9, 'OTROS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `captacion_ts`
--
ALTER TABLE `captacion_ts`
  ADD PRIMARY KEY (`idcaptacion_ts`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `captacion_ts`
--
ALTER TABLE `captacion_ts`
  MODIFY `idcaptacion_ts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-04-2026 a las 02:15:32
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `safci_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `en_ts`
--

CREATE TABLE `en_ts` (
  `iden_ts` int(11) NOT NULL,
  `en_ts` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `en_ts`
--

INSERT INTO `en_ts` (`iden_ts`, `en_ts`) VALUES
(1, 'CONSULTA MEDICINA GENERAL'),
(2, 'CONSULTA ESPECIALIZADA'),
(3, 'EMERGENCIA'),
(4, 'HOSPITALIZACIÓN');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `en_ts`
--
ALTER TABLE `en_ts`
  ADD PRIMARY KEY (`iden_ts`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `en_ts`
--
ALTER TABLE `en_ts`
  MODIFY `iden_ts` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
