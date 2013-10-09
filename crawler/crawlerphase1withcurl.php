<?php
	include_once ('../database/config.php');
	include_once ('../lib/utils.php');
	//include('redirector.php');
	include_once('inserturlinfo.php');
	set_time_limit(0);
	header("Cache-Control: no-cache, must-revalidate");
	CUtils::flushHard();

	// ---------------------------------------------------------------------------
	//this file will be used from the user interface file to parse the site in single level
	
	$pattern1='/(href)=[\'"]?([^\'" >]+)[\'" >]/';
	$mp3_pattern='/\.mp3/';
	$link_check=' ';
	$database="mgooscom_audio";
	$db_link_id;
	$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db($database, $db_link_id);

	

	/*if(isset($_GET['checked']))
	{
		mysql_query('delete * from nonmp3',$db_link_id) or die("Get delete Error: ".mysql_error($db_link_id));
		echo '<script type="text/javascript">parent.comet.update("Inside Check: '.$url.'");</script>'."\n";
	}*/
	if(isset($_GET['asite']))
	{
		$url_arrived=$_GET['asite'];
		echo $url_arrived;
		mysql_query('insert ignore into crawled_nonmp3_urls values ("'.mysql_real_escape_string($url_arrived).'",0)',$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
	}
	$url_arrived_check = str_replace('http://www.',"",$url_arrived);

	//echo $url_arrived_check;
	
	if (ob_get_level() == 0) 
		ob_start();
	
	$links = mysql_query("select url from crawled_nonmp3_urls where url like '%$url_arrived_check%' AND status=0",$db_link_id);
	$num_rows = mysql_num_rows($links);
	
	$non_mp3_count = 0;
	$mp3_count = 0;
	
	while($num_rows > 0)
	{
		while($row = mysql_fetch_array($links))
		{
			
			$url=mysql_real_escape_string($row ['url']);

			echo '<script type="text/javascript">parent.comet.update("Working on: '.$url.'");</script>'."\n";
			CUtils::flushHard();
			
			$final=CUtils::get_final_url($url);
			//echo '<script type="text/javascript">parent.comet.update("Url obtained: '.$final.'");</script>'."\n";
			CUtils::flushHard();
			if(CUtils::filecheck($final))
			{
				mysql_query("insert into crawled_mp3_urls values('$final',0,'$url_arrived') on duplicate key update url=url",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));

				if(mysql_affected_rows($db_link_id) > 0)
				{
					$mp3_count++;
					insertinfo($final,$url_arrived);
				}
				
				echo '<script type="text/javascript">parent.comet.update_mp3("MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count.'");</script>'."\n";
				mysql_query("update crawled_nonmp3_urls set status=1 where url = '$url' ",$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
				CUtils::flushHard();
				continue;
			}
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$final);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$crawl_inner_text = curl_exec ($ch);
			//$html = file_get_html($row ['url']);
			//$crawl_inner_text = $html->innertext;

			if(strcmp($crawl_inner_text, "") ==0)
			{
				echo '<script type="text/javascript">parent.comet.update("empty page: '.$url.'");</script>'."\n";
				mysql_query("update crawled_nonmp3_urls set status=1 where url = '$final' ",$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
				CUtils::flushHard();
				continue;

			}

			if(preg_match_all($pattern1,$crawl_inner_text,$out, PREG_SET_ORDER))
			{
				foreach($out as $link)
				{	
					$final=mysql_real_escape_string($link[2]);
					if(strncmp($final,'http',4) !== 0)
					{	
						if(strcmp($final[0],'/')!==0)
							$final=$url_arrived.'/'.$link[2];
						else
							$final=$url_arrived.$link[2];
					}

					$final = strtolower($final);
					$final=CUtils::get_final_url($final);
					if(CUtils::filecheck($final))
					{
						mysql_query("insert into crawled_mp3_urls values('$final',0,'$url_arrived') on duplicate key update url=url",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));

						if(mysql_affected_rows($db_link_id) > 0)
						{
							$mp3_count++;
							insertinfo($final,$url_arrived);
						}
						
						echo '<script type="text/javascript">parent.comet.update_mp3("MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count.'");</script>'."\n";
						CUtils::flushHard();
						CUtils::flushHard();
						
					}
					else if(stristr($final,$url_arrived_check) !== FALSE)
					{
						mysql_query("insert into crawled_nonmp3_urls values('$final',0) on duplicate key update url=url",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));

						if(mysql_affected_rows($db_link_id) > 0)
						{
							$non_mp3_count++;
						}
						echo '<script type="text/javascript">parent.comet.update_mp3("MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count.'");</script>'."\n";
						CUtils::flushHard();
						
					}
					unset($str);
					unset($final);
				}
			}
			
			mysql_query("update crawled_nonmp3_urls set status=1 where url = '$url' ",$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
			
			curl_close ($ch);
			unset($crawl_inner_text);
		}
		$links = mysql_query("select url from crawled_nonmp3_urls where status=0",$db_link_id);
		$num_rows = mysql_num_rows($links);
	}
	ob_end_flush();
	
?>