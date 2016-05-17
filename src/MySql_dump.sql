-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Vært: localhost:8889
-- Genereringstid: 18. 05 2016 kl. 00:49:10
-- Serverversion: 5.5.38
-- PHP-version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `security_exam`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `gifs`
--

DROP TABLE IF EXISTS `gifs`;
CREATE TABLE `gifs` (
`gif_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `uploaded` datetime NOT NULL,
  `pending` tinyint(1) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Data dump for tabellen `gifs`
--

INSERT INTO `gifs` (`gif_id`, `name`, `uploaded`, `pending`, `accepted`, `user_id`) VALUES
(1, 'claus-kaiser.jpg', '2016-05-17 22:44:23', 0, 1, 3),
(2, 'gifTest.gif', '2016-05-17 23:07:53', 0, 1, 2),
(14, 'JxoYl2mPmE8zC1463524556.gif', '2016-05-18 00:35:57', 0, 1, 2),
(15, 'IlDQB3jMArQqY1463524571.gif', '2016-05-18 00:36:13', 0, 1, 2),
(16, 'LoljviqRQ6JdS1463524586.gif', '2016-05-18 00:36:27', 0, 1, 2),
(17, 'KlulsTyJiED4I1463525047.gif', '2016-05-18 00:44:08', 1, 0, 2),
(18, '3o7WTH1FHw1el4UeAM1463525108.gif', '2016-05-18 00:45:09', 1, 0, 2),
(19, 'ArQwmklhFBGV21463525126.gif', '2016-05-18 00:45:28', 1, 0, 2),
(20, 'oJq8SwOOwbxDy1463525143.gif', '2016-05-18 00:45:44', 1, 0, 2),
(21, 'mOOuUUIEEgq6A1463525153.gif', '2016-05-18 00:45:55', 1, 0, 2),
(22, 'wEBC3dQZe8MQE1463525167.gif', '2016-05-18 00:46:08', 1, 0, 2),
(23, 'cnczob1SfXevK1463525179.gif', '2016-05-18 00:46:20', 1, 0, 2),
(24, 'xT1XGvQsbTq3JRF7YQ1463525195.gif', '2016-05-18 00:46:36', 1, 0, 2),
(25, 'A6aHBCFqlE0Rq1463525209.gif', '2016-05-18 00:46:50', 1, 0, 2),
(26, 'DQjUvq5NiJtjq1463525224.gif', '2016-05-18 00:47:05', 1, 0, 2),
(27, 'xT1XGTaTeovBeLdrRS1463525243.gif', '2016-05-18 00:47:23', 1, 0, 2),
(28, '10HegwKCnl0krS1463525256.gif', '2016-05-18 00:47:37', 1, 0, 2),
(29, '26gjiYH2vGNjB11wk1463525267.gif', '2016-05-18 00:47:47', 1, 0, 2);

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `gifs`
--
ALTER TABLE `gifs`
 ADD PRIMARY KEY (`gif_id`), ADD UNIQUE KEY `src_UNIQUE` (`name`), ADD KEY `fk_gifs_users_idx` (`user_id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `gifs`
--
ALTER TABLE `gifs`
MODIFY `gif_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- Begrænsninger for dumpede tabeller
--

--
-- Begrænsninger for tabel `gifs`
--
ALTER TABLE `gifs`
ADD CONSTRAINT `fk_gifs_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
