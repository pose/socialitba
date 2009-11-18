<?php
	
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance();
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	
	$data = $owner->postStatusUpdate($_GET['input_field']);
	
	$owner->sendUpdatedStatusNotification();
	
	header( 'Location: index.php' );
?>