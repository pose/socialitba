<?php

	include 'twitter/EpiCurl.php';
	include 'twitter/EpiOAuth.php';
	include 'twitter/EpiTwitter.php';
	include 'secret.php';

	$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

	echo '<a href="' . $twitterObj->getAuthorizationUrl() . '">Authorizar con Twitter</a>';
?>
