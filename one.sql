-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2015 at 12:34 AM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `one`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stock` int(5) NOT NULL,
  `price` int(5) NOT NULL,
  `img_url` varchar(200) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `stock`, `price`, `img_url`) VALUES
(1, 'Adidas Ball', 2, 230, 'C:\\xampp\\htdocs\\one\\public\\img\\.ball.jpg'),
(2, 'Tennis Racket', 0, 300, 'C:\\xampp\\htdocs\\one\\public\\img\\.download.jpg'),
(3, 'Nike football shoes', 6, 200, 'C:\\xampp\\htdocs\\one\\public\\img\\.football shoes.jpg'),
(4, 'Gloves', 1, 25, 'C:\\xampp\\htdocs\\one\\public\\img\\.gloves.jpg'),
(5, 'Green shorts', 4, 120, 'C:\\xampp\\htdocs\\one\\public\\img\\.green shorts.jpg'),
(6, 'Headphones', 6, 90, 'C:\\xampp\\htdocs\\one\\public\\img\\.headphones.jpg'),
(7, 'Apple Iphone 6 plus', 6, 750, 'C:\\xampp\\htdocs\\one\\public\\img\\.iphone-6-plus-reachability.jpg'),
(8, 'Wireless Mouse', 4, 50, 'C:\\xampp\\htdocs\\one\\public\\img\\.mouse.jpg'),
(9, 'Google Nexus 6 smartphone', 10, 600, 'C:\\xampp\\htdocs\\one\\public\\img\\.nexus2cee_n6lf3.png'),
(10, 'Black Shoes', 2, 500, 'C:\\xampp\\htdocs\\one\\public\\img\\.prd0683d04d-faaf-4826-a692-45d2e5cfbe3b.jpg'),
(11, 'Basic t-shirt', 15, 60, 'C:\\xampp\\htdocs\\one\\public\\img\\.tshirt.jpg'),
(12, 'Samsung Laptop', 4, 600, 'C:\\xampp\\htdocs\\one\\public\\img\\.Samsung-laptop.jpg'),
(13, 'Black Sunglasses', 7, 300, 'C:\\xampp\\htdocs\\one\\public\\img\\.Sunglasses.jpg'),
(14, 'Fifa 16 Xbox One', 0, 60, 'C:\\xampp\\htdocs\\one\\public\\img\\.Fifa 16.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `user_id` int(5) NOT NULL,
  `products` varchar(200) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`user_id`, `products`, `time`, `price`) VALUES
(1, '3, 2', '2015-10-07 19:37:36', 500),
(1, '3, 2', '2015-10-07 19:39:22', 500),
(1, '3, 2', '2015-10-07 19:39:38', 500),
(1, '4, 8', '2015-10-07 20:05:13', 75),
(1, '6, 7', '2015-10-07 20:10:44', 840),
(2, '1, 2', '2015-10-07 21:38:22', 530),
(2, '3', '2015-10-07 21:38:49', 200),
(1, '3', '2015-10-07 22:01:04', 200),
(2, '1, 4', '2015-10-07 22:05:51', 255),
(2, '4, 4, 4', '2015-10-07 22:06:11', 75),
(2, '6, 6', '2015-10-07 22:08:01', 180),
(2, '8, 8', '2015-10-07 22:12:53', 100),
(2, '5, 1', '2015-10-07 22:14:36', 350),
(2, '5, 5', '2015-10-07 22:14:49', 240),
(2, '8, 8', '2015-10-07 22:19:19', 100),
(2, '8, 8', '2015-10-07 22:20:24', 100),
(2, '1, 1', '2015-10-07 22:26:09', 460),
(2, '7', '2015-10-07 22:27:33', 750),
(2, '7, 7', '2015-10-07 22:28:01', 1500),
(2, '7, 6', '2015-10-07 22:29:32', 840),
(3, '1, 1, 1, 3', '2015-10-07 22:34:10', 890);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `avatar` varchar(200) DEFAULT NULL,
  `cart` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `avatar`, `cart`, `created_at`) VALUES
(1, 'Karim', 'Taha', 'Karimtaha', 'Karimtaha@hotmail.com', '$2y$10$NMr5m4i76HrpHejfNrlOKerMM/lZLgXB3zCiU2rqTMxDZgawzGKHq', 'C:\\xampp\\htdocs\\one\\public\\img\\..headphones.jpg', '', '2015-10-05 16:47:46'),
(2, 'Karim', 'Mohamed', 'karimtaha11', 'karim@hotmail.com', '$2y$10$huNWqa7DBsSO.HA627DYSOvo2KzU.P1COZYRoTrYhw.TknTZkgX7S', 'C:\\xampp\\htdocs\\one\\public\\img\\...Darmian1.jpg', '', '2015-10-06 21:35:53'),
(3, 'karimnew', 'taha', 'karimnew', 'karimnew@gmail.com', '$2y$10$lpBfSp1sxqnCHfPr1OAi2OsynhJFtgqjfg5JLNDH84wSn2nipy8Ve', 'C:\\xampp\\htdocs\\one\\public\\img\\..gloves.jpg', '', '2015-10-07 22:32:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
