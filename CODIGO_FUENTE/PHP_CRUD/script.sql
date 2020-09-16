-- CREAR LA BASE DE DATOS colegio
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE IF NOT EXISTS `alumno` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(255) NOT NULL,
  `APELLIDO` varchar(255) NOT NULL,
  `GRADO` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`ID`, `NOMBRE`, `APELLIDO`, `GRADO`) VALUES
(36, 'ADRIANA', 'MORALES', 7),
(39, 'Rafael', 'Mamani', 1),
(40, 'Pepe', 'Rios', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `telefono` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `nombre`, `apellido`, `telefono`) VALUES
(1, '0', '0', 222),
(2, 'JUAN', 'PEREZ', 23123);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
