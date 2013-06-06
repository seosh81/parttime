CREATE TABLE `car_category` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(100) NOT NULL,
	`url` varchar(100) NOT NULL,
	`cre_time` datetime NOT NULL,
	KEY(`seq`)
)

CREATE TABLE `car_comment` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`model` varchar(100) NOT NULL,
	`comment_no` varchar(100) NOT NULL,
	`comment` varchar(2000) NOT NULL,
	`email` varchar(200) NOT NULL,
	`cre_time` datetime NOT NULL,
	KEY(`seq`)
)

CREATE TABLE `car_receivemail` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`email` varchar(100) NOT NULL,
	`cre_time` datetime NOT NULL,
	KEY(`seq`)
)