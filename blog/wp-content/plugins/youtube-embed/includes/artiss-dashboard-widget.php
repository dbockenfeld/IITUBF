<?php
/**
* Artiss Dashboard Widget (v1.3)
*
* Add a box to the dashboard to display Artiss posts, and plugin news and support links
*
* @package	YouTubeEmbed
* @since	2.0
*/

/**
* Define Dashboard Widget
*
* Set up a new dashboard widget
*
*/

function artiss_dashboard_widget() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget( 'artiss_help_widget', 'Artiss News & Support', 'adw_create_widget' );
}
add_action( 'wp_dashboard_setup', 'artiss_dashboard_widget' );

/**
* Display Dashboard Widget
*
* Show dashboard widget. Fetch top news items from Twitter cache them.
*
*/

function adw_create_widget() {

	// Set number of minutes to cache output
	$minutes_to_cache = 120;

	// Set number of news items to display
	$news_items = 5;	// Attempt to get the cache
	$output = get_transient( 'artiss_dashboard_text' );

	// No cache found
	if (!$output) {

        // Add donation link
		$output .= "<span style=\"font-size: 0.8em; float: right\"><a href=\"http://www.artiss.co.uk/donate\">Donate</a></span>";

        // News heading
        $output .= "<span style=\"font-size: 1.1em; font-weight: bold;\">Latest News</span><br/><br/>\n";

		// Fetch the Twitter status'
        $file_return = adw_get_file( 'http://api.twitter.com/1/statuses/user_timeline.xml?screen_name=artiss_tech&count=' . $news_items . '&exclude_replies=true' );

		if ( $file_return[ 'file' ] != '' ) {

            // Extract Twitter status' and output

            $twitter_feed = $file_return[ 'file' ];

            $output .= "<span style=\"font-weight: bold; font-size: 0.9em;\">Last updated " . date('l jS F \a\t g:ia') . ".</span><br/><br/>\n<ul>\n";

            $loop = 1;
            $pos = 1;
            while ( $loop < ( $news_items + 1 ) ) {

                $start = strpos( $twitter_feed, '<text>', $pos );
                $end = strpos( $twitter_feed, '</text>', $start );

                $status = substr( $twitter_feed, $start + 6, $end - $start - 6 ); // Extract status
                $status = str_replace( 'New blog post: ', '', $status ); // Remove blog post text
                $status = ereg_replace( "[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]","<a href=\"\\0\">\\0</a>", $status ); // Add URL links

                $output .= '<li>' . $status . "</li>\n";

                $pos = $end+7;
                $loop ++;
            }
            $output .= "</ul>\n";

		}

		// Add link to Twitter
		$output .= "<p><a href=\"http://twitter.com/artiss_tech\">Follow us on Twitter</a></p>\n";

		// Generate support links
		$output .= "<span style=\"font-size: 1.1em; font-weight: bold;\">Support Links</span><br/><br/>\n<ul>\n<li><a href=\"http://www.artiss.co.uk\">Artiss.co.uk website</a><br/></li>\n<li><a href=\"http://www.artiss.co.uk/wp-plugins\">Main plugin page</a><br/></li>\n<li><a href=\"http://www.artiss.co.uk/forum\">Plugin forum </a></li>\n</ul>\n";

		// Update cache
		set_transient( 'artiss_dashboard_text', $output, $minutes_to_cache * 60 );
	}

	echo $output;
}

/**
* Fetch a file (1.5)
* Use WordPress API to fetch a file and check results
*
* @package [Plugin Name]
* @since [version number]
*
* @param    string	$filein		File name to fetch
* @return   string				Array containing file contents and response
*/

function adw_get_file( $filein ) {

    $fileout = wp_remote_get( $filein );
    if ( !is_wp_error( $response ) ) {
        if ( isset( $fileout[ 'body' ] ) ) { $file_return[ 'file' ] = $fileout[ 'body' ]; }
        if ( isset( $fileout[ 'response '][ 'code' ] ) ) { $file_return[ 'response' ] = $fileout[ 'response' ][ 'code' ]; }
    }

    return $file_return;

}
?>