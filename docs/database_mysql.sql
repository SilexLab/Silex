SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

CREATE DATABASE IF NOT EXISTS `silex` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `silex`;

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id` varchar(128) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(16) NOT NULL,
  `default_value` varchar(255) NOT NULL,
  `module` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `config` (`id`, `value`, `type`, `default_value`, `module`) VALUES
('language.default', 'en-US', 'string(255)', 'en-US', 'silex.core'),
('page.default', 'home', 'string(255)', 'home', 'silex.core'),
('page.title', 'Silex', 'string(255)', 'Silex', 'silex.core'),
('session.autologout', '3600', 'int(8)', '3600', 'silex.core'),
('session.autologout_probability', '25', 'int(3)', '25', 'silex.core'),
('session.cookie_time', '86400', 'int(8)', '86400', 'silex.core'),
('session.name', 'silex', 'string(255)', 'silex', 'silex.core'),
('style.default', 'silex.lunaelumen', 'string(255)', 'silex.lunaelumen', 'silex.core'),
('system.show_load', '1', 'bool', '0', 'silex.core'),
('time.timezone', 'Europe/Berlin', 'string(255)', 'Europe/Berlin', 'silex.core'),
('url.assets', '', 'string(255)', '', 'silex.core'),
('url.base', '/', 'string(255)', '/', 'silex.core'),
('url.format', '1', 'int(1)', '1', 'silex.core');

DROP TABLE IF EXISTS `group`;
CREATE TABLE IF NOT EXISTS `group` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

INSERT INTO `group` (`id`, `name`) VALUES
(0, 'user.group.guest'),
(1, 'user.group.user'),
(2, 'user.group.moderator'),
(3, 'user.group.administrator');

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` varchar(128) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `modules` (`id`, `enabled`) VALUES
('silex.core', 1);

DROP TABLE IF EXISTS `navigation`;
CREATE TABLE IF NOT EXISTS `navigation` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `target` varchar(100) NOT NULL,
  `position` tinyint(4) NOT NULL,
  `permission` tinytext NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Target` (`target`),
  UNIQUE KEY `position` (`position`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=3 ;

INSERT INTO `navigation` (`id`, `title`, `target`, `position`, `permission`, `enabled`) VALUES
(1, 'page.home', 'home', 1, '', 1),
(2, 'page.about', 'about', 2, '', 1);

DROP TABLE IF EXISTS `permission`;
CREATE TABLE IF NOT EXISTS `permission` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(127) NOT NULL,
  `type` varchar(16) NOT NULL DEFAULT 'bool',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `permission_group`;
CREATE TABLE IF NOT EXISTS `permission_group` (
  `group_id` int(8) NOT NULL,
  `permission_id` int(8) NOT NULL,
  `value` tinyint(1) NOT NULL,
  KEY `group_id` (`group_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE IF NOT EXISTS `permission_user` (
  `user_id` int(8) NOT NULL,
  `permission_id` int(8) NOT NULL,
  `value` tinyint(1) NOT NULL,
  KEY `user_id` (`user_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `group_id` int(8) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

INSERT INTO `user` (`id`, `name`, `password`, `mail`, `group_id`) VALUES
(0, '{user.guest}', '', '', 0),
(1, 'admin', '$2y$12$PY2Ka3MNB6Vmb5D5495gGeMuxDTtAviN/26Gvlin0H/unuKeGJ7fe\n', 'admin@silexlab.org', 3);


ALTER TABLE `config`
  ADD CONSTRAINT `config_ibfk_1` FOREIGN KEY (`module`) REFERENCES `modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `permission_group`
  ADD CONSTRAINT `permission_group_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_group_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `permission_user`
  ADD CONSTRAINT `permission_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_user_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `session`
  ADD CONSTRAINT `session_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
