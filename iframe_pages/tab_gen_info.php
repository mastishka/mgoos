<?php
	include_once("../lib/session_manager.php");
	include_once("../database/config.php");
	include_once("../lib/user_manager.php");
	if(CSessionManager::IsError() && CSessionManager::GetErrorMsg()!='')
	{
		echo"error during loading page".CSessionManager::GetErrorMsg();
	}
	/*if(CSessionManager::IsError())
	{
		echo"error during loading page".CSessionManager::GetErrorMsg();
	}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <HEAD>
  <TITLE> New Document </TITLE>
  <META NAME="Generator" CONTENT="EditPlus">
  <META NAME="Author" CONTENT="">
  <META NAME="Keywords" CONTENT="">
  <META NAME="Description" CONTENT="">
<SCRIPT LANGUAGE="JavaScript">
	<!--
		function CheckForEmpty(obj)
			{
				var bResult = false ;
				
				var style_cr = document.getElementById(obj.name+"_CR").style ;
				var style_wr = document.getElementById(obj.name+"_WR").style ;
				
				if(obj.value == '')
				{	
					style_cr.display = "none" ;
					style_wr.display = "inline" ;

					bResult = true ;
				}
				else
				{
					style_cr.display = "inline" ;
					style_wr.display = "none" ;
				}
				return bResult;
			}
		function onEdit()
		{			
			var bResult=false;			
			var obj1 = document.getElementById("SHOW").style;
			var obj2 = document.getElementById("SHOW2").style;
			var objButton1 = document.getElementById("BUT1").style;
			var objButton2 = document.getElementById("BUT2").style
			var objButton3 = document.getElementById("BUT3").style;
			if(obj1.display=="block")
			{
				obj1.display="none";
				obj2.display="inline";
				objButton1.display = "none";
				objButton2.display ="inline";
				objButton3.display ="inline";
				bResult = true;
			}
 		}
		function validateUpdateForm(obj)
		{
			if(document.getElementById("FNAME").value=='')
			{
				CheckForEmpty(document.getElementById("FNAME"));
				document.UPDATE_PROFILE.FNAME.focus();
				return false;
			}
			if(document.getElementById("LNAME").value=='')
			{
				CheckForEmpty(document.getElementById("LNAME"));
				document.UPDATE_PROFILE.LNAME.focus();
				return false;
			}
			if(document.getElementById("CITY").value=='')
			{
				CheckForEmpty(document.getElementById("CITY"));
				document.UPDATE_PROFILE.CITY.focus();
				return false;
			}
			if(document.getElementById("STATE").value=='')
			{
				CheckForEmpty(document.getElementById("STATE"));
				document.UPDATE_PROFILE.STATE.focus();
				return false;
			}
			return true;
		}
		function Cancel()
			{						
				
				var obj1 =  document.getElementById("SHOW").style;
				var obj2 = document.getElementById("SHOW2").style;
				var objButton1 = document.getElementById("BUT1").style;
				var objButton2 = document.getElementById("BUT2").style;
				var objButton3 = document.getElementById("BUT3").style;				
				obj1.display = "block";
				objButton1.display = "inline";
				objButton2.display = "none";
				objButton3.display = "none";
				obj2.display ="none";			
			}
	//-->
	</SCRIPT>	
</HEAD>
<BODY>
  <?php
	/*if( isset($_session['errmsg_arr']) && is_array($_session['errmsg_arr']) && count($_session['errmsg_arr']) >0 ) {
		echo '<ul class="err">';
		foreach($_session['errmsg_arr'] as $msg) {
			echo '<li>',$msg,'</li>'; 
		}
		echo '</ul>';
		unset($_session['errmsg_arr']);
	}*/

	$email =  CSessionManager::GetEmailId();
	$UserM = new CUserManager();
	$objuser = $UserM->GetUserByEmail(strtolower($email));
	
?>
<FORM ID="UPDATE_PROFILE" NAME="UPDATE_PROFILE" METHOD="POST" ACTION="tab_gen_update.php">
<DIV ID="SHOW" STYLE="display:block">
  <TABLE WIDTH="100%" BORDER="0" ALIGN="CENTER" CELLPADDING="2" CELLSPACING="0">
	<TR>
		  <TD><B>First Name:</B></TD>
			<TD>
				<?php 
					echo($objuser->GetFirstName());
				?>
			<TD>
	</TR>
	<TR>
			<TD><B>Last Name:</B></TD>
			<TD>
				<?php
					echo($objuser->GetLastName()); 
				?>
	</TR>
	<TR>
		<TD><B>E-mail:</B></TD>
		<TD>
			<?php 
				echo($objuser->GetEmail());
			?>
		</TD>
	</TR>
	<TR>
		<TD><B>Gender:</B></TD>
		<TD>
			<?php 
				$gender = $objuser->GetGender();
				if($gender==1)
				{	
					printf("<B>	Male <B/>");
				}
				else
				{
					printf("<B>Female <B/>");
				}
			?>
		</TD>
	</TR>
	<TR>
		<TD><B>City:</B></TD>
		<TD>
			<?php 
				echo($objuser->GetCity());
			?>
		</TD>
	</TR>
	<TR>
		<TD><B>State:</B></TD>
    	<TD>
			<?php
				echo($objuser->GetState());
			?>
	</TR>
	<TR><TD><B>Country:</B></TD>
		<TD>
			<?php 
				echo($objuser->GetCountry());
			?>
		</TD>
	</TR>
	<TR>
		<TD><B>Birth Date:</B></TD>
		<TD>
			<?php 
				printf("<B>%s<B>",$objuser->GetDOB());
			?>
		</TD>
	</TR>
</TABLE>

</DIV>
<DIV ID="SHOW2" STYLE="display:none">
  <TABLE WIDTH="100%" BORDER="0" ALIGN="CENTER" CELLPADDING="2" CELLSPACING="0">

	<TR>
		<TD VALIGN="TOP"><B>First Name:</B></TD>
		<TD>
			<INPUT NAME="FNAME" TYPE="TEXT" VALUE =" <?php echo($objuser->GetFirstName()); ?>" CLASS="TEXTFIELD" ID="FNAME" ONBLUR ="CheckForEmpty(this);">&nbsp;&nbsp;
			<IMG ID="FNAME_CR" STYLE="display:none" SRC="../images/apply.png" 
			WIDTH="16" HEIGHT="16" BORDER="0" ALT="">
			<IMG ID="FNAME_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
		</TD>
	</TR>
	<TR>
	  <TD VALIGN="TOP"><B>Last Name:</B></TD>
		<TD>
			<INPUT NAME="LNAME" TYPE="TEXT" VALUE =" <?php echo($objuser->GetLastName()); ?>" CLASS="TEXTFIELD" ID="LNAME" ONBLUR ="CheckForEmpty(this);">&nbsp;&nbsp;<IMG ID="LNAME_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="LNAME_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
		</TD>
	</TR>
	<TR>
		<TD VALIGN="TOP"><B>E-mail:</B></TD>
		<TD> <?php echo($objuser->GetEmail()); ?> </TD>
			<!-- <TD>		
				<INPUT NAME="EMAIL1" TYPE="TEXT" VALUE="<?php echo($objuser->GetEmail()); ?>" CLASS="TEXTFIELD" ID="EMAIL1" ONBLUR ="CHECKFOREMPTY(THIS);">&nbsp;&nbsp;<IMG ID="FNAME_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="FNAME_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
			</TD> -->
	</TR> 
	<TR>
		<TD VALIGN="TOP"><B>Gender:</B></TD>
		<TD>
			<?php 
				$gender = $objuser->GetGender();
				if($gender==1)
				{	
					printf("<B>	Male <B/>");
				}
				else
				{
					printf("<B>Female <B/>");
				}
			?>	<BR/><BR/>
		</TD>
	</TR>
	<TR>
		<TD VALIGN="TOP"><B>City:</B></TD>
		<TD>
		<INPUT NAME="CITY" ID="CITY" TYPE="TEXT" VALUE="<?php echo($objuser->GetCity()); ?>"CLASS="TEXTFIELD"  ONBLUR ="CheckForEmpty(this);" >&nbsp;&nbsp;<IMG ID="CITY_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="CITY_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
		</TD>
	</TR>
	<TR>
		<TD VALIGN="TOP"><B>State:</B></TD>
		<TD>
			<INPUT NAME="STATE"  ID="STATE" TYPE="TEXT" VALUE ="<?php echo($objuser->GetState()); ?> "CLASS="TEXTFIELD" ONBLUR ="CheckForEmpty(this);">&nbsp;&nbsp;
			<IMG ID="STATE_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="">
			<IMG ID="STATE_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
		</TD>
	</TR>
	<TR>
		<TD VALIGN="TOP"><B>Country:</B></TD>
		<TD>
			<SELECT NAME="COUNTRY"  >
				<?php 
					$UserM->ListCountryOption();
				?>
			</SELECT>&nbsp;&nbsp;
			<IMG ID="COUNTRY_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT="">
			<IMG ID="COUNTRY_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
		</TD>
	</TR>
	<TR>
		<TD VALIGN="TOP"><B>Birth Date:</B></TD>
		<TD> <?php 
				printf("<B>%s<B>",$objuser->GetDOB());
			 ?>
		</TD>
	</TR>			
  </TABLE>
</DIV>
<DIV ID="BUT1" STYLE="display:block">
<TABLE>
	<TR>
	 <TD></TD>
     <TD>
		<INPUT ID="BUT" TYPE="BUTTON" onClick="onEdit();" VALUE="Edit">
	 </TD>	 
   </TR>
</TABLE>
</DIV>
<DIV ID="BUT2" STYLE="display:none">
<TABLE>
	<TR>
	<TD></TD>
	<TD>
	<INPUT ID="BUT2" TYPE="SUBMIT" VALUE="Update"
		onclick="return validateUpdateForm();">
	</TD>
	<TD>
		<INPUT ID="BUT3" TYPE="button" VALUE="Cancel" onClick="Cancel();" STYLE="display:none">
	</TD>
	</TR>
</TABLE>
</DIV>

</FORM>
</FIELDSET>
</BODY>
</HTML>

