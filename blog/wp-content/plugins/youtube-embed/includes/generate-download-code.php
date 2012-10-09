<?php
/**
* Generate Download Code
*
* Create code to allow a YouTube video to be downloaded
*
* @package	YouTubeEmbed
* @since	2.0
*
* @uses		ye_extract_id				Extract an ID from a string
* @uses		ye_validate_id				Confirm the type of video
* @uses		ye_error					Display an error
*
* @param    string	$id					YouTube video ID
* @param 	string	$target				Link target
* @param 	string	$nofollow			Use rel="nofollow" ?
* @param 	string	$text				Text to add link to
* @return	string						URL
*/

function ye_generate_download_code( $id ) {

	if ( $id == '' ) { return ye_error( 'No YouTube ID was found.' ); }

	// Extract the ID if a full URL has been specified
	$id = ye_extract_id( $id );

	// Check what type of video it is and whether it's valid
	$embed_type = ye_validate_id( $id );
	if ( $embed_type != 'v' ) {
		if ( strlen( $embed_type ) > 1 ) {
			return ye_error( $embed_type );
		} else {
			return ye_error( 'The YouTube ID of ' . $id . ' is invalid.' );
		}
	}

	// Create the link
	return 'http://www.savevid.com/?url=http://www.youtube.com/watch?' . $embed_type . '=' . $id;
}
?>