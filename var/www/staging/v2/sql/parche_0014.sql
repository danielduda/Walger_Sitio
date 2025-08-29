ALTER TABLE `trama_descargas` CHANGE `tamanoArchivo` `tamanoArchivo` INT UNSIGNED NULL DEFAULT NULL;

ALTER TABLE `trama_descargas` CHANGE `inactivo` `activo` TINYINT(4) NULL DEFAULT NULL;

ALTER TABLE `trama_descargas` CHANGE `tipoArchivo` `tipoArchivo` VARCHAR(5) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;