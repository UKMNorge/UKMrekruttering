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
	
	$result = $mobCol->fetchByPlace(22);
}
elseif(get_option('site_type') == 'fylke') {
	$monstring = new monstring_v2(get_option('pl_id'));
	$fylke = $monstring->getFylke();
	$result = $mobCol->fetchByPlace($fylke->getId());
}
else {
	$result = $mobCol->fetchAll();	
}

if($result->success == true) {
	$TWIG['mobilnummer'] = $result;
}
else {
	$TWIG['message'] = $result;
}
