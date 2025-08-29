-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2015 a las 22:18:43
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `gestion_walger`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dbo_cliente`
--

CREATE TABLE IF NOT EXISTS `dbo_cliente` (
  `CodigoCli` varchar(10) NOT NULL,
  `RazonSocialCli` varchar(60) NOT NULL,
  `CuitCli` varchar(13) NOT NULL,
  `IngBrutosCli` varchar(18) NOT NULL,
  `Regis_IvaC` int(11) NOT NULL,
  `Regis_ListaPrec` int(11) NOT NULL,
  `emailCli` varchar(50) NOT NULL,
  `RazonSocialFlete` varchar(50) NOT NULL,
  `Direccion` varchar(90) NOT NULL,
  `BarrioCli` varchar(30) NOT NULL,
  `LocalidadCli` varchar(40) NOT NULL,
  `DescrProvincia` varchar(40) NOT NULL,
  `CodigoPostalCli` varchar(10) NOT NULL,
  `DescrPais` varchar(40) NOT NULL,
  `Telefono` varchar(90) NOT NULL,
  `FaxCli` varchar(30) NOT NULL,
  `PaginaWebCli` varchar(40) NOT NULL,
  PRIMARY KEY (`CodigoCli`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `dbo_cliente`
--

INSERT INTO `dbo_cliente` (`CodigoCli`, `RazonSocialCli`, `CuitCli`, `IngBrutosCli`, `Regis_IvaC`, `Regis_ListaPrec`, `emailCli`, `RazonSocialFlete`, `Direccion`, `BarrioCli`, `LocalidadCli`, `DescrProvincia`, `CodigoPostalCli`, `DescrPais`, `Telefono`, `FaxCli`, `PaginaWebCli`) VALUES
('CF121', 'diaz pablo walter', '20-21964648-9', '20-21964648-9', 1, 1, 'proveedores@nh-repuestos.com.ar', 'PERSONAL', 'Humboldt 199', 'asd', 'Villa Crespo', 'buenos aires', '1414', 'argentina', '4854-3431 | 1565128394 | 54*243*1006', '4854-3431', 'www.nh-repuestos.com.ar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estilopaquete`
--

CREATE TABLE IF NOT EXISTS `estilopaquete` (
  `Id_estiloPaquete` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `estiloPaquete` varchar(20) NOT NULL,
  PRIMARY KEY (`Id_estiloPaquete`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `estilopaquete`
--

INSERT INTO `estilopaquete` (`Id_estiloPaquete`, `estiloPaquete`) VALUES
(1, 'caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE IF NOT EXISTS `facturas` (
  `numFactura` varchar(10) NOT NULL,
  `RemitoCabecera` int(11) NOT NULL,
  PRIMARY KEY (`numFactura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`numFactura`, `RemitoCabecera`) VALUES
('15519', 1),
('345345', 2),
('3453454353', 3),
('56546', 3),
('657567', 1);

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
(0, 'Default');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operadores`
--

CREATE TABLE IF NOT EXISTS `operadores` (
  `Id_Operadores` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreOperadores` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Operadores`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `operadores`
--

INSERT INTO `operadores` (`Id_Operadores`, `nombreOperadores`) VALUES
(1, 'op prueba');

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
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}dbo_cliente', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}facturas', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}niveles', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}operadores', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}permisos', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}proveedores', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}remitos', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}remitos_detalle', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}transporte', 0),
(0, '{B81C6C2E-1100-4548-836E-685E96F6B551}usuarios', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `Id_Productos` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `denominacion` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Productos`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`Id_Productos`, `denominacion`) VALUES
(1, 'wer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `Id_Proveedores` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Proveedores`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`Id_Proveedores`, `razonSocial`) VALUES
(1, 'prov prueba');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `remitodetalle`
--
CREATE TABLE IF NOT EXISTS `remitodetalle` (
`Id_RemitoDetalle` int(10) unsigned
,`remitoCabecera` int(11)
,`cantidad` varchar(5)
,`descripcion` int(11)
,`CodigoCli` varchar(10)
,`RazonSocialCli` varchar(60)
,`Direccion` varchar(90)
,`LocalidadCli` varchar(40)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remitos`
--

CREATE TABLE IF NOT EXISTS `remitos` (
  `Id_Remito` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Cliente` varchar(10) DEFAULT NULL,
  `Proveedor` int(11) DEFAULT NULL,
  `Transporte` int(11) DEFAULT NULL,
  `NumeroDeBultos` int(11) DEFAULT NULL,
  `OperadorTraslado` int(11) DEFAULT NULL,
  `OperadorEntrego` int(11) DEFAULT NULL,
  `OperadorVerifico` int(11) DEFAULT NULL,
  `Observaciones` varchar(100) DEFAULT NULL,
  `observacionesInternas` varchar(255) NOT NULL,
  `Importe` varchar(10) DEFAULT NULL,
  `facturas` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Remito`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `remitos`
--

INSERT INTO `remitos` (`Id_Remito`, `Fecha`, `Cliente`, `Proveedor`, `Transporte`, `NumeroDeBultos`, `OperadorTraslado`, `OperadorEntrego`, `OperadorVerifico`, `Observaciones`, `observacionesInternas`, `Importe`, `facturas`) VALUES
(1, '2014-12-08', 'CF121', 1, 1, 2, 1, 1, 1, 'd', 'asd', '2', ''),
(2, '2014-12-08', 'CF121', 1, 1, 5, 1, 1, 1, 't', '', '5', '5'),
(3, '2014-12-08', 'CF121', 1, 1, 1, 1, 1, 1, NULL, '', NULL, NULL),
(4, '2014-12-17', 'CF121', 1, 1, 3, 1, 1, 1, NULL, '', '3', NULL);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `remitosclientes`
--
CREATE TABLE IF NOT EXISTS `remitosclientes` (
`Id_Remito` int(10) unsigned
,`CodigoCli` varchar(10)
,`RazonSocialCli` varchar(60)
,`Direccion` varchar(90)
,`LocalidadCli` varchar(40)
);
-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `remitosview`
--
CREATE TABLE IF NOT EXISTS `remitosview` (
`Id_Remito` int(10) unsigned
,`Cliente` varchar(10)
,`Fecha` date
,`Proveedor` int(11)
,`Transporte` int(11)
,`OperadorTraslado` int(11)
,`NumeroDeBultos` int(11)
,`OperadorEntrego` int(11)
,`OperadorVerifico` int(11)
,`Observaciones` varchar(100)
,`Importe` varchar(10)
,`facturas` varchar(50)
,`Id_RemitoDetalle` int(10) unsigned
,`remitoCabecera` int(11)
,`cantidad` varchar(5)
,`descripcion` int(11)
);
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remitos_detalle`
--

CREATE TABLE IF NOT EXISTS `remitos_detalle` (
  `Id_RemitoDetalle` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `remitoCabecera` int(11) NOT NULL,
  `cantidad` varchar(5) NOT NULL,
  `descripcion` int(11) NOT NULL,
  PRIMARY KEY (`Id_RemitoDetalle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `remitos_detalle`
--

INSERT INTO `remitos_detalle` (`Id_RemitoDetalle`, `remitoCabecera`, `cantidad`, `descripcion`) VALUES
(1, 1, '3', 1),
(2, 1, '2', 1),
(3, 2, '7', 1),
(4, 1, '4', 1),
(5, 4, '2', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transporte`
--

CREATE TABLE IF NOT EXISTS `transporte` (
  `Id_Transporte` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `razonSocial` varchar(50) NOT NULL,
  PRIMARY KEY (`Id_Transporte`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `transporte`
--

INSERT INTO `transporte` (`Id_Transporte`, `razonSocial`) VALUES
(1, 'Trans prueba');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `usuario`, `contrasenia`, `nombre`, `apellido`, `email`, `idNivel`, `activo`, `observaciones`) VALUES
(1, 'admin', '654321', 'Administrador', 'Prueba', 'admin@prueba.com.ar', -1, 1, ''),
(7, 'prueba', '123456', 'Usuario', 'Prueba', 'usuario@prueba.com.ar', 0, 1, '');

-- --------------------------------------------------------

--
-- Estructura para la vista `remitodetalle`
--
DROP TABLE IF EXISTS `remitodetalle`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remitodetalle` AS select `remitos_detalle`.`Id_RemitoDetalle` AS `Id_RemitoDetalle`,`remitos_detalle`.`remitoCabecera` AS `remitoCabecera`,`remitos_detalle`.`cantidad` AS `cantidad`,`remitos_detalle`.`descripcion` AS `descripcion`,`dbo_cliente`.`CodigoCli` AS `CodigoCli`,`dbo_cliente`.`RazonSocialCli` AS `RazonSocialCli`,`dbo_cliente`.`Direccion` AS `Direccion`,`dbo_cliente`.`LocalidadCli` AS `LocalidadCli` from (`remitos_detalle` join `dbo_cliente` on((`remitos_detalle`.`remitoCabecera` = `dbo_cliente`.`CodigoCli`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `remitosclientes`
--
DROP TABLE IF EXISTS `remitosclientes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remitosclientes` AS select `remitos`.`Id_Remito` AS `Id_Remito`,`dbo_cliente`.`CodigoCli` AS `CodigoCli`,`dbo_cliente`.`RazonSocialCli` AS `RazonSocialCli`,`dbo_cliente`.`Direccion` AS `Direccion`,`dbo_cliente`.`LocalidadCli` AS `LocalidadCli` from (`remitos` join `dbo_cliente` on((`remitos`.`Cliente` = `dbo_cliente`.`CodigoCli`)));

-- --------------------------------------------------------

--
-- Estructura para la vista `remitosview`
--
DROP TABLE IF EXISTS `remitosview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `remitosview` AS select `remitos`.`Id_Remito` AS `Id_Remito`,`remitos`.`Cliente` AS `Cliente`,`remitos`.`Fecha` AS `Fecha`,`remitos`.`Proveedor` AS `Proveedor`,`remitos`.`Transporte` AS `Transporte`,`remitos`.`OperadorTraslado` AS `OperadorTraslado`,`remitos`.`NumeroDeBultos` AS `NumeroDeBultos`,`remitos`.`OperadorEntrego` AS `OperadorEntrego`,`remitos`.`OperadorVerifico` AS `OperadorVerifico`,`remitos`.`Observaciones` AS `Observaciones`,`remitos`.`Importe` AS `Importe`,`remitos`.`facturas` AS `facturas`,`remitos_detalle`.`Id_RemitoDetalle` AS `Id_RemitoDetalle`,`remitos_detalle`.`remitoCabecera` AS `remitoCabecera`,`remitos_detalle`.`cantidad` AS `cantidad`,`remitos_detalle`.`descripcion` AS `descripcion` from (`remitos` join `remitos_detalle` on((`remitos`.`Id_Remito` = `remitos_detalle`.`remitoCabecera`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
