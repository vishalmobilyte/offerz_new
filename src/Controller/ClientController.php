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
use Abraham\TwitterOAuth\TwitterOAuth;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class ClientController extends Controller
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
	public $helpers = ['Form'];
	
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Twitter');
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
		$id = '5';
		$Clients = TableRegistry::get('Clients');
		$article = $Clients->get($id);
		$this->set('client_data',$article);
		
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
	
	public function login()
    {
		$session = $this->request->session();
		echo $session->read('Client.id'); 
		echo $session->read('Client.email'); 
		//die('-');
		//print_r($this->request->data);
		if(isset($this->request->data['username']) && !empty($this->request->data['username']))

		{
		$params = $this->request->data;
		$email = trim($this->request->data['username']);
		$password = trim($this->request->data['password']);
		$Clients = TableRegistry::get('Clients');
		// An advanced example
		$results = 	$Clients->find()
							->where(['email' => $email,'password'=>$password])
							->toArray(); // Also a collections library method

		if(count($results) > 0){
		$client_id = $results[0]->id;
		$client_name = $results[0]->name;
		$client_email = $results[0]->email;
		$session->write('Client.id',$client_id);
		$session->write('Client.name',$client_name);
		$session->write('Client.email',$client_email);
		return $this->redirect(['controller' => 'Client', 'action' => 'influencer']);
		
		}		
		else{
		echo "invalid username password";
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);					
		}
					//die('--eee');
		}
    }
	public function logout()
    {
		$session = $this->request->session();
		$session->destroy();
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);
		
	}
	public function influencer()
	{
		if(!$this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);			
		}
		
		$this->set('activeMenuButton', 'posts');
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		//echo $client_id; die('-eee');
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
		
		
		$ClientsTable->save($Clients);
		
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
	}
	//  ========================= Unlink Twitter ===========================
	
	public function unlinkTwitter()
	{
		$ClientsTable = TableRegistry::get('Clients');
		$client_id = $this->request->session()->read('Client.id');
		$Clients = $ClientsTable->get($client_id); // Return article with id 12

		$Clients->screen_name = '';
		$Clients->oauth_token = '';
		$Clients->oauth_secret_token = '';
		$Clients->twitter_id = '';
		$ClientsTable->save($Clients);
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
	}
	
	// ================ UPDATE PROFILE DETAIL OF CLIENT ======================
	public function updateProfile()
	{
		//print_r($this->request->data);
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$phone = $this->request->data['phone'];
		$password = $this->request->data['password'];
		$client_id = $this->request->session()->read('Client.id');
		
		$ClientsTable = TableRegistry::get('Clients');
		
		$Clients = $ClientsTable->get($client_id); // Return article with id 12
		
		$Clients->name = $name;
		$Clients->email = $email;
		$Clients->phone = $phone;
		if($password !=''){
		$Clients->password = $password;
		
		}
		$ClientsTable->save($Clients);
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);	
	}
	
	// =============== CHECK EMAIL EXISTS OR NOT OF CLIENT ==============
	
	public function checkEmail()
	{
		$client_id = $this->request->session()->read('Client.id');
		$email = $this->request->query('email');
		
		$ClientsTable = TableRegistry::get('Clients');
		$results = 	$ClientsTable->find()
								->where(['email' => $email, 'id !='=>'5'])
								//->where(['id NOT IN' => '5'])
								->toArray(); // Also a collections library method
							//	print_r($results);
		if(count($results) > 0){
		echo "false";
		}
		else{
		echo "true";
		}
		die;
	
	}
	
	// =============== CHECK EMAIL EXISTS OR NOT FOR INVITES UNDER CLIENT ==============
	
	
	public function checkInviteEmailExists()
	{
	
		$email = $this->request->query['email_influencer']; 
		$client_id = $this->request->session()->read('Client.id');
		$InvitesTable = TableRegistry::get('Invites');
		$results = 	$InvitesTable->find()
								->where(['email' => $email, 'client_id'=>$client_id])
								->hydrate(false)
								//->where(['id NOT IN' => '5'])
								->toArray(); // Also a collections library method	
		//print_r($results); die;
		if(count($results) > 0){
		echo "false";
		}
		else{
		echo "true";
		}
		die;
	}
	
	public function addInvite()
	{
		//print_r($this->request);
		$email = $this->request->data['email_influencer'];
		$client_id = $this->request->data['client_id'];
		$InvitesTable = TableRegistry::get('Invites');
		
		$Invites = $InvitesTable->newEntity();
		$Invites->email = $email;
		$Invites->client_id = $client_id;
		
		if($InvitesTable->save($Invites)){
		echo "success";
		}
		else{
		echo "failed";
		}
		die;
		
	}
	
}
