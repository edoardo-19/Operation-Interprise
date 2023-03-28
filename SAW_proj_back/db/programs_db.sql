CREATE TABLE `programs` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` varchar(50) NOT NULL,
	`description` varchar(255) NOT NULL,
	`price` int(20) NOT NULL,
    `type` varchar(50) NOT NULL,
    `place` varchar(50) NOT NULL,
    `image` LONGTEXT,
    `scoreAvg` varchar(15),
	PRIMARY KEY (`id`),
	UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1;











INSERT INTO `programs`
    VALUES (0, :title, :description, :price, :type, :place, :image, :scoreAvg)

INSERT INTO `programs`			
	VALUES (0, "Sunbathing on Mercury"  , " Have a sunbathe of UV ray! One minute of UV on mercury it's like 3 days on Hearth... CONSECUTIVE! (Sun cream is highly recommended)", 1000, "Activity", "Mercury", "Sunbath.jpg", NULL)

INSERT INTO `programs`
    VALUES (0, "Uranus ice resort", " Hotels, bars and restaurants are quite common on Hearth... In Uranus, with an average temperature of -213°C you can visit an entire ice resort! (Mountain clothes highly recommended)", 9000, "Activity", "Uranus", "Uranus1.jpg", NULL)