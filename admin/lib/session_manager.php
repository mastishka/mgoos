<?php
	include_once("session.php") ;
	
	class CSessionManager
	{
		// - - - - - - - - - - -
		// Referring constants.
		// - - - - - - - - - - -
		const REF_FROM_NONE					=-1 ; // Reset Reffered From
		const REF_FROM_INDEX_PHP 			= 0 ; // Referred from index.php
		const REF_FROM_MY_MGOOG_PHP 		= 1 ; // Referred from my_mgoos.php
		const REF_FROM_PLAYME_PHP 			= 2 ; // Referred from playme.php
		const REF_FROM_TSR_PHP 				= 3 ; // Referred from tab_search_results.php
		const REF_FROM_LOAD_POPULAR			= 4 ; // Referred from load_popular.php
		const REF_FROM_BROWSE_ALBUM			= 5 ; // Referred from browse_album.php
		const REF_FROM_RECENT_UPLOADS 		= 6 ; // Referred from recent_uploads.php
		const REF_FROM_LAST_WEEK_POPULAR	= 7 ; // Referred from last_week_popular.php
		
		const REF_DATA_MP3_ID		= "ref_mp3_id" ;
		// - - - - - - - - -
		
		// - - - - - - - - - -
		// COMMAND constants.
		// - - - - - - - - - -
		const COMMAND_NONE			= 0 ; // No command
		const COMMAND_PLAY_FIRST 	= 1 ; // Play first element from search results.
		// - - - - - - - - - -
		
		/*
		 * Constructor.
		 */
		public function __construct()
		{
			
		}
		
		/*
		 * Destructor.
		 */
		public function __destruct()
		{
			
		}
		
		/*
		 * Set User ID into Session.
		 */
		static function SetUserId($id)
		{
			CSession::SetSessionData("UserID", $id) ;
		}
		
		/*
		 * Get User ID from Session.
		 */
		static function GetUserId()
		{
			return CSession::GetSessionData("UserID") ;
		}
		
		/*
		 * Set 'Referred From' into Session.
		 */
		static function SetReferredFrom($page_id)
		{
			CSession::SetSessionData("RefFrom", $page_id) ;
		}
		
		/*
		 * Get 'Referred From' from Session.
		 */
		static function GetReferredFrom()
		{
			return CSession::GetSessionData("RefFrom") ;
		}
		
		/*
		 * Reset 'Referred From' to NONE into the Session.
		 */
		static function ResetRefferedFrom()
		{
			CSession::SetSessionData("RefFrom",CSessionManager::REF_FROM_NONE);
		}
		
		/*
		 * Set 'Command' into Session.
		 */
		static function SetCommand($command_id)
		{
			CSession::SetSessionData("Command", $command_id) ;
		}
		
		/*
		 * Get 'Command' from Session.
		 */
		static function GetCommand()
		{
			return CSession::GetSessionData("Command") ;
		}
		
		/*
		 * Reset 'Command' into Session.
		 */
		static function ResetCommand()
		{
			CSessionManager::SetCommand(CSessionManager::COMMAND_NONE) ;
		}
		
		/*
		 * Set 'Referred Data' into Session.
		 * $data should be in query string form  e.g. 'id=12345678&name=manish+arora',
		 * when retreiving the referred data, should use parse_str() to parse the string.
		 */
		static function SetReferredData($data)
		{
			CSession::SetSessionData("RefData", $data) ;
		}
		
		/*
		 * Get 'Referred Data' from Session.
		 * when retreiving the referred data, should use parse_str() to parse the string.
		 */
		static function GetReferredData()
		{
			return CSession::GetSessionData("RefData") ;
		}
		
		/*
		 * Returns Login Status.
		 */
		static function IsLoggedIn()
		{
			return CSession::GetSessionData("Login") ;
		}
		
		/*
		 * Set Login Status into Session.
		 */
		static function SetLoggedIn($value)
		{
			CSession::SetSessionData("Login", $value) ;
		}
		
		/*
		 * Logout from this session.
		 */
		static function Logout()
		{
			// Unset all of the session variables.
			session_unset();
			// Finally, destroy the session.
			session_destroy();
		}

		/*
		 * Set Email ID into Session.
		 */
		static function SetEmailId($email)
		{
			CSession::SetSessionData("EmailID", $email) ;
		}
		
		/*
		 * Get Email ID from Session.
		 */
		static function GetEmailId()
		{
			return CSession::GetSessionData("EmailID") ;
		}

		/*
		 * Set Error into Session.
		 */
		static function SetErrorMsg($err_msg)
		{
			CSessionManager::SetError(true);
			CSession::SetSessionData("ErrMsg", $err_msg) ;
		}
		static function SetErrorType($err_type)
		{
			CSession::SetSessionData("ErrType",$err_type);
		}
		static function GetErrorType()
		{
			CSession::GetSessionData("ErrType");
		}		
		/*
		 * Get Error from Session.
		 */
		static function GetErrorMsg()
		{
			return CSession::GetSessionData("ErrMsg") ;
		}
		/*
		 * Set Error from Session (true or false).
		 */
		static function SetError($value)
		{
			CSession::SetSessionData("Error", $value) ;
		}
		/*
		 * Set IsError into Session.
		 */
		static function IsError()
		{
			return CSession::GetSessionData("Error") ;
		}		
		static function ResetErrorMsg()
		{
			CSessionManager::SetError(false);
			CSessionManager::SetErrorMsg("");
		}
	}
?>