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
	
	$twitterInfo= $twitterObj->get_statusesUser_timeline();
	
	$html = "<link rel='stylesheet' type='text/css' href='http://190.16.38.12/style.css' />" .
			"<fb:header icon='false'>My Updates</fb:header>";
			
	foreach ( $twitterInfo->response as $st ){
		$html .= sprintf (  "<br/> <div class='fbgreybox'> %s </div><br/>", $st['text'] );
	}
	
	echo $html;
	
?>
