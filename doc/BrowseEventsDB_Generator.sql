-- MySQL Script generated by MySQL Workbench
-- Sun Aug 30 23:19:55 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema BrowseEventsDB
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `BrowseEventsDB` ;

-- -----------------------------------------------------
-- Schema BrowseEventsDB
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `BrowseEventsDB` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin ;
SHOW WARNINGS;
USE `BrowseEventsDB` ;

-- -----------------------------------------------------
-- Table `Cart`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Cart` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Cart` (
  `idCart` INT NOT NULL AUTO_INCREMENT,
  `Event_idEvent` INT NOT NULL,
  `User_idUsers` INT NOT NULL,
  `TicketQuantity` INT NULL,
  `Date` DATETIME NULL DEFAULT NOW(),
  `isAcquired` BIT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idCart`, `Event_idEvent`, `User_idUsers`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Category` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Category` (
  `idCategory` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NULL,
  `Description` VARCHAR(255) NULL,
  PRIMARY KEY (`idCategory`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Category_has_Event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Category_has_Event` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Category_has_Event` (
  `Event_idEvent` INT NOT NULL,
  `Category_idCategory` INT NOT NULL,
  PRIMARY KEY (`Event_idEvent`, `Category_idCategory`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Event`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Event` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Event` (
  `idEvent` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(45) NULL,
  `Datetime` DATE NULL,
  `Price` FLOAT NULL,
  `Place` VARCHAR(45) NULL,
  `TicketNumber` INT NULL,
  `Description` VARCHAR(255) NULL,
  `Image` VARCHAR(255) NOT NULL,
  `User_idUsers` INT NOT NULL,
  `LastModifyDate` DATETIME NULL DEFAULT NOW(),
  PRIMARY KEY (`idEvent`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Image` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Image` (
  `Image` VARCHAR(255) NOT NULL,
  `Description` VARCHAR(255) NOT NULL,
  `Event_idEvent` INT NOT NULL,
  PRIMARY KEY (`Image`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Log` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Log` (
  `Event_idEvent` INT NOT NULL,
  `User_idUsers` INT NOT NULL,
  `Date` DATETIME NULL DEFAULT NOW(),
  `Description` VARCHAR(255) NULL,
  PRIMARY KEY (`Event_idEvent`, `User_idUsers`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Notification` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Notification` (
  `idNotification` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(45) NULL,
  `Description` VARCHAR(512) NULL,
  `Date` DATETIME NULL DEFAULT NOW(),
  PRIMARY KEY (`idNotification`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `Session`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Session` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `Session` (
  `idSession` VARCHAR(512) NOT NULL,
  `User_idUsers` INT NOT NULL,
  `Date` DATETIME NULL DEFAULT NOW(),
  `Token` VARCHAR(512) NULL,
  PRIMARY KEY (`idSession`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `User` (
  `idUsers` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(45) NULL,
  `Password` VARCHAR(45) NULL,
  `Email` VARCHAR(45) NULL,
  `FirstName` VARCHAR(45) NULL,
  `LastName` VARCHAR(45) NULL,
  `UserType_idUserType` INT NOT NULL,
  `VerificationCode` VARCHAR(45) NULL,
  `EmailStatus` ENUM('not verified', 'verified') NULL DEFAULT 'not verified',
  `LastLoginDate` DATETIME NULL DEFAULT NOW(),
  `isApproved` BIT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idUsers`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `UserType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `UserType` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `UserType` (
  `idUserType` INT NOT NULL AUTO_INCREMENT,
  `Type` VARCHAR(45) NULL,
  `Description` VARCHAR(255) NULL,
  PRIMARY KEY (`idUserType`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `User_has_Notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `User_has_Notification` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `User_has_Notification` (
  `User_idUsers` INT NOT NULL,
  `Notification_idNotification` INT NOT NULL,
  `isRead` BIT NOT NULL DEFAULT 0,
  PRIMARY KEY (`User_idUsers`, `Notification_idNotification`))
ENGINE = InnoDB;

SHOW WARNINGS;
USE `BrowseEventsDB`;

DELIMITER $$

USE `BrowseEventsDB`$$
DROP TRIGGER IF EXISTS `Cart_AFTER_INSERT` $$
SHOW WARNINGS$$
USE `BrowseEventsDB`$$
CREATE DEFINER = CURRENT_USER TRIGGER `BrowseEventsDB`.`Cart_AFTER_INSERT` AFTER INSERT ON `Cart` FOR EACH ROW
BEGIN
DECLARE nameEvent VARCHAR(255);
	DECLARE nameUser VARCHAR(255);
	DECLARE emailUser VARCHAR(255);
	DECLARE idNotification INT;
	DECLARE idOrganizer INT;
	IF NEW.isAcquired = 1 THEN
		

		SET nameEvent = (SELECT Name FROM `event` WHERE idEvent = NEW.Event_idEvent);
		SET nameUser = (SELECT Username FROM User WHERE idUsers = NEW.User_idUsers);
		SET emailUser = (SELECT Email FROM User WHERE idUsers = NEW.User_idUsers);
		SET idOrganizer = (SELECT User_idUsers FROM `event` WHERE idEvent = NEW.Event_idEvent);

		INSERT INTO Notification (Title, Description) VALUE("Tickets bought ", CONCAT(nameUser, " (email: ", emailUser, ") has bought ", NEW.TicketQuantity, " tickets for the event ", nameEvent, " on ", NEW.Date));
		SET idNotification = (SELECT LAST_INSERT_ID() FROM Notification);

		IF idOrganizer != NEW.User_idUsers THEN
			INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUES(idOrganizer, idNotification);
        END IF;
		INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUES(NEW.User_idUsers, idNotification);
	END IF;
END$$

SHOW WARNINGS$$

USE `BrowseEventsDB`$$
DROP TRIGGER IF EXISTS `Cart_AFTER_UPDATE` $$
SHOW WARNINGS$$
USE `BrowseEventsDB`$$
CREATE DEFINER = CURRENT_USER TRIGGER `BrowseEventsDB`.`Cart_AFTER_UPDATE` AFTER UPDATE ON `Cart` FOR EACH ROW
BEGIN
	DECLARE nameEvent VARCHAR(255);
	DECLARE nameUser VARCHAR(255);
	DECLARE emailUser VARCHAR(255);
	DECLARE idNotification INT;
	DECLARE idOrganizer INT;
	IF NEW.isAcquired = 1 THEN
		SET nameEvent = (SELECT Name FROM `event` WHERE idEvent = NEW.Event_idEvent);
		SET nameUser = (SELECT Username FROM User WHERE idUsers = NEW.User_idUsers);
		SET emailUser = (SELECT Email FROM User WHERE idUsers = NEW.User_idUsers);
		SET idOrganizer = (SELECT User_idUsers FROM `event` WHERE idEvent = NEW.Event_idEvent);

		INSERT INTO Notification (Title, Description) VALUE("Tickets bought ", CONCAT(nameUser, " (email: ", emailUser, ") has bought ", NEW.TicketQuantity, " tickets for the event ", nameEvent, " on ", NEW.Date));
		SET idNotification = (SELECT LAST_INSERT_ID() FROM Notification);

		
        IF idOrganizer != NEW.User_idUsers THEN
			INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUES(idOrganizer, idNotification);
        END IF;
		INSERT INTO user_has_notification (User_idUsers, Notification_idNotification) VALUES(NEW.User_idUsers, idNotification);
	END IF;
END$$

SHOW WARNINGS$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `Category`
-- -----------------------------------------------------
START TRANSACTION;
USE `BrowseEventsDB`;
INSERT INTO `Category` (`idCategory`, `Name`, `Description`) VALUES (1, 'Concerts', 'Concerts');
INSERT INTO `Category` (`idCategory`, `Name`, `Description`) VALUES (2, 'Exhibitions', 'Exhibitions');
INSERT INTO `Category` (`idCategory`, `Name`, `Description`) VALUES (3, 'Festivals', 'Festivals');

COMMIT;


-- -----------------------------------------------------
-- Data for table `User`
-- -----------------------------------------------------
START TRANSACTION;
USE `BrowseEventsDB`;
INSERT INTO `User` (`idUsers`, `Username`, `Password`, `Email`, `FirstName`, `LastName`, `UserType_idUserType`, `VerificationCode`, `EmailStatus`, `LastLoginDate`, `isApproved`) VALUES (1, 'admin', '25f9e794323b453885f5181f1b624d0b', 'infobrowseevents@gmail.com', 'Admin', 'Admin', 1, NULL, 'verified', NULL, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `UserType`
-- -----------------------------------------------------
START TRANSACTION;
USE `BrowseEventsDB`;
INSERT INTO `UserType` (`idUserType`, `Type`, `Description`) VALUES (1, 'Admin', 'Admin has all priviligies');
INSERT INTO `UserType` (`idUserType`, `Type`, `Description`) VALUES (2, 'Organizer', 'Organizer has limited priviligies');
INSERT INTO `UserType` (`idUserType`, `Type`, `Description`) VALUES (3, 'Client', 'Client can only buy tickets');

COMMIT;

