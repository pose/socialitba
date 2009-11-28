<?php
	
	require_once('AppOwner.php');
	require_once('helpers.php');

	$owner = AppOwner::getInstance($_POST['fb_sig_in_profile_tab']);
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	$data = $owner->getUserFriendsTimeline();
	
	$context['title'] = "My Friends's Updates";
	$context['data'] = '';
					
	foreach ( $data as $st ){
		$context['data'] .= sprintf (  "<br/> <div class='twittBody'> <span><img class='profilePic' src='%s'/></span> <span class='twitText'> %s </span> </div><br/>", $st['user']['profile_image_url'], $st['text'] );
	}
	
	render( "templates/friends.html", $context );
?>
