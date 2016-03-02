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
		
    }
	public function beforeRender(Event $event)
    {
		if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
		
		$this->viewBuilder()->layout('admin');
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
	
	//get client listing
	public function users()
	{
		if(!$this->session->check('Admin.id')){
		return $this->redirect(['action' => 'login']);			
		}
		//$this->viewBuilder()->layout('admin');
		
		//get influencers
			$ClientsTable = TableRegistry::get('Clients');	
            $UsersTable = TableRegistry::get('Users');			
			$Clientlisting = 	$ClientsTable->find('all')
								->where(['role' => 1, 'status' => 1])							
								->hydrate(false)						
								->toArray();
								
			$Clientcount = 	$ClientsTable->find('all')
			                    ->count();
			$Userscount = 	$UsersTable->find('all')
                            ->count();
								
			
			//print_r($Clientlisting); die('-eee');			
		
			$this->set('Clientlisting', $Clientlisting);
			$this->set('Clientcount', $Clientcount);
			$this->set('Userscount', $Userscount);
	}

   public function influencers(){	
   
      //$this->viewBuilder()->layout('admin');
		//get corporate users
		   
		    $UsersTable = TableRegistry::get('Users');	
            $ClientsTable = TableRegistry::get('Clients');				
			$Userslisting = 	$UsersTable->find('all')
                                ->where(['status' => 1])					
								->hydrate(false)						
								->toArray();
								
			$Userscount = 	$UsersTable->find('all')
                            ->count();	
            $Clientcount = 	$ClientsTable->find('all')
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