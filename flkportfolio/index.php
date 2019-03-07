<?php
/*
Plugin Name: FlkPortfolio
Plugin URI: https://www.portfolioz.tk
description: This is a portfolio plugin
Version: 1.0
Author: Mr. Salman Rais
Author URI: m.salmanprog@gmail.com
License: GPL2
*/

function wpdocs_register_flkportfolio(){
    add_menu_page( 
        __( 'Portfolio', 'textdomain' ),
        'Flk Portfolio',
        'manage_options',
        'flk-portfolio',
        'add_my_custom_page',
        plugins_url( 'myplugin/images/icon.png' ),
        6
    ); 
}
//add_action( 'admin_menu', 'wpdocs_register_flkportfolio' );

function myplugin_activate() {
    $buf = "<?php\n"
        . "/*\n"
        . " * Template Name: Flk Portfolio\n"
        . " */\n"
        . "get_header();"
        . "\n"
        . " while (have_posts()) : the_post(); "
        . "\n"
        . "the_content();"
        . "\n"
        . "endwhile;"
        . "\n"
        . "get_footer();"
        . "\n"
        . "?>\n";

    $handle = fopen( get_stylesheet_directory() . '/page-portfolios.php', 'w' );
    fwrite( $handle, $buf );
    fclose( $handle );
}
register_activation_hook( __FILE__, 'myplugin_activate' );

function add_my_custom_page() {
    $my_post = array(
      'post_title'    => wp_strip_all_tags('Portfolios'),
      'post_content'  => '[flkportfolio]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );

    wp_insert_post( $my_post );
}
if( get_page_by_title('FlkPortfolio') == NULL ):
register_activation_hook(__FILE__, 'add_my_custom_page');
endif;

/**
 * Enqueue scripts and styles
 */
function wpdocs_flkportfolio_styles() {
  if ( is_page_template( 'page-portfolios.php' ) ) {
    wp_enqueue_style('flkp-style', "/wp-content/plugins/flkportfolio/assets/css/style.css");
  }
}
add_action( 'wp_enqueue_scripts', 'wpdocs_flkportfolio_styles',50);

function wpdocs_flkportfolio_scripts() {
  if ( is_page_template( 'page-portfolios.php' ) ) {
    wp_enqueue_script('flkp-library', "/wp-content/plugins/flkportfolio/assets/js/lib.js", array(), '1.0.0', true );
    wp_enqueue_script('flkp-function', "/wp-content/plugins/flkportfolio/assets/js/function.js", array(), '1.0.0', true );
    wp_enqueue_script('flkp-custom', "/wp-content/plugins/flkportfolio/assets/js/custom.js", array(), '1.0.0', true );
  }
}
add_action( 'wp_enqueue_scripts', 'wpdocs_flkportfolio_scripts');


function showflkportfolio($brand=null){
	include 'env.php';
	include 'UrlAPI.php';
	$UrlAPI = new UrlAPI();
	$ch = curl_init();
    if(isset($_GET['guid']) && $_GET['guid']>0){
      $url = CLIENT_URL.'/'.$_GET['guid'].'?wp=1';
    }else{
      $url = CLIENT_URL.'?wp=1';
    }
    curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	if(isset($_POST['action']) && $_POST['action']=="portfilter"){
	    $_POST['action']='wp_portfilter';
		if(isset($_POST['tags_list']) && is_array($_POST['tags_list'])){
			$_POST['tags_list']=implode(",", $_POST['tags_list']);
		}
		$headers = array('X-CSRF-TOKEN' => $_POST['_token']);
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
add_shortcode('flkportfolio','showflkportfolio');
?>