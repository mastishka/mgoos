<?php
	include('simple_html_dom.php');
	include('redirector.php');
	$database="ali";
	$db_link_id;
	$db_link_id = mysql_connect('localhost','root','');
	mysql_select_db($database, $db_link_id);
	$pattern1='/(href)=[\'"]?([^\'" >]+)[\'" >]/';
	$mp3_pattern='/\.mp3/';
	$parent_url='http://songs.pk/e_list.html';
	$html = file_get_html($parent_url);
	$i=0;
	$link_check='';
	
	if (ob_get_level() == 0) 
		ob_start();

	if(preg_match_all($pattern1,$html->innertext,$out, PREG_SET_ORDER))
	foreach($out as $link)
	{	
				
				/*if(strcmp($link[2][0],'h') !== 0)
				{	
					$link[2]=$parent_url1.$link[2];
				}*/
				//Add link to database here
				$k=strpos($link_check,$link[2]);
				if($k == FALSE )
				{
					$i++;
					$link_check=$link_check.' '.$link[2];
					$str=mysql_real_escape_string($link[2]);
					$final=get_final_url($str);
					if(preg_match_all($mp3_pattern,$final,$mp3check,PREG_SET_ORDER))
					{
						mysql_query("insert into mp3_url values($i,'$final')",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
						echo "<pre>";
							echo "link $i added to database";
						echo "</pre>";
							

					}
				}
				else 
				continue;
				$html_child=file_get_html($link[2]);
				//check in database if the link is already present
				//if yes then proceed else clear html_child and continue
				if(strcmp($html_child->innertext,"")!== 0)
				{
					if(preg_match_all($pattern1,$html_child->innertext,$out_child, PREG_SET_ORDER))
					{
						foreach($out_child as $link_child)
						{
							if(strcmp($link_child[2][0],'h') !== 0)
							{
								continue;
							}
							$k=strpos($link_check,$link_child[2]);
							if($k == FALSE )
							{
								$i++;
								$link_check=$link_check.' '.$link_child[2];
								$str=mysql_real_escape_string($link_child[2]);
								$final=get_final_url($str);
								if(preg_match_all($mp3_pattern,$final,$mp3check,PREG_SET_ORDER))
								{
									mysql_query("insert into mp3_url values($i,'$final')",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
									echo "<pre>";
										echo "link $i added to database";
									echo "</pre>";

									ob_flush();
							        flush();
								}
							}
							else
								continue;
							
						}
					}
				}
				$html_child->clear();
	}	

	$html->clear();
	ob_end_flush();
?>