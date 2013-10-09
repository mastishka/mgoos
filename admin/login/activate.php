<?php
	include_once("../database/config.php");
	include_once("../lib/user_manager.php");
	include_once("../lib/email.php");
	
	include_once("../lib/utils.php") ;
	
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url); // will return array of url components.
	parse_str($query_str["query"]) ; // the query string will be parsed here.
	
	$objUM	= new CUserManager();
	$result_id = $objUM->ActivateAccount($secid);
	$bResult = false;
	
	if($result_id) 
	{
		$bResult = true;
		$objUser = $objUM->GetUserByID($result_id);

		// Send welcome mail.
		$subject = "You can rock the world with MGooS!" ;
		$body = "Hi! ".$objUser->GetFirstName()." ".$objUser->GetLastName()."<BR/> Welcome to MGooS enjoy searching and sharing muzic with <A HREF=\"my.php\"><B>My MGoos</B></A>.";
		$from = "no_reply@mgoos.com";
		
		CEMail::Send($result_email, $from, $subject, $body);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
	<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<TITLE>MGooS - Activation</TITLE>
	</HEAD>
	<BODY>
		<FIELDSET>
		<LEGEND>Activation Status</LEGEND>
		<IMG SRC="../images/mgoos_logo_s.jpg" WIDTH="148" HEIGHT="46" BORDER="0" ALT=""/>
		<?php
			if($bResult)
			{
				echo("<P>Thank you for registering with MGooS! Your account has been activated. You may now <A HREF=\"../my_mgoos.php\">login</A> to your account.</P>") ;
			}
			else 
			{
				echo("<P>Activation Failed: Sorry we can not activate your account. Please make sure you have copied correct hyperlink in the address bar.</P>") ;
			}
		?>
		</FIELDSET>
	</BODY>
</HTML>