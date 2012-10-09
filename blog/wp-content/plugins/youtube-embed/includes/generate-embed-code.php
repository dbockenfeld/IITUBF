<?php
/**
* Generate embed code
*
* Functions calls to generate the required YouTube code
*
* @package	YouTubeEmbed
*/

/**
* Generate embed code
*
* Generate XHTML compatible YouTube embed code
*
* @since	2.0
*
* @uses		ye_convert_id			Convert special characters in ID
* @uses		ye_error				Display an error
* @uses		ye_extract_id			Get the video ID
* @uses		ye_validate_list		Get the requested listr
* @uses		ye_validate_id			Validate the video ID
* @uses		ye_validate_profile		Get the requested profile
* @uses		ye_set_general_defaults	Get general options
* @uses		ye_set_profile_defaults	Set default profile options
*
* @param	string		$id				Video ID
* @param	string		$type			Embed type
* @param	string		$width			Video width
* @param	string		$height			Video height
* @param	string		$fullscreen		Fullscreen button
* @param	string		$related		Show related info.
* @param	string		$autoplay		Start video automatically
* @param	string		$loop			Loop video to start
* @param	string		$start			Start in seconds
* @param	string		$info			Show video info.
* @param	string		$annotation		Annotations
* @param	string		$cc				Closed captions
* @param	string		$style			Stylesheet information
* @param	string		$link			Link back to YouTube
* @param	string		$react			Show EmbedPlus reactions
* @param	string		$stop			Stop in seconds
* @param	string		$sweetspot		Show EmbedPlus sweetspots
* @param	string		$disablekb		Disable keyboard controls
* @param	string		$ratio			Video size ratio
* @param	string		$autohide		Autohide controls
* @param	string		$controls		Display controls
* @param	string		$profile		Which profile to use
* @param	string		$list_style		How to use a list, if used
* @param	string		$audio			Only show controls, for audio playback
* @param	string		$template		Display template
* @param	string		$hd				Use HD, if available
* @param	string		$color		 	Progress bar colour
* @param	string		$theme			Use dark or light theme
* @param	string		$https			Use HTTPS for links
* @return	string						Code output
*/

function ye_generate_youtube_code( $id = '', $type = '', $width = '', $height = '', $fullscreen = '', $related = '', $autoplay = '', $loop = '', $start = '', $info = '', $annotation = '', $cc = '', $style = '', $link = '', $react = '', $stop = '', $sweetspot = '', $disablekb = '', $ratio = '', $autohide = '', $controls = '', $profile = '', $list_style = '', $audio = '', $template = '', $hd = '', $color = '', $theme = '', $https = '' )  {

	// Ensure an ID is passed
	if ( $id == '' ) { return ye_error( 'No video/playlist ID has been supplied' ); }

	// Get general options
	$general = ye_set_general_defaults();

	// Find the profile, if one is specified
	$profile = ye_validate_profile( $profile, $general[ 'profile_no' ] );

	// Get default values if no values are supplied
	$options = ye_set_profile_defaults( $profile );

	// Check it's not a list
	$playlist_ids = '';
	$list = ye_validate_list( $id, $general[ 'list_no' ] );
	if ( !is_array( $list ) ) {

		// Check if certain parameters are included in the URL
		$width = ye_get_url_para( $id, 'w', $width );
		$height = ye_get_url_para( $id, 'h', $height );

		// Extract the ID if a full URL has been specified
		$id = ye_extract_id( $id );

		// Is it being previewed? In which case remove any cache
		if ( ( preg_match( '/p=([0-9]*)&preview=true/', $_SERVER['QUERY_STRING'] ) == 1 ) && ( $general[ 'preview' ] == 1 ) ) {
			delete_transient( 'ye_type_' . $id );
			delete_transient( 'ye_title_' . $id );
		}

		// Check what type of video it is and whether it's valid
		$return = ye_validate_id( $id, true );
		$title = $return['title'];
		$embed_type = $return[ 'type' ];

		// If the video is invalid, output an appropriate error
		if ( ( $embed_type == '' ) or ( strlen ( $embed_type ) != 1 ) ) {
			if ( $embed_type == '' ) {
				$error = 'The YouTube ID of ' . $id . ' is invalid.';
			} else {
				$error = $embed_type;
			}
			$result = "\n<!-- YouTube Embed v" . youtube_embed_version . " | http://www.artiss.co.uk/artiss-youtube-embed -->\n";
			$result .= "<!-- " . $error . " -->\n" . ye_decode( $general[ 'error_message' ] ) . "\n<!-- End of YouTube Embed code -->\n";
			return $result;
		}

	} else {

		$embed_type = 'v';

		// Randomize the video
		if ( $list_style == 'random' ) { shuffle( $list ); }

		// Extract one video randomly
		if ( $list_style == 'single' ) {
			$id = $list[ array_rand( $list, 1 ) ];

		// Build the playlist
		} else {

			$id = $list [ 0 ];
			$title = '';
			// Build the playlist
			if ( count( $list ) > 1 ) {
				$loop = 1;
				while ( $loop < count( $list ) ) {
					if ( $playlist_ids != '' ) { $playlist_ids .= ','; }
					$list_id = ye_extract_id( $list[ $loop ] );
					$playlist_ids .= $list_id;
					$loop ++;
				}
			}
		}
	}

	// Generate a cache key for the above passed parameters
	$cache_key = 'ye_video_' . base64_encode( sha1( $id . $type . $width . $height . $fullscreen . $related . $autoplay . $loop . $start . $info . $annotation . $cc . $style . $link . $react . $stop . $sweetspot . $disablekb . $ratio . $autohide . $controls . $profile . $list_style . $audio . $template . $hd . $color . $theme . $https . print_r( $general, true ) . print_r( $options, true ) . print_r( $list, true ) ) );

	// Try and get the output from cache. If it exists, return the code
	if ( ( $general[ 'embed_cache' ] != 0 ) && ( !is_feed() ) ) {
		$result = get_transient( $cache_key );
		if ( $result !== false) { return $result; }
	}

	$metadata = $general[ 'metadata' ];

	// Work out correct protocol to use - HTTP or HTTPS
	if ( $https == '' ) { $https = $options[ 'https' ]; }
	if ( $https == 1 ) { $https = 's'; } else { $https = ''; }

	// If this is a feed then display a thumbnail and/or text link to the original video
	if ( is_feed () ) {
		$result = '';
		if ( $playlist_ids != '' ) {
			$result .= '<p>'.__('A video list cannot be viewed within this feed - please view the original content').".</p>\n";
		} else {
			$youtube_url = 'http' . $https . '://www.youtube.com/watch?' . $embed_type . '=' . $id;
			if ( ( $embed_type == 'v' ) && ( $general[ 'feed' ] != 't' ) ) { $result .= '<p><a href="' . $youtube_url . '"><img src="http://img.youtube.com/vi/' . $id . '/' . $general[ 'thumbnail' ] . ".jpg\"></a></p>\n"; }
			if ( ( $general ['feed'] != 'v' ) or ( $embed_type != 'v' ) ) { $result .= '<p><a href="' . $youtube_url . '">' . __( 'Click here</a> to view the video on YouTube' ) . ".</p>\n"; }
		}
		return $result;
	}

	// Only set width and height from defaults if both are missing
	if ( ( $width == '' ) && ( $height == '' ) ) {
		$width = $options[ 'width' ];
		$height = $options[ 'height' ];
	}

	// If values have not been pressed, use the default values
	if ( $fullscreen == '' ) { $fullscreen = $options[ 'fullscreen' ]; }
	if ( $related == '' ) { $related = $options[ 'related' ]; }
	if ( $autoplay == '' ) { $autoplay = $options[ 'autoplay' ]; }
	if ( $loop == '' ) { $loop = $options[ 'loop' ]; }
	if ( $info == '' ) { $info = $options[ 'info' ]; }
	if ( $annotation == '' ) { $annotation = $options[ 'annotation' ]; }
	if ( $cc == '' ) { $cc = $options[ 'cc' ]; }
	if ( $link == '' ) { $link = $options[ 'link' ]; }
	if ( $react == '' ) { $react = $options[ 'react' ]; }
	if ( $sweetspot == '' ) { $sweetspot = $options[ 'sweetspot' ]; }
	if ( $disablekb == '' ) { $disablekb = $options[ 'disablekb' ]; }
	if ( $autohide == '' ) { $autohide = $options[ 'autohide' ]; }
	if ( $controls == '' ) { $controls = $options[ 'controls' ]; }
	if ( $audio == '' ) { $audio = $options[ 'audio' ]; }
	if ( $hd == '' ) { $hd = $options[ 'hd' ]; }
	if ( $style == '' ) { $style = $options[ 'style' ]; }
	if ( $color == '' ) { $color = $options[ 'color' ]; }
	if ( $theme == '' ) { $theme = $options[ 'theme' ]; }

	$wmode = $options[ 'wmode' ];
	$shadow = $options[ 'shadow' ];

	// Build the required template
	if ( $template == '' ) { $template = $options[ 'template' ]; } else { $template = ye_decode( $template ); }
	if ( strpos( $template, '%video%' ) === false ) { $template = '%video%'; }

	// If a multi-play list has been specified and EmbedPlus selected, use fallback embedding method instead
	if ( ( $playlist_ids != '' ) && ( $type == 'm' ) && ( $list_style != 'single' ) ) { $type = $options[ 'fallback' ]; }

	// If looping and no playlist has been generated, add the current ID
	// This is a workaround for the AS3 player which won't otherwise loop
	if ( ( $loop == 1 ) && ( $embed_type != 'p' ) && ( $playlist_ids == '' ) ) { $playlist_ids = $id; }

	// If no type was specified, depending on whether this is a video or playlist, set the specific default
	if ( $type == '' ) {
		if ( $embed_type == 'v' ) {
			$type = $options[ 'type' ];
		} else {
			$type = $options[ 'playlist' ];
		}
	}

	// Set parameters without default values
	if ( $start == '' ) { $start = '0'; }
	if ( $stop == '' ) { $stop = '0'; }

	// If height or width is missing, calculate missing parameter using ratio
	if ( ( ( $width == '' ) or ( $height == '' ) ) && ( ( $width != '' ) or ( $height != '' ) ) ) {
		$ratio_to_use = '';
		if ( $ratio != '' ) {
			// Extract the ratio from the provided string
			$pos = strpos( $ratio, ':', 0 );
			if ( $pos !== false ) {
				$ratio_l = substr( $ratio, 0, $pos );
				$ratio_r = substr( $ratio, $pos + 1 );
				if ( ( is_numeric( $ratio_l ) ) && ( is_numeric( $ratio_r ) ) ) { $ratio_to_use = $ratio_l / $ratio_r; }
			}
		}

		// If no, or invalid, ratio supplied, calculate from the default video dimensions
		if ( $ratio_to_use == '' ) { $ratio_to_use = $options[ 'width' ] / $options[ 'height' ]; }

		// Complete the missing width or height using the ratio
		if ( $width == '' ) { $width = round( $height * $ratio_to_use, 0); }
		if ( $height == '' ) { $height = round( $width / $ratio_to_use, 0); }
	}

	// If audio playback option is set, restrict the height to just show the player toolbar
	if ( $audio == '1' ) { $height = 27; }

	// Set up embed types
	$tab = '';
	$class = 'youtube-player';
	$paras = 'version=3&amp;modestbranding=1';

	$embedplus = false;
	$swf = false;
	$iframe = false;
    $chromeless = false;

	if ( $type != 'v' ) {
		if ( $type == 'm' ) {
			$embedplus = true;
			$tab = "\t";
			$embedheight = $height + 32;
			$class = 'cantembedplus';
			$fallback = $options[ 'fallback' ];
		} else {
            if ( $type == "c" ) {
                $chromeless = true;
            } else {
                $swf = true;
            }
		}
	} else {
        $iframe = true;
	}

	// Generate parameters to add to URL
	if ( $fullscreen == 1 ) { $paras .= '&amp;fs=1'; } else { $paras .= '&amp;fs=0'; }
	if ( $related != 1 ) { $paras .= '&amp;rel=0'; }
	if ( $autoplay == 1 ) { $paras .= '&amp;autoplay=1'; $paras_ep .= '&amp;autoplay=1'; }
	if ( $loop == 1 ) { $paras .= '&amp;loop=1'; }
	if ( $info == 1 ) { $paras .= '&amp;showinfo=1'; }
	if ( $annotation != 1 ) { $paras .= '&amp;iv_load_policy=3'; }
	if ( $cc == 1 ) { $paras .= '&amp;cc_load_policy=1'; }
	if ( $disablekb == 1 ) { $paras .= '&amp;disablekb=1'; }
	if ( $autohide != 2 ) { $paras .= '&amp;autohide=' . $autohide; }
	if ( $controls != 1 ) { $paras .= '&amp;controls=0'; }
	if ( strtolower( $color ) != 'red' ) { $paras .= '&amp;color=' . strtolower( $color ); }
	if ( strtolower( $theme ) != 'dark' ) { $paras .= '&amp;theme=' . strtolower( $theme ); }

	// If not a playlist, add the playlist parameter
	if ( $playlist_ids != '' ) { $paras .= '&amp;playlist=' . $playlist_ids; }

	// Generate EmbedPlus parameters
	$paras_ep = '&amp;width=' . $width . '&amp;height=' . $height;
	if ( $react != 1 ) { $paras_ep .= '&amp;react=0'; }
	if ( $sweetspot != 1 ) { $paras_ep .= '&amp;sweetspot=0'; }
	if ( $hd == 1 ) { $paras_ep .= '&amp;hd=1'; }

	// Add start & stop parameters
	if ( $start != 0 ) { $paras .= '&amp;start=' . $start; $paras_ep .= '&amp;start=' . $start; }
	if ( $stop != 0 ) { $paras_ep .= '&amp;stop=' . $stop; }

	$result = '';

	// Add EmbedPlus code
	if ( $embedplus ) {
		$result .= "<object type=\"application/x-shockwave-flash\" width=\"" . $width . "\" height=\"" . $embedheight . "\" data=\"http://getembedplus.com/embedplus.swf\" style=\"" . $style . "\" id=\"" . uniqid( 'ep_', true ) . "\">\n";
		$result .= "\t<param value=\"http://getembedplus.com/embedplus.swf\" name=\"movie\" />\n";
		$result .= "\t<param value=\"high\" name=\"quality\" />\n";
		$result .= "\t<param value=\"" . $wmode . "\" name=\"wmode\" />\n";
		$result .= "\t<param value=\"always\" name=\"allowscriptaccess\" />\n";
		if ( $fullscreen == 1 ) { $result .= "\t<param name=\"allowFullScreen\" value=\"true\" />\n"; }
		$result .= "\t<param name=\"flashvars\" value=\"ytid=" . $id . $paras_ep . "\" />\n";
	}

	// Add AS3 YouTube embed code
	if ( ( $swf ) or ( $chromeless ) or ( ( $embedplus ) && ( ( $fallback == 'o' ) or ( $fallback == 'p' ) ) ) ) {

        if ( $chromeless ) {
            $url_start = 'http' . $https . '://www.youtube.com/apiplayer?video_id=' . $id . '&';
        } else {
            $url_start = 'http' . $https . '://www.youtube.com/' . $embed_type . '/' . $id . '?';
        }

		$result .= $tab . "<object class=\"" . $class . "\" type=\"application/x-shockwave-flash\" data=\"" . $url_start . $paras . "\" width=\"" . $width . "\" height=\"" . $height . "\" style=\"" . $style . "\"";

		if ( $metadata != 0 ) { $result .= " rel=\"media:video\" resource=\"http" . $https . "://www.youtube.com/" . $embed_type . "/" . $id ."\" xmlns:media=\"http://search.yahoo.com/searchmonkey/media/\""; }
		$result .= ">\n";
		if ( $metadata != 0 ) { $result .= $tab . "\t<a rel=\"media:thumbnail\" href=\"http://img.youtube.com/vi/" . $id . "/default.jpg\" />\n"; }
		$result .= $tab . "\t<param name=\"movie\" value=\"http" . $https . "://www.youtube.com/" . $embed_type . "/" . $id . "?" . $paras . "\" />\n";
		$result .= $tab . "\t<param name=\"wmode\" value=\"" . $wmode . "\" />\n";
		if ( $fullscreen == 1 ) { $result .= $tab . "\t<param name=\"allowFullScreen\" value=\"true\" />\n"; }
		if ( ( $link != 1 ) && ( $link != '' ) ) { $result .= $tab . "\t<param name=\"allowNetworking\" value=\"internal\" />\n"; }
		if ( ( $metadata != 0 ) && ( $title != '' ) ) { $result .= $tab . "\t<span property=\"media:title\" content=\"" . htmlentities( $title ) . "\" />\n"; }
		$result .= $tab . "</object>\n";
	}

	// Add IFRAME embed code
	if ( ( $iframe ) or ( ( $embedplus ) && ( $fallback == "v" ) ) ) {
		if ( $embed_type == "p" ) { $playlist_para = "p/"; } else { $playlist_para = ''; }
		$result .= $tab . '<iframe style="border: 0;' . $style . '" class="' . $class . '" width="' . $width . '" height="' . $height . '" src="http' . $https . '://www.youtube.com/embed/' . $playlist_para . $id . '?' . $paras . '&amp;wmode=' . $wmode . '"';
		if ( $fullscreen == 1 ) { $result .= ' allowfullscreen="allowfullscreen"'; }
		$result .= "></iframe>\n";
	}

	// If using EmbedPlus, add the OBJECT closure tag
	if ( $embedplus ) { $result .= "</object>\n<!--[if lte IE 6]> <style type=\"text/css\">.cantembedplus{display:none;}</style><![endif]-->\n"; }

	// Add drop shadow
	if ( ( is_numeric( $shadow ) ) && ( $shadow != 0 ) ) { $result .= "<br/><img src=\"" . plugins_url() . "/youtube-embed/images/shadow.png\" alt=\"\" title=\"\" height=\"" . $shadow . "\" width=\"" . $width . "\" />\n"; }

	// Now apply the template to the result
	$result = str_replace( '%video%', $result, $template );

	// Now add a commented header and trailer
	$result = "\n<!-- YouTube Embed v" . youtube_embed_version . " | http://www.artiss.co.uk/artiss-youtube-embed -->\n" . $result;
	$result .= "<!-- End of YouTube Embed code -->\n";

	// Cache the output
	if ( $general[ 'embed_cache' ] != 0 ) { set_transient( $cache_key, $result, 3600 * $general[ 'embed_cache' ] );	}

	return $result;
}

/**
* Validate a supplied profile name
*
* Returns a profile number for a supplied name
*
* @since	2.0
*
* @param	string		$name		The name of the profile to find
* @param	string		$number		The number of profiles available
* @return	string					The profile number (defaults to 0)
*/

function ye_validate_profile( $name, $number ) {

	$profile = 0;
	$name = strtolower( $name );

	if ( ( $name != '' ) && ( $name != 'default' ) ) {

		// Loop around, fetching in profile names
		$loop = 1;
		while ( ( $loop <= $number ) && ( $profile == 0 ) ) {
			if ( ( $name == $loop ) or ( $name == 'Profile ' . $loop ) ) {
				$profile = $loop;
			} else {
				$profiles = get_option( 'youtube_embed_profile' . $loop );
				$profname = strtolower( $profiles[ 'name' ] );
				if ( $profname == $name ) { $profile = $loop; }
			}
			$loop ++;
		}
	}
	return $profile;
}

/**
* Validate a supplied list name
*
* Returns a list for a supplied list number or name name - blank if not a valid list
*
* @since	2.0
*
* @param	string		$name		The name of the list to find
* @param	string		$number		The number of lists available
* @return	string					The list (defaults to blank)
*/

function ye_validate_list( $name, $number ) {

	$list = '';

	// If the parameter contains commas, assume to be a comma seperated list and move into an array
	if ( strpos( $name, ',' ) !== false ) {
		$list = explode( ',', $name );
	} else {

		// No comma, so check if this is a named list
		$name = strtolower( $name );

		if ( $name != '' ) {

			// Loop around, fetching in profile names
			$loop = 1;
			while ( ( $loop <= $number ) && ( $list == '' ) ) {
				$listfiles = get_option( 'youtube_embed_list' . $loop );
				if ( ( $name == strval( $loop ) ) or ( $name == 'List ' . $loop ) ) {
					$list = $listfiles[ 'list' ];
				} else {
					$listname = strtolower( $listfiles[ 'name' ] );
					if ( $listname == $name ) { $list = $listfiles[ 'list' ]; }
				}
				$loop ++;
			}
		}
		if ( $list != '' ) { $list = explode( "\n", $list ); }
	}
	return $list;
}

/**
* Get URL parameters
*
* Extract a requested parameter from a URL
*
* @since	2.0
*
* @param	string		$id			The ID of the video
* @param	string		$para		The parameter to extract
* @param	string		$current	The current parameter value
* @return	string					The parameter value
*/

function ye_get_url_para( $id, $para, $current ) {

	// Look for an ampersand
	$start_pos = false;
	if ( strpos( $id, '&amp;' . $para . '=' ) !== false ) {	$start_pos = strpos( $id, '&amp;' . $para . '=' ) + 6 + strlen( $para ); }

	// If a parameter was found, look for the end of it
	if ( $start_pos !== false ) {
		$end_pos = strpos( $id, '&amp;', $start_pos + 1 );
		if ( !$end_pos ) { $end_pos = strlen( $id ); }

		// Extract the parameter and return it
		$current = substr( $id, $start_pos, $end_pos - $start_pos );
	}

	return $current;
}

/**
* Decode a string
*
* Decode an HTML encoded string. I'm not using htmlspecialchars_decode to maintain
* PHP 4 compatibility.
*
* @since	2.0.3
*
* @param	string		$encoded	The encoded string
* @return	string					The decoded string
*/

function ye_decode( $encoded ) {

	$find = array( '&amp;', '&quot;', '&#039;', '&lt;', '&gt;' );
	$replace = array( '&', '"', "'", '<', '>' );

	$decoded = str_replace($find,$replace,$encoded);

	return $decoded;
}
?>