-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Värd: localhost:3306
-- Tid vid skapande: 22 okt 2016 kl 22:35
-- Serverversion: 5.5.49-log
-- PHP-version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `pingpong`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_started` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_ended` timestamp NULL DEFAULT NULL,
  `participants` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `game_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

--
-- Dumpning av Data i tabell `players`
--

INSERT INTO `players` (`id`, `username`, `firstname`, `lastname`, `game_id`) VALUES
(5, 'robnik', 'Robert', 'Niklasson', NULL),
(6, 'larkar', 'Lars', 'Karlsson', NULL),
(7, 'joarem', 'Joakim', 'Remler', NULL),
(8, 'benriz', 'Benjamin', 'Rizk', NULL),
(9, 'mareri', 'Marie', 'Eriksson', NULL),
(10, 'margus', 'Maria', 'Gustafsson', NULL),
(11, 'axebol', 'Axel', 'Bolle', NULL),
(12, 'amiel', 'Amin', 'El-Rifai', NULL),
(13, 'andhja', 'André', 'Hjalmarsson', NULL),
(14, 'caråbe', 'Carl', 'Åberg', NULL),
(15, 'chrbor', 'Christian', 'Borg', NULL),
(16, 'katche', 'Katarina', 'Chernyavskaya', NULL),
(17, 'erigli', 'Erica', 'Glimsholt', NULL),
(18, 'jerdan', 'Jeremy', 'Danner', NULL),
(19, 'krifre', 'Kristjan', 'Frederiksen', NULL),
(20, 'matkri', 'Mathias', 'Kristiansson', NULL),
(21, 'sigbje', 'Signe', 'Bjelkenäs', NULL),
(22, 'stamow', 'Staffan', 'Mowitz', NULL),
(23, 'vicols', 'Victor', 'Olsson', NULL),
(24, 'maxsan', 'Max', 'Sandelin', NULL),
(25, 'johtve', 'Johannes', 'Tveitan', NULL),
(26, 'vinkla', 'Vincent', 'Klaiber', NULL),
(27, 'hare', 'Harry (Revolutionist)', 'E', NULL);

-- --------------------------------------------------------

--
-- Tabellstruktur `results`
--

CREATE TABLE IF NOT EXISTS `results` (
  `id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `game_id` (`game_id`);

--
-- Index för tabell `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `game_id` (`game_id`),
  ADD KEY `player_id` (`player_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT för tabell `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT för tabell `results`
--
ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=43;
--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `players`
--
ALTER TABLE `players`
  ADD CONSTRAINT `players_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restriktioner för tabell `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`player_id`) REFERENCES `players` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
