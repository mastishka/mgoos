<?php
include_once('database/config.php');
include_once('lib/utils.php');
echo "<html>
<head>
<script src=\"js/ajax.js\" type=\"text/javascript\"></script>
<script src=\"js/swfobject.js\" type=\"text/javascript\"></script>
<script src=\"js/ep_player.js\" type=\"text/javascript\"></script>
<script type=\"text/javascript\">
function addto(url, title)
{
	parent.EP_addTracks('ep_player1', '<track><location>'+url+'</location><title>'+title+'</title></track>', 999);
}
function confirm_update(id,title,album,artist,genre,language,composer,pict,year)
{
	var poststr = 'id='+id+'&title='+title+'&album='+album+'&artist='+artist+'&genre='+genre+'&language='+language+'&composer='+composer+'&pict='+pict+'&year='+year;
	AJAX.MakePostRequest(\"ajax/citation_update_table.php\", poststr, this.callback_empty);
}
function callback_empty()
{
	var contents = AJAX.GetContents();
}
</script>
</head>
<body>";
$database='mgooscom_audio';
$db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
mysql_select_db($database,$db_link_id);
$links=mysql_query('select * from citation_request',$db_link_id) or die ("Select Citation error : " . mysql_error());
//$num_rows = mysql_num_rows($links);
//echo $num_rows;


echo "<table border='1' cellpadding='10'>";
echo "<tr><td style='border-bottom-style:solid;border-bottom-width:4px;'>Title</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>ALbum</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Artist</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Genre</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Language</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Composer</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Picturized On</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Year</td><td style='border-bottom-style:solid;border-bottom-width:4px;'>Confirm ?</td>";
while($row = mysql_fetch_assoc($links))
{
		$songid=$row['songid'];
		$songname=$row['title'];
		$songalbum=$row['album'];
		$songartist=$row['artist'];
		$songgenre=$row['genre'];
		$songcomposer=$row['composer'];
		$songpict=$row['picturizedon'];
		$songyear=$row['year'];
		$songlanguage=$row['language'];
		$url=mysql_query("select filepath, title from mp3_info where id like '$songid'",$db_link_id) or die ("Select mp3info error : " . mysql_error());
		echo "<tr><td>".$row['title']."</td><td>".$row['album']."</td><td>".$row['artist']."</td><td>".$row['genre']."</td><td>".$row['language']."</td><td>".$row['composer']."</td><td>".$row['picturizedon']."</td><td>".$row['year']."</td><td>";
		$fetch_url=mysql_fetch_assoc($url);
		$final_url=$fetch_url['filepath'];
		$final_title=$fetch_url['title'];
		echo "<input type ='button' value='confirm' onclick=\"confirm_update('$songid','$songname','$songalbum','$songartist','$songgenre','$songlanguage','$songcomposer','$songpict','$songyear');this.disabled=1;\">&nbsp;&nbsp;&nbsp;&nbsp;<A HREF='javascript:;' onClick=\"addto('$final_url','$final_title')\">Check &gt;&gt;</A></td></tr>"; 
}
echo "</table>";
echo "</body>";
echo "</html>";
?>