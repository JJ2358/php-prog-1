-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2020 at 11:25 PM
-- Server version: 5.7.30
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sean_dotnetcoreSamples`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblCustomer`
--

CREATE TABLE `tblCustomer` (
  `customerID` int(10) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal` varchar(7) DEFAULT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblCustomer`
--
ALTER TABLE `tblCustomer`
  ADD PRIMARY KEY (`customerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblCustomer`
--
ALTER TABLE `tblCustomer`
  MODIFY `customerID` int(10) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

INSERT INTO `tblCustomer` (`customerID`, `lastName`, `firstName`, `address`, `city`, `province`, `postal`, `phone`) VALUES
(1,	'Morrow',	'Sean',	'171 Portland Street',	'Dartmouth',	'Nova Scotia',	'N4N2P3',	'123-456-7890'),
(2,	'Smith',	'Joe',	'133 Pine Street',	'Truro',	'Nova Scotia',	'N6J7K8',	'789-777-8888'),
(3,	'Aikens',	'Nancy',	'723 Argyle Street',	'Halifax',	'Nova Scotia',	'K9K1D2',	'789-999-1244'),
(4, 'Johnson', 'Michael', '42 Oak Street', 'Sydney', 'Nova Scotia', 'M3M4M2', '456-789-0123'),
(5, 'Brown', 'Jennifer', '99 Elm Street', 'Yarmouth', 'Nova Scotia', 'Y8Y9Z1', '321-654-9876'),
(6, 'Taylor', 'Robert', '12 Pine Street', 'New Glasgow', 'Nova Scotia', 'N2N3N4', '789-012-3456'),
(7, 'Martin', 'Kimberly', '567 Maple Street', 'Antigonish', 'Nova Scotia', 'A5A6A7', '987-654-3210'),
(8, 'Baker', 'Christopher', '876 Birch Street', 'Wolfville', 'Nova Scotia', 'W1W2W3', '555-123-4567'),
(9, 'Garcia', 'Emily', '234 Cedar Street', 'Barrington', 'Nova Scotia', 'B8B9C1', '123-456-7890'),
(10, 'Lee', 'Jonathan', '789 Elmwood Street', 'Shelburne', 'Nova Scotia', 'S4S5S6', '111-222-3333'),
(11, 'Harris', 'Amanda', '456 Oakwood Street', 'Bridgewater', 'Nova Scotia', 'B1B2B3', '789-012-3456'),
(12, 'Jackson', 'Charles', '123 Pine Avenue', 'Amherst', 'Nova Scotia', 'A6A7A8', '987-654-3210'),
(13, 'Moore', 'Melissa', '789 Maple Lane', 'Kentville', 'Nova Scotia', 'K2K3K4', '555-123-4567'),
(14, 'Anderson', 'Brian', '345 Cedar Court', 'Digby', 'Nova Scotia', 'D7D8D9', '123-456-7890'),
(15, 'Walker', 'Michelle', '901 Birch Drive', 'Port Hawkesbury', 'Nova Scotia', 'P1P2P3', '111-222-3333'),
(16, 'Perez', 'John', '567 Pine Road', 'Sydney', 'Nova Scotia', 'S8S9T1', '456-789-0123'),
(17, 'Cooper', 'Laura', '234 Oak Street', 'Yarmouth', 'Nova Scotia', 'Y2Y3Y4', '321-654-9876'),
(18, 'Hill', 'Daniel', '876 Elm Street', 'New Glasgow', 'Nova Scotia', 'N5N6N7', '789-012-3456'),
(19, 'Barnes', 'Sarah', '12 Maple Street', 'Antigonish', 'Nova Scotia', 'A2A3A4', '987-654-3210'),
(20, 'White', 'Kevin', '901 Cedar Street', 'Wolfville', 'Nova Scotia', 'W4W5W6', '555-123-4567'),
(21, 'Cook', 'Jessica', '456 Elmwood Avenue', 'Barrington', 'Nova Scotia', 'B4B5B6', '123-456-7890'),
(22, 'Sanders', 'William', '789 Oakwood Lane', 'Shelburne', 'Nova Scotia', 'S7S8S9', '111-222-3333'),
(23, 'Ross', 'Katherine', '345 Pine Court', 'Bridgewater', 'Nova Scotia', 'B1B2B3', '789-012-3456'),
(24, 'Ward', 'Gary', '123 Birch Street', 'Amherst', 'Nova Scotia', 'A6A7A8', '987-654-3210'),
(25, 'Fisher', 'Linda', '789 Maple Drive', 'Kentville', 'Nova Scotia', 'K2K3K4', '555-123-4567'),
(26, 'Stewart', 'Matthew', '567 Cedar Road', 'Digby', 'Nova Scotia', 'D7D8D9', '123-456-7890'),
(27, 'Turner', 'Emily', '901 Elm Road', 'Port Hawkesbury', 'Nova Scotia', 'P1P2P3', '111-222-3333'),
(28, 'Baker', 'George', '234 Pine Drive', 'Sydney', 'Nova Scotia', 'S8S9T1', '456-789-0123'),
(29, 'Cruz', 'Susan', '876 Oak Lane', 'Yarmouth', 'Nova Scotia', 'Y2Y3Y4', '321-654-9876'),
(30, 'Evans', 'Richard', '12 Elm Street', 'New Glasgow', 'Nova Scotia', 'N5N6N7', '789-012-3456'),
(31, 'Mitchell', 'Patricia', '567 Maple Avenue', 'Antigonish', 'Nova Scotia', 'A2A3A4', '987-654-3210'),
(32, 'Cooper', 'Eric', '901 Cedar Drive', 'Wolfville', 'Nova Scotia', 'W4W5W6', '555-123-4567'),
(33, 'Garcia', 'Hannah', '456 Elmwood Road', 'Barrington', 'Nova Scotia', 'B4B5B6', '123-456-7890'),
(34, 'King', 'Thomas', '789 Oakwood Lane', 'Shelburne', 'Nova Scotia', 'S7S8S9', '111-222-3333'),
(35, 'Barnes', 'Nicole', '345 Pine Court', 'Bridgewater', 'Nova Scotia', 'B1B2B3', '789-012-3456'),
(36, 'Bell', 'Dennis', '123 Birch Street', 'Amherst', 'Nova Scotia', 'A6A7A8', '987-654-3210'),
(37, 'Fisher', 'Catherine', '789 Maple Drive', 'Kentville', 'Nova Scotia', 'K2K3K4', '555-123-4567'),
(38, 'Gomez', 'Christopher', '567 Cedar Road', 'Digby', 'Nova Scotia', 'D7D8D9', '123-456-7890'),
(39, 'Turner', 'Victoria', '901 Elm Road', 'Port Hawkesbury', 'Nova Scotia', 'P1P2P3', '111-222-3333'),
(40, 'Hill', 'Steven', '234 Pine Drive', 'Sydney', 'Nova Scotia', 'S8S9T1', '456-789-0123'),
(41, 'Ross', 'Maria', '876 Oak Lane', 'Yarmouth', 'Nova Scotia', 'Y2Y3Y4', '321-654-9876'),
(42, 'Ward', 'Jonathan', '12 Elm Street', 'New Glasgow', 'Nova Scotia', 'N5N6N7', '789-012-3456'),
(43, 'Sanders', 'Michelle', '567 Maple Avenue', 'Antigonish', 'Nova Scotia', 'A2A3A4', '987-654-3210'),
(44, 'Cook', 'Daniel', '901 Cedar Drive', 'Wolfville', 'Nova Scotia', 'W4W5W6', '555-123-4567'),
(45, 'Johnson', 'Holly', '456 Elmwood Road', 'Barrington', 'Nova Scotia', 'B4B5B6', '123-456-7890'),
(46, 'Taylor', 'Austin', '789 Oakwood Lane', 'Shelburne', 'Nova Scotia', 'S7S8S9', '111-222-3333'),
(47, 'Martin', 'Olivia', '345 Pine Court', 'Bridgewater', 'Nova Scotia', 'B1B2B3', '789-012-3456'),
(48, 'Walker', 'Benjamin', '123 Birch Street', 'Amherst', 'Nova Scotia', 'A6A7A8', '987-654-3210'),
(49, 'Perez', 'Laura', '789 Maple Drive', 'Kentville', 'Nova Scotia', 'K2K3K4', '555-123-4567'),
(50, 'Garcia', 'David', '567 Cedar Road', 'Digby', 'Nova Scotia', 'D7D8D9', '123-456-7890');
