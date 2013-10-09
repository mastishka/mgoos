<?php
	include_once("config.php");

	class CQueryManager
	{
		private $db_link_id;
		public function __construct($database)
		{
			// Server Name, UserName, Password, Database Name
			$this->db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or
				    die("Could not connect: " . mysql_error());
			mysql_select_db($database, $this->db_link_id)  or
				    die("Can not select database: " . mysql_error());
		}

		public function __destruct()
		{
			// Using mysql_close() isn't usually necessary,
			// as non-persistent open links are automatically closed at the end of the script's execution.

			/*
			mysql_close($this->db_link_id) ;
			*/
		}

		/*
		 * Get CId3Info array for given mp3 id.
		 */
		public function GetMp3Info($id)
		{
			$objId3 = new CId3Info(array()) ;

			$result = mysql_query("select * from mp3_info where id='".$id."';", $this->db_link_id) or die("Get Mp3 Info Error: ".mysql_error($this->db_link_id)) ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$objId3->SetAlbum($row["album"]) ;
				$objId3->SetArtist($row["artist"]) ;
				$objId3->SetBitRate($row["bitrate"]) ;
				$objId3->SetComposer($row["composer"]) ;
				$objId3->SetDurationSec($row["duration_sec"]) ;
				$objId3->SetFilePath($row["filepath"]) ;
				$objId3->SetFileSize($row["filesize"]) ;
				$objId3->SetGenre($row["genre"]) ;
				$objId3->SetMood($row["mood"]) ;
				$objId3->SetID($row["id"]) ;
				$objId3->SetLanguage($row["language"]) ;
				$objId3->SetLyrics($row["lyrics"]) ;
				$objId3->SetPicturizedOn($row["picturizedon"]) ;
				$objId3->SetStatus($row["status"]) ;
				$objId3->SetTitle($row["title"]) ;
				$objId3->SetUserId($row["user_id"]) ;
				$objId3->SetYear($row["year"]) ;
			}
			mysql_free_result($result) ;

			return $objId3 ;
		}

		/*
		 * Get CId3Info array for given mp3 id.
		 */
		public function RemoveMp3Entry($id)
		{
			// First get field's title.
			$v_title = $this->GetFieldValue($id, "title") ;
			// Get field's filepath as well.
			$v_filepath = $this->GetFieldValue($id, "filepath") ;

			// Now remove the entry from mp3_info.
			// echo("delete from mp3_info where id='".$id."';") ;
			mysql_query("delete from mp3_info where id='".$id."';", $this->db_link_id) or die("Remove Mp3 enrty Error: ".mysql_error($this->db_link_id)) ;

			if( mysql_affected_rows($this->db_link_id) > 0 )
			{
				// Remove the entry from mp3_metaphone_info as well.
				mysql_query("delete from mp3_metaphone_info where id='".$id."';", $this->db_link_id) ;

				// Now remove file from the disk (@ for suppressing error/warning message).
				@unlink($v_filepath) ;
			}

			return $v_title ;
		}
		/*
		 * Get CId3Info array for given mp3 id.
		 */
		public function GetFieldValue($id, $field)
		{
			$objId3 = new CId3Info(array()) ;

			$result = mysql_query("select ".$field." from mp3_info where id='".$id."';", $this->db_link_id) or die("Get Field Value Error: ".mysql_error($this->db_link_id)) ;

			$value = "" ;
			if( mysql_num_rows($result) > 0 )
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$value = $row[$field] ;
			}
			mysql_free_result($result) ;

			return $value ;
		}

		/*
		 * Insert CId3Info object values into mp3_info.
		 */
		public function InsertIntoMp3Info(CId3Info $id3info)
		{
			$id 			= mysql_escape_string($id3info->GetID()) ;
			$filepath 		= mysql_escape_string($id3info->GetFilePath()) ;
			$filesize 		= mysql_escape_string($id3info->GetFileSize()) ;
			$bitrate 		= mysql_escape_string($id3info->GetBitRate()) ;
			$duration_sec 	= mysql_escape_string($id3info->GetDurationSec()) ;
			$language		= mysql_escape_string($id3info->GetLanguage()) ;
			$status		 	= mysql_escape_string($id3info->GetStatus()) ; // 0 : Private, 1 : Public, 2: Issued Private
			$userid 		= mysql_escape_string($id3info->GetUserId()) ;
			$title 			= mysql_escape_string($id3info->GetTitle()) ;
			$artist 		= mysql_escape_string($id3info->GetArtist()) ;
			$album 			= mysql_escape_string($id3info->GetAlbum()) ;
			$lyrics 		= mysql_escape_string($id3info->GetLyrics()) ;
			$year 			= mysql_escape_string($id3info->GetYear()) ;
			$genre 			= mysql_escape_string($id3info->GetGenre()) ;
			$mood			= mysql_escape_string($id3info->GetMood()) ;
			$composer 		= mysql_escape_string($id3info->GetComposer()) ;
			$picturizedon 	= mysql_escape_string($id3info->GetPicturizedOn()) ;
			$provider		= mysql_escape_string($id3info->GetProvider()) ;

			// Insert query for mp3_info table.
			// echo("insert into mp3_info (id, filepath, filesize, bitrate, duration_sec, status, user_id, title, artist, album, lyrics, year, genre, composer, picturizedon) values ('".$id."', '".$filepath."', '".$filesize."', '".$bitrate."', '".$duration_sec."', '".$status."', '".$userid."', '".$title."', '".$artist."', '".$album."', '".$lyrics."', '".$year."', '".$genre."', '".$composer."', '".$picturizedon."') ; <BR/>") ;
			$bResult = mysql_query("insert ignore into mp3_info (id, upload_date, filepath, filesize, bitrate, duration_sec, language, status, user_id, title, artist, album, lyrics, year, genre,mood, composer, picturizedon, provider) values ('".$id."', CURDATE(), '".$filepath."', '".$filesize."', '".$bitrate."', '".$duration_sec."', '".$language."', '".$status."', '".$userid."', '".$title."', '".$artist."', '".$album."', '".$lyrics."', '".$year."', '".$genre."','".$mood."', '".$composer."', '".$picturizedon."', '".$provider."') ;", $this->db_link_id) or die("mp3_info Insert Error: ".mysql_error($this->db_link_id));

			// Insert query for mp3_metaphone_info table.
			if($bResult)
			{
				$bResult = mysql_query("insert into mp3_metaphone_info (id, title, artist, album, lyrics, genre, composer, picturizedon) values ('".$id."', '".CUtils::GetMetaphone($title)."', '".CUtils::GetMetaphone($artist)."', '".CUtils::GetMetaphone($album)."', '".CUtils::GetMetaphone($lyrics)."', '".CUtils::GetMetaphone($genre)."','".CUtils::GetMetaphone($composer)."', '".CUtils::GetMetaphone($picturizedon)."') ;", $this->db_link_id) or die("mp3_metaphone_info Insert Error: ".mysql_error($this->db_link_id));
			}

			return $bResult ;
		}

		/*
		 * Update mp3_info table details.
		 */
		public function UpdateMp3Info(CId3Info $id3info)
		{
			$id 			= $id3info->GetID() ;
			$language		= $id3info->GetLanguage() ;
			$title 			= $id3info->GetTitle() ;
			$artist 		= $id3info->GetArtist() ;
			$album 			= $id3info->GetAlbum() ;
			$lyrics 		= $id3info->GetLyrics() ;
			$year 			= $id3info->GetYear() ;
			$genre 			= $id3info->GetGenre() ;
			$mood 			= $id3info->GetMood() ;
			$composer 		= $id3info->GetComposer() ;
			$picturizedon 	= $id3info->GetPicturizedOn() ;

			// Update query for mp3_info table.
			// echo("update mp3_info set title='$title', artist='$artist', album='$album', lyrics='$lyrics', year='$year', genre='$genre', composer='$composer', picturizedon='$picturizedon', language='$language,' mood='$mood' where id='$id';<BR/>") ;

			$bResult = mysql_query("update mp3_info set title='".$title."', artist='".$artist."', album='".$album."', lyrics='".$lyrics."', year='".$year."', genre='".$genre."', composer='".$composer."', picturizedon='".$picturizedon."', language='".$language."', mood='".$mood. "' where id='".$id."';", $this->db_link_id) or die("mp3_info Update Error: ".mysql_error($this->db_link_id)) ;

			if($bResult)
			{
				$bResult = mysql_query("update mp3_metaphone_info set title='".CUtils::GetMetaphone($title)."', artist='".CUtils::GetMetaphone($artist)."', album='".CUtils::GetMetaphone($album)."', lyrics='".CUtils::GetMetaphone($lyrics)."', genre='".CUtils::GetMetaphone($genre)."', mood='".CUtils::GetMetaphone($mood)."' ,composer='".CUtils::GetMetaphone($composer)."', picturizedon='".CUtils::GetMetaphone($picturizedon)."' where id='".$id."';", $this->db_link_id) or die("mp3_metaphone_info Update Error: ".mysql_error($this->db_link_id));
			}

			return $bResult ;
		}

		/*
		 * Prepare Language options and select passed language.
		 */
		public function PrepareLangOptions($lang)
		{
			$result = mysql_query("select * from languages order by language asc;") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if(strcasecmp(@trim($row["language"]), $lang) != 0)
				{
					printf("<option id=\"lang_%s\" value=\"%s\">%s</option>", $row["language"], $row["language"], $row["language"]);
				}
				else
				{
					printf("<option id=\"lang_%s\" value=\"%s\" selected=\"selected\">%s</option>", $row["language"], $row["language"], $row["language"]);
				}
			}
			mysql_free_result($result);
		}

		/*
		 * Prepare Genre options and select passed Genre.
		 */
		public function PrepareGenreOptions($genre)
		{
			$result = mysql_query("select * from genres order by genre asc;") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if(strcasecmp(@trim($row["genre"]), $genre) != 0)
				{
					printf("<option id=\"genre_%s\" value=\"%s\">%s</option>", $row["genre"], $row["genre"], $row["genre"]);
				}
				else
				{
					printf("<option id=\"genre_%s\" value=\"%s\" selected=\"selected\">%s</option>", $row["genre"], $row["genre"], $row["genre"]);
				}
			}
			mysql_free_result($result);
		}

		public function PrepareMoodOptions($mood)
		{
			$result = mysql_query("select * from mood order by mood asc;") ;
			//if(strcasecmp($mood,"Unknown")==0)
				/*printf("<option value=\"%s\">%s</option>", $row["mood"], $row["mood"]);*/

			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if(strcasecmp(@trim($row["mood"]), $mood) != 0)
				{
					printf("<option id=\"mood_%s\" value=\"%s\">%s</option>", $row["mood"], $row["mood"], $row["mood"]);
				}
				else
				{
					printf("<option id=\"mood_%s\" value=\"%s\" selected=\"selected\">%s</option>", $row["mood"], $row["mood"], $row["mood"]);
				}
			}
			mysql_free_result($result);
		}
		/*
		 * Prepare Uploaded Mp3 listing for the user_id.
		 */

		public function PrepareMP3Listing($user_id, $pageno)
		{
			$count = mysql_query("select count(*) as cnt from mp3_info where user_id='".$user_id."' order by title asc;") ;
			$arr = mysql_fetch_array($count, MYSQL_ASSOC);
			$row_count = $arr["cnt"];
			$this->PreparePaging($pageno,$row_count,"tab_manage_aud_mymp3.php","");
			echo("<TABLE BORDER='0'>") ;
			echo("<TR BGCOLOR=\"#CCCC99\" ALIGN=\"CENTER\"><TD><B>Index</B></TD><TD><B>Title</B></TD><TD><B>Album</B></TD><TD><B>Artist</B></TD><TD><B>Genre</B></TD><TD><B>Bit Rate</B></TD><TD><B>Duration (min)</B></TD><TD><B>Edit</B></TD><TD><B>Remove</B></TD></TR>") ;

 			$startlimit = ($pageno -1)* 10;
			$endlimit = ($pageno -1)*10 +10;
			$result = mysql_query("select * from mp3_info where user_id='".$user_id."' order by title asc limit " .$startlimit. "," . $endlimit . ";");

			$i = 0 ;
			$index = $startlimit + 1;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($i == 0)
				{
					echo("<TR BGCOLOR=\"#FFFFCC\" ALIGN=\"CENTER\">") ;
					$i++ ;
				}
				else
				{
					echo("<TR BGCOLOR=\"#FFFF99\" ALIGN=\"CENTER\">") ;
					$i-- ;
				}

				printf("<TD>%d</TD><TD>%s (<A HREF='javascript:;' onClick=\"parent.parent.SR.AddToPlaylistUrl('%s','%s');\">Add
					</A>)</TD><TD>%s</TD><TD>%s</TD><TD>%s</TD><TD>%s kbps</TD><TD>%.2f</TD><TD><A HREF=\"tab_manage_aud_edit.php?id=%s&pg=1\">Edit</A></TD><TD><A HREF=\"tab_manage_aud_delete.php?id=%s&pg=1\">Remove</A></TD>", $index, $row["title"], $row["id"], mysql_real_escape_string($row["title"]), $row["album"], $row["artist"], $row["genre"], $row["bitrate"], $row["duration_sec"]/60, $row["id"], $row["id"]) ;
				echo("</TR>") ;
				$index++ ;
			}
			echo("</TABLE>") ;

			mysql_free_result($result);
		}

		/*
		 * Prepare Today's Mp3 upload details.
		 */
		public function PrepareTodayUploadDetails($user_id,$pageno)
		{
			$count = mysql_query("select count(*) as cnt from mp3_info where upload_date=CURDATE() AND user_id='".$user_id."' order by title asc;") ;
			$arr = mysql_fetch_array($count, MYSQL_ASSOC);
			$row_count = $arr["cnt"];
			$this->PreparePaging($pageno,$row_count,"tab_manage_aud_upload.php","");
			$startlimit = ($pageno -1)*10;
			$endlimit = ($pageno -1)*10 +10;
			$i = 0 ;
			$index = $startlimit + 1;
			$result = mysql_query("select * from mp3_info where upload_date=CURDATE() AND user_id='".$user_id."' order by title asc limit " . $startlimit . "," . $endlimit . ";") or die("message" .mysql_error());

			if(mysql_num_rows($result) > 0)
			{
				echo("<TABLE BORDER='0'>") ;
				echo("<TR BGCOLOR=\"#CCCC99\" ALIGN=\"CENTER\"><TD><B>Index</B></TD><TD><B>Title</B></TD><TD><B>Album</B></TD><TD><B>Artist</B></TD><TD><B>Genre</B></TD><TD><B>Bit Rate</B></TD><TD><B>Duration (min)</B></TD><TD><B>Edit</B></TD><TD><B>Remove</B></TD></TR>") ;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					if($i == 0)
					{
						echo("<TR BGCOLOR=\"#FFFFCC\" ALIGN=\"CENTER\">") ;
						$i++ ;
					}
					else
					{
						echo("<TR BGCOLOR=\"#FFFF99\" ALIGN=\"CENTER\">") ;
						$i-- ;
					}
					printf("<TD>%d</TD><TD>%s (<A HREF='javascript:;' onClick=\"parent.parent.SR.AddToPlaylistUrl('%s','%s');\">Add
					</A>)</TD><TD>%s</TD><TD>%s</TD><TD>%s</TD><TD>%s kbps</TD><TD>%.2f</TD><TD><A HREF=\"tab_manage_aud_edit.php?id=%s&pg=2\">Edit</A></TD><TD><A HREF=\"tab_manage_aud_delete.php?id=%s&pg=2\">Remove</A></TD>", $index, $row["title"], $row["id"], mysql_real_escape_string($row["title"]), $row["album"], $row["artist"], $row["genre"], $row["bitrate"], $row["duration_sec"]/60, $row["id"], $row["id"]) ;
					echo("</TR>") ;

					$index++ ;
				}
				echo("</TABLE>") ;
			}
			else
			{
				echo ("You have not uploaded any songs today :(") ;
			}

			mysql_free_result($result);
		}
		/*
		 * Prepare Today's Mp3 upload summary.
		 */
		public function PrepareTodayUploadSummary($user_id)
		{
			$result = mysql_query("select * from mp3_info where upload_date=CURDATE() AND user_id='".$user_id."' order by title asc;") ;

			if(mysql_num_rows($result) > 0)
			{
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$filesize += $row["filesize"] ;
				}
				printf("%.2f MB, Songs: %d", ($filesize/1048576), mysql_num_rows($result)) ;
			}
			else
			{
				echo ("You have not uploaded any songs today :(") ;
			}

			mysql_free_result($result);
		}

		/*
		 * Validate mp3_info table entries, if any entry exists whose corresponding file not found then remove the entry.
		 */
		private function ValidateMp3DBEntries()
		{
			// Execute search query.
			$result = mysql_query("select id, filepath from mp3_info; ", $this->db_link_id) ;
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$bResult = file_exists($row["filepath"]);
				if( !$bResult )
				{
					mysql_query("delete from md3_info where id='".$row["id"]."' ;", $this->db_link_id) ;
					if(mysql_affected_rows($this->db_link_id) > 0)
					{
						mysql_query("delete from md3_metaphone_info where id='".$row["id"]."' ;", $this->db_link_id) ;
					}
				}
			}
			mysql_free_result($result);
		}

		/*
		 * Scan the folder (File System) which contains all mp3 files and delete file which does'nt posses any corresponding entry in DB
		 */
		private function ValidateMp3FSEntries($dir)
		{
			$filepath_ary = scandir($dir) ;
			/*
			echo("<PRE>") ;
			print_r($filepath_ary) ;
			echo("</PRE>") ;
			*/

			foreach($filepath_ary as $file)
			{
				$pos = stripos($file, ".") ;
				if($pos === false)
				{
					// This query will fetch a row from DB.
					$result = mysql_query("select id from mp3_info where filepath LIKE '%".$file."%' ; ", $this->db_link_id) ;
					if (mysql_num_rows($result) <= 0)
					{
						//echo("Removing File: ".$dir."/".$file) ;
						unlink($dir."/".$file) ;
					}
					mysql_free_result($result) ;
				}
			}
		}

		/*
		 * Validate all mp3 entries from DB as well as from directory.
		 */
		public function ValidateMp3Entries($dir)
		{
			$this->ValidateMp3DBEntries() ;
			$this->ValidateMp3FSEntries($dir) ;
		}

		/*
		 * Update analytics.top_search table.
		 */
		function UpdateTopSearch($srchtxt)
		{
			if(strlen($srchtxt) <=0 )
			{
				return 0 ;
			}

			// Server Name, UserName, Password, Database Name
			$wordArray = str_word_count($srchtxt, 1, '0123456789');
			$i = 0 ;
			$srch_meta_txt = "" ;

			foreach($wordArray as $word)
			{
				$word_meta_ary[$i] = metaphone($word);
				$srch_meta_txt .= $word_meta_ary[$i];
				if(count($wordArray) > $i+1)
				{
					$srch_meta_txt .= " ";
				}
				$i++;
			}

			//echo ($srch_meta_txt) ;
			// ----------------------
			//Debug Code
			// ----------------------
			/*echo ("<PRE>") ;
			print_r($word_meta_ary) ;
			echo ("</PRE>") ;*/

			$query = "select meta_val, search_id from top_search where meta_val like '%".$srch_meta_txt."%'";

			$fetch_result = mysql_query($query)or die("<BR>query fail: ".mysql_error());

			//echo "<BR> result $result";

			if (mysql_num_rows($fetch_result)==0)
			{
				 $query = "insert into top_search (search_text,meta_val,count) values ('".$srchtxt."','".$srch_meta_txt."',1)";
				 $result = mysql_query($query) or die("query fail: ".mysql_error());
			}
			else
			{
				$match_result = array();
				$i = 0;
				while ($row = mysql_fetch_array($fetch_result, MYSQL_ASSOC))
				{
					$temp_ary = str_word_count($row["meta_val"], 1, '0123456789') ;
					if(count($temp_ary) > 0)
					{
						$match_result[$i] = CUtils::CompWords($temp_ary, $word_meta_ary) ;
						$i++;
					}
				}

				$max_result = max($match_result) ;

				//echo ($max_result) ;
				if($max_result >= 66)
				{
				//	echo ("Test 1 <BR/>") ;

					$i = 0;

					// - - - - - - - - - - - - - - - - - -
					// Don't change the order of calling.
					// - - - - - - - - - - - - - - - - - -

					foreach($match_result as $result)
					{
						if($max_result == $result)
						{
							break;
						}
						$i++;
					}

				//	echo ("Test 2 <BR/>") ;

					mysql_data_seek($fetch_result, $i) ;

					$row = mysql_fetch_array($fetch_result, MYSQL_ASSOC) ;

				//	print_r($row);

					if($row)
					{
						mysql_query("update top_search set count=count+1 where search_id='".$row["search_id"]."'") or die ("Update fail: ".mysql_error());
					}

					// - - - - - - - - - - - - - - - - - -
				}
				else
				{
					$query = "insert into top_search (search_text,meta_val,count) values ('".$srchtxt."','".$srch_meta_txt."',1)";
					$fetch_result = mysql_query($query) or die("query fail: ".mysql_error());
				}
			}
		}

		public function AddBookmark($user_id, $aud_id)
		{
			$bResult = 0 ;

			$result = mysql_query("select bookmarks from bookmarks where user_id='".$user_id."' ;", $this->db_link_id) ;
			if (mysql_num_rows($result) > 0)
			{
				//echo("Test 1.0<BR/>") ;
				// Update bookmarks field for given user.
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$bookmarks = $row["bookmarks"] + $aud_id + ";";
				mysql_query("update bookmarks set bookmarks=CONCAT(bookmarks,'".$aud_id.";') where user_id='".$user_id."' ;", $this->db_link_id) ;
				if(mysql_affected_rows($this->db_link_id) > 0)
				{
					//echo("Test 2.0<BR/>") ;
					$bResult = 1 ;
				}
			}
			else
			{
				//echo("Test 3.0<BR/>") ;
				mysql_query("insert into bookmarks (user_id, bookmarks) values ('".$user_id."', '".$aud_id.";');", $this->db_link_id) ;
				if(mysql_affected_rows($this->db_link_id) > 0)
				{
					//echo("Test 4.0<BR/>") ;
					$bResult = 1 ;
				}
			}
			mysql_free_result($result) ;

			return  $bResult ;
		}

		public function AddPlaylist($user_id, $pl_name, $comments, $playlist, &$bOverwrite, &$err_msg)
		{
			$bResult = 1 ;

			//echo("Overwrite : ".$bOverwrite." Comparision : ".$check."<BR/>");
			if($bOverwrite == 0)
			{
				//echo("Test 1<BR/>") ;
				$result = mysql_query("select name, playlist from playlists where user_id='".$user_id."' ;", $this->db_link_id) ;
				if (mysql_num_rows($result) > 0)
				{
					//echo("Test 2<BR/>") ;
					// Check if playlist name already exists.
					while($row = mysql_fetch_array($result, MYSQL_ASSOC))
					{
						//echo("Test 3<BR/>") ;
						if(strcasecmp($row["name"], $pl_name) == 0)
						{
							//echo("Test 4<BR/>") ;
							$bResult = 0 ;
							$bOverwrite = 1 ;
							$err_msg = "Playlist '".$pl_name."' already exists." ;
							break ;
						}
					}

					if($bResult)
					{
						//echo("Test 5<BR/>") ;
						$uuid = CUtils::uuid() ;
						$query = sprintf("insert into playlists (playlist_id,user_id,name,playlist,comments) values ('%s','%s',LOWER('%s'),'%s','%s');", $uuid, $user_id, $pl_name, $playlist, $comments) ;
						mysql_query($query, $this->db_link_id) ;

					}
				}
				else
				{
					//echo("Test 6<BR/>") ;
					$uuid = CUtils::uuid() ;
					$query = sprintf("insert into playlists (playlist_id,user_id,name,playlist,comments) values ('%s','%s',LOWER('%s'),'%s','%s');", $uuid, $user_id, $pl_name, $playlist, $comments);
					mysql_query($query, $this->db_link_id) or die("Error: ".mysql_error()) ;
				}

				mysql_free_result($result) ;
			}
			else
			{
				//echo("Test 7<BR/>") ;
				$uuid = CUtils::uuid() ;
				$query = sprintf("update playlists set playlist='%s',comments='%s' where name=LOWER('%s') AND user_id='%s';", $playlist, $comments, $pl_name, $user_id) ;
				mysql_query($query, $this->db_link_id) ;
			}

			return  $bResult ;
		}

		public function AlignLastWeekPlayCount($id)
		{
			mysql_query("update mp3_info set last_week_plays=last_week_plays-todays_plays where id='".$aud_id."' ;", $this->db_link_id) ;
		}

		public function AlignTodaysPlayCount($id)
		{
			mysql_query("update mp3_info set todays_plays=0 where id='".$aud_id."' AND DAY(last_played) <> DAY(NOW());", $this->db_link_id) ;
		}

		public function IncreasePlayCount($aud_id)
		{
			mysql_query("update mp3_info set plays=plays+1, last_week_plays=last_week_plays+1, todays_plays=todays_plays+1 where id='".$aud_id."' ;", $this->db_link_id) ;
		}

		public function GetDBFileCount()
		{
			$count = 0;
			$result = mysql_query("select count(*) as count from mp3_info;", $this->db_link_id);

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$count = $row["count"] ;
			}
			mysql_free_result($result) ;

			return $count ;
		}

		public function GetDBAlbumCount()
		{
			$count = 0;
			$result = mysql_query("select count(distinct album) as count from mp3_info;", $this->db_link_id);

			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$count = $row["count"] ;
			}
			mysql_free_result($result) ;

			return $count ;
		}

		public function GetUserPlayList($user_id, $pageno)
		{
		    $count = mysql_query("select count(*) as cnt from playlists where user_id= '".$user_id."';", $this->db_link_id);
			$arr = mysql_fetch_array($count, MYSQL_ASSOC);
			$row_count = $arr["cnt"];

			$this->PreparePaging($pageno,$row_count,"tab_manage_aud_playlist.php","");

			// display hyperlinks
 			$startlimit = ($pageno -1)* 10;
			$endlimit = ($pageno -1)*10 +10;

			$result = mysql_query("select * from playlists where user_id= '".$user_id."'limit ".$startlimit . "," .$endlimit. "  ;", $this->db_link_id);
			if( mysql_num_rows($result) > 0 )
			{
				echo("<TABLE BORDER='0' WIDTH=\"100%\">\n") ;
				echo("<TR BGCOLOR=\"#CCCC99\" ALIGN=\"CENTER\"><TD><B>Index</B></TD><TD><B>Playlist Name</B></TD><TD><B>Comment</B></TD><TD><B>Load</B></TD><TD><B>Remove</B></TD></TR>\n") ;
				$i = 0;
			    $index = 1;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					if($i == 0)
					{
						echo("<TR BGCOLOR=\"#FFFFCC\" ALIGN=\"CENTER\">") ;
						$i++ ;
					}
					else
					{
						echo("<TR BGCOLOR=\"#FFFF99\" ALIGN=\"CENTER\">") ;
						$i-- ;
					}
					$pid = $row["playlist_id"] ;
					$pname = $row["name"];
					$comment  = $row["comments"];
					if(empty($comment))
					{
						$comment   = "<B>.&nbsp;&nbsp;.&nbsp;&nbsp;.</B>";
					}
					printf("<TD>%d</TD> <TD><A HREF='tab_manage_aud_playlist_info.php?pid=%s'>%s</A></TD><TD>%s</TD><TD> <INPUT TYPE='button' VALUE =' Load ' ID='APPEND' name='APPEND' OnClick =\"OnLoadPlaylist('%s');\" /></TD><TD><INPUT TYPE=\"button\" VALUE=\"Remove\" OnClick=\"OnRemovePlaylist('%s','%s',%d);\"/></TD></TR>\n", $index,$pid,$pname,$comment,$pid,$pid, $pname, $pageno);
					$index++;
				}
				echo("</TABLE>") ;
			}
			mysql_free_result($result) ;
		}

		private function PreparePaging($pageno,$row_count,$href,$pid)
		{
			if($row_count > 10)
			{
				$page_count = ceil($row_count/10);
				$remainder =  $pageno%10;
				

				
				if($remainder == 0)
				{
					$remainder++;
				}

				$startoffset =  floor($pageno/10)*$remainder;
				$endoffset =  floor($pageno/10)*($remainder)  + 10;
				if($startoffset > 0)
				{
					$startoffset = ($startoffset + (5 - ($startoffset%5))) ;
					$endoffset = ($endoffset + (5 - ($endoffset%5))) ;
				}
				if($endoffset >= $page_count )
				{
					$endoffset = $page_count;
				}
				if($pageno >= $page_count)
				{
					$pageno = $page_count;
				}
				if($pageno -1 != $startoffset)
				{
					printf("<B><A HREF=\"%s?pg=%d&pid=%s\">&lt; Prev</A>&nbsp;&nbsp;&nbsp;",$href,$pageno-1,$pid);
				}
				else
				{
					printf("<B><A >&lt; Prev</A>&nbsp;&nbsp;&nbsp;");
				}
				for($i = $startoffset; $i < $endoffset; $i++)
				{
					if($pageno-1 !=$i)
					{
						printf("<A HREF=\"%s?pg=%d&pid=%s\">{%d}</A>&nbsp;&nbsp;",$href,$i+1,$pid, $i+1) ;
					}
					else
					{
						printf("<A>%d</A>&nbsp;&nbsp;",$i+1) ;
					}
				}
				if($pageno != $endoffset)
				{
					printf("&nbsp;&nbsp;<A HREF=\"%s?pg=%d&pid=%s\">Next &gt;</A></B></BR>",$href,$pageno+1,$pid);
				}
				else
				{
					printf("&nbsp;&nbsp;<A>Next &gt;</A></B></BR>");
				}
			}
		}

		public function PreparePlaylistInfo($playlist_id,$pageno)
		{
			$playlistresult = mysql_query("select * from playlists where playlist_id= '".$playlist_id."';", $this->db_link_id);
			$row = mysql_fetch_array($playlistresult);
			printf("<LEGEND> <B>Playlist : %s </B></LEGEND>",$row['name']);
			$mp3idarray = explode(";",$row['playlist']);
			$numsongs = count($mp3idarray);
			$this->PreparePaging($pageno,$numsongs,"tab_manage_aud_playlist_info.php",$playlist_id);
			$startlimit = ($pageno -1)* 10;
			$endlimit = ($pageno -1)*10 + 10;

			echo("<TABLE BORDER='0'>\n") ;
			echo("<TR BGCOLOR=\"#CCCC99\" ALIGN=\"CENTER\"><TD><B>Index</B></TD><TD><B>Title</B></TD><TD><B>Album</B></TD><TD><B>Artist</B></TD><TD><B>Genre</B></TD><TD><B>Bit Rate</B></TD><TD><B>Duration (min)</B></TD><TD><B>Remove</B></TD></TR>\n") ;

			$i = 0 ;
			$index = 1 ;

			foreach($mp3idarray as $mp3id)
			{
			    $result = mysql_query("select * from mp3_info where id='".$mp3id."' order by title asc;", $this->db_link_id) or die("Test Error: ".mysql_error($this->db_link_id));
				if($index > $startlimit &&  $index <= $endlimit)
				{
					while($row = mysql_fetch_array($result,MYSQL_ASSOC))
					{
						if($i == 0)
						{
							echo("<TR BGCOLOR=\"#FFFFCC\" ALIGN=\"CENTER\">") ;
							$i++ ;
						}
						else
						{
							echo("<TR BGCOLOR=\"#FFFF99\" ALIGN=\"CENTER\">") ;
							$i-- ;
						}
						printf("<TD>%d</TD><TD>%s (<A HREF='javascript:;' onClick=\"parent.parent.SR.AddToPlaylistUrl('%s','%s');\">Add</A>)</TD><TD>%s</TD><TD>%s</TD><TD>%s</TD><TD>%s kbps</TD><TD>%.2f</TD><TD><INPUT TYPE=\"button\" VALUE=\"Remove\" OnClick=\"OnRemovePlaylistElmt('%s','%s','%s',%d);\"/></TD>\n",
								$index, $row["title"], $row["id"], mysql_real_escape_string($row["title"]), $row["album"], $row["artist"], $row["genre"], $row["bitrate"], $row["duration_sec"]/60, $playlist_id, $row["id"], $row["title"], $pageno) ;
						echo("</TR>") ;

					}
				}
				$index++;
				mysql_free_result($result);
			}
			echo("</TABLE>") ;

			mysql_free_result($playlistresult);
		}

		public function PrepareBookMarksInfo($user_id,$pageno)
		{
			$playlistresult = mysql_query("select * from bookmarks where user_id= '".$user_id."';", $this->db_link_id);
			$row = mysql_fetch_array($playlistresult);
			$mp3idarray = explode(";",$row['bookmarks']);
			$count = count($mp3idarray);
			$this->PreparePaging($pageno,$count,"tab_manage_aud_bookmarks.php","");
			$startlimit = ($pageno -1)* 10;
			$endlimit = ($pageno -1)*10 + 10;

			echo("<TABLE BORDER='0'>\n") ;
			echo("<TR BGCOLOR=\"#CCCC99\" ALIGN=\"CENTER\"><TD><B>Index</B></TD><TD><B>Title</B></TD><TD><B>Album</B></TD><TD><B>Artist</B></TD><TD><B>Genre</B></TD><TD><B>Bit Rate</B></TD><TD><B>Duration (min)</B></TD><TD><B>Remove</B></TD></TR>\n") ;

			$i = 0 ;
			$index = 1 ;
			foreach($mp3idarray as $mp3id)
			{
				$result = mysql_query("select * from mp3_info where id='".$mp3id."' order by title asc;") ;
				if($index > $startlimit &&  $index <= $endlimit)
				{
					while($row = mysql_fetch_array($result,MYSQL_ASSOC))
					{

						if($i == 0)
						{
							echo("<TR BGCOLOR=\"#FFFFCC\" ALIGN=\"CENTER\">") ;
							$i++ ;
						}
						else
						{
							echo("<TR BGCOLOR=\"#FFFF99\" ALIGN=\"CENTER\">") ;
							$i-- ;
						}
						printf("<TD>%d</TD><TD>%s (<A HREF='javascript:;' onClick=\"parent.parent.SR.AddToPlaylistUrl('%s','%s');\">Add</A>)</TD><TD>%s</TD><TD>%s</TD><TD>%s</TD><TD>%s kbps</TD><TD>%.2f</TD><TD><input type = 'button' value = 'Remove' onClick = \"OnRemoveBookmark('%s',%d,'%s');\"></TD>\n",
								$index, $row["title"], $row["id"], mysql_real_escape_string($row["title"]), $row["album"], $row["artist"], $row["genre"], $row["bitrate"], $row["duration_sec"]/60,$row["id"],$pageno,mysql_real_escape_string($row["title"])) ;
						echo("</TR>") ;
						$index++ ;
					}
				}
				mysql_free_result($result);
			}
			echo("</TABLE>") ;

			mysql_free_result($playlistresult);
		}

		public function InsertSendToFriend($user_name, $user_email, $friends_name, $friends_email, $aud_id)
		{
			$query = sprintf("insert into send_to_friend (user_name, user_email, friend_name, friend_email, aud_id) values ('%s', '%s', '%s', '%s', '%s')", $user_name, $user_email, $friends_name, $friends_email, $aud_id);
			mysql_query($query) ;
		}

		public function IncreaseVoteCount($aud_id)
		{
			$query = sprintf("update mp3_info set votes = votes + 1 where id='%s' ;", $aud_id);
			mysql_query($query) ;
		}

		public function IsBookmarked($aud_id, $user_id)
		{
			$bResult = 0 ;
			$result = mysql_query("select bookmarks from bookmarks where user_id='".$user_id."';", $this->db_link_id);

			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$bookmark_array = explode(";", $row["bookmarks"]) ;
				if(in_array($aud_id, $bookmark_array))
				{
					$bResult = 1 ;
				}
			}
			mysql_free_result($result);

			return $bResult ;
		}

		public function RemovePlaylist($playlist_id)
		{
			$bResult = 0 ;
			mysql_query("delete from playlists where playlist_id='".$playlist_id."';", $this->db_link_id) ;

			if (mysql_affected_rows($this->db_link_id) > 0)
			{
				$bResult = 1 ;
			}

			return $bResult ;
		}

		public function RemovePlaylistElement($pid, $aud_id)
		{
			$result = mysql_query("select playlist from playlists where playlist_id='".$pid."';", $this->db_link_id);

			if (mysql_num_rows($result) > 0)
			{
				//echo($aud_id."<BR/>") ;
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$playlist_array = explode(";", $row["playlist"]) ;
				/*echo("<PRE>");
				print_r($playlist_array) ;
				echo("</PRE>") ;*/
				if(in_array($aud_id, $playlist_array))
				{
					//echo(array_search($aud_id, $playlist_array)) ;
					array_splice($playlist_array, array_search($aud_id, $playlist_array), 1) ;

					/*echo("<BR/><PRE>");
					print_r($playlist_array) ;
					echo("</PRE><BR/>") ;*/
					$playlists = implode(';',$playlist_array);

					$qry = sprintf("update playlists set playlist='%s' where playlist_id='%s';", $playlists, $pid) ;
					mysql_query($qry, $this->db_link_id);
				}
			}
			mysql_free_result($result);
		}

		public function RemoveBookmark($user_id, $aud_id)
		{
			$result = mysql_query("select bookmarks from bookmarks where user_id='".$user_id."';", $this->db_link_id);

			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$bookmark_array = explode(";", $row["bookmarks"]) ;
				/*echo("<PRE>");
				print_r($bookmark_array) ;
				echo("</PRE>") ;*/
				if(in_array($aud_id, $bookmark_array))
				{
					//echo(array_search($aud_id, $bookmark_array)) ;
					array_splice($bookmark_array, array_search($aud_id, $bookmark_array), 1) ;

					/*echo("<BR/><PRE>");
					print_r($bookmark_array) ;
					echo("</PRE><BR/>") ;*/
					$bookmarks = implode(';',$bookmark_array);

					$qry = sprintf("update bookmarks set bookmarks='%s' where user_id='%s';", $bookmarks, $user_id) ;
					mysql_query($qry, $this->db_link_id);
				}
			}
			mysql_free_result($result);
		}

		public function GetPlaylistInfo($pid, &$playlist_id_list, &$playlist_title_list)
		{
			$result = mysql_query("select playlist from playlists where playlist_id='".$pid."';", $this->db_link_id);

			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC) ;
				$playlist_ary = explode(";", $row["playlist"]) ;
				$playlist_id_list = $row["playlist"] ;

				$index = 1 ;
				$row_count = count($playlist_ary) ;
				foreach ($playlist_ary as $aud_id)
				{
					$mp3_result = mysql_query("select title from mp3_info where id='".$aud_id."';", $this->db_link_id) ;

					while($mp3_row = mysql_fetch_array($mp3_result, MYSQL_ASSOC))
					{
						if($row_count != $index)
						{
							$playlist_title_list .= $mp3_row["title"] . ";" ;
						}
						else
						{
							$playlist_title_list .= $mp3_row["title"] ;
						}
					}
					$index++ ;
					mysql_free_result($mp3_result ) ;
				}
			}
			mysql_free_result($result);

			return true ;
		}

		public function GetAlbumSongList($albumname, &$album_songid_list, &$album_songtitle_list)
		{
		    $albumname = urldecode($albumname);
			$mp3_result = mysql_query("select id, title from mp3_info where album= '".$albumname."';", $this->db_link_id) or die("Query fail: " . mysql_error());
			$numsongs = mysql_num_rows($mp3_result);
			if($numsongs > 0)
			{
			$index  = 1;
			while($mp3_row = mysql_fetch_array($mp3_result, MYSQL_ASSOC))
			  {
				if($numsongs != $index)
				{
				 $album_songtitle_list .= $mp3_row["title"] . ";" ;
				 $album_songid_list .= $mp3_row["id"] . ";" ;
				}
				else
				{
				$album_songtitle_list .= $mp3_row["title"] ;
				$album_songid_list .= $mp3_row["id"] ;
				}
				$index++ ;
			  }
            mysql_free_result($mp3_result );
			return 1 ;
		   }
		   else
		   {
               mysql_free_result($mp3_result );
			   return 0;
		   }

		}

		public function InsertIntoMP3PlayLocation($mp3_id, $ip)
		{
			$bResult = mysql_query("insert into mp3_play_location (mp3_id, ip_addr) values ('$mp3_id', '$ip') ;", $this->db_link_id) or die("mp3_play_location Insert Error: ".mysql_error($this->db_link_id));
		}
		 /*Check and Remove invalid entries*/
		 public function CheckandRemoveInvalid()
		 {
			 $cnt = 0;
			 $bFileExists = false;
			 $result = mysql_query("select * from mp3_info;");
			 while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			 {
						$AUDIO_ROOT =  getcwd(). '/ect'; // 'F:/MGooS/donn/ect';
						$MAXFOLDER = 10;
						$totalrow++;
						/*/home/mgooscom/public_html/donn/ect/00027293-6d8e-0b94-393a-d8487d47b92a */
					    $filepath =$row["filepath"];
					    list($blank,$home,$root,$public,$donn,$ect,$filename)= split('[/]',$filepath);
						for($i=1; $i<$MAXFOLDER; $i++)
						{
							$physicalfilepath = $AUDIO_ROOT .$i. "/". $filename;
							 if(file_exists($physicalfilepath))
							 {
								$bFileExists = true;
								$ctr++;
								break;
							 }
							 else
							 {
							 $bFileExists = false;
							 }
						}
						if(!$bFileExists)
							{
							 $id = $row["id"];
      					   mysql_query("delete from mp3_info where id='".$id."';", $this->db_link_id) or die("Remove Mp3 enrty Error: ".mysql_error($this->db_link_id));
							if( mysql_affected_rows($this->db_link_id) > 0 )
								{
								// Remove the entry from mp3_metaphone_info as well.
								mysql_query("delete from mp3_metaphone_info where id='".$id."';", $this->db_link_id) ;
								// Now remove file from the disk (@ for suppressing error/warning message).
							}
							 $cnt++; /* increase invalid count*/
							}
						}
			mysql_free_result($result);
		 	return $cnt;
		 }

		 public function MakeProperEntries()
		 {
			 $cnt = 0;
			 $bFileExists = false;
			 $result = mysql_query("select * from mp3_info;");
			 while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			 {
						$AUDIO_ROOT = getcwd(). '/ect'; //'F:/MGooS/donn/ect'; //getcwd(). '/ect'; //
						$MAXFOLDER = 10;
						$totalrow++;
						/*/home/mgooscom/public_html/donn/ect/00027293-6d8e-0b94-393a-d8487d47b92a */
					    $filepath = $row["filepath"];
					    list($blank,$home,$root,$public,$donn,$ect,$filename)= split('[/]',$filepath);
						for($i=1; $i<$MAXFOLDER; $i++)
						{
							$physicalfilepath = $AUDIO_ROOT .$i. "/". $filename;
							 if(file_exists($physicalfilepath))
							 {
								$bFileExists = true;
								$actualpath = '/'.$home.'/'. $root .'/'.$public.'/'.$donn.'/'.$ect . $i . '/' . $filename;
								 $id = $row["id"];
            					 mysql_query("update mp3_info set filepath = '".$actualpath. "' where id='".$id."';", $this->db_link_id) or die("Remove Mp3 enrty Error: ".mysql_error($this->db_link_id));
								 if( mysql_affected_rows($this->db_link_id) > 0 )
								 {
								  $cnt++;
								 }
								 break;
							 }
					     }
			  }
			  mysql_free_result($result);
		     	return $cnt;
		  }

			public function removeinvalidfiles()
		  	{
				// open the current directory by opendir
				$AUDIO_ROOT =  getcwd(). '/ect'; //'F:/MGooS/donn/ect';
			  	$serverroot = '/home/mgooscom/public_html/donn/';
			  	$firstleveldir = 'ect';
				$count = 0;
				for($i=1; $i<10; $i++)
				{
	     			$physicalfilepath = $AUDIO_ROOT .$i. "/";
					$handle=opendir($physicalfilepath);
					while (($file = readdir($handle))!==false)
					{
						$dbfilepath = $serverroot. $firstleveldir . $i ."/" . $file;
						$query = "select * from mp3_info where filepath= '".$dbfilepath."';";
						echo($query); echo("</br>");
						$result = mysql_query("select * from mp3_info where filepath= '".$dbfilepath."';", $this->db_link_id) or die("Query fail: " . mysql_error());
						if (mysql_num_rows($result) == 0)
						{
							$count++;
						}
					}
					closedir($handle);
			    }
				return $count;
			}

			public function InsertIntoAdminMP3Info($file, $filesize,
													$bitrate, $duration_sec,
													$year, 	$genre, $mood,
													$title, $artist,
													$album, $lang)
			{
				//echo "inserting into admin mp3 info ".$file." ".$filesize." ".$bitrate." ".$duration_sec." ".$year." ".$genre." ".$mood." ".$title." ".$artist." ".$album." ".$lang;

				mysql_query("insert into mp3_upload_info (file, title, artist, album, year, genre, mood, language, filesize, bitrate, duration_sec) values ('".$file."','".$title."','".$artist."','".$album."','".$year."','".$genre."','".$mood."','".$lang."','".$filesize."','".$bitrate."','".$duration_sec."') ;", $this->db_link_id) or die("mp3_info Insert Error: ".mysql_error($this->db_link_id));
			}

			public function SelectRowFromAdminMP3Info($index)
			{
				//echo "select * from mp3_upload_info limit ".$index.",".($index+1);
				$mp3_row["result"] = 0;
				$mp3_row["elements"] = 0;
				$mp3_result = mysql_query("select * from mp3_upload_info limit ".$index.",".($index+1)) or die("mp3_upload_info select error: ".mysql_error($this->db_link_id));

				if(mysql_num_rows($mp3_result) > 0)
				{
					$mp3_row = mysql_fetch_array($mp3_result, MYSQL_ASSOC);
					mysql_free_result($mp3_result);
					$mp3_row["result"] = 1;

					$mp3_result = mysql_query("select count(*) as count from mp3_upload_info") or die("mp3_upload_info select count error: ".mysql_error($this->db_link_id));
					$row = mysql_fetch_array($mp3_result, MYSQL_ASSOC);
					$mp3_row["elements"] = $row["count"];
				}
				
				return $mp3_row;
			}
			
			public function ListAlphabet($alphabet, $columns, $tabbed = false)
			{
				$result = mysql_query("select distinct album from mp3_info where album like '".$alphabet."%' and provider <> 'http://www.mgoos.com'") or die("mp3_info select error: ".mysql_error($this->db_link_id));
				
				$index = 0 ;
				$url = "" ;
				//$columns = 4 ;
				echo "<TABLE WIDTH=\"100%\" BORDER=\"0\" CELLSPACING=\"2\" CELLPADDING=\"5\">" ;
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					if($index == 0 || $index%$columns == 0)
					{
						echo "<TR ALIGN=\"Center\">" ;
					}
					
					if($tabbed)
					{
						$url = "tab_search_results.php?qry=".urlencode($row["album"])."&pg=1&ext=album&strict=true" ;
					}
					else
					{
						$url = "search_results.php?srchtxt=".urlencode($row["album"])."&ext=album&strict=true" ;
					}
					
					printf("<TD ALIGN=\"LEFT\"><B><A HREF=\"%s\">%s</A></B></TD>", $url, $row["album"]) ;
					
					$index++ ;

					if($index != 0 && $index%$columns == 0)
					{
						echo "</TR>" ;
					}					
				}
				echo "</TABLE>";
			}
		}
?>