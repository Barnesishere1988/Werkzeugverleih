CREATE DATABASE IF NOT EXISTS `toolsonloan`;
USE `toolsonloan`;

CREATE TABLE `user` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(510) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `username`, `password`) VALUES (NULL, 'testuser', '$2y$10$y5cZWZdXr8QBCMxj5lil5ulBpgZlSZzARElCe7zDGr4BnH.XTvKji');

CREATE TABLE IF NOT EXISTS `tool` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inventoryid` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`inventoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `loan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `tool_id` int NOT NULL,
  `start_date` date NOT NULL,
  `planned_return_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `daily_price` decimal(10,2) NOT NULL,
  `active_tool_id` int GENERATED ALWAYS AS (CASE WHEN `return_date` IS NULL THEN `tool_id` ELSE NULL END) STORED,
  PRIMARY KEY (`id`),
  UNIQUE KEY (`active_tool_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE RESTRICT,
  FOREIGN KEY (`tool_id`) REFERENCES `tool` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
