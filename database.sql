CREATE DATABASE 'toolsonloan';

CREATE TABLE `user` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(510) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`id`, `username`, `password`) VALUES (NULL, 'testuser', '$2y$10$y5cZWZdXr8QBCMxj5lil5ulBpgZlSZzARElCe7zDGr4BnH.XTvKji');