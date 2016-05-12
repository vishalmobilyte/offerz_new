<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth; // TWITTER 
//use Cake\Datasource\ConnectionManager;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class SocialController extends Controller
{
	
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
	public $helpers = ['Form','Flash'];
	
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Twitter'); // LOAD TWITTER COMPONENT
        $this->loadComponent('Facebook'); // LOAD Facebook COMPONENT
		$this->session = $this->request->session();
		
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
		
		$this->viewBuilder()->layout('client_new');
		$client_id = $this->request->session()->read('Client.id');
		//$client_id = '5';
		if($client_id){
		$Clients = TableRegistry::get('Clients');
		$article = $Clients->get($client_id);
		$this->set('client_data',$article);
		}
		else{
		$this->set('client_data','');
		
		}
		
    }
	
	public function myview(){
	$this->viewBuilder()->layout('client_new');
	//$connection = $this->Twitter->connect();
	//$connection_fb = $this->Twitter->fb_conn();
	//print_r($connection); die("YIPPIEEE !!!");
	//die('eeee');
	$session = $this->request->session();
	$session->write('User.user_id', '1');
	$Clients = TableRegistry::get('Clients');
//	$Clients_qry = TableRegistry::get('ClientQueries');

		//$query_clt = $Clients_qry->find();
		/*
		foreach ($query_clt as $rows) {
			echo $rows->content_query;
			echo "<hr>";
		}
		*/
		$query = $Clients->find('all')->contain(['Offers']);
		
		foreach ($query as $row) {
		//print_r($row);
		foreach($row->offers as $offer){
		//	echo @$offer->id.'--';
		}
			
			//echo $row->offers[0]->editable_text;
		//	echo "<hr>";
		}
	}
	
	public function index()
	{
	if(!$this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);			
		}
		else{
		return $this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
		
		}
		
	}
	// ----------------  Update Twitter Data in CLIENT table  ------------------
	public function updateSocialData(){
	$ClientsTable = TableRegistry::get('Clients');
	$query = $ClientsTable->find('all')->select(['screen_name','id'])->where(['screen_name !='=>''])->hydrate(false)->toArray();
	//print_r($query); die;
	foreach($query as $data){
	$screen_name = $data['screen_name'];
	$client_id = $data['id'];
	$get_twitter_data = $this->Twitter->getTwitterData($screen_name);
	$Clients = $ClientsTable->get($client_id);
		$tweets_count = @$get_twitter_data['tw_data']->user->statuses_count; 
		$followers_count = @$get_twitter_data['tw_data']->user->followers_count; 
		$favourites_count = @$get_twitter_data['tw_data']->user->favourites_count; 
		$retweet_count = @$get_twitter_data['tw_data']->retweet_count; 
		$twt_pic = @$get_twitter_data['tw_data']->user->profile_image_url; 
		
		$Clients->twt_tweets = $tweets_count;
		$Clients->twt_retweets = $retweet_count;
		$Clients->twt_favorites = $favourites_count;
		$Clients->twt_followers = $followers_count;
		$Clients->twt_pic = $twt_pic;
		
		
		$ClientsTable->save($Clients);
	}
	die('Updated Successfully');
	}
	//	//Update Twitter Data in USERS table 
	public function updateSocialDataUsers(){
	
	$UsersTable = TableRegistry::get('Users');
	$query = $UsersTable->find('all')->select(['screen_name','id'])->where(['screen_name !='=>''])->hydrate(false)->toArray();
	//print_r($query); die;
	foreach($query as $data){
	$screen_name = $data['screen_name'];
	$client_id = $data['id'];
	$get_twitter_data = $this->Twitter->getTwitterData($screen_name);
	$Users = $UsersTable->get($client_id);
	
		$followers_count = @$get_twitter_data['tw_data']->user->followers_count; 
		$twt_pic = @$get_twitter_data['tw_data']->user->profile_image_url; 
		
		
		$Users->twt_followers = $followers_count;
		$Users->twt_pic = $twt_pic;
		
		
		$UsersTable->save($Users);
	}
	//mail("vishal.kumar@mobilyte.com","test Cron ran","cron is working here");
	
	die('Updated Successfully');
	}
	
	// ========= UPDATE FACEBOOK FRIENDS COUNT FOR MOBILE USER ( INFLUENCERS ) ============
	public function updateFbDataUsers(){
	
	$UsersTable = TableRegistry::get('Users');
	$query = $UsersTable->find('all')->select(['fb_token','id'])->where(['fb_token !='=>'','status'=>'1'])->hydrate(false)->toArray();
	//print_r($query); die;
	foreach($query as $data){
	$fb_token = $data['fb_token'];
	$client_id = $data['id'];
	$get_fb_data_friends_count = $this->Facebook->getFacebookData($fb_token);
	$Users = $UsersTable->get($client_id);
	
		$fb_friends_count = @$get_fb_data_friends_count; 
		
		$Users->fb_friends = $fb_friends_count;
		
		$UsersTable->save($Users);
	}
	mail("vishal.kumar@mobilyte.com","FB test Cron ran for FB","cron is working here for facebook friends updateFbDataUsers");
	
	die('Updated Successfully');
	}
	/*
	Function: updateFbDataOffers
	Description: Updates the count of likes for offer which user has shared
	*/
	public function updateFbDataOffers(){
	
	$UserOffersTable = TableRegistry::get('UserOffers');
	
	$query = $UserOffersTable->find('all')->contain(['Users'])
	->select(['id','Users.fb_token','Users.id','post_id_fb'])->where(['shared_via'=>'FACEBOOK','UserOffers.status'=>'1','post_id_fb !='=>''])
	->hydrate(false)->toArray();
	//print_r($query); die;
	foreach($query as $data){
	$fb_token = $data['user']['fb_token'];
	$post_id_fb = $data['post_id_fb'];
	$user_offer_id = $data['id'];
	$get_fb_data_likes_count = $this->Facebook->getFbLikesCount($fb_token,$post_id_fb);
	$get_fb_data_shares_count = $this->Facebook->getFbsharesCount($fb_token,$post_id_fb);
	$UsersOffer = $UserOffersTable->get($user_offer_id);
	
		$fb_likes_count = @$get_fb_data_likes_count; 
		$fb_shares_count = @$get_fb_data_shares_count; 
		
		$UsersOffer->fb_likes = $fb_likes_count;
		$UsersOffer->fb_shares = $fb_likes_count;
		
		$UserOffersTable->save($UsersOffer);
	}
	mail("vishal.kumar@mobilyte.com","FB test Cron ran for FB","cron is working here for facebook  updateFbDataOffers");
	
	die('Updated Successfully');
	}
	/*
	Function: updateFbDataOffers
	Description: Updates the count of TWITTER Tweets and Favourites for offer which user has shared
	*/
	public function updateTwtDataOffers(){
	
	$UserOffersTable = TableRegistry::get('UserOffers');
	
	$query = $UserOffersTable->find('all')->contain(['Users'])
	->select(['id','Users.id','twt_id'])->where(['shared_via'=>'TWITTER','UserOffers.status'=>'1','twt_id !='=>''])
	->hydrate(false)->toArray();
	//print_r($query); die;
	foreach($query as $data){
	//$fb_token = $data['user']['fb_token'];
	$twt_id = $data['twt_id'];
	$user_offer_id = $data['id'];
	$twt_data = $this->Twitter->getRetweets($twt_id); 
	//$twt_data = $this->Twitter->getRetweets('712590902301097984'); 
	$UsersOffer = $UserOffersTable->get($user_offer_id);
	
		$retweets = @$twt_data['retweets']; 
		$favourites = @$twt_data['favourites']; 
		echo $retweets.'--'.$favourites.' for offer '.$user_offer_id. 'for twt id ->'.$twt_id.'<hr>';
		$UsersOffer->twt_retweets = $retweets;
		$UsersOffer->twt_likes = $favourites;
		
		$UserOffersTable->save($UsersOffer);
	}
	//mail("vishal.kumar@mobilyte.com","FB test Cron ran for FB","cron is working here for Twitter  updateTwtDataOffers");
	
	die('Updated Successfully');
	}
	
	
	// =================== Connect to Twitter  ====================
	public function connectTwitter(){
		$connection_url = $this->Twitter->connect();
		$this->redirect($connection_url);
	}
	// ================== Callback Twitter =========================
	public function callbackTwitter(){
		$oauth_access_token = $this->request->query['oauth_token'];
		$oauth_access_oauth_verifier = $this->request->query['oauth_verifier'];
		
		
		$consumer_key = "LEqoRF6gLyLPxIFlGDjze5xd0";
		$consumer_secret = "c0B582T95BFWUUzR2UnOFqWb2RaDQpQ1BH7qPC0aD7w1cf6hVR";
		$access_token = $this->Twitter->callback($consumer_key, $consumer_secret,$oauth_access_token , $oauth_access_oauth_verifier);
		
		
		$screen_name = $access_token['screen_name'];
		$oauth_token = $access_token['oauth_token'];
		$oauth_secret_token = $access_token['oauth_token_secret'];
		$twitter_id = $access_token['user_id'];
		
		$tweets_count = $access_token['tw_data']->user->statuses_count; 
		$followers_count = $access_token['tw_data']->user->followers_count; 
		$favourites_count = $access_token['tw_data']->user->favourites_count; 
		$retweet_count = $access_token['tw_data']->retweet_count; 
		$twt_pic = $access_token['tw_data']->user->profile_image_url; 
		
		$client_id = $this->request->session()->read('Client.id');
		
		$ClientsTable = TableRegistry::get('Clients');
		
		$Clients = $ClientsTable->get($client_id); // Return article with id 12

		$Clients->screen_name = $screen_name;
		$Clients->oauth_token = $oauth_token;
		$Clients->oauth_secret_token = $oauth_secret_token;
		$Clients->twitter_id = $twitter_id;
		
		$Clients->twt_tweets = $tweets_count;
		$Clients->twt_retweets = $retweet_count;
		$Clients->twt_favorites = $favourites_count;
		$Clients->twt_followers = $followers_count;
		$Clients->twt_pic = $twt_pic;
		
		
		$ClientsTable->save($Clients);
		
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
	}
	//  ========================= Unlink Twitter ===========================
	
	
	
}