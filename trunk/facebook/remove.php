<?php

	require_once 'facebook/facebook.php';
	include 'secret.php';
	
	$facebook = new Facebook($appapikey, $appsecret);
	$user_id = $facebook->require_login();
	
	error_log(print_r($_REQUEST,true));
	
	$db = mysql_connect('localhost','fbapp','lalala') or die("Database error");
	
	mysql_select_db('test', $db);
	
	$query = sprintf("DELETE FROM user WHERE fb_uid=%d", mysql_real_escape_string($user_id) );

	$result = mysql_query($query);	
?>
