-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 01, 2021 at 10:03 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_wellness_4_all_`
--
CREATE DATABASE IF NOT EXISTS `_wellness_4_all_` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `_wellness_4_all_`;

-- --------------------------------------------------------

--
-- Table structure for table `_address_`
--

CREATE TABLE IF NOT EXISTS `_address_` (
  `_cID_` int(11) NOT NULL,
  `_Postcode_` varchar(7) NOT NULL,
  `_Street_` varchar(90) NOT NULL,
  PRIMARY KEY (`_Postcode_`),
  KEY `_cID_` (`_cID_`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_address_`
--

INSERT INTO `_address_` (`_cID_`, `_Postcode_`, `_Street_`) VALUES
(1, 'D13TEST', 'test'),
(1, 'E163tb', 'Partridge Close'),
(3, 'Eb4324', 'Grimme War'),
(1, 'egret34', 'this is test street'),
(1, 'Let9432', 'Some Street'),
(1, 'Post213', 'Street'),
(1, 'test01', 'new'),
(1, 'test011', 'new'),
(1, 'TEst012', 'Test street');

-- --------------------------------------------------------

--
-- Table structure for table `_book_trainer`
--

CREATE TABLE IF NOT EXISTS `_book_trainer` (
  `_btID_` int(11) NOT NULL AUTO_INCREMENT,
  `_tID_` int(11) DEFAULT NULL,
  `_cID_` int(11) DEFAULT NULL,
  `_bDATE_` date DEFAULT NULL,
  `_uID_` int(11) DEFAULT NULL,
  `_is_confirm_` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`_btID_`),
  KEY `_tID_` (`_tID_`),
  KEY `_cID_` (`_cID_`),
  KEY `_uID_` (`_uID_`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_book_trainer`
--

INSERT INTO `_book_trainer` (`_btID_`, `_tID_`, `_cID_`, `_bDATE_`, `_uID_`, `_is_confirm_`) VALUES
(16, 5, 2, '2021-10-21', 28, 1),
(17, 1, 8, '2021-10-16', 28, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_city_`
--

CREATE TABLE IF NOT EXISTS `_city_` (
  `_cID_` int(11) NOT NULL AUTO_INCREMENT,
  `_c_name_` varchar(45) NOT NULL,
  PRIMARY KEY (`_cID_`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_city_`
--

INSERT INTO `_city_` (`_cID_`, `_c_name_`) VALUES
(1, 'London'),
(2, 'Birmingham'),
(3, 'Bristol'),
(4, 'Cambridge');

-- --------------------------------------------------------

--
-- Table structure for table `_class_`
--

CREATE TABLE IF NOT EXISTS `_class_` (
  `_cID_` int(11) NOT NULL AUTO_INCREMENT,
  `_Class_name_` varchar(90) NOT NULL,
  PRIMARY KEY (`_cID_`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_class_`
--

INSERT INTO `_class_` (`_cID_`, `_Class_name_`) VALUES
(1, 'Football'),
(2, 'Swimming'),
(3, 'Karate'),
(4, 'Bowling'),
(5, 'Athletic'),
(6, 'Tennins'),
(7, 'Basketball'),
(8, 'Volleyball'),
(9, 'Running');

-- --------------------------------------------------------

--
-- Table structure for table `_personal_trainer_`
--

CREATE TABLE IF NOT EXISTS `_personal_trainer_` (
  `_pID_` int(11) NOT NULL AUTO_INCREMENT,
  `_pFN_` varchar(90) DEFAULT NULL,
  `_pLN_` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`_pID_`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_personal_trainer_`
--

INSERT INTO `_personal_trainer_` (`_pID_`, `_pFN_`, `_pLN_`) VALUES
(1, 'Tendai', 'Trainer'),
(2, 'Chris', 'Masteir'),
(3, 'Ark', 'Novel'),
(4, 'Gengu', 'Vardi'),
(5, 'Rox', 'Inner');

-- --------------------------------------------------------

--
-- Table structure for table `_users_`
--

CREATE TABLE IF NOT EXISTS `_users_` (
  `_uID_` int(11) NOT NULL AUTO_INCREMENT,
  `_pw_` varchar(90) NOT NULL,
  `_posting_date_` date DEFAULT NULL,
  `_postcode_` varchar(7) NOT NULL,
  `_h_number_` varchar(5) NOT NULL,
  `_ln_` varchar(90) NOT NULL,
  `_fn_` varchar(90) NOT NULL,
  `_em_` varchar(90) NOT NULL,
  `_contactno_` int(11) NOT NULL,
  `_is_admin_` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`_uID_`),
  KEY `_postcode_` (`_postcode_`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_users_`
--

INSERT INTO `_users_` (`_uID_`, `_pw_`, `_posting_date_`, `_postcode_`, `_h_number_`, `_ln_`, `_fn_`, `_em_`, `_contactno_`, `_is_admin_`) VALUES
(27, '$2y$10$4N/OMW4G6fl/T.e6glRWhO.LFnZ1ANDWb3qJrmErSqES7Zf90piVy', '2019-07-06', 'Post213', '321', 'Account', 'Test', 'testUser@gmail.com', 700300400, 0),
(28, '$2y$10$tcx/EW7p0iibUlIzki1wU.ZVmhJt3Zzj05TIrd/WX1FkhOS9d9eOO', '2021-10-01', 'Eb4324', '34', 'User', 'Test', 'testuser@test.com', 700900700, 0),
(29, '$2y$10$jQYyB6Zu3nq7JECQ371Gu.X8VhHoBr6aemp3rb.h86FJhk5t5h3sC', '2021-10-01', 'Let9432', '764A', 'User', 'Admin', 'adminuser@admin.com', 2147483647, 1);

-- --------------------------------------------------------

--
-- Table structure for table `_user_class_`
--

CREATE TABLE IF NOT EXISTS `_user_class_` (
  `_class_id_` int(11) NOT NULL,
  `_cu_ID_` int(11) NOT NULL AUTO_INCREMENT,
  `_user_ID_` int(11) NOT NULL,
  `_date_` date DEFAULT NULL,
  `_is_confirmed_` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`_cu_ID_`),
  KEY `_class_id_` (`_class_id_`),
  KEY `_user_ID_` (`_user_ID_`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_user_class_`
--

INSERT INTO `_user_class_` (`_class_id_`, `_cu_ID_`, `_user_ID_`, `_date_`, `_is_confirmed_`) VALUES
(7, 28, 28, '2021-10-22', 1),
(3, 29, 28, '2021-10-29', 1),
(1, 30, 28, '2021-10-18', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `_address_`
--
ALTER TABLE `_address_`
  ADD CONSTRAINT `_address__ibfk_1` FOREIGN KEY (`_cID_`) REFERENCES `_city_` (`_cID_`);

--
-- Constraints for table `_book_trainer`
--
ALTER TABLE `_book_trainer`
  ADD CONSTRAINT `_book_trainer_ibfk_1` FOREIGN KEY (`_tID_`) REFERENCES `_personal_trainer_` (`_pID_`),
  ADD CONSTRAINT `_book_trainer_ibfk_2` FOREIGN KEY (`_uID_`) REFERENCES `_users_` (`_uID_`),
  ADD CONSTRAINT `_book_trainer_ibfk_3` FOREIGN KEY (`_cID_`) REFERENCES `_class_` (`_cID_`);

--
-- Constraints for table `_users_`
--
ALTER TABLE `_users_`
  ADD CONSTRAINT `_users__ibfk_1` FOREIGN KEY (`_postcode_`) REFERENCES `_address_` (`_Postcode_`);

--
-- Constraints for table `_user_class_`
--
ALTER TABLE `_user_class_`
  ADD CONSTRAINT `_user_class__ibfk_1` FOREIGN KEY (`_class_id_`) REFERENCES `_class_` (`_cID_`),
  ADD CONSTRAINT `_user_class__ibfk_2` FOREIGN KEY (`_user_ID_`) REFERENCES `_users_` (`_uID_`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
