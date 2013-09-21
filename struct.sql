-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 09, 2012 at 11:11 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.6-13ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `gta`
--

--
-- Table structure for table `gta_chem_feedback`
--

CREATE TABLE IF NOT EXISTS `gta_chem_feedback` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `gtaid` int(5) NOT NULL,
  `uname` varchar(8) NOT NULL,
  `vote` int(2) NOT NULL,
  `comment` text NOT NULL,
  `submit_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gta_chem_feedback`
--

CREATE TABLE IF NOT EXISTS `gta_chem_tutor_feedback` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `gtaid` int(5) NOT NULL,
  `uname` varchar(8) NOT NULL,
  `vote` int(2) NOT NULL,
  `comment` text NOT NULL,
  `submit_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gta_chem_gtas`
--

CREATE TABLE IF NOT EXISTS `gta_chem_gtas` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(75) NOT NULL,
  `group` varchar(30) NOT NULL,
  `experiment` varchar(30) NOT NULL,
  `open` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gta_chem_gtas`
--

CREATE TABLE IF NOT EXISTS `gta_chem_tutors` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `image` varchar(75) NOT NULL,
  `group` varchar(30) NOT NULL,
  `experiment` varchar(30) NOT NULL,
  `open` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gta_chem_users`
--

CREATE TABLE IF NOT EXISTS `gta_chem_users` (
  `uname` varchar(8) NOT NULL,
  `labgroup` varchar(5) NOT NULL,
  `tutorgroup` varchar(5) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
