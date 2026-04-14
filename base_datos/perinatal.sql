-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 14-04-2026 a las 15:37:48
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
-- Tiempo de generación: 14-04-2026 a las 15:39:36
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
-- Estructura de tabla para la tabla `ultimo_previo`
--

CREATE TABLE `ultimo_previo` (
  `idultimo_previo` int(11) NOT NULL,
  `ultimo_previo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ultimo_previo`
--

INSERT INTO `ultimo_previo` (`idultimo_previo`, `ultimo_previo`) VALUES
(1, 'NO'),
(2, '< 2500 g'),
(3, 'NORMAL'),
(4, '> 4000 g');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ultimo_previo`
--
ALTER TABLE `ultimo_previo`
  ADD PRIMARY KEY (`idultimo_previo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ultimo_previo`
--
ALTER TABLE `ultimo_previo`
  MODIFY `idultimo_previo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 14-04-2026 a las 15:40:27
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
-- Estructura de tabla para la tabla `metodo_anticonceptivo`
--

CREATE TABLE `metodo_anticonceptivo` (
  `idmetodo_anticonceptivo` int(11) NOT NULL,
  `metodo_anticonceptivo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `metodo_anticonceptivo`
--

INSERT INTO `metodo_anticonceptivo` (`idmetodo_anticonceptivo`, `metodo_anticonceptivo`) VALUES
(1, 'NO USABA'),
(2, 'BARRERA '),
(3, 'DIU'),
(4, 'HORMONAL'),
(5, 'EMERGENCIA'),
(6, 'NATURAL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `metodo_anticonceptivo`
--
ALTER TABLE `metodo_anticonceptivo`
  ADD PRIMARY KEY (`idmetodo_anticonceptivo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `metodo_anticonceptivo`
--
ALTER TABLE `metodo_anticonceptivo`
  MODIFY `idmetodo_anticonceptivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 14-04-2026 a las 15:41:32
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
-- Estructura de tabla para la tabla `esno`
--

CREATE TABLE `esno` (
  `idesno` int(11) NOT NULL,
  `esno` varchar(45) DEFAULT NULL,
  `inicial` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `esno`
--

INSERT INTO `esno` (`idesno`, `esno`, `inicial`) VALUES
(1, 'EMACIADA', 'E'),
(2, 'SOBREPESO', 'S'),
(3, 'NORMAL', 'N'),
(4, 'OBESIDAD', 'O');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `esno`
--
ALTER TABLE `esno`
  ADD PRIMARY KEY (`idesno`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `esno`
--
ALTER TABLE `esno`
  MODIFY `idesno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 14-04-2026 a las 15:42:41
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
-- Estructura de tabla para la tabla `antirubeola`
--

CREATE TABLE `antirubeola` (
  `idantirubeola` int(11) NOT NULL,
  `antirubeola` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `antirubeola`
--

INSERT INTO `antirubeola` (`idantirubeola`, `antirubeola`) VALUES
(1, 'PREVIA'),
(2, 'NO SABE'),
(3, 'EMBARAZO'),
(4, 'NO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `antirubeola`
--
ALTER TABLE `antirubeola`
  ADD PRIMARY KEY (`idantirubeola`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `antirubeola`
--
ALTER TABLE `antirubeola`
  MODIFY `idantirubeola` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
