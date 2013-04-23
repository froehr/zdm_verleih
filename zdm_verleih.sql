-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 18. Apr 2013 um 21:48
-- Server Version: 5.5.27
-- PHP-Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `zdm_verleih`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ausleihe`
--

CREATE TABLE IF NOT EXISTS `ausleihe` (
  `ausleih_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `matrikel` int(6) unsigned DEFAULT NULL,
  `verleiher_id` tinyint(2) unsigned DEFAULT NULL,
  `von` date DEFAULT NULL,
  `bis` date DEFAULT NULL,
  `ausleihe` tinyint(1) DEFAULT NULL,
  `objekte` text,
  PRIMARY KEY (`ausleih_id`),
  KEY `matrikel` (`matrikel`),
  KEY `verleiher_id` (`verleiher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ausleiher`
--

CREATE TABLE IF NOT EXISTS `ausleiher` (
  `matrikel` int(6) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `vorname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `telefon` varchar(20) DEFAULT NULL,
  `postleitzahl` decimal(5,0) DEFAULT NULL,
  `strasse` varchar(50) DEFAULT NULL,
  `hausnummer` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`matrikel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ausleihobjekt`
--

CREATE TABLE IF NOT EXISTS `ausleihobjekt` (
  `objekt_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `geraet_typ` varchar(50) DEFAULT NULL,
  `geraet_typ_id` tinyint(2) DEFAULT NULL,
  `zubehoer` text,
  PRIMARY KEY (`objekt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `verleiher`
--

CREATE TABLE IF NOT EXISTS `verleiher` (
  `verleiher_id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `vorname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`verleiher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zubehoer`
--

CREATE TABLE IF NOT EXISTS `zubehoer` (
  `zubehoer_id` int(4) NOT NULL AUTO_INCREMENT,
  `objekt_id` int(4) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`zubehoer_id`),
  KEY `objekt_id` (`objekt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ausleihe`
--
ALTER TABLE `ausleihe`
  ADD CONSTRAINT `ausleihe_ibfk_2` FOREIGN KEY (`verleiher_id`) REFERENCES `verleiher` (`verleiher_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ausleihe_ibfk_1` FOREIGN KEY (`matrikel`) REFERENCES `ausleiher` (`matrikel`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints der Tabelle `zubehoer`
--
ALTER TABLE `zubehoer`
  ADD CONSTRAINT `zubehoer_ibfk_1` FOREIGN KEY (`objekt_id`) REFERENCES `ausleihobjekt` (`objekt_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
