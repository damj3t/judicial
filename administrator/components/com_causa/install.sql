CREATE TABLE IF NOT EXISTS `#__clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `rut` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL DEFAULT '',
  `telefono` varchar(255) NOT NULL DEFAULT '',
  `celular` varchar(255) NOT NULL DEFAULT '',
  `ocupacion` varchar(255) NOT NULL DEFAULT '',
  `id_abogado` int(11),
  `comentario` mediumtext,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
