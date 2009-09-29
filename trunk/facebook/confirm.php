<?php

	require_once 'facebook/facebook.php';
	include 'twitter/EpiCurl.php';
	include 'twitter/EpiOAuth.php';
	include 'twitter/EpiTwitter.php';
	include 'secret.php';
	
	$appapikey = '95f7a9a8eedd1b80064f52b42a6c120e';
	$appsecret = '105b348d3ca252f04d137e268422df22';

	/* Finishing twitter oauth process */	

	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
	
	$twitterObj->setToken($_GET['oauth_token']);
	$token = $twitterObj->getAccessToken();

	$oauth_token = $token->oauth_token;
	$oauth_token_secret = $token->oauth_token_secret;
	
	/* Begining interaction with DB */
	
	$facebook = new Facebook($appapikey, $appsecret);
	$user_id = $facebook->require_login();
	
	$mysql_conn = mysql_connect('localhost', 'fbapp', 'lalala');
	
	if (!$mysql_conn) {
	    die('Could not connect: ' . mysql_error());
	}
	
	$query = sprintf("INSERT INTO user (uid, oauth_token, oauth_token_secret) VALUES (%d,'%s','%s')",
	    mysql_real_escape_string($user_id),
	    mysql_real_escape_string($oauth_token),
	    mysql_real_escape_string($oauth_token_secret));
	
	mysql_query($query,$mysql_conn);
?>