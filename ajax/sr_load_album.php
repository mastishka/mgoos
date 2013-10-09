<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/email.php"); 
	include_once("../lib/utils.php");
	include_once("../database/config.php");
	include_once("../database/queries.php");
	
	$albumname= $_POST["qry"] ;
	$album_songid_list    = "";
	$album_songtitle_list = "";
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$bResult = $objQM->GetAlbumSongList($albumname, $album_songid_list,$album_songtitle_list) ;
?>
{"result":
	{"bResult": <?php echo($bResult); ?>,
	 "album_songid_list": "<?php echo($album_songid_list); ?>",
	 "album_songtitle_list": "<?php echo($album_songtitle_list); ?>"
	}
}