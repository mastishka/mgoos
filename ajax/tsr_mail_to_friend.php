<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/email.php") ;
	include_once("../lib/id3_info.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	
	$user_name 		= $_POST["user_name"] ;
	$user_email 	= $_POST["user_email"] ;
	$friends_name	= $_POST["friend_name"] ;
	$friends_email 	= $_POST["friend_email"] ;
	$aud_id			= $_POST["aud_id"] ;
	$listing_index	= $_POST["listing_index"] ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$aud_title = $objQM->GetFieldValue($aud_id, "title") ;
	
	// Increase mp3_info Vote Count.
	$objQM->IncreaseVoteCount($aud_id);
	
	//Insert into send_to_friend table
	$objQM->InsertSendToFriend($user_name, $user_email, $friends_name, $friends_email, $aud_id);
	
	$play_url = CMGooSConfig::MGOOS_ROOT."/playme.php?id=".$aud_id ;
	
	// Invite Friend.
	CEMail::PrepAndSendMailSTF($friends_email, $friends_name, $user_email, $user_name, $aud_title, $play_url) ;
	
	// Acknowledge User.
	CEMail::PrepAndSendAckUserSTF($friends_email, $friends_name, $user_email, $user_name, $aud_title, $play_url) ;
	
	/*
	 * [Debug Code]
	 * "szTestString": "<?php echo("User Name: ".$user_name.", User Email: ".$user_email.", Friends Name: ".$friends_name.", Friends Email: ".$friends_email.", Aud Id:".$aud_id.", Aud Title: ".$aud_title.", Listing Index: ".$listing_index.", Play Url: ".$play_url); ?>"
	 */
?>
{"result": 
	{"bResult": true,
	 "nListingIndex": <?php echo($listing_index); ?>,
	 "szAudId": "<?php echo($aud_id); ?> ",
	 "szTitle": "<?php echo($aud_title); ?> ",
	 "szUserName": "<?php echo($user_name); ?>",
	 "szUserEmail": "<?php echo($user_email); ?>",
	 "szFriendName": "<?php echo($friends_name); ?>"
	}
}