<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/email.php") ;
	include_once("../lib/id3_info.php") ;
	include_once("../database/config.php") ;
	include_once("../database/queries.php") ;
	
	$user_name 		= $_POST["name"] ;
	$user_email 	= $_POST["email"] ;
	$abuse_type		= $_POST["abuse_type"] ;
	$aud_id			= $_POST["aud_id"] ;
	$listing_index	= $_POST["listing_index"] ;
	
	$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
	$aud_title = $objQM->GetFieldValue($aud_id, "title") ;
	
	$play_url = "http://www.mgoos.com/playme?id=".$aud_id ;
	
	// Report Abuse.
	$sub_for_friend = "Hi ".$friends_name."! ".$user_name." sent you an Audio!" ;
	$msg_for_friend = "Hi <B>".$friends_name."</B><BR/><BR/>Your friend <B>".$friends_name."</B> has invited you to listen audio <A HREF='".$play_url."'><B>".$aud_title."</B></A>. Please click on following link <A HREF='".$play_url."'>".$play_url."</A> or copy and paste above link to your browser." ;
	
	CEMail::Send($friends_email, "<MGooS Invite> invite@mgoos.com", $sub_for_friend, $msg_for_friend);
	
	// Acknowledge User.
	$sub_for_user = "Abuse: Thank you ".$user_name."!" ;
	$msg_for_user = "Hi <B>".$user_name."</B><BR/><BR/>We have received the invite to your friend <B>".$friends_name."</B> to listen audio <A HREF='".$play_url."'><B>".$aud_title."</B></A>. Please click on following link <A HREF='".$play_url."'>".$play_url."</A> or copy and paste above link to your browser." ;
	
	CEMail::Send($user_email, "<MGooS Invite> invite@mgoos.com", $sub_for_user, $msg_for_user);
?>
{"result": 
	{"bResult": true,
	 "nListingIndex": <?php echo($listing_index); ?>,
	 "szAudId": "<?php echo($aud_id); ?>",
	 "szTitle": "<?php echo($aud_title); ?>",
	 "szUserName": "<?php echo($user_name); ?>",
	 "szUserEmail": "<?php echo($user_email); ?>",
	 "szFriendName": "<?php echo($friends_name); ?>"
	}
}