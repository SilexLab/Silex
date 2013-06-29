SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `option` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(16) NOT NULL,
  `package` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `config` (`option`, `value`, `type`, `package`) VALUES
('page.title', 'Silex', 'string(255)', 1),
('session.autologout', '3600', 'int(8)', 1),
('session.autologout_probability', '25', 'int(3)', 1),
('session.cookie_time', '86400', 'int(8)', 1),
('session.name', 'silex', 'string(255)', 1),
('url.base', '/', 'string(255)', 1),
('url.format', '1', 'int(1)', 1);

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
	`id` int(255) NOT NULL AUTO_INCREMENT,
	`name` mediumtext NOT NULL,
	`mail` mediumtext NOT NULL,
	`form_token` varchar(40) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `name`, `mail`, `form_token`) VALUES
(1, 'Test', 'test@test.com', '2e9e06172d249dbd9c7665879662a12424c52a4c');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
