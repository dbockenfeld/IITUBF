<?php
/**
* Admin Bar
*
* Set up Admin Bar links
*
* @package	YouTubeEmbed
*/

/**
* Add option to Admin Bar
*
* Add link to YouTube Embed profile options to Admin Bar. This will only appear
* if the user can edit plugins
*
* @since	2.0
*/

function ye_admin_bar_render() {

	if ( current_user_can( 'edit_plugins' ) ) {

		$options = ye_set_general_defaults();

		if ( $options[ 'admin_bar' ] != '' ) {

			global $wp_admin_bar;
			$wp_admin_bar -> add_menu( array(
				'parent' => 'appearance',
				'id' => 'ye-options',
				'title' => __( 'YouTube Embed' ),
				'href' => admin_url( 'admin.php?page=youtube-embed-profiles' ),
				'meta' => false ) );
		}
	}
}
add_action( 'wp_before_admin_bar_render', 'ye_admin_bar_render' );
?>