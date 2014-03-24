SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `option` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(16) NOT NULL,
  `package` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `config` (`option`, `value`, `type`, `package`) VALUES
('language.default', 'en-US', 'string(255)', 1),
('page.default', 'home', 'string(255)', 1),
('page.title', 'Silex', 'string(255)', 1),
('session.autologout', '3600', 'int(8)', 1),
('session.autologout_probability', '25', 'int(3)', 1),
('session.cookie_time', '86400', 'int(8)', 1),
('session.name', 'silex', 'string(255)', 1),
('style.default', 'org.silex.lumenlunae', 'string(255)', 1),
('time.timezone', 'Europe/Berlin', 'string(255)', 1),
('url.base', '/', 'string(255)', 1),
('url.format', '1', 'int(1)', 1);

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

INSERT INTO `session` (`id`, `session_value`, `user_id`, `username`, `ip_address`, `user_agent`, `last_activity`, `token`) VALUES
('igua9pdcat6fo8ad9ob8m6ofu0tlgtg4', '', 0, '', '', '', 1395607276, '');

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`id`, `name`, `password`, `mail`) VALUES
(1, 'admin', '$2a$08$.HWRrP3wOf4yeY2Sm8J0j.Y5RfdMDGqzUZXm.o40Fwv6yk/WKhjdS', 'admin@silexlab.org');
