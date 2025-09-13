CREATE TABLE `tb_food_reports` (
  `food_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_date` date NOT NULL,
  `food_meal` varchar(100) NOT NULL,
  `food_menu` text NOT NULL,
  `food_images` TEXT COMMENT 'Store image paths as a JSON array',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`food_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;