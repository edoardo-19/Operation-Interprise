CREATE TABLE `reviews` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` int(11) NOT NULL,
	`program_id` int(11) NOT NULL,
	`title` varchar(50) NOT NULL,
	`description` varchar(255) NOT NULL,
	`score` int(2) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1;