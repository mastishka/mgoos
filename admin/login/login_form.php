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
		</FORM>
	</BODY>
</HTML>