<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Datasource\ConnectionManager;

class AdminController  extends Controller 
{
	public $helpers = ['Form','Flash'];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		$this->loadComponent('Pushios');
        $this->loadComponent('Push');
        $this->loadComponent('Twitter');
		$this->loadComponent('Paginator');
		
		$this->session = $this->request->session();
		$this->viewBuilder()->layout('admin');
			
    }
	
	// ======================== EXPORTING SECTION ==========================
	public function exportUsers() 
	{
		$this->viewBuilder()->layout('');
		$this->response->type(['csv' => 'text/csv']);
		$this->response->type('csv');
		$this->response->charset('UTF-8');
		
		$ClientsTable = TableRegistry::get('Clients');	
        $UsersTable = TableRegistry::get('Users');	
		
		$Clientlisting = 	$ClientsTable->find('all')->contain(['Invites'=> function ($q) {
							return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
							->contain(['Offers_stat'])
							->where(['role' => 1, 'status' => 1])							
							->hydrate(false)						
							->toArray();
		
		$i=0;
		foreach($Clientlisting as $displayClient)
		{
			if($displayClient['offers_stat'])
				{
					$mostRecent= 0;
					$total_offer_accepted=0;
					$total_offer_received=0;
						
					foreach ($displayClient['offers_stat'] as $k) 
					{
					$total_offer_accepted+=$k['offer_accepted'];
					$total_offer_received+=$k['total_offer_received'];
					if($k['last_offer_date'])
						{
						
						$curDate = strtotime($k['last_offer_date']);
						  if ($curDate > $mostRecent)
								{
									 $mostRecent = $curDate;
								}
						}
						
						else
						{
							$mostRecent= $mostRecent;
						}
					}
					$total_share_perc=round(($total_offer_accepted/$total_offer_received)*100);
					
				}
				
			else
				{
					$total_share_perc=0;
					$mostRecent= 0;
					
				}
			
			$Clientlisting[$i]['share_perc']=$total_share_perc;
			$Clientlisting[$i]['last_offer_date']=$mostRecent==0?' ':date('d/m/Y', $mostRecent);
			
			$data[$i]['name']=$displayClient['name'];
			$data[$i]['email']=$displayClient['email'];
			$data[$i]['twt_followers']=$displayClient['twt_followers'];
			$data[$i]['share_perc']=$Clientlisting[$i]['share_perc']." %";
			$data[$i]['last_offer_date']=$Clientlisting[$i]['last_offer_date'];
		
		$i++;
		}
		
		$this->set('data', $data);
        $this->set('_serialize', ['data']);
   		
	}
	// =================== Connect to Twitter  ====================
	public function connectTwitter(){
		$connection_url = $this->Twitter->connect('admin');
		$this->redirect($connection_url);
	}
	// ================== Callback Twitter =========================
	public function callbackTwitter(){
		$oauth_access_token = $this->request->query['oauth_token'];
		$oauth_access_oauth_verifier = $this->request->query['oauth_verifier'];
		
		
		$consumer_key = "LEqoRF6gLyLPxIFlGDjze5xd0";
		$consumer_secret = "c0B582T95BFWUUzR2UnOFqWb2RaDQpQ1BH7qPC0aD7w1cf6hVR";
		$access_token = $this->Twitter->callback($consumer_key, $consumer_secret,$oauth_access_token , $oauth_access_oauth_verifier);
		//print_r($access_token['tw_data']); die('--here--');
		
		$screen_name = $access_token['tw_data']->user->screen_name;
		$oauth_token = '';
		$oauth_secret_token = '';
		$twitter_id = $access_token['tw_data']->user->id;
		
		$twt_name = $access_token['tw_data']->user->name; 
		$twt_desc = $access_token['tw_data']->user->description; 
		$tweets_count = $access_token['tw_data']->user->statuses_count; 
		$followers_count = $access_token['tw_data']->user->followers_count; 
		$favourites_count = $access_token['tw_data']->user->favourites_count; 
		$retweet_count = $access_token['tw_data']->retweet_count; 
		$twt_pic = $access_token['tw_data']->user->profile_image_url; 
		
		$client_id = $this->request->session()->read('Admin.id');
		
		$ClientsTable = TableRegistry::get('Clients');
		
		$Clients = $ClientsTable->get($client_id); // Return article with id 12

		$Clients->screen_name = $screen_name;
		$Clients->oauth_token = $oauth_token;
		$Clients->oauth_secret_token = $oauth_secret_token;
		$Clients->twitter_id = $twitter_id;
		
		$Clients->name = $twt_name;
		$Clients->description = $twt_desc;
		$Clients->twt_tweets = $tweets_count;
		$Clients->twt_retweets = $retweet_count;
		$Clients->twt_favorites = $favourites_count;
		$Clients->twt_followers = $followers_count;
		$Clients->twt_pic = $twt_pic;
		
		
		$ClientsTable->save($Clients);
		//echo "saved"; die;
		$this->redirect(['controller' => 'Admin', 'action' => 'influencers']);			
	}
	//  ========================= Unlink Twitter ===========================
	
	public function unlinkTwitter()
	{
		$ClientsTable = TableRegistry::get('Clients');
		$client_id = $this->request->session()->read('Admin.id');
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
		$this->redirect(['controller' => 'Admin', 'action' => 'influencer']);			
	}
	
	
	public function exportInfluencers() 
	{
		$this->viewBuilder()->layout('');
		$this->response->type('csv');
		$this->response->charset('UTF-8');
		
		$usersModel = TableRegistry::get('Users');
		$Userlisting = $usersModel->find('all')
		->contain(['Offers_stat'])
		->where(['status' => 1])	
		->hydrate(false)
		->toArray();
		
		$i=0;
		foreach($Userlisting as $displayClient)
		{
			if($displayClient['offers_stat'])
				{
					$mostRecent= 0;
					$total_offer_accepted=0;
					$total_offer_received=0;
						
					foreach ($displayClient['offers_stat'] as $k) 
					{
					$total_offer_accepted+=$k['offer_accepted'];
					$total_offer_received+=$k['total_offer_received'];
					if($k['last_offer_date'])
						{
							
						$curDate = strtotime($k['last_offer_date']);
						  if ($curDate > $mostRecent)
								{
									 $mostRecent = $curDate;
								}
						}
						
						else
						{
							$mostRecent= $mostRecent;
						}
					}
					$total_share_perc=round(($total_offer_accepted/$total_offer_received)*100);
					
				}
				
			else
				{
					$total_share_perc=0;
					$mostRecent= 0;
					
				}
			
			$Userlisting[$i]['share_perc']=$total_share_perc;
			$Userlisting[$i]['last_offer_date']=$mostRecent==0?' ':date('d/m/Y', $mostRecent);
			
			$data[$i]['name']=$displayClient['name'];
			$data[$i]['email']=$displayClient['email'];
			$data[$i]['twt_followers']=$displayClient['twt_followers'];
			$data[$i]['share_perc']=$Userlisting[$i]['share_perc']." %";
			$data[$i]['last_offer_date']=$Userlisting[$i]['last_offer_date'];
		
		$i++;
		}
		
		$this->set('data', $data);
        $this->set('_serialize', ['data']);
       
	}
	public function beforeRender(Event $event)
    {
		if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
		
		$admin_id = $this->request->session()->read('Admin.id');
		//$client_id = '5';
		if($admin_id){
		$Clients = TableRegistry::get('Clients');
		$article = $Clients->get($admin_id);
		$this->set('admin_data',$article);
		}
		else{
		$this->set('admin_data','');
		
		}
	}
	
	
	public function viewuser($id=null)
    {
		
		$session = $this->request->session();
		$id=$this->request->pass[0];
		$Clients = TableRegistry::get('Clients');
		// An advanced example
		$results = 	$Clients->find()
							->where(['id' => $id])
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
		
			
		
    }
	
	//get client listing
	public function users()
	{
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		if(!$this->session->check('Admin.id')){
		return $this->redirect(['action' => 'login']);			
		}
		//$this->viewBuilder()->layout('admin');
		
		//get influencers
			$ClientsTable = TableRegistry::get('Clients');	
            $UsersTable = TableRegistry::get('Users');			
			$Clientlisting = 	$ClientsTable->find('all')->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => '1','is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])							
								->hydrate(false)						
								->toArray();
			//print_r($Clientlisting); die('---');
			/* foreach ($Clientlisting as $client)
			{
					
			$InvitesTable = TableRegistry::get('Invites');
			$count_qry = 	$InvitesTable->find('all',['conditions'=>['is_accepted' => '1', 'client_id'=>$client['id'],'is_deleted'=>0]])->count();
			
			$client['influencer_count']=$count_qry;
					
			}	*/	
			$Clientcount = 	$ClientsTable->find('all')->where(['role' => 1, 'status' => 1])	
			                    ->count();
								//pr($Clientcount);die;	
			$Userscount = 	$UsersTable->find('all')->where(['status' => 1])	
                            ->count();
							//pr($Userscount);die;	
				 			
			
			//print_r($Clientlisting); die('-eee');			
		
			$this->set('Clientlisting', $Clientlisting);
			$this->set('Clientcount', $Clientcount);
			$this->set('Userscount', $Userscount);
	}

   public function influencers(){	
   //$UserOffersTable = TableRegistry::get('UserOffers');
   //$UserOffersTable = TableRegistry::get('offers_stat');
   				
      //$this->viewBuilder()->layout('admin');
		//get corporate users
		   if(!$this->session->check('Admin.id')){
		return $this->redirect(['action' => 'login']);			
		}
		    $UsersTable = TableRegistry::get('Users');	
            $ClientsTable = TableRegistry::get('Clients');
			$InvitesTable = TableRegistry::get('Invites');			
			$Userslisting = 	$UsersTable->find('all')
								->contain(['Offers_stat'])
                                ->where(['status' => 1])					
								->hydrate(false)						
								->toArray();
			//print_r($Userslisting); die('-eee');

			//$followers_total = array($Userslisting[1]['offers_stat']);
			//print_r($followers_total); die('-eee');
			$Clientcount = 	$ClientsTable->find('all')->where(['role' => 1, 'status' => 1])	
			                    ->count();
								//pr($Clientcount);die;	
			$Userscount = 	$UsersTable->find('all')->where(['status' => 1])	
                            ->count();						
			$i=0;
			foreach($Userslisting as $displayUsers)
			{
				//echo $displayUsers['email'];die;
				$Sponsors = 	$InvitesTable->find('all')
				->contain(['Clients'])
				->where(['Invites.email' => $displayUsers['email'],'is_deleted'=>0,'Invites.is_accepted' => 1])
							->hydrate(false)
							->toArray();
							//print_r($Sponsors); 
				$Userslisting[$i]['Sponsors']=$Sponsors;
				$i++;				
			}
			//print_r($Userslisting); die('-eee');
			//print_r($Userslisting); die('-eee');			
		
			$this->set('Userslisting', $Userslisting);
			$this->set('Userscount', $Userscount);
	        $this->set('Clientcount', $Clientcount);
	
    }
	
	public function deleteUsers() {
		
		
		$user_id = $this->request->data['u_id'];
		if($user_id !=''){
			$ClientsTable = TableRegistry::get('Clients');
			$Clients = $ClientsTable->get($user_id);
			$Clients->status = '0';
		
		
				if($ClientsTable->save($Clients)){
				echo "success";
				}
		}
		
		
		else{
		echo "failed";
		}
		die;
	}
	
	public function deleteInfluencers() {
		
		
		$user_id = $this->request->data['u_id'];
		if($user_id !=''){
			$UsersTable = TableRegistry::get('Users');
			$Users = $UsersTable->get($user_id);
			$Users->status = '0';
		
		
				if($UsersTable->save($Users)){
				echo "success";
				}
		}
		
		
		else{
		echo "failed";
		}
		die;
	}
	
	public function index()
	{
	if(!$this->session->check('Admin.id')){
		return $this->redirect(['action' => 'login']);			
		}
		else{
		return $this->redirect(['action' => 'influencers']);			
		
		}
		
	}
	public function login()
    {
		if($this->session->check('Admin.id')){
		return $this->redirect(['action' => 'influencers']);			
		}
		
		
		$session = $this->request->session();
		
		if(isset($this->request->data['username']) && !empty($this->request->data['username']))

		{
		$params = $this->request->data;
		$email = trim($this->request->data['username']);
		$password = trim($this->request->data['password']);
		$Clients = TableRegistry::get('Clients');
		// An advanced example
		$results = 	$Clients->find()
							->where(['email' => $email,'password'=>$password,'role'=>'2'])
							->toArray(); // Also a collections library method

		if(count($results) > 0){
		$admin_id = $results[0]->id;
		$admin_name = $results[0]->name;
		$admin_email = $results[0]->email;
		$session->write('Admin.id',$admin_id);
		$session->write('Admin.name',$admin_name);
		$session->write('Admin.email',$admin_email);
		return $this->redirect(['action' => 'influencers']);
		
		}		
		else{
		$this->Flash->error('Invalid Email/Password!');
		//return $this->redirect(['controller' => 'Client', 'action' => 'login']);					
		}
					//die('--eee');
		}
    }
	public function logout()
    {
		$session = $this->request->session();
		$session->destroy();
		$this->Flash->success('Logged Out Successfully!');
		return $this->redirect(['action' => 'login']);
		
	}
	
	// ============== ANALYTICS SECTION =======================
	
	public function analytics() {
	
		if(!$this->session->check('Admin.id')){
		return $this->redirect(['controller' => 'Admin', 'action' => 'login']);			
		}
		
		$session = $this->request->session();
		//$admin_id = $session->read('Admin.id');
		$ActivityLog = TableRegistry::get('activity_logs');
		
		$results = 	$ActivityLog->find()
		                        ->contain(['Users'])
		                        ->select(['log_client','created_at','user_id','Users.email','Users.twt_pic'])
								
								->limit(5)
								->order(['activity_logs.created_at' => 'DESC'])
								->hydrate(false)
								->toArray(); // Also a collections library method	
								
			//print_r($results); die;
			$this->set('results',$results);
			
		//left sidebar	
		$ClientsTable = TableRegistry::get('Clients');	
          
			$Clientlisting = 	$ClientsTable->find('all')->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
		
			$this->set('invites_data_followers',$Clientlisting);
		
	}
		
	public function getFollowersInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');	
          
			$Clientlisting = 	$ClientsTable->find('all')->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => '1','is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
		
			$this->set('invites_data_followers',$Clientlisting);
				
	}
	public function getInfluencersInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');
		
			$Clientlisting = 	$ClientsTable->find('all')
								->select([
											'id','twt_pic','twt_followers','name','email',
											'screen_name',
											'invite_count' => '(select count(*) from invites as I where I.is_accepted=1 and I.is_deleted=0 and I.client_id = Clients.id)' 
										])	
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								->order(['invite_count'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
								//pr($Clientlisting);die;
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['invite_count']) 
			{
				unset($Clientlisting[$key]);
			}
		}
			$this->set('invites_data_followers',$Clientlisting);
			
		
		
	}
	public function getConnectionsInf()
	{
		$this->viewBuilder()->layout('');
		$ClientsTable = TableRegistry::get('Clients');	
		$UsersTable = TableRegistry::get('Users');	
		$InvitesTable = TableRegistry::get('Invites');
		
			$Clientlisting = 	$ClientsTable->find('all')->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
		$i=0;
		foreach($Clientlisting as $k)
		{
			if(count($k['invites'])==0)
				{
					$Clientlisting[$i]['total_connections']=0;
				}
				else
				{
					foreach($k['invites'] as $j)
						{
						$id=$j['client_id'];
						$query = $InvitesTable->find('all')
											->select(['u.status','Invites.email','Invites.is_accepted','u.twt_followers','u.email','u.fb_friends'])
											->where(['client_id' => $id,'is_deleted'=>0,'is_accepted'=>1])
											->join([
												'table' => 'users',
												'alias' => 'u',
												'type' => 'LEFT',
												'conditions' => 'u.email = Invites.email',
												])
											->hydrate(false)
											->toArray();
						
									//pr($query);
									$total_conn_result=0;
									foreach($query as $q)
									{
									$total_conn_result=$total_conn_result+$q['u']['twt_followers']+$q['u']['fb_friends'];
										
									}
						}
					$Clientlisting[$i]['total_connections']=$total_conn_result;
				}
		$i++;
		}
		usort($Clientlisting, function($a, $b) { 
		return $b['total_connections']-$a['total_connections'] ;
		});
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['total_connections']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
		//pr($Clientlisting);die;
		
		$this->set('invites_data_followers',$Clientlisting);
			
		
		
	}
	public function getOffersInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');	
          
			$Clientlisting = 	$ClientsTable->find('all')->select([
											'id','twt_pic','twt_followers','name','email',
											'screen_name',
											'offers_count' => '(select count(*) from offers as I where I.client_id = Clients.id)' 
										])	
								//->contain(['Offers'])
								->where(['role' => 1, 'status' => 1])	
								->limit(5)	
								->order(['offers_count'=> 'DESC'])								
								->hydrate(false)						
								->toArray();
		//pr($Clientlisting);die;
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['offers_count']) 
			{
				unset($Clientlisting[$key]);
			}
		}
			$this->set('invites_data_followers',$Clientlisting);
			
			
		
		
	}
	public function getMostImpressionsInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');	
          
			$Clientlisting = 	$ClientsTable->find('all')
									// ->select([
											// 'id','twt_pic','twt_followers','name','email',
											// 'screen_name',
											// 'offers_count' => '(select count(*) from offers as I where I.client_id = Clients.id)' 
										// ])
								->contain(['Offers'=> function ($q) {
								return $q
								->contain((['UserOffers'=> function ($p) {
								return $p
								->contain('Users')
								->where(['UserOffers.status'=>1]);}]))
								->where(['is_deleted'=>0]);}])										
								//->contain(['Offers'])
								->where(['role' => 1, 'status' => 1])	
								->limit(5)	
								//->order(['offers_count'=> 'DESC'])								
								->hydrate(false)						
								->toArray();
			$i=0;
			foreach($Clientlisting as $k=>$value)
			{
				//pr($value);
				$total=0;
				$total_impressions=0;
			foreach($value['offers'] as $j)
			{
				$total=0;
				$total_impressions=$total_impressions;
				//pr($j);
			foreach($j['user_offers'] as $l)
			{
				//pr($l);
				$total_impressions+=$l['user']['twt_followers'];
			}
			//echo $total_impressions;
			
			//echo $total;
			}
			$total=$total+$total_impressions;
			$Clientlisting[$i]['total_impressions']=$total;
			$i++;
			}
			//pr($Clientlisting);die;
		usort($Clientlisting, function($a, $b) { 
		return $b['total_impressions']-$a['total_impressions'] ;
		});
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['total_impressions']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
			$this->set('invites_data_followers',$Clientlisting);
			
			
		
		
	}
	
	public function getMostSharePer()
	{
		$this->viewBuilder()->layout('');
		$ClientsTable = TableRegistry::get('Clients');	
        $UsersTable = TableRegistry::get('Users');			
		$Clientlisting = 	$ClientsTable->find('all')
								->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])		
								->hydrate(false)						
								->toArray();
		$i=0;
			foreach($Clientlisting as $value)
			{
				//echo count($value['offers_stat']);die;
				if(count($value['offers_stat'])==0)
				{
					$Clientlisting[$i]['most_share_per']=0;
				}
				else
				{
				$total_offer_accepted=0;
				$total_offer_received=0;
					foreach($value['offers_stat'] as $k)
					{
					$total_offer_accepted=$total_offer_accepted+$k['offer_accepted'];
					$total_offer_received=$total_offer_received+$k['total_offer_received'];
					$most_share_per=round(($total_offer_accepted/$total_offer_received)*100);
					}
				$Clientlisting[$i]['most_share_per']=$most_share_per;
				}
				
				$i++;
				
			}
		usort($Clientlisting, function($a, $b) { 
		return $b['most_share_per']-$a['most_share_per'] ;
		});
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['most_share_per']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);

		$this->set('invites_data_followers',$Clientlisting);
				
	}
	public function getLeastInfluencersInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');
		
			$Clientlisting = 	$ClientsTable->find('all')
								
								->select([
											'id','twt_pic','twt_followers','name','email',
											'screen_name',
											'invite_count' => '(select count(*) from invites as I where I.is_accepted=1 and I.is_deleted=0 and I.client_id = Clients.id)' 
										])	
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								
								->order(['invite_count'=> 'ASC'])
								//->limit(5)								
								->hydrate(false)						
								->toArray();
								//pr($Clientlisting);die;
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['invite_count']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
			$this->set('invites_data_followers',$Clientlisting);
			
		
		
	}
	public function getLeastConnectionsInf()
	{
		$this->viewBuilder()->layout('');
		$ClientsTable = TableRegistry::get('Clients');	
		$UsersTable = TableRegistry::get('Users');	
		$InvitesTable = TableRegistry::get('Invites');
		
			$Clientlisting = 	$ClientsTable->find('all')->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
		$i=0;
		foreach($Clientlisting as $k)
		{
			if(count($k['invites'])==0)
				{
					$Clientlisting[$i]['total_connections']=0;
				}
				else
				{
					foreach($k['invites'] as $j)
						{
						$id=$j['client_id'];
						$query = $InvitesTable->find('all')
											->select(['u.status','Invites.email','Invites.is_accepted','u.twt_followers','u.email','u.fb_friends'])
											->where(['client_id' => $id,'is_deleted'=>0,'is_accepted'=>1])
											->join([
												'table' => 'users',
												'alias' => 'u',
												'type' => 'LEFT',
												'conditions' => 'u.email = Invites.email',
												])
											->hydrate(false)
											->toArray();
						
									//pr($query);
									$total_conn_result=0;
									foreach($query as $q)
									{
									$total_conn_result=$total_conn_result+$q['u']['twt_followers']+$q['u']['fb_friends'];
										
									}
						}
					$Clientlisting[$i]['total_connections']=$total_conn_result;
				}
		$i++;
		}
		usort($Clientlisting, function($a, $b) { 
		return $a['total_connections']-$b['total_connections'] ;
		});
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['total_connections']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
		//pr($Clientlisting);die;
		
		$this->set('invites_data_followers',$Clientlisting);
			
		
		
	}
	
	public function getLeastOffersInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		//	pr('hello');die;
		$ClientsTable = TableRegistry::get('Clients');	
          
			$Clientlisting = 	$ClientsTable->find('all')->select([
											'id','twt_pic','twt_followers','name','email',
											'screen_name',
											'offers_count' => '(select count(*) from offers as I where I.client_id = Clients.id)' 
										])	
								//->contain(['Offers'])
								->where(['role' => 1, 'status' => 1])	
								//->limit(5)	
								->order(['offers_count'=> 'ASC'])								
								->hydrate(false)						
								->toArray();
								foreach ($Clientlisting as $key => $value)
		{
			if (!$value['offers_count']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
		//pr($Clientlisting);die;
			$this->set('invites_data_followers',$Clientlisting);
			
			
		
		
	}
	public function getLeastImpressionsInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');	
          
			$Clientlisting = 	$ClientsTable->find('all')
									
								->contain(['Offers'=> function ($q) {
								return $q
								->contain((['UserOffers'=> function ($p) {
								return $p
								->contain('Users')
								->where(['UserOffers.status'=>1]);}]))
								->where(['is_deleted'=>0]);}])										
								//->contain(['Offers'])
								->where(['role' => 1, 'status' => 1])	
								->limit(5)	
								//->order(['offers_count'=> 'DESC'])								
								->hydrate(false)						
								->toArray();
			$i=0;
			foreach($Clientlisting as $k=>$value)
			{
				//pr($value);
				$total=0;
				$total_impressions=0;
			foreach($value['offers'] as $j)
			{
				$total=0;
				$total_impressions=$total_impressions;
				//pr($j);
			foreach($j['user_offers'] as $l)
			{
				//pr($l);
				$total_impressions+=$l['user']['twt_followers'];
			}
			//echo $total_impressions;
			
			//echo $total;
			}
			$total=$total+$total_impressions;
			$Clientlisting[$i]['total_impressions']=$total;
			$i++;
			}
			//pr($Clientlisting);die;
		usort($Clientlisting, function($a, $b) { 
		return $a['total_impressions']-$b['total_impressions']
		;
		});
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['total_impressions']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
			$this->set('invites_data_followers',$Clientlisting);
			
			
		
		
	}
	public function getLeastSharePer()
	{
		$this->viewBuilder()->layout('');
		$ClientsTable = TableRegistry::get('Clients');	
        $UsersTable = TableRegistry::get('Users');			
		$Clientlisting = 	$ClientsTable->find('all')
								->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])		
								->hydrate(false)						
								->toArray();
								
		$i=0;
			foreach($Clientlisting as $value)
			{
				//echo count($value['offers_stat']);die;
				if(count($value['offers_stat'])==0)
				{
					$Clientlisting[$i]['most_share_per']=0;
				}
				else
				{
				$total_offer_accepted=0;
				$total_offer_received=0;
					foreach($value['offers_stat'] as $k)
					{
					$total_offer_accepted=$total_offer_accepted+$k['offer_accepted'];
					$total_offer_received=$total_offer_received+$k['total_offer_received'];
					$most_share_per=round(($total_offer_accepted/$total_offer_received)*100);
					}
				$Clientlisting[$i]['most_share_per']=$most_share_per;
				}
				
				$i++;
				
			}
			
		usort($Clientlisting, function($a, $b) { 
		return $a['most_share_per']-$b['most_share_per'];
		});
		foreach ($Clientlisting as $key => $value)
		{
			if (!$value['most_share_per']) 
			{
				unset($Clientlisting[$key]);
			}
		}
		$Clientlisting=array_slice($Clientlisting, 0, 5);
//pr($Clientlisting);die;
		$this->set('invites_data_followers',$Clientlisting);
				
	}
	
	// =============== MOST POPULART FOLLOWERS OF INFLUENCERS ===============
	
	public function getSharePercInf(){
		// Set the layout.
		$this->viewBuilder()->layout('admin');
		//$this->autoRender = false;
		//left sidebar	
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		
		$InvitesTable = TableRegistry::get('Invites');
		
			// GEt Invites listing
		
		$UserOffersTable = TableRegistry::get('UserOffers');
		$results_invites = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->where(['is_deleted'=>0,'Invites.is_accepted' => 1])
							->hydrate(false)
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								])
							->join([
								'table' => 'offers_stat',
								'alias' => 'os',
								'type' => 'LEFT',
								'conditions' => 'u.id = os.user_id',
								])
								->limit(5)
							->toArray(); // Also a collections library method
							$j =0;
							pr($results_invites);
	}
	
	// =============== MOST DECLINED OFFER BY INFLUENCERS ===============
	
	public function getMostDelinedOffers(){
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		//$this->autoRender = false;
		//left sidebar	
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		
		$InvitesTable = TableRegistry::get('Invites');
		
			// GEt Invites listing
		
		$UserOffersTable = TableRegistry::get('UserOffers');
		$results_invites = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at','os.offer_accepted','os.offer_declined','os.total_offer_received','os.last_offer_date'])
							->where(['Invites.client_id' => $client_id,'is_deleted'=>0,'Invites.is_accepted' => 1])
							->hydrate(false)
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								])
							->join([
								'table' => 'offers_stat',
								'alias' => 'os',
								'type' => 'LEFT',
								'conditions' => 'u.id = os.user_id',
								])
								->limit(5)
							->toArray(); // Also a collections library method
							$j =0;
					foreach($results_invites as $inv_data){
					$calc_perc_share = 0;
					$ttl_received = $inv_data['os']['total_offer_received'];
					$ttl_shared = $inv_data['os']['offer_declined'];
					if($ttl_received){
					$calc_perc_share = $ttl_shared;
					
					}
					$results_invites[$j]['calc_perc_share'] = $calc_perc_share;
					$j++;
					}	
					usort($results_invites, function($b, $a) {
						return $a['u']['twt_followers'] - $b['u']['twt_followers'];
					});
				$followers_data= $results_invites;
				
				usort($results_invites, function($b, $a) {
						return $a['calc_perc_share'] - $b['calc_perc_share'];
					});
				$share_perc_data = $results_invites;
				//pr($share_perc_data); die('--');
		
			$this->set('share_perc_data',$share_perc_data);
			
		
		
	}
	// ===================Show all offers============================
	
	
	 public function offers()
	{
		if(!$this->session->check('Admin.id')){
			return $this->redirect(['action' => 'login']);			
		}
			// $session = $this->request->session();
			// $client_id = $session->read('Client.id');
			
			$OffersTable 		= TableRegistry::get('Offers');
			$InvitesTable 		= TableRegistry::get('Invites');
			$UserOffersTable 	= TableRegistry::get('UserOffers');
			$OffersStatTable 	= TableRegistry::get('OffersStat');
		
			
		/*if($this->request->data){
	
			
			$Offers = $OffersTable->newEntity();
			$Offers->title = $this->request->data['offer_title'];
			$Offers->editable_text = $this->request->data['editable_text'];
			$Offers->not_editable_text = $this->request->data['not_editable_text'];
			$Offers->client_id = @$client_id;
			if(isset($this->request->data['image_name'])){
			$Offers->image_name = @$this->request->data['image_name'];
			}
			$Offers->start_date = $this->request->data['start_date'];
		if( $this->request->data['start_date'] == 'later'){
			$Offers->date_send_on = $this->request->data['date_send_on'];
		}

		if($OffersTable->save($Offers)){ // If Saved Offer Successfully
			$offer_id = $Offers->id;

			$results = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id'])
							->where(['client_id' => $client_id,'is_deleted'=>0, 'is_accepted'=>1 ])
							->hydrate(false)
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								])
							->toArray(); // Also a collections library method
							
				//print_r($results); die;
		foreach($results as $users){ 
		
			// Save Record in Db to Show Offer to each user on app under this Client
			
			$user_id = $users['u']['id'];
			$UserOffers = $UserOffersTable->newEntity();
			$UserOffers->user_id = $user_id;
			$UserOffers->client_id = $client_id;
			$UserOffers->offer_id = $offer_id;
			
			$UserOffersTable->save($UserOffers);

			$check_stat_qry = 	$OffersStatTable->find()
								->where(['user_id' => $user_id, 'client_id'=>$client_id])
								->hydrate(false)
								//->where(['id NOT IN' => '5'])
								->toArray(); // Also a collections library method	

		if(count($check_stat_qry) < 1){
		// User Does not have any entry yet for User stat
			$OffersStat = $OffersStatTable->newEntity();
			$OffersStat->user_id = $user_id;
			$OffersStat->client_id = $client_id;
			$OffersStat->offer_accepted = '0';
			$OffersStat->offer_declined = '0';
			$OffersStat->total_offer_received = 1;
			$OffersStatTable->save($OffersStat);
		}
		else{
		// User  Have an entry for User stat of offer So we will just increment the offer received

			$column_inc = 'total_offer_received = total_offer_received + 1';
			$date = date('d-m-Y');
			$query = $OffersStatTable->query();
			$query->update()
			->set([$column_inc])
			->where(['user_id' => $user_id, 'client_id' => $client_id])
			->execute();
			}
		}
			$this->Flash->success('Offer Saved Successfully!');
	}
	} $this->paginate = [
        'limit' =>5
    ];
	*/
	
	// ---================  GET ALL OFFERS  =================
	/*$InvitesTable->find('all')->contain(['Clients'])
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
							*/
			/* $OffersTable 		= TableRegistry::get('Offers');
			$InvitesTable 		= TableRegistry::get('Invites');
			$UserOffersTable 	= TableRegistry::get('UserOffers');
			$OffersStatTable 	= TableRegistry::get('OffersStat'); */
			 $this->paginate = [
        'limit' =>4
    ];
		$get_offers = 	$OffersTable->find('all')
								->contain(['UserOffers'])
								//->select (['shares_count' => '(count(user_offers) where status = 1)' ])
								->contain(['UserOffers.Users'])
								->where(['is_deleted'=>0])
								->order(['created_at' => 'DESC'])
								->hydrate(false);
								
								//'offers_count' => '(select count(*) from offers as I where I.client_id = Clients.id)' 
								//->where(['id NOT IN' => '5'])
							//	->toArray(); // Also a collections library method	
		
		
		$result_offers = $this->paginate($get_offers)->toArray();
		
		$j=0;
		
		foreach($result_offers as $data_offr){
			//echo count($data_offr['user_offers']);die;
		if(count($data_offr['user_offers']) > 0){
		
	 	$count_off_user = count($data_offr['user_offers']);
		$shared_user_count =0;
		
		$k=0;
		$count_followers =0;
		foreach($data_offr['user_offers'] as $offer_user){
		if($offer_user['status']=='1'){
			$shared_user_count+=1;
		$count_followers = $count_followers + $offer_user['user']['twt_followers'];
		$k++;
		}
		//echo $shared_user_count;die;
		}
		//echo $k; die('==');
		
		$avg_comp = ($k/$count_off_user)*100;
		$result_offers[$j]['comp_perc'] = $avg_comp;
		$result_offers[$j]['followers_count'] = $count_followers;
		$result_offers[$j]['shared_user'] = $shared_user_count;
		$result_offers[$j]['not'] = count($data_offr['user_offers'])-$shared_user_count;
		//print_r($offer_user); die('--');
		$j++;
		}
		else{
		$result_offers[$j]['comp_perc'] = 0;
		}
		}
		// pr($result_offers);die;
		$this->set('all_offer_data',$result_offers);
		//print_r($result_offers); die('-e-e-');
		//print_r($this->paginate($get_offers)->toArray()); die;				
	
	}
	public function editOffer(){
	
	// print_r($this->request->data);
	$offer_id = $this->request->data['offer_id'];
	$OffersTable = TableRegistry::get('Offers');
		$Offers = $OffersTable->get($offer_id); // Return Offer by id
		$Offers->title = $this->request->data['offer_title'];
		$Offers->editable_text = $this->request->data['editable_text'];
		$Offers->not_editable_text = $this->request->data['not_editable_text'];
		if(isset($this->request->data['image_name'])){
		$Offers->image_name = @$this->request->data['image_name'];
		}	
		if($OffersTable->save($Offers)){
		echo "success";
		}
		else{
		echo "failed";
		}
		die;
	
	}
	
	public function pauseOffer(){
	// print_r($this->request->data);
		$offer_id = $this->request->data['offer_id'];
		$OffersTable = TableRegistry::get('Offers');
		$Offers = $OffersTable->get($offer_id); // Return Offer by id
		$Offers->is_paused = $this->request->data['is_paused'];
		
		if($OffersTable->save($Offers)){
		echo "success";
		}
		else{
		echo "failed";
		}
		die;
	}
	
	public function deleteOffer(){
	// print_r($this->request->data);
		$offer_id = $this->request->data['offer_id'];
		$OffersTable = TableRegistry::get('Offers');
		$Offers = $OffersTable->get($offer_id); // Return Offer by id
		$Offers->is_deleted = 1;
		
		if($OffersTable->save($Offers)){
		echo "success";
		}
		else{
		echo "failed";
		}
		die;
	}
	
	
	// ============ export clients offers information ============
	public function exportClientsOffersInformation()
	{
		$this->viewBuilder()->layout('empty');
		$this->response->type(['csv' => 'text/csv']);
		$this->response->type('csv');
		$this->response->charset('UTF-8');
			
		$usersModel = TableRegistry::get('Users');
		$ClientsModel = TableRegistry::get('Clients');
		$InvitesTable = TableRegistry::get('Invites');
		$OffersStatModel = TableRegistry::get('Offers_stat');
		$OffersTable=TableRegistry::get('Offers');
		$UserOffersTable = TableRegistry::get('UserOffers');
		
		$result_offers = 	$OffersTable->find('all')->contain(['UserOffers'])->contain(['UserOffers.Users'])
								->where(['is_deleted'=>0])
								->order(['created_at' => 'DESC'])
								->hydrate(false)
								->toArray();
								
		$j=0;				
		foreach($result_offers as $data_offr)
		{
		if(count($data_offr['user_offers']) > 0){
		
	 	$count_off_user = count($data_offr['user_offers']);
		$shared_user_count =0;
		
		$k=0;
		$count_followers =0;
		foreach($data_offr['user_offers'] as $offer_user){
			
		if($offer_user['status']=='1'){
		$count_followers = $count_followers + $offer_user['user']['twt_followers'];
		$k++;
		}
		}
		
		$avg_comp = ($k/$count_off_user)*100;
		$result_offers[$j]['comp_perc'] = $avg_comp;
		$result_offers[$j]['followers_count'] = $count_followers;
		
		$j++;
		}
		else{
		$result_offers[$j]['comp_perc'] = 0;
		}
		}
		
		$data=Array(Array());
		$shared_info=Array();
		$not_shared_info=Array();
		$i=0;
		foreach ($result_offers as $user)
		{
			$data[$i]['title']=$user['title'];
			$data[$i]['id']=$user['id'];
			$data[$i]['created_at']=$user['created_at'];
			$data[$i]['total_followers']=$user['followers_count'];
			$data[$i]['complete_percentage']=$user['comp_perc'];
			
			if($user['is_paused']==1)
			{
				$data[$i]['status']='Paused';
			}	
			else
			{
				$data[$i]['status']='Not Paused';
			}
				
			
			$i++;
		}
		$this->set('all_offer_data',$data);
		$this->set('_serialize', ['all_offer_data']);
		$this->set('shared_user_data',$shared_info);
		$this->set('_serialize', ['shared_user_data']);
		$this->set('not_shared_user_data',$not_shared_info);
		$this->set('_serialize', ['not_shared_user_data']);
		   
	}
	
	
	public function exportOffersInformation($id=null)
	{
		$offer_id=$id;
		$this->viewBuilder()->layout('empty');
		$this->response->type(['csv' => 'text/csv']);
		$this->response->type('csv');
		$this->response->charset('UTF-8');
				
		$usersModel = TableRegistry::get('Users');
		$ClientsModel = TableRegistry::get('Clients');
		$InvitesTable = TableRegistry::get('Invites');
		$OffersStatModel = TableRegistry::get('Offers_stat');
		$OffersTable=TableRegistry::get('Offers');
		$UserOffersTable = TableRegistry::get('UserOffers');
		
		$result_offers = 	$OffersTable->find('all')->contain(['UserOffers'])->contain(['UserOffers.Users'])
		
								->where(['is_deleted'=>0,'id' => $offer_id])
								->order(['created_at' => 'DESC'])
								->hydrate(false)
								->toArray();
								
				$j=0;				
		foreach($result_offers as $data_offr)
		{
			
		if(count($data_offr['user_offers']) > 0){
		
	 	$count_off_user = count($data_offr['user_offers']);
		$shared_user_count =0;
		
		$k=0;
		$count_followers =0;
		foreach($data_offr['user_offers'] as $offer_user){
			
		if($offer_user['status']=='1'){
		$count_followers = $count_followers + $offer_user['user']['twt_followers'];
		$k++;
		}
		}
				
		$avg_comp = ($k/$count_off_user)*100;
		$result_offers[$j]['comp_perc'] = $avg_comp;
		$result_offers[$j]['followers_count'] = $count_followers;
		
		$j++;
		}
		else{
		$result_offers[$j]['comp_perc'] = 0;
		}
		}
		
		$data=Array();
		$shared_info=Array();
		$not_shared_info=Array();
		foreach ($result_offers as $user)
		{
			$data['title']=$user['title'];
			$data['id']=$user['id'];
			$data['created_at']=$user['created_at'];
			$data['total_followers']=$user['followers_count'];
			$data['complete_percentage']=$user['comp_perc'];
			if($user['is_paused']==1)
			{
				$data['status']='Paused';
			}	
			else
			{
				$data['status']='Not Paused';
			}
							$i=0;
							foreach($user['user_offers'] as $users_data)
							{
							if($users_data['status']==1){ // User shared offer
							$shared_info[$i]['shared_user_name']=$users_data['user']['name'];
							$shared_info[$i]['shared_user_screen_name']=$users_data['user']['screen_name'];
							$shared_info[$i]['shared_user_email']=$users_data['user']['email'];
							$i++;
							}
							else
							{
								$not_shared_info[$i]['not_shared_user_name']=$users_data['user']['name'];
								$not_shared_info[$i]['not_shared_user_screen_name']=$users_data['user']['screen_name'];
								$not_shared_info[$i]['not_shared_user_email']=$users_data['user']['email'];
								$i++;
							}
							
							
							
							}
							
		}
		
		$this->set('all_offer_data',$data);
		$this->set('_serialize', ['all_offer_data']);
		$this->set('shared_user_data',$shared_info);
		$this->set('_serialize', ['shared_user_data']);
		$this->set('not_shared_user_data',$not_shared_info);
		$this->set('_serialize', ['not_shared_user_data']);
		
	}
	
	
	
function offerNudge(){
	$data = $this->request->data;
	//pr($data);die;
	$offer_id = $data['offer_id'];
	//echo $offer_id ;die;
	if($offer_id){
	
	//$offer_id = 7;
	//print_r($offer_id);die;
	$UserOffersTable = TableRegistry::get('UserOffers');
	$get_data = $UserOffersTable->find('all')->contain(['Users','Offers'])
					->where(['offer_id'=>$offer_id, 'UserOffers.status'=>0])
					->select(['Users.id','Users.email', 'Users.device_token','Offers.title'])
					->hydrate(false)
					->toArray();
			//print_r($get_data); die;	
		foreach($get_data as $data){
			//$token = $data['Users']['device_token'];
			$token = '8f078380670c193b29301800405174210f3d7721e2f6a7003071b721f045906a';
			$offer_title = $data['Offers']['title'];
			if($token != ''){
			$msg = "Hey! You have not shared '$offer_title' Offer yet.";
			// SEND PUSH NOTIFICATION
			$this->Pushios->sendPush($msg, $token);
			}
			
		}	// END FOREACH
		echo "success";
		}
		else{
		echo "failed";
		}
		die;
	}
	
	
	public function updateProfile()
	{
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$phone = $this->request->data['phone'];
		$password = $this->request->data['password'];
		
		$admin_id=$this->request->session()->read('Admin.id');
		
		$ClientsTable = TableRegistry::get('Clients');
		
		$Clients = $ClientsTable->get($admin_id); // Return article with id 12
		
		$Clients->name = $name;
		$Clients->email = $email;
		$Clients->phone = $phone;
		if($password !=''){
		$Clients->password = $password;
		
		}
		$ClientsTable->save($Clients);
		$this->redirect(['controller' => 'Admin', 'action' => 'influencers']);	
	}
	
	// =============== CHECK EMAIL EXISTS OR NOT OF ADMINS ==============
	
public function checkEmail()
	{ 
		$admin_id=$this->request->session()->read('Admin.id');
		$email = $this->request->query('email');
		$ClientsTable = TableRegistry::get('Clients');
		$results = 	$ClientsTable->find('all')
					->where(['email' => $email, 'id !='=>$admin_id,'role '=>'2'])
					->hydrate(false)
					->toArray(); // Also a collections library method
							
		if(count($results) > 0){
		echo "false";
		}
		else{
		echo "true";
		}
		die;
	} 
	
}


?>