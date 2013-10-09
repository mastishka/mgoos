<?php
	include_once("../database/config.php") ;
	include_once("../lib/utils.php") ;
	include_once("../lib/abuse.php") ;
	
	class CAbuseManager
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
			// Using mysql_close() isn't usually necessary, 
			// as non-persistent open links are automatically closed at the end of the script's execution.
			
			/*
			mysql_close($this->db_link_id) ;
			*/
		}
		
		public function ReportAbuse($user_email, $aud_id, $abuse_type, $comments)
		{
			$ticket_id = CUtils::uuid() ;
			
			$query = sprintf("insert into abuse (%s,%s,%s,%s,%s) values('%s','%s','%s','%s','%s') ;", 
							CAbuse::FIELD_TICKET_ID, CAbuse::FIELD_MP3_ID, CAbuse::FIELD_EMAIL, CAbuse::FIELD_ABUSE_TYPE, CAbuse::FIELD_COMMENTS,
							$ticket_id, $aud_id, $user_email, $abuse_type, $comments) ;
			// Fire Insert Query.
			mysql_query($query) ;
			
			return $ticket_id ;
		}
	}
?>