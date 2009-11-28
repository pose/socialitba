<?php
	
	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance(isset($_POST['fb_sig_in_profile_tab']));
	
	if( ! $owner->userExists() ){
		echo 'Faliur';
	}
	
	$data = $owner->getUserTimeline(NULL);
		
	$html = "<link rel='stylesheet' type='text/css' href='http://catadesk.no-ip.org/style/style.css?v0.9' />" .
			"<fb:header icon='false'>My Updates</fb:header><a href='http://apps.facebook.com/jcatalanapp'>Back</a><br/><br/>";
			
	foreach ( $data as $st ){
		//$owner->facebook->api_client->fbml_refreshImgSrc($st['user']['profile_image_url']); 
		$html .= sprintf (  "<div class='twittBody'><img scr='%s'/> %s </div>", $st['user']['profile_image_url'], $st['text'] );
	}
	
	echo $html;
	
?>
