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
	
	
	public function users() {
		
		$this->viewBuilder()->layout('admin');
		
		//get influencers
			$ClientsTable = TableRegistry::get('Clients');		
			$Clientlisting = 	$ClientsTable->find('all')
								->where(['role' => 1])							
								->hydrate(false)						
								->toArray();
								
			
			//print_r($Clientlisting); die('-eee');			
		
			$this->set('Clientlisting', $Clientlisting);
			
		//get corporate users
		   
		    $UsersTable = TableRegistry::get('Users');		
			$Userslisting = 	$UsersTable->find('all')															
								->hydrate(false)						
								->toArray();
								
			
			//print_r($Userslisting); die('-eee');			
		
			$this->set('Userslisting', $Userslisting);
	   
	
    }
	
	public function delete_users() {
		
		//print_r($this->request->data); die;
		$user_id = $this->request->data['u_id'];
		if($user_id !=''){
		$ClientsTable = TableRegistry::get('clients');
		$Clients = $InvitesTable->get($user_id);
		$Clients->is_deleted = '1';
		
		
		if($ClientsTable->save($Clients)){
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