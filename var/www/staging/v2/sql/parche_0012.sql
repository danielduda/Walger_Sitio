ALTER TABLE `walger_pedidos` CHANGE `CodigoCli` `CodigoCli` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '';
ALTER TABLE `trama_favoritos` CHANGE `idUsuario` `idUsuario` VARCHAR(50) NULL DEFAULT NULL;
ALTER TABLE `trama_favoritos` CHANGE `idUsuario` `idUsuario` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'FKCodigoCli';