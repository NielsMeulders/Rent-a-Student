-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 10.246.16.235:3306
-- Generation Time: May 18, 2015 at 09:08 PM
-- Server version: 5.5.43-MariaDB-1~wheezy
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nielsmeulders_b`
--
DROP DATABASE `nielsmeulders_b`;
CREATE DATABASE `nielsmeulders_b` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `nielsmeulders_b`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`, `email`) VALUES
(1, 'Niels Meulders', '$2y$12$z6Zq4WRW1CQKtd8EFvouzOrnpH901.jibVujt943gNp5a23RNP1ny', 'niels.meulders@telenet.be'),
(4, 'We Are IMD', '$2y$12$A58MQ1YOouhKFHZhMhFiOuHFKDweGkcUIdYvaAHFzxe2BGCJOWCtS', 'info@weareimd.be');

-- --------------------------------------------------------

--
-- Table structure for table `bezoeker`
--

DROP TABLE IF EXISTS `bezoeker`;
CREATE TABLE IF NOT EXISTS `bezoeker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `fbid` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `bezoeker`
--

INSERT INTO `bezoeker` (`id`, `name`, `email`, `fbid`) VALUES
(9, 'Twix Sibaya', 'hypro_t1@hotmail.com', '10204235351104130'),
(10, 'Niels Meulders', 'niels.meulders@telenet.be', '10206556890466058');

-- --------------------------------------------------------

--
-- Table structure for table `boeking`
--

DROP TABLE IF EXISTS `boeking`;
CREATE TABLE IF NOT EXISTS `boeking` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) DEFAULT NULL,
  `student_id` varchar(10) DEFAULT NULL,
  `date_id` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `date_available`
--

DROP TABLE IF EXISTS `date_available`;
CREATE TABLE IF NOT EXISTS `date_available` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `date_available`
--

INSERT INTO `date_available` (`id`, `date`) VALUES
(39, '2015-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `date_gids_available`
--

DROP TABLE IF EXISTS `date_gids_available`;
CREATE TABLE IF NOT EXISTS `date_gids_available` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `student_id` int(10) DEFAULT NULL,
  `date_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `date_gids_available`
--

INSERT INTO `date_gids_available` (`id`, `student_id`, `date_id`) VALUES
(10, 9, 39);

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

DROP TABLE IF EXISTS `email`;
CREATE TABLE IF NOT EXISTS `email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

DROP TABLE IF EXISTS `rating`;
CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bezoeker_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `comment` text NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `picture` varchar(100) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `branch` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `name`, `email`, `password`, `picture`, `year`, `branch`, `description`) VALUES
(8, 'Jan Lauwers', 'sibayatwix@gmail.com', '$2y$12$8MFuWzBkjuT36fWArqvYY.R.Y5fVy.kxoYSJm02sQNTbz.qXDB2Gi', 'images/profile_pics/sibayatwix@gmail.com/robby.jpg', 2, 1, 'IMD is voor mij een gepaste richting. Mijn grootste interesse gaat uit naar animatie en video, grafisch design en 3D. Code schrijven en websites bouwen was voor mij de grootste nieuwe uitdaging, met ruime skillset als resultaat.\r\nWaarom kom jij IMD studeren? \r\nTijdens de week vind je mij meestal in de Creativity Gym, IMD headquarters.\r\nBoek mij en dan laat ik je met veel plezier kennismaken met IMD.'),
(9, 'Niels Meulders', 'niels.meulders@telenet.be', '$2y$12$Byh8EJ30HargoNjspbix4OsyFkXxtmU4IKli8bI4bpEexsj1n23HC', 'images/profile_pics/niels.meulders@telenet.be/IMG_1555.jpg', 2, 2, 'Ik ben Niels en gepassioneerd door alles wat te maken heeft met het web.\r\nIk ben in het secundair afgestudeerd in de richting industriÃ«le informatica. Een goed vervolg op de richting was toegepaste informatica aan de KHL. De vakken die we hier kregen, zijn zeer uitgebreid en voor mij dus niet geschikt.\r\nNa mijn eerste jaar wist ik in welke richting ik mij wou specialiseren en dat was IMD. Meteen wist ik dat ik hierin verder zou gaan.\r\nHopelijk kan ik je binnenkort begeleiden doorheen onze opleiding. Tot dan!');

-- --------------------------------------------------------


