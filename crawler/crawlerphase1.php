<?php

	//this file will be used from the ui file to parse the site in single level
	
	include('simple_html_dom.php');
	include('redirector.php');
	$pattern1='/(href)=[\'"]?([^\'" >]+)[\'" >]/';
	$mp3_pattern='/\.mp3/';
	$link_check=' ';
	$database="ali";
	$db_link_id;
	$db_link_id = mysql_connect('localhost','root','');
	mysql_select_db($database, $db_link_id);
	
	if(isset($_POST['site']))
	{
		$url_arrived=$_POST['site'];
		mysql_query('insert ignore into nonmp3 values ("'.mysql_real_escape_string($url_arrived).'",0)',$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
	}
	
	$url_arrived_check = str_replace('http://www.',"",$url_arrived);

	echo $url_arrived_check;
	
	if (ob_get_level() == 0) 
		ob_start();
	
	$links = mysql_query("select url from nonmp3 where status=0",$db_link_id);
	$num_rows = mysql_num_rows($links);
	
	while($num_rows > 0)
	{
		while($row = mysql_fetch_assoc($links))
		{
			$url=$row ['url'];

			echo "Working on ".$url."<br/>";

			mysql_query("update nonmp3 set status=1 where url = '$url' ",$db_link_id) or die("Get Url Error: ".mysql_error($db_link_id));
			$html = file_get_html($row ['url']);
			$crawl_inner_text = $html->innertext;

			if(strcmp($crawl_inner_text, "") ==0)
			{
				echo "<pre>";
					echo "empty page: ".$url;
				echo "</pre>";
				ob_flush();
				flush();

				//$html->clear();
				continue;
			}

			if(preg_match_all($pattern1,$crawl_inner_text,$out, PREG_SET_ORDER))
			{
				foreach($out as $link)
				{	
					if(stristr($link[2],$url_arrived_check) !== FALSE)
					{
						$str=mysql_real_escape_string($link[2]);
						$final=get_final_url($str);
						if(strncmp($final,'http',4) !== 0)
						{	
								$final=$row ['url'].'/'.$link[2];
						}
							
						$final = strtolower($final);

						if(preg_match_all($mp3_pattern,$final,$mp3check,PREG_SET_ORDER))
						{
							mysql_query("insert ignore into mp3 values('$final',0)",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
							echo "<pre>";
								echo "mp3 link added to mp3 database: ".$final;
							echo "</pre>";
						}
						else
						{
							mysql_query("insert ignore into nonmp3 values('$final',0)",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
							echo "<pre>";
								echo "nonmp3 link added to nonmp3 database: ".$final;
							echo "</pre>";
						}
						ob_flush();
						flush();
						unset($str);
						unset($final);
					}
				}
			}
			$html->clear();
			unset($html);
			unset($crawl_inner_text);
		}	
	
		
		$links = mysql_query("select url from nonmp3 where status=0",$db_link_id);
		$num_rows = mysql_num_rows($links);
	}
	ob_end_flush();
?>