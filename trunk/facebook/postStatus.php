<?php
require_once 'facebook/facebook.php';
	require_once('twitter/twitterOAuth.php');
	include 'twitter/EpiCurl.php';
	include 'twitter/EpiOAuth.php';
	include 'twitter/EpiTwitter.php';
	include 'secret.php';
	
	$facebook = new Facebook($appapikey, $appsecret);
	$user_id = $facebook->require_login();
	$db = mysql_connect('localhost','fbapp','lalala') or die("Database error");
	
	mysql_select_db('test', $db);
		
	$query = sprintf("SELECT * FROM user WHERE fb_uid=%d", mysql_real_escape_string($user_id) );
	
	$result = mysql_query($query);

	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	$oauth_token = $row['oauth_token'];
	
	$oauth_token_secret = $row['oauth_token_secret'];
	
	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	$twitterObj->setToken($oauth_token, $oauth_token_secret);
	
	$params['status'] = $_GET['input_field'];
	
	$twitterInfo= $twitterObj->post_statusesUpdate($params);
	
	$html = "<div align='center' class='fbgreybox'>Estado actualizado correctamente</div>";
			
	echo $html;
?>