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
-- Database: `customers`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblCustomer`
--
-- init_db.sql

USE customers;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  price DECIMAL(10, 2) NOT NULL,
  photo VARCHAR(255),
  status VARCHAR(50),
  on_sale BOOLEAN DEFAULT FALSE
);

INSERT INTO products (title, description, price, photo, status, on_sale) VALUES
('Product 1', 'Description for product 1', 19.99, 'path/to/photo1.jpg', 'new', FALSE),
('Product 2', 'Description for product 2', 29.99, 'path/to/photo2.jpg', 'used', TRUE),
('Product 3', 'Description for product 3', 39.99, 'path/to/photo3.jpg', 'new', FALSE),
('Example Product', 'This is an example product description.', 99.99, 'path/to/photo.jpg', 'new', FALSE);


CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    rating TINYINT NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    comment TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample reviews for product 1
INSERT INTO reviews (product_id, rating, first_name, last_name, comment) VALUES
(1, 5, 'John', 'Doe', 'Great product! Highly recommend.'),
(1, 4, 'Jane', 'Smith', 'Really good, but could be better with more features.'),
(1, 5, 'Emily', 'Jones', 'Absolutely love it! Best purchase ever.');

-- Insert a sample review for product 2
INSERT INTO reviews (product_id, rating, first_name, last_name, comment) VALUES
(2, 3, 'Mike', 'Brown', 'It’s okay, but I had some issues with it.');
