<?php
$fp = fopen('php://output', 'w');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=exportusers'.date("d-m-Y").'.csv');

fputcsv($fp, array('INFLUENCERS', 'CONTACT', 'FOLLOWERS', 'SHARE %', 'LAST OFFER'));
 foreach ($data as $user):

// print_r($user);die;
	fputcsv($fp, $user);
	endforeach;

?>
