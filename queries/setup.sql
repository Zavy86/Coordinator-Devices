--
-- Devices - Setup (1.0.0)
--
-- @package Coordinator\Modules\Devices
-- @author  Manuel Zavatta <manuel.zavatta@gmail.com>
-- @link    http://www.coordinator.it
--

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Table structure for table `devices__categories`
--

CREATE TABLE IF NOT EXISTS `devices__categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices__devices`
--

CREATE TABLE IF NOT EXISTS `devices__devices` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `deleted` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `fkCategory` int(11) UNSIGNED NOT NULL,
  `name` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `brand` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `identifier` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` double UNSIGNED DEFAULT NULL,
  `purchase` date DEFAULT NULL,
  `warranty` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fkCategory` (`fkCategory`),
  CONSTRAINT `devices__devices_ibfk_1` FOREIGN KEY (`fkCategory`) REFERENCES `devices__categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices__devices__logs`
--

CREATE TABLE IF NOT EXISTS `devices__devices__logs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `fkObject` int(11) UNSIGNED NOT NULL,
  `fkUser` int(11) UNSIGNED DEFAULT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `alert` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `event` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `properties_json` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fkObject` (`fkObject`),
  CONSTRAINT `devices__devices__logs_ibfk_1` FOREIGN KEY (`fkObject`) REFERENCES `devices__devices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices__devices__join__documents`
--

CREATE TABLE IF NOT EXISTS `devices__devices__join__documents` (
  `fkDevice` int(11) UNSIGNED NOT NULL,
  `fkDocument` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`fkDevice`,`fkDocument`),
  KEY `fkDevice` (`fkDevice`),
  KEY `fkDocument` (`fkDocument`),
  CONSTRAINT `devices__devices__join__documents_ibfk_1` FOREIGN KEY (`fkDevice`) REFERENCES `devices__devices` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `devices__devices__join__documents_ibfk_2` FOREIGN KEY (`fkDocument`) REFERENCES `archive__documents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Authorizations
--

INSERT IGNORE INTO `framework__modules__authorizations` (`id`,`fkModule`,`order`) VALUES
('devices-manage','devices',1),
('devices-usage','devices',2);

-- --------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 1;

-- --------------------------------------------------------
