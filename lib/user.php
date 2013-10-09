<?php 
	Class CUser
	{
		// Const Members.
		const FIELD_USER_ID 		= "user_id" ;
		const FIELD_FIRST_NAME 		= "firstname" ;
		const FIELD_LAST_NAME	 	= "lastname" ;
		const FIELD_PASSWORD 		= "passwd" ;
		const FIELD_EMAIL 			= "email" ;
		const FIELD_GENDER			= "gender" ;
		const FIELD_CITY			= "city" ;
		const FIELD_STATE			= "state" ;
		const FIELD_COUNTRY			= "country" ;
		const FIELD_DOB				= "dob" ;
		const FIELD_SECURITY_QUES 	= "security_ques" ;
		const FIELD_SECURITY_ANS	= "security_ans" ;
		const FIELD_SIGNUP_DATE		= "signup_date" ;
		const FIELD_REG_STATUS		= "reg_status" ;
		const FIELD_ONLINE			= "online" ;
		
		// Class Members.
		private $user_id ;
		private $first_name ;
  		private $last_name ;
  		private $password ;
  		private $email ;
  		private $gender ;
  		private $city ;
  		private $state ;
  		private $country ;
  		private $dob ;
  		private $security_question ;
  		private $security_answer ;
  		private $signup_date ;
  		private $reg_status ;
  		private $online ;
	    
		function __construct()
		{
			
		}
		public function __destruct()
		{
			
		}
		
	    public function GetUserID()
	    {
			return $this->user_id ;
	    }
	    public function SetUserID($user_id)
	    {
	    	$this->user_id = $user_id;
	    }
		
	    public function GetFirstName()
	    {	    	
	    	return $this->first_name ;
	    }
		public function SetFirstName($first_name)
		{
			$this->first_name = $first_name ;
		}
		
		public function GetLastName()
	    {	    	
	    	return $this->last_name ;
	    }
		public function SetLastName($last_name)
		{
			$this->last_name = $last_name ;
		}
		
	    public function GetPassword()
	    {
	    	return $this->password ;
	    }
	    public function SetPassword($password)
	    {
	    	$this->password = $password ;
	    }
	    
	    public function GetEmail()
	    {
	    	return $this->email ;
	    }
	    public function SetEmail($email)
	    {
	    	$this->email = $email ;
	    }
	    
	    public function GetGender()
	    {
	    	return $this->gender ;
	    }
	    public function SetGender($gender)
	    {
	    	$this->gender = $gender ;
	    }
	    
	    public function GetCity()
	    {
	    	return $this->city ;
	    }
	    public function SetCity($city)
	    {
			$this->city = $city ;
	    }
	    
  		public function GetState()
  		{
  			return $this->state ;
  		}
  		public function SetState($state)
  		{
  			$this->state = $state ;
  		}
  		
  		public function GetCountry()
  		{
  			return $this->country ;
  		}
  		public function SetCountry($country)
  		{
  			$this->country = $country ;
  		}
  		
  		public function GetDOB()
  		{
  			return $this->dob ;
  		}
  		public function SetDOB($dob)
  		{
  			$this->dob = $dob ;
  		}
  		
  		public function GetSecQues()
  		{
  			return $this->security_question ;
  		}
  		public function SetSecQues($security_question)
  		{
			$this->security_question = $security_question ;
  		}
  		
  		public function GetSecAns()
  		{
  			return $this->security_answer ;
  		}
  		public function SetSecAns($security_answer)
  		{
			$this->security_answer = $security_answer ;
  		}
	    
	    public function GetSignupDate()
	    {
	    	return $this->signup_date ;
	    }
	    public function SetSignupDate($signup_date)
	    {
	    	$this->signup_date = $signup_date;
	    }
	    
	    public function GetRegStatus()
	    {
	    	return $this->reg_status ;
	    }
	    public function SetRegStatus($reg_status)
	    {
	    	$this->reg_status = $reg_status ;
	    }
	    
	    public function GetOnline()
	    {
	    	return $this->online ;
	    }
	    public function SetOnline($online)
	    {
	    	$this->online = $online ;
	    }
	}
?>