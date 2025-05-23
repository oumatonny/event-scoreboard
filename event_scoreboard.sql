-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 23, 2025 at 11:33 AM
-- Server version: 8.0.39
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_scoreboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `judges`
--

DROP TABLE IF EXISTS `judges`;
CREATE TABLE IF NOT EXISTS `judges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `display_name` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `judges`
--

INSERT INTO `judges` (`id`, `username`, `display_name`, `password_hash`, `is_admin`, `created_at`, `last_login`) VALUES
(1, 'mwas', 'Admin Mwangi', '$2y$10$W8p/aYJ6rQYv5XeQ5WqB.u5s7UOQdD7JZ8XkLm1VgK9sNwY6b3XZC', 1, '2025-05-23 11:17:38', NULL),
(2, 'Admin', 'Admin', '$2y$10$aBFXNTSvxXcFzWldxrTrCOq0sL3yWlK8RWWkb6HIANijeLE.EM0T.', 1, '2025-05-23 11:21:14', '2025-05-23 11:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
CREATE TABLE IF NOT EXISTS `scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `judge_id` int NOT NULL,
  `user_id` int NOT NULL,
  `points` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `judge_id` (`judge_id`),
  KEY `user_id` (`user_id`)
) ;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`id`, `judge_id`, `user_id`, `points`, `created_at`) VALUES
(1, 1, 1, 70, '2025-05-23 11:22:59'),
(2, 1, 3, 50, '2025-05-23 11:23:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `created_at`) VALUES
(1, 'Tonny Ouma', '2025-05-23 11:19:00'),
(2, 'Mary Wambui', '2025-05-23 11:19:00'),
(3, 'James Kariuki', '2025-05-23 11:19:00'),
(4, 'Grace Akinyi', '2025-05-23 11:19:00'),
(5, 'Peter Mwangi', '2025-05-23 11:19:00'),
(6, 'Susan Atieno', '2025-05-23 11:19:00'),
(7, 'David Odhiambo', '2025-05-23 11:19:00'),
(8, 'Lilian Achieng', '2025-05-23 11:19:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `scores`
--
ALTER TABLE `scores`
  ADD CONSTRAINT `scores_ibfk_1` FOREIGN KEY (`judge_id`) REFERENCES `judges` (`id`),
  ADD CONSTRAINT `scores_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
