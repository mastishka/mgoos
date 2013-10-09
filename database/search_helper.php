<?php
	//include("double_metaphone_class_1_01.php") ;
	include("shortenurl.php");
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
		
		static function ProcessHindiPhonetic($word)
		{
			/* Eliminate Double Characters */
			$word=strtolower($word);
			$k=1;
			$word1="D";	
			$n=strlen($word);
			$word1[0]=$word[0];
			for($i=1;$i<=($n-1);$i++)
			{
				if($word[$i]!='e' && $word[$i]!='o')
				{
					if($word[$i]==$word[$i-1]);
					else $word1[$k++]=$word[$i];
				}
				else $word1[$k++]=$word[$i];
			}
			
			
			
			/* Process the word */
			
			$word=$word1;
			$n=strlen($word);
			$result="S";
			$k=0;
			//if($word[0]=='e') $word[0]='i';
			if($word=="mein" || $word=="main")
			{
				$result="me";
			}
			else if($word=="hain" || $word=="hai")
			{
				$result="he";
			}
			else if ($word=="hun" || $word=="hoon")
			{
				$result="hu";
			}
			else 
			{
			for($i=0;$i<(strlen($word)+1);$i++)
			{
                                switch($word[$i])
                                                {
                                                    case 'a' :
																if($i==0)
																{
																	//$result[$k++]='a';
															
																	if($word[$i+1]=='e')
                                                                    {
																		//echo Hello;
                                                                         $result[$k++]='e';
                                                                         $i++;
                                                                    }
																	else if($word[$i+1]=='i')
                                                                    {
                                                                                      if($i+2==$n)
                                                                                      {
                                                                                                         $result[$k++]='a';
                                                                                                         $result[$k++]='i';
                                                                                                         $i++;
                                                                                      }
                                                                                      else 
                                                                                      {
                                                                                           $result[$k++]='e';
                                                                                           $i++;
                                                                                      }
                                                                    }
                                                                    else if($word[$i+1]=='y' && $i+2==$n)
                                                                    {
                                                                         $result[$k++]='a';
                                                                         $result[$k++]='i';
                                                                         $i++;
                                                                    }
                                                                    
                                                                    else if($word[$i+1]=='u')
                                                                    {
                                                                         $result[$k++]='o';
                                                                         $i++;
                                                                    }
																	else if($i+1==$n)
																	{
																		$result[$k++]='a';
																	}
																	else $result[$k++]='a';
																}
																else 
																{
																if($word[$i+1]=='e')
                                                                    {
																		//echo Hello;
                                                                         $result[$k++]='e';
                                                                         $i++;
                                                                    }
																	else if($word[$i+1]=='i')
                                                                    {
                                                                                      if($i+2==$n)
                                                                                      {
                                                                                                         $result[$k++]='a';
                                                                                                         $result[$k++]='i';
                                                                                                         $i++;
                                                                                      }
                                                                                      else 
                                                                                      {
                                                                                           $result[$k++]='e';
                                                                                           $i++;
                                                                                      }
                                                                    }
                                                                    else if($word[$i+1]=='y' && $i+2==$n)
                                                                    {
                                                                         $result[$k++]='a';
                                                                         $result[$k++]='i';
                                                                         $i++;
                                                                    }
                                                                    
                                                                    else if($word[$i+1]=='u')
                                                                    {
                                                                         $result[$k++]='o';
                                                                         $i++;
                                                                    }
																	else if($i+1==$n)
																	{
																		$result[$k++]='a';
																	}
																}
                                                                    break;
                                                                   
                                                    case 'b' : $result[$k++]='b'; break;
                                                    case 'c' : $result[$k++]='c'; break;
                                                    case 'd' : $result[$k++]='d'; break;
                                                    case 'e' :              if($i==0)
																			{
																				$result[$k++]='i';
																			}
                                                                             else if($word[$i+1]=='e')
                                                                             {
                                                                                               if($word[$i+2]=='y');
                                                                                               else $result[$k++]='i';
                                                                                               $i++;
                                                                             }
                                                                             else if($word[$i+1]=='i' && $word[$i+2]=='n')
                                                                             {
                                                                                              $result[$k++]='e';
                                                                                              $i=$i+2;
                                                                             }
                                                                             else if($word[$i+1]=='i')
                                                                             {
                                                                                  $result[$k++]='i';
                                                                                  $i++;
                                                                             }
                                                                             else $result[$k++]='e'; 
																			
                                                                             break;
                                                                 
                                                    case 'f' : $result[$k++]='f'; break;
                                                    case 'g' : if($word[$i+1]=='h')
																{
																	$result[$k++]='g';
																	$i++;
																}
																else $result[$k++]='g'; break;
                                                    case 'h' : 
                                                                
                                                                if($i+1==$n && ($word[$i-1]=='a' || $word[$i-1]=='e' || $word[$i-1]=='g' || $word[$i-1]=='j' || $word[$i-1]=='u'));
                                                                else $result[$k++]='h';
                                                                break;
                                                                
                                                    case 'i' : if($word[$i+1]=='y') ;
                                                               
                                                               else $result[$k++]='i'; break;
                                                    case 'j' : if($word[$i+1]=='h')
																{
																	$result[$k++]='j';
																	$i++;
																}
																else $result[$k++]='j'; break;
                                                    case 'k' : $result[$k++]='k'; break;
                                                    case 'l' : $result[$k++]= 'l'; break;
                                                    case 'm' : $result[$k++]='m'; break;
                                                    case 'n' : $result[$k++]='n'; break;
                                                    case 'o' : 
                                                             if($word[$i+1]=='n' && $i==$n-2)
															{
																$result[$k++]='o';
																$i++;
															}
                                                            else if($word[$i+1]=='w' || $word[$i+1]=='v' || $word[$i+1]=='u')
                                                             {
                                                                               
                                                                               $result[$k++]='o';
                                                                               $i++;
                                                             }
                                                             else if($word[$i+1]=='o')
                                                             {
                                                                  if($word[$i-1]=='r' && ($word[$i-2]=='m' || $word[$i-2]=='n' || $word[$i-2]=='v' || $word[$i-2]=='b' || $word[$i-2]=='g' || $word[$i-2]=='k'))
                                                               {
                                                                    $result[$k++]='i';
                                                               }
                                                               else               $result[$k++]='u';
                                                                              $i++;
                                                             }   
                                                             else $result[$k++]='o'; break;
                                                    case 'p' : 
                                                               if ($word[$i+1]=='h')
                                                               {
                                                                                 $result[$k++]='f';
                                                                                 $i++;
                                                               }
                                                               else $result[$k++]='p';
                                                               break;
                                                               
                                                    case 'q' : $result[$k++]='k'; break;
                                                    case 'r' : $result[$k++]='r'; break;
                                                    case 's' : if($word[$i+1]=='h')
																{
																	$result[$k++]='s';
																	$i++;
																}
																else $result[$k++]='s'; break;
                                                    case 't' : if($word[$i+1]=='h')
																{
																	$result[$k++]='t';
																	$i++;
																}
																else $result[$k++]='t'; break;
                                                    case 'u' : 
                                                         if($word[$i-1]=='r' && ($word[$i-2]=='m' || $word[$i-2]=='n' || $word[$i-2]=='v' || $word[$i-2]=='b' || $word[$i-2]=='g' || $word[$i-2]=='k'))
                                                               {
                                                                    $result[$k++]='i';
                                                               }
                                                               else $result[$k++]='u'; break;            
                                                    case 'v' : $result[$k++]='v'; break;
                                                    case 'w' : $result[$k++]='v'; break;
                                                    case 'x' : 
                                                                $result[$k++]='k';
                                                                $result[$k++]='s';
                                                                break;
                                                                
                                                   case 'y' : 
                                                               if($i==strlen($word)-1)
                                                               $result[$k++]='i';
                                                               else $result[$k++]='y';
                                                               break;
                                                   case 'z' :  if($word[$i+1]=='h')
																{
																	$result[$k++]='g';
																	$i++;
																}
																else $result[$k++]='j'; break;
                                                   case '1' : $result[$k++]='1'; break;
												   case '2' : $result[$k++]='2'; break;
												   case '3' : $result[$k++]='3'; break;
												   case '4' : $result[$k++]='4'; break;
												   case '5' : $result[$k++]='5'; break;
												   case '6' : $result[$k++]='6'; break;
												   case '7' : $result[$k++]='7'; break;
												   case '8' : $result[$k++]='8'; break;
												   case '9' : $result[$k++]='9'; break;
												   case '0' : $result[$k++]='0'; break;
												   default : ;
                                                }
                                }
			}
                                return $result;
		}
		static function GetHindiPhonetic($str)
		{
			$word_arr = str_word_count($str, 1,0123456789) ;
			$meta_str = "";
			
			foreach ($word_arr as $word)
			{
				$meta_str .= CSearchHelper::ProcessHindiPhonetic($word)." " ;
//				$meta_str .= exec ("C:\purav.exe ".$word);
			}
			
			return $meta_str;
		}
		public function PrepareWildQuery($wordArray)
		{
			$metaphoneAry = array() ;
			$field_array = array("artist", "album", "title", "year", "genre", "composer", "picturizedon", "lyrics") ;
			foreach($wordArray as $word)
			{
				$wordString .= $word." ";
			}
			$sqlQuery = "select mp3_info.id, mp3_info.artist, mp3_info.album, mp3_info.title, mp3_info.year, mp3_info.duration_sec, mp3_info.genre, mp3_info.composer, mp3_info.picturizedon, mp3_info.lyrics, mp3_info.provider, mp3_info.user_id, mp3_info.filepath, mp3_info.plays, (" ;
			$whereClause = "where (" ;
			$word_count = count($wordArray) * count($field_array) ;
			
			if(count($wordArray) > 0)
			{
				$word_index = 0 ;
				foreach($wordArray as $word)
				{
					//$metaphoneAry[$word_index] = metaphone($word) ;
					$metaphoneAry[$word_index] = CSearchHelper::ProcessHindiPhonetic($word) ;
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
							 //$sqlQuery .= "if(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' is null, 0, mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' )" ;
							 //$whereClause .= "(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;							
							 $sqlQuery .= "if(mp3_hphonetic_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' is null, 0, mp3_hphonetic_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' )" ;
							 $whereClause .= "(mp3_hphonetic_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;
							
						}
						else
						{
							
							if($wordArray[$word_index] == "'")
							{
							$wordArray[$word_index] = "";
							}							
							//$sqlQuery .= "if(mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]' is null, 0, mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]' )" ;
							//$whereClause .= "(mp3_info.".$field." REGEXP '[[:<:]]".$wordArray[$word_index]."[[:>:]]') " ;
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
							$sqlQuery .= ") AS score from mp3_info, mp3_hphonetic_info ".$whereClause.") AND (mp3_info.id = mp3_hphonetic_info.id) GROUP BY mp3_info.id ORDER BY score DESC;" ;
						}
						$word_index++ ;
						
					}
				}
			}
			else
			{
				$sqlQuery = "select id, filepath, artist, album, title, year, time, genre, composer, lyrics, provider, plays, user_id from mp3_info order by title asc" ;
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
			// echo ($sqlQuery) ;
			// - - - - - - - - - - - -			
			// Levenshtein Distance First Code
			/*foreach($wordArray as $word)
			{
				$wordString .= $word." ";
			}
			
			//echo Hello;	
			$CreateQuery = "create table distance(id varchar(40), levenshtein int(4))";
			mysql_query($CreateQuery,$con);
			$sql = "select * from mp3_info";
			echo Pre;
			$result = mysql_query($sql,$con);
			echo Post;
			$count = 0;
			while ($row = mysql_fetch_object($result))
			{
				$count++;
				$id = $row->$id ;
				$dist = 0 ;
				$dist += 800*(1-(levenshtein($wordString,$row->title))/(max(strlen($wordString),strlen($row->title))));
				$dist += 700*(1-(levenshtein($wordString,$row->album))/(max(strlen($wordString),strlen($row->album))));
				$dist += 600*(1-(levenshtein($wordString,$row->artist))/(max(strlen($wordString),strlen($row->artist))));
				$dist += 500*(1-(levenshtein($wordString,$row->lyrics))/(max(strlen($wordString),strlen($row->lyrics))));
				$dist += 400*(1-(levenshtein($wordString,$row->picturizedon))/(max(strlen($wordString),strlen($row->picturizedon))));
				$dist += 300*(1-(levenshtein($wordString,$row->composer))/(max(strlen($wordString),strlen($row->composer))));
				mysql_query("insert into distance values ('".$id."','".$dist."')",$con);
			}
			
			
			echo $count;*/
			
			return $sqlQuery ;
		}
		
		function PrepareFieldQuery($wordArray,$field)
		{
			$metaphoneAry = array();
			$field_array = array("artist", "album", "title", "year", "genre", "composer", "picturizedon", "lyrics") ;
			$sqlQuery = "select mp3_info.id, mp3_info.artist, mp3_info.album, mp3_info.title, mp3_info.year, mp3_info.duration_sec, mp3_info.genre, mp3_info.composer, mp3_info.picturizedon, mp3_info.lyrics, mp3_info.provider, mp3_info.user_id, mp3_info.filepath, mp3_info.plays, (" ;
			$whereClause = "where (";			
			$word_count = count($wordArray);
			if($word_count  > 0)
			{
				$word_index = 0 ;
				foreach($wordArray as $word)
				{
					//$metaphoneAry[$word_index] = metaphone($word) ;					
					$metaphoneAry[$word_index] = CSearchHelper::ProcessHindiPhonetic($word) ;					
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
					
						//$sqlQuery .= "if(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' is null, 0, mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' )" ;
						//$whereClause .= "(mp3_metaphone_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;
						$sqlQuery .= "if(mp3_hphonetic_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' is null, 0, mp3_hphonetic_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]' )" ;
						$whereClause .= "(mp3_hphonetic_info.".$field." REGEXP '[[:<:]]".$metaphoneAry[$word_index]."[[:>:]]') " ;
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
				//$sqlQuery .= ") AS score from mp3_info, mp3_metaphone_info ".$whereClause.")  AND (mp3_info.id = mp3_metaphone_info.id) GROUP BY mp3_info.id order by score DESC;" ;
				$sqlQuery .= ") AS score from mp3_info, mp3_hphonetic_info ".$whereClause.")  AND (mp3_info.id = mp3_hphonetic_info.id) GROUP BY mp3_info.id order by score DESC;" ;
			
			}
			else
			{	
				$sqlQuery = "select id, filepath, artist, album, title, year, time, genre, composer, lyrics, provider, plays, user_id from mp3_info order by title asc" ;
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

		public function browseAlbumRadio($page, $user_id,$pageno)
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
			$href = "radio_search_results.php?browse_album=true&pg=" .$page."&"; 

			CUTils::PreparePaging($pageno,$row_count,$href,"",true);
				
			$query = "select DISTINCT album, year, count(title) as count from mp3_info where album LIKE '".$page."%' group by album LIMIT " .$startoffset. ",".$endoffset. ";" ;
			$result = mysql_query($query, $this->db_link_id) ;																		
			printf("<UL>");				
			
			
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				printf("<LI><B>Album :</B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A> &nbsp;&nbsp;<INPUT TYPE='button' VALUE =' Load Album' ID='APPEND' name='APPEND' OnClick =\"TSR.OnLoadAlbum('%s'); \"/>  <BR/><B>Year :</B> %s<BR/><B>Audio Files :</B> %s</LI><BR/>", urlencode($row["album"]), $row["album"],urlencode($row["album"]), $row["year"], $row["count"]) ;
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

		public function showRecentUploadsRadio($page, $user_id)
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
					printf("<LI><B>Album :</B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A> &nbsp;&nbsp;<INPUT TYPE='button' VALUE =' Load Album' ID='APPEND' name='APPEND' OnClick =\"TSR.OnLoadAlbum('%s'); \"/>  <BR/><B>Year :</B> %s<BR/><B>Audio Files :</B> %s</LI><BR/>", urlencode($row["album"]), $row["album"],urlencode($row["album"]), $row["year"], $row["count"]) ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			mysql_free_result($result);
			return $index;
		}
		
		public function showLastWeekPopular($page, $user_id)
		{
			$query = "SELECT DISTINCT id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, filepath, plays as play_count, user_id, count( mp3_info.id ) AS plays FROM mp3_info, mp3_play_location WHERE (mp3_info.id = mp3_play_location.mp3_id) AND (mp3_play_location.play_datetime > DATE_SUB( NOW( ) , INTERVAL 7 DAY )) GROUP BY id ORDER BY plays DESC;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					printf("<script type='text/javascript'>
					$(function() {
						$(\".hint%d\").callout({ show: false, css: 'blue', position: 'right', msg: \"<div class='callout%d'>Feel Free to Correct!<hr><form name='citation%d' method='post'><table><TR><TD><input type='hidden' id='songid%d' readonly='readonly' value='%s'/></TD></TR><TR><TD>Song Name</TD><TD><input type='text' id='songname%d'/></TD><TD>Album Name</TD><TD><input type='text' id='album%d'/></TD></TR><TR><TD>Artist Name</TD><TD><input type='text' id='artist%d'/></TD><TD>Genre</TD><TD><input type='text' id='genre%d'/></TD></TR><TR><TD>Language</TD><TD><input type='text' id='language%d'/></TD><TD>Composer</TD><TD><input type='text' id='composer%d'/></TD></TR><TR><TD>Picturized On</TD><TD><input type='text' id='pict%d'/></TD><TD>Year</TD><TD><input type='text' id='year%d'/></TD></TR></form></TABLE><hr><button id='submit%d' value='somevalue'>Submit</button></div>\"});
						$('button').click(function() {
							$($(this).attr('id')).callout('hide');
						});
						$('button').click(function() {
							if(($(this).attr('id')) == 'submit%d')
							{
								var poststr = 'id='+$(songid%d).attr('value')+'&title='+$(songname%d).attr('value')+'&album='+$(album%d).attr('value')+'&artist='+$(artist%d).attr('value')+'&genre='+$(genre%d).attr('value')+'&language='+$(language%d).attr('value')+'&composer='+$(composer%d).attr('value')+'&pict='+$(pict%d).attr('value')+'&year='+$(year%d).attr('value');
								AJAX.MakePostRequest(\"../ajax/insert_citation.php\", poststr, this.callback_empty);
							}
						});
						$('.hint%d').mouseenter(function() {
						$(this).callout('show');
						});
						$('.callout%d').mouseenter(function() {
		
						}).mouseleave(function() {
						$('.hint%d').callout('hide');
						});
						});
						callback_empty : function()
						{
							var contents = AJAX.GetContents() ;
						}	
						</script>",$listing,$listing,$listing,$listing,$row["id"],$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing);
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing,urlencode($row["album"]), $row["album"], $row["play_count"], $index,$index,$index,$row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div><BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["play_count"], $index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["play_count"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
						
					/*if(strcmp($row["provider"], "http://www.songs.pk") == 0)
					{
						//echo "Test 1 - ".$row["user_id"]."<BR/>";
						$provider_res = mysql_query("select mp3_url from songs_pk_mp3s where id='".$row["user_id"]."'", $this->db_link_id) ;
						
						if(mysql_num_rows($provider_res) > 0)
						{
							//echo "Test 2<BR/>";
							$pro_row = mysql_fetch_array($provider_res, MYSQL_ASSOC) ;
							printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $pro_row["mp3_url"], $pro_row["mp3_url"]) ;
						}
						
						mysql_free_result($provider_res) ;
					}
					else */
					//if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					//{
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					//}

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
							
			if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<DIV NAME='Download_Captcha_%d' ID='Download_Captcha_%d'><A href='javascript:;' onClick=\"TSR.Captcha('%d');\"><b>Download!</b></A></div>",$listing,$listing,$listing);
						printf("<div id='Show_Captcha_%d' STYLE='display:none;' name='Show_Captcha_%d' class='err'>",$listing,$listing);
						echo "<form method='POST' name='contact_form' action='../captcha/html-contact-form.php'>";
						echo "<p>";
						echo "<img src='../captcha/captcha_code_file.php?rand=<?php echo rand(); ?>' id='captchaimg".$listing."'><br>";
						echo "<label for='message'>Enter the code above here :</label><br>";
						echo "<input id='url' name='url' STYLE='display:none;' value='".$row["id"]."' type='text'><br>";
						echo "<input id='6_letters_code' name='6_letters_code' type='text'><br>";
						echo "<small>Cannot read the image? click <a href='javascript: refreshCaptcha(".$listing.");'>here</a> to refresh</small>";
						echo "</p>";
						echo "<input type='submit' value='Download' name='submit'>";
						echo "</form></div>";
						echo "<script language='JavaScript' type='text/javascript'>";
						echo "function refreshCaptcha(entryIndex)
						{
							var img = document.images['captchaimg'+entryIndex];
							img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
						}
						</script>";
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}
					$tweet=shorten_url(urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1'));
					echo "<table cellspacing='10'><tr><td>";
					printf("<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url='%s' data-text='%s --> ' data-count=\"none\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>",$tweet,$row["title"]);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='small-button' data-locale='en_IN' data-url='%s'></a><script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>",$tweet);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone count='false' href='%s' size='medium'></g:plusone>",$tweet);
					echo "</td></tr></table>";
					printf ("<iframe src=\"http://www.facebook.com/plugins/like.php?href=%s\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; width:450px; height:60px\"></iframe>",urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1')) ;
					$listing++ ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}

		public function showLastWeekPopularRadio($page, $user_id)
		{
			$query = "SELECT DISTINCT id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, filepath, plays as play_count, user_id, count( mp3_info.id ) AS plays FROM mp3_info, mp3_play_location WHERE (mp3_info.id = mp3_play_location.mp3_id) AND (mp3_play_location.play_datetime > DATE_SUB( NOW( ) , INTERVAL 7 DAY )) GROUP BY id ORDER BY plays DESC;" ;
			
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
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["play_count"], $index,$index,$index,$row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["play_count"], $index,$index,$index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["play_count"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					/*if(strcmp($row["provider"], "http://www.songs.pk") == 0)
					{
						//echo "Test 1 - ".$row["user_id"]."<BR/>";
						$provider_res = mysql_query("select mp3_url from songs_pk_mp3s where id='".$row["user_id"]."'", $this->db_link_id) ;
						
						if(mysql_num_rows($provider_res) > 0)
						{
							//echo "Test 2<BR/>";
							$pro_row = mysql_fetch_array($provider_res, MYSQL_ASSOC) ;
							printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $pro_row["mp3_url"], $pro_row["mp3_url"]) ;
						}
						
						mysql_free_result($provider_res) ;
					}
					else */
					/*if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}*/

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
			$query = "SELECT DISTINCT id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, plays as play_count, user_id, filepath, count( mp3_info.id ) AS plays FROM mp3_info, mp3_play_location WHERE (mp3_info.id = mp3_play_location.mp3_id) AND (mp3_play_location.play_datetime = NOW()) GROUP BY id ORDER BY plays DESC;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					printf("<script type='text/javascript'>
					$(function() {
						$(\".hint%d\").callout({ show: false, css: 'blue', position: 'right', msg: \"<div class='callout%d'>Feel Free to Correct!<hr><form name='citation%d' method='post'><table><TR><TD><input type='hidden' id='songid%d' readonly='readonly' value='%s'/></TD></TR><TR><TD>Song Name</TD><TD><input type='text' id='songname%d'/></TD><TD>Album Name</TD><TD><input type='text' id='album%d'/></TD></TR><TR><TD>Artist Name</TD><TD><input type='text' id='artist%d'/></TD><TD>Genre</TD><TD><input type='text' id='genre%d'/></TD></TR><TR><TD>Language</TD><TD><input type='text' id='language%d'/></TD><TD>Composer</TD><TD><input type='text' id='composer%d'/></TD></TR><TR><TD>Picturized On</TD><TD><input type='text' id='pict%d'/></TD><TD>Year</TD><TD><input type='text' id='year%d'/></TD></TR></form></TABLE><hr><button id='submit%d' value='somevalue'>Submit</button></div>\"});
						$('button').click(function() {
							$($(this).attr('id')).callout('hide');
						});
						$('button').click(function() {
							if(($(this).attr('id')) == 'submit%d')
							{
								var poststr = 'id='+$(songid%d).attr('value')+'&title='+$(songname%d).attr('value')+'&album='+$(album%d).attr('value')+'&artist='+$(artist%d).attr('value')+'&genre='+$(genre%d).attr('value')+'&language='+$(language%d).attr('value')+'&composer='+$(composer%d).attr('value')+'&pict='+$(pict%d).attr('value')+'&year='+$(year%d).attr('value');
								AJAX.MakePostRequest(\"../ajax/insert_citation.php\", poststr, this.callback_empty);
							}
						});
						$('.hint%d').mouseenter(function() {
						$(this).callout('show');
						});
						$('.callout%d').mouseenter(function() {
		
						}).mouseleave(function() {
						$('.hint%d').callout('hide');
						});
						});
						callback_empty : function()
						{
							var contents = AJAX.GetContents() ;
						}	
						</script>",$listing,$listing,$listing,$listing,$row["id"],$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing);
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["play_count"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["play_count"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["play_count"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					//if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					//{
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					//}
					
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
							
			if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<DIV NAME='Download_Captcha_%d' ID='Download_Captcha_%d'><A href='javascript:;' onClick=\"TSR.Captcha('%d');\"><b>Download!</b></A></div>",$listing,$listing,$listing);
						printf("<div id='Show_Captcha_%d' STYLE='display:none;' name='Show_Captcha_%d' class='err'>",$listing,$listing);
						echo "<form method='POST' name='contact_form' action='../captcha/html-contact-form.php'>";
						echo "<p>";
						echo "<img src='../captcha/captcha_code_file.php?rand=<?php echo rand(); ?>' id='captchaimg".$listing."'><br>";
						echo "<label for='message'>Enter the code above here :</label><br>";
						echo "<input id='url' name='url' STYLE='display:none;' value='".$row["id"]."' type='text'><br>";
						echo "<input id='6_letters_code' name='6_letters_code' type='text'><br>";
						echo "<small>Cannot read the image? click <a href='javascript: refreshCaptcha(".$listing.");'>here</a> to refresh</small>";
						echo "</p>";
						echo "<input type='submit' value='Download' name='submit'>";
						echo "</form></div>";
						echo "<script language='JavaScript' type='text/javascript'>";
						echo "function refreshCaptcha(entryIndex)
						{
							var img = document.images['captchaimg'+entryIndex];
							img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
						}
						</script>";
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}
					$tweet=shorten_url(urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1'));
					echo "<table cellspacing='10'><tr><td>";
					printf("<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url='%s' data-text='%s --> ' data-count=\"none\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>",$tweet,$row["title"]);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='small-button' data-locale='en_IN' data-url='%s'></a><script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>",$tweet);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone count='false' href='%s' size='medium'></g:plusone>",$tweet);
					echo "</td></tr></table>";
					printf ("<iframe src=\"http://www.facebook.com/plugins/like.php?href=%s\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; width:450px; height:60px\"></iframe>",urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1')) ;		$listing++ ;
				}

				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}
		
		public function showPopular($page, $user_id)
		{
			$query = "select id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, filepath, user_id, plays from mp3_info where plays <> 0 ORDER BY plays DESC;" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					printf("<script type='text/javascript'>
					$(function() {
						$(\".hint%d\").callout({ show: false, css: 'blue', position: 'right', msg: \"<div class='callout%d'>Feel Free to Correct!<hr><form name='citation%d' method='post'><table><TR><TD><input type='hidden' id='songid%d' readonly='readonly' value='%s'/></TD></TR><TR><TD>Song Name</TD><TD><input type='text' id='songname%d'/></TD><TD>Album Name</TD><TD><input type='text' id='album%d'/></TD></TR><TR><TD>Artist Name</TD><TD><input type='text' id='artist%d'/></TD><TD>Genre</TD><TD><input type='text' id='genre%d'/></TD></TR><TR><TD>Language</TD><TD><input type='text' id='language%d'/></TD><TD>Composer</TD><TD><input type='text' id='composer%d'/></TD></TR><TR><TD>Picturized On</TD><TD><input type='text' id='pict%d'/></TD><TD>Year</TD><TD><input type='text' id='year%d'/></TD></TR></form></TABLE><hr><button id='submit%d' value='somevalue'>Submit</button></div>\"});
						$('button').click(function() {
							$($(this).attr('id')).callout('hide');
						});
						$('button').click(function() {
							if(($(this).attr('id')) == 'submit%d')
							{
								var poststr = 'id='+$(songid%d).attr('value')+'&title='+$(songname%d).attr('value')+'&album='+$(album%d).attr('value')+'&artist='+$(artist%d).attr('value')+'&genre='+$(genre%d).attr('value')+'&language='+$(language%d).attr('value')+'&composer='+$(composer%d).attr('value')+'&pict='+$(pict%d).attr('value')+'&year='+$(year%d).attr('value');
								AJAX.MakePostRequest(\"../ajax/insert_citation.php\", poststr, this.callback_empty);
							}
						});
						$('.hint%d').mouseenter(function() {
						$(this).callout('show');
						});
						$('.callout%d').mouseenter(function() {
		
						}).mouseleave(function() {
						$('.hint%d').callout('hide');
						});
						});
						callback_empty : function()
						{
							var contents = AJAX.GetContents() ;
						}	
						</script>",$listing,$listing,$listing,$listing,$row["id"],$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing);
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class=\"hint%d\" style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class=\"hint%d\" style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class=\"hint%d\" style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></div>", $row["title"], $row["id"], $row["title"], $listing, urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
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
							
			if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<DIV NAME='Download_Captcha_%d' ID='Download_Captcha_%d'><A href='javascript:;' onClick=\"TSR.Captcha('%d');\"><b>Download!</b></A></div>",$listing,$listing,$listing);
						printf("<div id='Show_Captcha_%d' STYLE='display:none;' name='Show_Captcha_%d' class='err'>",$listing,$listing);
						echo "<form method='POST' name='contact_form' action='../captcha/html-contact-form.php'>";
						echo "<p>";
						echo "<img src='../captcha/captcha_code_file.php?rand=<?php echo rand(); ?>' id='captchaimg".$listing."'><br>";
						echo "<label for='message'>Enter the code above here :</label><br>";
						echo "<input id='url' name='url' STYLE='display:none;' value='".$row["id"]."' type='text'><br>";
						echo "<input id='6_letters_code' name='6_letters_code' type='text'><br>";
						echo "<small>Cannot read the image? click <a href='javascript: refreshCaptcha(".$listing.");'>here</a> to refresh</small>";
						echo "</p>";
						echo "<input type='submit' value='Download' name='submit'>";
						echo "</form></div>";
						echo "<script language='JavaScript' type='text/javascript'>";
						echo "function refreshCaptcha(entryIndex)
						{
							var img = document.images['captchaimg'+entryIndex];
							img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
						}
						</script>";
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}
					$tweet=shorten_url(urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1'));
					echo "<table cellspacing='10'><tr><td>";
					printf("<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url='%s' data-text='%s --> ' data-count=\"none\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>",$tweet,$row["title"]);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='small-button' data-locale='en_IN' data-url='%s'></a><script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>",$tweet);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone count='false' href='%s' size='medium'></g:plusone>",$tweet);
					echo "</td></tr></table>";
					printf ("<iframe src=\"http://www.facebook.com/plugins/like.php?href=%s\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; width:450px; height:60px\"></iframe>",urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1')) ;
					$listing++ ;
				}
				$index++ ;
			}
			
			printf("</UL>") ;
			
			return $index ;
		}

		public function showRadioPlaylist($page, $user_id)
		{
			$query = "select id, title from radio_playlist where time_stamp >= SYSDATE() order by time_stamp" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			if($page==1)
			{
				printf("<UL><B><I>Now Playing => </I></B><BR>") ;
			}
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$query = "select album from mp3_info where id like '".$row["id"]."'";
				$album_result = mysql_query($query, $this->db_link_id);
				$rrow = mysql_fetch_array($album_result);
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<B>%s</B> - %s<BR/>",$row["title"],$rrow["album"]) ;
					printf("<HR ALIGN='LEFT' WIDTH='500'/>") ;
					//if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						//if($objQM->IsBookmarked($row["id"], $user_id))
						{
							
						}
						/*else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
						*/
					}
					/*
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					/*if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}*/
					
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					// Send to Friend : [Start]
					// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
					/*printf("<DIV NAME='STF_%d' ID='STF_%d' STYLE='display:none;text-align:center;'>", $listing, $listing);
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
					*/
					$listing++ ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}

		public function showPopularRadio($page, $user_id)
		{
			$query = "select id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, filepath, user_id, plays from mp3_info where plays <> 0 ORDER BY plays DESC;" ;
			
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
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"],  $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B>%s <BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], urlencode($row["album"]), $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					/*if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}*/
					
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
			$query = "select id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, filepath, plays, user_id from mp3_info where ".$ext."='".$query."';" ;
			
			$result = mysql_query($query, $this->db_link_id) ;
			
			$index = 0 ;
			$listing = 0 ;
			
			printf("<UL>") ;
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				if($index>=($page - 1)*10 && $index<(($page - 1)*10)+10)
				{
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					printf("<script type='text/javascript'>
					$(function() {
						$(\".hint%d\").callout({ show: false, css: 'blue', position: 'right', msg: \"<div class='callout%d'>Feel Free to Correct!<hr><form name='citation%d' method='post'><table><TR><TD><input type='hidden' id='songid%d' readonly='readonly' value='%s'/></TD></TR><TR><TD>Song Name</TD><TD><input type='text' id='songname%d'/></TD><TD>Album Name</TD><TD><input type='text' id='album%d'/></TD></TR><TR><TD>Artist Name</TD><TD><input type='text' id='artist%d'/></TD><TD>Genre</TD><TD><input type='text' id='genre%d'/></TD></TR><TR><TD>Language</TD><TD><input type='text' id='language%d'/></TD><TD>Composer</TD><TD><input type='text' id='composer%d'/></TD></TR><TR><TD>Picturized On</TD><TD><input type='text' id='pict%d'/></TD><TD>Year</TD><TD><input type='text' id='year%d'/></TD></TR></form></TABLE><hr><button id='submit%d' value='somevalue'>Submit</button></div>\"});
						$('button').click(function() {
							$($(this).attr('id')).callout('hide');
						});
						$('button').click(function() {
							if(($(this).attr('id')) == 'submit%d')
							{
								var poststr = 'id='+$(songid%d).attr('value')+'&title='+$(songname%d).attr('value')+'&album='+$(album%d).attr('value')+'&artist='+$(artist%d).attr('value')+'&genre='+$(genre%d).attr('value')+'&language='+$(language%d).attr('value')+'&composer='+$(composer%d).attr('value')+'&pict='+$(pict%d).attr('value')+'&year='+$(year%d).attr('value');
								AJAX.MakePostRequest(\"../ajax/insert_citation.php\", poststr, this.callback_empty);
							}
						});
						$('.hint%d').mouseenter(function() {
						$(this).callout('show');
						});
						$('.callout%d').mouseenter(function() {
		
						}).mouseleave(function() {
						$('.hint%d').callout('hide');
						});
						});
						callback_empty : function()
						{
							var contents = AJAX.GetContents() ;
						}	
						</script>",$listing,$listing,$listing,$listing,$row["id"],$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing);
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> %s<BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> %s<BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else 
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> %s<BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						</LI>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $listing, $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
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
							
						if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<DIV NAME='Download_Captcha_%d' ID='Download_Captcha_%d'><A href='javascript:;' onClick=\"TSR.Captcha('%d');\"><b>Download!</b></A></div>",$listing,$listing,$listing);
						printf("<div id='Show_Captcha_%d' STYLE='display:none;' name='Show_Captcha_%d' class='err'>",$listing,$listing);
						echo "<form method='POST' name='contact_form' action='../captcha/html-contact-form.php'>";
						echo "<p>";
						echo "<img src='../captcha/captcha_code_file.php?rand=<?php echo rand(); ?>' id='captchaimg".$listing."'><br>";
						echo "<label for='message'>Enter the code above here :</label><br>";
						echo "<input id='url' name='url' STYLE='display:none;' value='".$row["id"]."' type='text'><br>";
						echo "<input id='6_letters_code' name='6_letters_code' type='text'><br>";
						echo "<small>Cannot read the image? click <a href='javascript: refreshCaptcha(".$listing.");'>here</a> to refresh</small>";
						echo "</p>";
						echo "<input type='submit' value='Download' name='submit'>";
						echo "</form></div>";
						echo "<script language='JavaScript' type='text/javascript'>";
						echo "function refreshCaptcha(entryIndex)
						{
							var img = document.images['captchaimg'+entryIndex];
							img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
						}
						</script>";
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}
					$tweet=shorten_url(urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1'));
					echo "<table cellspacing='10'><tr><td>";
					printf("<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url='%s' data-text='%s --> ' data-count=\"none\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>",$tweet,$row["title"]);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='small-button' data-locale='en_IN' data-url='%s'></a><script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>",$tweet);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone count='false' href='%s' size='medium'></g:plusone>",$tweet);
					echo "</td></tr></table>";
					printf ("<iframe src=\"http://www.facebook.com/plugins/like.php?href=%s\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; width:450px; height:60px\"></iframe>",urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1')) ;
				}
				$index++ ;
			}
			printf("</UL>") ;
			
			return $index ;
		}

		public function listExactRadio($query, $page, $ext, $user_id)
		{
			$query = "select id, artist, album, title, year, duration_sec, genre, composer, picturizedon, lyrics, provider, filepath, plays, user_id from mp3_info where ".$ext."='".$query."';" ;
			
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
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> %s<BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							</LI>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> %s<BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"], $row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
						}
					}
					else 
					{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> %s<BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						</LI>
						<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $row["title"], $row["id"], $row["title"], $row["album"], $row["plays"], $index, $index, $index, $row["artist"], $row["year"], $row["duration_sec"]/60, $row["genre"], $row["composer"],$row["lyrics"], $listing, $listing, $listing, $listing, $listing) ;
					}
					
					/*if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}*/

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
					$provider	= $row["provider"] ;
					//$this->FindAndHighlightLyrics($row["lyrics"], $wordArray) ;
					
					printf("<HR ALIGN='LEFT' WIDTH='200'/>") ;
					//echo("Metaphone: ".$row['metaphone']."<BR/>") ;
					
					//$playlist_cmd = '<A HREF="javascript:;" onClick="parent.window.wimpy_AndPlay('''.'>Add to Playlist &gt;&gt; </A>' ;
					//echo($listing) ;
					printf("<script type='text/javascript'>
					$(function() {
						$(\".hint%d\").callout({ show: false, css: 'blue', position: 'right', msg: \"<div class='callout%d'>Feel Free to Correct!<hr><form name='citation%d' method='post'><table><TR><TD><input type='hidden' id='songid%d' readonly='readonly' value='%s'/></TD></TR><TR><TD>Song Name</TD><TD><input type='text' id='songname%d'/></TD><TD>Album Name</TD><TD><input type='text' id='album%d'/></TD></TR><TR><TD>Artist Name</TD><TD><input type='text' id='artist%d'/></TD><TD>Genre</TD><TD><input type='text' id='genre%d'/></TD></TR><TR><TD>Language</TD><TD><input type='text' id='language%d'/></TD><TD>Composer</TD><TD><input type='text' id='composer%d'/></TD></TR><TR><TD>Picturized On</TD><TD><input type='text' id='pict%d'/></TD><TD>Year</TD><TD><input type='text' id='year%d'/></TD></TR></form></TABLE><hr><button id='submit%d' value='somevalue'>Submit</button></div>\"});
						$('button').click(function() {
							$($(this).attr('id')).callout('hide');
						});
						$('button').click(function() {
							if(($(this).attr('id')) == 'submit%d')
							{
								var poststr = 'id='+$(songid%d).attr('value')+'&title='+$(songname%d).attr('value')+'&album='+$(album%d).attr('value')+'&artist='+$(artist%d).attr('value')+'&genre='+$(genre%d).attr('value')+'&language='+$(language%d).attr('value')+'&composer='+$(composer%d).attr('value')+'&pict='+$(pict%d).attr('value')+'&year='+$(year%d).attr('value');
								AJAX.MakePostRequest(\"../ajax/insert_citation.php\", poststr, this.callback_empty);
							}
						});
						$('.hint%d').mouseenter(function() {
						$(this).callout('show');
						});
						$('.callout%d').mouseenter(function() {
		
						}).mouseleave(function() {
						$('.hint%d').callout('hide');
						});
						});
						callback_empty : function()
						{
							var contents = AJAX.GetContents() ;
						}	
						</script>",$listing,$listing,$listing,$listing,$row["id"],$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing,$listing);
					if(CSessionManager::IsLoggedIn())
					{
						$objQM = new CQueryManager(CConfig::DB_AUDIO) ;
						if($objQM->IsBookmarked($row["id"], $user_id))
						{
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], $listing, urlencode($row["album"]), $album, $row["plays"], $index, $index, $index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"],$wordArray), $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], $listing, urlencode($row["album"]), $album, $row["plays"], $index, $index, $index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;
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
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToPlaylistUrl(\"%s\",\"%s\")'>Add to Playlist &gt;&gt;</A>}<div class='hint%d' style=\"width:150\"> <b>Edit this mp3 Info</b> <img src='../images/glass.png' width='24' height='24'></div> <BR/><B><EM>Album:</EM></B> <A HREF=\"tab_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], $listing, urlencode($row["album"]), $album, $row["plays"], $index, $index, $index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;
					}
					
//					if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
//					{
//						printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
//					}
					
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
					
					if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<DIV NAME='Download_Captcha_%d' ID='Download_Captcha_%d'><A href='javascript:;' onClick=\"TSR.Captcha('%d');\"><b>Download!</b></A></div>",$listing,$listing,$listing);
						printf("<div id='Show_Captcha_%d' STYLE='display:none;' name='Show_Captcha_%d' class='err'>",$listing,$listing);
						echo "<form method='POST' name='contact_form' action='../captcha/html-contact-form.php'>";
						echo "<p>";
						echo "<img src='../captcha/captcha_code_file.php?rand=<?php echo rand(); ?>' id='captchaimg".$listing."'><br>";
						echo "<label for='message'>Enter the code above here :</label><br>";
						echo "<input id='url' name='url' STYLE='display:none;' value='".$row["id"]."' type='text'><br>";
						echo "<input id='6_letters_code' name='6_letters_code' type='text'><br>";
						echo "<small>Cannot read the image? click <a href='javascript: refreshCaptcha(".$listing.");'>here</a> to refresh</small>";
						echo "</p>";
						echo "<input type='submit' value='Download' name='submit'>";
						echo "</form></div>";
						echo "<script language='JavaScript' type='text/javascript'>";
						echo "function refreshCaptcha(entryIndex)
						{
							var img = document.images['captchaimg'+entryIndex];
							img.src = img.src.substring(0,img.src.lastIndexOf('?'))+'?rand='+Math.random()*1000;
						}
						</script>";
						//printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}
					$tweet=shorten_url(urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1'));
					echo "<table cellspacing='10'><tr><td>";
					printf("<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url='%s' data-text='%s --> ' data-count=\"none\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>",$tweet,$row["title"]);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<a title='Post to Google Buzz' class='google-buzz-button' href='http://www.google.com/buzz/post' data-button-style='small-button' data-locale='en_IN' data-url='%s'></a><script type='text/javascript' src='http://www.google.com/buzz/api/button.js'></script>",$tweet);
					
					//echo "&nbsp;&nbsp;";
					echo "</td><td>";
					printf("<script type='text/javascript' src='https://apis.google.com/js/plusone.js'></script><g:plusone count='false' href='%s' size='medium'></g:plusone>",$tweet);
					echo "</td></tr></table>";
					printf ("<iframe src=\"http://www.facebook.com/plugins/like.php?href=%s\" scrolling=\"no\" frameborder=\"0\" style=\"border:none; width:450px; height:60px\"></iframe>",urlencode('http://beta.mgoos.com/search_results.php?id='.$row["id"].'&srchtxt='.$row["title"].'&pmode=1')) ;
					$listing++ ;
				}
				$index++ ;
			} while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) ;
			printf("</UL>") ;
			
			mysql_free_result($result);
			
			return $index ;
		}
		
		public function showUptoTenRecordsRadio($query, $page, $ext, $user_id)
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
					$provider	= $row["provider"] ;
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
							printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							<DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<B>Already Bookmarked!</B>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album, $row["plays"], $index, $index, $index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"],$wordArray), $listing, $listing, $listing, $listing, $listing) ;
						}
						else 
						{
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
							<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
							<DIV ID=\"div_details%s\" style=\"display:none\">
							<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
							&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
							</DIV>
							</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnBookmark(%d);\">Add to bookmarks</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album, $row["plays"], $index, $index, $index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;
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
						printf("<LI><B>%s</B> {<A HREF='javascript:;' onClick='parent.SR.AddToRadioUrl(\"%s\",\"%s\")'>Request to Play &gt;&gt;</A>}<BR/><B><EM>Album:</EM></B> <A HREF=\"radio_search_results.php?qry=%s&pg=1&ext=album&strict=true\">%s</A><BR/><FONT COLOR=\"#FF0000\"><B><EM>Play Count:</EM></B>&nbsp;%d</FONT><BR/>
						<A style=\"	cursor:pointer;\" id=\"%s_open\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/plus.png \"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">More details...</FONT></B></U></BR></A>
						<DIV ID=\"div_details%s\" style=\"display:none\">
						<A style=\"cursor:pointer;\" id=\"%s_close\" Onclick=\"TSR.ToggleDiv(this.id);\"><img border=\"0\" src=\"../images/minus.png \" alt=\"-\"/>&nbsp;&nbsp;<U><B><FONT COLOR=\"#FF9900\">Hide details...</FONT></B></U></A></BR>
						&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Artist:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Year:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Time:</EM></B> %.2f mins<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Genre:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Composer:</EM></B> %s<BR/>&nbsp;&nbsp;&nbsp;&nbsp;<B><EM>Lyrics:</EM></B> %s<BR/>						
						</DIV>
						</LI><DIV NAME=\"LISTING_LINK_%d\" ID=\"LISTING_LINK_%d\"><A HREF='javascript:;' onClick=\"TSR.OnSendToFriend('%d');\">Send to friend</A>&nbsp;|&nbsp;<A HREF='javascript:;' onClick=\"TSR.OnReportAbuse(%d)\">Report Abuse</A></DIV>", $title, $row["id"], $row["title"], urlencode($row["album"]), $album, $row["plays"], $index, $index, $index, $artist, $year, $duration, $genre, $composer, $this->FindAndHighlightLyrics($row["lyrics"], $wordArray), $listing, $listing, $listing, $listing, $listing) ;
					}
					
					/*if(strcmp($row["provider"], "http://www.mgoos.com") != 0)
					{
						printf("<BR/><FONT COLOR=\"#FF0000\"><B>Download!:</B></FONT> <A HREF=\"%s\" TARGET=\"_blank\">%s</A>", $row["filepath"], $row["filepath"]) ;
					}*/
					
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