<?php

	include 'AppOwner.php';
	
	$owner = AppOwner::getInstance($_POST['fb_sig_in_profile_tab']);
	
	$owner->finishUserCreation( $_GET['oauth_token'] );
	    
	header( 'Location: http://apps.facebook.com/jcatalanapp' );
?>