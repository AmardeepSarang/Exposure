-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2020 at 06:58 PM
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
(24, 'Cyber truck', 'images/uploads/5ed143afd76666.82875712.jpg', NULL, 111, 1, '2020-05-29 17:17:35', ''),
(25, 'Taycan', 'images/uploads/5ed14435edd036.40864098.jpg', NULL, 1, 1, '2020-05-29 17:19:49', ''),
(26, '2020 roadster', 'images/uploads/5ed1448293f690.80269394.jpg', NULL, 111, 1, '2020-05-29 17:21:06', 'This is now the 2020 roadster'),
(27, 'Spring flowers', 'images/uploads/5ed1452c43c853.96634563.jpg', NULL, 1, 1, '2020-05-29 17:23:56', ''),
(29, 'Snowy deck', 'images/uploads/5ed145dc907ae8.00005530.jpg', NULL, 121, 1, '2020-05-29 17:26:52', ''),
(30, 'statue of liberty', 'images/uploads/5ed14682810b37.81820983.jpg', NULL, 1, 1, '2020-05-29 17:29:38', ''),
(31, 'NYC river', 'images/uploads/5ed146eff3ab12.51888869.jpg', NULL, 1, 1, '2020-05-29 17:31:28', 'Some random buildings in NYC '),
(32, 'NYC beach', 'images/uploads/5ed14723cfb224.86299059.jpg', NULL, 111, 1, '2020-05-29 17:32:19', ''),
(33, 'Deck with sun', 'images/uploads/5ed147b4475bb2.67805968.jpg', NULL, 111, 1, '2020-05-29 17:34:44', 'A crisp spring day'),
(34, 'A very snowy deck', 'images/uploads/5ed147df90fd17.72928725.jpg', NULL, 1111, 1, '2020-05-29 17:35:27', ''),
(35, 'Fall deck', 'images/uploads/5ed14812cdb590.67982398.jpg', NULL, 1, 1, '2020-05-29 17:36:18', ''),
(36, 'Ducks!', 'images/uploads/5ed148547e3f81.20729285.jpg', NULL, 1, 1, '2020-05-29 17:37:24', ''),
(37, 'Taycan', 'images/uploads/5ede786974b6b5.30293276.jpg', 111, 1, 0, '2020-06-08 17:42:01', ''),
(38, '2020 roadster', 'images/uploads/5edfac36a52832.43986421.jpg', 111, 111, 0, '2020-06-09 15:35:18', 'This is now the 2020 roadster'),
(39, '2020 roadster edit 2', 'images/uploads/5edfac9cd981a9.79026823.jpg', 111, 111, 0, '2020-06-09 15:37:00', 'This is now the 2020 roadster'),
(40, '2020 roadster edit 3', 'images/uploads/5edfacc3d4c6e8.04694447.jpg', 111, 111, 0, '2020-06-09 15:37:39', 'This is now the 2020 roadster'),
(41, '2020 roadster edit 4', 'images/uploads/5edface25dda86.46217035.jpg', 111, 111, 0, '2020-06-09 15:38:10', 'This is now the 2020 roadster'),
(42, 'orange roller coaster', 'images/uploads/5efe13d9e32630.27920176.jpg', 0, 111, 1, '2020-07-02 17:05:29', ''),
(43, 'On leg', 'images/uploads/5efe1463d58ef2.65863516.jpg', 0, 111, 1, '2020-07-02 17:07:47', ''),
(45, 'ride', 'images/uploads/5efe1554c48973.56516798.jpg', 0, 111, 1, '2020-07-02 17:11:48', ''),
(50, 'wb test', 'images/uploads/5efe2be17bc812.04838362.jpg', 0, 111, 1, '2020-07-02 18:48:01', ''),
(73, 'Sunset tree', 'images/uploads/5f0345ee1a7771.18968424.jpg', 0, 113, 1, '2020-07-06 15:40:30', ''),
(74, 'Sunset tree edit', 'images/uploads/5f205d7a310076.83969242.png', 111, 113, 0, '2020-07-28 17:16:42', ''),
(76, 'beach edit', 'images/uploads/5f205eef84de60.86584025.png', 111, 111, 0, '2020-07-28 17:22:55', ''),
(83, 'statue of liberty edit', 'images/uploads/5f21aad25afef1.85555695.png', 111, 1, 0, '2020-07-29 16:58:58', ''),
(84, 'Taycan Tesla fanboy', 'images/uploads/5f2ec0c309fe63.83947261.png', 111, 1, 0, '2020-08-08 15:12:03', ''),
(91, 'delete test 3', 'images/uploads/5f317c4b66cd81.52094480.png', 119, 119, 0, '2020-08-10 16:56:43', '');

-- --------------------------------------------------------

--
-- Table structure for table `img_edit`
--

CREATE TABLE `img_edit` (
  `img_id` int(11) NOT NULL,
  `edit_id` int(11) NOT NULL COMMENT 'Another img_id '
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `img_edit`
--

INSERT INTO `img_edit` (`img_id`, `edit_id`) VALUES
(1, 6),
(37, 25),
(38, 26),
(39, 26),
(40, 26),
(41, 26),
(74, 73),
(75, 50),
(76, 50),
(77, 42),
(81, 80),
(82, 80),
(83, 30),
(84, 25),
(87, 86),
(91, 90);

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
(36, 34),
(37, 15),
(37, 18),
(37, 20),
(37, 35),
(38, 15),
(38, 16),
(38, 18),
(38, 35),
(39, 15),
(39, 16),
(39, 18),
(39, 35),
(40, 15),
(40, 16),
(40, 18),
(40, 35),
(41, 15),
(41, 16),
(41, 18),
(41, 35),
(42, 35),
(43, 35),
(44, 35),
(45, 35),
(46, 35),
(47, 35),
(48, 35),
(49, 35),
(50, 35),
(51, 35),
(52, 35),
(53, 35),
(54, 35),
(55, 35),
(56, 35),
(57, 35),
(58, 35),
(59, 35),
(60, 35),
(61, 35),
(62, 35),
(63, 35),
(64, 35),
(65, 35),
(66, 35),
(67, 35),
(68, 35),
(69, 35),
(70, 35),
(71, 35),
(72, 35),
(73, 35),
(74, 35),
(75, 35),
(76, 35),
(77, 35),
(78, 35),
(79, 35),
(80, 35),
(81, 35),
(82, 35),
(83, 25),
(83, 26),
(83, 35),
(84, 15),
(84, 16),
(84, 18),
(84, 20),
(87, 11),
(87, 35),
(87, 36),
(87, 37),
(91, 11),
(91, 35),
(91, 36),
(91, 37);

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
(111, 0),
(111, 24),
(111, 26),
(111, 27),
(111, 30),
(111, 31),
(111, 32),
(111, 36),
(111, 39),
(111, 40),
(111, 73),
(114, 36),
(114, 42),
(114, 50),
(114, 73),
(121, 25),
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
(35, ''),
(29, 'beach'),
(15, 'car'),
(14, 'cars'),
(24, 'deck'),
(34, 'duck'),
(33, 'fall'),
(36, 'fields'),
(21, 'flowers'),
(22, 'nature'),
(25, 'nyc'),
(30, 'pam'),
(19, 'pickup'),
(20, 'porsche'),
(27, 'river'),
(13, 'rollercoster'),
(37, 'sky'),
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
  `password` varchar(100) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `name`, `password`, `admin`) VALUES
(111, 'test@sim.ca', 'Test Mctester', '$2y$10$o6mgvdTPMpv8k3Us457e.eRGKmMPJwyYuWNvNPkkDeR61HydjlYX.', 0),
(119, 'admin@test.sim', 'admin', '$2y$10$nPRDZlMMQ3z4igfs5bEeeebkbw./EZ7h.DJYdwvqxA04NeyCN2572', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`Img_id`);

--
-- Indexes for table `img_edit`
--
ALTER TABLE `img_edit`
  ADD PRIMARY KEY (`img_id`,`edit_id`);

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
  MODIFY `Img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
