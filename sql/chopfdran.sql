-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 07. Aug 2016 um 19:26
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
(4, 'sdfsdf', '$2y$10$VWGOB6zyTxUNzkhJ5acCP.IoxiIUpAbqqLTg.Ya64eRapiQByiuFS', 'sde@sdf.sdf', 'f', '2222-02-22', 'sdf', 8),
(6, 'Schnurli', '$2y$10$qilaVlGIUI3jXdpd9.3LwOfagz0oOri04wpai548Jvcb2SCoaDzta', 'schnurli@super.xx', 'f', '2000-01-01', 'Basel', 7),
(8, 'Hans Baumgartner', '$2y$10$f2c8O6MdSFF7OOJiy7VcKe1zU7OrkgKHimHVuRv4dVPBis3FBdHWW', 'georg.brodbeck@gmail.com', 'm', '1992-06-01', 'Ittigen', 8);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `title` char(100) NOT NULL,
  `city` char(50) NOT NULL,
  `description` text,
  `instrumentation` int(11) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `project`
--

INSERT INTO `project` (`id`, `title`, `city`, `description`, `instrumentation`, `event_date`, `person_id`) VALUES
(3, 'Punk mit Stifu', 'Bärn', 'Judihui gagi', 2, '2016-08-15', 6),
(4, 'Gartenarbeit mit Musikinstrumenten', 'Bern', 'Die andere Art der Musik: Wir bearbeiten den Garten mit ausrangierten Musikinstrumenten und nehmen das ganze auf. Die CD-Verkaufs-Einnahmen werden an Pro Garten Schweiz gespendet.', 7, '2016-08-25', 2),
(5, 'Funk mit Tschortsch', 'Tschoto', 'E huere geili Bänd, mit em Tschortsch aus Liidsänger.\r\nGspiut wird usschliässläch kitschigä Funk. Aues säuber komponiert vom Tschortsch. Gsuächt wärde nur blondi Froue mit piiipsstimme.', 8, '2016-08-07', 6),
(9, 'Autohupkonzert-Probe', 'Bern', 'Wir treffen uns auf dem Galantparkplatz mit möglichst vielen Autos. Der Dirigent kommt mit einem Panzer, wir spielen die Hupsynphonie von Mozart.', 6, '2016-08-31', 2),
(10, 'Lorem ipsum', 'Ipsach', 'Damit Ihr indess erkennt, woher dieser ganze Irrthum gekommen ist, und weshalb man die Lust anklagt und den Schmerz lobet, so will ich Euch Alles eröffnen und auseinander setzen, was jener Begründer der Wahrheit und gleichsam Baumeister des glücklichen Lebens selbst darüber gesagt hat. Niemand, sagt er, verschmähe, oder hasse, oder fliehe die Lust als solche, sondern weil grosse Schmerzen ihr folgen, wenn man nicht mit Vernunft ihr nachzugehen verstehe. Ebenso werde der Schmerz als solcher von Niemand geliebt, gesucht und verlangt, sondern weil mitunter solche Zeiten eintreten, dass man mittelst Arbeiten und Schmerzen eine grosse Lust sich zu verschaften suchen müsse. Um hier gleich bei dem Einfachsten stehen zu bleiben, so würde Niemand von uns anstrengende körperliche Uebungen vornehmen, wenn er nicht einen Vortheil davon erwartete. Wer dürfte aber wohl Den tadeln, der nach einer Lust verlangt, welcher keine Unannehmlichkeit folgt, oder der einem Schmerze ausweicht, aus dem keine Lust hervorgeht?\r\n\r\nDagegen tadelt und hasst man mit Recht Den, welcher sich durch die Lockungen einer gegenwärtigen Lust erweichen und verführen lässt, ohne in seiner blinden Begierde zu sehen, welche Schmerzen und Unannehmlichkeiten seiner deshalb warten. Gleiche Schuld treffe Die, welche aus geistiger Schwäche, d.h. um der Arbeit und dem Schmerze zu entgehen, ihre Pflichten verabsäumen. Man kann hier leicht und schnell den richtigen Unterschied treffen; zu einer ruhigen Zeit, wo die Wahl der Entscheidung völlig frei ist und nichts hindert, das zu thun, was den Meisten gefällt, hat man jede Lust zu erfassen und jeden Schmerz abzuhalten; aber zu Zeiten trifft es sich in Folge von schuldigen Pflichten oder von sachlicher Noth, dass man die Lust zurückweisen und Beschwerden nicht von sich weisen darf. Deshalb trifft der Weise dann eine Auswahl, damit er durch Zurückweisung einer Lust dafür eine grössere erlange oder durch Uebernahme gewisser Schmerzen sich grössere erspare. ', 4, '2018-04-27', 6),
(11, 'müsig mit mätscherer', 'Deheim', '1. Projekt wird von einer Person vorgeschlagen\r\n2. Musiker bekommen Mail mit Empfehlungen von Projekten in der Nähe welche ihrem Niveau/Level entsprechen\r\n3. Musiker melden sich an\r\n4. Sind alle Positionen bis zum Stichtag besetzt, wird bei überbesetzten Registern die Kombination mit dem bestem Match automatisch ausgewählt.\r\n5. Durchführung des Projekts (Projekte mit öffentlichem Auftritt werden im Veranstaltungskalender hinzugefügt).\r\n6. Qualitätssicherung ? Auswertung', 6, '2016-08-07', 6),
(12, 'Stinknormale Bandprobe', 'Lauterbrunnen', 'Wir möchten uns gerne treffen für eine Bandprobe ohne Besonderheiten. Wenn du dich als Mensch ohne Besonderheiten wahrnimmst, dann ist das genau das Richtige für dich. Melde dich an! Bitte!!', 4, '2016-10-24', 2),
(13, 'Singen forever', 'Rammalan', 'Wir singen um die Wette bis jemand stirbt.', 8, '2016-09-03', 0),
(14, 'Gartehag irgendöpis', 'Ischdochglich', 'Wenn wir eine sache machen dan machen wir si auch', 2, '2016-09-28', 8),
(15, 'Augustwetterspielen', 'Worblaufen', 'Grosses Kino', 8, '2016-08-07', 8),
(16, 'Scheissen bis die Polizei kommt', 'Bundeshausplatz', '', 8, '2016-11-15', 6),
(19, 'Turmmusik auf dem Münster', 'Münster Bern', 'Wir spielen die Feuerwerksmusik zu Ostern auf dem Münster. Danach gibt es in der Münster-Turnwohnung ein Frühstück für alle Beteiligten.\r\nIch freue mich auf alle Anmeldungen!', 6, '2016-08-07', 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `project_participant`
--

CREATE TABLE `project_participant` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `project_participant`
--

INSERT INTO `project_participant` (`id`, `person_id`, `project_id`) VALUES
(1, 8, 13),
(2, 8, 5),
(3, 2, 3),
(4, 6, 4);

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
-- Indizes für die Tabelle `project_participant`
--
ALTER TABLE `project_participant`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT für Tabelle `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT für Tabelle `project_participant`
--
ALTER TABLE `project_participant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
