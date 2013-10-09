<?php
	include_once ('../../database/config.php');
	include_once ('../../lib/utils.php');
	include ('../lib/link_manager.php');
	include ("crawler_helper.php");
	//include('redirector.php');
	include_once('inserturlinfo.php');
	set_time_limit(0);
	header("Cache-Control: no-cache, must-revalidate");
	CUtils::flushHard();

	$objCHlpr = new CrawlerHelper();

	switch($_GET['mode'])
	{
		case 1:
			if(isset($_GET['asite']))
			{
				$url_arrived=$_GET['asite'];
				$objCHlpr->InvokeCrawler($url_arrived);
			}
			break;
		case 2:
			$objCHlpr->TruncateCraweldNonMp3Urls();
			$objCHlpr->FlushString("Truncated ... Table");
			break;
		case 3:
			$retVal = $objCHlpr->GetUrlStats();
			$objCHlpr->FlushString($retVal);
			break;
		case 4:
			$objCHlpr->ProcessCrawledMp3Urls();
			break;
		default:
			exit(0);
	}
	
	
	
	
	
	
	
	
	
	// ---------------------------------------------------------------------------
	//this file will be used from the user interface file to parse the site in single level
	
	$pattern1='/(href)=[\'"]?([^\'" >]+)[\'" >]/';
	$db_link_id;
	$db_link_id = mysql_connect(CConfig::HOST,CConfig::USER_NAME,CConfig::PASSWORD);
	mysql_select_db(CConfig::DB_AUDIO, $db_link_id);


	if(isset($_GET['asite']))
	{
		$url_arrived=$_GET['asite'];
		echo $url_arrived;
		mysql_query('insert ignore into crawled_nonmp3_urls values ("'.mysql_real_escape_string($url_arrived).'",0)',$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
	}
	$url_arrived_check = str_replace('http://www.',"",$url_arrived);
	if (ob_get_level() == 0) 
		ob_start();
	
	$links = mysql_query("select url from crawled_nonmp3_urls where url like '%$url_arrived_check%' AND status=0",$db_link_id);
	$num_rows = mysql_num_rows($links);
	
	$non_mp3_count = 0;
	$mp3_count = 0;
	$link_obj=new CLinkManager();
	while($num_rows > 0)
	{
		while($row = mysql_fetch_array($links))
		{
			
			$url=mysql_real_escape_string($row ['url']);

			echo '<script type="text/javascript">parent.comet.update("Working on: '.$url.'");</script>'."\n";
			CUtils::flushHard();
			
			$final=CUtils::get_final_url($url);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$final);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$crawl_inner_text = curl_exec ($ch);
			
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
					$arr= array('url' => $final,'status' =>0,'source' => $url_arrived);
					if(CUtils::filecheck($final))
					{
						$mp3_obj=new CMp3($arr);
						$mp3_count=$link_obj->InsertMp3Url($mp3_obj);
						echo '<script type="text/javascript">parent.comet.update_mp3("MP3 Crawled : '.$mp3_count.', Non-MP3 Crawled : '.$non_mp3_count.'");</script>'."\n";
						
						CUtils::flushHard();
						
					}
					else if(stristr($final,$url_arrived_check) !== FALSE)
					{
						$nonmp3_obj=new CNonMp3($arr);
						$nonmp3_count=$link_obj->InsertNonMp3Url($nonmp3_obj);
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