CREATE TABLE `users` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` varchar(50) NOT NULL,
	`password` varchar(255) NOT NULL,
	`firstname` varchar(50) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `birthday` DATE,
    `image` LONGTEXT,
    `country` varchar(50),
    `address` varchar(50),
    `phone` varchar(15),
    `isAdmin` tinyint(1),
	PRIMARY KEY (`id`),
	UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1;