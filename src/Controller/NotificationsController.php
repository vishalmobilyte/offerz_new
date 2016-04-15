<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;

class NotificationsController extends Controller
{
	public $helpers = ['Form','Flash'];
	
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Twitter');
		$this->loadComponent('Pushios');
		$this->session = $this->request->session();
		$session = $this->request->session();
			
    }

    public function beforeRender(Event $event)
    {
		
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }

		if(!$this->session->check('Client.id')){
		// echo 'not logged in';
		}
		
    }
	
	
	public function index()
	{
	$this->viewBuilder()->layout('notifications');
	$session = $this->request->session();
		if(!$this->session->check('Client.id'))
		{
			return $this->redirect(['controller' => 'Client', 'action' => 'login']);	
		}
		else
		{
		$Users = TableRegistry::get('Users');
		$results =  $Users->find('list')
					->select(['name','id'])
					->where(['status'=>1])
					->toArray();
		$this->set('options',$results); 
		
		if($this->request->is('post'))
		{
			//pr($this->request->data);die;
				
			$notifications = $this->request->data['notifications'];
			$sendmessagevia = $this->request->data['Sendmessagevia'];
			$users = $this->request->data['character'];
			$flag=0;
			foreach ($users as $key => $value)
			{
						$fetch =  $Users->find()
						->where(["id" => $value])
						->hydrate(false)
						->select(['name','email','device_token'])
						->toArray();
						
						$user_name = $fetch[0]['name'];
						$user_email = $fetch[0]['email'];
						$deviceToken = $fetch[0]['device_token'];
						//pr($fetch);
			$notifications= 'Hey '.$user_name . ', '.$notifications;
			if ($sendmessagevia == 'email')
			{
			 
			$subject = "Notification for Offerz";
			$headers = "From: info@offerz.com";
					
			mail($user_email,$subject,$notifications,$headers);
			$flag=1;
			}
			
			else 
			{
			// SEND PUSH NOTIFICATION
			//$token=;
			$this->Pushios->sendPush($notifications, $deviceToken);
			$flag=1;
			}			 
								 
				 
			}
			if($flag==1)
			{	
				$this->Flash->success('Notification send successfully!');
				return $this->redirect(['action' => 'index']);
			
			}
			else
			{
				$this->Flash->error('Error While sending Notification');
				
			}
			
		}
		
		}
	}
}
	


