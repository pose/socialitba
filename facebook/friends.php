<?php
	
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance();
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	$data = $owner->getUserFriendsTimeline();
	
	$html = "<link rel='stylesheet' type='text/css' href='http://190.16.39.171/style.css' />" .
			"<fb:header icon='false'>My Friends's Updates'</fb:header>";
			
	foreach ( $data as $st ){
		$html .= sprintf (  "<br/> <div class='fbgreybox'> %s - %s </div><br/>", $st['user']['name'], $st['text'] );
	}
	
	echo $html;
?>
