<?php
	include_once("lib/session_manager.php") ;
	include_once("lib/utils.php") ;
	
	// - - - - - - - - - - - - - - - - - - - - -
	// Parse URL and get the query string param.
	// - - - - - - - - - - - - - - - - - - - - -
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url);
	parse_str($query_str["query"]) ;
	// - - - - - - - - - - - - - - - - - - - - -
	
	// Set Reffered Information.
	CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_PLAYME_PHP) ;
	CSessionManager::SetReferredData(CSessionManager::REF_DATA_MP3_ID."=".$id) ;
	
	// Redirect page to search_results.php
	CUtils::Redirect("search_results.php") ;
?>