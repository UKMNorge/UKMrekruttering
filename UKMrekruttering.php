<?php  
/* 
Plugin Name: UKM Rekruttering
Plugin URI: http://www.ukm-norge.no
Description: Verktøy til bruk under rekruttering av deltakere.
Author: UKM Norge / A Hustad
Version: 1.0 
Author URI: http://www.github.com/AsgeirSH
*/

if(is_admin()) {
	add_action('UKM_admin_menu', 'UKMrekruttering_menu',100);
}

function UKMrekruttering_menu() {
	UKM_add_menu_page('resources','Rekruttering', 'Rekruttering', 'superadmin', 'UKMrekruttering', 'UKMrekruttering', 'http://ico.ukm.no/mapmarker-bubble-blue-menu.png',20);
	UKM_add_scripts_and_styles('UKMrekruttering', 'UKMrekruttering_script' );
}

function UKMrekruttering_script() {
	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
}

function UKMrekruttering() {
	$TWIG = array();
	require_once('controller/layout.controller.php');

	$VIEW = isset( $_GET['action'] ) ? $_GET['action'] : 'oversikt';
	$TWIG['tab_active'] = $VIEW;
	require_once(__DIR__.'/controller/'. $VIEW .'.controller.php');
	
	echo TWIG($VIEW .'.html.twig', $TWIG, dirname(__FILE__), true);
	echo TWIGjs( dirname(__FILE__) );
}