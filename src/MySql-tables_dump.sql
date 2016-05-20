-- MySQL Script generated by MySQL Workbench
-- Fri May 20 12:34:20 2016
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema security_exam
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `security_exam` ;

-- -----------------------------------------------------
-- Schema security_exam
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `security_exam` DEFAULT CHARACTER SET utf8 ;
USE `security_exam` ;

-- -----------------------------------------------------
-- Table `security_exam`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_exam`.`users` ;

CREATE TABLE IF NOT EXISTS `security_exam`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `admin` TINYINT(1) NOT NULL,
  `active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `security_exam`.`gifs`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `security_exam`.`gifs` ;

CREATE TABLE IF NOT EXISTS `security_exam`.`gifs` (
  `gif_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `uploaded` DATETIME NOT NULL,
  `pending` TINYINT(1) NOT NULL,
  `accepted` TINYINT(1) NOT NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`gif_id`),
  UNIQUE INDEX `src_UNIQUE` (`name` ASC),
  INDEX `fk_gifs_users_idx` (`user_id` ASC),
  CONSTRAINT `fk_gifs_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `security_exam`.`users` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;