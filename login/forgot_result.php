<?php
	include_once("../lib/user_manager.php");
	include_once("../lib/utils.php");
	include_once("../database/config.php");
    include_once("../lib/mgoos_config.php") ;
	include_once("../lib/session_manager.php");
?>
<HTML>
   <HEAD>
	<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<TITLE>	Forgot Result</TITLE>
    <link rel="stylesheet" type="text/css" href="../css/mgoos.css" />
	<script type="text/javascript">
	function CheckSimilarity()
	{
		var pass=document.getElementById('password').value;
		var cpass=document.getElementById('cpassword').value;
		if(pass == cpass)
		{
			document.getElementById('submitbutton').disabled=false;
		}
		else
		{
			document.getElementById('submitbutton').disabled=true;
		}
	}
	</script>
   </HEAD>
	<BODY>
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<!-- Header -->
				<?php					     include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=1&page_id=".CMGooSConfig::HF_FRGT_RSLT_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
	<TD><?php
	$UserM = new  CUserManager();

	$email = $_POST['email'];
	$secans= $_POST['ans'];
	
	$objUser = $UserM->GetUserByEmail($email);
	
	$value = $UserM->GetFieldValueByEmail($email,CUser::FIELD_SECURITY_ANS);

//	strcasecmp($secans,$value);

	if (strcasecmp($secans, $value) == 0)//($obj->GetSecAns()==$secans)
	{
		echo "<b>Email: </b>".$email;
		echo ("<br><B>Value is  </B>".$value."<br>") ;
		printf("<b>Well-come to mgoos %s %s</b>",$objUser->GetFirstName(),$objUser->GetLastName());
		printf("<BR>Enter new password ");
		printf("<BR>
			<FORM METHOD=POST ACTION=\"forgot_done.php\">
			Password <INPUT TYPE=\"password\" VALUE='' NAME=\"password\" ID=\"password\">
			Confirm Password <INPUT TYPE=\"password\" VALUE='' ID=\"cpassword\" NAME=\"cpassword\" onBlur=\"CheckSimilarity()\">
			<INPUT TYPE=\"submit\" id=\"submitbutton\" value=\"submit\" disabled=\"true\">
			<INPUT TYPE=\"text\" STYLE=\"display:none\" NAME=\"email\" value=\"%s\">
		</FORM>",$email);
	}
	else
	{
		printf("The answer you provided does not match with our records <br> Please Re-Enter the Answer");
		
		$objUser = $UserM->GetUserByEmail($email);
		
		//printf("<FORM METHOD=POST ACTION=\"forgot_result.php\">	
		//Security question:->\t\t <b>%s</b> ",$objUser->GetSecQues());
		
		//printf("<BR>Enter the answer <INPUT TYPE=\"text\" NAME=\"ans\"> ");
		//printf("<INPUT TYPE=\"submit\">");
		//printf("</FORM>");
		printf("<FORM METHOD=POST ACTION=\"forgot_result.php\"><TABLE><TR><TD>Email :</TD><TD><INPUT TYPE=\"text\" NAME=\"email\" SIZE=\"40\" VALUE=\"%s\" readonly=\"readonly\"/></TD></TR><TR><TD>Security Question :</TD><TD><B>%s</B><BR/></TD></TR><TR><TD>Security Answer :</TD><TD><INPUT TYPE=\"text\" NAME=\"ans\" SIZE=\"40\"/><INPUT TYPE=\"submit\" VALUE=\"Submit\"/></TD></TR></TABLE></FORM>",$email,$objUser->GetSecQues());
	}
?></TD>
            <TR>
				<?php					include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=1&page_id=".CMGooSConfig::HF_FRGT_RSLT_ID."&login=".CSessionManager::IsLoggedIn()); 
				?>
			</TR>
		</TABLE>
	</BODY>
</HTML>
             