<?php 	include_once("../lib/session_manager.php"); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<script type="text/javascript" language="javascript">
</script>
<HTML>
	<HEAD>
		<TITLE> New Document </TITLE>
		<META NAME="Generator" CONTENT="EditPlus">
		<META NAME="Author" CONTENT="">
		<META NAME="Keywords" CONTENT="">
		<META NAME="Description" CONTENT="">
		<SCRIPT LANGUAGE="JavaScript" type="text/javascript">
		function DisplayError(error)
		{
		  var msgspan =	parent.document.getElementById("message");		 
		  msgspan.innerHTML = error;
		}
		</SCRIPT>
	</HEAD>		
	<BODY>
		<FORM METHOD="POST" ACTION="login.php">
			<?php
			/*if(CSessionManager::IsError() && CSessionManager::GetErrorMsg()!="")
			{
				echo(sprintf("<script language='javascript' type='text/javascript'> DisplayError('%s');</script>",CSessionManager::GetErrorMsg()));
			}*/
			if(CSessionManager::IsError() && CSessionManager::GetErrorMsg()!="")
			{			
				echo"<span style=\"color:red\">".CSessionManager::GetErrorMsg(). "</span>";
			}
			CSessionManager::ResetErrorMsg();
			?>
			
			<TABLE ALIGN="CENTER" border="1">
				<TR>
					<TD>Email : </TD>
					<TD><INPUT ID="USERNAME" TYPE="text" NAME="email"/></TD>
				</TR>
				<TR>
					<TD>Password : </TD>
					<TD><INPUT ID="PASSWORD" TYPE="password" NAME="password"></TD>
				</TR>
			</TABLE>
			<TABLE ALIGN="CENTER">
				<TR>
					<TD><INPUT TYPE="submit" VALUE="    Login    "></TD>
				</TR>
			</TABLE>
			<hr/>
			<center>OR</center>
			<Table ALIGN="CENTER">
			<tr>
				<td>
					<!--<input type="submit" name="googlelogin" style="border-style:none; width:130 ;background-image: url('../images/google_login.png'); background-color:Transparent;" value=""></TD>-->
					<A href='http://beta.mgoos.com/login/dope_openid/login.php?from=1' target="_top"><img src="../images/google_login.png" width="130" height="22" border="0" alt=""></A></TD>
			<TR><TD></TD></TR>
					<TD><A href='http://beta.mgoos.com/lib/FBConnect/fbgetuserinfo.php' target="_top"><img src="../images/facebook_login.gif" width="154" height="22" border="0" alt=""></A></TD>
				</TR>
			</table> 
			<hr/>
			</FORM>
		
		
			
		
	</BODY>
</HTML>