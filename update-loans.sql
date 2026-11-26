USE `toolsonloan`;

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
