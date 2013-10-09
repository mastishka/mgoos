<?php 
	include_once("../session_manager.php");
	include_once("../../database/config.php");
	include_once("../utils.php");
   $app_id = "113270275430495";
   $app_secret = "c123ed66d7dd75650a785d3c0f56231a";
   $my_url = "http://beta.mgoos.com/lib/FBConnect/fbgetuserinfo.php";

   session_start();
   $code = $_REQUEST["code"];
   $error_reason = $_REQUEST["error_reason"];
   if(isset($error_reason))
   {
	  header("Location: http://beta.mgoos.com/my_mgoos.php");
   }
   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state']."&scope=email";
	 echo("<script> window.location.href='" . $dialog_url . "'</script>");
   }

   if($_REQUEST['state'] == $_SESSION['state']) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $user = json_decode(file_get_contents($graph_url));
	$database = "mgooscom_audio";
	$db_link_id = mysql_connect(CConfig::HOST, CConfig::USER_NAME , CConfig::PASSWORD) or die("Could not connect: " . mysql_error());
	mysql_select_db($database, $db_link_id);
	$uid=CUtils::uuid();
	mysql_query("insert ignore into alien_users (user_id,fname,lname,email) values ('$uid','$user->first_name','$user->last_name','$user->email')",$db_link_id) or die("Could not query: " . mysql_error());
	$get_uuid=mysql_query("select user_id from alien_users where email like '$user->email'",$db_link_id) or die("Could not query: " . mysql_error());
	$uuid_value=mysql_fetch_object($get_uuid);
	CSessionManager::SetUserId($uuid_value->user_id);
	CSessionManager::SetEmailId($user->email);
	CSessionManager::SetLoggedIn(true) ;
	CSessionManager::SetReferredFrom(CSessionManager::REF_FROM_MY_MGOOG_PHP);
	header("Location: http://beta.mgoos.com/search_results.php");
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }

 ?>