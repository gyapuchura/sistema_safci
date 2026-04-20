-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 02:38:39
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

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
-- Estructura de tabla para la tabla `antecedente_enfermedad`
--

CREATE TABLE `antecedente_enfermedad` (
  `idantecedente_enfermedad` int(11) NOT NULL,
  `antecedente_enfermedad` varchar(45) DEFAULT NULL,
  `ambos` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `antecedente_enfermedad`
--

INSERT INTO `antecedente_enfermedad` (`idantecedente_enfermedad`, `antecedente_enfermedad`, `ambos`) VALUES
(1, 'TBC', 'SI'),
(2, 'DIABETES - I', 'SI'),
(3, 'DIABETES - 2', 'SI'),
(4, 'DIABETES - G', 'SI'),
(5, 'HIPERTENSIÓN', 'SI'),
(6, 'PRECLAMPSIA', 'SI'),
(7, 'ECLAMPSIA', 'SI'),
(8, 'OTRA COND. MÉDICA GRAVE', 'SI'),
(9, 'CIRUGÍA TRACTO REPROD.', 'NO'),
(10, 'INFERTILIDAD', 'NO'),
(11, 'CARDIOPAT.', 'NO'),
(12, 'NEFROPATÍA', 'NO'),
(13, 'VIOLENCIA', 'NO'),
(14, 'VIH +', 'NO'),
(15, 'OTRA', 'NO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedente_enfermedad`
--
ALTER TABLE `antecedente_enfermedad`
  ADD PRIMARY KEY (`idantecedente_enfermedad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedente_enfermedad`
--
ALTER TABLE `antecedente_enfermedad`
  MODIFY `idantecedente_enfermedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 02:39:11
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

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
-- Estructura de tabla para la tabla `antecedente_obstetrico`
--

CREATE TABLE `antecedente_obstetrico` (
  `idantecedente_obstetrico` int(11) NOT NULL,
  `idhistoria_perinatal` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `gestaciones` int(11) DEFAULT NULL,
  `partos` int(11) DEFAULT NULL,
  `abortos` int(11) DEFAULT NULL,
  `cesareas` int(11) DEFAULT NULL,
  `nacidos_vivos` int(11) DEFAULT NULL,
  `viven` int(11) DEFAULT NULL,
  `nacidos_muertos` int(11) DEFAULT NULL,
  `muertos_a_semana` int(11) DEFAULT NULL,
  `muertos_d_semana` int(11) DEFAULT NULL,
  `vaginales` int(11) DEFAULT NULL,
  `idultimo_previo` int(11) DEFAULT NULL,
  `antecedente_gemelos` varchar(45) DEFAULT NULL,
  `fecha_fea` date DEFAULT NULL,
  `embarazo_planeado` varchar(45) DEFAULT NULL,
  `idmetodo_anticonceptivo` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `antecedente_obstetrico`
--

INSERT INTO `antecedente_obstetrico` (`idantecedente_obstetrico`, `idhistoria_perinatal`, `idnombre`, `gestaciones`, `partos`, `abortos`, `cesareas`, `nacidos_vivos`, `viven`, `nacidos_muertos`, `muertos_a_semana`, `muertos_d_semana`, `vaginales`, `idultimo_previo`, `antecedente_gemelos`, `fecha_fea`, `embarazo_planeado`, `idmetodo_anticonceptivo`, `fecha_registro`, `hora_registro`, `idusuario`) VALUES
(1, 1, 2155699, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 'NO', '2026-04-18', 'NO', 1, '2026-04-18', '23:06', 13731),
(2, 2, 2155699, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'NO', '2026-04-18', 'NO', 1, '2026-04-18', '23:22', 13731),
(3, 3, 2155699, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'NO', '2026-04-18', 'NO', 1, '2026-04-18', '23:53', 13731),
(4, 4, 2155699, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'NO', '2026-04-18', 'NO', 1, '2026-04-18', '00:02', 13731),
(5, 5, 2155699, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 'NO', '2026-04-18', 'NO', 1, '2026-04-18', '00:10', 13731),
(6, 6, 2155699, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'NO', '2026-04-13', 'NO', 1, '2026-04-19', '00:32', 13731);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedente_obstetrico`
--
ALTER TABLE `antecedente_obstetrico`
  ADD PRIMARY KEY (`idantecedente_obstetrico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedente_obstetrico`
--
ALTER TABLE `antecedente_obstetrico`
  MODIFY `idantecedente_obstetrico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 02:40:00
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

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
-- Estructura de tabla para la tabla `antecedente_perinatal`
--

CREATE TABLE `antecedente_perinatal` (
  `idantecedente_perinatal` int(11) NOT NULL,
  `idhistoria_perinatal` int(11) DEFAULT NULL,
  `idtipo_antecedente_enfermedad` int(11) DEFAULT NULL,
  `idantecedente_enfermedad` int(11) DEFAULT NULL,
  `valor_antecedente_perinatal` varchar(45) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `antecedente_perinatal`
--

INSERT INTO `antecedente_perinatal` (`idantecedente_perinatal`, `idhistoria_perinatal`, `idtipo_antecedente_enfermedad`, `idantecedente_enfermedad`, `valor_antecedente_perinatal`, `fecha_registro`, `hora_registro`, `idusuario`) VALUES
(1, 1, 2, 3, NULL, '2026-04-23', 'hora', 1),
(2, 3, 2, 1, 'NO', '2026-04-18', '23:53', 13731),
(3, 3, 2, 2, 'NO', '2026-04-18', '23:53', 13731),
(4, 3, 2, 3, 'NO', '2026-04-18', '23:53', 13731),
(5, 3, 2, 4, 'NO', '2026-04-18', '23:53', 13731),
(6, 3, 2, 5, 'NO', '2026-04-18', '23:53', 13731),
(7, 3, 2, 6, 'NO', '2026-04-18', '23:53', 13731),
(8, 3, 2, 7, 'NO', '2026-04-18', '23:53', 13731),
(9, 3, 2, 8, 'NO', '2026-04-18', '23:53', 13731),
(10, 3, 1, 1, 'NO', '2026-04-18', '23:53', 13731),
(11, 3, 1, 2, 'NO', '2026-04-18', '23:53', 13731),
(12, 3, 1, 3, 'NO', '2026-04-18', '23:53', 13731),
(13, 3, 1, 4, 'NO', '2026-04-18', '23:53', 13731),
(14, 3, 1, 5, 'NO', '2026-04-18', '23:53', 13731),
(15, 3, 1, 6, 'NO', '2026-04-18', '23:53', 13731),
(16, 3, 1, 7, 'NO', '2026-04-18', '23:53', 13731),
(17, 3, 1, 8, 'NO', '2026-04-18', '23:53', 13731),
(18, 3, 1, 9, 'NO', '2026-04-18', '23:53', 13731),
(19, 3, 1, 10, 'NO', '2026-04-18', '23:53', 13731),
(20, 3, 1, 11, 'NO', '2026-04-18', '23:53', 13731),
(21, 3, 1, 12, 'NO', '2026-04-18', '23:53', 13731),
(22, 3, 1, 13, 'NO', '2026-04-18', '23:53', 13731),
(23, 3, 1, 14, 'NO', '2026-04-18', '23:53', 13731),
(24, 3, 1, 15, 'NO', '2026-04-18', '23:53', 13731),
(25, 4, 2, 1, 'NO', '2026-04-18', '00:02', 13731),
(26, 4, 2, 2, 'NO', '2026-04-18', '00:02', 13731),
(27, 4, 2, 3, 'NO', '2026-04-18', '00:02', 13731),
(28, 4, 2, 4, 'NO', '2026-04-18', '00:02', 13731),
(29, 4, 2, 5, 'NO', '2026-04-18', '00:02', 13731),
(30, 4, 2, 6, 'NO', '2026-04-18', '00:02', 13731),
(31, 4, 2, 7, 'NO', '2026-04-18', '00:02', 13731),
(32, 4, 2, 8, 'NO', '2026-04-18', '00:02', 13731),
(33, 4, 1, 1, 'NO', '2026-04-18', '00:02', 13731),
(34, 4, 1, 2, 'NO', '2026-04-18', '00:02', 13731),
(35, 4, 1, 3, 'NO', '2026-04-18', '00:02', 13731),
(36, 4, 1, 4, 'NO', '2026-04-18', '00:02', 13731),
(37, 4, 1, 5, 'NO', '2026-04-18', '00:02', 13731),
(38, 4, 1, 6, 'NO', '2026-04-18', '00:02', 13731),
(39, 4, 1, 7, 'NO', '2026-04-18', '00:02', 13731),
(40, 4, 1, 8, 'NO', '2026-04-18', '00:02', 13731),
(41, 4, 1, 9, 'NO', '2026-04-18', '00:02', 13731),
(42, 4, 1, 10, 'NO', '2026-04-18', '00:02', 13731),
(43, 4, 1, 11, 'NO', '2026-04-18', '00:02', 13731),
(44, 4, 1, 12, 'NO', '2026-04-18', '00:02', 13731),
(45, 4, 1, 13, 'NO', '2026-04-18', '00:02', 13731),
(46, 4, 1, 14, 'NO', '2026-04-18', '00:02', 13731),
(47, 4, 1, 15, 'NO', '2026-04-18', '00:02', 13731),
(48, 5, 2, 1, 'NO', '2026-04-18', '00:10', 13731),
(49, 5, 2, 2, 'NO', '2026-04-18', '00:10', 13731),
(50, 5, 2, 3, 'NO', '2026-04-18', '00:10', 13731),
(51, 5, 2, 4, 'NO', '2026-04-18', '00:10', 13731),
(52, 5, 2, 5, 'NO', '2026-04-18', '00:10', 13731),
(53, 5, 2, 6, 'NO', '2026-04-18', '00:10', 13731),
(54, 5, 2, 7, 'NO', '2026-04-18', '00:10', 13731),
(55, 5, 2, 8, 'NO', '2026-04-18', '00:10', 13731),
(56, 5, 1, 1, 'NO', '2026-04-18', '00:10', 13731),
(57, 5, 1, 2, 'NO', '2026-04-18', '00:10', 13731),
(58, 5, 1, 3, 'NO', '2026-04-18', '00:10', 13731),
(59, 5, 1, 4, 'NO', '2026-04-18', '00:10', 13731),
(60, 5, 1, 5, 'NO', '2026-04-18', '00:10', 13731),
(61, 5, 1, 6, 'NO', '2026-04-18', '00:10', 13731),
(62, 5, 1, 7, 'NO', '2026-04-18', '00:10', 13731),
(63, 5, 1, 8, 'NO', '2026-04-18', '00:10', 13731),
(64, 5, 1, 9, 'NO', '2026-04-18', '00:10', 13731),
(65, 5, 1, 10, 'NO', '2026-04-18', '00:10', 13731),
(66, 5, 1, 11, 'NO', '2026-04-18', '00:10', 13731),
(67, 5, 1, 12, 'NO', '2026-04-18', '00:10', 13731),
(68, 5, 1, 13, 'NO', '2026-04-18', '00:10', 13731),
(69, 5, 1, 14, 'NO', '2026-04-18', '00:10', 13731),
(70, 5, 1, 15, 'NO', '2026-04-18', '00:10', 13731),
(71, 6, 2, 1, 'NO', '2026-04-19', '00:32', 13731),
(72, 6, 2, 2, 'SI', '2026-04-19', '00:32', 13731),
(73, 6, 2, 3, 'NO', '2026-04-19', '00:32', 13731),
(74, 6, 2, 4, 'SI', '2026-04-19', '00:32', 13731),
(75, 6, 2, 5, 'NO', '2026-04-19', '00:32', 13731),
(76, 6, 2, 6, 'NO', '2026-04-19', '00:32', 13731),
(77, 6, 2, 7, 'SI', '2026-04-19', '00:32', 13731),
(78, 6, 2, 8, 'SI', '2026-04-19', '00:32', 13731),
(79, 6, 1, 1, 'NO', '2026-04-19', '00:32', 13731),
(80, 6, 1, 2, 'NO', '2026-04-19', '00:32', 13731),
(81, 6, 1, 3, 'NO', '2026-04-19', '00:32', 13731),
(82, 6, 1, 4, 'NO', '2026-04-19', '00:32', 13731),
(83, 6, 1, 5, 'SI', '2026-04-19', '00:32', 13731),
(84, 6, 1, 6, 'SI', '2026-04-19', '00:32', 13731),
(85, 6, 1, 7, 'SI', '2026-04-19', '00:32', 13731),
(86, 6, 1, 8, 'SI', '2026-04-19', '00:32', 13731),
(87, 6, 1, 9, 'NO', '2026-04-19', '00:32', 13731),
(88, 6, 1, 10, 'NO', '2026-04-19', '00:32', 13731),
(89, 6, 1, 11, 'NO', '2026-04-19', '00:32', 13731),
(90, 6, 1, 12, 'NO', '2026-04-19', '00:32', 13731),
(91, 6, 1, 13, 'SI', '2026-04-19', '00:32', 13731),
(92, 6, 1, 14, 'SI', '2026-04-19', '00:32', 13731),
(93, 6, 1, 15, 'SI', '2026-04-19', '00:32', 13731);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antecedente_perinatal`
--
ALTER TABLE `antecedente_perinatal`
  ADD PRIMARY KEY (`idantecedente_perinatal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antecedente_perinatal`
--
ALTER TABLE `antecedente_perinatal`
  MODIFY `idantecedente_perinatal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 02:41:06
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

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
-- Estructura de tabla para la tabla `gestacion`
--

CREATE TABLE `gestacion` (
  `idgestacion` int(11) NOT NULL,
  `idhistoria_perinatal` int(11) DEFAULT NULL,
  `idantecedente_obstetrico` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `peso_anterior` varchar(45) DEFAULT NULL,
  `talla` varchar(45) DEFAULT NULL,
  `idesno` int(11) DEFAULT NULL,
  `fecha_fum` date DEFAULT NULL,
  `fecha_pp` date DEFAULT NULL,
  `eg_fum` varchar(45) DEFAULT NULL,
  `eco_veinte` varchar(45) DEFAULT NULL,
  `fuma_activo` varchar(45) DEFAULT NULL,
  `fuma_pasivo` varchar(45) DEFAULT NULL,
  `drogas` varchar(45) DEFAULT NULL,
  `alcohol` varchar(45) DEFAULT NULL,
  `violencia` varchar(45) DEFAULT NULL,
  `idantirubeola` int(11) DEFAULT NULL,
  `antitetanica` varchar(45) DEFAULT NULL,
  `dosis_antitetanica` varchar(45) DEFAULT NULL,
  `ex_odontologico` varchar(45) DEFAULT NULL,
  `ex_mamas` varchar(45) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `gestacion`
--

INSERT INTO `gestacion` (`idgestacion`, `idhistoria_perinatal`, `idantecedente_obstetrico`, `idnombre`, `peso_anterior`, `talla`, `idesno`, `fecha_fum`, `fecha_pp`, `eg_fum`, `eco_veinte`, `fuma_activo`, `fuma_pasivo`, `drogas`, `alcohol`, `violencia`, `idantirubeola`, `antitetanica`, `dosis_antitetanica`, `ex_odontologico`, `ex_mamas`, `fecha_registro`, `hora_registro`, `idusuario`) VALUES
(1, 5, 5, 2155699, '0', '', 3, '2026-04-18', '2026-04-18', NULL, NULL, 'NO', 'NO', 'NO', 'NO', 'NO', 2, 'NO', '2da', 'NO', 'NO', '2026-04-18', '00:10', 13731),
(2, 6, 6, 2155699, '65', '', 2, '2026-04-07', '2026-04-15', 'NO', 'NO', 'NO', 'NO', 'NO', 'NO', 'NO', 2, 'NO', '2da', 'SI', 'SI', '2026-04-19', '00:32', 13731);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `gestacion`
--
ALTER TABLE `gestacion`
  ADD PRIMARY KEY (`idgestacion`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `gestacion`
--
ALTER TABLE `gestacion`
  MODIFY `idgestacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 02:40:30
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

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
-- Estructura de tabla para la tabla `historia_perinatal`
--

CREATE TABLE `historia_perinatal` (
  `idhistoria_perinatal` int(11) NOT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idred_salud` int(11) DEFAULT NULL,
  `idmunicipio` int(11) DEFAULT NULL,
  `idestablecimiento_salud` int(11) DEFAULT NULL,
  `idarea_influencia` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `idnacion` int(11) DEFAULT NULL,
  `alfabeta` varchar(45) DEFAULT NULL,
  `idnivel_instruccion` int(11) DEFAULT NULL,
  `anos_mayor_nivel` varchar(45) DEFAULT NULL,
  `vive_sola` varchar(45) DEFAULT NULL,
  `gestion` varchar(45) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `historia_perinatal`
--

INSERT INTO `historia_perinatal` (`idhistoria_perinatal`, `iddepartamento`, `idred_salud`, `idmunicipio`, `idestablecimiento_salud`, `idarea_influencia`, `correlativo`, `codigo`, `idnombre`, `idnacion`, `alfabeta`, `idnivel_instruccion`, `anos_mayor_nivel`, `vive_sola`, `gestion`, `fecha_registro`, `hora_registro`, `idusuario`) VALUES
(1, 7, 55, 250, 2814, 10866, 1, 'MSYD-HCP-1/2026', 2155699, 35, 'SI', 7, '2', 'NO', '2026', '2026-04-18', '23:06', 13731),
(2, 7, 55, 250, 2814, 10866, 2, 'MSYD-HCP-2/2026', 2155699, 35, 'SI', 7, '2', 'NO', '2026', '2026-04-18', '23:22', 13731),
(3, 7, 55, 250, 2814, 10866, 3, 'MSYD-HCP-3/2026', 2155699, 35, 'SI', 7, '2', 'NO', '2026', '2026-04-18', '23:53', 13731),
(4, 7, 55, 250, 2814, 10866, 4, 'MSYD-HCP-4/2026', 2155699, 35, 'SI', 7, '2', 'NO', '2026', '2026-04-18', '00:02', 13731),
(5, 7, 55, 250, 2814, 10866, 5, 'MSYD-HCP-5/2026', 2155699, 35, 'SI', 7, '2', 'NO', '2026', '2026-04-18', '00:10', 13731),
(6, 7, 55, 250, 2814, 10866, 6, 'MSYD-HCP-6/2026', 2155699, 35, 'SI', 7, '3', 'NO', '2026', '2026-04-19', '00:32', 13731);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historia_perinatal`
--
ALTER TABLE `historia_perinatal`
  ADD PRIMARY KEY (`idhistoria_perinatal`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historia_perinatal`
--
ALTER TABLE `historia_perinatal`
  MODIFY `idhistoria_perinatal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;




-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 20-04-2026 a las 02:42:00
-- Versión del servidor: 5.7.34
-- Versión de PHP: 7.4.21

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
-- Estructura de tabla para la tabla `tipo_antecedente_enfermedad`
--

CREATE TABLE `tipo_antecedente_enfermedad` (
  `idtipo_antecedente_enfermedad` int(11) NOT NULL,
  `tipo_antecedente_enfermedad` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_antecedente_enfermedad`
--

INSERT INTO `tipo_antecedente_enfermedad` (`idtipo_antecedente_enfermedad`, `tipo_antecedente_enfermedad`) VALUES
(1, 'PERSONAL'),
(2, 'FAMILIAR');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tipo_antecedente_enfermedad`
--
ALTER TABLE `tipo_antecedente_enfermedad`
  ADD PRIMARY KEY (`idtipo_antecedente_enfermedad`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipo_antecedente_enfermedad`
--
ALTER TABLE `tipo_antecedente_enfermedad`
  MODIFY `idtipo_antecedente_enfermedad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


