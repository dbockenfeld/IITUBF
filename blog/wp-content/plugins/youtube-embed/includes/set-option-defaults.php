<?php
/**
* Set Default Options
*
* Set up default values for the various options
*
* @package	YouTubeEmbed
*/

/**
* Function to set Shortcode option
*
* Looks up shortcode option - if it's not set, assign a default
*
* @since	2.0
*
* @return   string		Alternative Shortcode
*/

function ye_set_shortcode_option() {

	$shortcode = get_option( 'youtube_embed_shortcode' );

	// If setting doesn't exist, set defaults
	if ( $shortcode == '' ) {
		$shortcode[ 1 ] = 'youtube_video';
		$shortcode[ 2 ] = '';
		update_option( 'youtube_embed_shortcode', $shortcode );
	}

	return $shortcode;
}

/**
* Function to set URL option
*
* Looks up URL option - if it's not set, override the WP URL embedding
*
* @since	2.0
*
* @return   string		URL override
*/

function ye_set_url_option() {

	$url = get_option( 'youtube_embed_url' );

	// If setting doesn't exist, set defaults
	if ( $url == '' ) { update_option( 'youtube_embed_url', '' ); }

	return $url;
}

/**
* Function to set general YouTube options
*
* Looks up options. If none exist, or some are missing, set default values
*
* @since	2.0
*
* @return   strings		Options array
*/

function ye_set_general_defaults() {
	$options = get_option( 'youtube_embed_general' );
	$changed = false;
	$default_error = htmlspecialchars( '<p>The video cannot be shown at the moment. Please try again later.</p>' );

	if ( !is_array( $options ) ) {
		if ( get_option( 'youtube_embed_editor' ) ) {
			// If the old options exist, import them and then delete them
			$old_opts = get_option( 'youtube_embed_editor' );
			$options[ 'editor_button' ] = $old_opts[ 'youtube' ];
			delete_option( 'youtube_embed_editor' );
			$changed = true;
		} else {
			// If array doesn't exist, set defaults
			$options = array( 'editor_button' => 1, 'admin_bar' => 1, 'profile_no' => 5, 'list_no' => 5, 'info_cache' => 1, 'embed_cache' => 24, 'transcript_cache' => 24, 'alt_profile' => 0, 'alt_profile2' => 0, 'bracket' => '', 'alt' => 0, 'url_profile' => 0, 'other_profile' => 0, 'comments' => '', 'comments_profile' => 0, 'metadata' => 1, 'feed' => 'b', 'api' => 1, 'error_message' => $default_error, 'thumbnail' => 2 );
			$changed = true;
		}
	}

	// Set current version level. Because this can be used to detect version changes (and to what extent), this
	// information may be useful in future upgrades
	if ( $options[ 'current_version' ] != youtube_embed_version ) {
		$options[ 'current_version' ] = youtube_embed_version;
		$changed = true;
	}

	// Because of upgrading, check each option - if not set, apply default
	if ( !array_key_exists( 'editor_button', $options ) ) { $options[ 'editor_button' ] = 1; $changed = true; }
	if ( !array_key_exists( 'admin_bar', $options ) ) { $options[ 'admin_bar' ] = 1; $changed = true; }
	if ( !array_key_exists( 'profile_no', $options ) ) { $options[ 'profile_no' ] = 5; $changed = true; }
	if ( !array_key_exists( 'list_no', $options ) ) { $options[ 'list_no' ] = 5; $changed = true; }
	if ( !array_key_exists( 'info_cache', $options ) ) { $options[ 'info_cache' ] = 1; $changed = true; }
	if ( !array_key_exists( 'embed_cache', $options ) ) { $options[ 'embed_cache' ] = 24; $changed = true; }
	if ( !array_key_exists( 'transcript_cache', $options ) ) { $options[ 'transcript_cache' ] = 24; $changed = true; }
	if ( !array_key_exists( 'alt_profile', $options ) ) { $options[ 'alt_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'alt_profile2', $options ) ) { $options[ 'alt_profile2' ] = 0; $changed = true; }
	if ( !array_key_exists( 'url_profile', $options ) ) { $options[ 'url_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'other_profile', $options ) ) { $options[ 'other_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'comments_profile', $options ) ) { $options[ 'comments_profile' ] = 0; $changed = true; }
	if ( !array_key_exists( 'metadata', $options ) ) { $options[ 'metadata' ] = 1; $changed = true; }
	if ( !array_key_exists( 'feed', $options ) ) { $options[ 'feed' ] = 'b'; $changed = true; }
	if ( !array_key_exists( 'api', $options ) ) { $options[ 'api' ] = 1; $changed = true; }
	if ( !array_key_exists( 'error_message', $options ) ) { $options[ 'error_message' ] = $default_error; $changed = true; }
	if ( !array_key_exists( 'thumbnail', $options ) ) { $options[ 'thumbnail' ] = 2; $changed = true; }

	// Update the options, if changed, and return the result
	if ( $changed ) { update_option( 'youtube_embed_general', $options ); }
	return $options;
}

/**
* Function to set YouTube profile options
*
* Looks up profile options, based on passed profile numer.
* If none exist, or some are missing, set default values
*
* @since	2.0
*
* @param    string	$profile	Profile number
* @return   string				Options array
*/

function ye_set_profile_defaults( $profile ) {
	if ( $profile == 0 ) {
		$profname = 'Default';
	} else {
		$profname = 'Profile ' . $profile;
	}
	$options = get_option( 'youtube_embed_profile' . $profile );
	$changed = false;
	$new_user = false;


	// Work out default dimensions
	if ( isset( $GLOBALS[ 'content_width' ] ) ) {
		$width = $GLOBALS[ 'content_width' ];
	} else {
		$width = 560;
	}
	$height = round( ( $width / 16 ) * 9, 0 );

	if ( !is_array( $options ) ) {
		if ( ( $profile == 0 ) && ( get_option( 'youtube_embed' ) ) ) {
			// If the old options exist, import them and then delete them
			$old_opts = get_option( 'youtube_embed' );
			$options = $old_opts;
			delete_option( 'youtube_embed' );
			$changed = true;
		} else {
			// If array doesn't exist, set defaults
			$options = array( 'width' => $width, 'height' => $height, 'fullscreen' => '', 'template' => '%video%', 'autoplay' => '', 'start' => '0', 'loop' => '', 'cc' => '', 'annotation' => '1', 'related' => '', 'info' => '1', 'link' => '1', 'react' => '1', 'stop' => '0', 'sweetspot' => '1', 'type' => 'v', 'disablekb' => '', 'autohide' => '2', 'controls' => '1', 'playlist' => 'v', 'fallback' => 'v', 'wmode' => 'opaque', 'shadow' => '0', 'audio' => '', 'hd' => '1', 'style' => '', 'color' => 'red', 'theme' => 'dark', 'https' => '0' );
			$changed = true;
		}
	}

	// Because of upgrading, check each option - if not set, apply default
	if ( !array_key_exists( 'name', $options ) ) { $options[ 'name' ] = $profname; $changed = true; }
	if ( !array_key_exists( 'width', $options ) ) {
		$option[ 'width' ] = $width;
		$options[ 'height' ] = $height;
		$changed = true;
	}
	if ( !array_key_exists( 'height', $options ) ) { $options[ 'height' ] = '340'; $changed = true; }
	if ( !array_key_exists( 'annotation', $options ) ) { $options[ 'annotation' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'info', $options ) ) { $options[ 'info' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'link', $options ) ) { $options[ 'link' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'react', $options ) ) { $options[ 'react' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'sweetspot', $options ) ) { $options[ 'sweetspot' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'type', $options ) ) { $options[ 'type' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'link', $options ) ) { $options[ 'link' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'react', $options ) ) { $options[ 'react' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'sweetspot', $options ) ) { $options[ 'sweetspot' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'autohide', $options ) ) { $options[ 'autohide' ] = '2'; $changed = true; }
	if ( !array_key_exists( 'controls', $options ) ) { $options[ 'controls' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'playlist', $options ) ) { $options[ 'playlist' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'fallback', $options ) ) { $options[ 'fallback' ] = 'v'; $changed = true; }
	if ( !array_key_exists( 'wmode', $options ) ) { $options[ 'wmode' ] = 'opaque'; $changed = true; }
	if ( !array_key_exists( 'shadow', $options ) ) { $options[ 'shadow' ] = '0'; $changed = true; }
	if ( !array_key_exists( 'template', $options ) ) { $options[ 'template' ] = '%video%'; $changed = true; }
	if ( !array_key_exists( 'hd', $options ) ) { $options[ 'hd' ] = '1'; $changed = true; }
	if ( !array_key_exists( 'color', $options ) ) { $options[ 'color' ] = 'red'; $changed = true; }
	if ( !array_key_exists( 'theme', $options ) ) { $options[ 'theme' ] = 'dark'; $changed = true; }

	// Update the options, if changed, and return the result
	if ( $changed ) { update_option( 'youtube_embed_profile' . $profile, $options ); }

	// Remove added slashes from template XHTML
	$options[ 'template' ] = stripslashes( $options[ 'template' ] );

	return $options;
}

/**
* Function to set default list options
*
* Looks up list options, based on passed list number.
* If none exist, or some are missing, set default values
*
* @since	2.0
*
* @param    string	$list		List number
* @return   string				Options array
*/

function ye_set_list_defaults( $list ) {
	$options = get_option( 'youtube_embed_list' . $list );
	$changed = false;

	// If array doesn't exist, set defaults
	if ( !is_array( $options ) ) {
		$options = array( 'name' => 'List ' . $list, 'list' => '' );
		$changed = true;
	}

	// Because of upgrading, check each option - if not set, apply default
	if ( !array_key_exists( 'name',$options ) ) { $options[ 'name' ] = 'List ' . $list; $changed = true; }
	if ( !array_key_exists( 'list',$options ) ) { $options[ 'list' ] = ''; $changed = true; }

	// Update the options, if changed, and return the result
	if ( $changed ) { update_option( 'youtube_embed_list' . $list, $options ); }
	return $options;
}
?>