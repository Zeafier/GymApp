-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2019 at 03:51 PM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `_wellness_4_all_`
--

-- --------------------------------------------------------

--
-- Table structure for table `_address_`
--

CREATE TABLE `_address_` (
  `_cID_` int(11) NOT NULL,
  `_Postcode_` varchar(7) NOT NULL,
  `_Street_` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_address_`
--

INSERT INTO `_address_` (`_cID_`, `_Postcode_`, `_Street_`) VALUES
(1, 'D13TEST', 'test'),
(1, 'E163tb', 'Partridge Close'),
(1, 'egret34', 'this is test street'),
(1, 'Post213', 'Street'),
(1, 'test01', 'new'),
(1, 'test011', 'new'),
(1, 'TEst012', 'Test street');

-- --------------------------------------------------------

--
-- Table structure for table `_book_trainer`
--

CREATE TABLE `_book_trainer` (
  `_btID_` int(11) NOT NULL,
  `_tID_` int(11) DEFAULT NULL,
  `_cID_` int(11) DEFAULT NULL,
  `_bDATE_` date DEFAULT NULL,
  `_uID_` int(11) DEFAULT NULL,
  `_is_confirm_` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_book_trainer`
--

INSERT INTO `_book_trainer` (`_btID_`, `_tID_`, `_cID_`, `_bDATE_`, `_uID_`, `_is_confirm_`) VALUES
(1, 3, 5, '2019-06-28', 17, 1),
(2, 1, 1, '0000-00-00', 17, 1),
(3, 5, 5, '2019-06-27', 17, 1),
(4, 5, 5, '2019-07-04', 17, 1),
(5, 2, 7, '2019-07-01', 17, 1),
(6, 3, 1, '2019-09-02', 17, 0),
(7, 5, 5, '2019-10-05', 17, 0),
(11, 2, 1, '2019-07-10', 17, 1),
(12, 3, 9, '2066-07-05', 17, 1),
(13, 4, 3, '2027-05-07', 17, 1),
(14, 1, 7, '2019-07-12', 24, 1),
(15, 1, 4, '2019-11-05', 24, 0);

-- --------------------------------------------------------

--
-- Table structure for table `_city_`
--

CREATE TABLE `_city_` (
  `_cID_` int(11) NOT NULL,
  `_c_name_` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `_class_` (
  `_cID_` int(11) NOT NULL,
  `_Class_name_` varchar(90) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `_personal_trainer_` (
  `_pID_` int(11) NOT NULL,
  `_pFN_` varchar(90) DEFAULT NULL,
  `_pLN_` varchar(90) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `_users_` (
  `_uID_` int(11) NOT NULL,
  `_pw_` varchar(90) NOT NULL,
  `_posting_date_` date DEFAULT NULL,
  `_postcode_` varchar(7) NOT NULL,
  `_h_number_` varchar(5) NOT NULL,
  `_ln_` varchar(90) NOT NULL,
  `_fn_` varchar(90) NOT NULL,
  `_em_` varchar(90) NOT NULL,
  `_contactno_` int(11) NOT NULL,
  `_is_admin_` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_users_`
--

INSERT INTO `_users_` (`_uID_`, `_pw_`, `_posting_date_`, `_postcode_`, `_h_number_`, `_ln_`, `_fn_`, `_em_`, `_contactno_`, `_is_admin_`) VALUES
(17, '$2y$10$yYbnGcL/4UR20KQF3IFF7uzdRe3IoFkG5FLJQPeoHU5RnvOdrvCG.', '2019-06-19', 'E163tb', '432', 'Malkowski', 'Krystian', 'krismalkos@gmail.com', 2147483647, 1),
(23, '$2y$10$UxBifphOU05cZdifMA9a8uwHGR4KMrq1VJi/6bdy5z.eIQXqL1NwC', '2019-07-05', 'Test012', '79', 'Malkowski', 'Krystian', 'test.user@gmail.com', 2019, 0),
(24, '$2y$10$uBi1tmI45PXRPvBsBMO6e.kIcvzYo5WZ.3oQZ2AqkrTW/Qw9ys2OK', '2019-07-05', 'E163tb', '32', 'Malkowski', 'Krzysztof', 'k.m96yr@gmail.com', 2147483647, 0),
(25, '$2y$10$BRJJvU/ppjc8vT6GDC1dce0Udz1YyJRKh34Yb3d9zwWO/jXzBtI0.', '2019-07-05', 'test01', '123', 'account', 'Tester', 'xx2primexx@gmail.com', 2147483647, 0),
(27, '$2y$10$4N/OMW4G6fl/T.e6glRWhO.LFnZ1ANDWb3qJrmErSqES7Zf90piVy', '2019-07-06', 'Post213', '321', 'Account', 'Test', 'testUser@gmail.com', 700300400, 0);

-- --------------------------------------------------------

--
-- Table structure for table `_user_class_`
--

CREATE TABLE `_user_class_` (
  `_class_id_` int(11) NOT NULL,
  `_cu_ID_` int(11) NOT NULL,
  `_user_ID_` int(11) NOT NULL,
  `_date_` date DEFAULT NULL,
  `_is_confirmed_` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `_user_class_`
--

INSERT INTO `_user_class_` (`_class_id_`, `_cu_ID_`, `_user_ID_`, `_date_`, `_is_confirmed_`) VALUES
(2, 1, 17, '2019-06-23', 1),
(7, 2, 17, '2019-06-30', 1),
(1, 3, 17, '2019-07-07', 1),
(5, 4, 17, '2019-09-06', 0),
(7, 5, 17, '2019-10-07', 1),
(9, 6, 17, '2019-10-06', 0),
(2, 7, 17, '2019-09-04', 1),
(5, 8, 17, '2019-10-02', 1),
(2, 15, 17, '2019-10-02', 1),
(2, 16, 17, '2019-10-02', 1),
(5, 19, 17, '2019-07-07', 1),
(1, 20, 17, '2019-07-08', 1),
(3, 21, 17, '2064-07-06', 1),
(1, 22, 17, '2019-11-05', 1),
(9, 26, 24, '2019-12-06', 0),
(9, 27, 24, '2022-07-10', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `_address_`
--
ALTER TABLE `_address_`
  ADD PRIMARY KEY (`_Postcode_`),
  ADD KEY `_cID_` (`_cID_`);

--
-- Indexes for table `_book_trainer`
--
ALTER TABLE `_book_trainer`
  ADD PRIMARY KEY (`_btID_`),
  ADD KEY `_tID_` (`_tID_`),
  ADD KEY `_cID_` (`_cID_`),
  ADD KEY `_uID_` (`_uID_`);

--
-- Indexes for table `_city_`
--
ALTER TABLE `_city_`
  ADD PRIMARY KEY (`_cID_`);

--
-- Indexes for table `_class_`
--
ALTER TABLE `_class_`
  ADD PRIMARY KEY (`_cID_`);

--
-- Indexes for table `_personal_trainer_`
--
ALTER TABLE `_personal_trainer_`
  ADD PRIMARY KEY (`_pID_`);

--
-- Indexes for table `_users_`
--
ALTER TABLE `_users_`
  ADD PRIMARY KEY (`_uID_`),
  ADD KEY `_postcode_` (`_postcode_`);

--
-- Indexes for table `_user_class_`
--
ALTER TABLE `_user_class_`
  ADD PRIMARY KEY (`_cu_ID_`),
  ADD KEY `_class_id_` (`_class_id_`),
  ADD KEY `_user_ID_` (`_user_ID_`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `_book_trainer`
--
ALTER TABLE `_book_trainer`
  MODIFY `_btID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `_city_`
--
ALTER TABLE `_city_`
  MODIFY `_cID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `_class_`
--
ALTER TABLE `_class_`
  MODIFY `_cID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `_personal_trainer_`
--
ALTER TABLE `_personal_trainer_`
  MODIFY `_pID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `_users_`
--
ALTER TABLE `_users_`
  MODIFY `_uID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `_user_class_`
--
ALTER TABLE `_user_class_`
  MODIFY `_cu_ID_` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
