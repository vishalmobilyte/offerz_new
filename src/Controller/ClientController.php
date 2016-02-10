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
use Cake\Datasource\ConnectionManager;
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
	public function login()
    {
		if($this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
		}
		
		
		$session = $this->request->session();
		//echo $session->read('Client.id'); 
		//echo $session->read('Client.email'); 
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
		//return $this->redirect(['controller' => 'Client', 'action' => 'login']);					
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
		// Count total Influncers who has not responded and who have accepted the invites
		$InvitesTable = TableRegistry::get('Invites');
		 $count_qry = 	$InvitesTable->find('all',['conditions'=>['is_accepted' => '1', 'client_id'=>$client_id]])->count();
				/* ->select(['count'=>$count_qry->func()->count('id')])
							->where(['is_accepted' => 0])
							->orWhere(['is_accepted' => 1])->hydrate(false)->toArray(); */
			$this->set('count_influencers',$count_qry); //die;
			
			$query = 	$InvitesTable->find('all');
							$query->select([
								'total_conn' => $query->func()->sum('u.twt_followers')
							])
							->where(['client_id' => $client_id,'is_deleted'=>0])
							->hydrate(false)
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								])
							->toArray(); // Also a collections library method
			$total_conn_result = $query->hydrate(false)->toArray();
			$total_connections = $total_conn_result[0]['total_conn'];
			$this->set('total_connections',$total_connections);
			
		// GEt Invites listing
		
		$UserOffersTable = TableRegistry::get('UserOffers');
		$results = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at'])
							->where(['client_id' => $client_id,'is_deleted'=>0])
							->hydrate(false)
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								])
							->toArray(); // Also a collections library method
							
		
			//	print_r($results); die('-eee');			
		//$conn = ConnectionManager::get('default');
		foreach($results as $data_inv){
		$user_id = $data_inv['u']['id'];
	//	echo $stmt = $conn->query('SELECT UserOffers.id AS `UserOffers__id`, (SUM((CASE WHEN status = 1 THEN 1 END))) AS `accepted`, (SUM((CASE WHEN status = 2 THEN 1 END))) AS `declined`, (SUM((CASE WHEN status = 0 THEN 1 END))) AS `not_responded` FROM user_offers UserOffers WHERE (client_id = '.$client_id.' AND user_id = '.$user_id.')');
	//	$restult = $stmt->execute();
		//$ex_resut = // Read all rows.
	//	print_r($stmt); die;
		//	$restult = $restult->fetchAll('assoc');
	//	echo $user_id;
	/*
		$results_share = 	$UserOffersTable->find('list');
							
				$accepted = $results_share->newExpr()->addCase($results_share->newExpr()->add(['status' => '1']), 1, 'integer');
				
				$declined = $results_share->newExpr()->addCase($results_share->newExpr()->add(['status' => '2']), 1, 'integer');
				
				$not_responded = $results_share->newExpr()->addCase($results_share->newExpr()->add(['status' => '0']), 1, 'integer');
				

				$results_share->select([
				
					'accepted' => $results_share->func()->sum($accepted),
					'declined' => $results_share->func()->sum($declined),
					'not_responded' => $results_share->func()->sum($not_responded)
				])
				
							->where(['client_id' => $client_id,'user_id'=>$user_id])
							//->group('status')
							//->hydrate(false)
							//->extract('accepted','declined') 
							
							//	->combine('id', 'accepted') // combine() is another collection method
							->toArray(); // Also a collections library method
							
		//echo "<hr>";
		*/
		
	//	print_r($data_inv); die;
		}
		//die;
		$this->set('invites_data',$results); 
		
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
	
	public function unlinkTwitter()
	{
		$ClientsTable = TableRegistry::get('Clients');
		$client_id = $this->request->session()->read('Client.id');
		$Clients = $ClientsTable->get($client_id); // Return article with id 12

		$Clients->screen_name = '';
		$Clients->oauth_token = '';
		$Clients->oauth_secret_token = '';
		$Clients->twitter_id = '';
		$Clients->twt_favorites = '';
		$Clients->twt_tweets = '';
		$Clients->twt_retweets = '';
		$Clients->twt_followers = '';
		$Clients->twt_pic = '';
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
								->where(['email' => $email, 'client_id'=>$client_id,'is_deleted'=>0])
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
	
	public function deleteInfluncer()
	{
		//print_r($this->request->data); die;
		$invite_id = $this->request->data['invt_id'];
		if($invite_id !=''){
		$InvitesTable = TableRegistry::get('Invites');
		$Invites = $InvitesTable->get($invite_id);
		$Invites->is_deleted = '1';
		
		
		if($InvitesTable->save($Invites)){
		echo "success";
		}
		}
		
		
		else{
		echo "failed";
		}
		die;
		
	}
	
	public function testing()
	{
	// echo  "teching";
	}
	
}
