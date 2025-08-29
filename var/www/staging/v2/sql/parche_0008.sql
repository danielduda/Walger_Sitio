CREATE TABLE `trama_favoritos` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `idUsuario` INT NULL , `idArticulo` INT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `trama_favoritos` ADD UNIQUE(`idUsuario`,`idArticulo`);
ALTER TABLE `trama_favoritos` CHANGE `idArticulo` `idArticulo` VARCHAR(24) NULL DEFAULT NULL;