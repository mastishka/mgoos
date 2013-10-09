<?php
	include_once("../lib/session_manager.php");
	include_once("../database/config.php");
	include_once("../lib/user_manager.php");
	if(CSessionManager::IsError() && CSessionManager::GetErrorMsg()!='')
	{
		echo"<span style=\"color:red\" >error during loading page".CSessionManager::GetErrorMsg(). "</span>";
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
 <BODY>
 <script language="javascript" type="text/javascript">
 function Back()
 {
 	window.location = "tab_gen_info.php";
 }
 </script>
  
 <?php
		$user_id = CSessionManager::GetUserId();
		$objUM = new CUserManager();
		$objCUser = new CUser();

		$fname	= ucwords ( rtrim ($_POST['FNAME'] ) ) ;
		$lname	= ucwords ( rtrim ($_POST['LNAME'] ) ) ;
		$city	= ucwords ( rtrim ($_POST['CITY'] ) ) ;	
		$state	= ucwords ( rtrim ($_POST['STATE'] ) ) ;
		/*$country= ucwords ( rtrim ($_POST['COUNTRY'] ) ) ;*/
		$country_id= ucwords ( rtrim ($_POST['COUNTRY'] ) ) ;
		$country = CUserManager::GetCountryText($country_id);

		$objCUser->SetFirstName($fname);
		$objCUser->SetLastName($lname);
		$objCUser->SetCity($city);
		$objCUser->SetState($state);
		$objCUser->SetCountry($country);

		$result = $objUM->Update_GenInfo($user_id,$objCUser);

		if ($result)
		{	
			$objCUser = $objUM->GetUserById($user_id);
			printf("<TABLE>");
			printf(" <TR><TD><span style=\"color:red\" >Dear user your profile has been updated </span></TD></TR>");
			printf("<TR>
				<TD><B>First Name:</B></TD>
				<TD>%s</TD>
				</TR>
				<TR>
				<TD><B>Last Name:</B></TD>
				<TD>
				%s 
				</TR>
				<TR>
				<TD><B>E-mail:</B></TD>
				<TD>
					%s
				</TD>
				</TR> ",$objCUser->GetFirstName(), $objCUser->GetLastName(), $objCUser->GetEmail());
			printf("<TR>
					<TD><B>Gender:</B></TD>");	
			$gender = $objCUser->GetGender();
				if($gender==1)
				{	
					printf("<TD><B>	Male <B/></TD>");
				}
				else
				{
					printf("<TD><B>Female <B/></TD></TR>");
				}
			printf("<TR>
					<TD><B>City:</B></TD>
					<TD>%s</TD>
					</TR>
					<TR>
					<TD><B>State:</B></TD>
			    	<TD>%s
					</TR>
					<TR><TD><B>Country:</B></TD>
					<TD>%s</TD>
					</TR>
					<TR>
					<TD><B>Birth Date:</B></TD>
					<TD>%s</TD>					</TR>",$objCUser->GetCity(),$objCUser->GetState(),$objCUser->GetCountry(),$objCUser->GetDOB());
		}	
		printf("<TABLE><TR>
			<TD>
				<INPUT ID='BUT1'  TYPE='button' VALUE= 'Back' onClick= 'Back();';>
			</TD>
		</TR>
</TABLE>");
		/*else
		{
			printf("Error during updation try again");
		}*/
 ?>


 </BODY>
</HTML>
