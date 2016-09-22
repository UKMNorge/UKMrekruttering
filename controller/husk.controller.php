<?php

require_once(__DIR__.'/../class/MobilnummerCollection.class.php');
require_once('UKM/monstring.class.php');

$api_key = 'test';
$api_secret = 'pah';
$mobCol = new MobilnummerCollection($api_key, $api_secret);

if(get_option('site_type') == 'kommune') {
	$monstring = new monstring_v2(get_option('pl_id'));
	if($monstring->erFellesMonstring()) {
		$kommuner = $monstring->getKommuner();	
	}
	
	foreach($kommuner as $kommune) {
		$result[] = $mobCol->fetchByPlace($monstring->getFylke()->getId(), $kommune);
	}
	#var_dump($result);
}
elseif(get_option('site_type') == 'fylke') {
	$monstring = new monstring_v2(get_option('pl_id'));
	$fylke = $monstring->getFylke();
	$result = $mobCol->fetchByPlace($fylke->getId(), 0);
	#var_dump($result);
}
else {
	#$result = $mobCol->fetchAll();
	// Fetch for land
	$result = $mobCol->fetchByPlace(0, 0);
}

if($result->success == true) {
	$TWIG['liste'] = $result->data;
}
else {
	$TWIG['message'] = $result;
}
