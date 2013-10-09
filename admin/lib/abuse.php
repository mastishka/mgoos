<?php
	class CAbuse
	{
		const FIELD_TICKET_ID	= "ticket_id" ;
		const FIELD_EMAIL		= "email" ;
		const FIELD_MP3_ID		= "mp3_id" ;
		const FIELD_ABUSE_TYPE	= "abuse_type" ; // Over 18 : 0, Copyright : 1
		const FIELD_COMMENTS	= "comments" ;
		const FIELD_STATUS		= "status" ; // Open : 0, Close : 1
		
		private $ticket_id ;
		private $email ;
		private $mp3_id ;
		private $abuse_type ;
		private $comments ;
		private $status ;
		
		/*
		 * Returns the Abuse Ticket ID.
		 */
		public function GetTicketID()
		{
			return $this->ticket_id ;
		}
		/*
		 * Sets the Abuse Ticket ID.
		 */
		public function SetTicketID($ticket_id)
		{
			$this->ticket_id = $ticket_id ;
		}
		
		/*
		 * Returns the Reporter Email.
		 */
		public function GetEmail()
		{
			return $this->email ;
		}
		/*
		 * Sets the Abuse Ticket ID.
		 */
		public function SetEmail($email)
		{
			$this->email = $email;
		}
		
		/*
		 * Returns abused mp3_id.
		 */
		public function GetMp3ID()
		{
			return $this->mp3_id ;
		}
		/*
		 * Sets the Abused mp3_id.
		 */
		public function SetMp3ID($mp3_id)
		{
			$this->mp3_id = $mp3_id ;
		}
		
		/*
		 * Returns type of abuse.
		 */
		public function GetAbuseType()
		{
			return $this->abuse_type ;
		}
		/*
		 * Sets the type of abuse.
		 */
		public function SetAbuseType($abuse_type)
		{
			$this->abuse_type = $abuse_type ;
		}
		
		/*
		 * Returns reporter's comments.
		 */
		public function GetComments()
		{
			return $this->comments ;
		}
		/*
		 * Sets reporter's comments.
		 */
		public function SetComments($comments)
		{
			$this->comments = $comments ;
		}
		
		/*
		 * Returns action status.
		 */
		public function GetStatus()
		{
			return $this->status ;
		}
		/*
		 * Sets action status.
		 */
		public function SetStatus($status)
		{
			$this->status = $status ;
		}
	}
?>