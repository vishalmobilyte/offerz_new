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
			$Clientlisting = 	$ClientsTable->find('all')
								->where(['role' => 1, 'status' => 1])							
								->hydrate(false)						
								->toArray();
								
			
			//print_r($Clientlisting); die('-eee');			
		
			$this->set('Clientlisting', $Clientlisting);
	}

   public function influencers(){	
   
      $this->viewBuilder()->layout('admin');
		//get corporate users
		   
		    $UsersTable = TableRegistry::get('Users');		
			$Userslisting = 	$UsersTable->find('all')
                                ->where(['status' => 1])					
								->hydrate(false)						
								->toArray();
								
			
			//print_r($Userslisting); die('-eee');			
		
			$this->set('Userslisting', $Userslisting);
	   
	
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