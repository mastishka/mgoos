<?php
if(isset($_POST['fblogin']))
{
	echo("<script> window.open('http://beta.mgoos.com/lib/FBConnect/fbgetuserinfo.php','plain','width=470,height=452')</script>"); 
	//header("Location: http://beta.mgoos.com/lib/FBConnect/fbgetuserinfo.php");
	//https://www.facebook.com/dialog/oauth?
     //client_id=113270275430495&redirect_uri=http://beta.mgoos.com/lib/FBConnect/fbgetuserinfo.php&scope=email
}
?>

<html>
<head>
</head>
<body>
<form method='post'>
<input type='submit' name='fblogin' value='login with facebook'/>
</form>