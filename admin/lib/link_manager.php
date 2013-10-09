<?php
include("mp3.php");
include("nonmp3.php");
//include_once("../database/config.php");
class CLinkManager
{
		
		
		private $db_link_id;
		private $mp3_count;
		private $nonmp3_count;
		public function __construct()
		{
			// Server Name, UserName, Password, Database Name		
			$this->db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
			mysql_select_db(CConfig::DB_AUDIO, $this->db_link_id);
			$this->mp3_count=0;
			$this->nonmp3_count=0;
		}
		public function __destruct()
		{
			mysql_close($this->db_link_id) ;
		}
		public function InsertMp3Url($mp3_obj)
		{
			$url=$mp3_obj->GetUrl();
			$status=$mp3_obj->GetStatus();
			$source=$mp3_obj->GetSource();
			mysql_query("insert ignore into crawled_mp3_urls values('$url',$status,'$source')");
			if(mysql_affected_rows($db_link_id) > 0)
			{
				$this->mp3_count++;
			}
			return $this->mp3_count++;

		}
		public function InsertNonMp3Url($nonmp3_obj)
		{
			$url=$nonmp3_obj->GetUrl();
			$status=$nonmp3_obj->GetStatus();
			$count=$nonmp3_obj->GetCount();
			mysql_query("insert ignore into crawled_nonmp3_urls values('$url',$status)");
			if(mysql_affected_rows($db_link_id) > 0)
			{
				$this->nonmp3_count++;
			}
			return $this->nonmp3_count++;
		}
		
}
?>