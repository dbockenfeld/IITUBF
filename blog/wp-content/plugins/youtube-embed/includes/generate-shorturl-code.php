<?php
/**
* Generate video short URL
*
* Create a short URL to a YouTube video
*
* @package	YouTubeEmbed
* @since	2.0
*
* @uses		ye_extract_id				Extract an ID from a string
* @uses		ye_validate_id				Confirm the type of video
* @uses		ye_error					Display an error
*
* @param    string	$id					YouTube video ID
* @return	string	$youtube_code		Code
*/

function ye_generate_shorturl_code( $id ) {

	// Check that an ID has been specified
	if ( $id == '' ) {
		return ye_error( 'No video ID has been supplied' );
	} else {

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

		return 'http://youtu.be/' . $id;
	}
}
?>