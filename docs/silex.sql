SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `option` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(16) NOT NULL,
  `default_value` varchar(255) NOT NULL,
  `package` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `config` (`option`, `value`, `type`, `default_value`, `package`) VALUES
('language.default', 'en-US', 'string(255)', 'en-US', 1),
('page.default', 'home', 'string(255)', 'home', 1),
('page.title', 'Silex', 'string(255)', 'Silex', 1),
('session.autologout', '3600', 'int(8)', '3600', 1),
('session.autologout_probability', '25', 'int(3)', '25', 1),
('session.cookie_time', '86400', 'int(8)', '86400', 1),
('session.name', 'silex', 'string(255)', 'silex', 1),
('style.default', 'silex.lumenlunae', 'string(255)', 'silex.lumenlunae', 1),
('time.timezone', 'Europe/Berlin', 'string(255)', 'Europe/Berlin', 1),
('url.base', '/', 'string(255)', '/', 1),
('url.format', '1', 'int(1)', '1', 1);

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

INSERT INTO `group` (`id`, `name`) VALUES
(0, 'group.guest'),
(1, 'group.user'),
(2, 'group.moderator'),
(3, 'group.administrator');

DROP TABLE IF EXISTS `navigation`;
CREATE TABLE IF NOT EXISTS `navigation` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `permission` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Target` (`target`),
  UNIQUE KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `navigation` (`id`, `title`, `target`, `position`, `permission`) VALUES
(1, 'page.home', 'home', 1, '');

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  `type` varchar(16) NOT NULL DEFAULT 'bool',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `permission_group`;
CREATE TABLE IF NOT EXISTS `permission_group` (
  `group_id` int(8) NOT NULL,
  `permission_id` int(8) NOT NULL,
  `value` tinyint(1) NOT NULL,
  KEY `group_id` (`group_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE IF NOT EXISTS `permission_user` (
  `user_id` int(8) NOT NULL,
  `permission_id` int(8) NOT NULL,
  `value` tinyint(1) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` varchar(32) NOT NULL,
  `session_value` mediumtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `ip_address` varchar(64) NOT NULL,
  `user_agent` tinytext NOT NULL,
  `last_activity` int(11) NOT NULL,
  `token` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `group_id` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`id`, `name`, `password`, `mail`, `group_id`) VALUES
(1, 'admin', '$2a$08$.HWRrP3wOf4yeY2Sm8J0j.Y5RfdMDGqzUZXm.o40Fwv6yk/WKhjdS', 'admin@silexlab.org', 3);
