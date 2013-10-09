<?php
	include_once("lib/session_manager.php") ;
	include_once("lib/utils.php") ;
	
	CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_RECENT_UPLOADS);
	
	CUtils::Redirect("search_results.php?pg=1") ;
?>