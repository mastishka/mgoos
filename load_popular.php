<?php
	include_once("lib/session_manager.php") ;
	include_once("lib/utils.php") ;
	
	CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_LOAD_POPULAR);
	
	CUtils::Redirect("search_results.php?pg=1") ;
?>