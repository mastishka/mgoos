<?php
include_once("admin.php");
include_once("../../database/config.php");
class CAdminManager
	{
		private $db_link_id_admin ;
		
		public function __construct()
		{
			// Server Name, UserName, Password, Database Name		
			$this->db_link_id_admin = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD)or die("Could not connect: " . mysql_error());
			mysql_select_db("mgooscom_admin", $this->db_link_id_admin);
		}
		
		public function __destruct()
		{
			mysql_close($this->db_link_id_admin) ;
		}
		public function GetAdminByEmail($email)
		{
			$objAdmin = new CAdmin() ;
			$result = mysql_query("select * from administrators where ".CAdmin::FIELD_EMAIL."='".$email."';",$this->db_link_id_admin) or die("Get Admin Info Error: ".mysql_error($this->db_link_id_admin)) ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$objAdmin->SetFirstName($row[CAdmin::FIELD_FIRST_NAME]) ;
				$objAdmin->SetLastName($row[CAdmin::FIELD_LAST_NAME]) ;
				$objAdmin->SetEmail($row[CAdmin::FIELD_EMAIL]) ;
				$objAdmin->SetPassword($row[CAdmin::FIELD_PASSWORD]) ;
				$objAdmin->SetPrivilege($row[CAdmin::FIELD_PRIVILEGE]) ;
				$objAdmin->SetAdminId($row[CAdmin::FIELD_ADMIN_ID]) ;

				
			}
			mysql_free_result($result) ;
			
			return $objAdmin ;

		}

		public function GetAdminFieldValueByEmail($email,$field)
		{
			$value = "" ;
			$result = mysql_query("select ".$field." from administrators where ".CAdmin::FIELD_EMAIL."='".$email."';",$this->db_link_id_admin) or die("Get Admin Info Error: ".mysql_error($this->db_link_id_admin)) ;
			
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

		public function VerifyAdmin($email,$password)
		{
			$bResult = 0;
			$val_pass = $this->GetAdminFieldValueByEmail($email, "password") ;
			//$val_reg_status = $this->GetAdminFieldValueByEmail($email, "reg_status") ;
			if(strcasecmp(md5($password), $val_pass) == 0)
			{
				//if($val_reg_status == 1)
					$bResult = 2;
				//else
					 //$bResult = 1;
			}
			return $bResult ;

		}
	}
?>