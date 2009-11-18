<?php

	require_once('AppOwner.php');
	
	$owner = AppOwner::getInstance();
	
	if ( ! $owner->userExists() ){
		$owner->beginUserCreation();
	}
	else{
		buildCanvas( $user_id );
	}
	
	


function buildCanvas( $user ){
	$string = 	"<link rel='stylesheet' type='text/css' href='style.css' />" .
				'<fb:tabs>  ' .
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/user.php" selected=True title="User" />  ' .
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/friends.php" title="Friends" align="right"/>  ' .
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/dmessages.php" title="Direct Messages" align="right"/>'.
					'<fb:tab-item href="http://apps.facebook.com/jcatalanapp/templates/invite.html" title="Invite Friends" align="left"/>'.
				'</fb:tabs>' .
				'</br></br>Ingrese su estado nuevo: </br></br>' .
				'<div>' .
					'<form method="get" action="postStatus.php">
	  					<textarea name="input_field" class="field"></textarea></br>' .
	  					'<input type="submit"/>
	 				</form>' .
 				'</div>';
 				
	echo $string; 
}









