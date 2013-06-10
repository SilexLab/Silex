SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `config_node` varchar(255) NOT NULL,
  `config_value` varchar(255) NOT NULL,
  `value_type` varchar(16) NOT NULL,
  `package` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`config_node`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `config` (`config_node`, `config_value`, `value_type`, `package`) VALUES
('page.title', 'Silex', 'string(255)', 1),
('url.base', '/', 'string(255)', 1),
('url.format', '1', 'int(1)', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
