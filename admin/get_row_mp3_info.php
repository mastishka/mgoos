<?php
	include_once("../lib/session_manager.php") ;
	include_once("../database/queries.php");
	
	$row_index = $_POST["row"] ;
	
	$objQM = new CQueryManager(CConfig::DB_ADMIN) ;
	
	//echo $row_index."\n";
	$row = $objQM->SelectRowFromAdminMP3Info($row_index) ;
	
	//print_r($row) ;
?>
{"result":
	{"bResult": <?php echo($row["result"]); ?>,
	 "elements": <?php echo($row["elements"]); ?>,
	 "file": "<?php echo($row["file"]); ?>",
	 "title": "<?php echo($row["title"]); ?>",
	 "artist": "<?php echo($row["artist"]); ?>",
	 "album": "<?php echo($row["album"]); ?>",
	 "year": "<?php echo($row["year"]); ?>",
	 "composer": "<?php echo($row["composer"]); ?>",
	 "picturizedon": "<?php echo($row["picturizedon"]); ?>",
	 "genre": "<?php echo($row["genre"]); ?>",
	 "mood": "<?php echo($row["mood"]); ?>",
	 "language": "<?php echo($row["language"]); ?>",
	 "lyrics": "<?php echo($row["lyrics"]); ?>",
	 "filesize": "<?php echo($row["filesize"]); ?>",
	 "bitrate": "<?php echo($row["bitrate"]); ?>",
	 "duration_sec": "<?php echo($row["duration_sec"]); ?>"
	}
}