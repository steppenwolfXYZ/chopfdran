-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Aug 2016 um 00:24
-- Server-Version: 10.1.13-MariaDB
-- PHP-Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `chopfdran`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `instrument`
--

CREATE TABLE `instrument` (
  `id` int(11) NOT NULL,
  `name` char(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `instrument`
--

INSERT INTO `instrument` (`id`, `name`) VALUES
(1, 'E-Bass'),
(2, 'Gitarre'),
(3, 'Keyboard'),
(4, 'Saxophon'),
(5, 'Schlagzeug'),
(6, 'Trompete'),
(7, 'Waldhorn'),
(8, 'Gesang');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `page`
--

CREATE TABLE `page` (
  `id` int(11) NOT NULL,
  `url` char(100) DEFAULT NULL,
  `object` char(30) NOT NULL,
  `name` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `page`
--

INSERT INTO `page` (`id`, `url`, `object`, `name`) VALUES
(1, 'login', 'Login', 'Login'),
(2, 'start', 'Start', 'Start'),
(3, 'logout', 'Logout', 'Logout'),
(4, 'newprofile', 'NewProfile', 'Neues Profil erstellen'),
(5, 'newproject', 'NewProject', 'Neues Projekt eröffnen');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `name` char(100) NOT NULL,
  `pw` char(255) DEFAULT NULL,
  `mail` char(255) NOT NULL,
  `title` char(1) NOT NULL,
  `birthdate` date NOT NULL,
  `city` char(100) NOT NULL,
  `instrument_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `person`
--

INSERT INTO `person` (`id`, `name`, `pw`, `mail`, `title`, `birthdate`, `city`, `instrument_id`) VALUES
(1, 'georg', '$2y$10$f7u8/wZRy97n9Nby8zpttOK/qZMacUdsD6G4JRiSeJtjl6zHHexmi', 'georg.b@gmx.ch', '', '0000-00-00', '', 5),
(2, 'Georg', '$2y$10$WjvfTm74B.dPn6xj5DleNeQ5HP8bEGBCzjq9iPL1pRq6/mcDxmX1e', 'info@web13.ch', 'm', '1989-01-20', 'sdf', 2),
(6, 'Schnurli', '$2y$10$qilaVlGIUI3jXdpd9.3LwOfagz0oOri04wpai548Jvcb2SCoaDzta', 'schnurli@super.xx', 'f', '2000-01-01', 'Basel', 7),
(8, 'Hans Baumgartner', '$2y$10$f2c8O6MdSFF7OOJiy7VcKe1zU7OrkgKHimHVuRv4dVPBis3FBdHWW', 'georg.brodbeck@gmail.com', 'm', '1992-06-01', 'Ittigen', 8),
(9, 'blau', '$2y$10$lJFFBdHFjiUDecc9FfV/HOGUTdhDwq/djHMKYskbFPddvXRctuCnm', 'blau@blau.bl', 'm', '2010-01-01', 'Samedan', 6),
(10, 'hans', '$2y$10$Gen/35SJ2UXMw7RXS2yuuOwUCSDQN4rrT9wzJBmya8yl0ezgGeRxW', 'hans@x.x', 'f', '2016-08-07', 'hansigen', 1),
(11, 'rot', '$2y$10$G040IDH29bZcZfWNfH8gbODBohyJt9lZbDkVcQGzUDG70PYfTnZmW', 'rot@rot.ro', 'f', '2012-02-02', 'Bever', 5),
(12, 'sepp', '$2y$10$raGCdu3OnUTxIEzhXN4vL.bBH4JUnQcODid4.8ZL2lIyGD/82LUai', 'sepp@x.x', 'm', '1999-09-09', 'burgund', 3),
(14, 'Anna', '$2y$10$WTrCgfTILgyoWtS7Leng5OxYlqKVb7iR/y7s6xosjJbolB9zoF7ky', 'anna@x.x', 'f', '1997-03-03', 'entenhausen', 1),
(15, 'Fritz', '$2y$10$gQmHuH0m6l3AQsvqMNvRGOWgWWV2Ayez5.SS7u9MxigsCPOYDams2', 'fritz@x.x', 'm', '1994-04-04', 'Bauernhof', 7),
(16, 'grau', '$2y$10$EkuKvK8afRlrOP4rGZc2l.2znq8kZ13Y5wd8uZXlGuGOeFGtMl5vK', 'grau@grau.gr', 'f', '2012-02-02', 'Graubünden', 8),
(17, 'Jack Milk''s', '$2y$10$g9rWp47DipWxENUnJ4aEGu0VlxQVElVjjSJTbJoV.EonjxRC5HyJe', 'jack@milks.ch', 'm', '1988-01-01', 'Bern', 5);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` char(100) NOT NULL,
  `city` char(50) NOT NULL,
  `description` text,
  `event_date` date DEFAULT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `project`
--

INSERT INTO `project` (`id`, `title`, `city`, `description`, `event_date`, `person_id`) VALUES
(3, 'Punk mit Stifu', 'Bärn', 'Judihui gagi', '2016-08-15', 6),
(4, 'Gartenarbeit mit Musikinstrumenten', 'Bern', 'Die andere Art der Musik: Wir bearbeiten den Garten mit ausrangierten Musikinstrumenten und nehmen das ganze auf. Die CD-Verkaufs-Einnahmen werden an Pro Garten Schweiz gespendet.', '2016-08-25', 2),
(5, 'Funk mit Tschortsch', 'Tschoto', 'E huere geili Bänd, mit em Tschortsch aus Liidsänger.\r\nGspiut wird usschliässläch kitschigä Funk. Aues säuber komponiert vom Tschortsch. Gsuächt wärde nur blondi Froue mit piiipsstimme.', '2016-08-07', 6),
(9, 'Autohupkonzert-Probe', 'Bern', 'Wir treffen uns auf dem Galantparkplatz mit möglichst vielen Autos. Der Dirigent kommt mit einem Panzer, wir spielen die Hupsynphonie von Mozart.', '2016-08-31', 2),
(10, 'Lorem ipsum', 'Ipsach', 'Damit Ihr indess erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Uebungen vornehmen, wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?\r\n\r\nDagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Uebernahme gewisser Schmerzen sich grössere erspare. ', '2018-04-27', 6),
(11, 'müsig mit mätscherer', 'Deheim', '1. Projekt wird von einer Person vorgeschlagen\r\n2. Musiker bekommen Mail mit Empfehlungen von Projekten in der Nähe welche ihrem Niveau/Level entsprechen\r\n3. Musiker melden sich an\r\n4. Sind alle Positionen bis zum Stichtag besetzt, wird bei überbesetzten Registern die Kombination mit dem bestem Match automatisch ausgewählt.\r\n5. Durchführung des Projekts (Projekte mit öffentlichem Auftritt werden im Veranstaltungskalender hinzugefügt).\r\n6. Qualitätssicherung ? Auswertung', '2016-08-07', 6),
(12, 'Stinknormale Bandprobe', 'Lauterbrunnen', 'Wir möchten uns gerne treffen für eine Bandprobe ohne Besonderheiten. Wenn du dich als Mensch ohne Besonderheiten wahrnimmst, dann ist das genau das Richtige für dich. Melde dich an! Bitte!!', '2016-10-24', 2),
(13, 'Singen forever', 'Rammalan', 'Wir singen um die Wette bis jemand stirbt.', '2016-09-03', 8),
(14, 'Gartehag irgendöpis', 'Ischdochglich', 'Wenn wir eine sache machen dan machen wir si auch', '2016-09-28', 8),
(15, 'Augustwetterspielen', 'Worblaufen', 'Grosses Kino', '2016-08-07', 8),
(16, 'Scheissen bis die Polizei kommt', 'Bundeshausplatz', '', '2016-11-15', 6),
(19, 'Turmmusik auf dem Münster', 'Münster Bern', 'Wir spielen die Feuerwerksmusik zu Ostern auf dem Münster. Danach gibt es in der Münster-Turnwohnung ein Frühstück für alle Beteiligten.\r\nIch freue mich auf alle Anmeldungen!', '2016-08-07', 6),
(20, 'Tschäm Seschän mit Jack Milk''s', 'Avrona', 'Läbe', '2016-08-07', 11),
(21, 'Fritz-Hornbläserei', 'Hornberg', 'Wir treffen uns auf dem Hornberg zum Blasen von verschiedenen Hörnern.', '2016-08-07', 15),
(22, 'Hans Runge Filmmusikproduktion', 'Berlin', 'Wir machen eine Session für die Filmmusik für den neuen Jabidsotto-Film und laden alle interessierten Musiker ein.', '2016-08-07', 8),
(24, 'Ga ggugge', 'Köln', 'So richtig lang überau ga ggugge', '2016-08-31', 2),
(25, 'Kiibord jäm mit Ableton', 'Bern', 'Impro und Experimentierrunde mit Jack Milk''s.\r\nGesucht sind talentierte Einsteiger und ambitionierte Amateure.', '2016-08-23', 17);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `project_instrumentation`
--

CREATE TABLE `project_instrumentation` (
  `id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `instrument_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `project_instrumentation`
--

INSERT INTO `project_instrumentation` (`id`, `project_id`, `instrument_id`, `person_id`) VALUES
(1, 22, 6, 9),
(2, 22, 8, 16),
(3, 22, 7, 6),
(7, 3, 2, 2),
(8, 4, 7, NULL),
(9, 5, 8, NULL),
(10, 9, 6, NULL),
(11, 10, 4, NULL),
(12, 11, 6, NULL),
(13, 12, 4, NULL),
(14, 13, 8, NULL),
(15, 14, 2, NULL),
(16, 15, 8, NULL),
(17, 16, 8, NULL),
(18, 19, 6, NULL),
(19, 20, 8, 8),
(20, 21, 7, 6),
(22, 24, 3, NULL),
(23, 24, 5, NULL),
(24, 25, 1, NULL),
(25, 25, 8, 8),
(26, 25, 2, NULL),
(27, 25, 3, NULL),
(28, 25, 4, NULL),
(29, 25, 6, NULL),
(30, 25, 7, NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `instrument`
--
ALTER TABLE `instrument`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `page`
--
ALTER TABLE `page`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `project_instrumentation`
--
ALTER TABLE `project_instrumentation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `instrument`
--
ALTER TABLE `instrument`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `page`
--
ALTER TABLE `page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT für Tabelle `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT für Tabelle `project_instrumentation`
--
ALTER TABLE `project_instrumentation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
