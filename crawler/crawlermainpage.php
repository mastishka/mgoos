<?PHP
include('crawlerphase1.php');
$database="ali";
$db_link_id;
$db_link_id = mysql_connect('localhost','root','');
mysql_select_db($database, $db_link_id);

if (isset($_POST['Submit1'])) 
{
	$selected_radio = $_POST['site'];
		if ($selected_radio == '1') 
		{
			mysql_query("insert into nonmp3 values('http://www.songs.pk',0)",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
			crawler();
		}
		else if ($selected_radio == '2') 
		{
			mysql_query("insert into nonmp3 values('http://www.masti4india.com',0)",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
			crawler();
		}
		else if ($selected_radio == '3') 
		{
			mysql_query("insert into nonmp3 values('http://www.fmw11.com',0)",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
			crawler();
		}
		else if ($selected_radio == '4') 
		{
			mysql_query("insert into nonmp3 values('http://www.muskurahat.com',0)",$db_link_id)or die("Get Url Error: ".mysql_error($db_link_id));
			crawler();
		}
}
if(isset($_POST['addnew']))
{
	$addedurl=$_POST['addurl'];
	echo $addedurl;
}

?>