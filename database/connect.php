<?php
// Connection to database starts
$connect = mysql_connect('localhost','mgooscom_ritesh','ritesh')
or die(mysql_error());
mysql_select_db('hr',$connect) or die(mysql_error());
?>