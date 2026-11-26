USE `toolsonloan`;

ALTER TABLE `customer` ADD COLUMN IF NOT EXISTS `deleted_at` datetime DEFAULT NULL;
