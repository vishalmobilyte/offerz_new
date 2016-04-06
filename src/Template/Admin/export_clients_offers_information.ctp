<?php
//print_r($all_offer_data);die;
$fp = fopen('php://output', 'w');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=OffersInformation_'.time().'.csv');
		
fputcsv($fp, array('Offers_Information'));
fputcsv($fp, array(''));

fputcsv($fp, array('Title', 'Created_at','Total_Impressions' ,'Total % Complete','Offer_status'));
	foreach($all_offer_data as $a)
{
	unset($a['id']);
	fputcsv($fp, $a);
}
	
fputcsv($fp, array(''));

?>