-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 14, 2025 at 09:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newdata`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `author` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `borrowed_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `description`, `author`, `user_id`, `borrowed_until`) VALUES
(1, 'The Holy Quran', 'The sacred book of Islam, revealed by God to Prophet Muhammad.', 'God', 1, '2025-09-19 21:06:03'),
(2, 'The Beginning and the End', 'Comprehensive history of Islamic civilization until the 8th century AH.', 'Ibn Kathir', 5, '2025-09-19 19:46:16'),
(3, 'Manahil al-Irfan', 'A detailed guide to Qur’anic sciences and recitation styles.', 'Abdulaziz Ibn Baz', 1, '2025-09-19 21:06:18'),
(4, 'Journey to the Moon', 'Classic sci-fi about humanity’s first lunar expedition.', 'Jules Verne', 2, '2025-09-19 21:20:31'),
(5, 'One Thousand and One Nights', 'Collection of Middle Eastern folk tales with magic and wisdom.', 'Anonymous', 2, '2025-09-19 21:07:02'),
(6, 'The Lost Library', 'An ancient manuscript found in a forgotten monastery.', 'Unknown Author', 2, '2025-09-24 21:20:44'),
(7, 'Digital Dreams', 'A speculative novel about AI consciousness in 2080.', 'Lena Carter', 5, '2025-09-24 19:43:32'),
(12, 'test', 'test', 'test', 3, NULL),
(13, 'The Holy Quran', 'The Holy Quran', 'The Holy Quran', 4, '2025-09-19 21:24:33'),
(14, 'The Holy Quran', 'The Holy Quran', 'The Holy Quran', NULL, NULL),
(15, 'The Holy Quran', 'The Holy Quran', 'The Holy Quran', NULL, NULL),
(16, 'Journey to the Moon', 'Journey to the Moon', 'Journey to the Moon', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `admin`) VALUES
(1, 'Ahmed', 'Mohamed', 'ahmed@example.com', '123456', 0),
(2, 'sara', 'Ali', 'sara@example.com', '1234567', 0),
(3, 'ahmedda', 'Mohamed', 'ahmedahmed800@gmail.com', 'a1a2a3', 1),
(4, 'ahmed', 'rashwan', 'rashwan@gmail.com', '123456', 1),
(5, 'ahmed', 'rashwan', 'ahmedrashwan@gmail.com', '123456789', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_books_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `fk_books_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
