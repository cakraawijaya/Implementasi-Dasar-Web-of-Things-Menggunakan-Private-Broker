-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2024 at 02:39 AM
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
  `username` varchar(10) NOT NULL,
  `sensor_actuator` enum('sensor','actuator') NOT NULL,
  `value` varchar(6) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mqtt_topic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `serial_number`, `username`, `sensor_actuator`, `value`, `name`, `mqtt_topic`, `time`) VALUES
(1, '12345678', 'albert', 'sensor', '40.5', 'suhu', 'kelasiot/12345678/suhu', '2024-12-13 13:49:02'),
(2, '12345678', 'albert', 'sensor', '60.0', 'kelembapan', 'kelasiot/12345678/kelembapan', '2024-12-13 13:50:05'),
(3, '12345678', 'albert', 'actuator', '180', 'servo', 'kelasiot/12345678/servo', '2024-12-13 13:50:05'),
(4, '43765218', 'albert', 'sensor', '25.3', 'suhu', 'kelasiot/43765218/suhu', '2024-12-13 13:54:09'),
(5, '43765218', 'albert', 'sensor', '80.0', 'kelembapan', 'kelasiot/43765218/kelembapan', '2024-12-13 13:54:09'),
(6, '43765218', 'albert', 'actuator', '150', 'servo', 'kelasiot/43765218/servo', '2024-12-13 13:54:09'),
(7, '46213454', 'himawari', 'sensor', '18.6', 'suhu', 'kelasiot/46213454/suhu', '2024-12-13 13:57:28'),
(8, '46213454', 'himawari', 'sensor', '65.4', 'kelembapan', 'kelasiot/46213454/kelembapan', '2024-12-13 13:57:28'),
(9, '46213454', 'himawari', 'actuator', '95', 'servo', 'kelasiot/46213454/servo', '2024-12-13 13:57:28'),
(10, '56781234', 'himawari', 'sensor', '28.2', 'suhu', 'kelasiot/56781234/suhu', '2024-12-13 14:00:06'),
(11, '56781234', 'himawari', 'sensor', '72.8', 'kelembapan', 'kelasiot/56781234/kelembapan', '2024-12-13 14:00:06'),
(12, '56781234', 'himawari', 'actuator', '34', 'servo', 'kelasiot/56781234/servo', '2024-12-13 14:00:06'),
(13, '83562714', 'linling', 'sensor', '38.0', 'suhu', 'kelasiot/83562714/suhu', '2024-12-13 14:02:46'),
(14, '83562714', 'linling', 'sensor', '50.2', 'kelembapan', 'kelasiot/83562714/kelembapan', '2024-12-13 14:02:46'),
(15, '83562714', 'linling', 'actuator', '120', 'servo', 'kelasiot/83562714/servo', '2024-12-13 14:02:46'),
(16, '78561342', 'linling', 'sensor', '60.5', 'suhu', 'kelasiot/78561342/suhu', '2024-12-13 14:04:29'),
(17, '78561342', 'linling', 'sensor', '25.7', 'kelembapan', 'kelasiot/78561342/kelembapan', '2024-12-13 14:04:29'),
(18, '78561342', 'linling', 'actuator', '42', 'servo', 'kelasiot/78561342/servo', '2024-12-13 14:04:29'),
(19, '46342134', 'bambang', 'sensor', '32.3', 'suhu', 'kelasiot/46342134/suhu', '2024-12-13 14:06:45'),
(20, '46342134', 'bambang', 'sensor', '58.7', 'kelembapan', 'kelasiot/46342134/kelembapan', '2024-12-13 14:06:45'),
(21, '46342134', 'bambang', 'actuator', '58', 'servo', 'kelasiot/46342134/servo', '2024-12-13 14:06:45'),
(22, '43218765', 'bambang', 'sensor', '28.0', 'suhu', 'kelasiot/43218765/suhu', '2024-12-13 14:08:58'),
(23, '43218765', 'bambang', 'sensor', '46.5', 'kelembapan', 'kelasiot/43218765/kelembapan', '2024-12-13 14:08:58'),
(24, '43218765', 'bambang', 'actuator', '73', 'servo', 'kelasiot/43218765/servo', '2024-12-13 14:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `serial_number` varchar(8) NOT NULL,
  `username` varchar(10) NOT NULL,
  `mcu_type` varchar(255) NOT NULL,
  `location` text NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`serial_number`, `username`, `mcu_type`, `location`, `created_time`, `active`) VALUES
('12345678', 'albert', 'ESP32', 'Gedung A', '2024-12-13 17:55:30', 'No'),
('43218765', 'bambang', 'Wemos D1 R2', 'Mall', '2024-12-12 23:40:31', 'Yes'),
('43765218', 'albert', 'ESP8266', 'Kolam', '2024-12-12 22:57:58', 'Yes'),
('46213454', 'himawari', 'ESP32', 'Taman', '2024-12-12 23:38:19', 'Yes'),
('46342134', 'bambang', 'Wemos D1 Mini', 'Pelabuhan', '2024-12-12 23:41:30', 'Yes'),
('56781234', 'himawari', 'RPI-W', 'Gedung B', '2024-12-12 23:39:05', 'Yes'),
('78561342', 'linling', 'Wemos D1 R1', 'Green House', '2024-12-12 16:43:38', 'No'),
('83562714', 'linling', 'ESP8266', 'Kantor A', '2024-12-12 16:45:04', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `iot_connection`
--

CREATE TABLE `iot_connection` (
  `id` int NOT NULL,
  `serial_number` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `username` varchar(10) NOT NULL,
  `server_name` varchar(255) NOT NULL,
  `port` varchar(4) NOT NULL,
  `username_account` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password_account` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `client_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `iot_connection`
--

INSERT INTO `iot_connection` (`id`, `serial_number`, `username`, `server_name`, `port`, `username_account`, `password_account`, `client_id`) VALUES
(1, '83562714', 'linling', 'kelasiotdevan.cloud.shiftr.io', '443', 'kelasiotdevan', 'w4TXjZVczSQ0DyiW', 'client-kelasiot-001');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('Wanita','Pria','Undefined') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Undefined',
  `fullname` varchar(255) NOT NULL,
  `profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'dist/img/default.jpg',
  `role` enum('Admin','User') NOT NULL DEFAULT 'User',
  `active` enum('Yes','No') NOT NULL,
  `reset_password` varchar(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `gender`, `fullname`, `profile`, `role`, `active`, `reset_password`) VALUES
('albert', '$2y$10$ka3uoc78kUvOcwRabECtVO7p80RXshScsHAphn18fgFGPCUHG8xfG', 'albert@gmail.com', 'Undefined', 'Albert Wiraradja', 'dist/img/default.jpg', 'User', 'Yes', '0'),
('bambang', '$2y$10$7CZqh1h3lxWj0J2vl14Em.ZRWBunrz4Ggdwlp9GxpVFSyT3AgHY/W', 'bambang@gmail.com', 'Pria', 'Bambang Prakoso', 'dist/img/user.jpg', 'User', 'No', '0'),
('himawari', '$2y$10$MbRu6rS5J/6KIUAILWy.LORD3c53fXFUxG1aRu99RqQL60OdEWbtO', 'himawari@gmail.com', 'Wanita', 'Sasaki Himawari', 'dist/img/admin.jpg', 'Admin', 'No', '0'),
('linling', '$2y$10$n2W.Kw80M1p/EfD1hkcsbudRRCbAa7CeuhPM/bvLy.m04d4wvVs3i', 'linling@gmail.com', 'Wanita', 'Lin Ling', 'dist/img/admin.jpg', 'Admin', 'Yes', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`),
  ADD KEY `serial_number` (`serial_number`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`serial_number`),
  ADD KEY `username` (`username`),
  ADD KEY `username_2` (`username`);

--
-- Indexes for table `iot_connection`
--
ALTER TABLE `iot_connection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`serial_number`),
  ADD KEY `username_2` (`username`),
  ADD KEY `username_3` (`username`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `iot_connection`
--
ALTER TABLE `iot_connection`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data`
--
ALTER TABLE `data`
  ADD CONSTRAINT `data_ibfk_1` FOREIGN KEY (`serial_number`) REFERENCES `devices` (`serial_number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `data_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `devices`
--
ALTER TABLE `devices`
  ADD CONSTRAINT `devices_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `iot_connection`
--
ALTER TABLE `iot_connection`
  ADD CONSTRAINT `iot_connection_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON UPDATE CASCADE,
  ADD CONSTRAINT `iot_connection_ibfk_3` FOREIGN KEY (`serial_number`) REFERENCES `devices` (`serial_number`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
