<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Abraham\TwitterOAuth\TwitterOAuth;
require_once ROOT . '/vendor/Facebook/autoload.php';
class TwitterComponent extends Component
{
	public $oauth_access_token;
	public $oauth_access_token_secret;
	public $consumer_key;
	public $consumer_secret;
	
	public function __construct()
    {
    $this->oauth_access_token = "4024026614-YzNlvVqSSGbG3kNR9Nik4aoyKy9zpCugloyVm8H";
    $this->oauth_access_token_secret = "zJAhBgxyOQQYICCM1o908EVFAPJKQwWkNM6jkmny3rrP7";
    $this->consumer_key = "LEqoRF6gLyLPxIFlGDjze5xd0"; // For Offerz-develop app
    $this->consumer_secret = "c0B582T95BFWUUzR2UnOFqWb2RaDQpQ1BH7qPC0aD7w1cf6hVR";
    }
	
	
	public function getTwitterConn(){
	$consumer_key = $this->consumer_key;
	$consumer_secret = $this->consumer_secret;
	$connection = new TwitterOAuth($consumer_key, $consumer_secret);
	return $connection;
	}
    public function connect()
    {
   /*  $oauth_access_token = "4024026614-YzNlvVqSSGbG3kNR9Nik4aoyKy9zpCugloyVm8H";
    $oauth_access_token_secret = "zJAhBgxyOQQYICCM1o908EVFAPJKQwWkNM6jkmny3rrP7";
    $consumer_key = "LEqoRF6gLyLPxIFlGDjze5xd0"; // For Offerz-develop app
    $consumer_secret = "c0B582T95BFWUUzR2UnOFqWb2RaDQpQ1BH7qPC0aD7w1cf6hVR"; */
	$consumer_key = $this->consumer_key;
	$consumer_secret = $this->consumer_secret;
	$connection = new TwitterOAuth($consumer_key, $consumer_secret);
	$request_token= $connection->oauth('oauth/request_token', array('oauth_callback' => SITE_URL."client/callback_twitter"));
	$url = $connection->url("oauth/authorize", array("oauth_token" => $request_token['oauth_token']));
	//header('Location: '. $url);
	
	// die('--333');
	return $url;
    }
	
	public function getTwitterData($screen_name)
    {
	
	$conn = $this->getTwitterConn();
	$obj = $conn->get("statuses/user_timeline",array("screen_name"=>$screen_name,"count"=>'1'));
	if(!isset($obj->errors)){
	
	$data['tw_data'] = $obj[0];
	return $data;
	}
	return false;
	}
	public function callback($consumer_key, $consumer_secret,$oauth_access_token , $oauth_access_oauth_verifier){
	
	$oauth_access_token = $oauth_access_token;
	$oauth_access_token_secret = $oauth_access_oauth_verifier;
	$consumer_key = "LEqoRF6gLyLPxIFlGDjze5xd0";
	$consumer_secret = "c0B582T95BFWUUzR2UnOFqWb2RaDQpQ1BH7qPC0aD7w1cf6hVR";
	$connection = new TwitterOAuth($consumer_key, $consumer_secret,$oauth_access_token , $oauth_access_token_secret );
	
	$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $oauth_access_token_secret));
	
	// print_r($access_token); die;
	$screen_name = $access_token['screen_name'];
	$oauth_token = $access_token['oauth_token'];
	$oauth_secret_token = $access_token['oauth_token_secret'];
	$twitter_id = $access_token['user_id'];
	
	$connection2 = new TwitterOAuth($consumer_key, $consumer_secret,$oauth_token , $oauth_secret_token );
	$obj = $connection2->get("statuses/user_timeline",array("screen_name"=>$screen_name,"count"=>'1'));
	$access_token['tw_data'] = $obj[0];
	return $access_token;
	}
	
	public function fb_conn(){
	//echo ROOT . '/vendor/Facebook/autoload.php'; die('ddd');
	$fb = new \Facebook\Facebook([
		'app_id' => '951163998343745',
		'app_secret' => '7a488717c25b50e0c5dda132b1cec166',
		'default_graph_version' => 'v2.5',
	]);
	$asscee_t="CAACEdEose0cBAE1ukOjW346XICjq0AriW8bWShtDyXaM9SJbsQ6efZBr2vdS5hzKZAzWFbZBpZCJlVkGRODnnRXJPIdFNLxd4KITxxVsHZA8qfGvlvOBgodCrh2ftj8nnCGjxM2CsphllkTv4FDrZBD1GsPXw8hGrEWBkjQaABnG8v2u1dfTZAYpeIh0C2VGilZB8rxPDMey2gZDZD";
 // $response = $fb->get('/me?fields=id,name', $asscee_t);
	print_r($fb); die('--eee');
	

	}
	
}
?>