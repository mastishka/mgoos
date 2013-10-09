-- phpMyAdmin SQL Dump
-- version 3.4.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 09, 2013 at 04:02 AM
-- Server version: 5.5.34
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mgooscom_audio`
--

-- --------------------------------------------------------

--
-- Table structure for table `abuse`
--

DROP TABLE IF EXISTS `abuse`;
CREATE TABLE IF NOT EXISTS `abuse` (
  `ticket_id` varchar(40) NOT NULL COMMENT 'UUID',
  `email` varchar(255) NOT NULL COMMENT 'Reporter Email-ID',
  `mp3_id` varchar(40) NOT NULL,
  `abuse_type` int(2) NOT NULL COMMENT 'above 18/copyright',
  `comments` text,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT 'open:0/close:1',
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `alien_users`
--

DROP TABLE IF EXISTS `alien_users`;
CREATE TABLE IF NOT EXISTS `alien_users` (
  `user_id` varchar(40) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `analytics`
--

DROP TABLE IF EXISTS `analytics`;
CREATE TABLE IF NOT EXISTS `analytics` (
  `ip_id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(30) DEFAULT NULL,
  `visit` int(11) DEFAULT NULL,
  PRIMARY KEY (`ip_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

DROP TABLE IF EXISTS `bookmarks`;
CREATE TABLE IF NOT EXISTS `bookmarks` (
  `user_id` varchar(40) NOT NULL,
  `bookmarks` longtext NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `citation_request`
--

DROP TABLE IF EXISTS `citation_request`;
CREATE TABLE IF NOT EXISTS `citation_request` (
  `songid` varchar(40) NOT NULL,
  `title` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `composer` varchar(255) NOT NULL,
  `picturizedon` varchar(255) NOT NULL,
  `year` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `code` int(4) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crawled_mp3_urls`
--

DROP TABLE IF EXISTS `crawled_mp3_urls`;
CREATE TABLE IF NOT EXISTS `crawled_mp3_urls` (
  `url` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `source` varchar(255) NOT NULL,
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crawled_nonmp3_urls`
--

DROP TABLE IF EXISTS `crawled_nonmp3_urls`;
CREATE TABLE IF NOT EXISTS `crawled_nonmp3_urls` (
  `url` varchar(512) NOT NULL,
  `status` int(1) NOT NULL,
  UNIQUE KEY `url` (`url`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crawled_rooturls`
--

DROP TABLE IF EXISTS `crawled_rooturls`;
CREATE TABLE IF NOT EXISTS `crawled_rooturls` (
  `url` varchar(255) NOT NULL,
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `genre` varchar(64) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT 'No Information',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1598 ;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `language` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=149 ;

-- --------------------------------------------------------

--
-- Table structure for table `mood`
--

DROP TABLE IF EXISTS `mood`;
CREATE TABLE IF NOT EXISTS `mood` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `mood` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=178 ;

-- --------------------------------------------------------

--
-- Table structure for table `mp3_hphonetic_info`
--

DROP TABLE IF EXISTS `mp3_hphonetic_info`;
CREATE TABLE IF NOT EXISTS `mp3_hphonetic_info` (
  `id` varchar(40) NOT NULL,
  `title` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `composer` varchar(255) NOT NULL,
  `picturizedon` varchar(255) NOT NULL,
  `lyrics` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp3_info`
--

DROP TABLE IF EXISTS `mp3_info`;
CREATE TABLE IF NOT EXISTS `mp3_info` (
  `id` varchar(40) NOT NULL,
  `upload_date` date NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `filesize` int(4) NOT NULL,
  `bitrate` int(2) NOT NULL,
  `duration_sec` float unsigned NOT NULL,
  `language` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '0 : Private, 1 : Public, 2: Issued Private',
  `lyrics` longtext NOT NULL,
  `composer` varchar(255) NOT NULL,
  `picturizedon` varchar(255) NOT NULL COMMENT 'If video picturized then on whom it is?',
  `year` varchar(16) NOT NULL,
  `plays` int(8) NOT NULL DEFAULT '0' COMMENT 'Number of times file played',
  `votes` int(8) NOT NULL DEFAULT '0' COMMENT 'Number of times this file has been recommended to other people by inviting them to hear this song.',
  `rating` int(8) NOT NULL DEFAULT '1',
  `user_id` varchar(40) NOT NULL COMMENT 'Foreign Key to users table primary key.',
  `mood` varchar(255) DEFAULT NULL,
  `last_played` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_week_plays` int(8) NOT NULL DEFAULT '0',
  `todays_plays` int(8) NOT NULL DEFAULT '0',
  `provider` varchar(255) NOT NULL DEFAULT 'http://www.mgoos.com',
  PRIMARY KEY (`id`),
  UNIQUE KEY `filepath` (`filepath`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp3_metaphone_info`
--

DROP TABLE IF EXISTS `mp3_metaphone_info`;
CREATE TABLE IF NOT EXISTS `mp3_metaphone_info` (
  `id` varchar(40) NOT NULL COMMENT 'Key common to mp3_info',
  `title` varchar(255) NOT NULL,
  `album` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `composer` varchar(255) NOT NULL,
  `picturizedon` varchar(255) NOT NULL,
  `lyrics` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mp3_play_location`
--

DROP TABLE IF EXISTS `mp3_play_location`;
CREATE TABLE IF NOT EXISTS `mp3_play_location` (
  `mp3_id` varchar(40) NOT NULL,
  `ip_addr` varchar(16) NOT NULL,
  `play_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orkut_users`
--

DROP TABLE IF EXISTS `orkut_users`;
CREATE TABLE IF NOT EXISTS `orkut_users` (
  `user` varchar(255) NOT NULL COMMENT 'Orkut user key should always starts with ''OU-''',
  `reg_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Registration Date-Time',
  PRIMARY KEY (`user`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

DROP TABLE IF EXISTS `playlists`;
CREATE TABLE IF NOT EXISTS `playlists` (
  `playlist_id` varchar(40) NOT NULL,
  `user_id` varchar(40) NOT NULL COMMENT 'user_id same as users table.',
  `name` varchar(255) NOT NULL,
  `playlist` longtext NOT NULL COMMENT 'semicolon sapareted mp3 ids',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comments` text,
  PRIMARY KEY (`playlist_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `radio_playlist`
--

DROP TABLE IF EXISTS `radio_playlist`;
CREATE TABLE IF NOT EXISTS `radio_playlist` (
  `id` varchar(40) NOT NULL,
  `title` varchar(255) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `send_to_friend`
--

DROP TABLE IF EXISTS `send_to_friend`;
CREATE TABLE IF NOT EXISTS `send_to_friend` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sent_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `friend_name` varchar(255) NOT NULL,
  `friend_email` varchar(255) NOT NULL,
  `aud_id` varchar(40) NOT NULL COMMENT 'Audio ID which were mailed by user.',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=414 ;

-- --------------------------------------------------------

--
-- Table structure for table `songs_pk_mp3s`
--

DROP TABLE IF EXISTS `songs_pk_mp3s`;
CREATE TABLE IF NOT EXISTS `songs_pk_mp3s` (
  `id` varchar(40) NOT NULL,
  `mp3_url` varchar(255) NOT NULL,
  `redirect_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` varchar(40) NOT NULL COMMENT 'UUID',
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `gender` tinyint(2) NOT NULL COMMENT '0 for Female & 1 for Male',
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `security_ques` varchar(255) NOT NULL,
  `security_ans` varchar(255) NOT NULL,
  `signupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Signup Date',
  `reg_status` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Registration Status of the member',
  `online` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0 for Offline, 1 for Online',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
