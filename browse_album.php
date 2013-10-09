<?php
	include_once("lib/session_manager.php") ;
	include_once("lib/utils.php") ;
	
	CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_BROWSE_ALBUM);
	
	CUtils::Redirect("search_results.php?pg=1") ;
?>