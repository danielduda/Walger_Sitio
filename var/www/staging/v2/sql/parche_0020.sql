ALTER TABLE `trama_slider` ADD `activo` TINYINT UNSIGNED NOT NULL AFTER `link`;

ALTER TABLE `trama_slider` ADD `titulo` VARCHAR(255) NULL AFTER `id`;