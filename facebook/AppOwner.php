<?php
	require_once 'facebook/facebook.php';
	require_once('twitter/twitterOAuth.php');
	require_once 'AppSecrets.php';
	include 'twitter/EpiCurl.php';
	include 'twitter/EpiOAuth.php';
	include 'twitter/EpiTwitter.php';
	
	
	class AppOwner{	
	
		private $facebook;
		private $user_id;
		private $db;
		private $result;
		private $oauth_token;
		private $oauth_token_secret;
		private $twitterObj;
		private $twitterInfo;
		
		private static $instance;


		public static function getInstance(){
			
			if (  !self::$instance instanceof self){
				self::$instance = new self;
			}
			return self::$instance;
		}
		
		private function __construct(){		
			
			$this->facebook = new Facebook(AppSecrets::appapikey, AppSecrets::appsecret);
		
			$this->user_id = $this->facebook->require_login();
			
			$this->db = mysql_connect(AppSecrets::mysql_host, AppSecrets::mysql_user, 
					AppSecrets::mysql_pass) or die("Database error");
		
			mysql_select_db(AppSecrets::mysql_db, $this->db);
			
			$query = sprintf("SELECT * FROM user WHERE fb_uid=%d", mysql_real_escape_string($this->user_id) );
		
			$this->result = mysql_query($query);
			
			$row = mysql_fetch_array($this->result, MYSQL_ASSOC);
			
			$this->oauth_token = $row['oauth_token'];
			
			$this->oauth_token_secret = $row['oauth_token_secret'];
			
			$this->twitterObj = new EpiTwitter(AppSecrets::consumer_key, 
										AppSecrets::consumer_secret);
		
			$this->twitterObj->setToken($this->oauth_token, $this->oauth_token_secret);
			
		}
		
		public function beginUserCreation(){
			
			$this->getAuthFromTwitter( AppSecrets::consumer_key, 
								AppSecrets::consumer_secret);
							
		}
		
		public function finishUserCreation($auth_token){
			
			/* Finishing twitter oauth process */	

			$this->twitterObj = new EpiTwitter(AppSecrets::consumer_key, AppSecrets::consumer_secret);
			
			$this->twitterObj->setToken($auth_token);
			
			$token = $this->twitterObj->getAccessToken();
		
			$this->oauth_token = $token->oauth_token;
			
			$this->oauth_token_secret = $token->oauth_token_secret;
			
			/* Begining interaction with DB */
			
			$query = sprintf("INSERT INTO test.user (fb_uid, oauth_token, oauth_token_secret) VALUES (%d,'%s','%s')",
			    mysql_real_escape_string($this->user_id),
			    mysql_real_escape_string($this->oauth_token),
			    mysql_real_escape_string($this->oauth_token_secret));
			   
			    if ( ! mysql_query($query) ){
			    	$err_msg = sprintf( 'error al insertar. %s', mysql_error());
			    	die($err_msg);
			    }
		}
		
		public function userExists(){
			return ! ( ! $this->result || mysql_num_rows( $this->result ) == 0 );
		}
		
		public function getUserTimeline(){
			$this->twitterInfo = $this->twitterObj->get_statusesUser_timeline();
			
			return $this->twitterInfo->response;
		}
		
		public function getUserFriendsTimeline(){
			$this->twitterInfo = $this->twitterObj->get_statusesHome_timeline();
			
			return $this->twitterInfo->response;
		}

		public function getDirectMessages(){
			$this->twitterInfo = $this->twitterObj->get_direct_messages();
			
			return $this->twitterInfo->response;
		}
		
		public function postStatusUpdate($status){
			
			$params['status'] = $status;
			
			$this->twitterInfo = $this->twitterObj->post_statusesUpdate($params);
		}

		public function sendUpdatedStatusNotification(){
			$this->facebook->api_client->notifications_send('', 'Your Status Has been Updated!', 'user_to_user');
		}

		public function removeUser(){
			
			$query = sprintf("DELETE FROM user WHERE fb_uid=%d", 
						mysql_real_escape_string($this->user_id) );
		
			$result = mysql_query($query);	
		}
		
		private function getAuthFromTwitter($consumer_key, $consumer_secret){
			
			$this->twitterObj = new EpiTwitter($consumer_key, $consumer_secret);

			echo '<a href="' . $this->twitterObj->getAuthorizationUrl() . '">Authorizar con Twitter</a>';
		}	 
	}

?>
