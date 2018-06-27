DROP SCHEMA IF EXISTS `AML-API` ;

CREATE SCHEMA IF NOT EXISTS `AML-API` DEFAULT CHARACTER SET utf8 ;

USE `AML-API` ;

DROP TABLE IF EXISTS `AML-API`.`empresas` ;

CREATE TABLE IF NOT EXISTS `AML-API`.`empresas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `razon_social` VARCHAR(45) NOT NULL,
  `cuit` VARCHAR(45) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  UNIQUE INDEX `cuit_UNIQUE` (`cuit` ASC),
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `AML-API`.`clientes` ;

CREATE TABLE IF NOT EXISTS `AML-API`.`clientes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `cuit` VARCHAR(11) NULL,
  `cuil` VARCHAR(11) NULL,
  `empresa_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `empresa_id`),
  INDEX `fk_cliente_empresa_idx` (`empresa_id` ASC),
  UNIQUE INDEX `cuil_empresa_id` (`empresa_id` ASC, `cuil` ASC),
  UNIQUE INDEX `cuit_empresa_id` (`cuit` ASC, `empresa_id` ASC),
  CONSTRAINT `fk_clientes_empresa_id_empresas_id`
    FOREIGN KEY (`empresa_id`)
    REFERENCES `AML-API`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

DROP TABLE IF EXISTS `AML-API`.`facturas` ;

CREATE TABLE IF NOT EXISTS `AML-API`.`facturas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero` VARCHAR(45) NOT NULL,
  `subtotal` DECIMAL(5,2) NOT NULL,
  `iva` DECIMAL(5,2) GENERATED ALWAYS AS (subtotal*(21/100)) STORED,
  `total` DECIMAL(5,2) GENERATED ALWAYS AS (subtotal+iva) STORED,
  `empresa_id` INT UNSIGNED NOT NULL,
  `cliente_id` INT UNSIGNED NOT NULL,
  `created_at` DATETIME NOT NULL,
  `updated_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`, `empresa_id`, `cliente_id`),
  INDEX `fk_factura_cliente_id_clientes_id_idx` (`cliente_id` ASC),
  INDEX `fk_facturas_empresa_id_empresas_id_idx` (`empresa_id` ASC),
  INDEX `numero` (`numero` ASC),
  CONSTRAINT `fk_factura_cliente_id_clientes_id`
    FOREIGN KEY (`cliente_id`)
    REFERENCES `AML-API`.`clientes` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_facturas_empresa_id_empresas_id`
    FOREIGN KEY (`empresa_id`)
    REFERENCES `AML-API`.`empresas` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;
