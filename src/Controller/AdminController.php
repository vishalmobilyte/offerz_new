<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;
use Cake\Datasource\ConnectionManager;

class AdminController  extends Controller {
	
	
	public $helpers = ['Form','Flash'];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Twitter');
		$this->session = $this->request->session();
		
		$this->viewBuilder()->layout('admin');
		
		
		
    }
	
	public function exportUsers() 
	{
		$this->viewBuilder()->layout('');
		$this->response->type(['csv' => 'text/csv']);
		$this->response->type('csv');
		$this->response->charset('UTF-8');
		//$this->response->download('exportusers.csv');
		$usersModel = TableRegistry::get('Clients');
		$data = $usersModel->find('all')->select(['name','email','twt_followers'])->where(['role' => 1, 'status' => 1])	->hydrate(false)->toArray();
		pr($data);die;	
		$this->set('data', $data);
        $this->set('_serialize', ['data']);
       
	}
	public function exportInfluencers() 
	{
		$this->viewBuilder()->layout('');
		$this->response->type('csv');
		$this->response->charset('UTF-8');
		//$this->response->download('exportinfluencers.csv');
		$usersModel = TableRegistry::get('Users');
		$data = $usersModel->find('all')->select(['name','email','twt_followers'])->where(['status' => 1])	->hydrate(false)->toArray();
		//pr($data);die;
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
		
		//return $this->redirect(['controller' => 'Client', 'action' => 'influencer']);
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
	
	// ============== ANALYTICS =======================
	
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
								return $q->where(['is_accepted' => '1','is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
		
			$this->set('invites_data_followers',$Clientlisting);
		//$InvitesTable = TableRegistry::get('Invites');
		
			// GEt Invites listing
		
		/* $UserOffersTable = TableRegistry::get('UserOffers');
		$results_invites = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->where(
							['is_deleted'=>0, 'Invites.is_accepted' => '1'])
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
							//pr($results_invites);die;
					foreach($results_invites as $inv_data){
					$calc_perc_share = 0;
					$ttl_received = $inv_data['os']['total_offer_received'];
					$ttl_shared = $inv_data['os']['offer_accepted'];
					if($ttl_received){
					$calc_perc_share = round(($ttl_shared/$ttl_received)*100);
					
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
			$this->set('invites_data',$results_invites);
			$this->set('invites_data_followers',$followers_data);
			$this->set('share_perc_data',$share_perc_data);
		
			 */
		
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
								/* ->contain(['Invites'=> function ($q) {
									
								return $q
								 ->select(['count' => $q->func()->count('*')])
								 ->where(['is_accepted' => '1','is_deleted'=>0,'client_id'=>'Clients.id']);}]) *//*->contain(['Invites'=> function ($q) {
												return $q->select(['id','client_id','settings_count' => 'COUNT(Invites.id)',                               
    ])->where(['is_accepted' => '1','is_deleted'=>0]);
									}])*/
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
		
			$this->set('invites_data_followers',$Clientlisting);
			
		
		
	}
	public function getConnectionsInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('admin');
		//pr('hello');die;
			$ClientsTable = TableRegistry::get('Clients');	
			$UsersTable = TableRegistry::get('Users');	
			$InvitesTable = TableRegistry::get('Invites');

			/* $Clientlisting = 	$ClientsTable->find()
								->contain(['Invites'=> function ($q) 
								{
								return 
								$q ->find('all')
								//->select([
								//'u.twt_followers','u.fb_friends'
								//'total_conn' => $q->func()->sum('u.twt_followers'),
								//'total_count_fb' => $q->func()->sum('u.fb_friends')
								//])
								->where(['is_deleted'=>0,'is_accepted'=>1])
								->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email'
								]);
							/* $q->select([
								'total_conn' => $q->func()->sum('u.twt_followers'),
								'total_count_fb' => $q->func()->sum('u.fb_friends')
							])
							
							->hydrate(false) 
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email'
								])
							->toArray();*/
								// ->hydrate(false)						
								// ->toArray() 
								//->where(['is_accepted' => '1','is_deleted'=>0]);
								/*}								
								])
								->where(['role' => 1, 'status' => 1])	
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)
								->hydrate(false)						
								->toArray();*/
				 $Clientlisting = $ClientsTable
								->find('all')
								//->SELECT(['I.email,I.client_id'])
								->join([
								'table' => 'Invites',
								'alias' => 'I',
								'type' => 'LEFT',
								'conditions' => 'I.client_id = Clients.id and is_accepted = 1 and is_deleted=0'
								])
								->where(['role' => 1, 'status' => 1])	
								//->limit(5)								
								->hydrate(false)						
								->toArray();
									pr($Clientlisting);die;
							/* ->contain(['Invites'=> function ($q) {
								return 
								$q
								->where(['is_accepted' => '1','is_deleted'=>0])
								->select(['Invites.id'])
								;
								}]
										)
								->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								]);
								->order(['Clients.twt_followers'=> 'DESC'])
								->limit(5)								
								->hydrate(false)						
								->toArray(); */
									//pr($Clientlisting);
								
		 $count_qry = 	$InvitesTable->find('all',['conditions'=>['is_accepted' => '1', 'client_id'=>$client_id,'is_deleted'=>0]])->count();
				/* ->select(['count'=>$count_qry->func()->count('id')])
							->where(['is_accepted' => 0])
							->orWhere(['is_accepted' => 1])->hydrate(false)->toArray(); */
			//pr($count_qry);die;
			$this->set('count_influencers',$count_qry); //die;
			
			$query = 	$InvitesTable->find('all');
							$query->select([
								'total_conn' => $query->func()->sum('u.twt_followers'),
								'total_count_fb' => $query->func()->sum('u.fb_friends')
							])
							->where(['client_id' => $client_id,'is_deleted'=>0,'is_accepted'=>'1'])
							->hydrate(false)
							->join([
								'table' => 'users',
								'alias' => 'u',
								'type' => 'LEFT',
								'conditions' => 'u.email = Invites.email',
								])
							->toArray();
							
							// Also a collections library method
			$total_conn_result = $query->hydrate(false)->toArray();
			//pr($total_conn_result);die;
			$total_connections = array_sum(array($total_conn_result[0]['total_conn'],$total_conn_result[0]['total_count_fb']));
			$this->set('total_connections',$total_connections);
			
		
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
			$this->set('invites_data_followers',$Clientlisting);
			
			
		
		
	}
	public function getMostSharePer()
	{
		$this->viewBuilder()->layout('');
		//pr('hello');die;
		$ClientsTable = TableRegistry::get('Clients');	
        $UsersTable = TableRegistry::get('Users');			
		$Clientlisting = 	$ClientsTable->find('all')
								->contain(['Invites'=> function ($q) {
								return $q->where(['is_accepted' => 1,'is_deleted'=>0]);}])
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
														
								->hydrate(false)						
								->toArray()
								;
								$total_offer_accepted=0;
								$total_offer_received=0;
								$most_share_per=0;
								foreach($Clientlisting as $value)
								{
									$value['most_share_per']=$most_share_per; 
									//pr($value);
									
									foreach($value['offers_stat'] as $k)
										{
											
									$total_offer_accepted=$total_offer_accepted+$k['offer_accepted'];
									$total_offer_received=$total_offer_received+$k['total_offer_received'];
									
										}
										$most_share_per=round(($total_offer_accepted/$total_offer_received)*100);
										//pr($most_share_per);
									pr($value);
									$this->set('invites_data_followers',$value);
								}
								$Clientlisting['most_share_per']=10; 
								pr($value);
								pr($total_offer_received);
								$this->set('invites_data_followers',$Clientlisting);
				
	}
	public function getLeastInfluencersInf()
	{
		// Set the layout.
		$this->viewBuilder()->layout('empty');
		
		$ClientsTable = TableRegistry::get('Clients');
		
			$Clientlisting = 	$ClientsTable->find('all')
								/* ->contain(['Invites'=> function ($q) {
									
								return $q
								 ->select(['count' => $q->func()->count('*')])
								 ->where(['is_accepted' => '1','is_deleted'=>0,'client_id'=>'Clients.id']);}]) *//*->contain(['Invites'=> function ($q) {
												return $q->select(['id','client_id','settings_count' => 'COUNT(Invites.id)',                               
    ])->where(['is_accepted' => '1','is_deleted'=>0]);
									}])*/
								->select([
											'id','twt_pic','twt_followers','name','email',
											'screen_name',
											'invite_count' => '(select count(*) from invites as I where I.is_accepted=1 and I.is_deleted=0 and I.client_id = Clients.id)' 
										])	
								->contain(['Offers_stat'])
								->where(['role' => 1, 'status' => 1])	
								
								->order(['invite_count'=> 'ASC'])
								->limit(5)								
								->hydrate(false)						
								->toArray();
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
								->limit(5)	
								->order(['offers_count'=> 'ASC'])								
								->hydrate(false)						
								->toArray();
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
	
	
}

?>