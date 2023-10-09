-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 09-10-2023 a las 23:40:37
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
-- Estructura de tabla para la tabla `ambito`
--

CREATE TABLE `ambito` (
  `idambito` int(11) NOT NULL,
  `ambito` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ambito`
--

INSERT INTO `ambito` (`idambito`, `ambito`) VALUES
(1, 'CENTRAL'),
(2, 'DEPARTAMENTAL'),
(3, 'MUNICIPAL'),
(4, 'CONTROL SOCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ambito_local`
--

CREATE TABLE `ambito_local` (
  `idambito_local` int(11) NOT NULL,
  `ambito_local` varchar(45) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ambito_local`
--

INSERT INTO `ambito_local` (`idambito_local`, `ambito_local`, `descripcion`) VALUES
(1, 'R', 'RURAL'),
(2, 'U', 'URBANO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area`
--

CREATE TABLE `area` (
  `idarea` int(11) NOT NULL,
  `iddireccion` int(11) DEFAULT NULL,
  `area` text,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `area`
--

INSERT INTO `area` (`idarea`, `iddireccion`, `area`, `idusuario`) VALUES
(1, 1, 'Unidad de Auditoria Interna', 5),
(2, 1, 'Unidad de Transparencia y Lucha Contra la Corrupción', 5),
(3, 1, 'Unidad de Comunicación Social', 5),
(4, 2, 'Unidad de Gestión Jurídica', 5),
(5, 2, 'Unidad de Análisis Juirídico', 5),
(6, 3, 'Unidad de Recursos Humanos', 5),
(7, 3, 'Unidad Financiera', 5),
(9, 4, 'Unidad de Planificación Estratégica', 5),
(10, 4, 'Unidad del Sistema Nacional de Información en Salud', 5),
(11, 20, 'Unidad de Redes de Servicios de Salud y Calidad', 5),
(12, 20, 'Unidad de la Gestión de Política de la Discapacidad', 5),
(13, 20, 'Unidad de Gestión de Riesgos Emergencias y Desastres', 5),
(14, 20, 'Programas Nacionales', 5),
(15, 21, 'Unidad de Regulación y Gestión de Hospitales ', 5),
(16, 21, 'Unidad de Regulación de Infraestructura Equipamiento y Tecnología', 5),
(17, 21, 'Unidad de Gestión de Programas y Proyectos (UGESPRO)', 5),
(18, 22, 'Unidad de Promoción de la Salud, Gestion y Participacion Social', 5),
(19, 22, 'Unidad de Alimentación y Nutrición', 5),
(20, 23, 'Unidad de Gestión de Medicina Tradicional', 5),
(21, 24, 'Unidad de Vigilancia Epidemiológica y Salud Ambiental', 5),
(22, 24, 'Unidad de Prevención y Control de Enfermedades', 5),
(23, 25, 'Unidad de Coordinación y Desarrollo del Sistema Único de Salud (SUS)', 5),
(24, 25, 'Unidad de Gestión Financiera del Sistema Únnico de Salud(SUS)', 5),
(25, 26, 'Unidad de Gestión Estratégica del Sector Salud de Corto Plazo', 5),
(26, 26, 'Unidad de Riesgos Profesionales y Asignaciones Familiares', 5),
(27, 27, 'Unidad de Desarrollo Integral del Deporte', 5),
(28, 27, 'Unidad de Deporte Federativo Profesional y Competitivo', 5),
(29, 28, 'Unidad de Coordinación de Centros Deportivos', 5),
(30, 28, 'Unidad de Formación, Promoción y Recreación Deportiva', 5),
(31, 24, 'Programas Nacionales', 5),
(32, 1, 'Jefatura de Gabinete', 5),
(33, 1, 'Programa de Cuidados Integrales para la Salud', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_conocimiento`
--

CREATE TABLE `area_conocimiento` (
  `idarea_conocimiento` int(11) NOT NULL,
  `area_conocimiento` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `area_conocimiento`
--

INSERT INTO `area_conocimiento` (`idarea_conocimiento`, `area_conocimiento`) VALUES
(1, 'INTRODUCTORIA'),
(2, 'PLANIFICACION EN SALUD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_influencia`
--

CREATE TABLE `area_influencia` (
  `idarea_influencia` int(11) NOT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idred_salud` int(11) DEFAULT NULL,
  `idestablecimiento_salud` int(11) DEFAULT NULL,
  `idtipo_area_influencia` int(11) DEFAULT NULL,
  `area_influencia` text,
  `idnacion` int(11) DEFAULT NULL,
  `habitantes` int(11) DEFAULT NULL,
  `familias` int(11) DEFAULT NULL,
  `distancia` int(11) DEFAULT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `area_influencia`
--

INSERT INTO `area_influencia` (`idarea_influencia`, `iddepartamento`, `idred_salud`, `idestablecimiento_salud`, `idtipo_area_influencia`, `area_influencia`, `idnacion`, `habitantes`, `familias`, `distancia`, `latitud`, `longitud`, `fecha_registro`, `idusuario`) VALUES
(1, 2, 3, 1, 3, 'area_influencia', 5, 324, 212, 40, 'latitud', 'longitud', '2023-09-25', 1),
(2, 4, 26, 1950, 3, 'NOMBRE O DENOMINACIÓN', 33, 2000, 800, 4, '-16.512434', '-68.131280', '2023-09-26', 1),
(3, 4, 26, 1951, 3, 'Villa Adela ', 33, 40000, 10000, 1, '-16.512085', '-68.136746', '2023-10-02', 1),
(4, 4, 15, 1505, 1, 'Comunidad Viacha-Ingavi-Rural', 33, 2000, 401, 3, '-16.513191', '-68.137330', '2023-09-26', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE `aula` (
  `idaula` int(11) NOT NULL,
  `aula` text NOT NULL,
  `disponibilidad` varchar(45) NOT NULL,
  `capacidad` varchar(45) NOT NULL,
  `codigo_aula` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `aula`
--

INSERT INTO `aula` (`idaula`, `aula`, `disponibilidad`, `capacidad`, `codigo_aula`) VALUES
(1, 'AULA VIRTUAL', 'DISPONIBLE', '40', 'A-VIR'),
(2, 'AULA PRESENCIAL', 'DISPONIBLE', '30', 'A-PR');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `idcargo` int(11) NOT NULL,
  `idarea` int(11) DEFAULT NULL,
  `cargo` text,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo_mds`
--

CREATE TABLE `cargo_mds` (
  `idcargo_mds` int(11) NOT NULL,
  `idministerio` int(11) DEFAULT NULL,
  `iddireccion` int(11) DEFAULT NULL,
  `idarea` int(11) DEFAULT NULL,
  `cargo_mds` text,
  `item_mds` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargo_mds`
--

INSERT INTO `cargo_mds` (`idcargo_mds`, `idministerio`, `iddireccion`, `idarea`, `cargo_mds`, `item_mds`) VALUES
(1, 3, 24, 31, 'Endocrinologo', '132'),
(2, 3, 24, 31, 'Especialista Dermatologo', '342'),
(3, 3, 24, 31, 'Administrador', '23122'),
(4, 3, 24, 31, 'Medico Cirujano', '2341'),
(5, 3, 24, 31, 'Especialista SAFCI', '342'),
(6, 3, 24, 31, 'Especialista SAFCI', '321'),
(7, 3, 24, 31, 'Especialista SAFCI', '342'),
(8, 3, 24, 31, 'Especialista SAFCI', '320'),
(9, 3, 24, 31, 'Especialista SAFCI', '322'),
(10, 3, 24, 31, 'Especialista SAFCI', '123'),
(11, 3, 24, 31, 'ESPECIALISTA SAFCI', '243'),
(12, 3, 24, 31, 'ESPECIALISTA OFTALMÓLOGO', '3241'),
(13, 3, 24, 31, 'ESPECIALISTA SAFCI', '421'),
(14, 3, 24, 31, 'ESPECIALISTA SAFCI', '452');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo_organigrama`
--

CREATE TABLE `cargo_organigrama` (
  `idcargo_organigrama` int(11) NOT NULL,
  `cargo_organigrama` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargo_organigrama`
--

INSERT INTO `cargo_organigrama` (`idcargo_organigrama`, `cargo_organigrama`) VALUES
(1, 'APOYO TECNICO'),
(2, 'AUX. O TEC MED. DE ENFERMERIA'),
(3, 'AUXILIAR ADMINISTRATIVO'),
(4, 'BIOIMAGENOLOGO(A)'),
(5, 'BIOQUIMICO(A) FARMACEUTICO(A)'),
(6, 'CONDUCTOR'),
(7, 'COORDINADOR DEPARTAMENTAL'),
(8, 'IMAGENOLOGO(A)'),
(9, 'JEFE DE ENSEÑANZA'),
(10, 'LIC. EN ENFERMERIA'),
(11, 'MANUAL DE LIMPIEZA'),
(12, 'MEDICO DE BASE'),
(13, 'MEDICO DE BASE ESPECIALISTA CLINICO - QUIRURGICO'),
(14, 'MEDICO RESIDENTE SAFCI'),
(15, 'ODONTOLOGO(A)'),
(16, 'RADIOLOGO(A)'),
(17, 'RESPONSABLE DE LA INFORMACION Y BASE DE DATOS(ESTADISTICO)'),
(18, 'RESPONSABLE DISTRITAL'),
(19, 'RESPONSABLE MUNICIPAL'),
(20, 'RESPONSABLE REGIONAL'),
(21, 'ACTUALIZAR CARGO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo_red_salud`
--

CREATE TABLE `cargo_red_salud` (
  `idcargo_red_salud` int(11) NOT NULL,
  `idred_salud` int(11) DEFAULT NULL,
  `idestablecimiento_salud` int(11) DEFAULT NULL,
  `cargo_red_salud` text,
  `item_red_salud` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cargo_red_salud`
--

INSERT INTO `cargo_red_salud` (`idcargo_red_salud`, `idred_salud`, `idestablecimiento_salud`, `cargo_red_salud`, `item_red_salud`) VALUES
(1, 26, 1949, 'Consultor Implementador', '342'),
(2, 29, 2018, 'Cirujano', '231'),
(3, 26, 1954, 'Especialista Nefrologa', '455'),
(4, 26, 1951, 'Medico General', '322'),
(5, 26, 1950, 'Especialista en Emergencias', '342'),
(6, 79, 1729, 'CARGO DE ACUERDO A MEMORADUM DE DESIGNACIÓN.', '3214'),
(7, 26, 1950, 'ESPECIALISTA SAFCI', '321'),
(8, 22, 1892, 'MEDICO ESPECIALISTA ', '342'),
(9, 22, 1891, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN.', '322'),
(10, 22, 1884, 'CARGO:\r\n(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN)', '322'),
(11, 21, 1873, 'MEDICO ESPECIALISTA SAFCI', '3321'),
(12, 26, 1947, 'CARGO (DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '320'),
(13, 28, 1996, 'ENCARAGDO DE RADIOLOGÍA', '422'),
(14, 21, 1875, 'MEDICO ESPECIALISTA SAFCI', '344'),
(15, 26, 1947, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '422'),
(16, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '322'),
(17, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN)', '321'),
(18, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN.', '232'),
(19, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN.', '442'),
(20, 22, 1898, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '232'),
(21, 26, 1948, 'CARGO', '231');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carpeta_familiar`
--

CREATE TABLE `carpeta_familiar` (
  `idcarpeta_familiar` int(11) NOT NULL,
  `idestablecimiento_salud` int(11) DEFAULT NULL,
  `idarea_influencia` int(11) DEFAULT NULL,
  `codigo_carpeta` varchar(45) DEFAULT NULL,
  `familia` text,
  `avenida_calle` text,
  `no_puerta` varchar(45) DEFAULT NULL,
  `nombre_edificio` text,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) NOT NULL,
  `altura` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `fecha_apertura` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario_evaluacion`
--

CREATE TABLE `comentario_evaluacion` (
  `idcomentario_evaluacion` int(11) NOT NULL,
  `comentario_evaluacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comentario_evaluacion`
--

INSERT INTO `comentario_evaluacion` (`idcomentario_evaluacion`, `comentario_evaluacion`) VALUES
(1, 'SIN EVALUAR'),
(2, 'NO SE PRESENTO'),
(3, 'REPROBADO(A)'),
(4, 'APROBADO(A)');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condicion`
--

CREATE TABLE `condicion` (
  `idcondicion` int(11) NOT NULL,
  `condicion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `condicion`
--

INSERT INTO `condicion` (`idcondicion`, `condicion`) VALUES
(1, 'ACTIVO'),
(2, 'PASIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dato_laboral`
--

CREATE TABLE `dato_laboral` (
  `iddato_laboral` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `iddependencia` int(11) DEFAULT NULL,
  `entidad` text,
  `cargo_entidad` text,
  `idministerio` int(11) DEFAULT NULL,
  `iddireccion` int(11) DEFAULT NULL,
  `idarea` int(11) DEFAULT NULL,
  `cargo_mds` text,
  `item_mds` varchar(45) DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idred_salud` int(11) DEFAULT NULL,
  `idestablecimiento_salud` int(11) DEFAULT NULL,
  `cargo_red_salud` text,
  `item_red_salud` varchar(45) DEFAULT NULL,
  `idcargo_organigrama` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dato_laboral`
--

INSERT INTO `dato_laboral` (`iddato_laboral`, `idusuario`, `idnombre`, `iddependencia`, `entidad`, `cargo_entidad`, `idministerio`, `iddireccion`, `idarea`, `cargo_mds`, `item_mds`, `iddepartamento`, `idred_salud`, `idestablecimiento_salud`, `cargo_red_salud`, `item_red_salud`, `idcargo_organigrama`) VALUES
(1, 2, 1, 2, '', '', 3, 24, 31, 'T&eacute;cnico de Desarrollo de Aulas Virtuales', NULL, 4, 0, 0, '', NULL, NULL),
(2, 3, 2, 2, '', '', 3, 24, 31, 'Encargado de Soporte Informatico Programa SAFCI - MI SALUD', NULL, 4, 0, 0, '', NULL, NULL),
(3, 4, 3, 2, '', '', 3, 24, 31, 'Responsable de Formación SAFCI - MI SALUD', NULL, 4, 0, 0, '', NULL, NULL),
(4, 5, 4, 1, 'Ministerio de Jsuticia', 'Encargado de Sistemas', 0, 0, 0, '', NULL, 4, 0, 0, '', NULL, NULL),
(5, 6, 5, 2, '', '', 1, 4, 10, 'Secretaria ', NULL, 5, 0, 0, '', NULL, NULL),
(6, 7, 6, 3, '', '', 0, 0, 0, '', NULL, 4, 26, 1950, 'Encargada de Contrataciones', NULL, NULL),
(7, 8, 7, 2, '', '', 3, 24, 31, 'encargado de procesos academicos', NULL, 4, 0, 0, '', NULL, NULL),
(8, 10, 8, 2, '', '', 3, 24, 31, 'Médico Especialista SAFCI para el C.S Somopae del municipio de San Andrés, departamento Beni ', NULL, 1, 0, 0, '', NULL, NULL),
(9, 11, 9, 2, '', '', 2, 20, 14, 'Médico Especialista SAFCI', NULL, 7, 0, 0, '', NULL, NULL),
(10, 12, 10, 2, '', '', 3, 24, 31, 'ENLACE DE RED MUNICIPAL SAFCI Y EDUCACION CONTINUA DE WARNES', NULL, 8, 0, 0, '', NULL, NULL),
(11, 13, 11, 2, '', '', 3, 24, 31, 'especialista safci centro de salud Villa Gto. Villarroel', NULL, 2, 0, 0, '', NULL, NULL),
(12, 14, 12, 2, '', '', 3, 24, 31, 'ENLACE DE RED SA.F.C.I Y EDUCACION CONTINUA CON BASE EN EL HOSPITAL SOLOMON KLEIN ', NULL, 2, 0, 0, '', NULL, NULL),
(13, 15, 13, 2, '', '', 3, 24, 31, 'RESPONSABLE MUNICIPAL DE LA IMPLEMENTACIÓN DE LA POLĪTICA SAFCI MI SALUD EN EL MUNICIPIO DE CATACORA DEL DEPARTAMENTO DE LA PAZ', NULL, 4, 0, 0, '', NULL, NULL),
(14, 16, 14, 2, '', '', 3, 24, 31, 'JEFE DE ENSEÑANZA RESIDENCIA M&Eacute;DICA SAFCI', NULL, 4, 0, 0, '', NULL, NULL),
(15, 17, 15, 2, '', '', 3, 24, 31, 'MEDICO ESPECIALISTA SAFCI PARA EL CENTRO DE SALUD INTEGRAL HUACAYA SAN  LORENZO SINCERI DEL MUNICIPIO DE HUACAYA DEL DEPARTAMENTO DE CHUQUISACA', NULL, 3, 0, 0, '', NULL, NULL),
(16, 18, 16, 2, '', '', 3, 24, 31, 'RESPONSABLE DE LA IMPLEMENTACION DE LA POLITICA SAFCI Y MI SALUD EN EL MUNICIPIO DE SAN BORJA DEL DEPARTAMENTO DE BENI', NULL, 1, 0, 0, '', NULL, NULL),
(17, 19, 17, 2, '', '', 3, 24, 31, 'Médico SAFCI C.S.I San Jorge Municipio de Zudáñez Departamento de Chuquisaca', NULL, 3, 0, 0, '', NULL, NULL),
(18, 20, 18, 3, '', '', 0, 0, 0, '', NULL, 1, 94, 31, 'M&eacute;dico', NULL, NULL),
(19, 21, 19, 2, '', '', 1, 1, 33, 'Responsable Municipal', NULL, 9, 0, 0, '', NULL, NULL),
(20, 22, 20, 2, '', '', 3, 22, 18, 'RESPONSABLE MUNICIPAL SAFCI EN MUNICIPIO ROBORE', NULL, 8, 0, 0, '', NULL, NULL),
(21, 23, 21, 2, '', '', 3, 24, 31, 'Responsable Municipal Programa Safci Municipio Ravelo', NULL, 7, 0, 0, '', NULL, NULL),
(22, 24, 22, 2, '', '', 3, 24, 31, 'SAFCI-MI SALUD', NULL, 3, 0, 0, '', NULL, NULL),
(23, 25, 23, 2, '', '', 1, 1, 33, 'Medico Especialista Safci ', NULL, 8, 0, 0, '', NULL, NULL),
(24, 26, 24, 3, '', '', 0, 0, 0, '', NULL, 2, 78, 1194, 'MEDICO ESPECIALISTA SAFCI', NULL, NULL),
(25, 27, 25, 2, '', '', 1, 1, 0, 'RESPONSABLE DE LA IMPLEMENTACION DE LA POLITICA SAFCI C.S. RAFAEL PABON', NULL, 5, 0, 0, '', NULL, NULL),
(26, 28, 26, 3, '', '', 0, 0, 0, '', NULL, 9, 84, 3936, 'MEDICO SAFCI', NULL, NULL),
(27, 29, 27, 2, '', '', 1, 1, 33, 'Responsable de la implementación de la política SAFCI Mi Salud del municipio Puerto Perez', NULL, 4, 0, 0, '', NULL, NULL),
(28, 30, 0, 2, '', '', 3, 24, 31, 'jefe de enseñanza residencia medica SAFCI POTOSI', NULL, 7, 0, 0, '', NULL, NULL),
(29, 31, 28, 2, '', '', 1, 1, 33, 'JEFE DE ENSEÑANZA DE LA RESIDENCIA MEDICA SAFCI REGIONAL CHUQUISACA', NULL, 3, 0, 0, '', NULL, NULL),
(30, 32, 29, 2, '', '', 3, 24, 31, 'RESPONSABLE IMPLEMENTACION POLITICA SAFCI MI SALUD DEL AREA DEL CENTRO DE SALUD PLAN 500', NULL, 5, 0, 0, '', NULL, NULL),
(31, 27, 25, 2, '', '', 3, 24, 31, 'RESPOSABLE DE LA IMPLEMENTACION DE LA POLITICA SAFCI DEL C.S. RAFAEL PABON', NULL, 5, 0, 0, '', NULL, NULL),
(32, 33, 30, 2, '', '', 3, 24, 31, 'Encargado de Capacitación', NULL, 4, 0, 0, '', NULL, NULL),
(33, 34, 31, 2, '', '', 3, 24, 31, 'Coordinador Nacional - Programa SAFCI - MI SALUD', NULL, 4, 0, 0, '', NULL, NULL),
(34, 35, 32, 3, '', '', 0, 0, 0, '', NULL, 4, 26, 1951, 'Encargada de Capacitación Virtual', NULL, NULL),
(35, 36, 33, 3, '', '', 0, 0, 0, '', NULL, 5, 49, 2299, 'RESPONSABLE DE LA IMPLEMENTACION DE LA POLITICA SAFCI Y MI SALUD DEL\r\nAREA DEL C.S. CHIRIPUJIO.', NULL, NULL),
(36, 40, 34, 2, '', '', 3, 24, 31, 'Endocrinologo', NULL, 4, 0, 0, '', NULL, NULL),
(37, 41, 35, 3, '', '', 0, 0, 0, '', NULL, 4, 26, 1950, 'Médico', NULL, NULL),
(38, 42, 36, 3, '', '', 0, 0, 0, '', NULL, 4, 26, 1949, 'Consultor Implementador', NULL, NULL),
(39, 43, 37, 3, '', '', 0, 0, 0, '', NULL, 4, 29, 2018, 'Cirujano', NULL, NULL),
(40, 44, 38, 2, '', '', 3, 24, 31, 'Especialista Dermatologo', '342', 4, 0, 0, '', '', NULL),
(41, 46, 40, 3, '', '', 0, 0, 0, '', '', 4, 26, 1951, 'Medico General', '322', NULL),
(42, 47, 41, 2, '', '', 3, 24, 31, 'Administrador', '23122', 4, 0, 0, '', '', NULL),
(43, 48, 42, 2, '', '', 3, 24, 31, 'Medico Cirujano', '2341', 4, 0, 0, '', '', NULL),
(44, 49, 43, 2, '', '', 3, 24, 31, 'Especialista SAFCI', '342', 4, 0, 0, '', '', NULL),
(45, 50, 44, 2, '', '', 3, 24, 31, 'Especialista SAFCI', '321', 4, 0, 0, '', '', NULL),
(46, 51, 45, 2, '', '', 3, 24, 31, 'Especialista SAFCI', '342', 4, 0, 0, '', '', NULL),
(47, 52, 46, 2, '', '', 3, 24, 31, 'Especialista SAFCI', '320', 4, 0, 0, '', '', NULL),
(48, 53, 47, 2, '', '', 3, 24, 31, 'Especialista SAFCI', '322', 4, 0, 0, '', '', NULL),
(49, 54, 48, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'Especialista en Emergencias', '342', NULL),
(50, 55, 49, 2, '', '', 3, 24, 31, 'Especialista SAFCI', '123', 4, 0, 0, '', '', NULL),
(51, 56, 50, 2, '', '', 3, 24, 31, 'ESPECIALISTA SAFCI', '243', 4, 0, 0, '', '', NULL),
(52, 57, 0, 2, '', '', 3, 24, 31, 'ESPECIALISTA OFTALMÓLOGO', '3241', 4, 0, 0, '', '', NULL),
(53, 58, 51, 2, '', '', 3, 24, 31, 'ESPECIALISTA SAFCI', '421', 4, 0, 0, '', '', NULL),
(54, 59, 52, 2, '', '', 3, 24, 31, 'ESPECIALISTA SAFCI', '452', 4, 0, 0, '', '', NULL),
(55, 1, 1, 2, '', '', 3, 24, 31, 'ESPECIALISTA', '322', 4, 0, 0, '', '', NULL),
(56, 1, 1, 2, '', '', 3, 24, 31, 'CARGO', '231', 4, 0, 0, '', '', NULL),
(57, 58, 51, 2, '', '', 3, 24, 31, 'CARGO MDS ', '341', 4, 0, 0, '', '', NULL),
(58, 55, 49, 3, '', '', 0, 0, 0, '', '', 4, 26, 1947, 'CARGO', '223', NULL),
(59, 55, 49, 2, '', '', 3, 24, 31, 'CARGO', '221', 4, 0, 0, '', '', NULL),
(60, 55, 49, 3, '', '', 0, 0, 0, '', '', 4, 26, 1949, 'Medico Especialista', '112', NULL),
(61, 55, 49, 3, '', '', 0, 0, 0, '', '', 4, 28, 1984, 'MEDICO GENERAL', '122', NULL),
(62, 55, 49, 3, '', '', 0, 0, 0, '', '', 3, 10, 548, 'M&eacute;dico para Medicina Interna', '221', NULL),
(63, 55, 49, 3, '', '', 0, 0, 0, '', '', 4, 29, 2018, 'Especialista SAFCI', '233', NULL),
(64, 55, 49, 3, '', '', 0, 0, 0, '', '', 4, 22, 1888, 'Especialista safci', '234', NULL),
(65, 60, 53, 3, '', '', 0, 0, 0, '', '', 4, 79, 1729, 'CARGO DE ACUERDO A MEMORADUM DE DESIGNACIÓN.', '3214', NULL),
(66, 62, 55, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'ESPECIALISTA SAFCI', '321', NULL),
(67, 63, 56, 3, '', '', 0, 0, 0, '', '', 4, 22, 1892, 'MEDICO ESPECIALISTA ', '342', 12),
(68, 64, 57, 3, '', '', 0, 0, 0, '', '', 4, 22, 1891, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN.', '322', 18),
(69, 65, 58, 3, '', '', 0, 0, 0, '', '', 4, 22, 1884, 'CARGO:\r\n(DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN)', '322', 14),
(70, 66, 59, 3, '', '', 0, 0, 0, '', '', 4, 21, 1873, 'MEDICO ESPECIALISTA SAFCI', '3321', 13),
(71, 67, 60, 3, '', '', 0, 0, 0, '', '', 4, 26, 1947, 'CARGO (DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '320', 13),
(72, 68, 61, 3, '', '', 0, 0, 0, '', '', 4, 28, 1996, 'ENCARAGDO DE RADIOLOGÍA', '422', 16),
(73, 69, 62, 3, '', '', 0, 0, 0, '', '', 4, 21, 1875, 'MEDICO ESPECIALISTA SAFCI', '344', 14),
(74, 70, 63, 3, '', '', 0, 0, 0, '', '', 4, 26, 1947, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '422', 12),
(75, 71, 64, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '322', 14),
(76, 71, 64, 3, '', '', 0, 0, 0, '', '', 4, 22, 1898, 'CARGO DE ACUERDO A MEMOR&Aacute;NDUM DE DESIGNACI&Oacute;N', '322', 12),
(77, 71, 64, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'CARGO DE ACUERDO A MEMOR&Aacute;NDUM DE DESIGNACI&Oacute;N.', '244', 14),
(78, 70, 63, 3, '', '', 0, 0, 0, '', '', 5, 46, 2413, 'CARGO DE ACUERDO A MEMOR&Aacute;NDUM DE DESIGNACI&Oacute;N.', '322', 12),
(79, 72, 65, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN)', '321', 12),
(80, 73, 66, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN.', '232', 11),
(81, 74, 67, 3, '', '', 0, 0, 0, '', '', 4, 26, 1950, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN.', '442', 14),
(82, 75, 68, 3, '', '', 0, 0, 0, '', '', 4, 22, 1898, 'CARGO DE ACUERDO A MEMORÁNDUM DE DESIGNACIÓN', '232', 12),
(83, 76, 69, 3, '', '', 0, 0, 0, '', '', 4, 26, 1948, 'CARGO', '231', 12),
(84, 75, 68, 3, '', '', 0, 0, 0, '', '', 1, 102, 91, 'CARGO', '2213', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE `departamento` (
  `iddepartamento` int(11) NOT NULL,
  `departamento` varchar(45) DEFAULT NULL,
  `sigla` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`iddepartamento`, `departamento`, `sigla`) VALUES
(1, 'BENI', 'BE'),
(2, 'COCHABAMBA', 'CB'),
(3, 'CHUQUISACA', 'CH'),
(4, 'LA PAZ', 'LP'),
(5, 'ORURO', 'OR'),
(6, 'PANDO', 'PD'),
(7, 'POTOSI', 'PO'),
(8, 'SANTA CRUZ', 'SC'),
(9, 'TARIJA', 'TJ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia`
--

CREATE TABLE `dependencia` (
  `iddependencia` int(11) NOT NULL,
  `dependencia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencia`
--

INSERT INTO `dependencia` (`iddependencia`, `dependencia`) VALUES
(1, 'OTRA ENTIDAD'),
(2, 'MINISTERIO DE SALUD'),
(3, 'RED DE SALUD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencia_institucion`
--

CREATE TABLE `dependencia_institucion` (
  `iddependencia_institucion` int(11) NOT NULL,
  `dependencia_institucion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `dependencia_institucion`
--

INSERT INTO `dependencia_institucion` (`iddependencia_institucion`, `dependencia_institucion`) VALUES
(1, 'ABEN    '),
(2, 'ARMADA                             '),
(3, 'C.C.H. - (Ministerio)              '),
(4, 'C.I.E.S.                           '),
(5, 'Cabildo Indigenal                  '),
(6, 'Caja Bancaria Estatal              '),
(7, 'Caja de Salud CORDES               '),
(8, 'Caja de Salud de Caminos y R.A.    '),
(9, 'Caja de Salud de La Banca Privada  '),
(10, 'Caja Nacional de Salud             '),
(11, 'Caja Petrolera de Salud            '),
(12, 'CEMES                              '),
(13, 'COSSMIL                            '),
(14, 'Entidades Privadas                 '),
(15, 'Fundación Contra el Hambre - (Min.)'),
(16, 'Fundación Pro Centro del Quemado   '),
(17, 'G.A.D.                             '),
(18, 'G.A.M.                             '),
(19, 'Iglesia Católica                   '),
(20, 'Ministerio - CARE                  '),
(21, 'MINISTERIO DE SALUD Y DEPORTES     '),
(22, 'No Católica                        '),
(23, 'ONG                                '),
(24, 'Policia Nacional                   '),
(25, 'Por definir ( FFAA )               '),
(26, 'PROSALUD                           '),
(27, 'S.A.C.O.A. - Alcaldía              '),
(28, 'Seguro Delegado (CNS)              '),
(29, 'Seguro Universitario Beni          '),
(30, 'Seguro Universitario Chuquisaca    '),
(31, 'Seguro Universitario Cochabamba    '),
(32, 'Seguro Universitario La Paz        '),
(33, 'Seguro Universitario Oruro         '),
(34, 'Seguro Universitario Pando         '),
(35, 'Seguro Universitario Potosi        '),
(36, 'Seguro Universitario Santa Cruz    '),
(37, 'Seguro Universitario Tarija        '),
(38, 'SINEC                              '),
(39, 'UNICEF. - (Ministerio)             '),
(40, 'UNICEF. - C.C.H. - Min.            '),
(41, 'UNICEF. - Iglesia                  '),
(42, 'Universidad                        ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `iddireccion` int(11) NOT NULL,
  `idministerio` int(11) DEFAULT NULL,
  `direccion` text,
  `sigla` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`iddireccion`, `idministerio`, `direccion`, `sigla`, `idusuario`) VALUES
(1, 1, 'Despacho Ministerio de Salud y Deportes', 'DESP-MSYD', 5),
(2, 1, 'Dirección General de Asuntos Jurídicos', 'DGAJ', 5),
(3, 1, 'Dirección General de Asuntos Administrativos', 'DGAA', 5),
(4, 1, 'Dirección General de Planificación', 'DGP', 5),
(5, 1, 'Autoridad de Supervición de la Seguridad Social de Corto Plazo', 'ASSUS', 5),
(6, 1, 'Loteria Nacional de Beneficencia', 'LONABOL', 5),
(7, 1, 'Instituto Nacional de Salud Ocupacional', 'INSO', 5),
(8, 1, 'Instituto Boliviano de la Ceguera', 'IBC', 5),
(9, 1, 'Central de Abastecimiento y Suministros', 'CEASS', 5),
(10, 1, 'Agencia de Infraestuctura en Salud y Equipamiento Médico', 'AISEM', 5),
(11, 1, 'Caja de Salud de la Banca Privada', 'CSBP', 5),
(12, 1, 'Caja Bancaria Estatal de Salud', 'CBES', 5),
(13, 1, 'Caja Nacional de Salud', 'CNS', 5),
(14, 1, 'Caja de Salud Cordes', 'CSC', 5),
(15, 1, 'Caja Petrolera de Salud', 'CPS', 5),
(16, 1, 'Caja de Salud del Servicio Nacional Caminos y Ramas Anexas', 'CSSNC', 5),
(17, 1, 'Seguro Integral de Salud', 'SINEC', 5),
(18, 1, 'Seguros Sociales Universitarios', 'SSU', 5),
(19, 1, 'Seguros Delegados en Bolivia', 'SDB', 5),
(20, 2, 'Dirección General de Redes de Servicios de Salud', 'DGRSS', 5),
(21, 2, 'Dirección General de Gestión Hospitalaria', 'DGGH', 5),
(22, 3, 'Dirección General de Promoción y Prevención de Salud', 'DGPPS', 5),
(23, 3, 'Dirección General de Medicina Tradicional', 'DGMT', 5),
(24, 3, 'Dirección General de Epidemiología', 'DGE', 5),
(25, 4, 'Dirección General de Gestión Nacional del Sistema Unico de Salud', 'DGGSUS', 5),
(26, 4, 'Dirección General de Seguros de Salud de Corto Plazo', 'DGSSCP', 5),
(27, 5, 'Dirección General de Deportes', 'DGD', 5),
(28, 5, 'Dirección General de Formación Deportiva', 'DGFD', 5),
(29, 1, 'Agencia Estatal de Medicamentos y Tecnologias en Salud', 'AGMED', 5),
(30, 1, 'Centro Nacional de Enfermedades Tropicales', 'CENETROP', 5),
(31, 1, 'Instituto Nacional de Laboratorios de Salud', 'INLASA', 5),
(32, 1, 'Escuela Nacional de Salud - La Paz', 'ENSLP', 5),
(33, 1, 'Escuela Técnica de Salud Boliviana Japonesa de Coperación Andina - CBBA', 'ETSBJ', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `iddocente` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `idnombre_datos` int(11) DEFAULT NULL,
  `iddato_laboral` int(11) DEFAULT NULL,
  `idresidencia` int(11) DEFAULT NULL,
  `idestado_docente` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`iddocente`, `idusuario`, `idnombre`, `idnombre_datos`, `iddato_laboral`, `idresidencia`, `idestado_docente`, `fecha_registro`) VALUES
(1, 4, 3, 3, 3, 4, 1, '2023-08-09'),
(2, 9, 1, 1, 1, 4, 1, '2023-08-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad_docente`
--

CREATE TABLE `especialidad_docente` (
  `idespecialidad_docente` int(11) NOT NULL,
  `iddocente` int(11) DEFAULT NULL,
  `idtematica` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `especialidad_docente`
--

INSERT INTO `especialidad_docente` (`idespecialidad_docente`, `iddocente`, `idtematica`) VALUES
(1, 1, 2),
(2, 2, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidad_medica`
--

CREATE TABLE `especialidad_medica` (
  `idespecialidad_medica` int(11) NOT NULL,
  `especialidad_medica` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `especialidad_medica`
--

INSERT INTO `especialidad_medica` (`idespecialidad_medica`, `especialidad_medica`) VALUES
(1, 'ANATOMÍA PATOLOGICA'),
(2, 'ANESTESIOLOGÍA'),
(3, 'CARDIOLOGÍA'),
(4, 'CARDIOLOGÍA PEDIÁTRICA'),
(5, 'CIRUGÍA BUCOMAXILOFACIAL'),
(6, 'CIRUGÍA GENERAL'),
(7, 'CIRUGÍA ONCOLÓGICA'),
(8, 'CIRUGÍA PEDIÁTRICA'),
(9, 'COLOPROCTOLOGÍA'),
(10, 'DERMATOLOGÍA'),
(11, 'EMERGENCIOLOGÍA'),
(12, 'ENDOCRINOLOGÍA'),
(13, 'GASTROENTEROLOGÍA CLÍNICA'),
(14, 'GERIATRíA Y GERONTOLOGÍA'),
(15, 'GINECOLOGÍA Y OBSTETRICIA'),
(16, 'HEMATOLOGÍA Y MEDICINA TRANSFUSIONAL'),
(17, 'IMAGENOLOGÍA'),
(18, 'INFECTOLOGÍA PEDIÁTRICA'),
(19, 'MEDICINA CRÍTICA Y TERAPIA INTENSIVA'),
(20, 'MEDICINA DEL DOLOR'),
(21, 'MEDICINA DEL TRABAJO'),
(22, 'MEDICINA FAMILIAR'),
(23, 'MEDICINA FÍSICA Y REHABILITACIÓN'),
(24, 'MEDICINA INTERNA'),
(25, 'MEDICINA MATERNO FETAL'),
(26, 'NEFROLOGÍA'),
(27, 'NEONATOLOGÍA'),
(28, 'NEUMOLOGÍA'),
(29, 'NEUROCIRUGÍA'),
(30, 'NEUROLOGÍA'),
(31, 'NEUROLOGIA PEDIÁTRCA'),
(32, 'OFTALMOLOGÍA'),
(33, 'ONCOLOGÍA CLÍNICA'),
(34, 'ONCOLOGÍA GINECOLÓGICA'),
(35, 'ONCOLOGÍA PEDIÁTRICA'),
(36, 'ORTOPEDIA PEDIÁTRICA'),
(37, 'OTORRINOLARINGOLOGÍA'),
(38, 'PEDIATRÍA'),
(39, 'PSIQUIATRÍA'),
(40, 'REUMATOLOGÍA'),
(41, 'SALUD FAMILIAR COMUNITARIA INTERCULTURAL'),
(42, 'TERAPIA INTENSIVA PEDIÁTRICA'),
(43, 'TRAUMATOLOGÍA Y ORTOPEDIA'),
(44, 'UROLOGÍA'),
(45, 'OTRA'),
(46, 'MEDICINA GENERAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `establecimiento_salud`
--

CREATE TABLE `establecimiento_salud` (
  `idestablecimiento_salud` int(11) NOT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idred_salud` int(11) DEFAULT NULL,
  `idmunicipio` int(11) DEFAULT NULL,
  `codigo_establecimiento` varchar(45) DEFAULT NULL,
  `establecimiento_salud` text,
  `idtipo_establecimiento` int(11) DEFAULT NULL,
  `idnivel_establecimiento` int(11) DEFAULT NULL,
  `idsubsector_salud` int(11) DEFAULT NULL,
  `iddependencia_institucion` int(11) DEFAULT NULL,
  `idambito_local` int(11) DEFAULT NULL,
  `latitud` varchar(45) DEFAULT NULL,
  `longitud` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `establecimiento_salud`
--

INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(1, 1, 94, 19, '800002', 'CASARABE', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2, 1, 94, 19, '800003', 'LOMA SUAREZ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3, 1, 94, 19, '800004', 'HOSP. MATERNO INFANTIL                                                ', 11, 3, 6, 17, 2, '-16.511292', '-68.133702', 1, '2023-10-09'),
(4, 1, 94, 19, '800005', 'HOSP. GERMAN BUSCH                                                    ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(5, 1, 94, 19, '800006', 'C.S. INTERNACION CENTRAL', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(6, 1, 94, 19, '800007', 'SAN JOSE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(7, 1, 94, 19, '800008', 'SAN VICENTE', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(8, 1, 94, 19, '800009', 'PEDRO MARBAN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(9, 1, 94, 19, '800010', 'POMPEYA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(10, 1, 94, 19, '800011', 'POLICONS. CAJA PETROLERA                                              ', 17, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(11, 1, 94, 19, '800012', 'HOSP. COSSMIL                                                         ', 12, 2, 7, 13, 2, NULL, NULL, NULL, NULL),
(12, 1, 94, 19, '800013', 'HOSP. OBRERO # 8                                                      ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(13, 1, 94, 19, '800015', 'CENTRO DE SALUD CARITAS                                            ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(14, 1, 94, 19, '800016', '12 DE ABRIL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(15, 1, 94, 19, '800017', 'PUERTO ALMACEN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(16, 1, 94, 19, '800018', 'VILLA VECINAL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(17, 1, 94, 19, '800019', 'CIPRIANO BARACE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(18, 1, 94, 19, '800022', 'COMPLEJO DE SALUD                                          ', 3, 1, 6, 42, 2, NULL, NULL, NULL, NULL),
(19, 1, 94, 19, '800023', 'PLATAFORMA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(20, 1, 94, 19, '800024', 'CSBP - POLICONSULTORIO TRINIDAD', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(21, 1, 94, 19, '800025', 'NUEVA TRINIDAD', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(22, 1, 94, 19, '800027', 'IVIATO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(23, 1, 94, 19, '800162', 'EL TOTAI', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(24, 1, 94, 19, '800177', 'VILLA MONASTERIO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(25, 1, 94, 19, '800178', 'MANGALITO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(26, 1, 94, 19, '800179', 'PUERTO BALLIVIAN', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(27, 1, 94, 19, '800180', 'POLICONS. CAJA DE SALUD CORDES                                        ', 17, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(28, 1, 94, 19, '800181', 'ACILO DE ANCIANOS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(29, 1, 94, 19, '800182', 'PUERTO VARADOR', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(30, 1, 94, 19, '800213', 'MANA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(31, 1, 94, 19, '800214', 'C.S. INTERNACION 30 DE JULIO', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(32, 1, 94, 19, '800221', 'PEDRO IGNACIO MUIBA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(33, 1, 94, 19, '800223', 'CDVIR - BENI', 2, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(34, 1, 94, 19, '800226', 'PRO VIDA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(35, 1, 94, 19, '800231', 'POLICONS. POLICIA BOLIVIANA BENI                                      ', 17, 1, 5, 24, 2, NULL, NULL, NULL, NULL),
(36, 1, 94, 19, '800243', 'P.S. INNOVASALUD S.A. EL CARMEN                                         ', 18, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(37, 1, 94, 19, '800247', 'POLICONS. CAJA DE CAMINOS                                             ', 17, 1, 7, 8, 2, '-16.511513', '-68.134827', 1, '2023-09-20'),
(38, 1, 94, 19, '800248', 'BANCO DE SANGRE DE REFERENCIA DEPARTAMENTAL BENII', 1, 4, 6, 17, 2, NULL, NULL, NULL, NULL),
(39, 1, 94, 19, '800249', 'C.S. CLÍNICA MATER DEI                                                ', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(40, 1, 94, 19, '800266', 'SEGURO SOCIAL UNIVERSITARIO-BENI                                      ', 17, 1, 7, 29, 2, NULL, NULL, NULL, NULL),
(41, 1, 94, 19, '800267', 'CENTRO INTEGRAL DE  MEDICINA FAMILIAR                                 ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(42, 1, 94, 19, '800274', 'SALUD AMBIENTAL BENI', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(43, 1, 94, 19, '800280', 'CARCELETA  MOCOVI VARONES', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(44, 1, 94, 19, '800284', 'SANTA GRACIA SRL.', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(45, 1, 94, 19, '800288', 'CLINICA REDAMAR', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(46, 1, 94, 19, '800290', 'LABORATORIO SEDES', 2, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(47, 1, 94, 19, '800291', '\"CENTRO DE DIAGN. Y CONSULTORIO ODONTOLOGICO \"\"DR. ELOY ÁVILA  ALBERDI\"\"\"', 3, 1, 4, 42, 1, NULL, NULL, NULL, NULL),
(48, 1, 94, 19, '800324', 'CLINICA VELASCO BACIGALUPO', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(49, 1, 94, 19, '800325', 'C.S.A. NUEVA JERUSALEN', 3, 1, 6, 17, 2, NULL, NULL, NULL, NULL),
(50, 1, 94, 19, '800326', 'CAJA DE LA BANCA ESTATAL DE SALUD - REGIONAL TRINIDAD', 5, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(51, 1, 94, 19, '800330', 'CENTRO DE REHABILITACIÓN PARA PERSONAS CON DISCAPACIDAD', 2, 1, 6, 17, 2, NULL, NULL, NULL, NULL),
(52, 1, 94, 19, '800331', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD - BENI', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(53, 1, 94, 19, '800332', 'CLINICA CORDES', 12, 2, 7, 7, 2, NULL, NULL, NULL, NULL),
(54, 1, 94, 19, '800346', 'CENTRO MEDICO Y DE DIAGNOSTICO DMI', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(55, 1, 94, 14, '800028', 'LAGUNA COLORADA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(56, 1, 94, 14, '800029', 'NUEVO ISRAEL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(57, 1, 94, 14, '800030', 'SAN JAVIER', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(58, 1, 94, 14, '800031', 'SAN PEDRO NUEVO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(59, 1, 94, 14, '800253', 'AVAROA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(60, 1, 94, 14, '800269', 'PATA DE AGUILA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(61, 1, 99, 8, '800075', 'SAN JUAN DE DIOS', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(62, 1, 99, 8, '800076', 'POLICONSULTORIO  REYES                                           ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(63, 1, 99, 8, '800077', 'BAQUETI                                                          ', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(64, 1, 99, 8, '800078', 'RATIJE                                                           ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(65, 1, 99, 8, '800079', 'PUERTO CAVINAS', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(66, 1, 99, 8, '800173', 'CARMEN ALTO DE HENESHUAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(67, 1, 99, 8, '800176', 'CALIFORNIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(68, 1, 99, 8, '800259', 'PENA AMARILLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(69, 1, 99, 18, '800087', 'C.S. I. SANTA ROSA ', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(70, 1, 99, 18, '800088', 'AUSTRALIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(71, 1, 99, 18, '800089', 'POLICON. SANTA ROSA                                                   ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(72, 1, 99, 18, '800090', 'C.S.I. PUERTO YATA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(73, 1, 99, 18, '800193', 'PUERTO TEREZA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(74, 1, 99, 18, '800205', 'CERRITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(75, 1, 99, 18, '800206', 'LAS PETAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(76, 1, 99, 18, '800207', 'P.S EL CANDADO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(77, 1, 99, 18, '800268', 'JUAN EVO MORALES AYMA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(78, 1, 99, 10, '800091', 'COLLANA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(79, 1, 99, 10, '800092', 'NUEVO HORIZONTE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(80, 1, 99, 10, '800093', 'HOSP. RURRENABAQUE', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(81, 1, 99, 10, '800094', 'POLICON. RURRENABAQUE                                                 ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(82, 1, 99, 10, '800160', 'PIEDRAS BLANCAS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(83, 1, 99, 10, '800175', 'NIÑO JESUS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(84, 1, 99, 10, '800194', 'C.S.A.VILLA AROMA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(85, 1, 99, 10, '800257', 'EL CAUCHAL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(86, 1, 99, 10, '800258', 'ASUNCION DEL QUIQUIBEY', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(87, 1, 99, 10, '800283', 'C.S.A LOS SAUCES', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(88, 1, 99, 10, '800285', 'C.S..A. EL CEBU ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(89, 1, 99, 10, '800298', 'CENTRO DE SALUD MILITAR COSSMIL RURRENABAQUE', 8, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(90, 1, 102, 12, '800080', 'EL PALMAR', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(91, 1, 102, 12, '800081', 'GALILEA', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(92, 1, 102, 12, '800082', 'HOREB', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(93, 1, 102, 12, '800083', 'PUEBLO NUEVO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(94, 1, 102, 12, '800084', 'HOSPITAL MUNICIPAL DR. JOSE EDUARDO OLMOS MAEDA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(95, 1, 102, 12, '800085', 'POLICON. SAN BORJA                                                    ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(96, 1, 102, 12, '800086', 'YUCUMO', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(97, 1, 102, 12, '800165', 'MISION FATIMA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(98, 1, 102, 12, '800166', 'QUIQUIBEY', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(99, 1, 102, 12, '800174', 'JUNRRENO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(100, 1, 102, 12, '800192', 'LA EMBOCADA', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(101, 1, 102, 12, '800227', 'VIRGEN DEL CARMEN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(102, 1, 102, 12, '800260', 'LA CRUZ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(103, 1, 102, 12, '800261', 'VILLA BORJANA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(104, 1, 102, 12, '800262', 'LAS ABRAS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(105, 1, 102, 12, '800263', 'VILLA INGAVI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(106, 1, 102, 12, '800300', 'CHACAL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(107, 1, 102, 12, '800328', 'CENTRO DE SALUD TSIMANÉ DEL RIO MANIQUI', 8, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(108, 1, 102, 12, '800334', 'CENTRO DE SALUD SAGRADO CORAZON', 8, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(109, 1, 102, 12, '800337', 'CENTRO DE REHABILITACION PARA PERSONAS CON DISCAPACIDAD', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(110, 1, 102, 12, '800343', 'C.S.I SAN MIGUEL DEL MARTIRIO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(111, 1, 102, 12, '800344', 'C.S.I. TACUARAL DEL MATTO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(112, 1, 96, 6, '800142', 'BELLA VISTA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(113, 1, 96, 6, '800143', 'BUENA VISTA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(114, 1, 96, 6, '800144', 'LA CAYOBA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(115, 1, 96, 6, '800145', 'BOLIVIANO CANADIENSE MA. MAGDALENA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(116, 1, 96, 6, '800147', 'POLICON.  MAGDALENA                                                   ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(117, 1, 96, 6, '800148', 'NUEVA CALAMA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(118, 1, 96, 6, '800149', 'OROBAYAYA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(119, 1, 96, 6, '800150', 'SAN BORJA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(120, 1, 96, 6, '800151', 'VERSALLES', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(121, 1, 96, 6, '800235', 'NUEVA BREMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(122, 1, 96, 6, '800250', 'PARROQUIAL BELLA VISTA                                           ', 4, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(123, 1, 96, 6, '800347', 'C. V. 3 DE MAYO ', 10, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(124, 1, 96, 1, '800152', 'HUGO BANZER (BAURES)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(125, 1, 96, 1, '800153', 'CAFETAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(126, 1, 96, 1, '800154', 'JASIAQUIRI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(127, 1, 96, 1, '800155', 'REMANZO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(128, 1, 96, 1, '800167', 'EL CAIRO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(129, 1, 96, 1, '800244', 'TIQUIN', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(130, 1, 96, 1, '800245', 'POLICONSULTORIO C.N.S                                                 ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(131, 1, 96, 1, '800256', 'CERRO SAN SIMON', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(132, 1, 96, 4, '800156', 'C.S.I. EL CARMEN DE ITENEZ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(133, 1, 96, 4, '800157', 'SAN MARTIN DE PORRES', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(134, 1, 96, 4, '800252', 'LA EMBROLLA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(135, 1, 97, 15, '800135', 'PUESTO DE SALUD MONTE AZUL ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(136, 1, 97, 15, '800136', 'HENRY K. BEYE', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(137, 1, 97, 15, '800137', 'POLICON. SAN JOAQUIN                                                  ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(138, 1, 97, 15, '800297', 'PUERTO USTARES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(139, 1, 97, 16, '800138', 'SAN RAMON', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(140, 1, 97, 16, '800139', 'POLICON. SAN RAMON                                                    ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(141, 1, 97, 16, '800299', 'P.S. EL CARMEN DE GUAYACANES - VILLA EL CARMEN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(142, 1, 97, 7, '800140', 'PUERTO SILES', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(143, 1, 97, 7, '800141', 'PUESTO DE SALUD STA. ROSA DE VIGO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(144, 1, 97, 7, '800191', 'PUESTO DE SALUD ALEJANDRIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(145, 1, 94, 5, '800121', 'CAMIACO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(146, 1, 94, 5, '800122', 'GUNDONOVIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(147, 1, 94, 5, '800123', 'LORETO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(148, 1, 94, 5, '800124', 'EL ROSARIO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(149, 1, 94, 5, '800125', 'SACHOJERE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(150, 1, 94, 5, '800126', 'SAN ANTONIO DE LORAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(151, 1, 94, 5, '800233', 'SAN PABLO DEL ISIBORO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(152, 1, 94, 5, '800287', 'VILLA EL CARMEN DEL REMANZO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(153, 1, 94, 11, '800127', 'NUEVA BETANIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(154, 1, 94, 11, '800128', 'SAN ANDRES', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(155, 1, 94, 11, '800129', 'VILLA SAN PEDRO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(156, 1, 94, 11, '800130', 'SAN LORENZO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(157, 1, 94, 11, '800131', 'PUENTE SAN PABLO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(158, 1, 94, 11, '800132', 'SANTA ROSA KM-100', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(159, 1, 94, 11, '800133', 'SOMOPAE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(160, 1, 94, 11, '800134', 'VILLA ALBA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(161, 1, 94, 11, '800183', 'PEROTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(162, 1, 94, 11, '800184', 'NUEVA MAGDALENA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(163, 1, 94, 11, '800228', 'ABACUYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(164, 1, 94, 11, '800229', 'CARMEN DEL DORADO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(165, 1, 94, 11, '800230', 'ELVIRA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(166, 1, 94, 11, '800271', 'C.S.A. TERRASUR                                                       ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(167, 1, 94, 11, '800275', 'REMANSO DEL PARAISO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(168, 1, 94, 11, '800276', 'PUENTES CAIMANES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(169, 1, 94, 11, '800289', 'P.S. UNION Y FE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(170, 1, 94, 11, '800302', 'P.S. MONTECRISTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(171, 1, 95, 13, '800101', 'ARGENTINA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(172, 1, 95, 13, '800102', 'BERMEO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(173, 1, 95, 13, '800103', 'DESENGANO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(174, 1, 95, 13, '800104', 'FATIMA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(175, 1, 95, 13, '800105', 'LAS MERCEDES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(176, 1, 95, 13, '800106', 'MONTE GRANDE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(177, 1, 95, 13, '800107', 'PARROQUIAL VINARASIRARE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(178, 1, 95, 13, '800108', 'CENTRO DE SALUD INTEGRAL 3 DE NOVIEMBRE', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(179, 1, 95, 13, '800109', 'SAN FRANCISCO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(180, 1, 95, 13, '800110', 'C.S. AMBULATORIO SAN IGNACIO                                            ', 3, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(181, 1, 95, 13, '800111', 'PUERTO SAN BORJA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(182, 1, 95, 13, '800112', 'NUEVA GALILEA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(183, 1, 95, 13, '800113', 'SAN JOSE DEL CABITO- TIM', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(184, 1, 95, 13, '800114', 'SAN LORENZO DE MOXOS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(185, 1, 95, 13, '800115', 'SANTA RITA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(186, 1, 95, 13, '800116', 'SANTA ROSA DEL APERE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(187, 1, 95, 13, '800117', 'SANTISIMA TRINIDAD', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(188, 1, 95, 13, '800118', 'PUERTO SAN LORENZO TIPNIS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(189, 1, 95, 13, '800158', 'OROMOMO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(190, 1, 95, 13, '800168', 'SAN MIGUEL DEL APERE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(191, 1, 95, 13, '800169', 'VILLA ESPERANZA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(192, 1, 95, 13, '800170', 'LITORAL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(193, 1, 95, 13, '800186', 'SANTIAGO DEL ICHOA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(194, 1, 95, 13, '800187', 'SAN LUIS SANTA ROSA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(195, 1, 95, 13, '800188', 'VILLA NINA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(196, 1, 95, 13, '800201', 'PUEBLO NUEVO MOXOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(197, 1, 95, 13, '800220', 'BRIGADA MOVIL LA PASCANA', 3, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(198, 1, 95, 13, '800277', 'SAN MIGUELITO DE MOXOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(199, 1, 95, 13, '800279', 'MONTE GRANDE KM. 5', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(200, 1, 95, 13, '800293', 'P.S. NATIVIDAD DEL RETIRO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(201, 1, 95, 13, '800305', 'P.S. SAN BERNARDO', 18, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(202, 1, 95, 13, '800306', 'TRINIDACITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(203, 1, 95, 13, '800307', 'FLORIDA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(204, 1, 95, 13, '800339', 'SAN MIGUELITO DEL ISIBORO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(205, 1, 95, 13, '800340', 'SAN MIGUEL DEL MATIRE (TIMI)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(206, 1, 95, 13, '800345', 'P.S. MERCEDES DEL CAVITU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(207, 1, 100, 9, '800032', '12 DE OCTUBRE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(208, 1, 100, 9, '800033', 'BELLA FLOR', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(209, 1, 100, 9, '800034', 'BUEN DESTINO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(210, 1, 100, 9, '800035', 'EL CERRITO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(211, 1, 100, 9, '800036', 'CANDELARIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(212, 1, 100, 9, '800037', 'ALTO IVON', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(213, 1, 100, 9, '800038', 'LA ESPERANZA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(214, 1, 100, 9, '800039', 'NAZARETH', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(215, 1, 100, 9, '800041', 'H.B. RIBERALTA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(216, 1, 100, 9, '800042', 'CONAVI', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(217, 1, 100, 9, '800043', 'SAN ANDRES', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(218, 1, 100, 9, '800044', 'SAN JOSE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(219, 1, 100, 9, '800045', 'PUEBLO NUEVO', 4, 1, 6, 18, 2, '-16.511385', '-68.133531', 1, '2023-09-28'),
(220, 1, 100, 9, '800046', 'LA UNIDAD', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(221, 1, 100, 9, '800051', 'HOSP. MATERNO REIDUM ROINE', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(222, 1, 100, 9, '800052', 'RENE SALAZAR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(223, 1, 100, 9, '800054', 'CRISTO REY', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(224, 1, 100, 9, '800055', 'SAN JUAN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(225, 1, 100, 9, '800056', 'SANTA MARIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(226, 1, 100, 9, '800057', 'TUMICHUCUA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(227, 1, 100, 9, '800058', 'WARNES', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(228, 1, 100, 9, '800195', 'DR. CESAR MOSCOSO C.', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(229, 1, 100, 9, '800196', 'TARUMA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(230, 1, 100, 9, '800202', 'TAMARINDO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(231, 1, 100, 9, '800232', 'SAN ANTONIO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(232, 1, 100, 9, '800234', 'HOSPITAL OBRERO NO 69                                                 ', 12, 2, 7, 10, 2, NULL, NULL, NULL, NULL),
(233, 1, 100, 9, '800254', 'LOS CAYUCES', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(234, 1, 100, 9, '800255', 'CLINICA 4 DE DICIEMBRE                                           ', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(235, 1, 100, 9, '800264', 'CONSUELO DEL ROSARIO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(236, 1, 100, 9, '800265', 'POLICLINICO CAJA DE SALUD CAMINOS                                     ', 16, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(237, 1, 100, 9, '800272', 'SANTA ELENA DEL LAGO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(238, 1, 100, 9, '800281', 'CARCELETA PUBLICA RIBERALTA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(239, 1, 100, 9, '800294', 'CAJA PETROLERA DE SALUD', 17, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(240, 1, 100, 9, '800295', 'VICTORIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(241, 1, 100, 9, '800296', 'PUERTO CHACOBO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(242, 1, 100, 9, '800301', 'CIMFA LOS ALMENDROS ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(243, 1, 100, 9, '800304', 'CRVIR RIBERALTA', 2, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(244, 1, 100, 9, '800327', '\"C.S.C.I. ETNICO \"\"CIRABO\"\"\"', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(245, 1, 100, 9, '800329', 'COSSMIL RIBERALTA', 2, 1, 7, 13, 1, NULL, NULL, NULL, NULL),
(246, 1, 100, 9, '800336', 'INNOVASALUD S.A. CENTRAL RIBERALTA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(247, 1, 101, 3, '800059', 'PUESTO DE SALUD BARRANCO COLORADO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(248, 1, 101, 3, '800060', 'CACHUELA ESPERANZA', 4, 1, 6, 18, 1, '-16.511414', '-68.134324', 1, '2023-09-27'),
(249, 1, 101, 3, '800061', 'POLICONS. COSSMIL (GUAYARA)                                           ', 17, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(250, 1, 101, 3, '800062', 'HOSP. LUIS ALBERTO NAVARRO RODRIGUEZ ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(251, 1, 101, 3, '800063', 'SAN GABRIEL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(252, 1, 101, 3, '800064', 'SAN JOAQUIN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(253, 1, 101, 3, '800065', 'SAN ISIDRO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(254, 1, 101, 3, '800066', '1 DE MAYO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(255, 1, 101, 3, '800069', 'HOSPITAL OBRERO Nº 15 GUAYARAMERIN                                    ', 12, 2, 7, 10, 2, NULL, NULL, NULL, NULL),
(256, 1, 101, 3, '800070', 'C.S.A. CAJA PETROLERA DE SALUD SUB ZONAL GYA.                           ', 3, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(257, 1, 101, 3, '800071', 'ROSARIO DEL YATA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(258, 1, 101, 3, '800072', 'SAN LORENZO - GUAYARA', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(259, 1, 101, 3, '800073', 'SAN MIGUEL', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(260, 1, 101, 3, '800074', 'VILLA BELLA', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(261, 1, 101, 3, '800159', 'LOS ALMENDROS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(262, 1, 101, 3, '800163', 'HOSPITAL MATERNO INFANTIL GUAYARAMERIN', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(263, 1, 101, 3, '800164', 'COM. 1RO. DE MAYO', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(264, 1, 101, 3, '800210', 'GUAYARAGUAZU', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(265, 1, 101, 3, '800211', 'SIMON BOLIVAR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(266, 1, 101, 3, '800282', 'CARCELETA LAS PALMAS  - GUAYARAMERIN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(267, 1, 101, 3, '800303', 'C.S.A  31 DE ENERO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(268, 1, 101, 3, '800335', 'CRVIR GUAYARAMERIN', 2, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(269, 1, 98, 17, '800095', 'AUGUSTO MORENO', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(270, 1, 98, 17, '800096', 'POLICON. SANTA ANA                                                    ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(271, 1, 98, 17, '800097', 'HOSPITAL MUNICIPAL DR. JACOBO ABULARACH ABULARACH', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(272, 1, 98, 17, '800172', 'TOTAIZAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(273, 1, 98, 17, '800208', 'SANTA ANA DE MOSERUNA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(274, 1, 98, 17, '800209', 'CARMEN DEL YRUYANEZ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(275, 1, 98, 17, '800278', 'SAN JUAN ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(276, 1, 98, 17, '800338', '18 DE NOVIEMBRE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(277, 1, 98, 2, '800098', 'BENEDICTO VINCENTI ZAMBRANA', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(278, 1, 98, 2, '800099', 'C.S.A. DR. GUIDO ROCA VILLAVICENCIO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(279, 1, 98, 2, '800100', 'SAN CARLOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(280, 1, 98, 2, '800171', 'SANTA ISABEL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(281, 3, 13, 88, '100101', 'DR. GUSTAVO HAASE PEREZ', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(282, 3, 13, 88, '100102', 'DURAZNAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(283, 3, 13, 88, '100103', 'PINOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(284, 3, 13, 88, '100104', 'RODEO CHICO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(285, 3, 13, 88, '100105', 'SAN ROQUE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(286, 3, 13, 88, '100106', 'SANTA ROSA (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(287, 3, 13, 88, '100107', 'TABLANI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(288, 3, 13, 88, '100380', 'COLLPAMAYU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(289, 3, 13, 88, '100385', 'QUEWENAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(290, 3, 13, 88, '100386', 'HUANCARANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(291, 3, 13, 88, '100387', 'LAS ABRAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(292, 3, 13, 85, '100108', 'ABRA KASA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(293, 3, 13, 85, '100109', 'CHUNCA CANCHA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(294, 3, 13, 85, '100110', 'LA SILLADA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(295, 3, 13, 85, '100111', 'MOLLENI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(296, 3, 13, 85, '100112', 'PAMPA HUASI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(297, 3, 13, 85, '100113', 'SAN MIGUEL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(298, 3, 13, 85, '100114', 'SAN PEDRO (CHQ)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(299, 3, 13, 85, '100115', 'VIRGEN DEL ROSARIO TARVITA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(300, 3, 13, 85, '100373', 'PAMPAS DE LEQUE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(301, 3, 13, 85, '100374', 'VILLA PAMPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(302, 3, 13, 85, '100375', 'SAN JOSE DE ALISOS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(303, 3, 13, 85, '100433', 'TACOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(304, 3, 13, 85, '100471', 'EL SALTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(305, 3, 16, 90, '100249', 'MENDOZA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(306, 3, 16, 90, '100250', 'MONTEGRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(307, 3, 16, 90, '100251', 'NUEVO MUNDO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(308, 3, 16, 90, '100252', 'PAMPAS DEL TIGRE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(309, 3, 16, 90, '100253', 'PIEDRA GRANDE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(310, 3, 16, 90, '100254', 'LOS POZOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(311, 3, 16, 90, '100255', 'URRIOLAGOITIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(312, 3, 16, 90, '100256', 'SAN MIGUEL DE VILLA SERRANO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(313, 3, 15, 76, '100163', 'LEONARDO GAMBERTI ALVINO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(314, 3, 15, 76, '100164', 'CERRILLOS (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(315, 3, 15, 76, '100165', 'CHAPIMAYU', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(316, 3, 15, 76, '100166', 'CRUCE PIRAIMIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(317, 3, 15, 76, '100167', 'INGAVI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(318, 3, 15, 76, '100168', 'ITAPENTI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(319, 3, 15, 76, '100169', 'LOS ARCOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(320, 3, 15, 76, '100170', 'MONTEAGUDO SAN ANTONIO DE LOS SAUCES', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(321, 3, 15, 76, '100171', 'C.N.S. C.I.S.  MONTEAGUDO                                               ', 3, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(322, 3, 15, 76, '100173', 'RODEO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(323, 3, 15, 76, '100174', 'SAN JUAN BAUTISTA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(324, 3, 15, 76, '100175', 'SAN MIGUEL DEL BAÑADO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(325, 3, 15, 76, '100176', 'VALLE NUEVO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(326, 3, 15, 76, '100177', 'DERMATOLOGICO', 4, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(327, 3, 15, 76, '100178', 'ROLDANA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(328, 3, 15, 76, '100179', 'DESPENSAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(329, 3, 15, 76, '100180', 'AZERO NORTE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(330, 3, 15, 76, '100434', 'SAN LORENZO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(331, 3, 15, 81, '100181', 'AÑIMBO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(332, 3, 15, 81, '100182', 'ATIRIMBIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(333, 3, 15, 81, '100183', 'CASA ALTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(334, 3, 15, 81, '100184', 'DURAZNITOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(335, 3, 15, 81, '100185', 'SAN PABLO DE HUACARETA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(336, 3, 15, 81, '100187', 'ÑACAMIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(337, 3, 15, 81, '100188', 'PIRAICITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(338, 3, 15, 81, '100189', 'ROSARIO DEL INGRE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(339, 3, 15, 81, '100190', 'URUGUAY', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(340, 3, 15, 81, '100191', 'TARTAGALITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(341, 3, 15, 81, '100192', 'YUMAO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(342, 3, 15, 81, '100193', 'IPATY DEL INGRE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(343, 3, 15, 81, '100300', 'ARENAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(344, 3, 15, 81, '100388', 'YAIRE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(345, 3, 15, 91, '100276', 'CUMANDAYTI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(346, 3, 15, 91, '100277', 'SAN LEOLINO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(347, 3, 15, 91, '100278', 'ITY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(348, 3, 15, 91, '100279', 'KARATINDY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(349, 3, 15, 91, '100280', 'LA TAPERA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(350, 3, 15, 91, '100281', 'MUYUPAMPA LEO SCHWARZ', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(351, 3, 15, 91, '100283', 'SAPIRANGUIMIRI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(352, 3, 15, 91, '100284', 'TAPERILLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(353, 3, 15, 91, '100301', 'IRIPITI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(354, 3, 15, 91, '100381', 'TENTAYAPE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(355, 3, 15, 91, '100391', 'AGUAIRENDA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(356, 3, 15, 91, '100392', 'ITICUPE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(357, 3, 15, 71, '100285', 'HUACAYA SAN LORENZO SINCERI', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(358, 3, 15, 71, '100286', 'SANTA ROSA DE CUEVO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(359, 3, 15, 71, '100370', 'MBORORIGUA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(360, 3, 15, 71, '100382', 'CAMATINDI DE HUACAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(361, 3, 15, 71, '100448', 'CHIMBE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(362, 3, 15, 75, '100287', 'CAMATINDI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(363, 3, 15, 75, '100288', 'CAMPO LEON', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(364, 3, 15, 75, '100289', 'CARANDAYTI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(365, 3, 15, 75, '100290', 'IPATI DE IVO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(366, 3, 15, 75, '100291', 'IVO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(367, 3, 15, 75, '100292', 'MACHARETI SANTA ISABEL', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(368, 3, 15, 75, '100294', 'NANCAROINZA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(369, 3, 15, 75, '100295', 'TENTAMI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(370, 3, 15, 75, '100296', 'TIGUIPA ESTACION', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(371, 3, 15, 75, '100372', 'ISIPOTINDI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(372, 3, 15, 75, '100390', 'TIGUIPA PUEBLO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(373, 3, 17, 67, '100213', 'CARPACHACRA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(374, 3, 17, 67, '100214', 'FALSURI (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(375, 3, 17, 67, '100215', 'YURAC CABALLO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(376, 3, 17, 67, '100216', 'SAN JUAN DE DIOS CAMARGO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(377, 3, 17, 67, '100217', 'SUQUISTACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(378, 3, 17, 67, '100218', 'POLICONSULTORIO 3 DE ABRIL', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(379, 3, 17, 67, '100306', 'HUACACANCHA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(380, 3, 17, 67, '100415', 'CUEVAPAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(381, 3, 17, 67, '100452', 'MOLLINI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(382, 3, 17, 67, '100470', 'MUYUQUIRI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(383, 3, 17, 80, '100219', 'HUAYLLANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(384, 3, 17, 80, '100220', 'OCURI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(385, 3, 17, 80, '100221', 'PUTUTACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(386, 3, 17, 80, '100222', 'CHINIMAYU', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(387, 3, 17, 80, '100223', 'MALLIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(388, 3, 17, 80, '100224', 'TAMBO KASA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(389, 3, 17, 80, '100225', 'PADCOYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(390, 3, 17, 80, '100226', 'CANCHAS BLANCAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(391, 3, 17, 80, '100227', 'PAYACOTA DEL CARMEN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(392, 3, 17, 80, '100228', 'SAN LUCAS', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(393, 3, 17, 80, '100229', 'COLLPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(394, 3, 17, 80, '100230', 'HUANUMILLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(395, 3, 17, 80, '100231', 'PIRHUANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(396, 3, 17, 80, '100232', 'PALACIO TAMBO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(397, 3, 17, 80, '100233', 'LA PALCA (CHQ SAN LUCAS)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(398, 3, 17, 80, '100234', 'ACCHILLA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(399, 3, 17, 80, '100235', 'SACAVILLQUE CHICO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(400, 3, 17, 80, '100236', 'CHAUPI COCHA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(401, 3, 17, 80, '100237', 'URUCHINI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(402, 3, 17, 80, '100238', 'BUENA VISTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(403, 3, 17, 80, '100309', 'C.N.S.  C.I.S. SAN LUCAS', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(404, 3, 17, 80, '100310', 'CHILLAGUA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(405, 3, 17, 80, '100311', 'SACAVILQUE GRANDE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(406, 3, 17, 80, '100383', 'MURIFAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(407, 3, 17, 80, '100395', 'TORRE DE LINARES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(408, 3, 17, 80, '100409', 'CRUZ MAYU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(409, 3, 17, 80, '100426', 'SAN PEDRO DE HUANAYA KASA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(410, 3, 17, 80, '100427', 'LARAVINTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(411, 3, 17, 80, '100472', 'CHUNCHO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(412, 3, 17, 80, '100473', 'PAZLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(413, 3, 17, 73, '100239', 'EL PORTILLO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(414, 3, 17, 73, '100240', 'JOLENCIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(415, 3, 17, 73, '100242', 'VIRGEN DEL ROSARIO INCAHUASI', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(416, 3, 17, 73, '100244', 'YATINA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(417, 3, 17, 73, '100245', 'HUAJLAYA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(418, 3, 17, 73, '100307', 'SAN ANDRES CHUQUISACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(419, 3, 17, 73, '100369', 'EL VERANO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(420, 3, 17, 73, '100428', 'CHILLAJARA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(421, 3, 17, 73, '100492', 'EL QUEMADO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(422, 3, 17, 95, '100241', 'PUCARITA (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(423, 3, 17, 95, '100243', 'SANTA MARIA MADRE DE DIOS', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(424, 3, 17, 95, '100246', 'SANTA ELENA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(425, 3, 17, 95, '100247', 'CAIZAK', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(426, 3, 17, 95, '100248', 'SUPAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(427, 3, 17, 95, '100308', 'SULTACA ALTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(428, 3, 17, 95, '100393', 'SACARI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(429, 3, 17, 95, '100394', 'HUANCARANI ALTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(430, 3, 17, 95, '100476', 'TIPANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(431, 3, 12, 94, '100079', 'ANFAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(432, 3, 12, 94, '100080', 'CACHIMAYU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(433, 3, 12, 94, '100081', 'CALERA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(434, 3, 12, 94, '100082', 'HUAYLLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(435, 3, 12, 94, '100083', 'ÑUJCHU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(436, 3, 12, 94, '100084', 'TAMBO ACKACHILA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(437, 3, 12, 94, '100085', 'TIPAKA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(438, 3, 12, 94, '100086', 'TUERO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(439, 3, 12, 94, '100087', 'UÑALA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(440, 3, 12, 94, '100088', 'NICOLAS ORTIZ YOTALA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(441, 3, 12, 94, '100475', 'TASAPAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(442, 3, 12, 78, '100089', 'CHIJMURI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(443, 3, 12, 78, '100090', 'COPAVILQUE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(444, 3, 12, 78, '100091', 'CUCURI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(445, 3, 12, 78, '100092', 'EL AJIAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(446, 3, 12, 78, '100093', 'THOLAPAMPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(447, 3, 12, 78, '100094', 'KAINACAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(448, 3, 12, 78, '100095', 'LUJE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(449, 3, 12, 78, '100096', 'POJPO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(450, 3, 12, 78, '100097', 'VIRGEN DEL ROSARIO (POROMA)', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(451, 3, 12, 78, '100098', 'SAN JUAN DE ORCAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(452, 3, 12, 78, '100099', 'CHALLCHA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(453, 3, 12, 78, '100100', 'LA PALCA (CHQ-POROMA)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(454, 3, 12, 78, '100376', 'SIJCHA BAJA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(455, 3, 12, 78, '100419', 'SOICOCO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(456, 3, 12, 78, '100429', 'VIRU VIRU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(457, 3, 12, 78, '100430', 'PALAJLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(458, 3, 12, 78, '100431', 'CALISAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(459, 3, 12, 78, '100432', 'POMANAZA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(460, 3, 12, 78, '100459', 'SAPSE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(461, 3, 12, 78, '100468', 'PIOCERA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(462, 3, 12, 78, '100469', 'YANANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(463, 3, 12, 78, '100478', 'IROCOTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(464, 3, 1, 83, '100009', 'ITS-SIDA                                                         ', 2, 1, 6, 17, 2, NULL, NULL, NULL, NULL),
(465, 3, 1, 83, '100016', 'SAN ROQUE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(466, 3, 1, 83, '100020', 'CLINICA DEL SUR (CHQ)                                                 ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(467, 3, 1, 83, '100023', 'COPACABANA (POLICIA)                                            ', 8, 1, 7, 24, 2, NULL, NULL, NULL, NULL),
(468, 3, 1, 83, '100028', 'CIMFA CNS SUCRE', 5, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(469, 3, 1, 83, '100029', 'CSBP - POLICONSULTORIO SUCRE', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(470, 3, 1, 83, '100035', 'COTES LTDA                                                       ', 8, 1, 7, 38, 2, NULL, NULL, NULL, NULL),
(471, 3, 1, 83, '100042', 'MERCADO CENTRAL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(472, 3, 1, 83, '100055', 'CENTRAL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(473, 3, 1, 83, '100453', 'CENTRO CENTINELA COVID-19 C.N.S', 2, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(474, 3, 1, 83, '100533', 'CAJA BANCARIA ESTATAL DE SALUD - CHUQUISACA', 5, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(475, 3, 1, 83, '100537', 'BANCO DE SANGRE DE  REFERENCIA DPTAL CHUQUISACA', 1, 4, 6, 42, 2, NULL, NULL, NULL, NULL),
(476, 3, 1, 83, '100539', 'P.A.I.S.E', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(477, 3, 2, 83, '100022', 'MARIE STOPES SUCRE                                              ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(478, 3, 2, 83, '100034', 'MERCADO CAMPESINO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(479, 3, 2, 83, '100037', 'KAUSAJ PUJYU                                                     ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(480, 3, 2, 83, '100077', 'VILLA ARMONIA (CHQ)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(481, 3, 2, 83, '100078', 'VILLA MARGARITA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(482, 3, 2, 83, '100303', 'INSALDE                                                               ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(483, 3, 2, 83, '100313', 'HORNO CKASA (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(484, 3, 2, 83, '100314', 'BARRIO LINDO (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(485, 3, 2, 83, '100315', 'ALTO DELICIAS (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(486, 3, 2, 83, '100323', 'CESSA  (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(487, 3, 2, 83, '100326', 'VILLA ARMONIA B', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(488, 3, 2, 83, '100330', 'CAPITAL  (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(489, 3, 2, 83, '100331', 'VIRGEN DE GUADALUPE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(490, 3, 2, 83, '100332', 'TOMAS KATARI', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(491, 3, 2, 83, '100407', 'SAN JUANILLO                                                      ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(492, 3, 2, 83, '100421', 'SANTA BARBARA NORTE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(493, 3, 2, 83, '100535', 'INNOVASALUD S.A. JATUN SONQO', 3, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(494, 3, 3, 83, '100008', 'SAGRADA FAMILIA                                                  ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(495, 3, 3, 83, '100043', 'MERCADO MINORISTA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(496, 3, 3, 83, '100046', 'CAJA DE SALUD DE CAMINOS Y R.A. REGIONAL SUCRE           ', 17, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(497, 3, 3, 83, '100049', 'CIMES                                                            ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(498, 3, 3, 83, '100063', 'MORRO MUNICIPAL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(499, 3, 3, 83, '100064', 'ALTO SAN JUANILLO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(500, 3, 3, 83, '100317', 'ALTO LOYOLA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(501, 3, 3, 83, '100318', 'LUIS ESPINAL', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(502, 3, 3, 83, '100320', 'GARCILAZO BAJO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(503, 3, 3, 83, '100321', 'PUEBLO NUEVO (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(504, 3, 3, 83, '100324', 'BARRIO OBRERO (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(505, 3, 3, 83, '100325', 'P. BUSTILLOS (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(506, 3, 3, 83, '100329', 'POCONAS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(507, 3, 3, 83, '100485', 'CRUZ ROJA FILIAL CHUQUISACA ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(508, 3, 3, 83, '100488', 'C.I.S. 1', 5, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(509, 3, 3, 83, '100527', 'CENTRO DE AISLAMIENTO COVID 19 BOLIVARIANA', 7, 5, 6, 18, 2, NULL, NULL, NULL, NULL),
(510, 3, 3, 83, '100532', 'CENTRO CORDINADOR DE EMERGENCIAS EN SALUD - CHQ.', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(511, 3, 3, 83, '100540', '\"UNIDAD DE HEMODIALISIS \"\"NEFROSOL\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(512, 3, 4, 83, '100065', 'VALLE HERMOSO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(513, 3, 4, 83, '100073', 'PATACON', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(514, 3, 4, 83, '100335', 'QUIRPINCHACA (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(515, 3, 4, 83, '100337', 'CASEGURAL', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(516, 3, 4, 83, '100341', 'SAN LUIS (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(517, 3, 4, 83, '100342', 'ESTADOS UNIDOS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(518, 3, 4, 83, '100343', 'VILLA LA JASTAMBO (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(519, 3, 4, 83, '100344', 'VILLA  MARLECITA (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(520, 3, 4, 83, '100422', 'HOLANDA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(521, 3, 4, 83, '100423', 'BELEN', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(522, 3, 4, 83, '100455', 'AMAZONAS (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(523, 3, 4, 83, '100466', 'MISION ESPERANZA                                                 ', 3, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(524, 3, 4, 83, '100536', 'ONCOMAR ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(525, 3, 5, 83, '100010', 'VILLA ROSARIO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(526, 3, 5, 83, '100012', 'MARIA  AUXILIADORA                                                ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(527, 3, 5, 83, '100041', 'ZOONOSIS                                                      ', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(528, 3, 5, 83, '100345', 'EL PALMAR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(529, 3, 5, 83, '100346', 'U.M. TATA CAJONCITO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(530, 3, 5, 83, '100347', 'SANTA ROSA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(531, 3, 5, 83, '100348', 'PLANTA DIESEL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(532, 3, 5, 83, '100349', 'MAX TOLEDO (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(533, 3, 5, 83, '100350', 'LA  HOYADA (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(534, 3, 5, 83, '100351', 'SAN CRISTOBAL (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(535, 3, 5, 83, '100352', 'LA FLORIDA (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(536, 3, 5, 83, '100450', 'PLATAFORMA DE CHAGAS                                             ', 2, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(537, 3, 5, 83, '100456', 'LOS ANGELES (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(538, 3, 6, 83, '100011', 'BARRIO JAPON', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(539, 3, 6, 83, '100013', 'SAN ANTONIO ALTO (CHQ)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(540, 3, 6, 83, '100014', 'SAN JOSE (CHQ)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(541, 3, 6, 83, '100018', 'VILLA COPACABANA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(542, 3, 6, 83, '100353', 'VILLA CHARCAS (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(543, 3, 6, 83, '100354', 'SAN FRANCISCO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(544, 3, 6, 83, '100357', 'SAN ANTONIO BAJO (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(545, 3, 6, 83, '100358', 'CRUCE AZARI', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(546, 3, 6, 83, '100454', 'ALEMANIA UNIDA (M)', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(547, 3, 10, 83, '100001', 'HOSPITAL MILITAR Nª6 COSSMIL SUCRE                                      ', 12, 2, 7, 13, 2, NULL, NULL, NULL, NULL),
(548, 3, 10, 83, '100003', 'CAJA PETROLERA                                                        ', 12, 2, 7, 11, 2, NULL, NULL, NULL, NULL),
(549, 3, 10, 83, '100004', 'CLINICA CIES REGIONAL SUCRE                                             ', 12, 2, 3, 4, 2, NULL, NULL, NULL, NULL),
(550, 3, 10, 83, '100021', 'HOSP. MONS. JESUS PEREZ                                               ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(551, 3, 10, 83, '100024', 'HOSPITAL IPTK                                                         ', 12, 2, 3, 23, 2, NULL, NULL, NULL, NULL),
(552, 3, 10, 83, '100040', 'HOSP. CRISTO DE LAS AMERICAS                                          ', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(553, 3, 10, 83, '100047', 'SAN PEDRO CLAVER', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(554, 3, 10, 83, '100053', 'MAT. INF. POCONAS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(555, 3, 10, 83, '100068', 'SEGURO SOCIAL UNIVERSITARIO                                             ', 12, 2, 7, 30, 2, NULL, NULL, NULL, NULL),
(556, 3, 10, 83, '100069', 'CAJA CORDES - CHUQUISACA                                              ', 8, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(557, 3, 10, 83, '100359', 'UNIVERSITARIO ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(558, 3, 11, 83, '100005', 'INST. PSICOPEDAGOGICO                                                 ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(559, 3, 11, 83, '100006', 'GINECO OBSTETRICO (CHQ)                                         ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(560, 3, 11, 83, '100007', 'HOSP. GASTROENTEROLOGICO                                              ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(561, 3, 11, 83, '100030', 'HOSP. SANTA BARBARA                                                   ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(562, 3, 11, 83, '100033', 'CNS HOSPITAL OBRERO Nº 6  DR. JAIME MENDOZA                             ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(563, 3, 11, 83, '100052', 'INST. PSIQUIATRICO NACIONAL                                           ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(564, 3, 11, 83, '100445', 'HOSP. NIÑO SOR TERESA HUARTE TAMA                                     ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(565, 3, 11, 83, '100446', 'INSTITUTO CUPERTINO ARTEAGA                                           ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(566, 3, 11, 83, '100477', 'INSTITUTO CHUQUISAQUEÑO DE ONCOLOGIA', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(567, 3, 11, 83, '100486', 'CLINICA  ÁNGELES ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(568, 3, 11, 83, '100538', 'BANCO DE SANGRE HOSPITAL OBRERO Nª6 DR JAIME MENDOZA', 1, 4, 7, 10, 2, NULL, NULL, NULL, NULL),
(569, 3, 7, 83, '100002', 'ARABATE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(570, 3, 7, 83, '100044', 'KHOCHIS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(571, 3, 7, 83, '100061', 'SONKHO CHIPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(572, 3, 7, 83, '100328', 'SIVISTO', 18, 1, 6, 17, 1, NULL, NULL, NULL, NULL),
(573, 3, 7, 83, '100333', 'CENTRO DE SALUD INTEGRAL ALEGRIA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(574, 3, 7, 83, '100367', 'QKORA-QKORA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(575, 3, 7, 83, '100460', 'HUANCAPAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(576, 3, 7, 83, '100462', 'LA BARRANCA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(577, 3, 7, 83, '100474', 'KORA KORA GUADALUPE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(578, 3, 7, 83, '100489', 'P.S. LLINFI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(579, 3, 8, 83, '100025', 'CANTU MOLINO', 18, 1, 6, 17, 1, NULL, NULL, NULL, NULL),
(580, 3, 8, 83, '100027', 'CHUQUI CHUQUI', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(581, 3, 8, 83, '100031', 'EL CHACO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(582, 3, 8, 83, '100039', 'IMILLA HUANUSCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(583, 3, 8, 83, '100045', 'LA PALMA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(584, 3, 8, 83, '100074', 'SURIMA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(585, 3, 8, 83, '100368', 'CKACHA-CKACHA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(586, 3, 8, 83, '100406', 'SOICO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(587, 3, 9, 83, '100026', 'CHAUNACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(588, 3, 9, 83, '100048', 'MARAGUA (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(589, 3, 9, 83, '100056', 'CRISTO REY DE POTOLO', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(590, 3, 9, 83, '100058', 'PUNILLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(591, 3, 9, 83, '100059', 'QUILA QUILA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(592, 3, 17, 68, '100257', 'COLPANAYOC', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(593, 3, 17, 68, '100258', 'SANTA MARIA VILLA  ABECIA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(594, 3, 17, 68, '100259', 'JAILIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(595, 3, 17, 68, '100260', 'HIGUERAYOC', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(596, 3, 17, 69, '100261', 'MANZANAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(597, 3, 17, 69, '100262', 'EL PALMAR (CHQ)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(598, 3, 17, 69, '100263', 'SAN JOSE CULPINA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(599, 3, 17, 69, '100264', 'CAMPAMENTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(600, 3, 17, 69, '100265', 'CARAPARI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(601, 3, 17, 69, '100266', 'SAJLINA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(602, 3, 17, 69, '100267', 'LA LOMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(603, 3, 17, 69, '100268', 'TOJLASA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(604, 3, 17, 69, '100269', 'EL MONTE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(605, 3, 17, 69, '100270', 'PUCA PAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(606, 3, 17, 69, '100363', 'PUMACKASA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(607, 3, 17, 69, '100384', 'LAS ABRAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(608, 3, 17, 69, '100463', 'SALVIANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(609, 3, 17, 74, '100271', 'TARAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(610, 3, 17, 74, '100272', 'LA TORRE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(611, 3, 17, 74, '100273', 'IMPORA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(612, 3, 17, 74, '100274', 'LIME', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(613, 3, 17, 74, '100275', 'VIRGEN DEL CARMEN LAS CARRERAS', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(614, 3, 17, 74, '100396', 'SOCPORA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(615, 3, 17, 74, '100491', 'SANTA ROSA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(616, 3, 71, 77, '100140', 'COREY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(617, 3, 71, 77, '100141', 'EL ROSAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(618, 3, 71, 77, '100142', 'LAMPACILLOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(619, 3, 71, 77, '100143', 'MARCOS ROJAS PADILLA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(620, 3, 71, 77, '100144', 'C.N.S. C.I.S.  PADILLA                                                  ', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(621, 3, 71, 77, '100145', 'TABACAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(622, 3, 71, 77, '100146', 'TIHUMAYU', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(623, 3, 71, 77, '100441', 'EL LLANTOJ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(624, 3, 71, 86, '100147', 'CORSO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(625, 3, 71, 86, '100148', 'RODEO PORVENIR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(626, 3, 71, 86, '100149', 'FUERTE RUA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(627, 3, 71, 86, '100150', 'OTORONGO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(628, 3, 71, 86, '100151', 'PUCARA (CHQ)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(629, 3, 71, 86, '100152', 'TARABUQUILLO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(630, 3, 71, 86, '100153', 'TOMINA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(631, 3, 71, 86, '100400', 'PUNAMAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(632, 3, 71, 86, '100401', 'KURI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(633, 3, 71, 86, '100420', 'THURUMAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(634, 3, 71, 86, '100480', 'VILLAFLORES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(635, 3, 71, 87, '100157', 'ALCALA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(636, 3, 71, 87, '100158', 'LIMABAMBA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(637, 3, 71, 87, '100397', 'MATELA ALTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(638, 3, 71, 70, '100159', 'EL DORADO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(639, 3, 71, 70, '100160', 'EL VILLAR', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(640, 3, 71, 70, '100161', 'RODEITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(641, 3, 71, 70, '100162', 'SEGURA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(642, 3, 71, 70, '100398', 'SAN BLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(643, 3, 71, 70, '100467', 'BARBECHOS                                                        ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(644, 3, 13, 82, '100154', 'AMANCAYA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(645, 3, 13, 82, '100155', 'PAMPAS DEL CARMEN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(646, 3, 13, 82, '100156', 'VIRGEN DE REMEDIOS SOPACHUY', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(647, 3, 13, 82, '100305', 'SIPICANI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(648, 3, 13, 82, '100399', 'MAMA HUASI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(649, 3, 14, 84, '100194', 'CORORO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(650, 3, 14, 84, '100195', 'EL CARMEN (TARABUCO)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(651, 3, 14, 84, '100196', 'EL PAREDON', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(652, 3, 14, 84, '100197', 'CIENEGA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(653, 3, 14, 84, '100198', 'PAJCHA (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(654, 3, 14, 84, '100199', 'PAMPA LUPIARA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(655, 3, 14, 84, '100200', 'SARUFAYA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(656, 3, 14, 84, '100201', 'SURIMA CHICA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(657, 3, 14, 84, '100202', 'RICARDO BACHERER', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(658, 3, 14, 84, '100302', 'COLLACAMANI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(659, 3, 14, 84, '100402', 'HIGUERAS CHILCA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(660, 3, 14, 84, '100484', 'MORADO K`ASA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(661, 3, 14, 84, '100490', 'SAN JUAN DE DIOS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(662, 3, 14, 93, '100203', 'CARAMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(663, 3, 14, 93, '100204', 'LAVADERO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(664, 3, 14, 93, '100205', 'ESCANA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(665, 3, 14, 93, '100206', 'JATUN CKACKA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(666, 3, 14, 93, '100207', 'PATALLAJTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(667, 3, 14, 93, '100208', 'SAJPAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(668, 3, 14, 93, '100209', 'SAN JUAN (CHQ)', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(669, 3, 14, 93, '100210', 'SOTOMAYOR', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(670, 3, 14, 93, '100211', 'CARDENAL MAURER', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(671, 3, 14, 92, '100117', 'WACA HUASI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(672, 3, 14, 92, '100118', 'SAN JORGE', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(673, 3, 14, 92, '100119', 'MANDINGA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(674, 3, 14, 92, '100120', 'SAYANCHACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(675, 3, 14, 92, '100121', 'MAYUTORCOCO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(676, 3, 14, 92, '100122', 'PARAQTY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(677, 3, 14, 79, '100123', 'PUNO KASA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(678, 3, 14, 79, '100124', 'RODEO EL PALMAR', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(679, 3, 14, 79, '100125', 'SANTIAGO DE PRESTO', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(680, 3, 14, 79, '100126', 'PASOPAYA (PRESTO)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(681, 3, 14, 79, '100404', 'SAN ISIDRO DE TOMOROCO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(682, 3, 14, 79, '100405', 'VIRGEN DEL ROSARIO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(683, 3, 14, 79, '100451', 'MOLANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(684, 3, 14, 79, '100465', 'EL PALMAR', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(685, 3, 14, 89, '100127', 'LA ABRA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(686, 3, 14, 89, '100128', 'SAN JUAN DE DIOS (CHQ)', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(687, 3, 14, 89, '100129', 'YACAMBE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(688, 3, 14, 89, '100130', 'CHURICANA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(689, 3, 14, 89, '100131', 'SACHAPAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(690, 3, 14, 89, '100132', 'QUIVALE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(691, 3, 14, 89, '100133', 'MOJOCOYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(692, 3, 14, 89, '100403', 'LA JOYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(693, 3, 14, 72, '100134', 'CANTAR GALLO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(694, 3, 14, 72, '100135', 'CANDELARIA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(695, 3, 14, 72, '100136', 'VIRGEN DEL ROSARIO (ICLA)', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(696, 3, 14, 72, '100138', 'TACOPAMPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(697, 3, 14, 72, '100139', 'UYUNI (CHQ)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(698, 3, 14, 72, '100360', 'SUMALA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(699, 3, 14, 72, '100361', 'SAN JACINTO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(700, 3, 14, 72, '100379', 'GUITARRANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(701, 3, 14, 72, '100414', 'KOLLPAPAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(702, 3, 14, 72, '100442', 'RODEO DE ICLA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(703, 3, 14, 72, '100464', 'JATUN MAYU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(704, 3, 14, 72, '100479', 'CHUNCA CANCHA - ICLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(705, 2, 68, 23, '300158', 'ARANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(706, 2, 68, 23, '300159', 'COLLPACIACO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(707, 2, 68, 23, '300160', 'POCOATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(708, 2, 68, 23, '300425', 'LAGUNITAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(709, 2, 68, 23, '300480', 'SAGA-SAGA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(710, 2, 68, 23, '300636', 'SERRANO                                                          ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(711, 2, 68, 60, '300161', 'CAÑADA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(712, 2, 68, 60, '300162', 'PEDREGAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(713, 2, 68, 60, '300163', 'TOTORA PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(714, 2, 68, 60, '300164', 'RODEO (CBB)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(715, 2, 68, 60, '300165', 'VACAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(716, 2, 68, 60, '300166', 'PAREDONES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(717, 2, 68, 60, '300427', 'JUNTUTUYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(718, 2, 69, 25, '300167', 'ARQUE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(719, 2, 69, 25, '300168', 'COLCHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(720, 2, 69, 25, '300169', 'HUAYCHA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(721, 2, 69, 25, '300170', 'KOLLPA KASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(722, 2, 69, 25, '300171', 'PONGO 2003', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(723, 2, 69, 25, '300172', 'OVEJERIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(724, 2, 69, 25, '300173', 'TUJSUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(725, 2, 69, 25, '300582', 'QUEÑUATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(726, 2, 69, 25, '300583', 'KUTIMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(727, 2, 69, 52, '300174', 'HORNONI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(728, 2, 69, 52, '300175', 'CHIQUIRUYO (LOQUEAPU)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(729, 2, 69, 52, '300176', 'SAN MIGUEL DE AQUERANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(730, 2, 69, 52, '300177', 'TACOPAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(731, 2, 69, 52, '300178', 'TOTORA PAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(732, 2, 69, 52, '300179', 'VENTILLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(733, 2, 69, 52, '300505', 'HAYQUI KASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(734, 2, 65, 35, '300100', 'ARAMANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(735, 2, 65, 35, '300101', 'CALCHANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(736, 2, 65, 35, '300102', 'CANTUMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(737, 2, 65, 35, '300103', 'CHARAHUAYTO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(738, 2, 65, 35, '300104', 'CHARAPAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(739, 2, 65, 35, '300105', 'CENTRO DE SALUD POCANCHE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(740, 2, 65, 35, '300106', 'COTANI (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(741, 2, 65, 35, '300107', 'HUANCARANI (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(742, 2, 65, 35, '300108', 'SAN JUAN DE DIOS (INDEPENDENCIA)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(743, 2, 65, 35, '300109', 'HOSP. KAMI', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(744, 2, 65, 35, '300110', 'KERAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(745, 2, 65, 35, '300111', 'KUTY', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(746, 2, 65, 35, '300112', 'MACHACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(747, 2, 65, 35, '300113', 'PATIÑO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(748, 2, 65, 35, '300114', 'SANIPAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(749, 2, 65, 35, '300115', 'SAYLAPATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(750, 2, 65, 35, '300116', 'SISIPALERMO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(751, 2, 65, 35, '300117', 'TIQUIRPAYA INDEPENDENCIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(752, 2, 65, 35, '300118', 'VILACOTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(753, 2, 65, 35, '300119', 'VILLA HERMOSA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(754, 2, 65, 35, '300503', 'C.S. CNS KAMI                                                         ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(755, 2, 65, 35, '300563', 'CHAMACOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(756, 2, 66, 37, '300121', 'CHINCHIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(757, 2, 66, 37, '300127', 'QUIRI QUIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(758, 2, 66, 37, '300128', 'MOROCHATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(759, 2, 66, 37, '300129', 'PATA MOROCHATA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(760, 2, 66, 37, '300130', 'PIUSILLA SAN ISIDRO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(761, 2, 66, 37, '300133', 'YAYANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(762, 2, 66, 37, '300429', 'CHULLPA KASA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(763, 2, 66, 37, '300553', 'PARTE LIBRE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(764, 2, 66, 37, '300555', 'HUMAMARCA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(765, 2, 66, 65, '300120', 'ALTAMACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(766, 2, 66, 65, '300123', 'COCAPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(767, 2, 66, 65, '300124', 'EL CHORO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(768, 2, 66, 65, '300125', 'FALSURI (CBB)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(769, 2, 66, 65, '300126', 'INCACASANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(770, 2, 66, 65, '300131', 'LA  AGUADA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(771, 2, 66, 65, '300132', 'RINCONADA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(772, 2, 66, 65, '300430', 'PUTUCUNI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(773, 2, 66, 65, '300502', 'VILLA VINTO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(774, 2, 66, 65, '300554', 'ICARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(775, 2, 66, 65, '300556', 'CALIENTES', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(776, 2, 66, 65, '300559', 'COLORADO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(777, 2, 66, 65, '300580', 'MARAVILLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(778, 2, 66, 65, '300660', 'TOCORANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(779, 2, 66, 65, '300661', 'SEQUERRANCHO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(780, 2, 66, 65, '300662', 'COLQUECHACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(781, 2, 66, 65, '300663', 'KUMARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(782, 2, 66, 65, '300664', 'LAGUNILLAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(783, 2, 66, 65, '300665', 'TUNARI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(784, 2, 69, 26, '300397', 'BOLIVAR', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(785, 2, 69, 26, '300398', 'CARPANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(786, 2, 69, 26, '300399', 'COMUNA(2002)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(787, 2, 69, 26, '300400', 'TANGALEQUE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(788, 2, 69, 26, '300401', 'VILAPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(789, 2, 64, 20, '300087', 'HOSP. CARMEN LOPEZ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(790, 2, 64, 20, '300088', 'BERTOL                                                   ', 5, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(791, 2, 64, 20, '300089', 'CNS. AIQUILE                                                     ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(792, 2, 64, 20, '300090', 'ESTANZUELAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(793, 2, 64, 20, '300091', 'LAGARPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(794, 2, 64, 20, '300092', 'MATARAL (CBB)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(795, 2, 64, 20, '300093', 'QUIROGA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(796, 2, 64, 20, '300094', 'VILLA GRANADO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(797, 2, 64, 20, '300549', 'ELVIRA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(798, 2, 64, 20, '300682', 'KEWIÑAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(799, 2, 64, 20, '300685', 'CHAQUI MAYO ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(800, 2, 64, 20, '300703', 'AIQUILE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(801, 2, 64, 20, '300755', 'P.S PANAMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(802, 2, 64, 39, '300095', 'PASORAPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(803, 2, 64, 39, '300096', 'QUINORI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(804, 2, 64, 39, '300097', 'SEIBAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(805, 2, 64, 39, '300550', 'PAMPAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(806, 2, 64, 39, '300574', 'ESPINAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(807, 2, 64, 38, '300098', 'ELE ELE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(808, 2, 64, 38, '300099', 'OMEREQUE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(809, 2, 64, 38, '300434', 'HUANACUNI CHICO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(810, 2, 64, 38, '300438', 'PEÑA COLORADA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(811, 2, 64, 38, '300573', 'PANTOJA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(812, 2, 64, 38, '300601', 'ESMERALDA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(813, 2, 69, 27, '300180', 'APILLAPAMPA', 3, 1, 6, 39, 1, NULL, NULL, NULL, NULL),
(814, 2, 69, 27, '300181', 'HOSP. CAPINOTA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(815, 2, 69, 27, '300182', 'CHARAMOCO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(816, 2, 69, 27, '300183', 'HORNOMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(817, 2, 69, 27, '300184', 'C.N.S. COBOCE IRPA IRPA                                          ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(818, 2, 69, 27, '300185', 'MOLLINI - ANZALDO COCHABAMBA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(819, 2, 69, 27, '300482', 'IRPA IRPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(820, 2, 69, 48, '300187', 'CAPORAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(821, 2, 69, 48, '300188', 'CAYACAYANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(822, 2, 69, 48, '300189', 'HUANACOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(823, 2, 69, 48, '300190', 'LA PAMPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(824, 2, 69, 48, '300192', 'SANTIVANEZ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(825, 2, 69, 49, '300194', 'ORCOMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(826, 2, 69, 49, '300195', 'SICAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(827, 2, 69, 49, '300518', 'CORATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(828, 2, 77, 28, '300334', 'SAN JUAN DE DIOS CHIMORE', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(829, 2, 77, 28, '300336', 'PUERTO AURORA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(830, 2, 77, 28, '300339', 'SAN ANDRES (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(831, 2, 77, 28, '300340', 'TACUARAL ENTRE RIOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(832, 2, 77, 28, '300501', 'ESTANO PALMITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(833, 2, 77, 28, '300590', 'NUEVA CANAAN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(834, 2, 77, 28, '300670', '\"CENTRO DE SALUD SENDA \"\"F\"\"\"', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(835, 2, 77, 28, '300671', 'CENTRO DE SALUD NUEVA ESPERANZA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(836, 2, 77, 28, '300754', 'CENTRO DE SALUD SENDA III', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(837, 2, 77, 42, '300341', '2 DE MARZO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(838, 2, 77, 42, '300342', 'ALTO SAN PABLO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(839, 2, 77, 42, '300343', 'AYOPAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(840, 2, 77, 42, '300345', 'ISRAEL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(841, 2, 77, 42, '300346', 'HOSP. IVIRGARZAMA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(842, 2, 77, 42, '300347', 'C.S. MARIPOSAS                                                        ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(843, 2, 77, 42, '300348', 'PARAISO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(844, 2, 77, 42, '300349', 'PUERTO VILLARROEL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(845, 2, 77, 42, '300350', 'VALLE SACTA                                                     ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(846, 2, 77, 42, '300351', 'SENDA VI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(847, 2, 77, 42, '300352', 'VALLE HERMOSO (CBB)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(848, 2, 77, 42, '300353', 'VALLE IVIRZA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(849, 2, 77, 42, '300354', 'VALLE TUNARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(850, 2, 77, 42, '300355', 'VILLA NUEVA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(851, 2, 77, 42, '300356', 'TAMBORADA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(852, 2, 77, 42, '300472', 'SANTA FE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(853, 2, 77, 42, '300473', 'ALTO CHIJINI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(854, 2, 77, 42, '300474', 'NUEVA ESTRELLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(855, 2, 77, 42, '300545', '\"INGAVI \"\"B\"\"\"', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(856, 2, 77, 42, '300577', '\"PADILLA \"\"A\"\"\"', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(857, 2, 77, 42, '300578', 'SACTA NORTE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(858, 2, 77, 42, '300605', 'C.S. MÉDICO SAN ALBERTO                                               ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(859, 2, 77, 42, '300638', 'CENTRO MEDICO SAGRADO CORAZON                                         ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(860, 2, 77, 42, '300694', 'IVIRGARZAMA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(861, 2, 77, 42, '300705', '\"CENTRO MEDICO INTEGRAL \"\"LEDEZMA\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(862, 2, 77, 42, '300742', 'P. S SAN PEDRO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(863, 2, 77, 34, '300311', 'BULO BULO', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(864, 2, 77, 34, '300313', 'ANDINO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(865, 2, 77, 34, '300315', 'ENTRE RIOS', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(866, 2, 77, 34, '300316', 'ISARZAMA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(867, 2, 77, 34, '300318', 'ALTO LINARES', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(868, 2, 77, 34, '300323', 'RIO BLANCO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(869, 2, 77, 34, '300471', '6 DE AGOSTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(870, 2, 77, 34, '300576', 'CHANCADORA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(871, 2, 77, 34, '300700', 'HOSPITAL ENTRE RIOS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(872, 2, 73, 28, '300335', 'LA MISION', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(873, 2, 73, 28, '300337', 'EL CARMEN (CBB)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(874, 2, 73, 28, '300338', 'SANTA ISABEL (CBB)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(875, 2, 73, 28, '300599', 'SANTA ANITA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(876, 2, 73, 28, '300637', 'P.S TRINIDADCITO                                                      ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(877, 2, 73, 42, '300344', 'BIARECUATE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(878, 2, 76, 59, '300304', 'ANTAKAWA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(879, 2, 76, 59, '300305', 'COPACHUNCHO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(880, 2, 76, 59, '300306', 'EPIZANA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(881, 2, 76, 59, '300307', 'LAIMETORO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(882, 2, 76, 59, '300308', 'SAUCE PILAPATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(883, 2, 76, 59, '300309', 'TIKAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(884, 2, 76, 59, '300310', 'HOSP. TOTORA', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(885, 2, 76, 59, '300595', 'PATAICUNA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(886, 2, 76, 59, '300757', 'CENTRO DE SALUD TOTORA', 3, 1, 6, 1, 1, NULL, NULL, NULL, NULL),
(887, 2, 76, 41, '300312', 'CHALLHUANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(888, 2, 76, 41, '300314', 'DIAN PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(889, 2, 76, 41, '300317', 'KARAWASI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(890, 2, 76, 41, '300320', 'SAN MIGUEL', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(891, 2, 76, 41, '300321', 'RODEO ADENTRO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(892, 2, 76, 41, '300322', 'YUTHUPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(893, 2, 76, 41, '300476', 'PALCA (CBB-POJO)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(894, 2, 76, 41, '300586', 'VILAQUE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(895, 2, 76, 41, '300587', 'THAGO LAGUNA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(896, 2, 76, 40, '300324', 'CHILLIJCHI ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(897, 2, 76, 40, '300325', 'CONDA BAJA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(898, 2, 76, 40, '300326', 'LAIMIÑA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(899, 2, 76, 40, '300327', 'LOMAN CHIUCHI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(900, 2, 76, 40, '300328', 'LOPE MENDOZA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(901, 2, 76, 40, '300329', 'POCONA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(902, 2, 76, 40, '300330', 'QHOPY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(903, 2, 76, 40, '300331', 'QUEWIÑAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(904, 2, 76, 40, '300332', 'WAYAPACHA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(905, 2, 76, 40, '300333', 'YURAK MOLINO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(906, 2, 76, 40, '300475', 'MAMA HUASI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(907, 2, 76, 40, '300515', 'MONTE PUNKU', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(908, 2, 76, 40, '300516', 'QUEWIÑAKASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(909, 2, 76, 40, '300546', 'PUYUHUASI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(910, 2, 76, 40, '300588', 'JATUM PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(911, 2, 61, 30, '300006', 'HOSP. MATERNOLÓGICO GERMÁN URQUIDI                                    ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(912, 2, 61, 30, '300007', 'HOSP. DEL NIÑO MANUEL ASCENCIO  VILLARROEL                            ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(913, 2, 61, 30, '300033', 'INST. GASTROENTEROLÓGICO BOLIVIANO JAPONÉS                            ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(914, 2, 61, 30, '300034', 'INST. PSIQUIÁTRICO SAN JUAN DE DIOS                                   ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(915, 2, 61, 30, '300070', 'HOSP. VIEDMA                                                          ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(916, 2, 61, 30, '300071', 'HOSP. OBRERO N° 2 CNS                                                 ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(917, 2, 61, 30, '300078', 'HOSP. ELIZABETH SETON CPS                                             ', 11, 3, 7, 11, 2, NULL, NULL, NULL, NULL),
(918, 2, 61, 30, '300079', 'HOSP. COSSMIL COCHABAMBA                                              ', 11, 3, 7, 13, 2, NULL, NULL, NULL, NULL),
(919, 2, 61, 30, '300483', 'INST. ONCOLÓGICO NACIONAL COCHABAMBA                                  ', 14, 3, 7, 11, 2, NULL, NULL, NULL, NULL),
(920, 2, 61, 30, '300575', 'PLATAFORMA DE ATENCION  A  PACIENTES CON  CHAGAS', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(921, 2, 61, 30, '300657', 'BANCO DE SANGRE DE REFERENCIA  CBBA ', 1, 4, 6, 21, 2, NULL, NULL, NULL, NULL),
(922, 2, 61, 30, '300733', 'VACUNATORIO SEDES CBBA', 19, 9, 6, 17, 2, NULL, NULL, NULL, NULL),
(923, 2, 61, 30, '300762', 'CLINICA LOS LIRIOS S.R.L', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(924, 2, 62, 30, '300016', 'BEATO SALOMON', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(925, 2, 62, 30, '300020', 'ROSBEN                                           ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(926, 2, 62, 30, '300029', 'CHAVEZ RANCHO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(927, 2, 62, 30, '300030', 'CHIMBA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(928, 2, 62, 30, '300038', 'CONDEBAMBA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(929, 2, 62, 30, '300041', 'NUESTRA SEÑORA VIRGEN DE GUADALUPE                               ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(930, 2, 62, 30, '300053', 'CENTRO MEDICO MARÍA INMACULADA                                          ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(931, 2, 62, 30, '300063', 'SARCOBAMBA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(932, 2, 62, 30, '300066', 'TEMPORAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(933, 2, 62, 30, '300067', 'TICTI NORTE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(934, 2, 62, 30, '300069', 'TUPURAYA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(935, 2, 62, 30, '300075', 'POLICLÍNICO SARCOBAMBA CNS                                       ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(936, 2, 62, 30, '300076', 'HOSP. PROSALUD CHIMBA                                                 ', 12, 2, 3, 26, 2, NULL, NULL, NULL, NULL),
(937, 2, 62, 30, '300077', 'POLICLÍNICO VILLA GALINDO CNS                                    ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(938, 2, 62, 30, '300419', 'EDGAR MONTAÑO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(939, 2, 62, 30, '300439', 'SANTA TERESITA                                                   ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(940, 2, 62, 30, '300442', 'C.S. BOLÍVAR                                                          ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(941, 2, 62, 30, '300443', 'HOSP. CLÍNICA COPACABANA                                              ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(942, 2, 62, 30, '300444', 'C.S. CLÍNICA SOLIDARIA ARANO                                          ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(943, 2, 62, 30, '300445', 'C.S. KANTUTA                                                          ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(944, 2, 62, 30, '300446', 'C.S. MONTAÑO                                                          ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(945, 2, 62, 30, '300453', 'HOSP. CLÍNICA LOS OLIVOS                                              ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(946, 2, 62, 30, '300454', 'HOSP. CLÍNICA COBIJA                                                  ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(947, 2, 62, 30, '300524', 'C.S. SAN VICENTE TUPURAYA                                             ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(948, 2, 62, 30, '300603', 'CENTRO MEDICO QUIRURGICO FERREL                                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(949, 2, 62, 30, '300604', 'C. S. Y REHABILITACION COMUNITARIO ROJAS MEJIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(950, 2, 62, 30, '300627', 'C.S POLICLINICO PAISE Nº 32                                           ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(951, 2, 62, 30, '300628', 'HOSPITAL PROSALUD SIMON LOPEZ', 12, 2, 3, 23, 2, NULL, NULL, NULL, NULL),
(952, 2, 62, 30, '300639', 'C. DE HEMODIALISIS   JOSE E. GUTIERREZ                                  ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(953, 2, 62, 30, '300641', 'NEFRODIAL CENTRO DEL RIÑON                                            ', 2, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(954, 2, 62, 30, '300647', 'A I N CENTRO DE HEMODIALISIS                                          ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(955, 2, 62, 30, '300648', 'CENTRO HEMODIALISIS DE IRAN                                           ', 2, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(956, 2, 62, 30, '300658', 'UNIDAD DE ATENCION AL ENFERMO RENAL - UNAER', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(957, 2, 62, 30, '300669', 'CLINICA LOS ANGELES S.A.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(958, 2, 62, 30, '300679', 'HOSPITAL UNIVALLE NORTE COSAIN S.A.', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(959, 2, 62, 30, '300706', 'HOSP. DEL NORTE', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(960, 2, 62, 30, '300707', '\"CENTRO MEDICO CON INTERNACIÓN \"\"BUSCAMED\"\"\"', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(961, 2, 62, 30, '300725', '\"CENTRO DE EDUCACIÓN E INFORMACIÓN \"\"VIVIR CON DIABETES\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(962, 2, 62, 30, '300726', 'POLICONSULTORIO NORTE C.P.S. COCHABAMBA', 17, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(963, 2, 62, 30, '300727', 'CLINICA S.A.P.U. NORTE S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(964, 2, 62, 30, '300729', 'CONSULTORIO MEDICO FANNY', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(965, 2, 62, 30, '300731', 'CAJA BANCARIA ESTATAL DE SALUD - COCHABAMBA', 3, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(966, 2, 62, 30, '300732', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD  - COCHABAMBA', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(967, 2, 62, 30, '300739', 'INNOVASALUD S.A. CORACA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(968, 2, 62, 30, '300741', 'UNIVERSIDAD PRIVADA FRANZ TAMAYO', 19, 9, 4, 14, 2, NULL, NULL, NULL, NULL),
(969, 2, 62, 30, '300750', 'CENTRO MEDICO GAMBOA', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(970, 2, 62, 30, '300752', 'NEFROSALUD S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(971, 2, 63, 30, '300001', 'HOSP. COMBASE 9 DE ABRIL                                              ', 12, 2, 2, 22, 2, NULL, NULL, NULL, NULL),
(972, 2, 63, 30, '300003', 'ALALAY', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(973, 2, 63, 30, '300005', 'ALTO COCHABAMBA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(974, 2, 63, 30, '300011', 'HOSP. HARRY WILLIAMS                                                  ', 12, 2, 2, 22, 2, NULL, NULL, NULL, NULL),
(975, 2, 63, 30, '300014', 'HOSPITAL SAN VICENTE                               ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(976, 2, 63, 30, '300015', 'C. M. SAN MIGUEL                                                      ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(977, 2, 63, 30, '300017', 'C.S. MARIE STOPES                                                     ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(978, 2, 63, 30, '300018', 'C.S. POLICLÍNICO 32 CNS                                               ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(979, 2, 63, 30, '300019', 'C.S. POLICLÍNICO CAJA PETROLERA                                       ', 8, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(980, 2, 63, 30, '300024', 'CSBP - POLICONSULTORIO CBBA                                   ', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(981, 2, 63, 30, '300026', 'HOSP. CLÍNICA BOLIVIANO AMERICANO                                     ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(982, 2, 63, 30, '300027', 'HOSP. CLÍNICA VIRGEN DE GUADALUPE                                     ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(983, 2, 63, 30, '300028', 'CERRO VERDE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(984, 2, 63, 30, '300032', 'C.S. C.I.E.S. COCHABAMBA                                              ', 8, 1, 3, 4, 2, NULL, NULL, NULL, NULL),
(985, 2, 63, 30, '300035', 'HOSP. ALBINA PATIÑO                                                   ', 14, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(986, 2, 63, 30, '300036', 'HOSP. SEGURO UNIVERSITARIO UMSS                                       ', 11, 3, 7, 31, 2, NULL, NULL, NULL, NULL),
(987, 2, 63, 30, '300042', 'HOSP. CAJA CORDES                                                     ', 12, 2, 7, 7, 2, NULL, NULL, NULL, NULL),
(988, 2, 63, 30, '300043', 'JAIHUAYCO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(989, 2, 63, 30, '300044', 'KANATA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(990, 2, 63, 30, '300045', 'HOSP. CLÍNICA SANTA MÓNICA                                            ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(991, 2, 63, 30, '300047', 'LA MAICA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(992, 2, 63, 30, '300048', 'LACMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(993, 2, 63, 30, '300050', 'HOSP. UNIVALLE                                                        ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(994, 2, 63, 30, '300054', 'VILLA ISRAEL PUCARA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(995, 2, 63, 30, '300055', 'C.S. SAN MARCOS                                                       ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(996, 2, 63, 30, '300058', 'PUCARITA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(997, 2, 63, 30, '300059', 'ESPANA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(998, 2, 63, 30, '300061', 'C.S. PARROQUIA SAN CARLOS                                             ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(999, 2, 63, 30, '300064', 'ALTO PAGADOR', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1000, 2, 63, 30, '300065', 'SEBASTIAN PAGADOR', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1001, 2, 63, 30, '300073', 'GLORIA ALTO BUENA VISTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1002, 2, 63, 30, '300080', 'POLICLINICO SERVICIO DE CAMINOS                                  ', 16, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(1003, 2, 63, 30, '300082', 'SENNFELD', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1004, 2, 63, 30, '300086', 'HOSP. CLÍNICA COCHABAMBA                                              ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1005, 2, 63, 30, '300420', 'HOSPITAL COCHABAMBA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1006, 2, 63, 30, '300421', 'C.S. MINEROS SAN JUAN                                   ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1007, 2, 63, 30, '300449', 'C.S. CONSULTORIO SAN JUAN DE DIOS                                     ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1008, 2, 63, 30, '300451', 'C.S. SAN FRANCISCO LACMA                                              ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1009, 2, 63, 30, '300459', 'HOSP. POLICIAL VIRGEN DE COPACABANA                                   ', 12, 2, 7, 24, 2, NULL, NULL, NULL, NULL),
(1010, 2, 63, 30, '300460', 'HOSP. BOLIVIANO BELGA                                                 ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(1011, 2, 63, 30, '300465', 'HOSP. CLÍNICA DR. LUÍS MORALES ARNEZ                                  ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(1012, 2, 63, 30, '300468', 'HOSP. CLÍNICA SAN PEDRO                                               ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(1013, 2, 63, 30, '300470', 'HOSP. CLÍNICA SAN JUAN DE DIOS PULACAYO                               ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1014, 2, 63, 30, '300481', 'KARA KARA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1015, 2, 63, 30, '300487', 'HOSP. CLÍNICA SAAVEDRA                                                ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1016, 2, 63, 30, '300489', 'C.S. ÁNGELA                                                           ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1017, 2, 63, 30, '300490', 'C.S. SEÑOR DE BURGOS                                                  ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1018, 2, 63, 30, '300519', 'C.S. CLÍNICA AMAZONAS                                                 ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1019, 2, 63, 30, '300522', 'MAICA CENTRAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1020, 2, 63, 30, '300523', 'C.S. PADRE CALIXTO                                                    ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1021, 2, 63, 30, '300527', 'HOSP. CLÍNICA DEL TRANSPORTISTA                                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1022, 2, 63, 30, '300528', 'HOSP. CLÍNICA SEÑOR DE MAYO                                           ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1023, 2, 63, 30, '300541', 'C.S. VALLE HERMOSO                                                   ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1024, 2, 63, 30, '300542', 'NUEVA GANTE                                                      ', 3, 1, 4, 42, 2, NULL, NULL, NULL, NULL),
(1025, 2, 63, 30, '300558', 'C.S. CONSULTORIO PEDIATRICO                                           ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1026, 2, 63, 30, '300584', 'VILLA VENEZUELA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1027, 2, 63, 30, '300585', 'HOSP.  CLINICA  MARIA DE LOS  ANGELES                                 ', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(1028, 2, 63, 30, '300593', ' VIGILANCIA Y REFERENCIA CDVIR                                    ', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1029, 2, 63, 30, '300594', 'C.S. CENAROB                                                          ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1030, 2, 63, 30, '300597', 'CLINICA ARANJUEZ                                                      ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1031, 2, 63, 30, '300609', 'C.S. POLICLINICO DEL SUR                                              ', 8, 1, 7, 38, 2, NULL, NULL, NULL, NULL),
(1032, 2, 63, 30, '300611', 'C.S. FUNDACION SAN LUCAS                                               ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1033, 2, 63, 30, '300629', 'P.S. SAN ANTONIO PENITENCIARIO                                        ', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1034, 2, 63, 30, '300630', 'P.S. MUJERES SAN SEBASTIAN PENITENCIARIO                              ', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1035, 2, 63, 30, '300631', 'P.S VARONES SAN SEBASTIAN PENITENCIARIO                               ', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1036, 2, 63, 30, '300632', 'C.S. CENALFES                                                         ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1037, 2, 63, 30, '300633', 'C.S. SAN SILVESTRE                                                    ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1038, 2, 63, 30, '300640', 'HEMO - D SERVICIOS DE DIALISIS S.R.L.                                 ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1039, 2, 63, 30, '300642', 'C.S INTEGRAL 1RO DE MAYO                                              ', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1040, 2, 63, 30, '300643', 'C.S. SAN LUIS                                                         ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1041, 2, 63, 30, '300649', 'LOS LAUROS S.R.L.                                                     ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1042, 2, 63, 30, '300677', 'HOSPITAL DEL SUD', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1043, 2, 63, 30, '300680', 'CONSULTORIO MÉDICO H & S', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1044, 2, 63, 30, '300681', 'CENTRO MÉDICO OMONTE ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1045, 2, 63, 30, '300709', '\"CENTRO DE AISLAMIENTO COVID-19 \"\"CAMPO FERIAL\"\"\"', 7, 5, 6, 18, 2, NULL, NULL, NULL, NULL),
(1046, 2, 63, 30, '300728', 'CENTRO MEDICO LA SALUD', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1047, 2, 63, 30, '300738', 'INNOVASALUD S.A  ALALAY', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1048, 2, 63, 30, '300744', 'C.M. DR. RAUL JOAQUIN GAMBOA M.', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1049, 2, 63, 30, '300747', 'C.M. SEÑOR DE QUILLACAS ', 18, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1050, 2, 63, 30, '300761', 'C. HEMODIALISIS MUTATIS', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1051, 2, 73, 63, '300650', 'SAN BENITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1052, 2, 73, 63, '300651', 'SANTA ROSA DE LA BOCA DEL CHAPARE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1053, 2, 73, 63, '300652', 'SAN JOSE DE ANGOSTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1054, 2, 73, 63, '300653', 'TRES DE MAYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1055, 2, 73, 63, '300654', 'SAN MIGUELITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1056, 2, 73, 63, '300655', 'SANTA ROSA DEL ISIBORO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1057, 2, 73, 63, '300656', 'BUEN PASTOR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1058, 2, 72, 45, '300237', 'CATACHILLA ALTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1059, 2, 72, 45, '300238', 'CHALLVIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1060, 2, 72, 45, '300239', 'HUAYLLANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1061, 2, 72, 45, '300241', 'MELGA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1062, 2, 72, 45, '300242', 'PALCA (CBB)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1063, 2, 72, 45, '300243', 'HOSP. MEXICO SACABA', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1064, 2, 72, 45, '300244', 'CNS.SACABA                                                 ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1065, 2, 72, 45, '300245', 'CLINICA AREBALO                                                  ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(1066, 2, 72, 45, '300247', 'ASUNCION SACABA                                         ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(1067, 2, 72, 45, '300248', 'CONSULTORIO DR JOSE LAZARTE ROSEL                                       ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1068, 2, 72, 45, '300250', 'DR. J. C. VILLARROEL                                             ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1069, 2, 72, 45, '300252', 'SAPANANI                                                         ', 3, 1, 6, 3, 1, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(1070, 2, 72, 45, '300253', 'SOLOMON KLEIN', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1071, 2, 72, 45, '300254', 'TUTIMAYU', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1072, 2, 72, 45, '300255', 'UCUCHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1073, 2, 72, 45, '300433', 'CM REHAB. INTEG. VIRGEN DE AFRICA                                ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1074, 2, 72, 45, '300494', 'TUSCAPUJIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1075, 2, 72, 45, '300506', 'ALALAY', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1076, 2, 72, 45, '300507', 'AGUIRRE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1077, 2, 72, 45, '300511', 'PISLI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1078, 2, 72, 45, '300512', 'KALUYO CHICO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1079, 2, 72, 45, '300513', 'ICHUCOLLO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1080, 2, 72, 45, '300514', 'EL ABRA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1081, 2, 72, 45, '300544', 'VILLA EL MAR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1082, 2, 72, 45, '300589', 'GUADALUPE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1083, 2, 72, 45, '300623', 'LARATI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1084, 2, 72, 45, '300667', 'PACATA DISTRITO 3', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1085, 2, 72, 45, '300668', 'CENTRO DE HEMODIALISIS MARIA ESPERANZA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1086, 2, 72, 45, '300683', 'QUINTANILLA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1087, 2, 72, 45, '300684', 'C.S. SAN JUAN DE DIOS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1088, 2, 72, 45, '300701', 'BALTAZAR', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1089, 2, 72, 45, '300735', 'INNOVASALUD S.A. SACABA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1090, 2, 72, 45, '300753', 'SEÑOR DE LOS MILAGROS RIÑONCITOS  SR D.L.M', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1091, 2, 72, 32, '300258', 'CANDELARIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1092, 2, 72, 32, '300259', 'COLOMI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1093, 2, 72, 32, '300260', 'CORANI PAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1094, 2, 72, 32, '300261', 'MAICA MONTE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1095, 2, 72, 32, '300262', 'MOSOJ LLAJTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1096, 2, 72, 32, '300263', 'TABLAS MONTE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1097, 2, 72, 32, '300432', 'SAN JOSE ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1098, 2, 72, 32, '300493', 'PARACTI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1099, 2, 74, 63, '300265', 'AROMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1100, 2, 74, 63, '300266', 'CHIPIRIRI                                                        ', 4, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(1101, 2, 74, 63, '300267', 'CINCO ESQUINAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1102, 2, 74, 63, '300268', 'CRISTAL MAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1103, 2, 74, 63, '300269', 'ETERAZAMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1104, 2, 74, 63, '300270', 'ICOYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1105, 2, 74, 63, '300271', 'ISINUTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1106, 2, 74, 63, '300272', 'JATUN PAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1107, 2, 74, 63, '300273', 'MOLETO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1108, 2, 74, 63, '300275', 'TODO SANTOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1109, 2, 74, 63, '300276', 'PUCA MAYU                                                        ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1110, 2, 74, 63, '300277', 'PUERTO PATIÑO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1111, 2, 74, 63, '300278', 'SAMUZABETH', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1112, 2, 74, 63, '300279', 'KM 21', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1113, 2, 74, 63, '300280', 'SAN GABRIEL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1114, 2, 74, 63, '300281', 'SAN JOSE (CBB-VILLA TUNARI)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1115, 2, 74, 63, '300282', 'SAN RAFAEL (CBB)', 18, 1, 6, 21, 1, '-16.511447', '-68.133071', 1, '2023-09-21'),
(1116, 2, 74, 63, '300283', 'TACOPAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1117, 2, 74, 63, '300285', 'UNCIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1118, 2, 74, 63, '300286', 'VILLA 14 DE SEPTIEMBRE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1119, 2, 74, 63, '300287', 'VILLA BOLIVAR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1120, 2, 74, 63, '300288', 'HOSP. VILLA TUNARI S.F. DE ASIS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1121, 2, 74, 63, '300289', 'C.S. C.N.S. VILLA TUNARI                                              ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1122, 2, 74, 63, '300508', 'PEDRO DOMINGO MURILLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1123, 2, 74, 63, '300509', 'MARISCAL SUCRE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1124, 2, 74, 63, '300570', 'SAN SALVADOR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1125, 2, 74, 63, '300571', '1 DE MAYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1126, 2, 74, 63, '300572', 'URKUPIÑA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1127, 2, 74, 63, '300607', 'INDEPENDENCIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1128, 2, 74, 63, '300608', 'LITORAL SANTA ROSA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1129, 2, 74, 63, '300612', 'CENTRAL NUEVA CHAPARE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1130, 2, 74, 63, '300613', 'ITIRAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1131, 2, 74, 63, '300614', 'P.S. ALTO SAN JOSÉ                                                    ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1132, 2, 74, 63, '300615', 'CAPIHUARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1133, 2, 74, 63, '300616', 'CENTRAL ANZALDO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1134, 2, 74, 63, '300617', 'LOCOTAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1135, 2, 74, 63, '300673', 'C.S. ESPIRITU SANTO ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1136, 2, 74, 63, '300674', 'C.S. TOCOPILLA ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1137, 2, 74, 63, '300696', '1RO DE ABRIL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1138, 2, 74, 63, '300697', 'VILLA TUNARI', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1139, 2, 74, 63, '300759', 'HOSPITAL VILLA TUNARI', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1140, 2, 67, 54, '300134', 'HUERTA MAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1141, 2, 67, 54, '300135', 'IZATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1142, 2, 67, 54, '300136', 'PUJYUNI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1143, 2, 67, 54, '300137', 'TARATA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1144, 2, 67, 54, '300620', 'HUAYCULLI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1145, 2, 67, 22, '300138', 'ANZALDO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1146, 2, 67, 22, '300139', 'CRUZ KÂ´ASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1147, 2, 67, 22, '300140', 'JATUN CIENEGA (ALFA MAYU)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1148, 2, 67, 22, '300141', 'KALALLUSTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1149, 2, 67, 22, '300142', 'LA VIÑA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1150, 2, 67, 22, '300143', 'MOLLINI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1151, 2, 67, 22, '300144', 'PAJCHAPATA LUX', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1152, 2, 67, 22, '300145', 'PUCARA (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1153, 2, 67, 22, '300146', 'SAN ISIDRO - ANZALDO (CBBA)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1154, 2, 67, 22, '300147', 'SAN JOSE (CBB-ANZALDO)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1155, 2, 67, 22, '300600', 'C.S. FUNDACIÓN PIETRO GAMBA                                           ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1156, 2, 67, 24, '300148', 'ARBIETO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1157, 2, 67, 24, '300149', 'COPAPUGIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1158, 2, 67, 24, '300150', 'KALUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1159, 2, 67, 24, '300151', 'LA LOMA (CBB)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1160, 2, 67, 24, '300152', 'TIATACU', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1161, 2, 67, 24, '300622', 'ARANJUEZ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1162, 2, 67, 24, '300624', 'MAMANACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1163, 2, 67, 24, '300625', '20 DE OCTUBRE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1164, 2, 67, 24, '300626', 'LLAVE MAYU', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1165, 2, 67, 46, '300153', 'APILLAPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1166, 2, 67, 46, '300154', 'MATARANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1167, 2, 67, 46, '300155', 'QUECOMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1168, 2, 67, 46, '300156', 'SACABAMBA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1169, 2, 67, 46, '300157', 'YUNKATAQUI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1170, 2, 67, 46, '300621', 'CHALLAQUE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1171, 2, 67, 29, '300196', 'CLIZA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1172, 2, 67, 29, '300197', 'HUASA CALLE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1173, 2, 67, 29, '300198', 'UCURENA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1174, 2, 67, 29, '300199', 'V. CONCEPCION', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1175, 2, 67, 29, '300569', 'AYOMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1176, 2, 67, 29, '300758', 'C.S.A. CLIZA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1177, 2, 67, 57, '300200', 'ANA RANCHO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1178, 2, 67, 57, '300201', 'CHILLICCHI (TOKO)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1179, 2, 67, 57, '300202', 'SICHEZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1180, 2, 67, 57, '300203', 'TOKO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1181, 2, 67, 57, '300619', 'PUKA PAMAPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1182, 2, 67, 58, '300204', 'CARCAJE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1183, 2, 67, 58, '300205', 'TOLATA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1184, 2, 67, 58, '300618', 'PADRE SUYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1185, 2, 78, 36, '300357', 'KURI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1186, 2, 78, 36, '300359', 'MINA ASIENTOS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1187, 2, 78, 36, '300360', '\"HOSP. MIZQUE \"\"AUGUSTOMORALES ASUA\"\"\"', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1188, 2, 78, 36, '300365', 'SAN VICENTE (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1189, 2, 78, 36, '300366', 'TIN TIN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1190, 2, 78, 36, '300367', 'TIPA TIPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1191, 2, 78, 36, '300368', 'TUCMA ALTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1192, 2, 78, 36, '300424', 'TAJRAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1193, 2, 78, 36, '300517', 'UCHAMA ALTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1194, 2, 78, 36, '300704', 'MIZQUE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1195, 2, 78, 61, '300369', 'POCOTAICA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1196, 2, 78, 61, '300370', 'SIKIMIRA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1197, 2, 78, 61, '300371', 'SIVINGANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1198, 2, 78, 61, '300372', 'VILA VILA (CBB)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1199, 2, 78, 61, '300565', 'CUEVAS PAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1200, 2, 78, 21, '300373', 'ALALAY (MIZQUE)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1201, 2, 78, 21, '300374', 'QUTURI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1202, 2, 78, 21, '300375', 'AYAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1203, 2, 78, 21, '300376', 'YANAGAGA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1204, 2, 78, 21, '300547', 'SIVINGANI CHICO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1205, 2, 78, 21, '300568', 'GUAMAN HUACHANA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1206, 2, 78, 338, '300358', 'LAGUNA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1207, 2, 78, 338, '300361', 'MIZQUEPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1208, 2, 78, 338, '300362', 'RAQAYPAMPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1209, 2, 78, 338, '300363', 'MOLINERO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1210, 2, 78, 338, '300364', 'SALVIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1211, 2, 78, 338, '300477', 'SANTIAGO (CBB)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1212, 2, 68, 43, '300377', 'LA VILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1213, 2, 68, 43, '300378', 'HOSP. PUNATA (MANUEL A.VILLAR)', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1214, 2, 68, 43, '300379', 'PUNATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1215, 2, 68, 43, '300380', 'C.S. POL CNS  NO.55                                                   ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1216, 2, 68, 43, '300381', 'VIRGEN DE GUADALUPE (CBB-PUNATA)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1217, 2, 68, 43, '300382', 'LEON RANCHO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1218, 2, 68, 43, '300383', 'TAJAMAR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1219, 2, 68, 43, '300384', 'LAGUNA SULTI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1220, 2, 68, 43, '300388', 'CURSANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1221, 2, 68, 43, '300479', 'CAPILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1222, 2, 68, 43, '300686', 'CLINICA CAMACHO SRL.', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(1223, 2, 68, 43, '300687', 'CENTRO MÈDICO QUIRÙRGICO FLORES', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1224, 2, 68, 43, '300751', 'CENTRO MEDICO EL NIÑO DE LA ESPINA', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1225, 2, 68, 62, '300385', 'ARAMASI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1226, 2, 68, 62, '300386', 'VILLA RIVERO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1227, 2, 68, 62, '300393', 'SAN FRANCISCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1228, 2, 68, 62, '300591', '11 DE MARZO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1229, 2, 68, 47, '300387', 'ALISU MAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1230, 2, 68, 47, '300389', 'LAGUNA CARMEN', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1231, 2, 68, 47, '300390', 'SAN BENITO (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1232, 2, 68, 47, '300391', 'PARACAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1233, 2, 68, 47, '300392', 'SUNCHU PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1234, 2, 68, 51, '300394', 'TACACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1235, 2, 68, 51, '300567', 'HUAÑA COTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1236, 2, 68, 51, '300678', 'CHARAGOSI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1237, 2, 68, 33, '300395', 'V. GUALBERTO VILL.', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1238, 2, 68, 33, '300396', 'YANA RUMI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1239, 2, 66, 44, '300206', 'VILLA MARIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1240, 2, 66, 44, '300207', 'EL PASO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1241, 2, 66, 44, '300208', 'IRONCOLLO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1242, 2, 66, 44, '300209', 'KAUSAY', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1243, 2, 66, 44, '300210', '\"DISTRITO \"\"3\"\"                                                     \"', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1244, 2, 66, 44, '300211', 'C.S. POL.  QUILLACOLLO # 70                                           ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1245, 2, 66, 44, '300213', 'HOSP. DR. BENIGNO SANCHEZ QUILLACOLLO', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1246, 2, 66, 44, '300216', 'CALVARIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1247, 2, 66, 44, '300500', 'APOTE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1248, 2, 66, 44, '300666', 'MISICUNI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1249, 2, 66, 44, '300688', 'CENTRO MÉDICO QUIRÚRGICO SAN BERNARDO', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1250, 2, 66, 44, '300689', 'CENTRO MÉDICO QUIRÚRGICO SAN JOSE', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1251, 2, 66, 44, '300690', 'CENTRO MÉDICO SAN CRISTOBAL', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1252, 2, 66, 44, '300691', 'CLÍNICA ÁLVAREZ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1253, 2, 66, 44, '300692', 'CLÍNICA EL CARMEN', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1254, 2, 66, 44, '300693', 'CLÍNICA M. BUSTAMANTE', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1255, 2, 66, 44, '300736', 'CENTRO MEDICO QUIRURGICO COPACABANA', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1256, 2, 66, 44, '300745', 'CENTRO INTEGRAL NEPHROLOGICO THANICHIY VALLE BAJO S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1257, 2, 66, 44, '300748', 'HEMOSALUD', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1258, 2, 66, 44, '300749', 'INNOVASALUD S.A. QUILLACOLLO', 18, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1259, 2, 66, 44, '300763', 'CLINICA ARCANGELES', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1260, 2, 66, 50, '300217', 'ITAPAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1261, 2, 66, 50, '300218', 'MALLCO RANCHO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1262, 2, 66, 50, '300219', 'MONTE NEGRO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1263, 2, 66, 50, '300220', 'PAROTANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1264, 2, 66, 50, '300221', 'PAYACOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1265, 2, 66, 50, '300222', 'SENOR DE LOS MILAGROS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1266, 2, 66, 50, '300223', 'VINTO CHICO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1267, 2, 66, 50, '300561', 'UCHU UCHU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1268, 2, 66, 55, '300224', 'CHAPISIRCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1269, 2, 66, 55, '300226', 'LINDE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1270, 2, 66, 55, '300228', 'HOSP. TIQUIPAYA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1271, 2, 66, 55, '300504', 'CIUDAD DEL NIÑO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1272, 2, 66, 55, '300531', 'MONTECILLO ALTO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1273, 2, 66, 55, '300532', 'JAMPINA HUASI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1274, 2, 66, 55, '300538', 'VILLA ORURO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1275, 2, 66, 55, '300539', '4 ESQUINAS ( PUBLICO ALCALDIA)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1276, 2, 66, 55, '300557', 'CALLAJCHULPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1277, 2, 66, 55, '300734', 'CONSULTORIO VECINAL ENCANTO PAMPA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1278, 2, 66, 55, '300743', 'CENTRO DE SALUD INTEGRAL D5 TIQUIPAYA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1279, 2, 66, 64, '300229', 'HOSP. VINTO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1280, 2, 66, 64, '300533', 'HOSPITAL ESPERANZA                                                    ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(1281, 2, 66, 64, '300534', 'C.S. MACHAJMARCA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1282, 2, 66, 64, '300535', 'C.S ISCAYPATA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1283, 2, 66, 64, '300536', 'C.S. KERAYA                                ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1284, 2, 66, 64, '300552', 'C.S. CHULLA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1285, 2, 66, 64, '300562', 'C.S. COMBUYO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1286, 2, 66, 64, '300644', 'CHINCHILLA                                                       ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1287, 2, 66, 64, '300698', 'C. S. CRIN VINTO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1288, 2, 66, 31, '300230', 'CAPACACHI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1289, 2, 66, 31, '300231', 'HOSPITAL MUNICIPAL ANDRES CUSCHIERI                                     ', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1290, 2, 66, 31, '300232', 'KAMI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1291, 2, 66, 31, '300235', 'SIMON BOLIVAR', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1292, 2, 66, 31, '300236', 'COLCAPIRHUA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1293, 2, 66, 31, '300695', 'ESQUILAN GRANDE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1294, 2, 66, 31, '300760', 'RENALSER S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1295, 2, 75, 53, '300290', 'JAPO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1296, 2, 75, 53, '300291', 'CHALLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1297, 2, 75, 53, '300292', 'CHIVIRRANCHO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1298, 2, 75, 53, '300293', 'CORACABA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1299, 2, 75, 53, '300294', 'JATUN PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1300, 2, 75, 53, '300295', 'JIRONKOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1301, 2, 75, 53, '300296', 'LEQUE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1302, 2, 75, 53, '300297', 'LLAVINI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1303, 2, 75, 53, '300298', 'BOMBEO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1304, 2, 75, 53, '300299', 'RAMADAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1305, 2, 75, 53, '300300', 'TAPACARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1306, 2, 75, 53, '300301', 'TUNAS VINTO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1307, 2, 75, 53, '300302', 'VILLA PEREIRA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1308, 2, 75, 53, '300303', 'WACA PLAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1309, 2, 75, 53, '300496', 'ARAMASI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1310, 2, 75, 53, '300497', 'CONFITAL', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1311, 2, 75, 53, '300498', 'PONGO KASA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1312, 2, 75, 53, '300529', 'APHARUMIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1313, 2, 75, 53, '300530', 'HUAYLLAMAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1314, 2, 68, 56, '300402', 'COTANI ALTO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1315, 2, 68, 56, '300403', 'COTANI BAJO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1316, 2, 68, 56, '300405', 'ISKAY WASI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1317, 2, 68, 56, '300406', 'KASPICANCHA ALTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1318, 2, 68, 56, '300407', 'KAYARANI                                                         ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1319, 2, 68, 56, '300409', 'PALCA (CBB-TIRAQUE)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1320, 2, 68, 56, '300410', 'KOARI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1321, 2, 68, 56, '300411', 'SANKAYANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1322, 2, 68, 56, '300414', 'TIRAQUE NUESTRA SEÑORA DE LAS ANGUSTIAS                          ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1323, 2, 68, 56, '300415', 'PAIRUMANI (CBB)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1324, 2, 68, 56, '300416', 'ILURI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1325, 2, 68, 56, '300417', 'TORALAPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1326, 2, 68, 56, '300548', 'MHISKA MAYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1327, 2, 68, 56, '300610', 'RODEO BAJO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1328, 2, 68, 56, '300635', 'P.S. BOQUERON K´ASA                                                   ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1329, 2, 74, 66, '300404', '\"HOSP. \"\"SAN MARTIN DE PORRES\"\"  IBUELO                                    \"', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1330, 2, 74, 66, '300408', 'MAJO PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1331, 2, 74, 66, '300412', 'SANTA ROSA (CBB)                                                 ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1332, 2, 74, 66, '300413', 'SHINAOTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1333, 2, 74, 66, '300596', 'PUERTO AROMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1334, 2, 74, 66, '300606', 'IBIRIZU', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1335, 2, 74, 66, '300675', 'C.S. SAN LUIS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1336, 2, 74, 66, '300676', 'C.S. SAN ISIDRO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1337, 2, 74, 66, '300702', 'COSSMIL - CHAPARE', 18, 1, 7, 13, 1, NULL, NULL, NULL, NULL),
(1338, 4, 32, 134, '200522', 'EL TIGRE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1339, 4, 32, 134, '200523', 'IXIAMAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1340, 4, 32, 134, '200524', 'MERCEDEZ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1341, 4, 32, 134, '200525', 'CARMEN DEL EMERO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1342, 4, 32, 134, '200526', 'TAHUA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1343, 4, 32, 134, '200527', 'ESPERANZA DEL MADIDI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1344, 4, 32, 134, '200717', 'TOROMONAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1345, 4, 32, 134, '200777', 'MANURIMI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1346, 4, 32, 157, '200528', 'HOSPITAL MUNICIPAL SAN BUAN AVENTURA', 12, 2, 6, 3, 1, NULL, NULL, NULL, NULL),
(1347, 4, 32, 157, '200529', 'TUMUPASA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1348, 4, 32, 157, '200530', 'SAN JOSE DE CHUPIAMONAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1349, 4, 32, 157, '200531', '25 DE MAYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1350, 4, 32, 157, '200532', 'COMUNIDAD BUENAVISTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1351, 4, 39, 163, '200488', 'COLLPA PUCHO BELEN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1352, 4, 39, 163, '200489', 'CHIJMUNI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1353, 4, 39, 163, '200490', 'JARUMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1354, 4, 39, 163, '200491', 'KONANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1355, 4, 39, 163, '200492', 'LAHUACHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1356, 4, 39, 163, '200493', 'SICA SICA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1357, 4, 39, 163, '200494', 'VILLA ESTEBAN ARCE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1358, 4, 39, 163, '200756', 'PANDURO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1359, 4, 39, 163, '200757', 'MACHACAMARCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1360, 4, 39, 163, '200758', 'CHUACOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1361, 4, 39, 171, '200495', 'CANAVIRI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1362, 4, 39, 171, '200496', 'HUARI BELEN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1363, 4, 39, 171, '200497', 'KELLHUIRI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1364, 4, 39, 171, '200498', 'UMALA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1365, 4, 39, 171, '200722', 'SAN JOSE DE LLANGA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1366, 4, 39, 171, '200754', 'HUANCARAMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1367, 4, 39, 171, '200755', 'SANTIAGO DE COLLANA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1368, 4, 39, 149, '200506', 'VISCACHANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1369, 4, 39, 149, '200507', 'CHIARAQUE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1370, 4, 39, 149, '200508', 'CHIARUMANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1371, 4, 39, 149, '200509', 'HOSPITAL  PATACAMAYA', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1372, 4, 39, 149, '200863', 'COLCHANI', 18, 1, 6, 18, 1, '-16.511725', '-68.133778', 1, '2023-09-21'),
(1373, 4, 40, 103, '200499', 'AYO AYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1374, 4, 40, 103, '200500', 'EL THOLAR', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1375, 4, 40, 103, '200501', 'VILLA CARMEN (LPZ)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1376, 4, 40, 103, '200827', 'CUMBRE VILACOTA                                                 ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1377, 4, 40, 108, '200502', 'CALAMARCA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1378, 4, 40, 108, '200503', 'CALUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1379, 4, 40, 108, '200504', 'SAN ANTONIO - CALAMARCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1380, 4, 40, 108, '200505', 'SIVICANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1381, 4, 40, 108, '200734', 'VILAQUE COPATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1382, 4, 40, 108, '200826', 'AJOYA                                                        ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1383, 4, 40, 108, '200972', 'CHOCOROSI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1384, 4, 40, 117, '200510', 'COLQUENCHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1385, 4, 40, 117, '200511', 'MACHACAMARCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1386, 4, 40, 117, '200512', 'STGO.DE LLALLAGUA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1387, 4, 40, 117, '200606', 'MARQUIRIVI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1388, 4, 40, 117, '200839', 'MICAYA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1389, 4, 40, 116, '200513', 'COLLANA (COLLANA)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1390, 4, 40, 116, '200732', 'HICHURAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1391, 4, 40, 116, '200733', 'UNCALLAMAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1392, 4, 33, 128, '200533', 'AMARETE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1393, 4, 33, 128, '200534', 'CAATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1394, 4, 33, 128, '200535', 'FLORIDA (LPZ)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1395, 4, 33, 128, '200536', 'CHARAZANI', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1396, 4, 33, 128, '200537', 'CHULLINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1397, 4, 33, 128, '200538', 'COTAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1398, 4, 33, 128, '200622', 'HUATO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1399, 4, 33, 128, '200675', 'SOTOPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1400, 4, 33, 125, '200539', 'CANUHUMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1401, 4, 33, 125, '200540', 'CURVA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1402, 4, 33, 125, '200674', 'CAALAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1403, 4, 34, 152, '200261', 'CHIÑAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1404, 4, 34, 152, '200264', 'IQUIPUNI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1405, 4, 34, 152, '200266', 'PASUJA BELEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1406, 4, 34, 152, '200267', 'PUERTO ACOSTA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1407, 4, 34, 152, '200268', 'SALLACUCHO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1408, 4, 34, 152, '200860', 'COTAPATA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1409, 4, 34, 144, '200269', 'ILAVE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1410, 4, 34, 144, '200270', 'ITALAQUE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1411, 4, 34, 144, '200271', 'MOCO MOCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1412, 4, 34, 144, '200272', 'PACAURES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1413, 4, 34, 144, '200273', 'QUEÑI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1414, 4, 34, 144, '200274', 'QUILIMAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1415, 4, 34, 144, '200275', 'SAPHIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1416, 4, 34, 144, '200276', 'TAJANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1417, 4, 34, 144, '200277', 'WILACALA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1418, 4, 34, 144, '200658', 'PACOBAMBA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1419, 4, 34, 153, '200278', 'AGUAS CALIENTES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1420, 4, 34, 153, '200279', 'AMBANA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1421, 4, 34, 153, '200280', 'CARABUCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1422, 4, 34, 153, '200281', 'COPUSQUIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1423, 4, 34, 153, '200282', 'MOLLIPONGO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1424, 4, 34, 153, '200283', 'CHAGUAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1425, 4, 34, 153, '200284', 'SANTIAGO DE OKOLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1426, 4, 34, 153, '200285', 'YARICOA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1427, 4, 34, 153, '200286', 'HUILACUNCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1428, 4, 34, 153, '200659', 'CHUANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1429, 4, 34, 153, '200694', 'SANIDAD OPERATIVA BIMA                                         ', 3, 1, 1, 2, 1, NULL, NULL, NULL, NULL),
(1430, 4, 34, 153, '200778', 'CRUZ PATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1431, 4, 34, 179, '200263', 'HUMANATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1432, 4, 34, 179, '200265', 'PACOLLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1433, 4, 34, 178, '200260', 'CHALLAPATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1434, 4, 34, 178, '200262', 'HOSPITAL ESCOMA', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1435, 4, 36, 110, '200557', 'ALCOCHE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1436, 4, 36, 110, '200560', 'CALAMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1437, 4, 36, 110, '200561', 'HOSPITAL CARANAVI', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1438, 4, 36, 110, '200563', 'CARRASCO LA RESERVA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1439, 4, 36, 110, '200565', 'ENTRE RIOS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1440, 4, 36, 110, '200567', 'LOS ANDES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1441, 4, 36, 110, '200568', 'MOSCOVIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1442, 4, 36, 110, '200570', 'SAN PEDRO DE CARANAVI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1443, 4, 36, 110, '200572', 'TAYPIPLAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1444, 4, 36, 110, '200573', 'VILLA ELEVACION', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1445, 4, 36, 110, '200574', 'SAN LORENZO - CARANAVI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1446, 4, 36, 110, '200575', 'UYUNENSE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1447, 4, 36, 110, '200576', 'NOR-ESTE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1448, 4, 36, 110, '200613', 'CARANAVI  CNS                                                  ', 3, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1449, 4, 36, 110, '200678', 'VILLAMONTES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1450, 4, 36, 110, '200727', 'LLUSTA II', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1451, 4, 36, 110, '200816', 'SANTA FE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1452, 4, 36, 110, '200828', 'SAN PABLO                                                      ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1453, 4, 36, 110, '200829', 'REHABILITACION CARANAVI                                          ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1454, 4, 36, 110, '200865', 'C.S. VILLA LA PAZ ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1455, 4, 36, 110, '200866', 'C.S. SANTA  ANA DE CARANAVI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1456, 4, 36, 180, '200558', 'BELLA VISTA - LA PAZ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1457, 4, 36, 180, '200559', 'BORG', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1458, 4, 36, 180, '200564', 'LITORAL', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1459, 4, 36, 180, '200566', 'KOLLASUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1460, 4, 36, 180, '200569', 'SAN ANTONIO (CARANAVI)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1461, 4, 36, 180, '200571', 'SARARIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1462, 4, 36, 180, '200711', 'MERCEDES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1463, 4, 36, 180, '200759', 'VILLA EL PORVENIR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1464, 4, 33, 100, '200334', 'APOLO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1465, 4, 33, 100, '200335', 'ATEN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1466, 4, 33, 100, '200336', 'PUCHAHUI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1467, 4, 33, 100, '200337', 'SANTA CRUZ  VALLE AMENO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1468, 4, 33, 100, '200338', 'SIPHIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1469, 4, 33, 100, '200583', 'YANAMAYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1470, 4, 33, 100, '200666', 'PUCASUCHO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1471, 4, 33, 100, '200993', 'YUYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1472, 4, 33, 150, '200339', 'ANTAQUILLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1473, 4, 33, 150, '200340', 'PELECHUCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1474, 4, 33, 150, '200341', 'SUCHEZ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1475, 4, 33, 150, '200342', 'HILO HILO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1476, 4, 33, 150, '200343', 'ULLA ULLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1477, 4, 33, 150, '200699', 'HICHOCOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1478, 4, 33, 150, '200872', 'P.S. PUYU PUYU ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1479, 4, 31, 161, '200554', 'BERENGUELA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1480, 4, 31, 161, '200555', 'SANTIAGO DE MACHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1481, 4, 31, 161, '200736', 'HUARIPUJO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1482, 4, 31, 161, '200737', 'VILLA EXALTACION', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1483, 4, 31, 111, '200556', 'CATACORA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1484, 4, 31, 111, '200740', 'PAIRUMANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1485, 4, 31, 111, '200854', 'TOLACOLLO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1486, 4, 39, 158, '200547', 'JANKO MARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1487, 4, 39, 158, '200548', 'SAN PEDRO DE CURAHUARA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1488, 4, 39, 158, '200549', 'VILLA MANQUIRI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1489, 4, 39, 158, '200680', 'LLOKOHUTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1490, 4, 39, 158, '200723', 'JALSURI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1491, 4, 39, 158, '200739', 'CHOJNA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1492, 4, 39, 148, '200550', 'COLQUEAMAYA                                                      ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1493, 4, 39, 148, '200551', 'PAPEL PAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1494, 4, 39, 148, '200552', 'UNUPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1495, 4, 39, 148, '200716', 'MOLLEBAMBA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1496, 4, 39, 148, '200724', 'ESCALONA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1497, 4, 39, 148, '200725', 'RIVERA ALTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1498, 4, 39, 112, '200553', 'PACOLLO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1499, 4, 39, 112, '200726', 'CHACARILLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1500, 4, 23, 172, '200344', 'CHACOMA - VIACHA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1501, 4, 23, 172, '200346', 'COLLAGUA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1502, 4, 23, 172, '200348', 'CONIRI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1503, 4, 23, 172, '200350', 'HILATA CENTRO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1504, 4, 23, 172, '200351', 'JALSURI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1505, 4, 23, 172, '200357', 'FLORIDA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1506, 4, 23, 172, '200358', 'VIACHA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1507, 4, 23, 172, '200359', 'MISIONES MUNDIALES                                             ', 3, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(1508, 4, 23, 172, '200361', 'VILLA REMEDIOS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1509, 4, 23, 172, '200362', 'VIACHA CNS                                                   ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1510, 4, 23, 172, '200701', 'HOSPITAL MUNICIPAL VIACHA', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1511, 4, 23, 172, '200800', 'TILATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1512, 4, 23, 172, '200883', 'CIMFA VIACHA', 5, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1513, 4, 23, 172, '200885', 'CENTRO MÉDICO ROMA ', 3, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1514, 4, 23, 172, '200908', 'COSSMIL VIACHA', 3, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(1515, 4, 23, 172, '200965', 'CENTRO MEDICO BELLA VISTA', 3, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1516, 4, 38, 130, '200363', 'ANDAMARCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1517, 4, 38, 130, '200364', 'COPAJIRA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1518, 4, 38, 130, '200365', 'GUAQUI', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1519, 4, 38, 130, '200366', 'KASSA STA. ROSA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1520, 4, 38, 168, '200367', 'ACHACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1521, 4, 38, 168, '200368', 'CALUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1522, 4, 38, 168, '200369', 'HUACULLANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1523, 4, 38, 168, '200372', 'PILLAPI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1524, 4, 38, 168, '200374', 'TIAHUANACU', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1525, 4, 38, 126, '200376', 'DESAGUADERO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1526, 4, 38, 126, '200377', 'SAN JUAN DE HUANCOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1527, 4, 38, 126, '200853', 'KEALLUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1528, 4, 38, 99, '200347', 'CONCHACOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1529, 4, 38, 99, '200353', 'LAQUINAMAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1530, 4, 38, 99, '200354', 'SAN ANDRES DE MACHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1531, 4, 38, 99, '200360', 'VILLA PUSUMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1532, 4, 38, 99, '200621', 'TATA PEPE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1533, 4, 38, 135, '200345', 'CHAMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1534, 4, 38, 135, '200349', 'CORPA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1535, 4, 38, 135, '200352', 'JESUS DE MACHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1536, 4, 38, 135, '200355', 'SANTO DOMINGO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1537, 4, 38, 135, '200356', 'SULLCATITI KHONKHO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1538, 4, 38, 135, '200660', 'PARINA ARRIBA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1539, 4, 38, 135, '200661', 'KALLA BAJA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1540, 4, 38, 135, '200830', 'CUIPA                                                          ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1541, 4, 38, 135, '200831', 'JANCOHAQUE                                                     ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1542, 4, 38, 166, '200370', 'CHIRIPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1543, 4, 38, 166, '200371', 'NACHOCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1544, 4, 38, 166, '200373', 'TARACO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1545, 4, 38, 166, '200649', 'COACOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1546, 4, 38, 166, '200850', 'JAHUIRA PAMPA ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1547, 4, 42, 132, '200401', 'ARCOPONGO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1548, 4, 42, 132, '200402', 'CAPIÑATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1549, 4, 42, 132, '200403', 'CAVARI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1550, 4, 42, 132, '200404', 'COPACABANA (LPZ)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1551, 4, 42, 132, '200405', 'INQUISIVI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1552, 4, 42, 132, '200406', 'VENTILLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1553, 4, 42, 132, '200407', 'SIGUAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1554, 4, 42, 132, '200618', 'POCUSCO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1555, 4, 42, 132, '200696', 'PATOHOCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1556, 4, 42, 132, '200765', 'KANAMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1557, 4, 42, 132, '200812', 'YACUPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1558, 4, 42, 156, '200408', 'CHOQUETANGA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1559, 4, 42, 156, '200409', 'MINA ARGENTINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1560, 4, 42, 156, '200411', 'QUIME', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1561, 4, 42, 156, '200412', 'PONGO B2', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1562, 4, 42, 156, '200648', 'PACUNI  CNS                                                    ', 3, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1563, 4, 42, 106, '200413', 'CAJUATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1564, 4, 42, 106, '200414', 'CIRCUATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1565, 4, 42, 106, '200415', 'SURI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1566, 4, 42, 106, '200416', 'VILLA KHORA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1567, 4, 42, 106, '200672', 'HUARITOLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1568, 4, 42, 106, '200813', 'CANAMINA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1569, 4, 42, 118, '200417', 'AJAMARCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1570, 4, 42, 118, '200418', 'COLQUIRI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1571, 4, 42, 118, '200419', 'MOHOZA LANZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1572, 4, 42, 118, '200420', 'PAUCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1573, 4, 42, 118, '200421', 'PIPINI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1574, 4, 42, 118, '200422', 'SALLALLI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1575, 4, 42, 118, '200423', 'TULTUANI (CORIRI)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1576, 4, 42, 118, '200647', 'COLQUIRI  CNS                                                  ', 3, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1577, 4, 42, 118, '200673', 'ANCOCOTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1578, 4, 42, 118, '200695', 'CALUYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1579, 4, 42, 118, '200792', 'CAQUENA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1580, 4, 42, 118, '200793', 'UYUNI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1581, 4, 42, 118, '200852', 'LLANQUERA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1582, 4, 42, 118, '200988', 'CENTRO DE SALUD VIRGEN DE FATIMA', 2, 1, 7, 28, 1, NULL, NULL, NULL, NULL),
(1583, 4, 42, 131, '200424', 'GERMAN BUSCH', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1584, 4, 42, 131, '200425', 'ICHOCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1585, 4, 42, 131, '200426', 'LURUTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1586, 4, 42, 131, '200662', 'SAN ANTONIO DE SIRARANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1587, 4, 42, 131, '200859', 'FRANZ TAMAYO - ICHOCA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1588, 4, 42, 139, '200427', 'LICOMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1589, 4, 42, 139, '200686', 'CHARAPAXI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1590, 4, 30, 164, '200302', 'CHUCHULAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1591, 4, 30, 164, '200303', 'CHUSSI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1592, 4, 30, 164, '200304', 'ILABAYA(CHEJJE)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1593, 4, 30, 164, '200305', 'LARIPATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1594, 4, 30, 164, '200306', 'MILLIPAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1595, 4, 30, 164, '200307', 'SORATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1596, 4, 30, 164, '200308', 'OBISPO BOSQUE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1597, 4, 30, 164, '200309', 'YANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1598, 4, 30, 164, '200310', 'ANCOMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1599, 4, 30, 164, '200820', 'NATHALIE ESTEPHANIE - ILABAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1600, 4, 30, 164, '200841', 'VIACHA - SORATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1601, 4, 30, 165, '200325', 'CONZATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1602, 4, 30, 165, '200326', 'TACACOMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1603, 4, 30, 165, '200708', 'INCACHACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1604, 4, 30, 165, '200772', 'SECTOR UNO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1605, 4, 30, 165, '200842', 'TACACHACA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1606, 4, 30, 165, '200843', 'PALLAYUNGA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1607, 4, 30, 165, '200844', 'CHUMISA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1608, 4, 30, 155, '200327', 'QUIABAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1609, 4, 30, 155, '200992', 'CHACAMBAYA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1610, 4, 30, 120, '200328', 'COMBAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1611, 4, 30, 120, '200329', 'SOREJAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1612, 4, 30, 120, '200704', 'TICAMBLAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1613, 4, 30, 120, '200705', 'HUAYCHO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1614, 4, 36, 129, '200312', 'AMAGUAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1615, 4, 36, 129, '200313', 'CARURA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1616, 4, 36, 129, '200315', 'GUANAY', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1617, 4, 36, 129, '200321', 'TANIPLAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1618, 4, 36, 129, '200323', 'VILLA FLORIDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1619, 4, 36, 129, '200773', 'CANDELARIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1620, 4, 36, 169, '200330', 'CHIMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1621, 4, 36, 169, '200332', 'TIPUANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1622, 4, 36, 169, '200333', 'UNUTULUNI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1623, 4, 36, 169, '200703', 'CHUQUINI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1624, 4, 36, 142, '200314', 'CHIMATE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1625, 4, 36, 142, '200316', 'MAPIRI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1626, 4, 36, 142, '200318', 'SANTA ROSA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1627, 4, 36, 142, '200324', 'ACHIQUIRI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1628, 4, 36, 167, '200311', 'ALTO TOMACHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1629, 4, 36, 167, '200317', 'MAYAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1630, 4, 36, 167, '200319', 'SANTO DOMINGO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1631, 4, 36, 167, '200320', 'TAJLIHUI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1632, 4, 36, 167, '200322', 'TEOPONTE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1633, 4, 36, 167, '200584', 'VILLA AROMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1634, 4, 36, 167, '200782', 'TOMACHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1635, 4, 40, 162, '200384', 'CARACATO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1636, 4, 40, 162, '200385', 'MURUHUTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1637, 4, 40, 162, '200386', 'SAPAHAQUI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1638, 4, 40, 162, '200387', 'KHOLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1639, 4, 41, 140, '200378', 'ANCHALLANI                                                       ', 18, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(1640, 4, 41, 140, '200379', 'LURIBAY', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1641, 4, 41, 140, '200380', 'AZAMBO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1642, 4, 41, 140, '200381', 'POROMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1643, 4, 41, 140, '200382', 'PUCUMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1644, 4, 41, 140, '200383', 'PORVENIR', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1645, 4, 41, 140, '200624', 'MURMUNTANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(1646, 4, 41, 140, '200684', 'COLLIRI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1647, 4, 41, 140, '200685', 'ANQUIOMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1648, 4, 41, 140, '200810', 'MATARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1649, 4, 41, 140, '200953', 'CENTRO DE ATENCION AMBULATORIO VILACORA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1650, 4, 41, 174, '200388', 'CAXATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1651, 4, 41, 174, '200389', 'CONCHAMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1652, 4, 41, 174, '200390', 'TABLACHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1653, 4, 41, 174, '200391', 'VILLA PUCHUNI (YACO)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1654, 4, 41, 174, '200392', 'YACO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1655, 4, 41, 174, '200608', 'CHALLOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1656, 4, 41, 174, '200609', 'CHUCAMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1657, 4, 41, 174, '200610', 'PAMPAJASI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1658, 4, 41, 174, '200748', 'HORNUNI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1659, 4, 41, 141, '200393', 'JACHAPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1660, 4, 41, 141, '200394', 'MALLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1661, 4, 41, 141, '200589', 'RODEO (LPZ)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1662, 4, 41, 141, '200607', 'ASIRIRI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1663, 4, 41, 105, '200395', 'CAIROMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1664, 4, 41, 105, '200396', 'COROCUTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1665, 4, 41, 105, '200397', 'LLOJA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1666, 4, 41, 105, '200398', 'TORREPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1667, 4, 41, 105, '200399', 'UCHUMBAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1668, 4, 41, 105, '200400', 'VILOCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1669, 4, 41, 105, '200590', 'HUARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1670, 4, 41, 105, '200646', 'VILOCO  CNS                                                    ', 3, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(1671, 4, 41, 105, '200657', 'SACANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1672, 4, 41, 105, '200718', 'MACHACAMARCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1673, 4, 41, 105, '200867', 'P.S. ARACA EL ASIENTO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1674, 4, 35, 151, '200466', 'CATAVI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1675, 4, 35, 151, '200467', 'CHOJASIVI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1676, 4, 35, 151, '200468', 'CORAPATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1677, 4, 35, 151, '200469', 'PALCOCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1678, 4, 35, 151, '200470', 'PATAMANTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1679, 4, 35, 151, '200471', 'HOSPITAL MUNICIPAL PUCARANI', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(1680, 4, 35, 151, '200472', 'VILLA VILAQUE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1681, 4, 35, 151, '200483', 'AYGACHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1682, 4, 35, 151, '200484', 'COHANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1683, 4, 35, 151, '200760', 'LACAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1684, 4, 35, 151, '200848', 'VILLA IQUIACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1685, 4, 35, 151, '200849', 'CHIARPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1686, 4, 35, 104, '200478', 'BATALLAS', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1687, 4, 35, 104, '200479', 'CHACHACOMANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1688, 4, 35, 104, '200480', 'KERANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1689, 4, 35, 104, '200481', 'PEÑAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1690, 4, 35, 104, '200482', 'TUQUIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1691, 4, 35, 104, '200940', 'CENTRO DE SALUD CALASAYA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1692, 4, 35, 104, '200941', 'CENTRO DE SALUD SURIQUIÑA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1693, 4, 35, 154, '200485', 'SURIQUI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1694, 4, 35, 154, '200486', 'PUERTO PEREZ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1695, 4, 35, 154, '200487', 'QUEHUAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1696, 4, 35, 154, '200614', 'CUMANA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1697, 4, 35, 154, '200966', 'KHANAPATA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(1698, 4, 38, 138, '200473', 'CURVA PUCARA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1699, 4, 38, 138, '200474', 'LAJA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1700, 4, 38, 138, '200475', 'SAN JUAN SATATOTORA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1701, 4, 38, 138, '200476', 'SANTA ROSA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1702, 4, 38, 138, '200477', 'TAMBILLO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1703, 4, 38, 138, '200605', 'KALLUTACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1704, 4, 38, 138, '200761', 'CANTAPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1705, 4, 38, 138, '200762', 'CAPACASI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1706, 4, 35, 121, '200541', 'COPACABANA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1707, 4, 35, 121, '200542', 'ISLA DEL SOL', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1708, 4, 35, 121, '200543', 'SIRIPACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1709, 4, 35, 121, '200808', 'HUACUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1710, 4, 35, 159, '200544', 'OJJE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1711, 4, 35, 159, '200545', 'TIQUINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1712, 4, 35, 159, '200587', 'VILLA AMACARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1713, 4, 35, 159, '200650', 'SAN PEDRO DE TIQUINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1714, 4, 35, 170, '200546', 'TITO YUPANQUI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1715, 4, 35, 170, '200615', 'HUATAPAMPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1716, 4, 79, 137, '200010', 'HOSPITAL GRAL. NRO 1 (OBRERO)                                         ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1717, 4, 79, 137, '200011', 'HOSPITAL OTORRINO OFTALMOLOGICO                                       ', 14, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1718, 4, 79, 137, '200082', 'HOSPITAL MATERNO INFANTIL                                             ', 14, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1719, 4, 79, 137, '200099', 'HOSPITAL PSIQUIATRICO N° 14                                           ', 14, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1720, 4, 79, 137, '200100', 'HOSPITAL MILITAR COSSMIL                                              ', 11, 3, 7, 13, 2, NULL, NULL, NULL, NULL),
(1721, 4, 79, 137, '200102', 'INSTITUTO DE REHABILITACION                                           ', 14, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1722, 4, 79, 137, '200115', 'HOSPITAL GENERAL L.U.O                                                ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1723, 4, 79, 137, '200580', 'CLINICA GERIATRICA                                                    ', 14, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(1724, 4, 79, 137, '200671', 'POLICLINICO DE ESPECIALIDADES LP                                      ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1725, 4, 79, 137, '200901', 'H.O.D.E. ONCOLOGICO', 14, 3, 7, 10, 1, NULL, NULL, NULL, NULL),
(1726, 4, 79, 137, '200902', '\"CENTRO INTEGRAL DE REHABILITACIÓN INFANTIL \"\"JUANA  AZURDUY DE PADILLA\"\"\"', 2, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1727, 4, 79, 137, '200076', 'HOSPITAL DE LA MUJER                                                  ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1728, 4, 79, 137, '200077', 'HOSPITAL DE CLINICAS                                                  ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1729, 4, 79, 137, '200078', 'HOSPITAL DEL NIÑO                                                     ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1730, 4, 79, 137, '200079', 'INSTITUTO DE GASTROENTEROLOGIA                                        ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1731, 4, 79, 137, '200080', 'INSTITUTO NAL. DE OFTALMOLOGIA                                        ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1732, 4, 79, 137, '200081', 'INSTITUTO NAL. DEL TORAX                                              ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1733, 4, 79, 137, '200101', 'INST. NAL. SALUD OCUPACIONAL                                          ', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1734, 4, 79, 137, '200108', 'INLASA                                                                ', 13, 7, 6, 21, 2, NULL, NULL, NULL, NULL),
(1735, 4, 79, 137, '200664', 'HOSPITAL DE REHABILITACIÓN Y SALUD MENTAL SAN JUAN DE DIOS            ', 14, 3, 2, 19, 2, NULL, NULL, NULL, NULL),
(1736, 4, 79, 137, '200823', 'CENTRO DE REHABILITACION DEL QUEMADO                                  ', 14, 3, 3, 16, 2, NULL, NULL, NULL, NULL),
(1737, 4, 79, 137, '200933', '\"VACUNATORIO \"\"PAI SEDES LA PAZ\"\"\"', 19, 9, 6, 17, 2, NULL, NULL, NULL, NULL),
(1738, 4, 24, 127, '200163', 'HOSPITAL CORAZON DE JESUS                                             ', 11, 3, 2, 19, 2, NULL, NULL, NULL, NULL),
(1739, 4, 24, 127, '200809', 'HOSPITAL DEL NORTE                                                    ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1740, 4, 24, 127, '200921', 'HOSPITAL DE EL ALTO SUR', 11, 3, 6, 18, 2, NULL, NULL, NULL, NULL),
(1741, 4, 24, 127, '200945', 'VACUNATORIO MUNICIPAL EL ALTO', 19, 9, 6, 18, 2, NULL, NULL, NULL, NULL),
(1742, 4, 18, 137, '200005', 'NIÑO KOLLO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1743, 4, 18, 137, '200006', 'CLINICA CEMES                                                         ', 5, 1, 4, 12, 2, NULL, NULL, NULL, NULL),
(1744, 4, 18, 137, '200007', 'POLICLINICO 9 DE ABRIL                                                ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1745, 4, 18, 137, '200008', 'LA GRUTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1746, 4, 18, 137, '200012', 'TEMBLADERANI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1747, 4, 18, 137, '200015', 'TACAGUA BAJO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1748, 4, 18, 137, '200017', 'PASANKERY', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1749, 4, 18, 137, '200018', 'LLOJETA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1750, 4, 18, 137, '200028', '8 DE DICIEMBRE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1751, 4, 18, 137, '200029', 'CLINICA C.I.E.S. LA PAZ                                               ', 5, 1, 3, 4, 2, NULL, NULL, NULL, NULL),
(1752, 4, 18, 137, '200032', 'SAN PEDRO BAJO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1753, 4, 18, 137, '200034', 'SAN LUIS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1754, 4, 18, 137, '200035', 'VILLA  NUEVO POTOSI', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1755, 4, 18, 137, '200038', 'POLICLINICO CAMINOS REGIONAL LA PAZ                                   ', 3, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(1756, 4, 18, 137, '200039', 'TACAGUA  ALTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1757, 4, 18, 137, '200045', 'ALCOREZA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1758, 4, 18, 137, '200046', 'BIBLIOTECA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1759, 4, 18, 137, '200084', 'POLICLINICO 20 DE OCTUBRE                                             ', 16, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(1760, 4, 18, 137, '200105', 'EL ROSAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1761, 4, 18, 137, '200113', 'PENAL DE SAN PEDRO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1762, 4, 18, 137, '200625', 'CLINICA 6 DE AGOSTO                                                   ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1763, 4, 18, 137, '200627', 'CLINICA LIENDO                                                        ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1764, 4, 18, 137, '200629', 'CLINICA SAN PABLO                                                     ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1765, 4, 18, 137, '200630', 'CLINICA VIRGEN DE LA ASUNCION                                         ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1766, 4, 18, 137, '200631', 'CLINIMED SRL.                                                         ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1767, 4, 18, 137, '200633', 'HOSPITAL DEL SEGURO SOCIAL UNIVERSITARIO', 12, 2, 7, 32, 2, NULL, NULL, NULL, NULL),
(1768, 4, 18, 137, '200692', 'MARIE STOPES BOLIVIA                                           ', 3, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(1769, 4, 18, 137, '200776', 'USACSIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1770, 4, 18, 137, '200801', 'HOSPITAL UNIVERSITARIO NUESTRA SEÑORA DE LA PAZ                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1771, 4, 18, 137, '200871', 'HOSPITAL MUNICIPAL COTAHUMA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1772, 4, 18, 137, '200887', 'CLÍNICA SOCIEDAD MÉDICA ALEMANA S.R.L.', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1773, 4, 18, 137, '200946', 'HEMO D SERVICIOS DE DIALISIS S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1774, 4, 18, 137, '200947', 'RENALVIDA S.R.L.', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1775, 4, 18, 137, '200954', 'CLINICA VIRGEN DE LAS NIEVES', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1776, 4, 18, 137, '200970', 'CLINICA RENGEL', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1777, 4, 18, 137, '200975', 'DERMACLINIC', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1778, 4, 18, 137, '200980', 'CLINICA BRASIL', 2, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1779, 4, 18, 137, '200981', 'CONSUL. MEDICO DAR SALUD 20 DE OCTUBRE', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1780, 4, 19, 137, '200048', 'CHAMOCO CHICO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1781, 4, 19, 137, '200049', 'HOSPITAL LA PAZ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1782, 4, 19, 137, '200050', 'ALTO MCAL.SANTA CRUZ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1783, 4, 19, 137, '200075', 'HOSPITAL  JUAN XXIII                                                  ', 11, 3, 2, 19, 2, NULL, NULL, NULL, NULL),
(1784, 4, 19, 137, '200086', 'LA PORTADA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1785, 4, 19, 137, '200087', 'EL TEJAR', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1786, 4, 19, 137, '200088', 'BAJO TEJAR', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1787, 4, 19, 137, '200089', 'MUNAYPATA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1788, 4, 19, 137, '200090', 'OBISPO INDABURO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1789, 4, 19, 137, '200091', 'CDVIR LA PAZ', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1790, 4, 19, 137, '200092', 'CIUDADELA FERROVIARIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1791, 4, 19, 137, '200093', 'PANTICIRCA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1792, 4, 19, 137, '200094', 'SAID', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1793, 4, 19, 137, '200096', 'POLICLINICO 18 DE MAYO                                                ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1794, 4, 19, 137, '200114', 'VILLA VICTORIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1795, 4, 19, 137, '200118', 'APUMALLA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1796, 4, 19, 137, '200654', 'CAMSIQUE ZONGO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1797, 4, 19, 137, '200750', 'ZONGO CHORO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1798, 4, 19, 137, '200857', 'HOSPITAL MUNICIPAL LA PORTADA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1799, 4, 19, 137, '200884', 'CONSULTORIO MEDICO GENERAL LA MERCED', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1800, 4, 19, 137, '200889', 'CENTRO MEDICO LA PAZ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1801, 4, 19, 137, '200909', '\"CONSULTORIO MEDICO \"\"DULCE ESPERANZA\"\"\"', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1802, 4, 19, 137, '200915', 'CONSULTORIO MEDICO DE LA MUJER', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1803, 4, 19, 137, '200916', 'CENTRO MEDICO DE LA FAMILIA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1804, 4, 19, 137, '200917', 'CENTRO MEDICO HOGAR Y SALUD', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1805, 4, 20, 137, '200004', 'HOSPITAL ARCO IRIS                                                    ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1806, 4, 20, 137, '200009', 'CORDES                                                ', 17, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(1807, 4, 20, 137, '200019', '18 DE MAYO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1808, 4, 20, 137, '200036', '\"CAJA BANCARIA ESTATAL DE SALUD - CLINICA MODELO LA PAZ\"\"                 \"', 5, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(1809, 4, 20, 137, '200037', 'CSBP - POLICONSULTORIO LA PAZ', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(1810, 4, 20, 137, '200051', 'PLAN AUTOPISTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1811, 4, 20, 137, '200052', 'ACHACHICALA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1812, 4, 20, 137, '200053', 'AGUA DE LA VIDA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1813, 4, 20, 137, '200054', 'SAN JUAN LAZARETO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1814, 4, 20, 137, '200056', 'ALTO MIRAFLORES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1815, 4, 20, 137, '200058', 'EL CALVARIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1816, 4, 20, 137, '200059', 'CHUQUIAGUILLO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1817, 4, 20, 137, '200060', 'HOSPITAL SAN FRANCISCO DE ASIS                                        ', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(1818, 4, 20, 137, '200061', 'SAN JOSE NATIVIDAD', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1819, 4, 20, 137, '200062', 'VILLA  FATIMA LAS DELICIAS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1820, 4, 20, 137, '200065', 'VINO TINTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1821, 4, 20, 137, '200073', 'ASISTENCIA PUBLICA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1822, 4, 20, 137, '200074', 'CEMSE                                                          ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1823, 4, 20, 137, '200083', 'POL. VILLA FATIMA                                                     ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1824, 4, 20, 137, '200095', 'JUANCITO PINTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1825, 4, 20, 137, '200097', 'POLICONSULTORIO  CENTRAL                                                ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1826, 4, 20, 137, '200098', 'POLICONSULTORIO MANCO KAPAC                                             ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1827, 4, 20, 137, '200104', 'POLICONSULTORIO  MIRAFLORES                                             ', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1828, 4, 20, 137, '200595', 'SAN ANTONIO DE PADUA                                           ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1829, 4, 20, 137, '200652', 'PENITENCIARIO MIRAFLORES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1830, 4, 20, 137, '200715', 'POLICONSULTORIO PROSALUD LA PAZ                                         ', 17, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(1831, 4, 20, 137, '200752', 'HOSPITAL LA MERCED', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1832, 4, 20, 137, '200811', 'INTERCULTURAL BARTOLINA SISA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1833, 4, 20, 137, '200832', 'INSTITUTO BOLIVIANO DE NEFROLOGIA                                     ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1834, 4, 20, 137, '200846', 'CENTRAL MIRAFLORES', 17, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(1835, 4, 20, 137, '200847', 'LAS DELICIAS CENTRAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1836, 4, 20, 137, '200856', 'UNIDAD DE TERAPIA RENAL SAN FRANCISCO DE ASIS', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1837, 4, 20, 137, '200858', 'NEFROMED SRL. (NEFROLOGIA Y MEDICINA)', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1838, 4, 20, 137, '200878', 'INSTITUTO NACIONAL DE MEDICINA NUCLEAR ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(1839, 4, 20, 137, '200882', 'CLINICA SANTA LAURA S.R.L.', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1840, 4, 20, 137, '200888', '\"CONSULTORIO MEDICO \"\"SAN JUDAS TADEO1\"\"\"', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1841, 4, 20, 137, '200890', 'CLINICA  AMID S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1842, 4, 20, 137, '200891', 'CLINICA SANTA TERESA', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1843, 4, 20, 137, '200893', 'INSTITUTO DE ONCOHEMATOLOGÍA ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1844, 4, 20, 137, '200895', 'CONKARDIO CENTRO CARDIOLÓGICO INTEGRAL S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1845, 4, 20, 137, '200896', 'CONSULTORIO MEDICO DE ESPECIALIDAD EN TRAUMATOLOGIA Y ORTOPEDIA', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1846, 4, 20, 137, '200897', 'CIES SALUD SEXUAL Y REPRODUCTIVA - SUC TUMUSLA ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1847, 4, 20, 137, '200903', 'CENTRO MEDICO DE PIEL', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1848, 4, 20, 137, '200904', 'CLINICA SEÑOR DE LA EXALTACIÓN S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1849, 4, 20, 137, '200905', 'CONSULTORIO MÉDICO DE ESPECIALIDAD EN GINECOLOGÍA Y OBSTETRICIA CON ECOG', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1850, 4, 20, 137, '200907', 'POLICONSULTORIO UYUNI', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1851, 4, 20, 137, '200910', 'RED DE SALUD INTERNACIONAL DE ASISTENCIA S.A.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1852, 4, 20, 137, '200911', 'CONSULTORIO MEDICO QUIRURGICO SAN FRANCISCO', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1853, 4, 20, 137, '200912', '\"CENTRO ONCOLÓGICO \"\"ONCOCLINIC S.R.L.\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1854, 4, 20, 137, '200918', 'CONSULTORIO MEDICO DE ESPECIALIDAD EN CARDIOLOGÍA Y PATOLOGÍA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1855, 4, 20, 137, '200930', 'CONSULTORIO MEDICO RESP. MARCO F. BARRERA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1856, 4, 20, 137, '200937', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD-LA PAZ', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(1857, 4, 20, 137, '200944', 'CENTRO DE ESPECIALIDADES MEDICAS PROSALUD MIRAFLORES', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1858, 4, 20, 137, '200950', 'POLICONSULTORIO DE ESPECIALIDADES ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1859, 4, 20, 137, '200952', 'CONSULTORIO MEDICO DE ESPECIALIDADES DE GINECO OBSTETRICIA', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1860, 4, 20, 137, '200959', 'CONSULTORIO INTEGRAL', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1861, 4, 20, 137, '200962', 'CONSULTORIO MEDICO FAMILIAR', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1862, 4, 20, 137, '200967', 'CENTRO DE ESPECIALIDADES MEDICAS D. N. J.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1863, 4, 20, 137, '200971', 'ESCOBAR CLINICA OFTALMOLOGICA S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1864, 4, 20, 137, '200973', 'HEMOCENTRO -BSRDLP', 1, 4, 6, 17, 2, NULL, NULL, NULL, NULL),
(1865, 4, 20, 137, '200984', 'CONSUL.MEDICO DE ESPECIALIDAD EN OFTALMOLOGIA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1866, 4, 20, 137, '200985', 'CONSULTORIO MEDICO UYUNI', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1867, 4, 20, 137, '200986', '\"POLICONSULTORIO MED. \"\"CIES\"\" SALUD SEXUAL Y REPRODUCTIVA\"', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1868, 4, 20, 137, '200987', '\"BANCO DE SANGRE PRIVADO \"\"PROF. CARLOS ASCARRUNZ\"\"\"', 1, 4, 4, 14, 2, NULL, NULL, NULL, NULL),
(1869, 4, 21, 137, '200066', 'HOSPITAL SAN GABRIEL                                                  ', 12, 2, 3, 16, 2, NULL, NULL, NULL, NULL),
(1870, 4, 21, 137, '200067', 'PAMPAHASI (BAJO)', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1871, 4, 21, 137, '200068', 'PAMPAHASI ALTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1872, 4, 21, 137, '200069', 'SAN ANTONIO ALTO ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1873, 4, 21, 137, '200071', 'SAN ISIDRO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1874, 4, 21, 137, '200072', 'SAN ANTONIO BAJO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1875, 4, 21, 137, '200116', 'VILLA COPACABANA (PACASA)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1876, 4, 21, 137, '200578', 'VALLE HERMOSO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1877, 4, 21, 137, '200579', 'VILLA SALOME', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1878, 4, 21, 137, '200597', 'KUPINI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1879, 4, 21, 137, '200639', 'PAMPAHASI ( E )                                                ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1880, 4, 21, 137, '200730', 'VILLA ARMONIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1881, 4, 21, 137, '200794', 'CHOQUECHIHUANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(1882, 4, 21, 137, '200795', 'ESCOBAR URIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1883, 4, 21, 137, '200932', 'INOVASALUD VILLA COPACABANA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1884, 4, 22, 137, '200003', 'ALTO OBRAJES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1885, 4, 22, 137, '200014', 'OBRAJES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1886, 4, 22, 137, '200020', 'BELLA VISTA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1887, 4, 22, 137, '200021', 'ACHUMANI PROSALUD                                              ', 3, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(1888, 4, 22, 137, '200022', 'COTA COTA ( LOS PINOS)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1889, 4, 22, 137, '200025', 'CHASQUIPAMPA E. SAENZ', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1890, 4, 22, 137, '200026', 'CENTRO DE ORIENTACION FEMENINA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1891, 4, 22, 137, '200027', 'BOLOGNIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1892, 4, 22, 137, '200042', 'ACHUMANI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1893, 4, 22, 137, '200109', 'ALTO IRPAVI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1894, 4, 22, 137, '200111', 'MALLASA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1895, 4, 22, 137, '200112', 'ALTO SEGUENCOMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1896, 4, 22, 137, '200632', 'HOSPITAL VIRGEN DE COPACABANA                                         ', 12, 2, 5, 24, 2, NULL, NULL, NULL, NULL),
(1897, 4, 22, 137, '200642', 'HOSPITAL METODISTA                                                    ', 12, 2, 2, 22, 2, NULL, NULL, NULL, NULL),
(1898, 4, 22, 137, '200643', 'CLINICA DEL SUR                                                       ', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1899, 4, 22, 137, '200653', 'BAJO LLOJETA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1900, 4, 22, 137, '200668', 'MALLASILLA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1901, 4, 22, 137, '200713', 'CLINICA CORDES                                                        ', 16, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(1902, 4, 22, 137, '200751', 'HOSPITAL LOS PINOS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1903, 4, 22, 137, '200814', 'HOGAR NIÑO JESUS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1904, 4, 22, 137, '200879', 'HOSPITAL CAJA  PETROLERA DE SALUD', 11, 3, 7, 11, 2, NULL, NULL, NULL, NULL),
(1905, 4, 22, 137, '200880', 'CSBP - CLINICA LA PAZ', 12, 2, 7, 9, 2, NULL, NULL, NULL, NULL),
(1906, 4, 22, 137, '200894', 'CLINICA MÉDICA DE ATENCIÓN INTEGRAL OBRAJES S.R.L. (CMAIO S.R.L)', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1907, 4, 22, 137, '200899', 'HOSPITAL DE LA CAJA DE CAMINOS REGIONAL LA PAZ', 12, 2, 7, 8, 2, NULL, NULL, NULL, NULL),
(1908, 4, 22, 137, '200913', 'EMBRIOBIT S.R.L. (CLINICA LOS ANDES)', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1909, 4, 22, 137, '200934', 'SEPYN S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1910, 4, 22, 137, '200939', 'ROCLINIC CENTRO MEDICO FAMILIAR S.R.L.', 3, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1911, 4, 22, 137, '200942', 'HOTEL MEDICALIZADO DEL DEPORTE', 7, 5, 6, 17, 2, NULL, NULL, NULL, NULL),
(1912, 4, 22, 137, '200943', 'CENTRO NEFROLIFE S.R.L.', 2, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(1913, 4, 22, 137, '200955', 'CONSULTORIO MEDICO DE ESPECIALIDADES EN DERMATOLOGIA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1914, 4, 22, 137, '200956', 'OMNILASER S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1915, 4, 22, 137, '200957', '\"CENTRO DE PREVENCION DE LA CEGUERA \"\"DR. FERNANDEZ RALDE\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1916, 4, 22, 137, '200964', 'CONSULTORIO MEDICO ESPECIALIZADO EN ORTOPEDIA Y TRAUMATOLOGIA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1917, 4, 22, 137, '200969', 'ONCOCLINIC S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1918, 4, 25, 127, '200140', 'VILLA EXALTACION', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1919, 4, 25, 127, '200142', 'POLICLINICO  EL ALTO                                                  ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1920, 4, 25, 127, '200143', 'HOSP. BOLIVIANO HOLANDES', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1921, 4, 25, 127, '200144', '12 DE OCTUBRE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1922, 4, 25, 127, '200152', 'BUEN SAMARITANO                                                ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1923, 4, 25, 127, '200154', 'ROSAS PAMPA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1924, 4, 25, 127, '200155', 'M. MADRE DE DIOS V. D.', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1925, 4, 25, 127, '200170', 'SANTIAGO I', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1926, 4, 25, 127, '200176', 'ADOLFO KOLPING                                                 ', 5, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1927, 4, 25, 127, '200178', 'FUNDACION CEREFE                                               ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1928, 4, 25, 127, '200207', 'POL. CAJA PETROLERA EL ALTO                                           ', 16, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(1929, 4, 25, 127, '200611', 'SANTA ROSA (LPZ-EL ALTO)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1930, 4, 25, 127, '200651', 'POLICLINICO DE ESPECIALIDADES                                         ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1931, 4, 25, 127, '200688', 'CAJA CORDES (EL ALTO)                                          ', 3, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(1932, 4, 25, 127, '200729', 'ALPACOMA BAJO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1933, 4, 25, 127, '200764', 'HOSPITAL REPUBLICA ISLAMICA DE IRAN                                   ', 12, 2, 3, 23, 2, NULL, NULL, NULL, NULL),
(1934, 4, 25, 127, '200791', 'BANCO DE SANGRE EL ALTO                                               ', 1, 4, 6, 21, 2, NULL, NULL, NULL, NULL),
(1935, 4, 25, 127, '200822', 'HOSPITAL VILLA DOLORES                         ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1936, 4, 25, 127, '200851', 'CENTRAL DE EMERGENCIAS NUEVA ESPERANZA S.A. HOSPITAL AGRAMONT M.R.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(1937, 4, 25, 127, '200935', 'CENTRO MEDICO INTEGRAL APOLO', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1938, 4, 25, 127, '200936', 'COSSMIL EL ALTO', 17, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(1939, 4, 25, 127, '200938', 'CAJA DE SALUD DE CAMINOS REGIONAL EL ALTO', 17, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(1940, 4, 25, 127, '200949', 'CLINICA MEDICA SUR-TOMOCENTRO S.R.L', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1941, 4, 25, 127, '200990', 'CENTRO MEDICO DAVIDA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1942, 4, 25, 127, '200991', 'UNIDAD DE HEMODIALISIS CMICOR S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1943, 4, 26, 127, '200139', 'SAN MARTIN', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1944, 4, 26, 127, '200141', 'ASUNCION SAN PEDRO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1945, 4, 26, 127, '200145', 'COSMOS 79', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1946, 4, 26, 127, '200146', 'LUIS ESPINAL (EL ALTO)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1947, 4, 26, 127, '200147', 'VILLA AVAROA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1948, 4, 26, 127, '200150', 'CALAMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1949, 4, 26, 127, '200151', 'SANTIAGO II', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1950, 4, 26, 127, '200161', 'HOSPITAL MUNICIPAL BOLIVIANO COREANO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1951, 4, 26, 127, '200166', 'VILLA ADELA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1952, 4, 26, 127, '200169', 'SAN SEBASTIAN                                                  ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1953, 4, 26, 127, '200171', '1RO DE MAYO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1954, 4, 26, 127, '200172', 'NUEVOS HORIZONTES', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1955, 4, 26, 127, '200184', '3 DE MAYO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1956, 4, 26, 127, '200186', 'SAN JUAN KENKO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1957, 4, 26, 127, '200601', 'CLINICA JESUS OBRERO                                                  ', 5, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1958, 4, 26, 127, '200720', 'POL. VILLA ADELA                                                      ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(1959, 4, 26, 127, '200745', 'PREFECTURAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1960, 4, 26, 127, '200746', 'URBANIZACION KENKO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1961, 4, 26, 127, '200747', 'MUJER Y FAMILIA                                         ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1962, 4, 26, 127, '200783', '6 DE JUNIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1963, 4, 26, 127, '200799', 'ROMERO PAMPA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1964, 4, 26, 127, '200804', 'COPACABANA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1965, 4, 26, 127, '200833', 'SAN JOSE DE CHARAPAQUI II', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1966, 4, 26, 127, '200834', 'ALTO CHIJINI- U.V.A.', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1967, 4, 26, 127, '200835', 'CHIJINI CHICO- U.V.A.', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1968, 4, 26, 127, '200875', '\"CENTRO DE SALUD RENAL \"\"SAN JUAN BAUTISTA\"\"  UNIDAD DE HEMODIALISIS\"', 2, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1969, 4, 26, 127, '200906', 'CLINICA DIVINO SEÑOR', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1970, 4, 26, 127, '200920', 'HOSPITAL OBRERO Nº 30', 12, 2, 7, 10, 2, NULL, NULL, NULL, NULL),
(1971, 4, 26, 127, '200948', 'KIDNEYLIFE CENTER S.R.L.', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1972, 4, 26, 127, '200968', 'CENTRO MEDICO FIORI', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1973, 4, 26, 127, '200974', 'CIES EL ALTO', 3, 1, 3, 4, 2, '-16.511384', '-68.133907', 1, '2023-09-27'),
(1974, 4, 26, 127, '200977', 'CENTRO MEDICO Y PSICOLOGICO PSICO-MED-SILVANA', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1975, 4, 27, 127, '200153', 'SENKATA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1976, 4, 27, 127, '200158', 'MERCEDES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1977, 4, 27, 127, '200183', 'ATIPIRIS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1978, 4, 27, 127, '200600', 'UNIFICADA POTOSI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1979, 4, 27, 127, '200612', 'VENTILLA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1980, 4, 27, 127, '200767', 'SAN FRANCISCO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1981, 4, 27, 127, '200785', 'LOS PINOS EL ALTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1982, 4, 27, 127, '200963', 'CENTRO DE MEDICINA NUCLEAR Y RADIOTERAPIA EL ALTO', 15, 8, 6, 1, 2, NULL, NULL, NULL, NULL),
(1983, 4, 28, 127, '200149', 'HUAYNA POTOSI', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1984, 4, 28, 127, '200157', 'CEJA EL ALTO - CRA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1985, 4, 28, 127, '200159', 'GERMAN BUSCH', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1986, 4, 28, 127, '200168', 'VILLA INGENIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1987, 4, 28, 127, '200190', '16 DE JULIO PROSALUD                                           ', 5, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(1988, 4, 28, 127, '200191', 'C.S.I. BIENESTAR SERVICIOS EN SALUD                                   ', 5, 1, 3, 4, 2, NULL, NULL, NULL, NULL),
(1989, 4, 28, 127, '200194', 'SANTA MARIA DE LOS ANGELES                                     ', 5, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1990, 4, 28, 127, '200195', 'CLINICA FIDES                                                         ', 16, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1991, 4, 28, 127, '200197', 'PLAN VIVIENDA VILLA ESPERANZA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1992, 4, 28, 127, '200198', 'HOSPITAL MUNICIPAL LOS ANDES', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(1993, 4, 28, 127, '200200', 'PUERTO MEJILLONES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1994, 4, 28, 127, '200201', 'ESPIRITU SANTO                                                 ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(1995, 4, 28, 127, '200202', 'CLINICA SAN MARTIN DE PORRES                                          ', 16, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(1996, 4, 28, 127, '200203', 'ALTO LIMA IV', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1997, 4, 28, 127, '200204', 'ALTO LIMA III', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(1998, 4, 28, 127, '200670', 'CRVIR EL ALTO', 2, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(1999, 4, 28, 127, '200741', 'MARIE STOPES EL ALTO                                           ', 3, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(2000, 4, 28, 127, '200743', 'CLINICA SALVADOR                                                      ', 16, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2001, 4, 28, 127, '200744', 'CENTRO DE SALUD INTEGRAL COMUNITARIO CHACALTAYA                         ', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2002, 4, 28, 127, '200766', 'SANTA ROSA DE LIMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2003, 4, 28, 127, '200802', 'CEVICOS EL ALTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2004, 4, 28, 127, '200825', 'ALTO LIMA 2 SECCION', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2005, 4, 28, 127, '200881', 'NEFRO CENTRO', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2006, 4, 28, 127, '200978', 'ABELE', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2007, 4, 29, 127, '200138', 'SAN JOSE DE YUNGUYO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2008, 4, 29, 127, '200156', 'BRASIL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2009, 4, 29, 127, '200164', 'LOTES Y SERVICIOS', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2010, 4, 29, 127, '200165', 'SAN VICENTE DE PAUL                                            ', 3, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(2011, 4, 29, 127, '200167', 'NORUEGO                                                        ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2012, 4, 29, 127, '200182', '16 DE FEBRERO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2013, 4, 29, 127, '200189', 'VILLA TUNARI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2014, 4, 29, 127, '200205', 'SAN ROQUE (EL ALTO)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2015, 4, 29, 127, '200206', 'VILLA COOPERATIVA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2016, 4, 29, 127, '200581', 'OCOMISTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2017, 4, 29, 127, '200588', 'FRANZ TAMAYO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2018, 4, 29, 127, '200602', 'MERCEDARIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2019, 4, 29, 127, '200721', 'POLICLINICO VILLA TUNARI                                              ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(2020, 4, 29, 127, '200784', 'PUERTO CAMACHO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2021, 4, 29, 127, '200824', 'POMAMAYA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2022, 4, 29, 127, '200837', 'VILLA YUNGUYO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2023, 4, 29, 127, '200994', 'SALUD  SEGURA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2024, 4, 23, 146, '200121', 'CAYIMBAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2025, 4, 23, 146, '200122', 'COHONI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2026, 4, 23, 146, '200123', 'OVEJUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2027, 4, 23, 146, '200124', 'PALCA (LPZ)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2028, 4, 23, 146, '200125', 'QUILIHUAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2029, 4, 23, 146, '200126', 'TAHUAPALCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2030, 4, 23, 146, '200617', 'TIRATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2031, 4, 23, 146, '200669', 'CHOQUECOTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2032, 4, 23, 146, '200774', 'COTANA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2033, 4, 23, 146, '200951', 'CENTRO DE SALUD UNI', 7, 5, 6, 18, 1, NULL, NULL, NULL, NULL),
(2034, 4, 23, 143, '200128', 'COLLANA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2035, 4, 23, 143, '200129', 'HUAJCHILLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2036, 4, 23, 143, '200130', 'HUARICANA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2037, 4, 23, 143, '200131', 'MECAPACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2038, 4, 23, 143, '200132', 'PALOMAR', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2039, 4, 23, 143, '200133', 'CARACARANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2040, 4, 23, 143, '200134', 'WILACOTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2041, 4, 23, 97, '200135', 'ACHOCALLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2042, 4, 23, 97, '200136', 'LAYURI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2043, 4, 23, 97, '200137', 'TUNI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2044, 4, 23, 97, '200862', 'C.S.A. NORTE ACHOCALLA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2045, 4, 23, 97, '200886', 'C.S.A. DISTRITO 8', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2046, 4, 23, 97, '200923', '\"CENTRO DE AISLAMIENTO COVID 19 \"\"PUCARANI\"\"\"', 7, 5, 6, 18, 1, NULL, NULL, NULL, NULL),
(2047, 4, 23, 97, '200924', 'C.S. 6 DE AGOSTO - DISTRITO 9', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2048, 4, 23, 97, '200925', 'UYPACA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2049, 4, 23, 97, '200926', 'C.S.A. CHAÑOCAGUA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2050, 4, 23, 97, '200927', 'C.S.A. VERGEL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2051, 4, 33, 115, '200287', 'CHUMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2052, 4, 33, 115, '200288', 'JICHUHUAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2053, 4, 33, 115, '200289', 'SOCOCONI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2054, 4, 33, 115, '200290', 'TIMUSI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2055, 4, 33, 115, '200291', 'TITICACHI                                                    ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2056, 4, 33, 115, '200292', 'CHAJLAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2057, 4, 33, 115, '200623', 'HUALLAPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2058, 4, 33, 102, '200293', 'AYATA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2059, 4, 33, 102, '200294', 'MOLLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2060, 4, 33, 102, '200295', 'SAYHUANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2061, 4, 33, 102, '200296', 'CAMATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2062, 4, 33, 102, '200297', 'CUIBAJA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2063, 4, 33, 102, '200958', 'UPANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2064, 4, 33, 101, '200298', 'AUCAPATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2065, 4, 33, 101, '200299', 'HUANCO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2066, 4, 33, 101, '200300', 'MEMECONI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2067, 4, 33, 101, '200301', 'YANAHUAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2068, 4, 33, 101, '200604', 'PUSILLANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2069, 4, 33, 101, '200620', 'ROSARIO (LPZ)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2070, 4, 37, 124, '200514', 'CHALLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2071, 4, 37, 124, '200515', 'HOSPITAL GENERAL DE LOS YUNGAS COROICO', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(2072, 4, 37, 124, '200516', 'PACALLO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2073, 4, 37, 124, '200517', 'STA.ROSA QUILO QUILO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2074, 4, 37, 124, '200518', 'SUAPI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2075, 4, 37, 124, '200616', 'CARMEN PAMPA                                                   ', 4, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(2076, 4, 37, 124, '200931', 'YOLOSA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2077, 4, 37, 122, '200519', 'ARAPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2078, 4, 37, 122, '200520', 'CORIPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2079, 4, 37, 122, '200521', 'SANTIAGO TOCORONI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2080, 4, 37, 122, '200585', 'SAN JUAN (LPZ)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2081, 4, 37, 122, '200592', 'MILLIHUAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2082, 4, 37, 122, '200593', 'TRINIDAD PAMPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2083, 4, 30, 96, '200208', 'HOSP. ACHACACHI', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(2084, 4, 30, 96, '200209', 'AJLLATA GRANDE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2085, 4, 30, 96, '200210', 'CORPAPUTO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2086, 4, 30, 96, '200213', 'JANKO AMAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2087, 4, 30, 96, '200216', 'TACAMARA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2088, 4, 30, 96, '200217', 'TOLA TOLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2089, 4, 30, 96, '200218', 'UMACHA (FRANZ TAMAYO)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2090, 4, 30, 96, '200219', 'VILLA CARMEN LIPE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2091, 4, 30, 96, '200220', 'WALATA GRANDE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2092, 4, 30, 96, '200221', 'WARIZATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2093, 4, 30, 96, '200222', 'FRASQUIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2094, 4, 30, 96, '200676', 'CHALUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2095, 4, 30, 96, '200677', 'PUNGONHUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2096, 4, 30, 96, '200771', 'CHOJNACALA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2097, 4, 30, 96, '200779', 'CHIJIPINA CHICO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2098, 4, 30, 96, '200780', 'COCOTONI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2099, 4, 30, 96, '200781', 'ACHACACHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2100, 4, 30, 96, '200818', 'JAPURAYA BAJA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2101, 4, 30, 96, '200819', 'MURUMAMANI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2102, 4, 30, 96, '200868', 'C.S. ACHACACHI -CNS', 16, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2103, 4, 30, 98, '200224', 'ANCORAIMES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2104, 4, 30, 98, '200225', 'CAJIATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2105, 4, 30, 98, '200226', 'CHEJEPAMPA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2106, 4, 30, 98, '200227', 'INCA KATURAPI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2107, 4, 30, 98, '200228', 'POCOATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2108, 4, 30, 98, '200229', 'VILLA MACA MACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2109, 4, 30, 98, '200709', 'CHOJNAPATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2110, 4, 30, 98, '200870', 'C.S.A  MOROCOLLO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2111, 4, 30, 339, '200735', 'CHUA COCANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2112, 4, 30, 176, '200211', 'HUARINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2113, 4, 30, 176, '200223', 'COROMATA BAJA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2114, 4, 30, 176, '200840', 'COROMATA  ALTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2115, 4, 30, 176, '200864', 'C.S. WEKARANI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2116, 4, 30, 176, '200983', 'COPANCARA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2117, 4, 30, 177, '200214', 'KALAQUE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2118, 4, 30, 177, '200215', 'SANTIAGO DE HUATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2119, 4, 30, 177, '200656', 'TAJOCACHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2120, 4, 30, 340, '200212', 'HUATAJATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2121, 4, 30, 340, '200710', 'SANKA JAHUIRA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2122, 4, 31, 123, '200230', 'COROCORO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2123, 4, 31, 123, '200231', 'GENERAL PANDO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2124, 4, 31, 123, '200232', 'QUILLOMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2125, 4, 31, 123, '200233', 'CARLOS PALENQUE A. (TOHOPOCO)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2126, 4, 31, 123, '200234', 'ROSAPATA HUANCARAMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2127, 4, 31, 123, '200235', 'MURUPILAR', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2128, 4, 31, 123, '200738', 'ENEQUELLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2129, 4, 31, 123, '200806', 'JANKOMARKA SIRPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2130, 4, 31, 123, '200815', 'CAQUINGORA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2131, 4, 31, 123, '200874', 'CORO CORO CNS', 16, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2132, 4, 31, 123, '200979', 'ANCO AQUE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2133, 4, 31, 109, '200236', 'ACHIRI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2134, 4, 31, 109, '200237', 'ANTAQUIRA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2135, 4, 31, 109, '200238', 'CAQUIAVIRI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2136, 4, 31, 109, '200239', 'KASILLUNCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2137, 4, 31, 109, '200240', 'KALLA LLALLAGUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2138, 4, 31, 109, '200241', 'JIHUACUTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2139, 4, 31, 109, '200763', 'VILLA ANTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2140, 4, 31, 109, '200798', 'VICHAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2141, 4, 31, 109, '200821', 'CHOCOROSI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2142, 4, 31, 109, '200989', 'LAURA LLOKOLLOKO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2143, 4, 31, 107, '200242', 'CALACOTO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2144, 4, 31, 107, '200243', 'CONDORIQUINA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2145, 4, 31, 107, '200244', 'GRAL.CAMPERO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2146, 4, 31, 107, '200245', 'JANKO MARCA PACAJES', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2147, 4, 31, 107, '200246', 'OKORURO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2148, 4, 31, 107, '200247', 'TARQUIAMAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2149, 4, 31, 107, '200248', 'ULLOMA LERCO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2150, 4, 31, 119, '200249', 'COMANCHE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2151, 4, 31, 119, '200250', 'ROSAPATA TULI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2152, 4, 31, 119, '200251', 'CANTUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2153, 4, 31, 113, '200252', 'CHARANA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2154, 4, 31, 113, '200253', 'SEPULTURAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2155, 4, 31, 113, '200807', 'GENERAL PEREZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(2156, 4, 31, 145, '200255', 'NAZACARA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2157, 4, 39, 160, '200256', 'CALLAPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2158, 4, 39, 160, '200257', 'VILLA PUCHUNI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2159, 4, 39, 160, '200258', 'CALTECA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2160, 4, 39, 160, '200259', 'CANUTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2161, 4, 39, 160, '200702', 'YARIBAY', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2162, 4, 39, 160, '200976', 'ROMERO PAMPA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2163, 4, 40, 160, '200254', 'TUMARAPI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2164, 4, 36, 147, '200447', 'LA CASCADA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2165, 4, 36, 147, '200448', 'CHARCAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2166, 4, 36, 147, '200449', 'COVENDO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2167, 4, 36, 147, '200450', 'EL SILLAR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2168, 4, 36, 147, '200451', 'INICUA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2169, 4, 36, 147, '200452', 'LAS DELICIAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2170, 4, 36, 147, '200454', 'PALOS BLANCOS', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2171, 4, 36, 147, '200455', 'POPOY', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2172, 4, 36, 147, '200456', 'PUERTO CARMEN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2173, 4, 36, 147, '200457', 'SAN MIGUEL DE HUACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2174, 4, 36, 147, '200458', 'SAPECHO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2175, 4, 36, 147, '200459', 'TUCUPI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2176, 4, 36, 147, '200460', 'SANTA ANA DE MOSETENES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2177, 4, 36, 147, '200679', 'COCOCHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2178, 4, 36, 147, '200787', 'BAJO INICUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2179, 4, 36, 147, '200788', 'SAN JOSE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2180, 4, 36, 147, '200789', 'VILLA CONCEPCION', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2181, 4, 36, 147, '200790', 'SAN PEDRO DE COGOTAY', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2182, 4, 37, 114, '200428', 'HOSPITAL CHULUMANI', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(2183, 4, 37, 114, '200429', 'HUANCANE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2184, 4, 37, 114, '200430', 'OCOBAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2185, 4, 37, 114, '200431', 'CHIRCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2186, 4, 37, 114, '200432', 'TAJMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2187, 4, 37, 114, '200591', 'COLPAR', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2188, 4, 37, 133, '200433', 'CHICALOMA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2189, 4, 37, 133, '200434', 'IRUPANA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2190, 4, 37, 133, '200435', 'LA PLAZUELA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2191, 4, 37, 133, '200436', 'LAMBATE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2192, 4, 37, 133, '200437', 'LAZA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2193, 4, 37, 133, '200438', 'PARIGUAYA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2194, 4, 37, 133, '200439', 'TABLERIA ALTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2195, 4, 37, 133, '200440', 'TACA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2196, 4, 37, 133, '200441', 'TRES RIOS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2197, 4, 37, 133, '200442', 'VICTORIO LANZA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2198, 4, 37, 133, '200869', 'C.S.A. TOTORAL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2199, 4, 37, 133, '200876', 'C.S.A. LEJNA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2200, 4, 37, 133, '200877', 'C.S.A. HUIRI NOGALANI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2201, 4, 37, 175, '200443', 'CHACO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2202, 4, 37, 175, '200444', 'PUENTE VILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2203, 4, 37, 175, '200445', 'YANACACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2204, 4, 37, 175, '200446', 'SANTA ROSA DE CHACALA (LPZ)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2205, 4, 37, 175, '200817', 'CHOJLLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2206, 4, 37, 136, '200461', 'CHARIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2207, 4, 37, 136, '200462', 'COTAPATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2208, 4, 37, 136, '200463', 'LA ASUNTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2209, 4, 37, 136, '200464', 'LAS MERCEDES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2210, 4, 37, 136, '200465', 'STA.ROSA DE QUINUNI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2211, 4, 37, 136, '200586', 'PUERTO RICO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2212, 4, 37, 136, '200697', 'SIGUANI GRANDE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2213, 4, 37, 136, '200698', 'COLOPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2214, 4, 37, 136, '200753', 'YANAMAYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2215, 4, 37, 136, '200892', 'COPALANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2216, 4, 37, 136, '200960', 'SAN PEDRO C', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2217, 4, 37, 136, '200961', 'NUEVOS HORIZONTES', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2218, 4, 37, 136, '200982', 'LAS AMERICAS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2219, 5, 47, 203, '400104', 'CRUZ DE HUAYLLAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2220, 5, 47, 203, '400105', 'JULO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2221, 5, 47, 203, '400106', 'NEGRILLOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2222, 5, 47, 203, '400107', 'PISIGA BOLIVAR', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2223, 5, 47, 203, '400108', 'SABAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2224, 5, 47, 203, '400109', 'VILLA VITALINA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2225, 5, 47, 189, '400110', 'COIPASA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2226, 5, 47, 187, '400111', 'CHIPAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2227, 5, 47, 187, '400154', 'AYPARAVI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2228, 5, 43, 186, '400053', 'ANCACATO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2229, 5, 43, 186, '400054', 'ANTACOLLO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2230, 5, 43, 186, '400055', 'CACACHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2231, 5, 43, 186, '400056', 'HOSP. SAN JUAN DE DIOS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2232, 5, 43, 186, '400057', 'C.S. C.N.S. CHALLAPATA                                                ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2233, 5, 43, 186, '400058', 'CRUCE CULTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2234, 5, 43, 186, '400059', 'LIVICHUCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2235, 5, 43, 186, '400060', 'THOLAPALCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2236, 5, 43, 186, '400142', 'HUCHUSUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2237, 5, 43, 186, '400143', 'PARCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2238, 5, 43, 186, '400190', 'HUANCANE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2239, 5, 43, 186, '400206', 'NORTE CONDO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2240, 5, 43, 186, '400219', 'CULTA ANTIGUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2241, 5, 43, 186, '400220', 'HUANCARANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2242, 5, 43, 186, '400229', 'SUMAJ CAUSAYPAJ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2243, 5, 43, 186, '400243', '1º DE MAYO ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2244, 5, 43, 186, '400245', 'HUMAMARCA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2245, 5, 43, 207, '400061', 'SANTUARIO DE QUILLACAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2246, 5, 43, 207, '400062', 'SEVARUYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2247, 5, 43, 207, '400205', 'TORKO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2248, 5, 45, 190, '400063', 'SAN PEDRO DE HUAYLLOCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2249, 5, 45, 190, '400064', 'C.S. CON INTERNACION SAN JUAN BAUTISTA CORQUE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2250, 5, 45, 190, '400065', 'HUMAMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2251, 5, 45, 190, '400066', 'OPOQUERI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2252, 5, 45, 190, '400067', 'POMATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2253, 5, 45, 190, '400068', 'SAN ANTONIO (ORU)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2254, 5, 45, 190, '400069', 'SAN JOSE DE KALA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2255, 5, 45, 190, '400070', 'TARUCACHI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2256, 5, 45, 190, '400155', 'VILLA COPACABANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2257, 5, 45, 190, '400177', 'CATAZA ANCARAVI', 4, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2258, 5, 45, 190, '400188', 'HUAYLLAPACHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2259, 5, 45, 190, '400189', 'VILLA ESPERANZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2260, 5, 45, 190, '400248', 'ANDAPATA LUPE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2261, 5, 45, 190, '400254', 'P.S. CONDORIRI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2262, 5, 45, 188, '400071', 'CHOQUECOTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2263, 5, 45, 188, '400259', 'P.S. VIRGEN DEL ROSARIO DE ANDAPATA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2264, 5, 44, 184, '400045', 'CAÑOHUMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2265, 5, 44, 184, '400046', 'SAN ANDRES DE CARACOLLO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2266, 5, 44, 184, '400047', 'HUERTA PAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2267, 5, 44, 184, '400048', 'LA JOYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2268, 5, 44, 184, '400049', 'LAJMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2269, 5, 44, 184, '400149', 'C.S. CNS CARACOLLO                                                    ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2270, 5, 44, 184, '400179', 'VILA VILA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2271, 5, 44, 184, '400214', 'HUNTUTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2272, 5, 44, 184, '400215', 'SILLOTA BELEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2273, 5, 44, 184, '400216', 'SILLOTA VITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2274, 5, 44, 184, '400235', 'MARKA NUEVA LLALLAGUA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2275, 5, 44, 184, '400236', 'VENTILLA PONGO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2276, 5, 44, 184, '400237', 'OCOTAVI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2277, 5, 44, 184, '400246', 'QUEMALLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2278, 5, 44, 184, '400263', 'P.S. YARVICOYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2279, 5, 44, 208, '400003', 'HUAYNA PASTO GRANDE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2280, 5, 44, 208, '400005', 'LEQUEPALCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2281, 5, 44, 208, '400033', 'P.S. BANDERANI                                                        ', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2282, 5, 44, 208, '400038', 'PARIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2283, 5, 44, 208, '400040', 'THOLAPALCA ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2284, 5, 44, 208, '400157', 'SORACACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2285, 5, 44, 208, '400158', 'GUARDANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2286, 5, 44, 208, '400181', 'CRUCE OCOTAVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2287, 5, 44, 208, '400202', 'CACHI CACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2288, 5, 44, 208, '400203', 'IRUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2289, 5, 44, 208, '400204', 'SEPULTURAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2290, 5, 45, 193, '400050', 'SAN PEDRO DE CHALLACOLLO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2291, 5, 45, 193, '400051', 'EL CHORO VIRGEN DE LAS NIEVES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2292, 5, 45, 193, '400052', 'RANCHO GRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2293, 5, 45, 193, '400178', 'CRUCERO BELEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2294, 5, 45, 193, '400185', 'CHAITAVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2295, 5, 45, 193, '400209', 'SANTA MARIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2296, 5, 49, 200, '400001', 'ALTO ORURO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2297, 5, 49, 200, '400006', 'CLINICA SALVADOR                                                      ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2298, 5, 49, 200, '400007', 'ASISTENCIA PUBLICA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2299, 5, 49, 200, '400008', 'CHIRIPUJIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2300, 5, 49, 200, '400009', 'HOSP. WALTER KHON', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2301, 5, 49, 200, '400010', 'RAFAEL PABON', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2302, 5, 49, 200, '400011', 'SANTA LUCIA (ORU)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2303, 5, 49, 200, '400012', 'NSTA.SRA. DE CANDELARIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2304, 5, 49, 200, '400013', 'YUGOESLAVO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2305, 5, 49, 200, '400014', 'HOSP. BARRIOS MINEROS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2306, 5, 49, 200, '400015', 'CENTRO DE SALUD INTEGRAL VINTO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2307, 5, 49, 200, '400016', 'HOSP. OBRERO N° 4                                                     ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(2308, 5, 49, 200, '400017', 'HOSP. GINECO OBSTETRICO (ORU)                                         ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(2309, 5, 49, 200, '400018', 'HOSPITAL CAJA DE SALUD DE CAMINOS Y R. A. ORURO                         ', 12, 2, 7, 8, 2, NULL, NULL, NULL, NULL),
(2310, 5, 49, 200, '400020', 'C.S. VILLA CHALLACOLLO                                                ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(2311, 5, 49, 200, '400021', 'CENTRO DE SALUD EPIDEMIOLOGICO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2312, 5, 49, 200, '400022', 'C.S. CNS POLICONSULTORIO 10 DE FEBRERO                                ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(2313, 5, 49, 200, '400023', 'C.S. DISP.  GUADALUPE                                                 ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(2314, 5, 49, 200, '400025', 'C.S. CAJA PETROLERA - ORURO                                           ', 5, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(2315, 5, 49, 200, '400027', 'C.S. COSSMIL (ORU)                                                    ', 8, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(2316, 5, 49, 200, '400028', 'CLINICA C.I.E.S. ORURO                                                ', 5, 1, 3, 4, 2, NULL, NULL, NULL, NULL),
(2317, 5, 49, 200, '400029', 'C.S. DISP. SANTA JOAQUINA                                             ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(2318, 5, 49, 200, '400030', 'C.S. DISP.  JUAN PABLO II                                             ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(2319, 5, 49, 200, '400032', 'C.S. DISP. SANTA RAFAELA MARIA                                          ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(2320, 5, 49, 200, '400035', 'HOSP. GENERAL S.J.D.D.                                                ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(2321, 5, 49, 200, '400036', 'C.S. C.N.S. VINTO E.N.A.F.                                            ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(2322, 5, 49, 200, '400039', 'POLICLINICO ORURO                                                     ', 16, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2323, 5, 49, 200, '400041', 'CLINICA CRISTO REY                                                    ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2324, 5, 49, 200, '400042', 'POLICLINICO UNIVERSITARIO UTO                                         ', 12, 2, 7, 33, 2, NULL, NULL, NULL, NULL),
(2325, 5, 49, 200, '400044', 'C.S. PROSALUD (ORU)                                                   ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(2326, 5, 49, 200, '400166', 'C.S. DISP. NAZARIA IGNACIA                                            ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(2327, 5, 49, 200, '400168', 'AURORA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2328, 5, 49, 200, '400169', 'C.S. ONDI                                                             ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(2329, 5, 49, 200, '400171', 'CAJA DE SALUD DE LA BANCA PRIVADA   (ORURO)                      ', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(2330, 5, 49, 200, '400173', 'MARIA AUXILIADORA (HUAJARA)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2331, 5, 49, 200, '400195', 'CLINICA URME                                                          ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2332, 5, 49, 200, '400196', 'C.S. RENACER                                                          ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2333, 5, 49, 200, '400198', 'PLAN 500', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2334, 5, 49, 200, '400222', 'CLINICA  NATIVIDAD                                                    ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2335, 5, 49, 200, '400224', 'RUMY CAMPANA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2336, 5, 49, 200, '400226', 'PUMAS ANDINOS', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2337, 5, 49, 200, '400227', 'VERDE UNO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2338, 5, 49, 200, '400228', 'SANTA ROSA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2339, 5, 49, 200, '400230', 'AMBULATORIO SOCAMANI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2340, 5, 49, 200, '400232', 'CENTRO DE SALUD  VICHULOMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2341, 5, 49, 200, '400233', 'CDVIR ORURO', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2342, 5, 49, 200, '400234', 'CENTRO MEDICO VIRGEN DEL CARMEN', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2343, 5, 49, 200, '400238', 'BANCO DE SANGRE ORURO', 1, 4, 6, 18, 2, NULL, NULL, NULL, NULL),
(2344, 5, 49, 200, '400239', '7 DE MARZO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2345, 5, 49, 200, '400241', '\"POLICONSULTORIO \"\"SAN JUAN DE DIOS\"\"\"', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2346, 5, 49, 200, '400242', 'CLINICA MEDICOS SAN AGUSTIN S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2347, 5, 49, 200, '400244', '\'PAPA JUAN PABLO II \'\'', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2348, 5, 49, 200, '400250', 'CENTRO DE AISLAMIENTO MUNICIPAL COVID 19', 7, 5, 6, 17, 1, NULL, NULL, NULL, NULL),
(2349, 5, 49, 200, '400251', '\"CENTRO DE AISLAMIENTO DE INTELIGENCIA EPIDEMIOLOGICA Y SANITARIA  \"\"COVID\"', 7, 5, 6, 17, 1, NULL, NULL, NULL, NULL),
(2350, 5, 49, 200, '400253', '\"CENTRO DE SALUD \"\"LOS ANGELES\"\"\"', 3, 1, 6, 17, 2, NULL, NULL, NULL, NULL),
(2351, 5, 49, 200, '400255', 'CAJA BANCARIA ESTATAL DE SALUD - ORURO', 5, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(2352, 5, 49, 200, '400256', 'INOVA SALUD S.A. SAN MIGUEL', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2353, 5, 49, 200, '400257', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD - ORURO', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(2354, 5, 49, 200, '400258', 'CLINICA MATERNO INFANTIL YOLANDA  MARIA', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2355, 5, 49, 200, '400260', 'CLIBETAB S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2356, 5, 49, 200, '400261', 'CLINICA SAJAMA', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2357, 5, 49, 200, '400262', 'CLINICA SANTIAGO', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(2358, 5, 43, 204, '400098', 'LUCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2359, 5, 43, 204, '400099', 'PUQUI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2360, 5, 43, 204, '400100', 'SALINAS DE G. MENDOZA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2361, 5, 43, 204, '400101', 'SAN MARTIN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2362, 5, 43, 204, '400102', 'UCUMASI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2363, 5, 43, 204, '400144', 'AROMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2364, 5, 43, 204, '400145', 'CHALLACOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2365, 5, 43, 204, '400240', 'P.S. VIRGEN DE CONCEPCION DE VILLA ESPERANZA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2366, 5, 43, 201, '400103', 'PAMPA AULLAGAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2367, 5, 43, 201, '400192', 'BENGAL VINTO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2368, 5, 43, 201, '400193', 'ICHALULA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2369, 5, 47, 197, '400081', 'HUACHACALLA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2370, 5, 47, 194, '400082', 'ESCARA (ORU)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2371, 5, 47, 191, '400212', 'CRUZ DE MACHACAMARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2372, 5, 47, 215, '400211', 'YUNGUYO DE LITORAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2373, 5, 47, 195, '400182', 'BELEN DE ESMERALDA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2374, 5, 47, 195, '400249', 'ROMERO PAMPA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2375, 5, 47, 198, '400136', 'LA RIVERA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2376, 5, 47, 209, '400137', 'TODOS SANTOS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2377, 5, 47, 185, '400138', 'CARANGAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2378, 5, 44, 206, '400139', 'CHUQUICHAMBI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2379, 5, 44, 206, '400140', 'HUAYLLAMARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2380, 5, 44, 206, '400141', 'LLANQUERA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2381, 5, 44, 206, '400151', 'SAN MIGUEL (ORU)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2382, 5, 44, 206, '400207', 'CHOJNOHUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2383, 5, 44, 206, '400208', 'BELEN DE CHOQUECOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2384, 5, 44, 206, '400217', 'BELLA VISTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2385, 5, 44, 206, '400218', 'PUERTO NEQUETA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2386, 5, 46, 213, '400092', 'HOSP. SAN MARTIN DE PORRES HUANUNI', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(2387, 5, 46, 213, '400093', 'C.S. C.N.S.  SANTA ELENA                                              ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2388, 5, 46, 213, '400094', 'MOROCOCALA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2389, 5, 46, 213, '400095', 'TAYAQUIRA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2390, 5, 46, 213, '400156', 'HUALLATIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2391, 5, 46, 213, '400160', 'CATARICAGUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2392, 5, 46, 213, '400161', 'BARTOLINA SISA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2393, 5, 46, 213, '400162', 'HUAYRAPATA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2394, 5, 46, 213, '400163', 'JAPO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2395, 5, 46, 213, '400247', 'P.S. VILUYO ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2396, 5, 46, 213, '400252', '\"CENTRO DE AISLAMIENTO COVID 19 \"\"27 DE JULIO-HUANUNI\"\"\"', 7, 5, 6, 17, 1, NULL, NULL, NULL, NULL),
(2397, 5, 46, 199, '400096', 'MACHACAMARCA HNA. MONICA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2398, 5, 46, 199, '400097', 'C.S. C.N.S. MACHACAMARCA                                              ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2399, 5, 46, 199, '400199', 'ACO ACO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2400, 5, 43, 202, '400086', 'PAZÑA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2401, 5, 43, 202, '400087', 'C.S. C.N.S. PAZÑA                                                     ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2402, 5, 43, 202, '400088', 'PEÑAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2403, 5, 43, 202, '400089', 'TOTORAL', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2404, 5, 43, 202, '400090', 'URMIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2405, 5, 43, 202, '400223', 'AVICAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2406, 5, 46, 214, '400083', 'POOPO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2407, 5, 46, 214, '400084', 'C.S. C.N.S. POOPO                                                     ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2408, 5, 46, 214, '400085', 'VENTA Y MEDIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2409, 5, 46, 214, '400174', 'SAN JOSE TOLAPAMPA (ORU)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2410, 5, 46, 214, '400183', 'CALLIPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2411, 5, 46, 182, '400091', 'ANTEQUERA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2412, 5, 46, 182, '400152', 'CHALLHUAMAYU', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2413, 5, 46, 182, '400153', 'TUTUNI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2414, 5, 44, 192, '400072', 'CURAHUARA DE CARANGAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2415, 5, 44, 192, '400073', 'LAGUNAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2416, 5, 44, 192, '400074', 'SAJAMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2417, 5, 44, 192, '400150', 'CULTA II', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2418, 5, 45, 212, '400075', 'CHACHACOMANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2419, 5, 45, 212, '400076', 'COSAPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2420, 5, 45, 212, '400077', 'LACA LACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2421, 5, 45, 212, '400078', 'TITIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2422, 5, 45, 212, '400079', 'TURCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2423, 5, 45, 212, '400080', 'TAMBO QUEMADO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2424, 5, 44, 211, '400123', 'CRUCERO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2425, 5, 44, 211, '400124', 'CULTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2426, 5, 44, 211, '400125', 'ROSA SANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2427, 5, 44, 211, '400126', 'SAN PEDRO DE TOTORA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2428, 5, 44, 211, '400127', 'SORA SORA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2429, 5, 44, 211, '400128', 'VINOHUTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2430, 5, 44, 211, '400180', 'CALAZAYA', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2431, 5, 44, 211, '400184', 'HUACANAPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2432, 5, 44, 211, '400225', 'VILLA IRPOCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2433, 5, 44, 211, '400264', 'P.S.PUERTO ESCOMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2434, 5, 45, 210, '400112', 'CHALLAVITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2435, 5, 45, 210, '400113', 'C.S. CHUQUIÑA                                                         ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(2436, 5, 45, 210, '400114', 'CULLURI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2437, 5, 45, 210, '400115', 'TOLEDO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2438, 5, 45, 210, '400116', 'UNTAVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2439, 5, 45, 210, '400164', 'CARI CARI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2440, 5, 45, 210, '400165', 'CHALLA CRUZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2441, 5, 45, 210, '400201', 'TOMA TOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2442, 5, 43, 205, '400129', 'CASTILLO HUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2443, 5, 43, 205, '400130', 'HUARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2444, 5, 43, 205, '400131', 'C.S. C.N.S. HUARI                                                     ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2445, 5, 43, 205, '400132', 'SAN PEDRO DE CONDO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2446, 5, 43, 205, '400133', 'URMIRI DE QUILLACAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2447, 5, 43, 205, '400134', 'VICHAJ LUPE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2448, 5, 43, 205, '400135', 'MARKA LAGUNILLAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2449, 5, 43, 205, '400231', 'GUADALUPE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2450, 5, 45, 183, '400118', 'SANTIAGO DE ANDAMARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2451, 5, 45, 183, '400119', 'AVAROA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2452, 5, 45, 183, '400120', 'ORINOCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2453, 5, 45, 183, '400175', 'ROSAPATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2454, 5, 45, 183, '400186', 'LLOCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2455, 5, 45, 183, '400187', 'CALAVILLCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2456, 5, 45, 183, '400200', 'ROSARIO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2457, 5, 45, 183, '400121', 'BELEN DE ANDAMARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2458, 5, 45, 183, '400122', 'CALAMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2459, 5, 45, 183, '400176', 'CRUZ DE HUAYLLAMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2460, 5, 45, 183, '400213', 'REAL MACHACAMARCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2461, 5, 44, 196, '400117', 'EUCALIPTUS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2462, 5, 44, 196, '400146', 'AMACHUMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2463, 5, 44, 196, '400147', 'QUELCATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2464, 6, 92, 228, '900047', 'SANTA ROSA - PANDO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2465, 6, 92, 228, '900048', '1RO. DE MAYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2466, 6, 92, 228, '900094', 'PUERTO MORALES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2467, 6, 92, 222, '900049', 'HUMAITA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2468, 6, 92, 222, '900075', 'INGAVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2469, 6, 93, 223, '900050', 'NUEVA ESPERANZA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2470, 6, 93, 223, '900059', 'ARCA DE ISRAEL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2471, 6, 93, 223, '900080', 'PUERTO CONSUELO II', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2472, 6, 93, 223, '900097', 'P.S. TRES HERMANOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2473, 6, 93, 230, '900051', 'LOMA ALTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2474, 6, 93, 230, '900061', 'SANTA CRUSITO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2475, 6, 93, 230, '900066', 'SANTA FE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2476, 6, 93, 230, '900076', 'PERSEVERANCIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2477, 6, 93, 230, '900087', 'ENAREWENA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2478, 6, 93, 229, '900053', 'RESERVA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2479, 6, 93, 229, '900085', 'SAN MARTIN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2480, 6, 92, 341, '900041', 'BLANCA FLOR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2481, 6, 92, 341, '900042', 'TRINIDASITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2482, 6, 92, 341, '900043', 'GALILEA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2483, 6, 92, 341, '900089', 'NARANJAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2484, 6, 92, 341, '900095', 'VISTA  ALEGRE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2485, 6, 92, 220, '900045', 'EL SENA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2486, 6, 92, 220, '900056', 'PALMA REAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2487, 6, 92, 220, '900101', 'GIRADO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2488, 6, 93, 225, '900035', 'MIRAFLORES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2489, 6, 93, 225, '900036', 'GONZALO MORENO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2490, 6, 93, 225, '900037', 'LAS PIEDRAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2491, 6, 93, 225, '900038', 'FRONTERA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2492, 6, 93, 225, '900039', 'PORTACHUELO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2493, 6, 93, 225, '900067', 'CONTRAVARICIA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2494, 6, 93, 225, '900084', 'BUEN FUTURO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2495, 6, 93, 225, '900088', 'AGUA DULCE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2496, 6, 91, 221, '900031', 'FILADELFIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2497, 6, 91, 221, '900032', 'EMPRESINHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2498, 6, 91, 221, '900033', 'BUYUYO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2499, 6, 91, 221, '900034', 'CHIVE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2500, 6, 91, 221, '900057', 'LUZ DE AMERICA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2501, 6, 91, 221, '900078', 'SOBERANIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2502, 6, 92, 226, '900028', 'HOSPITAL INTEGRAL COMUNITARIO PUERTO RICO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2503, 6, 92, 226, '900058', 'CONQUISTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2504, 6, 92, 226, '900090', 'BATRAJA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2505, 6, 93, 227, '900030', 'LOMA VELARDE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2506, 6, 93, 227, '900065', 'VALPARAISO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2507, 6, 93, 227, '900071', 'TRES ESTRELLAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2508, 6, 93, 227, '900086', 'FORTALEZA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2509, 6, 91, 219, '900001', 'ALTO BAHIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2510, 6, 91, 219, '900002', '27 DE MAYO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2511, 6, 91, 219, '900003', 'SANTA CLARA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2512, 6, 91, 219, '900004', 'HOS. INTEGRAL DE ESP. EN SALUD (H.I.E.S. OBRERO PANDO)', 12, 2, 7, 10, 2, NULL, NULL, NULL, NULL),
(2513, 6, 91, 219, '900005', 'HOSPITAL BOLIVIANO JAPONES DR. ROBERTO GALINDO TERAN', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2514, 6, 91, 219, '900006', 'COBIJA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2515, 6, 91, 219, '900007', 'C.S. CLÍNICA BURGOS                                                   ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2516, 6, 91, 219, '900008', 'VILLA BUSCH', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2517, 6, 91, 219, '900009', 'NUEVA ESPERANZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2518, 6, 91, 219, '900011', 'NUEVO TRIUNFO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2519, 6, 91, 219, '900012', 'C.S. CAJA CORDES COBIJA                                               ', 8, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(2520, 6, 91, 219, '900013', 'C.S. CAJA DE CAMINOS                                                  ', 8, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(2521, 6, 91, 219, '900014', 'POLICLINICO COSSMIL COBIJA                                            ', 8, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(2522, 6, 91, 219, '900015', 'MAPAJO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2523, 6, 91, 219, '900068', 'PETROLERO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2524, 6, 91, 219, '900072', 'CD-VIR / PANDO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2525, 6, 91, 219, '900073', 'C.S. SEGURO UNIVERSITARIO (S.I.S.U.)                                  ', 8, 1, 3, 34, 2, NULL, NULL, NULL, NULL),
(2526, 6, 91, 219, '900074', 'C.S. CAJA PETROLERA                                                   ', 8, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(2527, 6, 91, 219, '900077', 'C.S. CLINICA POLICIAL VIRGEN DE COPACABANA                            ', 8, 1, 5, 24, 2, NULL, NULL, NULL, NULL),
(2528, 6, 91, 219, '900093', 'BANCO DE SANGRE DE REFERENCIA DEPARTAMENTAL                      ', 1, 4, 6, 21, 2, NULL, NULL, NULL, NULL),
(2529, 6, 91, 219, '900096', 'POLICONSULTORIO. CIMFA', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(2530, 6, 91, 219, '900099', 'CLINICA UNEDI S.R.L.', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2531, 6, 91, 219, '900100', 'CLINICA INTEGRAMEDICA', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2532, 6, 91, 219, '900102', 'CENTRO DE AISLAMIENTO COVID-19 PERLA DEL ACRE', 7, 5, 6, 17, 2, NULL, NULL, NULL, NULL),
(2533, 6, 91, 219, '900103', 'HOSPITAL COVID-19 DR. HERNAN MESSUTI RIVERA', 4, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(2534, 6, 91, 219, '900104', 'BIOLOGIA MOLECULAR SEDES PANDO', 13, 7, 6, 17, 2, NULL, NULL, NULL, NULL),
(2535, 6, 91, 219, '900111', '\"CLINICA MATERNO INFANTIL \"\"CLIMAIN S.R.L.\"\"\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(2536, 6, 91, 219, '900112', 'CSBP - POLICONSULTORIO COBIJA', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(2537, 6, 91, 219, '900113', 'CAJA BANCARIA ESTATAL DE SALUD - COBIJA', 3, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(2538, 6, 91, 219, '900114', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD - PANDO', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(2539, 6, 91, 219, '900115', 'POLICONSULTORIO MARCELO PEREZ MARPER', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2540, 6, 91, 224, '900016', 'VILLA ROJAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2541, 6, 91, 224, '900017', 'SAN MARTIN DE PORRES', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2542, 6, 91, 224, '900063', 'SAN JOSE', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2543, 6, 91, 218, '900018', 'BOLPEBRA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2544, 6, 91, 218, '900019', 'MUKDEN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2545, 6, 91, 218, '900020', 'YAMINAGUAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2546, 6, 91, 218, '900021', 'NAREUDA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2547, 6, 91, 216, '900022', 'SANTA RITA (KM 70)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2548, 6, 91, 216, '900023', 'CON CAMAS SANTA LUCIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2549, 6, 91, 216, '900025', 'BELLA FLOR (V. AMAZONICA)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2550, 6, 91, 216, '900062', 'SANTA LOURDES', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2551, 6, 91, 216, '900079', 'EL CARMEN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2552, 6, 91, 216, '900092', 'PUERTO EVO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2553, 6, 91, 216, '900098', 'P.S.  MAPAJO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2554, 7, 56, 252, '500231', 'COLLOMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2555, 7, 56, 252, '500232', 'JANKARACHI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2556, 7, 56, 252, '500233', 'LAYUPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2557, 7, 56, 252, '500234', 'MALLCUCHAPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2558, 7, 56, 252, '500235', 'SACACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2559, 7, 56, 252, '500236', 'SAKANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2560, 7, 56, 252, '500237', 'SILLU SILLU', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2561, 7, 56, 252, '500238', 'TARWUACHAPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2562, 7, 56, 252, '500460', 'HUARAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2563, 7, 56, 252, '500461', 'PICHUYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2564, 7, 56, 252, '500498', 'MALLKUQOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2565, 7, 56, 252, '500499', 'VIRTOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2566, 7, 56, 252, '500509', 'JAYU JAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2567, 7, 56, 252, '500510', 'ITURATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2568, 7, 56, 252, '500587', 'VILA VILA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2569, 7, 56, 237, '500239', 'CORAZON DE MARIA DE CARIPUYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2570, 7, 56, 237, '500240', 'CHOJLLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2571, 7, 56, 237, '500241', 'HUAÑACHACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2572, 7, 56, 237, '500242', 'HUANACOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2573, 7, 56, 237, '500243', 'JANKOJANKO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2574, 7, 56, 237, '500462', 'LACAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2575, 7, 56, 237, '500505', 'JUNTAVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2576, 7, 53, 261, '500378', 'TOLAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2577, 7, 53, 261, '500379', 'CALAZAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2578, 7, 53, 261, '500380', 'CARLOS MACHICADO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2579, 7, 53, 261, '500382', 'TACORA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2580, 7, 53, 261, '500384', 'TICA TICA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2581, 7, 53, 261, '500385', 'VIRGEN DE CONCEPCIÓN TOMAVE                                      ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2582, 7, 53, 261, '500388', 'TARANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2583, 7, 53, 261, '500474', '\"TOTORA \"\"K\"\"\"', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2584, 7, 53, 261, '500543', 'OPOCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2585, 7, 53, 261, '500591', 'JACHIOCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2586, 7, 53, 261, '500592', 'VILUYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2587, 7, 53, 248, '500389', 'CARMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2588, 7, 53, 248, '500390', 'CHAQUILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2589, 7, 53, 248, '500391', 'PORCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2590, 7, 53, 248, '500563', 'AGUA DE CASTILLA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2591, 7, 53, 342, '500381', 'PAJCHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2592, 7, 53, 342, '500383', 'TAURO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2593, 7, 53, 342, '500386', 'VIRGEN DE LA ENCARNACION YURA                                           ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2594, 7, 53, 342, '500475', 'KORKA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2595, 7, 53, 342, '500526', 'PELCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2596, 7, 53, 342, '500554', 'TATUCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2597, 7, 59, 265, '500368', 'ALPACANI                                                 ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2598, 7, 59, 265, '500369', 'CANDELARIA DE VILUYO                                             ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2599, 7, 59, 265, '500370', 'CERDAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2600, 7, 59, 265, '500371', 'COLCHANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2601, 7, 59, 265, '500372', 'COROMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2602, 7, 59, 265, '500373', 'RIO MULATO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2603, 7, 59, 265, '500374', 'HOSP. J. EDUARDO PEREZ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2604, 7, 59, 265, '500375', 'POLICLINICO UYUNI C.N.S.                                         ', 16, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2605, 7, 59, 265, '500376', 'HOSP. OBRERO C.N.S.                                                   ', 12, 2, 7, 10, 1, NULL, NULL, NULL, NULL),
(2606, 7, 59, 265, '500377', 'PULACAYO C.N.S.                                                  ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2607, 7, 59, 265, '500458', 'PULACAYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2608, 7, 59, 265, '500465', 'TUSQUI                                                           ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2609, 7, 59, 265, '500489', 'BELLA VISTA - UYUNI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2610, 7, 59, 265, '500544', 'SAN JUAN DE DIOS UYUNI', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2611, 7, 59, 265, '500545', 'ZONA CENTRAL                                                     ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2612, 7, 59, 265, '500546', 'QUIJARRO                                                         ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2613, 7, 59, 265, '500547', 'SEÑOR DE  MAYO                                                   ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2614, 7, 59, 265, '500566', 'ASUNCION VILLA ESPERANZA', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2615, 7, 59, 265, '500573', 'KELUYO ALTO ALIANZA                                              ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2616, 7, 59, 265, '500584', 'QUEHUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2617, 7, 59, 265, '500585', 'CHACALA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2618, 7, 59, 265, '500609', 'COSSMIL - UYUNI', 3, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(2619, 7, 59, 265, '500625', 'CLINICA S.P. SUMAJ RIJCHARIY S.R.L.', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2620, 7, 56, 256, '500169', 'CHIRO KASA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2621, 7, 56, 256, '500170', 'COCHUBAMDURIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2622, 7, 56, 256, '500171', 'ESQUENCACHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2623, 7, 56, 256, '500172', 'MICANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2624, 7, 56, 256, '500173', 'MOSCARI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2625, 7, 56, 256, '500174', 'PAIRUMANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2626, 7, 56, 256, '500175', 'QUINAMARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2627, 7, 56, 256, '500176', 'SAN MARCOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2628, 7, 56, 256, '500177', 'SAN PEDRO DE B.V.', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2629, 7, 56, 256, '500178', 'SURAGUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2630, 7, 56, 256, '500179', 'TORACARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2631, 7, 56, 256, '500500', 'CHIQUIPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2632, 7, 56, 256, '500501', 'MARTIN KALA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2633, 7, 56, 256, '500502', 'IRPI IRPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2634, 7, 56, 256, '500562', 'CHIRIMIRA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2635, 7, 56, 256, '500576', 'ATACARI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2636, 7, 56, 256, '500599', 'ÑEQUETA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2637, 7, 56, 256, '500600', 'ZAPACARI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2638, 7, 56, 256, '500601', 'POETERA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2639, 7, 56, 256, '500602', 'SILLARAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2640, 7, 56, 262, '500180', 'AÑAHUANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2641, 7, 56, 262, '500181', 'CARASI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2642, 7, 56, 262, '500182', 'JULO GRANDE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2643, 7, 56, 262, '500183', 'PALLA PALLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2644, 7, 56, 262, '500184', 'TAMBO KASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2645, 7, 56, 262, '500185', 'TORO TORO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2646, 7, 56, 262, '500186', 'YAMBATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2647, 7, 56, 262, '500463', 'POCOSUCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2648, 7, 56, 262, '500571', 'SUCUSUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2649, 7, 56, 262, '500630', 'PUESTO DE SALUD ARAFANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2650, 7, 52, 241, '500122', 'CHAYRAPATA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2651, 7, 52, 241, '500123', 'CHUAFAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2652, 7, 52, 241, '500124', 'SAN JUAN DE DIOS DE COLQUECHACA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2653, 7, 52, 241, '500126', 'COLQUECHACA (C.N.S.)                                             ', 16, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2654, 7, 52, 241, '500127', 'TURCO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2655, 7, 52, 241, '500129', 'IRUCOYANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2656, 7, 52, 241, '500487', 'ROSARIO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2657, 7, 52, 241, '500511', 'SURUMI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2658, 7, 52, 241, '500512', 'CHULLPA CKASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2659, 7, 52, 241, '500528', 'JAMACHIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2660, 7, 52, 251, '500135', 'ANTORA', 4, 1, 6, 15, 1, NULL, NULL, NULL, NULL),
(2661, 7, 52, 251, '500136', 'HUAYCOMA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2662, 7, 52, 251, '500137', 'JANINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2663, 7, 52, 251, '500138', 'KUTURI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2664, 7, 52, 251, '500139', 'LACAYANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2665, 7, 52, 251, '500140', 'PITANTORA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2666, 7, 52, 251, '500141', 'SAN MIGUEL DE RAVELO', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2667, 7, 52, 251, '500142', 'RODEO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2668, 7, 52, 251, '500143', 'TOMOYO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2669, 7, 52, 251, '500144', 'YURUBAMBA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2670, 7, 52, 251, '500438', 'YUCURI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2671, 7, 52, 251, '500513', 'MOROTO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2672, 7, 52, 251, '500514', 'TOROCA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2673, 7, 52, 251, '500515', 'SASANTA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2674, 7, 52, 251, '500588', 'SOROJCHI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2675, 7, 52, 251, '500596', 'CUIRI TEJA MOLINO', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2676, 7, 52, 247, '500145', 'VILLA ALCARAPI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2677, 7, 52, 247, '500146', 'COLLANA TUICA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2678, 7, 52, 247, '500147', 'CAMPAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2679, 7, 52, 247, '500148', 'HUANCARANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2680, 7, 52, 247, '500149', 'PACOTANCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2681, 7, 52, 247, '500150', 'SANTA BARBARA DE POCOATA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2682, 7, 52, 247, '500151', 'QUESIMPUCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2683, 7, 52, 247, '500152', 'SAN MIGUEL DE KHARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2684, 7, 52, 247, '500153', 'SARIJCHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2685, 7, 52, 247, '500154', 'TOLAPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2686, 7, 52, 247, '500155', 'TOTORA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2687, 7, 52, 247, '500157', 'YACUACO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2688, 7, 52, 247, '500158', 'COLLPAKASA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2689, 7, 52, 247, '500437', 'SANTA MARIA TURBERIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2690, 7, 52, 247, '500567', 'PISAKA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2691, 7, 52, 247, '500568', 'SUKI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2692, 7, 52, 247, '500569', 'VIRGEN DEL CARMEN TOMOYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2693, 7, 52, 247, '500613', 'SORA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2694, 7, 52, 247, '500614', 'ACHUMANI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2695, 7, 52, 246, '500159', 'CKARA CKARA (OCURI)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2696, 7, 52, 246, '500160', 'LUYUPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2697, 7, 52, 246, '500161', 'MARAGUA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2698, 7, 52, 246, '500162', 'MARCOMA', 4, 1, 6, 15, 1, NULL, NULL, NULL, NULL),
(2699, 7, 52, 246, '500163', 'MILLUNI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2700, 7, 52, 246, '500164', 'SAN SALVADOR DE OCURI                                                   ', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2701, 7, 52, 246, '500165', 'MURIFAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(2702, 7, 52, 246, '500166', 'PUCALOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2703, 7, 52, 246, '500167', 'YURIMATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2704, 7, 52, 246, '500168', 'JUTHY', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2705, 7, 52, 246, '500506', 'CKARI MAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2706, 7, 52, 246, '500516', 'ROCO ROCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2707, 7, 52, 246, '500551', 'TAWA RREJA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2708, 7, 52, 343, '500119', 'AYOMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2709, 7, 52, 343, '500120', 'BOMBORI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2710, 7, 52, 343, '500121', 'CASTILLA HUMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2711, 7, 52, 343, '500128', 'FUTINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2712, 7, 52, 343, '500130', 'MACHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2713, 7, 52, 343, '500131', 'PAMPA COLORADA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2714, 7, 52, 343, '500132', 'SALINAS ALTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2715, 7, 52, 343, '500133', 'TOMAYCURI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2716, 7, 52, 343, '500134', 'ULUCHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2717, 7, 52, 343, '500486', 'TITIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2718, 7, 52, 343, '500488', 'CHALVIRI-COLQUECHACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2719, 7, 52, 343, '500529', 'SALINAS BAJA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2720, 7, 52, 343, '500548', 'CHOQUECAYARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2721, 7, 52, 343, '500549', 'PALCOYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2722, 7, 52, 343, '500550', 'CANTA CANTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2723, 7, 52, 343, '500574', 'YOCONA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2724, 7, 50, 235, '500084', 'ANCOMAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2725, 7, 50, 235, '500085', 'AVAROA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2726, 7, 50, 235, '500086', 'CENTRO DE SALUD INTEGRAL ROBERTO LOAYZA BETANZOS', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2727, 7, 50, 235, '500087', 'BETANZOS C.N.S.                                                  ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2728, 7, 50, 235, '500088', 'BUEY TAMBO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2729, 7, 50, 235, '500089', 'CHAJPI GRANDE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2730, 7, 50, 235, '500090', 'KOA KOA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2731, 7, 50, 235, '500091', 'LAGUNILLAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2732, 7, 50, 235, '500092', 'MAMAHOTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2733, 7, 50, 235, '500093', 'MARIACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2734, 7, 50, 235, '500094', 'MILLARES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2735, 7, 50, 235, '500095', 'OTUYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2736, 7, 50, 235, '500096', 'POCO POCO                                                        ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2737, 7, 50, 235, '500097', 'SAN BLAS DE PUITA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2738, 7, 50, 235, '500098', 'QUIVI QUIVI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2739, 7, 50, 235, '500099', 'QUIVINCHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2740, 7, 50, 235, '500100', 'SIPORO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2741, 7, 50, 235, '500101', 'TIRISPAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2742, 7, 50, 235, '500102', 'TIRQUIBUCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2743, 7, 50, 235, '500103', 'VILA VILA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2744, 7, 50, 235, '500104', 'VILLA CARMEN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2745, 7, 50, 235, '500105', 'URIFAYA                                                          ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2746, 7, 50, 235, '500434', 'TRAPICHE BAJO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2747, 7, 50, 235, '500435', 'HUANU HUANU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2748, 7, 50, 235, '500447', 'VIÑA QUEMADA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2749, 7, 50, 235, '500456', 'LA FLORIDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2750, 7, 50, 235, '500490', 'POTOBAMBA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2751, 7, 50, 235, '500491', 'VILLA NUEVA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2752, 7, 50, 235, '500519', 'SAN PEDRO DE COLILA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2753, 7, 50, 235, '500575', 'TROJAPAMPA                                                       ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2754, 7, 50, 238, '500106', 'CHAQUI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2755, 7, 50, 238, '500107', 'BAÑOS CHAQUI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2756, 7, 50, 238, '500108', 'CHICO CHICO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2757, 7, 50, 238, '500109', 'COIPASI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2758, 7, 50, 238, '500110', 'EL PALOMAR', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2759, 7, 50, 238, '500111', 'DON DIEGO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2760, 7, 50, 238, '500436', 'CHIUTALUYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2761, 7, 50, 238, '500518', 'SILAPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2762, 7, 53, 258, '500112', 'CERCA CANCHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2763, 7, 53, 258, '500113', 'CHALLVIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2764, 7, 53, 258, '500114', 'MIGMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2765, 7, 53, 258, '500115', 'RODEO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2766, 7, 53, 258, '500116', 'COLAVI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2767, 7, 53, 258, '500117', 'TACOBAMBA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2768, 7, 53, 258, '500118', 'HUERTA MAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2769, 7, 53, 258, '500522', 'TIRINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2770, 7, 53, 258, '500564', 'YAWACARI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2771, 7, 53, 258, '500598', 'CONDES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2772, 7, 59, 244, '500401', 'BELLA VISTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2773, 7, 59, 244, '500402', 'CHACOMA - POTOSI                                                 ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2774, 7, 59, 244, '500403', 'HUANAQUE                                                         ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2775, 7, 59, 244, '500404', 'LLICA                                                            ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2776, 7, 59, 244, '500405', 'LLICA C.N.S.                                                     ', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2777, 7, 59, 244, '500406', 'SEJCIHUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2778, 7, 59, 244, '500407', 'TRES CRUCES                                                      ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2779, 7, 59, 244, '500408', 'VILLA AROMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2780, 7, 59, 244, '500483', 'PALAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2781, 7, 59, 259, '500409', 'CAQUENA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2782, 7, 59, 259, '500410', 'TAHUA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2783, 7, 59, 259, '500411', 'YONZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2784, 7, 59, 253, '500431', 'ALOTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2785, 7, 59, 253, '500432', 'SAN AGUSTIN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2786, 7, 59, 253, '500433', 'TODO- SANTOS                                                     ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2787, 7, 59, 253, '500565', 'CERRO GORDO                                                      ', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2788, 7, 56, 232, '500392', 'RENATO CASTRO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2789, 7, 56, 232, '500393', 'ASANQUIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2790, 7, 56, 232, '500394', 'SANTIAGO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2791, 7, 56, 232, '500395', 'SARCURI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2792, 7, 56, 232, '500507', 'KOARACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2793, 7, 56, 232, '500572', 'CALACHUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2794, 7, 56, 231, '500396', 'ACACIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2795, 7, 56, 231, '500397', 'CHURITACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2796, 7, 56, 231, '500398', 'PIRIQUINA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2797, 7, 56, 231, '500399', 'TORNO K`ASA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2798, 7, 56, 231, '500400', 'TOTOROMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2799, 7, 56, 231, '500459', 'KIRUSILLANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2800, 7, 55, 250, '500331', 'CHINOLI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2801, 7, 55, 250, '500333', 'ESMERALDA ALTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2802, 7, 55, 250, '500336', 'KEPALLO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2803, 7, 55, 250, '500339', 'MICULPAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2804, 7, 55, 250, '500341', 'NUQUI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2805, 7, 55, 250, '500343', 'OTAVI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2806, 7, 55, 250, '500344', 'PACASI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2807, 7, 55, 250, '500345', 'PUNA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2808, 7, 55, 250, '500346', 'SAN LORENZO - PUNA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2809, 7, 55, 250, '500348', 'SEPULTURAS - POTOSI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2810, 7, 55, 250, '500349', 'SUQUICHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2811, 7, 55, 250, '500351', 'TOCLA (PUNA)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2812, 7, 55, 250, '500352', 'TOMOLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2813, 7, 55, 250, '500354', 'VILACAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2814, 7, 55, 250, '500355', 'YASCAPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2815, 7, 55, 250, '500466', 'CAPAÑA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2816, 7, 55, 250, '500467', 'TURQUIÑA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2817, 7, 55, 250, '500469', 'HUATINA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2818, 7, 55, 250, '500496', 'CRUZ PATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2819, 7, 55, 250, '500497', 'MOJONA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2820, 7, 55, 250, '500523', 'C.S.C.I. ALCATUYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2821, 7, 55, 250, '500603', 'TACLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2822, 7, 55, 250, '500604', 'SANTA ROSA DE BELEN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2823, 7, 55, 236, '500357', 'SAN MARTIN DE PORRES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2824, 7, 55, 236, '500358', 'CALTAPI PUNKU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2825, 7, 55, 236, '500359', 'CHILLMA                                                          ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2826, 7, 55, 236, '500360', 'CUCHU INGENIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2827, 7, 55, 236, '500361', 'HUICHACA                                                         ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2828, 7, 55, 236, '500362', 'FRAGUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2829, 7, 55, 236, '500363', 'LA LAVA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2830, 7, 55, 236, '500364', 'PANCOCHI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2831, 7, 55, 236, '500365', 'TRES CRUCES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2832, 7, 55, 236, '500366', 'HORNOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2833, 7, 55, 236, '500367', 'TUCTAPARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2834, 7, 55, 270, '500329', 'CALAPAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2835, 7, 55, 270, '500330', 'CHECCHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2836, 7, 55, 270, '500332', 'CKOCHAS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2837, 7, 55, 270, '500334', 'HUAYLLAJARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2838, 7, 55, 270, '500335', 'KELUYO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2839, 7, 55, 270, '500337', 'MEDIA LUNA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2840, 7, 55, 270, '500338', 'MELENA ALTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2841, 7, 55, 270, '500340', 'MOLLES', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2842, 7, 55, 270, '500342', 'ORONKOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2843, 7, 55, 270, '500347', 'SAN PEDRO DE ESQUIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2844, 7, 55, 270, '500350', 'TAMBILLOS', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2845, 7, 55, 270, '500353', 'TURUCHIPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2846, 7, 55, 270, '500439', 'UYUNI (PUNA)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2847, 7, 55, 270, '500468', 'SEOCOCHI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2848, 7, 55, 270, '500470', 'AUCAPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2849, 7, 55, 270, '500471', 'LAJAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2850, 7, 55, 270, '500472', 'CARPA HUATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2851, 7, 55, 270, '500521', 'HUARA HUARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2852, 7, 55, 270, '500618', 'P.S. LADERA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2853, 7, 60, 267, '500412', 'BERQUE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2854, 7, 60, 267, '500413', 'CASIRA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2855, 7, 60, 267, '500414', 'CHAGUA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2856, 7, 60, 267, '500415', 'CHIPIHUAYCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2857, 7, 60, 267, '500416', 'CHOSCONTY', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2858, 7, 60, 267, '500417', 'HIGUERAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2859, 7, 60, 267, '500418', 'MOJO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2860, 7, 60, 267, '500419', 'MORAYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2861, 7, 60, 267, '500420', 'SAGNASTY', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2862, 7, 60, 267, '500421', 'SELOCHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2863, 7, 60, 267, '500422', 'SOCOCHA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2864, 7, 60, 267, '500423', 'SAN MARTIN', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2865, 7, 60, 267, '500424', 'SAN JUAN DE DIOS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2866, 7, 60, 267, '500425', 'ELIODORO VILLAZON', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2867, 7, 60, 267, '500426', 'HOSP. SAN ROQUE', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(2868, 7, 60, 267, '500427', 'C.N.S. POLICLINICO 5                                             ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2869, 7, 60, 267, '500429', 'SAN JUDAS TADEO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2870, 7, 60, 267, '500430', 'YURUMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2871, 7, 60, 267, '500530', 'SALITRE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2872, 7, 60, 267, '500579', 'NIÑO JESUS DE NAZARETH', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2873, 7, 60, 267, '500597', 'OJO DE AGUA', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2874, 7, 60, 267, '500605', 'CLINICA MONTECINOS ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(2875, 7, 60, 267, '500623', 'C.S. MARIA ISABEL', 4, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(2876, 7, 51, 242, '500187', 'ASCANTI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2877, 7, 51, 242, '500188', 'CALILA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2878, 7, 51, 242, '500189', 'CAZON', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2879, 7, 51, 242, '500190', 'CHECOCHI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2880, 7, 51, 242, '500191', 'CHUI CHUI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2881, 7, 51, 242, '500192', 'CKARA CKARA (COTAGAITA)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2882, 7, 51, 242, '500193', 'COLLPA UNO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2883, 7, 51, 242, '500194', 'CORNACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2884, 7, 51, 242, '500195', 'COTAGAITA', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2885, 7, 51, 242, '500196', 'COTAGAITA (CAJA)                                                 ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2886, 7, 51, 242, '500197', 'COTAGAITILLA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2887, 7, 51, 242, '500198', 'ESCARA', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2888, 7, 51, 242, '500199', 'LAYTAPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2889, 7, 51, 242, '500200', 'LIMETA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2890, 7, 51, 242, '500201', 'MOCKO PATA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2891, 7, 51, 242, '500202', 'RANCHO PALCA HIGUERAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2892, 7, 51, 242, '500203', 'PAMPA GRANDE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2893, 7, 51, 242, '500204', 'QUECHISLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2894, 7, 51, 242, '500205', 'RAMADAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2895, 7, 51, 242, '500206', 'SAGRARIO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2896, 7, 51, 242, '500207', 'SAN JORGE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2897, 7, 51, 242, '500208', 'TABLAYA CHICA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2898, 7, 51, 242, '500209', 'TASNA RETIRO                                                     ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2899, 7, 51, 242, '500210', 'TASNA ROSARIO                                                    ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2900, 7, 51, 242, '500211', 'THAPI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2901, 7, 51, 242, '500212', 'TOCLA (COTAGAITA)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2902, 7, 51, 242, '500213', 'TOROPALCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2903, 7, 51, 242, '500214', 'TOTORA (COTAGAITA)', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2904, 7, 51, 242, '500215', 'TUMUSLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2905, 7, 51, 242, '500216', 'VICHACLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2906, 7, 51, 242, '500217', 'VILLA CONCEPCION', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2907, 7, 51, 242, '500218', 'TAPCHIQUIRA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2908, 7, 51, 242, '500219', 'TASNA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2909, 7, 51, 242, '500220', 'SAGRARIO (CAJA)                                                   ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2910, 7, 51, 242, '500448', 'JACOSCAPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2911, 7, 51, 242, '500457', 'URUPALCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2912, 7, 51, 242, '500524', 'PALCA LILI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2913, 7, 51, 268, '500221', 'ARIPALCA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2914, 7, 51, 268, '500222', 'CALCHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2915, 7, 51, 268, '500223', 'KEHUACA GRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2916, 7, 51, 268, '500224', 'PECKA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2917, 7, 51, 268, '500225', 'PEKAJSI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2918, 7, 51, 268, '500226', 'SAN ANTONIO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2919, 7, 51, 268, '500227', 'TUSQUIÑA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2920, 7, 51, 268, '500228', 'VITICHI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2921, 7, 51, 268, '500229', 'YAWISLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2922, 7, 51, 268, '500230', 'YULO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2923, 7, 51, 268, '500449', 'CALVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2924, 7, 51, 268, '500492', 'ESTUMILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2925, 7, 51, 268, '500525', 'TOQUENZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2926, 7, 51, 268, '500589', 'YURAC CANCHA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2927, 7, 51, 268, '500590', 'SURMAJCHI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2928, 7, 59, 240, '500299', '\"CALCHA \"\"K\"\"\"', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2929, 7, 59, 240, '500300', 'COCANI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2930, 7, 59, 240, '500301', '\"COLCHA \"\"K\"\"\"', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2931, 7, 59, 240, '500302', '\"CULPINA \"\"K\"\"\"', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2932, 7, 59, 240, '500303', 'POZO CABADO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2933, 7, 59, 240, '500304', 'RIO GRANDE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2934, 7, 59, 240, '500305', 'SAN CRISTOBAL', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2935, 7, 59, 240, '500306', 'SANTIAGO DE AGENCHA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2936, 7, 59, 240, '500307', '\"SANTIAGO \"\"K\"\"\"', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2937, 7, 59, 240, '500308', 'VILLA MAR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2938, 7, 59, 240, '500309', 'ZONIQUERA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2939, 7, 59, 240, '500310', '\"COLCHA \"\"K\"\" C.N.S.                                                \"', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2940, 7, 59, 240, '500311', 'SAN JUAN - POTOSI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2941, 7, 59, 240, '500444', 'COPACABANA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2942, 7, 59, 240, '500503', '\"VILUYO \"\"K\"\"\"', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2943, 7, 59, 240, '500504', 'AGUA DE CASTILLA NOR LIPEZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2944, 7, 59, 240, '500520', 'CIENEGUILLAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2945, 7, 59, 240, '500580', 'TOLDOS                                                  ', 5, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(2946, 7, 59, 240, '500586', 'VILAMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2947, 7, 59, 240, '500608', 'VILA VILA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2948, 7, 59, 257, '500312', 'SAN PEDRO DE QUEMES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2949, 7, 58, 264, '500057', 'CALA CALA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2950, 7, 58, 264, '500059', 'HOSP. OBRERO Nº11 UNCIA                                               ', 12, 2, 7, 10, 2, NULL, NULL, NULL, NULL),
(2951, 7, 58, 264, '500060', 'MOROCOMARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2952, 7, 58, 264, '500061', 'PATA PATA GRANDE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2953, 7, 58, 264, '500062', 'CIVIL DE UNCIA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(2954, 7, 58, 264, '500478', 'MERKAYMAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2955, 7, 58, 264, '500606', 'LAGUNILLAS', 4, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(2956, 7, 58, 239, '500066', 'VIRGEN DE ROSARIO - AMAYAPAMPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2957, 7, 58, 239, '500067', 'AYMAYA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2958, 7, 58, 239, '500068', 'SAN JUAN DE DIOS CHAYANTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2959, 7, 58, 239, '500069', 'CNS CHAYANTA                                                     ', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2960, 7, 58, 239, '500071', 'COATACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2961, 7, 58, 239, '500072', 'SANTIAGO - IRUPATA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2962, 7, 58, 239, '500073', 'SAN FRANCISCO - COPANA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2963, 7, 58, 239, '500074', 'SAN CRISTOBAL - PANACACHI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2964, 7, 58, 239, '500075', 'QUINTAPAMPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2965, 7, 58, 239, '500076', 'CNS  AMAYAPAMPA                                                  ', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2966, 7, 58, 239, '500440', 'ENTRE RIOS (CHAYANTA)', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2967, 7, 58, 239, '500445', 'CORAZÓN DE JESUS  - CHAYANTA CALA CALA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2968, 7, 58, 239, '500479', 'SAN BARTOLOMÉ - KEWAYLLUNI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2969, 7, 58, 239, '500615', 'SANTA MARIA LA YURI', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2970, 7, 58, 243, '500077', 'CNS POLICLINICO LLALLAGUA                                        ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(2971, 7, 58, 243, '500078', 'CAMANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2972, 7, 58, 243, '500079', 'JACHOJO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2973, 7, 58, 243, '500080', 'HOSP. MADRE OBRERA (LLALLAGUA)', 12, 2, 6, 18, 1, NULL, NULL, NULL, NULL),
(2974, 7, 58, 243, '500081', 'UYUNI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2975, 7, 58, 243, '500082', 'CNS  CATAVI                                                      ', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2976, 7, 58, 243, '500441', 'CAPUNITA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2977, 7, 58, 243, '500442', 'SAUTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2978, 7, 58, 243, '500480', 'MADRE OBRERA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2979, 7, 58, 243, '500481', 'CATAVI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2980, 7, 58, 243, '500482', 'SIGLO XX', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(2981, 7, 58, 269, '500058', 'SANTA MARIA DE CHUQUIUTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2982, 7, 58, 269, '500065', 'CNS CHUQUIUTA                                                    ', 18, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(2983, 7, 58, 269, '500443', 'ARANIPAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2984, 7, 58, 269, '500477', 'MIKANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2985, 7, 58, 269, '500552', 'TACOPALCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2986, 7, 58, 269, '500622', 'BELEN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2987, 7, 57, 263, '500244', 'CHACOPAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2988, 7, 57, 263, '500245', 'CHILCOBIJA                                                       ', 4, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(2989, 7, 57, 263, '500246', 'CHUQUIAGO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2990, 7, 57, 263, '500247', 'ESMORACA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2991, 7, 57, 263, '500248', 'ESTARCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2992, 7, 57, 263, '500249', 'HUMACHA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2993, 7, 57, 263, '500250', 'KENCO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(2994, 7, 57, 263, '500251', 'MOLINO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2995, 7, 57, 263, '500252', 'NAZARENO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2996, 7, 57, 263, '500253', 'OPLOCA  C.N.S.                                        ', 18, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(2997, 7, 57, 263, '500254', 'OPLOCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2998, 7, 57, 263, '500256', 'ORO INGENIO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(2999, 7, 57, 263, '500257', 'PENA AMARILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3000, 7, 57, 263, '500258', 'PIEDRAS BLANCAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3001, 7, 57, 263, '500259', 'QUIRIZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3002, 7, 57, 263, '500260', 'REYNECILLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3003, 7, 57, 263, '500261', 'RIO BLANCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3004, 7, 57, 263, '500262', 'SALO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3005, 7, 57, 263, '500263', 'SAN JOSE PAMPA GRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3006, 7, 57, 263, '500264', 'SAN MIGUEL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3007, 7, 57, 263, '500265', 'SUIPACHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3008, 7, 57, 263, '500266', 'SUPIRA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3009, 7, 57, 263, '500267', 'TALINA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3010, 7, 57, 263, '500268', 'TAPAXA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3011, 7, 57, 263, '500269', 'TOCLOCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3012, 7, 57, 263, '500270', 'TUPIZA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3013, 7, 57, 263, '500271', 'APOSTOL SANTIAGO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3014, 7, 57, 263, '500272', 'VILLA FATIMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3015, 7, 57, 263, '500273', 'SAN ANTONIO (TUPIZA)', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3016, 7, 57, 263, '500274', 'SAN GERARDO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3017, 7, 57, 263, '500275', 'HOSP. EDUARDO EGUA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3018, 7, 57, 263, '500276', 'AGENCIA REGIONAL COSSMIL TUPIZA                                         ', 4, 1, 1, 2, 2, NULL, NULL, NULL, NULL),
(3019, 7, 57, 263, '500277', 'CAJA DE SALUD DE CAMINOS Y R.A.                                         ', 4, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(3020, 7, 57, 263, '500278', 'VILLA PACHECO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3021, 7, 57, 263, '500279', 'POLICONSULTORIO Nº 37                                          ', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3022, 7, 57, 263, '500281', 'PALQUIZA', 18, 1, 6, 39, 1, NULL, NULL, NULL, NULL),
(3023, 7, 57, 263, '500282', 'VISCACHANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3024, 7, 57, 263, '500283', 'TAMBO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3025, 7, 57, 263, '500284', 'ZAPATERA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3026, 7, 57, 263, '500285', 'ALTO MAMAHOTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3027, 7, 57, 263, '500531', 'HOSPITAL OBRERO Nº 10 C.N.S.                                         ', 12, 2, 7, 10, 1, NULL, NULL, NULL, NULL),
(3028, 7, 57, 263, '500535', 'TOLAMAYU                                                         ', 18, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3029, 7, 57, 263, '500537', 'MINA  SEGOVIA                                                    ', 18, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3030, 7, 57, 263, '500538', 'SAN  SILVESTRE                                                  ', 18, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3031, 7, 57, 263, '500539', 'ATENCION AL PACIENTE CHAGASICO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3032, 7, 57, 263, '500581', 'SANTA ROSA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3033, 7, 57, 233, '500287', 'ANIMAS C.N.S.                    ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3034, 7, 57, 233, '500288', 'CIVIL ATOCHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3035, 7, 57, 233, '500289', 'HOSP. OBRERO 13  C.N.S.                                            ', 12, 2, 7, 10, 1, NULL, NULL, NULL, NULL),
(3036, 7, 57, 233, '500290', 'CHOROLQUE C.N.S.                     ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3037, 7, 57, 233, '500292', 'COTANI C.N.S.            ', 18, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3038, 7, 57, 233, '500293', 'SAN VICENTE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3039, 7, 57, 233, '500294', 'GUADALUPE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3040, 7, 57, 233, '500295', 'SANTA BARBARA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3041, 7, 57, 233, '500296', 'SIETE SUYOS C.N.S.                                                ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3042, 7, 57, 233, '500297', 'TATASI C.N.S.      ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3043, 7, 57, 233, '500298', 'TELEMAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3044, 7, 57, 233, '500485', 'TATASI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3045, 7, 57, 233, '500561', 'FIERRO UNO C.N.S.                            ', 18, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3046, 7, 57, 233, '500570', 'TELAMAYU  C.N.S.                                                 ', 4, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3047, 7, 57, 233, '500582', 'ANIMAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3048, 7, 57, 233, '500583', 'SIETE SUYOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3049, 7, 57, 255, '500313', 'CERRILLOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3050, 7, 57, 255, '500314', 'SAN ANTONIO DE LIPEZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3051, 7, 57, 255, '500315', 'POLULOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3052, 7, 57, 255, '500316', 'QUETENA CHICO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3053, 7, 57, 255, '500317', 'QUETENA GRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3054, 7, 57, 255, '500318', 'RELAVE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3055, 7, 57, 255, '500319', 'RIO SAN PABLO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3056, 7, 57, 255, '500320', 'SAN PABLO DE LIPEZ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3057, 7, 57, 255, '500321', 'SANTA ISABEL                                                     ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3058, 7, 57, 255, '500322', 'VILUYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3059, 7, 57, 255, '500517', 'KOLLPANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3060, 7, 57, 245, '500323', 'CASA GRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3061, 7, 57, 245, '500324', 'LA CIENEGA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3062, 7, 57, 245, '500325', 'MOJINETE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3063, 7, 57, 254, '500326', 'GUADALUPE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3064, 7, 57, 254, '500327', 'RIO MOJON', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3065, 7, 57, 254, '500328', 'SAN ANTONIO DE ESMORUCO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3066, 7, 57, 254, '500473', 'RIO SECO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3067, 7, 53, 260, '500035', 'ANTHURA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3068, 7, 53, 260, '500036', 'CAIMOMA - PIQUIRA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3069, 7, 53, 260, '500037', 'CHALLAMAYU', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3070, 7, 53, 260, '500038', 'JAHUACAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3071, 7, 53, 260, '500040', 'CRISTO DE LA ASCENSION DE KELLU CANCHA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3072, 7, 53, 260, '500041', 'SIHUAYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3073, 7, 53, 260, '500042', 'TALULA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3074, 7, 53, 260, '500043', 'TINGUIPAYA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3075, 7, 53, 260, '500044', 'TUISURI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3076, 7, 53, 260, '500045', 'ACTARA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3077, 7, 53, 260, '500450', 'MUITA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3078, 7, 53, 260, '500451', 'SAYACA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3079, 7, 53, 260, '500452', 'CIENEGOMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3080, 7, 53, 260, '500453', 'CALLPA PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3081, 7, 53, 260, '500454', 'PUJYU PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3082, 7, 53, 260, '500455', 'PUKA PUNTA                                                       ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3083, 7, 53, 260, '500559', 'ANCKARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3084, 7, 53, 266, '500046', 'CAYARA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3085, 7, 53, 266, '500047', 'CHIRACORO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3086, 7, 53, 266, '500049', 'TOTORA D', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3087, 7, 53, 266, '500050', 'TURQUI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3088, 7, 53, 266, '500051', 'YOCALLA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3089, 7, 53, 266, '500053', 'BELEN PAMPA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3090, 7, 53, 266, '500557', 'SAN ANTONIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3091, 7, 53, 266, '500558', 'TOTORA PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3092, 7, 53, 234, '500054', 'BELEN DE URMIRI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3093, 7, 53, 234, '500055', 'VACUYO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3094, 7, 53, 234, '500056', 'PUITUCO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3095, 7, 54, 249, '500002', 'HOSP. OBRERO # 5 CNS                                                  ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(3096, 7, 54, 249, '500003', 'HOSP. D. BRACAMONTE                                                   ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3097, 7, 54, 249, '500004', 'CAJA PETROLERA                                                   ', 16, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(3098, 7, 54, 249, '500005', 'PLAN 40', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3099, 7, 54, 249, '500006', 'AZANGARO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3100, 7, 54, 249, '500007', 'LAS DELICIAS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3101, 7, 54, 249, '500008', 'PARY ORKO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3102, 7, 54, 249, '500010', 'HOSP. S.S. UNIVERSITARIO                                              ', 12, 2, 7, 35, 2, NULL, NULL, NULL, NULL),
(3103, 7, 54, 249, '500011', 'C.S. AMBULATORIO SAN ROQUE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3104, 7, 54, 249, '500012', 'HOSP. N.I.S. DE CONCEPCION                                            ', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(3105, 7, 54, 249, '500014', 'C.S. DISPENSARIO SAN GERARDO                                          ', 4, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(3106, 7, 54, 249, '500016', 'SAN CRISTOBAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3107, 7, 54, 249, '500017', 'SAN GERARDO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3108, 7, 54, 249, '500018', ' C.I.E.S.                                                         ', 4, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3109, 7, 54, 249, '500019', 'PAILAVIRI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3110, 7, 54, 249, '500021', 'CHAQUILLA ALTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3111, 7, 54, 249, '500022', 'CHULLCHUCANI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3112, 7, 54, 249, '500023', 'HUARI HUARI', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3113, 7, 54, 249, '500024', 'EMERGENCIA (SEDES)                                               ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3114, 7, 54, 249, '500025', 'POTOSI', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3115, 7, 54, 249, '500026', 'CANTUMARCA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3116, 7, 54, 249, '500027', 'SAN PEDRO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3117, 7, 54, 249, '500028', 'VILLA COLON', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3118, 7, 54, 249, '500030', 'CAJA DE SALUD DE CAMINOS R.A                                           ', 12, 2, 7, 8, 2, NULL, NULL, NULL, NULL),
(3119, 7, 54, 249, '500031', 'SAGRADA FAMILIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3120, 7, 54, 249, '500032', 'SANTIAGO DE OCKORURO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3121, 7, 54, 249, '500033', 'SAN BENITO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3122, 7, 54, 249, '500034', 'VILLA VENEZUELA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3123, 7, 54, 249, '500446', 'TARAPAYA', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3124, 7, 54, 249, '500484', 'HOSPITAL MUNICIPAL SAN CRISTOBAL', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3125, 7, 54, 249, '500508', 'VILLA MECANICOS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3126, 7, 54, 249, '500527', 'CERRO DE PLATA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3127, 7, 54, 249, '500541', 'VIRGEN DE  COPACABANA POTOSI                                     ', 4, 1, 5, 24, 2, NULL, NULL, NULL, NULL),
(3128, 7, 54, 249, '500553', 'CSBP - POLICONSULTORIO POTOSÍ', 16, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(3129, 7, 54, 249, '500555', 'SAN ANCELMO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3130, 7, 54, 249, '500556', 'CRUZ  ROJA                                                       ', 4, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3131, 7, 54, 249, '500593', 'CENTRO MULTIFUNCIONAL PARA PERSONAS CON DISCAPACIDAD POTOSI', 2, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3132, 7, 54, 249, '500594', 'BANCO DE SANGRE DE REFERENCIA DEPARTAMENTAL', 1, 4, 6, 18, 2, NULL, NULL, NULL, NULL),
(3133, 7, 54, 249, '500595', 'MADRE TERESA DE CALCUTA ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3134, 7, 54, 249, '500607', 'CEMFY', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3135, 7, 54, 249, '500616', 'HOSPITAL SAN ROQUE POTOSI', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3136, 7, 54, 249, '500617', 'CAJA DE SALUD DE LA BANCA ESTATAL - POTOSÍ', 17, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(3137, 7, 54, 249, '500620', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD - POTOSÍ', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(3138, 7, 54, 249, '500621', 'KARACHIPAMPA', 3, 1, 6, 17, 1, NULL, NULL, NULL, NULL),
(3139, 7, 54, 249, '500624', 'CONSULTORIO MEDICO INNOVASALUD S.A. SAN ROQUE', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3140, 7, 54, 249, '500626', 'CLINICA DE ESPECIALIDADES BASICAS DIAGNOSTICO S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3141, 7, 54, 249, '500627', '\"CLINICA DEL CHOFER \"\"1 DE MAYO\"\"\"', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3142, 7, 54, 249, '500628', '\"CLINICA DE ESPECIALIDADES MEDICAS BASICAS \"\"SAINT JUDE CENTRO MEDICO QUIR\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3143, 7, 54, 249, '500631', 'CONSULTORIO MEDICO SANTA TERESA', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3144, 7, 54, 249, '500632', 'CENTRO DE SALUD INTEGRAL PLAN 700', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3145, 8, 103, 320, '700001', 'HOSP.  DE NIÑOS                                                       ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3146, 8, 103, 320, '700002', 'H.G. SAN JUAN DE DIOS                                                 ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3147, 8, 103, 320, '700003', 'INSTITUTO ONCOLOGICO                                                  ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3148, 8, 103, 320, '700004', 'HOSPITAL DE LA MUJER  DR. PERCY BOLAND RODRIGUEZ                      ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3149, 8, 103, 320, '700005', 'C.E.N.E.T.R.O.P.                                                      ', 13, 7, 6, 39, 2, NULL, NULL, NULL, NULL),
(3150, 8, 103, 320, '700006', 'H.G. UNIVERSITARIO JAPONES                                            ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3151, 8, 103, 320, '700077', 'CSBP - CLINICA SANTA CRUZ                                     ', 12, 2, 7, 9, 2, NULL, NULL, NULL, NULL),
(3152, 8, 103, 320, '700078', 'H.G. C.P.S.                                                           ', 11, 3, 7, 11, 2, NULL, NULL, NULL, NULL),
(3153, 8, 103, 320, '700079', 'HOSPITAL MATERNO INFANTIL CAÑOTO C.N.S.                               ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(3154, 8, 103, 320, '700615', 'C.S. CDVIR - SC                                                       ', 2, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3155, 8, 103, 320, '700767', 'HOSPITAL OBRERO Nº 3 C.N.S.                                           ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(3156, 8, 103, 320, '700782', 'BANCO DE SANGRE CAJA NACIONAL DE SALUD', 1, 4, 7, 10, 2, NULL, NULL, NULL, NULL),
(3157, 8, 103, 320, '700872', 'HOSPITAL DE TERCER NIVEL DE MONTERO', 11, 3, 6, 21, 2, NULL, NULL, NULL, NULL),
(3158, 8, 103, 320, '700881', 'BRIGADAS DE VACUNACIÓN SEDES SANTA CRUZ', 19, 9, 6, 17, 2, NULL, NULL, NULL, NULL),
(3159, 8, 118, 282, '700118', 'LOS TAJIBOS - COTOCA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3160, 8, 118, 282, '700119', 'HOSPITAL MUNICIPAL VIRGEN DE COTOCA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3161, 8, 118, 282, '700120', 'CAMPANERO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3162, 8, 118, 282, '700121', 'PUERTO PAILAS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3163, 8, 118, 282, '700455', 'DON LORENZO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3164, 8, 118, 282, '700456', 'TAROPE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3165, 8, 118, 282, '700458', 'MAPAIZO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3166, 8, 118, 282, '700459', 'ENCONADA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3167, 8, 118, 282, '700596', 'BISITO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3168, 8, 118, 282, '700597', 'DON CHICHI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3169, 8, 118, 282, '700706', 'HOGAR TERESA DE LOS ANDES                                      ', 4, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(3170, 8, 118, 282, '700854', 'EL CARMEN 2', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3171, 8, 118, 282, '700893', 'CENTRO DE SALUD GREMIAL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3172, 8, 118, 282, '700913', 'CENTRO DE SALUD PATUJU', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3173, 8, 118, 282, '700914', 'PUESTO DE SALUD ARROYUELO NORTE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3174, 8, 118, 282, '700915', 'PUESTO DE SALUD SAN ANDRES', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3175, 8, 118, 282, '700916', 'PUESTO DE SALUD LA LAGUNOTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3176, 8, 118, 282, '700917', 'CENTRO DE SALUD COSORIO', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3177, 8, 118, 272, '700122', 'SOMBRERITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3178, 8, 118, 272, '700123', 'SAN JUAN BAUTISTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3179, 8, 118, 272, '700124', 'TEREBINTO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3180, 8, 118, 272, '700125', 'SANTA FE DE AMBORO ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3181, 8, 118, 272, '700461', 'TARUMATU', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3182, 8, 118, 272, '700462', 'LOS BATOS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3183, 8, 118, 272, '700463', 'NUEVA PALESTINA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3184, 8, 118, 272, '700464', 'SAN PEDRO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3185, 8, 118, 272, '700674', 'LUQUILLAS', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3186, 8, 118, 272, '700675', 'LAS CRUCES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3187, 8, 118, 289, '700126', 'ROMULO GOMEZ', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3188, 8, 118, 289, '700127', 'SANTA TERESA ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3189, 8, 118, 289, '700128', 'PEDRO LORENZO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3190, 8, 118, 289, '700129', 'VILLA ARRIEN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3191, 8, 118, 289, '700130', 'BASILIO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3192, 8, 118, 289, '700131', 'EL CARMEN KM.9', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3193, 8, 118, 289, '700132', 'SAN JOSE ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3194, 8, 118, 289, '700133', 'SAN SILVESTRE', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3195, 8, 118, 289, '700460', 'SAN MIGUEL DEL ROSARIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3196, 8, 118, 289, '700671', 'HOSP. 3ER NIVEL  COMUNIDAD ENCUENTRO                                  ', 14, 3, 2, 19, 2, NULL, NULL, NULL, NULL),
(3197, 8, 118, 289, '700705', '23 DE OCTUBRE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3198, 8, 118, 289, '700825', 'C.S.A. MARIA FERNANDA ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3199, 8, 118, 289, '700848', 'CLÍNICA MEDICMEL', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3200, 8, 118, 289, '700855', 'CHERENTAVE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3201, 8, 118, 289, '700862', 'EL CARMEN KM 10', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3202, 8, 118, 286, '700134', 'HOSPITAL EL TORNO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3203, 8, 118, 286, '700135', 'FORESTAL', 3, 1, 6, 41, 1, NULL, NULL, NULL, NULL),
(3204, 8, 118, 286, '700136', 'JUNTA PIRAY', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3205, 8, 118, 286, '700137', 'SAN LUIS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3206, 8, 118, 286, '700138', 'JOROCHITO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3207, 8, 118, 286, '700139', 'ANGOSTURA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3208, 8, 118, 286, '700140', 'DERMATOLOGICO                                                  ', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3209, 8, 118, 286, '700141', 'LIMONCITO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3210, 8, 118, 286, '700142', 'TARUMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3211, 8, 118, 286, '700143', 'SANTA RITA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3212, 8, 118, 286, '700144', 'SANTA MARTHA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3213, 8, 118, 286, '700145', 'VILLA TUMAVI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3214, 8, 118, 286, '700649', 'CANADA II', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3215, 8, 118, 286, '700650', 'EL SALAO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3216, 8, 118, 286, '700651', 'MONTE VERDE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3217, 8, 118, 286, '700672', 'NUEVA ESPERANZA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3218, 8, 118, 286, '700673', 'LA SAGRADA FAMILIA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3219, 8, 118, 286, '700676', 'C.S. CLINICA SANTIAGO APOSTOL                                         ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3220, 8, 118, 286, '700831', 'DISTRITO 8 ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3221, 8, 118, 286, '700832', 'DISTRITO 1', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3222, 8, 118, 286, '700847', 'TIQUIPAYA', 3, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3223, 8, 118, 286, '700907', 'P.S. VILLA FLORIDA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3224, 8, 104, 320, '700007', 'PERPETUO SOCORRO ', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3225, 8, 104, 320, '700008', 'ROQUE AGUILERA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3226, 8, 104, 320, '700010', 'WILLE LEMAITRE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3227, 8, 104, 320, '700011', 'SAN LUIS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3228, 8, 104, 320, '700012', 'VIRGEN DE COTOCA ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3229, 8, 104, 320, '700024', 'ELVIRA WUNDERLICH', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3230, 8, 104, 320, '700025', 'SANTA ROSITA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3231, 8, 104, 320, '700026', 'VIRGEN DE FATIMA ', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3232, 8, 104, 320, '700034', 'C.S. PROSALUD LA MORITA                                               ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3233, 8, 104, 320, '700040', 'C.S. PROSALUD LA MADRE                                                ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3234, 8, 104, 320, '700041', 'C.S. PROSALUD EL CARMEN                                               ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3235, 8, 104, 320, '700046', 'H.B.  KOLPING PARAISO                                                 ', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(3236, 8, 104, 320, '700050', 'C.S. MARIE STOPES BOLIVIA                                              ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3237, 8, 104, 320, '700052', 'SAN CARLOS', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3238, 8, 104, 320, '700069', 'C.S. C.I.E.S. SANTA CRUZ                                              ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3239, 8, 104, 320, '700072', 'BRIGIDA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(3240, 8, 104, 320, '700076', 'H.B. CL. MELENDRES                                                    ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3241, 8, 104, 320, '700088', 'H.B. CLINICA PEREYRA                                                  ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3242, 8, 104, 320, '700092', 'C.S. POLICLINICO CNS IRALA                                            ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3243, 8, 104, 320, '700100', 'H.B. CL. ANGEL FOIANINI                                               ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3244, 8, 104, 320, '700104', 'H.B. CL. #3 POLICIAL                                                  ', 12, 2, 5, 24, 2, NULL, NULL, NULL, NULL),
(3245, 8, 104, 320, '700107', 'H.B. CLINICA SAAVEDRA                                                 ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3246, 8, 104, 320, '700109', 'H.B. CLINICA INCOR                                                    ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3247, 8, 104, 320, '700111', '\"CONSULTORIO MEDICO \"\"DR. TORRES\"\"                                         \"', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3248, 8, 104, 320, '700114', 'H.B. CLINICA NIÑO JESUS                                               ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3249, 8, 104, 320, '700116', 'H.B. CLINICA MONTALVO SRL.                                            ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3250, 8, 104, 320, '700117', 'C.S. CLINICA SAN PEDRO                                                ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3251, 8, 104, 320, '700499', 'C.S. CLINICA BETHEL                                                   ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3252, 8, 104, 320, '700500', 'H.B. CLINICA BILBAO                                                   ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3253, 8, 104, 320, '700502', 'CLINICA KAMIYA                                                   ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3254, 8, 104, 320, '700503', 'H.B. CLINCA LOURDES                                                   ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3255, 8, 104, 320, '700504', 'H.B. CLINICA NIÑO JESUS SUC1                                          ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3256, 8, 104, 320, '700505', 'H.B. CLINICA SIRANI                                                   ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3257, 8, 104, 320, '700507', 'H.B.SINEC                                                             ', 12, 2, 7, 38, 2, NULL, NULL, NULL, NULL),
(3258, 8, 104, 320, '700508', 'H.B. CLINICA CARDENAL MAURER                                          ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3259, 8, 104, 320, '700543', 'H.B. CLINICA COSALUD                                                  ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3260, 8, 104, 320, '700545', 'C.S. MISION ESPERANZA                                                 ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3261, 8, 104, 320, '700592', 'H.B. CL.  NUCLEAR                                                     ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3262, 8, 104, 320, '700599', 'H.B. ITALIA                                                           ', 12, 2, 4, 5, 2, NULL, NULL, NULL, NULL),
(3263, 8, 104, 320, '700719', 'CONS. MEDICO A.  C.E.D.I.M.                                           ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3264, 8, 104, 320, '700722', 'CONS. MEDICO LAPAROSCOPICA                                            ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3265, 8, 104, 320, '700723', 'CONS. MEDICO A . RIVIUT SRL.                                          ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3266, 8, 104, 320, '700726', 'CONS. MEDICO DE NEFROLOGIA Y DIALISIS                                 ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3267, 8, 104, 320, '700731', 'CLINICA DEL PULMON                                                    ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3268, 8, 104, 320, '700732', 'CLINICA BALANCE                                                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3269, 8, 104, 320, '700734', 'CLINICA CRISTIANA SOLIDARIA                                           ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3270, 8, 104, 320, '700735', 'CLINICA AMEC II                                                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3271, 8, 104, 320, '700737', 'HOSP. COSSMIL                                                         ', 12, 2, 1, 25, 2, NULL, NULL, NULL, NULL),
(3272, 8, 104, 320, '700770', 'CLINICA CENTRO DE LA MUJER RENGEL SRL                                 ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3273, 8, 104, 320, '700772', 'INSTITUTO DEL RIÑON S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3274, 8, 104, 320, '700781', 'BANCO DE SANGRE CAJA PETROLERA DE SALUD', 1, 4, 7, 11, 2, NULL, NULL, NULL, NULL),
(3275, 8, 104, 320, '700783', 'BANCO DE SANGRE DR. ZUMA ', 1, 4, 4, 14, 2, NULL, NULL, NULL, NULL),
(3276, 8, 104, 320, '700784', 'BANCO DE SANGRE REGIONAL SANTA CRUZ', 1, 4, 6, 21, 2, NULL, NULL, NULL, NULL),
(3277, 8, 104, 320, '700788', 'CLINICA INNOVE', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3278, 8, 104, 320, '700789', 'CLINICA MADRID S.R.L.', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3279, 8, 104, 320, '700790', 'CENTRO DE HEMODIALISIS DAVOSAN', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3280, 8, 104, 320, '700798', 'POLICONSULTORIO BIOCELL', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3281, 8, 104, 320, '700799', 'CLINICA MEDICA MANANTIAL DE VIDA SRL.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3282, 8, 104, 320, '700800', '\"POLICONSULTORIO MEDICO \"\"POLIMEC\"\" SRL \"', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3283, 8, 104, 320, '700801', '\"\"\"FAMILY CENTER\"\" S.R.L. CENTRO DE SALUD SEXUAL\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3284, 8, 104, 320, '700802', 'CENTRO DE ESPECIALIDADES RENAL NEFROLOGIA INTEGRAL ', 14, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(3285, 8, 104, 320, '700803', 'CENTRO MEDICO BARUCH', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3286, 8, 104, 320, '700805', 'CLINICA ESPAÑA', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3287, 8, 104, 320, '700810', 'BIOINGENIERIA ESPECIALIZADA S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3288, 8, 104, 320, '700811', 'CLINICA SION SALUD URBARI SRL.', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(3289, 8, 104, 320, '700812', 'CLINICA CRISTIANA SRL.', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3290, 8, 104, 320, '700813', 'HOSPITAL PSIQUIATRICO BLANCA  AÑEZ DE LOZADA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3291, 8, 104, 320, '700816', 'CAJA PETROLERA DE SALUD POLICONSULTORIO NORTE', 17, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(3292, 8, 104, 320, '700833', 'CLINICA TRAUMA CLINIC S.R.L', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3293, 8, 104, 320, '700836', 'CENTRO DE ATENCIÓN Y PREVENCIÓN DE LA DIABETES', 2, 1, 7, 36, 2, NULL, NULL, NULL, NULL),
(3294, 8, 104, 320, '700839', 'CENTRO DE HEMODIÁLISIS MERCADO AMORES S.R.L. ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3295, 8, 104, 320, '700843', 'CIMFA CENTRAL CNS', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3296, 8, 104, 320, '700846', 'POLICLINICO NORTE', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3297, 8, 104, 320, '700857', 'CENTRO DE TRAUMATOLOGIA Y ORTOPEDIA', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3298, 8, 104, 320, '700866', 'CAJA DE SALUD CORDES', 16, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(3299, 8, 104, 320, '700867', 'SEGURO SOCIAL UNIVERSITARIO SANTA CRUZ', 16, 1, 7, 36, 2, NULL, NULL, NULL, NULL),
(3300, 8, 104, 320, '700871', '\"CENTRO DE ESP. MEDICAS \"\"ROCHA\"\"\"', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3301, 8, 104, 320, '700873', '\"HOSPITAL UNIVERSITARIO \"\"MARTIN DOCKWEILER\"\"\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3302, 8, 104, 320, '700883', 'CLINICA CORPSALUD S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3303, 8, 104, 320, '700886', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD - SCZ', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(3304, 8, 104, 320, '700918', 'CENTRO MEDICO JESUS AYALA S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3305, 8, 104, 320, '700919', 'MEDICINA ESPECIALIZADA GALENICA S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3306, 8, 104, 320, '700920', '\"CONSULTORIO MEDICO \"\"INNOVASALUD SUC PIRAI\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3307, 8, 104, 320, '700927', 'NEFRODIALISIS S.R.L.', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3308, 8, 104, 320, '700928', 'INSIDE', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3309, 8, 104, 320, '700929', '\"NEFRO CENTER\"\" BERMER\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3310, 8, 104, 320, '700938', '\"CRITICAL CENTER \"\" LOS ANGELES \"\" S.R.L.\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3311, 8, 104, 320, '700939', 'CENTRO DE SERVICIOS MEDICOS SAN LIBORIO S.R.L.', 2, 1, 4, 5, 2, NULL, NULL, NULL, NULL),
(3312, 8, 104, 320, '700943', 'POLICONSULTORIO DE LA CAJA DE SALUD DE LA BANCA PRIVADA', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(3313, 8, 104, 320, '700948', 'CLINICA MATERSALUD S.R.L', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3314, 8, 105, 320, '700015', 'EL PAJONAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3315, 8, 105, 320, '700027', 'SAN PANTALEON', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3316, 8, 105, 320, '700028', '25 DE DICIEMBRE', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3317, 8, 105, 320, '700032', 'C.S. PROSALUD DR. I. SUAREZ                                           ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3318, 8, 105, 320, '700033', 'C.S. PROSALUD DR. D. FOIANINI                                         ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3319, 8, 105, 320, '700042', 'C.S. PROSALUD HEROES DEL CHACO                                        ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3320, 8, 105, 320, '700044', 'C.S. BUEN SAMARITANO -STA.CRUZ                                        ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3321, 8, 105, 320, '700061', 'H.B. VIRGEN MILAGROSA                                                 ', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(3322, 8, 105, 320, '700063', 'PREVENTIVA SUD', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3323, 8, 105, 320, '700064', 'SAN AGUSTIN', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3324, 8, 105, 320, '700066', '18 DE MARZO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3325, 8, 105, 320, '700067', 'H.B. HERNANDEZ VERA                                                   ', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(3326, 8, 105, 320, '700080', 'C.S. C.N.S. VILLA 1 DE MAYO                                           ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3327, 8, 105, 320, '700082', 'MARIA CECILIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3328, 8, 105, 320, '700086', 'VIDA Y ESPERANZA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3329, 8, 105, 320, '700087', 'MI SALUD', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3330, 8, 105, 320, '700095', 'PUEBLO NUEVO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3331, 8, 105, 320, '700101', '12 DE DICIEMBRE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3332, 8, 105, 320, '700510', 'H.B. CLINICA MEDICA GONZALES                                          ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3333, 8, 105, 320, '700569', 'CENTRO DE RECUPERACION NUTRICIONAL SANTA CRUZ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3334, 8, 105, 320, '700623', 'CL. SANTA FE                                                          ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3335, 8, 105, 320, '700628', 'C.S. PAURITO MATERNO INFANTIL                                         ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3336, 8, 105, 320, '700629', 'CLINICA EL TROMPILLO                                                  ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3337, 8, 105, 320, '700630', 'HOSPITAL MUNICIPAL PLAN 3000', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3338, 8, 105, 320, '700631', 'CLINICA SAN RAFAELA                                                   ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3339, 8, 105, 320, '700632', 'CAÑADA EL CARMEN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3340, 8, 105, 320, '700633', 'SAN LUISITO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3341, 8, 105, 320, '700634', 'SAN MIGUEL DE LOS JUNOS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3342, 8, 105, 320, '700635', 'EL PORVENIR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3343, 8, 105, 320, '700636', 'NOEL KEMPFF', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3344, 8, 105, 320, '700648', 'HOSPITAL MUNICIPAL VILLA 1RO DE MAYO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3345, 8, 105, 320, '700661', 'LOS PINOS BARRIO NUEVO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3346, 8, 105, 320, '700662', 'ONDULINE GUAPURU', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3347, 8, 105, 320, '700663', 'SANTIAGO PARADA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3348, 8, 105, 320, '700693', 'EL QUIOR', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3349, 8, 105, 320, '700694', 'BUEN SAMARITANO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3350, 8, 105, 320, '700695', 'C.S. PROFAMILIA                                                       ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3351, 8, 105, 320, '700696', 'CLINICA MEDICO CRISTIANO SOLIDARIO                                    ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3352, 8, 105, 320, '700806', 'CLINICA SAN ISIDRO', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3353, 8, 105, 320, '700807', '\"CLINICA \"\"BARTA DE GRUVID S.R.L.\"\"\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3354, 8, 105, 320, '700815', 'CAJA PETROLERA DE SALUD POLICONSULTORIO SUR', 17, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(3355, 8, 105, 320, '700869', 'EL TATU', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3356, 8, 105, 320, '700884', '\"CONSULTORIO MEDICO \"\"INNOVA S.A.- CIUDAD JARDIN\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3357, 8, 105, 320, '700902', 'CENTRO MEDICO SAN MIGUEL', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3358, 8, 105, 320, '700925', '\"UNIDAD DE HEMODIALISIS \"\"NEPHROLOGY\"\"\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3359, 8, 105, 320, '700932', 'CLINICA MEDICA VITALVID-CARDIOSALUD S.R.L', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3360, 8, 106, 320, '700009', 'ANITA SUAREZ DE LEIGUE', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3361, 8, 106, 320, '700013', 'POCHOLA TRAPERO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3362, 8, 106, 320, '700029', 'SANTA ISABEL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3363, 8, 106, 320, '700030', 'C.S. PROSALUD VILLA PILLIN                                            ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3364, 8, 106, 320, '700031', 'H.B. CLINICA PROSALUD                                                 ', 12, 2, 3, 26, 2, NULL, NULL, NULL, NULL),
(3365, 8, 106, 320, '700036', 'LAZARETO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3366, 8, 106, 320, '700045', 'C.S. KOLPING 15 DE DICIEMBRE                                          ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(3367, 8, 106, 320, '700047', 'HAMACAS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3368, 8, 106, 320, '700048', 'C.S. KOLPING-LOS CHACOS                                               ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(3369, 8, 106, 320, '700049', 'C.S. SAN MARTIN-LAS PAMPITAS                                          ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(3370, 8, 106, 320, '700054', 'C.S. PROSALUD LAS PAMPITAS                                            ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3371, 8, 106, 320, '700060', 'SAN ANTONIO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3372, 8, 106, 320, '700081', '10 DE OCTUBRE                                                    ', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3373, 8, 106, 320, '700084', 'MONTERO HOYOS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3374, 8, 106, 320, '700090', 'H.B. CLINICA UCEBOL                                                   ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3375, 8, 106, 320, '700091', 'C.S.C. I. JESUS MARIA                                                   ', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3376, 8, 106, 320, '700094', 'C.S. C.N.S.  PAUSERNA                                                 ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3377, 8, 106, 320, '700487', 'C.S. IGLESIA LOS CHACOS                                               ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(3378, 8, 106, 320, '700513', 'H.B. GUARACACHI  CPS                                                  ', 12, 2, 7, 11, 2, NULL, NULL, NULL, NULL),
(3379, 8, 106, 320, '700515', 'H.B. CLINICA HAMACAS                                                  ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3380, 8, 106, 320, '700516', 'C.S. CLINICA BUENA SALUD                                              ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3381, 8, 106, 320, '700549', 'CLÍNICA VIRGEN DE COTOCA                                              ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3382, 8, 106, 320, '700565', 'CENTRO DE SALUD INNOVALSALUD S.A.-BONANZA                               ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3383, 8, 106, 320, '700567', 'C.S INNOVALSALUD S.A. PATUJU                                            ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3384, 8, 106, 320, '700637', 'C.S. CAMINOS Y.R.A.                                                   ', 12, 2, 7, 8, 2, NULL, NULL, NULL, NULL),
(3385, 8, 106, 320, '700641', 'EL DORADO NORTE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3386, 8, 106, 320, '700655', 'LOS TUSEQUIS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3387, 8, 106, 320, '700666', 'PAMPA DE LA ISLA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3388, 8, 106, 320, '700686', 'CLINICA MEDICA FIGUEROA                                               ', 12, 2, 3, 23, 2, NULL, NULL, NULL, NULL),
(3389, 8, 106, 320, '700687', 'C.S. VIRGEN DE LUJAN                                                  ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3390, 8, 106, 320, '700688', 'LOS CUSIS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3391, 8, 106, 320, '700701', '26 DE SEPTIEMBRE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3392, 8, 106, 320, '700724', 'DR. RIÑON CENTRO MEDICO ESPECIALIZADO  DIALYEMS S.R.L              ', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3393, 8, 106, 320, '700766', 'H.B. CLINICA BRASIL                                                   ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3394, 8, 106, 320, '700785', 'HOSPITAL CATOLICO S.M.- HCSM', 12, 2, 2, 19, 2, NULL, NULL, NULL, NULL),
(3395, 8, 106, 320, '700819', 'CLINICA GALYTER S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3396, 8, 106, 320, '700826', 'CENTRO MÉDICO INTEGRAL', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3397, 8, 106, 320, '700827', 'CLÍNICA VIARA SRL. ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3398, 8, 106, 320, '700844', 'C.S.I. MUNICIPAL DM-5', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3399, 8, 106, 320, '700853', 'CLINICA CAMPERO S.R.L.', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3400, 8, 106, 320, '700858', 'CIES-SALUD SEXUAL Y REPRODUCTIVA SANTA CRUZ', 12, 2, 3, 4, 2, NULL, NULL, NULL, NULL),
(3401, 8, 106, 320, '700880', 'CAJA BANCARIA ESTATAL DE SALUD - SANTA CRUZ', 5, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(3402, 8, 106, 320, '700906', 'CENTRO DE ESPECIALIDADES MEDICAS REDMARIELA S.R.L.', 5, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3403, 8, 106, 320, '700941', 'CLINICA HA MEDICA ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3404, 8, 106, 320, '700944', '\"CLINICA \"\"ONCOSALUD\"\"\"', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3405, 8, 106, 320, '700949', 'CLINICA METROPOLITANA DE LAS AMERICAS S.A', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(3406, 8, 106, 320, '700950', 'C. DE MED.NUCLEAR Y RADIOTERAPIA SANTA CRUZ DE LA SIERRA', 15, 8, 6, 1, 2, NULL, NULL, NULL, NULL),
(3407, 8, 107, 320, '700017', 'PEDRO DIEZ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3408, 8, 107, 320, '700020', 'ANTOFAGASTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3409, 8, 107, 320, '700021', 'TIERRAS NUEVAS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3410, 8, 107, 320, '700022', 'LAS AMERICAS', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3411, 8, 107, 320, '700023', 'H.B. GRUMEDSO                                                         ', 12, 2, 3, 23, 2, NULL, NULL, NULL, NULL),
(3412, 8, 107, 320, '700035', 'LOS OLIVOS', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3413, 8, 107, 320, '700037', 'C.S. PROSALUD LOS LOTES                                               ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3414, 8, 107, 320, '700038', 'SAGRADA FAMILIA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3415, 8, 107, 320, '700039', 'C.S. PROSALUD LA CUCHILLA                                             ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(3416, 8, 107, 320, '700051', 'SANTE SUD', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3417, 8, 107, 320, '700057', 'LA COLORADA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3418, 8, 107, 320, '700058', 'H.B. SAN MARTIN DE P. CUCHILLA                                        ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3419, 8, 107, 320, '700071', 'C.S. POLICLINICO CNS KM 6                                             ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3420, 8, 107, 320, '700074', 'H.B. CL. SAN PRUDENCIO                                                ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3421, 8, 107, 320, '700075', 'CLINICA VIRGENCITA DE COPACABANA                         ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3422, 8, 107, 320, '700085', 'PALMAR DEL ORATORIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3423, 8, 107, 320, '700093', 'C.S. C.N.S. SANTOS  DUMONT                                            ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3424, 8, 107, 320, '700529', 'HOSPITAL MUNICIPAL FRANCES', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3425, 8, 107, 320, '700595', 'INSTITUTO  PSIQUIATRICO BENITO MENNI                                  ', 14, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(3426, 8, 107, 320, '700616', 'PALMASOLA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3427, 8, 107, 320, '700627', 'ROCA Y CORONADO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3428, 8, 107, 320, '700638', 'EL RECREO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3429, 8, 107, 320, '700639', 'PLAN 4000', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3430, 8, 107, 320, '700640', 'LOS BOSQUES', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3431, 8, 107, 320, '700642', 'HOSPITAL MUNICIPAL BAJIO DEL ORIENTE', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3432, 8, 107, 320, '700643', 'MAGISTERIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3433, 8, 107, 320, '700644', 'EL TAJIBO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3434, 8, 107, 320, '700645', 'CORTEZ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3435, 8, 107, 320, '700685', 'BERMUDEZ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3436, 8, 107, 320, '700791', 'CLINICA MODELO JESUS OBRERO', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3437, 8, 107, 320, '700792', 'CLINICA  ANDREA H&M', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3438, 8, 107, 320, '700850', 'CENTRO MÉDICO SAN SALVADOR ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3439, 8, 107, 320, '700852', 'MUNICIPAL DM-12', 5, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(3440, 8, 107, 320, '700864', 'CLINICA RAMIREZ', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3441, 8, 107, 320, '700875', 'HERMANAS PADILLA S.R.L.', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3442, 8, 107, 320, '700876', 'CENTRO MEDICO LOS LOTES', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3443, 8, 107, 320, '700889', 'UNIMEDIC', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3444, 8, 107, 320, '700890', 'CLINICA GRIGOTA', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3445, 8, 107, 320, '700891', 'MUNICIPAL DM-10', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3446, 8, 107, 320, '700911', '\"CONSULTORIO MEDICO \"\"INNOVASALUD SUC. PERLA DEL ORIENTE\"\"\"', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3447, 8, 107, 320, '700922', 'CENDIALISIS INTEGRAL S.R.L', 2, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(3448, 8, 107, 320, '700931', 'CENTRO MEDICO MOSCU S.R.L.', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3449, 8, 107, 320, '700946', 'CLINICA MARANATHAH', 9, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3450, 8, 108, 315, '700409', 'SANTO CORAZON', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3451, 8, 108, 315, '700410', 'SAN MATIAS', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3452, 8, 108, 315, '700411', 'ASCENSION DE LA FRONTERA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3453, 8, 108, 315, '700412', 'LAS PETAS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3454, 8, 108, 315, '700413', 'CANDELARIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3455, 8, 108, 315, '700414', 'SANTA ISABEL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3456, 8, 108, 315, '700415', 'SAN FERNANDO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3457, 8, 108, 315, '700613', 'SANTA FE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3458, 8, 108, 315, '700762', 'TORNITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3459, 8, 108, 315, '700763', 'NATIVIDAD', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3460, 8, 108, 315, '700930', 'CNS CIS SAN MATIAS', 5, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3461, 8, 109, 312, '700216', 'HOSPITAL BERNARDINO GIL JULIO.', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3462, 8, 109, 312, '700217', 'SAN JUAN DE CHIQUITOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3463, 8, 109, 312, '700218', 'TAPERAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3464, 8, 109, 312, '700219', 'BUENA VISTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3465, 8, 109, 312, '700220', 'ENTRE RIOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3466, 8, 109, 312, '700221', 'C.S. CAJA PETROLERA SJ                                                ', 8, 1, 7, 11, 1, NULL, NULL, NULL, NULL),
(3467, 8, 109, 312, '700222', 'C.S. C.N.S SAN JOSE                                                   ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3468, 8, 109, 312, '700223', 'C.S. CLINICA CRISTO REY                                               ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3469, 8, 109, 312, '700224', 'QUIMOME', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3470, 8, 109, 312, '700583', 'IPIAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3471, 8, 109, 312, '700820', 'P.S. 15 DE AGOSTO', 18, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3472, 8, 109, 312, '700821', 'P.S. RAMADA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3473, 8, 109, 312, '700822', 'P.S. LA FORTUNA ', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3474, 8, 109, 296, '700225', 'PAILON', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3475, 8, 109, 296, '700226', 'TRES CRUCES', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3476, 8, 109, 296, '700227', 'POZO DEL TIGRE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3477, 8, 109, 296, '700228', 'ROSAL CENTRO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3478, 8, 109, 296, '700229', 'CANHADA LARGA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3479, 8, 109, 296, '700690', 'TINTO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3480, 8, 109, 296, '700691', '25 DE MAYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3481, 8, 109, 296, '700692', 'CERRO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3482, 8, 109, 305, '700230', 'SANTA LUCIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3483, 8, 109, 305, '700231', 'GERMAN VACA DIEZ', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3484, 8, 109, 305, '700232', 'JUAN XXIII', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3485, 8, 109, 305, '700233', 'H.I.S. ROBORE                                                    ', 12, 2, 7, 10, 1, NULL, NULL, NULL, NULL),
(3486, 8, 109, 305, '700234', 'H.B. CAJA PETROLERA -ROBORE                                           ', 12, 2, 7, 11, 1, NULL, NULL, NULL, NULL),
(3487, 8, 109, 305, '700235', 'C.S. COSSMIL (SCZ-ROBORE)                                               ', 8, 1, 7, 13, 1, NULL, NULL, NULL, NULL),
(3488, 8, 109, 305, '700236', 'AGUAS CALIENTES', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3489, 8, 110, 290, '700253', 'SAN LUIS (LAGUNILLAS)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3490, 8, 110, 290, '700255', 'PUEBLO NUEVO ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3491, 8, 110, 290, '700256', 'POTRERILLOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3492, 8, 110, 290, '700257', 'IGUASURENDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3493, 8, 110, 290, '700258', 'IVIYECA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3494, 8, 110, 290, '700585', 'SAN ISIDRO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3495, 8, 110, 290, '700934', 'CARAPARICITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3496, 8, 110, 278, '700259', 'MAMERTO EGUEZ SORUCO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3497, 8, 110, 278, '700260', 'TAPUTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3498, 8, 110, 278, '700261', 'KAPIGUAZUTI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3499, 8, 110, 278, '700262', 'MASAVI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3500, 8, 110, 278, '700263', 'ITAYU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3501, 8, 110, 278, '700264', 'EL ESPINO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3502, 8, 110, 278, '700265', 'DR. ROBERTO UGARTE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3503, 8, 110, 278, '700266', 'JOSE IYAMBAE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3504, 8, 110, 278, '700267', 'YAPIROA', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3505, 8, 110, 278, '700268', 'COPERE LOMA', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3506, 8, 110, 278, '700269', 'YOVI', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3507, 8, 110, 278, '700270', 'SAN ANTONIO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3508, 8, 110, 278, '700271', 'ITATIQUI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3509, 8, 110, 278, '700272', 'SAN LORENZO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3510, 8, 110, 278, '700273', 'CUARIRENDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3511, 8, 110, 278, '700274', 'RANCHO NUEVO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3512, 8, 110, 278, '700275', 'ISIPORENDA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3513, 8, 110, 278, '700769', 'P.S. AGUARATY                                                         ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3514, 8, 110, 278, '700771', 'C.S.A. CHARAGUA                                                       ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3515, 8, 110, 278, '700787', 'TARENDA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3516, 8, 110, 278, '700856', 'ROGELIO ABAGUAZU CEJAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3517, 8, 110, 275, '700276', 'CABEZAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3518, 8, 110, 275, '700277', 'ABAPO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3519, 8, 110, 275, '700278', 'RIO SECO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3520, 8, 110, 275, '700279', 'MORA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3521, 8, 110, 275, '700280', 'ZANJA HONDA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3522, 8, 110, 275, '700281', 'FLORIDA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3523, 8, 110, 275, '700539', 'SAN JUAN DE CAMARGO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3524, 8, 110, 275, '700584', 'BRECHA 7', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3525, 8, 110, 275, '700778', 'PAMPA EL COSTAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3526, 8, 110, 275, '700912', 'P.S YATEIRENDA', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3527, 8, 110, 284, '700282', 'SAN JUAN BAUTISTA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3528, 8, 110, 284, '700283', 'SALINAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3529, 8, 110, 284, '700284', 'EL ARENAL', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3530, 8, 110, 284, '700285', 'HUARACA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3531, 8, 110, 284, '700286', 'IVICUATI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3532, 8, 110, 284, '700698', 'TARATAGALITO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3533, 8, 110, 288, '700287', 'GUTIERREZ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3534, 8, 110, 288, '700288', 'PALMARITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3535, 8, 110, 288, '700289', 'IPITA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3536, 8, 110, 288, '700290', 'ITEMBEGUAZU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3537, 8, 110, 288, '700291', 'IPITACITO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3538, 8, 110, 288, '700292', 'HEITI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3539, 8, 110, 288, '700293', 'IPATIMIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3540, 8, 110, 288, '700294', 'IVAMIRAPINTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3541, 8, 110, 288, '700295', 'KAPIRENDA', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3542, 8, 110, 288, '700296', 'KASAPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3543, 8, 110, 288, '700297', 'TATARENDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3544, 8, 110, 288, '700298', 'SAN MIGUEL DE POSITOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3545, 8, 110, 288, '700774', 'C.S. GRAN KAIPEPEMDI KARO VAICHO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3546, 8, 110, 276, '700299', 'HOSPITAL CAMIRI', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3547, 8, 110, 276, '700300', 'SAN JOSE LA ABRA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3548, 8, 110, 276, '700302', 'PENA BLANCA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3549, 8, 110, 276, '700303', 'SAN JOSE OBRERO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3550, 8, 110, 276, '700304', 'CHORETI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3551, 8, 110, 276, '700305', 'GUASUIGUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3552, 8, 110, 276, '700306', 'H.B. CAJA PETROLERA DE SALUD                                          ', 12, 2, 7, 11, 1, NULL, NULL, NULL, NULL),
(3553, 8, 110, 276, '700307', 'C.S. COSSMIL(CAMIRI)                                                  ', 8, 1, 7, 13, 1, NULL, NULL, NULL, NULL),
(3554, 8, 110, 276, '700308', 'VIRGEN DE FATIMA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3555, 8, 110, 276, '700309', 'H.B. CAJA NACIONAL CAMIRI                                             ', 12, 2, 7, 10, 1, NULL, NULL, NULL, NULL),
(3556, 8, 110, 276, '700311', 'ITANAMBICUA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3557, 8, 110, 276, '700312', 'PIPI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3558, 8, 110, 276, '700541', 'SAN FRANCISCO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3559, 8, 110, 276, '700542', 'GUIRARAPO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3560, 8, 110, 276, '700624', 'LA WILLIAN', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3561, 8, 110, 276, '700699', 'RODEO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3562, 8, 110, 276, '700758', 'URUNDAITY', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3563, 8, 110, 276, '700759', 'C.S.I.P CLINICA VIRGO                                                 ', 5, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3564, 8, 110, 276, '700780', 'CLINICA SR. DE LA VERA CRUZ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3565, 8, 110, 273, '700313', 'FRAY LEON BIAGGINI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3566, 8, 110, 273, '700314', 'LAGUNA CAMATINDI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3567, 8, 110, 273, '700315', 'CHOROQUETAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3568, 8, 110, 273, '700316', 'VIRGEN DE FATIMA-RBOY', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3569, 8, 110, 273, '700610', 'PRIMERO DE MAYO', 18, 1, 6, 20, 2, NULL, NULL, NULL, NULL),
(3570, 8, 111, 307, '700334', 'FLORIDA', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3571, 8, 111, 307, '700335', 'BERMEJO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3572, 8, 111, 307, '700336', 'CUEVAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3573, 8, 111, 307, '700337', 'SANTIAGO DEL VALLE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3574, 8, 111, 307, '700777', 'BELLA VICTORIA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3575, 8, 111, 307, '700834', 'P.S. RVDO. RAMÓN FERRAN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3576, 8, 111, 297, '700339', 'LOS NEGROS', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3577, 8, 111, 297, '700340', 'MATARAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3578, 8, 111, 297, '700341', 'PAMPA GRANDE', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3579, 8, 111, 297, '700342', 'SANTA ROSA DE LIMA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3580, 8, 111, 297, '700611', 'PALMASOLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3581, 8, 111, 291, '700343', 'MAIRANA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3582, 8, 111, 291, '700344', 'MENDIOLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3583, 8, 111, 291, '700345', 'YERBA BUENA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3584, 8, 111, 291, '700346', 'PIEDRA MESA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3585, 8, 111, 304, '700348', 'QUIRUSILLA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3586, 8, 111, 304, '700612', 'HIERBA BUENA CIVIL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3587, 8, 112, 303, '700427', 'YACUSE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3588, 8, 112, 303, '700429', 'PARADERO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3589, 8, 112, 303, '700433', 'C.S. CLINICA G. SANCHEZ                                               ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3590, 8, 112, 303, '700434', 'C.S. DR. CASTEDO                                                      ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3591, 8, 112, 303, '700435', 'C.S.  BETHESDA                                                        ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(3592, 8, 112, 303, '700586', 'HOSPITAL SAN JUAN DE DIOS ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3593, 8, 112, 303, '700877', 'P.S. MANUEL LARREA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3594, 8, 112, 303, '700879', 'C.S. SAN JUAN DE DIOS - BAHIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3595, 8, 112, 303, '700882', 'COSSMIL PUERTO SUAREZ', 2, 1, 7, 13, 1, NULL, NULL, NULL, NULL),
(3596, 8, 112, 303, '700901', 'C.S. MOTACUCITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3597, 8, 112, 303, '700947', 'CONSUL. MEDICO INNOVASALUD SUC. PUERTO SUAREZ', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3598, 8, 112, 302, '700436', 'PRINCIPE DE PAZ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3599, 8, 112, 302, '700438', 'JANUARIO PEREIRA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3600, 8, 112, 302, '700441', 'C.S. CLINICA SAN JORGE                                                ', 8, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3601, 8, 112, 302, '700442', 'C.S. NAVAL PTO. QUIJARRO                                              ', 8, 1, 1, 25, 1, NULL, NULL, NULL, NULL),
(3602, 8, 112, 302, '700443', 'C.S. CAJA PETROLERA QUIJARRO                                          ', 8, 1, 7, 11, 1, NULL, NULL, NULL, NULL),
(3603, 8, 112, 277, '700425', 'RINCON DEL TIGRE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3604, 8, 112, 277, '700428', 'NUESTRA SEÑORA DEL CARMEN', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3605, 8, 112, 277, '700527', 'CANDELARIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3606, 8, 112, 277, '700528', 'SANTA ANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3607, 8, 112, 277, '700609', 'BOCAINA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3608, 8, 113, 271, '700444', 'GUARAYOS', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3609, 8, 113, 271, '700445', 'SAN PABLO', 18, 1, 6, 41, 1, NULL, NULL, NULL, NULL),
(3610, 8, 113, 271, '700446', 'P.S. SANTA MARIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3611, 8, 113, 271, '700448', 'NUEVA JERUSALEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3612, 8, 113, 271, '700537', 'CERRO GRANDE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3613, 8, 113, 271, '700606', 'SAN ANTONIO EL JUNTE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3614, 8, 113, 271, '700607', 'SAN ANDREZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3615, 8, 113, 271, '700665', 'MUNICIPAL SANTA ROSA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3616, 8, 113, 271, '700897', 'CLINICA MEDICA TINEO', 9, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3617, 8, 113, 323, '700449', 'SAN JOSE', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3618, 8, 113, 323, '700450', 'C.S. YAGUARU                                                          ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(3619, 8, 113, 323, '700451', 'EL BUEN PASTOR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3620, 8, 113, 323, '700536', 'SANTA TERESITA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3621, 8, 113, 285, '700452', 'YOTAU', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3622, 8, 113, 285, '700453', 'EL PUENTE', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3623, 8, 113, 285, '700454', 'NUCLEO 47 - 10 NOV.', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3624, 8, 113, 285, '700533', 'NUCLEO 53', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3625, 8, 113, 285, '700534', 'SURUCUSI', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3626, 8, 113, 285, '700587', 'NUCLEO 50', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3627, 8, 114, 274, '700189', 'ROQUE AGUILERA', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3628, 8, 114, 274, '700190', 'ARBOLEDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3629, 8, 114, 274, '700191', 'CARANDA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3630, 8, 114, 274, '700192', 'HUAYTU', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3631, 8, 114, 274, '700193', 'ESPEJITOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3632, 8, 114, 274, '700194', 'SAN MIGUEL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3633, 8, 114, 274, '700195', 'VILLA DIEGO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3634, 8, 114, 274, '700196', 'PALACIO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3635, 8, 114, 274, '700197', 'EL CARMEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3636, 8, 114, 274, '700493', 'SAN ISIDRO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3637, 8, 114, 309, '700198', 'ICHILO', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3638, 8, 114, 309, '700199', 'CSCI SANTA FE', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3639, 8, 114, 309, '700201', 'BUEN RETIRO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3640, 8, 114, 309, '700203', 'ANTOFAGASTA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3641, 8, 114, 309, '700204', '2 DE AGOSTO ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3642, 8, 114, 309, '700490', 'VILLA IMPERIAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3643, 8, 114, 326, '700207', 'YAPACANI', 5, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3644, 8, 114, 326, '700208', 'EL PALMAR ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3645, 8, 114, 326, '700209', 'SAN GERMAN', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3646, 8, 114, 326, '700211', 'SAN RAFAEL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3647, 8, 114, 326, '700212', 'PTO. GRETHEL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3648, 8, 114, 326, '700213', 'NUEVO HORIZONTE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3649, 8, 114, 326, '700214', 'MOILLER CONDOR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3650, 8, 114, 326, '700215', 'CAMPO VIBORA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3651, 8, 114, 326, '700466', 'CHORE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3652, 8, 114, 326, '700494', 'LOS POZOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3653, 8, 114, 326, '700604', 'PUERTO AVAROA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3654, 8, 114, 326, '700617', 'HOSPITAL YAPACANI', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3655, 8, 114, 313, '700200', 'SAN JUAN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3656, 8, 114, 313, '700202', 'AYACUCHO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3657, 8, 114, 313, '700205', 'H.B. COLONIA SAN JUAN                                                 ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(3658, 8, 114, 313, '700206', 'ENCONADA ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3659, 8, 114, 313, '700465', 'RAUL MENACHO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3660, 8, 114, 313, '700548', 'MARIA AUXILIADORA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3661, 8, 115, 280, '700416', 'SAN MARTIN DE PORRES', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3662, 8, 115, 280, '700417', 'PULQUINA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3663, 8, 115, 280, '700418', 'SAN ISIDRO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3664, 8, 115, 280, '700419', 'SAN JUAN DEL POTRERO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3665, 8, 115, 280, '700420', 'SIBERIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3666, 8, 115, 280, '700421', 'TORRECILLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3667, 8, 115, 280, '700588', 'SAN MATEO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3668, 8, 115, 280, '700689', 'PULQUINA ARRIBA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3669, 8, 115, 280, '700870', 'COMARAPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3670, 8, 115, 280, '700878', 'CIS. CNS. COMARAPA', 3, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3671, 8, 115, 306, '700423', 'CHILON', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3672, 8, 115, 306, '700424', 'SAIPINA', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3673, 8, 117, 293, '700349', 'C.S. CRUZ ROJA(SCZ)                                                   ', 8, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(3674, 8, 117, 293, '700352', 'NARANJAL DON BOSCO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3675, 8, 117, 293, '700353', 'DR. VICTOR HUGO CASSAL BARBA ', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3676, 8, 117, 293, '700354', 'C.S. VILLA COCHABAMBA                                                 ', 8, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(3677, 8, 117, 293, '700356', 'C.N.S. MONTERO                                                   ', 17, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3678, 8, 117, 293, '700357', 'DIVINO NIÑO', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3679, 8, 117, 293, '700358', 'HOSPITAL RENE BALDERAS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3680, 8, 117, 293, '700359', 'HOSPITAL ALFONSO GUMUCIO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3681, 8, 117, 293, '700361', 'C.S. JUANA  AZURDUY DE PADILLA                                          ', 8, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(3682, 8, 117, 293, '700559', 'NAICO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3683, 8, 117, 293, '700560', 'VILLA COPACABANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3684, 8, 117, 293, '700590', 'ERNESTO CHE GUEVARA', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3685, 8, 117, 293, '700591', 'LA SAGRADA FAMILIA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3686, 8, 117, 293, '700614', 'C.S. CAJA CORDES                                                      ', 12, 2, 7, 7, 1, NULL, NULL, NULL, NULL),
(3687, 8, 117, 293, '700619', 'CL. VIDAL                                                             ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(3688, 8, 117, 293, '700659', 'HOSP. BAS. CLINICA SAN ANTONIO                                        ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3689, 8, 117, 293, '700660', 'CLINICA SAN MIGUEL                                      ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3690, 8, 117, 293, '700680', 'CLINICA SAN FRANCISCO DE ASIS                                         ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3691, 8, 117, 293, '700681', 'CLINICA UNIMAX                                                        ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3692, 8, 117, 293, '700682', 'CLINICA MONTERO                                                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3693, 8, 117, 293, '700683', 'CLINICA NORTE                                                         ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3694, 8, 117, 293, '700684', 'CLINICA YARVI                                                         ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3695, 8, 117, 293, '700818', 'POLICONSULTORIO MÉDICO CEDIR', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3696, 8, 117, 293, '700823', 'CLINICA CARDIO SALUD', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(3697, 8, 117, 293, '700824', 'CLINICA LASER ARGERICH', 11, 3, 4, 14, 2, NULL, NULL, NULL, NULL),
(3698, 8, 117, 293, '700838', 'SAN MARTIN DE PORREZ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3699, 8, 117, 293, '700840', 'CLINICA PEDIÁTRICA DIVINO NIÑO', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3700, 8, 117, 293, '700849', 'CENTRO DE REHABILITACIÓN Y HABILITACIÓN BIOPSICOSOCIAL', 2, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(3701, 8, 117, 293, '700861', 'CLINICA CRUZ BLANCA', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3702, 8, 117, 293, '700863', 'CIMFA MONTERO', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3703, 8, 117, 293, '700895', 'P.S. INNOVASALUD S.A. SUC. SOMBRERO DE SAO', 18, 1, 4, 5, 2, NULL, NULL, NULL, NULL),
(3704, 8, 117, 293, '700923', '\"UNIDAD DE HEMODIALISIS \"\"NEPRHOLOGIA SUC. I\"\"\"', 3, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3705, 8, 117, 293, '700926', '\"UNIDAD DE HEMODIALISIS \"\"NEPHROLOGY SUC I\"\"\"', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3706, 8, 117, 293, '700933', 'CLINICA ORELLANA S.R.L.', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(3707, 8, 117, 293, '700945', 'SALUD FEMENINA INTEGRAL (FEM-SALUD)', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3708, 8, 117, 287, '700362', 'AROMA ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3709, 8, 117, 287, '700363', 'POZA CAIMANES', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3710, 8, 117, 287, '700364', 'SAN JUAN DE AMARILLOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3711, 8, 117, 287, '700365', 'PICO DE MONTE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3712, 8, 117, 287, '700366', 'ABELARDO SUAREZ', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3713, 8, 117, 287, '700367', 'CHANE BEDOYA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3714, 8, 117, 287, '700368', 'CRUZ SOLETO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3715, 8, 117, 287, '700557', 'PUENTE CAIMANES', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3716, 8, 117, 287, '700561', 'SAN LORENZO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3717, 8, 117, 287, '700562', '12 DE OCTUBRE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3718, 8, 117, 292, '700369', 'MARIO DAZA CRONENBOLD', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3719, 8, 117, 292, '700380', 'LA PORFIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3720, 8, 117, 292, '700383', 'PUEBLO NUEVO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3721, 8, 117, 292, '700384', 'LITORAL MAROTAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3722, 8, 117, 292, '700558', 'ALIANZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL);
INSERT INTO `establecimiento_salud` (`idestablecimiento_salud`, `iddepartamento`, `idred_salud`, `idmunicipio`, `codigo_establecimiento`, `establecimiento_salud`, `idtipo_establecimiento`, `idnivel_establecimiento`, `idsubsector_salud`, `iddependencia_institucion`, `idambito_local`, `latitud`, `longitud`, `idusuario`, `fecha_registro`) VALUES
(3723, 8, 117, 292, '700581', 'SAN LORENZO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3724, 8, 117, 292, '700809', 'CLINICA LUHAM', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(3725, 8, 117, 344, '700373', 'AGUAHIS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3726, 8, 117, 344, '700379', 'VIRGEN DE FATIMA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3727, 8, 117, 344, '700382', 'CHANE', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3728, 8, 117, 344, '700568', '3 DE MAYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3729, 8, 117, 317, '700370', 'HARDEMAN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3730, 8, 117, 317, '700371', 'SAN PEDRO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3731, 8, 117, 317, '700372', 'SAGRADO CORAZON', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3732, 8, 117, 317, '700374', 'COLONIA PIRAI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3733, 8, 117, 317, '700375', 'LITORAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3734, 8, 117, 317, '700376', 'MURILLO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3735, 8, 117, 317, '700377', 'SAN JOSE DEL NORTE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3736, 8, 117, 317, '700378', 'SAN BERNARDINO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3737, 8, 117, 317, '700381', 'CANANDOA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3738, 8, 117, 317, '700837', 'P.S. PETA GRANDE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3739, 8, 119, 298, '700237', 'SAN IGNACIO DEL SARA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3740, 8, 119, 298, '700238', 'SAN JUAN DE PALOMETILLAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3741, 8, 119, 298, '700239', 'NICOLAS ORTIZ A.', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3742, 8, 119, 298, '700241', 'SAN JOSE OBRERO', 5, 1, 6, 41, 2, NULL, NULL, NULL, NULL),
(3743, 8, 119, 298, '700244', 'CLINICA ECOCEDEM                                         ', 5, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3744, 8, 119, 321, '700245', 'GALILEA ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3745, 8, 119, 321, '700246', 'MELCHOR PINTO PARADA', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3746, 8, 119, 321, '700247', 'RINCON DE PALOMETAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3747, 8, 119, 321, '700248', 'LOMA  ALTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3748, 8, 119, 321, '700249', 'AZUBI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3749, 8, 119, 321, '700250', 'LOS ANDES ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3750, 8, 119, 321, '700251', 'SAN LUIS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3751, 8, 119, 321, '700252', 'RIO NUEVO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3752, 8, 119, 321, '700563', 'LA CUARTA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3753, 8, 119, 321, '700564', 'LAS PAVAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3754, 8, 119, 321, '700574', 'GUADALUPE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3755, 8, 119, 279, '700240', 'SAN SILVESTRE', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3756, 8, 119, 279, '700242', 'C.S. LA BELGICA - CNS                                                 ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3757, 8, 119, 279, '700243', 'EL CEDRO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3758, 8, 120, 324, '700317', 'HOSPITAL SEÑOR DE MALTA', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3759, 8, 120, 324, '700318', 'KJASAMONTES ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3760, 8, 120, 324, '700319', 'MASICURI', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3761, 8, 120, 324, '700320', 'PIRAIMIRI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3762, 8, 120, 324, '700321', 'H.B. C.N.S.VALLEGRANDE                                                ', 12, 2, 7, 10, 1, NULL, NULL, NULL, NULL),
(3763, 8, 120, 324, '700322', 'SAN JUAN DEL CHACO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3764, 8, 120, 324, '700323', 'ALTO SECO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3765, 8, 120, 324, '700483', 'SANTA  ANA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3766, 8, 120, 324, '700793', 'VILLA ESPERANZA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3767, 8, 120, 324, '700794', 'NARANJOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3768, 8, 120, 324, '700795', 'GUADALUPE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3769, 8, 120, 324, '700814', 'P.S.  DURAZNILLO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3770, 8, 120, 324, '700935', 'CLINICA INTEGRAL VALLEGRANDE', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3771, 8, 120, 324, '700936', 'CLINICA ANA ISABEL', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3772, 8, 120, 324, '700942', 'CLINICA SEÑOR DE JESUCRISTO S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3773, 8, 120, 322, '700324', 'EL TRIGAL', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3774, 8, 120, 322, '700325', 'TRIGO PAMPA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3775, 8, 120, 322, '700326', 'COCHABAMBITA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3776, 8, 120, 294, '700328', 'SATIAGO DE MORO MORO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3777, 8, 120, 294, '700329', 'LA LAJA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3778, 8, 120, 299, '700330', 'SAN JUAN DE DIOS POSTRER VALLE', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3779, 8, 120, 299, '700331', 'TIERRAS NUEVAS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3780, 8, 120, 299, '700625', 'MOSQUERA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3781, 8, 120, 300, '700332', 'SAN JUAN DE DIOS PUCARA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3782, 8, 120, 300, '700333', 'LOMA LARGA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3783, 8, 120, 300, '700841', 'P.S. HUERTAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3784, 8, 121, 310, '700163', 'CANDELARIA DE NOZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3785, 8, 121, 310, '700164', 'EL CARMEN DE RUIZ', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3786, 8, 121, 310, '700165', 'ESPIRITU', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3787, 8, 121, 310, '700166', 'SAN BARTOLO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3788, 8, 121, 310, '700167', 'SAN JAVIERITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3789, 8, 121, 310, '700169', 'C.S. C.N.S. SAN IGNACIO                                               ', 8, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3790, 8, 121, 310, '700170', 'SAN MARTIN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3791, 8, 121, 310, '700171', 'SAN NICOLAS CERRITO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3792, 8, 121, 310, '700172', 'SANTA ROSA DE ROCA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3793, 8, 121, 310, '700173', 'SANTA  ANA DE VELASCO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3794, 8, 121, 310, '700174', 'EL CAMPAMENTO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3795, 8, 121, 310, '700175', 'PORVENIR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3796, 8, 121, 310, '700176', 'SAN SIMON', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3797, 8, 121, 310, '700177', 'PISO FIRME', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3798, 8, 121, 310, '700178', 'FLORIDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3799, 8, 121, 310, '700179', 'PALMARITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3800, 8, 121, 310, '700180', 'SAN LORENZITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3801, 8, 121, 310, '700181', 'JULIO MANUEL ARAMAYO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3802, 8, 121, 310, '700182', 'SAN VICENTE(SCZ)', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3803, 8, 121, 310, '700183', 'SAN JUAN DE MACONO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3804, 8, 121, 310, '700598', 'SANTA CLARA DE LA ESTRELLA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3805, 8, 121, 310, '700859', 'SAN FRANCISCO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3806, 8, 121, 310, '700184', 'SALVADOR PILON FLORIAN', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3807, 8, 121, 310, '700185', 'CERRITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3808, 8, 121, 310, '700186', 'SAN JUAN DE LOMERIO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3809, 8, 121, 318, '700187', 'SANTIAGO PARIS', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3810, 8, 121, 318, '700188', 'EL TUNA', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3811, 8, 121, 318, '700860', 'MIRAFLORES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3812, 8, 122, 325, '700146', 'LAS BARRERAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3813, 8, 122, 325, '700147', 'AZUZAQUI', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3814, 8, 122, 325, '700148', 'EL BARRIAL', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3815, 8, 122, 325, '700149', 'OFELIA SANCHEZ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3816, 8, 122, 325, '700150', 'CLARA CHUCHIO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3817, 8, 122, 325, '700151', 'LAS GAMAS', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3818, 8, 122, 325, '700152', 'LOS CHACOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3819, 8, 122, 325, '700153', 'LOS CIERVOS', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3820, 8, 122, 325, '700154', 'NTRA. SRA. ROSARIO', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3821, 8, 122, 325, '700155', 'IGNACIO WARNES', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3822, 8, 122, 325, '700156', 'SAN MARTIN DE PORREZ', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3823, 8, 122, 325, '700157', 'CONSULTORIO FAMILIAR ESTE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3824, 8, 122, 325, '700158', 'VILLA EL CARMEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3825, 8, 122, 325, '700159', 'LA ESPERANZA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3826, 8, 122, 325, '700575', 'SATELITE NORTE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3827, 8, 122, 325, '700576', 'LA REFORMA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3828, 8, 122, 325, '700577', 'LA FINCA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3829, 8, 122, 325, '700578', 'TERRACOR', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3830, 8, 122, 325, '700600', '21 DE SEPTIEMBRE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3831, 8, 122, 325, '700601', 'SAN ANTONIO', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3832, 8, 122, 325, '700652', 'GUAJOJO', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3833, 8, 122, 325, '700653', 'LA MARINA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3834, 8, 122, 325, '700654', 'CHANE JUSTINIANO', 18, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3835, 8, 122, 325, '700677', 'JUAN PABLO II', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3836, 8, 122, 325, '700678', 'PENTAGUAZU', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3837, 8, 122, 325, '700775', 'INTEGRACION DEL NORTE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3838, 8, 122, 325, '700776', 'BUENA  FE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3839, 8, 122, 325, '700828', '24 DE SEPTIEMBRE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3840, 8, 122, 325, '700829', 'CLÍNICA JEHOVÁ RAPHA', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3841, 8, 122, 325, '700842', 'CLÍNICA MESOCRUZ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(3842, 8, 122, 325, '700845', 'CNS WARNES', 5, 1, 7, 10, 1, NULL, NULL, NULL, NULL),
(3843, 8, 122, 325, '700851', 'C.S. PAITITI', 8, 1, 6, 3, 2, NULL, NULL, NULL, NULL),
(3844, 8, 122, 325, '700865', 'CAJA DE SALUD CORDES', 16, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(3845, 8, 122, 325, '700874', 'CLINICA INTEGRACION DEL NORTE', 17, 1, 4, 14, 1, NULL, NULL, NULL, NULL),
(3846, 8, 122, 325, '700904', 'JUAN LATINO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3847, 8, 122, 295, '700160', 'R.P.M.G. OKINAWA', 4, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3848, 8, 122, 295, '700161', 'NUEVO HORIZONTE', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3849, 8, 122, 295, '700162', 'SAN MIGUEL', 3, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3850, 8, 122, 295, '700489', 'H.B. JAPONES                                                          ', 12, 2, 4, 14, 1, NULL, NULL, NULL, NULL),
(3851, 8, 116, 281, '700385', 'CESAR BANZER', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3852, 8, 116, 281, '700467', 'SAN PEDRO ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3853, 8, 116, 281, '700524', 'PALMARITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3854, 8, 116, 281, '700526', 'EL CARMEN', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3855, 8, 116, 281, '700667', 'MAKANATE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3856, 8, 116, 281, '700668', 'CANDELARIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3857, 8, 116, 281, '700765', 'DISTRITO 5 EL PALMAR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3858, 8, 116, 281, '700908', 'SAN SILVESTRE', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3859, 8, 116, 311, '700386', 'HOSPITAL MUNICIPAL SAN JAVIER', 5, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3860, 8, 116, 319, '700387', 'C.S. PARROQUIAL SAN RAMON                                             ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(3861, 8, 116, 319, '700835', 'P.S. SANTA ROSA DE LA  LIMA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3862, 8, 116, 314, '700388', 'C.S. SANTA CLARA                                                      ', 4, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(3863, 8, 116, 314, '700389', 'VILLA PARAISO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3864, 8, 116, 314, '700394', 'NUCLEO 14 NUEVA VIDA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3865, 8, 116, 314, '700395', 'NUCLEO 38 SAN SALVADOR', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3866, 8, 116, 314, '700396', 'ILLIMANI NUCLEO 29', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3867, 8, 116, 314, '700397', 'VILLA ARANCIBIA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3868, 8, 116, 314, '700398', 'NUCLEO 32 EL LIMONAL', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3869, 8, 116, 314, '700399', 'LA  ASUNTA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3870, 8, 116, 314, '700400', 'EL CARMEN', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3871, 8, 116, 314, '700401', 'NUCLEO 23  SAN MARTIN', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3872, 8, 116, 314, '700402', 'AREA 5', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3873, 8, 116, 314, '700403', 'NUCLEO 66 - 2 DE AGOSTO', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3874, 8, 116, 314, '700468', '2 DE AGOSTO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3875, 8, 116, 314, '700470', 'FLOR DEL VALLE', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3876, 8, 116, 314, '700479', 'VILLA VICTORIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3877, 8, 116, 314, '700480', 'NUCLEO 47 EL PALMAR', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3878, 8, 116, 314, '700481', 'VILLA MONTERO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3879, 8, 116, 314, '700482', 'NUEVO AMANECER', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3880, 8, 116, 314, '700521', 'HOSPITAL MUNICIPAL SAN JULIAN', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3881, 8, 116, 314, '700552', 'LIMONCITO', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3882, 8, 116, 314, '700589', 'CAFECES', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3883, 8, 116, 314, '700669', 'CORDILLERA', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3884, 8, 116, 314, '700670', 'LOS TRONCOS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3885, 8, 116, 314, '700796', 'TAJIBO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3886, 8, 116, 314, '700797', 'JOSE MARIA LINAREZ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3887, 8, 116, 314, '700887', 'LOS ANGELES', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3888, 8, 116, 314, '700909', 'SANTO DOMINGO', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3889, 8, 116, 314, '700910', 'SAN JOSE', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3890, 8, 116, 308, '700405', 'PALMIRA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3891, 8, 116, 308, '700406', 'C.S. SAN ANTONIO - LOMERIO                                            ', 8, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(3892, 8, 116, 308, '700407', 'SAN LORENZO SANTA CRUZ', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3893, 8, 116, 308, '700408', 'P.S. SALINAS(SCZ-SAN ANTONIO DE LOMERIO)                              ', 18, 1, 2, 19, 1, NULL, NULL, NULL, NULL),
(3894, 8, 116, 308, '700556', 'PUQUIO CRISTO REY', 18, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3895, 8, 116, 308, '700804', 'P.S. FATIMA', 18, 1, 6, 3, 1, NULL, NULL, NULL, NULL),
(3896, 8, 116, 283, '700390', ' 4 CAÑADAS', 5, 1, 6, 40, 2, NULL, NULL, NULL, NULL),
(3897, 8, 116, 283, '700391', 'C.S. PUERTO RICO - CUATRO CAÑADAS                                     ', 8, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(3898, 8, 116, 283, '700392', 'C.S. NUEVO PALMAR                                                     ', 8, 1, 3, 23, 1, NULL, NULL, NULL, NULL),
(3899, 8, 116, 283, '700473', 'NUEVA ESPERANZA', 3, 1, 6, 21, 2, NULL, NULL, NULL, NULL),
(3900, 8, 116, 283, '700474', 'C.S. 26 DE AGOSTO                                                     ', 8, 1, 3, 27, 1, NULL, NULL, NULL, NULL),
(3901, 8, 116, 283, '700475', 'P.S. MONTE RICO                                                       ', 18, 1, 3, 27, 1, NULL, NULL, NULL, NULL),
(3902, 8, 116, 283, '700476', 'P.S. SAN MIGUEL DE LOS ANGELES                                        ', 18, 1, 3, 27, 1, NULL, NULL, NULL, NULL),
(3903, 8, 116, 283, '700550', 'SAN MIGUEL DE LA FLORIDA', 4, 1, 6, 21, 1, NULL, NULL, NULL, NULL),
(3904, 9, 80, 327, '600062', 'BARREDERO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3905, 9, 80, 327, '600063', 'HOSPITAL VIRGEN DE CHAGUAYA                                             ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(3906, 9, 80, 327, '600064', 'CNS BERMEJO                                                           ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(3907, 9, 80, 327, '600065', 'CORDES BERMEJO                                                        ', 12, 2, 7, 7, 2, NULL, NULL, NULL, NULL),
(3908, 9, 80, 327, '600066', 'CAJA PETROLERA BERMEJO                                                ', 12, 2, 7, 11, 2, NULL, NULL, NULL, NULL),
(3909, 9, 80, 327, '600068', 'CAMPO GRANDE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3910, 9, 80, 327, '600069', 'COLONIA LINARES', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3911, 9, 80, 327, '600070', 'COSSMIL BERMEJO                                                       ', 8, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(3912, 9, 80, 327, '600183', 'NARANJITOS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3913, 9, 80, 327, '600185', 'SAN JOSE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3914, 9, 80, 327, '600186', '21 DE DICIEMBRE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3915, 9, 80, 327, '600187', 'AZUCARERO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3916, 9, 80, 327, '600228', 'CANDADO GRANDE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3917, 9, 80, 327, '600261', 'ARROZALES', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3918, 9, 80, 327, '600262', 'CENTRAL', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3919, 9, 80, 327, '600270', 'PORCELANA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3920, 9, 80, 327, '600274', 'SANTA ROSA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3921, 9, 80, 327, '600280', 'MOTO MENDEZ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3922, 9, 80, 327, '600281', 'SAN ROQUE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(3923, 9, 80, 327, '600283', 'CLINICA BERMEJO                                                       ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(3924, 9, 80, 327, '600343', 'INNOVASALUD S.A. BERMEJO', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(3925, 9, 84, 331, '600041', 'CAMACHO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3926, 9, 84, 331, '600042', 'CANAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3927, 9, 84, 331, '600043', 'CHAGUAYA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3928, 9, 84, 331, '600044', 'EL CARMEN (PAD)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3929, 9, 84, 331, '600045', 'EL LIMAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3930, 9, 84, 331, '600046', 'EMBOROZU', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3931, 9, 84, 331, '600047', 'LA HUERTA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3932, 9, 84, 331, '600048', 'LA MAMORA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3933, 9, 84, 331, '600049', 'LA MERCED', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3934, 9, 84, 331, '600050', 'MECOYA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3935, 9, 84, 331, '600051', 'OROZAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3936, 9, 84, 331, '600052', 'SAN ROQUE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3937, 9, 84, 331, '600053', 'MARANUELOS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3938, 9, 84, 331, '600054', 'RIO NEGRO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3939, 9, 84, 331, '600055', 'PUESTO 27', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3940, 9, 84, 331, '600056', 'REJARA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3941, 9, 84, 331, '600057', 'ROSILLAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3942, 9, 84, 331, '600058', 'EL SALADO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3943, 9, 84, 331, '600059', 'SAN TELMO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3944, 9, 84, 331, '600060', 'TARIQUIA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3945, 9, 84, 331, '600061', 'TREMENTINAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3946, 9, 84, 331, '600203', 'SAN JOSE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3947, 9, 84, 331, '600219', 'QUEBRADA DE CANAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3948, 9, 84, 331, '600220', 'VALLE DORADO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3949, 9, 84, 331, '600221', 'SALADO CONCHAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3950, 9, 84, 331, '600222', 'SAN FRANCISCO PADCAYA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3951, 9, 84, 331, '600267', 'MOTOVI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3952, 9, 84, 331, '600275', 'VOLCAN BLANCO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3953, 9, 87, 334, '600113', 'CALAMUCHITA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3954, 9, 87, 334, '600114', 'CHARAJA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3955, 9, 87, 334, '600115', 'CHOCLOCA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3956, 9, 87, 334, '600116', 'FANOR ROMERO', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3957, 9, 87, 334, '600117', 'JUNTAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3958, 9, 87, 334, '600118', 'COLON SUD (DESDE 4/98)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3959, 9, 87, 334, '600119', 'MISCAS CALDERAS (DESDE5/98)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3960, 9, 87, 334, '600120', 'LA VENTOLERA (DESDE 5/99)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3961, 9, 87, 334, '600264', 'ALIZOS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3962, 9, 87, 334, '600265', 'LADERAS SUD', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3963, 9, 90, 337, '600121', 'HUAYLLAJARA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3964, 9, 90, 337, '600122', 'SANTA BARBARA DE ÑOQUERA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3965, 9, 90, 337, '600123', 'PAPACHACRA FRONTERA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3966, 9, 90, 337, '600124', 'PASAJES', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3967, 9, 90, 337, '600125', 'TOJO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3968, 9, 90, 337, '600126', 'YUNCHARA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3969, 9, 90, 337, '600127', 'BELEN (YUNCHARA)', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3970, 9, 83, 330, '600150', 'CHIQUIACA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3971, 9, 83, 330, '600151', 'HOSPITAL SAN JUAN DE DIOS  ENTRE RIOS', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(3972, 9, 83, 330, '600152', 'LA CUEVA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3973, 9, 83, 330, '600153', 'LAGUNITAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3974, 9, 83, 330, '600154', 'NARVAEZ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3975, 9, 83, 330, '600155', 'ÑAURENDA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3976, 9, 83, 330, '600156', 'PALOS BLANCOS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3977, 9, 83, 330, '600157', 'POTRERILLOS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3978, 9, 83, 330, '600158', 'PUERTO MARGARITA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3979, 9, 83, 330, '600159', 'SALADITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3980, 9, 83, 330, '600160', 'SALINAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3981, 9, 83, 330, '600161', 'SAN DIEGO NORTE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3982, 9, 83, 330, '600162', 'SAN JOSECITO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3983, 9, 83, 330, '600163', 'SERERE SUD', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3984, 9, 83, 330, '600164', 'SUARURO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3985, 9, 83, 330, '600165', 'TARUPAYO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3986, 9, 83, 330, '600166', 'TENTAPIAU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3987, 9, 83, 330, '600167', 'TIMBOY', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3988, 9, 83, 330, '600168', 'VALLE DEL MEDIO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3989, 9, 83, 330, '600169', 'YUATY', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3990, 9, 83, 330, '600170', 'YUQUIMBIA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3991, 9, 83, 330, '600199', 'TABASAY', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3992, 9, 83, 330, '600200', 'TENTAHUAZU', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3993, 9, 83, 330, '600201', 'KUMANDAROTY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3994, 9, 83, 330, '600204', 'PAMPA REDONDA (ENTRE RIOS)', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3995, 9, 83, 330, '600205', 'HUAYCO CENTRO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3996, 9, 83, 330, '600212', 'SIVINGAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3997, 9, 83, 330, '600213', 'VALLECITO LOS LAPACHOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3998, 9, 83, 330, '600223', 'IBOPEITY ENTRE RIOS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(3999, 9, 86, 333, '600001', 'ALTO ESPAÑA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4000, 9, 86, 333, '600002', '15 DE NOVIEMBRE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4001, 9, 86, 333, '600003', 'JUNACAS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4002, 9, 86, 333, '600004', 'LA PINTADA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4003, 9, 86, 333, '600005', 'PAMPA REDONDA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4004, 9, 86, 333, '600006', 'PINOS SUD', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4005, 9, 86, 333, '600007', 'SAN BLASS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4006, 9, 86, 333, '600008', 'SAN ANDRES', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4007, 9, 86, 333, '600009', 'SANTA ANA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4008, 9, 86, 333, '600010', 'SELLA - CERCADO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4009, 9, 86, 333, '600011', 'CLINICA PROSALUD TABLADITA                                            ', 12, 2, 3, 26, 2, NULL, NULL, NULL, NULL),
(4010, 9, 86, 333, '600013', 'EDUARDO ABAROA', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4011, 9, 86, 333, '600014', 'PALMARCITO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4012, 9, 86, 333, '600015', 'TABLADITA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4013, 9, 86, 333, '600016', 'GUADALQUIVIR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4014, 9, 86, 333, '600017', 'SAN LUIS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4015, 9, 86, 333, '600018', 'SAN JORGE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4016, 9, 86, 333, '600019', 'GERMAN BUSH', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4017, 9, 86, 333, '600020', 'HOSPITAL OBRERO Nª 7 CNS                         ', 11, 3, 7, 10, 2, NULL, NULL, NULL, NULL),
(4018, 9, 86, 333, '600021', 'CAJA PETROLERA TARIJA                                                 ', 8, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(4019, 9, 86, 333, '600022', 'SEGURO UNIVERSITARIO - TARIJA                                         ', 8, 1, 7, 37, 2, NULL, NULL, NULL, NULL),
(4020, 9, 86, 333, '600024', 'PROSALUD EL MOLINO                                                    ', 8, 1, 3, 26, 2, NULL, NULL, NULL, NULL),
(4021, 9, 86, 333, '600025', 'HOSPITAL REGIONAL SAN JUAN DE DIOS              ', 11, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(4022, 9, 86, 333, '600026', 'POLICLINICO VARAS CASTRILLO                                           ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4023, 9, 86, 333, '600027', 'SEDES - EPIDEMIOLOGIA                                                 ', 2, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4024, 9, 86, 333, '600028', 'INTRAID - COPRE                                                       ', 14, 3, 6, 17, 2, NULL, NULL, NULL, NULL),
(4025, 9, 86, 333, '600029', 'CLINICA CIES TARIJA                                                     ', 12, 2, 3, 4, 2, NULL, NULL, NULL, NULL),
(4026, 9, 86, 333, '600030', 'NESTOR PAZ ZAMORA', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4027, 9, 86, 333, '600032', 'COSSMIL TARIJA                                                        ', 12, 2, 7, 13, 2, NULL, NULL, NULL, NULL),
(4028, 9, 86, 333, '600033', 'CAJA DE SALUD DE LA BANCA PRIVADA -TARIJA                            ', 17, 1, 7, 9, 2, NULL, NULL, NULL, NULL),
(4029, 9, 86, 333, '600036', 'TOLOMOSA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4030, 9, 86, 333, '600037', 'CRUZ ROJA BOLIVIANA                                                   ', 8, 1, 3, 23, 2, NULL, NULL, NULL, NULL),
(4031, 9, 86, 333, '600038', 'YESERA NORTE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4032, 9, 86, 333, '600039', 'SEGURO DE CAMINOS - TJA                                               ', 8, 1, 7, 8, 2, NULL, NULL, NULL, NULL),
(4033, 9, 86, 333, '600040', 'CAJA CORDES TARIJA                                                    ', 12, 2, 7, 7, 2, NULL, NULL, NULL, NULL),
(4034, 9, 86, 333, '600171', 'CLINICA  NUESTRA SEÑORA DE LUCIA                                        ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4035, 9, 86, 333, '600172', 'PAPACHACRA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4036, 9, 86, 333, '600202', 'INSTITUTO CARDIOVASCULAR                                              ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4037, 9, 86, 333, '600216', 'SAN PABLO                                                        ', 8, 1, 2, 19, 2, NULL, NULL, NULL, NULL),
(4038, 9, 86, 333, '600226', 'CLINICA SANTISIMA TRINIDAD                                            ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4039, 9, 86, 333, '600229', 'ARANJUEZ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4040, 9, 86, 333, '600230', 'GAMONEDA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4041, 9, 86, 333, '600231', 'CIENEGUILLAS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4042, 9, 86, 333, '600236', 'SAO  PAOLO CLINICA DE CIRUGIA  PLASTICA                      ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4043, 9, 86, 333, '600237', 'BRIGADA MOVIL DE SALUD MUNICIPAL                                      ', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4044, 9, 86, 333, '600238', 'POLICONSULTORIO  VIRGEN  DE  COPACABANA                          ', 8, 1, 5, 24, 2, NULL, NULL, NULL, NULL),
(4045, 9, 86, 333, '600239', 'IV CENTENARIO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4046, 9, 86, 333, '600241', 'CONSULTORIO NIÑOS JESUS DE PRAGA                                  ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4047, 9, 86, 333, '600242', 'FACULTAD DE ODONTOLOGIA UAJMS', 2, 1, 6, 42, 2, NULL, NULL, NULL, NULL),
(4048, 9, 86, 333, '600243', 'PLATAFORMA CHAGAS U.A.J.M.S', 2, 1, 6, 42, 2, NULL, NULL, NULL, NULL),
(4049, 9, 86, 333, '600249', '3 DE MAYO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4050, 9, 86, 333, '600263', 'EL CONSTRUCTOR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4051, 9, 86, 333, '600268', 'POLICONSULTORIO LA FAMILIA DE DIOS                               ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4052, 9, 86, 333, '600279', 'ESCULAPIO   CLINICA DE CIRUGIA PLASTICA                             ', 8, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4053, 9, 86, 333, '600284', 'VIRGEN DE GUADALUPE', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4054, 9, 86, 333, '600286', 'GUERRAHUAYCO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4055, 9, 86, 333, '600289', 'POLICONSULTORIO DR RAUL HENRY MERCADO V.', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4056, 9, 86, 333, '600290', 'CIMFA 15 DE ABRIL - CNS', 17, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(4057, 9, 86, 333, '600291', 'CENTRO MUNICIPAL DE HEMODIALISIS SAN ANDRES', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4058, 9, 86, 333, '600293', 'CLINICA YAPUR', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4059, 9, 86, 333, '600296', 'UNIDAD DE HEMODIALISIS CLINICA YAPUR', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4060, 9, 86, 333, '600306', 'CIMFA LOURDES CNS', 3, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(4061, 9, 86, 333, '600327', 'HOSPITAL SAN ANTONIO', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(4062, 9, 86, 333, '600329', 'CAJA BANCARIA ESTATAL DE SALUD - TARIJA', 5, 1, 7, 6, 2, NULL, NULL, NULL, NULL),
(4063, 9, 86, 333, '600330', 'CENTRO COORDINADOR DE EMERGENCIAS EN SALUD - TARIJA', 6, 6, 6, 21, 2, NULL, NULL, NULL, NULL),
(4064, 9, 86, 333, '600331', 'CLINICA DE PROSTACHECK', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4065, 9, 86, 333, '600332', 'CLINICA DE OJOS DR. AGUIRRE PEREZ', 5, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4066, 9, 86, 333, '600335', 'BANCO DE SANGRE DE REFERENCIA DPTAL .TARIJA', 1, 4, 6, 3, 2, NULL, NULL, NULL, NULL),
(4067, 9, 86, 333, '600337', 'INNOVASALUD S.A.PANAMERICANO', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4068, 9, 86, 333, '600338', 'INNOVASALUD S.A. PALMARCITO', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4069, 9, 86, 333, '600340', 'CLINICA VITALMEDIC S.R.L.', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4070, 9, 86, 333, '600342', 'CENTRO MEDICO SAN ROQUE', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4071, 9, 86, 333, '600344', 'SANTA MARIA', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4072, 9, 86, 333, '600345', 'SAN BERNARDO', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4073, 9, 86, 333, '600346', 'VICEMS SERVICIO MEDICO POR ESPECIALIDAD', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4074, 9, 86, 333, '600347', 'C. MEDICO SAN MARTIN MEDICAL R.M.R', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4075, 9, 86, 333, '600348', 'POLICLINICO LAS AMERICAS', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4076, 9, 86, 333, '600349', 'MEDICINARTE', 2, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4077, 9, 81, 328, '600086', 'AGUA BLANCA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4078, 9, 81, 328, '600087', 'BERETY CHACO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4079, 9, 81, 328, '600088', 'VIRGEN DE GUADALUPE', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4080, 9, 81, 328, '600089', 'INIGUAZU', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4081, 9, 81, 328, '600090', 'ITAPERENDA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4082, 9, 81, 328, '600091', 'ITAU', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4083, 9, 81, 328, '600092', 'SALADILLO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4084, 9, 81, 328, '600093', 'ZAPATERA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4085, 9, 81, 328, '600094', 'LAS SIDRAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4086, 9, 81, 328, '600189', 'CAMPO LARGO HITO 22', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4087, 9, 81, 328, '600192', 'SAN ALBERTO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4088, 9, 81, 328, '600193', 'SAN NICOLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4089, 9, 81, 328, '600244', 'LA CENTRAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4090, 9, 81, 328, '600245', 'CANITAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4091, 9, 81, 328, '600246', 'LOMA ALTA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4092, 9, 81, 328, '600247', 'CAMPO LARGO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4093, 9, 81, 328, '600248', 'CANAVERAL', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4094, 9, 81, 328, '600273', 'CAJA  NACIONAL DE SALUD  CARAPARI                                    ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(4095, 9, 88, 335, '600095', 'CAIGUA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4096, 9, 88, 335, '600096', 'CAPIRENDITA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4097, 9, 88, 335, '600097', 'CHIMEO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4098, 9, 88, 335, '600098', 'CUTAIQUI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4099, 9, 88, 335, '600099', 'IBIBOBO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4100, 9, 88, 335, '600100', 'VIRGEN DE LOS REMEDIOS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4101, 9, 88, 335, '600101', 'LA MISION', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4102, 9, 88, 335, '600102', 'VICTORIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4103, 9, 88, 335, '600103', 'LOS GALPONES', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4104, 9, 88, 335, '600104', 'PALMAR GRANDE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4105, 9, 88, 335, '600105', 'PUESTO GARCIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4106, 9, 88, 335, '600106', 'RESISTENCIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4107, 9, 88, 335, '600107', 'SAN ANTONIO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4108, 9, 88, 335, '600108', 'TAHIGUATY', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4109, 9, 88, 335, '600109', 'TARAIRI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4110, 9, 88, 335, '600110', 'HOSPITAL VILLA MONTES', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(4111, 9, 88, 335, '600111', 'CNS VILLA MONTES                                                      ', 8, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(4112, 9, 88, 335, '600112', 'CAJA PETROLERA VILLA MONTES                                           ', 8, 1, 7, 11, 2, NULL, NULL, NULL, NULL),
(4113, 9, 88, 335, '600174', 'COSSMIL VILLA MONTES                                                  ', 8, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(4114, 9, 88, 335, '600175', 'IPA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4115, 9, 88, 335, '600194', 'CAPITAN USTAREZ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4116, 9, 88, 335, '600195', 'IBOPEITY ( VILLA MONTES)', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4117, 9, 88, 335, '600227', 'SAN JUAN DE DIOS VILLA MONTES', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4118, 9, 88, 335, '600240', 'TIGUIPA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4119, 9, 88, 335, '600256', 'TREZ POZOS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4120, 9, 88, 335, '600257', 'ALGARROBAL', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4121, 9, 88, 335, '600258', 'ESMERALDA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4122, 9, 88, 335, '600295', 'VIRGEN MARIA', 4, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4123, 9, 88, 335, '600297', 'CLINICA RENACER ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4124, 9, 88, 335, '600339', 'CAJA DE SALUD CORDES DISTRITAL VILLAMONTES', 5, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(4125, 9, 89, 336, '600071', 'CAIZA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4126, 9, 89, 336, '600073', 'CREVAUX', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4127, 9, 89, 336, '600074', 'EL PALMAR', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4128, 9, 89, 336, '600075', 'POCITOS', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4129, 9, 89, 336, '600076', 'HOSPITAL DOCTOR RUBEN ZELAYA ', 12, 2, 6, 18, 2, NULL, NULL, NULL, NULL),
(4130, 9, 89, 336, '600077', 'CNS YACUIBA                                                           ', 12, 2, 7, 10, 2, NULL, NULL, NULL, NULL),
(4131, 9, 89, 336, '600078', 'CAJA PETROLERA YACUIBA                                                ', 12, 2, 7, 11, 2, NULL, NULL, NULL, NULL),
(4132, 9, 89, 336, '600079', 'COSSMIL  YACUIBA                                                      ', 8, 1, 7, 13, 2, NULL, NULL, NULL, NULL),
(4133, 9, 89, 336, '600082', 'SACHAPERA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4134, 9, 89, 336, '600083', 'YAGUACUA', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4135, 9, 89, 336, '600084', 'CLINICA SAN ROQUE                                                     ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4136, 9, 89, 336, '600176', 'SANANDITA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4137, 9, 89, 336, '600177', 'TIMBOY', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4138, 9, 89, 336, '600178', 'CAMPO PAJOSO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4139, 9, 89, 336, '600180', 'CLINICA MONSERRAT                                                     ', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4140, 9, 89, 336, '600206', 'EL JARDIN', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4141, 9, 89, 336, '600207', 'EL PORVENIR', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4142, 9, 89, 336, '600208', 'EL PRADO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4143, 9, 89, 336, '600209', 'LAS DELICIAS', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4144, 9, 89, 336, '600214', 'BARRIO NUEVO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4145, 9, 89, 336, '600232', 'SAN JERONIMO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4146, 9, 89, 336, '600233', 'SAN JOSE OBRERO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4147, 9, 89, 336, '600234', 'CAMPO GRANDE', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4148, 9, 89, 336, '600250', 'PALMAR GRANDE YACUIBA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4149, 9, 89, 336, '600251', 'SUNCHAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4150, 9, 89, 336, '600252', 'DORBIGNY', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4151, 9, 89, 336, '600253', 'EL BAGUAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4152, 9, 89, 336, '600254', 'SAN PEDRO', 3, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4153, 9, 89, 336, '600287', 'VILLA EL CARMEN', 5, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4154, 9, 89, 336, '600288', 'TIERRAS NUEVAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4155, 9, 89, 336, '600298', 'CLÍNICA LABOSUR', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4156, 9, 89, 336, '600299', 'CLÍNICA LAZARETO', 12, 2, 4, 14, 2, NULL, NULL, NULL, NULL),
(4157, 9, 89, 336, '600300', 'CLINICA CRUZ DEL SUR', 4, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4158, 9, 89, 336, '600301', 'LA GRAMPA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4159, 9, 89, 336, '600302', 'SAN ISIDRO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4160, 9, 89, 336, '600307', 'COSSMIL SANANDITA', 17, 1, 7, 13, 1, NULL, NULL, NULL, NULL),
(4161, 9, 89, 336, '600308', 'FRAY QUEBRACHO', 12, 2, 6, 3, 2, NULL, NULL, NULL, NULL),
(4162, 9, 89, 336, '600333', 'CIMFA Nª42', 16, 1, 7, 10, 2, NULL, NULL, NULL, NULL),
(4163, 9, 89, 336, '600334', 'CAJA DE SALUD CORDES DISTRITAL YACUIBA ', 3, 1, 7, 7, 2, NULL, NULL, NULL, NULL),
(4164, 9, 89, 336, '600341', 'POLICONSULTORIO MORUNO', 17, 1, 4, 14, 2, NULL, NULL, NULL, NULL),
(4165, 9, 82, 329, '600142', 'CARRIZAL', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4166, 9, 82, 329, '600143', 'CURQUI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4167, 9, 82, 329, '600144', 'EL PUENTE', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4168, 9, 82, 329, '600145', 'PAICHO SUD', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4169, 9, 82, 329, '600146', 'VIRGEN DE CHAGUAYA DE ISCAYACHI', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4170, 9, 82, 329, '600147', 'PAICHO CENTRO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4171, 9, 82, 329, '600148', 'SANTA ANA DE BELEN', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4172, 9, 82, 329, '600149', 'TOMAYAPO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4173, 9, 82, 329, '600181', 'CHORCOYA MENDEZ', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4174, 9, 82, 329, '600191', 'SAN FRANCISCO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4175, 9, 82, 329, '600259', 'HUARMACHI', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4176, 9, 82, 329, '600294', 'SAN LORENCITO', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4177, 9, 85, 332, '600128', 'CAMARON', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4178, 9, 85, 332, '600129', 'CANASMORO', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4179, 9, 85, 332, '600130', 'CARACHIMAYO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4180, 9, 85, 332, '600131', 'ALAYPATA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4181, 9, 85, 332, '600132', 'JARCAS', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4182, 9, 85, 332, '600133', 'LA VITORIA', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4183, 9, 85, 332, '600134', 'LEON CANCHA', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4184, 9, 85, 332, '600135', 'SAN LORENZO', 5, 1, 6, 18, 2, NULL, NULL, NULL, NULL),
(4185, 9, 85, 332, '600136', 'SAN PEDRO DE LAS PEÑAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4186, 9, 85, 332, '600137', 'SELLA MENDEZ', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4187, 9, 85, 332, '600138', 'TOMATITAS', 4, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4188, 9, 85, 332, '600139', 'ZAPATERA (SAN LORENZO)', 3, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4189, 9, 85, 332, '600140', 'COCHAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4190, 9, 85, 332, '600141', 'QUIRUSILLAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4191, 9, 85, 332, '600210', 'PAMPA GRANDE', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4192, 9, 85, 332, '600211', 'ERQUIS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4193, 9, 85, 332, '600269', 'COIMATA', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4194, 9, 85, 332, '600304', 'LAJAS', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4195, 9, 85, 332, '600305', 'PAJONALCITO', 18, 1, 6, 18, 1, NULL, NULL, NULL, NULL),
(4196, 4, 123, 137, ' ', 'OFICINA NACIONAL PROGRAMA SAFCI - MI SALUD', 5, 1, 6, 21, 1, '-16.512539', '-68.132341', 1, '2023-09-26'),
(4197, 4, 124, 127, '', 'OFICINA DEPARTAMENTAL - LA PAZ', 8, 1, 6, 21, 2, '-16.511305', '-68.133952', 1, '2023-09-20'),
(4198, 1, 125, 19, '', 'OFICINA COORDINACIÓN DEPARTAMENTAL - BENI', 8, 1, 6, 21, 2, '-16.511313', '-68.134007', 1, '2023-09-20'),
(4199, 2, 126, 30, '', 'OFICINA COORDINACIÓN DEPARTAMENTAL - COCHABAMBA', 8, 1, 6, 21, 2, '-16.511305', '-68.133952', 1, '2023-09-20'),
(4200, 3, 127, 83, NULL, 'OFICINA COORDINACIÓN DEPARTAMENTAL - CHUQUISACA', 8, 1, 6, 21, 2, NULL, NULL, 1, '2023-10-06'),
(4201, 5, 128, 200, NULL, 'OFICINA COORDINACIÓN - ORURO', 8, 1, 6, 21, 2, NULL, NULL, 1, '2023-10-06'),
(4202, 6, 129, 219, NULL, 'OFICINA COORDINACIÓN DEPARTAMENTAL - PANDO', 8, 1, 6, 21, 2, NULL, NULL, 1, '2023-10-06'),
(4203, 7, 130, 249, NULL, 'OFICINA COORDINACIÓN DEPARTAMENTAL - POTOSÍ', 8, 1, 6, 21, 2, NULL, NULL, 1, '2023-10-06'),
(4204, 8, 131, 320, NULL, 'OFICINA COORDINACIÓN DEPARTAMENTAL - SANTA CRUZ', 8, 1, 6, 21, 2, NULL, NULL, 1, '2023-10-06'),
(4205, 9, 132, 333, NULL, 'OFICINA COORDINACIÓN DEPARTAMENTAL - TARIJA', 8, 1, 6, 21, 2, NULL, NULL, 1, '2023-10-06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_docente`
--

CREATE TABLE `estado_docente` (
  `idestado_docente` int(11) NOT NULL,
  `estado_docente` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_docente`
--

INSERT INTO `estado_docente` (`idestado_docente`, `estado_docente`) VALUES
(1, 'REGISTRADO'),
(2, 'HABILITADO'),
(3, 'INHABILITADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_ejecucion`
--

CREATE TABLE `estado_ejecucion` (
  `idestado_ejecucion` int(11) NOT NULL,
  `estado_ejecucion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_ejecucion`
--

INSERT INTO `estado_ejecucion` (`idestado_ejecucion`, `estado_ejecucion`) VALUES
(1, 'PROGRAMADO'),
(2, 'EN EJECUCION'),
(3, 'EN EVALUACION'),
(4, 'CONCLUIDO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_establecimiento`
--

CREATE TABLE `estado_establecimiento` (
  `idestado_establecimiento` int(11) NOT NULL,
  `estado_establecimiento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_establecimiento`
--

INSERT INTO `estado_establecimiento` (`idestado_establecimiento`, `estado_establecimiento`) VALUES
(1, 'EN FUNCIONAMIENTO'),
(2, 'CERRADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_evaluacion`
--

CREATE TABLE `estado_evaluacion` (
  `idestado_evaluacion` int(11) NOT NULL,
  `estado_evaluacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_evaluacion`
--

INSERT INTO `estado_evaluacion` (`idestado_evaluacion`, `estado_evaluacion`) VALUES
(1, 'SIN EVALUAR'),
(2, 'EVALUADO'),
(3, 'CON CERTIFICACION');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_inscripcion`
--

CREATE TABLE `estado_inscripcion` (
  `idestado_inscripcion` int(11) NOT NULL,
  `estado_inscripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_inscripcion`
--

INSERT INTO `estado_inscripcion` (`idestado_inscripcion`, `estado_inscripcion`) VALUES
(1, 'PREINSCRITO'),
(2, 'INSCRITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_personal`
--

CREATE TABLE `estado_personal` (
  `idestado_personal` int(11) NOT NULL,
  `estado_personal` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_personal`
--

INSERT INTO `estado_personal` (`idestado_personal`, `estado_personal`) VALUES
(1, 'REGISTRADO'),
(2, 'EN EJERCICIO DE FUNCIONES'),
(3, 'FUERA DE FUNCIONES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_registro`
--

CREATE TABLE `estado_registro` (
  `idestado_registro` int(11) NOT NULL,
  `estado_registro` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `estado_registro`
--

INSERT INTO `estado_registro` (`idestado_registro`, `estado_registro`) VALUES
(1, 'REGISTRADO'),
(2, 'CONSOLIDADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eval_docente`
--

CREATE TABLE `eval_docente` (
  `ideval_docente` int(11) NOT NULL,
  `iddocente` int(11) DEFAULT NULL,
  `idevento` int(11) DEFAULT NULL,
  `idponderacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento`
--

CREATE TABLE `evento` (
  `idevento` int(11) NOT NULL,
  `idobjetivo_anual` int(11) DEFAULT NULL,
  `idmacrocurricula` int(11) DEFAULT NULL,
  `idmicrocurricula` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `gestion` varchar(45) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL,
  `idprovincia` int(11) DEFAULT NULL,
  `idmunicipio` int(11) DEFAULT NULL,
  `idpublicacion` int(11) DEFAULT NULL,
  `idmodalidad` int(11) DEFAULT NULL,
  `cupo_min` int(11) DEFAULT NULL,
  `cupo_max` int(11) DEFAULT NULL,
  `iddocente` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idestado_registro` int(11) DEFAULT NULL,
  `idestado_ejecucion` int(11) DEFAULT NULL,
  `idtipo_inscripcion` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `evento`
--

INSERT INTO `evento` (`idevento`, `idobjetivo_anual`, `idmacrocurricula`, `idmicrocurricula`, `codigo`, `correlativo`, `gestion`, `fecha_inicio`, `fecha_fin`, `iddepartamento`, `idprovincia`, `idmunicipio`, `idpublicacion`, `idmodalidad`, `cupo_min`, `cupo_max`, `iddocente`, `idusuario`, `idestado_registro`, `idestado_ejecucion`, `idtipo_inscripcion`, `fecha_registro`) VALUES
(1, 1, 1, 1, 'MSYD/LP-1/2023', 1, '2023', '2023-08-28', '2023-09-17', 4, 52, 137, 1, 2, 10, 30, 4, 1, 2, 4, 1, '2023-08-23'),
(2, 1, 5, 4, 'MSYD/LP-2/2023', 2, '2023', '2023-08-21', '2023-08-24', 4, 52, 137, 1, 2, 10, 30, 2, 1, 2, 1, 2, '2023-08-23'),
(3, 1, 1, 1, 'MSYD/LP-3/2023', 3, '2023', '2023-08-28', '2023-09-03', 4, 52, 137, 1, 2, 10, 30, 1, 1, 2, 1, 1, '2023-08-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formacion_academica`
--

CREATE TABLE `formacion_academica` (
  `idformacion_academica` int(11) NOT NULL,
  `formacion_academica` varchar(45) DEFAULT NULL,
  `etapa_academica` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `formacion_academica`
--

INSERT INTO `formacion_academica` (`idformacion_academica`, `formacion_academica`, `etapa_academica`) VALUES
(1, 'BACHILLER', 'GRADO'),
(2, 'TÉCNICO MEDIO', 'GRADO'),
(3, 'TÉCNICO SUPERIOR', 'GRADO'),
(4, 'LICENCIATURA', 'GRADO'),
(5, 'DIPLOMADO', 'POSGRADO'),
(6, 'ESPECIALIDAD', 'POSGRADO'),
(7, 'MAESTRIA', 'GRADO'),
(8, 'DOCTORADO', 'GRADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `idgenero` int(11) NOT NULL,
  `genero` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`idgenero`, `genero`) VALUES
(1, 'FEMENINO'),
(2, 'MASCULINO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `idhorario` int(11) NOT NULL,
  `idevento` int(11) NOT NULL,
  `idaula` int(11) NOT NULL,
  `inicio` date NOT NULL,
  `fin` date NOT NULL,
  `hora_i` varchar(45) NOT NULL,
  `hora_f` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`idhorario`, `idevento`, `idaula`, `inicio`, `fin`, `hora_i`, `hora_f`) VALUES
(1, 1, 1, '2023-08-28', '2023-09-14', '19:00', '20:30'),
(2, 1, 1, '2023-09-15', '2023-09-17', '19:00', '20:00'),
(3, 2, 1, '2023-08-21', '2023-08-24', '18:30', '20:00'),
(4, 3, 1, '2023-08-28', '2023-09-03', '19:00', '20:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripcion`
--

CREATE TABLE `inscripcion` (
  `idinscripcion` int(11) NOT NULL,
  `idevento` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `idnombre_datos` int(11) DEFAULT NULL,
  `iddato_laboral` int(11) DEFAULT NULL,
  `idestado_inscripcion` int(11) DEFAULT NULL,
  `idestado_evaluacion` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `fecha_preins` date DEFAULT NULL,
  `fecha_ins` date DEFAULT NULL,
  `gestion` varchar(45) DEFAULT NULL,
  `nota_final` int(11) DEFAULT NULL,
  `idcomentario_evaluacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inscripcion`
--

INSERT INTO `inscripcion` (`idinscripcion`, `idevento`, `idusuario`, `idnombre`, `idnombre_datos`, `iddato_laboral`, `idestado_inscripcion`, `idestado_evaluacion`, `correlativo`, `codigo`, `fecha_preins`, `fecha_ins`, `gestion`, `nota_final`, `idcomentario_evaluacion`) VALUES
(1, 1, 5, 4, 4, 4, 1, 1, 1, 'INS/MDSYD-1/2023', '2023-08-09', '2023-08-09', '2023', NULL, 1),
(2, 1, 6, 5, 5, 5, 1, 1, 2, 'INS/MDSYD-2/2023', '2023-08-09', '2023-08-09', '2023', NULL, 1),
(3, 1, 7, 6, 6, 6, 2, 1, 3, 'INS/MDSYD-3/2023', '2023-08-09', '2023-08-09', '2023', 85, 4),
(4, 1, 1, 1, 1, 1, 1, 1, 4, 'INS/MDSYD-4/2023', '2023-08-09', '2023-08-09', '2023', NULL, NULL),
(5, 1, 8, 7, 7, 7, 2, 1, 5, 'INS/MDSYD-5/2023', '2023-08-09', '2023-08-09', '2023', NULL, 1),
(6, 2, 10, 8, 8, 8, 2, 1, 6, 'INS/MSYD-6/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(7, 2, 1, 1, 1, 1, 2, 1, 7, 'INS/MSYD-7/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(8, 2, 11, 9, 11, 9, 2, 1, 8, 'INS/MSYD-8/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(9, 2, 12, 10, 9, 10, 2, 1, 9, 'INS/MSYD-9/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(10, 1, 13, 11, 10, 11, 2, 1, 10, 'INS/MSYD-10/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(11, 2, 15, 13, 12, 13, 2, 1, 11, 'INS/MSYD-11/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(12, 2, 16, 14, 13, 14, 2, 1, 12, 'INS/MSYD-12/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(13, 2, 17, 15, 14, 15, 2, 1, 13, 'INS/MSYD-13/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(14, 2, 15, 13, 12, 13, 2, 1, 14, 'INS/MSYD-14/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(15, 1, 18, 16, 15, 16, 2, 1, 15, 'INS/MSYD-15/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(16, 2, 19, 17, 16, 17, 2, 1, 16, 'INS/MSYD-16/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(17, 2, 20, 18, 17, 18, 2, 1, 17, 'INS/MSYD-17/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(18, 2, 19, 17, 16, 17, 2, 1, 18, 'INS/MSYD-18/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(19, 2, 19, 17, 16, 17, 2, 1, 19, 'INS/MSYD-19/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(20, 1, 17, 15, 14, 15, 2, 1, 20, 'INS/MSYD-20/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(21, 2, 21, 19, 19, 19, 2, 1, 21, 'INS/MSYD-21/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(22, 2, 22, 20, 20, 20, 2, 1, 22, 'INS/MSYD-22/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(23, 2, 23, 21, 21, 21, 2, 1, 23, 'INS/MSYD-23/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(24, 2, 24, 22, 22, 22, 2, 1, 24, 'INS/MSYD-24/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(25, 1, 25, 23, 23, 23, 2, 1, 25, 'INS/MSYD-25/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(26, 2, 24, 22, 22, 22, 2, 1, 26, 'INS/MSYD-26/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(27, 2, 24, 22, 22, 22, 2, 1, 27, 'INS/MSYD-27/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(28, 2, 26, 24, 24, 24, 2, 1, 28, 'INS/MSYD-28/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(29, 2, 27, 25, 25, 25, 2, 1, 29, 'INS/MSYD-29/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(30, 2, 28, 26, 26, 26, 2, 1, 30, 'INS/MSYD-30/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(31, 2, 29, 27, 29, 27, 2, 1, 31, 'INS/MSYD-31/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(32, 2, 30, 0, 27, 28, 2, 1, 32, 'INS/MSYD-32/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(33, 2, 31, 28, 28, 29, 2, 1, 33, 'INS/MSYD-33/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(34, 2, 12, 10, 9, 10, 2, 1, 34, 'INS/MSYD-34/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(35, 2, 32, 29, 29, 30, 2, 1, 35, 'INS/MSYD-35/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(36, 2, 25, 23, 23, 23, 2, 1, 36, 'INS/MSYD-36/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(37, 3, 33, 30, 30, 32, 2, 1, 37, 'INS/MSYD-37/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(38, 2, 34, 31, 31, 33, 2, 1, 38, 'INS/MSYD-38/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(39, 2, 34, 31, 31, 33, 2, 1, 39, 'INS/MSYD-39/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(40, 2, 34, 31, 31, 33, 2, 1, 40, 'INS/MSYD-40/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(41, 2, 34, 31, 31, 33, 1, 1, 41, 'INS/MSYD-41/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(42, 2, 34, 31, 31, 33, 1, 1, 42, 'INS/MSYD-42/2023', '2023-08-23', '2023-08-23', '2023', 0, 1),
(43, 2, 35, 32, 32, 34, 2, 1, 43, 'INS/MSYD-43/2023', '2023-08-24', '2023-08-24', '2023', 0, 1),
(44, 3, 35, 32, 32, 34, 2, 1, 44, 'INS/MSYD-44/2023', '2023-08-24', '2023-08-24', '2023', 0, 1),
(45, 3, 34, 31, 31, 33, 2, 1, 45, 'INS/MSYD-45/2023', '2023-08-24', '2023-08-24', '2023', 0, 1),
(46, 3, 34, 31, 31, 33, 1, 1, 46, 'INS/MSYD-46/2023', '2023-08-24', '2023-08-24', '2023', 0, 1),
(47, 2, 36, 33, 33, 35, 2, 1, 47, 'INS/MSYD-47/2023', '2023-08-24', '2023-08-24', '2023', 0, 1),
(48, 1, 36, 33, 33, 35, 1, 1, 48, 'INS/MSYD-48/2023', '2023-08-24', '2023-08-24', '2023', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_login`
--

CREATE TABLE `log_login` (
  `idlog_login` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `ip` varchar(45) NOT NULL,
  `condicion` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `log_login`
--

INSERT INTO `log_login` (`idlog_login`, `usuario`, `fecha`, `fecha_hora`, `ip`, `condicion`) VALUES
(1, 'lyapuchura', '2023-08-04', '2023-08-04 18:31:39', '10.9.1.30', 'OPEN'),
(2, 'lyapuchura-P', '2023-08-04', '2023-08-04 18:37:51', '10.9.1.30', 'OPEN'),
(3, 'lyapuchura', '2023-08-04', '2023-08-04 18:40:38', '10.9.1.30', 'OPEN'),
(4, 'lyapuchura', '2023-08-09', '2023-08-09 10:54:34', '10.9.1.25', 'OPEN'),
(5, '6103812', '2023-08-09', '2023-08-09 11:34:20', '10.9.1.25', 'OPEN'),
(6, 'lyapuchura', '2023-08-09', '2023-08-09 11:34:42', '10.9.1.25', 'OPEN'),
(7, 'lyapuchura', '2023-08-09', '2023-08-09 11:36:28', '10.9.1.25', 'OPEN'),
(8, 'lyapuchura', '2023-08-09', '2023-08-09 12:18:26', '10.9.1.25', 'OPEN'),
(9, 'lyapuchura', '2023-08-09', '2023-08-09 12:27:27', '10.9.1.25', 'OPEN'),
(10, 'lyapuchura', '2023-08-09', '2023-08-09 12:45:57', '10.9.1.25', 'OPEN'),
(11, '4952971', '2023-08-09', '2023-08-09 12:59:55', '10.9.1.25', 'OPEN'),
(12, '4952971', '2023-08-09', '2023-08-09 13:00:36', '10.9.1.25', 'OPEN'),
(13, 'lyapuchura', '2023-08-09', '2023-08-09 18:31:13', '10.0.71.83', 'OPEN'),
(14, '4952971', '2023-08-09', '2023-08-09 18:34:09', '10.0.71.83', 'OPEN'),
(15, 'lyapuchura', '2023-08-09', '2023-08-09 18:37:09', '10.0.71.83', 'OPEN'),
(16, 'lyapuchura', '2023-08-14', '2023-08-14 11:18:14', '10.9.1.40', 'OPEN'),
(17, 'lyapuchura', '2023-08-19', '2023-08-19 20:27:39', '10.0.9.143', 'OPEN'),
(18, 'lyapuchura', '2023-08-23', '2023-08-23 11:16:27', '10.9.1.50', 'OPEN'),
(19, 'dcastanon', '2023-08-23', '2023-08-23 11:19:40', '10.9.1.50', 'OPEN'),
(20, 'lyapuchura', '2023-08-23', '2023-08-23 11:22:51', '10.9.1.50', 'OPEN'),
(21, 'lyapuchura', '2023-08-23', '2023-08-23 12:27:50', '10.9.1.50', 'OPEN'),
(22, 'lyapuchura', '2023-08-23', '2023-08-23 12:33:14', '10.9.1.50', 'OPEN'),
(23, 'lyapuchura', '2023-08-23', '2023-08-23 12:45:09', '10.9.1.50', 'OPEN'),
(24, 'lyapuchura', '2023-08-23', '2023-08-23 13:06:03', '10.9.1.50', 'OPEN'),
(25, 'lyapuchura', '2023-08-23', '2023-08-23 13:29:22', '10.9.1.50', 'OPEN'),
(26, 'lyapuchura', '2023-08-23', '2023-08-23 15:42:13', '10.9.1.50', 'OPEN'),
(27, '5291102', '2023-08-23', '2023-08-23 15:49:49', '10.0.9.143', 'OPEN'),
(28, '5116331', '2023-08-23', '2023-08-23 16:17:25', '10.9.1.50', 'OPEN'),
(29, 'lyapuchura', '2023-08-23', '2023-08-23 16:20:56', '10.9.1.50', 'OPEN'),
(30, 'lyapuchura', '2023-08-23', '2023-08-23 19:02:33', '10.0.9.143', 'OPEN'),
(31, '6301836', '2023-08-23', '2023-08-23 19:54:11', '10.0.9.143', 'OPEN'),
(32, '6301836', '2023-08-23', '2023-08-23 20:01:57', '10.0.9.143', 'OPEN'),
(33, '4022301', '2023-08-23', '2023-08-23 20:11:53', '10.0.9.143', 'OPEN'),
(34, '4091334', '2023-08-23', '2023-08-23 20:12:40', '10.0.9.143', 'OPEN'),
(35, '4091334', '2023-08-23', '2023-08-23 20:13:29', '10.0.9.143', 'OPEN'),
(36, '5043838', '2023-08-23', '2023-08-23 20:14:46', '10.0.9.143', 'OPEN'),
(37, '4020217', '2023-08-23', '2023-08-23 20:16:00', '10.0.9.143', 'OPEN'),
(38, '3933560', '2023-08-23', '2023-08-23 20:26:38', '10.0.9.143', 'OPEN'),
(39, '3933560', '2023-08-23', '2023-08-23 20:28:33', '10.0.9.143', 'OPEN'),
(40, '3933560', '2023-08-23', '2023-08-23 20:31:02', '10.0.9.143', 'OPEN'),
(41, '4020217', '2023-08-23', '2023-08-23 21:05:06', '10.0.9.143', 'OPEN'),
(42, '3933560', '2023-08-23', '2023-08-23 21:15:30', '10.0.9.143', 'OPEN'),
(43, '4022301', '2023-08-23', '2023-08-23 21:22:00', '10.0.9.143', 'OPEN'),
(44, 'lyapuchura', '2023-08-23', '2023-08-23 21:23:32', '10.0.9.143', 'OPEN'),
(45, '1079799', '2023-08-23', '2023-08-23 22:57:39', '10.0.9.143', 'OPEN'),
(46, 'lyapuchura', '2023-08-23', '2023-08-23 23:36:26', '10.0.9.143', 'OPEN'),
(47, 'lyapuchura', '2023-08-24', '2023-08-24 02:45:30', '::1', 'OPEN'),
(48, 'lyapuchura', '2023-08-24', '2023-08-24 02:50:46', '::1', 'OPEN'),
(49, 'lyapuchura', '2023-08-24', '2023-08-24 02:56:09', '::1', 'OPEN'),
(50, 'lyapuchura', '2023-08-24', '2023-08-24 03:02:09', '::1', 'OPEN'),
(51, 'lyapuchura', '2023-08-24', '2023-08-24 03:07:45', '::1', 'OPEN'),
(52, 'lyapuchura', '2023-08-24', '2023-08-24 04:10:12', '::1', 'OPEN'),
(53, 'lyapuchura', '2023-08-24', '2023-08-24 04:19:18', '::1', 'OPEN'),
(54, 'lyapuchura', '2023-08-25', '2023-08-25 03:47:58', '::1', 'OPEN'),
(55, 'lyapuchura', '2023-08-25', '2023-08-25 03:56:40', '::1', 'OPEN'),
(56, 'lyapuchura', '2023-08-28', '2023-08-28 22:11:13', '::1', 'OPEN'),
(57, 'lyapuchura', '2023-08-28', '2023-08-28 22:14:03', '::1', 'OPEN'),
(58, 'lyapuchura', '2023-08-30', '2023-08-30 15:55:39', '::1', 'OPEN'),
(59, 'lyapuchura', '2023-08-30', '2023-08-30 16:09:34', '::1', 'OPEN'),
(60, 'lyapuchura', '2023-08-30', '2023-08-30 18:55:58', '::1', 'OPEN'),
(61, 'lyapuchura', '2023-08-31', '2023-08-31 20:29:25', '::1', 'OPEN'),
(62, 'lyapuchura', '2023-08-31', '2023-08-31 21:42:04', '::1', 'OPEN'),
(63, 'lyapuchura', '2023-09-04', '2023-09-04 20:10:08', '::1', 'OPEN'),
(64, 'lyapuchura', '2023-09-04', '2023-09-04 21:10:24', '::1', 'OPEN'),
(65, 'lyapuchura', '2023-09-04', '2023-09-04 21:13:27', '::1', 'OPEN'),
(66, 'lyapuchura', '2023-09-05', '2023-09-05 02:02:36', '::1', 'OPEN'),
(67, 'lyapuchura', '2023-09-05', '2023-09-05 13:14:33', '::1', 'OPEN'),
(68, 'lyapuchura', '2023-09-05', '2023-09-05 14:06:35', '::1', 'OPEN'),
(69, 'lyapuchura', '2023-09-05', '2023-09-05 14:28:38', '::1', 'OPEN'),
(70, 'lyapuchura', '2023-09-05', '2023-09-05 14:31:29', '::1', 'OPEN'),
(71, 'lyapuchura', '2023-09-05', '2023-09-05 14:40:26', '::1', 'OPEN'),
(72, 'lyapuchura', '2023-09-05', '2023-09-05 20:11:11', '::1', 'OPEN'),
(73, 'lyapuchura', '2023-09-06', '2023-09-06 14:03:18', '::1', 'OPEN'),
(74, 'lyapuchura', '2023-09-06', '2023-09-06 19:07:50', '::1', 'OPEN'),
(75, 'lyapuchura', '2023-09-07', '2023-09-07 12:53:27', '::1', 'OPEN'),
(76, 'lyapuchura', '2023-09-07', '2023-09-07 23:07:47', '::1', 'OPEN'),
(77, 'lyapuchura', '2023-09-07', '2023-09-07 23:07:47', '::1', 'OPEN'),
(78, 'lyapuchura', '2023-09-07', '2023-09-07 23:09:10', '::1', 'OPEN'),
(79, 'lyapuchura', '2023-09-07', '2023-09-07 23:09:34', '::1', 'OPEN'),
(80, 'lyapuchura', '2023-09-08', '2023-09-08 14:06:35', '::1', 'OPEN'),
(81, 'lyapuchura', '2023-09-08', '2023-09-08 15:04:27', '::1', 'OPEN'),
(82, 'lyapuchura', '2023-09-12', '2023-09-12 14:23:03', '::1', 'OPEN'),
(83, 'lyapuchura', '2023-09-13', '2023-09-13 19:44:55', '::1', 'OPEN'),
(84, 'lyapuchura', '2023-09-14', '2023-09-14 12:58:24', '::1', 'OPEN'),
(85, 'lyapuchura', '2023-09-15', '2023-09-15 14:08:10', '::1', 'OPEN'),
(86, 'lyapuchura', '2023-09-15', '2023-09-15 22:37:08', '::1', 'OPEN'),
(87, 'lyapuchura', '2023-09-15', '2023-09-15 22:50:54', '::1', 'OPEN'),
(88, 'lyapuchura', '2023-09-18', '2023-09-18 00:14:44', '::1', 'OPEN'),
(89, 'lyapuchura', '2023-09-18', '2023-09-18 13:04:43', '::1', 'OPEN'),
(90, 'lyapuchura', '2023-09-18', '2023-09-18 13:12:39', '192.168.250.238', 'OPEN'),
(91, 'lyapuchura', '2023-09-18', '2023-09-18 20:02:25', '::1', 'OPEN'),
(92, 'lyapuchura', '2023-09-18', '2023-09-18 20:09:22', '::1', 'OPEN'),
(93, 'lyapuchura', '2023-09-18', '2023-09-18 20:10:45', '192.168.250.238', 'OPEN'),
(94, 'lyapuchura', '2023-09-18', '2023-09-18 20:24:02', '192.168.250.238', 'OPEN'),
(95, 'lyapuchura', '2023-09-19', '2023-09-19 13:01:15', '::1', 'OPEN'),
(96, 'lyapuchura', '2023-09-19', '2023-09-19 18:21:47', '::1', 'OPEN'),
(97, 'lyapuchura', '2023-09-19', '2023-09-19 21:19:33', '::1', 'OPEN'),
(98, 'lyapuchura', '2023-09-20', '2023-09-20 13:40:11', '::1', 'OPEN'),
(99, 'lyapuchura', '2023-09-21', '2023-09-21 13:51:59', '::1', 'OPEN'),
(100, 'lyapuchura', '2023-09-21', '2023-09-21 16:23:12', '::1', 'OPEN'),
(101, 'lyapuchura', '2023-09-21', '2023-09-21 18:54:13', '::1', 'OPEN'),
(102, 'lyapuchura', '2023-09-21', '2023-09-21 20:27:13', '::1', 'OPEN'),
(103, 'lyapuchura', '2023-09-21', '2023-09-21 22:39:39', '::1', 'OPEN'),
(104, 'lyapuchura', '2023-09-22', '2023-09-22 12:57:18', '::1', 'OPEN'),
(105, 'lyapuchura', '2023-09-22', '2023-09-22 20:25:37', '::1', 'OPEN'),
(106, 'lyapuchura', '2023-09-22', '2023-09-22 20:43:01', '::1', 'OPEN'),
(107, 'lyapuchura', '2023-09-25', '2023-09-25 13:50:26', '::1', 'OPEN'),
(108, 'lyapuchura', '2023-09-26', '2023-09-26 13:03:17', '::1', 'OPEN'),
(109, 'lyapuchura', '2023-09-26', '2023-09-26 19:01:03', '::1', 'OPEN'),
(110, 'lyapuchura', '2023-09-27', '2023-09-27 20:44:21', '::1', 'OPEN'),
(111, 'lyapuchura', '2023-09-28', '2023-09-28 13:55:40', '::1', 'OPEN'),
(112, 'lyapuchura', '2023-09-28', '2023-09-28 14:44:30', '::1', 'OPEN'),
(113, 'lyapuchura', '2023-09-28', '2023-09-28 14:46:36', '::1', 'OPEN'),
(114, 'lyapuchura', '2023-09-28', '2023-09-28 15:02:03', '::1', 'OPEN'),
(115, 'lyapuchura', '2023-09-28', '2023-09-28 15:38:42', '::1', 'OPEN'),
(116, 'lyapuchura', '2023-09-28', '2023-09-28 15:49:40', '::1', 'OPEN'),
(117, 'lyapuchura', '2023-09-28', '2023-09-28 16:07:40', '::1', 'OPEN'),
(118, 'lyapuchura', '2023-09-28', '2023-09-28 18:59:48', '::1', 'OPEN'),
(119, 'lyapuchura', '2023-09-29', '2023-09-29 13:19:17', '::1', 'OPEN'),
(120, 'lyapuchura', '2023-09-29', '2023-09-29 15:48:07', '::1', 'OPEN'),
(121, 'lyapuchura', '2023-09-29', '2023-09-29 19:47:42', '::1', 'OPEN'),
(122, 'lyapuchura', '2023-10-02', '2023-10-02 13:10:26', '::1', 'OPEN'),
(123, 'lyapuchura', '2023-10-02', '2023-10-02 19:01:31', '::1', 'OPEN'),
(124, 'lyapuchura', '2023-10-02', '2023-10-02 21:12:59', '::1', 'OPEN'),
(125, 'lyapuchura', '2023-10-02', '2023-10-02 22:03:18', '::1', 'OPEN'),
(126, 'lyapuchura', '2023-10-03', '2023-10-03 12:53:16', '::1', 'OPEN'),
(127, 'lyapuchura', '2023-10-03', '2023-10-03 13:46:20', '::1', 'OPEN'),
(128, 'lyapuchura', '2023-10-03', '2023-10-03 14:53:19', '::1', 'OPEN'),
(129, 'lyapuchura', '2023-10-04', '2023-10-04 13:14:28', '::1', 'OPEN'),
(130, 'lyapuchura', '2023-10-04', '2023-10-04 14:38:46', '::1', 'OPEN'),
(131, 'lyapuchura', '2023-10-04', '2023-10-04 20:34:31', '::1', 'OPEN'),
(132, 'lyapuchura', '2023-10-06', '2023-10-06 13:22:45', '::1', 'OPEN'),
(133, 'lyapuchura', '2023-10-06', '2023-10-06 19:28:50', '::1', 'OPEN'),
(134, 'lyapuchura', '2023-10-09', '2023-10-09 21:49:21', '::1', 'OPEN'),
(135, 'lyapuchura', '2023-10-09', '2023-10-09 21:53:33', '::1', 'OPEN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_login_failure`
--

CREATE TABLE `log_login_failure` (
  `idlog_login_failure` int(11) NOT NULL,
  `usuario` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `fecha` date NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `ip` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `log_login_failure`
--

INSERT INTO `log_login_failure` (`idlog_login_failure`, `usuario`, `password`, `fecha`, `fecha_hora`, `ip`) VALUES
(1, 'mcalle', 'mcalle', '2023-08-09', '2023-08-09 13:49:34', '10.9.1.37'),
(2, 'mcalle', '123456', '2023-08-09', '2023-08-09 13:49:45', '10.9.1.37'),
(3, '4881814', 'Machac@48', '2023-08-09', '2023-08-09 17:35:41', '10.0.71.107'),
(4, '4881814', 'Machac@48', '2023-08-09', '2023-08-09 17:36:00', '10.0.71.107'),
(5, 'LYAPUCHUIRA', 'LYAPUCHURA', '2023-08-09', '2023-08-09 18:30:56', '10.0.71.83'),
(6, 'YVASQUEZ', '3839707', '2023-08-22', '2023-08-22 20:08:15', '10.0.9.143'),
(7, '3839707', '3839707', '2023-08-22', '2023-08-22 20:12:24', '10.0.9.143'),
(8, '6301836', '6301836', '2023-08-22', '2023-08-22 21:23:49', '10.0.9.143'),
(9, 'dcastanon', 'dcastanon', '2023-08-23', '2023-08-23 11:16:04', '10.9.1.50'),
(10, '6301836', '6301836', '2023-08-23', '2023-08-23 12:18:42', '10.0.9.143'),
(11, '6301836', '6301836', '2023-08-23', '2023-08-23 12:20:59', '10.0.9.143'),
(12, '6301836', '6301836', '2023-08-23', '2023-08-23 12:21:28', '10.0.9.143'),
(13, '4792874', '4792874', '2023-08-23', '2023-08-23 15:28:57', '10.0.9.143'),
(14, '4792874', '4792874', '2023-08-23', '2023-08-23 15:47:11', '10.0.9.143'),
(15, '4792874', '4792874', '2023-08-23', '2023-08-23 15:47:16', '10.0.9.143'),
(16, '4792874', '4792874', '2023-08-23', '2023-08-23 15:48:35', '10.0.9.143'),
(17, 'ZAMBRANA', '4176112', '2023-08-23', '2023-08-23 16:21:00', '10.0.9.143'),
(18, '3626104', '3626104', '2023-08-23', '2023-08-23 18:09:25', '10.0.9.143'),
(19, '3971793', '3971793', '2023-08-23', '2023-08-23 18:45:30', '10.0.9.143'),
(20, '4020217', '4020217', '2023-08-23', '2023-08-23 19:54:07', '10.0.9.143'),
(21, '4020217', '4020217', '2023-08-23', '2023-08-23 19:55:36', '10.0.9.143'),
(22, 'lyapuchura', 'lyapuchura', '2023-08-28', '2023-08-28 17:52:53', '::1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE `lugar` (
  `idlugar` int(11) NOT NULL,
  `lugar` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `macrocurricula`
--

CREATE TABLE `macrocurricula` (
  `idmacrocurricula` int(11) NOT NULL,
  `idobjetivo_anual` int(11) DEFAULT NULL,
  `idarea_conocimiento` int(11) DEFAULT NULL,
  `macrocurricula` text,
  `idambito` int(11) DEFAULT NULL,
  `idmodelo_educativo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `macrocurricula`
--

INSERT INTO `macrocurricula` (`idmacrocurricula`, `idobjetivo_anual`, `idarea_conocimiento`, `macrocurricula`, `idambito`, `idmodelo_educativo`, `codigo`, `correlativo`, `idusuario`) VALUES
(1, 1, 1, 'CURSOS INTRODUCTORIOS ', 1, 1, 'MACRO-1/OBJ-1/2023', 1, 1),
(2, 1, 1, 'CURSOS FOCALIZADOS', 1, 1, 'MACRO-2/OBJ-1/2023', 2, 1),
(3, 1, 1, 'SEMINARIOS', 1, 1, 'MACRO-2/OBJ-3/2023', 3, 1),
(4, 1, 2, 'RESIDENCIA MEDICA SAFCI', 1, 1, 'MACRO-4/OBJ-1/2023', 4, 1),
(5, 1, 1, 'FORMACIÓN DOCENTE', 1, 1, 'MACRO-5/OBJ-1/2023', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `microcurricula`
--

CREATE TABLE `microcurricula` (
  `idmicrocurricula` int(11) NOT NULL,
  `idmacrocurricula` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `idtematica` int(11) DEFAULT NULL,
  `carga_horaria` varchar(45) DEFAULT NULL,
  `objetivo_curso` text,
  `idtipo_costo` int(11) DEFAULT NULL,
  `costo` int(11) DEFAULT NULL,
  `pre_requisito` int(11) DEFAULT NULL,
  `idtipo_evento` int(11) DEFAULT NULL,
  `idnivel_curricular` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `microcurricula`
--

INSERT INTO `microcurricula` (`idmicrocurricula`, `idmacrocurricula`, `correlativo`, `codigo`, `idtematica`, `carga_horaria`, `objetivo_curso`, `idtipo_costo`, `costo`, `pre_requisito`, `idtipo_evento`, `idnivel_curricular`, `idusuario`) VALUES
(1, 1, 1, 'MICRO-1/1/2023', 2, '30', 'OBJETIVO DEL CURSO DE CAPACITACIÓN', 1, 0, 1, 1, 2, 1),
(2, 1, 2, 'MICRO-2/1/2023', 3, '30', 'OBJETIVO DEL CURSO DE CAPACITACIÓN', 1, 0, 2, 1, 2, 1),
(3, 1, 3, 'MICRO-3/1/2023', 4, '30', 'Promocionar la Salud en la Sopciedad Civil', 2, 50, 3, 1, 2, 1),
(4, 5, 1, 'MICRO-1/5/2023', 5, '8', 'Formar a docentes en politica SAFCI en aspectos de educacion virtual.', 1, 0, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ministerio`
--

CREATE TABLE `ministerio` (
  `idministerio` int(11) NOT NULL,
  `ministerio` text,
  `sigla` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ministerio`
--

INSERT INTO `ministerio` (`idministerio`, `ministerio`, `sigla`) VALUES
(1, 'MINISTERIO DE SALUD Y DEPORTES', 'MDSYD'),
(2, 'VICEMINISTERIO DE GESTIÓN DEL SISTEMA DE SALUD', 'VMGSS'),
(3, 'VICEMINISTERIO DE PROMOCIÓN Y VIGILANCIA EPIDEMIOLÓGICA Y MEDICINA TRADICIONAL', 'VMPVEMD'),
(4, 'VICEMINISTERIO DE SEGUROS DE SALUD Y GESTIÓN DEL SUS', 'VMSSGS'),
(5, 'VICEMINISTERIO DE DEPORTES', 'VMD');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modalidad`
--

CREATE TABLE `modalidad` (
  `idmodalidad` int(11) NOT NULL,
  `modalidad` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modalidad`
--

INSERT INTO `modalidad` (`idmodalidad`, `modalidad`) VALUES
(1, 'PRESENCIAL'),
(2, 'VIRTUAL'),
(3, 'SEMI-PRESENCIAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo_educativo`
--

CREATE TABLE `modelo_educativo` (
  `idmodelo_educativo` int(11) NOT NULL,
  `modelo_educativo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `modelo_educativo`
--

INSERT INTO `modelo_educativo` (`idmodelo_educativo`, `modelo_educativo`) VALUES
(1, 'POE'),
(2, 'PDC');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `idmunicipio` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `idprovincia` int(11) NOT NULL,
  `municipio` text NOT NULL,
  `cod_municipio` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`idmunicipio`, `iddepartamento`, `idprovincia`, `municipio`, `cod_municipio`) VALUES
(1, 1, 3, 'Baures', '80802'),
(2, 1, 1, 'Exaltacion', '80402'),
(3, 1, 2, 'Guayaramerin', '80202'),
(4, 1, 3, 'Huacaraje', '80803'),
(5, 1, 4, 'Loreto', '80601'),
(6, 1, 3, 'Magdalena', '80801'),
(7, 1, 5, 'Puerto Siles', '80703'),
(8, 1, 6, 'Reyes', '80301'),
(9, 1, 2, 'Riberalta', '80201'),
(10, 1, 6, 'Rurrenabaque', '80304'),
(11, 1, 4, 'San Andres', '80602'),
(12, 1, 6, 'San Borja', '80302'),
(13, 1, 7, 'San Ignacio', '80501'),
(14, 1, 8, 'San Javier', '80102'),
(15, 1, 5, 'San Joaquin', '80701'),
(16, 1, 5, 'San Ramon', '80702'),
(17, 1, 1, 'Santa Ana de Yacuma', '80401'),
(18, 1, 6, 'Santa Rosa', '80303'),
(19, 1, 8, 'Trinidad', '80101'),
(20, 2, 9, 'Aiquile', '30201'),
(21, 2, 24, 'Alalay', '31303'),
(22, 2, 10, 'Anzaldo', '30402'),
(23, 2, 11, 'Arani', '30501'),
(24, 2, 10, 'Arbieto', '30403'),
(25, 2, 12, 'Arque', '30601'),
(26, 2, 13, 'Bolivar', '31501'),
(27, 2, 14, 'Capinota', '30701'),
(28, 2, 20, 'Chimore', '31204'),
(29, 2, 15, 'Cliza', '30801'),
(30, 2, 16, 'Cochabamba', '30101'),
(31, 2, 17, 'Colcapirhua', '30905'),
(32, 2, 18, 'Colomi', '31002'),
(33, 2, 19, 'Cuchumuela', '31405'),
(34, 2, 15, 'Entre Rios (Bulo Bulo)', '31206'),
(35, 2, 21, 'Independencia', '30301'),
(36, 2, 24, 'Mizque', '31301'),
(37, 2, 21, 'Morochata', '30302'),
(38, 2, 9, 'Omereque', '30203'),
(39, 2, 9, 'Pasorapa', '30202'),
(40, 2, 20, 'Pocona', '31203'),
(41, 2, 20, 'Pojo', '31202'),
(42, 2, 20, 'Puerto Villarroel', '31205'),
(43, 2, 19, 'Punata', '31401'),
(44, 2, 17, 'Quillacollo', '30901'),
(45, 2, 18, 'Sacaba', '31001'),
(46, 2, 10, 'Sacabamba', '30404'),
(47, 2, 19, 'San Benito', '31403'),
(48, 2, 14, 'Santivanez', '30702'),
(49, 2, 14, 'Sicaya', '30703'),
(50, 2, 17, 'Sipe Sipe', '30902'),
(51, 2, 19, 'Tacachi', '31404'),
(52, 2, 12, 'Tacopaya', '30602'),
(53, 2, 22, 'Tapacari', '31101'),
(54, 2, 10, 'Tarata', '30401'),
(55, 2, 17, 'Tiquipaya', '30903'),
(56, 2, 23, 'Tiraque', '31601'),
(57, 2, 15, 'Toco', '30802'),
(58, 2, 15, 'Tolata', '30803'),
(59, 2, 20, 'Totora', '31201'),
(60, 2, 11, 'Vacas', '30502'),
(61, 2, 24, 'Vila Vila', '31302'),
(62, 2, 19, 'Villa Rivero', '31402'),
(63, 2, 18, 'Villa Tunari', '31003'),
(64, 2, 17, 'Vinto', '30904'),
(65, 2, 21, 'Cocapata ', '30303'),
(66, 2, 23, 'Shinahota ', '31602'),
(67, 3, 25, 'Camargo', '10701'),
(68, 3, 2, 'Camataqui', '10901'),
(69, 3, 26, 'Culpina', '10902'),
(70, 3, 27, 'El Villar', '10405'),
(71, 3, 28, 'Huacaya', '10502'),
(72, 3, 29, 'Icla', '10304'),
(73, 3, 25, 'Incahuasi', '10703'),
(74, 3, 26, 'Las Carreras', '10903'),
(75, 3, 28, 'Machareti', '11003'),
(76, 3, 30, 'Monteagudo', '10501'),
(77, 3, 27, 'Padilla', '10401'),
(78, 3, 31, 'Poroma', '10103'),
(79, 3, 29, 'Presto', '10302'),
(80, 3, 25, 'San Lucas', '10702'),
(81, 3, 30, 'San Pablo de Huacareta', '10502'),
(82, 3, 27, 'Sopachuy', '10403'),
(83, 3, 31, 'Sucre', '10101'),
(84, 3, 32, 'Tarabuco', '10601'),
(85, 3, 33, 'Tarvita', '10202'),
(86, 3, 27, 'Tomina', '10402'),
(87, 3, 27, 'Villa Alcala', '10404'),
(88, 3, 33, 'Villa Azurduy', '10201'),
(89, 3, 23, 'Villa Mojocoya', '10303'),
(90, 3, 34, 'Villa Serrano', '10801'),
(91, 3, 25, 'Villa Vaca Guzman', '11001'),
(92, 3, 29, 'Villa Zudanez', '10301'),
(93, 3, 32, 'Yamparaez', '10602'),
(94, 3, 31, 'Yotala', '10102'),
(95, 3, 25, 'Villa Charcas ', '10704'),
(96, 4, 35, 'Achacachi', '20201'),
(97, 4, 52, 'Achocalla ', '20104'),
(98, 4, 35, 'Ancoraimes', '20202'),
(99, 4, 36, 'Andres de Machaca', '20805'),
(100, 4, 37, 'Apolo', '20701'),
(101, 4, 47, 'Aucapata', '20503'),
(102, 4, 47, 'Ayata', '20502'),
(103, 4, 38, 'Ayo Ayo', '21303'),
(104, 4, 39, 'Batallas', '21203'),
(105, 4, 40, 'Cairoma', '20905'),
(106, 4, 41, 'Cajuata', '21003'),
(107, 4, 42, 'Calacoto', '20303'),
(108, 4, 38, 'Calamarca', '21304'),
(109, 4, 42, 'Caquiaviri', '20302'),
(110, 4, 43, 'Caranavi', '22001'),
(111, 4, 44, 'Catacora', '21902'),
(112, 4, 45, 'Chacarilla', '21803'),
(113, 4, 42, 'Charana', '20305'),
(114, 4, 46, 'Chulumani', '21101'),
(115, 4, 47, 'Chuma', '20501'),
(116, 4, 21, 'Collana', '21307'),
(117, 4, 22, 'Colquencha', '21306'),
(118, 4, 41, 'Colquiri', '21004'),
(119, 4, 42, 'Comanche', '20304'),
(120, 4, 48, 'Combaya', '20605'),
(121, 4, 49, 'Copacabana', '21701'),
(122, 4, 50, 'Coripata', '21402'),
(123, 4, 42, 'Coro Coro', '20301'),
(124, 4, 50, 'Coroico', '21401'),
(125, 4, 51, 'Curva', '21602'),
(126, 4, 36, 'Desaguadero', '20804'),
(127, 4, 52, 'El Alto', '20105'),
(128, 4, 33, 'Gral. Juan Jose Perez (Charazani)', '21601'),
(129, 4, 48, 'Guanay', '20602'),
(130, 4, 36, 'Guaqui', '20802'),
(131, 4, 41, 'Ichoca', '21005'),
(132, 4, 41, 'Inquisivi', '21001'),
(133, 4, 46, 'Irupana', '21102'),
(134, 4, 54, 'Ixiamas', '21501'),
(135, 4, 40, 'Jesus de Machaca', '20806'),
(136, 4, 46, 'La Asunta', '21105'),
(137, 4, 52, 'La Paz', '20101'),
(138, 4, 39, 'Laja', '21202'),
(139, 4, 44, 'Licoma Pampa', '21006'),
(140, 4, 40, 'Luribay', '20901'),
(141, 4, 40, 'Malla', '20904'),
(142, 4, 47, 'Mapiri', '20607'),
(143, 4, 52, 'Mecapaca (1)', '20103'),
(144, 4, 53, 'Mocomoco', '20402'),
(145, 4, 50, 'Nazacara de Pacajes', '20307'),
(146, 4, 52, 'Palca (1)', '20102'),
(147, 4, 46, 'Palos Blancos', '21104'),
(148, 4, 45, 'Papel Pampa', '21802'),
(149, 4, 38, 'Patacamaya', '21305'),
(150, 4, 37, 'Pelechuco', '20702'),
(151, 4, 39, 'Pucarani', '21201'),
(152, 4, 53, 'Puerto Acosta', '20401'),
(153, 4, 53, 'Puerto Carabuco', '20403'),
(154, 4, 39, 'Puerto Perez', '21204'),
(155, 4, 48, 'Quiabaya', '20604'),
(156, 4, 41, 'Quime', '21002'),
(157, 4, 54, 'San Buena Ventura', '21502'),
(158, 4, 45, 'San Pedro de Curahuara', '21801'),
(159, 4, 49, 'San Pedro de Tiquina', '21702'),
(160, 4, 65, 'Santiago de Callapa', '20308'),
(161, 4, 44, 'Santiago de Machaca', '21901'),
(162, 4, 40, 'Sapahaqui', '20902'),
(163, 4, 38, 'Sica Sica', '21301'),
(164, 4, 48, 'Sorata', '20601'),
(165, 4, 48, 'Tacacoma', '20603'),
(166, 4, 71, 'Taraco', '20807'),
(167, 4, 72, 'Teoponte', '20608'),
(168, 4, 36, 'Tiahuanacu', '20803'),
(169, 4, 74, 'Tipuani', '20606'),
(170, 4, 49, 'Tito Yupanqui', '21703'),
(171, 4, 38, 'Umala', '21302'),
(172, 4, 36, 'Viacha', '20801'),
(173, 4, 78, 'Waldo Ballivian', '20306'),
(174, 4, 40, 'Yaco', '20903'),
(175, 4, 46, 'Yanacachi', '21103'),
(176, 4, 35, 'Huarina ', '20204'),
(177, 4, 35, 'Santiago de Huata ', '20205'),
(178, 4, 53, 'Escoma ', '20405'),
(179, 4, 53, 'Humanata ', '20404'),
(180, 4, 43, 'Alto Beni ', '22002'),
(181, 5, 55, 'Santiago de Andamarca', '41201'),
(182, 5, 56, 'Antequera', '40603'),
(183, 5, 55, 'Belen de Andamarca', '41202'),
(184, 5, 57, 'Caracollo', '40102'),
(185, 5, 58, 'Carangas', '41503'),
(186, 5, 59, 'Challapata', '40201'),
(187, 5, 7, 'Chipaya', '40903'),
(188, 5, 61, 'Choquecota', '40302'),
(189, 5, 9, 'Coipasa', '40902'),
(190, 5, 61, 'Corque', '40301'),
(191, 5, 62, 'Cruz de Machacamarca', '40702'),
(192, 5, 63, 'Curahuara de Carangas', '40401'),
(193, 5, 57, 'El Choro', '40103'),
(194, 5, 62, 'Escara', '40502'),
(195, 5, 62, 'Esmeralda', '40505'),
(196, 5, 64, 'Eucaliptus', '41101'),
(197, 5, 62, 'Huachacalla', '40501'),
(198, 5, 58, 'La Rivera', '41501'),
(199, 5, 65, 'Machacamarca', '40503'),
(200, 5, 57, 'Oruro', '40101'),
(201, 5, 66, 'Pampa Aullagas', '40802'),
(202, 5, 56, 'Pazna', '40602'),
(203, 5, 23, 'Sabaya', '40901'),
(204, 5, 66, 'Salinas de Garci Mendoza', '40801'),
(205, 5, 67, 'Santiago de Huari', '41401'),
(206, 5, 68, 'Santiago de Huayllamarca', '41601'),
(207, 5, 59, 'Santuario de Quillacas', '40202'),
(208, 5, 57, 'Soracachi', '40104'),
(209, 5, 58, 'Todos Santos', '41502'),
(210, 5, 69, 'Toledo', '41001'),
(211, 5, 70, 'San Pedro de Totora', '41301'),
(212, 5, 63, 'Turco', '40402'),
(213, 5, 65, 'Villa Huanuni', '40701'),
(214, 5, 56, 'Villa Poopo', '40601'),
(215, 5, 62, 'Yunguyo del Litoral', '40504'),
(216, 6, 71, 'Bella Flor', '90104'),
(217, 6, 2, 'Blanca Flor', ''),
(218, 6, 71, 'Bolpebra', '90103'),
(219, 6, 71, 'Cobija', '90101'),
(220, 6, 72, 'El Sena', '90303'),
(221, 6, 73, 'Filadelfia', '90203'),
(222, 6, 7, 'Humaita', '90402'),
(223, 6, 75, 'Nueva Esperanza', '90501'),
(224, 6, 71, 'Porvenir', '90102'),
(225, 6, 72, 'Puerto Gonzalo Moreno', '90301'),
(226, 6, 73, 'Puerto Rico', '90201'),
(227, 6, 73, 'San Pedro', '90202'),
(228, 6, 74, 'Santa Rosa del Abuna', '90401'),
(229, 6, 75, 'Santos Mercado (Reserva)', '90503'),
(230, 6, 75, 'Villa Nueva (Loma Alta)', '90502'),
(231, 7, 76, 'Acasio', ''),
(232, 7, 76, 'Arampampa', '51301'),
(233, 7, 77, 'Atocha', '50802'),
(234, 7, 78, 'Belen de Urmiri', '50104'),
(235, 7, 81, 'Betanzos', '50301'),
(236, 7, 79, 'Caiza D', '51102'),
(237, 7, 80, 'Caripuyo', '50702'),
(238, 7, 8, 'Chaqui', '50302'),
(239, 7, 82, 'Chayanta', '50202'),
(240, 7, 83, 'Colcha K', '50901'),
(241, 7, 84, 'Colquechaca', '50401'),
(242, 7, 85, 'Cotagaita', '50601'),
(243, 7, 82, 'Llallagua', '50203'),
(244, 7, 86, 'Llica', '51401'),
(245, 7, 15, 'Mojinete', '51002'),
(246, 7, 84, 'Ocuri', '50404'),
(247, 7, 17, 'Pocoata', '50403'),
(248, 7, 88, 'Porco', '51203'),
(249, 7, 78, 'Potosi', '50101'),
(250, 7, 79, 'Puna', '51101'),
(251, 7, 84, 'Ravelo', '50402'),
(252, 7, 80, 'Sacaca', '50701'),
(253, 7, 89, 'San Agustin', '51601'),
(254, 7, 87, 'San Antonio de Esmoruco', '51003'),
(255, 7, 87, 'San Pablo de Lipez', '51001'),
(256, 7, 90, 'San Pedro de Buena Vista', '50501'),
(257, 7, 83, 'San Pedro de Quemes', '50902'),
(258, 7, 81, 'Tacobamba', '50303'),
(259, 7, 86, 'Tahua', '51402'),
(260, 7, 78, 'Tinguipaya (4)', '50102'),
(261, 7, 88, 'Tomave', '51202'),
(262, 7, 90, 'Toro Toro', '50502'),
(263, 7, 77, 'Tupiza', '50801'),
(264, 7, 82, 'Uncia', '50201'),
(265, 7, 88, 'Uyuni', '51201'),
(266, 7, 78, 'Villa de Yocalla (4)', '50103'),
(267, 7, 37, 'Villazon', '51501'),
(268, 7, 85, 'Vitichi', '50602'),
(269, 7, 82, 'Chuquiuta ', '50204'),
(270, 7, 79, 'Ckochas ', '51103'),
(271, 8, 99, 'Ascencion de Guarayos', '71501'),
(272, 8, 2, 'Ayacucho - Porongo', '70103'),
(273, 8, 3, 'Boyuibe', '70707'),
(274, 8, 93, 'Buena Vista', '70401'),
(275, 8, 94, 'Cabezas', '70703'),
(276, 8, 6, 'Camiri', '70706'),
(277, 8, 95, 'Carmen Rivero Torres', '71403'),
(278, 8, 94, 'Charagua', '70702'),
(279, 8, 96, 'Colpa Belgica', '70603'),
(280, 8, 97, 'Comarapa', '71301'),
(281, 8, 98, 'Concepcion', '71101'),
(282, 8, 92, 'Cotoca', '70102'),
(283, 8, 13, 'Cuatro Cañadas', '71106'),
(284, 8, 94, 'Cuevo', '70704'),
(285, 8, 15, 'El Puente', '71503'),
(286, 8, 92, 'El Torno', '70105'),
(287, 8, 100, 'Gral. Saavedra', '71002'),
(288, 8, 94, 'Gutierrez', '70705'),
(289, 8, 92, 'La Guardia', '70104'),
(290, 8, 94, 'Lagunillas', '70701'),
(291, 8, 101, 'Mairana', '70903'),
(292, 8, 100, 'Mineros', '71003'),
(293, 8, 100, 'Montero', '71001'),
(294, 8, 102, 'Moro Moro', '70803'),
(295, 8, 103, 'Okinawa', '70202'),
(296, 8, 104, 'Pailon', '70502'),
(297, 8, 101, 'Pampa Grande', '70902'),
(298, 8, 96, 'Portachuelo', '70601'),
(299, 8, 29, 'Postrer Valle', '70804'),
(300, 8, 102, 'Pucara', '70805'),
(301, 8, 100, 'Puerto Ferna', ''),
(302, 8, 95, 'Puerto Quijarro', '71402'),
(303, 8, 95, 'Puerto Suarez', '71401'),
(304, 8, 101, 'Quirusillas', '70904'),
(305, 8, 104, 'Robore', '70503'),
(306, 8, 97, 'Saipina', '71302'),
(307, 8, 101, 'Samaipata', '70901'),
(308, 8, 98, 'San Antonio del Lomerio', '71105'),
(309, 8, 93, 'San Carlos', '70402'),
(310, 8, 105, 'San Ignacio de Velasco', '70301'),
(311, 8, 98, 'San Javier', '71102'),
(312, 8, 104, 'San Jose de Chiquitos', '70501'),
(313, 8, 43, 'San Juan', '70404'),
(314, 8, 98, 'San Julian', '71104'),
(315, 8, 106, 'San Matias', '71201'),
(316, 8, 105, 'San Miguel de Velasco', '70302'),
(317, 8, 100, 'San Pedro', '71005'),
(318, 8, 105, 'San Rafael', '70303'),
(319, 8, 98, 'San Ramon', '71103'),
(320, 8, 92, 'Santa Cruz de la Sierra', '70101'),
(321, 8, 96, 'Santa Rosa del Sara', '70602'),
(322, 8, 102, 'Trigal', '70802'),
(323, 8, 99, 'Urubicha', '71502'),
(324, 8, 102, 'Valle Grande', '70801'),
(325, 8, 103, 'Warnes', '70201'),
(326, 8, 93, 'Yapacani', '70403'),
(327, 9, 107, 'Bermejo', '60202'),
(328, 9, 108, 'Carapari', '60302'),
(329, 9, 109, 'El Puente', '60502'),
(330, 9, 110, 'Entre Rios', '60601'),
(331, 9, 107, 'Padcaya', '60201'),
(332, 9, 109, 'San Lorenzo', '60501'),
(333, 9, 111, 'Tarija', '60101'),
(334, 9, 112, 'Uriondo', '60401'),
(335, 9, 108, 'Villamontes', '60303'),
(336, 9, 108, 'Yacuiba', '60301'),
(337, 9, 112, 'Yunchara', '60402'),
(338, 2, 24, 'RAQAYPAMPA(ETA)', '31304'),
(339, 4, 35, 'Chua Cocani', '20203'),
(340, 4, 35, 'Huatajata', '20206'),
(341, 6, 72, 'San Lorenzo', '90302'),
(342, 7, 88, 'GAIOC Jatun Ayllu Yura', '51204'),
(343, 7, 84, 'San Pedro de Macha', '50405'),
(344, 8, 100, 'Fernández Alonso', '71004');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacion`
--

CREATE TABLE `nacion` (
  `idnacion` int(11) NOT NULL,
  `nacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nacion`
--

INSERT INTO `nacion` (`idnacion`, `nacion`) VALUES
(1, 'BAURÉ'),
(2, 'MOJEÑO (TRINTARIO et IGNACIANO)'),
(3, 'CHULUPIS (Población dispersa)'),
(4, 'CHACOBO'),
(5, 'MACHINERI'),
(6, 'PACAHUARA'),
(7, 'YAMINAGUA'),
(8, 'ARAONA'),
(9, 'CAVINEÑA'),
(10, 'ESSE EJJA'),
(11, 'REYESANO'),
(12, 'TACANA'),
(13, 'GUARANI'),
(14, 'GUARAYO'),
(15, 'SIRIONO'),
(16, 'TAPIETE'),
(17, 'YUQUI (BIA YE)'),
(18, 'AYOREO'),
(19, 'CANICHANA'),
(20, 'CAYUBABA'),
(21, 'CHIQUITANOS (BESIRO)'),
(22, 'ITONAMA'),
(23, 'JAVERIANOS'),
(24, 'JOAQUINIANOS'),
(25, 'LECO'),
(26, 'LORETANO'),
(27, 'MORE'),
(28, 'MOSETEN'),
(29, 'MOVIMA'),
(30, 'TSIMANE'),
(31, 'YURACARE'),
(32, 'WENNHAYEK'),
(33, 'OTRA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nacionalidad`
--

CREATE TABLE `nacionalidad` (
  `idnacionalidad` int(11) NOT NULL,
  `nacionalidad` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nacionalidad`
--

INSERT INTO `nacionalidad` (`idnacionalidad`, `nacionalidad`) VALUES
(1, 'BOLIVIANA'),
(2, 'EXTRANJERO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_curricular`
--

CREATE TABLE `nivel_curricular` (
  `idnivel_curricular` int(11) NOT NULL,
  `nivel_curricular` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nivel_curricular`
--

INSERT INTO `nivel_curricular` (`idnivel_curricular`, `nivel_curricular`) VALUES
(1, 'PERSONAL DE APOYO'),
(2, 'PROFESIONAL-TÉCNICO'),
(3, 'EJECUTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel_establecimiento`
--

CREATE TABLE `nivel_establecimiento` (
  `idnivel_establecimiento` int(11) NOT NULL,
  `nivel_establecimiento` varchar(45) DEFAULT NULL,
  `nivel_oficial` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nivel_establecimiento`
--

INSERT INTO `nivel_establecimiento` (`idnivel_establecimiento`, `nivel_establecimiento`, `nivel_oficial`) VALUES
(1, '1er NIVEL ', 'NIVEL'),
(2, '2do NIVEL ', 'NIVEL'),
(3, '3er NIVEL ', 'NIVEL'),
(4, 'Banco de Sangre', 'NIVEL'),
(5, 'C. Aislamiento', 'OTRO'),
(6, 'CCESD', 'OTRO'),
(7, 'IDE', 'OTRO'),
(8, 'T. Nuclear', 'OTRO'),
(9, 'Vacunatorio', 'OTRO'),
(10, 'Penitenciarias', 'OTRO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre`
--

CREATE TABLE `nombre` (
  `idnombre` int(11) NOT NULL,
  `paterno` varchar(45) DEFAULT NULL,
  `materno` varchar(45) DEFAULT NULL,
  `nombre` varchar(45) DEFAULT NULL,
  `ci` varchar(45) DEFAULT NULL,
  `complemento` varchar(45) DEFAULT NULL,
  `exp` varchar(45) DEFAULT NULL,
  `fecha_nac` date DEFAULT NULL,
  `idnacionalidad` int(11) DEFAULT NULL,
  `idgenero` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nombre`
--

INSERT INTO `nombre` (`idnombre`, `paterno`, `materno`, `nombre`, `ci`, `complemento`, `exp`, `fecha_nac`, `idnacionalidad`, `idgenero`) VALUES
(1, 'Yapuchura', 'Chuquimia', 'Luis Gonzalo', '5966306', NULL, 'LP', '1982-07-25', 1, 2),
(2, 'Calle', 'Salcedo', 'Juan Marcelo', '6103812', '', 'LP', '1984-05-16', 1, 2),
(3, 'Casta&ntilde;on', 'Espinoza', 'Jose Daniel', '8989899', '', 'LP', '1982-07-22', 1, 2),
(4, 'Carani', 'Choque', 'Angel ', '3454123', '', 'LP', '1973-01-03', 1, 2),
(5, 'Coca', 'Mamani', 'Liz', '5543123', '', 'LP', '1988-09-15', 1, 1),
(6, 'Pardo', 'Alcocer', 'Angela', '4952971', '', 'LP', '1987-01-12', 1, 1),
(7, 'Huarita', 'Orozco', 'Luis ', '3443505', '', 'LP', '2080-08-09', 1, 2),
(8, 'Castro', 'Landivar', 'Karenine ', '4693242', '', 'SC', '1982-07-12', 1, 1),
(9, 'Flores ', 'Lucas', 'Evans Carlos ', '5116331', '', 'PO', '1980-07-14', 1, 2),
(10, 'Garcia', 'Suarez', 'Helen Tatiana', '6301836', '', 'SC', '1985-01-16', 1, 1),
(11, 'Ticona', 'Rodriguez', 'Ruben', '4021514', '', 'OR', '1977-02-18', 1, 2),
(12, 'Grigoriu', 'Méndez', 'Virginia Adriana', '5291102', '', 'CB', '1984-03-05', 1, 1),
(13, 'Magne', 'Calle', 'José Silvestre', '5971333', '', 'LP', '1984-05-12', 1, 2),
(14, 'Chavez', 'Lima', 'Mónica Carola', '4792874', '', 'LP', '1978-05-04', 1, 1),
(15, 'Muñoz', 'Mendez', 'Carlos Eddy ', '1079799', '', 'CH', '1962-07-07', 1, 2),
(16, 'Nava', 'Machaca', 'Nestor Hugo', '3133874', '', 'CB', '2023-08-04', 1, 2),
(17, 'Gallo', 'Chavaría', 'Huguett Lorna', '5664902', '', 'CH', '1985-02-11', 1, 1),
(18, 'Zambrana', 'Lara', 'Leny', '4176112', '', 'BE', '1980-12-21', 1, 1),
(19, 'Perales', 'Nieves', 'América', '5043838', '', 'TJ', '1984-02-25', 1, 1),
(20, 'Vasquez ', 'Otalora', 'Ycela Remedios', '3839707', '', 'SC', '1971-11-21', 1, 1),
(21, 'Rasguido', 'Serrudo', 'Raul', '3626104', '', 'CH', '1974-02-13', 1, 2),
(22, 'Enriquez', 'Velasquez', 'Mirtha Aydee', '3643748', '', 'CH', '1974-02-25', 1, 1),
(23, 'Quisbert ', 'Fuentes ', 'José Edgar ', '3933560', '', 'SC', '1975-06-17', 1, 2),
(24, 'Molina', 'Arce', 'Qoriwara Elizabeth', '7278340', '', 'OR', '1989-12-10', 1, 1),
(25, 'Pally', 'Montaño', 'Sonia', '4022301', '', 'OR', '1979-02-20', 1, 1),
(26, 'Romero', 'Romero', 'Mirian Eugenia ', '5002327', '', 'TJ', '1978-03-04', 1, 1),
(27, 'Colque', 'Calsina', 'Angel', '6009670', '', 'LP', '1982-12-25', 1, 2),
(28, 'Zeballos', 'Ortiz', 'Moises Jose', '4091334', '', 'CH', '1985-03-29', 1, 2),
(29, 'Velasquez', 'Soliz', 'Ximena Alejandra ', '4020217', '', 'OR', '1979-01-02', 1, 1),
(30, 'Patón', 'Nuñez', 'Juan Carlos', '4966390', '', 'LP', '1973-08-23', 1, 2),
(31, 'Zurita', 'Alcón', 'Jimmy', '7942971', '', 'LP', '1970-08-28', 1, 2),
(32, 'Villazón', 'Ortíz', 'Ángela', '4765231', '', 'LP', '1989-12-25', 1, 1),
(33, 'Aquino', 'Checa', 'Telma Jeannette', '5066491', '', 'OR', '1982-04-14', 1, 1),
(34, 'Cortéz', 'Medrano', 'Angel', '5966310', '', 'LP', '1970-09-12', 1, 2),
(35, 'Quispe', 'Menacho', 'Adela', '5966311', '', 'LP', '1980-07-11', 1, 1),
(36, 'Casas', 'Mamani', 'Gabriel', '5966312', '', 'LP', '1993-09-01', 1, 2),
(37, 'Tancara', 'Chuquimia', 'Timoteo', '4966309', '', 'LP', '1973-09-01', 1, 2),
(38, 'Cabrera', 'Segura', 'German', '4966301', '', 'LP', '1960-09-01', 1, 2),
(39, 'Espejo', 'Zarate', 'Genoveva', '4966311', '', 'LP', '1985-09-01', 1, 1),
(40, 'Cruz', 'Aguilar', 'Efrain', '4789110', '', 'LP', '1960-09-01', 1, 2),
(41, 'Choque', 'Condori', 'Grover', '4567321', '', 'LP', '1980-09-01', 1, 2),
(42, 'Baltazar', 'Alquiza', 'Jhonatan', '3452131', '', 'LP', '1993-09-01', 1, 2),
(43, 'Pablo', 'Cayoja', 'Janett', '2431243', '', 'LP', '1943-09-12', 1, 1),
(44, 'Castro', 'Medina', 'Bernabe ', '4321521', '', 'LP', '1978-07-22', 1, 2),
(45, 'Villamor', 'Encinas', 'Adela', '4321678', '', 'LP', '1976-09-21', 1, 1),
(46, 'Aracibia', 'Nogales', 'Juan Carlos', '4132311', '', 'LP', '1970-08-03', 1, 2),
(47, 'Córdova', 'Aliaga', 'Jose Luis', '3432121', '', 'LP', '1979-10-12', 1, 2),
(48, 'Gutierrez', 'Mamani', 'Luis', '4967521', '', 'LP', '1982-06-06', 1, 2),
(49, 'Tarqui', 'Villarroel', 'Helen', '6098123', '', 'LP', '1993-09-04', 1, 1),
(50, 'Gutierrez', 'Careaga', 'Esteban', '498732', '', 'LP', '1979-09-09', 1, 2),
(51, 'Gonzales', 'Rojas', 'Daniel ', '4421234', '1M', 'LP', '1965-09-04', 1, 2),
(52, 'Rodriguez', 'Beltran', 'Antonio', '4321321', '', 'LP', '1978-09-04', 1, 2),
(53, 'Velasquez', 'Alacoria', 'Noemi ', '6942971', '', 'LP', '1997-09-11', 1, 1),
(54, 'Tejerina', 'Chavez', 'Alberto', '3452121', '', 'LP', '1989-09-11', 1, 2),
(55, 'Chavez', 'Mendieta', 'Carlos', '3232412', '', 'LP', '1989-09-11', 1, 2),
(56, 'Choquehuanca', 'Mamani', 'Jorge', '4387612', '', 'LP', '1982-09-12', 1, 2),
(57, 'Zurita', 'Calle', 'Humberto', '2341534', '', 'LP', '1978-09-12', 1, 2),
(58, 'Cespedes', 'Tapia', 'Ernesto', '4532671', '', 'LP', '1973-09-11', 1, 2),
(59, 'Gutierrez', 'Catacora', 'Evans', '4321527', '', 'LP', '1988-09-05', 1, 2),
(60, 'Suarez', 'Mendez', 'Anselmo ', '4321567', '', 'LP', '1980-09-13', 1, 2),
(61, 'Gonzales', 'Jimenez', 'Jose Alberto', '4789321', '', 'LP', '1972-09-12', 1, 2),
(62, 'Laura', 'Apaza', 'Jose Luis ', '5432123', '', 'LP', '1970-09-04', 1, 2),
(63, 'Callejas', 'Choque', 'Jesus Marcelo', '4351234', '', 'LP', '1980-09-13', 1, 2),
(64, 'Alarcon', 'Mejia', 'Juan Carlos', '4535656', '', 'LP', '1983-09-23', 1, 2),
(65, 'Miranda', 'Lucana', 'Mabel', '5432671', '', 'LP', '2023-10-02', 1, 1),
(66, 'Pablo', 'Cayoja', 'Ivonne', '5432679', '', 'LP', '2023-10-04', 1, 1),
(67, 'Baltazar', 'Quispe', 'juan', '5432680', '', 'LP', '1983-10-04', 1, 2),
(68, 'Zabala', 'Pérez', 'Noelia', '5432677', '', 'LP', '1993-10-04', 1, 1),
(69, 'Machicado', 'Lopez', 'Ernesto ', '5432698', '', 'LP', '1993-10-04', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_academico`
--

CREATE TABLE `nombre_academico` (
  `idnombre_academico` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `idprofesion` int(11) DEFAULT NULL,
  `idespecialidad_medica` int(11) DEFAULT NULL,
  `idformacion_academica` int(11) DEFAULT NULL,
  `descripcion_academica` text,
  `entidad_academica` text,
  `gestion` varchar(45) DEFAULT NULL,
  `idformacion_academica_p` int(11) DEFAULT NULL,
  `descripcion_academica_p` text,
  `entidad_academica_p` text,
  `gestion_p` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nombre_academico`
--

INSERT INTO `nombre_academico` (`idnombre_academico`, `idusuario`, `idnombre`, `idprofesion`, `idespecialidad_medica`, `idformacion_academica`, `descripcion_academica`, `entidad_academica`, `gestion`, `idformacion_academica_p`, `descripcion_academica_p`, `entidad_academica_p`, `gestion_p`) VALUES
(1, 23, 22, 1, 23, 4, 'descripcion_academica', 'entidad_academica', '2020', NULL, NULL, NULL, NULL),
(2, 60, 53, 1, 3, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'Universidad Publica de El Alto ', '2019', NULL, NULL, NULL, NULL),
(3, 61, 54, 1, 6, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'Universidad Mayor de San Andres', '2005', NULL, NULL, NULL, NULL),
(4, 62, 55, 1, 6, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '2009', NULL, NULL, NULL, NULL),
(5, 63, 56, 1, 13, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRÉS', '1998', NULL, NULL, NULL, NULL),
(6, 64, 57, 1, 3, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '1999', NULL, NULL, NULL, NULL),
(7, 69, 62, 1, 23, 4, 'Descripcion_academica', 'Entidad_academica', '1999', 6, 'Descripcion_academica_p', 'Entidad_academica_p', '2020'),
(8, 70, 63, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UMSA', '1999', 6, 'ESPCECIALIZACION SAFCI', 'SAFCI', '2020'),
(9, 71, 64, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '2009', 5, 'DIPLOMADO EN EDUCACIÓN SUPERIOR', 'UMSA', '2020'),
(10, 71, 64, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'FORMACIÓN DE PREGRADO/GRADO', '2009', 6, 'DIPLOMADO EN GESTION DE LA SALUD', 'UMSA', '2012'),
(11, 71, 64, 1, 46, 4, 'FORMACIÓN DE GRADO', 'ENTIDAD DE FORMACIÓN DE GRADO ', 'GESTION', 5, 'DIPLOMADO EN SISTEMAS ADMINISTRATIVOS EN SALUD', 'UMSA', '2019'),
(12, 71, 64, 1, 46, 4, 'FORMACIÓN DE GRADO', 'ENTIDAD DE FORMACIÓN DE GRADO ', 'GESTION', 6, 'PLANIFICACIÓN DE MEDIANO Y CORTO PLAZO', 'CGE', '2018'),
(13, 70, 63, 1, 46, 4, 'FORMACIÓN DE GRADO', 'ENTIDAD DE FORMACIÓN DE GRADO ', 'GESTION', 5, 'DIPLOMADO EN ALTOS ESTUDIOS NACIONALES', 'ESTADO MAYOR', '2019'),
(14, 72, 65, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '2007', 5, 'DIPLOMADO EN EDUCACIÓN SUPERIOR', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '2016'),
(15, 73, 66, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SANA ANDRES', '2020', 5, 'DIPLOMADO EN EDUCACIÓN SUPERIOR', 'UNIVERSIDAD MAYOR DE SANA ANDRES-UNIDAD DE POSGRADO', '2021'),
(16, 74, 67, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRES', '2009', 6, 'ESPECIALIDAD SAFCI', 'PROGRAMA SAFCI - MI SALUD', '2021'),
(17, 75, 68, 1, 6, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRÉS', '2010', 5, 'DIPLOMADO EN EDUCACIÓN SUPERIOR', 'POSGRADO - UNIVERSIDAD MAYOR DE SAN ANDRÉS', '2018'),
(18, 76, 69, 1, 46, 4, 'FORMACIÓN DE PREGRADO/GRADO', 'UNIVERSIDAD MAYOR DE SAN ANDRÉS', '2010', 6, 'SALUD FAMILIAR COMUNITARIA INTERCULTURAL', 'PROGRAMA SAFCI - MI SALUD', '2020'),
(19, 75, 68, 1, 6, 4, 'FORMACIÓN DE GRADO', 'ENTIDAD DE FORMACIÓN DE GRADO ', 'GESTION', 5, 'ECOGRAFIA', 'UMSA', '2020');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_datos`
--

CREATE TABLE `nombre_datos` (
  `idnombre_datos` int(11) NOT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idformacion_academica` int(11) DEFAULT NULL,
  `idprofesion` int(11) DEFAULT NULL,
  `idespecialidad_medica` int(11) DEFAULT NULL,
  `correo` text,
  `celular` text,
  `direccion_dom` text,
  `iddepartamento` int(11) DEFAULT NULL,
  `celular_emergencia` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `nombre_datos`
--

INSERT INTO `nombre_datos` (`idnombre_datos`, `idnombre`, `idusuario`, `idformacion_academica`, `idprofesion`, `idespecialidad_medica`, `correo`, `celular`, `direccion_dom`, `iddepartamento`, `celular_emergencia`) VALUES
(1, 1, 1, 4, 11, 45, 'gonzalo.yapuchura1982@gmail.com', '79109937', 'Calle B Nro. 127 Zona F Villa Dolores', 4, NULL),
(2, 2, 3, 4, 6, 45, 'jhoan.marchelo@gmail.com', '73222864', 'Avenida Peru S/N Zona Central', 4, NULL),
(3, 3, 4, 4, 1, 41, 'daniel@gmail.com', '78103345', 'Calle 27 De Cota Cota Zona Sur', NULL, NULL),
(4, 4, 5, 4, 6, 45, 'angel@gmail.com', '78245612', NULL, 4, NULL),
(5, 5, 6, 4, 3, 45, 'lizcoca@gmail.com', '63124551', NULL, 5, NULL),
(6, 6, 7, 4, 5, 45, 'angelapardo@gmail.com', '78181089', NULL, 4, NULL),
(7, 7, 8, 4, 1, 41, 'lucho9cito@gmail.com', '68016000', NULL, 4, NULL),
(8, 8, 10, 4, 1, 41, 'kareninematias@gmail.com', '72370631', NULL, 1, NULL),
(9, 10, 12, 4, 1, 41, 'doctorahelen2022@gmail.com', '73687640', NULL, 8, NULL),
(10, 11, 13, 4, 1, 41, 'sandrofran77@gmail.com', '71392638', NULL, 2, NULL),
(11, 12, 14, 4, 1, 41, 'vicky.grigoriu@gmail.com', '67560928', NULL, 2, NULL),
(12, 13, 15, 4, 1, 41, 'catacora.mi.salud@gmail.com', '67075479', NULL, 4, NULL),
(13, 14, 16, 4, 1, 41, 'moncarchavezlima@gmail.com', '72523036', NULL, 4, NULL),
(14, 15, 17, 4, 1, 41, 'camum69@gmail.com', '67651689', NULL, 3, NULL),
(15, 16, 18, 4, 1, 41, 'hugo.amistad.SAFCI@gmail.com', '74721416', NULL, 1, NULL),
(16, 17, 19, 5, 1, 41, 'huguettgallo85@gmail.com', '67603480', NULL, 3, NULL),
(17, 18, 20, 4, 1, 41, 'lennyzam21@hotmail.com', '72816291', NULL, 1, NULL),
(18, 9, 9, 4, 1, 41, 'evans@gmail.com', '72078078', 'Direccion', 7, NULL),
(19, 19, 21, 4, 1, 41, 'wiela_10@hotmail.com', '76185602', NULL, 9, NULL),
(20, 20, 22, 4, 1, 41, 'guiselitarobore.sc@gmail.com', '76386087', NULL, 8, NULL),
(21, 21, 23, 5, 1, 41, 'raulrasguido@gmail.com', '73866045', NULL, 7, NULL),
(22, 22, 24, 4, 1, 41, 'mirthaaydeeenriquez40@gmail.com', '68620988', NULL, 3, NULL),
(23, 23, 25, 4, 1, 41, 'joseqf3@gmail.com', '71038236', NULL, 8, NULL),
(24, 24, 26, 4, 1, 41, 'elizabethcema333@gmail.com ', '73848968', NULL, 2, NULL),
(25, 25, 27, 4, 1, 41, 'soniapallymontano@gmail.com', '60426154', NULL, 5, NULL),
(26, 26, 28, 4, 1, 41, 'mirianrom4@gmail.com', '72970289', NULL, 9, NULL),
(27, 0, 30, 4, 1, 41, 'Karlattas1@gmail.com', '72420915', NULL, 7, NULL),
(28, 28, 31, 4, 1, 41, 'moises.zeballos.ortiz@gmail.com', '72872062', NULL, 3, NULL),
(29, 29, 32, 4, 1, 41, 'ximouse79@gmail.com', '68285682', NULL, 5, NULL),
(30, 30, 33, 4, 8, 45, 'juan@gmail.com', '79109937', NULL, 4, NULL),
(31, 31, 34, 4, 1, 41, 'jimmy@gmail.com', '79109937', NULL, 4, NULL),
(32, 32, 35, 4, 6, 45, 'angela@gmail.com', '79109937', NULL, 4, NULL),
(33, 33, 36, 4, 1, 41, 'telmacheca1982@gmail.com', '73835225', NULL, 5, NULL),
(34, 34, 40, 4, 1, 12, 'angel@gmail.com', '79109937', NULL, 4, NULL),
(35, 35, 41, 4, 1, 41, 'adela@gmail.com', '79109937', NULL, 4, NULL),
(36, 36, 42, 4, 1, 39, 'gabriel@gmail.com', '79109937', NULL, 4, NULL),
(37, 37, 43, 4, 1, 6, 'timoteo@gmail.com', '79109937', NULL, 4, NULL),
(38, 38, 44, 4, 1, 10, 'german@gmail.com', '79109937', NULL, 4, NULL),
(39, 39, 45, 4, 1, 26, 'genoveva@gmail.com', '79109937', NULL, 4, NULL),
(40, 40, 46, 4, 1, 46, 'efrain@gmail.com', '79109937', 'Calle B Nro 127 Zona F Villa Dolores', 4, NULL),
(41, 41, 47, 4, 4, 45, 'grover@gmail.com', '79109937', 'Avenida Sucre Nro 123 Zona Central', 4, NULL),
(42, 42, 48, 4, 1, 6, 'jhonatan@gmail.com', '79109937', 'Calle B Nro 34 ', 4, NULL),
(43, 43, 49, 4, 1, 3, 'janepablo@gmail.com', '79109937', 'Av. del Policia Nro.231', 4, NULL),
(44, 44, 50, 4, 1, 3, 'berni@gmail.com', '79109937', 'Direccion Domicilio', 4, NULL),
(45, 45, 51, 4, 1, 33, 'adela@gmail.com', '79109937', 'Calle B Nro 127', 4, NULL),
(46, 46, 52, 4, 1, 6, 'juan@gmail.com', '79109937', 'Direccion domicilio', 4, NULL),
(47, 47, 53, 4, 1, 6, 'jose_luis@gmail.com', '79109937', 'Dirección Domicilio', 4, NULL),
(48, 48, 54, 4, 1, 11, 'luis@gmail.com', '79109937', 'Dirección Domicilio', 4, NULL),
(49, 49, 55, 4, 1, 33, 'helen@gmail.com', '79109936', 'Direccion/domicilio.', 4, NULL),
(50, 50, 56, 4, 1, 42, 'estebancambiasso@gmail.com', '61101799', 'DIRECCI&Oacute;N/DOMICILIO/CALLE', 4, NULL),
(51, 0, 57, 4, 1, 32, 'german@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, NULL),
(52, 51, 58, 4, 1, 22, 'daniel.gonzales@gmail.com', '79109937', 'DIRECCI&Oacute;N/DOMICILIO', 4, NULL),
(53, 52, 59, 4, 5, 45, 'antonio_zorro@gmail.com', '79109939', 'DIRECCI&Oacute;N/DOMICILIO', 4, NULL),
(54, 53, 60, 4, 1, 3, 'noemi@gmail.com', '61898231', 'DIRECCIÓN/DOMICILIO', 4, NULL),
(55, 54, 61, 4, 1, 6, 'alberto@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, NULL),
(56, 55, 62, 4, 1, 6, 'carlos@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, NULL),
(57, 56, 63, 4, 1, 13, 'jorge@gmail.com', '79109927', 'DIRECCIÓN/DOMICILIO', 4, NULL),
(58, 57, 64, 4, 1, 3, 'humberto@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, NULL),
(59, 61, 68, 4, 1, 6, 'jose_alberto@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '70898231'),
(60, 62, 69, 4, 1, 3, 'jose_luis@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '70976432'),
(61, 63, 70, 4, 1, 46, 'jesus@gmail.com', '79109937', 'DIRECCI&Oacute;N/DOMICILIO', 4, '70897213'),
(62, 64, 71, 4, 1, 46, 'juan_carlos@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '67123412'),
(63, 65, 72, 4, 1, 46, 'mabel@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '78595002'),
(64, 66, 73, 4, 1, 46, 'ivonne@gmail.com', '79109937', 'AVENIDA GENERAL LANZA - CRISTO REY-LA PAZ', 4, '61101789'),
(65, 67, 74, 4, 1, 46, 'juan@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '61101789'),
(66, 68, 75, 4, 1, 6, 'noelia@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '61101789'),
(67, 69, 76, 4, 1, 46, 'ernesto@gmail.com', '79109937', 'DIRECCIÓN/DOMICILIO', 4, '61101789');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `objetivo_anual`
--

CREATE TABLE `objetivo_anual` (
  `idobjetivo_anual` int(11) NOT NULL,
  `idplan_anual` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `objetivo_anual` text,
  `meta` int(11) DEFAULT NULL,
  `presupuesto` bigint(16) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `gestion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `objetivo_anual`
--

INSERT INTO `objetivo_anual` (`idobjetivo_anual`, `idplan_anual`, `correlativo`, `codigo`, `objetivo_anual`, `meta`, `presupuesto`, `idusuario`, `gestion`) VALUES
(1, 1, 1, 'OBJ-1/2023', 'Capacitar en temas de Salud familiar Comunitario e Intercultural a Servidores Públicos del Sector Salud en la modalidad virtual a nivel nacional', 70, 7000, 1, '2023');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida_presup`
--

CREATE TABLE `partida_presup` (
  `idpartida_presup` int(11) NOT NULL,
  `partida_presup` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `partida_presup`
--

INSERT INTO `partida_presup` (`idpartida_presup`, `partida_presup`) VALUES
(1, '255'),
(2, '256'),
(3, '257');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE `perfil` (
  `idperfil` int(11) NOT NULL,
  `perfil` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`idperfil`, `perfil`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'PERSONAL'),
(3, 'ADM-ESTABLECIMIENTO'),
(4, 'ADM-DEPARTAMENTAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `idpersonal` int(11) NOT NULL,
  `idusuario` int(11) DEFAULT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `idnombre_datos` int(11) DEFAULT NULL,
  `idnombre_academico` int(11) DEFAULT NULL,
  `iddato_laboral` int(11) DEFAULT NULL,
  `correlativo` int(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `idestado_personal` int(11) DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `hora_registro` varchar(45) DEFAULT NULL,
  `gestion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`idpersonal`, `idusuario`, `idnombre`, `idnombre_datos`, `idnombre_academico`, `iddato_laboral`, `correlativo`, `codigo`, `idestado_personal`, `fecha_registro`, `hora_registro`, `gestion`) VALUES
(1, 40, 34, 34, NULL, 36, 1, 'PS/MSYD-1-5966310-2023', 1, '2023-09-01', '04:03', '2023'),
(2, 41, 35, 35, NULL, 37, 2, 'PS/MSYD-2-5966311-2023', 1, '2023-09-01', '04:09', '2023'),
(3, 42, 36, 36, NULL, 38, 3, 'PS/MSYD-3-5966312-2023', 1, '2023-09-01', '04:18', '2023'),
(4, 43, 37, 37, NULL, 39, 4, 'PS/MSYD-4-4966309-2023', 1, '2023-09-01', '04:22', '2023'),
(5, 44, 38, 38, NULL, 40, 5, 'PS/MSYD-5-4966301-2023', 1, '2023-09-01', '05:00', '2023'),
(6, 45, 39, 39, NULL, 0, 6, 'PS/MSYD-6-4966311-2023', 1, '2023-09-01', '05:04', '2023'),
(7, 46, 40, 40, NULL, 41, 7, 'PS/MSYD-7-4789110-2023', 1, '2023-09-01', '05:19', '2023'),
(8, 47, 41, 41, NULL, 42, 8, 'PS/MSYD-8-4567321-2023', 1, '2023-09-01', '05:28', '2023'),
(9, 48, 42, 42, NULL, 43, 9, 'PS/MSYD-9-3452131-2023', 1, '2023-09-01', '06:44', '2023'),
(10, 49, 43, 43, NULL, 44, 10, 'PS/MSYD-10-2431243-2023', 1, '2023-09-04', '09:29', '2023'),
(11, 50, 44, 44, NULL, 45, 11, 'PS/MSYD-11-4321521-2023', 1, '2023-09-04', '09:47', '2023'),
(12, 51, 45, 45, NULL, 46, 12, 'PS/MSYD-12-4321678-2023', 1, '2023-09-04', '10:21', '2023'),
(13, 52, 46, 46, NULL, 47, 13, 'PS/MSYD-13-4132311-2023', 1, '2023-09-04', '10:33', '2023'),
(14, 53, 47, 47, NULL, 48, 14, 'PS/MSYD-14-3432121-2023', 1, '2023-09-04', '10:41', '2023'),
(15, 54, 48, 48, NULL, 49, 15, 'PS/MSYD-15-4967521-2023', 1, '2023-09-04', '10:50', '2023'),
(16, 55, 49, 49, NULL, 64, 16, 'PS/MSYD-16-6098123-2023', 1, '2023-09-04', '04:00', '2023'),
(17, 56, 50, 50, NULL, 51, 17, 'PS/MSYD-17-4987321-2023', 1, '2023-09-05', '11:57', '2023'),
(18, 57, 0, 51, NULL, 52, 18, 'PS/MSYD-18-4765321-2023', 1, '2023-09-05', '04:49', '2023'),
(19, 58, 51, 52, NULL, 53, 19, 'PS/MSYD-19-4421234-2023', 1, '2023-09-05', '05:11', '2023'),
(20, 59, 52, 53, NULL, 54, 20, 'PS/MSYD-20-4321321-2023', 1, '2023-09-06', '03:41', '2023'),
(21, 60, 53, 54, NULL, 65, 21, 'PS/MSYD-21-6942971-2023', 1, '2023-09-11', '04:51', '2023'),
(22, 61, 54, 55, NULL, 0, 22, 'PS/MSYD-22-3452121-2023', 1, '2023-09-11', '05:27', '2023'),
(23, 62, 55, 56, NULL, 66, 23, 'PS/MSYD-23-3232412-2023', 1, '2023-09-11', '05:41', '2023'),
(24, 63, 56, 57, NULL, 67, 24, 'PS/MSYD-24-4387612-2023', 1, '2023-09-12', '11:11', '2023'),
(25, 64, 57, 58, NULL, 68, 25, 'PS/MSYD-25-2341534-2023', 1, '2023-09-12', '03:06', '2023'),
(26, 65, 58, 65, NULL, 69, 26, 'PS/MSYD-26-4532671-2023', 1, '2023-09-12', '06:37', '2023'),
(27, 66, 59, 66, NULL, 70, 27, 'PS/MSYD-27-4321527-2023', 1, '2023-09-13', '10:10', '2023'),
(28, 67, 60, 67, NULL, 71, 28, 'PS/MSYD-28-4321567-2023', 1, '2023-09-13', '10:37', '2023'),
(29, 68, 61, 59, NULL, 72, 29, 'PS/MSYD-29-4789321-2023', 1, '2023-09-13', '10:50', '2023'),
(30, 69, 62, 60, NULL, 73, 30, 'PS/MSYD-30-5432123-2023', 1, '2023-09-13', '11:12', '2023'),
(31, 70, 63, 61, 13, 78, 31, 'PS/MSYD-31-4351234-2023', 1, '2023-09-13', '12:12', '2023'),
(32, 71, 64, 62, 12, 77, 32, 'PS/MSYD-32-4535656-2023', 1, '2023-09-13', '05:11', '2023'),
(33, 72, 65, 63, NULL, 79, 33, 'PS/MSYD-33-5432671-2023', 1, '2023-10-03', '09:39', '2023'),
(34, 73, 66, 64, NULL, 80, 34, 'PS/MSYD-34-5432679-2023', 1, '2023-10-04', '09:30', '2023'),
(35, 74, 67, 65, NULL, 81, 35, 'PS/MSYD-35-5432680-2023', 1, '2023-10-04', '11:05', '2023'),
(36, 75, 68, 66, 19, 84, 36, 'PS/MSYD-36-5432677-2023', 1, '2023-10-04', '04:39', '2023'),
(37, 76, 69, 67, 18, 83, 37, 'PS/MSYD-37-5432698-2023', 1, '2023-10-04', '05:36', '2023');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_anual`
--

CREATE TABLE `plan_anual` (
  `idplan_anual` int(11) NOT NULL,
  `denominacion` text,
  `gestion` varchar(45) DEFAULT NULL,
  `idtipo_documento` int(11) DEFAULT NULL,
  `fecha_aprob` date DEFAULT NULL,
  `vigencia_i` date DEFAULT NULL,
  `vigencia_f` date DEFAULT NULL,
  `no_doc` varchar(45) DEFAULT NULL,
  `idpartida_presup` int(11) DEFAULT NULL,
  `presupuesto` bigint(11) DEFAULT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `plan_anual`
--

INSERT INTO `plan_anual` (`idplan_anual`, `denominacion`, `gestion`, `idtipo_documento`, `fecha_aprob`, `vigencia_i`, `vigencia_f`, `no_doc`, `idpartida_presup`, `presupuesto`, `codigo`, `idusuario`) VALUES
(1, 'PLAN DE CAPACITACI&Oacute;N CONTINUA MDSYD - 2023', '2023', 1, '2023-05-05', '2023-05-08', '2023-12-29', 'MDS-RES-2024', 2, 84000, 'P-2023', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ponderacion`
--

CREATE TABLE `ponderacion` (
  `idponderacion` int(11) NOT NULL,
  `valor` int(11) DEFAULT NULL,
  `ponderacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `ponderacion`
--

INSERT INTO `ponderacion` (`idponderacion`, `valor`, `ponderacion`) VALUES
(1, 1, 'No suficiente'),
(2, 2, 'Suficiente'),
(3, 3, 'Bueno'),
(4, 4, 'Muy Bueno'),
(5, 5, 'Excelente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesion`
--

CREATE TABLE `profesion` (
  `idprofesion` int(11) NOT NULL,
  `profesion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `profesion`
--

INSERT INTO `profesion` (`idprofesion`, `profesion`) VALUES
(1, 'Medico'),
(2, 'Lic. en Enfermería'),
(3, 'Lic. en Administración de Empresas'),
(4, 'Lic. en Economía'),
(5, 'Lic. en Contaduria'),
(6, 'Lic. en Informatica'),
(7, 'Lic. en Bibliotecologia'),
(8, 'Lic. en Contaduría'),
(9, 'Ing. en Sistemas'),
(10, 'Ing. Civil'),
(11, 'Ing. en Electrónica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE `provincias` (
  `idprovincia` int(11) NOT NULL,
  `iddepartamento` int(11) NOT NULL,
  `provincia` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`idprovincia`, `iddepartamento`, `provincia`) VALUES
(1, 1, 'Yacuma'),
(2, 1, 'Vaca Diez'),
(3, 1, 'Itenez'),
(4, 1, 'Marban'),
(5, 1, 'Mamore'),
(6, 1, 'Jose Ballivian'),
(7, 1, 'Moxos'),
(8, 1, 'Cercado'),
(9, 2, 'Campero'),
(10, 2, 'Esteban Arce'),
(11, 2, 'Arani'),
(12, 2, 'Arque'),
(13, 2, 'Bolivar'),
(14, 2, 'Capinota'),
(15, 2, 'German Guzman'),
(16, 2, 'Cercado'),
(17, 2, 'Quillacollo'),
(18, 2, 'Chapare'),
(19, 2, 'Punata'),
(20, 2, 'Carrasco'),
(21, 2, 'Ayopaya'),
(22, 2, 'Tapacari'),
(23, 2, 'Tiraque'),
(24, 2, 'Mizque'),
(25, 3, 'Nor Cinti'),
(26, 3, 'Sud Cinti'),
(27, 3, 'Tomina'),
(28, 3, 'Luis Calvo'),
(29, 3, 'Zudañez'),
(30, 3, 'Hernando Siles'),
(31, 3, 'Oropeza'),
(32, 3, 'Yamparaez'),
(33, 3, 'Azurduy'),
(34, 3, 'Belisario Boeto'),
(35, 4, 'Omasuyos'),
(36, 4, 'Ingavi'),
(37, 4, 'Franz Tamayo'),
(38, 4, 'Aroma'),
(39, 4, 'Los Andes'),
(40, 4, 'Loayza'),
(41, 4, 'Inquisivi'),
(42, 4, 'Pacajes'),
(43, 4, 'Caranavi'),
(44, 4, 'Jose Manuel Pando'),
(45, 4, 'Gualberto Villarroel'),
(46, 4, 'Sud Yungas'),
(47, 4, 'Muñecas'),
(48, 4, 'Larecaja'),
(49, 4, 'Manco Kapac'),
(50, 4, 'Nor Yungas'),
(51, 4, 'Bautista Saavedra'),
(52, 4, 'Murillo'),
(53, 4, 'Camacho'),
(54, 4, 'Abel Iturralde'),
(55, 5, 'Sud Carangas'),
(56, 5, 'Poopo'),
(57, 5, 'Cercado'),
(58, 5, 'Puerto de Mejillones'),
(59, 5, 'Eduardo Avaroa'),
(60, 5, 'Atahuallpa'),
(61, 5, 'Carangas'),
(62, 5, 'Litoral de Atacama'),
(63, 5, 'Sajama'),
(64, 5, 'Tomas Barron'),
(65, 5, 'Pantaleon Dalence'),
(66, 5, 'Ladislao Cabrera'),
(67, 5, 'Sebastian Pagador'),
(68, 5, 'Nor Carangas'),
(69, 5, 'Saucari'),
(70, 5, 'San Pedro de Totora'),
(71, 6, 'Nicolas Suarez'),
(72, 6, 'Madre de Dios'),
(73, 6, 'Manuripi'),
(74, 6, 'Abuna'),
(75, 6, 'Federico Roman'),
(76, 7, 'Bernardino Bilbao Rioja'),
(77, 7, 'Sur Chichas'),
(78, 7, 'Tomas Frias'),
(79, 7, '\'José María Linares'),
(80, 7, 'Alonso de Ibañez'),
(81, 7, 'Cornelio Saavedra'),
(82, 7, 'Rafael Bustillo'),
(83, 7, 'Nor Lipez'),
(84, 7, 'Chayanta'),
(85, 7, 'Nor Chichas'),
(86, 7, 'Daniel Campos'),
(87, 7, 'Sur Lipez'),
(88, 7, 'Antonio Quijarro'),
(89, 7, 'Enrique Baldivieso'),
(90, 7, 'Charcas'),
(91, 7, 'Modesto Omiste'),
(92, 8, 'Andrés Ibáñez'),
(93, 8, 'Ichilo'),
(94, 8, 'Cordillera'),
(95, 8, 'German Busch'),
(96, 8, 'Sara'),
(97, 8, 'Manuel Maria Caballero'),
(98, 8, 'Ñuflo de Chávez'),
(99, 8, 'Guarayos'),
(100, 8, 'Obispo Santiestevan'),
(101, 8, 'Florida'),
(102, 8, 'Vallegrande'),
(103, 8, 'Warnes'),
(104, 8, 'Chiquitos'),
(105, 8, 'Velasco'),
(106, 8, 'Angel Sandoval'),
(107, 9, 'Aniceto Arce'),
(108, 9, 'Gran Chaco'),
(109, 9, 'Méndez'),
(110, 9, 'Burnet O\' Oconnor'),
(111, 9, 'Cercado'),
(112, 9, 'Aviles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

CREATE TABLE `publicacion` (
  `idpublicacion` int(11) NOT NULL,
  `publicacion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idpublicacion`, `publicacion`) VALUES
(1, 'INTERNA Y EXTERNA'),
(2, 'EXTERNA'),
(3, 'INTERNA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `red_salud`
--

CREATE TABLE `red_salud` (
  `idred_salud` int(11) NOT NULL,
  `red_salud` varchar(45) DEFAULT NULL,
  `iddepartamento` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `red_salud`
--

INSERT INTO `red_salud` (`idred_salud`, `red_salud`, `iddepartamento`) VALUES
(1, 'RED I - DISTRITO 1       ', 3),
(2, 'RED I - DISTRITO 2       ', 3),
(3, 'RED I - DISTRITO 3       ', 3),
(4, 'RED I - DISTRITO 4       ', 3),
(5, 'RED I - DISTRITO 5       ', 3),
(6, 'RED I - DISTRITO 6       ', 3),
(7, 'RED VII-DISTRITO 7       ', 3),
(8, 'RED VII-DISTRITO 8       ', 3),
(9, 'RED VII-DISTRITO 9       ', 3),
(10, 'RED I - HOSP 2DO NIVEL   ', 3),
(11, 'RED I - HOSP 3ER NIVEL   ', 3),
(12, 'RED DE SALUD VII RURAL   ', 3),
(13, 'RED DE SALUD IV AZURDUY  ', 3),
(14, 'RED DE SALUD II TARABUCO ', 3),
(15, 'RED DE SALUD V MONTEAGUDO', 3),
(16, 'RED DE SALUD III PADILLA ', 3),
(17, 'RED DE SALUD VI CAMARGO  ', 3),
(18, 'RED - 1 SUR OESTE        ', 4),
(19, 'RED - 2 NOR OESTE        ', 4),
(20, 'RED - 3 NORTE CENTRAL    ', 4),
(21, 'RED - 4 ESTE (N)         ', 4),
(22, 'RED - 5 SUR              ', 4),
(23, 'RED RURAL  6             ', 4),
(24, 'HOSP.TERCER NIVEL EL ALTO', 4),
(25, 'RED BOLIVIANO HOLANDES   ', 4),
(26, 'RED COREA                ', 4),
(27, 'RED DE SALUD SENKATA     ', 4),
(28, 'RED LOS ANDES            ', 4),
(29, 'RED LOTES Y SERVICIOS    ', 4),
(30, 'RED RURAL  4             ', 4),
(31, 'RED RURAL 11             ', 4),
(32, 'RED RURAL  1             ', 4),
(33, 'RED RURAL  2             ', 4),
(34, 'RED RURAL  3             ', 4),
(35, 'RED RURAL  5             ', 4),
(36, 'RED RURAL  7             ', 4),
(37, 'RED RURAL  8             ', 4),
(38, 'RED RURAL  9             ', 4),
(39, 'RED RURAL 12             ', 4),
(40, 'RED RURAL 13             ', 4),
(41, 'RED RURAL 14             ', 4),
(42, 'RED RURAL 15             ', 4),
(43, 'AZANAQUE                 ', 5),
(44, 'NORTE ORURO              ', 5),
(45, 'RED CUENCA POOPO (3)     ', 5),
(46, 'RED MINERA (2)           ', 5),
(47, 'RED OCCIDENTE            ', 5),
(49, 'RED URBANA (1)           ', 5),
(50, 'BETANZOS                 ', 7),
(51, 'COTAGAITA                ', 7),
(52, 'OCURI                    ', 7),
(53, 'POTOSI (RURAL)           ', 7),
(54, 'POTOSI (URBANO)          ', 7),
(55, 'PUNA                     ', 7),
(56, 'SACACA                   ', 7),
(57, 'TUPIZA                   ', 7),
(58, 'UNCIA                    ', 7),
(59, 'UYUNI                    ', 7),
(60, 'VILLAZON                 ', 7),
(61, 'CBBA (HOSPITALES)        ', 2),
(62, 'CBBA (NORTE)             ', 2),
(63, 'CBBA (SUD)               ', 2),
(64, 'AIQUILE                  ', 2),
(65, 'INDEPENDENCIA            ', 2),
(66, 'QUILLACOLLO              ', 2),
(67, 'TARATA                   ', 2),
(68, 'PUNATA                   ', 2),
(69, 'CAPINOTA                 ', 2),
(71, 'RED DE SALUD III PADILLA ', 2),
(72, 'SACABA                   ', 2),
(73, 'RED INDIGENA DE SALUD    ', 2),
(74, 'VILLA TUNARI             ', 2),
(75, 'TAPACARI                 ', 2),
(76, 'TOTORA                   ', 2),
(77, 'IVIRGARZAMA              ', 2),
(78, 'MIZQUE                   ', 2),
(79, 'CAJAS DE SEGURO LA PAZ   ', 4),
(80, 'BERMEJO                  ', 9),
(81, 'CARAPARI                 ', 9),
(82, 'EL PUENTE                ', 9),
(83, 'ENTRE RIOS               ', 9),
(84, 'PADCAYA                  ', 9),
(85, 'SAN LORENZO              ', 9),
(86, 'TARIJA - CERCADO         ', 9),
(87, 'URIONDO (A. CONCEPCION)  ', 9),
(88, 'VILLA MONTES             ', 9),
(89, 'YACUIBA                  ', 9),
(90, 'YUNCHARA                 ', 9),
(91, 'I COBIJA                 ', 6),
(92, 'II PUERTO RICO           ', 6),
(93, 'III GONZALO MORENO       ', 6),
(94, '01 TRINIDAD              ', 1),
(95, '02 MOXOS                 ', 1),
(96, '03 ITENEZ                ', 1),
(97, '04 MAMORE                ', 1),
(98, '05 YACUMA                ', 1),
(99, '06 BALLIVIAN             ', 1),
(100, '07 RIBERALTA             ', 1),
(101, '08 GUAYARAMERIN          ', 1),
(102, '09 SAN BORJA             ', 1),
(103, 'HOSPITALES (URB.)        ', 8),
(104, 'RED CENTRO               ', 8),
(105, 'RED ESTE                 ', 8),
(106, 'RED NORTE                ', 8),
(107, 'RED SUD                  ', 8),
(108, 'ANGEL SANDOVAL           ', 8),
(109, 'CHIQUITOS                ', 8),
(110, 'CORDILLERA               ', 8),
(111, 'FLORIDA                  ', 8),
(112, 'GERMAN BUSH              ', 8),
(113, 'GUARAYOS                 ', 8),
(114, 'ICHILO                   ', 8),
(115, 'MANUEL MARIA CABALLERO   ', 8),
(116, 'ÑUFLO DE CHÁVEZ          ', 8),
(117, 'OBISPO SANTISTEVAN       ', 8),
(118, 'RED ANDRÉS IBAÑEZ        ', 8),
(119, 'SARA                     ', 8),
(120, 'VALLEGRANDE              ', 8),
(121, 'VELASCO                  ', 8),
(122, 'WARNES                   ', 8),
(123, 'COORDINACIÓN NACIONAL - SAFCI', 4),
(124, 'COORDINACIÓN DEPARTAMENTAL - LA PAZ', 4),
(125, 'COORDINACIÓN DEPARTAMENTAL - BENI', 1),
(126, 'COORDINACIÓN DEPARTAMENTAL - COCHABAMBA', 2),
(127, 'COORDINACIÓN DEPARTAMENTAL - CHUQUISACA', 3),
(128, 'COORDINACIÓN DEPARTAMENTAL - ORURO', 5),
(129, 'COORDINACIÓN DEPARTAMENTAL - PANDO', 6),
(130, 'COORDINACIÓN DEPARTAMENTAL - POTOSÍ', 7),
(131, 'COORDINACIÓN DEPARTAMENTAL - SANTA CRUZ', 8),
(132, 'COORDINACIÓN DEPARTAMENTAL - TARIJA', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subsector_salud`
--

CREATE TABLE `subsector_salud` (
  `idsubsector_salud` int(11) NOT NULL,
  `subsector_salud` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `subsector_salud`
--

INSERT INTO `subsector_salud` (`idsubsector_salud`, `subsector_salud`) VALUES
(1, 'FF.AA. de la Nación           '),
(2, 'Iglesia                       '),
(3, 'Organismos no Gubernamentales '),
(4, 'Organismos Privados           '),
(5, 'Policia Nacional              '),
(6, 'Público                       '),
(7, 'Seguridad Social (CAJAS)      ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tematica`
--

CREATE TABLE `tematica` (
  `idtematica` int(11) NOT NULL,
  `tematica` text,
  `descripcion` text,
  `url` varchar(45) DEFAULT NULL,
  `idusuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tematica`
--

INSERT INTO `tematica` (`idtematica`, `tematica`, `descripcion`, `url`, `idusuario`) VALUES
(1, 'NINGUNO', ' ', ' ', 1),
(2, 'ASPECTOS GENERALES DE LA POLÍTICA SAFCI', 'El presente curso le permitirá conocer los aspectos generales de la Politica Nacional Salud Familiar Comunitaria Intercultural (SAFCI)', '../img/safci_oferta.png', 1),
(3, 'ASPECTOS GENERALES DEL SISTEMA ÚNICO DE SALUD', 'El presente curso le permitirá conocer los aspectos generales del Sistema Único de Salud (SUS)', '../img/sus_oferta.png', 1),
(4, 'PROMOCIÓN DE LA SALUD', 'El presente curso le permitirá conocer los aspectos mas importantes de la Promoción de la Salud.', '../img/promocion_salud.png', 1),
(5, 'TUTORÍA VIRTUAL', 'Dirigido a la formación de docentes en el ambito de la Tutoría Virtual.', '../img/tutoria_curso.png', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_area_influencia`
--

CREATE TABLE `tipo_area_influencia` (
  `idtipo_area_influencia` int(11) NOT NULL,
  `tipo_area_influencia` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_area_influencia`
--

INSERT INTO `tipo_area_influencia` (`idtipo_area_influencia`, `tipo_area_influencia`) VALUES
(1, 'COMUNIDAD'),
(2, 'BARRIO'),
(3, 'ZONA'),
(4, 'UNIDAD VECINAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_costo`
--

CREATE TABLE `tipo_costo` (
  `idtipo_costo` int(11) NOT NULL,
  `tipo_costo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_costo`
--

INSERT INTO `tipo_costo` (`idtipo_costo`, `tipo_costo`) VALUES
(1, 'SIN COSTO'),
(2, 'COSTO FIJO'),
(3, 'COSTO POR HORA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `idtipo_documento` int(11) NOT NULL,
  `tipo_documento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`idtipo_documento`, `tipo_documento`) VALUES
(1, 'COMUNICACIÓN INTERNA'),
(2, 'RESOLUCIÓN'),
(3, 'HOJA DE RUTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_establecimiento`
--

CREATE TABLE `tipo_establecimiento` (
  `idtipo_establecimiento` int(11) NOT NULL,
  `idnivel_establecimiento` int(11) DEFAULT NULL,
  `tipo_establecimiento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_establecimiento`
--

INSERT INTO `tipo_establecimiento` (`idtipo_establecimiento`, `idnivel_establecimiento`, `tipo_establecimiento`) VALUES
(1, 4, 'BANCO DE SANGRE          '),
(2, 1, 'C. CARACTERISTICAS PART.'),
(3, 2, 'C.S. AMBULATORIO'),
(4, 1, 'C.S. CON INTERNACION'),
(5, 1, 'C.S. INTEGRAL'),
(6, 1, 'CCESD'),
(7, 1, 'CENTRO DE AISLAMIENTO'),
(8, 1, 'CENTRO SALUD             '),
(9, 1, 'CLINICA'),
(10, 1, 'CONSULTORIO VECINAL'),
(11, 3, 'HOSPITAL GENERAL         '),
(12, 2, 'HOSPITAL SEGUNDO NIVEL'),
(13, 2, 'IDE'),
(14, 3, 'INSTITUTO ESPECIALIZADO  '),
(15, 3, 'MEDICINA NUCLEAR'),
(16, 1, 'POLICLINICO'),
(17, 1, 'POLICONSULTORIO'),
(18, 2, 'PUESTO DE SALUD          '),
(19, 1, 'Vacunatorio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_evento`
--

CREATE TABLE `tipo_evento` (
  `idtipo_evento` int(11) NOT NULL,
  `tipo_evento` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_evento`
--

INSERT INTO `tipo_evento` (`idtipo_evento`, `tipo_evento`) VALUES
(1, 'CURSO INDIVIDUAL'),
(2, 'PROGRAMA DE ESPECIALIZACIÓN'),
(3, 'SEMINARIO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_inscripcion`
--

CREATE TABLE `tipo_inscripcion` (
  `idtipo_inscripcion` int(11) NOT NULL,
  `tipo_inscripcion` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipo_inscripcion`
--

INSERT INTO `tipo_inscripcion` (`idtipo_inscripcion`, `tipo_inscripcion`) VALUES
(1, 'CON CONFIRMACIÓN'),
(2, 'AUTOMATICA-DIRECTA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `idnombre` int(11) DEFAULT NULL,
  `usuario` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `condicion` varchar(45) DEFAULT NULL,
  `perfil` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `idnombre`, `usuario`, `password`, `fecha`, `condicion`, `perfil`) VALUES
(1, 1, 'lyapuchura', 'lyapuchura', '2023-08-04', 'ACTIVO', 'ADMINISTRADOR'),
(2, 1, 'lyapuchura-P', '5966306', '2023-08-04', 'ACTIVO', 'PARTICIPANTE'),
(3, 2, '6103812', '6103812', '2023-08-09', 'ACTIVO', 'ADMINISTRADOR'),
(4, 3, 'dcastanon', 'dcastanon', '2023-08-09', 'ACTIVO', 'DOCENTE'),
(5, 4, '3454123', '3454123', '2023-08-09', 'ACTIVO', 'PARTICIPANTE'),
(6, 5, '5543123', '5543123', '2023-08-09', 'ACTIVO', 'PARTICIPANTE'),
(7, 6, '4952971', '4952971', '2023-08-09', 'ACTIVO', 'PARTICIPANTE'),
(8, 7, '3443505', '3443505', '2023-08-09', 'ACTIVO', 'PARTICIPANTE'),
(9, 1, 'lyapuchura-D', '5966306', '2023-08-23', 'ACTIVO', 'DOCENTE'),
(10, 8, '4693242', '4693242', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(11, 9, '5116331', '5116331', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(12, 10, '6301836', '6301836', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(13, 11, '4021514', '4021514', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(14, 12, '5291102', '5291102', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(15, 13, '5971333', '5971333', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(16, 14, '4792874', '4792874', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(17, 15, '1079799', '1079799', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(18, 16, '3133874', '3133874', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(19, 17, '5664902', '5664902', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(20, 18, '4176112', '4176112', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(21, 19, '5043838', '5043838', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(22, 20, '3839707', '3839707', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(23, 21, '3626104', '3626104', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(24, 22, '3643748', '3643748', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(25, 23, '3933560', '3933560', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(26, 24, '7278340', '7278340', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(27, 25, '4022301', '4022301', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(28, 26, '5002327', '5002327', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(29, 27, '6009670', '6009670', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(30, 0, '3971793', '3971793', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(31, 28, '4091334', '4091334', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(32, 29, '4020217', '4020217', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(33, 30, '4966390', '4966390', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(34, 31, '7942971', '7942971', '2023-08-23', 'ACTIVO', 'PARTICIPANTE'),
(35, 32, '4765231', '4765231', '2023-08-24', 'ACTIVO', 'PARTICIPANTE'),
(36, 33, '5066491', '5066491', '2023-08-24', 'ACTIVO', 'PARTICIPANTE'),
(37, 34, '5678901', '5678901', '2023-08-31', 'ACTIVO', 'PERSONAL'),
(38, 35, '5966307', '5966307', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(39, 36, '5966308', '5966308', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(40, 34, '5966310', '5966310', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(41, 35, '5966311', '5966311', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(42, 36, '5966312', '5966312', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(43, 37, '4966309', '4966309', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(44, 38, '4966301', '4966301', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(45, 39, '4966311', '4966311', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(46, 40, '4789110', '4789110', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(47, 41, '4567321', '4567321', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(48, 42, '3452131', '3452131', '2023-09-01', 'ACTIVO', 'PERSONAL'),
(49, 43, '2431243', '2431243', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(50, 44, '4321521', '4321521', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(51, 45, '4321678', '4321678', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(52, 46, '4132311', '4132311', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(53, 47, '3432121', '3432121', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(54, 48, '4967521', '4967521', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(55, 49, '6098123', '6098123', '2023-09-04', 'ACTIVO', 'PERSONAL'),
(56, 50, '4987321', '4987321', '2023-09-05', 'ACTIVO', 'PERSONAL'),
(57, 0, '4765321', '4765321', '2023-09-05', 'ACTIVO', 'PERSONAL'),
(58, 51, '4421234', '4421234', '2023-09-05', 'ACTIVO', 'PERSONAL'),
(59, 52, '4321321', '4321321', '2023-09-06', 'ACTIVO', 'PERSONAL'),
(60, 53, '6942971', '6942971', '2023-09-11', 'ACTIVO', 'PERSONAL'),
(61, 54, '3452121', '3452121', '2023-09-11', 'ACTIVO', 'PERSONAL'),
(62, 55, '3232412', '3232412', '2023-09-11', 'ACTIVO', 'PERSONAL'),
(63, 56, '4387612', '4387612', '2023-09-12', 'ACTIVO', 'PERSONAL'),
(64, 57, '2341534', '2341534', '2023-09-12', 'ACTIVO', 'PERSONAL'),
(65, 58, '4532671', '4532671', '2023-09-12', 'ACTIVO', 'PERSONAL'),
(66, 59, '4321527', '4321527', '2023-09-13', 'ACTIVO', 'PERSONAL'),
(67, 60, '4321567', '4321567', '2023-09-13', 'ACTIVO', 'PERSONAL'),
(68, 61, '4789321', '4789321', '2023-09-13', 'ACTIVO', 'PERSONAL'),
(69, 62, '5432123', '5432123', '2023-09-13', 'ACTIVO', 'PERSONAL'),
(70, 63, '4351234', '4351234', '2023-09-13', 'ACTIVO', 'PERSONAL'),
(71, 64, '4535656', '4535656', '2023-09-13', 'ACTIVO', 'PERSONAL'),
(72, 65, '5432671', '5432671', '2023-10-03', 'ACTIVO', 'PERSONAL'),
(73, 66, '5432679', '5432679', '2023-10-04', 'ACTIVO', 'PERSONAL'),
(74, 67, '5432680', '5432680', '2023-10-04', 'ACTIVO', 'PERSONAL'),
(75, 68, '5432677', '5432677', '2023-10-04', 'ACTIVO', 'PERSONAL'),
(76, 69, '5432698', '5432698', '2023-10-04', 'PASIVO', 'PERSONAL');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ambito`
--
ALTER TABLE `ambito`
  ADD PRIMARY KEY (`idambito`);

--
-- Indices de la tabla `ambito_local`
--
ALTER TABLE `ambito_local`
  ADD PRIMARY KEY (`idambito_local`);

--
-- Indices de la tabla `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`idarea`),
  ADD KEY `idusuario_idxo` (`idusuario`);

--
-- Indices de la tabla `area_conocimiento`
--
ALTER TABLE `area_conocimiento`
  ADD PRIMARY KEY (`idarea_conocimiento`);

--
-- Indices de la tabla `area_influencia`
--
ALTER TABLE `area_influencia`
  ADD PRIMARY KEY (`idarea_influencia`);

--
-- Indices de la tabla `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`idaula`);

--
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`idcargo`);

--
-- Indices de la tabla `cargo_mds`
--
ALTER TABLE `cargo_mds`
  ADD PRIMARY KEY (`idcargo_mds`);

--
-- Indices de la tabla `cargo_organigrama`
--
ALTER TABLE `cargo_organigrama`
  ADD PRIMARY KEY (`idcargo_organigrama`);

--
-- Indices de la tabla `cargo_red_salud`
--
ALTER TABLE `cargo_red_salud`
  ADD PRIMARY KEY (`idcargo_red_salud`);

--
-- Indices de la tabla `carpeta_familiar`
--
ALTER TABLE `carpeta_familiar`
  ADD PRIMARY KEY (`idcarpeta_familiar`,`longitud`);

--
-- Indices de la tabla `comentario_evaluacion`
--
ALTER TABLE `comentario_evaluacion`
  ADD PRIMARY KEY (`idcomentario_evaluacion`);

--
-- Indices de la tabla `condicion`
--
ALTER TABLE `condicion`
  ADD PRIMARY KEY (`idcondicion`);

--
-- Indices de la tabla `dato_laboral`
--
ALTER TABLE `dato_laboral`
  ADD PRIMARY KEY (`iddato_laboral`);

--
-- Indices de la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`iddepartamento`);

--
-- Indices de la tabla `dependencia`
--
ALTER TABLE `dependencia`
  ADD PRIMARY KEY (`iddependencia`);

--
-- Indices de la tabla `dependencia_institucion`
--
ALTER TABLE `dependencia_institucion`
  ADD PRIMARY KEY (`iddependencia_institucion`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`iddireccion`),
  ADD KEY `idministerio_idx` (`idministerio`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`iddocente`),
  ADD KEY `idusuario_idx` (`idusuario`),
  ADD KEY `iddepartamento_idx` (`idresidencia`);

--
-- Indices de la tabla `especialidad_docente`
--
ALTER TABLE `especialidad_docente`
  ADD PRIMARY KEY (`idespecialidad_docente`);

--
-- Indices de la tabla `especialidad_medica`
--
ALTER TABLE `especialidad_medica`
  ADD PRIMARY KEY (`idespecialidad_medica`);

--
-- Indices de la tabla `establecimiento_salud`
--
ALTER TABLE `establecimiento_salud`
  ADD PRIMARY KEY (`idestablecimiento_salud`),
  ADD KEY `departamento_fk_idx` (`iddepartamento`),
  ADD KEY `idred_salud_idx` (`idred_salud`),
  ADD KEY `idmunicipio_idx` (`idmunicipio`),
  ADD KEY `municipio_identif_idx` (`idmunicipio`),
  ADD KEY `idtipo_establecimiento_idx` (`idtipo_establecimiento`);

--
-- Indices de la tabla `estado_docente`
--
ALTER TABLE `estado_docente`
  ADD PRIMARY KEY (`idestado_docente`);

--
-- Indices de la tabla `estado_ejecucion`
--
ALTER TABLE `estado_ejecucion`
  ADD PRIMARY KEY (`idestado_ejecucion`);

--
-- Indices de la tabla `estado_establecimiento`
--
ALTER TABLE `estado_establecimiento`
  ADD PRIMARY KEY (`idestado_establecimiento`);

--
-- Indices de la tabla `estado_evaluacion`
--
ALTER TABLE `estado_evaluacion`
  ADD PRIMARY KEY (`idestado_evaluacion`);

--
-- Indices de la tabla `estado_inscripcion`
--
ALTER TABLE `estado_inscripcion`
  ADD PRIMARY KEY (`idestado_inscripcion`);

--
-- Indices de la tabla `estado_personal`
--
ALTER TABLE `estado_personal`
  ADD PRIMARY KEY (`idestado_personal`);

--
-- Indices de la tabla `estado_registro`
--
ALTER TABLE `estado_registro`
  ADD PRIMARY KEY (`idestado_registro`);

--
-- Indices de la tabla `eval_docente`
--
ALTER TABLE `eval_docente`
  ADD PRIMARY KEY (`ideval_docente`);

--
-- Indices de la tabla `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`idevento`),
  ADD KEY `idmacrocurricula_idx` (`idmacrocurricula`),
  ADD KEY `iddepartamento_idx` (`iddepartamento`),
  ADD KEY `idmicrocurricula_idx` (`idmicrocurricula`),
  ADD KEY `idmodalidad_idx` (`idmodalidad`),
  ADD KEY `idpublicacion_idx` (`idpublicacion`),
  ADD KEY `idobjetivo_anual_idx` (`idobjetivo_anual`),
  ADD KEY `fk_objetivo_anual_idx` (`idobjetivo_anual`),
  ADD KEY `idprovincia_idx` (`idprovincia`),
  ADD KEY `fk_idprovincia_idx` (`idprovincia`);

--
-- Indices de la tabla `formacion_academica`
--
ALTER TABLE `formacion_academica`
  ADD PRIMARY KEY (`idformacion_academica`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`idgenero`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`idhorario`);

--
-- Indices de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  ADD PRIMARY KEY (`idinscripcion`);

--
-- Indices de la tabla `log_login`
--
ALTER TABLE `log_login`
  ADD PRIMARY KEY (`idlog_login`);

--
-- Indices de la tabla `log_login_failure`
--
ALTER TABLE `log_login_failure`
  ADD PRIMARY KEY (`idlog_login_failure`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`idlugar`);

--
-- Indices de la tabla `macrocurricula`
--
ALTER TABLE `macrocurricula`
  ADD PRIMARY KEY (`idmacrocurricula`),
  ADD KEY `idobjetivo_anual_idx` (`idobjetivo_anual`),
  ADD KEY `idarea_conocimiento_idx` (`idarea_conocimiento`),
  ADD KEY `idambito_idx` (`idambito`),
  ADD KEY `idmodelo_educativo_idx` (`idmodelo_educativo`),
  ADD KEY `idusuario_idx` (`idusuario`);

--
-- Indices de la tabla `microcurricula`
--
ALTER TABLE `microcurricula`
  ADD PRIMARY KEY (`idmicrocurricula`),
  ADD KEY `idmacrocurricula_idx` (`idmacrocurricula`),
  ADD KEY `idtematica_idx` (`idtematica`),
  ADD KEY `idtipo_costo_idx` (`idtipo_costo`),
  ADD KEY `idmicrocurricula_idx` (`pre_requisito`);

--
-- Indices de la tabla `ministerio`
--
ALTER TABLE `ministerio`
  ADD PRIMARY KEY (`idministerio`);

--
-- Indices de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  ADD PRIMARY KEY (`idmodalidad`);

--
-- Indices de la tabla `modelo_educativo`
--
ALTER TABLE `modelo_educativo`
  ADD PRIMARY KEY (`idmodelo_educativo`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`idmunicipio`);

--
-- Indices de la tabla `nacion`
--
ALTER TABLE `nacion`
  ADD PRIMARY KEY (`idnacion`);

--
-- Indices de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  ADD PRIMARY KEY (`idnacionalidad`);

--
-- Indices de la tabla `nivel_curricular`
--
ALTER TABLE `nivel_curricular`
  ADD PRIMARY KEY (`idnivel_curricular`);

--
-- Indices de la tabla `nivel_establecimiento`
--
ALTER TABLE `nivel_establecimiento`
  ADD PRIMARY KEY (`idnivel_establecimiento`);

--
-- Indices de la tabla `nombre`
--
ALTER TABLE `nombre`
  ADD PRIMARY KEY (`idnombre`);

--
-- Indices de la tabla `nombre_academico`
--
ALTER TABLE `nombre_academico`
  ADD PRIMARY KEY (`idnombre_academico`);

--
-- Indices de la tabla `nombre_datos`
--
ALTER TABLE `nombre_datos`
  ADD PRIMARY KEY (`idnombre_datos`);

--
-- Indices de la tabla `objetivo_anual`
--
ALTER TABLE `objetivo_anual`
  ADD PRIMARY KEY (`idobjetivo_anual`),
  ADD KEY `idplan_anual_idx` (`idplan_anual`),
  ADD KEY `idusuario_idx` (`idusuario`);

--
-- Indices de la tabla `partida_presup`
--
ALTER TABLE `partida_presup`
  ADD PRIMARY KEY (`idpartida_presup`);

--
-- Indices de la tabla `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`idperfil`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idpersonal`);

--
-- Indices de la tabla `plan_anual`
--
ALTER TABLE `plan_anual`
  ADD PRIMARY KEY (`idplan_anual`),
  ADD KEY `idtipo_documento_idx` (`idtipo_documento`),
  ADD KEY `idpartida_presup_idx` (`idpartida_presup`);

--
-- Indices de la tabla `ponderacion`
--
ALTER TABLE `ponderacion`
  ADD PRIMARY KEY (`idponderacion`);

--
-- Indices de la tabla `profesion`
--
ALTER TABLE `profesion`
  ADD PRIMARY KEY (`idprofesion`);

--
-- Indices de la tabla `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`idprovincia`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idpublicacion`);

--
-- Indices de la tabla `red_salud`
--
ALTER TABLE `red_salud`
  ADD PRIMARY KEY (`idred_salud`);

--
-- Indices de la tabla `subsector_salud`
--
ALTER TABLE `subsector_salud`
  ADD PRIMARY KEY (`idsubsector_salud`);

--
-- Indices de la tabla `tematica`
--
ALTER TABLE `tematica`
  ADD PRIMARY KEY (`idtematica`);

--
-- Indices de la tabla `tipo_area_influencia`
--
ALTER TABLE `tipo_area_influencia`
  ADD PRIMARY KEY (`idtipo_area_influencia`);

--
-- Indices de la tabla `tipo_costo`
--
ALTER TABLE `tipo_costo`
  ADD PRIMARY KEY (`idtipo_costo`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`idtipo_documento`);

--
-- Indices de la tabla `tipo_establecimiento`
--
ALTER TABLE `tipo_establecimiento`
  ADD PRIMARY KEY (`idtipo_establecimiento`);

--
-- Indices de la tabla `tipo_evento`
--
ALTER TABLE `tipo_evento`
  ADD PRIMARY KEY (`idtipo_evento`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ambito`
--
ALTER TABLE `ambito`
  MODIFY `idambito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ambito_local`
--
ALTER TABLE `ambito_local`
  MODIFY `idambito_local` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `area`
--
ALTER TABLE `area`
  MODIFY `idarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `area_conocimiento`
--
ALTER TABLE `area_conocimiento`
  MODIFY `idarea_conocimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `area_influencia`
--
ALTER TABLE `area_influencia`
  MODIFY `idarea_influencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `aula`
--
ALTER TABLE `aula`
  MODIFY `idaula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `idcargo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cargo_mds`
--
ALTER TABLE `cargo_mds`
  MODIFY `idcargo_mds` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `cargo_organigrama`
--
ALTER TABLE `cargo_organigrama`
  MODIFY `idcargo_organigrama` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `cargo_red_salud`
--
ALTER TABLE `cargo_red_salud`
  MODIFY `idcargo_red_salud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `carpeta_familiar`
--
ALTER TABLE `carpeta_familiar`
  MODIFY `idcarpeta_familiar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `condicion`
--
ALTER TABLE `condicion`
  MODIFY `idcondicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `dato_laboral`
--
ALTER TABLE `dato_laboral`
  MODIFY `iddato_laboral` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT de la tabla `departamento`
--
ALTER TABLE `departamento`
  MODIFY `iddepartamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `dependencia_institucion`
--
ALTER TABLE `dependencia_institucion`
  MODIFY `iddependencia_institucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `iddireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `docente`
--
ALTER TABLE `docente`
  MODIFY `iddocente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `especialidad_docente`
--
ALTER TABLE `especialidad_docente`
  MODIFY `idespecialidad_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `establecimiento_salud`
--
ALTER TABLE `establecimiento_salud`
  MODIFY `idestablecimiento_salud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4206;

--
-- AUTO_INCREMENT de la tabla `estado_docente`
--
ALTER TABLE `estado_docente`
  MODIFY `idestado_docente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_ejecucion`
--
ALTER TABLE `estado_ejecucion`
  MODIFY `idestado_ejecucion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `estado_establecimiento`
--
ALTER TABLE `estado_establecimiento`
  MODIFY `idestado_establecimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_evaluacion`
--
ALTER TABLE `estado_evaluacion`
  MODIFY `idestado_evaluacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_inscripcion`
--
ALTER TABLE `estado_inscripcion`
  MODIFY `idestado_inscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `estado_personal`
--
ALTER TABLE `estado_personal`
  MODIFY `idestado_personal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estado_registro`
--
ALTER TABLE `estado_registro`
  MODIFY `idestado_registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `eval_docente`
--
ALTER TABLE `eval_docente`
  MODIFY `ideval_docente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `evento`
--
ALTER TABLE `evento`
  MODIFY `idevento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `formacion_academica`
--
ALTER TABLE `formacion_academica`
  MODIFY `idformacion_academica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `genero`
--
ALTER TABLE `genero`
  MODIFY `idgenero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `idhorario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inscripcion`
--
ALTER TABLE `inscripcion`
  MODIFY `idinscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `log_login`
--
ALTER TABLE `log_login`
  MODIFY `idlog_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT de la tabla `log_login_failure`
--
ALTER TABLE `log_login_failure`
  MODIFY `idlog_login_failure` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `idlugar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `macrocurricula`
--
ALTER TABLE `macrocurricula`
  MODIFY `idmacrocurricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `microcurricula`
--
ALTER TABLE `microcurricula`
  MODIFY `idmicrocurricula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ministerio`
--
ALTER TABLE `ministerio`
  MODIFY `idministerio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `modalidad`
--
ALTER TABLE `modalidad`
  MODIFY `idmodalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `modelo_educativo`
--
ALTER TABLE `modelo_educativo`
  MODIFY `idmodelo_educativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `idmunicipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=345;

--
-- AUTO_INCREMENT de la tabla `nacion`
--
ALTER TABLE `nacion`
  MODIFY `idnacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `nacionalidad`
--
ALTER TABLE `nacionalidad`
  MODIFY `idnacionalidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nivel_curricular`
--
ALTER TABLE `nivel_curricular`
  MODIFY `idnivel_curricular` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `nivel_establecimiento`
--
ALTER TABLE `nivel_establecimiento`
  MODIFY `idnivel_establecimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `nombre`
--
ALTER TABLE `nombre`
  MODIFY `idnombre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `nombre_academico`
--
ALTER TABLE `nombre_academico`
  MODIFY `idnombre_academico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `nombre_datos`
--
ALTER TABLE `nombre_datos`
  MODIFY `idnombre_datos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de la tabla `objetivo_anual`
--
ALTER TABLE `objetivo_anual`
  MODIFY `idobjetivo_anual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `partida_presup`
--
ALTER TABLE `partida_presup`
  MODIFY `idpartida_presup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `perfil`
--
ALTER TABLE `perfil`
  MODIFY `idperfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `idpersonal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `plan_anual`
--
ALTER TABLE `plan_anual`
  MODIFY `idplan_anual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ponderacion`
--
ALTER TABLE `ponderacion`
  MODIFY `idponderacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `profesion`
--
ALTER TABLE `profesion`
  MODIFY `idprofesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `provincias`
--
ALTER TABLE `provincias`
  MODIFY `idprovincia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idpublicacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `red_salud`
--
ALTER TABLE `red_salud`
  MODIFY `idred_salud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT de la tabla `subsector_salud`
--
ALTER TABLE `subsector_salud`
  MODIFY `idsubsector_salud` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tematica`
--
ALTER TABLE `tematica`
  MODIFY `idtematica` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipo_area_influencia`
--
ALTER TABLE `tipo_area_influencia`
  MODIFY `idtipo_area_influencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tipo_costo`
--
ALTER TABLE `tipo_costo`
  MODIFY `idtipo_costo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `idtipo_documento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_establecimiento`
--
ALTER TABLE `tipo_establecimiento`
  MODIFY `idtipo_establecimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `tipo_evento`
--
ALTER TABLE `tipo_evento`
  MODIFY `idtipo_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `idministerio` FOREIGN KEY (`idministerio`) REFERENCES `ministerio` (`idministerio`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `establecimiento_salud`
--
ALTER TABLE `establecimiento_salud`
  ADD CONSTRAINT `departamento_clave` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idred_salud` FOREIGN KEY (`idred_salud`) REFERENCES `red_salud` (`idred_salud`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idtipo_establecimiento` FOREIGN KEY (`idtipo_establecimiento`) REFERENCES `tipo_establecimiento` (`idtipo_establecimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `fk_idmacrocurricula_sup` FOREIGN KEY (`idmacrocurricula`) REFERENCES `macrocurricula` (`idmacrocurricula`),
  ADD CONSTRAINT `fk_objetivo_anual` FOREIGN KEY (`idobjetivo_anual`) REFERENCES `objetivo_anual` (`idobjetivo_anual`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `iddepartamento` FOREIGN KEY (`iddepartamento`) REFERENCES `departamento` (`iddepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idmicrocurricula` FOREIGN KEY (`idmicrocurricula`) REFERENCES `microcurricula` (`idmicrocurricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idmodalidad` FOREIGN KEY (`idmodalidad`) REFERENCES `modalidad` (`idmodalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idpublicacion` FOREIGN KEY (`idpublicacion`) REFERENCES `publicacion` (`idpublicacion`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `macrocurricula`
--
ALTER TABLE `macrocurricula`
  ADD CONSTRAINT `idambito` FOREIGN KEY (`idambito`) REFERENCES `ambito` (`idambito`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idarea_conocimiento` FOREIGN KEY (`idarea_conocimiento`) REFERENCES `area_conocimiento` (`idarea_conocimiento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idmodelo_educativo` FOREIGN KEY (`idmodelo_educativo`) REFERENCES `modelo_educativo` (`idmodelo_educativo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idobjetivo_anual` FOREIGN KEY (`idobjetivo_anual`) REFERENCES `objetivo_anual` (`idobjetivo_anual`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `microcurricula`
--
ALTER TABLE `microcurricula`
  ADD CONSTRAINT `idmacrocurricula` FOREIGN KEY (`idmacrocurricula`) REFERENCES `macrocurricula` (`idmacrocurricula`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idtematica` FOREIGN KEY (`idtematica`) REFERENCES `tematica` (`idtematica`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idtipo_costo` FOREIGN KEY (`idtipo_costo`) REFERENCES `tipo_costo` (`idtipo_costo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `pre_requisito` FOREIGN KEY (`pre_requisito`) REFERENCES `tematica` (`idtematica`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `objetivo_anual`
--
ALTER TABLE `objetivo_anual`
  ADD CONSTRAINT `idplan_anual` FOREIGN KEY (`idplan_anual`) REFERENCES `plan_anual` (`idplan_anual`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `plan_anual`
--
ALTER TABLE `plan_anual`
  ADD CONSTRAINT `idpartida_presup` FOREIGN KEY (`idpartida_presup`) REFERENCES `partida_presup` (`idpartida_presup`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idtipo_documento` FOREIGN KEY (`idtipo_documento`) REFERENCES `tipo_documento` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
