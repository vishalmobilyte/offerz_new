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
		
		$this->viewBuilder()->layout('client_new');
		
		$ClientsTable = TableRegistry::get('Clients');		
		$Clientlisting = 	$ClientsTable->find('all')
		                    ->where(['role' => 1])							
							->hydrate(false)						
							->toArray();
							
		
		//print_r($Clientlisting); die('-eee');			
	
		$this->set('Clientlisting', $Clientlisting);
	   
	
    }
	
}

?>