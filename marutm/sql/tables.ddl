CREATE TABLE `category` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
	`title` varchar(100) NOT NULL,
	`display_order` smallint DEFAULT 0 NOT NULL,
	`act_interval` tinyint NOT NULL,
	`startpage` tinyint NOT NULL,
	`endpage` tinyint NOT NULL,
	`cre_time` datetime NOT NULL,
	UNIQUE KEY (`title`),
	KEY(`seq`),
	PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `cafe` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
 	`title` varchar(100) NOT NULL,
 	`club_id` varchar(100) NOT NULL,
 	`display_order` smallint DEFAULT 0 NOT NULL,
 	`category_id` varchar(100) NOT NULL,
 	`cre_time` datetime NOT NULL,
 	CONSTRAINT `FK_CAFE_CATEGORY` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
 	UNIQUE KEY (`title`),
 	KEY(`seq`),
 	PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

CREATE TABLE `userinfo` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
	`email` varchar(100) NOT NULL,
	`category_id` varchar(100) NOT NULL,
	`cafe_id` varchar(100) NOT NULL,
	`cre_time` datetime NOT NULL,
	KEY(`seq`),
	UNIQUE KEY (`id`, `category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;