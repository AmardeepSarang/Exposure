-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2020 at 07:33 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `exposure`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `Img_id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `Img_file_name` varchar(100) NOT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `uploaded_by` int(11) NOT NULL,
  `is_original` tinyint(1) NOT NULL,
  `uploaded_on` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`Img_id`, `title`, `Img_file_name`, `edited_by`, `uploaded_by`, `is_original`, `uploaded_on`, `description`) VALUES
(23, 'Model x', 'images/uploads/5ed1435ca49fa8.44580793.jpg', NULL, 1, 1, '2020-05-29 17:16:12', ''),
(24, 'Cyber truck', 'images/uploads/5ed143afd76666.82875712.jpg', NULL, 1, 1, '2020-05-29 17:17:35', ''),
(25, 'Taycan', 'images/uploads/5ed14435edd036.40864098.jpg', NULL, 1, 1, '2020-05-29 17:19:49', ''),
(26, '2020 roadster', 'images/uploads/5ed1448293f690.80269394.jpg', NULL, 1, 1, '2020-05-29 17:21:06', 'This is now the 2020 roadster'),
(27, 'Spring flowers', 'images/uploads/5ed1452c43c853.96634563.jpg', NULL, 1, 1, '2020-05-29 17:23:56', ''),
(29, 'Snowy deck', 'images/uploads/5ed145dc907ae8.00005530.jpg', NULL, 1, 1, '2020-05-29 17:26:52', ''),
(30, 'statue of liberty', 'images/uploads/5ed14682810b37.81820983.jpg', NULL, 1, 1, '2020-05-29 17:29:38', ''),
(31, 'NYC river', 'images/uploads/5ed146eff3ab12.51888869.jpg', NULL, 1, 1, '2020-05-29 17:31:28', 'Some random buildings in NYC '),
(32, 'NYC beach', 'images/uploads/5ed14723cfb224.86299059.jpg', NULL, 1, 1, '2020-05-29 17:32:19', ''),
(33, 'Deck with sun', 'images/uploads/5ed147b4475bb2.67805968.jpg', NULL, 1, 1, '2020-05-29 17:34:44', 'A crisp spring day'),
(34, 'A very snowy deck', 'images/uploads/5ed147df90fd17.72928725.jpg', NULL, 1, 1, '2020-05-29 17:35:27', ''),
(35, 'Fall deck', 'images/uploads/5ed14812cdb590.67982398.jpg', NULL, 1, 1, '2020-05-29 17:36:18', ''),
(36, 'Ducks!', 'images/uploads/5ed148547e3f81.20729285.jpg', NULL, 1, 1, '2020-05-29 17:37:24', '');

-- --------------------------------------------------------

--
-- Table structure for table `img_edit`
--

CREATE TABLE `img_edit` (
  `img_id` int(11) NOT NULL,
  `edit_id` int(11) NOT NULL COMMENT 'Another img_id '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `img_tag`
--

CREATE TABLE `img_tag` (
  `img_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_tag`
--

INSERT INTO `img_tag` (`img_id`, `tag_id`) VALUES
(0, 0),
(18, 8),
(18, 11),
(18, 12),
(18, 13),
(19, 12),
(19, 13),
(19, 14),
(20, 11),
(20, 12),
(20, 13),
(21, 11),
(21, 12),
(21, 13),
(22, 11),
(22, 12),
(22, 13),
(23, 15),
(23, 16),
(23, 17),
(23, 18),
(24, 15),
(24, 16),
(24, 18),
(24, 19),
(25, 15),
(25, 18),
(25, 20),
(26, 15),
(26, 16),
(26, 18),
(27, 21),
(27, 22),
(28, 22),
(28, 23),
(28, 24),
(29, 22),
(29, 23),
(29, 24),
(30, 25),
(30, 26),
(31, 25),
(31, 27),
(31, 28),
(32, 29),
(32, 30),
(32, 31),
(33, 24),
(33, 32),
(34, 22),
(34, 23),
(34, 24),
(35, 22),
(35, 24),
(35, 33),
(36, 22),
(36, 34);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `img_id`) VALUES
(76, 23),
(111, 23),
(111, 30),
(111, 31),
(157, 23);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`tag_id`, `tag_name`) VALUES
(29, 'beach'),
(15, 'car'),
(14, 'cars'),
(24, 'deck'),
(34, 'duck'),
(33, 'fall'),
(21, 'flowers'),
(22, 'nature'),
(25, 'nyc'),
(30, 'pam'),
(19, 'pickup'),
(20, 'porsche'),
(27, 'river'),
(13, 'rollercoster'),
(28, 'skyline'),
(23, 'snow'),
(26, 'statue-liberty'),
(32, 'sun'),
(17, 'SUV'),
(16, 'tesla'),
(11, 'test'),
(8, 'test1'),
(31, 'tree'),
(18, 'wallpapaer'),
(12, 'wonderland');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(40) NOT NULL,
  `name` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`Img_id`);

--
-- Indexes for table `img_tag`
--
ALTER TABLE `img_tag`
  ADD PRIMARY KEY (`img_id`,`tag_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_id`,`img_id`),
  ADD KEY `user_id` (`user_id`,`img_id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name` (`tag_name`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `Img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
