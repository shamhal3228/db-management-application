DROP DATABASE IF EXISTS appDB;
CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT ALL ON appDB.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE appDB;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(35) NOT NULL,
  `user_group` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
);

-- -----------------------------------------------------
-- Table `employee`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `employee` (
  `employeeID` INT(5) NOT NULL AUTO_INCREMENT,
  `FIO` VARCHAR(80) NOT NULL,
  `salary` INT(6) NOT NULL,
  `salaryNDFL` INT(6),
  `form_of_employment` VARCHAR(9) NOT NULL DEFAULT 'full-time',
  `shift` TINYINT NOT NULL DEFAULT 0,
  `experience` INT(3) NOT NULL DEFAULT 0,
  PRIMARY KEY (`employeeID`));


-- -----------------------------------------------------
-- Table `worker`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `worker` (
  `employeeID` INT(5) NOT NULL,
  `position` VARCHAR(35) NOT NULL,
  PRIMARY KEY (`employeeID`),
  FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `engeneer`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `engeneer` (
  `employeeID` INT(5) NOT NULL,
  `activity` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`employeeID`),
  FOREIGN KEY (`employeeID`) REFERENCES `employee` (`employeeID`) ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `interior`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `interior` (
  `schemeID` INT(4) NOT NULL AUTO_INCREMENT,
  `authorID` INT(5),
  `price` INT(10) NULL DEFAULT NULL,
  `type` VARCHAR(25) NOT NULL,
  `style` VARCHAR(25) NOT NULL,
  `materials` VARCHAR(35) NULL DEFAULT NULL,
  PRIMARY KEY (`schemeID`),
  FOREIGN KEY (`authorID`) REFERENCES `employee` (`employeeID`) ON DELETE SET NULL);


-- -----------------------------------------------------
-- Table `exterior`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `exterior` (
  `modelID` INT(4) NOT NULL AUTO_INCREMENT,
  `authorID` INT(5),
  `price` INT(15) NULL DEFAULT NULL,
  `type` VARCHAR(50) NOT NULL,
  `height` INT(6) NULL DEFAULT NULL,
  `width` INT(6) NULL DEFAULT NULL,
  `number_of_floors` INT(6) NULL DEFAULT NULL,
  `heating` TINYINT NOT NULL,
  `fire_resistance` VARCHAR(12) NOT NULL,
  `longlevity` INT(5) NULL DEFAULT NULL,
  PRIMARY KEY (`modelID`),
  FOREIGN KEY (`authorID`) REFERENCES `employee` (`employeeID`) ON DELETE SET NULL);


-- -----------------------------------------------------
-- Table `clientele`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `clientele` (
  `clienteleID` INT(4) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `modelID` INT(4),
  `schemeID` INT(4),
  `time_of_cooperation` DATE NOT NULL,
  `telephone` VARCHAR(20) NULL DEFAULT NULL,
  `number_of_orders` INT(3) NULL DEFAULT NULL,
  `email` VARCHAR(20) NULL DEFAULT NULL,
  `adress` VARCHAR(30) NULL DEFAULT NULL,
  PRIMARY KEY (`clienteleID`),
  FOREIGN KEY (`modelID`) REFERENCES `exterior` (`modelID`) ON DELETE SET NULL,
  FOREIGN KEY (`schemeID`) REFERENCES `interior` (`schemeID`) ON DELETE SET NULL);


-- -----------------------------------------------------
-- Table `vehicles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `vehicles` (
  `vehicalID` INT(5) NOT NULL AUTO_INCREMENT,
  `vehical_serial_number` VARCHAR(50) NOT NULL,
  `arend_time` DATE NOT NULL,
  `quanity` INT(4) NOT NULL,
  `operating_time` INT(3) NULL DEFAULT NULL,
  `rent_price` INT(7) NOT NULL,
  PRIMARY KEY (`vehicalID`));


-- -----------------------------------------------------
-- Table `store`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `store` (
  `materialID` INT(3) NOT NULL AUTO_INCREMENT,
  `material_type` VARCHAR(50) NOT NULL,
  `material_amount` INT(4) NOT NULL,
  `place` VARCHAR(60) NOT NULL,
  `expiration_date` DATE NOT NULL,
  `cost` INT(7) NOT NULL,
  PRIMARY KEY (`materialID`));


-- -----------------------------------------------------
-- Table `tenders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tenders` (
  `tenderID` INT(3) NOT NULL AUTO_INCREMENT,
  `price` INT(7) NULL DEFAULT NULL,
  `status` TINYINT NULL DEFAULT 0,
  `importance` VARCHAR(30) NULL DEFAULT NULL,
  `type` VARCHAR(40) NOT NULL,
  `place_of_building` VARCHAR(60) NULL DEFAULT NULL,
  `potential_profit` INT(9) NULL DEFAULT NULL,
  PRIMARY KEY (`tenderID`));


-- -----------------------------------------------------
-- Table `current_project`
-- -----------------------------------------------------
USE appDB;
CREATE TABLE IF NOT EXISTS `current_project` (
  `tenderID` INT(3),
  `projectID` INT(3) NOT NULL AUTO_INCREMENT,
  `schemeID` INT(4),
  `modelID` INT(4),
  `cost` INT(7) NOT NULL,
  `duration` DATE NOT NULL,
  `materialID` INT(3),
  `vehicalID` INT(5),
  PRIMARY KEY (`projectID`),
  FOREIGN KEY (`tenderID`) REFERENCES `tenders` (`tenderID`) ON DELETE CASCADE,
  FOREIGN KEY (`schemeID`) REFERENCES `interior` (`schemeID`) ON DELETE SET NULL,
  FOREIGN KEY (`modelID`) REFERENCES `exterior` (`modelID`) ON DELETE SET NULL,
  FOREIGN KEY (`materialID`) REFERENCES `store` (`materialID`) ON DELETE SET NULL,
  FOREIGN KEY (`vehicalID`) REFERENCES `vehicles` (`vehicalID`) ON DELETE SET NULL);

ALTER DATABASE appDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

ALTER TABLE appDB.employee CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.employee CHANGE FIO FIO VARCHAR(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.employee CHANGE form_of_employment form_of_employment ENUM('Полная', 'Частичная', 'Стажировка') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Полная';
ALTER TABLE appDB.employee CHANGE shift shift ENUM('Дневная', 'Ночная') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'Дневная';

ALTER TABLE appDB.worker CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.worker CHANGE position position ENUM('Красная', 'Белая', 'Желтая', 'Зеленая') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE appDB.engeneer CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.engeneer CHANGE activity activity ENUM('Работает', 'Не работает') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Работает';

ALTER TABLE appDB.interior CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.interior CHANGE type type VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.interior CHANGE style style VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.interior CHANGE materials materials VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE appDB.exterior CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.exterior CHANGE heating heating ENUM('Есть', 'Нет') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.exterior CHANGE type type VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.exterior CHANGE fire_resistance fire_resistance ENUM('К0', 'К1', 'К2', 'К3', 'К4') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE appDB.clientele CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.clientele CHANGE title title VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.clientele CHANGE adress adress VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE appDB.vehicles CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.vehicles CHANGE vehical_serial_number vehical_serial_number VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE appDB.store CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.store CHANGE material_type material_type VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.store CHANGE place place VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE appDB.tenders CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE appDB.tenders CHANGE status status ENUM('Выиграны', 'В процессе') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT 'В процессе';
ALTER TABLE appDB.tenders CHANGE importance importance VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE appDB.tenders CHANGE type type VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE appDB.tenders CHANGE place_of_building place_of_building VARCHAR(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

CREATE TRIGGER NDFL BEFORE INSERT ON employee
FOR EACH ROW SET NEW.salaryNDFL = NEW.salary - NEW.salary * 0.13;

INSERT INTO employee VALUES ('1', 'Шахгусейнов Шамхал Мехти оглы', '80000', NULL, 'Стажировка', 'Ночная', '5');
INSERT INTO employee (FIO, salary, experience) VALUES 
('Иванов Петр Михайлович', '200000', 37), 
('Хотаб Хотабович', '1200000', 120), 
('Купов Илья Пупович', '30000', 17), 
('Забой Виктор Ашотович', '100000', 55), 
('Работ Иван Многизи', '45000', 42);

INSERT INTO `worker` VALUES ('1', 'Красная'), ('4', 'Белая'), ('6', 'Желтая');

INSERT INTO `engeneer` VALUES ('2', 'Работает'), ('3', 'Не работает'), ('5', 'Работает');

INSERT INTO interior VALUES ('1', '5', '300000', 'Больница', 'Городской', 'Ламинат, цемент, известь');
INSERT INTO interior (authorID, price, type, style, materials) VALUES
('2', '4500000', 'Торговый центр', 'Модернизм', 'Стекло, пластик'),
('3', '98000', 'Антикафе', 'Лофт', 'Кирпичи, стекло, дерево');

INSERT INTO exterior VALUES ('1', '5', '3000000', 'Больница', '40', '60', '5', 'Есть', 'К0', '30');
INSERT INTO exterior (authorID, price, type, height, width, number_of_floors, heating, fire_resistance, longlevity) VALUES 
('2', '12000000', 'Торговый центр', '70', '100', '15', 'Есть', 'К1', '15'),
('3', '500000', 'Антикафе', '5', '30', '1', 'Нет', 'К4', '5');

INSERT INTO `clientele` VALUES ('1', 'OOO Hospital', '1', '1', '2011.11.11', '84955490345', '5', 'hospital@gmail.com', 'Краснопресненская, 39');
INSERT INTO `clientele` (title, modelID, schemeID, time_of_cooperation) VALUES
('Trump Organization', '2', '2', '2020.11.11'),
('ИП Виталий', '3', '3', '2021.08.30');

INSERT INTO `vehicles` VALUES ('1', 'Экскаватор VT-1234', '2021.12.11', '15', '12', '300000'), 
('2', 'Кран Super-3000', '2021.12.11', '7', NULL, '100000'),
('3', 'Лазер QfG', '2031.01.24', '1', NULL, '3000000');

INSERT INTO `store` VALUES
('1', 'Дерево', '5000', 'Щербинка, 44', '2021-08-14', '600000'), 
('2', 'Стекло', '40000', 'Щербинка, 44', '2041-12-23', '500000'), 
('3', 'Цемент', '500', 'Щербинка, 44', '2042-01-08', '60000');

INSERT INTO `tenders` VALUES
('1', '30000', 'В процессе', 'Неплохо', 'Бассейн', NULL, '50000'),
('2', '50000', 'Выиграны', 'Очень важно', 'Торговый центр', 'США, Нью Барк, 41', '9999999'),
('3', '10000', 'Выиграны', 'Неважно', 'Больница', 'Россия, Бартенеская, 62', '0');

INSERT INTO `current_project` VALUES
('1', '1', '1', '1', '1500000', '2025-01-01', '1', '1'), 
('2', '2', '2', '2', '2800000', '2024-07-17','2', '2'), 
('3', '3', '3', '3', '500000', '2022-10-21','3', '3');
