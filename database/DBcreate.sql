-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema schedulrDB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `schedulrDB` ;

-- -----------------------------------------------------
-- Schema schedulrDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `schedulrDB` ;
USE `schedulrDB` ;



-- -----------------------------------------------------
-- Table `schedulrDB`.`CONGREGATION`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`CONGREGATION` (
  `congregation_ID` INT NOT NULL AUTO_INCREMENT,
  `congregation_name` VARCHAR(255) NULL,
  `congregation_street_address` VARCHAR(155) NULL,
  `congregation_phone` VARCHAR(11) NULL,
  `congregation_bus_need` TINYINT(1) NULL,
  `congregation_city` VARCHAR(45) NULL,
  `congregation_state` CHAR(2) NULL,
  `congregation_zip` CHAR(5) NULL,
  PRIMARY KEY (`congregation_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`USER`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`USER` (
  `user_ID` INT NOT NULL AUTO_INCREMENT,
  `password` VARCHAR(255) NULL,
  `email` VARCHAR(255) NULL,
  `phone_number` VARCHAR(11) NULL,
  `first_name` VARCHAR(45) NULL,
  `last_name` VARCHAR(45) NULL,
  `user_type` CHAR(1) NULL,
  `congregation_ID` INT NOT NULL,
  PRIMARY KEY (`user_ID`),
  INDEX `congregation_ID_idx` (`congregation_ID` ASC),
  CONSTRAINT `u_congregation_ID_fk`
    FOREIGN KEY (`congregation_ID`)
    REFERENCES `schedulrDB`.`CONGREGATION` (`congregation_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`BLACKOUT_DATE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`BLACKOUT_DATE` (
  `blackout_date_ID` INT NOT NULL AUTO_INCREMENT,
  `blackout_date_start` DATETIME NULL,
  `blackout_date_end` DATETIME NULL,
  PRIMARY KEY (`blackout_date_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`CONGREGATION_BLACKOUT_DATE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`CONGREGATION_BLACKOUT_DATE` (
  `congregation_ID` INT NOT NULL,
  `blackout_date_ID` INT NOT NULL,
  PRIMARY KEY (`congregation_ID`, `blackout_date_ID`),
  INDEX `blackout_date_ID_idx` (`blackout_date_ID` ASC),
  CONSTRAINT `cbd_congregation_ID_fk`
    FOREIGN KEY (`congregation_ID`)
    REFERENCES `schedulrDB`.`CONGREGATION` (`congregation_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `cbd_blackout_date_ID_fk`
    FOREIGN KEY (`blackout_date_ID`)
    REFERENCES `schedulrDB`.`BLACKOUT_DATE` (`blackout_date_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`CONGREGATION_SCHEDULE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`CONGREGATION_SCHEDULE` (
  `congregation_schedule_ID` INT NOT NULL AUTO_INCREMENT,
  `congregation_schedule_name` VARCHAR(100) NULL,
  `congregation_schedule_start_date` DATE NULL,
  `congregation_schedule_end_date` DATE NULL,
  PRIMARY KEY (`congregation_schedule_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`CONGREGATION_SCHEDULE_ASSIGNMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`CONGREGATION_SCHEDULE_ASSIGNMENT` (
  `congregation_ID` INT NOT NULL,
  `congregation_schedule_ID` INT NOT NULL,
  `scheduled_date_start` DATE NOT NULL,
  `scheduled_date_end` DATE NOT NULL,
  PRIMARY KEY (`congregation_ID`, `congregation_schedule_ID`, `scheduled_date_start`, `scheduled_date_end`),
  INDEX `congregation_schedule_ID_idx` (`congregation_schedule_ID` ASC),
  CONSTRAINT `csm_congregation_ID_fk`
    FOREIGN KEY (`congregation_ID`)
    REFERENCES `schedulrDB`.`CONGREGATION` (`congregation_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `csm_congregation_schedule_ID_fk`
    FOREIGN KEY (`congregation_schedule_ID`)
    REFERENCES `schedulrDB`.`CONGREGATION_SCHEDULE` (`congregation_schedule_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`SCHEDULE_STATE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`SCHEDULE_STATE` (
  `state_ID` INT NOT NULL AUTO_INCREMENT,
  `state_name` VARCHAR(45) NULL,
  PRIMARY KEY (`state_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`CONGREGATION_SCHEDULE_HISTORY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`CONGREGATION_SCHEDULE_HISTORY` (
  `congregation_schedule_ID` INT NOT NULL,
  `state_ID` INT NOT NULL,
  `work_start_date` DATE NULL,
  `work_start_time` TIME NULL,
  `work_end_date` DATE NULL,
  `work_end_time` TIME NULL,
  PRIMARY KEY (`congregation_schedule_ID`, `state_ID`),
  INDEX `state_ID_idx` (`state_ID` ASC),
  CONSTRAINT `csh_congregation_schedule_ID_fk`
    FOREIGN KEY (`congregation_schedule_ID`)
    REFERENCES `schedulrDB`.`CONGREGATION_SCHEDULE` (`congregation_schedule_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `csh_state_ID_fk`
    FOREIGN KEY (`state_ID`)
    REFERENCES `schedulrDB`.`SCHEDULE_STATE` (`state_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`BUS_SCHEDULE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`BUS_SCHEDULE` (
  `bus_schedule_ID` INT NOT NULL AUTO_INCREMENT,
  `bus_schedule_name` VARCHAR(100) NULL,
  `bus_schedule_start` DATE NULL,
  `bus_schedule_end` DATE NULL,
  PRIMARY KEY (`bus_schedule_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`BUS_SCHEDULE_HISTORY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`BUS_SCHEDULE_HISTORY` (
  `bus_schedule_ID` INT NOT NULL,
  `state_ID` INT NOT NULL,
  `work_start_date` DATE NULL,
  `work_start_time` TIME NULL,
  `work_end_date` DATE NULL,
  `work_end_time` TIME NULL,
  PRIMARY KEY (`bus_schedule_ID`, `state_ID`),
  INDEX `state_ID_idx` (`state_ID` ASC),
  CONSTRAINT `bsh_bus_schedule_ID_fk`
    FOREIGN KEY (`bus_schedule_ID`)
    REFERENCES `schedulrDB`.`BUS_SCHEDULE` (`bus_schedule_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bsh_state_ID_fk`
    FOREIGN KEY (`state_ID`)
    REFERENCES `schedulrDB`.`SCHEDULE_STATE` (`state_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`BUS_SCHEDULE_ASSIGNMENT`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`BUS_SCHEDULE_ASSIGNMENT` (
  `user_ID` INT NOT NULL,
  `bus_schedule_ID` INT NOT NULL,
  `scheduled_day` DATE NULL,
  `scheduled_time_of_day` CHAR(2) NULL,
  `backup` INT NULL,
  PRIMARY KEY (`user_ID`, `bus_schedule_ID`),
  INDEX `bus_schedule_ID_idx` (`bus_schedule_ID` ASC),
  CONSTRAINT `bsa_user_ID_fk`
    FOREIGN KEY (`user_ID`)
    REFERENCES `schedulrDB`.`USER` (`user_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bsa_bus_schedule_ID_fk`
    FOREIGN KEY (`bus_schedule_ID`)
    REFERENCES `schedulrDB`.`BUS_SCHEDULE` (`bus_schedule_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`AVAILABILITY_DATE`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`AVAILABILITY_DATE` (
  `availability_date_ID` INT NOT NULL AUTO_INCREMENT,
  `availability_day` DATE NULL,
  `availability_time_of_day` CHAR(2) NULL,
  PRIMARY KEY (`availability_date_ID`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `schedulrDB`.`BUS_DRIVER_AVAILABILITY`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedulrDB`.`BUS_DRIVER_AVAILABILITY` (
  `user_ID` INT NOT NULL,
  `availability_date_ID` INT NOT NULL,
  PRIMARY KEY (`user_ID`, `availability_date_ID`),
  INDEX `availability_idx` (`availability_date_ID` ASC),
  CONSTRAINT `bda_user_ID_fk`
    FOREIGN KEY (`user_ID`)
    REFERENCES `schedulrDB`.`USER` (`user_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bda_availability_fk`
    FOREIGN KEY (`availability_date_ID`)
    REFERENCES `schedulrDB`.`AVAILABILITY_DATE` (`availability_date_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
