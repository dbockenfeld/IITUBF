<?php

$globalProduct = 'wp-piclens-plus';
$globalVersion = '1.0.5.10';
$globalURL = 'http://update.piclens.com/cgi-bin/wordpressv1.php';

// added for PHP4 compatibility taken from a comment on
// http://us.php.net/htmlspecialchars_decode
if (!function_exists("htmlspecialchars_decode")) {
    function htmlspecialchars_decode($string, $quote_style = ENT_COMPAT) {
        return strtr($string, array_flip(get_html_translation_table(HTML_SPECIALCHARS, $quote_style)));
    }
}


//*****************************************************************************
//
// FUNCTION: plplus_pageURItoFeedURI
//
// Converts a fully qualified page URI to its corresponding feed.
// Example, http://website/blog/page/ is converted to 
// http://website/blog/page/feed/mrss/
//
//*****************************************************************************
function plplus_pageURItoFeedURI( $pageURI ) {
	global $wp_rewrite;
	
  $uri_has_parameters = ereg("=", $pageURI);
  
	// IF permalinks AND there are no parameters then /feed/mrss/
	// note: the second part (no parameters) was added because of 
	// http://www.anneliesmeykens.be/portfolio/?album=7&gallery=6
	// this is a blog that is using permalinks, but the gallery plugin does not
	// use permalinks.  So, the URL has parameters even though the blog 
	// does not.
	if ( ($wp_rewrite->using_permalinks()) && (! $uri_has_parameters)) {
    // permalinks
    
    $mrss_uri = 'feed/mrss/';
    
    // check to see if the uri has a slash on the end of it.
    // if not, then we need to add one.
    if (! preg_match( "/\/$/", $pageURI)) {
      $mrss_uri = '/' . $mrss_uri;
    }
    
  } else {
    // no permalinks and/or the link has parameters then ?feed=mrss
    
    // Check the request_uri to see if it already has some parameters in it.
    // set feed params appropriately.
    $feed_params = ($uri_has_parameters ? '&amp;' : '?') . 'feed=mrss';
    $mrss_uri = $feed_params;
  }
	
	$mrss_uri = $pageURI . $mrss_uri;
	return $mrss_uri;
	
}  // plplus_pageURItoFeedURI


?>
