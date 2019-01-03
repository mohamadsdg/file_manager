-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 03, 2019 at 06:59 AM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `7lphp`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `display_name` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remember_token` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `display_name`, `email`, `last_login`, `remember_token`) VALUES
(17, 'mohamad', '2ed6980a7cc6f29c85b044893a9c5c7d141b8048', 'mohamad sadeghi', 'sadeghi.dev@gmail.com', '2019-01-01 11:08:55', NULL),
(19, 'ali', '5ec5e732a1567d9661da09206d7c5c6aeefc62d4', 'Ali Alavi', 'ali@localhost', '2014-09-05 19:47:32', NULL),
(20, 'loghman', '197e19b8f3d4bee035c7c2e0f3886d78b1d54b60', 'Loghman Avand', 'avand@localhost', '2014-09-05 19:49:16', NULL),
(21, 'sara', '9140c29065f32f77366d3e4c2126b0a05087f5a4', 'Sara Ahmadi', 'sara@localhost', '2014-09-05 19:49:16', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
