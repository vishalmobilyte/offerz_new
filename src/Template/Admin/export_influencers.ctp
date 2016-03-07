<?php

$fp = fopen('php://output', 'w');

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=exportinfluencers'.date("d-m-Y").'.csv');

fputcsv($fp, array('Name', 'email', 'password'));
 foreach ($data as $user):

	fputcsv($fp, $user);
	endforeach;
	?>
