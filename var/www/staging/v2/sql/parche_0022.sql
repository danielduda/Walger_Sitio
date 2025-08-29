CREATE TABLE `trama_mensajes-publicos-leidos` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`idMensajePublico` INT(11) UNSIGNED NULL DEFAULT NULL,
	`idCliente` INT(11) UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `trama_mensajes-clientes` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`idCliente` INT(11) UNSIGNED NULL DEFAULT NULL,
	`fecha` DATETIME NULL DEFAULT NULL,
	`mensaje` TEXT NULL DEFAULT NULL,
	`leido` INT UNSIGNED NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `trama_mensajes-clientes`
	CHANGE COLUMN `idCliente` `idCliente` VARCHAR(10) NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `trama_mensajes-publicos-leidos`
	CHANGE COLUMN `idCliente` `idCliente` VARCHAR(10) NULL DEFAULT NULL AFTER `idMensajePublico`;
	
