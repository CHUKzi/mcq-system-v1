-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2022 at 09:35 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mcq`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `admin_level` int(11) NOT NULL,
  `last_login` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `admin_level`, `last_login`) VALUES
(1, 'admin', 'alexlanka@gmail.com', '0192023a7bbd73250516f069df18b500', 0, '2022-04-24 01:04:49'),
(2, 'Smith', 'roguerevengerpcj2@gmail.com', '6a97b6bab97302add091538b802763e3', 1, '2022-04-24 00:26:28');

-- --------------------------------------------------------

--
-- Table structure for table `a_table`
--

CREATE TABLE `a_table` (
  `id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `q_answer` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `a_table`
--

INSERT INTO `a_table` (`id`, `u_id`, `q_id`, `q_answer`, `time`) VALUES
(6, 80, 36, 4, '2022-04-23 19:28:53'),
(7, 80, 39, 3, '2022-04-23 19:29:10'),
(8, 80, 37, 1, '2022-04-23 19:29:15'),
(9, 80, 38, 4, '2022-04-23 19:29:17'),
(10, 80, 40, 2, '2022-04-23 19:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

CREATE TABLE `houses` (
  `id` int(11) NOT NULL,
  `h_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`id`, `h_name`, `time`) VALUES
(4, 'House 1', '2021-10-17 16:57:41'),
(5, 'House 2', '2021-10-17 16:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `q_table`
--

CREATE TABLE `q_table` (
  `id` int(11) NOT NULL,
  `quaction` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `a1` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `a2` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `a3` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `a4` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `r_answer` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `q_table`
--

INSERT INTO `q_table` (`id`, `quaction`, `a1`, `a2`, `a3`, `a4`, `r_answer`, `time`) VALUES
(36, '<p>Holkar Trophy is associated with which sport?</p>', 'Bridge', 'Football', 'Hockey', 'Badminton', 1, '2022-04-23 19:08:01'),
(37, '<p>Term Chinaman is related to which sports ?</p>', 'Football', 'Golf', 'Hockey', 'Cricket', 4, '2022-04-23 19:08:49'),
(38, '<p>With which game does Davis Cup is associated</p>', 'Hockey', 'Lawn Tennis ', 'Table Tennis', 'Polo', 2, '2022-04-23 19:09:36'),
(39, '<p>Who is the first Indian woman to win an Asian Games gold in 400m run</p>', 'M.L. Valsamma', 'Kamaljit Sandhu', 'P.T. Usha', 'K.Malleshwari', 3, '2022-04-23 19:10:27'),
(40, '<p>The first Indian to cross seven important seas by swimming ____ ?</p>', 'Amrendra Singh', 'Junko Taibei', 'Bula Chaudhury', 'Yuri Gagarin', 3, '2022-04-23 19:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `site_title` varchar(25) NOT NULL,
  `stats` int(11) NOT NULL,
  `fb` longtext NOT NULL,
  `yt` longtext NOT NULL,
  `teli` longtext NOT NULL,
  `wa` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `stats`, `fb`, `yt`, `teli`, `wa`) VALUES
(6, 'Alex Lanka - MCQ System', 0, 'https://www.facebook.com/', 'https://www.youtube.com/', 'https://telegram.org/', 'https://www.whatsapp.com/');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nick_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `house_id` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `s_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nick_name`, `email`, `house_id`, `time`, `s_time`) VALUES
(80, 'Alex', 'CHUKzi', 'alexlanka99@gmail.com', 4, '2022-04-23 19:28:15', '2022-04-24 00:58:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `a_table`
--
ALTER TABLE `a_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `houses`
--
ALTER TABLE `houses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `q_table`
--
ALTER TABLE `q_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `a_table`
--
ALTER TABLE `a_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `houses`
--
ALTER TABLE `houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `q_table`
--
ALTER TABLE `q_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
