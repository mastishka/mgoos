<?php
	include_once("../database/queries.php") ;
	include_once("../lib/id3_info.php") ;
	
	$objId3 = new CId3Info($_POST);
	
	$song = $objId3->GetTitle() ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	if( $objQM->UpdateMp3Info($objId3) )
	{
		$bUpdate = true ;
				
		CUtils::Redirect("tab_manage_aud_mymp3.php?type=1&update=true&title=".urlencode($song)) ;
	}
	else 
	{
		$bUpdate = false ;
		
		CUtils::Redirect("tab_manage_aud_mymp3.php?type=1&update=false&title=".urlencode($song)) ;
	}
?>