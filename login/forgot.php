<?php
include_once("../lib/mgoos_config.php") ;
include_once("../lib/session_manager.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
	<HEAD>
		<TITLE>MGoos forgot password help</TITLE>
        <link rel="stylesheet" type="text/css" href="../css/mgoos.css" />
		<script language="JavaScript">
			function validate_form(emailinfo)
			{
				if(emailinfo.email.value == "" || emailinfo.email.value == null)
				{
					// Check for an empty string or null value
					alert("Please enter your email");
					return(false);
				}
				else
				{
					if (validate_email(emailinfo.email ,"Not a valid e-mail address!")==false)
					{
						emailinfo.email.focus();
						return false;
					}
					else
					{
						return(true);
					}
				}
			}
		
			function validate_email(field,alerttxt)
			{
				with (field)
				{
					apos=value.indexOf("@");
					dotpos=value.lastIndexOf(".");
					if (apos<1||dotpos-apos<2)
					{
						alert(alerttxt);
						return false;
					}
					else 
					{
						return true;
					}
				}
			}
		</script>
    </HEAD>
		<BODY>
		<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<!-- Header -->
				<?php					     include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=1&page_id=".CMGooSConfig::HF_FORGOT_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
		<TD><FIELDSET>
		<LEGEND>Welcome to MGooS forgot password help - 1</LEGEND>
		<IMG SRC="../images/mgoos_logo_s.jpg" WIDTH="148" HEIGHT="46" BORDER="0" ALT=""/>
		<FORM METHOD="POST" ACTION="forgot_search.php" NAME="INFO"
		    onSubmit="return validate_form(document.INFO)"><p>
			Please provide your E-Mail ID which you have given while registering with us.<BR/><BR/>
			E-Mail : <INPUT TYPE="text" NAME="email" SIZE="40" class="input"/>&nbsp;&nbsp;&nbsp;&nbsp;
			<INPUT TYPE="submit" value =" Submit "/>
		</FORM>
		</FIELDSET></TD>
             <TR>
				<?php					include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=1&page_id=".CMGooSConfig::HF_FORGOT_ID."&login=".CSessionManager::IsLoggedIn()); 
				?>
			</TR>
		</TABLE>
	</BODY>
</HTML>





