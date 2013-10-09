<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/id3_info.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	
	$aud_id			= $_POST["aud_id"] ;
	$listing_index	= $_POST["listing_index"] ;
	$used_id = CSessionManager::GetUserId();
	
	$bResult = true ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$bAdded = $objQM->IsBookmarked($aud_id, $used_id) ;
	
	if(!$bAdded)
	{
		$bResult = $objQM->AddBookmark(CSessionManager::GetUserId(), $aud_id) ;
	}
?>
{"result": 
	{"bResult": <?php echo($bResult); ?>,
	 "bAlreadyAdded": <?php echo($bAdded); ?>,
	 "nListingIndex": <?php echo($listing_index); ?>,
	 "szAudId": "<?php echo($aud_id); ?>"
	}
}