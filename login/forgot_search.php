<?php
	include_once("../lib/session_manager.php") ;
	include_once("../lib/utils.php") ;
	include_once("../database/config.php") ;
	include_once("../lib/user_manager.php") ;

	$email = $_POST['email'];
	$email=	rtrim(strtolower($email));
	
	CSessionManager::SetEmailId($email) ;
	
	$objUM = new CUserManager() ;
	$sec_ques = $objUM->GetFieldValueByEmail($email, CUser::FIELD_SECURITY_QUES);

	$str_msg = "" ;
	
	if ($sec_ques == "")
	{
		$str_msg = sprintf("<BR/>E-mail id  You porvide %s is not match with our records <BR/> please register yourself. Please go through the following link <A HREF=\"register.php\">Register with MGooS</A> to register with us.",$email);
	}
	else
	{
		$str_msg = sprintf("<BR/>Please answer following security question for e-mail ID.<BR/><BR/><FORM METHOD=POST ACTION=\"forgot_result.php\"><TABLE><TR><TD>Email :</TD><TD><INPUT TYPE=\"text\" NAME=\"email\" SIZE=\"40\" VALUE=\"%s\" readonly=\"readonly\"/></TD></TR><TR><TD>Security Question :</TD><TD><B>%s</B><BR/></TD></TR><TR><TD>Security Answer :</TD><TD><INPUT TYPE=\"text\" NAME=\"ans\" SIZE=\"40\"/><INPUT TYPE=\"submit\" VALUE=\"Submit\"/></TD></TR></TABLE></FORM>",$email, $sec_ques);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
	<HEAD>
		<TITLE>MGoos forgot password help - 2</TITLE>
	</HEAD>
	<BODY>
		<FIELDSET>
		<LEGEND>Welcome to MGooS forgot password help - 2</LEGEND>
		<IMG SRC="../images/mgoos_logo_s.jpg" WIDTH="148" HEIGHT="46" BORDER="0" ALT=""/>
		<?php
			echo($str_msg) ;
		?>
		</FIELDSET>
	</BODY>
</HTML>
	
