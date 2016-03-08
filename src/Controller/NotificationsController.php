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
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class NotificationsController extends Controller
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
	public $helpers = ['Form','Flash'];
	
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Twitter');
		$this->session = $this->request->session();
		$session = $this->request->session();
			
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
		$this->viewBuilder()->layout('notifications');
		if(!$this->session->check('Client.id')){
		// echo 'not logged in';
		}
		
    }
	
	
	public function index()
	{
	$this->viewBuilder()->layout('notifications');
	$session = $this->request->session();
	if(!$this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);	
		}
		else{
		
		
		
		$Users = TableRegistry::get('Users');
		$results =  $Users->find('list')
		->select(['name','id'])
		->where(['status'=>1])
		->toArray();
		
		$this->set('options',$results); 
		
	if($this->request->is('post'))
		{
				
			$notifications = $this->request->data['notifications'];
			$sendmessagevia = $this->request->data['Sendmessagevia'];
			$users = $this->request->data['character'];
			
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
			if ($sendmessagevia == 'email')
			{
			 
			$subject = "Notification";
			$headers = "From: info@offerz.com";
						
			mail($user_email,$subject,$notifications,$headers);
			$flag=1;	 
			}
			
			else 
			{
				
				
						
				// Put your device token here (without spaces):
				//$deviceToken = '0f744707bebcf74f9b7c25d48e3358945f6aa01da5ddb387462c7eaf61bbad78';
				//$deviceToken = 'fc5db59be7dc894f27d1808aef189c21e4950a4e3a3ddd334bc7b0de50a2d87b';
				

				// Put your private key's passphrase here:
				$passphrase ='';

				// Put your alert message here:
				//$message = 'My first push notification!';

				$ctx = stream_context_create();
				stream_context_set_option($ctx, 'ssl', 'local_cert', 'apns-dev-cert.pem');
				stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

				// Open a connection to the APNS server
				$fp = stream_socket_client(
					'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
				
				if (!$fp)
				{
					exit("Failed to connect: $err $errstr" . PHP_EOL);
				}
				else
				{
				//echo 'Connected to APNS' . PHP_EOL;

				// Create the payload body
				$body['aps'] = array(
					'alert' => $notifications,
					'sound' => 'default'
					);

				// Encode the payload as JSON
				$payload = json_encode($body);
				
				// Build the binary notification
				$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	
				// Send it to the server
				$result = fwrite($fp, $msg, strlen($msg));
				
				if (!$result)
				{
				$flag=0;
				//echo 'Message not delivered' . PHP_EOL;
				}
				else
				{
					$flag=1;
				//echo 'Message successfully delivered' . PHP_EOL;
				}

				// Close the connection to the server
				fclose($fp);
				}
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