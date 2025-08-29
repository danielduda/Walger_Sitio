-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-04-2015 a las 17:42:01
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `sixco`
--

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `analisisprecioxkm`
--
CREATE TABLE IF NOT EXISTS `analisisprecioxkm` (
`codigoUT` varchar(255)
,`viaje` varchar(255)
,`fechaCarga` date
,`fechaFronteraI` date
,`idPais` int(10) unsigned
,`origen` varchar(255)
,`destino` varchar(255)
,`valorVentaNac` varchar(255)
,`valorVentaInt` varchar(255)
,`TotalVenta` double
,`kilometrosRecorridos` decimal(32,0)
,`preciokm` varchar(1)
,`kilometrosVacio` varchar(1)
,`kilometrosCargado` varchar(1)
,`PorcentajeVacio` varchar(1)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asientos`
--

CREATE TABLE IF NOT EXISTS `asientos` (
  `Id_asiento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_movimiento` varchar(20) NOT NULL,
  `cuenta` varchar(30) NOT NULL,
  `importe` float NOT NULL,
  `saldo` varchar(10) NOT NULL,
  PRIMARY KEY (`Id_asiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Volcado de datos para la tabla `asientos`
--

INSERT INTO `asientos` (`Id_asiento`, `id_movimiento`, `cuenta`, `importe`, `saldo`) VALUES
(1, '2', '3', 4, '5'),
(2, '1', '2', 3, '4'),
(3, '1', '2', 3, '4'),
(4, '0', '2', 3, '4'),
(5, '0', '2', 3, '4'),
(6, '1', '2', 3, '4'),
(7, '0', '2', 3, '4'),
(8, '0', '2', 3, '4'),
(9, '0', '2', 3, '4'),
(10, '0', '2', 3, '4'),
(11, '0', '2', 3, '4'),
(12, '0', '2', 3, '4'),
(13, '0', '2', 3, '4'),
(14, '2147483647', '20150102024917', 20150100000000, '2015010202'),
(15, '20150106055308', '20150106055308', 20150100000000, '2015010605'),
(16, '20150106060712', '20150106060712', 20150100000000, '2015010606'),
(17, '20150106070057', '20150106070057', 20150100000000, '2015010607'),
(18, '20150106070133', '20150106070133', 20150100000000, '2015010607'),
(19, '20150107072533', '20150107072533', 20150100000000, '2015010707'),
(20, '20150107072632', 'Resource id #17', 20150100000000, '2015010707'),
(21, '20150107072721', 'Resource id #17', 20150100000000, '2015010707'),
(22, '20150107072738', 'Resource id #17', 20150100000000, '2015010707'),
(23, '20150107072849', 'Array', 20150100000000, '2015010707'),
(24, '20150107073326', 'Array', 20150100000000, '2015010707'),
(25, '20150107074757', '', 20150100000000, '2015010707'),
(26, '20150107074909', 'contracuenta prueba 2', 20150100000000, '2015010707'),
(27, '20150107082006', 'cuenta prueba', 0, '2015010708'),
(28, '20150107082132', 'cuenta prueba', 10, '2015010708'),
(29, '20150107104353', '', 0, '2015010710'),
(30, '20150107104535', '', 0, '1'),
(31, '20150107111543', 'cuenta prueba', 10, 'debe'),
(32, '20150107111647', 'cuenta prueba', 10, 'haber'),
(33, '20150108124927', 'cuenta prueba', 10, 'debe'),
(34, '20150108124927', 'IDF', 2.1, 'debe'),
(35, '20150108010343', 'cuenta prueba', 100, 'debe'),
(36, '20150108010343', 'IDF', 2.1, 'debe'),
(37, '20150108010343', 'ASD', 0.01, 'debe'),
(38, '20150108010343', 'asd', 10, 'debe'),
(39, '20150108010446', 'cuenta prueba', 60, 'haber'),
(40, '20150108010446', 'ICF', 6.3, 'haber'),
(41, '20150108011114', 'cuenta prueba', 10, 'debe'),
(42, '20150108011114', 'IDF', 2.1, 'debe'),
(43, '20150108011114', 'ASD', 0.01, 'debe'),
(44, '20150108011114', 'IDF', 0.021, 'debe'),
(45, '20150108011311', 'cuenta prueba', 10, 'haber'),
(46, '20150108011311', 'ICF', 0.021, 'haber'),
(47, '20150108012721', 'cuenta prueba', 200, 'debe'),
(48, '20150108012721', 'IDF', 2.1, 'debe'),
(49, '20150108012721', 'contracuenta prueba', 202.1, 'haber'),
(50, '20150108025911', 'Peajes', 30, 'debe'),
(51, '20150108025911', 'Iva Débito Fiscal', 3.15, 'debe'),
(52, '20150108025911', 'Peajes a pagar', 33.15, 'haber'),
(53, '20150108012629', 'Peajes', 60, 'debe'),
(54, '20150108012629', 'Iva Débito Fiscal', 6.3, 'debe'),
(55, '20150108012629', 'QWD', 4.95, 'debe'),
(56, '20150108012629', 'asd', 4.5, 'debe'),
(57, '20150108012629', 'Bancos', 75.75, 'haber'),
(58, '20150108012824', '', 4.5, 'debe'),
(59, '20150108012824', '', 4.5, 'haber'),
(60, '20150124095910', '', 0, 'debe'),
(61, '20150124095910', '', 0, 'haber'),
(62, '20150125115811', '', 10135, 'debe'),
(63, '20150125115811', 'asd', 0, 'debe'),
(64, '20150125115811', 'Iva Débito Fiscal', 2128.35, 'debe'),
(65, '20150125115811', 'QWD', 1672.28, 'debe'),
(66, '20150125115811', '', 13935.6, 'haber'),
(67, '20150126120422', '', 0, 'debe'),
(68, '20150126120422', '', 0, 'haber'),
(69, '20150126051129', 'Peajes', 1, 'debe'),
(70, '20150126051129', 'Peajes a pagar', 1, 'haber'),
(71, '20150126051233', 'Peajes', 0, 'debe'),
(72, '20150126051233', 'Caja', 0, 'haber'),
(73, '20150128043826', '', 0, 'debe'),
(74, '20150128043826', '', 0, 'haber'),
(75, '20150128104753', '', 50, 'debe'),
(76, '20150128104753', 'asd', 0, 'debe'),
(77, '20150128104753', '', 75, 'haber'),
(78, '20150128105138', 'Peajes', 50, 'debe'),
(79, '20150128105138', 'asd', 0, 'debe'),
(80, '20150128105138', 'Bancos', 75, 'haber'),
(81, '20150128105725', '', 50, 'debe'),
(82, '20150128105725', '', 75, 'haber'),
(83, '20150128105857', 'Peajes', 50, 'debe'),
(84, '20150128105857', 'Bancos', 75, 'haber'),
(85, '20150128110452', '', 50, 'debe'),
(86, '20150128110452', '', 75, 'haber'),
(87, '20150128110622', '', 50, 'debe'),
(88, '20150128110622', 'asd', 5, 'debe'),
(89, '20150128110622', '', 75, 'haber'),
(90, '20150128111412', '', 0, 'debe'),
(91, '20150128111412', '', 0, 'haber'),
(92, '20150128112411', '', 0, 'debe'),
(93, '20150128112411', '', 0, 'haber'),
(94, '20150128112447', '', 50, 'debe'),
(95, '20150128112447', 'asd', 0, 'debe'),
(96, '20150128112447', '', 75, 'haber'),
(97, '20150128113314', '', 50, 'debe'),
(98, '20150128113314', 'asd', 0, 'debe'),
(99, '20150128113314', '', 50, 'haber'),
(100, '20150128114327', '', 50, 'debe'),
(101, '20150128114327', 'asd', 25, 'debe'),
(102, '20150128114327', '', 75, 'haber'),
(103, '20150130030330', '', 0, 'debe'),
(104, '20150130030330', '', 0, 'haber'),
(105, '20150130030339', '', 0, 'debe'),
(106, '20150130030339', '', 0, 'haber');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE IF NOT EXISTS `ciudades` (
  `idCiudad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idProvincia` int(10) unsigned NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  `denominacionCorta` varchar(255) NOT NULL,
  PRIMARY KEY (`idCiudad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=144 ;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`idCiudad`, `idProvincia`, `denominacion`, `denominacionCorta`) VALUES
(1, 2, 'Venado Tuerto', 'Vtto'),
(2, 1, 'Chacabuco', 'Chaca'),
(3, 5, 'Gualeguaychu', 'Gchu'),
(4, 12, 'Fray Bentos', 'Fbento'),
(5, 13, 'Montevideo', 'Mtvdo'),
(6, 12, 'Young', 'Young'),
(7, 18, 'Ciudad de Buenos Aires', 'CABA'),
(8, 2, 'Horreos', 'Horreos'),
(9, 1, 'Salto', 'Salto'),
(10, 1, 'Arrecifes', 'Arre'),
(11, 1, 'Gahan', 'Gahan'),
(12, 14, 'Ciudad del Este', 'CdE'),
(13, 2, 'Rosario', 'Ros'),
(14, 3, 'Jesus Maria', 'Jm'),
(15, 3, 'Chazon', 'Chaz'),
(16, 5, 'Rosario del Tala', 'Rtala'),
(17, 19, 'Clorinda', 'Clor'),
(18, 15, 'Asuncion', 'Asu'),
(19, 16, 'Mercedes', 'Merce'),
(20, 1, 'Pergamino', 'Perga'),
(21, 14, 'Encarnacion', 'Encar'),
(22, 4, 'Posadas', 'Pos'),
(23, 3, 'Rio Cuarto', 'R4to'),
(24, 6, 'Metan', 'Metan'),
(25, 20, 'Burruyacu', 'Burru'),
(26, 5, 'Viale', 'Viale'),
(27, 5, 'Urdinarrain', 'Urdi'),
(28, 5, 'Victoria', 'Victo'),
(29, 2, 'San Jorge', 'SJorge'),
(30, 1, 'Balcarce', 'Bal'),
(31, 3, 'Tancacha', 'Tch'),
(32, 1, 'Tigre', 'Tigre'),
(33, 5, 'Gualeguay', 'Guay'),
(34, 5, 'Concepción del Uruguay', 'CdelU'),
(35, 1, 'General Pacheco', 'Pacheco'),
(36, 3, 'Cordoba', 'Cba'),
(37, 8, 'Azara', 'Aza'),
(38, 1, 'Bahia Blanca', 'Bahia'),
(39, 1, 'Campana', 'Campa'),
(40, 2, 'Carcaraña', 'Carca'),
(41, 1, 'Carmen de Areco', 'Areco'),
(42, 5, 'Concepcion del Uruguay', 'Concep'),
(43, 1, 'Florida', 'Flo'),
(45, 8, 'Garrucho', 'Garru'),
(46, 1, 'Lobos', 'Lobos'),
(47, 1, 'Lujan', 'Lujan'),
(48, 16, 'Nueva Palmira', 'Nva Palmira'),
(49, 3, 'Marcos Juarez', 'MJua'),
(50, 1, 'Pehuajo', 'Pehua'),
(51, 13, 'Puerto Montevideo', 'Pto. Mtvdo'),
(52, 18, 'Puerto Buenos Aires', 'Pto. Bs. As.'),
(53, 1, 'Rojas', 'Rojas'),
(54, 6, 'Salta', 'Salta'),
(55, 1, 'San Fernando', 'Sanfer'),
(56, 1, 'San Martin', 'Sanma'),
(57, 1, 'San Justo', 'Sanjus'),
(58, 5, 'San Salvador', 'Sansal'),
(59, 21, 'Talamayuna', 'Talama'),
(60, 3, 'Tancacha', 'Tanca'),
(61, 11, 'Tupungato', 'Tupung'),
(62, 8, 'Virasoro', 'Vira'),
(63, 1, 'Zarate', 'Zarate'),
(64, 13, 'Zona America', 'ZAme'),
(65, 13, 'Zona Franca', 'Zfranca'),
(66, 1, 'Zona Franca', 'Zfrancabs'),
(67, 1, 'Avellaneda', 'Avell'),
(68, 1, 'Brandsen', 'Brand'),
(69, 1, 'Benavidez', 'Benav'),
(70, 1, 'Caseros', 'Case'),
(71, 17, 'Canelones', 'Canelo'),
(72, 17, 'Carmelo', 'Carme'),
(73, 16, 'Dolores', 'Dolo'),
(74, 16, 'Durazno', 'Duraz'),
(75, 1, 'Escobar', 'Esco'),
(76, 1, 'Ezeiza', 'Ezeiza'),
(77, 1, 'Florencio Varela', 'Varela'),
(78, 1, 'Garin', 'Garin'),
(79, 1, 'Gemes', 'gemes'),
(80, 1, 'General Roriguez', 'Gral Rod'),
(81, 1, 'Gonzalez Catan', 'Catan'),
(82, 1, 'Hurlingham', 'Hurli'),
(83, 1, 'La Plata', 'Lplata'),
(84, 1, 'Las Flores', 'Lflores'),
(85, 1, 'Libertad', 'Libertad'),
(86, 14, 'Minga Guazu', 'MinGua'),
(87, 22, 'Nueva Helvecia', 'Helvecia'),
(88, 22, 'Ombues del Valle', 'Ombues'),
(89, 22, 'Punta del Este', 'Pta Este'),
(90, 1, 'Quilmes', 'Quilmes'),
(91, 3, 'San Francisco', 'San fran'),
(92, 1, 'San Isidro', 'Sidro'),
(93, 11, 'San Martin', 'smanmdz'),
(94, 22, 'Santa Cruz de la Sierra', 'Sta Cruz'),
(95, 22, 'Santa Lucia', 'Sta Lucia'),
(96, 14, 'Santa Rita', 'Sta Rita'),
(97, 22, 'Tarariras', 'Tara'),
(98, 22, 'Trinidad', 'Trinidad'),
(99, 20, 'San Miguel de Tucuman', 'SMTucu'),
(100, 12, 'Viedma', 'Viedma'),
(101, 3, 'Noetinger', 'Noetin'),
(102, 11, 'Mendoza', 'Mdza'),
(103, 2, 'Gobernador Galvez', 'GGz'),
(104, 0, 'Maldonado', ''),
(105, 0, 'Freyre', ''),
(106, 0, 'Dock Sud', ''),
(107, 0, 'Puerto Madero', ''),
(108, 0, 'Falcon', ''),
(109, 0, 'Caazapa', ''),
(110, 0, 'Pto. Falcon', ''),
(111, 0, 'Paso Pereira', ''),
(112, 0, 'Alvear', ''),
(113, 0, 'La Cruz', ''),
(114, 0, 'Noestinger', ''),
(115, 0, 'Parana', ''),
(116, 0, 'Saladas', ''),
(117, 0, 'Defiba', ''),
(118, 0, 'Treinta y Tres', ''),
(119, 0, 'Techint', ''),
(120, 0, 'Punta Pereira', ''),
(121, 0, 'Tefasa', ''),
(122, 0, 'Lievis', ''),
(123, 0, 'Cap. Del Señor', ''),
(124, 0, 'Padilla', ''),
(125, 0, 'Marcos Paz', ''),
(126, 0, 'Guardamonte', ''),
(127, 0, 'Luke', ''),
(128, 0, 'Rodo', ''),
(129, 0, 'Las Moscas', ''),
(130, 0, 'Boulogne', ''),
(131, 0, 'Pto. Las Palmas', ''),
(132, 0, 'Alsina', ''),
(133, 0, 'Pap. Del Plata', ''),
(134, 0, 'Alejandro Korn', ''),
(135, 0, 'La Carlota', ''),
(136, 0, 'Pta. Pereyra', ''),
(137, 0, 'G. Rodriguez', ''),
(138, 0, 'Om. Lavalle', ''),
(139, 0, 'Cardona', ''),
(140, 0, 'Brikmann', ''),
(141, 0, 'Pto. Madero', ''),
(142, 0, 'Cnel. Bermudes', ''),
(143, 0, 'Tapua', '');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `ciudades_provincias`
--
CREATE TABLE IF NOT EXISTS `ciudades_provincias` (
`idCiudad` int(10) unsigned
,`denominacion` varchar(255)
,`denominacion1` varchar(255)
,`idProvincia` int(10) unsigned
,`denominacionCorta` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `condiciones-iva`
--

CREATE TABLE IF NOT EXISTS `condiciones-iva` (
  `idCondicionIVA` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  `denominacionCorta` varchar(255) NOT NULL,
  PRIMARY KEY (`idCondicionIVA`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `condiciones-iva`
--

INSERT INTO `condiciones-iva` (`idCondicionIVA`, `denominacion`, `denominacionCorta`) VALUES
(1, 'Responsable Inscripto', 'RI'),
(2, 'Monotributo', 'Mono');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `contracuentas`
--
CREATE TABLE IF NOT EXISTS `contracuentas` (
`Id_cuenta` int(11)
,`rubroContracuenta` int(11)
,`Id_contracuenta` int(11)
,`rubroCuentas` varchar(20)
,`denominacionCuenta` varchar(50)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE IF NOT EXISTS `cuentas` (
  `idCuenta` int(10) unsigned NOT NULL,
  `cuenta` varchar(255) DEFAULT NULL,
  `costoCuenta` varchar(255) DEFAULT NULL,
  `idCostoCuenta` int(10) unsigned DEFAULT NULL,
  `tipoGasto` char(1) DEFAULT NULL,
  `idTipoGasto` int(10) unsigned DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idCuenta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cuentas`
--

INSERT INTO `cuentas` (`idCuenta`, `cuenta`, `costoCuenta`, `idCostoCuenta`, `tipoGasto`, `idTipoGasto`, `clave`) VALUES
(1, 'fede', 'ana', 1, 'A', 1, '1.1.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas2`
--

CREATE TABLE IF NOT EXISTS `cuentas2` (
  `Id_cuentas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacionCuenta` varchar(50) NOT NULL,
  `rubro` int(11) NOT NULL,
  `regimen` varchar(10) NOT NULL,
  `tipoGasto` int(11) NOT NULL,
  PRIMARY KEY (`Id_cuentas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `cuentas2`
--

INSERT INTO `cuentas2` (`Id_cuentas`, `denominacionCuenta`, `rubro`, `regimen`, `tipoGasto`) VALUES
(1, 'cuenta prueba', 1, 'asd', 1),
(2, 'contracuenta prueba', 1, 'asd', 1),
(3, 'contracuenta prueba 2', 3, 'asd', 1),
(4, 'Peajes', 4, '1', 6),
(5, 'Caja', 5, '1', 1),
(6, 'Peajes a pagar', 5, '1', 2),
(7, 'Bancos', 5, '1', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento-movimiento`
--

CREATE TABLE IF NOT EXISTS `documento-movimiento` (
  `Id_documentoMovimiento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_Documento` int(11) NOT NULL,
  `Id_tipoDocumento` int(11) NOT NULL,
  `Id_SaldoImpositivo` int(11) NOT NULL,
  PRIMARY KEY (`Id_documentoMovimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `documento-movimiento`
--

INSERT INTO `documento-movimiento` (`Id_documentoMovimiento`, `Id_Documento`, `Id_tipoDocumento`, `Id_SaldoImpositivo`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos`
--

CREATE TABLE IF NOT EXISTS `documentos` (
  `Id_Documentos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `documento` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_Documentos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `documentos`
--

INSERT INTO `documentos` (`Id_Documentos`, `documento`) VALUES
(1, 'Factura'),
(2, 'Nota de crédito'),
(3, 'Nota de débito');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `documentostipodocumentos`
--
CREATE TABLE IF NOT EXISTS `documentostipodocumentos` (
`Id_documentoMovimiento` int(10) unsigned
,`documento` varchar(20)
,`tipoDocumento` varchar(10)
,`Id_SaldoImpositivo` int(11)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dominios`
--

CREATE TABLE IF NOT EXISTS `dominios` (
  `idDominio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dominio` varchar(255) NOT NULL,
  `idTipoPropietario` int(10) unsigned DEFAULT NULL,
  `idTipoVehiculo` int(10) unsigned DEFAULT NULL,
  `VencimientoRuta` date DEFAULT NULL,
  `VencimientoSeguroNacional` date DEFAULT NULL,
  `VencimientoSeguroInternacional` date DEFAULT NULL,
  `VencimientoVTV` date DEFAULT NULL,
  `archivoTitulo` varchar(250) DEFAULT NULL,
  `archivoRUTA` varchar(250) DEFAULT NULL,
  `archivoSeguroNacional` varchar(250) DEFAULT NULL,
  `archivoSeguroInternacional` varchar(250) DEFAULT NULL,
  `archivoVTV` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idDominio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Volcado de datos para la tabla `dominios`
--

INSERT INTO `dominios` (`idDominio`, `dominio`, `idTipoPropietario`, `idTipoVehiculo`, `VencimientoRuta`, `VencimientoSeguroNacional`, `VencimientoSeguroInternacional`, `VencimientoVTV`, `archivoTitulo`, `archivoRUTA`, `archivoSeguroNacional`, `archivoSeguroInternacional`, `archivoVTV`) VALUES
(2, 'HDE379', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'MFT580', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'HMH996', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'HDE381', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'KPA222', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'KQK615', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'FZI561', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'FFU715', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'LBL492', 1, 1, '2015-03-28', '2014-06-30', '2014-06-30', '2015-03-05', 'LBL492(1).pdf', 'RUTA LBL492.pdf', 'LBL 492 NAC..pdf', 'LBL 492 INTERN..pdf', 'VT LBL492.pdf'),
(11, 'LBL491', 1, 2, '2015-03-28', '2014-06-30', '2014-06-30', '2015-03-05', 'LBL491(1).pdf', 'RUTA LBL491.jpg', 'LBL 491 NAC..pdf', 'LBL 491 INTERN..pdf', 'VT LBL491.pdf'),
(12, 'ICR811', 1, 1, '2014-12-16', '2014-06-30', '2014-06-30', '2014-12-04', 'ICR811(1).pdf', 'RUTA ICR811.pdf', 'ICR 811 NAC.pdf', 'ICR 811 INTERN..pdf', 'VT ICR811.pdf'),
(13, 'HSD761', 1, 2, '2014-12-16', '2014-06-30', '2014-06-30', '2014-12-23', 'HSD761(1).pdf', 'RUTA HSD761.pdf', 'HSD 761 NAC..pdf', 'HSD 761 INTERN..pdf', 'VT HSD761.pdf'),
(14, 'EUU433', 1, 1, '2014-07-15', '2014-06-30', '2014-06-30', '2015-02-13', 'EUU433.pdf', 'RUTA EUU433.pdf', 'EUU 433 NAC.pdf', 'EUU 433 INTERN..pdf', 'VT EUU433.pdf'),
(15, 'LKK541', 1, 2, NULL, '2014-06-30', '2014-06-30', '2014-07-20', 'LKK541.pdf', 'RUTA LKK541.pdf', 'LKK 541 NAC.pdf', 'LKK 541 INTERN..pdf', 'VT LKK541.pdf'),
(16, 'EVQ418', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'GFI340', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'FMS249', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'GLH949', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'KYJ693', 1, 1, '2014-08-20', '2014-06-30', '2014-06-30', '2015-01-23', 'KYJ693.pdf', 'RUTA KYJ693.jpg', 'KYJ 693 NAC..pdf', 'KYJ 693 INTERN..pdf', 'VT KYJ693.pdf'),
(21, 'LYX797', 1, 2, NULL, '2014-06-30', '2014-06-30', NULL, 'LYX797.pdf', 'RUTA LYX797.pdf', 'LYX 797 NAC..pdf', 'LYX 797 INTERN..pdf', 'VT LYX797.pdf'),
(22, 'LDQ566', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'LFL320', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'KYJ692', 1, 1, '2014-08-20', '2014-06-30', '2014-06-30', '2015-01-21', 'KYJ692.pdf', 'RUTA KYJ692.pdf', NULL, 'KYJ 692 INTERN..pdf', NULL),
(25, 'LBL490', 1, 2, '2015-03-28', '2014-06-30', '2014-06-30', '2015-03-13', 'LBL490.pdf', 'RUTA LBL490.jpg', 'LBL 490 NAC..pdf', 'LBL 490 INTERN..pdf', 'VT LBL490.pdf'),
(26, 'GZX097', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'KBW359', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'GJV116', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'GHO341', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'FUN433', 1, 2, '2015-01-20', '2014-06-30', '2014-06-30', '2014-12-17', 'FUN433.pdf', 'RUTA FUN433.pdf', 'FUN 433 NAC..pdf', 'FUN 433 INTERN..pdf', 'VT FUN433.pdf'),
(32, 'FUN434', 1, 2, NULL, '2014-06-30', '2014-06-30', '2014-09-20', 'FUN434.pdf', 'RUTA FUN434.pdf', 'FUN 434 NAC.pdf', 'FUN 434 INTERN..pdf', 'VT FUN434.pdf'),
(33, 'GGY791', 1, 2, '2014-06-25', '2014-06-30', '2014-06-30', '2014-05-04', 'GGY791.pdf', 'RUTA GGY791.pdf', 'GGY 791 NAC..pdf', 'GGY 791 INTERN..pdf', 'VT GGY791.pdf'),
(34, 'HCY417', 1, 1, '2015-04-29', '2014-06-30', '2014-06-30', '2014-05-03', 'HCY417.pdf', 'Revalida RUTA HCY417.jpg', 'HCY417 NAC..pdf', 'HCY417 INTERN..pdf', 'VT HCY417.pdf'),
(35, 'KPQ343', 1, 1, '2014-08-20', '2014-06-30', '2014-06-30', '2014-11-16', 'KPQ343.pdf', 'RUTA KPQ343.pdf', 'KPQ 343 NAC..pdf', 'KPQ 343 INTERN..pdf', 'VT KPQ343.pdf'),
(36, 'HFK639', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'FSO154', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'GFL857', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'EAM492', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'MUW216', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'FNX 115', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'FND122', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'KFA923', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'ILU790', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'IGC730', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'FZV194', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'MFT581', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'CYM749', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'SRR609', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'AWU591', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'RLA716', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'DAI740', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'RDQ066', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'DRL197', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'CQL340', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'HHI094', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'HHI095', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'GTR299', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'BFQ892', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'WAU234', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'BDL858', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'ERH575', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'BRN117', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'FAT666', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'CJY421', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'HRO490', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'HRO488', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'BOM848', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'GPV482', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'AAY102', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'DFM509', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'IYY611', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'DKU999', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'JTK356', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'IBT366', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'FEK120', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'FEK119', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 'GSB239', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 'LNP025', 2, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 'GBY254', 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 'CBY254', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 'LNP025', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 'JBJ090', 2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 'FWW451', 2, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `drilldown`
--
CREATE TABLE IF NOT EXISTS `drilldown` (
`1` int(1)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esquema-contable`
--

CREATE TABLE IF NOT EXISTS `esquema-contable` (
  `idEsquemaContable` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) DEFAULT NULL,
  `tipoMovimiento` char(1) DEFAULT NULL,
  `idCuenta` int(10) unsigned DEFAULT NULL,
  `saldoContable` char(1) DEFAULT NULL,
  `tipoMovimientoD` char(1) DEFAULT NULL,
  `idCuentaD` int(11) DEFAULT NULL,
  `saldoContableD` char(1) DEFAULT NULL,
  `tipoGasto` char(1) DEFAULT NULL,
  `tipoGastoD` char(1) NOT NULL,
  PRIMARY KEY (`idEsquemaContable`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `esquema-contable2`
--

CREATE TABLE IF NOT EXISTS `esquema-contable2` (
  `Id_esquemaContable` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Id_cuenta` int(11) NOT NULL,
  `rubroContracuenta` int(11) NOT NULL,
  `Id_contracuenta` int(11) NOT NULL,
  PRIMARY KEY (`Id_esquemaContable`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `esquema-contable2`
--

INSERT INTO `esquema-contable2` (`Id_esquemaContable`, `Id_cuenta`, `rubroContracuenta`, `Id_contracuenta`) VALUES
(1, 1, 1, 2),
(2, 1, 3, 3),
(3, 4, 5, 5),
(4, 4, 5, 6),
(5, 4, 5, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados-ut`
--

CREATE TABLE IF NOT EXISTS `estados-ut` (
  `idEstadoUT` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idEstadoUT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `estados-ut`
--

INSERT INTO `estados-ut` (`idEstadoUT`, `denominacion`) VALUES
(1, 'Datos'),
(2, 'Confirmado'),
(3, 'Cargado'),
(4, 'Frontera'),
(5, 'Descargado'),
(6, 'Anulado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fronteras`
--

CREATE TABLE IF NOT EXISTS `fronteras` (
  `idFrontera` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idCiudadOrigen` int(10) unsigned DEFAULT NULL,
  `idCiudadDestino` int(10) unsigned DEFAULT NULL,
  `frontera` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`idFrontera`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE IF NOT EXISTS `grupos` (
  `idGrupo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idGrupo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuestos`
--

CREATE TABLE IF NOT EXISTS `impuestos` (
  `Id_impuestos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacionImpuesto` varchar(20) NOT NULL,
  `porcentajeImpuesto` varchar(4) NOT NULL,
  `denominacionDebe` varchar(20) NOT NULL,
  `denominacionHaber` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_impuestos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `impuestos`
--

INSERT INTO `impuestos` (`Id_impuestos`, `denominacionImpuesto`, `porcentajeImpuesto`, `denominacionDebe`, `denominacionHaber`) VALUES
(1, 'IVA', '21', 'Iva Débito Fiscal', 'Iva Crédito Fiscal'),
(3, 'IVA', '10', 'Iva Débito Fiscal', 'Iva Crédito Fiscal'),
(4, 'ASD', '16.5', 'QWD', 'ASD'),
(5, 'imp', '0', 'asd', 'asd');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `listas-precios`
--

CREATE TABLE IF NOT EXISTS `listas-precios` (
  `idListaPrecio` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clave` varchar(255) DEFAULT NULL,
  `idCiudadOrigen` int(10) unsigned DEFAULT NULL,
  `idCiudadDestino` int(10) unsigned DEFAULT NULL,
  `idFrontera` int(10) unsigned DEFAULT NULL,
  `idMoneda` int(10) unsigned DEFAULT NULL,
  `valorTotal` float DEFAULT NULL,
  `transporteInternacional` float DEFAULT NULL,
  `transporteNacional` float DEFAULT NULL,
  `ivaTransporteNacional` float DEFAULT NULL,
  `comision` float DEFAULT NULL,
  PRIMARY KEY (`idListaPrecio`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `listas-precios`
--

INSERT INTO `listas-precios` (`idListaPrecio`, `clave`, `idCiudadOrigen`, `idCiudadDestino`, `idFrontera`, `idMoneda`, `valorTotal`, `transporteInternacional`, `transporteNacional`, `ivaTransporteNacional`, `comision`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, 200, 100, 100, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, 122, 20.5, 101.5, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL, 444, 44, 400, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mes-contable`
--

CREATE TABLE IF NOT EXISTS `mes-contable` (
  `id_MesContable` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mesContable` varchar(7) DEFAULT NULL,
  `activo` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id_MesContable`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `mes-contable`
--

INSERT INTO `mes-contable` (`id_MesContable`, `mesContable`, `activo`) VALUES
(1, '112014', 1),
(2, '2014-12', NULL),
(3, '012015', NULL),
(4, '022015', NULL),
(5, '2015-01', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `mescontableactivo`
--
CREATE TABLE IF NOT EXISTS `mescontableactivo` (
`id_MesContable` int(10) unsigned
,`mesContable` varchar(7)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE IF NOT EXISTS `monedas` (
  `idMoneda` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  `denominacionCorta` varchar(255) NOT NULL,
  PRIMARY KEY (`idMoneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`idMoneda`, `denominacion`, `denominacionCorta`) VALUES
(1, 'Pesos', '$'),
(2, 'Dolar', 'U$D'),
(3, 'Guaranies', 'Gua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

CREATE TABLE IF NOT EXISTS `movimientos` (
  `Id_movimiento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asiento` varchar(20) NOT NULL,
  `codigo` varchar(255) DEFAULT NULL,
  `empresa` int(11) DEFAULT NULL,
  `tercero` int(11) DEFAULT NULL,
  `Documento` int(11) DEFAULT NULL,
  `numeroDocumento` varchar(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `moneda` int(11) DEFAULT NULL,
  `tipoCambio` varchar(10) DEFAULT NULL,
  `rubroCuenta` int(11) DEFAULT NULL,
  `cuenta` int(11) DEFAULT NULL,
  `rubroContracuenta` int(11) DEFAULT NULL,
  `contracuenta` int(11) DEFAULT NULL,
  `cantidad` decimal(11,3) DEFAULT NULL,
  `importe` float DEFAULT NULL,
  `impuesto1` int(11) DEFAULT NULL,
  `impuesto1Porcentaje` float DEFAULT NULL,
  `impuesto1Importe` float DEFAULT NULL,
  `impuesto2` int(11) DEFAULT NULL,
  `impuesto2Porcentaje` float DEFAULT NULL,
  `impuesto2Importe` float DEFAULT NULL,
  `impuesto3` int(11) DEFAULT NULL,
  `impuesto3Importe` float DEFAULT NULL,
  `impuesto3Porcentaje` float DEFAULT NULL,
  `Observaciones` varchar(250) DEFAULT NULL,
  `adjunto` varchar(250) DEFAULT NULL,
  `montoImpuesto` float DEFAULT NULL,
  `montoNeto` float DEFAULT NULL,
  `montoTotal` float DEFAULT NULL,
  `imp1unit` tinyint(4) DEFAULT NULL,
  `imp2unit` tinyint(4) DEFAULT NULL,
  `imp3unit` tinyint(4) DEFAULT NULL,
  `mesContable` int(11) DEFAULT NULL,
  `anulado` tinyint(4) DEFAULT NULL,
  `impuesto1final` float DEFAULT NULL,
  `impuesto2final` float DEFAULT NULL,
  `impuesto3final` float DEFAULT NULL,
  PRIMARY KEY (`Id_movimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`Id_movimiento`, `asiento`, `codigo`, `empresa`, `tercero`, `Documento`, `numeroDocumento`, `fecha`, `moneda`, `tipoCambio`, `rubroCuenta`, `cuenta`, `rubroContracuenta`, `contracuenta`, `cantidad`, `importe`, `impuesto1`, `impuesto1Porcentaje`, `impuesto1Importe`, `impuesto2`, `impuesto2Porcentaje`, `impuesto2Importe`, `impuesto3`, `impuesto3Importe`, `impuesto3Porcentaje`, `Observaciones`, `adjunto`, `montoImpuesto`, `montoNeto`, `montoTotal`, `imp1unit`, `imp2unit`, `imp3unit`, `mesContable`, `anulado`, `impuesto1final`, `impuesto2final`, `impuesto3final`) VALUES
(2, '0', '1', 1, 3, 1, '1', '2014-12-28', NULL, NULL, 1, 1, 1, 2, '1.000', 1, 4, 1.3, 16.5, 3, 10, 10, 1, 21, 21, NULL, NULL, 16.5, 1, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(3, '0', NULL, 1, 3, 1, NULL, '2014-12-28', NULL, NULL, 1, 1, 1, 2, '1216.000', 100, 4, 16.5, 1650, 3, 10, 1000, 4, 1650, 16.5, NULL, NULL, 1650, 100, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(4, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(5, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, 4, 16.5, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(6, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, 1, 21, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(7, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, 1, 21, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(8, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, 3, 10, 0, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(9, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1.000', 0, 1, 0.21, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(11, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(12, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(13, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(14, '0', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(15, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(16, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(17, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(18, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(19, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(20, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(21, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(22, '0', '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(23, '20150102024917', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(24, '20150106055308', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(25, '20150106060712', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(26, '20150106070057', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(27, '20150106070133', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(28, '20150107072533', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(29, '20150107072632', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(30, '20150107072721', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(31, '20150107072738', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 3, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(32, '20150107072849', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(33, '20150107073326', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(34, '20150107074757', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(35, '20150107074909', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 3, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(36, '20150107082006', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0),
(37, '20150107082132', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0),
(38, '20150107104353', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(39, '20150107104535', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0),
(40, '20150107111543', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0),
(41, '20150107111647', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 10, 10, 0, 0, 0, 0, 0, 0, 0, 0),
(42, '20150108124927', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, 1, 21, 2.1, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 2.1, 10, 12.1, 0, 0, 0, 0, 0, 0, 0, 0),
(43, '20150108010343', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '10.000', 10, 1, 21, 2.1, 3, 0.1, 0.01, 5, 10, 0, NULL, NULL, 12.11, 100, 112.11, 0, 0, 0, 0, 0, 0, 0, 0),
(44, '20150108010446', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2.000', 30, 1, 21, 6.3, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 6.3, 60, 66.3, 0, 0, 0, 0, 0, 0, 0, 0),
(45, '20150108011114', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, 1, 21, 2.1, 3, 0.1, 0.01, 1, 0.021, 0.21, NULL, NULL, 2.131, 10, 12.131, 0, 0, 0, 0, 0, 0, 0, 0),
(46, '20150108011311', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '1.000', 10, NULL, 0, 0, 1, 0.21, 0.021, NULL, 0, 0, NULL, NULL, 0.021, 10, 10.021, 0, 0, 0, 0, 0, 0, 0, 0),
(47, '20150108012721', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 1, 1, 1, 2, '20.000', 10, 1, 21, 2.1, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 2.1, 200, 202.1, 0, 0, 0, 0, 0, 0, 0, 0),
(48, '20150108025911', '1', 1, 3, 1, '123456789', '2015-01-07', 1, '1', 4, 4, 5, 6, '2.000', 15, 1, 21, 3.15, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 3.15, 30, 33.15, 0, 0, 0, 0, 0, 0, 0, 0),
(49, '20150108012629', NULL, 1, 3, 1, '123456789', '2015-01-08', 1, '1', 4, 4, 5, 7, '2.000', 30, 1, 21, 6.3, 4, 16.5, 4.95, 5, 4.5, 15, NULL, NULL, 15.75, 60, 75.75, 0, 0, 0, 0, 0, 0, 0, 0),
(50, '20150108012824', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1.5', NULL, NULL, NULL, NULL, '1.000', 3, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 4.5, 4.5, 0, 0, 0, 0, 0, 0, 0, 0),
(51, '20150124095910', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '1233.156', 0, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(52, '20150125115811', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10', NULL, NULL, NULL, NULL, '10.135', 100, 5, NULL, 0, 1, 21, 2128.35, 4, 1672.28, 16.5, NULL, NULL, 3800.62, 10135, 13935.6, 0, 0, 0, 0, 1, 0, 0, 0),
(53, '20150126120422', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1.156', NULL, NULL, NULL, NULL, '0.000', 0, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(54, '20150126051129', NULL, NULL, NULL, 1, NULL, NULL, NULL, '1', 4, 4, 5, 6, '1.000', 1, NULL, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 1, 1, NULL, NULL, NULL, 2, NULL, 0, 0, 0),
(55, '20150126051233', NULL, NULL, NULL, 2, NULL, NULL, NULL, '1', 4, 4, 5, 5, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, 0, 0),
(56, '20150128043826', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, 0, 0, 0),
(57, '20150128104753', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(58, '20150128105138', NULL, 1, 3, 1, '123', '2015-01-04', 1, '1', 4, 4, 5, 7, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(59, '20150128105725', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(60, '20150128105857', NULL, NULL, NULL, 1, NULL, NULL, NULL, '1', 4, 4, 5, 7, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(61, '20150128110452', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(62, '20150128110622', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(63, '20150128111412', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, 0, 0),
(64, '20150128112411', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, 0, 0, 0),
(65, '20150128112447', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(66, '20150128113314', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 0, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 0, 50, 50, 1, NULL, NULL, 2, NULL, 0, 0, 0),
(67, '20150128114327', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '5.000', 10, 5, 0, 5, NULL, 0, 0, NULL, 0, 0, NULL, NULL, 25, 50, 75, 1, NULL, NULL, 2, NULL, 25, 0, 0),
(68, '20150130030330', '1', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL),
(69, '20150130030339', '1321', NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, NULL, NULL, '0.000', 0, NULL, NULL, 0, NULL, NULL, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE IF NOT EXISTS `niveles` (
  `idNivel` int(11) NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idNivel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`idNivel`, `denominacion`) VALUES
(-1, 'Administrador'),
(0, 'Default'),
(1, 'OperativoUT'),
(2, 'Consulta'),
(3, 'OperativoUTAleStano');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden-combustible`
--

CREATE TABLE IF NOT EXISTS `orden-combustible` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sociedad` int(10) unsigned DEFAULT NULL,
  `fechaEmision` date DEFAULT NULL,
  `terceroCombustible` int(11) DEFAULT NULL,
  `litros` double DEFAULT NULL,
  `dominio` int(11) DEFAULT NULL,
  `terceroChofer` int(11) DEFAULT NULL,
  `estado` int(10) unsigned DEFAULT NULL,
  `codigoUT` int(11) DEFAULT NULL,
  `codigoOrdenPago` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Volcado de datos para la tabla `orden-combustible`
--

INSERT INTO `orden-combustible` (`id`, `sociedad`, `fechaEmision`, `terceroCombustible`, `litros`, `dominio`, `terceroChofer`, `estado`, `codigoUT`, `codigoOrdenPago`) VALUES
(1, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000001'),
(2, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000002'),
(3, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000003'),
(4, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000004'),
(5, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000005'),
(6, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000006'),
(7, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000007'),
(8, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000008'),
(9, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000009'),
(10, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000010'),
(11, NULL, '2015-04-09', NULL, NULL, NULL, NULL, NULL, NULL, '0000-00000011'),
(12, NULL, '2015-04-09', NULL, NULL, NULL, NULL, 0, NULL, '0000-00000012'),
(13, NULL, '2015-04-09', NULL, NULL, NULL, NULL, 0, NULL, '0000-00000013'),
(14, NULL, '2015-04-09', 79, NULL, NULL, NULL, 0, NULL, '0000-00000014'),
(15, NULL, '2015-04-10', 79, NULL, NULL, NULL, 0, NULL, '0000-00000015'),
(16, 5, '2015-04-10', 79, 234, 10, 6, 0, NULL, '0000-00000016'),
(17, 5, '2015-04-10', 79, 567, 21, 18, 0, NULL, '0000-00000017'),
(18, 5, '2015-04-18', 79, 456, 12, 21, 0, NULL, '0000-00000018'),
(19, 5, '2015-04-18', 79, 345, 10, 21, 0, NULL, '0000-00000019'),
(20, 5, '2015-04-18', 79, 456, 14, 21, 0, NULL, '0000-00000020'),
(21, 5, '2015-04-18', 79, 456, 12, 21, 0, NULL, '0000-00000021'),
(22, 5, '2015-04-18', 79, 567, 12, 21, 0, NULL, '0000-00000022'),
(23, 5, '2015-04-18', 79, 65, 10, 21, 0, NULL, '0000-00000023'),
(24, 5, '2015-04-18', 79, 678, 12, 21, 0, NULL, '0000-00000024'),
(25, 5, '2015-04-18', 79, 567, 14, 21, 2, NULL, '0000-00000025'),
(26, 5, '2015-04-18', 79, 456, 10, 21, 2, NULL, '0000-00000026'),
(27, NULL, '2015-04-18', NULL, 567, NULL, NULL, 2, NULL, '0000-00000027');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paises`
--

CREATE TABLE IF NOT EXISTS `paises` (
  `idPais` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  `denominacionCorta` varchar(255) NOT NULL,
  PRIMARY KEY (`idPais`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `paises`
--

INSERT INTO `paises` (`idPais`, `denominacion`, `denominacionCorta`) VALUES
(1, 'Argentina', 'Arg'),
(2, 'Uruguay', 'Uy'),
(3, 'Paraguay', 'Py'),
(4, 'Brasil', 'Bra'),
(5, 'Bolivia', 'Bol'),
(6, 'Chile', 'Chi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peajes`
--

CREATE TABLE IF NOT EXISTS `peajes` (
  `idPeaje` int(11) NOT NULL AUTO_INCREMENT,
  `codigoViaje` varchar(255) DEFAULT NULL,
  `idEmpresa` int(11) DEFAULT NULL,
  `idTercero` int(11) DEFAULT NULL,
  `tipoDocumento` int(11) DEFAULT NULL,
  `numeroDocumento` varchar(255) DEFAULT NULL,
  `fechaDocumento` date DEFAULT NULL,
  `idMoneda` int(11) DEFAULT NULL,
  `tipoCambio` varchar(20) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` varchar(20) DEFAULT NULL,
  `total` varchar(20) DEFAULT NULL,
  `ivaIncluido` int(11) DEFAULT NULL,
  `IVA` varchar(20) DEFAULT NULL,
  `montoIVA` varchar(20) DEFAULT NULL,
  `montoNeto` varchar(20) DEFAULT NULL,
  `montoTotal` varchar(20) DEFAULT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `idUnidadTrabajo` int(11) DEFAULT NULL,
  `idCuenta` int(11) DEFAULT NULL,
  `idTipoGasto` varchar(1) DEFAULT NULL,
  `idMovimiento` varchar(1) DEFAULT NULL,
  `idSaldoContable` varchar(1) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idPeaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Volcado de datos para la tabla `peajes`
--

INSERT INTO `peajes` (`idPeaje`, `codigoViaje`, `idEmpresa`, `idTercero`, `tipoDocumento`, `numeroDocumento`, `fechaDocumento`, `idMoneda`, `tipoCambio`, `cantidad`, `precio`, `total`, `ivaIncluido`, `IVA`, `montoIVA`, `montoNeto`, `montoTotal`, `adjunto`, `idUnidadTrabajo`, `idCuenta`, `idTipoGasto`, `idMovimiento`, `idSaldoContable`, `observaciones`) VALUES
(1, 'ITLS.Molyagro.14.05.27', 18, 18, 0, '123', '2014-08-04', 1, '2', 6, '11.57', NULL, 1, '0.21', '29.16', '138.84', '168.00', NULL, 96, 3, 'P', 'E', 'H', ''),
(2, 'ITLS.Molyagro.14.05.27', 18, 18, 0, '123', '2014-08-04', 1, '2', 6, '11.57', NULL, 1, '0.21', '29.16', '138.84', '168.00', NULL, 96, 4, 'A', 'E', 'H', ''),
(3, 'ITLS.Molyagro.14.05.27', 18, 18, NULL, '123', '2014-08-04', 1, '2', 6, '11.57', '14', 1, '0.21', '29.16', '138.84', '168.00', NULL, 96, 1, 'R', 'E', 'D', NULL),
(4, 'ITLS.Molyagro.14.05.27', 0, 0, 0, '', '0000-00-00', 0, '1', 1, '168.00', '168.00', 0, '0', '0', '168.00', '168.00', NULL, 96, 3, 'P', 'E', 'H', ''),
(5, 'ITLS.Molyagro.14.05.27', 0, 0, 0, '', '0000-00-00', 0, '1', 1, '29.16', '29.16', 0, '0', '0', '29.16', '29.16', NULL, 96, 4, 'A', 'E', 'H', ''),
(6, 'ITLS.Molyagro.14.05.27', NULL, NULL, NULL, NULL, NULL, NULL, '2', 6, '11.57', '14', 1, '0.21', '29.16', '138.84', '168.00', NULL, 96, 1, 'R', 'E', 'D', NULL),
(7, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 96, 3, 'P', 'E', 'H', ''),
(8, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 96, 4, 'A', 'E', 'H', ''),
(9, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '123', 2, 'NaN', '3', 1, '0.21', 'NaN', 'NaN', 'NaN', NULL, 96, 1, 'R', 'E', 'D', NULL),
(10, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 1, '6.00', '6.00', 0, '0', '0', '6.00', '6.00', NULL, 96, 3, 'P', 'E', 'H', ''),
(11, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 1, '1.04', '1.04', 0, '0', '0', '1.04', '1.04', NULL, 96, 4, 'A', 'E', 'H', ''),
(12, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 2, '2.48', '3', 1, '0.21', '1.04', '4.96', '6.00', NULL, 96, 1, 'R', 'E', 'D', NULL),
(13, 'ITLS.Molyagro.14.05.27', 18, 18, 2, '123', '2014-12-15', 1, '1', 1, '6.00', '6.00', 0, '0', '0', '6.00', '6.00', NULL, 96, 3, 'P', 'E', 'H', ''),
(14, 'ITLS.Molyagro.14.05.27', 18, 18, 2, '123', '2014-12-15', 1, '1', 1, '1.04', '1.04', 0, '0', '0', '1.04', '1.04', NULL, 96, 4, 'A', 'E', 'H', ''),
(15, 'ITLS.Molyagro.14.05.27', 18, 18, 2, '123', '2014-12-15', 1, '1', 2, '2.48', '3', 1, '0.21', '1.04', '4.96', '6.00', NULL, 96, 1, 'R', 'E', 'D', NULL),
(16, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 96, 3, 'P', 'E', 'H', ''),
(17, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 96, 4, 'A', 'E', 'H', ''),
(18, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-15', 1, 'a', 2, '2.48', '3', 1, '0.21', 'NaN', 'NaN', 'NaN', NULL, 96, 1, 'R', 'E', 'D', NULL),
(19, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 96, 3, 'P', 'E', 'H', ''),
(20, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 96, 4, 'A', 'E', 'H', ''),
(21, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '123', '2014-12-14', 1, '1', 2, 'NaN', '23', 1, '0.21', 'NaN', 'NaN', 'NaN', NULL, 96, 1, 'R', 'E', 'D', NULL),
(22, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '2', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 95, 3, 'P', 'E', 'H', ''),
(23, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '2', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 95, 4, 'A', 'E', 'H', ''),
(24, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '2', '2014-12-14', 1, '3', 2, 'NaN', '1', 1, '0.21', 'NaN', 'NaN', 'NaN', NULL, 95, 1, 'R', 'E', 'D', NULL),
(25, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '3', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 95, 3, 'P', 'E', 'H', ''),
(26, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '3', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 95, 4, 'A', 'E', 'H', ''),
(27, 'ITLS.Molyagro.14.05.27', 18, 18, 1, '3', '2014-12-14', 1, '2', 3, 'NaN', '34', 1, '0.21', 'NaN', 'NaN', 'NaN', NULL, 95, 1, 'R', 'E', 'D', NULL),
(28, 'ITLS.Molyagro.14.05.27', 4, 49, 1, '34', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 95, 3, 'P', 'E', 'H', ''),
(29, 'ITLS.Molyagro.14.05.27', 4, 49, 1, '34', '2014-12-14', 1, '1', 1, 'NaN', 'NaN', 0, '0', '0', 'NaN', 'NaN', NULL, 95, 4, 'A', 'E', 'H', ''),
(30, 'ITLS.Molyagro.14.05.27', 4, 49, 1, '34', '2014-12-14', 1, '14', 15, 'NaN', '16', 1, '0.21', 'NaN', 'NaN', 'NaN', NULL, 95, 1, 'R', 'E', 'D', NULL),
(31, 'ITLS.Molyagro.14.05.27', 18, 18, 2, '999', '2015-01-01', 1, '1', 1, '10.00', '10.00', 0, '0', '0', '10.00', '10.00', NULL, 96, 3, 'P', 'E', 'H', ''),
(32, 'ITLS.Molyagro.14.05.27', 18, 18, 2, '999', '2015-01-01', 1, '1', 1, '1.74', '1.74', 0, '0', '0', '1.74', '1.74', NULL, 96, 4, 'A', 'E', 'H', ''),
(33, 'ITLS.Molyagro.14.05.27', 18, 18, 2, '999', '2015-01-01', 1, '1', 1, '8.26', '10', 1, '0.21', '1.74', '8.26', '10.00', NULL, 96, 1, 'R', 'E', 'D', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `idNivel` int(11) NOT NULL,
  `tabla` varchar(255) NOT NULL,
  `permisos` int(11) NOT NULL,
  PRIMARY KEY (`idNivel`,`tabla`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`idNivel`, `tabla`, `permisos`) VALUES
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}ciudades', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}condiciones-iva', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}cuentas', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}dominios', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}esquema-contable', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}estados-ut', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}fronteras', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}grupos', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}listas-precios', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}monedas', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}niveles', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}paises', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}peajes', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}permisos', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}porcentajes-iva', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}provincias', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}sociedades', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}terceros', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-documentos', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-operaciones', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-propietarios', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-terceros', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-ut', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-vehiculos', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}transacciones', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}unidades-trabajo', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuario-sociedades', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuarios', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view1', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view10', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view11', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view12', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view13', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view14', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view2', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view3', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view4', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view5', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view6', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view7', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view8', 0),
(0, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view9', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}analisisprecioxkm', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}asientos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades_provincias', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}condiciones-iva', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}contracuentas', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas2', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documento-movimiento', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentostipodocumentos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}dominios', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable2', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}estados-ut', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}fronteras', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}grupos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}impuestos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}listas-precios', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mes-contable', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mescontableactivo', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}monedas', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}movimientos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}niveles', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}paises', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}peajes', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}permisos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmcabecera', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmdetalle', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}porcentajes-iva', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}provincias', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}rubro-cuentas', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}saldo', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}sociedades', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}terceros', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-documento', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-gasto', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-movimiento', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-documentos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-operaciones', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-propietarios', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-terceros', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-ut', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-vehiculos', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}transacciones', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}unidades-trabajo', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuario-sociedades', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuarios', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view1', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view10', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view11', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view12', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view13', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view14', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view15', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view16', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view2', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view3', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view4', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view5', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view6', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view7', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view8', 0),
(0, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view9', 0),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}ciudades', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}condiciones-iva', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}cuentas', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}dominios', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}esquema-contable', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}estados-ut', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}fronteras', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}grupos', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}listas-precios', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}monedas', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}niveles', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}paises', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}peajes', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}permisos', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}porcentajes-iva', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}provincias', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}sociedades', 0),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}terceros', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-documentos', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-operaciones', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-propietarios', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-terceros', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-ut', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-vehiculos', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}transacciones', 0),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}unidades-trabajo', 0),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuario-sociedades', 0),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuarios', 0),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view1', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view10', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view11', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view12', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view13', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view14', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view2', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view3', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view4', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view5', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view6', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view7', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view8', 111),
(1, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view9', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}analisisprecioxkm', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}asientos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades_provincias', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}condiciones-iva', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}contracuentas', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas2', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documento-movimiento', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentostipodocumentos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}dominios', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable2', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}estados-ut', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}fronteras', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}grupos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}impuestos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}listas-precios', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mes-contable', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mescontableactivo', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}monedas', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}movimientos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}niveles', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}paises', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}peajes', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}permisos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmcabecera', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmdetalle', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}porcentajes-iva', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}provincias', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}rubro-cuentas', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}saldo', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}sociedades', 0),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}terceros', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-documento', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-gasto', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-movimiento', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-documentos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-operaciones', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-propietarios', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-terceros', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-ut', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-vehiculos', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}transacciones', 0),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}unidades-trabajo', 0),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuario-sociedades', 0),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuarios', 0),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view1', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view10', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view11', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view12', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view13', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view14', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view15', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view16', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view2', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view3', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view4', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view5', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view6', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view7', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view8', 111),
(1, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view9', 111),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}ciudades', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}condiciones-iva', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}cuentas', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}dominios', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}esquema-contable', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}estados-ut', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}fronteras', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}grupos', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}listas-precios', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}monedas', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}niveles', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}paises', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}peajes', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}permisos', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}porcentajes-iva', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}provincias', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}sociedades', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}terceros', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-documentos', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-operaciones', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-propietarios', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-terceros', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-ut', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-vehiculos', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}transacciones', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}unidades-trabajo', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuario-sociedades', 0),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuarios', 0),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view1', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view10', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view11', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view12', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view13', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view14', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view2', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view3', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view4', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view5', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view6', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view7', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view8', 104),
(2, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view9', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}analisisprecioxkm', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}asientos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades_provincias', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}condiciones-iva', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}contracuentas', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas2', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documento-movimiento', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentostipodocumentos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}dominios', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable2', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}estados-ut', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}fronteras', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}grupos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}impuestos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}listas-precios', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mes-contable', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mescontableactivo', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}monedas', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}movimientos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}niveles', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}paises', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}peajes', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}permisos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmcabecera', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmdetalle', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}porcentajes-iva', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}provincias', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}rubro-cuentas', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}saldo', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}sociedades', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}terceros', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-documento', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-gasto', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-movimiento', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-documentos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-operaciones', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-propietarios', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-terceros', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-ut', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-vehiculos', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}transacciones', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}unidades-trabajo', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuario-sociedades', 0),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuarios', 0),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view1', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view10', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view11', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view12', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view13', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view14', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view15', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view16', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view2', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view3', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view4', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view5', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view6', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view7', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view8', 104),
(2, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view9', 104),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}ciudades', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}condiciones-iva', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}cuentas', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}dominios', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}esquema-contable', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}estados-ut', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}fronteras', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}grupos', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}listas-precios', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}monedas', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}niveles', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}paises', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}peajes', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}permisos', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}porcentajes-iva', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}provincias', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}sociedades', 0),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}terceros', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-documentos', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-operaciones', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-propietarios', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-terceros', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-ut', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}tipos-vehiculos', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}transacciones', 0),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}unidades-trabajo', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuario-sociedades', 0),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}usuarios', 0),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view1', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view10', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view11', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view12', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view13', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view14', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view2', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view3', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view4', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view5', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view6', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view7', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view8', 111),
(3, '{427EA519-C899-4D37-ABE4-C47AB22B700B}view9', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}analisisprecioxkm', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}asientos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}ciudades_provincias', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}condiciones-iva', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}contracuentas', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}cuentas2', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documento-movimiento', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}documentostipodocumentos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}dominios', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}esquema-contable2', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}estados-ut', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}fronteras', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}grupos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}impuestos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}listas-precios', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mes-contable', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}mescontableactivo', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}monedas', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}movimientos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}niveles', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}paises', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}peajes', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}permisos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmcabecera', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}planillakmdetalle', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}porcentajes-iva', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}provincias', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}rubro-cuentas', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}saldo', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}sociedades', 0),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}terceros', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-documento', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-gasto', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipo-movimiento', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-documentos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-operaciones', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-propietarios', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-terceros', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-ut', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}tipos-vehiculos', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}transacciones', 0),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}unidades-trabajo', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuario-sociedades', 0),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}usuarios', 0),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view1', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view10', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view11', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view12', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view13', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view14', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view15', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view16', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view2', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view3', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view4', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view5', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view6', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view7', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view8', 111),
(3, '{5B6CC4C4-3465-4120-8C2A-2684077FECEB}view9', 111);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planillakmcabecera`
--

CREATE TABLE IF NOT EXISTS `planillakmcabecera` (
  `idPlanillaKm` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idSociedad` int(11) DEFAULT NULL,
  `idTerceros` int(11) DEFAULT NULL,
  `idDominio` int(11) DEFAULT NULL,
  `idMesContable` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPlanillaKm`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=115 ;

--
-- Volcado de datos para la tabla `planillakmcabecera`
--

INSERT INTO `planillakmcabecera` (`idPlanillaKm`, `idSociedad`, `idTerceros`, `idDominio`, `idMesContable`) VALUES
(1, 1, 16, 20, 2),
(23, 1, 18, 24, 7),
(24, 1, 18, 24, 8),
(25, 1, 18, 24, 9),
(26, 1, 18, 24, 10),
(27, 1, 18, 24, 11),
(28, 1, 18, 24, 12),
(29, 1, 18, 24, 13),
(30, 1, 18, 24, 14),
(31, 1, 18, 24, 15),
(32, 1, 18, 24, 16),
(33, 1, 18, 24, 17),
(34, 1, 18, 24, 18),
(35, 2, 30, 93, 7),
(36, 2, 30, 93, 8),
(37, 2, 30, 93, 9),
(38, 2, 30, 24, 10),
(39, 2, 30, 0, 11),
(40, 2, 30, 24, 12),
(41, 2, 30, 24, 13),
(42, 2, 30, 10, 14),
(43, 2, 30, 35, 15),
(44, 2, 30, 35, 16),
(45, 2, 30, 35, 17),
(46, 2, 30, 35, 18),
(47, 1, 11, 10, 7),
(48, 1, 11, 10, 8),
(49, 1, 11, 10, 9),
(50, 1, 11, 10, 10),
(51, 1, 11, 10, 11),
(52, 1, 11, 10, 12),
(53, 1, 11, 10, 13),
(54, 1, 11, 10, 14),
(55, 1, 11, 10, 15),
(56, 1, 11, 10, 16),
(57, 1, 11, 10, 17),
(58, 1, 11, 10, 18),
(59, 2, 29, 34, 7),
(60, 2, 29, 34, 8),
(61, 2, 29, 34, 9),
(62, 2, 29, 34, 10),
(63, 2, 29, 34, 11),
(64, 2, 29, 34, 12),
(65, 2, 29, 34, 13),
(66, 2, 29, 34, 14),
(67, 2, 29, 34, 15),
(68, 2, 29, 35, 16),
(69, 2, 29, 314, 17),
(70, 2, 29, 314, 18),
(71, 1, 26, 35, 7),
(72, 1, 26, 35, 8),
(73, 1, 26, 35, 9),
(74, 1, 26, 35, 10),
(75, 1, 26, 35, 11),
(76, 1, 26, 35, 12),
(77, 1, 26, 35, 13),
(78, 1, 26, 35, 14),
(79, 2, 12, 14, 7),
(80, 2, 12, 14, 8),
(81, 2, 12, 14, 9),
(82, 2, 12, 14, 10),
(83, 2, 12, 14, 11),
(84, 2, 12, 14, 12),
(85, 2, 12, 14, 13),
(86, 2, 12, 14, 14),
(87, 2, 12, 14, 15),
(88, 2, 12, 14, 16),
(89, 2, 12, 14, 17),
(90, 2, 12, 14, 18),
(91, 2, 21, 12, 7),
(92, 2, 21, 12, 8),
(93, 2, 21, 12, 9),
(94, 2, 21, 12, 10),
(95, 2, 21, 12, 11),
(96, 2, 21, 12, 12),
(97, 2, 21, 12, 13),
(98, 2, 21, 12, 14),
(99, 2, 21, 12, 15),
(100, 2, 21, 12, 16),
(101, 2, 21, 12, 17),
(102, 2, 21, 12, 18),
(103, 1, 16, 20, 7),
(104, 1, 16, 20, 8),
(105, 1, 16, 20, 9),
(106, 1, 16, 20, 10),
(107, 1, 16, 20, 11),
(108, 1, 16, 20, 12),
(109, 1, 16, 20, 13),
(110, 1, 16, 20, 14),
(111, 1, 16, 20, 15),
(112, 1, 16, 20, 16),
(113, 1, 16, 20, 17),
(114, 1, 16, 20, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planillakmdetalle`
--

CREATE TABLE IF NOT EXISTS `planillakmdetalle` (
  `idPlanillaKmDetalle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fechaSalida` date DEFAULT NULL,
  `lugarSalida` int(11) DEFAULT NULL,
  `fechaLlegada` date DEFAULT NULL,
  `lugarLlegada` int(11) DEFAULT NULL,
  `kilometrosRecorridos` int(11) DEFAULT NULL,
  `controlDescarga` int(11) DEFAULT NULL,
  `simplePresencia` int(11) DEFAULT NULL,
  `cruceFrontera` int(11) DEFAULT NULL,
  `kilometrosRecorridos120` int(11) DEFAULT NULL,
  `kilometrosRecorridos140` int(11) DEFAULT NULL,
  `idUt` int(11) DEFAULT NULL,
  `viajaVacio` tinyint(4) DEFAULT NULL,
  `idPlanillaKmCabecera` int(11) DEFAULT NULL,
  PRIMARY KEY (`idPlanillaKmDetalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1673 ;

--
-- Volcado de datos para la tabla `planillakmdetalle`
--

INSERT INTO `planillakmdetalle` (`idPlanillaKmDetalle`, `fechaSalida`, `lugarSalida`, `fechaLlegada`, `lugarLlegada`, `kilometrosRecorridos`, `controlDescarga`, `simplePresencia`, `cruceFrontera`, `kilometrosRecorridos120`, `kilometrosRecorridos140`, `idUt`, `viajaVacio`, `idPlanillaKmCabecera`) VALUES
(1, '2014-11-27', 3, '2014-11-27', 19, 270, 1, NULL, NULL, NULL, NULL, 28, 1, 1),
(5, '2014-11-27', 19, '2014-11-27', 63, 120, NULL, NULL, NULL, NULL, NULL, 28, 1, 1),
(6, '2014-12-01', 63, '2014-12-01', 20, 154, NULL, NULL, NULL, NULL, NULL, 43, NULL, 1),
(258, '2013-12-26', 4, '2013-12-26', 5, 345, 1, 1, 1, 0, 0, 0, 0, 23),
(259, '2013-12-26', 5, '2013-12-26', 3, 345, 0, 0, 1, 0, 0, 0, 0, 23),
(260, '2014-01-02', 3, '2014-01-02', 70, 241, 1, 0, 0, 0, 0, 0, 0, 23),
(261, '2014-01-02', 70, '2014-01-03', 3, 305, 0, 0, 0, 0, 0, 0, 0, 23),
(262, '2014-01-19', 3, '2014-01-20', 46, 315, 0, 0, 0, 0, 0, 0, 0, 23),
(263, '2014-01-20', 46, '2014-01-21', 3, 315, 0, 0, 0, 0, 0, 0, 0, 23),
(264, '2014-01-21', 3, '2014-01-21', 4, 38, 0, 1, 1, 0, 0, 0, 0, 23),
(265, '2014-01-22', 4, '2014-01-22', 207, 445, 1, 1, 0, 0, 0, 0, 0, 23),
(266, '2014-01-23', 207, '2014-01-23', 3, 480, 0, 1, 1, 0, 0, 0, 0, 23),
(267, '2014-01-26', 3, '2014-01-27', 47, 240, 0, 0, 0, 0, 0, 0, 0, 23),
(268, '2014-01-27', 47, '2014-01-27', 3, 331, 0, 0, 0, 0, 0, 0, 0, 23),
(269, '2014-01-28', 3, '2014-01-28', 4, 38, 0, 1, 1, 0, 0, 0, 0, 24),
(270, '2014-01-29', 4, '2014-01-29', 64, 348, 1, 2, 0, 0, 0, 0, 0, 24),
(271, '2014-01-30', 64, '2014-01-30', 3, 390, 0, 0, 1, 0, 0, 0, 0, 24),
(272, '2014-01-30', 3, '2014-01-31', 20, 325, 0, 0, 0, 0, 0, 0, 0, 24),
(273, '2014-01-31', 20, '2014-01-31', 3, 325, 0, 0, 0, 0, 0, 0, 0, 24),
(274, '2014-02-03', 3, '2014-02-03', 4, 38, 0, 3, 1, 0, 0, 0, 0, 24),
(275, '2014-02-05', 4, '2014-02-06', 5, 335, 1, 1, 0, 0, 0, 0, 0, 24),
(276, '2014-02-06', 5, '2014-02-07', 179, 430, 0, 1, 0, 0, 0, 0, 0, 24),
(277, '2014-02-07', 179, '2014-02-07', 3, 120, 0, 0, 1, 0, 0, 0, 0, 24),
(278, '2014-02-09', 3, '2014-02-10', 91, 475, 0, 0, 0, 0, 0, 0, 0, 24),
(279, '2014-02-10', 91, '2014-02-10', 208, 37, 1, 1, 0, 0, 0, 0, 0, 24),
(280, '2014-02-11', 208, '2014-02-12', 194, 580, 1, 0, 0, 0, 0, 0, 0, 24),
(281, '2014-02-12', 194, '2014-02-12', 3, 280, 0, 0, 0, 0, 0, 0, 0, 24),
(282, '2014-03-10', 3, '2014-03-11', 50, 545, 0, 2, 0, 0, 0, 0, 0, 25),
(283, '2014-03-13', 50, '2014-03-13', 3, 545, 0, 0, 0, 0, 0, 0, 0, 25),
(284, '2014-03-13', 3, '2014-03-13', 4, 38, 0, 0, 1, 0, 0, 0, 0, 25),
(285, '2014-03-16', 4, '2014-03-17', 5, 345, 1, 0, 0, 0, 0, 0, 0, 25),
(286, '2014-03-17', 5, '2014-03-17', 48, 325, 0, 1, 0, 0, 0, 0, 0, 25),
(287, '2014-03-18', 48, '2014-03-18', 4, 120, 0, 1, 0, 0, 0, 0, 0, 25),
(288, '2014-03-19', 4, '2014-03-19', 3, 38, 0, 1, 1, 0, 0, 0, 0, 25),
(289, '2014-03-19', 3, '2014-03-20', 99, 1120, 1, 4, 0, 0, 0, 0, 0, 25),
(290, '2014-03-25', 99, '2014-03-26', 54, 387, 0, 1, 0, 0, 0, 0, 0, 25),
(291, '2014-03-26', 54, '2014-03-28', 3, 1448, 0, 0, 0, 0, 0, 0, 0, 25),
(292, '2014-03-31', 3, '2014-04-01', 4, 38, 1, 1, 1, 0, 0, 0, 0, 26),
(293, '2014-04-01', 4, '2014-04-02', 5, 390, 0, 0, 0, 0, 0, 0, 0, 26),
(294, '2014-04-03', 5, '2014-04-05', 4, 415, 0, 2, 0, 0, 0, 0, 0, 26),
(295, '2014-04-05', 4, '2014-04-05', 3, 38, 0, 0, 1, 0, 0, 0, 0, 26),
(296, '2014-04-08', 63, '2014-04-10', 2, 220, 1, 2, 0, 0, 0, 0, 0, 26),
(297, '2014-04-11', 2, '2014-04-11', 3, 335, 0, 0, 0, 0, 0, 0, 0, 26),
(298, '2014-04-14', 3, '2014-04-14', 4, 38, 0, 0, 1, 0, 0, 0, 0, 26),
(299, '2014-04-14', 4, '2014-04-14', 5, 313, 1, 2, 0, 0, 0, 0, 0, 26),
(300, '2014-04-15', 5, '2014-04-16', 3, 380, 0, 0, 1, 0, 0, 0, 0, 26),
(301, '2014-04-21', 3, '2014-04-21', 177, 260, 1, 1, 0, 0, 0, 0, 0, 26),
(302, '2014-04-22', 177, '2014-04-23', 102, 1047, 0, 2, 0, 0, 0, 0, 0, 26),
(303, '2014-04-25', 61, '2014-04-26', 3, 1330, 0, 0, 0, 0, 0, 0, 0, 27),
(304, '2014-04-28', 3, '2014-04-29', 5, 380, 1, 5, 1, 0, 0, 0, 0, 27),
(305, '2014-05-03', 5, '2014-05-03', 179, 460, 0, 1, 0, 0, 0, 0, 0, 27),
(306, '2014-05-05', 179, '2014-05-05', 209, 415, 0, 4, 1, 0, 0, 0, 0, 27),
(307, '2014-05-09', 209, '2014-05-09', 194, 15, 1, 0, 0, 0, 0, 0, 0, 27),
(308, '2014-05-10', 194, '2014-05-12', 31, 695, 0, 0, 0, 0, 0, 0, 0, 27),
(309, '2014-05-12', 31, '2014-05-13', 3, 730, 0, 0, 0, 0, 0, 0, 0, 27),
(310, '2014-05-14', 3, '2014-05-16', 43, 395, 1, 0, 1, 0, 0, 0, 0, 27),
(311, '2014-05-16', 43, '2014-05-17', 1, 865, 0, 0, 1, 0, 0, 0, 0, 27),
(312, '2014-05-17', 1, '2014-05-17', 3, 480, 0, 0, 0, 0, 0, 0, 0, 27),
(313, '2014-05-18', 3, '2014-05-18', 22, 817, 0, 0, 0, 0, 0, 0, 0, 27),
(314, '2014-05-19', 22, '2014-05-19', 21, 10, 0, 5, 1, 0, 0, 0, 0, 27),
(315, '2014-05-22', 21, '2014-05-23', 12, 285, 1, 0, 0, 0, 0, 0, 0, 27),
(316, '2014-05-23', 12, '2014-05-23', 21, 285, 0, 2, 0, 0, 0, 0, 0, 27),
(317, '2014-05-26', 21, '2014-05-26', 22, 10, 0, 0, 1, 0, 0, 0, 0, 27),
(318, '2014-05-26', 22, '2014-05-26', 62, 100, 0, 2, 0, 0, 0, 0, 0, 28),
(319, '2014-05-27', 62, '2014-05-28', 3, 715, 0, 0, 0, 0, 0, 0, 0, 28),
(320, '2014-05-29', 3, '2014-05-29', 7, 276, 1, 0, 0, 0, 0, 0, 0, 28),
(321, '2014-05-30', 7, '2014-06-02', 110, 720, 0, 0, 0, 0, 0, 0, 0, 28),
(322, '2014-06-03', 110, '2014-06-03', 3, 720, 0, 0, 0, 0, 0, 0, 0, 28),
(323, '2014-06-04', 3, '2014-06-04', 5, 360, 1, 0, 1, 0, 0, 0, 0, 28),
(324, '2014-06-05', 5, '2014-06-05', 48, 315, 0, 1, 0, 0, 0, 0, 0, 28),
(325, '2014-06-08', 48, '2014-06-08', 4, 140, 0, 0, 0, 0, 0, 0, 0, 28),
(326, '2014-06-27', 3, '2014-06-27', 3, 35, 0, 0, 0, 0, 0, 0, 0, 29),
(327, '2014-07-10', 3, '2014-07-11', 39, 180, 1, 0, 0, 0, 0, 0, 0, 29),
(328, '2014-07-11', 39, '2014-07-11', 134, 115, 0, 0, 0, 0, 0, 0, 0, 29),
(329, '2014-07-14', 134, '2014-07-15', 3, 270, 0, 0, 0, 0, 0, 0, 0, 29),
(330, '2014-07-15', 3, '2014-07-16', 5, 380, 1, 2, 1, 0, 0, 0, 0, 29),
(331, '2014-07-16', 5, '2014-07-17', 27, 430, 0, 0, 1, 0, 0, 0, 0, 29),
(332, '2014-07-17', 27, '2014-07-17', 3, 40, 0, 0, 0, 0, 0, 0, 0, 29),
(333, '2014-07-18', 3, '2014-07-18', 34, 80, 0, 0, 0, 0, 0, 0, 0, 29),
(334, '2014-07-20', 34, '2014-07-20', 22, 750, 0, 0, 0, 0, 0, 0, 0, 29),
(335, '2014-07-21', 22, '2014-07-21', 21, 10, 0, 3, 1, 0, 0, 0, 0, 29),
(336, '2014-07-22', 21, '2014-07-22', 96, 261, 0, 5, 0, 0, 0, 0, 0, 29),
(337, '2014-07-27', 96, '2014-07-28', 21, 261, 0, 0, 0, 0, 0, 0, 0, 29),
(338, '2014-07-28', 21, '2014-07-28', 62, 110, 0, 0, 1, 0, 0, 0, 0, 29),
(339, '2014-07-30', 62, '2014-07-30', 3, 736, 0, 1, 0, 0, 0, 0, 0, 30),
(340, '2014-07-30', 3, '2014-07-31', 69, 215, 1, 0, 0, 0, 0, 0, 0, 30),
(341, '2014-08-01', 69, '2014-08-01', 67, 95, 0, 0, 0, 0, 0, 0, 0, 30),
(342, '2014-08-04', 67, '2014-08-04', 3, 260, 0, 0, 0, 0, 0, 0, 0, 30),
(343, '2014-08-05', 3, '2014-08-05', 4, 38, 0, 0, 1, 0, 0, 0, 0, 30),
(344, '2014-08-05', 4, '2014-08-06', 5, 320, 1, 1, 0, 0, 0, 0, 0, 30),
(345, '2014-08-06', 5, '2014-08-06', 3, 320, 0, 0, 1, 0, 0, 0, 0, 30),
(346, '2014-08-07', 3, '2014-08-07', 47, 240, 0, 0, 0, 0, 0, 0, 0, 30),
(347, '2014-08-07', 47, '2014-08-07', 67, 113, 0, 0, 0, 0, 0, 0, 0, 30),
(348, '2014-08-08', 67, '2014-08-08', 3, 265, 0, 0, 0, 0, 0, 0, 0, 30),
(349, '2014-08-09', 3, '2014-08-09', 4, 38, 0, 0, 1, 0, 0, 0, 0, 30),
(350, '2014-08-11', 4, '2014-08-11', 5, 368, 1, 1, 0, 0, 0, 0, 0, 30),
(351, '2014-08-11', 5, '2014-08-12', 3, 368, 0, 0, 1, 0, 0, 0, 0, 30),
(352, '2014-08-12', 3, '2014-08-13', 20, 335, 0, 0, 0, 0, 0, 0, 0, 30),
(353, '2014-08-13', 20, '2014-08-13', 3, 335, 0, 0, 0, 0, 0, 0, 0, 30),
(354, '2014-08-14', 3, '2014-08-14', 4, 38, 0, 0, 1, 0, 0, 0, 0, 30),
(355, '2014-08-14', 4, '2014-08-15', 5, 345, 1, 1, 0, 0, 0, 0, 0, 30),
(356, '2014-08-15', 5, '2014-08-15', 3, 380, 0, 0, 1, 0, 0, 0, 0, 30),
(357, '2014-08-19', 3, '2014-08-19', 53, 355, 0, 0, 0, 0, 0, 0, 0, 30),
(358, '2014-08-19', 53, '2014-08-20', 3, 370, 0, 0, 0, 0, 0, 0, 0, 30),
(359, '2014-08-20', 3, '2014-08-20', 4, 38, 0, 0, 1, 0, 0, 0, 0, 30),
(360, '2014-08-20', 4, '2014-08-20', 48, 210, 1, 1, 0, 0, 0, 0, 0, 30),
(361, '2014-08-21', 48, '2014-08-21', 3, 160, 0, 0, 1, 0, 0, 0, 0, 30),
(362, '2014-08-22', 3, '2014-08-22', 53, 355, 0, 0, 0, 0, 0, 0, 0, 30),
(363, '2014-08-22', 53, '2014-08-23', 3, 390, 0, 0, 0, 0, 0, 0, 0, 30),
(364, '2014-08-23', 3, '2014-08-23', 4, 38, 0, 0, 1, 0, 0, 0, 0, 30),
(365, '2014-08-26', 4, '2014-08-27', 5, 350, 1, 1, 0, 0, 0, 0, 0, 30),
(366, '2014-08-27', 5, '2014-08-27', 3, 350, 1, 1, 1, 0, 0, 0, 0, 31),
(367, '2014-08-28', 3, '2014-08-29', 4, 38, 0, 1, 1, 0, 0, 0, 0, 31),
(368, '2014-08-31', 4, '2014-08-31', 5, 345, 1, 1, 0, 0, 0, 0, 0, 31),
(369, '2014-09-02', 5, '2014-09-03', 4, 325, 0, 1, 0, 0, 0, 0, 0, 31),
(370, '2014-09-03', 4, '2014-09-03', 3, 38, 0, 0, 1, 0, 0, 0, 0, 31),
(371, '2014-09-03', 3, '2014-09-04', 210, 255, 1, 0, 0, 0, 0, 0, 0, 31),
(372, '2014-09-04', 210, '2014-09-05', 3, 255, 0, 0, 0, 0, 0, 0, 0, 31),
(373, '2014-09-10', 3, '2014-09-11', 53, 356, 0, 0, 0, 0, 0, 0, 0, 31),
(374, '2014-09-11', 53, '2014-09-12', 3, 356, 0, 0, 0, 0, 0, 0, 0, 31),
(375, '2014-09-13', 3, '2014-09-13', 22, 820, 0, 1, 0, 0, 0, 0, 0, 31),
(376, '2014-09-15', 22, '2014-09-15', 21, 10, 0, 3, 1, 0, 0, 0, 0, 31),
(377, '2014-09-16', 21, '2014-09-16', 12, 380, 1, 1, 0, 0, 0, 0, 0, 31),
(378, '2014-09-17', 12, '2014-09-17', 22, 390, 0, 0, 1, 0, 0, 0, 0, 31),
(379, '2014-09-18', 22, '2014-09-18', 62, 100, 0, 0, 0, 0, 0, 0, 0, 31),
(380, '2014-09-18', 62, '2014-09-19', 67, 938, 1, 0, 0, 0, 0, 0, 0, 31),
(381, '2014-09-24', 67, '2014-09-24', 9, 230, 0, 0, 0, 0, 0, 0, 0, 31),
(382, '2014-09-24', 9, '2014-09-25', 3, 310, 0, 0, 0, 0, 0, 0, 0, 31),
(383, '2014-09-24', 9, '2014-09-25', 3, 350, 0, 0, 0, 0, 0, 0, 0, 32),
(384, '2014-09-25', 3, '2014-09-26', 18, 1045, 0, 8, 1, 0, 0, 0, 0, 32),
(385, '2014-10-03', 18, '2014-10-04', 141, 460, 1, 0, 0, 0, 0, 0, 0, 32),
(386, '2014-10-04', 141, '2014-10-04', 21, 50, 0, 1, 0, 0, 0, 0, 0, 32),
(387, '2014-10-05', 21, '2014-10-05', 62, 110, 0, 1, 0, 0, 0, 0, 0, 32),
(388, '2014-10-07', 62, '2014-10-08', 3, 830, 0, 0, 0, 0, 0, 0, 0, 32),
(389, '2014-10-27', 3, '2014-10-27', 35, 330, 1, 1, 0, 0, 0, 0, 0, 33),
(390, '2014-10-28', 35, '2014-10-29', 53, 335, 0, 0, 0, 0, 0, 0, 0, 33),
(391, '2014-10-29', 53, '2014-10-29', 3, 350, 0, 0, 0, 0, 0, 0, 0, 33),
(392, '2014-11-02', 3, '2014-11-02', 211, 1026, 0, 4, 1, 0, 0, 0, 0, 33),
(393, '2014-11-06', 211, '2014-11-06', 167, 290, 1, 3, 0, 0, 0, 0, 0, 33),
(394, '2014-11-08', 167, '2014-11-10', 21, 510, 0, 0, 0, 0, 0, 0, 0, 33),
(395, '2014-11-10', 21, '2014-11-10', 62, 110, 0, 0, 1, 0, 0, 0, 0, 33),
(396, '2014-11-12', 62, '2014-11-14', 172, 1120, 1, 1, 0, 0, 0, 0, 0, 33),
(397, '2014-11-14', 172, '2014-11-14', 3, 320, 0, 0, 0, 0, 0, 0, 0, 33),
(398, '2014-11-21', 3, '2014-11-21', 39, 190, 0, 0, 0, 0, 0, 0, 0, 33),
(399, '2014-11-22', 39, '2014-11-22', 3, 190, 0, 0, 0, 0, 0, 0, 0, 33),
(400, '2014-11-22', 3, '2014-11-22', 4, 38, 0, 1, 1, 0, 0, 0, 0, 33),
(401, '2014-11-24', 4, '2014-11-25', 5, 320, 1, 1, 0, 0, 0, 0, 0, 33),
(402, '2014-11-25', 5, '2014-11-25', 3, 395, 0, 0, 1, 0, 0, 0, 0, 33),
(403, '2014-11-27', 3, '2014-11-28', 1, 465, 0, 0, 0, 0, 0, 0, 0, 34),
(404, '2014-11-28', 1, '2014-11-29', 3, 465, 0, 0, 0, 0, 0, 0, 0, 34),
(405, '2014-11-30', 3, '2014-11-30', 21, 870, 0, 4, 1, 0, 0, 0, 0, 34),
(406, '2014-12-03', 21, '2014-12-03', 12, 280, 1, 0, 0, 0, 0, 0, 0, 34),
(407, '2014-12-04', 12, '2014-12-04', 21, 280, 0, 0, 1, 0, 0, 0, 0, 34),
(408, '2014-12-05', 21, '2014-12-05', 62, 110, 0, 0, 0, 0, 0, 0, 0, 34),
(409, '2014-12-05', 62, '2014-12-06', 3, 860, 0, 0, 0, 0, 0, 0, 0, 34),
(410, '2014-12-09', 3, '2014-12-09', 175, 330, 1, 0, 0, 0, 0, 0, 0, 34),
(411, '2014-12-09', 175, '2014-12-09', 63, 174, 0, 0, 0, 0, 0, 0, 0, 34),
(412, '2014-12-15', 63, '2014-12-15', 168, 240, 0, 0, 0, 0, 0, 0, 0, 34),
(413, '2014-12-15', 168, '2014-12-15', 53, 60, 0, 0, 0, 0, 0, 0, 0, 34),
(414, '2014-12-15', 53, '2014-12-16', 3, 360, 0, 0, 0, 0, 0, 0, 0, 34),
(415, '2014-12-16', 3, '2014-12-17', 21, 860, 0, 1, 1, 0, 0, 0, 0, 34),
(416, '2014-12-18', 21, '2014-12-19', 212, 310, 1, 5, 0, 0, 0, 0, 0, 34),
(417, '2014-12-20', 212, '2014-12-20', 21, 310, 0, 0, 0, 0, 0, 0, 0, 34),
(418, '2014-12-22', 21, '2014-12-22', 62, 110, 0, 0, 1, 0, 0, 0, 0, 34),
(419, '2014-12-22', 62, '2014-12-23', 75, 960, 1, 0, 0, 0, 0, 0, 0, 34),
(420, '2014-12-23', 75, '2014-12-23', 3, 290, 0, 0, 0, 0, 0, 0, 0, 34),
(421, '2014-01-02', 3, '2014-01-03', 17, 1000, 0, 0, 0, 0, 0, 0, 0, 35),
(422, '2014-01-03', 17, '2014-01-03', 213, 5, 0, 3, 1, 0, 0, 0, 0, 35),
(423, '2014-01-06', 213, '2014-01-06', 18, 39, 1, 0, 0, 0, 0, 0, 0, 35),
(424, '2014-01-07', 18, '2014-01-09', 62, 447, 0, 0, 1, 0, 0, 0, 0, 35),
(425, '2014-01-09', 62, '2014-01-10', 2, 1003, 1, 0, 0, 0, 0, 0, 0, 35),
(426, '2014-01-10', 2, '2014-01-10', 11, 160, 0, 0, 0, 0, 0, 0, 0, 35),
(427, '2014-01-10', 11, '2014-01-10', 3, 275, 0, 0, 0, 0, 0, 0, 0, 35),
(428, '2014-01-12', 3, '2014-01-12', 125, 430, 0, 0, 0, 0, 0, 0, 0, 35),
(429, '2014-01-13', 125, '2014-01-13', 21, 338, 0, 0, 1, 0, 0, 0, 0, 35),
(430, '2014-01-15', 21, '2014-01-15', 121, 43, 1, 2, 0, 0, 0, 0, 0, 35),
(431, '2014-01-15', 121, '2014-01-16', 62, 132, 0, 0, 1, 0, 0, 0, 0, 35),
(432, '2014-01-20', 62, '2014-01-22', 69, 891, 0, 4, 0, 0, 0, 0, 0, 35),
(433, '2014-01-22', 69, '2014-01-22', 52, 76, 0, 0, 0, 0, 0, 0, 0, 35),
(434, '2014-01-22', 52, '2014-01-22', 3, 250, 0, 1, 0, 0, 0, 0, 0, 35),
(435, '2014-01-24', 3, '2014-01-24', 52, 250, 1, 0, 0, 0, 0, 0, 0, 35),
(436, '2014-01-24', 52, '2014-01-24', 3, 279, 0, 0, 0, 0, 0, 0, 0, 35),
(437, '2014-01-28', 3, '2014-01-28', 53, 343, 0, 0, 0, 0, 0, 0, 0, 36),
(438, '2014-01-28', 53, '2014-01-30', 21, 1111, 0, 0, 1, 0, 0, 0, 0, 36),
(439, '2014-01-30', 21, '2014-01-31', 86, 269, 1, 1, 0, 0, 0, 0, 0, 36),
(440, '2014-01-31', 86, '2014-02-01', 62, 358, 0, 0, 1, 0, 0, 0, 0, 36),
(441, '2014-02-01', 62, '2014-02-01', 3, 696, 0, 0, 0, 0, 0, 0, 0, 36),
(442, '2014-02-03', 3, '2014-02-03', 55, 206, 1, 0, 0, 0, 0, 0, 0, 36),
(443, '2014-02-03', 55, '2014-02-03', 3, 200, 0, 0, 0, 0, 0, 0, 0, 36),
(444, '2014-02-05', 3, '2014-02-05', 56, 235, 0, 0, 0, 0, 0, 0, 0, 36),
(445, '2014-02-05', 56, '2014-02-08', 18, 1299, 1, 1, 1, 0, 0, 0, 0, 36),
(446, '2014-02-08', 18, '2014-02-08', 21, 361, 0, 1, 0, 0, 0, 0, 0, 36),
(447, '2014-02-10', 21, '2014-02-10', 62, 85, 0, 0, 1, 0, 0, 0, 0, 36),
(448, '2014-02-10', 62, '2014-02-11', 80, 912, 1, 0, 0, 0, 0, 0, 0, 36),
(449, '2014-02-11', 80, '2014-02-11', 3, 210, 0, 0, 0, 0, 0, 0, 0, 36),
(450, '2014-02-26', 3, '2014-02-27', 5, 377, 0, 1, 1, 0, 0, 0, 0, 37),
(451, '2014-02-28', 5, '2014-02-28', 4, 337, 0, 1, 0, 0, 0, 0, 0, 37),
(452, '2014-03-05', 4, '2014-03-06', 67, 275, 0, 1, 1, 0, 0, 0, 0, 37),
(453, '2014-03-07', 67, '2014-03-07', 47, 81, 1, 0, 0, 0, 0, 0, 0, 37),
(454, '2014-03-07', 47, '2014-03-07', 39, 75, 0, 0, 0, 0, 0, 0, 0, 37),
(455, '2014-03-11', 39, '2014-03-12', 4, 190, 0, 0, 1, 0, 0, 0, 0, 37),
(456, '2014-03-13', 4, '2014-03-14', 95, 373, 1, 0, 0, 0, 0, 0, 0, 37),
(457, '2014-03-14', 95, '2014-03-14', 3, 289, 0, 0, 1, 0, 0, 0, 0, 37),
(458, '2014-03-17', 3, '2014-03-17', 47, 213, 0, 1, 0, 0, 0, 0, 0, 37),
(459, '2014-03-18', 47, '2014-03-18', 67, 84, 0, 0, 0, 0, 0, 0, 0, 37),
(460, '2014-03-18', 67, '2014-03-19', 4, 284, 0, 0, 1, 0, 0, 0, 0, 37),
(461, '2014-03-20', 4, '2014-03-21', 5, 328, 1, 0, 0, 0, 0, 0, 0, 37),
(462, '2014-03-26', 5, '2014-03-26', 3, 431, 0, 3, 1, 0, 0, 0, 0, 37),
(463, '2014-03-27', 3, '2014-03-28', 36, 700, 1, 0, 0, 0, 0, 0, 0, 38),
(464, '2014-03-28', 36, '2014-03-29', 40, 371, 0, 1, 0, 0, 0, 0, 0, 38),
(465, '2014-03-31', 40, '2014-03-31', 63, 286, 0, 0, 0, 0, 0, 0, 0, 38),
(466, '2014-04-01', 63, '2014-04-02', 4, 222, 0, 0, 1, 0, 0, 0, 0, 38),
(467, '2014-04-02', 4, '2014-04-02', 119, 352, 1, 0, 0, 0, 0, 0, 0, 38),
(468, '2014-04-03', 119, '2014-04-03', 3, 402, 0, 0, 1, 0, 0, 0, 0, 38),
(469, '2014-04-07', 3, '2014-04-07', 63, 153, 0, 1, 0, 0, 0, 0, 0, 38),
(470, '2014-04-14', 63, '2014-04-14', 56, 240, 1, 1, 0, 0, 0, 0, 0, 38),
(471, '2014-04-14', 56, '2014-04-14', 63, 77, 0, 0, 0, 0, 0, 0, 0, 38),
(472, '2014-04-15', 63, '2014-04-15', 4, 213, 0, 0, 1, 0, 0, 0, 0, 38),
(473, '2014-04-16', 4, '2014-04-16', 73, 239, 1, 1, 0, 0, 0, 0, 0, 38),
(474, '2014-04-17', 73, '2014-04-17', 3, 106, 0, 0, 1, 0, 0, 0, 0, 38),
(475, '2014-04-23', 3, '2014-04-23', 39, 156, 0, 0, 0, 0, 0, 0, 0, 38),
(476, '2014-04-23', 39, '2014-04-24', 4, 222, 0, 0, 1, 0, 0, 0, 0, 38),
(477, '2014-04-24', 4, '2014-04-25', 5, 306, 1, 0, 0, 0, 0, 0, 0, 38),
(478, '2014-04-25', 5, '2014-04-25', 48, 286, 1, 2, 0, 0, 0, 0, 0, 38),
(479, '2014-04-28', 48, '2014-04-29', 3, 155, 0, 0, 1, 0, 0, 0, 0, 38),
(480, '2014-05-10', 179, '2014-05-10', 194, 357, 1, 1, 1, 0, 0, 0, 0, 39),
(481, '2014-05-10', 194, '2014-05-10', 39, 94, 0, 1, 0, 0, 0, 0, 0, 39),
(482, '2014-05-11', 39, '2014-05-11', 49, 300, 0, 0, 0, 0, 0, 0, 0, 39),
(483, '2014-05-11', 49, '2014-05-12', 31, 300, 0, 1, 0, 0, 0, 0, 0, 39),
(484, '2014-05-12', 31, '2014-05-14', 4, 755, 0, 0, 1, 0, 0, 0, 0, 39),
(485, '2014-05-15', 4, '2014-05-15', 97, 209, 1, 0, 0, 0, 0, 0, 0, 39),
(486, '2014-05-16', 97, '2014-05-16', 3, 243, 0, 0, 1, 0, 0, 0, 0, 39),
(487, '2014-06-08', 4, '2014-06-08', 3, 46, 0, 0, 1, 0, 0, 0, 0, 40),
(488, '2014-06-09', 3, '2014-06-09', 7, 250, 0, 0, 0, 0, 0, 0, 0, 40),
(489, '2014-06-09', 7, '2014-06-10', 105, 636, 1, 0, 0, 0, 0, 0, 0, 40),
(490, '2014-06-10', 105, '2014-06-11', 31, 832, 0, 2, 0, 0, 0, 0, 0, 40),
(491, '2014-06-13', 31, '2014-06-14', 3, 680, 0, 0, 0, 0, 0, 0, 0, 40),
(492, '2014-06-16', 3, '2014-06-16', 4, 45, 0, 0, 1, 0, 0, 0, 0, 40),
(493, '2014-06-16', 4, '2014-06-16', 97, 216, 1, 0, 0, 0, 0, 0, 0, 40),
(494, '2014-06-17', 97, '2014-06-17', 5, 189, 0, 1, 0, 0, 0, 0, 0, 40),
(495, '2014-06-18', 5, '2014-06-18', 4, 328, 1, 0, 0, 0, 0, 0, 0, 40),
(496, '2014-06-19', 4, '2014-06-19', 3, 38, 0, 1, 1, 0, 0, 0, 0, 40),
(497, '2014-06-23', 3, '2014-06-23', 7, 259, 0, 1, 0, 0, 0, 0, 0, 40),
(498, '2014-06-24', 7, '2014-06-24', 67, 15, 0, 1, 0, 0, 0, 0, 0, 40),
(499, '2014-06-24', 67, '2014-06-24', 7, 15, 1, 0, 0, 0, 0, 0, 0, 40),
(500, '2014-06-26', 7, '2014-06-26', 120, 219, 0, 0, 0, 0, 0, 0, 0, 40),
(501, '2014-06-26', 120, '2014-06-26', 3, 291, 0, 0, 0, 0, 0, 0, 0, 40),
(502, '2014-06-30', 3, '2014-07-01', 5, 371, 1, 0, 1, 0, 0, 0, 0, 41),
(503, '2014-07-01', 5, '2014-07-01', 48, 313, 0, 1, 0, 0, 0, 0, 0, 41),
(504, '2014-07-03', 48, '2014-07-03', 4, 135, 0, 1, 0, 0, 0, 0, 0, 41),
(505, '2014-07-10', 4, '2014-07-10', 3, 40, 1, 0, 1, 0, 0, 0, 0, 41),
(506, '2014-08-07', 3, '2014-08-07', 16, 155, 0, 0, 0, 0, 0, 0, 0, 42),
(507, '2014-08-07', 16, '2014-08-07', 4, 180, 0, 1, 1, 0, 0, 0, 0, 42),
(508, '2014-08-08', 4, '2014-08-08', 98, 188, 1, 0, 0, 0, 0, 0, 0, 42),
(509, '2014-08-09', 98, '2014-08-09', 3, 243, 0, 1, 1, 0, 0, 0, 0, 42),
(510, '2014-08-11', 3, '2014-08-11', 16, 150, 0, 0, 0, 0, 0, 0, 0, 42),
(511, '2014-08-11', 16, '2014-08-11', 4, 166, 0, 0, 1, 0, 0, 0, 0, 42),
(512, '2014-08-12', 4, '2014-08-12', 98, 197, 1, 0, 0, 0, 0, 0, 0, 42),
(513, '2014-08-13', 98, '2014-08-13', 3, 230, 0, 1, 1, 0, 0, 0, 0, 42),
(514, '2014-08-14', 3, '2014-08-15', 53, 367, 0, 0, 0, 0, 0, 0, 0, 42),
(515, '2014-08-15', 53, '2014-08-16', 4, 410, 0, 0, 0, 0, 0, 0, 0, 42),
(516, '2014-08-18', 4, '2014-08-18', 5, 335, 1, 1, 1, 0, 0, 0, 0, 42),
(517, '2014-08-19', 5, '2014-08-20', 3, 373, 0, 0, 0, 0, 0, 0, 0, 42),
(518, '2014-08-21', 3, '2014-08-21', 20, 371, 0, 0, 1, 0, 0, 0, 0, 42),
(519, '2014-08-21', 20, '2014-08-22', 4, 400, 0, 0, 1, 0, 0, 0, 0, 42),
(520, '2014-08-22', 4, '2014-08-23', 5, 370, 1, 0, 0, 0, 0, 0, 0, 42),
(521, '2014-08-23', 5, '2014-08-23', 3, 404, 0, 0, 1, 0, 0, 0, 0, 42),
(522, '2014-09-01', 3, '2014-09-02', 5, 367, 1, 0, 1, 0, 0, 0, 0, 43),
(523, '2014-09-02', 5, '2014-09-02', 3, 370, 0, 1, 1, 0, 0, 0, 0, 43),
(524, '2014-09-04', 3, '2014-09-04', 9, 302, 0, 0, 0, 0, 0, 0, 0, 43),
(525, '2014-09-04', 9, '2014-09-05', 4, 348, 0, 0, 1, 0, 0, 0, 0, 43),
(526, '2014-09-06', 4, '2014-09-06', 19, 35, 1, 0, 0, 0, 0, 0, 0, 43),
(527, '2014-09-06', 19, '2014-09-06', 3, 75, 0, 1, 1, 0, 0, 0, 0, 43),
(528, '2014-09-08', 3, '2014-09-08', 34, 100, 0, 0, 0, 0, 0, 0, 0, 43),
(529, '2014-09-12', 34, '2014-09-12', 53, 365, 0, 0, 0, 0, 0, 0, 0, 43),
(530, '2014-09-12', 53, '2014-09-12', 3, 365, 0, 0, 0, 0, 0, 0, 0, 43),
(531, '2014-09-15', 3, '2014-09-16', 21, 838, 0, 1, 1, 0, 0, 0, 0, 43),
(532, '2014-09-17', 21, '2014-09-17', 12, 307, 1, 0, 0, 0, 0, 0, 0, 43),
(533, '2014-09-18', 12, '2014-09-18', 21, 298, 0, 0, 0, 0, 0, 0, 0, 43),
(534, '2014-09-22', 21, '2014-09-23', 62, 100, 0, 2, 1, 0, 0, 0, 0, 43),
(535, '2014-09-23', 62, '2014-09-24', 109, 996, 1, 0, 0, 0, 0, 0, 0, 43),
(536, '2014-09-24', 109, '2014-09-24', 67, 224, 0, 0, 0, 0, 0, 0, 0, 43),
(537, '2014-09-25', 67, '2014-09-25', 3, 265, 0, 0, 0, 0, 0, 0, 0, 43),
(538, '2014-09-26', 3, '2014-09-26', 4, 50, 0, 2, 1, 0, 0, 0, 0, 44),
(539, '2014-09-29', 4, '2014-09-29', 5, 351, 1, 2, 0, 0, 0, 0, 0, 44),
(540, '2014-10-01', 5, '2014-10-02', 3, 381, 0, 0, 1, 0, 0, 0, 0, 44),
(541, '2014-10-03', 3, '2014-10-03', 7, 255, 1, 0, 0, 0, 0, 0, 0, 44),
(542, '2014-10-03', 7, '2014-10-03', 3, 255, 0, 0, 0, 0, 0, 0, 0, 44),
(543, '2014-10-04', 3, '2014-10-04', 27, 53, 0, 0, 0, 0, 0, 0, 0, 44),
(544, '2014-10-04', 27, '2014-10-04', 3, 54, 0, 0, 0, 0, 0, 0, 0, 44),
(545, '2014-10-06', 3, '2014-10-06', 4, 40, 0, 1, 1, 0, 0, 0, 0, 44),
(546, '2014-10-07', 4, '2014-10-07', 98, 180, 1, 0, 0, 0, 0, 0, 0, 44),
(547, '2014-10-08', 98, '2014-10-08', 214, 139, 0, 2, 0, 0, 0, 0, 0, 44),
(548, '2014-10-10', 214, '2014-10-11', 3, 265, 0, 0, 1, 0, 0, 0, 0, 44),
(549, '2014-10-13', 3, '2014-10-13', 7, 221, 0, 1, 0, 0, 0, 0, 0, 44),
(550, '2014-10-15', 7, '2014-10-15', 35, 49, 1, 0, 0, 0, 0, 0, 0, 44),
(551, '2014-10-16', 35, '2014-10-16', 139, 241, 0, 1, 0, 0, 0, 0, 0, 44),
(552, '2014-10-17', 139, '2014-10-17', 3, 340, 0, 0, 0, 0, 0, 0, 0, 44),
(553, '2014-10-20', 3, '2014-10-20', 4, 31, 0, 1, 1, 0, 0, 0, 0, 44),
(554, '2014-10-21', 4, '2014-10-22', 5, 361, 1, 0, 0, 0, 0, 0, 0, 44),
(555, '2014-10-22', 5, '2014-10-22', 214, 270, 0, 1, 0, 0, 0, 0, 0, 44),
(556, '2014-10-23', 214, '2014-10-23', 4, 182, 0, 0, 0, 0, 0, 0, 0, 44),
(557, '2014-10-24', 4, '2014-10-24', 3, 40, 0, 0, 1, 0, 0, 0, 0, 44),
(558, '2014-11-01', 3, '2014-11-01', 4, 37, 0, 1, 1, 0, 0, 0, 0, 45),
(559, '2014-11-03', 4, '2014-11-04', 5, 343, 1, 0, 0, 0, 0, 0, 0, 45),
(560, '2014-11-04', 5, '2014-11-05', 3, 378, 0, 0, 1, 0, 0, 0, 0, 45),
(561, '2014-11-06', 3, '2014-11-06', 67, 263, 0, 0, 0, 0, 0, 0, 0, 45),
(562, '2014-11-06', 67, '2014-11-06', 47, 88, 1, 1, 0, 0, 0, 0, 0, 45),
(563, '2014-11-07', 47, '2014-11-07', 63, 72, 0, 1, 0, 0, 0, 0, 0, 45),
(564, '2014-11-10', 63, '2014-11-10', 20, 167, 0, 0, 0, 0, 0, 0, 0, 45),
(565, '2014-11-10', 20, '2014-11-11', 4, 361, 0, 0, 1, 0, 0, 0, 0, 45),
(566, '2014-11-11', 4, '2014-11-12', 5, 323, 1, 0, 0, 0, 0, 0, 0, 45),
(567, '2014-11-12', 5, '2014-11-13', 3, 360, 0, 0, 1, 0, 0, 0, 0, 45),
(568, '2014-11-27', 3, '2014-11-28', 1, 466, 0, 0, 0, 0, 0, 0, 0, 46),
(569, '2014-11-28', 1, '2014-11-29', 3, 469, 0, 1, 0, 0, 0, 0, 0, 46),
(570, '2014-11-30', 3, '2014-11-30', 215, 560, 0, 0, 0, 0, 0, 0, 0, 46),
(571, '2014-12-01', 215, '2014-12-01', 21, 247, 0, 2, 1, 0, 0, 0, 0, 46),
(572, '2014-12-03', 21, '2014-12-03', 12, 281, 1, 0, 0, 0, 0, 0, 0, 46),
(573, '2014-12-04', 12, '2014-12-04', 114, 329, 0, 1, 1, 0, 0, 0, 0, 46),
(574, '2014-12-05', 114, '2014-12-05', 3, 750, 0, 0, 0, 0, 0, 0, 0, 46),
(575, '2014-12-09', 3, '2014-12-09', 55, 223, 1, 0, 0, 0, 0, 0, 0, 46),
(576, '2014-12-09', 55, '2014-12-09', 75, 35, 0, 1, 0, 0, 0, 0, 0, 46),
(577, '2014-12-10', 75, '2014-12-10', 63, 35, 0, 0, 0, 0, 0, 0, 0, 46),
(578, '2014-12-11', 63, '2014-12-12', 1, 312, 0, 0, 0, 0, 0, 0, 0, 46),
(579, '2014-12-12', 1, '2014-12-12', 3, 466, 0, 0, 0, 0, 0, 0, 0, 46),
(580, '2014-12-14', 3, '2014-12-14', 216, 550, 0, 0, 0, 0, 0, 0, 0, 46),
(581, '2014-12-15', 216, '2014-12-15', 21, 249, 0, 1, 1, 0, 0, 0, 0, 46),
(582, '2014-12-16', 21, '2014-12-17', 12, 281, 1, 0, 0, 0, 0, 0, 0, 46),
(583, '2014-12-17', 12, '2014-12-17', 21, 277, 0, 0, 0, 0, 0, 0, 0, 46),
(584, '2014-12-18', 21, '2014-12-18', 174, 160, 0, 1, 1, 0, 0, 0, 0, 46),
(585, '2014-12-19', 174, '2014-12-20', 3, 640, 0, 1, 0, 0, 0, 0, 0, 46),
(586, '2014-12-22', 3, '2014-12-22', 32, 220, 1, 0, 0, 0, 0, 0, 0, 46),
(587, '2014-12-22', 32, '2014-12-22', 3, 217, 0, 0, 0, 0, 0, 0, 0, 46),
(588, '2014-01-02', 3, '2014-01-02', 47, 216, 0, 0, 0, 0, 0, 0, 0, 47),
(589, '2014-01-03', 47, '2014-01-03', 67, 86, 0, 0, 0, 0, 0, 0, 0, 47),
(590, '2014-01-03', 67, '2014-01-03', 3, 261, 0, 0, 0, 0, 0, 0, 0, 47),
(591, '2014-01-06', 3, '2014-01-06', 4, 39, 0, 0, 1, 0, 0, 0, 0, 47),
(592, '2014-01-07', 4, '2014-01-07', 4, 0, 0, 1, 0, 0, 0, 0, 0, 47),
(593, '2014-01-08', 4, '2014-01-08', 5, 344, 0, 0, 0, 0, 0, 0, 0, 47),
(594, '2014-01-09', 5, '2014-01-09', 47, 625, 1, 0, 1, 0, 0, 0, 0, 47),
(595, '2014-01-10', 47, '2014-01-10', 67, 86, 0, 0, 0, 0, 0, 0, 0, 47),
(596, '2014-01-10', 67, '2014-01-10', 3, 347, 0, 0, 0, 0, 0, 0, 0, 47),
(597, '2014-01-11', 3, '2014-01-11', 4, 38, 0, 0, 1, 0, 0, 0, 0, 47),
(598, '2014-01-13', 4, '2014-01-14', 5, 347, 1, 0, 0, 0, 0, 0, 0, 47),
(599, '2014-01-14', 5, '2014-01-15', 5, 0, 0, 1, 0, 0, 0, 0, 0, 47),
(600, '2014-01-15', 5, '2014-01-15', 5, 0, 0, 1, 0, 0, 0, 0, 0, 47),
(601, '2014-01-16', 5, '2014-01-16', 5, 0, 0, 1, 0, 0, 0, 0, 0, 47),
(602, '2014-01-17', 5, '2014-01-17', 4, 344, 1, 0, 0, 0, 0, 0, 0, 47),
(603, '2014-01-18', 4, '2014-01-18', 3, 39, 0, 0, 1, 0, 0, 0, 0, 47),
(604, '2014-01-19', 3, '2014-01-20', 67, 264, 0, 0, 0, 0, 0, 0, 0, 47),
(605, '2014-01-20', 67, '2014-01-21', 47, 86, 0, 1, 0, 0, 0, 0, 0, 47),
(606, '2014-01-22', 47, '2014-01-22', 63, 74, 1, 0, 0, 0, 0, 0, 0, 47),
(607, '2014-01-23', 63, '2014-01-23', 3, 256, 0, 0, 0, 0, 0, 0, 0, 47),
(608, '2014-01-24', 3, '2014-01-24', 87, 241, 0, 0, 1, 0, 0, 0, 0, 47),
(609, '2014-01-25', 87, '2014-01-25', 3, 251, 1, 0, 1, 0, 0, 0, 0, 47),
(610, '2014-01-27', 3, '2014-01-28', 53, 373, 0, 0, 0, 0, 0, 0, 0, 48),
(611, '2014-01-28', 53, '2014-01-29', 3, 362, 0, 0, 0, 0, 0, 0, 0, 48),
(612, '2014-01-29', 3, '2014-01-30', 21, 807, 0, 0, 1, 0, 0, 0, 0, 48),
(613, '2014-01-30', 21, '2014-01-31', 86, 283, 1, 0, 0, 0, 0, 0, 0, 48),
(614, '2014-01-31', 86, '2014-01-31', 21, 281, 0, 1, 1, 0, 0, 0, 0, 48),
(615, '2014-01-31', 21, '2014-02-01', 45, 150, 0, 0, 0, 0, 0, 0, 0, 48),
(616, '2014-02-01', 45, '2014-02-02', 34, 673, 0, 0, 0, 0, 0, 0, 0, 48),
(617, '2014-02-03', 34, '2014-02-03', 76, 393, 1, 1, 0, 0, 0, 0, 0, 48),
(618, '2014-02-04', 76, '2014-02-04', 3, 306, 0, 0, 0, 0, 0, 0, 0, 48),
(619, '2014-02-10', 3, '2014-02-11', 5, 383, 0, 0, 1, 0, 0, 0, 0, 48),
(620, '2014-02-11', 5, '2014-02-12', 3, 388, 1, 1, 1, 0, 0, 0, 0, 48),
(621, '2014-02-12', 3, '2014-02-13', 67, 257, 0, 0, 0, 0, 0, 0, 0, 48),
(622, '2014-02-13', 67, '2014-02-13', 47, 86, 0, 0, 0, 0, 0, 0, 0, 48),
(623, '2014-02-14', 47, '2014-02-14', 47, 0, 1, 0, 0, 0, 0, 0, 0, 48),
(624, '2014-02-15', 47, '2014-02-15', 47, 0, 0, 0, 0, 0, 0, 0, 0, 48),
(625, '2014-02-16', 47, '2014-02-16', 47, 0, 0, 0, 0, 0, 0, 0, 0, 48),
(626, '2014-02-17', 47, '2014-02-17', 47, 0, 0, 0, 0, 0, 0, 0, 0, 48),
(627, '2014-02-18', 47, '2014-02-18', 47, 0, 0, 0, 0, 0, 0, 0, 0, 48),
(628, '2014-02-19', 47, '2014-02-19', 47, 0, 0, 1, 0, 0, 0, 0, 0, 48),
(629, '2014-02-20', 47, '2014-02-20', 50, 306, 0, 0, 0, 0, 0, 0, 0, 48),
(630, '2014-02-21', 50, '2014-02-22', 3, 536, 0, 0, 0, 0, 0, 0, 0, 48),
(631, '2014-02-24', 3, '2014-02-24', 4, 37, 0, 0, 1, 0, 0, 0, 0, 48),
(632, '2014-02-25', 4, '2014-02-26', 5, 355, 1, 0, 0, 0, 0, 0, 0, 48),
(633, '2014-02-27', 5, '2014-03-05', 3, 380, 0, 1, 1, 0, 0, 0, 0, 48),
(634, '2014-03-05', 3, '2014-03-06', 67, 265, 0, 0, 0, 0, 0, 0, 0, 49),
(635, '2014-03-07', 67, '2014-03-07', 47, 85, 1, 1, 0, 0, 0, 0, 0, 49),
(636, '2014-03-07', 47, '2014-03-07', 63, 79, 0, 0, 0, 0, 0, 0, 0, 49),
(637, '2014-03-11', 63, '2014-03-11', 3, 181, 0, 0, 0, 0, 0, 0, 0, 49),
(638, '2014-03-12', 3, '2014-03-12', 4, 37, 0, 0, 1, 0, 0, 0, 0, 49),
(639, '2014-03-13', 4, '2014-03-13', 5, 398, 0, 1, 0, 0, 0, 0, 0, 49),
(640, '2014-03-14', 5, '2014-03-14', 3, 304, 1, 0, 1, 0, 0, 0, 0, 49),
(641, '2014-03-16', 3, '2014-03-17', 47, 224, 0, 0, 0, 0, 0, 0, 0, 49),
(642, '2014-03-17', 47, '2014-03-17', 67, 89, 0, 0, 0, 0, 0, 0, 0, 49),
(643, '2014-03-18', 67, '2014-03-18', 3, 0, 0, 0, 0, 0, 0, 0, 0, 49),
(644, '2014-03-19', 3, '2014-03-20', 5, 384, 1, 0, 1, 0, 0, 0, 0, 49),
(645, '2014-03-21', 5, '2014-03-22', 3, 385, 0, 1, 1, 0, 0, 0, 0, 49),
(646, '2014-03-25', 3, '2014-03-25', 7, 246, 1, 0, 0, 0, 0, 0, 0, 49),
(647, '2014-03-25', 7, '2014-03-26', 55, 151, 0, 1, 0, 0, 0, 0, 0, 49),
(648, '2014-03-28', 55, '2014-03-28', 3, 285, 0, 1, 0, 0, 0, 0, 0, 49),
(649, '2014-03-29', 3, '2014-03-29', 4, 37, 0, 0, 1, 0, 0, 0, 0, 49),
(650, '2014-03-31', 4, '2014-04-01', 89, 472, 1, 0, 0, 0, 0, 0, 0, 50),
(651, '2014-04-01', 89, '2014-04-01', 48, 446, 0, 0, 0, 0, 0, 0, 0, 50),
(652, '2014-04-02', 48, '2014-04-02', 4, 123, 0, 0, 0, 0, 0, 0, 0, 50),
(653, '2014-04-03', 4, '2014-04-03', 67, 395, 0, 1, 1, 0, 0, 0, 0, 50),
(654, '2014-04-04', 67, '2014-04-04', 35, 47, 0, 0, 0, 0, 0, 0, 0, 50),
(655, '2014-04-05', 35, '2014-04-08', 2, 251, 1, 0, 0, 0, 0, 0, 0, 50),
(656, '2014-04-08', 2, '2014-04-09', 4, 371, 0, 0, 1, 0, 0, 0, 0, 50),
(657, '2014-04-09', 4, '2014-04-09', 6, 104, 1, 1, 0, 0, 0, 0, 0, 50),
(658, '2014-04-10', 6, '2014-04-10', 48, 189, 0, 0, 0, 0, 0, 0, 0, 50),
(659, '2014-04-11', 48, '2014-04-11', 48, 0, 0, 1, 0, 0, 0, 0, 0, 50),
(660, '2014-04-14', 48, '2014-04-15', 4, 124, 0, 1, 0, 0, 0, 0, 0, 50),
(661, '2014-04-15', 4, '2014-04-15', 3, 37, 0, 0, 1, 0, 0, 0, 0, 50),
(662, '2014-04-16', 3, '2014-04-16', 39, 174, 1, 0, 0, 0, 0, 0, 0, 50),
(663, '2014-04-23', 63, '2014-04-24', 3, 204, 0, 1, 0, 0, 0, 0, 0, 50),
(664, '2014-04-25', 3, '2014-04-28', 18, 1051, 0, 0, 1, 0, 0, 0, 0, 50),
(665, '2014-04-28', 18, '2014-04-29', 18, 0, 0, 0, 0, 0, 0, 0, 0, 51),
(666, '2014-04-30', 18, '2014-05-01', 21, 434, 1, 1, 0, 0, 0, 0, 0, 51),
(667, '2014-05-01', 21, '2014-05-02', 34, 755, 0, 0, 1, 0, 0, 0, 0, 51),
(668, '2014-05-05', 34, '2014-05-05', 34, 0, 0, 0, 0, 0, 0, 0, 0, 51),
(669, '2014-05-05', 34, '2014-05-05', 77, 425, 1, 0, 0, 0, 0, 0, 0, 51),
(670, '2014-05-05', 77, '2014-05-06', 190, 441, 0, 0, 0, 0, 0, 0, 0, 51),
(671, '2014-05-06', 190, '2014-05-06', 3, 480, 0, 0, 0, 0, 0, 0, 0, 51),
(672, '2014-05-07', 3, '2014-05-07', 5, 353, 1, 1, 1, 0, 0, 0, 0, 51),
(673, '2014-05-08', 5, '2014-05-09', 190, 839, 0, 0, 1, 0, 0, 0, 0, 51),
(674, '2014-05-09', 190, '2014-05-09', 3, 482, 0, 0, 0, 0, 0, 0, 0, 51),
(675, '2014-05-12', 3, '2014-05-13', 5, 350, 1, 1, 1, 0, 0, 0, 0, 51),
(676, '2014-05-13', 5, '2014-05-13', 3, 348, 0, 0, 1, 0, 0, 0, 0, 51),
(677, '2014-05-15', 3, '2014-05-15', 63, 334, 0, 0, 0, 0, 0, 0, 0, 51),
(678, '2014-05-15', 63, '2014-05-15', 3, 0, 0, 0, 0, 0, 0, 0, 0, 51),
(679, '2014-05-16', 4, '2014-05-17', 5, 352, 1, 0, 1, 0, 0, 0, 0, 51),
(680, '2014-05-17', 5, '2014-05-17', 3, 354, 0, 0, 1, 0, 0, 0, 0, 51),
(681, '2014-05-21', 3, '2014-05-21', 217, 374, 0, 1, 0, 0, 0, 0, 0, 51),
(682, '2014-05-22', 217, '2014-05-22', 91, 193, 0, 0, 0, 0, 0, 0, 0, 51),
(683, '2014-05-22', 91, '2014-05-23', 218, 186, 0, 0, 0, 0, 0, 0, 0, 51),
(684, '2014-05-24', 218, '2014-05-24', 219, 502, 0, 0, 0, 0, 0, 0, 0, 51),
(685, '2014-05-25', 219, '2014-05-25', 22, 352, 0, 0, 0, 0, 0, 0, 0, 51),
(686, '2014-05-26', 22, '2014-05-26', 21, 18, 0, 0, 1, 0, 0, 0, 0, 51),
(687, '2014-05-27', 21, '2014-05-27', 96, 229, 1, 0, 0, 0, 0, 0, 0, 51),
(688, '2014-05-27', 96, '2014-05-27', 21, 226, 0, 1, 1, 0, 0, 0, 0, 51),
(689, '2014-05-28', 21, '2014-05-30', 67, 1097, 1, 0, 0, 0, 0, 0, 0, 52),
(690, '2014-05-30', 67, '2014-06-02', 40, 0, 0, 0, 0, 0, 0, 0, 0, 52),
(691, '2014-06-03', 40, '2014-06-03', 3, 710, 0, 0, 0, 0, 0, 0, 0, 52),
(692, '2014-06-04', 3, '2014-06-05', 135, 257, 1, 0, 1, 0, 0, 0, 0, 52),
(693, '2014-06-05', 135, '2014-06-05', 48, 0, 0, 1, 0, 0, 0, 0, 0, 52),
(694, '2014-06-06', 48, '2014-06-06', 4, 234, 0, 1, 0, 0, 0, 0, 0, 52),
(695, '2014-06-07', 4, '2014-06-07', 3, 37, 0, 0, 1, 0, 0, 0, 0, 52),
(696, '2014-06-09', 3, '2014-06-09', 105, 885, 1, 0, 0, 0, 0, 0, 0, 52),
(697, '2014-06-10', 105, '2014-06-11', 31, 829, 0, 0, 0, 0, 0, 0, 0, 52),
(698, '2014-06-12', 31, '2014-06-12', 31, 0, 0, 1, 0, 0, 0, 0, 0, 52),
(699, '2014-06-13', 31, '2014-06-14', 3, 698, 0, 1, 0, 0, 0, 0, 0, 52),
(700, '2014-06-16', 3, '2014-06-16', 97, 251, 0, 0, 1, 0, 0, 0, 0, 52),
(701, '2014-06-17', 97, '2014-06-17', 48, 98, 1, 0, 0, 0, 0, 0, 0, 52),
(702, '2014-06-18', 48, '2014-06-18', 3, 0, 0, 0, 1, 0, 0, 0, 0, 52),
(703, '2014-06-18', 3, '2014-06-18', 220, 416, 0, 0, 0, 0, 0, 0, 0, 52),
(704, '2014-06-19', 220, '2014-06-20', 105, 642, 1, 0, 0, 0, 0, 0, 0, 52),
(705, '2014-06-20', 105, '2014-06-20', 63, 670, 0, 0, 0, 0, 0, 0, 0, 52),
(706, '2014-06-24', 63, '2014-06-24', 67, 115, 0, 1, 0, 0, 0, 0, 0, 52),
(707, '2014-06-24', 67, '2014-06-25', 111, 0, 0, 0, 0, 0, 0, 0, 0, 52),
(708, '2014-06-26', 111, '2014-06-26', 3, 292, 0, 0, 0, 0, 0, 0, 0, 52),
(709, '2014-06-27', 3, '2014-06-27', 119, 405, 1, 0, 1, 0, 0, 0, 0, 53),
(710, '2014-06-28', 119, '2014-06-28', 48, 344, 0, 0, 0, 0, 0, 0, 0, 53),
(711, '2014-06-29', 48, '2014-06-29', 48, 0, 0, 1, 0, 0, 0, 0, 0, 53),
(712, '2014-06-30', 48, '2014-06-30', 4, 140, 0, 0, 0, 0, 0, 0, 0, 53),
(713, '2014-07-01', 4, '2014-07-01', 3, 37, 0, 1, 1, 0, 0, 0, 0, 53),
(714, '2014-07-02', 3, '2014-07-02', 220, 282, 0, 0, 0, 0, 0, 0, 0, 53),
(715, '2014-07-03', 220, '2014-07-04', 105, 641, 1, 0, 0, 0, 0, 0, 0, 53),
(716, '2014-07-04', 105, '2014-07-05', 63, 680, 0, 0, 0, 0, 0, 0, 0, 53),
(717, '2014-07-08', 63, '2014-07-08', 3, 0, 0, 0, 0, 0, 0, 0, 0, 53),
(718, '2014-07-09', 3, '2014-07-09', 5, 586, 1, 0, 1, 0, 0, 0, 0, 53),
(719, '2014-07-10', 5, '2014-07-10', 5, 0, 0, 0, 0, 0, 0, 0, 0, 53),
(720, '2014-07-11', 5, '2014-07-11', 5, 0, 0, 1, 0, 0, 0, 0, 0, 53),
(721, '2014-07-14', 5, '2014-07-14', 4, 0, 0, 0, 0, 0, 0, 0, 0, 53),
(722, '2014-07-15', 4, '2014-07-16', 36, 1131, 1, 0, 1, 0, 0, 0, 0, 53),
(723, '2014-07-16', 36, '2014-07-16', 31, 135, 0, 1, 0, 0, 0, 0, 0, 53),
(724, '2014-07-17', 31, '2014-07-17', 3, 688, 0, 0, 0, 0, 0, 0, 0, 53),
(725, '2014-07-21', 3, '2014-07-21', 97, 251, 1, 0, 1, 0, 0, 0, 0, 53),
(726, '2014-07-22', 97, '2014-07-22', 3, 256, 0, 0, 1, 0, 0, 0, 0, 53),
(727, '2014-07-23', 3, '2014-07-23', 20, 345, 0, 0, 0, 0, 0, 0, 0, 53),
(728, '2014-07-23', 20, '2014-07-23', 3, 347, 0, 0, 0, 0, 0, 0, 0, 53),
(729, '2014-07-24', 4, '2014-07-25', 5, 344, 1, 1, 1, 0, 0, 0, 0, 53),
(730, '2014-07-25', 5, '2014-07-25', 221, 338, 0, 0, 0, 0, 0, 0, 0, 53),
(731, '2014-07-26', 221, '2014-07-26', 4, 604, 0, 0, 0, 0, 0, 0, 0, 53),
(732, '2014-07-28', 4, '2014-07-28', 3, 37, 0, 0, 1, 0, 0, 0, 0, 53),
(733, '2014-07-29', 3, '2014-07-29', 35, 226, 0, 0, 0, 0, 0, 0, 0, 54),
(734, '2014-07-30', 35, '2014-07-30', 222, 18, 1, 0, 0, 0, 0, 0, 0, 54),
(735, '2014-07-30', 222, '2014-07-31', 67, 68, 0, 1, 0, 0, 0, 0, 0, 54),
(736, '2014-08-04', 67, '2014-08-04', 3, 271, 0, 0, 0, 0, 0, 0, 0, 54),
(737, '2014-08-05', 3, '2014-08-06', 5, 372, 1, 0, 1, 0, 0, 0, 0, 54),
(738, '2014-08-06', 5, '2014-08-06', 3, 369, 0, 0, 1, 0, 0, 0, 0, 54),
(739, '2014-08-26', 3, '2014-08-26', 47, 260, 0, 0, 0, 0, 0, 0, 0, 54),
(740, '2014-08-26', 47, '2014-08-26', 67, 93, 0, 0, 0, 0, 0, 0, 0, 54),
(741, '2014-08-26', 67, '2014-08-26', 3, 273, 0, 0, 0, 0, 0, 0, 0, 54),
(742, '2014-08-27', 4, '2014-08-28', 5, 361, 1, 0, 1, 0, 0, 0, 0, 54),
(743, '2014-08-28', 5, '2014-08-28', 3, 390, 0, 1, 1, 0, 0, 0, 0, 54),
(744, '2014-08-30', 3, '2014-08-30', 4, 37, 0, 0, 1, 0, 0, 0, 0, 55),
(745, '2014-09-01', 4, '2014-09-02', 5, 357, 1, 0, 0, 0, 0, 0, 0, 55),
(746, '2014-09-02', 5, '2014-09-02', 3, 376, 0, 0, 1, 0, 0, 0, 0, 55),
(747, '2014-09-04', 3, '2014-09-04', 9, 312, 0, 0, 0, 0, 0, 0, 0, 55),
(748, '2014-09-04', 9, '2014-09-04', 3, 324, 0, 0, 0, 0, 0, 0, 0, 55),
(749, '2014-09-05', 3, '2014-09-06', 19, 74, 1, 1, 1, 0, 0, 0, 0, 55),
(750, '2014-09-06', 19, '2014-09-06', 3, 75, 0, 0, 1, 0, 0, 0, 0, 55),
(751, '2014-09-07', 3, '2014-09-08', 53, 385, 0, 0, 0, 0, 0, 0, 0, 55),
(752, '2014-09-08', 53, '2014-09-09', 3, 381, 0, 0, 0, 0, 0, 0, 0, 55),
(753, '2014-09-09', 3, '2014-09-10', 21, 1120, 0, 0, 1, 0, 0, 0, 0, 55),
(754, '2014-09-10', 21, '2014-09-11', 86, 299, 1, 1, 0, 0, 0, 0, 0, 55),
(755, '2014-09-11', 86, '2014-09-11', 21, 297, 0, 0, 0, 0, 0, 0, 0, 55),
(756, '2014-09-12', 21, '2014-09-12', 62, 130, 0, 0, 1, 0, 0, 0, 0, 55),
(757, '2014-09-13', 62, '2014-09-15', 82, 992, 1, 0, 0, 0, 0, 0, 0, 55),
(758, '2014-09-15', 82, '2014-09-15', 3, 267, 0, 0, 0, 0, 0, 0, 0, 55),
(759, '2014-09-18', 3, '2014-09-18', 9, 205, 0, 0, 0, 0, 0, 0, 0, 55),
(760, '2014-09-19', 9, '2014-09-19', 34, 369, 0, 0, 0, 0, 0, 0, 0, 55),
(761, '2014-09-23', 34, '2014-09-24', 201, 878, 0, 0, 0, 0, 0, 0, 0, 55),
(762, '2014-09-25', 201, '2014-09-25', 17, 106, 0, 1, 0, 0, 0, 0, 0, 55),
(763, '2014-09-25', 18, '2014-09-26', 96, 296, 1, 0, 1, 0, 0, 0, 0, 55),
(764, '2014-09-26', 96, '2014-09-26', 21, 211, 0, 0, 0, 0, 0, 0, 0, 55),
(765, '2014-09-27', 21, '2014-09-27', 62, 130, 0, 1, 1, 0, 0, 0, 0, 55),
(766, '2014-09-28', 62, '2014-09-29', 62, 968, 0, 1, 0, 0, 0, 0, 0, 55),
(767, '2014-09-30', 62, '2014-09-30', 158, 973, 1, 0, 0, 0, 0, 0, 0, 55),
(768, '2014-10-01', 158, '2014-10-01', 3, 286, 0, 0, 0, 0, 0, 0, 0, 55),
(769, '2014-10-02', 3, '2014-10-03', 87, 233, 1, 0, 1, 0, 0, 0, 0, 56),
(770, '2014-10-03', 87, '2014-10-03', 3, 230, 0, 0, 1, 0, 0, 0, 0, 56),
(771, '2014-10-04', 3, '2014-10-04', 27, 56, 0, 0, 0, 0, 0, 0, 0, 56),
(772, '2014-10-04', 27, '2014-10-04', 3, 54, 0, 0, 0, 0, 0, 0, 0, 56),
(773, '2014-10-06', 3, '2014-10-06', 4, 34, 0, 0, 1, 0, 0, 0, 0, 56),
(774, '2014-10-07', 4, '2014-10-07', 98, 185, 0, 1, 0, 0, 0, 0, 0, 56),
(775, '2014-10-08', 98, '2014-10-08', 223, 143, 1, 0, 0, 0, 0, 0, 0, 56),
(776, '2014-10-09', 223, '2014-10-09', 223, 0, 0, 1, 0, 0, 0, 0, 0, 56),
(777, '2014-10-10', 223, '2014-10-10', 4, 198, 0, 0, 0, 0, 0, 0, 0, 56),
(778, '2014-10-11', 4, '2014-10-11', 3, 36, 0, 0, 1, 0, 0, 0, 0, 56),
(779, '2014-10-14', 3, '2014-10-14', 224, 271, 0, 0, 0, 0, 0, 0, 0, 56),
(780, '2014-10-15', 224, '2014-10-15', 224, 0, 0, 1, 0, 0, 0, 0, 0, 56),
(781, '2014-10-15', 224, '2014-10-15', 35, 52, 1, 0, 0, 0, 0, 0, 0, 56),
(782, '2014-10-16', 35, '2014-10-16', 155, 310, 0, 0, 0, 0, 0, 0, 0, 56),
(783, '2014-10-16', 155, '2014-10-17', 3, 391, 0, 0, 0, 0, 0, 0, 0, 56),
(784, '2014-10-19', 3, '2014-10-19', 4, 35, 0, 1, 1, 0, 0, 0, 0, 56),
(785, '2014-10-20', 4, '2014-10-20', 135, 248, 1, 0, 0, 0, 0, 0, 0, 56),
(786, '2014-10-20', 135, '2014-10-20', 223, 121, 0, 0, 0, 0, 0, 0, 0, 56),
(787, '2014-10-21', 223, '2014-10-22', 223, 0, 0, 1, 0, 0, 0, 0, 0, 56),
(788, '2014-10-22', 223, '2014-10-23', 224, 498, 0, 0, 1, 0, 0, 0, 0, 56),
(789, '2014-10-23', 224, '2014-10-24', 35, 119, 1, 0, 0, 0, 0, 0, 0, 56),
(790, '2014-10-28', 63, '2014-10-28', 103, 340, 0, 0, 0, 0, 0, 0, 0, 57),
(791, '2014-10-29', 103, '2014-10-30', 146, 339, 0, 0, 0, 0, 0, 0, 0, 57),
(792, '2014-10-30', 146, '2014-10-31', 4, 706, 0, 0, 1, 0, 0, 0, 0, 57),
(793, '2014-11-02', 4, '2014-11-03', 5, 351, 0, 0, 0, 0, 0, 0, 0, 57),
(794, '2014-11-03', 5, '2014-11-03', 5, 0, 0, 1, 0, 0, 0, 0, 0, 57),
(795, '2014-11-04', 5, '2014-11-04', 5, 0, 1, 0, 0, 0, 0, 0, 0, 57),
(796, '2014-11-05', 5, '2014-11-05', 5, 0, 0, 1, 0, 0, 0, 0, 0, 57),
(797, '2014-11-06', 5, '2014-11-06', 5, 0, 0, 1, 0, 0, 0, 0, 0, 57),
(798, '2014-11-07', 5, '2014-11-07', 4, 398, 0, 0, 0, 0, 0, 0, 0, 57),
(799, '2014-11-07', 4, '2014-11-07', 3, 35, 0, 0, 1, 0, 0, 0, 0, 57),
(800, '2014-11-08', 3, '2014-11-09', 36, 700, 1, 0, 0, 0, 0, 0, 0, 57),
(801, '2014-11-09', 36, '2014-11-09', 63, 678, 0, 0, 0, 0, 0, 0, 0, 57),
(802, '2014-11-11', 63, '2014-11-11', 3, 160, 0, 0, 0, 0, 0, 0, 0, 57),
(803, '2014-11-12', 3, '2014-11-13', 95, 398, 1, 1, 1, 0, 0, 0, 0, 57),
(804, '2014-11-13', 95, '2014-11-14', 3, 313, 0, 0, 1, 0, 0, 0, 0, 57),
(805, '2014-11-27', 3, '2014-11-28', 1, 456, 0, 0, 0, 0, 0, 0, 0, 58),
(806, '2014-11-28', 1, '2014-11-29', 3, 460, 0, 0, 0, 0, 0, 0, 0, 58),
(807, '2014-11-29', 3, '2014-11-29', 34, 70, 0, 0, 0, 0, 0, 0, 0, 58),
(808, '2014-11-30', 34, '2014-11-30', 215, 496, 0, 0, 0, 0, 0, 0, 0, 58),
(809, '2014-12-01', 215, '2014-12-01', 21, 246, 0, 0, 1, 0, 0, 0, 0, 58),
(810, '2014-12-02', 21, '2014-12-02', 21, 0, 0, 1, 0, 0, 0, 0, 0, 58),
(811, '2014-12-03', 21, '2014-12-04', 12, 283, 1, 1, 0, 0, 0, 0, 0, 58),
(812, '2014-12-04', 12, '2014-12-04', 21, 281, 0, 1, 0, 0, 0, 0, 0, 58),
(813, '2014-12-05', 21, '2014-12-05', 62, 95, 0, 0, 1, 0, 0, 0, 0, 58),
(814, '2014-12-06', 62, '2014-12-06', 34, 652, 0, 0, 0, 0, 0, 0, 0, 58),
(815, '2014-12-09', 34, '2014-12-09', 55, 298, 1, 0, 0, 0, 0, 0, 0, 58),
(816, '2014-12-10', 63, '2014-12-10', 3, 201, 0, 0, 0, 0, 0, 0, 0, 58),
(817, '2014-12-11', 3, '2014-12-11', 4, 35, 0, 0, 1, 0, 0, 0, 0, 58),
(818, '2014-12-11', 4, '2014-12-12', 5, 325, 1, 0, 0, 0, 0, 0, 0, 58),
(819, '2014-12-12', 5, '2014-12-13', 3, 378, 0, 0, 1, 0, 0, 0, 0, 58),
(820, '2014-12-14', 3, '2014-12-16', 47, 320, 1, 1, 0, 0, 0, 0, 0, 58),
(821, '2014-12-16', 47, '2014-12-17', 168, 171, 0, 0, 0, 0, 0, 0, 0, 58),
(822, '2014-12-17', 168, '2014-12-17', 53, 0, 0, 0, 0, 0, 0, 0, 0, 58),
(823, '2014-12-17', 53, '2014-12-19', 18, 0, 0, 1, 1, 0, 0, 0, 0, 58),
(824, '2014-12-19', 18, '2014-12-20', 167, 280, 1, 0, 0, 0, 0, 0, 0, 58),
(825, '2014-12-20', 167, '2014-12-21', 21, 555, 0, 1, 1, 0, 0, 0, 0, 58),
(826, '2014-12-22', 21, '2014-12-22', 62, 101, 0, 0, 0, 0, 0, 0, 0, 58),
(827, '2014-12-23', 62, '2014-12-24', 34, 682, 0, 0, 0, 0, 0, 0, 0, 58),
(828, '2014-12-27', 34, '2014-12-27', 3, 61, 0, 0, 0, 0, 0, 0, 0, 58),
(829, '2013-12-28', 3, '2013-12-28', 43, 230, 1, 0, 0, 0, 0, 0, 0, 59),
(830, '2013-12-29', 43, '2013-12-29', 3, 230, 0, 0, 0, 0, 0, 0, 0, 59),
(831, '2014-01-02', 3, '2014-01-03', 17, 972, 0, 0, 0, 0, 0, 0, 0, 59),
(832, '2014-01-04', 17, '2014-01-04', 211, 2, 0, 1, 1, 0, 0, 0, 0, 59),
(833, '2014-01-06', 211, '2014-01-06', 18, 40, 1, 4, 0, 0, 0, 0, 0, 59),
(834, '2014-01-07', 18, '2014-01-07', 21, 360, 0, 0, 0, 0, 0, 0, 0, 59),
(835, '2014-01-08', 21, '2014-01-08', 225, 75, 0, 0, 1, 0, 0, 0, 0, 59),
(836, '2014-01-09', 225, '2014-01-10', 55, 998, 1, 0, 0, 0, 0, 0, 0, 59),
(837, '2014-01-10', 55, '2014-01-10', 3, 330, 0, 0, 0, 0, 0, 0, 0, 59),
(838, '2014-01-13', 3, '2014-01-14', 1, 457, 0, 0, 0, 0, 0, 0, 0, 59),
(839, '2014-01-14', 1, '2014-01-15', 17, 1137, 1, 0, 1, 0, 0, 0, 0, 59),
(840, '2014-01-16', 17, '2014-01-16', 211, 2, 0, 0, 0, 0, 0, 0, 0, 59),
(841, '2014-01-17', 211, '2014-01-18', 96, 369, 0, 1, 0, 0, 0, 0, 0, 59),
(842, '2014-01-18', 96, '2014-01-18', 21, 200, 0, 0, 0, 0, 0, 0, 0, 59),
(843, '2014-01-20', 21, '2014-01-20', 114, 58, 0, 2, 1, 0, 0, 0, 0, 59),
(844, '2014-01-21', 114, '2014-01-21', 62, 35, 0, 0, 0, 0, 0, 0, 0, 59),
(845, '2014-01-22', 62, '2014-01-22', 55, 940, 1, 0, 0, 0, 0, 0, 0, 59),
(846, '2014-01-22', 55, '2014-01-22', 52, 30, 0, 0, 0, 0, 0, 0, 0, 59),
(847, '2014-01-22', 52, '2014-01-22', 3, 240, 1, 0, 0, 0, 0, 0, 0, 59),
(848, '2014-01-23', 3, '2014-01-23', 4, 38, 0, 0, 0, 0, 0, 0, 0, 59),
(849, '2014-01-23', 4, '2014-01-24', 52, 301, 0, 0, 0, 0, 0, 0, 0, 59),
(850, '2014-01-25', 52, '2014-01-25', 63, 100, 0, 0, 0, 0, 0, 0, 0, 59),
(851, '2014-01-25', 63, '2014-01-26', 3, 170, 1, 0, 0, 0, 0, 0, 0, 59),
(852, '2014-01-26', 3, '2014-01-27', 18, 997, 0, 0, 1, 0, 0, 0, 0, 60),
(853, '2014-01-30', 18, '2014-01-30', 21, 390, 0, 3, 0, 0, 0, 0, 0, 60),
(854, '2014-02-01', 21, '2014-02-01', 62, 90, 0, 0, 1, 0, 0, 0, 0, 60),
(855, '2014-02-02', 62, '2014-02-02', 3, 702, 1, 0, 0, 0, 0, 0, 0, 60),
(856, '2014-02-03', 3, '2014-02-03', 78, 210, 0, 0, 0, 0, 0, 0, 0, 60),
(857, '2014-02-03', 78, '2014-02-03', 3, 210, 0, 0, 0, 0, 0, 0, 0, 60),
(858, '2014-02-10', 3, '2014-02-10', 5, 384, 0, 0, 1, 0, 0, 0, 0, 60),
(859, '2014-02-11', 5, '2014-02-13', 47, 719, 1, 1, 1, 0, 0, 0, 0, 60),
(860, '2014-02-13', 47, '2014-02-13', 43, 120, 0, 0, 0, 0, 0, 0, 0, 60),
(861, '2014-02-14', 43, '2014-02-14', 3, 240, 1, 0, 0, 0, 0, 0, 0, 60),
(862, '2014-02-16', 3, '2014-02-16', 18, 1022, 0, 2, 1, 0, 0, 0, 0, 60),
(863, '2014-02-19', 18, '2014-02-19', 21, 370, 0, 0, 0, 0, 0, 0, 0, 60),
(864, '2014-02-20', 21, '2014-02-20', 62, 100, 0, 0, 1, 0, 0, 0, 0, 60),
(865, '2014-02-21', 62, '2014-02-22', 3, 847, 1, 0, 0, 0, 0, 0, 0, 60),
(866, '2014-02-24', 3, '2014-02-24', 226, 180, 0, 0, 0, 0, 0, 0, 0, 60),
(867, '2014-02-25', 226, '2014-02-25', 3, 200, 0, 0, 0, 0, 0, 0, 0, 60),
(868, '2014-03-11', 3, '2014-03-11', 39, 160, 1, 0, 0, 0, 0, 0, 0, 61),
(869, '2014-03-11', 39, '2014-03-11', 3, 160, 0, 0, 0, 0, 0, 0, 0, 61),
(870, '2014-03-12', 3, '2014-03-12', 4, 48, 0, 0, 1, 0, 0, 0, 0, 61),
(871, '2014-03-13', 4, '2014-03-13', 95, 359, 0, 0, 0, 0, 0, 0, 0, 61),
(872, '2014-03-13', 95, '2014-03-13', 3, 340, 0, 1, 1, 0, 0, 0, 0, 61),
(873, '2014-03-17', 3, '2014-03-17', 47, 210, 0, 0, 0, 0, 0, 0, 0, 61),
(874, '2014-03-17', 47, '2014-03-17', 67, 88, 1, 0, 0, 0, 0, 0, 0, 61),
(875, '2014-03-18', 67, '2014-03-18', 3, 255, 0, 0, 0, 0, 0, 0, 0, 61),
(876, '2014-03-19', 3, '2014-03-19', 4, 48, 0, 0, 1, 0, 0, 0, 0, 61),
(877, '2014-03-20', 4, '2014-03-20', 5, 330, 0, 0, 0, 0, 0, 0, 0, 61),
(878, '2014-03-22', 5, '2014-03-22', 3, 370, 1, 2, 1, 0, 0, 0, 0, 61),
(879, '2014-03-25', 3, '2014-03-25', 7, 230, 0, 0, 0, 0, 0, 0, 0, 61),
(880, '2014-03-25', 7, '2014-03-25', 3, 230, 0, 0, 0, 0, 0, 0, 0, 61),
(881, '2014-04-29', 3, '2014-04-29', 227, 170, 0, 0, 0, 0, 0, 0, 0, 63),
(882, '2014-04-29', 227, '2014-04-29', 20, 165, 1, 0, 0, 0, 0, 0, 0, 63),
(883, '2014-04-30', 20, '2014-04-30', 3, 320, 0, 0, 0, 0, 0, 0, 0, 63),
(884, '2014-05-05', 3, '2014-05-05', 4, 38, 0, 0, 1, 0, 0, 0, 0, 63),
(885, '2014-05-06', 4, '2014-05-07', 5, 315, 0, 1, 0, 0, 0, 0, 0, 63),
(886, '2014-05-07', 5, '2014-05-08', 179, 400, 1, 0, 1, 0, 0, 0, 0, 63),
(887, '2014-05-09', 179, '2014-05-09', 7, 350, 0, 2, 0, 0, 0, 0, 0, 63),
(888, '2014-05-10', 7, '2014-05-10', 63, 100, 0, 0, 0, 0, 0, 0, 0, 63),
(889, '2014-05-11', 63, '2014-05-12', 31, 564, 0, 0, 0, 0, 0, 0, 0, 63),
(890, '2014-05-12', 31, '2014-05-13', 3, 634, 1, 0, 0, 0, 0, 0, 0, 63),
(891, '2014-05-13', 3, '2014-05-13', 4, 38, 0, 0, 1, 0, 0, 0, 0, 63),
(892, '2014-05-15', 4, '2014-05-15', 97, 206, 0, 1, 0, 0, 0, 0, 0, 63),
(893, '2014-05-16', 97, '2014-05-16', 48, 110, 0, 1, 0, 0, 0, 0, 0, 63),
(894, '2014-05-19', 48, '2014-05-19', 4, 120, 1, 0, 0, 0, 0, 0, 0, 63),
(895, '2014-05-20', 4, '2014-05-20', 39, 195, 0, 0, 1, 0, 0, 0, 0, 63),
(896, '2014-05-20', 39, '2014-05-22', 3, 160, 0, 1, 0, 0, 0, 0, 0, 63),
(897, '2014-05-28', 3, '2014-05-28', 63, 200, 0, 0, 0, 0, 0, 0, 0, 64),
(898, '2014-05-29', 63, '2014-05-29', 3, 180, 1, 1, 0, 0, 0, 0, 0, 64),
(899, '2014-06-01', 3, '2014-06-02', 18, 1258, 0, 0, 1, 0, 0, 0, 0, 64),
(900, '2014-06-04', 18, '2014-06-04', 21, 380, 0, 2, 0, 0, 0, 0, 0, 64),
(901, '2014-06-05', 21, '2014-06-05', 125, 350, 0, 0, 1, 0, 0, 0, 0, 64),
(902, '2014-06-06', 125, '2014-06-06', 3, 555, 1, 0, 0, 0, 0, 0, 0, 64),
(903, '2014-06-09', 3, '2014-06-09', 104, 260, 0, 0, 0, 0, 0, 0, 0, 64),
(904, '2014-06-09', 104, '2014-06-09', 20, 330, 0, 0, 0, 0, 0, 0, 0, 64),
(905, '2014-06-11', 20, '2014-06-12', 4, 350, 1, 0, 1, 0, 0, 0, 0, 64),
(906, '2014-06-12', 4, '2014-06-13', 74, 246, 0, 0, 0, 0, 0, 0, 0, 64),
(907, '2014-06-13', 74, '2014-06-13', 48, 220, 0, 0, 0, 0, 0, 0, 0, 64),
(908, '2014-06-16', 48, '2014-06-17', 3, 130, 1, 2, 1, 0, 0, 0, 0, 64),
(909, '2014-06-18', 3, '2014-06-18', 7, 238, 0, 0, 0, 0, 0, 0, 0, 64),
(910, '2014-06-18', 7, '2014-06-19', 105, 666, 0, 0, 0, 0, 0, 0, 0, 64),
(911, '2014-06-19', 105, '2014-06-20', 63, 640, 0, 0, 0, 0, 0, 0, 0, 64),
(912, '2014-06-24', 63, '2014-06-25', 4, 203, 1, 0, 1, 0, 0, 0, 0, 64),
(913, '2014-06-25', 4, '2014-06-26', 95, 360, 0, 0, 0, 0, 0, 0, 0, 64),
(914, '2014-06-26', 95, '2014-06-26', 48, 240, 0, 0, 0, 0, 0, 0, 0, 64),
(915, '2014-06-27', 48, '2014-06-27', 3, 174, 1, 1, 1, 0, 0, 0, 0, 64),
(916, '2014-06-30', 3, '2014-06-30', 52, 243, 0, 0, 0, 0, 0, 0, 0, 65),
(917, '2014-07-02', 52, '2014-07-03', 105, 640, 0, 0, 0, 0, 0, 0, 0, 65),
(918, '2014-07-03', 105, '2014-07-03', 122, 610, 1, 0, 0, 0, 0, 0, 0, 65),
(919, '2014-07-04', 122, '2014-07-04', 4, 290, 0, 0, 1, 0, 0, 0, 0, 65),
(920, '2014-07-07', 4, '2014-07-07', 123, 435, 0, 3, 0, 0, 0, 0, 0, 65),
(921, '2014-07-10', 123, '2014-07-10', 51, 155, 0, 0, 0, 0, 0, 0, 0, 65),
(922, '2014-07-14', 51, '2014-07-14', 4, 310, 1, 0, 1, 0, 0, 0, 0, 65),
(923, '2014-07-15', 4, '2014-07-16', 36, 755, 0, 1, 0, 0, 0, 0, 0, 65),
(924, '2014-07-16', 36, '2014-07-16', 31, 160, 0, 0, 0, 0, 0, 0, 0, 65),
(925, '2014-07-17', 31, '2014-07-18', 3, 650, 1, 0, 0, 0, 0, 0, 0, 65),
(926, '2014-07-21', 3, '2014-07-21', 4, 38, 0, 0, 1, 0, 0, 0, 0, 65),
(927, '2014-07-21', 4, '2014-07-21', 97, 208, 0, 0, 0, 0, 0, 0, 0, 65),
(928, '2014-07-22', 97, '2014-07-22', 48, 97, 0, 1, 0, 0, 0, 0, 0, 65),
(929, '2014-07-23', 48, '2014-07-24', 52, 397, 1, 0, 1, 0, 0, 0, 0, 65),
(930, '2014-07-25', 52, '2014-07-25', 105, 610, 0, 1, 0, 0, 0, 0, 0, 65),
(931, '2014-07-26', 105, '2014-07-26', 63, 670, 0, 0, 0, 0, 0, 0, 0, 65),
(932, '2014-07-29', 63, '2014-07-29', 3, 188, 1, 0, 0, 0, 0, 0, 0, 66),
(933, '2014-07-30', 3, '2014-07-30', 4, 38, 0, 0, 1, 0, 0, 0, 0, 66),
(934, '2014-07-30', 4, '2014-07-31', 5, 310, 0, 1, 0, 0, 0, 0, 0, 66),
(935, '2014-07-31', 5, '2014-07-31', 48, 280, 0, 0, 0, 0, 0, 0, 0, 66),
(936, '2014-08-01', 48, '2014-08-01', 4, 126, 1, 0, 0, 0, 0, 0, 0, 66),
(937, '2014-08-02', 4, '2014-08-02', 3, 40, 0, 1, 1, 0, 0, 0, 0, 66),
(938, '2014-08-04', 3, '2014-08-04', 39, 172, 0, 0, 0, 0, 0, 0, 0, 66),
(939, '2014-08-04', 39, '2014-08-04', 53, 202, 1, 0, 0, 0, 0, 0, 0, 66),
(940, '2014-08-05', 53, '2014-08-05', 3, 348, 0, 0, 0, 0, 0, 0, 0, 66),
(941, '2014-08-06', 3, '2014-08-07', 5, 350, 0, 1, 1, 0, 0, 0, 0, 66),
(942, '2014-08-07', 5, '2014-08-07', 3, 365, 0, 0, 1, 0, 0, 0, 0, 66),
(943, '2014-08-11', 3, '2014-08-11', 16, 146, 1, 0, 0, 0, 0, 0, 0, 66),
(944, '2014-08-11', 16, '2014-08-11', 4, 186, 0, 0, 1, 0, 0, 0, 0, 66),
(945, '2014-08-12', 4, '2014-08-12', 98, 238, 0, 0, 0, 0, 0, 0, 0, 66),
(946, '2014-08-13', 98, '2014-08-13', 3, 276, 0, 0, 1, 0, 0, 0, 0, 66),
(947, '2014-08-16', 3, '2014-08-16', 53, 346, 1, 1, 0, 0, 0, 0, 0, 66),
(948, '2014-08-16', 53, '2014-08-17', 4, 385, 0, 0, 1, 0, 0, 0, 0, 66),
(949, '2014-08-19', 4, '2014-08-19', 5, 307, 0, 0, 0, 0, 0, 0, 0, 66),
(950, '2014-08-19', 5, '2014-08-20', 3, 403, 0, 0, 1, 0, 0, 0, 0, 66),
(951, '2014-08-21', 3, '2014-08-21', 67, 270, 0, 0, 0, 0, 0, 0, 0, 66),
(952, '2014-08-21', 67, '2014-08-21', 47, 72, 0, 1, 0, 0, 0, 0, 0, 66),
(953, '2014-08-22', 47, '2014-08-22', 53, 160, 1, 0, 0, 0, 0, 0, 0, 66),
(954, '2014-08-22', 53, '2014-08-23', 4, 403, 0, 0, 1, 0, 0, 0, 0, 66),
(955, '2014-08-25', 4, '2014-08-26', 5, 307, 0, 0, 0, 0, 0, 0, 0, 66),
(956, '2014-08-26', 5, '2014-08-26', 3, 350, 0, 0, 1, 0, 0, 0, 0, 66),
(957, '2014-09-04', 3, '2014-09-04', 9, 295, 1, 0, 0, 0, 0, 0, 0, 67),
(958, '2014-09-04', 9, '2014-09-04', 3, 295, 0, 0, 0, 0, 0, 0, 0, 67),
(959, '2014-09-05', 3, '2014-09-05', 4, 48, 0, 0, 1, 0, 0, 0, 0, 67),
(960, '2014-09-06', 4, '2014-09-06', 19, 35, 0, 1, 0, 0, 0, 0, 0, 67),
(961, '2014-09-06', 19, '2014-09-06', 3, 85, 0, 0, 1, 0, 0, 0, 0, 67),
(962, '2014-09-25', 3, '2014-09-25', 3, 210, 0, 0, 0, 0, 0, 0, 0, 67);
INSERT INTO `planillakmdetalle` (`idPlanillaKmDetalle`, `fechaSalida`, `lugarSalida`, `fechaLlegada`, `lugarLlegada`, `kilometrosRecorridos`, `controlDescarga`, `simplePresencia`, `cruceFrontera`, `kilometrosRecorridos120`, `kilometrosRecorridos140`, `idUt`, `viajaVacio`, `idPlanillaKmCabecera`) VALUES
(963, '2014-09-27', 3, '2014-09-27', 34, 60, 0, 0, 0, 0, 0, 0, 0, 67),
(964, '2014-09-27', 34, '2014-09-27', 3, 70, 0, 0, 0, 0, 0, 0, 0, 67),
(965, '2014-10-10', 3, '2014-10-10', 228, 435, 1, 0, 0, 0, 0, 0, 0, 68),
(966, '2014-11-11', 228, '2014-11-11', 63, 110, 0, 0, 0, 0, 0, 0, 0, 68),
(967, '2014-10-15', 63, '2014-10-15', 20, 170, 1, 0, 0, 0, 0, 0, 0, 68),
(968, '2014-10-15', 20, '2014-10-15', 3, 323, 0, 0, 0, 0, 0, 0, 0, 68),
(969, '2014-10-16', 3, '2014-10-17', 5, 367, 0, 0, 1, 0, 0, 0, 0, 68),
(970, '2014-10-17', 5, '2014-10-17', 3, 370, 0, 1, 1, 0, 0, 0, 0, 68),
(971, '2014-10-18', 3, '2014-10-18', 229, 180, 0, 0, 0, 0, 0, 0, 0, 68),
(972, '2014-10-18', 229, '2014-10-18', 3, 180, 1, 0, 0, 0, 0, 0, 0, 68),
(973, '2014-10-20', 3, '2014-10-20', 4, 48, 0, 0, 1, 0, 0, 0, 0, 68),
(974, '2014-10-21', 4, '2014-10-21', 135, 190, 0, 0, 0, 0, 0, 0, 0, 68),
(975, '2014-10-22', 135, '2014-10-22', 164, 110, 0, 1, 0, 0, 0, 0, 0, 68),
(976, '2014-10-23', 164, '2014-10-23', 4, 190, 1, 0, 0, 0, 0, 0, 0, 68),
(977, '2014-10-24', 4, '2014-10-24', 3, 48, 0, 1, 1, 0, 0, 0, 0, 68),
(978, '2014-10-27', 3, '2014-10-27', 224, 252, 0, 0, 0, 0, 0, 0, 0, 68),
(979, '2014-10-28', 224, '2014-10-28', 35, 60, 1, 1, 0, 0, 0, 0, 0, 68),
(980, '2014-10-28', 35, '2014-10-28', 47, 90, 0, 0, 0, 0, 0, 0, 0, 68),
(981, '2014-10-30', 47, '2014-10-30', 67, 93, 1, 1, 0, 0, 0, 0, 0, 68),
(982, '2014-10-31', 67, '2014-10-31', 3, 258, 0, 1, 0, 0, 0, 0, 0, 68),
(983, '2014-11-11', 3, '2014-11-11', 47, 270, 1, 0, 0, 0, 0, 0, 0, 69),
(984, '2014-11-11', 47, '2014-11-11', 67, 90, 0, 0, 0, 0, 0, 0, 0, 69),
(985, '2014-11-12', 67, '2014-11-12', 3, 280, 0, 1, 0, 0, 0, 0, 0, 69),
(986, '2014-11-13', 3, '2014-11-13', 4, 48, 0, 0, 1, 0, 0, 0, 0, 69),
(987, '2014-11-17', 4, '2014-11-18', 5, 350, 0, 1, 0, 0, 0, 0, 0, 69),
(988, '2014-11-18', 5, '2014-11-19', 3, 390, 1, 0, 1, 0, 0, 0, 0, 69),
(989, '2014-11-20', 3, '2014-11-20', 47, 370, 0, 0, 0, 0, 0, 0, 0, 69),
(990, '2014-11-25', 47, '2014-11-25', 67, 90, 1, 0, 0, 0, 0, 0, 0, 69),
(991, '2014-11-25', 67, '2014-11-25', 3, 280, 0, 0, 0, 0, 0, 0, 0, 69),
(992, '2014-11-26', 3, '2014-11-26', 4, 48, 0, 1, 1, 0, 0, 0, 0, 69),
(993, '2014-11-26', 4, '2014-11-27', 5, 350, 0, 0, 0, 0, 0, 0, 0, 69),
(994, '2014-11-27', 5, '2014-11-27', 4, 350, 1, 0, 0, 0, 0, 0, 0, 69),
(995, '2014-11-28', 4, '2014-11-28', 3, 48, 0, 1, 0, 0, 0, 0, 0, 69),
(996, '2014-12-01', 3, '2014-12-01', 67, 280, 1, 0, 0, 0, 0, 0, 0, 70),
(997, '2014-12-04', 67, '2014-12-04', 47, 90, 0, 3, 0, 0, 0, 0, 0, 70),
(998, '2014-12-04', 47, '2014-12-05', 67, 90, 1, 0, 0, 0, 0, 0, 0, 70),
(999, '2014-12-05', 67, '2014-12-06', 4, 328, 0, 0, 1, 0, 0, 0, 0, 70),
(1000, '2014-12-08', 4, '2014-12-09', 5, 350, 0, 1, 0, 0, 0, 0, 0, 70),
(1001, '2014-12-09', 5, '2014-12-10', 3, 388, 1, 0, 1, 0, 0, 0, 0, 70),
(1002, '2014-12-11', 3, '2014-12-11', 67, 280, 0, 0, 0, 0, 0, 0, 0, 70),
(1003, '2014-12-12', 67, '2014-12-12', 47, 90, 1, 1, 0, 0, 0, 0, 0, 70),
(1004, '2014-12-12', 47, '2014-12-12', 63, 80, 0, 0, 0, 0, 0, 0, 0, 70),
(1005, '2014-12-18', 63, '2014-12-18', 107, 515, 0, 0, 0, 0, 0, 0, 0, 70),
(1006, '2014-12-19', 107, '2014-12-19', 4, 780, 1, 1, 1, 0, 0, 0, 0, 70),
(1007, '2014-12-23', 4, '2014-12-24', 5, 368, 0, 0, 0, 0, 0, 0, 0, 70),
(1008, '2014-12-24', 5, '2014-12-24', 3, 396, 0, 1, 1, 0, 0, 0, 0, 70),
(1009, '2014-12-27', 3, '2014-12-27', 39, 170, 1, 0, 0, 0, 0, 0, 0, 70),
(1010, '2014-12-29', 39, '2014-12-29', 4, 210, 0, 0, 1, 0, 0, 0, 0, 70),
(1011, '2014-12-30', 4, '2014-12-30', 5, 300, 0, 0, 0, 0, 0, 0, 0, 70),
(1012, '2014-12-31', 5, '2014-12-31', 3, 350, 0, 1, 1, 0, 0, 0, 0, 70),
(1013, '2014-01-03', 3, '2014-01-03', 7, 320, 1, 0, 0, 0, 0, 0, 0, 71),
(1014, '2014-01-03', 7, '2014-01-03', 3, 240, 0, 0, 0, 0, 0, 0, 0, 71),
(1015, '2014-01-05', 3, '2014-01-06', 17, 1070, 0, 0, 0, 0, 0, 0, 0, 71),
(1016, '2014-01-07', 17, '2014-01-07', 211, 10, 0, 0, 0, 0, 0, 0, 0, 71),
(1017, '2014-01-07', 211, '2014-01-07', 230, 40, 1, 2, 1, 0, 0, 0, 0, 71),
(1018, '2014-01-08', 230, '2014-01-08', 21, 423, 0, 0, 0, 0, 0, 0, 0, 71),
(1019, '2014-01-09', 21, '2014-01-10', 114, 60, 0, 3, 1, 0, 0, 0, 0, 71),
(1020, '2014-01-13', 114, '2014-01-15', 7, 950, 1, 0, 0, 0, 0, 0, 0, 71),
(1021, '2014-01-15', 7, '2014-01-15', 3, 250, 1, 0, 0, 0, 0, 0, 0, 71),
(1022, '2014-01-20', 3, '2014-01-20', 53, 370, 0, 0, 0, 0, 0, 0, 0, 71),
(1023, '2014-01-20', 53, '2014-01-20', 3, 370, 0, 0, 0, 0, 0, 0, 0, 71),
(1024, '2014-01-21', 3, '2014-01-21', 21, 850, 0, 3, 1, 0, 0, 0, 0, 71),
(1025, '2014-01-24', 21, '2014-01-24', 96, 230, 1, 1, 0, 0, 0, 0, 0, 71),
(1026, '2014-01-25', 96, '2014-01-25', 21, 230, 0, 0, 0, 0, 0, 0, 0, 71),
(1027, '2014-01-27', 21, '2014-01-28', 3, 850, 0, 2, 1, 0, 0, 0, 0, 71),
(1028, '2014-01-28', 3, '2014-01-28', 7, 280, 0, 0, 0, 0, 0, 0, 0, 72),
(1029, '2014-01-28', 7, '2014-01-28', 63, 80, 1, 0, 0, 0, 0, 0, 0, 72),
(1030, '2014-01-29', 63, '2014-01-29', 3, 180, 0, 0, 0, 0, 0, 0, 0, 72),
(1031, '2014-01-30', 3, '2014-01-31', 211, 1100, 0, 6, 1, 0, 0, 0, 0, 72),
(1032, '2014-02-06', 18, '2014-02-06', 21, 405, 1, 1, 0, 0, 0, 0, 0, 72),
(1033, '2014-02-07', 21, '2014-02-07', 3, 810, 0, 0, 1, 0, 0, 0, 0, 72),
(1034, '2014-02-10', 3, '2014-02-10', 83, 320, 1, 0, 0, 0, 0, 0, 0, 72),
(1035, '2014-02-10', 83, '2014-02-10', 3, 375, 0, 0, 0, 0, 0, 0, 0, 72),
(1036, '2014-03-13', 3, '2014-03-13', 63, 206, 0, 0, 0, 0, 0, 0, 0, 73),
(1037, '2014-03-13', 63, '2014-03-13', 3, 206, 0, 0, 0, 0, 0, 0, 0, 73),
(1038, '2014-03-14', 3, '2014-03-14', 4, 40, 0, 0, 1, 0, 0, 0, 0, 73),
(1039, '2014-03-16', 4, '2014-03-16', 231, 100, 0, 0, 0, 0, 0, 0, 0, 73),
(1040, '2014-03-17', 231, '2014-03-17', 5, 225, 1, 0, 0, 0, 0, 0, 0, 73),
(1041, '2014-03-18', 5, '2014-03-18', 3, 390, 0, 0, 1, 0, 0, 0, 0, 73),
(1042, '2014-03-19', 3, '2014-03-19', 7, 250, 1, 0, 0, 0, 0, 0, 0, 73),
(1043, '2014-03-19', 7, '2014-03-19', 30, 440, 0, 0, 0, 0, 0, 0, 0, 73),
(1044, '2014-03-20', 30, '2014-03-20', 3, 690, 0, 0, 0, 0, 0, 0, 0, 73),
(1045, '2014-03-25', 3, '2014-03-26', 5, 400, 1, 1, 1, 0, 0, 0, 0, 73),
(1046, '2014-03-26', 5, '2014-03-26', 5, 0, 0, 1, 0, 0, 0, 0, 0, 73),
(1047, '2014-03-27', 5, '2014-03-27', 4, 390, 1, 1, 0, 0, 0, 0, 0, 73),
(1048, '2014-03-28', 4, '2014-03-28', 4, 0, 0, 1, 0, 0, 0, 0, 0, 73),
(1049, '2014-03-29', 4, '2014-03-29', 3, 40, 0, 0, 1, 0, 0, 0, 0, 73),
(1050, '2014-03-31', 3, '2014-03-31', 36, 710, 1, 3, 0, 0, 0, 0, 0, 74),
(1051, '2014-04-03', 36, '2014-04-04', 63, 720, 0, 0, 0, 0, 0, 0, 0, 74),
(1052, '2014-04-07', 63, '2014-04-08', 4, 380, 0, 0, 1, 0, 0, 0, 0, 74),
(1053, '2014-04-08', 4, '2014-04-09', 5, 403, 5, 2, 0, 0, 0, 0, 0, 74),
(1054, '2014-04-09', 5, '2014-04-09', 48, 280, 0, 0, 0, 0, 0, 0, 0, 74),
(1055, '2014-04-11', 48, '2014-04-11', 4, 130, 0, 5, 0, 0, 0, 0, 0, 74),
(1056, '2014-04-16', 4, '2014-04-16', 3, 30, 0, 0, 1, 0, 0, 0, 0, 74),
(1057, '2014-04-21', 3, '2014-04-21', 67, 150, 0, 0, 0, 0, 0, 0, 0, 74),
(1058, '2014-04-22', 67, '2014-04-22', 35, 50, 1, 2, 0, 0, 0, 0, 0, 74),
(1059, '2014-04-23', 35, '2014-04-23', 63, 30, 0, 0, 0, 0, 0, 0, 0, 74),
(1060, '2014-04-24', 63, '2014-04-24', 9, 470, 1, 0, 0, 0, 0, 0, 0, 74),
(1061, '2014-04-25', 3, '2014-04-25', 4, 40, 0, 0, 1, 0, 0, 0, 0, 74),
(1062, '2014-04-27', 4, '2014-04-27', 5, 325, 0, 0, 1, 0, 0, 0, 0, 75),
(1063, '2014-04-28', 5, '2014-04-28', 3, 390, 1, 1, 1, 0, 0, 0, 0, 75),
(1064, '2014-04-29', 3, '2014-04-29', 2, 330, 0, 0, 0, 0, 0, 0, 0, 75),
(1065, '2014-04-29', 2, '2014-04-30', 4, 380, 0, 0, 1, 0, 0, 0, 0, 75),
(1066, '2014-05-04', 4, '2014-05-05', 5, 340, 1, 0, 0, 0, 0, 0, 0, 75),
(1067, '2014-05-05', 5, '2014-05-07', 179, 410, 0, 3, 1, 0, 0, 0, 0, 75),
(1068, '2014-05-16', 3, '2014-05-16', 1, 480, 0, 0, 0, 0, 0, 0, 0, 75),
(1069, '2014-05-17', 1, '2014-05-17', 3, 480, 0, 0, 0, 0, 0, 0, 0, 75),
(1070, '2014-05-18', 3, '2014-05-18', 22, 817, 0, 0, 0, 0, 0, 0, 0, 75),
(1071, '2014-05-19', 22, '2014-05-19', 21, 0, 0, 0, 1, 0, 0, 0, 0, 75),
(1072, '2014-05-22', 21, '2014-05-22', 12, 285, 0, 7, 0, 0, 0, 0, 0, 75),
(1073, '2014-05-23', 12, '2014-05-23', 21, 285, 1, 0, 0, 0, 0, 0, 0, 75),
(1074, '2014-05-26', 21, '2014-05-26', 22, 10, 0, 0, 0, 0, 0, 0, 0, 75),
(1075, '2014-05-27', 62, '2014-05-28', 34, 760, 2, 0, 0, 0, 0, 0, 0, 76),
(1076, '2014-06-17', 34, '2014-06-18', 106, 410, 0, 0, 0, 0, 0, 0, 0, 76),
(1077, '2014-06-18', 106, '2014-06-18', 3, 350, 0, 0, 0, 0, 0, 0, 0, 76),
(1078, '2014-06-19', 3, '2014-06-19', 4, 40, 0, 0, 1, 0, 0, 0, 0, 76),
(1079, '2014-06-22', 4, '2014-06-22', 5, 340, 1, 0, 0, 0, 0, 0, 0, 76),
(1080, '2014-06-23', 5, '2014-06-23', 3, 357, 1, 1, 1, 0, 0, 0, 0, 76),
(1081, '2014-06-24', 3, '2014-06-24', 34, 140, 0, 0, 0, 0, 0, 0, 0, 76),
(1082, '2014-06-25', 3, '2014-06-25', 20, 325, 1, 0, 0, 0, 0, 0, 0, 76),
(1083, '2014-06-25', 20, '2014-06-25', 3, 335, 0, 0, 0, 0, 0, 0, 0, 76),
(1084, '2014-06-26', 3, '2014-06-26', 4, 40, 1, 1, 1, 0, 0, 0, 0, 76),
(1085, '2014-06-26', 4, '2014-06-27', 5, 340, 1, 1, 0, 0, 0, 0, 0, 76),
(1086, '2014-06-27', 5, '2014-06-27', 48, 0, 0, 1, 0, 0, 0, 0, 0, 76),
(1087, '2014-06-27', 48, '2014-06-27', 4, 600, 0, 0, 0, 0, 0, 0, 0, 76),
(1088, '2014-06-29', 4, '2014-06-29', 48, 0, 0, 0, 0, 0, 0, 0, 0, 76),
(1089, '2014-06-30', 48, '2014-06-30', 4, 125, 0, 1, 1, 0, 0, 0, 0, 76),
(1090, '2014-07-02', 3, '2014-07-02', 7, 260, 0, 0, 0, 0, 0, 0, 0, 77),
(1091, '2014-07-02', 7, '2014-07-03', 105, 640, 1, 0, 0, 0, 0, 0, 0, 77),
(1092, '2014-07-03', 105, '2014-07-04', 63, 724, 0, 0, 0, 0, 0, 0, 0, 77),
(1093, '2014-07-08', 63, '2014-07-09', 4, 205, 0, 0, 1, 0, 0, 0, 0, 77),
(1094, '2014-07-09', 4, '2014-07-10', 5, 230, 1, 0, 0, 0, 0, 0, 0, 77),
(1095, '2014-07-10', 5, '2014-07-14', 4, 426, 0, 4, 0, 0, 0, 0, 0, 77),
(1096, '2014-07-15', 4, '2014-07-16', 36, 790, 1, 0, 1, 0, 0, 0, 0, 77),
(1097, '2014-07-16', 36, '2014-07-16', 31, 130, 0, 0, 0, 0, 0, 0, 0, 77),
(1098, '2014-07-17', 31, '2014-07-21', 4, 730, 0, 0, 1, 0, 0, 0, 0, 77),
(1099, '2014-07-21', 4, '2014-07-21', 43, 365, 1, 0, 0, 0, 0, 0, 0, 77),
(1100, '2014-07-22', 43, '2014-07-22', 48, 360, 0, 2, 0, 0, 0, 0, 0, 77),
(1101, '2014-07-23', 48, '2014-07-23', 3, 170, 0, 0, 1, 0, 0, 0, 0, 77),
(1102, '2014-07-24', 3, '2014-07-24', 7, 259, 0, 1, 0, 0, 0, 0, 0, 77),
(1103, '2014-07-25', 7, '2014-07-25', 105, 665, 1, 0, 0, 0, 0, 0, 0, 77),
(1104, '2014-08-01', 105, '2014-08-12', 3, 1005, 1, 0, 0, 0, 0, 0, 0, 78),
(1105, '2014-08-13', 3, '2014-08-13', 39, 190, 0, 0, 0, 0, 0, 0, 0, 78),
(1106, '2014-08-13', 39, '2014-08-15', 95, 590, 1, 1, 1, 0, 0, 0, 0, 78),
(1107, '2014-08-15', 95, '2014-08-15', 3, 370, 0, 0, 1, 0, 0, 0, 0, 78),
(1108, '2014-08-21', 3, '2014-08-21', 20, 345, 0, 0, 0, 0, 0, 0, 0, 78),
(1109, '2014-08-21', 20, '2014-08-21', 3, 345, 0, 0, 0, 0, 0, 0, 0, 78),
(1110, '2014-08-22', 3, '2014-08-23', 5, 400, 1, 0, 1, 0, 0, 0, 0, 78),
(1111, '2014-08-23', 5, '2014-08-23', 3, 390, 1, 1, 1, 0, 0, 0, 0, 78),
(1112, '2014-08-26', 3, '2014-08-26', 7, 320, 0, 0, 0, 0, 0, 0, 0, 78),
(1113, '2014-08-26', 7, '2014-08-27', 4, 310, 0, 0, 1, 0, 0, 0, 0, 78),
(1114, '2014-08-27', 4, '2014-08-28', 5, 350, 1, 1, 0, 0, 0, 0, 0, 78),
(1115, '2014-08-28', 5, '2014-08-28', 3, 380, 0, 0, 1, 0, 0, 0, 0, 78),
(1116, '2014-01-02', 3, '2014-01-02', 81, 330, 1, 0, 0, 0, 0, 0, 0, 79),
(1117, '2014-01-02', 81, '2014-01-02', 43, 50, 0, 0, 0, 0, 0, 0, 0, 79),
(1118, '2014-01-03', 43, '2014-01-03', 3, 210, 1, 0, 0, 0, 0, 0, 0, 79),
(1119, '2014-01-05', 3, '2014-01-05', 17, 1060, 0, 0, 1, 0, 0, 0, 0, 79),
(1120, '2014-01-07', 17, '2014-01-07', 18, 40, 0, 1, 0, 0, 0, 0, 0, 79),
(1121, '2014-01-08', 18, '2014-01-08', 21, 360, 0, 0, 0, 0, 0, 0, 0, 79),
(1122, '2014-01-09', 21, '2014-01-09', 62, 90, 0, 1, 1, 0, 0, 0, 0, 79),
(1123, '2014-01-13', 62, '2014-01-14', 3, 690, 1, 3, 0, 0, 0, 0, 0, 79),
(1124, '2014-01-15', 3, '2014-01-15', 69, 190, 0, 0, 0, 0, 0, 0, 0, 79),
(1125, '2014-01-15', 69, '2014-01-15', 20, 250, 0, 0, 0, 0, 0, 0, 0, 79),
(1126, '2014-01-16', 20, '2014-01-16', 3, 300, 1, 0, 0, 0, 0, 0, 0, 79),
(1127, '2014-01-20', 3, '2014-01-21', 5, 350, 0, 0, 1, 0, 0, 0, 0, 79),
(1128, '2014-01-21', 5, '2014-01-21', 39, 500, 0, 1, 1, 0, 0, 0, 0, 79),
(1129, '2014-01-21', 39, '2014-01-22', 6, 280, 1, 0, 1, 0, 0, 0, 0, 79),
(1130, '2014-01-22', 6, '2014-01-22', 3, 130, 1, 0, 1, 0, 0, 0, 0, 79),
(1131, '2014-02-13', 3, '2014-02-13', 43, 230, 0, 0, 0, 0, 0, 0, 0, 80),
(1132, '2014-02-13', 43, '2014-02-14', 3, 230, 1, 0, 0, 0, 0, 0, 0, 80),
(1133, '2014-02-15', 3, '2014-02-16', 17, 990, 0, 0, 0, 0, 0, 0, 0, 80),
(1134, '2014-02-18', 17, '2014-02-18', 18, 50, 0, 1, 1, 0, 0, 0, 0, 80),
(1135, '2014-02-19', 18, '2014-02-20', 62, 490, 0, 0, 1, 0, 0, 0, 0, 80),
(1136, '2014-02-21', 62, '2014-02-22', 3, 650, 1, 0, 0, 0, 0, 0, 0, 80),
(1137, '2014-02-24', 3, '2014-02-24', 55, 210, 0, 0, 0, 0, 0, 0, 0, 80),
(1138, '2014-02-24', 55, '2014-02-24', 3, 210, 0, 0, 0, 0, 0, 0, 0, 80),
(1139, '2014-03-10', 3, '2014-03-10', 232, 130, 0, 0, 0, 0, 0, 0, 0, 81),
(1140, '2014-03-10', 232, '2014-03-12', 211, 950, 1, 0, 1, 0, 0, 0, 0, 81),
(1141, '2014-03-19', 211, '2014-03-19', 18, 40, 0, 8, 0, 0, 0, 0, 0, 81),
(1142, '2014-03-19', 18, '2014-03-20', 62, 450, 0, 0, 1, 0, 0, 0, 0, 81),
(1143, '2014-03-21', 62, '2014-03-22', 80, 910, 1, 0, 0, 0, 0, 0, 0, 81),
(1144, '2014-03-22', 80, '2014-03-22', 3, 200, 0, 0, 0, 0, 0, 0, 0, 81),
(1145, '2014-03-26', 3, '2014-03-26', 55, 220, 1, 0, 0, 0, 0, 0, 0, 82),
(1146, '2014-03-28', 55, '2014-03-28', 52, 70, 0, 1, 0, 0, 0, 0, 0, 82),
(1147, '2014-03-28', 52, '2014-03-28', 3, 210, 0, 0, 0, 0, 0, 0, 0, 82),
(1148, '2014-03-31', 3, '2014-03-31', 89, 480, 0, 0, 1, 0, 0, 0, 0, 82),
(1149, '2014-04-01', 89, '2014-04-01', 48, 430, 0, 0, 0, 0, 0, 0, 0, 82),
(1150, '2014-04-02', 48, '2014-04-03', 35, 450, 0, 0, 1, 0, 0, 0, 0, 82),
(1151, '2014-04-07', 35, '2014-04-08', 2, 230, 0, 0, 0, 0, 0, 0, 0, 82),
(1152, '2014-04-08', 2, '2014-04-08', 3, 310, 1, 0, 0, 0, 0, 0, 0, 82),
(1153, '2014-04-09', 3, '2014-04-09', 6, 140, 0, 0, 1, 0, 0, 0, 0, 82),
(1154, '2014-04-10', 6, '2014-04-11', 5, 330, 0, 0, 0, 0, 0, 0, 0, 82),
(1155, '2014-04-14', 5, '2014-04-15', 67, 620, 1, 0, 1, 0, 0, 0, 0, 82),
(1156, '2014-04-16', 67, '2014-04-16', 47, 80, 0, 1, 0, 0, 0, 0, 0, 82),
(1157, '2014-04-17', 47, '2014-04-17', 63, 70, 0, 0, 0, 0, 0, 0, 0, 82),
(1158, '2014-04-22', 63, '2014-04-22', 63, 20, 0, 1, 0, 0, 0, 0, 0, 82),
(1159, '2014-04-23', 63, '2014-04-25', 18, 1200, 1, 3, 1, 0, 0, 0, 0, 82),
(1160, '2014-04-28', 18, '2014-04-29', 174, 530, 0, 0, 1, 0, 0, 0, 0, 82),
(1161, '2014-04-30', 174, '2014-05-01', 3, 630, 1, 0, 0, 0, 0, 0, 0, 83),
(1162, '2014-05-05', 3, '2014-05-05', 233, 210, 0, 0, 0, 0, 0, 0, 0, 83),
(1163, '2014-05-06', 233, '2014-05-06', 115, 540, 0, 0, 0, 0, 0, 0, 0, 83),
(1164, '2014-05-12', 115, '2014-05-12', 116, 470, 1, 7, 0, 0, 0, 0, 0, 83),
(1165, '2014-05-13', 116, '2014-05-13', 63, 120, 0, 0, 0, 0, 0, 0, 0, 83),
(1166, '2014-05-14', 63, '2014-05-16', 95, 670, 1, 0, 1, 0, 0, 0, 0, 83),
(1167, '2014-05-16', 95, '2014-05-16', 48, 230, 0, 0, 0, 0, 0, 0, 0, 83),
(1168, '2014-05-19', 48, '2014-05-20', 39, 330, 1, 2, 1, 0, 0, 0, 0, 83),
(1169, '2014-05-22', 39, '2014-05-22', 1, 320, 0, 0, 0, 0, 0, 0, 0, 83),
(1170, '2014-05-23', 1, '2014-05-23', 3, 460, 1, 0, 0, 0, 0, 0, 0, 83),
(1171, '2014-05-25', 3, '2014-05-25', 21, 800, 0, 0, 1, 0, 0, 0, 0, 83),
(1172, '2014-05-28', 21, '2014-05-28', 12, 270, 0, 2, 0, 0, 0, 0, 0, 83),
(1173, '2014-05-30', 12, '2014-05-31', 62, 360, 0, 2, 1, 0, 0, 0, 0, 83),
(1174, '2014-05-31', 62, '2014-06-01', 3, 680, 1, 0, 0, 0, 0, 0, 0, 84),
(1175, '2014-06-02', 3, '2014-06-02', 120, 270, 0, 0, 0, 0, 0, 0, 0, 84),
(1176, '2014-06-02', 120, '2014-06-02', 40, 400, 0, 0, 0, 0, 0, 0, 0, 84),
(1177, '2014-06-03', 40, '2014-06-03', 3, 300, 1, 0, 0, 0, 0, 0, 0, 84),
(1178, '2014-06-04', 3, '2014-06-04', 135, 250, 0, 0, 1, 0, 0, 0, 0, 84),
(1179, '2014-06-05', 135, '2014-06-05', 48, 130, 0, 0, 0, 0, 0, 0, 0, 84),
(1180, '2014-06-06', 48, '2014-06-07', 3, 160, 1, 2, 1, 0, 0, 0, 0, 84),
(1181, '2014-06-09', 3, '2014-06-09', 220, 240, 0, 0, 0, 0, 0, 0, 0, 84),
(1182, '2014-06-09', 220, '2014-06-10', 105, 600, 0, 0, 0, 0, 0, 0, 0, 84),
(1183, '2014-06-10', 105, '2014-06-11', 120, 550, 0, 1, 0, 0, 0, 0, 0, 84),
(1184, '2014-06-12', 120, '2014-06-12', 234, 140, 0, 0, 0, 0, 0, 0, 0, 84),
(1185, '2014-06-12', 234, '2014-06-12', 63, 30, 0, 0, 0, 0, 0, 0, 0, 84),
(1186, '2014-06-16', 63, '2014-06-16', 235, 100, 0, 1, 0, 0, 0, 0, 0, 84),
(1187, '2014-06-17', 235, '2014-06-17', 63, 130, 0, 0, 0, 0, 0, 0, 0, 84),
(1188, '2014-06-19', 63, '2014-06-19', 3, 180, 0, 2, 0, 0, 0, 0, 0, 84),
(1189, '2014-06-23', 3, '2014-06-23', 63, 180, 0, 3, 0, 0, 0, 0, 0, 84),
(1190, '2014-06-25', 63, '2014-06-27', 119, 570, 1, 0, 1, 0, 0, 0, 0, 84),
(1191, '2014-06-27', 119, '2014-06-27', 48, 330, 0, 1, 0, 0, 0, 0, 0, 84),
(1192, '2014-06-30', 48, '2014-07-01', 3, 150, 1, 1, 1, 0, 0, 0, 0, 84),
(1193, '2014-07-02', 3, '2014-07-02', 220, 240, 0, 0, 0, 0, 0, 0, 0, 85),
(1194, '2014-07-03', 220, '2014-07-04', 105, 640, 1, 0, 0, 0, 0, 0, 0, 85),
(1195, '2014-07-04', 105, '2014-07-05', 63, 660, 0, 0, 0, 0, 0, 0, 0, 85),
(1196, '2014-07-07', 63, '2014-07-07', 236, 20, 0, 1, 0, 0, 0, 0, 0, 85),
(1197, '2014-07-14', 236, '2014-07-15', 119, 560, 1, 0, 1, 0, 0, 0, 0, 85),
(1198, '2014-07-16', 119, '2014-07-17', 27, 420, 0, 1, 1, 0, 0, 0, 0, 85),
(1199, '2014-07-17', 27, '2014-07-17', 3, 70, 1, 0, 0, 0, 0, 0, 0, 85),
(1200, '2014-07-20', 3, '2014-07-21', 21, 790, 0, 0, 1, 0, 0, 0, 0, 85),
(1201, '2014-07-23', 21, '2014-07-23', 96, 240, 0, 2, 0, 0, 0, 0, 0, 85),
(1202, '2014-07-27', 96, '2014-07-28', 62, 320, 0, 4, 1, 0, 0, 0, 0, 85),
(1203, '2014-07-29', 62, '2014-07-30', 32, 930, 1, 0, 0, 0, 0, 0, 0, 86),
(1204, '2014-07-30', 32, '2014-07-31', 67, 100, 0, 1, 0, 0, 0, 0, 0, 86),
(1205, '2014-08-04', 67, '2014-08-04', 3, 240, 1, 0, 0, 0, 0, 0, 0, 86),
(1206, '2014-08-05', 3, '2014-08-06', 5, 350, 0, 0, 1, 0, 0, 0, 0, 86),
(1207, '2014-08-06', 5, '2014-08-07', 47, 560, 0, 1, 1, 0, 0, 0, 0, 86),
(1208, '2014-08-07', 47, '2014-08-07', 67, 80, 1, 0, 0, 0, 0, 0, 0, 86),
(1209, '2014-08-07', 67, '2014-08-07', 3, 250, 0, 0, 0, 0, 0, 0, 0, 86),
(1210, '2014-08-09', 3, '2014-08-11', 5, 370, 0, 0, 1, 0, 0, 0, 0, 86),
(1211, '2014-08-11', 5, '2014-08-12', 16, 490, 0, 1, 1, 0, 0, 0, 0, 86),
(1212, '2014-08-12', 16, '2014-08-12', 3, 140, 1, 0, 0, 0, 0, 0, 0, 86),
(1213, '2014-08-13', 3, '2014-08-13', 135, 220, 0, 0, 1, 0, 0, 0, 0, 86),
(1214, '2014-08-14', 135, '2014-08-14', 3, 220, 0, 1, 1, 0, 0, 0, 0, 86),
(1215, '2014-08-18', 3, '2014-08-19', 5, 380, 1, 0, 1, 0, 0, 0, 0, 86),
(1216, '2014-08-19', 5, '2014-08-21', 67, 620, 1, 2, 1, 0, 0, 0, 0, 86),
(1217, '2014-08-21', 67, '2014-08-21', 47, 80, 0, 0, 0, 0, 0, 0, 0, 86),
(1218, '2014-08-22', 47, '2014-08-22', 10, 140, 0, 0, 0, 0, 0, 0, 0, 86),
(1219, '2014-08-22', 10, '2014-08-22', 3, 260, 1, 0, 0, 0, 0, 0, 0, 86),
(1220, '2014-08-24', 3, '2014-08-25', 211, 1000, 0, 0, 1, 0, 0, 0, 0, 86),
(1221, '2014-08-27', 211, '2014-08-28', 121, 440, 0, 3, 0, 0, 0, 0, 0, 86),
(1222, '2014-08-28', 121, '2014-08-28', 62, 140, 0, 0, 1, 0, 0, 0, 0, 86),
(1223, '2014-08-29', 62, '2014-08-30', 3, 690, 1, 0, 0, 0, 0, 0, 0, 87),
(1224, '2014-09-01', 3, '2014-09-01', 237, 300, 0, 0, 0, 0, 0, 0, 0, 87),
(1225, '2014-09-01', 237, '2014-09-01', 3, 320, 0, 0, 0, 0, 0, 0, 0, 87),
(1226, '2014-09-02', 3, '2014-09-03', 5, 360, 1, 0, 1, 0, 0, 0, 0, 87),
(1227, '2014-09-03', 5, '2014-09-04', 3, 350, 0, 1, 1, 0, 0, 0, 0, 87),
(1228, '2014-09-05', 3, '2014-09-06', 5, 370, 1, 0, 1, 0, 0, 0, 0, 87),
(1229, '2014-09-06', 5, '2014-09-06', 3, 360, 0, 1, 1, 0, 0, 0, 0, 87),
(1230, '2014-09-08', 3, '2014-09-08', 53, 340, 0, 0, 0, 0, 0, 0, 0, 87),
(1231, '2014-09-08', 53, '2014-09-10', 21, 1120, 1, 0, 1, 0, 0, 0, 0, 87),
(1232, '2014-09-10', 21, '2014-09-11', 12, 280, 0, 0, 0, 0, 0, 0, 0, 87),
(1233, '2014-09-11', 12, '2014-09-12', 62, 380, 0, 2, 1, 0, 0, 0, 0, 87),
(1234, '2014-09-13', 62, '2014-09-15', 55, 850, 1, 0, 0, 0, 0, 0, 0, 87),
(1235, '2014-09-15', 55, '2014-09-15', 63, 70, 0, 0, 0, 0, 0, 0, 0, 87),
(1236, '2014-09-16', 63, '2014-09-16', 238, 480, 1, 0, 0, 0, 0, 0, 0, 87),
(1237, '2014-09-17', 238, '2014-09-18', 3, 610, 0, 0, 0, 0, 0, 0, 0, 87),
(1238, '2014-09-21', 3, '2014-09-22', 21, 790, 0, 0, 1, 0, 0, 0, 0, 87),
(1239, '2014-09-23', 21, '2014-09-24', 12, 280, 0, 0, 0, 0, 0, 0, 0, 87),
(1240, '2014-09-24', 12, '2014-09-24', 62, 380, 0, 2, 1, 0, 0, 0, 0, 87),
(1241, '2014-09-25', 62, '2014-09-26', 70, 900, 1, 0, 0, 0, 0, 0, 0, 87),
(1242, '2014-09-26', 70, '2014-09-26', 53, 250, 0, 0, 0, 0, 0, 0, 0, 88),
(1243, '2014-09-29', 53, '2014-10-01', 21, 1210, 1, 2, 1, 0, 0, 0, 0, 88),
(1244, '2014-10-02', 21, '2014-10-03', 12, 280, 0, 0, 0, 0, 0, 0, 0, 88),
(1245, '2014-10-03', 12, '2014-10-03', 162, 360, 0, 2, 1, 0, 0, 0, 0, 88),
(1246, '2014-10-04', 162, '2014-10-05', 3, 780, 1, 0, 0, 0, 0, 0, 0, 88),
(1247, '2014-10-06', 3, '2014-10-06', 55, 210, 0, 0, 0, 0, 0, 0, 0, 88),
(1248, '2014-10-08', 55, '2014-10-08', 67, 70, 0, 1, 0, 0, 0, 0, 0, 88),
(1249, '2014-10-08', 67, '2014-10-10', 5, 610, 1, 0, 1, 0, 0, 0, 0, 88),
(1250, '2014-10-10', 5, '2014-10-10', 3, 340, 0, 1, 1, 0, 0, 0, 0, 88),
(1251, '2014-10-14', 3, '2014-10-14', 160, 280, 0, 0, 0, 0, 0, 0, 0, 88),
(1252, '2014-10-15', 160, '2014-10-16', 5, 630, 1, 1, 1, 0, 0, 0, 0, 88),
(1253, '2014-10-17', 5, '2014-10-17', 165, 140, 0, 0, 0, 0, 0, 0, 0, 88),
(1254, '2014-10-18', 165, '2014-10-21', 56, 460, 1, 2, 1, 0, 0, 0, 0, 88),
(1255, '2014-10-22', 56, '2014-10-22', 47, 90, 0, 0, 0, 0, 0, 0, 0, 88),
(1256, '2014-10-23', 47, '2014-10-23', 67, 90, 1, 0, 0, 0, 0, 0, 0, 88),
(1257, '2014-10-23', 67, '2014-10-23', 3, 240, 0, 0, 0, 0, 0, 0, 0, 88),
(1258, '2014-10-24', 3, '2014-10-28', 5, 390, 0, 0, 1, 0, 0, 0, 0, 88),
(1259, '2014-10-28', 5, '2014-10-28', 239, 250, 0, 2, 0, 0, 0, 0, 0, 88),
(1260, '2014-10-29', 239, '2014-10-30', 3, 250, 1, 0, 1, 0, 0, 0, 0, 88),
(1261, '2014-11-03', 3, '2014-11-03', 169, 270, 0, 0, 0, 0, 0, 0, 0, 89),
(1262, '2014-11-04', 169, '2014-11-04', 63, 230, 0, 0, 0, 0, 0, 0, 0, 89),
(1263, '2014-11-06', 63, '2014-11-09', 87, 380, 1, 0, 1, 0, 0, 0, 0, 89),
(1264, '2014-11-10', 87, '2014-11-10', 3, 210, 0, 1, 1, 0, 0, 0, 0, 89),
(1265, '2014-11-11', 3, '2014-11-11', 63, 180, 0, 0, 0, 0, 0, 0, 0, 89),
(1266, '2014-11-11', 63, '2014-11-13', 95, 570, 1, 0, 1, 0, 0, 0, 0, 89),
(1267, '2014-11-13', 95, '2014-11-14', 3, 300, 0, 1, 1, 0, 0, 0, 0, 89),
(1268, '2014-11-17', 3, '2014-11-17', 63, 160, 0, 0, 0, 0, 0, 0, 0, 89),
(1269, '2014-11-19', 63, '2014-11-21', 95, 590, 0, 0, 1, 0, 0, 0, 0, 89),
(1270, '2014-11-21', 95, '2014-11-21', 239, 210, 0, 1, 0, 0, 0, 0, 0, 89),
(1271, '2014-11-24', 239, '2014-11-27', 35, 540, 1, 3, 1, 0, 0, 0, 0, 89),
(1272, '2014-11-28', 35, '2014-11-28', 63, 110, 0, 0, 0, 0, 0, 0, 0, 89),
(1273, '2014-11-30', 63, '2014-12-01', 1, 300, 0, 0, 0, 0, 0, 0, 0, 90),
(1274, '2014-12-01', 1, '2014-12-03', 21, 1190, 1, 0, 1, 0, 0, 0, 0, 90),
(1275, '2014-12-04', 21, '2014-12-04', 12, 270, 0, 0, 0, 0, 0, 0, 0, 90),
(1276, '2014-12-05', 12, '2014-12-06', 62, 380, 0, 2, 1, 0, 0, 0, 0, 90),
(1277, '2014-12-07', 62, '2014-12-07', 3, 670, 1, 0, 0, 0, 0, 0, 0, 90),
(1278, '2014-12-09', 3, '2014-12-09', 69, 210, 0, 0, 0, 0, 0, 0, 0, 90),
(1279, '2014-12-10', 69, '2014-12-10', 63, 70, 0, 0, 0, 0, 0, 0, 0, 90),
(1280, '2014-12-16', 63, '2014-12-17', 168, 230, 0, 0, 0, 0, 0, 0, 0, 90),
(1281, '2014-12-17', 168, '2014-12-19', 211, 1390, 1, 0, 1, 0, 0, 0, 0, 90),
(1282, '2014-12-19', 211, '2014-12-20', 167, 270, 0, 0, 0, 0, 0, 0, 0, 90),
(1283, '2014-12-20', 167, '2014-12-22', 62, 630, 0, 3, 1, 0, 0, 0, 0, 90),
(1284, '2013-12-26', 3, '2013-12-26', 43, 246, 0, 0, 0, 0, 0, 0, 0, 91),
(1285, '2013-12-27', 43, '2013-12-27', 3, 246, 0, 0, 0, 0, 0, 0, 0, 91),
(1286, '2014-01-02', 3, '2014-01-03', 17, 972, 0, 0, 0, 0, 0, 0, 0, 91),
(1287, '2014-01-04', 17, '2014-01-04', 211, 2, 0, 1, 1, 0, 0, 0, 0, 91),
(1288, '2014-01-06', 211, '2014-01-06', 18, 40, 1, 4, 0, 0, 0, 0, 0, 91),
(1289, '2014-01-07', 18, '2014-01-07', 21, 360, 0, 5, 0, 0, 0, 0, 0, 91),
(1290, '2014-01-08', 21, '2014-01-08', 62, 110, 0, 1, 1, 0, 0, 0, 0, 91),
(1291, '2014-01-09', 62, '2014-01-10', 68, 1318, 0, 0, 0, 0, 0, 0, 0, 91),
(1292, '2014-01-10', 68, '2014-01-11', 3, 318, 1, 0, 0, 0, 0, 0, 0, 91),
(1293, '2014-01-13', 3, '2014-01-14', 1, 481, 0, 0, 0, 0, 0, 0, 0, 91),
(1294, '2014-01-14', 1, '2014-01-15', 17, 1127, 0, 0, 0, 0, 0, 0, 0, 91),
(1295, '2014-01-16', 17, '2014-01-16', 211, 2, 0, 1, 1, 0, 0, 0, 0, 91),
(1296, '2014-01-17', 211, '2014-01-18', 96, 369, 0, 1, 0, 0, 0, 0, 0, 91),
(1297, '2014-01-18', 96, '2014-01-18', 21, 200, 1, 1, 0, 0, 0, 0, 0, 91),
(1298, '2014-01-20', 21, '2014-01-20', 114, 58, 0, 2, 1, 0, 0, 0, 0, 91),
(1299, '2014-01-22', 114, '2014-01-23', 158, 931, 1, 0, 0, 0, 0, 0, 0, 91),
(1300, '2014-01-23', 158, '2014-01-23', 63, 90, 0, 0, 0, 0, 0, 0, 0, 91),
(1301, '2014-01-24', 63, '2014-01-25', 3, 167, 0, 0, 0, 0, 0, 0, 0, 91),
(1302, '2014-01-26', 3, '2014-01-26', 189, 650, 0, 0, 0, 0, 0, 0, 0, 92),
(1303, '2014-01-27', 189, '2014-01-27', 18, 400, 0, 0, 1, 0, 0, 0, 0, 92),
(1304, '2014-01-29', 18, '2014-01-30', 21, 373, 1, 2, 0, 0, 0, 0, 0, 92),
(1305, '2014-01-30', 21, '2014-01-30', 62, 110, 0, 0, 1, 0, 0, 0, 0, 92),
(1306, '2014-01-31', 62, '2014-02-03', 240, 898, 1, 0, 0, 0, 0, 0, 0, 92),
(1307, '2014-02-03', 240, '2014-02-03', 47, 32, 0, 0, 0, 0, 0, 0, 0, 92),
(1308, '2014-02-05', 47, '2014-02-05', 67, 80, 0, 0, 0, 0, 0, 0, 0, 92),
(1309, '2014-02-05', 67, '2014-02-06', 4, 284, 0, 0, 1, 0, 0, 0, 0, 92),
(1310, '2014-02-06', 4, '2014-02-07', 5, 342, 1, 0, 0, 0, 0, 0, 0, 92),
(1311, '2014-02-10', 5, '2014-02-11', 3, 427, 0, 0, 1, 0, 0, 0, 0, 92),
(1312, '2014-02-11', 3, '2014-02-12', 177, 250, 1, 0, 0, 0, 0, 0, 0, 92),
(1313, '2014-02-12', 177, '2014-02-12', 52, 300, 0, 0, 0, 0, 0, 0, 0, 92),
(1314, '2014-02-14', 52, '2014-02-14', 43, 33, 1, 2, 0, 0, 0, 0, 0, 92),
(1315, '2014-02-15', 43, '2014-02-15', 3, 230, 0, 0, 0, 0, 0, 0, 0, 92),
(1316, '2014-02-16', 3, '2014-02-17', 189, 650, 0, 0, 0, 0, 0, 0, 0, 92),
(1317, '2014-02-17', 189, '2014-02-17', 211, 350, 0, 0, 1, 0, 0, 0, 0, 92),
(1318, '2014-02-18', 211, '2014-02-18', 18, 40, 0, 1, 0, 0, 0, 0, 0, 92),
(1319, '2014-02-20', 18, '2014-02-20', 21, 370, 1, 0, 0, 0, 0, 0, 0, 92),
(1320, '2014-02-21', 21, '2014-02-21', 62, 110, 0, 0, 1, 0, 0, 0, 0, 92),
(1321, '2014-02-21', 62, '2014-02-22', 3, 700, 0, 0, 0, 0, 0, 0, 0, 92),
(1322, '2014-02-24', 3, '2014-02-24', 77, 290, 1, 0, 0, 0, 0, 0, 0, 92),
(1323, '2014-02-24', 77, '2014-02-25', 30, 476, 0, 0, 0, 0, 0, 0, 0, 92),
(1324, '2014-02-25', 30, '2014-02-26', 4, 683, 0, 1, 1, 0, 0, 0, 0, 93),
(1325, '2014-02-27', 4, '2014-02-28', 177, 220, 0, 1, 0, 0, 0, 0, 0, 93),
(1326, '2014-02-28', 177, '2014-02-28', 3, 215, 1, 0, 1, 0, 0, 0, 0, 93),
(1327, '2014-03-16', 3, '2014-03-17', 177, 320, 0, 0, 0, 0, 0, 0, 0, 93),
(1328, '2014-03-17', 177, '2014-03-17', 31, 280, 0, 0, 0, 0, 0, 0, 0, 93),
(1329, '2014-03-18', 31, '2014-03-19', 4, 644, 0, 1, 1, 0, 0, 0, 0, 93),
(1330, '2014-03-19', 4, '2014-03-19', 241, 134, 0, 1, 0, 0, 0, 0, 0, 93),
(1331, '2014-03-20', 241, '2014-03-20', 3, 167, 1, 0, 1, 0, 0, 0, 0, 93),
(1332, '2014-03-25', 3, '2014-03-25', 9, 309, 0, 0, 0, 0, 0, 0, 0, 93),
(1333, '2014-03-25', 9, '2014-03-26', 3, 320, 0, 0, 0, 0, 0, 0, 0, 93),
(1334, '2014-03-27', 3, '2014-03-27', 4, 5, 0, 1, 1, 0, 0, 0, 0, 93),
(1335, '2014-03-27', 4, '2014-03-28', 5, 308, 0, 0, 0, 0, 0, 0, 0, 93),
(1336, '2014-03-28', 5, '2014-03-28', 242, 181, 1, 1, 0, 0, 0, 0, 0, 93),
(1337, '2014-03-30', 242, '2014-03-30', 48, 105, 0, 0, 0, 0, 0, 0, 0, 94),
(1338, '2014-04-02', 48, '2014-04-02', 4, 120, 0, 2, 0, 0, 0, 0, 0, 94),
(1339, '2014-04-03', 4, '2014-04-04', 35, 320, 0, 0, 1, 0, 0, 0, 0, 94),
(1340, '2014-04-05', 35, '2014-04-05', 63, 61, 1, 0, 0, 0, 0, 0, 0, 94),
(1341, '2014-04-07', 63, '2014-04-08', 2, 170, 0, 0, 0, 0, 0, 0, 0, 94),
(1342, '2014-04-08', 2, '2014-04-09', 4, 350, 0, 0, 1, 0, 0, 0, 0, 94),
(1343, '2014-04-09', 4, '2014-04-09', 6, 120, 0, 0, 0, 0, 0, 0, 0, 94),
(1344, '2014-04-11', 6, '2014-04-11', 5, 333, 1, 0, 0, 0, 0, 0, 0, 94),
(1345, '2014-04-11', 5, '2014-04-12', 3, 355, 0, 0, 1, 0, 0, 0, 0, 94),
(1346, '2014-04-14', 3, '2014-04-14', 67, 256, 0, 0, 0, 0, 0, 0, 0, 94),
(1347, '2014-04-16', 67, '2014-04-16', 63, 152, 1, 2, 0, 0, 0, 0, 0, 94),
(1348, '2014-04-25', 63, '2014-04-25', 18, 1304, 0, 1, 0, 0, 0, 0, 0, 94),
(1349, '2014-04-28', 18, '2014-04-29', 62, 459, 1, 2, 1, 0, 0, 0, 0, 94),
(1350, '2014-04-29', 62, '2014-04-30', 57, 1020, 1, 0, 0, 0, 0, 0, 0, 95),
(1351, '2014-04-30', 57, '2014-04-30', 1, 377, 0, 0, 0, 0, 0, 0, 0, 95),
(1352, '2014-04-30', 1, '2014-05-01', 3, 453, 0, 0, 0, 0, 0, 0, 0, 95),
(1353, '2014-05-05', 3, '2014-05-05', 4, 43, 0, 0, 1, 0, 0, 0, 0, 95),
(1354, '2014-05-05', 4, '2014-05-06', 5, 294, 1, 0, 0, 0, 0, 0, 0, 95),
(1355, '2014-05-06', 5, '2014-05-07', 179, 467, 0, 1, 0, 0, 0, 0, 0, 95),
(1356, '2014-05-09', 179, '2014-05-10', 7, 293, 1, 3, 1, 0, 0, 0, 0, 95),
(1357, '2014-05-10', 7, '2014-05-12', 31, 654, 0, 0, 0, 0, 0, 0, 0, 95),
(1358, '2014-05-12', 31, '2014-05-14', 4, 634, 0, 1, 1, 0, 0, 0, 0, 95),
(1359, '2014-05-15', 4, '2014-05-15', 97, 200, 0, 1, 0, 0, 0, 0, 0, 95),
(1360, '2014-05-16', 97, '2014-05-16', 48, 110, 1, 0, 0, 0, 0, 0, 0, 95),
(1361, '2014-05-16', 48, '2014-05-16', 4, 120, 0, 0, 0, 0, 0, 0, 0, 95),
(1362, '2014-05-18', 4, '2014-05-18', 48, 120, 0, 0, 0, 0, 0, 0, 0, 95),
(1363, '2014-05-19', 48, '2014-05-19', 4, 120, 0, 1, 0, 0, 0, 0, 0, 95),
(1364, '2014-05-20', 4, '2014-05-21', 39, 206, 1, 0, 1, 0, 0, 0, 0, 95),
(1365, '2014-05-22', 39, '2014-05-23', 118, 588, 0, 0, 0, 0, 0, 0, 0, 95),
(1366, '2014-05-23', 118, '2014-05-24', 247, 299, 0, 2, 0, 0, 0, 0, 0, 95),
(1367, '2014-05-26', 243, '2014-05-27', 4, 598, 0, 0, 1, 0, 0, 0, 0, 96),
(1368, '2014-05-28', 4, '2014-05-28', 5, 307, 1, 1, 0, 0, 0, 0, 0, 96),
(1369, '2014-05-28', 5, '2014-05-29', 63, 514, 0, 0, 1, 0, 0, 0, 0, 96),
(1370, '2014-05-29', 63, '2014-05-30', 3, 167, 0, 0, 0, 0, 0, 0, 0, 96),
(1371, '2014-06-01', 3, '2014-06-02', 189, 700, 0, 0, 0, 0, 0, 0, 0, 96),
(1372, '2014-06-02', 189, '2014-06-02', 18, 307, 0, 1, 1, 0, 0, 0, 0, 96),
(1373, '2014-06-04', 18, '2014-06-05', 21, 371, 1, 0, 0, 0, 0, 0, 0, 96),
(1374, '2014-06-05', 21, '2014-06-06', 125, 347, 0, 3, 1, 0, 0, 0, 0, 96),
(1375, '2014-06-06', 125, '2014-06-09', 104, 709, 0, 0, 0, 0, 0, 0, 0, 96),
(1376, '2014-06-09', 104, '2014-06-09', 9, 208, 0, 0, 0, 0, 0, 0, 0, 96),
(1377, '2014-06-09', 9, '2014-06-10', 4, 323, 0, 2, 1, 0, 0, 0, 0, 96),
(1378, '2014-06-11', 4, '2014-06-12', 5, 305, 1, 1, 0, 0, 0, 0, 0, 96),
(1379, '2014-06-13', 5, '2014-06-14', 48, 317, 0, 2, 0, 0, 0, 0, 0, 96),
(1380, '2014-06-18', 48, '2014-06-19', 244, 273, 0, 1, 1, 0, 0, 0, 0, 96),
(1381, '2014-06-19', 244, '2014-06-20', 105, 604, 0, 0, 0, 0, 0, 0, 0, 96),
(1382, '2014-06-21', 105, '2014-06-21', 63, 644, 1, 0, 0, 0, 0, 0, 0, 96),
(1383, '2014-06-25', 63, '2014-06-26', 4, 190, 0, 0, 1, 0, 0, 0, 0, 97),
(1384, '2014-06-26', 4, '2014-06-27', 114, 290, 1, 0, 0, 0, 0, 0, 0, 97),
(1385, '2014-06-27', 114, '2014-06-27', 48, 200, 0, 0, 0, 0, 0, 0, 0, 97),
(1386, '2014-06-30', 48, '2014-06-30', 4, 120, 0, 0, 0, 0, 0, 0, 0, 97),
(1387, '2014-07-01', 4, '2014-07-03', 7, 255, 0, 0, 1, 0, 0, 0, 0, 97),
(1388, '2014-07-03', 7, '2014-07-04', 105, 604, 1, 0, 0, 0, 0, 0, 0, 97),
(1389, '2014-07-04', 105, '2014-07-05', 63, 644, 0, 0, 0, 0, 0, 0, 0, 97),
(1390, '2014-07-07', 63, '2014-07-07', 63, 15, 0, 0, 0, 0, 0, 0, 0, 97),
(1391, '2014-07-14', 63, '2014-07-16', 119, 543, 1, 2, 1, 0, 0, 0, 0, 97),
(1392, '2014-07-16', 119, '2014-07-17', 27, 446, 0, 0, 1, 0, 0, 0, 0, 97),
(1393, '2014-07-17', 27, '2014-07-17', 3, 79, 0, 0, 0, 0, 0, 0, 0, 97),
(1394, '2014-07-20', 3, '2014-07-21', 22, 775, 0, 0, 0, 0, 0, 0, 0, 97),
(1395, '2014-07-21', 22, '2014-07-21', 21, 5, 0, 4, 1, 0, 0, 0, 0, 97),
(1396, '2014-07-23', 21, '2014-07-23', 96, 200, 0, 0, 0, 0, 0, 0, 0, 97),
(1397, '2014-07-27', 96, '2014-07-27', 21, 208, 1, 0, 0, 0, 0, 0, 0, 97),
(1398, '2014-07-28', 21, '2014-07-28', 114, 49, 0, 4, 1, 0, 0, 0, 0, 97),
(1399, '2014-07-29', 114, '2014-07-30', 132, 1214, 1, 0, 0, 0, 0, 0, 0, 98),
(1400, '2014-07-30', 132, '2014-07-31', 67, 35, 0, 1, 0, 0, 0, 0, 0, 98),
(1401, '2014-08-04', 67, '2014-08-05', 3, 240, 0, 0, 0, 0, 0, 0, 0, 98),
(1402, '2014-08-05', 3, '2014-08-06', 5, 350, 1, 1, 1, 0, 0, 0, 0, 98),
(1403, '2014-08-06', 5, '2014-08-07', 47, 560, 0, 0, 1, 0, 0, 0, 0, 98),
(1404, '2014-08-07', 47, '2014-08-07', 3, 330, 0, 0, 0, 0, 0, 0, 0, 98),
(1405, '2014-08-09', 3, '2014-08-09', 4, 45, 0, 0, 1, 0, 0, 0, 0, 98),
(1406, '2014-08-11', 4, '2014-08-11', 5, 370, 1, 1, 0, 0, 0, 0, 0, 98),
(1407, '2014-08-11', 5, '2014-08-12', 16, 490, 0, 0, 1, 0, 0, 0, 0, 98),
(1408, '2014-08-12', 16, '2014-08-13', 4, 166, 0, 0, 1, 0, 0, 0, 0, 98),
(1409, '2014-08-13', 4, '2014-08-14', 98, 197, 1, 1, 0, 0, 0, 0, 0, 98),
(1410, '2014-08-14', 98, '2014-08-15', 53, 597, 0, 0, 1, 0, 0, 0, 0, 98),
(1411, '2014-08-16', 53, '2014-08-16', 4, 410, 0, 1, 1, 0, 0, 0, 0, 98),
(1412, '2014-08-18', 4, '2014-08-19', 5, 388, 1, 0, 0, 0, 0, 0, 0, 98),
(1413, '2014-08-19', 5, '2014-08-21', 67, 620, 0, 2, 1, 0, 0, 0, 0, 98),
(1414, '2014-08-21', 67, '2014-08-21', 47, 80, 1, 0, 0, 0, 0, 0, 0, 98),
(1415, '2014-08-22', 47, '2014-08-22', 10, 140, 0, 0, 0, 0, 0, 0, 0, 98),
(1416, '2014-08-22', 10, '2014-08-22', 3, 260, 0, 0, 1, 0, 0, 0, 0, 98),
(1417, '2014-08-24', 3, '2014-08-25', 211, 1000, 0, 0, 0, 0, 0, 0, 0, 98),
(1418, '2014-08-27', 211, '2014-08-28', 140, 390, 1, 3, 0, 0, 0, 0, 0, 98),
(1419, '2014-08-28', 140, '2014-08-28', 114, 290, 0, 0, 1, 0, 0, 0, 0, 98),
(1420, '2014-08-29', 114, '2014-09-01', 55, 1047, 0, 0, 0, 0, 0, 0, 0, 99),
(1421, '2014-09-01', 55, '2014-09-01', 3, 220, 1, 0, 0, 0, 0, 0, 0, 99),
(1422, '2014-09-03', 3, '2014-09-03', 20, 300, 0, 0, 0, 0, 0, 0, 0, 99),
(1423, '2014-09-03', 20, '2014-09-04', 4, 345, 0, 0, 1, 0, 0, 0, 0, 99),
(1424, '2014-09-04', 4, '2014-09-05', 5, 340, 0, 0, 0, 0, 0, 0, 0, 99),
(1425, '2014-09-05', 5, '2014-09-06', 4, 370, 1, 2, 0, 0, 0, 0, 0, 99),
(1426, '2014-09-06', 4, '2014-09-08', 67, 265, 0, 0, 1, 0, 0, 0, 0, 99),
(1427, '2014-09-10', 67, '2014-09-10', 47, 80, 1, 2, 0, 0, 0, 0, 0, 99),
(1428, '2014-09-10', 47, '2014-09-11', 53, 160, 0, 0, 0, 0, 0, 0, 0, 99),
(1429, '2014-09-11', 53, '2014-09-12', 3, 365, 0, 0, 0, 0, 0, 0, 0, 99),
(1430, '2014-09-14', 3, '2014-09-15', 21, 820, 0, 0, 1, 0, 0, 0, 0, 99),
(1431, '2014-09-16', 21, '2014-09-17', 12, 310, 1, 2, 0, 0, 0, 0, 0, 99),
(1432, '2014-09-17', 12, '2014-09-17', 114, 350, 0, 0, 1, 0, 0, 0, 0, 99),
(1433, '2014-09-18', 114, '2014-09-19', 69, 950, 1, 0, 0, 0, 0, 0, 0, 99),
(1434, '2014-09-19', 69, '2014-09-19', 9, 200, 0, 0, 0, 0, 0, 0, 0, 99),
(1435, '2014-09-19', 9, '2014-09-19', 3, 283, 0, 0, 0, 0, 0, 0, 0, 99),
(1436, '2014-09-21', 3, '2014-09-22', 17, 1000, 0, 0, 0, 0, 0, 0, 0, 99),
(1437, '2014-09-23', 17, '2014-09-23', 211, 17, 0, 1, 1, 0, 0, 0, 0, 99),
(1438, '2014-09-24', 211, '2014-09-25', 96, 379, 0, 0, 0, 0, 0, 0, 0, 99),
(1439, '2014-09-25', 96, '2014-09-25', 22, 230, 1, 2, 1, 0, 0, 0, 0, 99),
(1440, '2014-09-26', 22, '2014-09-29', 82, 980, 1, 0, 0, 0, 0, 0, 0, 100),
(1441, '2014-09-29', 82, '2014-09-29', 53, 150, 0, 0, 0, 0, 0, 0, 0, 100),
(1442, '2014-09-29', 53, '2014-09-30', 3, 365, 0, 0, 0, 0, 0, 0, 0, 100),
(1443, '2014-09-30', 3, '2014-10-01', 21, 764, 0, 0, 1, 0, 0, 0, 0, 100),
(1444, '2014-10-02', 21, '2014-10-03', 12, 268, 1, 2, 0, 0, 0, 0, 0, 100),
(1445, '2014-10-03', 12, '2014-10-03', 162, 361, 0, 0, 1, 0, 0, 0, 0, 100),
(1446, '2014-10-04', 162, '2014-10-05', 3, 753, 0, 0, 0, 0, 0, 0, 0, 100),
(1447, '2014-10-06', 3, '2014-10-06', 163, 264, 1, 0, 0, 0, 0, 0, 0, 100),
(1448, '2014-10-06', 163, '2014-10-06', 67, 151, 0, 2, 0, 0, 0, 0, 0, 100),
(1449, '2014-10-08', 67, '2014-10-09', 4, 277, 0, 0, 1, 0, 0, 0, 0, 100),
(1450, '2014-10-09', 4, '2014-10-10', 5, 308, 0, 2, 0, 0, 0, 0, 0, 100),
(1451, '2014-10-10', 5, '2014-10-10', 3, 340, 1, 0, 1, 0, 0, 0, 0, 100),
(1452, '2014-10-14', 3, '2014-10-14', 160, 271, 0, 1, 0, 0, 0, 0, 0, 100),
(1453, '2014-10-15', 160, '2014-10-15', 5, 622, 0, 0, 1, 0, 0, 0, 0, 100),
(1454, '2014-10-17', 5, '2014-10-17', 164, 207, 1, 2, 0, 0, 0, 0, 0, 100),
(1455, '2014-10-18', 164, '2014-10-18', 4, 189, 0, 1, 0, 0, 0, 0, 0, 100),
(1456, '2014-10-20', 4, '2014-10-21', 210, 302, 0, 1, 1, 0, 0, 0, 0, 100),
(1457, '2014-10-22', 244, '2014-10-22', 35, 142, 1, 0, 0, 0, 0, 0, 0, 100),
(1458, '2014-10-24', 35, '2014-10-25', 4, 248, 0, 1, 1, 0, 0, 0, 0, 100),
(1459, '2014-10-27', 4, '2014-10-28', 5, 331, 1, 0, 0, 0, 0, 0, 0, 100),
(1460, '2014-10-28', 5, '2014-10-28', 164, 261, 1, 2, 0, 0, 0, 0, 0, 101),
(1461, '2014-10-29', 164, '2014-10-29', 4, 207, 0, 0, 0, 0, 0, 0, 0, 101),
(1462, '2014-10-30', 4, '2014-11-03', 245, 300, 0, 1, 1, 0, 0, 0, 0, 101),
(1463, '2014-11-03', 245, '2014-11-05', 63, 275, 1, 1, 0, 0, 0, 0, 0, 101),
(1464, '2014-11-06', 63, '2014-11-07', 4, 195, 0, 0, 1, 0, 0, 0, 0, 101),
(1465, '2014-11-09', 4, '2014-11-10', 5, 307, 1, 1, 0, 0, 0, 0, 0, 101),
(1466, '2014-11-11', 5, '2014-11-11', 4, 403, 0, 0, 0, 0, 0, 0, 0, 101),
(1467, '2014-11-12', 4, '2014-11-13', 19, 301, 0, 0, 1, 0, 0, 0, 0, 101),
(1468, '2014-11-14', 19, '2014-11-14', 3, 270, 1, 1, 0, 0, 0, 0, 0, 101),
(1469, '2014-11-17', 3, '2014-11-18', 63, 172, 0, 0, 0, 0, 0, 0, 0, 101),
(1470, '2014-11-19', 63, '2014-11-20', 4, 207, 0, 0, 1, 0, 0, 0, 0, 101),
(1471, '2014-11-20', 4, '2014-11-21', 95, 353, 1, 1, 0, 0, 0, 0, 0, 101),
(1472, '2014-11-21', 95, '2014-11-24', 164, 215, 0, 1, 0, 0, 0, 0, 0, 101),
(1473, '2014-11-24', 164, '2014-11-25', 4, 207, 0, 1, 0, 0, 0, 0, 0, 101),
(1474, '2014-11-25', 4, '2014-11-26', 244, 302, 0, 1, 1, 0, 0, 0, 0, 101),
(1475, '2014-11-27', 244, '2014-11-27', 35, 40, 0, 0, 0, 0, 0, 0, 0, 101),
(1476, '2014-11-28', 35, '2014-11-28', 63, 69, 1, 1, 0, 0, 0, 0, 0, 101),
(1477, '2014-11-30', 63, '2014-12-01', 1, 300, 0, 1, 0, 0, 0, 0, 0, 102),
(1478, '2014-12-01', 1, '2014-12-03', 21, 1226, 0, 0, 1, 0, 0, 0, 0, 102),
(1479, '2014-12-04', 21, '2014-12-04', 12, 270, 0, 2, 0, 0, 0, 0, 0, 102),
(1480, '2014-12-05', 12, '2014-12-06', 62, 366, 1, 0, 1, 0, 0, 0, 0, 102),
(1481, '2014-12-06', 62, '2014-12-08', 55, 917, 1, 0, 0, 0, 0, 0, 0, 102),
(1482, '2014-12-08', 55, '2014-12-10', 63, 67, 0, 2, 0, 0, 0, 0, 0, 102),
(1483, '2014-12-17', 63, '2014-12-17', 107, 502, 0, 0, 0, 0, 0, 0, 0, 102),
(1484, '2014-12-18', 107, '2014-12-24', 5, 1050, 1, 4, 1, 0, 0, 0, 0, 102),
(1485, '2014-12-24', 5, '2014-12-24', 3, 458, 0, 0, 1, 0, 0, 0, 0, 102),
(1486, '2014-12-27', 3, '2014-12-27', 63, 168, 0, 0, 0, 0, 0, 0, 0, 102),
(1487, '2014-12-29', 63, '2014-12-31', 5, 495, 1, 2, 1, 0, 0, 0, 0, 102),
(1488, '2014-12-31', 5, '2014-12-31', 3, 355, 0, 0, 1, 0, 0, 0, 0, 102),
(1489, '2014-01-02', 3, '2014-01-02', 47, 260, 0, 0, 0, 0, 0, 0, 0, 103),
(1490, '2014-01-03', 47, '2014-01-03', 67, 60, 0, 0, 0, 0, 0, 0, 0, 103),
(1491, '2014-01-03', 67, '2014-01-03', 3, 265, 0, 0, 0, 0, 0, 0, 0, 103),
(1492, '2014-01-06', 3, '2014-01-08', 5, 385, 1, 1, 1, 0, 0, 0, 0, 103),
(1493, '2014-01-09', 5, '2014-01-09', 3, 385, 0, 0, 1, 0, 0, 0, 0, 103),
(1494, '2014-01-09', 3, '2014-01-10', 20, 320, 0, 0, 0, 0, 0, 0, 0, 103),
(1495, '2014-01-10', 20, '2014-01-10', 3, 365, 0, 0, 0, 0, 0, 0, 0, 103),
(1496, '2014-01-13', 4, '2014-01-15', 5, 355, 1, 1, 1, 0, 0, 0, 0, 103),
(1497, '2014-01-15', 5, '2014-01-15', 3, 380, 0, 1, 1, 0, 0, 0, 0, 103),
(1498, '2014-01-19', 3, '2014-01-22', 47, 350, 1, 2, 0, 0, 0, 0, 0, 103),
(1499, '2014-01-22', 47, '2014-01-23', 39, 65, 0, 1, 0, 0, 0, 0, 0, 103),
(1500, '2014-01-23', 39, '2014-01-23', 3, 170, 0, 0, 0, 0, 0, 0, 0, 103),
(1501, '2014-01-24', 3, '2014-01-24', 87, 240, 1, 1, 1, 0, 0, 0, 0, 103),
(1502, '2014-01-25', 87, '2014-01-25', 3, 250, 0, 0, 1, 0, 0, 0, 0, 103),
(1503, '2014-01-27', 3, '2014-01-28', 53, 365, 0, 0, 0, 0, 0, 0, 0, 104),
(1504, '2014-01-28', 53, '2014-01-29', 3, 365, 0, 0, 0, 0, 0, 0, 0, 104),
(1505, '2014-01-29', 3, '2014-01-30', 21, 810, 0, 0, 1, 0, 0, 0, 0, 104),
(1506, '2014-01-31', 21, '2014-01-31', 12, 285, 1, 0, 0, 0, 0, 0, 0, 104),
(1507, '2014-01-31', 12, '2014-01-31', 62, 385, 0, 1, 1, 0, 0, 0, 0, 104),
(1508, '2014-02-01', 62, '2014-02-02', 3, 700, 0, 0, 0, 0, 0, 0, 0, 104),
(1509, '2014-02-03', 3, '2014-02-03', 75, 200, 1, 0, 0, 0, 0, 0, 0, 104),
(1510, '2014-02-03', 75, '2014-02-03', 3, 200, 0, 0, 0, 0, 0, 0, 0, 104),
(1511, '2014-03-10', 3, '2014-03-12', 211, 1120, 0, 0, 1, 0, 0, 0, 0, 105),
(1512, '2014-03-19', 211, '2014-03-19', 18, 35, 1, 8, 1, 0, 0, 0, 0, 105),
(1513, '2014-03-20', 18, '2014-03-20', 62, 490, 0, 0, 0, 0, 0, 0, 0, 105),
(1514, '2014-03-21', 62, '2014-03-22', 3, 710, 0, 0, 0, 0, 0, 0, 0, 105),
(1515, '2014-03-25', 3, '2014-03-25', 35, 210, 1, 0, 0, 0, 0, 0, 0, 105),
(1516, '2014-03-26', 3, '2014-03-26', 7, 275, 0, 0, 0, 0, 0, 0, 0, 106),
(1517, '2014-03-28', 7, '2014-03-28', 3, 285, 0, 0, 0, 0, 0, 0, 0, 106),
(1518, '2014-03-31', 3, '2014-03-31', 89, 470, 1, 1, 1, 0, 0, 0, 0, 106),
(1519, '2014-04-01', 89, '2014-04-01', 48, 445, 0, 0, 0, 0, 0, 0, 0, 106),
(1520, '2014-04-02', 48, '2014-04-02', 4, 125, 0, 0, 1, 0, 0, 0, 0, 106),
(1521, '2014-04-03', 4, '2014-04-03', 35, 340, 1, 0, 0, 0, 0, 0, 0, 106),
(1522, '2014-04-05', 35, '2014-04-07', 2, 240, 0, 0, 0, 0, 0, 0, 0, 106),
(1523, '2014-04-08', 2, '2014-04-08', 3, 330, 0, 0, 0, 0, 0, 0, 0, 106),
(1524, '2014-04-09', 3, '2014-04-09', 4, 38, 0, 0, 1, 0, 0, 0, 0, 106),
(1525, '2014-04-09', 4, '2014-04-09', 6, 100, 1, 0, 0, 0, 0, 0, 0, 106),
(1526, '2014-04-09', 6, '2014-04-09', 5, 350, 0, 0, 0, 0, 0, 0, 0, 106),
(1527, '2014-04-14', 5, '2014-04-14', 3, 388, 0, 0, 1, 0, 0, 0, 0, 106),
(1528, '2014-04-15', 3, '2014-04-16', 67, 260, 0, 1, 0, 0, 0, 0, 0, 106),
(1529, '2014-04-16', 67, '2014-04-17', 47, 80, 1, 0, 0, 0, 0, 0, 0, 106),
(1530, '2014-04-17', 47, '2014-04-24', 63, 90, 0, 0, 0, 0, 0, 0, 0, 106),
(1531, '2014-04-24', 63, '2014-04-25', 3, 170, 0, 0, 0, 0, 0, 0, 0, 106),
(1532, '2014-04-27', 3, '2014-04-27', 211, 1050, 0, 0, 1, 0, 0, 0, 0, 107),
(1533, '2014-04-28', 211, '2014-04-29', 18, 30, 1, 4, 0, 0, 0, 0, 0, 107),
(1534, '2014-04-30', 18, '2014-05-02', 62, 510, 0, 0, 1, 0, 0, 0, 0, 107),
(1535, '2014-05-03', 62, '2014-05-03', 3, 715, 0, 0, 0, 0, 0, 0, 0, 107),
(1536, '2014-05-05', 3, '2014-05-05', 55, 230, 1, 0, 0, 0, 0, 0, 0, 107),
(1537, '2014-05-05', 55, '2014-05-06', 190, 395, 0, 0, 0, 0, 0, 0, 0, 107),
(1538, '2014-05-06', 190, '2014-05-06', 3, 480, 0, 0, 0, 0, 0, 0, 0, 107),
(1539, '2014-05-07', 3, '2014-05-07', 4, 40, 0, 0, 1, 0, 0, 0, 0, 107),
(1540, '2014-05-07', 4, '2014-05-07', 5, 310, 1, 0, 1, 0, 0, 0, 0, 107),
(1541, '2014-05-08', 5, '2014-05-09', 2, 680, 0, 0, 0, 0, 0, 0, 0, 107),
(1542, '2014-05-09', 2, '2014-05-09', 3, 330, 0, 0, 0, 0, 0, 0, 0, 107),
(1543, '2014-05-12', 3, '2014-05-13', 5, 310, 1, 0, 1, 0, 0, 0, 0, 107),
(1544, '2014-05-13', 5, '2014-05-14', 3, 350, 1, 0, 1, 0, 0, 0, 0, 107),
(1545, '2014-05-15', 3, '2014-05-15', 1, 465, 0, 0, 0, 0, 0, 0, 0, 107),
(1546, '2014-05-17', 1, '2014-05-17', 3, 475, 0, 0, 0, 0, 0, 0, 0, 107),
(1547, '2014-05-18', 3, '2014-05-18', 21, 810, 0, 4, 1, 0, 0, 0, 0, 107),
(1548, '2014-05-19', 21, '2014-05-22', 12, 285, 0, 0, 0, 0, 0, 0, 0, 107),
(1549, '2014-05-23', 12, '2014-05-23', 21, 285, 1, 0, 0, 0, 0, 0, 0, 107),
(1550, '2014-05-23', 21, '2014-05-23', 22, 10, 0, 3, 1, 0, 0, 0, 0, 107),
(1551, '2014-05-26', 22, '2014-05-26', 62, 100, 0, 0, 0, 0, 0, 0, 0, 108),
(1552, '2014-05-27', 62, '2014-05-28', 3, 710, 0, 1, 0, 0, 0, 0, 0, 108),
(1553, '2014-05-29', 3, '2014-05-29', 32, 220, 1, 0, 0, 0, 0, 0, 0, 108),
(1554, '2014-05-29', 32, '2014-05-30', 107, 470, 0, 0, 0, 0, 0, 0, 0, 108),
(1555, '2014-05-31', 107, '2014-05-31', 3, 685, 0, 0, 0, 0, 0, 0, 0, 108),
(1556, '2014-06-01', 3, '2014-06-05', 211, 1040, 0, 5, 1, 0, 0, 0, 0, 108),
(1557, '2014-06-05', 211, '2014-06-05', 18, 40, 1, 0, 0, 0, 0, 0, 0, 108),
(1558, '2014-06-05', 18, '2014-06-06', 62, 480, 0, 0, 1, 0, 0, 0, 0, 108),
(1559, '2014-06-06', 62, '2014-06-07', 3, 710, 0, 0, 0, 0, 0, 0, 0, 108),
(1560, '2014-06-09', 3, '2014-06-09', 108, 280, 1, 0, 0, 0, 0, 0, 0, 108),
(1561, '2014-06-09', 108, '2014-06-10', 102, 1200, 0, 7, 0, 0, 0, 0, 0, 108),
(1562, '2014-06-16', 102, '2014-06-17', 3, 1300, 0, 0, 0, 0, 0, 0, 0, 108),
(1563, '2014-06-18', 3, '2014-06-19', 5, 365, 1, 0, 1, 0, 0, 0, 0, 108),
(1564, '2014-06-19', 5, '2014-06-19', 48, 310, 0, 0, 0, 0, 0, 0, 0, 108),
(1565, '2014-06-20', 48, '2014-06-20', 4, 120, 0, 0, 0, 0, 0, 0, 0, 108),
(1566, '2014-06-20', 4, '2014-06-20', 3, 35, 0, 2, 1, 0, 0, 0, 0, 108),
(1567, '2014-06-24', 3, '2014-06-26', 105, 900, 1, 1, 0, 0, 0, 0, 0, 109),
(1568, '2014-06-26', 105, '2014-06-26', 11, 600, 0, 0, 0, 0, 0, 0, 0, 109),
(1569, '2014-06-27', 11, '2014-06-27', 3, 300, 0, 0, 0, 0, 0, 0, 0, 109),
(1570, '2014-06-29', 3, '2014-06-29', 22, 800, 0, 0, 0, 0, 0, 0, 0, 109),
(1571, '2014-06-30', 22, '2014-07-02', 246, 45, 1, 3, 1, 0, 0, 0, 0, 109),
(1572, '2014-07-02', 246, '2014-07-02', 22, 45, 0, 0, 1, 0, 0, 0, 0, 109),
(1573, '2014-07-03', 22, '2014-07-03', 45, 90, 0, 0, 0, 0, 0, 0, 0, 109),
(1574, '2014-07-04', 45, '2014-07-05', 3, 1075, 0, 0, 0, 0, 0, 0, 0, 109),
(1575, '2014-07-07', 3, '2014-07-07', 55, 230, 1, 0, 0, 0, 0, 0, 0, 109),
(1576, '2014-07-07', 55, '2014-07-07', 39, 110, 0, 0, 0, 0, 0, 0, 0, 109),
(1577, '2014-07-08', 39, '2014-07-08', 3, 165, 0, 0, 0, 0, 0, 0, 0, 109),
(1578, '2014-07-09', 3, '2014-07-10', 5, 360, 1, 0, 1, 0, 0, 0, 0, 109),
(1579, '2014-07-10', 5, '2014-07-15', 3, 420, 0, 6, 1, 0, 0, 0, 0, 109),
(1580, '2014-07-15', 3, '2014-07-16', 36, 780, 1, 0, 0, 0, 0, 0, 0, 109),
(1581, '2014-07-16', 36, '2014-07-17', 31, 150, 0, 0, 0, 0, 0, 0, 0, 109),
(1582, '2014-07-17', 31, '2014-07-18', 3, 680, 0, 0, 0, 0, 0, 0, 0, 109),
(1583, '2014-07-21', 3, '2014-07-21', 43, 398, 0, 0, 1, 0, 0, 0, 0, 109),
(1584, '2014-07-22', 43, '2014-07-22', 48, 318, 1, 0, 0, 0, 0, 0, 0, 109),
(1585, '2014-07-23', 48, '2014-07-23', 3, 160, 0, 0, 1, 0, 0, 0, 0, 109),
(1586, '2014-07-24', 3, '2014-07-25', 7, 255, 0, 0, 0, 0, 0, 0, 0, 110),
(1587, '2014-07-25', 7, '2014-07-26', 105, 640, 1, 0, 0, 0, 0, 0, 0, 110),
(1588, '2014-07-26', 105, '2014-07-26', 39, 680, 0, 0, 0, 0, 0, 0, 0, 110),
(1589, '2014-07-29', 39, '2014-07-30', 4, 200, 0, 0, 1, 0, 0, 0, 0, 110),
(1590, '2014-07-31', 4, '2014-07-31', 19, 35, 0, 0, 0, 0, 0, 0, 0, 110),
(1591, '2014-07-31', 19, '2014-07-31', 3, 75, 1, 0, 1, 0, 0, 0, 0, 110),
(1592, '2014-08-02', 3, '2014-08-02', 27, 56, 0, 0, 0, 0, 0, 0, 0, 110),
(1593, '2014-08-02', 27, '2014-08-02', 3, 56, 0, 0, 0, 0, 0, 0, 0, 110),
(1594, '2014-08-03', 3, '2014-08-03', 22, 810, 0, 0, 0, 0, 0, 0, 0, 110),
(1595, '2014-08-04', 22, '2014-08-07', 96, 220, 0, 4, 1, 0, 0, 0, 0, 110),
(1596, '2014-08-07', 96, '2014-08-07', 21, 220, 0, 0, 1, 0, 0, 0, 0, 110),
(1597, '2014-08-09', 21, '2014-08-09', 62, 100, 0, 0, 0, 0, 0, 0, 0, 110),
(1598, '2014-08-09', 62, '2014-08-10', 3, 720, 0, 1, 0, 0, 0, 0, 0, 110),
(1599, '2014-08-11', 3, '2014-08-11', 55, 220, 1, 0, 0, 0, 0, 0, 0, 110),
(1600, '2014-08-11', 55, '2014-08-11', 39, 60, 0, 0, 0, 0, 0, 0, 0, 110),
(1601, '2014-08-13', 39, '2014-08-13', 3, 170, 0, 0, 0, 0, 0, 0, 0, 110),
(1602, '2014-08-14', 3, '2014-08-15', 95, 415, 0, 2, 1, 0, 0, 0, 0, 110),
(1603, '2014-08-15', 95, '2014-08-15', 3, 310, 1, 0, 1, 0, 0, 0, 0, 110),
(1604, '2014-08-20', 3, '2014-08-20', 9, 310, 0, 0, 0, 0, 0, 0, 0, 110),
(1605, '2014-08-20', 9, '2014-08-20', 3, 305, 0, 0, 0, 0, 0, 0, 0, 110),
(1606, '2014-08-21', 3, '2014-08-21', 19, 70, 1, 0, 1, 0, 0, 0, 0, 110),
(1607, '2014-08-21', 19, '2014-08-21', 3, 70, 0, 0, 1, 0, 0, 0, 0, 110),
(1608, '2014-08-25', 3, '2014-08-25', 16, 140, 0, 0, 0, 0, 0, 0, 0, 111),
(1609, '2014-08-25', 16, '2014-08-25', 3, 140, 0, 0, 0, 0, 0, 0, 0, 111),
(1610, '2014-08-26', 3, '2014-08-26', 4, 37, 0, 0, 1, 0, 0, 0, 0, 111),
(1611, '2014-08-26', 4, '2014-08-26', 88, 150, 0, 0, 0, 0, 0, 0, 0, 111),
(1612, '2014-08-27', 88, '2014-08-28', 3, 170, 1, 1, 1, 0, 0, 0, 0, 111),
(1613, '2014-08-30', 3, '2014-09-01', 5, 330, 0, 0, 1, 0, 0, 0, 0, 111),
(1614, '2014-09-01', 5, '2014-09-02', 3, 330, 0, 2, 1, 0, 0, 0, 0, 111),
(1615, '2014-09-03', 3, '2014-09-03', 10, 270, 0, 0, 0, 0, 0, 0, 0, 111),
(1616, '2014-09-03', 10, '2014-09-03', 3, 270, 0, 1, 0, 0, 0, 0, 0, 111),
(1617, '2014-09-04', 3, '2014-09-04', 4, 38, 0, 0, 1, 0, 0, 0, 0, 111),
(1618, '2014-09-04', 4, '2014-09-04', 5, 310, 0, 0, 0, 0, 0, 0, 0, 111),
(1619, '2014-09-06', 5, '2014-09-06', 3, 350, 1, 0, 1, 0, 0, 0, 0, 111),
(1620, '2014-09-10', 3, '2014-09-11', 53, 360, 0, 0, 0, 0, 0, 0, 0, 111),
(1621, '2014-09-11', 53, '2014-09-12', 3, 360, 0, 0, 0, 0, 0, 0, 0, 111),
(1622, '2014-09-14', 3, '2014-09-15', 21, 812, 0, 0, 1, 0, 0, 0, 0, 111),
(1623, '2014-09-16', 21, '2014-09-17', 12, 285, 1, 0, 0, 0, 0, 0, 0, 111),
(1624, '2014-09-17', 12, '2014-09-17', 62, 480, 0, 4, 1, 0, 0, 0, 0, 111),
(1625, '2014-09-17', 62, '2014-09-19', 67, 990, 0, 0, 0, 0, 0, 0, 0, 111),
(1626, '2014-09-19', 67, '2014-09-24', 9, 240, 0, 0, 0, 0, 0, 0, 0, 111),
(1627, '2014-09-24', 9, '2014-09-24', 3, 300, 0, 0, 0, 0, 0, 0, 0, 111),
(1628, '2014-09-25', 3, '2014-09-26', 211, 1045, 0, 4, 1, 0, 0, 0, 0, 112),
(1629, '2014-10-03', 211, '2014-10-04', 141, 460, 1, 4, 0, 0, 0, 0, 0, 112),
(1630, '2014-10-04', 141, '2014-10-04', 21, 50, 0, 2, 1, 0, 0, 0, 0, 112),
(1631, '2014-10-06', 21, '2014-10-07', 174, 215, 0, 1, 0, 0, 0, 0, 0, 112),
(1632, '2014-10-07', 174, '2014-10-08', 159, 430, 1, 0, 0, 0, 0, 0, 0, 112),
(1633, '2014-10-08', 159, '2014-10-10', 3, 270, 0, 0, 0, 0, 0, 0, 0, 112),
(1634, '2014-10-10', 3, '2014-10-10', 10, 280, 0, 0, 0, 0, 0, 0, 0, 112),
(1635, '2014-10-11', 10, '2014-10-11', 3, 280, 0, 0, 0, 0, 0, 0, 0, 112),
(1636, '2014-10-14', 3, '2014-10-14', 4, 37, 0, 0, 1, 0, 0, 0, 0, 112),
(1637, '2014-10-15', 4, '2014-10-15', 6, 95, 1, 0, 1, 0, 0, 0, 0, 112),
(1638, '2014-10-16', 6, '2014-10-16', 3, 130, 0, 0, 0, 0, 0, 0, 0, 112),
(1639, '2014-10-17', 3, '2014-10-17', 16, 180, 0, 0, 0, 0, 0, 0, 0, 112),
(1640, '2014-10-17', 16, '2014-10-17', 3, 197, 0, 0, 0, 0, 0, 0, 0, 112),
(1641, '2014-10-18', 3, '2014-10-18', 4, 37, 0, 0, 1, 0, 0, 0, 0, 112),
(1642, '2014-10-20', 4, '2014-10-20', 135, 200, 1, 0, 0, 0, 0, 0, 0, 112),
(1643, '2014-10-21', 135, '2014-10-21', 164, 105, 0, 0, 0, 0, 0, 0, 0, 112),
(1644, '2014-10-21', 164, '2014-10-23', 4, 185, 0, 3, 0, 0, 0, 0, 0, 112),
(1645, '2014-10-23', 4, '2014-10-24', 3, 37, 1, 0, 1, 0, 0, 0, 0, 112),
(1646, '2014-10-27', 3, '2014-10-27', 7, 330, 1, 0, 0, 0, 0, 0, 0, 113),
(1647, '2014-10-28', 7, '2014-10-29', 168, 270, 0, 0, 0, 0, 0, 0, 0, 113),
(1648, '2014-10-29', 168, '2014-10-29', 53, 60, 0, 0, 0, 0, 0, 0, 0, 113),
(1649, '2014-10-29', 53, '2014-10-29', 3, 350, 0, 0, 0, 0, 0, 0, 0, 113),
(1650, '2014-11-02', 3, '2014-11-03', 211, 1035, 0, 0, 1, 0, 0, 0, 0, 113),
(1651, '2014-11-06', 211, '2014-11-06', 167, 290, 1, 0, 0, 0, 0, 0, 0, 113),
(1652, '2014-11-08', 167, '2014-11-10', 62, 610, 0, 7, 1, 0, 0, 0, 0, 113),
(1653, '2014-11-11', 62, '2014-11-11', 3, 710, 0, 0, 0, 0, 0, 0, 0, 113),
(1654, '2014-11-11', 3, '2014-11-11', 32, 230, 0, 0, 0, 0, 0, 0, 0, 113),
(1655, '2014-11-11', 32, '2014-11-11', 3, 230, 0, 0, 0, 0, 0, 0, 0, 113),
(1656, '2014-11-18', 3, '2014-11-18', 174, 325, 0, 0, 0, 0, 0, 0, 0, 113);
INSERT INTO `planillakmdetalle` (`idPlanillaKmDetalle`, `fechaSalida`, `lugarSalida`, `fechaLlegada`, `lugarLlegada`, `kilometrosRecorridos`, `controlDescarga`, `simplePresencia`, `cruceFrontera`, `kilometrosRecorridos120`, `kilometrosRecorridos140`, `idUt`, `viajaVacio`, `idPlanillaKmCabecera`) VALUES
(1657, '2014-11-19', 174, '2014-11-20', 3, 455, 0, 0, 0, 0, 0, 0, 0, 113),
(1658, '2014-11-20', 3, '2014-11-21', 5, 320, 0, 0, 1, 0, 0, 0, 0, 113),
(1659, '2014-11-21', 5, '2014-11-21', 242, 210, 1, 2, 0, 0, 0, 0, 0, 113),
(1660, '2014-11-24', 242, '2014-11-24', 5, 215, 0, 0, 0, 0, 0, 0, 0, 113),
(1661, '2014-11-25', 5, '2014-11-26', 3, 370, 0, 0, 1, 0, 0, 0, 0, 113),
(1662, '2014-11-27', 3, '2014-11-27', 19, 270, 1, 0, 0, 0, 0, 0, 0, 114),
(1663, '2014-11-27', 19, '2014-11-27', 63, 120, 0, 0, 0, 0, 0, 0, 0, 114),
(1664, '2014-12-01', 63, '2014-12-01', 20, 154, 0, 0, 0, 0, 0, 0, 0, 114),
(1665, '2014-12-01', 20, '2014-12-01', 3, 317, 0, 0, 0, 0, 0, 0, 0, 114),
(1666, '2014-12-02', 3, '2014-12-02', 4, 37, 0, 0, 1, 0, 0, 0, 0, 114),
(1667, '2014-12-03', 4, '2014-12-03', 5, 330, 0, 2, 0, 0, 0, 0, 0, 114),
(1668, '2014-12-03', 5, '2014-12-04', 3, 360, 0, 0, 1, 0, 0, 0, 0, 114),
(1669, '2014-12-17', 3, '2014-12-17', 1, 460, 0, 0, 0, 0, 0, 0, 0, 114),
(1670, '2014-12-18', 1, '2014-12-18', 3, 460, 0, 0, 0, 0, 0, 0, 0, 114),
(1671, '2014-12-18', 3, '2014-12-19', 5, 360, 0, 1, 1, 0, 0, 0, 0, 114),
(1672, '2014-12-23', 5, '2014-12-23', 3, 360, 1, 0, 1, 0, 0, 0, 0, 114);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `porcentajes-iva`
--

CREATE TABLE IF NOT EXISTS `porcentajes-iva` (
  `idPorcentajeIva` int(11) NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(11) NOT NULL,
  `valor` varchar(11) NOT NULL,
  PRIMARY KEY (`idPorcentajeIva`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `porcentajes-iva`
--

INSERT INTO `porcentajes-iva` (`idPorcentajeIva`, `denominacion`, `valor`) VALUES
(1, '21%', '0.21'),
(2, '10%', '0.10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `provincias`
--

CREATE TABLE IF NOT EXISTS `provincias` (
  `idProvincia` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `idPais` int(10) unsigned NOT NULL,
  `denominacion` varchar(255) NOT NULL,
  `denominacionCorta` varchar(255) NOT NULL,
  PRIMARY KEY (`idProvincia`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Volcado de datos para la tabla `provincias`
--

INSERT INTO `provincias` (`idProvincia`, `idPais`, `denominacion`, `denominacionCorta`) VALUES
(1, 1, 'Buenos Aires', 'Bue'),
(2, 1, 'Santa Fe', 'Sta Fe'),
(3, 1, 'Cordoba', 'Cba'),
(4, 1, 'Misiones', 'Mis'),
(5, 1, 'Entre Rios', 'ER'),
(6, 1, 'Salta', 'Salt'),
(7, 1, 'Jujuy', 'Juy'),
(8, 1, 'Corrientes', 'Corr'),
(9, 1, 'Chaco', 'Cha'),
(10, 1, 'La Pampa', 'Lpam'),
(11, 1, 'Mendoza', 'Men'),
(12, 2, 'Rio Negro', 'RNuy'),
(13, 2, 'Montevideo', 'Mont'),
(14, 3, 'Alto Parana', 'Alt Para'),
(15, 3, 'Central', 'Central'),
(16, 2, 'Soriano', 'Sor'),
(17, 2, 'Colonia', 'Col'),
(18, 1, 'Ciudad de Buenos Aires', 'CABA'),
(19, 1, 'Formosa', 'For'),
(20, 1, 'Tucuman', 'Tuc'),
(21, 1, 'La Rioja', 'Rioja'),
(22, 2, 'S/D', 'S/D');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rubro-cuentas`
--

CREATE TABLE IF NOT EXISTS `rubro-cuentas` (
  `Id_RubroCuentas` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rubroCuentas` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_RubroCuentas`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `rubro-cuentas`
--

INSERT INTO `rubro-cuentas` (`Id_RubroCuentas`, `rubroCuentas`) VALUES
(1, 'rubro prueba'),
(3, 'rubro 3'),
(4, 'Gastos'),
(5, 'Medio de pago');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `saldo`
--

CREATE TABLE IF NOT EXISTS `saldo` (
  `Id_saldo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saldo` varchar(10) NOT NULL,
  PRIMARY KEY (`Id_saldo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `saldo`
--

INSERT INTO `saldo` (`Id_saldo`, `saldo`) VALUES
(1, 'acreedor'),
(2, 'deudor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sociedades`
--

CREATE TABLE IF NOT EXISTS `sociedades` (
  `idSociedad` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idSociedad`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `sociedades`
--

INSERT INTO `sociedades` (`idSociedad`, `denominacion`) VALUES
(1, 'Sixco S.A.'),
(2, 'Noro S.A.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `terceros`
--

CREATE TABLE IF NOT EXISTS `terceros` (
  `idTercero` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) DEFAULT NULL,
  `denominacionCorta` varchar(255) DEFAULT NULL,
  `clave` varchar(255) DEFAULT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `piso` varchar(255) DEFAULT NULL,
  `departamento` varchar(255) DEFAULT NULL,
  `codigoPostal` varchar(255) DEFAULT NULL,
  `idPais` int(10) unsigned DEFAULT NULL,
  `idProvincia` int(10) unsigned DEFAULT NULL,
  `idCiudad` int(10) unsigned DEFAULT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `eMail` varchar(255) DEFAULT NULL,
  `idTipoTercero` int(10) unsigned DEFAULT NULL,
  `idCondicionIVA` int(10) unsigned DEFAULT NULL,
  `archivoEstatuto` varchar(255) DEFAULT NULL,
  `archivoInscripcionAFIP` varchar(255) DEFAULT NULL,
  `archivoInscripcionIIBB` varchar(255) DEFAULT NULL,
  `archivoAsambleaRenovacionCargos` varchar(255) DEFAULT NULL,
  `archivoRUTA` varchar(255) DEFAULT NULL,
  `archivoAdjunto1` varchar(255) DEFAULT NULL,
  `archivoAdjunto2` varchar(255) DEFAULT NULL,
  `archivoAdjunto3` varchar(255) DEFAULT NULL,
  `archivoAdjunto4` varchar(255) DEFAULT NULL,
  `archivoAdjunto5` varchar(255) DEFAULT NULL,
  `archivoAdjunto6` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idTercero`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Volcado de datos para la tabla `terceros`
--

INSERT INTO `terceros` (`idTercero`, `denominacion`, `denominacionCorta`, `clave`, `calle`, `numero`, `piso`, `departamento`, `codigoPostal`, `idPais`, `idProvincia`, `idCiudad`, `telefono`, `eMail`, `idTipoTercero`, `idCondicionIVA`, `archivoEstatuto`, `archivoInscripcionAFIP`, `archivoInscripcionIIBB`, `archivoAsambleaRenovacionCargos`, `archivoRUTA`, `archivoAdjunto1`, `archivoAdjunto2`, `archivoAdjunto3`, `archivoAdjunto4`, `archivoAdjunto5`, `archivoAdjunto6`) VALUES
(3, 'Nidera S.A.', 'Nasa', '33-50673744-9', 'Paseo Colon', '505', '4', NULL, '1063', 1, 18, 7, '43468001', NULL, 1, 1, NULL, NULL, 'BLED112.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'Alejandro Stano', 'AS', '28-508384-3', 'Paracaidista Picasso', '2558', NULL, NULL, '1684', 1, 1, NULL, '1549738696', 'astano@sixco.com.ar', 5, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'Sixco S.A.', 'Sixco', '33-71086910-9', 'Av. Santa Fe', '1877', '3', 'F', '1123', 1, 18, 7, NULL, 'leandromusso@gmail.com', 4, 1, NULL, NULL, NULL, NULL, NULL, 'logosixco.jpg', NULL, NULL, NULL, NULL, NULL),
(6, 'Demarchi Horacio', 'Demar', '20-14322274-9', 'Austria', '1724', NULL, NULL, NULL, 1, 18, 7, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'Rebora Jose Antonio', 'Rebora', '20-25660809-0', 'Gualeguay', '95', NULL, NULL, NULL, 1, 5, 3, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Remezzano Jose Santiago Ramon', 'Reme', '11950515', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626314', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'Dequimpe Paulino Enrique', 'Dequim P', '27599632', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626315', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'Demarchi Natalio Horacio', 'Demarc', '33317568|', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626316', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'Gil Ricardo Omar', 'Gil', '20-20813711-6', 'Peatonal A', '332', NULL, NULL, '3260', 1, 5, 34, '03442-15649487', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 'Rodriguez Hector Ramon', 'Rodriguez', '23-12385059-9', 'San Luis', NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15609323', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 'Falle Angel Alfredo', 'Falle', '24596593', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15610798', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 'Berisso Nestor Daniel', 'Berisso', '31434617', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626311', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(15, 'Gershanik Gaston Ruben', 'Gershanik', '31112880', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15611670', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, 'Sandoval Nestor Fabian', 'Sando', '20-25018774-3', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15405422', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 'Vega Gabriel Ramon', 'Vega', '25342323', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626312', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'Aguirre Walter Federico', 'Aguirre', '20-30406784-6', 'Posadas', '1412', NULL, NULL, '3260', 1, 5, 34, '03442-15587863', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'Santamarina Francisco', 'Santam', '25711340', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15407614', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'Transporte Noro S.A.', 'Noro', '30-71401965-8', 'Av. Santa Fe', '1877', '3', 'F', '1123', 1, 18, 7, NULL, NULL, 4, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'Sambon Andres Miguel', 'Sambon', '20-31567278-4', 'Bvard. 2 de Abril', '1947', NULL, NULL, '2820', 1, 5, 3, '03446-15535329', NULL, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'Sixco S.A.', 'Sixco', '33-71086910-9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'Sursem S.A.', 'Srm', '30-63209020-6', 'Ruta 32 Km 2', NULL, NULL, NULL, NULL, 1, 1, 20, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, 'Transporte Noro S.A.', 'Noro', '30-71401965-8', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'Benetti Guillermo', 'Bene', '24596116', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15417877', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'Perez Guillermo Javier', 'Perez', '20-22616717-0', 'Barrio Manuel Alarcón Manzana 5 Casa 5', NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15524186', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'Alfalfares S.A.', 'Alfaf', '30-64708403-2', 'Lavallle', '843', NULL, NULL, '1648', 1, 1, 32, '4731-4040', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, 'Rebora Jose Antonio', 'Rebora2', '25660809', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15407612', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'Ojeda Osvaldo Arturo', 'Ojeda', '20-12385624-5', 'Cafferatta', '278', NULL, NULL, '2820', 1, 5, 3, '03446-15646235', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'Camera Marcelo Esteban', 'Camera', '20-25018784-0', '3 de Caballería', '1770', NULL, NULL, '2820', 1, 5, 3, '03446-15574913', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'Dequimpe Diego Damian', 'Dequim P', '33.318.752', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626306', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'Lizzi Angel Alberto', 'Lizzi', '20243619', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15314041', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'Correa Dario Alberto', 'Correa', '27272929', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, '03446-15641475', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'Zubacoff Hernan', 'Zub', '20568673', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, '011-1554614527', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'Sosa Jorge', 'Sosa', '13816567', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'Avila Fabian Rene', 'Avila', '17000096', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 'Peralta Dante Ramon', 'Peralta', '17549083', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'Olivera Luis Omar', 'Oliver', '17534295', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'Ludueña Pablo', 'Ludueña', '25289868', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 'Leiguarda Francisco', 'Lei', '18177223', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'Carrion Carlos Hector', 'Carr', '28429655', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'Dos Santos Pablo Rene', 'Dos', '31513605', NULL, NULL, NULL, NULL, NULL, 1, 4, NULL, '03755-15545585', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'Kolmaier Gerardo Enrique', 'Kolm', '11904048', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '03754-15498018', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'Nolasco Diego Maximiliano', 'Nola', '34734614', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '03754-15498015', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'Vitasse Yamil Rene', 'Vita', '29157759', NULL, NULL, NULL, NULL, NULL, 1, 5, 34, '03442-15520073', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Sauer Jonathan Ezequiel', 'Saue', '32502934', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, '0376-154669388', NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Henscheid Alberto Marcelo', 'Hens', '21426751', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Larrosa Omar', 'Larr', '16465544', NULL, NULL, NULL, NULL, '2820', 1, 5, 3, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Aserradero Panamericano SACIA', 'As Pana', '30-55968713-4', 'Ruta 9 Km 40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'Aserradero Romano SRL', 'Ase Roma', '30-69638268-5', 'Av. Vergara', '3550', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'Asimet SRL', 'Asimet', '30-71089651-4', 'Arevalo', '3464', NULL, NULL, '16417', 1, 1, 35, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'C.H. Robinson W. ARG. S.A.', 'CHR', '30-62334729-6', 'Maipu', '1252', '11', NULL, '1006', 1, 18, 7, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'E.T.M. Internacional S.R.L.', 'ETM', '30-70904872-0', 'Av. Belgrano', '615', '1', 'j', NULL, 1, 18, 7, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'ITLS S.A.', 'ITLS', '30-7118622-7', NULL, NULL, NULL, NULL, NULL, 1, 2, 13, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'ITLS S.A.', 'ITLS', '30-7118622-7', NULL, NULL, NULL, NULL, NULL, 1, 2, 13, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'KWS Argentina S.A.', 'KWS', '30-59821885-0', NULL, NULL, NULL, NULL, NULL, 1, 1, 30, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'La Paraguaya Internacional S.R.L.', 'Paraguaya', '80007926-4', 'Av. Fdo. de la Mora y Rpa. Argentina', NULL, NULL, NULL, NULL, 3, 15, 18, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Madera', 'Madera', '00-00000000-0', NULL, NULL, NULL, NULL, NULL, 1, 8, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'Operaciones, Logistica & Servicios Especiales', 'Oper esp', '33-71152047-9', 'In.g. Huergo', '1708', NULL, NULL, '2400', 1, 3, 36, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Pepsico S.A.', 'Pepsico', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'RPB S.A.', 'RPB', '30-66313737-5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Sissa Materiales S.A.', 'Sissa', '30-71229804-5', 'Libertad', '5856', NULL, NULL, NULL, 1, 18, 7, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Tecnopallets SRL', 'Tecpall', '30-71056281-0', 'Ruta 14 Km 755', NULL, NULL, NULL, NULL, 1, 8, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Tomol SRL', 'Tomol', '33-70879903-9', 'El Salvador', '565', NULL, NULL, NULL, 1, 8, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Viveros del Este SRL', 'VVeste', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Zubacoff SRL', 'Zub', '30-66143392-9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Zubacoff SRL', 'Zub', '30-66143392-9', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Transporte Elois SRL', 'Elois', '30-70951564-7', NULL, NULL, NULL, NULL, NULL, 1, 5, 34, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Manderly S.A.', 'Mander', '30-66120926-3', NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Transporte Rigatosso', 'Rigatosso', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Lauman Jorge', 'Lauman', '20620900', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Rodriguez Hugo', 'RoHugo', '25025798', NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Marcelo Ferreyra', 'Mferreyra', NULL, NULL, NULL, NULL, NULL, NULL, 1, 4, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Rodriguez Maria Agustina', 'RodriMaria', '5000000016', NULL, NULL, NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Boer S.A.', 'Boer', '21-471836-0012', 'Avda. Gral. Flores', '3457', NULL, NULL, NULL, 2, 13, 5, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Paravac SRL', 'Paravac', '80078606', 'Peru casi artigas', '1044', NULL, NULL, NULL, 3, 15, 18, NULL, NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Demarchi Natalio Horacio', 'Demarc', '33317568|', NULL, NULL, NULL, NULL, NULL, 1, 5, 33, '03444-15626316', NULL, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 'Rotor SRL', 'Rotor', '30-70844084-8', 'Ruta Nacional 9', '426.5', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 'leandro', 'lm', '234234', 'asd', '234', '3', 'l2', '234', 1, 1, 67, '234', 'leandro@trama.solutions', 6, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo-documento`
--

CREATE TABLE IF NOT EXISTS `tipo-documento` (
  `Id_tipoDocumento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipoDocumento` varchar(10) NOT NULL,
  PRIMARY KEY (`Id_tipoDocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipo-documento`
--

INSERT INTO `tipo-documento` (`Id_tipoDocumento`, `tipoDocumento`) VALUES
(1, 'original'),
(2, 'duplicado'),
(3, 'triplicado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo-gasto`
--

CREATE TABLE IF NOT EXISTS `tipo-gasto` (
  `Id_TipoGasto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saldoCuenta` tinyint(3) unsigned NOT NULL,
  `tipoGasto` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_TipoGasto`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `tipo-gasto`
--

INSERT INTO `tipo-gasto` (`Id_TipoGasto`, `saldoCuenta`, `tipoGasto`) VALUES
(1, 1, 'activo'),
(2, 2, 'pasivo'),
(5, 2, 'patrimonio neto'),
(6, 3, 'resultado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo-movimiento`
--

CREATE TABLE IF NOT EXISTS `tipo-movimiento` (
  `Id_TipoMovimiento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipoMovimiento` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_TipoMovimiento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipo-movimiento`
--

INSERT INTO `tipo-movimiento` (`Id_TipoMovimiento`, `tipoMovimiento`) VALUES
(1, 'ingreso'),
(2, 'egreso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos-documentos`
--

CREATE TABLE IF NOT EXISTS `tipos-documentos` (
  `idTipoDocumento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `letra` varchar(255) NOT NULL,
  PRIMARY KEY (`idTipoDocumento`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos-documentos`
--

INSERT INTO `tipos-documentos` (`idTipoDocumento`, `letra`) VALUES
(1, 'f'),
(2, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos-operaciones`
--

CREATE TABLE IF NOT EXISTS `tipos-operaciones` (
  `idTipoOperacion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  `denominacionCorta` varchar(255) NOT NULL,
  `idGrupo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idTipoOperacion`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos-propietarios`
--

CREATE TABLE IF NOT EXISTS `tipos-propietarios` (
  `idTipoPropietario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idTipoPropietario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `tipos-propietarios`
--

INSERT INTO `tipos-propietarios` (`idTipoPropietario`, `denominacion`) VALUES
(1, 'Propio'),
(2, 'Tercero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos-terceros`
--

CREATE TABLE IF NOT EXISTS `tipos-terceros` (
  `idTipoTercero` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idTipoTercero`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `tipos-terceros`
--

INSERT INTO `tipos-terceros` (`idTipoTercero`, `denominacion`) VALUES
(1, 'Cliente'),
(2, 'Proveedor'),
(3, 'Chofer'),
(4, 'Grupo'),
(5, 'Empleado'),
(6, 'Combustible'),
(7, 'Chofer Propio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos-ut`
--

CREATE TABLE IF NOT EXISTS `tipos-ut` (
  `idTipoUT` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idTipoUT`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `tipos-ut`
--

INSERT INTO `tipos-ut` (`idTipoUT`, `denominacion`) VALUES
(1, 'Nacional'),
(2, 'Internacional'),
(3, 'Vacio');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos-vehiculos`
--

CREATE TABLE IF NOT EXISTS `tipos-vehiculos` (
  `idTipoVehiculo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(255) NOT NULL,
  PRIMARY KEY (`idTipoVehiculo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `tipos-vehiculos`
--

INSERT INTO `tipos-vehiculos` (`idTipoVehiculo`, `denominacion`) VALUES
(1, 'Tractor'),
(2, 'Semiremolque'),
(3, 'Chasis'),
(4, 'Acoplado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transacciones`
--

CREATE TABLE IF NOT EXISTS `transacciones` (
  `idTransaccion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fechaTransaccion` date DEFAULT NULL,
  `idSociedadFacturacion` int(10) unsigned DEFAULT NULL,
  `fechaDocumento` date DEFAULT NULL,
  `idTercero` int(10) unsigned DEFAULT NULL,
  `numeroDocumento` int(10) unsigned DEFAULT NULL,
  `idTipoDocumento` int(10) unsigned DEFAULT NULL,
  `tipoMovimiento` char(1) DEFAULT NULL,
  `tipoGasto` char(1) DEFAULT NULL,
  `idSubcuentaContable` int(10) unsigned DEFAULT NULL,
  `saldoContable` char(1) DEFAULT NULL,
  `detalleGasto` varchar(255) DEFAULT NULL,
  `idMoneda` int(10) unsigned DEFAULT NULL,
  `tipoCambio` float unsigned DEFAULT NULL,
  `cantidad` float unsigned DEFAULT NULL,
  `precioUnitario` float unsigned DEFAULT NULL,
  `iva` float unsigned DEFAULT NULL,
  `gravado` float unsigned DEFAULT NULL,
  `montoIVA` float unsigned DEFAULT NULL,
  `sinGravar` float unsigned DEFAULT NULL,
  `retencionPercepcion` float unsigned DEFAULT NULL,
  `montoNeto` float unsigned DEFAULT NULL,
  `montoTotal` float unsigned DEFAULT NULL,
  `pagoCobro` varchar(255) DEFAULT NULL,
  `verificadoInterna` tinyint(3) unsigned DEFAULT NULL,
  `verificadoExterna` tinyint(3) unsigned DEFAULT NULL,
  `cierraIVA` tinyint(3) unsigned DEFAULT NULL,
  `mesIVA` int(10) unsigned DEFAULT NULL,
  `anioIVA` int(10) unsigned DEFAULT NULL,
  `idProvincia` int(10) unsigned DEFAULT NULL,
  `cierreIIBB` tinyint(3) unsigned DEFAULT NULL,
  `operacionComercial` int(10) unsigned DEFAULT NULL,
  `grupo` int(10) unsigned DEFAULT NULL,
  `fechaCaja` date DEFAULT NULL,
  `trIVA` tinyint(3) unsigned DEFAULT NULL,
  `adjunto` varchar(255) DEFAULT NULL,
  `mesLiquidacion` tinyint(3) unsigned DEFAULT NULL,
  `anioLiquidacion` tinyint(3) unsigned DEFAULT NULL,
  `idUnidadTrabajo` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`idTransaccion`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `transacciones`
--

INSERT INTO `transacciones` (`idTransaccion`, `fechaTransaccion`, `idSociedadFacturacion`, `fechaDocumento`, `idTercero`, `numeroDocumento`, `idTipoDocumento`, `tipoMovimiento`, `tipoGasto`, `idSubcuentaContable`, `saldoContable`, `detalleGasto`, `idMoneda`, `tipoCambio`, `cantidad`, `precioUnitario`, `iva`, `gravado`, `montoIVA`, `sinGravar`, `retencionPercepcion`, `montoNeto`, `montoTotal`, `pagoCobro`, `verificadoInterna`, `verificadoExterna`, `cierraIVA`, `mesIVA`, `anioIVA`, `idProvincia`, `cierreIIBB`, `operacionComercial`, `grupo`, `fechaCaja`, `trIVA`, `adjunto`, `mesLiquidacion`, `anioLiquidacion`, `idUnidadTrabajo`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades-trabajo`
--

CREATE TABLE IF NOT EXISTS `unidades-trabajo` (
  `idUnidadTrabajo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fechaAlta` date DEFAULT NULL,
  `idUsuarioAlta` int(10) unsigned DEFAULT NULL,
  `codigoUT` varchar(255) DEFAULT NULL,
  `idTerceroSociedad` int(10) unsigned DEFAULT NULL,
  `viaje` varchar(255) DEFAULT NULL,
  `fechaCarga` date DEFAULT NULL,
  `fechaFronteraI` date DEFAULT NULL,
  `fechaFronteraE` date DEFAULT NULL,
  `fechaDescarga` date DEFAULT NULL,
  `idPais` int(10) unsigned DEFAULT NULL,
  `idEstadoUT` int(10) unsigned DEFAULT NULL,
  `idTipoUT` int(10) unsigned DEFAULT NULL,
  `facturaCliente` varchar(255) DEFAULT NULL,
  `recorrido` tinyint(1) DEFAULT NULL,
  `idProvincia` int(10) unsigned DEFAULT NULL,
  `idCiudadOrigen` int(10) unsigned DEFAULT NULL,
  `idCiudadR1` int(10) unsigned DEFAULT NULL,
  `idCiudadR2` int(10) unsigned DEFAULT NULL,
  `idCiudadDestino` int(10) unsigned DEFAULT NULL,
  `idTerceroChofer` int(10) unsigned DEFAULT NULL,
  `idDominioTractor` int(10) unsigned DEFAULT NULL,
  `idDominioSemi` int(10) unsigned DEFAULT NULL,
  `idTerceroTransporte` int(10) unsigned DEFAULT NULL,
  `remito` varchar(255) DEFAULT NULL,
  `CRT` varchar(255) DEFAULT NULL,
  `MICDTA` varchar(255) DEFAULT NULL,
  `productos` varchar(255) DEFAULT NULL,
  `idTipoOperacion` int(10) unsigned DEFAULT NULL,
  `datos1` int(11) DEFAULT NULL,
  `datos2` tinyint(1) DEFAULT NULL,
  `datos3` tinyint(1) DEFAULT NULL,
  `datos4` tinyint(1) DEFAULT NULL,
  `datos5` int(11) DEFAULT NULL,
  `datos6` int(11) DEFAULT NULL,
  `viajeLiquidado` tinyint(1) DEFAULT NULL,
  `idTerceroFacturacion` int(10) unsigned DEFAULT NULL,
  `diasDemora` int(10) unsigned DEFAULT NULL,
  `facturacion` tinyint(1) DEFAULT NULL,
  `idListaPrecio` int(10) unsigned DEFAULT NULL,
  `utCerrado` tinyint(1) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `tags` text,
  `monCompra` int(10) unsigned DEFAULT NULL,
  `valorCompraNac` varchar(255) DEFAULT '0',
  `factCompraNac` varchar(255) DEFAULT NULL,
  `valorCompraInt` varchar(255) DEFAULT '0',
  `factCompraInt` varchar(255) DEFAULT NULL,
  `monVenta` int(10) unsigned DEFAULT NULL,
  `factVentaNac` varchar(255) DEFAULT NULL,
  `valorVentaNac` varchar(255) DEFAULT '0',
  `factVentaInt` varchar(255) DEFAULT NULL,
  `valorVentaInt` varchar(255) DEFAULT '0',
  `archivoFacturaCliente` varchar(255) DEFAULT NULL,
  `archivoRemito` varchar(255) DEFAULT NULL,
  `archivoCRT` varchar(255) DEFAULT NULL,
  `archivoMICDTA` varchar(255) DEFAULT NULL,
  `direccionCarga` varchar(255) DEFAULT NULL,
  `direccionDescarga` varchar(255) DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `idTerceroShipper` varchar(255) DEFAULT NULL,
  `valorReferenciaFacturacion` float unsigned DEFAULT NULL,
  `idMonedaReferenciaFacturacion` int(10) unsigned DEFAULT NULL,
  `valorDemora` varchar(255) DEFAULT NULL,
  `facturaDemoraProv` varchar(255) DEFAULT NULL,
  `valorFactDemora` varchar(255) DEFAULT NULL,
  `facturaDemoraCliente` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idUnidadTrabajo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

--
-- Volcado de datos para la tabla `unidades-trabajo`
--

INSERT INTO `unidades-trabajo` (`idUnidadTrabajo`, `fechaAlta`, `idUsuarioAlta`, `codigoUT`, `idTerceroSociedad`, `viaje`, `fechaCarga`, `fechaFronteraI`, `fechaFronteraE`, `fechaDescarga`, `idPais`, `idEstadoUT`, `idTipoUT`, `facturaCliente`, `recorrido`, `idProvincia`, `idCiudadOrigen`, `idCiudadR1`, `idCiudadR2`, `idCiudadDestino`, `idTerceroChofer`, `idDominioTractor`, `idDominioSemi`, `idTerceroTransporte`, `remito`, `CRT`, `MICDTA`, `productos`, `idTipoOperacion`, `datos1`, `datos2`, `datos3`, `datos4`, `datos5`, `datos6`, `viajeLiquidado`, `idTerceroFacturacion`, `diasDemora`, `facturacion`, `idListaPrecio`, `utCerrado`, `cantidad`, `tags`, `monCompra`, `valorCompraNac`, `factCompraNac`, `valorCompraInt`, `factCompraInt`, `monVenta`, `factVentaNac`, `valorVentaNac`, `factVentaInt`, `valorVentaInt`, `archivoFacturaCliente`, `archivoRemito`, `archivoCRT`, `archivoMICDTA`, `direccionCarga`, `direccionDescarga`, `observaciones`, `idTerceroShipper`, `valorReferenciaFacturacion`, `idMonedaReferenciaFacturacion`, `valorDemora`, `facturaDemoraProv`, `valorFactDemora`, `facturaDemoraCliente`) VALUES
(18, NULL, NULL, 'Nasa.2.15.03.17', 3, '2', '2015-03-17', '2014-04-14', '2014-04-14', '2014-04-15', 2, 4, 1, '73158', 0, 2, 8, NULL, NULL, 6, 8, 2, 3, 6, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'DescargadoNidera S.A. Nasa Uruguay Uy Descargado Internacional Santa Fe Sta Fe Horreos Horreos     Young Young Remenazzo jose Reme HDE379 MFT580 Demarchi Horacio Demar   Sixco S.A. Sixco    Descargado    Descargado          Young Young Remenazzo jose Reme HDE379 MFT580 Demarchi Horacio DemarNidera S.A. Nasa   Descargado Internacional Santa Fe Sta Fe Horreos Horreos     Young Young Remenazzo jose Reme HDE379 MFT580 Demarchi Horacio Demar   Sixco S.A. SixcoNidera S.A. Nasa Uruguay Uy Frontera Nacional Santa Fe Sta Fe Horreos Horreos     Young Young Remezzano Jose Santiago Ramon Reme HDE379 MFT580 Demarchi Horacio Demar   Sixco S.A. SixcoNidera S.A. Nasa Uruguay Uy Frontera Nacional Santa Fe Sta Fe Horreos Horreos     Young Young Remezzano Jose Santiago Ramon Reme HDE379 MFT580 Demarchi Horacio Demar   Sixco S.A. SixcoNidera S.A. Nasa Uruguay Uy Frontera Nacional Santa Fe Sta Fe Horreos Horreos     Young Young Remezzano Jose Santiago Ramon Reme HDE379 MFT580 Demarchi Horacio Demar   Sixco S.A. Sixco    Frontera            Remezzano Jose Santiago Ramon Reme HDE379 MFT580Nidera S.A. Nasa Uruguay Uy Frontera Nacional Santa Fe Sta Fe Horreos Horreos     Young Young Remezzano Jose Santiago Ramon Reme HDE379 MFT580 Demarchi Horacio Demar   Sixco S.A. Sixco', 1, '7', '3', '665.35', '7', NULL, NULL, '2.6', NULL, '5.5', '300100007315.PDF', NULL, NULL, 'FC7315 - NIDERA RAMENAZZO.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, NULL, NULL, 'Nasa.2.14.04.12', 3, '2', '2014-04-12', '2014-04-14', '2014-04-14', '2014-04-15', 2, 5, 2, '7315', 0, 2, 8, NULL, NULL, 6, 9, 4, 5, 6, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Young Young De Quimpe Paulino Dequimpe HMH996 HDE381 Demarchi Horacio Demar', NULL, '2', '2', '2', '2', NULL, NULL, '0', NULL, '0', '300100007315(1).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(20, NULL, NULL, 'Nasa.3.14.04.12', 3, '3', '2014-04-12', '2014-04-14', '2014-04-14', '2014-04-15', 2, 5, 2, '7315', 0, 2, 8, NULL, NULL, 6, 10, 6, 7, 6, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Young Young De Marchi Natalio Demarc KPA222 KQK615 Demarchi Horacio Demar    Descargado', 1, '2', '1', '5', '1', NULL, NULL, '0', NULL, '0', '300100007315(2).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(21, NULL, NULL, 'Nasa.4.14.04.09', 3, '4', '2014-04-09', '2014-04-10', '2014-04-10', '2014-04-11', 2, 5, 2, '7315', 0, 2, 8, NULL, NULL, 6, 15, 8, 9, 7, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Rebora Jose Antonio Rebora    Descargado          Young Young Gershanik Gaston Gershanik FZI561 FFU715 Rebora Jose Antonio Rebora', 1, '8', '1', '4', '3', NULL, NULL, '0', NULL, '0', '300100007315(3).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(22, NULL, NULL, 'Nasa.5.14.04.08', 3, '5', '2014-04-08', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7315', 0, 1, 2, NULL, NULL, 6, 11, 10, 11, 22, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Young Young Gil Ricardo Gil LBL492 LBL491 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007315(4).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(23, NULL, NULL, 'Nasa.6.14.04.08', 3, '6', '2014-04-08', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7315', 0, 1, 2, NULL, NULL, 6, 21, 12, 13, 24, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Transporte Noro S.A. Noro    Descargado          Young Young Sambon Andres Sambon ICR811 HSD761 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007315(5).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(24, NULL, NULL, 'Nasa.7.14.04.08', 3, '7', '2014-04-08', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7315', 0, 1, 2, NULL, NULL, 6, 12, 14, 15, 24, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Transporte Noro S.A. Noro    Descargado          Young Young Rodriguez Hector Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro', NULL, '2', NULL, '2', '2', NULL, NULL, '0', NULL, '0', '300100007315(6).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(25, NULL, NULL, 'Nasa.8.14.04.08', 3, '8', '2014-04-08', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7315', 0, 2, 8, NULL, NULL, 6, 8, 2, 3, 6, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Young Young Remenazzo jose Reme HDE379 MFT580 Demarchi Horacio Demar', NULL, '0', NULL, '2', NULL, NULL, NULL, '0', NULL, '0', '300100007315(10).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(26, NULL, NULL, 'Nasa.9.14.04.09', 3, '9', '2014-04-09', '2014-04-10', '2014-04-10', '2014-04-11', 2, 5, 2, '7315', 0, 2, 8, NULL, NULL, 6, 13, 16, 17, 7, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Rebora Jose Antonio Rebora    Descargado          Young Young Falle Angel Falle EVQ418 GFI340 Rebora Jose Antonio Rebora', NULL, '2', NULL, '0', '2', NULL, NULL, '0', NULL, '0', '300100007315(9).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(27, NULL, NULL, 'Nasa.10.14.04.08', 3, '10', '2014-04-08', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7315', 0, 2, 8, NULL, NULL, 6, 14, 18, 19, 6, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Young Young Berisso Nestor Berisso FMS249 GLH949 Demarchi Horacio Demar', NULL, '0', NULL, '4', NULL, NULL, NULL, '0', NULL, '0', '300100007315(8).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(28, NULL, NULL, 'Nasa.11.14.04.08', 3, '11', '2014-04-08', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7315', 0, 1, 2, NULL, NULL, 6, 16, 24, 21, 22, NULL, '026AR353010551', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Young Young Sandoval Nestor 25018774 KYJ693 LYX797 Sixco S.A. SixcoNidera S.A. Nasa Uruguay Uy Descargado Internacional Buenos Aires Bue Chacabuco Chaca     Young Young Sandoval Nestor Fabian Sando KYJ692 LYX797 Sixco S.A. Sixco   Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007315(7).PDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, NULL, NULL, 'Nasa.12.14.04.09', 3, '12', '2014-04-09', '2014-04-11', '2014-04-11', '2014-04-12', 2, 5, 2, '7316', 0, 2, 8, NULL, NULL, 5, 9, 4, 5, 6, NULL, '026AR353010550', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Montevideo Mtvdo De Quimpe Paulino Dequimpe HMH996 HDE381 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007316.PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(30, NULL, NULL, 'Nasa.13.14.04.09', 3, '13', '2014-04-09', '2014-04-11', '2014-04-11', '2014-04-12', 2, 5, 2, '7316', 0, 2, 8, NULL, NULL, 5, 10, 6, 7, 6, NULL, '026AR353010550', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Montevideo Mtvdo De Marchi Natalio Demarc KPA222 KQK615 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007316(4).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(31, NULL, NULL, 'Nasa.14.14.04.09', 3, '14', '2014-04-09', '2014-04-11', '2014-04-11', '2014-04-12', 2, 5, 2, '7316', 0, 2, 8, NULL, NULL, 5, 17, 22, 23, 6, NULL, '026AR353010550', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Montevideo Mtvdo Vega Gabriel Vega LDQ566 LFL320 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007316(3).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(32, NULL, NULL, 'Nasa.15.14.04.11', 3, '15', '2014-04-11', '2014-04-14', '2014-04-14', '2014-04-15', 2, 5, 2, '7316', 0, 1, 2, NULL, NULL, 5, 18, 24, 25, 22, NULL, '026AR353010550', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Aguirre Walter Aguirre KYJ692 LBL490 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007316(2).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(33, NULL, NULL, 'Nasa.16.14.04.07', 3, '16', '2014-04-07', '2014-04-09', '2014-04-09', '2014-04-10', 2, 5, 2, '7316', 0, 1, 2, NULL, NULL, 5, 19, 26, 27, 7, NULL, '026AR353010550', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Rebora Jose Antonio Rebora    Descargado          Montevideo Mtvdo Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007316(1).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(38, '2014-04-22', 2, 'Nasa.17.14.04.29', 3, '17', '2014-04-29', '2014-05-05', '2014-05-05', '2014-05-06', NULL, 5, 2, '7448', NULL, 2, 8, NULL, NULL, 5, 10, 16, 25, 6, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Demarchi Horacio Demar    Descargado          Montevideo Mtvdo De Marchi Natalio Demarc EVQ418 LBL490 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448.PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(39, '2014-04-22', 2, 'Nasa.18.14.04.25', 3, '18', '2014-04-25', '2014-04-28', '2014-04-28', '2014-04-29', 2, 5, 2, '7448', 0, 2, 8, NULL, NULL, 5, 25, 36, 37, 7, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Rebora Jose Antonio Rebora    Descargado          Montevideo Mtvdo Benetti Guillermo Bene HFK639 FSO154 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(1).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(40, '2014-04-22', 2, 'Nasa.19.14.04.25', 3, '19', '2014-04-25', '2014-04-28', '2014-04-28', '2014-04-29', NULL, 5, 2, '7448', NULL, 2, 8, NULL, NULL, 5, 15, 8, 9, 7, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Rebora Jose Antonio Rebora    Descargado          Montevideo Mtvdo Gershanik Gaston Gershanik FZI561 FFU715 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(2).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(41, '2014-04-22', 2, 'Nasa.20.14.04.30', 3, '20', '2014-04-30', '2014-05-05', '2014-05-05', '2014-05-06', NULL, 5, 2, '7448', NULL, 2, 8, NULL, NULL, 5, 21, 12, 13, 24, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Transporte Noro S.A. Noro    Descargado          Montevideo Mtvdo Sambon Andres Sambon ICR811 HSD761 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(3).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(42, '2014-04-22', 2, 'Nasa.21.14.05.06', 3, '21', '2014-05-06', '2014-05-07', '2014-05-07', '2014-05-08', NULL, 5, 2, '7448', NULL, 2, 8, NULL, NULL, 5, 11, 10, 11, 22, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Gil Ricardo Gil LBL492 LBL491 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(4).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(43, '2014-04-22', 2, 'Nasa.22.14.05.06', 3, '22', '2014-05-06', '2014-05-07', '2014-05-07', '2014-05-08', NULL, 5, 2, '7448', NULL, 2, 8, NULL, NULL, 5, 16, 20, 21, 22, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Sandoval Nestor 25018774 KYJ693 LYX797 Sixco S.A. SixcoNidera S.A. Nasa   Descargado Internacional Santa Fe Sta Fe Horreos Horreos     Montevideo Mtvdo Sandoval Nestor Fabian Sando KYJ693 LYX797 Sixco S.A. Sixco   Sixco S.A. SixcoNidera S.A. Nasa   Descargado Internacional Santa Fe Sta Fe Horreos Horreos     Montevideo Mtvdo Sandoval Nestor Fabian Sando KYJ693 LYX797 Sixco S.A. Sixco   Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, '10', '10', NULL, '0', '300100007448(5).PDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, '2014-04-22', 2, 'Nasa.23.14.05.09', 3, '23', '2014-05-09', '2014-05-12', '2014-05-12', '2014-05-13', NULL, 5, 2, '7448', NULL, 2, 8, NULL, NULL, 5, 11, 10, 11, 22, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Gil Ricardo Gil LBL492 LBL491 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(6).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(45, '2014-04-22', 2, 'Nasa.24.14.05.09', 3, '24', '2014-05-09', '2014-05-12', '2014-05-12', '2014-05-13', NULL, 5, 2, '7448', NULL, 1, 2, NULL, NULL, 5, 16, 20, 21, 22, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Sandoval Nestor 25018774 KYJ693 LYX797 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(7).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(46, '2014-04-22', 2, '.25.14.04.25', NULL, '25', '2014-04-25', '2014-04-28', '2014-04-28', '2014-04-29', NULL, NULL, NULL, '7448', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Rebora Jose Antonio Rebora    Descargado          Montevideo Mtvdo Falle Angel Falle EVQ418 GFI340 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(8).PDF', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, '2014-04-22', 2, 'Nasa.26.14.04.29', 3, '26', '2014-04-29', '2014-04-30', '2014-04-30', '2014-05-02', NULL, 5, 2, '7448', NULL, 1, 2, NULL, NULL, 5, 26, 35, 31, 22, NULL, '026AR353010558', NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 680, 'Nidera S.A. Nasa Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Perez Guillermo Perez KPQ343 FUN433 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', '300100007448(9).PDF', NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(49, '2014-04-30', 1, 'Nasa.2.14.04.12', 3, '2', '2014-04-12', NULL, NULL, '2014-04-15', NULL, 5, 2, '7315', NULL, 2, 8, NULL, NULL, 6, 9, 4, 5, 6, NULL, NULL, NULL, 'Semilla trigo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 123, NULL, NULL, 0, NULL, 'Nidera S.A. Nasa Horacio De Marchi Demar    Descargado          Young Young Dequimpe Paulino Enrique Dequim P HMH996 HDE381 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(50, '2014-05-13', 2, '.12.14.04.11', NULL, '12', '2014-04-11', '2014-04-14', '2014-04-15', '2014-04-16', NULL, NULL, NULL, '182', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR3530105554', '14AR118815X', 'Semilla forrajera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 20130, 'Descargado          Montevideo Mtvdo Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora', NULL, '2', NULL, '2', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '14AR118815X-1.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, '2014-05-13', 2, '.13.14.04.24', NULL, '13', '2014-04-24', '2014-04-25', '2014-04-28', '2014-04-29', NULL, NULL, NULL, '185', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR353010557', '14AR130687J', 'Semilla forrajera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 27000, 'Descargado          Montevideo Mtvdo Perez Guillermo Perez KPQ343 FUN433 Sixco S.A. SixcoAlfalfares S.A. Alfaf   Descargado Internacional Buenos Aires Bue Salto Salto     Montevideo Mtvdo Perez Guillermo Javier Perez KPQ343 FUN433 Sixco S.A. Sixco   Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '14AR130687J-1.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(52, '2014-05-13', 2, '.14.14.04.25', NULL, '14', '2014-04-25', '2014-04-28', '2014-04-29', '2014-04-30', NULL, NULL, NULL, '191', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR353010562', '14AR132846X', 'Semilla forrajera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 25425, 'Descargado          Montevideo Mtvdo Rebora Jose Antonio Rebora2 GJV 116 GHO 341 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '14AR132846X.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '2014-05-13', 2, '.15.14.04.30', NULL, '15', '2014-04-30', '2014-05-05', '2014-05-06', '2014-05-07', NULL, NULL, NULL, '187', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR353010563', '14AR141350V', 'Semilla forrajera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 28000, 'Descargado          Montevideo Mtvdo Ojeda Osvaldo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '14AR141350V.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(54, '2014-05-13', 2, '.16.14.05.12', NULL, '16', '2014-05-12', '2014-05-14', '2014-05-15', '2014-05-16', NULL, NULL, NULL, '190', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR353010564', '14AR151765J', 'Semilla forrajera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 28000, 'Frontera          Montevideo Mtvdo Berisso Nestor Berisso FMS249 GLH949 Demarchi Horacio Demar    Frontera          Montevideo Mtvdo Berisso Nestor Daniel Berisso FMS249 GLH949 Demarchi Horacio Demar    Frontera          Montevideo Mtvdo Berisso Nestor Daniel Berisso FMS249 GLH949 Demarchi Horacio Demar    Descargado          Montevideo Mtvdo Berisso Nestor Daniel Berisso FMS249 GLH949 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '14AR151765J.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, '2014-05-16', 2, '.17.14.05.19', NULL, '17', '2014-05-19', '2014-05-20', '2014-05-20', '2014-05-21', NULL, NULL, NULL, '189', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '026AR353010567', '14AR160575X', 'Semilla forrajera', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'Alfalfares S.A. Alfaf   Confirmado Internacional Buenos Aires Bue Salto Salto     Montevideo Mtvdo     Transporte Elois SRL Elois   Sixco S.A. SixcoAlfalfares S.A. Alfaf   Confirmado Internacional Buenos Aires Bue Salto Salto     Montevideo Mtvdo Lauman Jorge Lauman   Transporte Elois SRL Elois   Sixco S.A. SixcoAlfalfares S.A. Alfaf   Confirmado Internacional Buenos Aires Bue Salto Salto     Montevideo Mtvdo Lauman Jorge Lauman   Transporte Elois SRL Elois   Sixco S.A. SixcoAlfalfares S.A. Alfaf   Confirmado Internacional Buenos Aires Bue Salto Salto     Montevideo Mtvdo Lauman Jorge Lauman   Transporte Elois SRL Elois   Sixco S.A. Sixco    Confirmado          Montevideo Mtvdo Rodriguez Hugo RoHugo   Transporte Elois SRL Elois    Confirmado          Montevideo Mtvdo Rodriguez Hugo RoHugo   Transporte Elois SRL Elois    Confirmado          Montevideo Mtvdo Rodriguez Hugo RoHugo   Transporte Elois SRL Elois    Cargado          Montevideo Mtvdo Rodriguez Hugo RoHugo MUW 216 FNX 115 Transporte Elois SRL Elois    Descargado          Montevideo Mtvdo Rodriguez Hugo RoHugo MUW 216 FNX 115 Transporte Elois SRL Elois', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', 'PACKING FC 189.jpg', NULL, NULL, '14AR160575X.pdf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, '2014-05-19', 1, 'CHR.Syngenta.14.05.17', 52, 'Syngenta', '2014-05-17', '2014-05-19', NULL, NULL, 3, 3, 2, NULL, 0, 2, 1, NULL, NULL, 12, 18, 24, 25, 22, NULL, '046ARNORO008/2014', '14AR156623H', 'Semilla girasol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR Paraguay Py Cargado Internacional Buenos Aires Bue       Asuncion Asu Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. Sixco    Cargado          Asuncion Asu Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. SixcoC.H. Robinson W. ARG. S.A. CHR   Cargado Internacional Santa Fe Sta Fe Venado Tuerto Vtto     Asuncion Asu Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. Sixco   Paravac SRL Paravac    Cargado          Ciudad del Este CdE Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '046ARNORO008-2014 - 14AR156623H - KYJ692.pdf', '', '', '', NULL, NULL, NULL, '', '', '', ''),
(59, '2014-05-19', 1, 'CHR.Syngenta.14.05.17', 52, 'Syngenta', '2014-05-17', '2014-05-19', NULL, NULL, 3, 3, 2, NULL, 0, 2, 1, NULL, NULL, 12, 26, 35, 31, 22, NULL, '046ARNORO008/2014', '14AR156669R', 'Semilla girasol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR Paraguay Py Cargado Internacional Buenos Aires Bue       Asuncion Asu Perez Guillermo Javier Perez KPQ343 FUN433 Sixco S.A. SixcoC.H. Robinson W. ARG. S.A. CHR   Cargado Internacional Santa Fe Sta Fe Venado Tuerto Vtto     Asuncion Asu Perez Guillermo Javier Perez KPQ343 FUN433 Sixco S.A. Sixco   Paravac SRL Paravac    Cargado          Ciudad del Este CdE Perez Guillermo Javier Perez KPQ343 FUN433 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '046ARNORO008-2014 - 14AR156669R - KPQ343.pdf', '', '', '', NULL, NULL, NULL, '', '', '', ''),
(60, '2014-05-19', 1, 'CHR.Syngenta.14.05.17', 52, 'Syngenta', '2014-05-17', '2014-05-19', NULL, NULL, 3, 3, 2, NULL, 0, 2, 1, NULL, NULL, 12, 16, 20, 21, 22, NULL, '046ARNORO008/2014', '14AR156682M', 'Semilla girasol', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR Paraguay Py Cargado Internacional Buenos Aires Bue       Asuncion Asu Sandoval Nestor Fabian Sando KYJ693 LYX797 Sixco S.A. SixcoC.H. Robinson W. ARG. S.A. CHR   Cargado Internacional Santa Fe Sta Fe Venado Tuerto Vtto     Asuncion Asu Sandoval Nestor Fabian Sando KYJ693 LYX797 Sixco S.A. Sixco   Paravac SRL Paravac    Cargado          Ciudad del Este CdE Sandoval Nestor Fabian Sando KYJ693 LYX797 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '046ARNORO008-2014 - 14AR156682M - KYJ693.pdf', '', '', '', NULL, NULL, NULL, '', '', '', ''),
(61, '2014-05-22', 2, 'Mferreyra.1.14.05.22', 73, '1', '2014-05-22', '2014-05-26', '2014-05-26', '2014-05-27', NULL, 5, 2, NULL, NULL, 3, 101, NULL, NULL, 96, 11, 10, 11, 22, NULL, NULL, NULL, 'Maquinas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 1, 'Marcelo Ferreyra Mferreyra   Cargado Internacional Cordoba Cba Noetinger Noetin     Santa Rita Sta Rita Gil Ricardo Omar Gil LBL492 LBL491 Sixco S.A. Sixco   Sixco S.A. Sixco    Descargado          Santa Rita Sta Rita Gil Ricardo Omar Gil LBL492 LBL491 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(62, '2014-05-22', 2, 'Mferreyra.2.14.05.22', 73, '2', '2014-05-22', '2014-05-26', '2014-05-26', '2014-05-27', NULL, 5, 2, NULL, NULL, 3, 101, NULL, NULL, 96, 25, 36, 37, 7, NULL, NULL, NULL, 'Maquinas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, 0, 1, 'Marcelo Ferreyra Mferreyra   Cargado Internacional Cordoba Cba Noetinger Noetin     Santa Rita Sta Rita Benetti Guillermo Bene HFK639 FSO154 Rebora Jose Antonio Rebora   Sixco S.A. Sixco    Descargado          Santa Rita Sta Rita Benetti Guillermo Bene HFK639 FSO154 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(63, '2014-05-29', 2, 'CHR..14.05.14', 52, NULL, '2014-05-14', NULL, NULL, NULL, NULL, 5, NULL, 'EX5964', NULL, 1, 63, NULL, NULL, 5, 12, 14, 15, 24, '0150R00178590', '008AR353010565', '14AR153999U', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 75, NULL, NULL, NULL, 0, NULL, 'AnuladoC.H. Robinson W. ARG. S.A. CHR   Anulado                    Sixco S.A. SixcoC.H. Robinson W. ARG. S.A. CHR   Descargado  Buenos Aires Bue Zarate Zarate     Montevideo Mtvdo     Transporte Noro S.A. Noro   Boer S.A. Boer    Descargado          Montevideo Mtvdo Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(64, '2014-05-29', 2, 'RodriMaria..14.05.02', 74, NULL, '2014-05-02', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 11, 102, NULL, NULL, 5, 48, 83, 81, 47, NULL, '038AR353010560', '14AR133045A', 'Papas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, 0, NULL, 'Rodriguez Maria Agustina RodriMaria                       Transporte Noro S.A. NoroRodriguez Maria Agustina RodriMaria   Descargado Internacional Mendoza Men Mendoza Mdza     Montevideo Mtvdo Larrosa Omar Larr CBY254 LNP025 Henscheid Alberto Marcelo Hens   Transporte Noro S.A. Noro    Descargado          Montevideo Mtvdo Larrosa Omar Larr CBY254 LNP025 Henscheid Alberto Marcelo Hens', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(65, '2014-05-29', 2, 'RodriMaria..14.05.02', 74, NULL, '2014-05-02', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 11, 102, NULL, NULL, 5, 38, 85, 86, 47, NULL, '038AR353010560', '14AR133012R', 'Papas', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, 0, NULL, 'Rodriguez Maria Agustina RodriMaria   Descargado Internacional Mendoza Men Mendoza Mdza     Montevideo Mtvdo Olivera Luis Omar Oliver JBJ090 FWW451 Henscheid Alberto Marcelo Hens   Transporte Noro S.A. Noro    Descargado          Montevideo Mtvdo Olivera Luis Omar Oliver JBJ090 FWW451 Henscheid Alberto Marcelo Hens', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(66, '2014-05-29', 2, 'CHR..14.05.15', 52, NULL, '2014-05-15', NULL, NULL, NULL, NULL, 5, 2, 'EX5968', NULL, 1, 63, NULL, NULL, 5, 11, 10, 11, 22, NULL, '008AR353010566', '14ar155782M', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 75, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR   Descargado Internacional Buenos Aires Bue Zarate Zarate     Montevideo Mtvdo Gil Ricardo Omar Gil LBL492 LBL491 Sixco S.A. Sixco   Boer S.A. Boer    Descargado          Montevideo Mtvdo Gil Ricardo Omar Gil LBL492 LBL491 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(67, '2014-05-29', 2, 'Rotor..14.05.19', 78, NULL, '2014-05-19', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 5, 3, NULL, NULL, 4, 10, 6, NULL, 6, NULL, '026AR353010568', '14AR160073B', 'Surtidores combustible', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 77, NULL, NULL, NULL, 0, NULL, 'Rotor SRL Rotor   Descargado Internacional Entre Rios ER Gualeguaychu Gchu     Fray Bentos Fbento Demarchi Natalio Horacio Demarc KPA222  Demarchi Horacio Demar   Demarchi Natalio Horacio Demarc    Descargado          Fray Bentos Fbento Demarchi Natalio Horacio Demarc KPA222  Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(68, '2014-05-29', 2, 'CHR.Syngenta.14.05.23', 52, 'Syngenta', '2014-05-23', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 2, 1, NULL, NULL, 12, 12, 14, 15, 24, NULL, '046ARNORO010/2014', '14AR166646N', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR   Descargado Internacional Santa Fe Sta Fe Venado Tuerto Vtto     Ciudad del Este CdE Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro   Paravac SRL ParavacC.H. Robinson W. ARG. S.A. CHR   Descargado Internacional Santa Fe Sta Fe Venado Tuerto Vtto     Ciudad del Este CdE Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro   Paravac SRL Paravac    Descargado          Ciudad del Este CdE Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(69, '2014-05-29', 2, 'CHR.Dak.14.05.28', 52, 'Dak', '2014-05-28', NULL, NULL, NULL, NULL, 3, 2, NULL, NULL, 1, 63, NULL, NULL, 18, 29, 34, 32, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR   Cargado Internacional Buenos Aires Bue Zarate Zarate     Asuncion Asu Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro   Paravac SRL Paravac', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(70, '2014-05-29', 2, 'CHR.Dak.14.05.29', 52, 'Dak', '2014-05-29', NULL, NULL, NULL, NULL, 2, 2, NULL, NULL, 1, 63, NULL, NULL, 18, 13, 16, 17, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR   Confirmado Internacional Buenos Aires Bue Zarate Zarate     Asuncion Asu Falle Angel Alfredo Falle EVQ418 GFI340 Rebora Jose Antonio Rebora   Paravac SRL Paravac', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(71, '2014-05-29', 2, 'CHR.Dak.14.05.29', 52, 'Dak', '2014-05-29', NULL, NULL, NULL, NULL, 2, 2, NULL, NULL, 1, 63, NULL, NULL, 18, 21, 12, 13, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR   Confirmado Internacional Buenos Aires Bue Zarate Zarate     Asuncion Asu Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro   Paravac SRL Paravac', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(72, '2014-05-29', 2, 'CHR.Dak.14.05.29', 52, 'Dak', '2014-05-29', NULL, NULL, NULL, NULL, 2, 2, NULL, NULL, 1, 63, NULL, NULL, 18, 19, 26, 27, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 76, NULL, NULL, NULL, 0, NULL, 'C.H. Robinson W. ARG. S.A. CHR   Confirmado Internacional Buenos Aires Bue Zarate Zarate     Asuncion Asu Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora   Paravac SRL Paravac', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(73, '2014-06-02', 3, 'ITLS..14.06.02', 54, NULL, '2014-06-02', NULL, NULL, NULL, NULL, 3, 2, NULL, NULL, 2, 40, NULL, NULL, 5, 11, 10, 11, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Cargado Internacional Santa Fe Sta Fe Carcaraña Carca     Montevideo Mtvdo Gil Ricardo Omar Gil LBL492 LBL491 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(74, '2014-06-02', 3, 'ITLS..14.06.02', 54, NULL, '2014-06-02', NULL, NULL, NULL, NULL, 3, 2, NULL, NULL, 2, 40, NULL, NULL, 5, 12, 14, 15, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Cargado Internacional Santa Fe Sta Fe Carcaraña Carca     Montevideo Mtvdo Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(75, '2014-06-02', 3, 'ITLS.Roman Servicios SA.14.05.07', 54, 'Roman Servicios SA', '2014-05-07', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 13, 51, NULL, NULL, 52, 21, 12, 13, 24, '001-12899', 'UY110502059', 'UY110502078', 'Partes máquina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Montevideo Mont Puerto Montevideo Pto. Mtvdo     Puerto Buenos Aires Pto. Bs. As. Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro   Transporte Noro S.A. Noro    Descargado          Puerto Buenos Aires Pto. Bs. As. Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro    Descargado          Puerto Buenos Aires Pto. Bs. As. Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(76, '2014-06-03', 3, 'ITLS.Roman Servicios SA.14.05.07', 54, 'Roman Servicios SA', '2014-05-07', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 13, 51, NULL, NULL, 52, 29, 34, 32, 24, '001-14749', 'UY110502059', NULL, 'Partes máquina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Montevideo Mont Puerto Montevideo Pto. Mtvdo     Puerto Buenos Aires Pto. Bs. As. Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro   Transporte Noro S.A. Noro    Descargado          Puerto Buenos Aires Pto. Bs. As. Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(77, '2014-06-03', 3, 'ITLS.Roman Servicios SA.14.05.10', 54, 'Roman Servicios SA', '2014-05-10', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 13, 51, NULL, NULL, 52, 26, 35, 31, 24, '001-14742', 'UY110502059', 'UY110502062', 'Partes máquina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Montevideo Mont Puerto Montevideo Pto. Mtvdo     Puerto Buenos Aires Pto. Bs. As. Perez Guillermo Javier Perez KPQ343 FUN433 Transporte Noro S.A. Noro   Transporte Noro S.A. Noro    Descargado          Puerto Buenos Aires Pto. Bs. As. Perez Guillermo Javier Perez KPQ343 FUN433 Transporte Noro S.A. Noro    Descargado          Puerto Buenos Aires Pto. Bs. As. Perez Guillermo Javier Perez KPQ343 FUN433 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(78, '2014-06-04', 3, '.Molyagro.14.05.12', NULL, 'Molyagro', '2014-05-12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '088AR110501251', '14AR150544D', 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. Sixco    Descargado          Montevideo Mtvdo Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. SixcoITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. SixcoITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. SixcoITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. SixcoITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Aguirre Walter Federico Aguirre KYJ692 LBL490 Sixco S.A. Sixco', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'edede', NULL, NULL, NULL, NULL, NULL, NULL),
(79, '2014-06-04', 3, '.UPM.14.05.17', NULL, 'UPM', '2014-05-17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'UY110502062', 'UY110502096', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro    Descargado          Campana Campa Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, '2014-06-04', 3, 'ETM.UPM.14.05.17', 53, 'UPM', '2014-05-17', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 29, 34, 32, 24, NULL, 'UY110502062', 'UY110502087', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro    Descargado          Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroE.T.M. Internacional S.R.L. ETM   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroE.T.M. Internacional S.R.L. ETM   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroE.T.M. Internacional S.R.L. ETM   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroE.T.M. Internacional S.R.L. ETM   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroE.T.M. Internacional S.R.L. ETM   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. NoroE.T.M. Internacional S.R.L. ETM   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '12', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '321', NULL, NULL, NULL, NULL, NULL, NULL),
(81, '2014-06-04', 3, 'ITLS.UPM.14.05.17', 54, 'UPM', '2014-05-17', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 21, 12, 13, 24, NULL, 'UY110502062', 'UY110502088', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro    Descargado          Campana Campa Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(82, '2014-06-04', 3, 'ITLS.Unilever.14.05.20', 54, 'Unilever', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 2, 103, NULL, NULL, 5, 17, 22, 23, 6, NULL, '052AR0318142320', '14AR161256F', 'Artículos de perfumería', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Santa Fe Sta Fe       Montevideo Mtvdo Vega Gabriel Ramon Vega LDQ566 LFL320 Demarchi Horacio DemarITLS S.A. ITLS   Descargado Internacional Santa Fe Sta Fe       Montevideo Mtvdo Vega Gabriel Ramon Vega LDQ566 LFL320 Demarchi Horacio Demar    Descargado          Montevideo Mtvdo Vega Gabriel Ramon Vega LDQ566 LFL320 Demarchi Horacio DemarITLS S.A. ITLS   Descargado Internacional Santa Fe Sta Fe Gobernador Galvez GGz     Montevideo Mtvdo Vega Gabriel Ramon Vega LDQ566 LFL320 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(83, '2014-06-04', 3, 'ITLS.Unilever.14.05.20', 54, 'Unilever', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 2, NULL, NULL, NULL, 5, 31, 46, 47, 6, NULL, '052AR0318142320', '14AR161224A', 'Artículos de perfumería', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Santa Fe Sta Fe       Montevideo Mtvdo Dequimpe Diego Damian Dequim P FZV194 MFT581 Demarchi Horacio Demar    Descargado          Montevideo Mtvdo Dequimpe Diego Damian Dequim P FZV194 MFT581 Demarchi Horacio Demar    Descargado          Montevideo Mtvdo Dequimpe Diego Damian Dequim P FZV194 MFT581 Demarchi Horacio Demar', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(84, '2014-06-04', 3, 'ITLS.UPM.14.05.20', 54, 'UPM', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 28, 28, 29, 7, NULL, 'UY110502062', 'UY110502092', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Rebora Jose Antonio Rebora2 GJV 116 GHO 341 Transporte Noro S.A. Noro    Descargado          Campana Campa Rebora Jose Antonio Rebora2 GJV 116 GHO 341 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(85, '2014-06-04', 3, 'ITLS.UPM.14.05.20', 54, 'UPM', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 25, 36, 37, 7, NULL, 'UY110502062', 'UY110502089', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Benetti Guillermo Bene HFK639 FSO154 Transporte Noro S.A. Noro    Descargado          Campana Campa Benetti Guillermo Bene HFK639 FSO154 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(86, '2014-06-04', 3, 'ITLS.UPM.14.05.20', 54, 'UPM', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 15, 8, 9, 7, NULL, 'UY110502062', 'UY110502091', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Gershanik Gaston Ruben Gershanik FZI561 FFU715 Transporte Noro S.A. Noro    Descargado          Campana Campa Gershanik Gaston Ruben Gershanik FZI561 FFU715 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(87, '2014-06-04', 3, 'ITLS.UPM.14.05.20', 54, 'UPM', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 13, 16, 17, 7, NULL, 'UY110502062', 'UY110502090', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Falle Angel Alfredo Falle EVQ418 GFI340 Transporte Noro S.A. Noro    Descargado          Campana Campa Falle Angel Alfredo Falle EVQ418 GFI340 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(88, '2014-06-04', 3, 'ITLS.UPM.14.05.20', 54, 'UPM', '2014-05-20', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 19, 26, 27, 7, NULL, 'UY110502062', 'UY110502093', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora    Descargado          Campana Campa Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(89, '2014-06-04', 3, 'ITLS.Metal Noet SRL.14.05.24', 54, 'Metal Noet SRL', '2014-05-24', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 3, 101, NULL, NULL, 96, 11, 10, 11, 24, NULL, '017AR-LIDER-00237', '14AR160828J', 'Carro transportador de plataforma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 56, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Noetinger Noetin     Santa Rita Sta Rita Gil Ricardo Omar Gil LBL492 LBL491 Transporte Noro S.A. Noro    Descargado          Santa Rita Sta Rita Gil Ricardo Omar Gil LBL492 LBL491 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '017AR-LIDER-00237 - 14AR160828J - LBL492.pdf', '', '', '', NULL, NULL, NULL, '', '', '', ''),
(90, '2014-06-04', 3, 'ITLS.Metal Noet SRL.14.05.24', 54, 'Metal Noet SRL', '2014-05-24', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 3, 101, NULL, NULL, 96, 25, 36, 37, 7, NULL, NULL, NULL, 'Carro transportador de plataforma', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 56, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Noetinger Noetin     Santa Rita Sta Rita Benetti Guillermo Bene HFK639 FSO154 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', '');
INSERT INTO `unidades-trabajo` (`idUnidadTrabajo`, `fechaAlta`, `idUsuarioAlta`, `codigoUT`, `idTerceroSociedad`, `viaje`, `fechaCarga`, `fechaFronteraI`, `fechaFronteraE`, `fechaDescarga`, `idPais`, `idEstadoUT`, `idTipoUT`, `facturaCliente`, `recorrido`, `idProvincia`, `idCiudadOrigen`, `idCiudadR1`, `idCiudadR2`, `idCiudadDestino`, `idTerceroChofer`, `idDominioTractor`, `idDominioSemi`, `idTerceroTransporte`, `remito`, `CRT`, `MICDTA`, `productos`, `idTipoOperacion`, `datos1`, `datos2`, `datos3`, `datos4`, `datos5`, `datos6`, `viajeLiquidado`, `idTerceroFacturacion`, `diasDemora`, `facturacion`, `idListaPrecio`, `utCerrado`, `cantidad`, `tags`, `monCompra`, `valorCompraNac`, `factCompraNac`, `valorCompraInt`, `factCompraInt`, `monVenta`, `factVentaNac`, `valorVentaNac`, `factVentaInt`, `valorVentaInt`, `archivoFacturaCliente`, `archivoRemito`, `archivoCRT`, `archivoMICDTA`, `direccionCarga`, `direccionDescarga`, `observaciones`, `idTerceroShipper`, `valorReferenciaFacturacion`, `idMonedaReferenciaFacturacion`, `valorDemora`, `facturaDemoraProv`, `valorFactDemora`, `facturaDemoraCliente`) VALUES
(91, '2014-06-04', 3, 'ITLS.Molyagro.14.05.12', 54, 'Molyagro', '2014-05-12', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 3, 31, NULL, NULL, 5, 21, 12, 13, 24, NULL, '088AR110501251', '14AR150837X', 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro    Descargado          Montevideo Mtvdo Sambon Andres Miguel Sambon ICR811 HSD761 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '088AR110501251 - 14AR150837X - ICR811.pdf', '', '', '', NULL, NULL, NULL, '', '', '', ''),
(92, '2014-06-04', 3, 'ITLS.Molyagro.14.05.12', 54, 'Molyagro', '2014-05-12', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 3, 31, NULL, NULL, 5, 29, 34, 32, 24, NULL, '088AR110501251', '14AR150706D', 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro    Descargado          Montevideo Mtvdo Ojeda Osvaldo Arturo Ojeda HCY417 FUN434 Transporte Noro S.A. Noro', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, '088AR110501251 - 14AR150706D - HCY417.pdf', '', '', '', NULL, NULL, NULL, '', '', '', ''),
(93, '2014-06-04', 3, 'ITLS.Molyagro.14.05.27', 54, 'Molyagro', '2014-05-27', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 3, 31, NULL, NULL, 5, 28, 28, 29, 7, NULL, NULL, NULL, 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Rebora Jose Antonio Rebora2 GJV116 GHO341 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(94, '2014-06-04', 3, 'ITLS.Molyagro.14.05.27', 54, 'Molyagro', '2014-05-27', NULL, NULL, NULL, NULL, 5, 2, NULL, NULL, 3, 31, NULL, NULL, 5, 15, 8, 9, 7, NULL, NULL, NULL, 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Gershanik Gaston Ruben Gershanik FZI561 FFU715 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '', '', '', ''),
(95, '2014-06-04', 3, 'ITLS.Molyagro.14.05.27', 54, 'Molyagro', '2014-05-27', NULL, NULL, NULL, 3, 5, 2, NULL, NULL, 3, 31, NULL, NULL, 5, 13, 16, 17, 7, NULL, NULL, NULL, 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Falle Angel Alfredo Falle EVQ418 GFI340 Rebora Jose Antonio Rebora  Paraguay Py', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', '', 'fede', NULL, NULL, '', '', '', ''),
(96, '2014-06-04', 3, 'ITLS.Molyagro.14.05.27', 54, 'Molyagro', '2014-05-27', NULL, NULL, NULL, NULL, 1, 2, NULL, NULL, 3, 31, NULL, NULL, 5, 19, 26, 27, 7, NULL, NULL, NULL, 'Suplemento alimenticio animal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Cordoba Cba Tancacha Tch     Montevideo Mtvdo Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora    Confirmado    Anulado    Datos    Datos          Montevideo Mtvdo Santamarina Francisco Santam GZX097 KBW359 Rebora Jose Antonio Rebora', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, '', '', NULL, '345', 34.5, 1, '', '', '', ''),
(97, '2014-07-03', 1, '....', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', ''),
(98, '2014-07-03', 1, 'VVeste.321.14.07.09', 65, '321', '2014-07-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 'Viveros del Este SRL VVeste', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '123', NULL, NULL, '', '', '', ''),
(99, '2014-07-03', 1, 'Alfaf.1234...', 27, '1234', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 75, NULL, NULL, NULL, NULL, NULL, 'Alfalfares S.A. Alfaf                       Boer S.A. Boer', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1234', NULL, NULL, '', '', '', ''),
(100, '2014-07-04', 1, 'As Pana.4...', 49, '4', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 77, NULL, 0, NULL, NULL, NULL, 'Aserradero Panamericano SACIA As Pana     Buenos Aires Bue                 Demarchi Natalio Horacio Demarc', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', ''),
(101, '2014-07-04', 1, 'As Pana.2...', 49, '2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 75, NULL, 0, NULL, NULL, NULL, 'Aserradero Panamericano SACIA As Pana                       Boer S.A. Boer', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL, '', '', '', ''),
(103, '2014-10-07', 1, 'ITLS.UPM.14.05.17', 54, 'UPM', '2014-05-17', NULL, NULL, NULL, NULL, 6, 2, NULL, NULL, 16, 48, NULL, NULL, 39, 12, 14, 15, 24, NULL, 'UY110502062', 'UY110502096', 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, 'ITLS S.A. ITLS   Descargado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro    Datos            Rodriguez Hector Ramon Rodriguez EUU433 LKK541ITLS S.A. ITLS   Datos Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. NoroITLS S.A. ITLS   Confirmado Internacional Soriano Sor Nueva Palmira Nva Palmira     Campana Campa Rodriguez Hector Ramon Rodriguez EUU433 LKK541 Transporte Noro S.A. Noro    Anulado  Soriano Sor       Campana Campa Rodriguez Hector Ramon Rodriguez EUU433 LKK541', NULL, '0', NULL, '0', NULL, NULL, NULL, '0.10', NULL, '0', 'CD- TP evento efímero copia.jpg', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', '', ''),
(104, '2014-11-07', 1, '.1asd.14.11.01', NULL, '1asd', '2014-11-01', NULL, NULL, '2014-11-07', NULL, NULL, NULL, '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 'Alfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. BoerAlfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. Boer', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '11915', NULL, NULL, NULL, NULL, NULL, NULL),
(105, '2014-11-07', 1, '.654.14.11.01', NULL, '654', '2014-11-01', NULL, NULL, '2014-11-07', NULL, NULL, NULL, '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 'Alfalfares S.A. Alfaf Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Demarchi Natalio Horacio Demarc', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '321', NULL, NULL, NULL, NULL, NULL, NULL),
(106, '2014-11-07', 1, '.654.14.11.01', NULL, '654', '2014-11-01', NULL, NULL, '2014-11-07', NULL, NULL, NULL, '6', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Pasta de celulosa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 'Aserradero Panamericano SACIA As Pana Argentina Arg Descargado Internacional Alto Parana Alt Para Ciudad del Este CdE     Carmen de Areco Areco Aguirre Walter Federico Aguirre AAY102 BDL858 Demarchi Horacio Demar   Boer S.A. Boer  Argentina Arg    Frontera', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '345', NULL, NULL, NULL, NULL, NULL, NULL),
(107, '2014-12-03', 1, 'As Pana....', 49, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, NULL, 'Alfalfares S.A. AlfafAserradero Panamericano SACIA As Pana', NULL, '0', NULL, '0', NULL, NULL, NULL, '0', NULL, '0', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario-sociedades`
--

CREATE TABLE IF NOT EXISTS `usuario-sociedades` (
  `idUsuario` int(10) unsigned NOT NULL,
  `idSociedad` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idUsuario`,`idSociedad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario-sociedades`
--

INSERT INTO `usuario-sociedades` (`idUsuario`, `idSociedad`) VALUES
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `idUsuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `idNivel` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `contrasenia`, `nombre`, `apellido`, `email`, `idNivel`, `activo`, `observaciones`) VALUES
(1, 'admin', '654321', 'Francisco', 'Firpo', 'kfirpo@sixco.com', -1, 1, ''),
(2, 'astano', '123456', 'Alejandro', 'Stano', 'astano@sixco.com.ar', 3, 1, NULL),
(3, 'ema', '123456', 'Emanuel', 'Guignard', 'pin_ema@hotmail.com', 1, 1, NULL),
(4, 'silvio', '123456', 'Silvio', 'Noro', 'snoro@gmail.com', 1, 1, NULL),
(5, 'frank', '654321', 'Francisco', 'Firpo', 'kfirpo@sixco.com.ar', 1, 1, NULL),
(6, 'vicky', '123456', 'Victoria', 'Martire', 'mvmartire@sixco.com.ar', 1, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view1`
--
CREATE TABLE IF NOT EXISTS `view1` (
`idTercero` int(10) unsigned
,`denominacion` varchar(255)
,`denominacionCorta` varchar(255)
,`clave` varchar(255)
,`idTipoTercero` int(10) unsigned
,`idCondicionIVA` int(10) unsigned
,`eMail` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view2`
--
CREATE TABLE IF NOT EXISTS `view2` (
`idTercero` int(10) unsigned
,`denominacion` varchar(255)
,`calle` varchar(255)
,`numero` varchar(255)
,`piso` varchar(255)
,`departamento` varchar(255)
,`codigoPostal` varchar(255)
,`idPais` int(10) unsigned
,`idProvincia` int(10) unsigned
,`idCiudad` int(10) unsigned
,`telefono` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view3`
--
CREATE TABLE IF NOT EXISTS `view3` (
`codigoUT` varchar(255)
,`idTerceroSociedad` int(10) unsigned
,`idTerceroFacturacion` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`idProvincia` int(10) unsigned
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`fechaCarga` date
,`fechaDescarga` date
,`idTerceroChofer` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idTipoUT` int(10) unsigned
,`idTerceroTransporte` int(10) unsigned
,`idEstadoUT` int(10) unsigned
,`productos` varchar(255)
,`idUsuarioAlta` int(10) unsigned
,`fechaAlta` date
,`cantidad` int(11)
,`idUnidadTrabajo` int(10) unsigned
,`tags` text
,`archivoFacturaCliente` varchar(255)
,`idTerceroShipper` varchar(255)
,`facturacion` tinyint(1)
,`idPais` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view4`
--
CREATE TABLE IF NOT EXISTS `view4` (
`idUnidadTrabajo` int(10) unsigned
,`fechaCarga` date
,`fechaDescarga` date
,`idPais` int(10) unsigned
,`idEstadoUT` int(10) unsigned
,`idProvincia` int(10) unsigned
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idTipoUT` int(10) unsigned
,`viajeLiquidado` tinyint(1)
,`remito` varchar(255)
,`CRT` varchar(255)
,`MICDTA` varchar(255)
,`idTerceroSociedad` int(10) unsigned
,`codigoUT` varchar(255)
,`tags` text
,`archivoRemito` varchar(255)
,`archivoCRT` varchar(255)
,`archivoMICDTA` varchar(255)
,`idTipoPropietario` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view5`
--
CREATE TABLE IF NOT EXISTS `view5` (
`idUnidadTrabajo` int(10) unsigned
,`codigoUT` varchar(255)
,`tags` text
,`idTerceroSociedad` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`fechaCarga` date
,`fechaDescarga` date
,`idTerceroChofer` int(10) unsigned
,`clave` varchar(255)
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idEstadoUT` int(10) unsigned
,`remito` varchar(255)
,`archivoRemito` varchar(255)
,`diasDemora` int(10) unsigned
,`idTipoUT` int(10) unsigned
,`idTerceroShipper` varchar(255)
,`observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view6`
--
CREATE TABLE IF NOT EXISTS `view6` (
`idUnidadTrabajo` int(10) unsigned
,`idTerceroSociedad` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`fechaCarga` date
,`fechaFronteraI` date
,`fechaFronteraE` date
,`fechaDescarga` date
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idEstadoUT` int(10) unsigned
,`remito` varchar(255)
,`CRT` varchar(255)
,`MICDTA` varchar(255)
,`diasDemora` int(10) unsigned
,`codigoUT` varchar(255)
,`tags` text
,`idTerceroTransporte` int(10) unsigned
,`archivoMICDTA` varchar(255)
,`archivoCRT` varchar(255)
,`archivoRemito` varchar(255)
,`archivoFacturaCliente` varchar(255)
,`idTipoUT` int(10) unsigned
,`clave` varchar(255)
,`idTerceroShipper` varchar(255)
,`observaciones` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view7`
--
CREATE TABLE IF NOT EXISTS `view7` (
`idUnidadTrabajo` int(10) unsigned
,`codigoUT` varchar(255)
,`idTerceroSociedad` int(10) unsigned
,`idProvincia` int(10) unsigned
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`fechaCarga` date
,`fechaDescarga` date
,`idEstadoUT` int(10) unsigned
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idTerceroTransporte` int(10) unsigned
,`tags` text
,`utCerrado` tinyint(1)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view8`
--
CREATE TABLE IF NOT EXISTS `view8` (
`idUnidadTrabajo` int(10) unsigned
,`idTerceroSociedad` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`utCerrado` tinyint(1)
,`idEstadoUT` int(10) unsigned
,`codigoUT` varchar(255)
,`tags` text
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view9`
--
CREATE TABLE IF NOT EXISTS `view9` (
`codigoUT` varchar(255)
,`idTerceroSociedad` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`idEstadoUT` int(10) unsigned
,`idTipoUT` int(10) unsigned
,`remito` varchar(255)
,`CRT` varchar(255)
,`MICDTA` varchar(255)
,`idTerceroTransporte` int(10) unsigned
,`idTerceroFacturacion` int(10) unsigned
,`monVenta` int(10) unsigned
,`factVentaNac` varchar(255)
,`valorVentaNac` varchar(255)
,`factVentaInt` varchar(255)
,`valorVentaInt` varchar(255)
,`idUnidadTrabajo` int(10) unsigned
,`archivoFacturaCliente` varchar(255)
,`facturacion` tinyint(1)
,`idMonedaReferenciaFacturacion` int(10) unsigned
,`valorReferenciaFacturacion` float unsigned
,`idTerceroChofer` int(10) unsigned
,`facturaDemoraCliente` varchar(255)
,`valorFactDemora` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view10`
--
CREATE TABLE IF NOT EXISTS `view10` (
`idUnidadTrabajo` int(10) unsigned
,`codigoUT` varchar(255)
,`idEstadoUT` int(10) unsigned
,`idTerceroSociedad` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`utCerrado` tinyint(1)
,`tags` text
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view11`
--
CREATE TABLE IF NOT EXISTS `view11` (
`idTercero` int(10) unsigned
,`denominacion` varchar(255)
,`archivoEstatuto` varchar(255)
,`archivoInscripcionAFIP` varchar(255)
,`archivoInscripcionIIBB` varchar(255)
,`archivoAsambleaRenovacionCargos` varchar(255)
,`archivoRUTA` varchar(255)
,`archivoAdjunto1` varchar(255)
,`archivoAdjunto2` varchar(255)
,`archivoAdjunto3` varchar(255)
,`archivoAdjunto4` varchar(255)
,`archivoAdjunto5` varchar(255)
,`archivoAdjunto6` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view12`
--
CREATE TABLE IF NOT EXISTS `view12` (
`idTerceroSociedad` int(10) unsigned
,`viaje` varchar(255)
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`fechaCarga` date
,`idEstadoUT` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view13`
--
CREATE TABLE IF NOT EXISTS `view13` (
`codigoUT` varchar(255)
,`viaje` varchar(255)
,`idEstadoUT` int(10) unsigned
,`fechaCarga` date
,`idTerceroChofer` int(10) unsigned
,`idTerceroTransporte` int(10) unsigned
,`remito` varchar(255)
,`archivoRemito` varchar(255)
,`CRT` varchar(255)
,`archivoCRT` varchar(255)
,`MICDTA` varchar(255)
,`archivoMICDTA` varchar(255)
,`diasDemora` int(10) unsigned
,`idUnidadTrabajo` int(10) unsigned
,`tags` text
,`idTerceroShipper` varchar(255)
,`idPais` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view14`
--
CREATE TABLE IF NOT EXISTS `view14` (
`codigoUT` varchar(255)
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idTerceroTransporte` int(10) unsigned
,`remito` varchar(255)
,`MICDTA` varchar(255)
,`idTerceroFacturacion` int(10) unsigned
,`facturacion` tinyint(1)
,`monCompra` int(10) unsigned
,`valorCompraNac` varchar(255)
,`factCompraNac` varchar(255)
,`valorCompraInt` varchar(255)
,`factCompraInt` varchar(255)
,`valorCompra` double
,`valorVenta` double
,`idTipoPropietario` int(10) unsigned
,`idUnidadTrabajo` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view15`
--
CREATE TABLE IF NOT EXISTS `view15` (
`idUnidadTrabajo` int(10) unsigned
,`codigoUT` varchar(255)
,`idTerceroShipper` varchar(255)
,`viaje` varchar(255)
,`fechaCarga` date
,`fechaFronteraI` date
,`idPais` int(10) unsigned
,`idEstadoUT` int(10) unsigned
,`idTipoUT` int(10) unsigned
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idTerceroTransporte` int(10) unsigned
,`remito` varchar(255)
,`CRT` varchar(255)
,`MICDTA` varchar(255)
,`idTerceroFacturacion` int(10) unsigned
,`monCompra` int(10) unsigned
,`valorCompraNac` varchar(255)
,`factCompraNac` varchar(255)
,`valorCompraInt` varchar(255)
,`factCompraInt` varchar(255)
,`monVenta` int(10) unsigned
,`factVentaNac` varchar(255)
,`valorVentaNac` varchar(255)
,`factVentaInt` varchar(255)
,`valorVentaInt` varchar(255)
,`idMonedaReferenciaFacturacion` int(10) unsigned
,`valorReferenciaFacturacion` float unsigned
,`TotalCompra` double
,`TotalVenta` double
,`Resultado` double
,`idTipoPropietario` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `view16`
--
CREATE TABLE IF NOT EXISTS `view16` (
`codigoUT` varchar(255)
,`facturaCliente` varchar(255)
,`idCiudadOrigen` int(10) unsigned
,`idCiudadDestino` int(10) unsigned
,`idTerceroChofer` int(10) unsigned
,`idDominioTractor` int(10) unsigned
,`idDominioSemi` int(10) unsigned
,`idTerceroTransporte` int(10) unsigned
,`remito` varchar(255)
,`MICDTA` varchar(255)
,`idTerceroFacturacion` int(10) unsigned
,`facturacion` tinyint(1)
,`monCompra` int(10) unsigned
,`valorCompraNac` varchar(255)
,`factCompraNac` varchar(255)
,`valorCompraInt` varchar(255)
,`factCompraInt` varchar(255)
,`valorCompra` double
,`valorVenta` double
,`idTipoPropietario` int(10) unsigned
,`idUnidadTrabajo` int(10) unsigned
,`diasDemora` int(10) unsigned
,`facturaDemoraProv` varchar(255)
,`valorDemora` varchar(255)
);
-- --------------------------------------------------------

--
-- Estructura para la vista `analisisprecioxkm`
--
DROP TABLE IF EXISTS `analisisprecioxkm`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `analisisprecioxkm` AS select `unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaFronteraI` AS `fechaFronteraI`,`unidades-trabajo`.`idPais` AS `idPais`,`ciudades`.`denominacion` AS `origen`,`ciudades1`.`denominacion` AS `destino`,`unidades-trabajo`.`valorVentaNac` AS `valorVentaNac`,`unidades-trabajo`.`valorVentaInt` AS `valorVentaInt`,(ifnull(`unidades-trabajo`.`valorVentaInt`,0) + ifnull(`unidades-trabajo`.`valorVentaNac`,0)) AS `TotalVenta`,sum(`planillakmdetalle`.`kilometrosRecorridos`) AS `kilometrosRecorridos`,'0' AS `preciokm`,'0' AS `kilometrosVacio`,'0' AS `kilometrosCargado`,'0' AS `PorcentajeVacio` from ((((`planillakmcabecera` join `planillakmdetalle` on((`planillakmcabecera`.`idPlanillaKm` = `planillakmdetalle`.`idPlanillaKmCabecera`))) join `unidades-trabajo` on((`planillakmdetalle`.`idUt` = `unidades-trabajo`.`idUnidadTrabajo`))) join `ciudades` on((`unidades-trabajo`.`idCiudadOrigen` = `ciudades`.`idCiudad`))) join `ciudades` `ciudades1` on((`unidades-trabajo`.`idCiudadDestino` = `ciudades1`.`idCiudad`))) group by `unidades-trabajo`.`codigoUT`,(ifnull(`unidades-trabajo`.`valorVentaInt`,0) + ifnull(`unidades-trabajo`.`valorVentaNac`,0));

-- --------------------------------------------------------

--
-- Estructura para la vista `ciudades_provincias`
--
DROP TABLE IF EXISTS `ciudades_provincias`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ciudades_provincias` AS select `ciudades`.`idCiudad` AS `idCiudad`,`ciudades`.`denominacion` AS `denominacion`,`provincias`.`denominacion` AS `denominacion1`,`ciudades`.`idProvincia` AS `idProvincia`,`ciudades`.`denominacionCorta` AS `denominacionCorta` from (`provincias` join `ciudades` on((`ciudades`.`idProvincia` = `provincias`.`idProvincia`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `contracuentas`
--
DROP TABLE IF EXISTS `contracuentas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `contracuentas` AS select `esquema-contable2`.`Id_cuenta` AS `Id_cuenta`,`esquema-contable2`.`rubroContracuenta` AS `rubroContracuenta`,`esquema-contable2`.`Id_contracuenta` AS `Id_contracuenta`,`rubro-cuentas`.`rubroCuentas` AS `rubroCuentas`,`cuentas2`.`denominacionCuenta` AS `denominacionCuenta` from ((`cuentas2` join `esquema-contable2` on((`esquema-contable2`.`Id_contracuenta` = `cuentas2`.`Id_cuentas`))) join `rubro-cuentas` on((`esquema-contable2`.`rubroContracuenta` = `rubro-cuentas`.`Id_RubroCuentas`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `documentostipodocumentos`
--
DROP TABLE IF EXISTS `documentostipodocumentos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `documentostipodocumentos` AS select `documento-movimiento`.`Id_documentoMovimiento` AS `Id_documentoMovimiento`,`documentos`.`documento` AS `documento`,`tipo-documento`.`tipoDocumento` AS `tipoDocumento`,`documento-movimiento`.`Id_SaldoImpositivo` AS `Id_SaldoImpositivo` from ((`documento-movimiento` join `documentos` on((`documento-movimiento`.`Id_Documento` = `documentos`.`Id_Documentos`))) join `tipo-documento` on((`documento-movimiento`.`Id_tipoDocumento` = `tipo-documento`.`Id_tipoDocumento`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `drilldown`
--
DROP TABLE IF EXISTS `drilldown`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `drilldown` AS select 1 AS `1`;

-- --------------------------------------------------------

--
-- Estructura para la vista `mescontableactivo`
--
DROP TABLE IF EXISTS `mescontableactivo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `mescontableactivo` AS select `mes-contable`.`id_MesContable` AS `id_MesContable`,`mes-contable`.`mesContable` AS `mesContable` from `mes-contable` where isnull(`mes-contable`.`activo`);

-- --------------------------------------------------------

--
-- Estructura para la vista `view1`
--
DROP TABLE IF EXISTS `view1`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view1` AS select `terceros`.`idTercero` AS `idTercero`,`terceros`.`denominacion` AS `denominacion`,`terceros`.`denominacionCorta` AS `denominacionCorta`,`terceros`.`clave` AS `clave`,`terceros`.`idTipoTercero` AS `idTipoTercero`,`terceros`.`idCondicionIVA` AS `idCondicionIVA`,`terceros`.`eMail` AS `eMail` from `terceros`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view2`
--
DROP TABLE IF EXISTS `view2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view2` AS select `terceros`.`idTercero` AS `idTercero`,`terceros`.`denominacion` AS `denominacion`,`terceros`.`calle` AS `calle`,`terceros`.`numero` AS `numero`,`terceros`.`piso` AS `piso`,`terceros`.`departamento` AS `departamento`,`terceros`.`codigoPostal` AS `codigoPostal`,`terceros`.`idPais` AS `idPais`,`terceros`.`idProvincia` AS `idProvincia`,`terceros`.`idCiudad` AS `idCiudad`,`terceros`.`telefono` AS `telefono` from `terceros`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view3`
--
DROP TABLE IF EXISTS `view3`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view3` AS select `unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`idTerceroFacturacion` AS `idTerceroFacturacion`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idProvincia` AS `idProvincia`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaDescarga` AS `fechaDescarga`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idTipoUT` AS `idTipoUT`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`productos` AS `productos`,`unidades-trabajo`.`idUsuarioAlta` AS `idUsuarioAlta`,`unidades-trabajo`.`fechaAlta` AS `fechaAlta`,`unidades-trabajo`.`cantidad` AS `cantidad`,`unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`tags` AS `tags`,`unidades-trabajo`.`archivoFacturaCliente` AS `archivoFacturaCliente`,`unidades-trabajo`.`idTerceroShipper` AS `idTerceroShipper`,`unidades-trabajo`.`facturacion` AS `facturacion`,`unidades-trabajo`.`idPais` AS `idPais` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view4`
--
DROP TABLE IF EXISTS `view4`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view4` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaDescarga` AS `fechaDescarga`,`unidades-trabajo`.`idPais` AS `idPais`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`idProvincia` AS `idProvincia`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idTipoUT` AS `idTipoUT`,`unidades-trabajo`.`viajeLiquidado` AS `viajeLiquidado`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`CRT` AS `CRT`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`tags` AS `tags`,`unidades-trabajo`.`archivoRemito` AS `archivoRemito`,`unidades-trabajo`.`archivoCRT` AS `archivoCRT`,`unidades-trabajo`.`archivoMICDTA` AS `archivoMICDTA`,`dominios`.`idTipoPropietario` AS `idTipoPropietario` from (`unidades-trabajo` join `dominios` on((`unidades-trabajo`.`idDominioTractor` = `dominios`.`idDominio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `view5`
--
DROP TABLE IF EXISTS `view5`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view5` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`tags` AS `tags`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaDescarga` AS `fechaDescarga`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`terceros`.`clave` AS `clave`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`archivoRemito` AS `archivoRemito`,`unidades-trabajo`.`diasDemora` AS `diasDemora`,`unidades-trabajo`.`idTipoUT` AS `idTipoUT`,`unidades-trabajo`.`idTerceroShipper` AS `idTerceroShipper`,`unidades-trabajo`.`observaciones` AS `observaciones` from (`unidades-trabajo` join `terceros` on((`unidades-trabajo`.`idTerceroChofer` = `terceros`.`idTercero`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `view6`
--
DROP TABLE IF EXISTS `view6`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view6` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaFronteraI` AS `fechaFronteraI`,`unidades-trabajo`.`fechaFronteraE` AS `fechaFronteraE`,`unidades-trabajo`.`fechaDescarga` AS `fechaDescarga`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`CRT` AS `CRT`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`diasDemora` AS `diasDemora`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`tags` AS `tags`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`archivoMICDTA` AS `archivoMICDTA`,`unidades-trabajo`.`archivoCRT` AS `archivoCRT`,`unidades-trabajo`.`archivoRemito` AS `archivoRemito`,`unidades-trabajo`.`archivoFacturaCliente` AS `archivoFacturaCliente`,`unidades-trabajo`.`idTipoUT` AS `idTipoUT`,`terceros`.`clave` AS `clave`,`unidades-trabajo`.`idTerceroShipper` AS `idTerceroShipper`,`unidades-trabajo`.`observaciones` AS `observaciones` from (`unidades-trabajo` join `terceros` on((`unidades-trabajo`.`idTerceroChofer` = `terceros`.`idTercero`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `view7`
--
DROP TABLE IF EXISTS `view7`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view7` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`idProvincia` AS `idProvincia`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaDescarga` AS `fechaDescarga`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`tags` AS `tags`,`unidades-trabajo`.`utCerrado` AS `utCerrado` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view8`
--
DROP TABLE IF EXISTS `view8`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view8` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`utCerrado` AS `utCerrado`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`tags` AS `tags` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view9`
--
DROP TABLE IF EXISTS `view9`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view9` AS select `unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`idTipoUT` AS `idTipoUT`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`CRT` AS `CRT`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`idTerceroFacturacion` AS `idTerceroFacturacion`,`unidades-trabajo`.`monVenta` AS `monVenta`,`unidades-trabajo`.`factVentaNac` AS `factVentaNac`,`unidades-trabajo`.`valorVentaNac` AS `valorVentaNac`,`unidades-trabajo`.`factVentaInt` AS `factVentaInt`,`unidades-trabajo`.`valorVentaInt` AS `valorVentaInt`,`unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`archivoFacturaCliente` AS `archivoFacturaCliente`,`unidades-trabajo`.`facturacion` AS `facturacion`,`unidades-trabajo`.`idMonedaReferenciaFacturacion` AS `idMonedaReferenciaFacturacion`,`unidades-trabajo`.`valorReferenciaFacturacion` AS `valorReferenciaFacturacion`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`facturaDemoraCliente` AS `facturaDemoraCliente`,`unidades-trabajo`.`valorFactDemora` AS `valorFactDemora` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view10`
--
DROP TABLE IF EXISTS `view10`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view10` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`utCerrado` AS `utCerrado`,`unidades-trabajo`.`tags` AS `tags` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view11`
--
DROP TABLE IF EXISTS `view11`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view11` AS select `terceros`.`idTercero` AS `idTercero`,`terceros`.`denominacion` AS `denominacion`,`terceros`.`archivoEstatuto` AS `archivoEstatuto`,`terceros`.`archivoInscripcionAFIP` AS `archivoInscripcionAFIP`,`terceros`.`archivoInscripcionIIBB` AS `archivoInscripcionIIBB`,`terceros`.`archivoAsambleaRenovacionCargos` AS `archivoAsambleaRenovacionCargos`,`terceros`.`archivoRUTA` AS `archivoRUTA`,`terceros`.`archivoAdjunto1` AS `archivoAdjunto1`,`terceros`.`archivoAdjunto2` AS `archivoAdjunto2`,`terceros`.`archivoAdjunto3` AS `archivoAdjunto3`,`terceros`.`archivoAdjunto4` AS `archivoAdjunto4`,`terceros`.`archivoAdjunto5` AS `archivoAdjunto5`,`terceros`.`archivoAdjunto6` AS `archivoAdjunto6` from `terceros`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view12`
--
DROP TABLE IF EXISTS `view12`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view12` AS select `unidades-trabajo`.`idTerceroSociedad` AS `idTerceroSociedad`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view13`
--
DROP TABLE IF EXISTS `view13`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view13` AS select `unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`archivoRemito` AS `archivoRemito`,`unidades-trabajo`.`CRT` AS `CRT`,`unidades-trabajo`.`archivoCRT` AS `archivoCRT`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`archivoMICDTA` AS `archivoMICDTA`,`unidades-trabajo`.`diasDemora` AS `diasDemora`,`unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`tags` AS `tags`,`unidades-trabajo`.`idTerceroShipper` AS `idTerceroShipper`,`unidades-trabajo`.`idPais` AS `idPais` from `unidades-trabajo`;

-- --------------------------------------------------------

--
-- Estructura para la vista `view14`
--
DROP TABLE IF EXISTS `view14`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view14` AS select `unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`idTerceroFacturacion` AS `idTerceroFacturacion`,`unidades-trabajo`.`facturacion` AS `facturacion`,`unidades-trabajo`.`monCompra` AS `monCompra`,`unidades-trabajo`.`valorCompraNac` AS `valorCompraNac`,`unidades-trabajo`.`factCompraNac` AS `factCompraNac`,`unidades-trabajo`.`valorCompraInt` AS `valorCompraInt`,`unidades-trabajo`.`factCompraInt` AS `factCompraInt`,(`unidades-trabajo`.`valorCompraInt` + `unidades-trabajo`.`valorCompraNac`) AS `valorCompra`,(`unidades-trabajo`.`valorVentaInt` + `unidades-trabajo`.`valorVentaNac`) AS `valorVenta`,`dominios`.`idTipoPropietario` AS `idTipoPropietario`,`unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo` from (`unidades-trabajo` join `dominios` on((`unidades-trabajo`.`idDominioTractor` = `dominios`.`idDominio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `view15`
--
DROP TABLE IF EXISTS `view15`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view15` AS select `unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`idTerceroShipper` AS `idTerceroShipper`,`unidades-trabajo`.`viaje` AS `viaje`,`unidades-trabajo`.`fechaCarga` AS `fechaCarga`,`unidades-trabajo`.`fechaFronteraI` AS `fechaFronteraI`,`unidades-trabajo`.`idPais` AS `idPais`,`unidades-trabajo`.`idEstadoUT` AS `idEstadoUT`,`unidades-trabajo`.`idTipoUT` AS `idTipoUT`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`CRT` AS `CRT`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`idTerceroFacturacion` AS `idTerceroFacturacion`,`unidades-trabajo`.`monCompra` AS `monCompra`,`unidades-trabajo`.`valorCompraNac` AS `valorCompraNac`,`unidades-trabajo`.`factCompraNac` AS `factCompraNac`,`unidades-trabajo`.`valorCompraInt` AS `valorCompraInt`,`unidades-trabajo`.`factCompraInt` AS `factCompraInt`,`unidades-trabajo`.`monVenta` AS `monVenta`,`unidades-trabajo`.`factVentaNac` AS `factVentaNac`,`unidades-trabajo`.`valorVentaNac` AS `valorVentaNac`,`unidades-trabajo`.`factVentaInt` AS `factVentaInt`,`unidades-trabajo`.`valorVentaInt` AS `valorVentaInt`,`unidades-trabajo`.`idMonedaReferenciaFacturacion` AS `idMonedaReferenciaFacturacion`,`unidades-trabajo`.`valorReferenciaFacturacion` AS `valorReferenciaFacturacion`,(ifnull(`unidades-trabajo`.`valorCompraInt`,0) + ifnull(`unidades-trabajo`.`valorCompraNac`,0)) AS `TotalCompra`,(ifnull(`unidades-trabajo`.`valorVentaInt`,0) + ifnull(`unidades-trabajo`.`valorVentaNac`,0)) AS `TotalVenta`,((ifnull(`unidades-trabajo`.`valorVentaInt`,0) + ifnull(`unidades-trabajo`.`valorVentaNac`,0)) - (ifnull(`unidades-trabajo`.`valorCompraInt`,0) + ifnull(`unidades-trabajo`.`valorCompraNac`,0))) AS `Resultado`,`dominios`.`idTipoPropietario` AS `idTipoPropietario` from (`unidades-trabajo` join `dominios` on((`unidades-trabajo`.`idDominioTractor` = `dominios`.`idDominio`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `view16`
--
DROP TABLE IF EXISTS `view16`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view16` AS select `unidades-trabajo`.`codigoUT` AS `codigoUT`,`unidades-trabajo`.`facturaCliente` AS `facturaCliente`,`unidades-trabajo`.`idCiudadOrigen` AS `idCiudadOrigen`,`unidades-trabajo`.`idCiudadDestino` AS `idCiudadDestino`,`unidades-trabajo`.`idTerceroChofer` AS `idTerceroChofer`,`unidades-trabajo`.`idDominioTractor` AS `idDominioTractor`,`unidades-trabajo`.`idDominioSemi` AS `idDominioSemi`,`unidades-trabajo`.`idTerceroTransporte` AS `idTerceroTransporte`,`unidades-trabajo`.`remito` AS `remito`,`unidades-trabajo`.`MICDTA` AS `MICDTA`,`unidades-trabajo`.`idTerceroFacturacion` AS `idTerceroFacturacion`,`unidades-trabajo`.`facturacion` AS `facturacion`,`unidades-trabajo`.`monCompra` AS `monCompra`,`unidades-trabajo`.`valorCompraNac` AS `valorCompraNac`,`unidades-trabajo`.`factCompraNac` AS `factCompraNac`,`unidades-trabajo`.`valorCompraInt` AS `valorCompraInt`,`unidades-trabajo`.`factCompraInt` AS `factCompraInt`,(ifnull(`unidades-trabajo`.`valorCompraInt`,0) + ifnull(`unidades-trabajo`.`valorCompraNac`,0)) AS `valorCompra`,(ifnull(`unidades-trabajo`.`valorVentaInt`,0) + ifnull(`unidades-trabajo`.`valorVentaNac`,0)) AS `valorVenta`,`dominios`.`idTipoPropietario` AS `idTipoPropietario`,`unidades-trabajo`.`idUnidadTrabajo` AS `idUnidadTrabajo`,`unidades-trabajo`.`diasDemora` AS `diasDemora`,`unidades-trabajo`.`facturaDemoraProv` AS `facturaDemoraProv`,`unidades-trabajo`.`valorDemora` AS `valorDemora` from (`unidades-trabajo` join `dominios` on((`unidades-trabajo`.`idDominioTractor` = `dominios`.`idDominio`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
