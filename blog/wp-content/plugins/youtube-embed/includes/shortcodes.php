<?php
/**
* Shortcodes
*
* Define the various shortcodes
*
* @package	YouTubeEmbed
* @since	2.0
*/

/**
* Default Video shortcode
*
* Main [youtube] shortcode to display video
*
* @since	2.0
*
* @uses		ye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function ye_video_shortcode_default( $paras = '', $content = '' ) {
	return ye_video_shortcode( $paras, $content );
}
add_shortcode( 'youtube', 'ye_video_shortcode_default' );

/**
* Alternative Video shortcode 1
*
* 1st alternative shortcode to display video
*
* @since	2.0
*
* @uses		ye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function ye_video_shortcode_alt1( $paras = '', $content = '' ) {
	return ye_video_shortcode( $paras, $content, '', 1 );
}
$shortcode = ye_set_shortcode_option();
if ( $shortcode[ 1 ] != '' ) { add_shortcode( $shortcode[ 1 ], 'ye_video_shortcode_alt1' ); }

/**
* Alternative Video shortcode 2
*
* 2nd alternative shortcode to display video
*
* @since	2.0
*
* @uses		ye_video_shortcode			Action the shortcode parameters
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube embed code
*/

function ye_video_shortcode_alt2( $paras = '', $content = '' ) {
	return ye_video_shortcode( $paras, $content, '', 2 );
}
if ( $shortcode[ 2 ] != '' ) { add_shortcode( $shortcode[ 2 ], 'ye_video_shortcode_alt2' ); }

/**
* Video shortcode
*
* Use shortcode parameters to embed a YouTube video or playlist
*
* @since	2.0
*
* @uses		ye_get_embed_type			Get the embed type
* @uses		ye_set_autohide				Get the autohide parameter
* @uses		ye_generate_youtube_code	Generate the embed code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @param	string		$alt_shortcode	The number of the alternative shortcode used
* @return   string						YouTube embed code
*/

function ye_video_shortcode( $paras = '', $content = '', $callback = '', $alt_shortcode = '' ) {

	extract( shortcode_atts( array( 'type' => '', 'width' => '', 'height' => '', 'fullscreen' => '', 'related' => '', 'autoplay' => '', 'loop' => '', 'start' => '', 'info' => '', 'annotation' => '', 'cc' => '', 'style' => '', 'link' => '', 'react' => '', 'stop' => '', 'sweetspot' => '', 'disablekb' => '', 'ratio' => '', 'autohide' => '', 'controls' => '', 'profile' => '', 'embedplus' => '', 'audio' => '', 'id' => '', 'url' => '', 'rel' => '', 'fs' => '', 	'cc_load_policy' => '', 'iv_load_policy' => '', 'showinfo' => '', 'youtubeurl' => '', 'template' => '', 'list' => '', 'hd' => '', 'color' => '', 'theme' => '', 'https' => '', 'height' => '', 'width' => '' ), $paras ) );

	// If no profile specified and an alternative shortcode used, get that shortcodes default profile
	if ( ( $profile == '' ) && ( $alt_shortcode != '' ) ) {
		// Profile is now blank or 2
		if ( $alt_shortcode == '1' ) { $alt_shortcode = ''; }
		// Get general options
		$options = ye_set_general_defaults();
		$profile = $options[ 'alt_profile'.$alt_shortcode ];
	}

	// If an alternative field is set, use it
	if ( ( $id != '' ) && ( $content == '' ) ) { $content = $id; }
	if ( ( $url != '' ) && ( $content == '' ) ) { $content = $url; }
	if ( ( $youtubeurl != '' ) && ( $content == '' ) ) { $content = $youtubeurl; }

    if ( ( $h != '' ) && ( $height == '' ) ) { $height = $h; }
    if ( ( $w != '' ) && ( $width == '' ) ) { $width = $w; }

	if ( ( $rel != '' ) && ( $related == '' ) ) { $related = $rel;}
	if ( ( $fs != '' ) && ( $fullscreen == '' ) ) { $fullscreen = $fs;}
	if ( ( $cc_load_policy != '' ) && ( $cc == '' ) ) { $cc = $cc_load_policy;}
	if ( ( $iv_load_policy != '' ) && ( $annotation == '' ) ) { $annotation = $iv_load_policy;}
	if ( ( $showinfo != '' ) && ( $info == '' ) ) { $info = $showinfo;}

	// If ID was not passed in the content and the first parameter is set, assume that to be the ID
	if ( ( $content == '' ) && ( $paras[ 0 ] != '' ) ) {
		$content = $paras[ 0 ];
		if  ( (substr( $content, 0, 1 ) == ":" ) or ( substr( $content, 0, 1 ) == "=" ) ) { $content = substr( $content, 1 ); }
		if ( $paras[ 1 ] != '' ) { $width = $paras[ 1 ]; }
		if ( $paras[ 2 ] != '' ) { $height = $paras[ 2 ]; }
	}

	// Get Embed type
	$type = ye_get_embed_type( $type, $embedplus );

	// Set up Autohide parameter
	$autohide = ye_set_autohide( $autohide );

	// Create YouTube code
	$youtube_code = ye_generate_youtube_code( $content, $type, $width, $height, ye_convert( $fullscreen ), ye_convert( $related ), ye_convert( $autoplay ), ye_convert( $loop ), $start, ye_convert( $info ), ye_convert_3( $annotation ), ye_convert( $cc ), $style, ye_convert( $link ), ye_convert( $react ), $stop, ye_convert( $sweetspot ), ye_convert( $disablekb ), $ratio, $autohide, ye_convert( $controls ), $profile, $list, ye_convert( $audio ), $template, ye_convert( $hd ), $color, $theme, ye_convert( $https ) );

	return $youtube_code;
}

/**
* Return a thumbnail URL
*
* Shortcode to return the URL for a thumbnail
*
* @since	2.0
*
* @uses		ye_generate_thumbnail_code	Generate the thumbnail code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube thumbnail code
*/

function ye_thumbnail_sc( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'style' => '', 'class' => '', 'rel' => '', 'target' => '', 'width' => '', 'height' => '', 'alt' => '', 'version' => '' ), $paras ) );
	return ye_generate_thumbnail_code( $content, $style, $class, $rel, $target, $width, $height, $alt, $version );
}
add_shortcode( 'youtube_thumb', 'ye_thumbnail_sc' );

/**
* Short URL shortcode
*
* Generate a short URL for a YouTube video
*
* @since	2.0
*
* @uses		ye_error					Show an error
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube short URL code
*/

function ye_shorturl_sc( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'id' => '' ), $paras ) );
	return ye_generate_shorturl_code( $id );
}
add_shortcode( 'youtube_url', 'ye_shorturl_sc' );

/**
* Download shortcode
*
* Generate a short URL for a YouTube video
*
* @since	2.0
*
* @uses		ye_generate_download_code	Generate the download code
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						YouTube download link
*/

function ye_video_download( $paras = '', $content = '' ) {
	extract( shortcode_atts( array( 'id' => '', 'target' => '', 'nofollow' => '' ), $paras ) );

	// Return the URL
	$link = ye_generate_download_code( $id );

	// Now add the HTML to the URL (assuming it's not an error)
	if ( substr( $link, 0, 2 ) != '<p' ) {
		$link = '<a href="' . $link . '"';
		if ( $target != '' ) { $link .= ' target="' . $target . '"'; }
		if ( strtolower( $nofollow ) != 'no' ) { $link .= ' rel="nofollow"'; }
		$link .= '>' . $content . '</a>';
	}

	return $link;
}
add_shortcode( 'download_video', 'ye_video_download' );

/**
* Transcript Shortcode
*
* Shortcode to return YouTube transcripts
*
* @since	2.0
*
* @uses		ye_generate_transcript		Generate the transcript
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						Transcript XHTML
*/

function ye_transcript_sc( $paras = '', $content = '' ) {
	return ye_generate_transcript( $content );
}
add_shortcode( 'transcript', 'ye_transcript_sc' );

/**
* Video Name Shortcode
*
* Shortcode to return the name of a YouTube video
*
* @since	2.0
*
* @uses		ye_extract_id				Extract the video ID
* @uses		ye_validate_id				Get the name and video type
* @uses		ye_error					Return an error
*
* @param    string		$paras			Shortcode parameters
* @param	string		$content		Shortcode content
* @return   string						Video name
*/

function ye_video_name_shortcode( $paras = '', $content = '' ) {

	// Extract the ID if a full URL has been specified
	$id = ye_extract_id( $content );

	// Check what type of video it is and whether it's valid
	$return = ye_validate_id( $id, true );
	if ( !$return[ 'type' ] ) { return ye_error( 'The YouTube ID of ' . $id . ' is invalid.' ); }
	if ( strlen( $return[ 'type' ] ) != 1 ) { return ye_error( $return[ 'type' ] ); }

	// Return the video title
	return $return['title'];
}
add_shortcode( 'youtube_name', 'ye_video_name_shortcode' );
?>