<?php
	include_once("user.php") ;
	
	class CUserManager
	{
		private $db_link_id ;
		
		public function __construct()
		{
			// Server Name, UserName, Password, Database Name		
			$this->db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or
				    die("Could not connect: " . mysql_error());
			mysql_select_db(CConfig::DB_AUDIO, $this->db_link_id);
		}
		
		public function __destruct()
		{
			mysql_close($this->db_link_id) ;
		}
		
		public function GetUserById($id)
		{
			$objUser = new CUser() ;
			
			$result = mysql_query("select * from users where ".CUser::FIELD_USER_ID."='".$id."';", $this->db_link_id) or die("Get User Info Error: ".mysql_error($this->db_link_id)) ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$objUser->SetCity($row[CUser::FIELD_CITY]) ;
				$objUser->SetCountry($row[CUser::FIELD_COUNTRY ]) ;
				$objUser->SetDOB($row[CUser::FIELD_DOB]) ;
				$objUser->SetEmail($row[CUser::FIELD_EMAIL]) ;
				$objUser->SetFirstName($row[CUser::FIELD_FIRST_NAME]) ;
				$objUser->SetLastName($row[CUser::FIELD_LAST_NAME]) ;
				$objUser->SetGender($row[CUser::FIELD_GENDER]) ;
				$objUser->SetPassword($row[CUser::FIELD_PASSWORD]) ;
				$objUser->SetRegStatus($row[CUser::FIELD_REG_STATUS]) ;
				$objUser->SetSecAns($row[CUser::FIELD_SECURITY_ANS]) ;
				$objUser->SetSecQues($row[CUser::FIELD_SECURITY_QUES]) ;
				$objUser->SetSignupDate($row[CUser::FIELD_SIGNUP_DATE]) ;
				$objUser->SetState($row[CUser::FIELD_STATE]) ;
				$objUser->SetUserID($row[CUser::FIELD_USER_ID]) ;
			}
			mysql_free_result($result) ;
			
			return $objUser ;
		}
		
		public function GetUserByEmail($email)
		{
			$objUser = new CUser() ;
			
			$result = mysql_query("select * from users where ".CUser::FIELD_EMAIL."='".$email."';", $this->db_link_id) or die("Get User Info Error: ".mysql_error($this->db_link_id)) ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$objUser->SetCity($row[CUser::FIELD_CITY]) ;
				$objUser->SetCountry($row[CUser::FIELD_COUNTRY ]) ;
				$objUser->SetDOB($row[CUser::FIELD_DOB]) ;
				$objUser->SetEmail($row[CUser::FIELD_EMAIL]) ;
				$objUser->SetFirstName($row[CUser::FIELD_FIRST_NAME]) ;
				$objUser->SetLastName($row[CUser::FIELD_LAST_NAME]) ;
				$objUser->SetGender($row[CUser::FIELD_GENDER]) ;
				$objUser->SetPassword($row[CUser::FIELD_PASSWORD]) ;
				$objUser->SetRegStatus($row[CUser::FIELD_REG_STATUS]) ;
				$objUser->SetSecAns($row[CUser::FIELD_SECURITY_ANS]) ;
				$objUser->SetSecQues($row[CUser::FIELD_SECURITY_QUES]) ;
				$objUser->SetSignupDate($row[CUser::FIELD_SIGNUP_DATE]) ;
				$objUser->SetState($row[CUser::FIELD_STATE]) ;
				$objUser->SetUserID($row[CUser::FIELD_USER_ID]) ;
			}
			mysql_free_result($result) ;
			
			return $objUser ;
		}
		
		public function GetFieldValueByID($id, $field)
		{
			$value = "" ;
			$result = mysql_query("select ".$field." from users where id='".$id."';", $this->db_link_id) or die("Get User Info Error: ".mysql_error($this->db_link_id)) ;
			
			if(mysql_num_rows($result) == 1)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$value = $row[$field] ;
			}
			mysql_free_result($result) ;
			
			return $value ;
		}
		
		public function GetFieldValueByEmail($email, $field)
		{
			$value = "" ;
			$result = mysql_query("select ".$field." from users where ".CUser::FIELD_EMAIL."='".$email."';", $this->db_link_id) or die("Get User Info Error: ".mysql_error($this->db_link_id)) ;
			
			if(mysql_num_rows($result) == 1)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$value = $row[$field] ;
			}
			mysql_free_result($result) ;
			
			return $value ;
		}
		
		/*
		  return value = 0 --> invalid password
		  return value = 1 -->  password is right but user has not activated account through email link.
		  return value = 2 --> successful login		  
		  
		*/
		public function VerifyUser($email, $password)
		{
			$bResult = 0;
			$val_pass = $this->GetFieldValueByEmail($email, "passwd") ;
			$val_reg_status = $this->GetFieldValueByEmail($email, "reg_status") ;
			if(strcasecmp(md5($password), $val_pass) == 0)
			{
				if($val_reg_status == 1)
					$bResult = 2;
				else
					 $bResult = 1;
			}
			return $bResult ;
		}
		
		/*public function VerifyUser($email, $password)
		{
			$bResult = false ;
			$val_pass = $this->GetFieldValueByEmail($email, "passwd") ;
			
			if(strcasecmp(md5($password), $val_pass) == 0)
			{
				$bResult = true ;
			}
			
			return $bResult ;
		}*/
		
		public function AddUser(CUser $objUser)
		{
			$bResult = false ;
			
			$user_id = CUtils::uuid() ;
			$query = sprintf("INSERT INTO users(".CUser::FIELD_USER_ID.", ".CUser::FIELD_FIRST_NAME.", ".CUser::FIELD_LAST_NAME.", ".CUser::FIELD_PASSWORD.", ".CUser::FIELD_EMAIL.", ".CUser::FIELD_GENDER.", ".CUser::FIELD_CITY.", ".CUser::FIELD_STATE.", ".CUser::FIELD_COUNTRY.", ".CUser::FIELD_DOB.", ".CUser::FIELD_SECURITY_QUES .", ".CUser::FIELD_SECURITY_ANS.") VALUES('%s','%s','%s','%s','%s','%d','%s','%s','%s','%s','%s','%s') ;", 
							$user_id, $objUser->GetFirstName(), $objUser->GetLastName(), md5($objUser->GetPassword()), $objUser->GetEmail(), $objUser->GetGender(), $objUser->GetCity(), $objUser->GetState(), $objUser->GetCountry(), $objUser->GetDOB(), $objUser->GetSecQues(), $objUser->GetSecAns()) ;
			
			$result = mysql_query($query, $this->db_link_id) or die("Insert User Info Error: ".mysql_error($this->db_link_id)) ;
			if(mysql_affected_rows($this->db_link_id) > 0)
			{
				$bResult = true ;
			}
			
			return $bResult ;
		}
		
		public function IsUserExists($email)
		{
			$bResult = false ;
			
			$query = sprintf("select * from users where ".CUser::FIELD_EMAIL."='".$email."' ;") ;
			$result = mysql_query($query, $this->db_link_id) or die("Search For Duplicate Email Error: ".mysql_error($this->db_link_id)) ;
						
			if (mysql_num_rows($result) > 0)
			{
				$bResult = true ;
			}
			
			return $bResult ;
		}
		
		public function UpdatePassword($email,$password)
		{
			$bResult = false ;
			
			$query = sprintf("update users set ".CUser::FIELD_PASSWORD."='".md5($password)."' where ".CUser::FIELD_EMAIL."='%s' ;", $email) ;
			
			$result = mysql_query($query, $this->db_link_id) or die("Search For Duplicate Email Error: ".mysql_error($this->db_link_id)) ;
			
			if (mysql_affected_rows($this->db_link_id))
			{
				$query = sprintf("update users set ".CUser::FIELD_REG_STATUS."=0 where ".CUser::FIELD_EMAIL."='%s' ;", $email) ;
				$result = mysql_query($query, $this->db_link_id) or die("Search For Duplicate Email Error: ".mysql_error($this->db_link_id)) ;
				$bResult = true ;
			}
			
			return $bResult ;
		}

		public function SetOnline($id)
		{
			$loginResult= false;
			
			$query = sprintf("update users set ".CUser::FIELD_ONLINE."= 1 where ".CUser::FIELD_USER_ID ."='%s';", $id);

			$result = mysql_query($query,$this->db_link_id) or die ("Error during setting field online:".mysql_error($this->db_link_id));

			if(mysql_affected_rows($this->db_link_id))
			{
				$loginResult = true;
			}
			
			return $loginResult;
		}
		
		public function ResetOnline($id)
		{
			$loginResult= false;

			$query = sprintf("update users set ".CUser::FIELD_ONLINE."= 0 where ".CUser::FIELD_USER_ID."='%s';", $id);

			$result = mysql_query($query,$this->db_link_id) or die ("Error during setting field online:".mysql_error($this->db_link_id));

			if(mysql_affected_rows($this->db_link_id))
			{
				$loginResult = true;
			}
			
			return $loginResult;
		}

		public function ListCountryOption()
		{
			$query  = "select * from countries order by name;";
			$result = mysql_query($query)or die("query fail");
			printf(" <option value=\"91\" selected=\"selected\">India</option> ");
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{	
				printf("<option value=\"%d\">%s</option>", $row["code"], $row["name"]);
			}
			mysql_free_result($result) ;
		}

		public function ListDateOption()
		{
			for($index = 1; $index <= 31; $index++)
			{	
				printf("<option value=\"%02d\">%d</option>", $index, $index);
			}
		}

		public function ListYearOption()
		{
			$year = date("Y");
			$year =$year-18;
		
			for($count=1;$count<=80;$count++)
			{
				printf("<option value=\"%d\">%d</option>",$year,$year);
				$year--;
			}
		}
		
		public function GetUsersLoginCount()
		{
			$count = 0 ;
			
			$result = mysql_query("select count(*) as count from users where online='1';", $this->db_link_id) or die("Get Users Login Count: ".mysql_error($this->db_link_id)) ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$count = $row["count"] ;
			}
			mysql_free_result($result) ;
			
			return $count ;
		}
		
		public function ActivateAccount($md5_email)
		{
			$ret_val = '' ;
			$query = sprintf("select %s from users where md5(email)='%s';", CUser::FIELD_USER_ID, $md5_email);
			
			$result = mysql_query($query);
			
			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				
				mysql_query("update users set reg_status = 1 where user_id='".$row["user_id"]."' ;");
				$ret_val = $row["user_id"];
			}
			else 
			{
				$ret_val = false ;
			}
			
			return $ret_val;
		}
		
		public function Update_GenInfo($user_id, CUser $objCUser)
		{
		   $updateresult = false;
		   $query = sprintf("update users set firstname = '%s', lastname ='%s', city = '%s', state = '%s',country = '%s' where user_id = '%s'",$objCUser->GetFirstName(),$objCUser->GetLastName(),$objCUser->GetCity(),$objCUser->GetState(),$objCUser->GetCountry(),$user_id);
		   $result = mysql_query($query,$this->db_link_id) or die ("Error during updation :".mysql_error($this->db_link_id));
		   if(mysql_affected_rows($this->db_link_id))
		   {
		  	 $updateresult  = true;
		   }
		   return $updateresult ;
		}
	public function  Update_SecInfo($user_id,$objCUser,$oldpw)
		{
		   $updateresult = 0;
           $sqlquery = sprintf("select security_ques, security_ans,passwd from users where user_id = '%s'", $user_id);
		   $result = mysql_query($sqlquery, $this->db_link_id) or die ("Error during updation :".mysql_error($this->db_link_id));
		   $row = mysql_fetch_array($result, MYSQL_ASSOC);
		   $secQuestion = $row["security_ques"];
		   $secAns = $row["security_ans"];		   
		   $password = $row["passwd"];		  
		   if(md5($oldpw)!= $password)
		   {
		   		$updateresult = 1;
				return $updateresult;
		   }
		   /*$sa = $objCUser->GetSecAns();
		   $sa = mb_convert_case($sa, MB_CASE_UPPER, "UTF-8");
		   $secAns = mb_convert_case($secAns, MB_CASE_UPPER, "UTF-8");		   
		   if($secAns != $sa)
		   {
		     return $updateresult;
		   }*/
 	
		   //$query = sprintf("update users set passwd = '%s' where security_ques = '%s' and security_ans = '%s'  and user_id = '%s' ",md5($objCUser->GetPassword()),$secQuestion,$secAns,$user_id);
		   $query = sprintf("update users set passwd = '%s' where user_id = '%s' ",md5($objCUser->GetPassword()),$user_id);		   
		   $result = mysql_query($query,$this->db_link_id) or die ("Error during updation :".mysql_error($this->db_link_id));
		   if(mysql_affected_rows($this->db_link_id))
		   {
		  	 $updateresult = 2;
		   }
		   return $updateresult ;
		}		
	public static function GetCountryText($country_id)
		{
		  $ret_val = '' ;
		  $query = sprintf("select name from countries where code = '%s'",$country_id);
		  $result = mysql_query($query);//,$this->db_link_id) or die ("Error during getting country name :".mysql_error($this->db_link_id));
		  $row = mysql_fetch_array($result,MYSQL_ASSOC);
		  $ret_val  =  $row["name"];
			return $ret_val; 
		}
	}
?>