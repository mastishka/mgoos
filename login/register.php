<?php
	include_once("../lib/session_manager.php");
	include_once("../database/config.php");
	include_once("../lib/user_manager.php");
    include_once("../lib/mgoos_config.php") ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<!-- Header -->
				<?php					     include_once(CMGooSConfig::MGOOS_ROOT."/lib/header.php?folder_level=1&page_id=".CMGooSConfig::HF_REGISTER_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
	</TABLE>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Login Form</title>
		<link rel="stylesheet" type="text/css" href="../css/mgoos.css" />
		<SCRIPT LANGUAGE="JavaScript">
		<!--
			function OnHide()
			{
				var objStyle = document.getElementById("MSG").style;
				if (objStyle.display== "block")
				{
					objStyle.display= "none";
				}
			}

			function ValidateUserForm()
			{
				if(document.getElementById("FNAME").value == '')
				{
					CheckForEmpty(document.getElementById("FNAME")) ;
					document.LOGINFORM.FNAME.focus() ;
					return false;
				}
				if(document.getElementById("LNAME").value == '')
				{
					CheckForEmpty(document.getElementById("LNAME")) ;
					document.LOGINFORM.LNAME.focus() ;
					return false;
				}
				if(document.getElementById("CITY").value == '')
				{
					CheckForEmpty(document.getElementById("CITY")) ;
					document.LOGINFORM.CITY.focus() ;
					return false;
				}
				if(document.getElementById("STATE").value == '')
				{
					CheckForEmpty(document.getElementById("STATE")) ;
					document.LOGINFORM.STATE.focus() ;
					return false;
				}
				if(document.getElementById("EMAIL").value == '')
				{
					CheckForEmpty(document.getElementById("EMAIL")) ;
					document.LOGINFORM.EMAIL.focus() ;
					return false;
				}
				if(document.getElementById("PASSWORD").value == '')
				{
					CheckForEmpty(document.getElementById("PASSWORD")) ;
					document.LOGINFORM.PASSWORD.focus() ;
					return false;
				}
				if(document.getElementById("CPASSWORD").value == '')
				{
					CheckForEmpty(document.getElementById("CPASSWORD")) ;
					document.LOGINFORM.CPASSWORD.focus() ;
					return false;
				}
				if(document.getElementById("QUESTION").value == '')
				{
					CheckForEmpty(document.getElementById("QUESTION")) ;
					document.LOGINFORM.QUESTION.focus() ;
					return false;
				}
				if(document.getElementById("ANSWER").value == '')
				{
					CheckForEmpty(document.getElementById("ANSWER")) ;
					document.LOGINFORM.ANSWER.focus() ;
					return false;
				}
				return true;
			}
			function ValidateEmail(obj) 
			{
				var bResult = false ;
				
				var style_cr = document.getElementById(obj.name+"_CR").style ;
				var style_wr = document.getElementById(obj.name+"_WR").style ;

				if((obj.value.indexOf(".") > 2) && (obj.value.indexOf("@") > 0))
				{
					style_cr.display = "inline" ;
					style_wr.display = "none" ;
					bResult = true ;
				}
				else
				{
					style_cr.display = "none" ;
					style_wr.display = "inline" ;
				}
				
				return bResult;
			}
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
			function CheckPass(obj)
			{
				var bResult = true;
				var style_cr = document.getElementById(obj.name+"_CR").style ;
				var style_wr = document.getElementById(obj.name+"_WR").style ;
				var objMsg = document.getElementById(obj.name+"_MSG") ;
				
				if(obj.value.length < 6)
				{
					style_cr.display = "none" ;
					style_wr.display = "inline" ;
					objMsg.color = "RED";
				}
				else
				{
					style_cr.display = "inline" ;
					style_wr.display = "none" ;
					objMsg.color = "BLUE";
				}
				return bResult ;
			}
			function ConfirmPass(obj)
			{
				var bResult = false;
				var pass_val = document.getElementById("PASSWORD").value ;
				var style_cr = document.getElementById(obj.name+"_CR").style ;
				var style_wr = document.getElementById(obj.name+"_WR").style ;
				
				if(pass_val.length >= 6 && pass_val == obj.value)
				{
					style_cr.display = "inline" ;
					style_wr.display = "none" ;
					
					bResult = true;
				}
				else
				{
					style_cr.display = "none" ;
					style_wr.display = "inline" ;
				}
				return bResult;
			}
		//-->
		</SCRIPT>
	</head>
	<body>
		<?php
			$objUM = new CUserManager() ;
			if(CSessionManager::IsError())
			{
				CSessionManager::SetError(false) ;
		?>
			<div id="MSG" style="display:block">
				<fieldset style="width:800px">
				<legend>Error Message</legend>	
					<?php 
						echo("<p>Error during registeration : ".CSessionManager::GetErrorMsg()."</p>");
					?>
				<INPUT TYPE="button" NAME="HIDE" value="Hide" onClick="OnHide();"/>
				</fieldset>
			</div>
		<?php
			}
		?>
		<fieldset style="width:800px">
		<legend><A class="anchor" HREF="../index.php"><IMG SRC="../images/mgoos_logo_s.jpg" WIDTH="148" HEIGHT="46" BORDER="0" ALT="Go to home page"></A></legend>
		<p>Welcome to MGooS user registration. Please fill the following details for being a part of musical wave.</p>
		<form id="LOGINFORM" name="LOGINFORM" method="POST" action="register-exec.php">
			<table width="800" border="0" align="center" cellpadding="2" cellspacing="0">
				<tr>
					<td><span class="boldfont">First Name :</span><BR/><BR/></td>
					<td><input name="FNAME" type="text" class="textfield" id="FNAME" onblur ="CheckForEmpty(this);" size="30" class="input"/>&nbsp;&nbsp;<IMG ID="FNAME_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="FNAME_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">Last Name :</span><BR/><BR/></td>
					<td><input name="LNAME" type="text" class="textfield" id="LNAME" onblur ="CheckForEmpty(this);" size="30" class="input"/>&nbsp;&nbsp;<IMG ID="LNAME_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="LNAME_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">Gender :</span><BR/><BR/></td>
					<td>
						Male<INPUT TYPE="radio"  NAME="GENDER" id="GENDER_MALE" value="1" CHECKED="checked"/>&nbsp;
						Female<INPUT TYPE="radio" NAME="GENDER" id ="GENDER_FEMALE" value="0"/><BR/><BR/>	
					</td>
				</tr>
				<tr>
					<td><span class="boldfont">Birth Day :</span><BR/><BR/></td>
					<td> 
						<select name="MONTH" id="MONTH">
							<option value="01" >January</option>
							<option value="02" >February</option>
							<option value="03" >March</option>
							<option value="04" >April</option>
							<option value="05" >May</option>
							<option value="06" >June</option>
							<option value="07" >July</option>
							<option value="08" >August</option>
							<option value="09" >September</option>
							<option value="10" >October</option>
							<option value="11" >November</option>
							<option value="12" >December</option>
						</select>			 
						<select name="DAY" id="DAY">
							<?php
								$objUM->ListDateOption() ;
							?>
						</select>
						<select name="BIRTHYEAR" id="BIRTHYEAR">
							<?php
								$objUM->ListYearOption() ;
							?>
						</select>&nbsp;&nbsp;<IMG ID="BIRTHDAY_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="BD_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
					</td>
				</tr>
				<tr>
					<td><span class="boldfont">City :</span><BR/><BR/></td>
					<td><input name="CITY" type="text" class="textfield" id="CITY" onblur ="CheckForEmpty(this);" />&nbsp;&nbsp;<IMG ID="CITY_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="CITY_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">State :</span><BR/><BR/></td>
					<td><input name="STATE" type="text" class="textfield" id="STATE" onblur ="CheckForEmpty(this);"/>&nbsp;&nbsp;<IMG ID="STATE_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="STATE_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">Country :</span><BR/><BR/></td>
					<td>
						<select name="COUNTRY" class="formText0" id="COUNTRY">
						<?php
							$objUM->ListCountryOption() ;
						?>
						</select>&nbsp;&nbsp;<IMG ID="COUNTRY_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="COUNTRY_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
					</td>
				</tr>
				<tr>
					<td><span class="boldfont">Email :</span><BR/><BR/></td>
					<td><input name="EMAIL" type="text" class="textfield" id="EMAIL" onblur ="ValidateEmail(this);" size="50"class="input" />&nbsp;&nbsp;<IMG ID="EMAIL_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="EMAIL_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">Password :</span><BR/><BR/></td>
					<td><input name="PASSWORD" type="password" id="PASSWORD" onblur ="CheckPass(this);" />&nbsp;&nbsp;<IMG ID="PASSWORD_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="PASSWORD_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/>
					<FONT ID="PASSWORD_MSG" SIZE="" ALIGN=\"CENTRE\" COLOR="BLUE">(Password Length Should be Greater Then Or Equal To 6 )</FONT><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">Confirm Password :</span><BR/><BR/></td>
					<td><input name="CPASSWORD" type="password" id="CPASSWORD" onblur ="ConfirmPass(this);" />&nbsp;&nbsp;<IMG ID="CPASSWORD_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="CPASSWORD_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
					<td><span class="boldfont">Security Question :</span><BR/><BR/></td>
					<td>
						<select name="QUESTION" onblur ="CheckForEmpty(this);">
							<option value="">--Select--</option>
							<option value="What is your pets name?">What is your pets name?</option>
							<option value="What was the name of your first school">What was the name of your first school?</option>
							<option value="Who was your childhood hero?">Who was your childhood hero?</option>
							<option value="What is your favorite pass-time?">What is your favorite pass-time?</option>
							<option value="What is your all-time favorite sports team?">What is your all-time favorite sports team?</option>
							<option value="What is your fathers middle name?">What is your fathers middle name?</option>
							<option value="What was your high school mascot?">What was your high school mascot?</option>
							<option value="What make was your first car or bike?">What make was your first car or bike?</option>
							<option value="Where did you first meet your spouse?">Where did you first meet your spouse?</option>
						</select>&nbsp;&nbsp;<IMG ID="QUESTION_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="QUESTION_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/>
					</td>
				</tr>
				<tr>
				  <td><span class="boldfont">Answer :</span><BR/><BR/></td>
				  <td><input name="ANSWER" type="text" class="textfield" id="answer" size="42" onblur ="CheckForEmpty(this);"/>&nbsp;&nbsp;<IMG ID="ANSWER_CR" STYLE="display:none" SRC="../images/apply.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><IMG ID="ANSWER_WR" STYLE="display:none" SRC="../images/cancel.png" WIDTH="16" HEIGHT="16" BORDER="0" ALT=""><BR/><BR/></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td><input type="submit" name="Submit" OnClick="return ValidateUserForm();" value="Register" /></td>
				</tr>
				<tr ALIGN="CENTER">
			    </tr>
			</table>
		</form>
		</fieldset>
        <TABLE WIDTH="100%" BORDER="0" CELLSPACING="0" CELLPADDING="0">
			<TR ALIGN="CENTER">
				<?php
                include_once(CMGooSConfig::MGOOS_ROOT."/lib/footer.php?folder_level=1&page_id=".CMGooSConfig::HF_REGISTER_ID."&login=".CSessionManager::IsLoggedIn());
				?>
			</TR>
			</TABLE>
	</body>
</html>
