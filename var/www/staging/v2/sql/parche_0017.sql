CREATE TABLE `trama_lineas-productos` ( `id` INT NOT NULL AUTO_INCREMENT , `id_categoria` INT NOT NULL,  `denominacion` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

CREATE TABLE `trama_marcas-productos` ( `id` INT NOT NULL AUTO_INCREMENT , `denominacion` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;