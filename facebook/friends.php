<?php
	
	require_once('AppOwner.php');
	require_once('helpers.php');

	$owner = AppOwner::getInstance();
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	$data = $owner->getUserFriendsTimeline();
	
	$context['title'] = "My Friends's Updates";
	$context['data'] = '';
					
	foreach ( $data as $st ){
		$context['data'] .= sprintf (  "<br/> <div class='fbgreybox'> %s - %s </div><br/>", $st['user']['name'], $st['text'] );
	}
	
	render( "templates/friends.html", $context );
?>
