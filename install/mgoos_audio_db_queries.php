<?php
	class CMGoosAudioDBQueries
	{
		// Variable strings ends with _FR says, Format Required.
		var $m_sqlCreateDB_FR = "create database IF NOT EXISTS %s;" ;

		var $m_sqlDropAnalytics = "DROP TABLE IF EXISTS analytics;" ;
		/*
			CREATE TABLE `analytics` (
				`ip_id` int(11) NOT NULL auto_increment,
				`ip` varchar(30) default NULL,
				`visit` int(11) default NULL,
				PRIMARY KEY  (`ip_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
		*/
		var $m_sqlCreateAnalytics = "CREATE TABLE `analytics` ( `ip_id` int(11) NOT NULL auto_increment, `ip` varchar(30) default NULL, `visit` int(11) default NULL, PRIMARY KEY  (`ip_id`)) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;" ;

		var $m_sqlDropId3Info = "DROP TABLE IF EXISTS id3_info;" ;
		/*
			CREATE TABLE `id3_info` (
				`filepath` varchar(255) NOT NULL default '',
				`artist` text,
				`album` text,
				`title` text,
				`track` text,
				`comments` text,
				`genre` text,
				`seconds` text,
				`filesize` text,
				`bitrate` text,
				`visual` text,
				`file_id` text,
				`filetype` text,
				`basename` text,
				`add_date` text,
				`year` text,
				`votes` text,
				`plays` text,
				`rating` text,
				`time` text,
				`price` text,
				`alt1` text,
				`alt2` text,
				`alt3` text,
				`lyrics` longtext,
				`Show` binary(1) NOT NULL default '1' COMMENT 'will show the specific song if true',
				`Status` int(11) NOT NULL default '0' COMMENT 'For the status of the current song',
				PRIMARY KEY  (`filepath`),
				UNIQUE KEY `filepath` (`filepath`),
				UNIQUE KEY `filepath_2` (`filepath`),
				FULLTEXT KEY `artist` (`artist`,`album`,`basename`,`title`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;

		*/
		var $m_sqlCreateId3Info = "CREATE TABLE `id3_info` (`filepath` varchar(255) NOT NULL default '', `artist` text, `album` text, `title` text, `track` text, `comments` text, `genre` text, `seconds` text, `filesize` text, `bitrate` text, `visual` text, `myid` text, `filetype` text, `basename` text, `add_date` text, `year` text, `votes` text, `plays` text, `rating` text, `time` text, `price` text, `alt1` text, `alt2` text, `alt3` text, `lyrics` longtext, `Show` binary(1) NOT NULL default '1' COMMENT 'will show the specific song if true', `Status` int(11) NOT NULL default '0' COMMENT 'For the status of the current song', PRIMARY KEY  (`filepath`), UNIQUE KEY `filepath` (`filepath`), UNIQUE KEY `filepath_2` (`filepath`),  FULLTEXT KEY `artist` (`artist`,`album`,`basename`,`title`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;" ;
		
		var $m_sqlDropPlaylists = "DROP TABLE IF EXISTS playlists;" ;
		/*
			CREATE TABLE `playlists` (
				`myid` varchar(20) NOT NULL default '',
				`myname` text,
				`user` text,
				`date` text,
				`comments` text,
				`coverart` text,
				`mydata` text,
				`alt1` text,
				`alt2` text,
				`alt3` text,
				PRIMARY KEY  (`myid`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		*/
		var $m_sqlCreatePlaylists = "CREATE TABLE `playlists` ( `myid` varchar(20) NOT NULL default '', `myname` text, `user` text, `date` text, `comments` text, `coverart` text, `mydata` text, `alt1` text, `alt2` text, `alt3` text, PRIMARY KEY  (`myid`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;" ;
		
		var $m_sqlDropUsers = "DROP TABLE IF EXISTS users;" ;
		/*
			CREATE TABLE `users` (
				`myuser` varchar(20) NOT NULL default '',
				`mypwd` text,
				`mypriv` text,
				`mypls` text,
				`mysignupdate` text,
				`email` text,
				`alt1` text,
				`alt2` text,
				`alt3` text,
				PRIMARY KEY  (`myuser`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		*/
		var $m_sqlCreateUsers = "CREATE TABLE `users` ( `myuser` varchar(20) NOT NULL default '', `mypwd` text, `mypriv` text, `mypls` text, `mysignupdate` text, `email` text, `alt1` text, `alt2` text, `alt3` text, PRIMARY KEY  (`myuser`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;" ;

		var $m_sqlDropQuotes = "DROP TABLE IF EXISTS quotes;" ;
		/*
			CREATE TABLE `quotes` (
				`quote_id` int(11) NOT NULL auto_increment,
				`quote` text default NULL,
				`author` text default NULL,
				PRIMARY KEY  (`quote_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1;
		*/
		var $m_sqlCreateQuotes = "CREATE TABLE `quotes` (`quote_id` int(11) NOT NULL auto_increment,	`quote` text default NULL, `author` text default NULL, PRIMARY KEY  (`quote_id`)) ENGINE=MyISAM DEFAULT CHARSET=latin1;" ;
	}
?>