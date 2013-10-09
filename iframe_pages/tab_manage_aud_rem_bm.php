<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/utils.php") ;
	include_once("../lib/id3_info.php") ;
	include_once("../database/queries.php") ;
			
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url); // will return array of url components.
	parse_str($query_str["query"]) ; // the query string will be parsed here.
	
	$objDB = new CQueryManager(CConfig::DB_AUDIO) ;
	$objDB->RemoveBookmark(CSessionManager::GetUserId(), $id) ;
	
	CUtils::Redirect('tab_manage_aud_bookmarks.php?pg='.$pg);
?>