CREATE TABLE `##PREFIX##blog_articles` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `article` text NOT NULL,
  `art_more` text,
  `insert_date` int(18) NOT NULL,
  `insert_user_id` int(7) NOT NULL,
  `comments` int(6) NOT NULL,
  `enable_comments` tinyint(1) NOT NULL,
  `password` varchar(32) NOT NULL,
  `categorieshtml` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `##PREFIX##blog_comments` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `id_article` int(8) unsigned NOT NULL,
  `comment` text NOT NULL,
  `user_id` int(8) unsigned NOT NULL,
  `user` varchar(50) NOT NULL,
  `dateinsert` int(18) unsigned NOT NULL,
  `type` int(1) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `web` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `##PREFIX##blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##blog_articles` (title, article, art_more, insert_date, insert_user_id, comments, enable_comments, password) VALUES ('Another Fantastic Blog', 'Another Fantastic Blog', '', UNIX_TIMESTAMP(), 1, 1, 0, '');

INSERT INTO `##PREFIX##blog_comments` (id_article, comment, user_id, user, dateinsert, type, email, web) VALUES (1, 'Thx to use our blogging module for AneCMS ', 0, 'AneCMS Team', 1246813681, 1, 'info@anecms.com', 'http://anecms.com');

INSERT INTO `##PREFIX##dev_menus` VALUES (null,1,'Blog',1,'blog',2,0),(null,104,'blog_new',1,'?p=mod&mod=blog&m=new',1,52),(null,104,'blog_view',1,'?p=mod&mod=blog',2,52),(52,104,'Blog',1,'0',0,0);
