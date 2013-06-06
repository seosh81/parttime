CREATE TABLE `mrtong_category` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
	`title` varchar(100) NOT NULL,
	`startpage` tinyint NOT NULL,
	`endpage` tinyint NOT NULL,
	`cre_time` datetime NOT NULL,
	UNIQUE KEY (`title`),
	KEY(`seq`),
	PRIMARY KEY (`id`)
)

insert into mrtong_category(id, title, startpage, endpage, cre_time) values('A', '패션의류', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('B', '패션잡화/뷰티', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('C', '디지털/가전/컴퓨터', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('D', '스포츠/레져/자동차', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('E', '식품/유아동', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('F', '가구/생활/취미', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('G', '도서/티켓/여행', 1, 10, now());
insert into mrtong_category(id, title, startpage, endpage, cre_time) values('H', '컨텐츠', 1, 10, now());



CREATE TABLE `mrtong_siteinfo` (
	`seq` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`id` varchar(100) NOT NULL,
	`code` varchar(100) NOT NULL,
	`name` varchar(100) NOT NULL,
	`url` varchar(100) NOT NULL,
	`naver_registry` char(1) NOT NULL,
	`category_id` varchar(100) NOT NULL,
	`cre_time` datetime NOT NULL,
	KEY(`seq`),
	UNIQUE KEY (`id`, `category_id`)
)