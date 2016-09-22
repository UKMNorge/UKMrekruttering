<?php

$tabs = array();
$tabs[] = (object) array( 'link' 		=> 'oversikt',
						  'header' 		=> 'Rekruttering',
						  'icon'		=> 'info-button-256',
						  'description'	=> 'Hva er Rekruttering?');

$tabs[] = (object) array( 'link'		=> 'husk',
						  'header'		=> 'Mulige deltakere',
						  'icon'		=> 'mapmarker-bubble-pink-256',
						  'description' => 'Fra husk.ukm.no');



$TWIG['tabs'] = $tabs;