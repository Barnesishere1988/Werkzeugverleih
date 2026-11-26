CREATE DATABASE IF NOT EXISTS `toolsonloan`;
USE `toolsonloan`;

CREATE TABLE `user` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(510) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `username`, `password`) VALUES (NULL, 'testuser', '$2y$10$y5cZWZdXr8QBCMxj5lil5ulBpgZlSZzARElCe7zDGr4BnH.XTvKji');

-- Die spätere Ausleihtabelle muss tool(id) per Fremdschlüssel mit ON DELETE RESTRICT referenzieren.
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

-- Die spätere Ausleihtabelle soll customer(id) per Fremdschlüssel mit ON DELETE RESTRICT referenzieren.
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
