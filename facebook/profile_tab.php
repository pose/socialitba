<?php

	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance($_POST['fb_sig_in_profile_tab']);
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	$params['count'] = 10;
	
	$data = $owner->getUserTimeline($params);
	$html = "<fb:header icon='False'>Last 10 Updates</fb:header>"; 	
	$html .= "<link rel='stylesheet' type='text/css' href='http://catadesk.no-ip.org/style/style.css?v=1.0' />";
			
	foreach ( $data as $st ){
		$html .= sprintf (  "<div class='twittBody'> <img scr='%s'/> %s </div>", $st['user']['profile_image_url'], $st['text'] );
	}
	
	echo $html;
?>
