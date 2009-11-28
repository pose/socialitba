<?php

	include 'AppOwner.php';

	AppOwner::getInstance($_POST['fb_sig_in_profile_tab'])->removeUser();	

?>
