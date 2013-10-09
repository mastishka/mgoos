<?php 
include_once("../database/config.php");
//include_once("../donn/download.php");
$db_link_id ;
$database = "mgooscom_audio";
$db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
mysql_select_db($database, $db_link_id);
session_start();
$errors = '';

if(isset($_POST['submit']))
{
	
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "\n The captcha code does not match!";
	}
	if(empty($errors))
	{
		$id=($_POST['url']);
		$query="select filepath, title from mp3_info where id like '".$id."'";
		$link=mysql_query($query,$db_link_id);
		$retrive_link=mysql_fetch_object($link);
		//provide_download($retrive_link->title,$retrive_link->filepath);
		/*header('Content-type: application/force-download');

		// It will be called [title].mp3
		header('Content-Disposition: attachment; filename="'.$retrive_link->title.'.mp3"');
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".@filesize($retrive_link->filepath));*/

		//header("Location: ".$retrive_link->filepath);
		//header("Location: http://soundx.mp3pk.com/indian/dil_kya_kare/7dkk(songs.pk).mp3');

		header('Content-type: application/mp3');
        header('Content-Disposition: attachment; filename="'.$retrive_link->title.'.mp3"');
		header("Content-Length: ".@filesize($retrive_link->filepath));
        $f = file_get_contents($retrive_link->filepath);
        print $f;

	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Validate Captcha</title>
<!-- define some style elements-->
<style>
label,a, body 
{
	font-family : Arial, Helvetica, sans-serif;
	font-size : 12px; 
}
.err
{
	font-family : Verdana, Helvetica, sans-serif;
	font-size : 12px;
	color: red;
}
</style>	
<!-- a helper script for vaidating the form-->
<script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>	
</head>

<body>
<?php
if(!empty($errors)){
echo "<p class='err'>".nl2br($errors)."</p>";
}
?>
</body>
</html>