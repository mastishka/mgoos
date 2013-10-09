<?php
include_once("mgoos_config.php");
	class CEMail
	{
		static function Send($to, $from, $sub, $msg)
		{
			// to add content type 
			$header = "MIME-Version: 1.0" . "\r\n";
			$header .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
			$header .= "From: " . $from . "\r\n";
			
			$msg = str_replace("\n.", "\n..", $msg);	// to replace blank space in.
			
			$msg = wordwrap($msg, 70) ;
			
			@mail($to, $sub, $msg, $header) ;
		}
		
		/*
		 * Prepare and Send invite mail To Friend.
		 */
		static function PrepAndSendMailSTF($friends_email, $friends_name, $user_email, $user_name, $aud_title, $play_url)
		{
			$sub_for_friend = "Hi ".$friends_name."! ".$user_name." sent you an Audio!" ;
			$msg_for_friend = "Hi <B>".$friends_name."</B>,<BR/><BR/>Your friend <B>".$user_name."</B> ( ".$user_email." ) has invited you to listen audio <A HREF='".$play_url."'><B>".$aud_title."</B></A>. To listen the audio, please click on following link <A HREF='".$play_url."'>".$play_url."</A> or copy and paste above link to your browser.<BR/><BR/>Regards,<BR/><A HREF=CMGooSConfig::MGOOS_ROOT>www.MGooS.com</A><BR/><B>Search Audio, Share Audio, Love Audio</B><BR/><BR/><BR/>This is an auto generated Email. Please don't reply to this mail." ;
			
			CEMail::Send($friends_email, "invite@mgoos.com", $sub_for_friend, $msg_for_friend) ;
		}
		
		/*
		 * Acknowledge User on Send To Friend.
		 */
		static function PrepAndSendAckUserSTF($friends_email, $friends_name, $user_email, $user_name, $aud_title, $play_url)
		{
			$sub_for_user = "Hi ".$user_name."! we have sent invite to ".$friends_name ;
			$msg_for_user = "Hi <B>".$user_name."</B>,<BR/><BR/>We have sent the invite to your friend <B>".$friends_name."</B> ( ".$friends_email." )to listen audio <A HREF='".$play_url."'><B>".$aud_title."</B></A>. To listen the audio, please click on following link <A HREF='".$play_url."'>".$play_url."</A> or copy and paste above link to your browser.<BR/><BR/>Regards,<BR/><A HREF=CMGooSConfig::MGOOS_ROOT>www.MGooS.com</A><BR/><B>Search Audio, Share Audio, Love Audio</B><BR/><BR/><BR/>This is an auto generated Email. Please don't reply to this mail." ;
			
			CEMail::Send($user_email, "invite@mgoos.com", $sub_for_user, $msg_for_user);
		}
	}
?>		