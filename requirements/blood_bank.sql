-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2024 at 09:50 AM
-- Server version: 5.7.36
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
CREATE TABLE IF NOT EXISTS `appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `status_id` int(11) DEFAULT '8',
  `blood_process_id` int(11) DEFAULT NULL,
  `type` varchar(25) DEFAULT NULL,
  `blood_unit` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `approved_at` timestamp NULL DEFAULT NULL,
  `case_details` varchar(150) DEFAULT NULL,
  `appointment_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`appointment_id`),
  KEY `post_status` (`status_id`),
  KEY `blood_process_id` (`blood_process_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blood_groups`
--

DROP TABLE IF EXISTS `blood_groups`;
CREATE TABLE IF NOT EXISTS `blood_groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_groups`
--

INSERT INTO `blood_groups` (`group_id`, `group_name`) VALUES
(1, 'A+'),
(2, 'A-'),
(3, 'B+'),
(4, 'B-'),
(5, 'AB+'),
(6, 'AB-'),
(7, 'O+'),
(8, 'O-');

-- --------------------------------------------------------

--
-- Table structure for table `blood_processes`
--

DROP TABLE IF EXISTS `blood_processes`;
CREATE TABLE IF NOT EXISTS `blood_processes` (
  `process_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_name` varchar(30) DEFAULT NULL,
  `interval_days` int(11) DEFAULT NULL,
  `min_` int(11) DEFAULT NULL,
  `max_` int(11) DEFAULT NULL,
  PRIMARY KEY (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blood_processes`
--

INSERT INTO `blood_processes` (`process_id`, `process_name`, `interval_days`, `min_`, `max_`) VALUES
(1, 'Whole Blood', 56, 450, 500),
(2, 'Power Red', 112, 500, 500),
(3, 'Platelet', 7, 300, 650);

-- --------------------------------------------------------

--
-- Table structure for table `diseases`
--

DROP TABLE IF EXISTS `diseases`;
CREATE TABLE IF NOT EXISTS `diseases` (
  `disease_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `disease_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`disease_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diseases`
--

INSERT INTO `diseases` (`disease_id`, `disease_name`) VALUES
(1, 'Thalassemia'),
(2, 'Cancer'),
(3, 'Malaria'),
(4, 'HIV/AIDS'),
(5, 'Anemia'),
(6, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_type` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`status_id`, `status_type`) VALUES
(1, 'completed'),
(2, 'canceled'),
(3, 'active'),
(4, 'inactive'),
(5, 'suspended'),
(6, 'rejected'),
(7, 'approved'),
(8, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `passwrd` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `birthday` timestamp NULL DEFAULT NULL,
  `profile_pic` varchar(50) DEFAULT 'default.png',
  `status_id` int(11) DEFAULT '3',
  `blood_group_id` int(11) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `donated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reset_token` varchar(255) DEFAULT NULL,
  `expiry` timestamp NULL DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `blood_group_id` (`blood_group_id`),
  KEY `acc_status` (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `name`, `email`, `passwrd`, `phone_number`, `gender`, `birthday`, `profile_pic`, `status_id`, `blood_group_id`, `is_admin`, `donated_at`, `created_at`, `updated_at`, `reset_token`, `expiry`, `city`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$27wyB0kHIpDx3vo3yd5RduL6jog7/jnsaRKKScOGLOGqzGZuh9I5m', '0000000', 'male', '2005-05-18 21:00:00', 'default.png', 3, 1, 1, NULL, '2024-05-07 09:39:20', '2024-05-07 09:39:38', NULL, NULL, 'Beirut'),
(2, 'user', 'User', 'user@gmail.com', '$2y$10$QIZti8pWh1BzmZvbm2S7t.WC/WRG/dLR0MOLMCG2pe.IKM1/WqU6G', '0000000', 'male', '2005-12-18 22:00:00', 'default.png', 3, 5, 0, NULL, '2024-05-07 09:40:44', '2024-05-07 09:40:44', NULL, NULL, 'Beirut');

-- --------------------------------------------------------

--
-- Table structure for table `user_diseases`
--

DROP TABLE IF EXISTS `user_diseases`;
CREATE TABLE IF NOT EXISTS `user_diseases` (
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `disease_id` int(11) UNSIGNED DEFAULT NULL,
  KEY `user_id` (`user_id`),
  KEY `disease_id` (`disease_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_diseases`
--
ALTER TABLE `user_diseases`
  ADD CONSTRAINT `fk2_disease_id` FOREIGN KEY (`disease_id`) REFERENCES `diseases` (`disease_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk2_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
