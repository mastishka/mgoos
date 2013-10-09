<?php
function shorten_url($url)
{
	//Set up account info
	$bitly_login = 'mgoos';
	$bitly_api = 'R_c4fd6eaf6155b62fde836cf9ae73f177';
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?&longUrl='.$url.'&login='.$bitly_login.'&apiKey='.$bitly_api.'&format=txt';
	//get the url
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$bitly);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec ($ch);
	return $response;
	curl_close ($ch);
	//parse depending on desired format
}



?>