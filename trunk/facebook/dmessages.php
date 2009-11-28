<?php
	
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance(isset($_POST['fb_sig_in_profile_tab']));
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	$data = $owner->getDirectMessages();
	
	
	$html = "<link rel='stylesheet' type='text/css' href='http://catadesk.no-ip.org/style/style.css?v0.9' />" .
			"<fb:header icon='false'>My Direct Messages</fb:header><a href='http://apps.facebook.com/jcatalanapp'>Back</a>";
			
	foreach ( $data as $st ){
		$html .= sprintf (  "<br/> <div class='twittBody'> %s - %s </div><br/>", $st['sender']['name'], $st['text'] );
	}
	
	echo $html;
?>
