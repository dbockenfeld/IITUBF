<?php
/**
* TinyMCE Button Functions
*
* Add extra button(s) to TinyMCE interface
*
* @package	YouTubeEmbed
*/

/**
* Set up TinyMCE button
*
* Add filters (assuming user is editing) for TinyMCE
*
* @since 	2.0
*/

function youtube_embed_button() {

	if ( current_user_can( 'edit_posts' ) ) {
		$options = ye_set_general_defaults();

		if ( ( get_user_option( 'rich_editing' ) == 'true' ) && ( $options[ 'editor_button' ] != '' ) ) {
			add_filter( 'mce_external_plugins', 'add_youtube_embed_mce_plugin' );
			add_filter( 'mce_buttons', 'register_youtube_embed_button' );
		}
	}
}
add_action( 'init','youtube_embed_button' );

/**
* Register new TinyMCE button
*
* Register details of new TinyMCE button
*
* @since	2.0
*
* @param	string	$buttons	TinyMCE button data
* @return	string				TinyMCE button data, but with new YouTube button added
*/

function register_youtube_embed_button( $buttons ) {
	array_push( $buttons, '|', 'YouTube' );
	return $buttons;
}

/**
* Register TinyMCE Script
*
* Register JavaScript that will be actioned when the new TinyMCE button is used
*
* @since	2.0
*
* @param	string	$plugin_array	Array of MCE plugin data
* @return	string					Array of MCE plugin data, now with URL of MCE script
*/

function add_youtube_embed_mce_plugin( $plugin_array ) {
	$plugin_array[ 'YouTube' ] = plugins_url() . '/youtube-embed/js/mcebutton.js';
	return $plugin_array;
}
?>