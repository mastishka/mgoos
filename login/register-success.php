<?php
	// Send verification mail
	include_once("../lib/email.php");
	include_once("../lib/utils.php") ;
	
	$url = CUtils::curPageURL() ;
	$query_str = parse_url($url); // will return array of url components.
	parse_str($query_str["query"]) ; // the query string will be parsed here.
	
	$subject = "Activate My MGooS!" ;
	$body = "Please click on link http://beta.mgoos.com/login/activate.php?secid=".md5(urldecode($umail))." to activate your account on MGooS.com .";
	$from = "no_reply@mgoos.com";
	CEMail::Send($umail,$from, $subject, $body);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
	<HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<TITLE>MGooS - Registration Pending</TITLE>
	</HEAD>
	<BODY>
		<FIELDSET>
		<LEGEND>Registration Pending</LEGEND>
		<IMG SRC="../images/mgoos_logo_s.jpg" WIDTH="148" HEIGHT="46" BORDER="0" ALT=""><P>Thank you for registering with MGooS. We have sent you an e-mail to activate your account. Please check your e-mail '<?php echo($umail); ?>' account and follow the instructions to activate your account.Click <a href="www.mgoos.com">Here </a> to go to Search Page</P>
		</FIELDSET>
	</BODY>
</HTML>
