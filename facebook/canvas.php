<?php

	require_once 'facebook/facebook.php';
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
	
	
	if ( ! result || mysql_num_rows( $result ) == 0 ){
		createNewUser( $user_id );
	}
	else{
		buildCanvas( $user_id );
	}
	
	
function createNewUser( $user ){
	$consumer_key = 'N57iCnEqUfPewcUGipJKGg';
	$consumer_secret = 'Zn6huTSzi5XRL9CNRzEWD8zqvuZuT90ZRsZ4kEORqwA';
	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	echo '<a href="' . $twitterObj->getAuthorizationUrl() . '">Authorizar con Twitter</a>';	
}

function buildCanvas( $user ){
	$string = sprintf( 'Hola mundo, <fb:name uid=%d/>!', $user );
	echo $string; 
}