<?php
/*
Plugin Name: Artiss YouTube Embed
Plugin URI: http://www.artiss.co.uk/artiss-youtube-embed
Description: Embed YouTube Videos in WordPress
Version: 2.3.1
Author: David Artiss
Author URI: http://www.artiss.co.uk
*/

/**
* YouTube Embed
*
* Main code - include various functions
*
* @package	YouTubeEmbed
* @since	2.0
*/

define( 'youtube_embed_version', '2.3.1' );

$functions_dir = WP_PLUGIN_DIR . '/youtube-embed/includes/';

// Include all the various functions

include_once( $functions_dir . 'shared.php' );								// Shared routines

include_once( $functions_dir . 'set-option-defaults.php' );					// Set default options

include_once( $functions_dir . 'admin-bar.php' );							// Admin bar

include_once( $functions_dir . 'generate-embed-code.php' );					// Generate YouTube embed code

if ( is_admin() ) {

	include_once( $functions_dir . 'admin-menu.php' );						// Administration menus

	include_once( $functions_dir . 'mcebutton.php' );						// Editor button

	if ( !has_action( 'wp_dashboard_setup', 'artiss_dashboard_widget' ) ) {

		include_once( $functions_dir . 'artiss-dashboard-widget.php' );		// Artiss dashboard widget

	}

} else {

	include_once( $functions_dir . 'content.php' );							// Process post content

	include_once( $functions_dir . 'function-calls.php' );					// Function calls

	include_once( $functions_dir . 'generate-download-code.php' );			// Generate download URLs

	include_once( $functions_dir . 'generate-shorturl-code.php' );			// Generate short URLs

	include_once( $functions_dir . 'generate-thumbnail-code.php' );			// Generate thumbnail code

	include_once( $functions_dir . 'generate-transcript-code.php' );		// Generate transcripts

	include_once( $functions_dir . 'shortcodes.php' );						// Shortcodes

	include_once( $functions_dir . 'deprecated.php' );						// Deprecated options

}

include_once($functions_dir . 'widgets.php');

/**
* Output some useful debug information
*
* Quick debug task to output version number and plugin directory, in case of queries
*
* @since	2.0
*
* @return	string	Plugin version and plugin directory, seperated by double colons
*/

if ( !is_admin() ) {
	function ye_debug( $paras = '', $content = '' ) { echo youtube_embed_version . ' :: ' . WP_PLUGIN_DIR; }
	add_shortcode( 'ye-debug', 'ye_debug' );
}
?>