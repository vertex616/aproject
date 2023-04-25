-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2023 at 04:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `pid` int(10) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `phase` enum('design','development','testing','deployment','complete') DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `uid` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`pid`, `title`, `start_date`, `end_date`, `phase`, `description`, `uid`) VALUES
(1, 'Website Redesign', '2023-05-01', '2023-07-31', 'development', 'Redesigning our company website to improve user experience and increase engagement. This will involve creating new designs, updating content, and integrating new features such as a chatbot and improved search functionality.', 1),
(2, 'Mobile App Development', '2023-06-01', '2023-10-31', 'testing', 'Developing a mobile app for our e-commerce platform to allow customers to browse and purchase products on-the-go. The app will be available for both iOS and Android devices and will include features such as push notifications, in-app messaging, and a personalized shopping experience.', 2),
(3, 'AI Chatbot Implementation', '2023-07-01', '2023-09-30', 'deployment', 'Implementing an AI-powered chatbot to improve customer service and support. The chatbot will be integrated into our website and will be able to handle a range of customer inquiries, including product information, order tracking, and returns.', 3),
(4, 'Cloud Migration', '2023-08-01', '2023-12-30', '', 'Migrating our on-premise infrastructure to the cloud to improve scalability, reliability, and cost-effectiveness. This will involve designing a new architecture, selecting a cloud provider, and migrating our data and applications to the cloud.', 5),
(5, 'pc builder', '2023-04-23', '2023-04-30', 'development', 'please develop this normal pc to a well build gaming pc', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(10) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `email`) VALUES
(1, 'john', '$2y$10$KnTG7z26/wze.yty8I47IO6Lqfv5AGDHshJT.WUJYEBwQdpmq.BKq', 'john@amazon.com'),
(2, 'jane', '$2y$10$h2pX5qEIiDq4rNZ9AWDzceW9aZgbBcMZdkn1KPx4ZDC4RiaydBqZi', 'jane@cloud.com'),
(3, 'david', '$2y$10$uHy2m5QOQE.k0lioHg/YQuWsDrU08eNIumD7g.3r7p6LgBi/Pjm4m', 'david@yahoo.com'),
(4, ' sarah', '$2y$10$Rx7oO0Gb.AnAL6iIyjPLQeqS0d0qB2ZmZJBgKNrS0ySi.J248MWt.', 'sarah@gmail.com'),
(5, 'sarah', '$2y$10$ORQJmmCxScnhE6OuBSTJrunWsOl1aoYhMKqGmIsZTPuTdA0E85khK', 'sarah@amazon.com'),
(6, 'yousaf', '$2y$10$JoPk0eHshG5DX3PR0wdAGecrc5H.2dtMjYtK0foi/aIp18GyXM956', 'yousafbazaz@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `pid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
