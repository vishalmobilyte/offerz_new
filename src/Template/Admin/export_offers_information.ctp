<?php

$fp = fopen('php://output', 'w');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=OffersInformationOf_ID='.$all_offer_data['id'].'_Date='. date("d-m-Y").'.csv');
/* pr($all_offer_data);
pr($shared_user_data);
pr($not_shared_user_data);die; */
			
fputcsv($fp, array('Offer_Information'));
fputcsv($fp, array(''));
unset($all_offer_data['id']);
fputcsv($fp, array('Title', 'Created_at','Total_Impressions' ,'Total % Complete','Offer_status'));
	fputcsv($fp, $all_offer_data);
fputcsv($fp, array(''));

fputcsv($fp, array('Sharing_Information'));

fputcsv($fp, array('Shared_Information'));
fputcsv($fp, array(''));
fputcsv($fp, array('Name', 'Twitter Handle','Email Address'));
foreach($shared_user_data as $shared_data)
{
	fputcsv($fp, $shared_data);
}
	fputcsv($fp, array(''));
	fputcsv($fp, array('Not_Shared_Information'));
fputcsv($fp, array(''));
fputcsv($fp, array('Name', 'Twitter Handle','Email Address'));
foreach($not_shared_user_data as $not_shared_data)
{
	fputcsv($fp, $not_shared_data);
}


?>