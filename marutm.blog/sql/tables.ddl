CREATE TABLE `blog_category` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
	`title` varchar(100) NOT NULL,
	`act_interval` tinyint NOT NULL,
	`endpage` tinyint NOT NULL,
	`keyword` varchar(1000) NOT NULL,
	`cre_time` datetime NOT NULL,
	UNIQUE KEY (`title`),
	KEY(`seq`),
	PRIMARY KEY (`id`)
)

CREATE TABLE `blog_userinfo` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL,
	`category_id` varchar(100) NOT NULL,
	`flag` char(1) NOT NULL,
	`cre_time` datetime NOT NULL,
	KEY(`seq`),
	UNIQUE KEY (`id`, `category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;