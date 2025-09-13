-- Create a new database named `laundry_db` if it doesn't exist
CREATE DATABASE IF NOT EXISTS `laundry_db`;

-- Use th DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
e created database
USE `laundry_db`;

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL
--
-- Dumping data for table `users` (example user)
--
INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `address`, `created_at`) VALUES
(1, 'Test User', 'test@example.com', 'hashed_password', '1234567890', '123 Test Street, Mumbai', '2025-09-01 07:00:00');

--
-- Table structure for table `services`
--
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `services`
--
INSERT INTO `services` (`id`, `service_name`, `description`, `price`) VALUES
(1, 'Wash & Fold', 'Standard wash, dry, and fold service per kg.', 250.00),
(2, 'Dry Cleaning', 'Special care for delicate garments per item.', 400.00),
(3, 'Ironing Service', 'Professional ironing service per item.', 50.00);

--
-- Table structure for table `orders`
--
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `pickup_time` time NOT NULL,
  `delivery_address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;