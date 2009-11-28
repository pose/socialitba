<?php
	
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance(isset($_POST['fb_sig_in_profile_tab']));
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	
	$data = $owner->postStatusUpdate($_GET['status_field']);
	
	$owner->sendUpdatedStatusNotification();
	
	header( 'Location: index.php' );
?>