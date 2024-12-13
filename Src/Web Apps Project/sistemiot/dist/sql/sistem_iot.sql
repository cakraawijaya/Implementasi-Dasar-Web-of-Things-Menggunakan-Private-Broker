-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 13, 2024 at 02:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistem_iot`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` int NOT NULL,
  `serial_number` varchar(8) NOT NULL,
  `sensor_actuator` enum('sensor','actuator') NOT NULL,
  `value` varchar(10) NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mqtt_topic` text NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `serial_number`, `sensor_actuator`, `value`, `name`, `mqtt_topic`, `time`) VALUES
(2, '87654321', 'actuator', '180', 'servo', 'kelasiot/12345678/servo', '2024-12-11 16:47:55'),
(6, '87654321', 'sensor', '40', 'suhu', 'kelasiot/87654321/suhu', '2024-12-12 14:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `serial_number` varchar(8) NOT NULL,
  `mcu_type` varchar(15) NOT NULL,
  `location` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`serial_number`, `mcu_type`, `location`, `created_time`, `active`) VALUES
('12345678', 'ESP8266', 'Danau', '2024-12-10 04:01:02', 'Yes'),
('43218765', 'Arduino', 'Green House', '2024-12-09 00:00:09', 'No'),
('87654321', 'NodeMCU', 'Kampus', '2024-12-07 06:07:29', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `gender` enum('Wanita','Pria','Undefined') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Undefined',
  `fullname` varchar(100) NOT NULL,
  `profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'dist/img/default.jpg',
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `active` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `gender`, `fullname`, `profile`, `role`, `active`) VALUES
('asyiaappp', '$2y$10$9VVWo9lwJhoGir8/AhTKruA8gbXSDhmbciJA.age9eNhqTSHiXWqK', 'Undefined', 'asyiappp Asyiapppp', 'dist/img/default.jpg', 'Admin', 'Yes'),
('bambang', '$2y$10$s1dpneBjJ2BaRA1cbKEoMOytEaH7F1Pt65aJrFjvSd6.6IKe/KCPq', 'Undefined', 'Bambang Puji', 'dist/img/default.jpg', 'User', 'No'),
('himawari', '$2y$10$S8/3Itu0RKR8dCvzaEv/2uu9cuoaBFELpWfbq4dcO2d/f8LDUK.Yq', 'Wanita', 'Himawari', 'dist/img/admin.jpg', 'Admin', 'Yes'),
('kamoee123', '$2y$10$K9xgid8jHlzQzl9wKpUuLu9sHHHxO8mAZEIakYwGKZxzYL6Z8TqNS', 'Wanita', 'KamoeeMuaachh', 'dist/img/default.jpg', 'User', 'No'),
('linling', '$2y$10$CUmcji5eBAdS7.2eSO8ApOaceiOCrApAtCdFmZSvlCzwDigqjKdb6', 'Wanita', 'Lin Ling', 'dist/img/admin.jpg', 'Admin', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serial_number` (`serial_number`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`serial_number`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`serial_number`) REFERENCES `devices` (`serial_number`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
