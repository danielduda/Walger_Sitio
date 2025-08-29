CREATE TABLE `trama_newsletter` ( `id` INT UNSIGNED NOT NULL AUTO_INCREMENT , `email` VARCHAR(100) NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `trama_newsletter` ADD UNIQUE(`email`);