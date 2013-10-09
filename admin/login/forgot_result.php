<?php
	include_once("../lib/user_manager.php");
	include_once("../lib/utils.php");
	include_once("../database/config.php");

	$UserM = new  CUserManager;

	$email = "vimal_scs@yahoo.co.in" ;// $_POST['email'];
	$secans= $_POST['ans'];
	echo "email".$email;
	
	$objUser = $UserM->GetUserByEmail($email);
	
	$value = $UserM->GetFieldValueByEmail($email,"security_ans");

//	strcasecmp($secans,$value);

	echo ("<br>value is  ".$value) ;
	if (strcasecmp($secans, $value) == 0)//($obj->GetSecAns()==$secans)
	{
		printf("Well-come to mgoos %s %s",$objUser->GetFirstName(),$objUser->GetLastName());
		printf("Enter new password ");
		printf("<BR>
			<FORM METHOD=POST ACTION=\"forgot_done.php\">
			Password <INPUT TYPE=\"text\" NAME=\"password\">
			Confirm Password <INPUT TYPE=\"text\" NAME=\"cpassword\">
			<INPUT TYPE=\"submit\" value=\"submit\">
		</FORM>");
	}
	else
	{
		printf("Answer you provide does not match with our records <br> Plese Re-Enter the Answer");
		
		$objUser = $UserM->GetUserByEmail($email);
		
		printf("<FORM METHOD=POST ACTION=\"forgot_result.php\">	
		Security question:->\t\t%S ",$objUser->GetSecQues());
		
		printf("<BR>Enter the answer <INPUT TYPE=\"text\" NAME=\"ans\"> ");
		printf("<INPUT TYPE=\"submit\">");
		printf("</FORM>");
	}
?>