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
use Cake\Datasource\ConnectionManager;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class ClientController extends Controller
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
	 public $paginate = [
        'limit' =>5
    ];
	
	
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Twitter');
        $this->loadComponent('Pushios');
        $this->loadComponent('Push');
        $this->loadComponent('Paginator');
		
		$this->session = $this->request->session();
		
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
		//echo $this->request->params['action']; die;
		$action_nm = $this->request->params['action'];
		
		if($action_nm != 'getFollowersInf' && $action_nm !='getSharePercInf' && $action_nm != 'getMostDelinedOffers' && $action_nm != 'exportInfluencers'&& $action_nm != 'exportOffersInformation'){
		$this->viewBuilder()->layout('client_new');
		}
		$client_id = $this->request->session()->read('Client.id');
		//$client_id = '5';
		if($client_id){
		$Clients = TableRegistry::get('Clients');
		$article = $Clients->get($client_id);
		
		$this->set('client_data',$article);
		}
		else{
		$this->set('client_data','');
		
		}
		
    }
	
	
	
	public function myview(){
	$this->viewBuilder()->layout('client_new');
	//$connection = $this->Twitter->getRetweets('vishaljaura183');
	$connection_fb = $this->Twitter->fb_conn();
	//$connection_insta = $this->Twitter->InstagConnect();
	print_r($connection_fb); die("--YIPPIEEE !!!");
	//die('eeee');
	$session = $this->request->session();
	$session->write('User.user_id', '1');
	$Clients = TableRegistry::get('Clients');
//	$Clients_qry = TableRegistry::get('ClientQueries');

		//$query_clt = $Clients_qry->find();
		/*
		foreach ($query_clt as $rows) {
			echo $rows->content_query;
			echo "<hr>";
		}
		*/
		$query = $Clients->find('all')->contain(['Offers']);
		
		foreach ($query as $row) {
		//print_r($row);
		foreach($row->offers as $offer){
		//	echo @$offer->id.'--';
		}
			
			//echo $row->offers[0]->editable_text;
		//	echo "<hr>";
		}
	}
	
	public function index()
	{
	if(!$this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);			
		}
		else{
		return $this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
		
		}
		
	}
	public function login()
    {
		if($this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
		}
		
		
		$session = $this->request->session();
		//echo $session->read('Client.id'); 
		//echo $session->read('Client.email'); 
		//die('-');
		//print_r($this->request->data);
		if(isset($this->request->data['username']) && !empty($this->request->data['username']))

		{
		$params = $this->request->data;
		$email = trim($this->request->data['username']);
		$password = trim($this->request->data['password']);
		$Clients = TableRegistry::get('Clients');
		// An advanced example
		$results = 	$Clients->find()
							->where(['email' => $email,'password'=>$password])
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
		$session->delete('Client.id');
		//$session->destroy();
		$this->Flash->success('Logged Out Successfully!');
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);
		
	}
	
	// =============== GETT ALL INFLUENCERS LISTING ============================
	
	public function influencer()
	{
		if(!$this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);			
		}
		
		$this->set('activeMenuButton', 'posts');
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		//echo $client_id; die('-eee');
		// Count total Influncers who has not responded and who have accepted the invites
		$InvitesTable = TableRegistry::get('Invites');
		 $count_qry = 	$InvitesTable->find('all',['conditions'=>['is_accepted' => '1', 'client_id'=>$client_id,'is_deleted'=>0]])->count();
				/* ->select(['count'=>$count_qry->func()->count('id')])
							->where(['is_accepted' => 0])
							->orWhere(['is_accepted' => 1])->hydrate(false)->toArray(); */
			//pr($count_qry);die;
			$this->set('count_influencers',$count_qry); //die
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
							//	pr($query);die;
							// Also a collections library method
			$total_conn_result = $query->hydrate(false)->toArray();
			//pr($total_conn_result);die;
			$total_connections = array_sum(array($total_conn_result[0]['total_conn'],$total_conn_result[0]['total_count_fb']));
			$this->set('total_connections',$total_connections);
			
		// ----------------   GEt Invites listing  --------------------------------------------
		
		$UserOffersTable = TableRegistry::get('UserOffers');
		$results = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id','u.oauth_token','u.status','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','Clients.id','u.twt_followers','u.twt_pic','u.name','u.email','u.fb_friends','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->where(['Invites.client_id' => $client_id,'is_deleted'=>0])
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
								'conditions' => 'u.id = os.user_id and os.client_id = Invites.client_id',
								])
								
							->toArray(); // Also a collections library method
							
		
			//print_r($results); die('-eee');			
		//$conn = ConnectionManager::get('default');
		/*
		$i=0;
		foreach($results as $data_inv){
		
		$user_id = $data_inv['u']['id'];
		$results_share 	= 	$UserOffersTable->find('all');			
		$shared = $results_share->newExpr()->addCase($results_share->newExpr()->add(['status' => '1']));
		
		$declined = $results_share->newExpr()->addCase($results_share->newExpr()->add(['status' => '2']));
		
		$not_responded = $results_share->newExpr()->addCase($results_share->newExpr()->add(['status' => '0']));
		$results_share->select([
		
			'shared' => $results_share->func()->sum($shared),
			'declined' => $results_share->func()->sum($declined),
			'not_responded' => $results_share->func()->sum($not_responded)
		])
		
		->where(['client_id' => $client_id,'user_id'=>$user_id]);
		$get_result_share = $results_share->hydrate(false)->toArray(); 
		//print_r($get_result_share);
		$offer_shared = $get_result_share[0]['shared'];
		$total_offers = array_sum(array_values($get_result_share[0]));
		if($total_offers > 0){
		$shared_perc = round(($offer_shared/$total_offers)*100,0);
		}
		else{
		$shared_perc =0;
		}
		//echo $shared_perc;
		$results[$i]['share_perc'] = $shared_perc;
		//die;
		$i++;
		}
		*/
		//die;
	//	print_r($results); die;
		$this->set('invites_data',$results); 
		
	}
	// =================== Connect to Twitter  ====================
	public function connectTwitter(){
		$connection_url = $this->Twitter->connect();
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
		
		$client_id = $this->request->session()->read('Client.id');
		
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
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
	}
	//  ========================= Unlink Twitter ===========================
	
	public function unlinkTwitter()
	{
		$ClientsTable = TableRegistry::get('Clients');
		$client_id = $this->request->session()->read('Client.id');
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
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);			
	}
	
	// ================ UPDATE PROFILE DETAIL OF CLIENT ======================
	public function updateProfile()
	{
		//print_r($this->request->data);
		$name = $this->request->data['name'];
		$email = $this->request->data['email'];
		$phone = $this->request->data['phone'];
		$password = $this->request->data['password'];
		$client_id = $this->request->session()->read('Client.id');
		
		$ClientsTable = TableRegistry::get('Clients');
		
		$Clients = $ClientsTable->get($client_id); // Return article with id 12
		
		$Clients->name = $name;
		$Clients->email = $email;
		$Clients->phone = $phone;
		if($password !=''){
		$Clients->password = $password;
		
		}
		$ClientsTable->save($Clients);
		$this->redirect(['controller' => 'Client', 'action' => 'influencer']);	
	}
	
	// =============== CHECK EMAIL EXISTS OR NOT OF CLIENT ==============
	
	public function checkEmail()
	{
		$client_id = $this->request->session()->read('Client.id');
		$email = $this->request->query('email');
		
		$ClientsTable = TableRegistry::get('Clients');
		$results = 	$ClientsTable->find()
								->where(['email' => $email, 'id !='=>'5'])
								//->where(['id NOT IN' => '5'])
								->toArray(); // Also a collections library method
							//	print_r($results);
		if(count($results) > 0){
		echo "false";
		}
		else{
		echo "true";
		}
		die;
	
	}
	
	// =============== CHECK EMAIL EXISTS OR NOT FOR INVITES UNDER CLIENT ==============
	
	
	public function checkInviteEmailExists()
	{
	
		$email = $this->request->query['email_influencer']; 
		$client_id = $this->request->session()->read('Client.id');
		$InvitesTable = TableRegistry::get('Invites');
		$results = 	$InvitesTable->find()
								->where(['email' => $email, 'client_id'=>$client_id,'is_deleted'=>0])
								->hydrate(false)
								//->where(['id NOT IN' => '5'])
								->toArray(); // Also a collections library method	
		//print_r($results); die;
		if(count($results) > 0){
		echo "false";
		}
		else{
		echo "true";
		}
		die;
	}
	
	public function addInvite()
	{
		//print_r($this->request);
		
		$InvitesTable = TableRegistry::get('Invites');
		$client_id = $this->request->session()->read('Client.id');
		$client_name = $this->request->session()->read('Client.name');
		$app_link = SITE_URL;
		$email = $this->request->data['email_influencer'];
		$results = 	$InvitesTable->find()
								->where(['email' => $email, 'client_id'=>$client_id,'is_deleted'=>0])
								->hydrate(false)
								//->where(['id NOT IN' => '5'])
								->toArray(); // Also a collections library method	
		if(count($results) < 1){
		//Send Email to new Influencer
		$to = $email;
	$subject = "Invitation Email- Offerz";

	$message = "
	<html>
	<head>
	<title>Invitation Email- Offerz</title>
	</head>
	<body>
	<h2>Invitation to Join Offerz App</h2>
	<table>

	<tr>
	<td>Hi,</td>
	</tr>
	<tr><td>
	$client_name has added you to their list of key influencers. Please click the link and download our mobile app so that you can receive special offerz and share on social media: <a href='$app_link' target='_blank'>$app_link</a></td></tr>
	</table>
	</body>
	</html>
	";

	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// More headers
	$headers .= 'From: <mailer@offerz.co>' . "\r\n";
	//$headers .= 'Cc: viskumar@betasoftsystems.com' . "\r\n";

	mail($to,$subject,$message,$headers);
	}
		
		
		$client_id = $this->request->data['client_id'];
		
		$Invites = $InvitesTable->newEntity();
		$Invites->email = $email;
		$Invites->client_id = $client_id;
		
		if($InvitesTable->save($Invites)){
		echo "success";
		}
		else{
		echo "failed";
		}
		die;
		
	}
	//  =============== DELETE MOBILE USER ( SOFT DELETE ) ==============
	public function deleteInfluncer()
	{
		//print_r($this->request->data); die;
		$invite_id = $this->request->data['invt_id'];
		if($invite_id !=''){
		$InvitesTable = TableRegistry::get('Invites');
		$Invites = $InvitesTable->get($invite_id);
		$Invites->is_deleted = '1';
		
		
		if($InvitesTable->save($Invites)){
		echo "success";
		}
		}
		
		
		else{
		echo "failed";
		}
		die;
		
	}
	
	public function testing()
	{
	// echo  "teching";
	}
	
	// ================ Save offer ====================
	public function offers()
	{
		if(!$this->session->check('Client.id')){
			return $this->redirect(['controller' => 'Client', 'action' => 'login']);			
		}
			$session = $this->request->session();
			$client_id = $session->read('Client.id');
			
			$OffersTable 		= TableRegistry::get('Offers');
			$InvitesTable 		= TableRegistry::get('Invites');
			$UserOffersTable 	= TableRegistry::get('UserOffers');
			$OffersStatTable 	= TableRegistry::get('OffersStat');
		
			
		if($this->request->data){
	
			
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
	}
	$this->paginate = [
        'limit' =>5
    ];
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
		$get_offers = 	$OffersTable->find('all')->contain(['UserOffers'])->contain(['UserOffers.Users'])
								->where(['client_id'=>$client_id,'is_deleted'=>0])
								->order(['created_at' => 'DESC'])
								->hydrate(false);
								//->where(['id NOT IN' => '5'])
							//	->toArray(); // Also a collections library method	
		
		
		$result_offers = $this->paginate($get_offers)->toArray();
		$j=0;
		
		foreach($result_offers as $data_offr){
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
		//echo $k; die('==');
		
		$avg_comp = ($k/$count_off_user)*100;
		$result_offers[$j]['comp_perc'] = $avg_comp;
		$result_offers[$j]['followers_count'] = $count_followers;
		//print_r($offer_user); die('--');
		$j++;
		}
		else{
		$result_offers[$j]['comp_perc'] = 0;
		}
		}
		$this->set('all_offer_data',$result_offers);
		//print_r($result_offers); die('-e-e-');
		//print_r($this->paginate($get_offers)->toArray()); die;				
	
	}
	// ===========Exporting offers information ==================
	public function exportOffersInformation($id=null)
	{
		$offer_id=$id;
		$this->viewBuilder()->layout('empty');
		$this->response->type(['csv' => 'text/csv']);
		$this->response->type('csv');
		$this->response->charset('UTF-8');
		
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		
		$usersModel = TableRegistry::get('Users');
		$ClientsModel = TableRegistry::get('Clients');
		$InvitesTable = TableRegistry::get('Invites');
		$OffersStatModel = TableRegistry::get('Offers_stat');
		$OffersTable=TableRegistry::get('Offers');
		$UserOffersTable = TableRegistry::get('UserOffers');
		
		$result_offers = 	$OffersTable->find('all')->contain(['UserOffers'])->contain(['UserOffers.Users'])
		//->select(['id','title','created_at','is_paused'])
								->where(['client_id'=>$client_id,'is_deleted'=>0,'id' => $offer_id])
								->order(['created_at' => 'DESC'])
								->hydrate(false)
								->toArray();
								//print_r($result_offers); 
								// unset($result_offers['user_offers']);
								// print_r($result_offers); die('--');
				$j=0;				
		foreach($result_offers as $data_offr)
		{
			//echo count($data_offr['user_offers']);die;
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
		
		//echo $k; die('==');
		
		$avg_comp = ($k/$count_off_user)*100;
		$result_offers[$j]['comp_perc'] = $avg_comp;
		$result_offers[$j]['followers_count'] = $count_followers;
		
		$j++;
		}
		else{
		$result_offers[$j]['comp_perc'] = 0;
		}
		}
		//print_r($result_offers);
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
			//$data['is_paused']=$user['is_paused'];
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
							/* pr($shared_info);
							pr($not_shared_info);
							die; */
		
			//pr($data);die;
			//pr($user['user_offers']);
			//unset($user['user_offers']);
			//unset('editable_text');
			//unset($user['editable_text']);
			//unset($user['user_offers']);
		}
		//$data=$result_offers->select(['id','title','created_at','is_paused']);
		//pr($data);die;
			
		/* 
		foreach ($result_offers as $user):

		$result = array_merge($user['u'],$user,$user['os']);
		unset($result['u']);
		unset($result['os']);
		unset($result['client']);
		unset($result['offer_accepted']);
		unset($result['id']);
		unset($result['user_id']);
		unset($result['client_id']);
		unset($result['total_offer_received']);
		unset($result['fb_friends']);
	unset($result['twt_followers']);} */
	//pr($data);die;
		$this->set('all_offer_data',$data);
		$this->set('_serialize', ['all_offer_data']);
		$this->set('shared_user_data',$shared_info);
		$this->set('_serialize', ['shared_user_data']);
		$this->set('not_shared_user_data',$not_shared_info);
		$this->set('_serialize', ['not_shared_user_data']);
		 /* pr($data);
		 pr($shared_info);
		 pr($not_shared_info);die; */
	}
	
	// ================== EDIT OFFER =================================
	
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
	// ============== ANALYTICS =======================
	
	public function analytics() {
		
		$this->viewBuilder()->layout('client');
		
		if(!$this->session->check('Client.id')){
		return $this->redirect(['controller' => 'Client', 'action' => 'login']);			
		}
		
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		$ActivityLog = TableRegistry::get('activity_logs');
		//  -------- GET RECENT ACTIVITIES  ---------------
		$results = 	$ActivityLog->find()
		                        ->contain(['Users'])
		                        ->select(['log_client','created_at','user_id','Users.email','Users.twt_pic'])
								->where(['client_id' => $client_id])
								->limit(5)
								->order(['activity_logs.created_at' => 'DESC'])
								->hydrate(false)
								->toArray(); // Also a collections library method	
								
			//print_r($results); die;
			$this->set('results',$results);
			
		//left sidebar	
		$InvitesTable = TableRegistry::get('Invites');
		
			// GEt Invites listing
		
		$UserOffersTable = TableRegistry::get('UserOffers');
		$results_invites = 	$InvitesTable->find('all')->contain(['Clients'])
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->where(['Invites.client_id' => $client_id,'is_deleted'=>0, 'Invites.is_accepted' => '1'])
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
		
			
		
	}
	// =============== MOST POPULART FOLLOWERS OF INFLUENCERS ===============
	
	public function getFollowersInf(){
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
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->where(['Invites.client_id' => $client_id,'is_deleted'=>0, 'Invites.is_accepted' => '1'])
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
		
			$this->set('invites_data_followers',$followers_data);
			
		
		
	}
	
	// =============== MOST POPULART FOLLOWERS OF INFLUENCERS ===============
	
	public function getSharePercInf(){
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
							->select(['u.id','u.oauth_token','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','u.twt_followers','u.twt_pic','u.name','u.email','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
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
		
			$this->set('share_perc_data',$share_perc_data);
			
		
		
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
	
	// =============== NUDGE OFFER ========================
	
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
			$token = $data['Users']['device_token'];
			//$token = '8f078380670c193b29301800405174210f3d7721e2f6a7003071b721f045906a';
			$offer_title = $data['Offers']['title'];
			if($token){
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
	
	public function uploadfile()
	{
	
		
		// Valid image formats 
		$valid_formats = array("jpg", "png", "gif","jpeg");
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") 
		{
		$img_path = SITE_URL.'/uploads/offers_images/';
		$uploaddir = WWW_ROOT."uploads/offers_images/"; //Image upload directory
		foreach ($_FILES['photos']['name'] as $name => $value)
		{
		$filename = stripslashes($_FILES['photos']['name'][$name]);
		$size=filesize($_FILES['photos']['tmp_name'][$name]);
		//Convert extension into a lower case format
		$ext = $this->getExtension($filename);
		$ext = strtolower($ext);
		//File extension check
		if(in_array($ext,$valid_formats))
		{
		//File size check
		if ($size < (MAX_SIZE*1024))
		{ 
		//$image_name=str_replace(" ", "_",time().$filename); 
		$image_name=time().'.'.$ext; 
		$offer_id = @$_REQUEST['offer_id_temp'];

		echo "<img src='".$img_path.$image_name."'  width='120' height='100'>
		<input type='hidden' id='image_name' name='image_name' value='".$image_name."' /><input type='hidden' id='offer_id' value='".$offer_id."'/>"; 
		$newname=$uploaddir.$image_name; 
		//Moving file to uploads folder
		if (move_uploaded_file($_FILES['photos']['tmp_name'][$name], $newname)) 
		{ 
		$time=time(); 
		//Insert upload image files names into user_uploads table
		//mysql_query("INSERT INTO user_uploads(image_name,user_id_fk,created) VALUES('$image_name','$session_id','$time')");
		}
		else 
		{ 
		echo 'You have exceeded the size limit! so moving unsuccessful!'; } 
		}

		else 
		{ 
		echo '<span class="imgList">You have exceeded the size limit!</span>'; 
		} 

		} 

		else 
		{ 
		echo 'Unknown extension!. Only png, Jpg or gif images allowed.'; 
		} 

		} //foreach end

		} 
	die;
	}
	
	public function getExtension($str)
		{
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
		}
		
		// =============== EXPORT INFLUENCERS ===============
		
		public function exportInfluencers() 
		{	
		$this->viewBuilder()->layout('');
		$this->response->type(['csv' => 'text/csv']);
		$this->response->type('csv');
		$this->response->charset('UTF-8');
		
		$session = $this->request->session();
		$client_id = $session->read('Client.id');
		
		$usersModel = TableRegistry::get('Users');
		$ClientsModel = TableRegistry::get('Clients');
		$InvitesTable = TableRegistry::get('Invites');
		$OffersStatModel = TableRegistry::get('Offers_stat');
		$UserOffersTable = TableRegistry::get('UserOffers');
		
		$data=$InvitesTable->find('all')->contain(['Clients'])
							//->select(['u.id','u.oauth_token','u.status','Invites.email','Invites.id','u.created_at','Invites.is_accepted','u.screen_name','Clients.name','Clients.id','u.twt_followers','u.twt_pic','u.name','u.email','u.fb_friends','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->select(['Clients.name','Clients.email','u.id','os.user_id','os.client_id','Invites.is_accepted','Invites.client_id','u.name','u.screen_name','u.email','u.fb_friends','u.twt_followers','u.created_at','Invites.email','Invites.created_at','os.offer_accepted','os.total_offer_received','os.last_offer_date'])
							->where(['Invites.client_id' => $client_id,'is_deleted'=>0])
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
								'conditions' => 'u.id = os.user_id and os.client_id = Invites.client_id',
								])
							->order('u.id')
							->hydrate(false)
							->toArray();
		$count_qry = 	$InvitesTable->find('all',['conditions'=>['is_accepted' => 1, 'client_id'=>$client_id,'is_deleted'=>0]])->count();
			//pr($count_qry);die;	
		$conn = ConnectionManager::get('default');
		$i=0;
		
		//// Find Total FOLLOWERS and SHARE_PERCENTAGE
	 	 foreach($data as $data_inf)
		{
			if($data_inf['os']['total_offer_received'] >0)
			{
				$offer_share_perc = round(($data_inf['os']['offer_accepted']/$data_inf['os']['total_offer_received'])*100);
				
			}
			else
			{
				$offer_share_perc = 0;
			}
			
			if($data_inf['u']['fb_friends'] >0 || $data_inf['u']['twt_followers'] >0)
			{
				$total_followers = intval($data_inf['u']['fb_friends']+$data_inf['u']['twt_followers']);
				
			}
			else
			{
				$total_followers = 0;
				
			}
			$data[$i]['share_perc'] = $offer_share_perc;
			$data[$i]['total_followers'] = $total_followers;
		
		$i++;
		}  
		$client_data=$data[0]['client'];
		$this->set('data', $data);
        $this->set('_serialize', ['data']);
		$this->set('client_data2', $client_data);
		$this->set('total_influencers', $count_qry);
	}		//end of exportInfluencers Function
	
}
