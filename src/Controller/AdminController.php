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
   
      //$this->viewBuilder()->layout('admin');
		//get corporate users
		   if(!$this->session->check('Admin.id')){
		return $this->redirect(['action' => 'login']);			
		}
		    $UsersTable = TableRegistry::get('Users');	
            $ClientsTable = TableRegistry::get('Clients');				
			$Userslisting = 	$UsersTable->find('all')
                                ->where(['status' => 1])					
								->hydrate(false)						
								->toArray();
								
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
	
	
}

?>