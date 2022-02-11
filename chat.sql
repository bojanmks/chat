-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql311.epizy.com
-- Generation Time: Feb 11, 2022 at 11:05 AM
-- Server version: 10.3.27-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `epiz_27721802_chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `friends_id` int(11) NOT NULL,
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `accepted` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`friends_id`, `user_id1`, `user_id2`, `accepted`) VALUES
(38, 6, 5, 1),
(37, 5, 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `messageContent` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `isRead` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `sender_id`, `receiver_id`, `messageContent`, `timestamp`, `isRead`) VALUES
(61, 5, 6, 'hah', '2021-07-11 18:57:49', 1),
(60, 6, 5, 'ok', '2021-07-11 18:55:59', 1),
(59, 5, 6, 'ok', '2021-07-11 18:55:51', 1),
(58, 5, 6, 'evo', '2021-07-11 18:55:08', 1),
(57, 6, 5, 'desi', '2021-07-11 18:55:03', 1),
(56, 6, 5, 'e', '2021-07-11 18:55:01', 1),
(55, 5, 6, 'e', '2021-07-11 18:54:59', 1),
(62, 6, 5, 'aha', '2021-07-11 18:57:53', 1),
(63, 5, 6, ':)', '2021-07-11 19:01:34', 1),
(64, 6, 5, ':)', '2021-07-11 19:03:32', 1),
(65, 6, 5, '.', '2021-07-11 19:03:41', 1),
(66, 5, 6, '.', '2021-07-11 19:03:46', 1),
(67, 6, 5, '.', '2021-07-11 21:52:19', 1),
(68, 5, 6, 'https://www.google.rs/', '2021-07-14 13:20:41', 1),
(72, 6, 5, 'e', '2021-07-18 19:59:28', 1),
(73, 5, 6, 'e', '2021-07-18 19:59:34', 1),
(71, 5, 6, 'http://uhhchat.epizy.com/index.php?page=messages&user=6', '2021-07-17 11:27:21', 1),
(74, 6, 5, 'e', '2021-07-18 19:59:54', 1),
(75, 5, 6, 'e', '2021-07-18 19:59:57', 1),
(76, 5, 6, 'e', '2021-07-18 20:00:09', 1),
(77, 6, 5, 'e', '2021-07-18 20:00:10', 1),
(78, 5, 6, 'e', '2021-07-18 20:00:13', 1),
(79, 6, 5, 'desi', '2021-07-18 20:00:18', 1),
(80, 5, 6, 'desi', '2021-07-18 20:00:21', 1),
(81, 6, 5, 'desi', '2021-07-18 20:00:32', 1),
(82, 6, 5, 'e', '2021-07-18 22:12:29', 1),
(83, 5, 6, 'e', '2021-07-18 22:12:53', 1),
(84, 6, 5, 'e', '2021-07-18 22:12:56', 1),
(85, 6, 5, 'e', '2021-07-18 22:13:00', 1),
(86, 5, 6, 'e', '2021-07-18 22:13:09', 1),
(87, 5, 6, 'e', '2021-07-18 22:13:14', 1),
(88, 5, 6, 'e', '2021-07-18 22:13:32', 1),
(89, 6, 5, 'e', '2021-07-22 00:26:05', 1),
(90, 6, 5, 'e', '2021-07-22 00:26:05', 1),
(91, 5, 6, 'aaaa https://9anime.to/watch/jujutsu-kaisen-tv.32n8/ep-1 aaaaa', '2021-08-02 07:11:05', 1),
(92, 5, 6, 'a', '2021-08-04 20:01:25', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'regular');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'user_image.jpg',
  `role_id` int(11) NOT NULL DEFAULT 2,
  `active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `image`, `role_id`, `active`) VALUES
(5, 'bojam', 'c5d42d0f281d958bb96dffe27ce041ee', '1626102071.jpg', 2, 1),
(6, 'nebojam', 'c5d42d0f281d958bb96dffe27ce041ee', '1624991213.jpg', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`friends_id`),
  ADD KEY `user_id1` (`user_id1`),
  ADD KEY `user_id2` (`user_id2`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `senderId` (`sender_id`),
  ADD KEY `receiverId` (`receiver_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `friends_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
