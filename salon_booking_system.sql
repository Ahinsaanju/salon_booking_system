-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2026 at 07:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `salon_booking_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') DEFAULT 'pending',
  `total_amount` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(50) DEFAULT 'Pending',
  `payment_method` varchar(50) DEFAULT NULL,
  `reminder_sent` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `customer_id`, `staff_id`, `appointment_date`, `appointment_time`, `status`, `total_amount`, `created_at`, `payment_status`, `payment_method`, `reminder_sent`) VALUES
(14, 5, 2, '2026-03-19', '12:34:00', 'confirmed', 3000.00, '2026-03-17 18:04:13', 'Pending', 'Cash', 1),
(15, 8, 2, '2026-03-20', '12:28:00', 'confirmed', 3000.00, '2026-03-18 17:57:00', 'Pending', 'Card', 0),
(16, 8, 2, '2026-03-20', '14:30:00', 'pending', 3000.00, '2026-03-18 18:06:27', 'Pending', 'Card', 0),
(17, 8, 2, '2026-03-20', '15:30:00', 'pending', 3000.00, '2026-03-18 18:17:51', 'Pending', 'Card', 0),
(21, 10, 1, '2026-03-20', '09:20:00', 'confirmed', 5000.00, '2026-03-19 12:45:50', 'Paid', 'Card', 0),
(22, 6, 2, '2026-03-21', '15:07:00', 'pending', 3000.00, '2026-03-19 18:34:18', 'Pending', 'Card', 0),
(23, 6, 2, '2026-03-21', '09:10:00', 'confirmed', 3000.00, '2026-03-19 18:34:35', 'Paid', 'Online Card', 0);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_services`
--

CREATE TABLE `appointment_services` (
  `id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_services`
--

INSERT INTO `appointment_services` (`id`, `appointment_id`, `service_id`) VALUES
(2, 14, 2),
(3, 15, 2),
(4, 16, 2),
(5, 17, 2),
(9, 21, 3),
(10, 22, 2),
(11, 23, 2);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `payment_method` enum('cash','card','online') NOT NULL,
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `amount` decimal(10,2) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `appointment_id`, `payment_method`, `payment_status`, `amount`, `payment_date`) VALUES
(1, 23, '', '', 3000.00, '2026-03-19 18:35:03');

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`service_id`, `service_name`, `description`, `price`, `duration`, `created_at`) VALUES
(1, 'Haircut', 'Professional haircut service', 1500.00, 30, '2026-03-16 08:38:07'),
(2, 'Facial', 'Skin treatment facial', 3000.00, 45, '2026-03-16 08:38:07'),
(3, 'Hair Coloring', 'Full hair coloring service', 5000.00, 90, '2026-03-16 08:38:07'),
(4, 'Beard Trim', 'Beard shaping and trimming', 800.00, 15, '2026-03-16 08:38:07'),
(5, 'Full Body Wax', 'full body wax service', 4500.00, 120, '2026-03-17 18:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `user_id`, `specialization`) VALUES
(1, 3, 'Hair Stylist'),
(2, 4, 'Makeup Artist');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin','staff') NOT NULL DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `password`, `role`, `created_at`) VALUES
(2, 'anjali', 'ahinsa', 'anjuahinsa2001@gmail.com', '0759088376', '$2y$10$S8cnQyUAwNvKRNWVvyvjYe1MF6TnQL.ZZSkVHRNaabIk.kMd.r4Q2', 'admin', '2026-03-14 18:07:20'),
(3, 'kasuni', 'perera', 'kasuniperera@gmail.com', '0758646123', '$2y$10$Ff9dN..8EULJXifdDN6SMeDo7nuIbs65nYdxGaKC4Yu8jq45QAdkG', 'staff', '2026-03-16 12:15:14'),
(4, 'tanasha ', 'dias', 'thanashadias@gmail.com', '0745691234', '$2y$10$0uE4m9IE7vbeco2FBEWRKe5IfdXHeCmufaHx2CMhUIttm0KKutpUy', 'staff', '2026-03-16 12:17:12'),
(5, 'kaveesha', 'shehani', 'kaveeshashehani@gmail.com', '0755566215', '$2y$10$LAu/BiH7ILXmtQo///NJp.Ihe6xhfk/a3uUxNcoDmDAJe9rDbw7/C', 'customer', '2026-03-17 18:02:28'),
(6, 'malisha', 'sanjana', 'malishasanjana@gmail.com', '0775226487', '$2y$10$TFwvUilp7UIOHKHAzJFG5ex5wjc2rgmgSSd0rvbJHbxAk7AgxR2K2', 'customer', '2026-03-18 16:41:56'),
(7, 'nirosha', 'sanjeewani', 'niroshasanjeewani@gmail.com', '0767569222', '$2y$10$BbZgAb0EnM034c281Vf4Q.4rT9G1fs7hadia9mcywzI5Qeig1nk16', 'customer', '2026-03-18 16:46:27'),
(8, 'malshi', 'chathurika', 'malshichathurika@gmail.com', '0759996422', '$2y$10$axTlHwb/xu1JGFq39PrCmeWG8a8bFurtZJHEwhT8ug/1NEQhDyDdC', 'customer', '2026-03-18 16:58:58'),
(9, 'sadani', 'maheshika', 'sandanimaheshika@gmail.com', '0759964123', '$2y$10$xE7/sJnJasXWB97po2AlsOF3wnrpQ9MIgOOuvNUbd/uUojShw6Nwu', 'customer', '2026-03-18 18:56:31'),
(10, 'ranga', 'nuwan', 'ranganuwan@gmail.com', '0752661957', '$2y$10$WgPFyeoq1LqlxilmW/nmUOlBm5mFA16tDwFkizPOjuQQRfb9j2dDm', 'customer', '2026-03-19 12:44:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointment_id` (`appointment_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `appointment_services`
--
ALTER TABLE `appointment_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE;

--
-- Constraints for table `appointment_services`
--
ALTER TABLE `appointment_services`
  ADD CONSTRAINT `appointment_services_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointment_services_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`service_id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
