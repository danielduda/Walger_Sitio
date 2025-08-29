CREATE TABLE `trama_tipos_clientes` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `denominacion` VARCHAR(50) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
INSERT INTO `trama_tipos_clientes` (`id`, `denominacion`) VALUES (NULL, 'Casa de repuestos'), (NULL, 'Distribuidor'), (NULL, 'Consumidor Final');
