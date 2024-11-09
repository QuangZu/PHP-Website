-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 10:14 AM
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
-- Database: `coursework`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentid` int(5) NOT NULL,
  `commenttext` varchar(300) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_id` int(3) NOT NULL,
  `questionid` int(3) NOT NULL,
  `commentdate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentid`, `commenttext`, `username`, `user_id`, `questionid`, `commentdate`) VALUES
(1, 'Idk bro', 'ChillinPepper', 3, 1, '2024-10-27'),
(13, 'Heloo', 'Toufu', 1, 10, '2024-11-01'),
(14, 'hi', 'Toufu', 1, 10, '2024-11-01'),
(15, 'ngu', 'Nem', 6, 14, '2024-11-02'),
(16, 'hello', 'Nem', 6, 2, '2024-11-03'),
(17, 'i dunno ', 'Nem', 6, 2, '2024-11-03'),
(18, 'hi', 'admin', 7, 16, '2024-11-07');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(3) NOT NULL,
  `module_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `module_name`) VALUES
(1, 'COMP 1770 - Project Managment'),
(2, 'COMP 1841 - Web Programming'),
(3, 'COMP 1773 - User Interface Design'),
(4, 'COMP 1752 - Object Oriented Programming');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `questionid` int(3) NOT NULL,
  `user_id` int(11) NOT NULL,
  `questiontitle` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `questiontext` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `questionimage` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '.png/jpg',
  `questionlink` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `questiondate` date NOT NULL DEFAULT current_timestamp(),
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `number_like` int(11) DEFAULT 0,
  `number_comment` int(11) DEFAULT 0,
  `module_id` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`questionid`, `user_id`, `questiontitle`, `questiontext`, `questionimage`, `questionlink`, `questiondate`, `comment`, `number_like`, `number_comment`, `module_id`) VALUES
(1, 1, 'Coursework', 'Did anyone do the coursework yet ?', '', '', '2024-10-17', NULL, 1, 0, 1),
(2, 2, 'Database', 'How to run SQL guys ?', '', '', '2024-10-22', NULL, 2, 2, 2),
(10, 1, 'Thanh', 'Hi', '', '', '2024-10-28', NULL, 4, 2, 3),
(14, 6, 'Hello', 'Damn', '', '', '2024-11-01', NULL, 1, 1, 4),
(16, 7, 'Duc Anh', 'Nam and Duc Anh are friendly', '', '', '2024-11-04', NULL, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `question_likes`
--

CREATE TABLE `question_likes` (
  `likeid` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `questionid` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `question_likes`
--

INSERT INTO `question_likes` (`likeid`, `user_id`, `questionid`) VALUES
(3, 1, 1),
(2, 1, 2),
(4, 1, 10),
(7, 6, 2),
(5, 6, 10),
(6, 6, 14),
(9, 7, 10),
(8, 7, 16);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(3) NOT NULL,
  `role` int(3) NOT NULL DEFAULT 1,
  `username` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `role`, `username`, `email`, `password`, `date`, `image`) VALUES
(1, 1, 'Toufu', 'minhquangvuxd@gmail.com', '123456', '2024-11-03 12:32:38', ''),
(2, 1, 'Quang', 'quangvmgch230200@fpt.edu.vn', '123456', '2024-11-03 12:32:44', ''),
(3, 1, 'ChillinPepper', 'minhquangvuxd@outlook.com', '123456', '2024-11-03 12:32:50', ''),
(4, 1, 'Ezero', 'minhquanglb2k5@gmail.com', '123456', '2024-11-03 12:32:56', ''),
(6, 1, 'Nem', 'uvi@gmail.com', '$2y$10$rVugcrOZ/6ftnsdNQY1KT.keOJ6qJs4M4ut6VNrN.lo914x4Otb2y', '2024-11-03 12:33:12', ''),
(7, 2, 'admin', 'admin@gmail.com', '$2y$10$LazwngFXmsKJpAZ1liFcn.wbsbTCGG1eWBu4pKoTI.BEgldAW0x9i', '2024-11-07 11:12:00', 'avatar_uploads/672b0885af6a8-CC.jpg'),
(8, 1, 'duck', 'ducanh0560@gmail.com', '$2y$10$Ouv3mCedYLkAQZY3DhLaNOnYqbRLfXvPukKTcdBjxT.R4IcEfZRn.', '2024-11-06 06:10:41', 'avatar_uploads/672b0861918b3-flat,750x,075,f-pad,750x1000,f8f8f8.jpg'),
(9, 1, 'Huy', 'huydepzai4105@gmail.com', '$2y$10$PPMokW4QZopoFTd7vy0F4ugZVkyV7pY1zEh9bmP4F628FJbTQwJdq', '2024-11-05 06:32:52', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentid`),
  ADD KEY `FOREIGN` (`user_id`) USING BTREE,
  ADD KEY `questionid` (`questionid`) USING BTREE;

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`questionid`),
  ADD KEY `user_ques` (`user_id`),
  ADD KEY `module_id` (`module_id`);

--
-- Indexes for table `question_likes`
--
ALTER TABLE `question_likes`
  ADD PRIMARY KEY (`likeid`),
  ADD UNIQUE KEY `user_id` (`user_id`,`questionid`),
  ADD KEY `questionid` (`questionid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`) USING BTREE,
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `questionid` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `question_likes`
--
ALTER TABLE `question_likes`
  MODIFY `likeid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `Test` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `question_comment_id` FOREIGN KEY (`questionid`) REFERENCES `question` (`questionid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `module` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ques` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `question_likes`
--
ALTER TABLE `question_likes`
  ADD CONSTRAINT `question_likes_ibfk_1` FOREIGN KEY (`questionid`) REFERENCES `question` (`questionid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
