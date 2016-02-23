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
	
	//get client listing
	public function users() {
		
		$this->viewBuilder()->layout('admin');
		
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
   
      $this->viewBuilder()->layout('admin');
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
	
	
}

?>