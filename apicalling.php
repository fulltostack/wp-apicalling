<?php
/**
 * @package API Calling
 */
/*
Plugin Name: API Calling
Plugin URI: https://www.xxx.com/
Description: This is test plugin for calling API
Version: 1.0.0
Author: Test User
License: GPLv2 or later
*/

// Make Ajax Code for call button 
function apicalling_ajax_enqueue() {

	// Register CSS file 
	wp_enqueue_style( 'apicalling-ajax-style', plugins_url('/apicalling/assets/css/apicalling-ajax.css'), array(), '1.1', 'all');

	// Enqueue javascript on the frontend.
	wp_enqueue_script('apicalling-ajax-script', plugins_url('/apicalling/assets/js/apicalling-ajax.js') ,array('jquery'));

	// The wp_localize_script allows us to output the ajax_url path for our script to use.
	wp_localize_script('apicalling-ajax-script','apicalling_ajax_obj',array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

}
add_action( 'wp_enqueue_scripts', 'apicalling_ajax_enqueue' );
add_action( 'admin_enqueue_scripts', 'apicalling_ajax_enqueue' );

function apicalling_ajax_request() {
	$url = "http://api.strategy11.com/wp-json/challenge/v1/1";
	$getData = file_get_contents($url); 
	$convertjSonToArr = json_decode($getData);   
	add_option( 'apicalling_data', $convertjSonToArr, '', 'yes' );  
	die('Option is added.');
}
 
add_action( 'wp_ajax_apicalling_ajax_request', 'apicalling_ajax_request' );
 
// If you wanted to also use the function for non-logged in users (in a theme for example)
add_action( 'wp_ajax_nopriv_apicalling_ajax_request', 'apicalling_ajax_request' );

function show_apiCalling($atts)
{
	$getAPICallingData = get_option( 'apicalling_data' ); 

	$html = "<div id='challenges'>";
		$html .= "<div class='top-wrapper'>";
		$html .= "<h2>API Calling</h2>";
			$html .= "<button class='btn' id='getData'> Get Data</button>";
		$html .= "</div>";
		$html .= "<div class='innerBody'>";
		if(!empty($getAPICallingData )){
			
			$convertRowData = $getAPICallingData->data->rows;
			$makeTempArrs = array();
			foreach($convertRowData as $rows){
				$changeObjToArr = changeObjToArray($rows); // Covert Objec to Array
				$makeTempArrs[] =  array_values($changeObjToArr); // Remove Key name 
			}
			//$html .= "<div class='title'>".$getAPICallingData->data->title."</div>";
			$html .= "<table width='100%' class='wp-list-table widefat fixed striped toplevel_page_formidable'>";
				$html .= "<thead>";
					$html .= "<tr>";
						foreach ($getAPICallingData->data->headers as $key => $value) {
							$html .= "<th>".$value."</th>";
						}
					$html .= "<tr>";
				$html .= "</thead>";
				$html .= "<tbody>";
					foreach ($makeTempArrs as $rows) {
						$html .= "<tr>";  
							foreach ($rows as $key => $value) {
								$html .= "<td>".$value."</td>"; 
							}
						$html .= "<tr>";	
					}
				$html .= "</tbody>";		
			$html .= "</table>";
		} else {
			$html .= "No data found.";
		}	
		$html .= "</div>";
		$html .= "<div class='footerBody'></div>";
	$html .= "</div>"; 
	return $html;
}

add_shortcode('APICalling', 'show_apiCalling');

// Change Object to array method
function changeObjToArray($d) {	
	if (is_object($d)) {
		$d = get_object_vars($d);
	}

	if (is_array($d)) {
		return array_map(__FUNCTION__, $d);
	}
	else {
		return $d;
	}
}

// Admin Page Menu create 
function apicalling_register_admin_menu(){
    add_menu_page( 
        __( 'API Calling', 'apicalling' ),
        'API Calling',
        'manage_options',
        'apicalling',
        'apiCalling_menu_page',
        plugins_url( 'assets/images/icon.png' ),
        6
    ); 
}
add_action( 'admin_menu', 'apicalling_register_admin_menu' );
 
/**
 * Display a custom menu page
 */
function apiCalling_menu_page(){ 
	echo '<div class="apiCalling_admin">';
		echo do_shortcode( '[APICalling]' );
	echo '</div>';	
    
}

// WP CLI 

function addAPICallingData( ) {
	apicalling_ajax_request();
    WP_CLI::success( 'Remove Option successfully' );
}


function updateApiCallingData( ) {
	apicalling_ajax_request();
    WP_CLI::success( 'Data refreshed successfully' );
}

function removeAPICallingData( ) {
	delete_option('apicalling_data');
    WP_CLI::success( 'Remove Option successfully' );
}

if ( class_exists( 'WP_CLI' ) ) {
	WP_CLI::add_command( 'addAPICallingData', 'addAPICallingData' );
	WP_CLI::add_command( 'updateAPICallingData', 'updateApiCallingData' );
	WP_CLI::add_command( 'deleteAPICallingData', 'removeAPICallingData' );
}
