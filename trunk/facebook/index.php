<?php
	require_once('facebook/facebook.php');
	require_once('helpers.php');
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance();
	
	if ( ! $owner->userExists() ){
		$owner->beginUserCreation();
	}
	else{
		render("templates/index.html", NULL);
	}









