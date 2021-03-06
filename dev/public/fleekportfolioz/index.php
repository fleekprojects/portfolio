<?php
/*
Plugin Name: Fleek Portfolioz
Plugin URI: http://dev.portfolioz.tk
description: This is portfolioz plugin
Version: 0.1
Author: Mr. Salman Rais
Author URI: http://www.google.com
License: GPL2
*/

function wpdocs_register_fleekportfolioz(){
    add_menu_page( 
        __( 'Fleek Portfolioz', 'textdomain' ),
        'Fleek Portfolioz Setting',
        'manage_options',
        'fleekportfolioz',
        'add_my_custom_page',
        plugins_url( 'myplugin/images/icon.png' ),
        6
    ); 
}
//add_action( 'admin_menu', 'wpdocs_register_fleekportfolioz' );

function add_my_custom_page() {
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'Fleek Portfolioz' ),
      'post_content'  => '[flkportfolioz]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );

    wp_insert_post( $my_post );
}
if( get_page_by_title( 'Fleek Portfolioz' ) == NULL ):
register_activation_hook(__FILE__, 'add_my_custom_page');
endif;

function showportfolioz($brand=null){
	include 'env.php';
	include 'UrlAPI.php';
	$UrlAPI = new UrlAPI();
	$ch = curl_init();
    if(isset($_GET['guid']) && $_GET['guid']>0){
      $url = CLIENT_URL. $_GET['guid'];
    }else{
      $url = CLIENT_URL;
    }
  curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if(isset($_POST['action']) && $_POST['action']=="portfilter"){
		$headers = "X-CSRF-TOKEN:".$_POST['_token'];
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	$output = curl_exec($ch); 
	curl_close($ch);
	return $output;
}   
add_shortcode('flkportfolioz','showportfolioz');
?>