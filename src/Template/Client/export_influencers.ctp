<?php

$fp = fopen('php://output', 'w');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=exportinfluencers'.date("d-m-Y").'.csv');

$overall_total_followers=0;
$overall_total_share_per=0;
			
fputcsv($fp, array('Client_Name', 'Client_Email Address'));
fputcsv($fp, $client_data2);
fputcsv($fp, array(''));
fputcsv($fp, array('Name', 'Twitter Handle','Email Address' ,'Invites_created_date','Share %','Followers','Last Offer','Invitation_status'));

	foreach ($data as $user):

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
		unset($result['twt_followers']);
			

	$overall_total_followers+=$result['total_followers'];
	$overall_total_share_per+=$result['share_perc'];
	
		if($result['is_accepted']==0)
		{
			$result['Invitation_status']='Not Respond';
		}
		elseif($result['is_accepted']==1)
		{
			$result['Invitation_status']='Accepted';
		}
		else{
			$result['Invitation_status']='Declined';
		}
	unset($result['is_accepted']);

	fputcsv($fp, $result);

	endforeach;
 
$avg_share_per=round($overall_total_share_per/count($data)).'%';

fputcsv($fp, array(''));
fputcsv($fp, array('Total_followers',$overall_total_followers));
fputcsv($fp, array('overall_total_share_per',$avg_share_per));
fclose($fp);

	?>
