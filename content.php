<?php
$path  = '';  
if ( !defined('WP_LOAD_PATH') ) {

	/** classic root path if wp-content and plugins is below wp-config.php */
	$classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
	
	if (file_exists( $classic_root . 'wp-load.php') )
		define( 'WP_LOAD_PATH', $classic_root);
	else
		if (file_exists( $path . 'wp-load.php') )
			define( 'WP_LOAD_PATH', $path);
		else
			exit("Could not find wp-load.php");
}
// let's load WordPress
require_once( WP_LOAD_PATH . 'wp-load.php');

global $wpdb;

if(!empty($_GET['page_id']))
{
	
	$page_id = (int) $_GET['page_id'];
	$post_id_2 = get_post($page_id);
	
	$content = $post_id_2->post_content;
	echo $content;
	/*$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);*/


}

?>