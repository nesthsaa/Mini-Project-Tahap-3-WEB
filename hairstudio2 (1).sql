-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 10:45 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hairstudio2`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `service` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `name`, `date`, `time`, `service`, `status`) VALUES
(1, 'agnes', '2024-04-03', '13:09:00', 'Haircut', 'accepted'),
(2, '', '0000-00-00', '00:00:00', '', 'rejected'),
(5, 'nes', '2024-04-11', '00:59:00', 'Haircut', 'accepted'),
(6, 'agnesia', '2024-04-25', '15:23:00', 'Styling', 'accepted'),
(7, 'nama', '2024-04-13', '16:15:00', 'Keratin Straightening', 'accepted'),
(8, 'dera', '2024-04-18', '23:28:00', 'Perm', 'accepted'),
(9, 'karina', '2024-04-24', '23:06:00', 'Keratin Straightening', 'pending'),
(10, 'winter', '2024-04-24', '09:15:00', 'Styling', 'accepted'),
(11, 'ningyi', '2024-04-22', '21:27:00', 'Creambath', 'accepted'),
(12, 'nana', '2024-04-17', '16:02:00', 'Haircut', 'accepted'),
(13, 'nara', '2024-04-24', '04:07:00', 'Haircut', 'pending'),
(14, 'tay', '2024-04-24', '04:08:00', 'Styling', 'pending'),
(15, 'ivyy', '2024-04-24', '04:11:00', 'Perm', 'pending'),
(16, 'ppp', '2024-04-24', '04:21:00', 'Coloring', 'pending'),
(17, 'augistine', '2024-04-24', '19:25:00', 'Coloring', 'pending'),
(18, 'emma', '2024-04-16', '21:08:00', 'Hair Spa', 'accepted'),
(19, 'clean', '2024-04-24', '18:16:00', 'Styling', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `treatment` varchar(100) NOT NULL,
  `feedback` text NOT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `treatment`, `feedback`, `rating`, `created_at`) VALUES
(1, 'Haircut', 'aaaa', 2, '2024-04-03 15:28:30'),
(2, 'Haircut', 'aaaa', 2, '2024-04-03 16:27:14'),
(7, 'Haircut', 'aaaa', 2, '2024-04-03 16:34:57'),
(8, 'Coloring', 'nes', 4, '2024-04-03 16:38:06'),
(9, 'Coloring', 'nes', 4, '2024-04-03 16:41:27'),
(10, 'Creambath', 'bagus', 5, '2024-04-04 02:41:26'),
(11, 'Perm', 'bagus', 5, '2024-04-04 04:00:46'),
(12, 'Perm', 'bagus', 5, '2024-04-04 04:05:05'),
(13, 'Perm', 'bagus', 5, '2024-04-04 04:06:13'),
(14, 'Keratin Straightening', 'cocok', 5, '2024-04-15 01:07:00'),
(15, 'Creambath', 'oke', 4, '2024-04-15 01:14:59'),
(16, 'Hair Extensions', 'memuaskan', 5, '2024-04-16 19:36:31'),
(17, 'Coloring', 'oke lah', 3, '2024-04-16 19:37:18'),
(18, 'Coloring', 'oke lah', 3, '2024-04-16 19:43:24'),
(19, 'Haircut', 'okeoek', 3, '2024-04-16 19:43:56'),
(20, 'Haircut', 'okeoek', 3, '2024-04-16 19:45:23'),
(30, 'Coloring', '23', 3, '2024-04-16 20:20:52'),
(31, 'Haircut', 'sgt cocok ', 4, '2024-04-16 20:21:55'),
(32, 'Haircut', 'yaaa oked', 4, '2024-04-16 20:23:43'),
(33, 'Haircut', 'okelah', 4, '2024-04-16 20:25:01'),
(34, 'Coloring', 'good good', 4, '2024-04-16 20:26:11'),
(35, 'Hair Spa', 'lumayan', 3, '2024-04-18 08:03:45'),
(36, 'Styling', 'lumayan', 3, '2024-04-18 08:16:27');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL,
  `level` varchar(10) DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `email`, `username`, `password`, `level`) VALUES
(1, '', 'admin', '1', 'admin'),
(2, '', 'ula', '1', 'customer'),
(3, 'agnesiaprawini2019@gmail.com', 'nesthsaa', '123', 'customer'),
(5, 'agnesia@gmail.com', 'ann', '12', 'customer'),
(6, 'agn@gmail.com', 'nes', '123', ''),
(7, 'stylist123@gmail.com', 'stylist', '321', 'stylist'),
(9, 'nesa@gmail.com', 'nesa', '', 'customer'),
(10, 'mnn@gmail.com', 'annnnnn', '', 'customer'),
(11, 'caca@gmail.com', 'caca123', '', 'customer'),
(12, 'may@gmail.com', 'mayasy', '', 'customer'),
(13, 'hangyulsite@gmail.com', 'hanw', '', 'customer'),
(16, '', '', '', ''),
(17, 'karina@gmail.com', 'karina', '141', ''),
(18, 'thesa@gmail.con', 'thesa', '$2y$10$/V3', 'customer'),
(19, 'agnesia1@gmail.com', 'agnesia', '111', 'customer'),
(20, 'taylor@gmail.com', 'taylor', 'taytay', ''),
(21, 'betty@gmail.com', 'betty', 'cardigan', 'customer'),
(23, 'ivy@gmail.com', 'ivy', 'ivy', 'customer'),
(25, 'clean@gmail.com', 'clean', '1989', 'customer'),
(26, 'lavender@gmail.com', 'lavender', 'haze', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
