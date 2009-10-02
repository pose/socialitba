<?php

	require_once 'facebook/facebook.php';
	include 'twitter/EpiCurl.php';
	include 'twitter/EpiOAuth.php';
	include 'twitter/EpiTwitter.php';
	include 'secret.php';
	
	/* Finishing twitter oauth process */	

	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
	
	$twitterObj->setToken($_GET['oauth_token']);
	$token = $twitterObj->getAccessToken();

	$oauth_token = $token->oauth_token;
	$oauth_token_secret = $token->oauth_token_secret;
	
	/* Begining interaction with DB */
	
	$facebook = new Facebook($appapikey, $appsecret);
	$user_id = $facebook->require_login();
	
	$db = mysql_connect('localhost','fbapp','lalala') or die("Database error");
	
	mysql_select_db('test', $db);
	
	
	$query = sprintf("INSERT INTO test.user (fb_uid, oauth_token, oauth_token_secret) VALUES (%d,'%s','%s')",
	    mysql_real_escape_string($user_id),
	    mysql_real_escape_string($oauth_token),
	    mysql_real_escape_string($oauth_token_secret));
	   
	    if ( ! mysql_query($query) ){
	    	$err_msg = sprintf( 'error al insertar. %s', mysql_error());
	    	die($err_msg);
	    }
	    
	header( 'Location: http://apps.facebook.com/jcatalanapp' ) ;
?>