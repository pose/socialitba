<?php

	include 'AppOwner.php';
	
	$owner = AppOwner::getInstance();
	
	$owner->finishUserCreation( $_GET['oauth_token'] );
	    
	header( 'Location: http://apps.facebook.com/jcatalanapp' );
?>