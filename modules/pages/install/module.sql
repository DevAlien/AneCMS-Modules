CREATE TABLE `##PREFIX##pages_config` (
  `defaultid` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `##PREFIX##pages_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `who` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `##PREFIX##pages_pages` (name, text, who, time) VALUES ('First Page', '<h2>Thank you</h2><p>We hope that you\'ll engjoy our module.</p>', 1, UNIXTIMESTAMP());
INSERT INTO `##PREFIX##pages_config` VALUES (1,1);

INSERT INTO `##PREFIX##dev_menus` (type, name, view, link) VALUES (103, 'pages_new', 1, '?p=mod&mod=pages&m=new');
INSERT INTO `##PREFIX##dev_menus` (type, name, view, link) VALUES (103, 'pages_view', 1, '?p=mod&mod=pages');