<?php
include("mp3.php");
include("nonmp3.php");

	class CrawlerHelper
	{
		private $db_link_id;
		
		public function __construct()
		{
			// Server Name, UserName, Password, Database Name		
			$this->db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
			mysql_select_db(CConfig::DB_AUDIO, $this->db_link_id);
			$this->mp3_count=0;
			$this->nonmp3_count=0;
			//if (ob_get_level() == 0) 
			ob_start();
		}
		
		public function __destruct()
		{
			mysql_close($this->db_link_id) ;
			ob_end_flush();
		}
		
		public function uuid() 
		{
			// The field names refer to RFC 4122 section 4.1.2
			
			return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			    mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			    mt_rand(0, 65535), // 16 bits for "time_mid"
			    mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			    bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			        // 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			        // (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			        // 8 bits for "clk_seq_low"
			    mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node" 
				); 
		}
		
		public function InsertMp3Url($mp3_obj)
		{
			$url=$mp3_obj->GetUrl();
			$status=$mp3_obj->GetStatus();
			$source=$mp3_obj->GetSource();
			mysql_query("insert ignore into crawled_mp3_urls values('$url',$status,'$source')", $this->db_link_id);
			if(mysql_affected_rows($this->db_link_id) > 0)
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
			mysql_query("insert ignore into crawled_nonmp3_urls values('$url',$status)", $this->db_link_id);
			//$this->FlushString('insertnonmp3', "insert ignore into crawled_nonmp3_urls values('$url',$status)");
			if(mysql_affected_rows($this->db_link_id) > 0)
			{
				$this->nonmp3_count++;
			}
			return $this->nonmp3_count++;
		}
		
		public function InvokeCrawler($url_arrived)
		{
			$mp3_count = 0;
			$non_mp3_count = 0;

			/*echo "<br/>InvokeCrawler<br/>";
			$this->flushHard();*/

			if(!empty($url_arrived))
			{
				mysql_query('insert ignore into crawled_nonmp3_urls values ("'.mysql_real_escape_string($url_arrived).'",0)',$this->db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
			}

			$pattern='/(href)=[\'"]?([^\'" >]+)[\'" >]/';
			//$url_arrived_check = str_replace('http://www.',"",$url_arrived);
			$parent=explode(".",$url_arrived,2);
			$url_arrived_check= $parent[1];
			
			/* 
			#- Debug Code -#
			echo $url_arrived_check;
			$this->flushHard();
			*/

			$links = mysql_query("select url from crawled_nonmp3_urls where url like '%$url_arrived_check%' AND status=0", $this->db_link_id)or die("Select Url Error: ".mysql_error($this->db_link_id));
			$num_rows = mysql_num_rows($links);
			
			/* 
			#- Debug Code -#
			echo $num_rows;
			$this->flushHard();
			*/
			while($num_rows > 0)
			{
				
				while($row = mysql_fetch_array($links))
				{
					/*
					#- Debug Code -#
					echo 'Row:'.$row ['url'].'<br/>';
					$this->flushHard();
					*/

					$url=mysql_real_escape_string($row ['url']);

					//echo '<script type="text/javascript">parent.comet.update("Working on: '.$url.'");</script>'."\n";
					$this->FlushString('update','Working on: '.$url);
					
					$final=$this->get_final_url($url);
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$final);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$crawl_inner_text = curl_exec ($ch);
					
					if(strcmp($crawl_inner_text, "") ==0)
					{
						mysql_query("update crawled_nonmp3_urls set status=1 where url = '$final' ", $this->db_link_id) or die("Update Url Error: ".mysql_error($this->db_link_id));
						//echo '<script type="text/javascript">parent.comet.update("empty page: '.$url.'");</script>'."\n";
						$this->FlushString('update','empty page: '.$url);
					}
					else if(preg_match_all($pattern,$crawl_inner_text,$out, PREG_SET_ORDER))
					{
						foreach($out as $link)
						{
							/*
							#- Debug Code -#
							echo $link[2].'<br/>';
							$this->flushHard();
							*/

							$final=mysql_real_escape_string($link[2]);
							if(strncmp($final,'http',4) !== 0)
							{	
								if(strcmp($final[0],'/')!==0)
									$final=$url_arrived.'/'.$link[2];
								else
									$final=$url_arrived.$link[2];
							}

							//$final = strtolower($final);
							$final=$this->get_final_url($final);
							$arr= array('url' => $final,'status' =>0,'source' => $url_arrived);
							
							/*
							#- Debug Code -#
							echo '<pre>';
							print_r($arr);
							echo '</pre>';
							$this->flushHard();
							*/
							
							if($this->filecheck($final))
							{
								$mp3_obj=new CMp3($arr);
								$mp3_count=$this->InsertMp3Url($mp3_obj);
								
								//echo '<script type="text/javascript">parent.comet.update_mp3_crawling_stats("MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count.'");</script>'."\n";
								$this->FlushString('update_mp3_crawling_stats','MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count);
								
							}
							else if(stristr($final,$url_arrived_check) !== FALSE)
							{
								$nonmp3_obj=new CNonMp3($arr);
								$nonmp3_count=$this->InsertNonMp3Url($nonmp3_obj);
								//echo '<script type="text/javascript">parent.comet.update_mp3_crawling_stats("MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count.'");</script>'."\n";
								$this->FlushString('update_mp3_crawling_stats', 'MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count);
								
							}
							unset($str);
							unset($final);
						}
					}
					
					mysql_query("update crawled_nonmp3_urls set status=1 where url = '$url' ") or die("update Url Error: ".mysql_error($this->db_link_id));
					
					curl_close ($ch);
					unset($crawl_inner_text);
				}
				$links = mysql_query("select url from crawled_nonmp3_urls where status=0")or die("select_late Url Error: ".mysql_error($this->db_link_id));
				$num_rows = mysql_num_rows($links);
			}
		}

		public function get_redirect_url($url)
		{
			$redirect_url = null; 
		 
			$url_parts = @parse_url($url);
			if (!$url_parts) return false;
			if (!isset($url_parts['host'])) return false; //can't process relative URLs
			if (!isset($url_parts['path'])) $url_parts['path'] = '/';
		 
			$sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
			if (!$sock) return false;
		 
			$request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n"; 
			$request .= 'Host: ' . $url_parts['host'] . "\r\n"; 
			$request .= "Connection: Close\r\n\r\n"; 
			fwrite($sock, $request);
			$response = '';
			while(!feof($sock)) $response .= fread($sock, 8192);
			fclose($sock);
		 
			if (preg_match('/^Location: (.+?)$/m', $response, $matches))
			{
				if ( substr($matches[1], 0, 1) == "/" )
					return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
				else
					return trim($matches[1]);
		 
			} 
			else 
			{
				return false;
			}
		}
		
		public function get_all_redirects($url)
		{
			$redirects = array();
			while ($newurl = $this->get_redirect_url($url))
			{
				if (in_array($newurl, $redirects))
				{
					break;
				}
				$redirects[] = $newurl;
				$url = $newurl;
			}
			return $redirects;
		}
		 
		public function get_final_url($url)
		{
			$redirects = $this->get_all_redirects($url);
			if (count($redirects)>0)
			{
				return array_pop($redirects);
			} 
			else 
			{
				return $url;
			}
		}

		public function flushHard()
		{
			echo(str_repeat(' ',256));
			// check that buffer is actually set before flushing
			if (ob_get_length())
			{           
				@ob_flush();
				@flush();
				@ob_end_flush();
			}   
			@ob_start();
		}
		
		public function FlushString($function, $val, $debug=0)
		{
			if($debug)
			{
				echo $function.'-'.$val.'<br/>';
				$this->flushHard();
			}
			else
			{
				echo '<script type="text/javascript">parent.comet.'.$function.'("'.$val.'");</script>'."\n";
				$this->flushHard();
			}
		}
		
		public function filecheck($entry)
		{
			$prot = strtolower(substr($entry, 0, 7));
			$ext = strtolower(strrchr($entry, '.'));
			if (($prot == 'http://') && ($ext == '.mp3')) 
			{
				return true;
			} 
			else 
			{
				return false;
			}
		}

		/*public function GetUrlStats()
		{
			
		}*/

		public function TruncateCraweldNonMp3Urls()
		{
			mysql_query("truncate table nonmp3") or die("Truncate Error: ".mysql_error($this->db_link_id));
		}

			
		public function ProcessCrawledMp3Urls()
		{
			include_once("../../getid3/getid3.php");
			include_once("../../lib/id3_info.php");
			include_once('../../lib/utils.php');

			$count = 0;
			$userid="9ba7f5c9-dc3d-2a04-bd2a-00273fd9872e";
			$links=mysql_query("select * from crawled_mp3_urls where status=0",$this->db_link_id) or die("Sql select error :- ".mysql_error($this->db_link_id));	
			$num_rows = mysql_num_rows($links);
			while($row = mysql_fetch_assoc($links))
			{
				$url=$row['url'];
				$url=str_replace(' ','%20',$url);
				//$this->FlushString("update_insert","Working on ".$url);
				$file=fopen($url,"rb");
				$data=fread($file, 8192);
				fclose($file);
				$local_filename="remote_".implode("_",microtime()).".mp3";
				$file=fopen($local_filename,"wb");
				fwrite($file,$data);
				unset($data);
				fclose($file); 

				$obj = new getid3();
				$id3info = $obj->analyze($local_filename);
				unlink($local_filename); 
				
				$filenamepath = $url; //$id3info['filenamepath'] ;
				//$filesize = $id3info['filesize'] ;
				$bitrate = $id3info['audio']['bitrate'] / 1000 ; // Its in bps, convert it to kbps by dividing it to 1000.
				$duration_sec = $id3info['playtime_seconds'] ;
				//$user_id = CSessionManager::GetUserId() ;
				
				$provider=$row['source'];
				
				$u_year = ucwords(strtolower($id3info['tags']['id3v1']['year']['0'])) ;
				if(empty($u_year))
				{
					$u_year = ucwords(strtolower($id3info['id3v2']['comments']['year']['0'])) ;
					if(empty($u_year))
					{
						$u_year = "Unknown" ;
					}
				}
				
				$u_gener = ucwords(strtolower($id3info['tags']['id3v1']['genre']['0'])) ;
				if(empty($u_gener) || strcasecmp($u_gener,"other") == 0)
				{
					$u_gener = ucwords(strtolower($id3info['id3v2']['comments']['content_type']['0'])) ;
					if(empty($u_gener))
					{
						$u_gener = "Unknown" ;
					}
				}
				
				$u_mood = "Unknown";
				
				$u_title = ucwords(strtolower($id3info['tags']['id3v1']['title']['0'])) ;
				if(empty($u_title))
				{
					$u_title = ucwords(strtolower($id3info['id3v2']['comments']['title']['0'])) ;
				}
				
				$u_artist = ucwords(strtolower($id3info['tags']['id3v1']['artist']['0'])) ;
				if(empty($u_artist))
				{
					$u_artist = ucwords(strtolower($id3info['id3v2']['comments']['artist']['0'])) ;
				}
				
				$u_album = ucwords(strtolower($id3info['tags']['id3v1']['album']['0'])) ;
				if(empty($u_album))
				{
					$u_album = ucwords(strtolower($id3info['id3v2']['comments']['album']['0'])) ;
				}
				
				$u_lang = ucwords(strtolower($id3info['id3v2']['COMM']['0']['languagename'])) ;
				if(empty($u_lang))
				{
					$u_lang = ucwords(strtolower($id3info['id3v2']['COMM']['1']['languagename'])) ;
					if(empty($u_lang))
					{
						$u_lang = "Hindi" ;
					}
				}
				
				$u_band = ucwords(strtolower($id3info['id3v2']['comments']['band']['0'])) ;
				if(empty($u_band))
				{
					$u_band = "Unknown" ;
				}
				$u_composer = ucwords(strtolower($id3info['tag']['id3v2']['composer']['0'])); 
				if(empty($u_composer))
				{
					$u_composer=$id3info['id3v2']['comments']['composer']['0'];
				}
				
				$headers = get_headers($url, 1);
				
				$id=$this->uuid();
				$array ['filesize']=$headers['Content-Length']; // size in bytes
				$array ['id']= $id;
				$array ['filepath']=$filenamepath;
				$array ['bitrate']=$bitrate;
				$array ['duration_sec']=$duration_sec;
				$array ['year']=$u_year;
				$array ['genre']=$u_gener;
				$array ['mood']=$u_mood;
				$array ['title']=$u_title;
				$array ['artist']=$u_artist;
				$array ['album']=$u_album;
				$array ['language']=$u_lang;
				//$array ['band']=$u_band;
				$array ['user_id']=$userid;
				$array ['composer']=$u_composer;
				$array ['provider']=$provider;
				$array ['lyrics']="";
				$array ['status']=1;
				$array ['picturizedon']="";

				$id3info_obj = new CId3Info($array);
				
				$flag=$this->InsertIntoMp3Info($id3info_obj);
				
				if($flag == 1)
				{
					$met_id=$id;
					$met_title=Cutils::GetHindiPhonetic($u_title);
					$met_album=Cutils::GetHindiPhonetic($u_album);
					$met_artist=Cutils::GetHindiPhonetic($u_artist);
					$met_genre=Cutils::GetHindiPhonetic($u_gener);
					$met_composer=Cutils::GetHindiPhonetic($u_composer);
					$met_picturizedon=Cutils::GetHindiPhonetic("");
					$met_lyrics=Cutils::GetHindiPhonetic("");
					mysql_query("insert ignore into mp3_hphonetic_info values('$met_id','$met_title','$met_album','$met_artist','$met_genre','$met_composer','$met_picturizedon','$met_lyrics')",$this->db_link_id) or die("metaphone insert error :- ".mysql_error($this->db_link_id));
				}
				$count++;
				$this->FlushString("update_insert","Files Processed: ".$count." - Added Info of :-".$url);
				mysql_query("update crawled_mp3_urls set status= 1 where url like '$url' ",$this->db_link_id) or die("Sql update error :- ".mysql_error($this->db_link_id));
			}
		}
		
		public function InsertIntoMp3Info(CId3Info $id3info,$flag)
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

			$bResult = mysql_query("insert ignore into mp3_info (id, upload_date, filepath, filesize, bitrate, duration_sec, language, status, user_id, title, artist, album, lyrics, year, genre,mood, composer, picturizedon, provider) values ('$id', SYSDATE(), '$filepath', '$filesize', '$bitrate', '$duration_sec', '$language', $status, '$userid', '$title', '$artist', '$album', '$lyrics', '$year', '$genre','$mood', '$composer', '$picturizedon', '$provider') ;",$this->db_link_id) or die("Sql insert error :- ".mysql_error());
			$flag=0;
			if(mysql_affected_rows($this->db_link_id)>0)
			{
				$flag=1;
			}
			return $flag;
			
		}
		public function CrawledUrlStats()
		{
			$mp3_not_processed = 0;
			$nonmp3_not_processed = 0;
			
			$result = mysql_query("select count(*) as count from crawled_mp3_urls where status = 0",$this->db_link_id);
			if (mysql_num_rows($result) != 0)
			{
				$row = mysql_fetch_assoc($result);
				$mp3_not_processed = $row['count'];
			}

			$result = mysql_query("select count(*) as count from crawled_nonmp3_urls where status = 0",$this->db_link_id);
			if (mysql_num_rows($result) != 0)
			{
				$row = mysql_fetch_assoc($result);
				$nonmp3_not_processed = $row['count'];
			}
			
			$this->FlushString('update_status', 'MP3 not processed : '.$mp3_not_processed.', Non-MP3 not processed : '.$nonmp3_not_processed);
		}
		public function Reconciliation()
		{
			$links=mysql_query("select url from mp3_info where provider not like 'http://www.mgoos.com'",$this->db_link_id);
			$num_rows = mysql_num_rows($links);
			while($row = mysql_fetch_array($links))
			{
				$url=$row['url'];
				if(CUtils::reconcile($url) == 404)
				{
					mysql_query("delete from mp3_info where url like '%$url%'");

				}
			}
			$links=mysql_query("select url from mp3_info where provider not like 'http://www.mgoos.com'",$this->db_link_id);
			$num_rows_final= mysql_num_rows($links);
			$this->FlushString('update_reconciliation_status', 'Before Reconcilation : '.$num_rows.', After Reconcilation : '.$num_rows_final);
			
		}
		public function HeartBeat()
		{
			
		}
	};
?>