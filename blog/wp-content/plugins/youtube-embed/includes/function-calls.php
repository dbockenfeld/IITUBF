<?php
/**
* Function Calls
*
* Various function calls that the user may call directly
*
* @package	YouTubeEmbed
*/

/**
* Embed a YouTube video
*
* Write out XHTML to embed a YouTube video
*
* @since	2.0
*
* @uses		ye_get_parameters			Extract parameters from input
* @uses		ye_get_embed_type			Work out the correct embed type to use
* @uses		ye_set_autohide				Set correct autohide parameter
* @uses		ye_generate_youtube_code	Generate the YouTube code
*
* @param    string	$content	YouTube video ID
* @param 	string	$paras		List of parameters
* @param	string	$style		Optional CSS
*/

function youtube_video_embed( $content, $paras = '', $style = '' ) {
	$width = ye_get_parameters( $paras, 'width' );
	$height = ye_get_parameters( $paras, 'height' );
	$fullscreen = ye_get_parameters( $paras, 'fullscreen' );
	$related = ye_get_parameters( $paras, 'related' );
	$autoplay = ye_get_parameters( $paras, 'autoplay' );
	$loop = ye_get_parameters( $paras, 'loop' );
	$start = ye_get_parameters( $paras, 'start' );
	$info = ye_get_parameters( $paras, 'info' );
	$annotation = ye_get_parameters( $paras, 'annotation' );
	$cc = ye_get_parameters( $paras, 'cc' );
	$link = ye_get_parameters( $paras, 'link' );
	$react = ye_get_parameters( $paras, 'react' );
	$stop = ye_get_parameters( $paras, 'stop' );
	$sweetspot = ye_get_parameters( $paras, 'sweetspot' );
	$embedplus = ye_get_parameters( $paras, 'embedplus' );
	$disablekb = ye_get_parameters( $paras, 'disablekb' );
	$ratio = ye_get_parameters( $paras, 'ratio' );
	$autohide = ye_get_parameters( $paras, 'autohide' );
	$controls = ye_get_parameters( $paras, 'controls' );
	$type = ye_get_parameters( $paras, 'type' );
	$profile = ye_get_parameters( $paras, 'profile' );
	$list = ye_get_parameters( $paras, 'list' );
	$audio = ye_get_parameters( $paras, 'audio' );
	$template = ye_get_parameters( $paras, 'template' );
	$hd = ye_get_parameters( $paras, 'hd' );
	$color = ye_get_parameters( $paras, 'color' );
	$theme = ye_get_parameters( $paras, 'theme' );
	$https = ye_get_parameters( $paras, 'https' );

	// Get Embed type
	$type = ye_get_embed_type( $type, $embedplus );

	// Set up Autohide parameter
	$autohide = ye_set_autohide( $autohide );

	echo ye_generate_youtube_code( $content, $type, $width, $height, ye_convert( $fullscreen ), ye_convert( $related ), ye_convert( $autoplay ), ye_convert( $loop ), $start, ye_convert( $info ), ye_convert_3( $annotation ), ye_convert( $cc ), $style, ye_convert( $link ), ye_convert( $react ), $stop, ye_convert( $sweetspot ), ye_convert( $disablekb ), $ratio, $autohide, ye_convert( $controls ), $profile, $list, ye_convert( $audio ), $template, ye_convert( $hd ), $color, $theme, $https );
	return;
}

/**
* Display a video thumbnail
*
* Display a thumbnail of a video
*
* @since	2.0
*
* @uses		ye_get_parameters			Extract parameters from a string
* @uses		ye_generate_thumbnaik_code	Get the thumbnail code
*
* @param    string		$content		YouTube video ID
* @param    string		$paras			Parameters
* @param    string		$style			CSS information
* @param    string		$alt			Alt text
*/

function youtube_thumb_embed( $content, $paras = '', $style = '', $alt = '' ) {

	$class = ye_get_parameters( $paras, 'class' );
	$rel = ye_get_parameters( $paras, 'rel' );
	$target = ye_get_parameters( $paras, 'target' );
	$width = ye_get_parameters( $paras, 'width' );
	$height = ye_get_parameters( $paras, 'height' );
	$version = ye_get_parameters( $paras, 'version' );

	echo ye_generate_thumbnail_code( $content, $style, $class, $rel, $target, $width, $height, $alt, $version );

	return;
}

/**
* Return video short URL
*
* Return a short URL for the YouTube video
*
* @since	2.0
*
* @uses		ye_generate_shorturl_code	Display an error
*
* @param    string		$id				YouTube video ID
* @return	string						Download URL
*/

function youtube_short_url( $id ) {
	return ye_generate_shorturl_code( $id );
}

/**
* Get video download URL
*
* Return a URL for the video so that it can be downloaded
*
* @since	2.0
*
* @uses		ye_generate_download_code	Get the download URL
*
* @param    string		$id				YouTube video ID
* @return	string						Download URL
*/

function get_video_download( $id ) {
	return ye_generate_download_code( $id );
}

/**
* Get XML transcript
*
* Return XML formatted YouTube transcript
*
* @since	2.0
*
* @uses		ye_error					Output an error
* @uses		ye_extract_id				Extract a video ID
* @uses		ye_get_file					Get a file
* @uses		ye_validate_id				Check the video ID is valid
*
* @param    string		$id				YouTube video ID
* @return	string						Transcript file in XML format
*/

function get_youtube_transcript_xml ( $id ) {

	// Extract the ID if a full URL has been specified
	$id = ye_extract_id( $id );

	// Check what type of video it is and whether it's valid
	$embed_type = ye_validate_id( $id );
	if ( $embed_type != 'v' ) {
		if ( strlen( $embed_type ) > 1 ) {
			echo ye_error( $embed_type );
		} else {
			echo ye_error( 'The YouTube ID of ' . $id . ' is invalid.' );
		}
		return;
	}

	// Get transcript file
	$filename = 'http://video.google.com/timedtext?lang=en&v=' . $id;
	$xml = ye_get_file( $filename );

	// Check success and return appropriate output
	if ( $xml[ 'rc' ] > 0 ) {
		echo ye_error( 'Could not fetch the transcript file ' . $filename . '.' );
		return;
	} else {
		return $xml;
	}
}

/**
* Get transcript
*
* Return XHTML formatted YouTube transcript
*
* @since	2.0
*
* @uses		ye_generate_generatE_transcript		Generate the transcript output
*
* @param    string		$id						YouTube video ID
* @return	string								Transcript file in XHTML format
*/

function get_youtube_transcript( $id ) {
	return ye_generate_transcript( $id );
}

/**
* Get Video Name
*
* Function to return the name of a YouTube video
*
* @since	2.0
*
* @uses		ye_extract_id				Extract the video ID
* @uses		ye_validate_id				Get the name and video type
* @uses		ye_error					Return an error
*
* @param    string		$id				Video ID
* @return   string						Video name
*/

function get_youtube_name( $id ) {

	// Extract the ID if a full URL has been specified
	$id = ye_extract_id( $id );

	// Check what type of video it is and whether it's valid
	$return = ye_validate_id( $id, true );
	$embed_type = $return[ 'type' ];
	if ( strlen( $embed_type ) > 1 ) {
		echo ye_error( $embed_type );
	} else {
		echo ye_error( 'The YouTube ID of ' . $id . ' is invalid.' );
	}

	// Return the video title
	return $return['title'];
}
?>