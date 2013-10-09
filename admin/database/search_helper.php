<?php
	//include("double_metaphone_class_1_01.php") ;
	class CSearchHelper
	{
		private $db_link_id ;
		
		public function __construct($database)
		{
			// Server Name, UserName, Password, Database Name		
			$this->db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or
				    die("Could not connect: " . mysql_error());
			mysql_select_db($database, $this->db_link_id);
		}
		
		public function __destruct()
		{
			// Using mysql_close() isn't usually necessary, 
			// as non-persistent open links are automatically closed at the end of the script's execution.
			
			/*
				mysql_close($this->db_link_id) ;
			*/
		}
		
		public function PrepareWildQuery($wordArray)
		{
			$metaphoneAry = array() ;
			$field_array = array("artist", "album", "title", "year", "genre", "composer", "picturizedon", "lyrics") ;
			
			$sqlQuery = "select mp3_info.id, mp3_info.artist, mp3_info.album, mp3_info.title, mp3_info.year, mp3_info.duration_sec, mp3_info.genre, mp3_info.composer, mp3_info.picturizedon, mp3_info.lyrics, (" ;
			$whereClause = "where (" ;
			$word_count = count($wordArray) * count($field_array) ;
			
			if(count($wordArray) > 0)
			{
				$word_index = 0 ;
				foreach($wordArray as $word)
				{
					$metaphoneAry[$word_index] = metaphone($word) ;
					
					$word_index++ ;
				}
				
				foreach($field_array as $field)
				{
					$word_index = 0 ;
					$metaphoneIfClause = "" ;
					$metaphoneWhereClause = "" ;
					
					/*foreach($wordArray as $word)
					{
						$metaphoneIfClause = "if(mp3_metaphone_info.title REGEXP '[[:<:]]".$word."[[:>:]]', 0, 1) AND (mp3_metaphone_info.title REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') ";
						$metaphoneWhereClause = "(mp3_metaphone_info.title REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;
						$word_index++ ;
					}*/
					
					foreach($wordArray as $word)
					{
						if($field != "year")
						{
							if($metaphoneAry[$word_index] == "'") /*hack for proper db query*/
							{
							$metaphoneAry[$word_index] ="";
							}
														
							 $sqlQuery .= "if(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' is null, 0, mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' )" ;
							 $whereClause .= "(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;							
						}
						else
						{
							
							if($wordArray[$word_index] == "'")
							{
							$wordArray[$word_index] = "";
							}							
							$sqlQuery .= "if(mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]' is null, 0, mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]' )" ;
							$whereClause .= "(mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]') " ;
							
						}
						$word_count-- ;
						//$word_index++ ;
						
						if($word_count > 0)
						{
							if($field == "title")
							{
								$sqlQuery .= "*8 + " ;
							}
							else if($field == "album")
							{
								$sqlQuery .= "*7 + " ;
							}
							else if($field == "artist")
							{
								$sqlQuery .= "*6 + " ;
							}
							else if($field == "lyrics")
							{
								$sqlQuery .= "*4 + " ;
							}
							else if($field == "picturizedon")
							{
								$sqlQuery .= "*3 + " ;
							}
							else if($field == "composer")
							{
								$sqlQuery .= "*2 + " ;
							}
							else
							{
								$sqlQuery .= " + " ;
							}														
							$whereClause .= " OR " ;							
						}
						else
						{
							$sqlQuery .= ") AS score from mp3_info, mp3_metaphone_info ".$whereClause.") AND (mp3_info.id = mp3_metaphone_info.id) GROUP BY mp3_info.id ORDER BY score DESC;" ;
						}
						$word_index++ ;
						
					}
				}
			}
			else
			{
				$sqlQuery = "select id, filepath, artist, album, title, year, time, genre, composer, lyrics from mp3_info order by title asc" ;
			}
			
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			// Index based query.
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			/*
			if(count($wordArray) > 0)
			{
				$sqlQuery = "select filepath, artist, album, title, year, time, genre, alt1, lyrics, MATCH(artist, album, title, year, genre, alt1, lyrics) AGAINST ('".$query."') AS score from id3_info where MATCH(artist, album, title, year, genre, alt1, lyrics) AGAINST ('".$query."') ORDER BY score DESC, title ASC;" ;
			}
			else
			{
				$sqlQuery = "select filepath, artist, album, title, year, time, genre, alt1, lyrics from id3_info order by title asc" ;
			}
			*/
			// - - - - - - - - - - - - - - - - - - - - - - - - - - -
			
			// - - - - - - - - - - - -
			// Debug Code
			// - - - - - - - - - - - -
			 //echo ($sqlQuery) ;
			// - - - - - - - - - - - -			
			
			return $sqlQuery ;
		}
		
		function PrepareFieldQuery($wordArray,$field)
		{
			$metaphoneAry = array();
			$field_array = array("artist", "album", "title", "year", "genre", "composer", "picturizedon", "lyrics") ;
			$sqlQuery = "select mp3_info.id, mp3_info.artist, mp3_info.album, mp3_info.title, mp3_info.year, mp3_info.duration_sec, mp3_info.genre, mp3_info.composer, mp3_info.picturizedon, mp3_info.lyrics, (" ;
			$whereClause = "where (";			
			$word_count = count($wordArray);
			if($word_count  > 0)
			{
				$word_index = 0 ;
				foreach($wordArray as $word)
				{
					$metaphoneAry[$word_index] = metaphone($word) ;					
					$word_index++ ;
				}
				$word_index = 0 ;																			
				foreach($wordArray as $word)
				{
					if($field != "year")
					{
					if($metaphoneAry[$word_index] == "'") /*hack for proper db query*/
					{
						$metaphoneAry[$word_index] ="";
					}
					
						$sqlQuery .= "if(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' is null, 0, mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' )" ;
						$whereClause .= "(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;
					}
					else
					{
						if($wordArray[$word_index] == "'") /*hack for proper db query*/
							{
							$wordArray[$word_index] = "";
							}
						$sqlQuery .= "if(mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]' is null, 0, mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]' )" ;
						$whereClause .= "(mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]') " ;
					}
					
					if($word_index < (count($wordArray)-1))
					{
						$sqlQuery .= " + " ;
						$whereClause .= " OR " ;
					}
					
					$word_index++ ;
				}
				$sqlQuery .= ") AS score from mp3_info, mp3_metaphone_info ".$whereClause.")  AND (mp3_info.id = mp3_metaphone_info.id) GROUP BY mp3_info.id order by score DESC;" ;
			}
			else
			{
				$sqlQuery = "select id, filepath, artist, album, title, year, time, genre, composer, lyrics from mp3_info order by title asc" ;
			}
			
			// - - - - - - - - - - - -
			// Debug Code
			// - - - - - - - - - - - -
			// echo ($sqlQuery) ;
			// - - - - - - - - - - - -			
			return $sqlQuery ;
		}
		
		public function browseAlbum($page, $user_id,$pageno)
		{
		
			/*$query = "select DISTINCT album, year, count(title) as count from mp3_info where album LIKE '".$page."%' group by album ;" ;
			$result = mysql_query($query, $this->db_link_id) ;
			$row_count = mysql_num_rows($result);*/															
			if(!isset($pageno))
			$pageno = 1;
					
			$pagesize = 10;
			$startoffset = $pagesize*($pageno -1);
			$endoffset = $startoffset + $pagesize;
			
			$query = "select DISTINCT album, year, count(title) as count from mp3_info where album LIKE '".$page."%' group by album ;" ;
			$result = mysql_query($query, $this->db_link_id) ;
			$row_count = mysql_num_rows($result);
			
			//$href = "iframe_pages/tab_search_results.php?browse_album=true&pg=A".$page."&pageno= ".$pageno.
			$href = "tab_search_results.php?browse_album=true&pg=" .$page."&"; 

			CUTils::PreparePaging($pageno,$row_count,$href,"",true);
				
			$query = "select DISTINCT album, year, count(title) as count from mp3_info where album LIKE '".$page."%' group by album LIMIT " .$startoffset. ",".$endoffset. ";" ;
			$result = mysql_query($query, $this->db_link_id) ;																		
			printf("<UL>");				
			
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				printf("<LI><B>Album :</B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A> &nbsp;&nbsp;<INPUT TYPE='button' VALUE =' Load Album' ID='APPEND' name='APPEND' OnClick =\"TSR.OnLoadAlbum('%s'); \"/>  <BR/><B>Year :</B> %s<BR/><B>Audio Files :</B> %s</LI><BR/>", urlencode($row["album"]), $row["album"],urlencode($row["album"]), $row["year"], $row["count"]) ;
			}
			printf("</UL>") ;
			
			mysql_free_result($result);
			return $row_count ;
			//return $count;
		}
		
		public function showRecentUploads($page, $user_id)
		{
			//$query = "select DISTINCT album, year, count(title) as count from mp3_info where MONTH(upload_date)=MONTH(NOW()) OR IF(MONTH(NOW())<>1, MONTH(upload_date)=MONTH(NOW())-1, YEAR(NOW())=YEAR(NOW()) -1 AND MONTH(upload_date)=12) group by album order by upload_date desc LIMIT ".(($page-1)*10).",".(($page*10)-1) ;
			$query = "select DISTINCT album, year, count(title) as count from mp3_info where MONTH(upload_date)=MONTH(NOW()) OR IF(MONTH(NOW())<>1, MONTH(upload_date)=MONTH(NOW())-1, YEAR(NOW())=YEAR(NOW()) -1 AND MONTH(upload_date)=12) group by album order by upload_date desc" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<LI><B>Album :</B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A> &nbsp;&nbsp;<INPUT TYPE='button' VALUE =' Load Album' ID='APPEND' name='APPEND' OnClick =\"TSR.OnLoadAlbum('%s'); \"/>  <BR/><B>Year :</B> %s<BR/><B>Audio Files :</B> %s</LI><BR/>", urlencode($row["album"]), $row["album"],urlencode($row["album"]), $row["year"], $row["count"]) ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			mysql_free_result($result);
			return $index;
		}
		
		public function showLastWeekPopular($page, $user_id)
		{
			$query = "SELECT DISTINCT id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, count( mp3_info.id ) AS plays FROM mp3_info, mp3_play_location WHERE (mp3_info.id = mp3_play_location.mp3_id) AND (mp3_play_location.play_datetime > DATE_SUB( NOW( ) , INTERVAL 7 DAY )) GROUP BY id ORDER BY plays DESC;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $index,$index,$index,$row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='STF_%d' ID='STF_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Send to friend</FONT></LEGEND>") ;
					printf("<SPAN ID='STF_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_NAME_%d' NAME='name' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_USER_EMAIL_%d' NAME='email' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_NAME_%d' NAME='fname' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_EMAIL_%d' NAME='femail' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='STF_AUD_ID_%d' NAME='aud_id' VALUE='%s' />", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' disabled =\"true\" Value = 'Send' ID = 'STF_SEND_%d' />&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('%d');\" VALUE='Cancel'/>", $listing, $listing,$listing) ;
					echo("</FORM>") ;
					echo("</FIELDSET>") ;
					echo("</SPAN></DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='REPORT_ABUSE_%d' ID='REPORT_ABUSE_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Report Abuse</FONT></LEGEND>") ;
					printf("<SPAN ID='REPORT_ABUSE_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_NAME_%d' NAME='name' VALUE='' SIZE='40'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_EMAIL_%d' NAME='email' VALUE='' SIZE='50'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Abuse Type: </TD><TD>") ;
					
					printf("<SELECT NAME='REPORT_ABUSE_OPTION_%d' ID='_%d'>", $listing, $listing);
					printf("<OPTION VALUE=\"O18C\">Over 18 Content</OPTION>") ;
					printf("<OPTION VALUE=\"COPY\">Copyright Content</OPTION>") ;
  					echo("</SELECT>");
  					
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='REPORT_ABUSE_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' onClick=\"TSR.OnBtnClkReport('%d');\" VALUE='Report'/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnReportAbuse('%d');\" VALUE='Cancel'/>", $listing, $listing) ;
					echo("</FORM>") ;
					echo("</SPAN>") ;
					echo("</FIELDSET>") ;
					echo("</DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					$listing++ ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}
		
		public function showTodaysPopular($page, $user_id)
		{
			$query = "SELECT DISTINCT id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, count( mp3_info.id ) AS plays FROM mp3_info, mp3_play_location WHERE (mp3_info.id = mp3_play_location.mp3_id) AND (mp3_play_location.play_datetime = NOW()) GROUP BY id ORDER BY plays DESC;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $index,$index,$index,$row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='STF_%d' ID='STF_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Send to friend</FONT></LEGEND>") ;
					printf("<SPAN ID='STF_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_NAME_%d' NAME='name' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_USER_EMAIL_%d' NAME='email' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_NAME_%d' NAME='fname' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_EMAIL_%d' NAME='femail' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='STF_AUD_ID_%d' NAME='aud_id' VALUE='%s' />", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' disabled =\"true\" Value = 'Send' ID = 'STF_SEND_%d' />&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('%d');\" VALUE='Cancel'/>", $listing, $listing,$listing) ;
					echo("</FORM>") ;
					echo("</FIELDSET>") ;
					echo("</SPAN></DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='REPORT_ABUSE_%d' ID='REPORT_ABUSE_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Report Abuse</FONT></LEGEND>") ;
					printf("<SPAN ID='REPORT_ABUSE_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_NAME_%d' NAME='name' VALUE='' SIZE='40'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_EMAIL_%d' NAME='email' VALUE='' SIZE='50'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Abuse Type: </TD><TD>") ;
					
					printf("<SELECT NAME='REPORT_ABUSE_OPTION_%d' ID='_%d'>", $listing, $listing);
					printf("<OPTION VALUE=\"O18C\">Over 18 Content</OPTION>") ;
					printf("<OPTION VALUE=\"COPY\">Copyright Content</OPTION>") ;
  					echo("</SELECT>");
  					
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='REPORT_ABUSE_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' onClick=\"TSR.OnBtnClkReport('%d');\" VALUE='Report'/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnReportAbuse('%d');\" VALUE='Cancel'/>", $listing, $listing) ;
					echo("</FORM>") ;
					echo("</SPAN>") ;
					echo("</FIELDSET>") ;
					echo("</DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					$listing++ ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}
		
		public function showPopular($page, $user_id)
		{
			$query = "select id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics from mp3_info where plays <> 0 ORDER BY plays DESC;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $index,$index,$index,$row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='STF_%d' ID='STF_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Send to friend</FONT></LEGEND>") ;
					printf("<SPAN ID='STF_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_NAME_%d' NAME='name' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_USER_EMAIL_%d' NAME='email' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_NAME_%d' NAME='fname' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_EMAIL_%d' NAME='femail' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='STF_AUD_ID_%d' NAME='aud_id' VALUE='%s' />", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' disabled =\"true\" Value = 'Send' ID = 'STF_SEND_%d' />&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('%d');\" VALUE='Cancel'/>", $listing, $listing,$listing) ;
					echo("</FORM>") ;
					echo("</FIELDSET>") ;
					echo("</SPAN></DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='REPORT_ABUSE_%d' ID='REPORT_ABUSE_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Report Abuse</FONT></LEGEND>") ;
					printf("<SPAN ID='REPORT_ABUSE_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_NAME_%d' NAME='name' VALUE='' SIZE='40'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_EMAIL_%d' NAME='email' VALUE='' SIZE='50'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Abuse Type: </TD><TD>") ;
					
					printf("<SELECT NAME='REPORT_ABUSE_OPTION_%d' ID='_%d'>", $listing, $listing);
					printf("<OPTION VALUE=\"O18C\">Over 18 Content</OPTION>") ;
					printf("<OPTION VALUE=\"COPY\">Copyright Content</OPTION>") ;
  					echo("</SELECT>");
  					
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='REPORT_ABUSE_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' onClick=\"TSR.OnBtnClkReport('%d');\" VALUE='Report'/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnReportAbuse('%d');\" VALUE='Cancel'/>", $listing, $listing) ;
					echo("</FORM>") ;
					echo("</SPAN>") ;
					echo("</FIELDSET>") ;
					echo("</DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					$listing++ ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}
		
		public function listExact($query, $page, $ext, $user_id)
		{
			$query = "select id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics from mp3_info where ".$ext."='".$query."';" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> %s<BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> %s<BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else 
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> %s<BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						</LI>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $row["album"],$index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='STF_%d' ID='STF_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Send to friend</FONT></LEGEND>") ;
					printf("<SPAN ID='STF_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_NAME_%d' NAME='name' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_USER_EMAIL_%d' NAME='email' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_NAME_%d' NAME='fname' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_EMAIL_%d' NAME='femail' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d')\"/><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='STF_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' disabled =\"true\" onClick=\"TSR.OnBtnClkSend('%d',this);\" VALUE='Send' ID = 'STF_SEND_%d' />&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('%d');\" VALUE='Cancel'/>", $listing, $listing,$listing) ;
					echo("</FORM>") ;
					echo("</FIELDSET>") ;
					echo("</SPAN></DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='REPORT_ABUSE_%d' ID='REPORT_ABUSE_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Report Abuse</FONT></LEGEND>") ;
					printf("<SPAN ID='REPORT_ABUSE_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_NAME_%d' NAME='name' VALUE='' SIZE='40'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_EMAIL_%d' NAME='email' VALUE='' SIZE='50'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Abuse Type: </TD><TD>") ;
					
					printf("<SELECT NAME='REPORT_ABUSE_OPTION_%d' ID='_%d'>", $listing, $listing);
					printf("<OPTION VALUE=\"O18C\">Over 18 Content</OPTION>") ;
					printf("<OPTION VALUE=\"COPY\">Copyright Content</OPTION>") ;
  					echo("</SELECT>");
  					
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='REPORT_ABUSE_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' onClick=\"TSR.OnBtnClkReport('%d');\" VALUE='Report'/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnReportAbuse('%d');\" VALUE='Cancel'/>", $listing, $listing) ;
					echo("</FORM>") ;
					echo("</SPAN>") ;
					echo("</FIELDSET>") ;
					echo("</DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					$listing++ ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}
		
		public function showUptoTenRecords($query, $page, $ext, $user_id)
		{
			if(strlen($query) <= 0)
			{
				return 0 ;
			}
			
			// Current row index.
			$index = 0 ;
			$listing = 0 ;
			$bStart = true ;
			$str = "";
			
			$wordArray = str_word_count($query, 1, '0123456789') ;
			/*$searchWordArray = $this->GetPairs($wordArray) ;
			
			if(preg_match("/\[.*\]/", $query))
			{
				echo("Ordered Query") ;
			}
			else if(preg_match("/\".*\"/", $query))
			{
				echo("Specific Query") ;
			}
			else
			{
				echo("Normal Query") ;
			}
			foreach($searchWordArray as $word)
			{
				echo($word."<BR/>") ;
			}*/

			$sqlQuery = "" ;
			
			if($ext == "album")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "album") ;
			}
			else if($ext == "artist")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "artist") ;
			}
			else if($ext == "year")
			{
			    foreach($wordArray as $word)
				{
					if(count($word)!=4 && !is_numeric($word))
					    return 0;
				}
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "year") ;
			}
			else if($ext == "genre")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "genre") ;
			}
			else if($ext == "composer")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "composer") ;
			}			
			else if($ext == "picturizedon")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "picturizedon") ;
			}
			else if($ext == "lyrics")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "lyrics") ;
			}
			else if($ext == "language")
			{
				$sqlQuery = $this->PrepareFieldQuery($wordArray, "language") ;
			}
			else
			{
				$sqlQuery = $this->PrepareWildQuery($wordArray) ;
			}
			
			// - - - - - - - - - - - -
			// Debug Code
			// - - - - - - - - - - - -
			// echo ($sqlQuery) ;
			// - - - - - - - - - - - -
			
			// - - - - - - - - - - - - - - - - - - -
			// You May Also Like Section : [Start]
			// - - - - - - - - - - - - - - - - - - -
			/*printf("<UL><LI><B>You May Also Like</B><BR/>") ;
			$random_result = mysql_query("SELECT title, album, filepath, ROUND(RAND()*100) as round FROM id3_info order by round Limit 0,3", $this->db_link_id);
			while ($random_row = mysql_fetch_array($random_result, MYSQL_ASSOC))
			{
				printf("<FONT COLOR='#FF3300'>%s</FONT> - %s <A HREF='javascript:;' onClick='AddToPlaylistUrl(\"%s\",\"%s\")'>(Add to Playlist &gt;&gt;)</A><BR/>", $random_row['title'], $random_row['album'], $random_row['filepath'], $random_row['title']);
			}
			printf("</LI></UL>");
			mysql_free_result($random_result);*/
			// - - - - - - - - - - - - - - - - - - -
			// You May Also Like Section : [End]
			// - - - - - - - - - - - - - - - - - - -
			
			// - - - - - - - - - - - - - - - - - - -
			// Execute Search Query.
			// - - - - - - - - - - - - - - - - - - -
			$result = mysql_query($sqlQuery, $this->db_link_id) ;
			
			/*if(mysql_num_rows($result) > 0)
			{
				 $row = mysql_fetch_array($result, MYSQL_ASSOC);
				
				if(CSessionManager::GetCommand() == CSessionManager::COMMAND_PLAY_FIRST)
				{
					echo ("\n<SCRIPT LANGUAGE=\"JavaScript\" TYPE=\"TEXT/JAVASCRIPT\">\n") ;
					printf ("TSR.AddToPlaylistUrl(\"%s\",\"%s\");\n", $row["id"], $row["title"]) ;
					CSessionManager::ResetCommand();
					echo ("</SCRIPT>\n") ;
				}
			}*/
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					$title 		= CUtils::FindAndHighLight($row["title"], $wordArray) ;
					$album 		= CUtils::FindAndHighLight($row["album"], $wordArray) ;
					$artist 	= CUtils::FindAndHighLight($row["artist"], $wordArray) ;
					$year 		= CUtils::FindAndHighLight($row["year"], $wordArray) ;
					$genre 		= CUtils::FindAndHighLight($row["genre"], $wordArray) ;
					$composer 	= CUtils::FindAndHighLight($row["composer"], $wordArray) ;
					$duration 	= $row["duration_sec"]/60 ;
					//$this->FindAndHighlightLyrics($row["lyrics"], $wordArray) ;
					
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					//echo("Metaphone: ".$row['metaphone']."<BR/>") ;
					
					//$playlist_cmd = '<A HREF="javascript:;" onClick="parent.window.wimpy_AndPlay('''.'>Add to Playlist &gt;&gt; </A>' ;
					//echo($listing) ;
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album,$index,$index,$index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"],$wordArray), $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album,$index,$index,$index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;
							/*printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
							<A href=\"\" id=\"2_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \" alt=\"+\" /></A>&nbsp;&nbsp;<B><FONT COLOR=\"#FF9900\">More details...</FONT></B>
							<DIV ID=\"div_details2\" style=\"display:none\">
							<A href=\"\" id=\"2_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/></A>&nbsp;&nbsp;<B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B>
							<B><EM>Artist:</EM></B> %s<BR/><B><EM>Year:</EM></B> %s<BR/><B><EM>Time:</EM></B> %.2f mins<BR/><B><EM>Genre:</EM></B> %s<BR/><B><EM>Composer:</EM></B> %s<BR/><B><EM>Lyrics:</EM></B> %s<BR/>
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;*/						
						}
					}
					else 
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album,$index,$index,$index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;
					}
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='STF_%d' ID='STF_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Send to friend</FONT></LEGEND>") ;
					printf("<SPAN ID='STF_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_NAME_%d' NAME='name' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d');\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_USER_EMAIL_%d' NAME='email' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d');\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_NAME_%d' NAME='fname' VALUE='' SIZE='40' onBlur =\"TSR.CheckEmpty('%d');\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Friend's Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='STF_FRIEND_EMAIL_%d' NAME='femail' VALUE='' SIZE='50' onBlur =\"TSR.CheckEmpty('%d');\" /><BR/>", $listing,$listing);
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='STF_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' disabled =\"true\" onClick=\"TSR.OnBtnClkSend('%d',this);\" VALUE='Send' ID = 'STF_SEND_%d' />&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnSendToFriend('%d');\" VALUE='Cancel'/>", $listing, $listing,$listing) ;
					echo("</FORM>") ;
					echo("</FIELDSET>") ;
					echo("</SPAN></DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					printf("<DIV NAME='REPORT_ABUSE_%d' ID='REPORT_ABUSE_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
					echo("<FIELDSET STYLE=\"width:450px;\"><LEGEND><FONT SIZE=\"\" COLOR=\"#0000FF\">Report Abuse</FONT></LEGEND>") ;
					printf("<SPAN ID='REPORT_ABUSE_SPAN_%d'>", $listing) ;
					printf("<FORM NAME='UPDT_FORM_%d' METHOD='POST' ACTION=''>", $listing) ;
					echo("<TABLE>") ;
					echo("<TR><TD>Your Name: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_NAME_%d' NAME='name' VALUE='' SIZE='40'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Your Email: </TD><TD>") ;
					printf("<INPUT TYPE='text' ID='REPORT_ABUSE_EMAIL_%d' NAME='email' VALUE='' SIZE='50'/><BR/>", $listing);
					echo("</TD></TR>") ;
					echo("<TR><TD>Abuse Type: </TD><TD>") ;
					
					printf("<SELECT NAME='REPORT_ABUSE_OPTION_%d' ID='_%d'>", $listing, $listing);
					printf("<OPTION VALUE=\"O18C\">Over 18 Content</OPTION>") ;
					printf("<OPTION VALUE=\"COPY\">Copyright Content</OPTION>") ;
  					echo("</SELECT>");
  					
					echo("</TD></TR>") ;
					echo("</TABLE>") ;
					printf("<INPUT TYPE='hidden' ID='REPORT_ABUSE_AUD_ID_%d' NAME='aud_id' VALUE='%s'/>", $listing, $row["id"]) ;
					printf("<BR/><INPUT TYPE='button' onClick=\"TSR.OnBtnClkReport('%d');\" VALUE='Report'/>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' onClick=\"TSR.OnReportAbuse('%d');\" VALUE='Cancel'/>", $listing, $listing) ;
					echo("</FORM>") ;
					echo("</SPAN>") ;
					echo("</FIELDSET>") ;
					echo("</DIV>") ;
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Report Abuse : [End]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					
					$listing++ ;
				}
				$index++ ;
			} while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) ;
			printf("</UL>") ;
			
			mysql_free_result($result);
			
			return $index ;
		}
		
		public function FindAndHighlightLyrics($lyrics, $arrToFind)
		{
			$str = "" ;
			
			foreach($arrToFind as $word)
			{
				$pos = stripos($str, $word);
				if($pos === false)
				{
					$pos = stripos($lyrics, $word);
				}
				else
				{
					continue;
				}
				if(!($pos === false))
				{
					if($pos >= 10)
					{
						$pos -= 10 ;
					}
					else
					{
						$pos = 0 ;
					}
					$str .= "...".substr($lyrics, $pos, 70)."..." ;
					//echo("<B>".$word.":</B> ".$this->FindAndHighLight($str, $arrToFind)."<BR/>");
				}
			}
			
			return  CUtils::FindAndHighLight($str, $arrToFind) ;
		}
		
		public function GetTopSearchAry($count)
		{
			$top_srch_ary = array() ;
			
			$result = mysql_query("select search_text, type from top_search order by DATE(last_queried) desc, count desc limit $count ;", $this->db_link_id) ;
			if (mysql_num_rows($result) > 0)
			{
				$i = 0 ;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					//strptime($row["last_queried"], "%Y-%m-%d %H-%M-%S") ;
					$top_srch_ary[$i] = array($row["search_text"], $row["type"]) ;
										
					$i++ ;
				}
			}
			mysql_free_result($result) ;
			
			return $top_srch_ary ;
		}
		
		public function GetTopSearchElement($count)
		{
			$top_srch_element_ary = array() ;
			$top_srch_ary = $this->GetTopSearchAry($count) ;
			
			$i = 0 ;
			foreach ($top_srch_ary as $element)
			{
				$sqlQuery = "" ;
				$wordArray = str_word_count($element[0], 1, '0123456789') ;
				
				if($element[1] == "album")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "album") ;
				}
				else if($element[1] == "artist")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "artist") ;
				}
				else if($element[1] == "year")
				{
				    foreach($wordArray as $word)
					{
						if(count($word)!=4 && !is_numeric($word))
						    return 0;
					}
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "year") ;
				}
				else if($element[1] == "genre")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "genre") ;
				}
				else if($element[1] == "composer")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "composer") ;
				}			
				else if($element[1] == "picturizedon")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "picturizedon") ;
				}
				else if($element[1] == "lyrics")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "lyrics") ;
				}
				else if($element[1] == "language")
				{
					$sqlQuery = $this->PrepareFieldQuery($wordArray, "language") ;
				}
				else
				{
					$sqlQuery = $this->PrepareWildQuery($wordArray) ;
				}
				
				$obj = new CSearchHelper(CConfig::DB_AUDIO) ;
				$mp3_result = mysql_query($sqlQuery) or die("Error: ".mysql_error()) ;
				if(mysql_num_rows($mp3_result) > 0)
				{
					$mp3_row = mysql_fetch_array($mp3_result, MYSQL_ASSOC) ;
					$top_srch_element_ary[$i] = array($mp3_row["title"], $element[1]) ;
					$i++ ;
				}
				mysql_free_result($mp3_result) ;
			}
			
			return $top_srch_element_ary ;
		}
		
		public function GetAudienceChoice($count)
		{
			$aud_choice_ary = array() ;
			
			$query = "select id, album, title from mp3_info where plays <> 0 ORDER BY plays DESC limit $count;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$i = 0 ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$aud_choice_ary[$i] = array($row["album"], $row["title"], $row["id"]) ;
				$i++;
			}
			
			mysql_free_result($result) ;
			return $aud_choice_ary ;
		}
	}
	/*UPdate history*/
	/*Updated on 17/12/2008 fixed issue when any song'g title,lyrics etc. contains "'"
	function updated PrepareWildQuery, PrepareFieldQuery
	
	 */
?>