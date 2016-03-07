<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Abraham\TwitterOAuth\TwitterOAuth;
use MetzWeb\Instagram\Instagram;

require_once ROOT . '/vendor/Facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

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
		'app_id' => '1664076740532832',
		'app_secret' => 'a180fa4be0822cce909ecf69d1eb23e8',
		'default_graph_version' => 'v2.5',
	]);
	$fb_id = "10153885670188116";
	$asscee_t_1="CAAXpeA7ZCmmABADTVmawwasxJQxiuImZCdZA2gqQ3JY38IiQXpqnSJ3ZAG9VYayEYWW1NZA4bAxUi4VgZCIiIZBC9jZAVN6q0LJU7VYt9NJZCYC6MWswIf2UivIyPyVw9oShHyqSpjHMDZAhOKnQuCfz7fIWw427WWLBpZCidSLZBwEjijNY2Ovn3zU11Rl0qX4FfRZCIZC4ZA3VJZAmtqb4Uz4ZCJrGBZATKJwctfbzMZD";
	$asscee_t_2="CAAXpeA7ZCmmABACX0mNMrpd6oYtQkaKfKZCnllG4BuZCC4u6ZBOnw96bKUHWwhEL9zCWNZAvIRD3qPrKwwfT9vNdNc631F1J5eQkhxRnt0x5MfqXjgvR72PIX9Wtd7oRHOZBzfrvr3xlLYbID22794R08u7WxpmF7hpuZBbPRftEauWMQPLo6aNWaYujwXTnzZC1GzZA76m26Yx9gyrWZAVuLdgq4cpQANMt24qIJxv9WRcgZDZD";
	//$asscee_t="CAACEdEose0cBACc0PK7sS2bRMhzjqh7LDsbe5fivAsxXvBBZC9SxQXeGzYWzhp4Goin1wFr3nKzYc09AeTzZAM42cdwhn3j8ekPa1ZCjsBL2p7ySbDoEMLwb4MmUNnZCZA9gGbps83wpgcwndIdyYqlWhtZCPZBXuYtakRxKqwBz260n7Kk06ofCqjKbIEN9m0HCyfVRdLdGncpxdev0RlY";
	$fbApp = new \Facebook\FacebookApp('1664076740532832', 'a180fa4be0822cce909ecf69d1eb23e8');
	$request = new \Facebook\FacebookRequest($fbApp, $asscee_t_2, 'GET', 'me/likes');
//	$resp = $fb->get('/me/friends', $asscee_t);
	//$response = $fb->get('/'.$fb_id.'?fields=id,name', $asscee_t_2);
	//$graphNode = $resp->getGraphEdge();
	//$get_data = $response->getDecodedBody();
//	PRINT_R($get_data); DIE;
//	echo $get_data['summary']['total_count']; die;
	// Send the request to Graph
try {
  $response = $fb->getClient()->sendRequest($request);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}



print_r($response->getDecodedBody()['data']);DIE;

	//$request = $fb->request('GET', '/530767340283701/likes', $asscee_t);
	//print_r($request); die;
	//$fb = \Facebook\FacebookApp('1664076740532832', 'a180fa4be0822cce909ecf69d1eb23e8');

	/*
	$fb_id = "10153885670188116";
	$asscee_t="CAAXpeA7ZCmmABADTVmawwasxJQxiuImZCdZA2gqQ3JY38IiQXpqnSJ3ZAG9VYayEYWW1NZA4bAxUi4VgZCIiIZBC9jZAVN6q0LJU7VYt9NJZCYC6MWswIf2UivIyPyVw9oShHyqSpjHMDZAhOKnQuCfz7fIWw427WWLBpZCidSLZBwEjijNY2Ovn3zU11Rl0qX4FfRZCIZC4ZA3VJZAmtqb4Uz4ZCJrGBZATKJwctfbzMZD";
	//$response = $fb->get('/'.$fb_id.'?fields=id,name', $asscee_t);
	try {
  // Returns a `Facebook\FacebookResponse` object
  //$response = $fb->get('/'.$fb_id.'?fields=id,name', $asscee_t);
  $response = $fb->get('/'.$fb_id.'/likes', $asscee_t);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

//$user = $response->getGraphNode();

//echo 'Name: ' . $user['name']; die;

	//$response = $fb->get('/'.$fb_id.'/follows', $asscee_t);
	print_r($response); die('--eee');
	*/

	}
	
	public function InstagConnect(){
	
		$instagram = new Instagram(array(
		'apiKey'      => '4332edb055b740518267a61c647c5654',
		'apiSecret'   => 'aec34fe7a77a4bc2a4aa8b61fb45e5a',
		'apiCallback' => 'https://1SourceDFW.betasoft.com'
	));
	print_r($instagram); 

	}
	
}
?>