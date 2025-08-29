ALTER TABLE `trama_medios-pagos`
	ADD COLUMN `recargo` FLOAT UNSIGNED NULL DEFAULT '0' AFTER `activo`;
