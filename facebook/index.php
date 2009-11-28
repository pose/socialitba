<?php
	require_once('facebook/facebook.php');
	require_once('helpers.php');
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance(isset($_POST['fb_sig_in_profile_tab']));
	
	//Seteo el profile Box
	
	$profile_html = '<img src="http://catadesk.no-ip.org/images/ctlogo.png"/><br/>' .
			'<a href="http://www.twitter.com/home">Twitter Home</a> ' .
			'<a href="http://apps.facebook.com/jcatalanapp">CataTwitter</a>';
			
	
	if ( ! $owner->userExists() ){
		$owner->beginUserCreation();
	}
	else{
		$owner->facebook->api_client->profile_setFBML(NULL, $owner->user_id, $profile_html, NULL, NULL, $profile_html);
		render("templates/index.html", NULL);
	}









