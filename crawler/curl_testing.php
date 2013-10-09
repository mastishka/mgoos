<?php
/**
* Initialize the cURL session
*/
$ch = curl_init();
/**
* Set the URL of the page or file to download.
*/
curl_setopt($ch, CURLOPT_URL,
'http://www.songs.pk');
/**
* Ask cURL to return the contents in a variable
* instead of simply echoing them to the browser.
*/
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
/**
* Execute the cURL session
*/
$contents = curl_exec ($ch);
echo "<pre>";
print_r($contents);
echo "</pre>";
/**
* Close cURL session
*/
curl_close ($ch);
?>