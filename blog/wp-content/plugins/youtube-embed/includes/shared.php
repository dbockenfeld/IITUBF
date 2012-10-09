<?php
/**
* Shared Functions
*
* Small utilities shared by a number of other functions
*
* @package	YouTubeEmbed
*/

/**
* Extract parameters (1.0)
*
* Function to extract parameters from an input string
*
* @since	2.0
*
* @param	string	$input		Input string to search through
* @param	string	$para		Parameter to look for
* @return	string				Parameter value (if found)
*/

function ye_get_parameters( $input, $para ) {

	$start = strpos( strtolower( $input ), $para . '=' );
	$content = '';

	if ( $start !== false ) {
		$start = $start + strlen( $para ) + 1;
		$end=strpos( strtolower( $input ), '&', $start );
		if ( $end !== false ) { $end = $end - 1; } else { $end = strlen( $input ); }
		$content = substr( $input, $start, $end - $start + 1 );
	}

	return $content;
}

/**
* Extract a video ID
*
* Function to extract an ID if a full URL has been supplied
*
* @since	2.0
*
* @param	string	$id		Video ID
* @return	string			Extracted ID
*/

function ye_extract_id( $id ) {

	$id = trim( strip_tags( $id ) );

	// Check if it's the full URL, as found in address bar
	$video_pos = strpos( $id, 'youtube.com/watch?', 0 );

	if ( $video_pos !== false ) {
		$video_pos = $video_pos + 20;
		$ampersand_pos = strpos( $id, '&', $video_pos );
		if ( !$ampersand_pos ) {
			$id = substr( $id, $video_pos );
		} else {
			$id = substr( $id, $video_pos, $ampersand_pos - $video_pos );
		}

	} else {

		// Now check to see if it's a full URL, as used in the embed code
		// Need to check both video and playlist formats
		$video_pos = strpos( $id, 'youtube.com/v/' );
		if ($video_pos === false) { $video_pos = strpos( $id, 'youtube.com/p/' ); }

		if ( $video_pos !== false ) {
			$video_pos = $video_pos + 14;
			$qmark_pos = strpos( $id, '?', $video_pos );
			if ( !$qmark_pos ) {
				$id = substr( $id, $video_pos );
			} else {
				$id = substr( $id, $video_pos, $qmark_pos - $video_pos );
			}

		} else {

			// Check if it's a shortened URL
			$video_pos = strpos( $id, 'youtu.be/', 0 );

			if ( $video_pos !== false ) {
				$video_pos = $video_pos + 9;
				$ampersand_pos = strpos( $id, '&', $video_pos );
				if ( !$ampersand_pos ) {
					$id = substr( $id, $video_pos );
				} else {
					$id = substr( $id, $video_pos, $ampersand_pos - $video_pos );
				}
			}
		}
	}

	// Convert video ID characters
	$id = str_replace( '&#8211;', '--', $id );
	$id = str_replace( '&#215;', 'x', $id );

	return $id;
}

/**
* Validate video type
*
* Function to work out what type of video has been requested and
* whether it is valid. Also fetches the video title.
*
* @since	2.0
*
* @param	string	$id				Video ID
* @param	string	$title_needed	Whether the title requires extracting
* @return	string					Array containing file details
*/

function ye_validate_id( $id, $title_needed = false ) {

	$type = false;
	$title = false;
	$options = false;

	$options = ye_set_general_defaults();

	// Attempt to get the video type and title from cache
	if ( $general[ 'info_cache' ] != 0 ) {
		$type = get_transient( 'ye_type_' . $id );
		$title = get_transient( 'ye_title_' . $id );
	}

	// Check if items are cached
	$cache = true;
	if ( ( !$type ) or ( !$title ) ) { $cache = false; }

	// Get video information if not cached
	if ( !$cache ) {

		$type = '-';

		if ( $options [ 'api' ] != 0 ) {

			if ( ( $options[ 'api' ] == 2 ) or ( $options[ 'api' ] == 4 ) ) { $https = 's'; } else { $https = ''; }

			// Check with YouTube API as to whether the ID is a video
			$id_check = ye_get_file( 'http' . $https . '://gdata.youtube.com/feeds/api/videos/' . $id . '?v=2', false );
			if ( $id_check[ 'rc' ] == 0 ) {
				if ( $id_check[ 'response' ] != 200 ) {

					// Check with YouTube API as to whether the ID is a playlist
					$id_check = ye_get_file( 'http' . $https . '://gdata.youtube.com/feeds/api/playlists/' . $id . '?v=2', false );
					if ( $id_check[ 'rc' ] == 0 ) {
						if ( $id_check[ 'response' ] != 200 ) {
							$type = '';
						} else {
							$type = 'p';
						}
					}
				} else {
					$type = 'v';
				}
			}
		}

		// If no type has been assigned then an API error must have occured
		if ( $type == '-' ) {

			if ( ( $options[ 'api' ] == 1 ) or ( $options[ 'api' ] == 2 ) ) {
				// If reporting API errors, output it
				$type = 'An error occurred accessing the YouTube API for video ID ' . $id . ' - ' . $id_check[ 'error' ];
			} else {
				// If not reporting errors or API switched off, work out whether a video or playlist
				$type = '';
				if ( strlen( $id ) == 11 ) {
					$type = 'v';
				} else {
					if ( strlen( $id ) == 16 ) {
						$type = 'p';
					}
				}
			}
		}

		// Update the cache
		set_transient( 'ye_type_' . $id, $type, $options[ 'info_cache' ] * 3600 );

		// If the video is valid extract the title from the XML
		if ( ( $title_needed) && ( $id_check[ 'file' ] != '' ) ) {

			// Find title in XML
			$tag_start = strpos( $id_check[ 'file' ], '<title>', 1 );
			if ( $tag_start !== false ) {
				$tag_end = strpos( $id_check[ 'file' ], '</title>', $tag_start );
				if ( $tag_end !== false ) {
					$title = substr( $id_check[ 'file' ], $tag_start + 7, $tag_end - $tag_start + 6 );
				}
			}

			// Update the cache
			set_transient( 'ye_title_' . $id, $title, $options[ 'info_cache' ] * 3600 );
		}
	}

	if ( !$title_needed ) { return $type; }

	$return[ 'type' ] = $type;
	$return[ 'title' ] = $title;
	return $return;
}

/**
* Function to report an error
*
* Display an error message in a standard format
*
* @since	2.0
*
* @param	string	$errorin	Error message
* @return	string				Error output
*/

function ye_error( $errorin ) {

	return '<p style="color: #f00; font-weight: bold;">Artiss YouTube Embed: ' . $errorin . "</p>\n";

}

/**
* Convert input to a 1 or 0 equivalent
*
* Function to convert a Yes or No input to an equivalent 1 or 0 output
*
* @since	2.0
*
* @uses		ye_yes_or_no		Convert input to a true or false equivalent
*
* @param	string	$input		Input, usually Yes or No
* @return	string				1, 0 or blank, depending on input
*/

function ye_convert( $input ) {

	$input = ye_yes_or_no( $input );
	$output = '';
	if ( $input === true ) { $output = '1'; }
	if ( $input === false ) { $output = '0'; }

	return $output;
}

/**
* Convert input to a 1 or 3 equivalent
*
* Function to convert a Yes or No input to an equivalent 1 or 3 output
*
* @since	2.0
*
* @uses		ye_yes_or_no		Convert input to a true or false equivalent
*
* @param	string	$input		Input, usually Yes or No
* @return   string				1, 3 or blank, depending on input
*/

function ye_convert_3( $input ) {

	$input = ye_yes_or_no( $input );
	$output = '';
	if ( $input === true ) { $output = '1'; }
	if ( $input === false ) { $output = '3'; }

	return $output;
}

/**
* Convert input to True or False (1.0)
*
* Return true or false, depending on the input. Possible inputs are Yes, No, 0, 1, True,
* False, On, Off
*
* @since	2.0
*
* @param	string	$input		Value passed for checking
* @return	string				Blank string or boolean true, false
*/

function ye_yes_or_no( $input = '' ) {

	$input = strtolower( $input );
	if ( ( $input === true ) or ( $input == 'true' ) or ( $input == '1' ) or ( $input == 'yes' ) or ( $input == 'on' ) ) { return true; }
	if ( ( $input === false ) or ( $input == 'false' ) or ( $input == '0' ) or ( $input == 'no' ) or ( $input == 'off' ) ) { return false; }

	return;
}

/**
* Fetch a file (1.6)
*
* Use WordPress API to fetch a file and check results
* RC is 0 to indicate success, -1 a failure
*
* @since	2.0
*
* @param	string	$filein		File name to fetch
* @param	string	$header		Only get headers?
* @return	string				Array containing file contents and response
*/

function ye_get_file( $filein, $header = false ) {

	$rc = 0;
	$error = '';
	if ( $header ) {
		$fileout = wp_remote_head( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Header: '.$fileout->get_error_message();
			$rc = -1;
		}
	} else {
		$fileout = wp_remote_get( $filein );
		if ( is_wp_error( $fileout ) ) {
			$error = 'Body: '.$fileout->get_error_message();
			$rc = -1;
		} else {
			if ( isset( $fileout[ 'body' ] ) ) {
				$file_return[ 'file' ] = $fileout[ 'body' ];
			}
		}
	}

	$file_return[ 'error' ] = $error;
	$file_return[ 'rc' ] = $rc;
	if ( !is_wp_error( $fileout ) ) {
		if ( isset( $fileout[ 'response' ][ 'code' ] ) ) {
			$file_return[ 'response' ] = $fileout[ 'response' ][ 'code' ];
		}
	}

	return $file_return;
}

/**
* Function to set embed type
*
* Depending on embed parameters set a value
*
* @since	2.0
*
* @uses		ye_convert			Convert value to a 0 or 1 equivalent
*
* @param	string	$type		Current embed type
* @param	string	$embedplus	Whether EmbedPlus embedding is required
* @return	string				The type of embedding to use
*/

function ye_get_embed_type( $type, $embedplus ) {

	$embedplus = ye_convert( $embedplus );
	$type = strtolower( $type );

	if ( ( $type == 'embedplus' ) or ( $embedplus == '1' ) ) { $type = 'm'; }
	if ( $type == 'iframe' ) { $type = 'v'; }
	if ( $type == 'object' ) { $type = 'p'; }
	if ( $type == 'chromeless' ) { $type = 'c'; }

	return $type;
}

/**
* Convert autohide parameter
*
* Convert autohide text value to a numeric equivalent
*
* @since	2.0
*
* @param	string	$autohide	Autohide parameter value
* @return	string				Autohide numeric equivalent
*/

function ye_set_autohide( $autohide ) {

	$autohide = strtolower( $autohide );
	if ( $autohide == 'no' )	{ $autohide = '0'; }
	if ( $autohide == 'yes' )	{ $autohide = '1'; }
	if ( $autohide == 'fade' )	{ $autohide = '2'; }

	return $autohide;
}

/**
* Generate a profile list
*
* Generate FORM options for the current profiles
*
* @since	2.0
*
* @param	string	$current	The current profile number
* @param	string	$total		The total number of profiles
*/

function ye_generate_profile_list( $current, $total ) {

	echo '<option value="0"';
	if ( $current == "0" ) { echo " selected='selected'"; }
	echo ' >'.__('Default').'</option>';
	$loop = 1;
	while ( $loop <= $total ) {

		$profiles = get_option( 'youtube_embed_profile' . $loop );
		$profname = $profiles[ 'name' ];

		if ( $profname == '' ) { $profname = "Profile " . $loop; }
        if ( strlen( $profname ) > 30 ) { $profname = substr( $profname, 0, 30 ) . '&#8230;'; }
		echo '<option value="' . $loop . '"';

		if ( $current == $loop ) { echo " selected='selected'"; }
		echo '>' . __( $profname ) . "</option>\n";

		$loop ++;
	}

	return;
}
?>