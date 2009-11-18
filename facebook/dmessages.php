<?php
	
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance();
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	$data = $owner->getDirectMessages();
	
	
	$html = "<link rel='stylesheet' type='text/css' href='http://190.16.39.171/style.css' />" .
			"<fb:header icon='false'>My Direct Messages</fb:header>";
			
	foreach ( $data as $st ){
		$html .= sprintf (  "<br/> <div class='fbgreybox'> %s - %s </div><br/>", $st['sender']['name'], $st['text'] );
	}
	
	echo $html;
?>
