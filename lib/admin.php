<?php 
	Class CAdmin
	{
		// Const Members.
		const FIELD_EMAIL 		= "email" ;
		const FIELD_PASSWORD	= "password";
		const FIELD_FIRST_NAME	= "first_name";
		const FIELD_LAST_NAME	= "last_name";
		const FIELD_PRIVILEGE	= "privilege";
		const FIELD_ADMIN_ID    = "admin_id";

		//Class Members

		private $email;
		private $password;
		private $first_name;
		private $last_name;
		private $privilege;
		private $admin_id;
		
		function __construct()
		{
			
		}
		public function __destruct()
		{
			
		}
		public function GetAdminId()
	    {	    	
	    	return $this->admin_id ;
	    }
		public function SetAdminId($admin_id)
	    {	    	
	    	$this->admin_id = $admin_id ;
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
		public function GetPrivilege()
	    {
	    	return $this->privilege ;
	    }
	    public function SetPrivilege($privilege)
	    {
	    	$this->privilege = $privilege ;
	    }
	}
?>
