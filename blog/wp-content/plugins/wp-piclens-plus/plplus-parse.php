<?php

/*
  Creator: Shack Dougall (http://liferain.com/id/ShackDougall/)
  
  Special thanks to Ronald Heft, Jr. http://cavemonkey50.com/ since I copied
  the feed initialization code from his Podcasting plugin at:
  http://wordpress.org/extend/plugins/podcasting/
  
  Super big thanks to The Cooliris Team.  PicLens rocks!
*/

$phpVersion = phpversion();
if ($phpVersion < 5) {
  require_once('plplus-parse-php4-include.php');
} else {
  require_once('plplus-parse-php5-include.php');
}

// takes a block of html and returns the links and img's in an array.
function DOMParseHTML( $htmlcontent ) {

  $dom = initDOMfromHTML( $htmlcontent );
  return DOMParse( $dom );
}

// reads all posts from DB and returns an array
function getAllImages($post_id) {
    global $post;
    $allImages = array();
    if ($post_id == 'all') {
        // query all the posts in the blog, build the allImages array.
        $r = new WP_Query("what_to_show=posts&nopaging=0&post_status=publish");
        if ($r->have_posts()) {
            while ($r->have_posts()) : $r->the_post();
                $post_content = $post->post_content;
                $tmpArray = DOMParseHTML($post_content);
                foreach ($tmpArray as $tmpArray2) {
                    $tmpArray2['guid'] = $post->guid;
                    $tmpArray2['text'] = $post->post_title;
                    array_push($allImages, $tmpArray2);
                }
            endwhile;
        }
    } else {
        // work on a single post.
        $post = get_post($post_id); 
        $post_content = $post->post_content;
        $srcUrl = 'post ' . $post_id;
    
        $tmpArray = DOMParseHTML($post_content);
        foreach ($tmpArray as $tmpArray2) {
            $tmpArray2['guid'] = $post->guid;
            $tmpArray2['text'] = $post->post_title;
            array_push($allImages, $tmpArray2);
        }
    }
    return $allImages;

}

function plplus_getFilteredContent() {

	$content = get_the_content();	
	$content = apply_filters('the_content', $content);
	$filteredContent = str_replace(']]>', ']]&gt;', $content);

	return $filteredContent;
}


function plplug_initDOMwithFilteredContent() {

  $filteredContent = plplus_getFilteredContent();
  
  return initDOMfromHTML( $filteredContent );
}


// reads all posts from DB and returns an array
function plplus_getPostImages( $dom ) {
    global $post;
    $postImages = array();
        // work on a single post in the loop
          
        $tmpArray = DOMParse($dom);
        foreach ($tmpArray as $tmpArray2) {
            $tmpArray2['guid'] = $post->guid;
            $tmpArray2['text'] = $post->post_title;
            array_push($postImages, $tmpArray2);
        }
    return $postImages;
}

// below are functions for youtube support.
function youtubeUrl($videoId) {
    $url = 'http://www.youtube.com/v/' . $videoId;
    return $url;
}
function youtubeThumbnail($videoId) {
	$url = 'http://img.youtube.com/vi/' . $videoId . '/default.jpg';
	return $url;
}

// below are functions to find the thumbnail or full size image from the other.
function thumbnailToContentUrl($url) {
	// split hostname into components by dot, and remove top-level domain
	// and country code second-level domain if needed
	$host = array_reverse(explode('.', parse_url($url, PHP_URL_HOST)));
	array_shift($host);
	if (in_array($host[0], array('co','ac','com','net','org','edu'))) {
		array_shift($host);
	}
	switch ($host[0]) {
		case 'facebook':	return t2c_facebook($url);
		case 'flickr':		return t2c_flickr($url);
		case 'photobucket':	return t2c_photobucket($url);
		case 'google':		return t2c_google($url);
		case 'friendster':	return t2c_friendster($url);
		default:		return $url;
	}
}
function contentUrlToThumbnail($url) {
	// split hostname into components by dot, and remove top-level domain
	// and country code second-level domain if needed
	$host = array_reverse(explode('.', parse_url($url, PHP_URL_HOST)));
	array_shift($host);
	if (in_array($host[0], array('co','ac','com','net','org','edu'))) {
		array_shift($host);
	}
	switch ($host[0]) {
		case 'facebook':	return c2t_facebook($url);
		case 'flickr':		return c2t_flickr($url);
		case 'photobucket':	return c2t_photobucket($url);
		case 'google':		return c2t_google($url);
		case 'friendster':	return c2t_friendster($url);
		default:		return $url;
	}
}

// Facebook functions are complete
function t2c_facebook($url) {
	if (preg_match('@(http://photo.*/)([^/]+)@', $url, $regs)) {
		$file = $regs[2];
		$file[0] = 'n';
		return $regs[1].$file;
	}
	return null;
}
function c2t_facebook($url) {
	if (preg_match('@(http://photo.*/)([^/]+)@', $url, $regs)) {
		$file = $regs[2];
		$file[0] = 's';
		return $regs[1].$file;
	}
	return null;
}

//Flickr functions are complete
function t2c_flickr($url) {
	$url = eregi_replace("_d.jpg", ".jpg", $url);
	if (preg_match('@(.*/)([^/]+?)(?:_\\w)?\\.@', $url, $regs)) {
		// this returns the standard size, which is always available
		return $regs[1].$regs[2].'.jpg';
	}
	// when PLL and PL client support multiple media:content elems,
	// switch to this higher-quality fallback list
	/*return array(
		$regs[1].'_b.jpg',	// big
		$regs[1].'_o.jpg',	// original
		$regs[1].'.jpg',	// standard
		$regs[1].'_m.jpg'	// medium
	);*/
	return null;
}
function c2t_flickr($url) {
	$url = eregi_replace("_d.jpg", ".jpg", $url);
    if (preg_match('@(.*/)([^/]+?)(?:_\\w)?\\.@', $url, $regs)) {
		if (eregi("_[t|s].$", $regs[0])) {
			return $url;
		} else {
			// this returns the thumbnail size (now medium)
			return $regs[1].$regs[2].'_m.jpg';
		}
	}
	return null;
}

// Photobucket functions are complete
function t2c_photobucket($url) {
	// remove the th_ prefix from the image file
	if (preg_match('@(.*/)([^/]+)@', $url, $regs)) {
		return $regs[1].str_replace('th_', '', $regs[2]);
	}
	return null;
}
function c2t_photobucket($url) {
	// add the th_ prefix from the image file
	if (preg_match('@(.*/)([^/]+)@', $url, $regs)) {
		return $regs[1] . 'th_' . $regs[2];
	}
	return null;
}

//Google Images functions are not complete
function t2c_google($url) {
	// assumes Picasa Web Albums (picasaweb.google.*) images start with 'lh'
	// to reduce the probability of accidentally mangling an image url from another
	// google site, since the domain for the images is lh*.google.com
	if (strpos($url, 'http://lh') !== 0) {
		return null;
	}
	
	// remove path component specific to thumbnails
	$parts = parse_url($url);
	if (preg_match('@(.+?)/[a-z]\\d+/(.+)@', $parts['path'], $regs)) {
		$parts['path'] = $regs[1].'/'.$regs[2];
	}

	// recompose url with desired size specified
	return $parts['scheme'].'://'.$parts['host'].$parts['path'].'?imgmax=1024';
}
function c2t_google($url) {
	// assumes Picasa Web Albums (picasaweb.google.*) images start with 'lh'
	// to reduce the probability of accidentally mangling an image url from another
	// google site, since the domain for the images is lh*.google.com
	if (strpos($url, 'http://lh') !== 0) {
		return null;
	}
	
	// remove path component specific to thumbnails
	$parts = parse_url($url);
	if (preg_match('@(.+?)/[a-z]\\d+/(.+)@', $parts['path'], $regs)) {
		$parts['path'] = $regs[1].'/'.$regs[2];
	}

	// recompose url with desired size specified
	return $parts['scheme'].'://'.$parts['host'].$parts['path'].'?imgmax=1024';
}

// Friendster functions are complete
function t2c_friendster($url) {
	// swap the s to an l
	if (substr($url, -5) == 's.jpg') {
		return substr($url, 0, -5).'l.jpg';
	}
	return null;
}
function c2t_friendster($url) {
	// swap the l to an s
	if (substr($url, -5) == 'l.jpg') {
		return substr($url, 0, -5).'s.jpg';
	}
	return null;
}

?>
