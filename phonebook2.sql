-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2021 at 09:03 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phonebook2`
--

-- --------------------------------------------------------

--
-- Table structure for table `phone_info`
--

CREATE TABLE `phone_info` (
  `phone_id` int(11) NOT NULL,
  `contact_num` varchar(24) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phone_info`
--

INSERT INTO `phone_info` (`phone_id`, `contact_num`, `user_id`) VALUES
(1, '0194853341', 1),
(2, '0124853341', 2),
(4, '0144853341', 1),
(5, '0154853341', 2),
(6, '0127124124', 4),
(7, '011124124', 5),
(8, '0181241249', 6),
(9, '0123488564', 7),
(10, '0192141577', 8),
(11, '01124125886', 9),
(12, '01259135818', 10),
(13, '0141259024', 11),
(14, '0171241244', 11),
(15, '0186526788', 12),
(16, '02141611661', 13),
(17, '0121361626', 13);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `name`) VALUES
(1, 'Luqman Ahmad'),
(2, 'Ali Baba'),
(3, 'Kamal Yahyas'),
(4, 'Mr. Jordon Kiss'),
(5, 'Shahron Adli'),
(6, 'Mr. Jordon Koss'),
(7, 'Lee Tan Su'),
(8, 'Yusuf Tayub'),
(9, 'Tamae Dafi'),
(10, 'Mr. Sofi'),
(11, 'Miss Irene'),
(12, 'Amalina Hasan'),
(13, 'Yunus');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phone_info`
--
ALTER TABLE `phone_info`
  ADD PRIMARY KEY (`phone_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phone_info`
--
ALTER TABLE `phone_info`
  MODIFY `phone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `phone_info`
--
ALTER TABLE `phone_info`
  ADD CONSTRAINT `phone_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_info` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
