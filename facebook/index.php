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
		createNewUser( $user_id, $consumer_key, $consumer_secret );
	}
	else{
		buildCanvas( $user_id );
	}
	
	
function createNewUser( $user, $consumer_key, $consumer_secret ){

	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	echo '<a href="' . $twitterObj->getAuthorizationUrl() . '">Authorizar con Twitter</a>';	
}

function buildCanvas( $user ){
	$string = 	'<fb:tabs>  ' .
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/user.php" title="User" />  ' .
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/friends.php" title="Friends" align="right"/>  ' .
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/dmessages.php" title="Direct Messages" align="right"/>'.
				'</fb:tabs>';
	echo $string; 
}









