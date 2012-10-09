<?php

$globalProduct = 'wp-piclens';
$globalVersion = '1.0.5';
$globalURL = 'http://update.piclens.com/cgi-bin/wordpressv1.php';

// takes the array of images and generates html for the widget
function widgetHTML() {
    // for the widget get all images and return html for the widget.
    $options = get_option('widget_piclens_options');
    $limit = attribute_escape($options['slideshowMaxNumImg']);
    $feed = urldecode($options['flickrFeed']);
    $allImages = array();
    
    if ($feed != '') {
        $allImages = getFeedImages($feed);
    }

    // get images from the blog posts.
    if (is_array($allImages)) {
        $allImages = array_merge(getAllImages('all'), $allImages);
    } else {
        $allImages = getAllImages('all');
    }
    
    foreach ($allImages as $imgArray) {
        if ($count < $limit || $limit === '0') {
           $widgetHTML .= '<a href="' . $imgArray[full] . '" onClick="window.location=\'' . $imgArray['guid'] . '\';return false;"><img src="' . $imgArray[thumb] . '" /></a>';
        }
           $count++;
    }
    if (!$widgetHTML) {
        $widgetHTML = '<div id="noImages"><table border="0" height="100%" width="100%"><tr><td><strong><font color="#C0C0C0">NO IMAGES AVAILABLE</font></strong></td></tr></table></div>';
    }
    return $widgetHTML;
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

// takes a block of html and returns the links and img's in an array.
function DOMParseHTML($htmlContent) {

    $domImages = array();
    $dom = new DOMDocument();
    @$dom->loadHTML($htmlContent);
    $domXpath = new DOMXPath($dom);
    
    /* this handles the case if there is a thumbnail 
     * image and a link to another (bigger?) image
     */
    $hrefs = $domXpath->evaluate("//a");
    for ($i = 0; $i < $hrefs->length; $i++) {
        $href = $hrefs->item($i);
        $url = $href->getAttribute('href');
        $img = $href->getElementsByTagName('img');
	    if ($img->item(0)) {
                $src = $img->item(0)->getAttribute('src');
                if (ereg(".jpg$|.png$", $src) && ereg(".jpg$|.png$", $url)) {
                    $tmpArray['thumb'] = $src;
                    $tmpArray['full'] = $url;
                    array_push($domImages, $tmpArray);
                } else {
                    $tmpArray['thumb'] = contentUrlToThumbnail($src);
                    $tmpArray['full'] = thumbnailToContentUrl($src);
                    array_push($domImages, $tmpArray);
                }
	    }
	}

    /* this handles the case if there is only an image
     * we do not know if there is a thumbnail.
     */
    $imgs = $domXpath->evaluate("//img");
    for ($i = 0; $i < $imgs->length; $i++) {
        $img = $imgs->item($i);
        $src = $img->getAttribute('src');

        // check if this was already from the above case.
        $duplicate = false;
        foreach ($domImages as $testArray) {
            if ($src === $testArray['full'] || $src === $testArray['thumb']) {
                $duplicate = true;
            }
        }
        // push it onto the array if it is unique!
        if (ereg(".jpg$|.png$", $src) && $duplicate == false && !ereg("PicLensButton.png", $src)) {
            $tmpArray['thumb'] = contentUrlToThumbnail($src);
            $tmpArray['full'] = thumbnailToContentUrl($src);
            array_push($domImages, $tmpArray);
        }
                    
    }

    /* this handles embedded youtube content
     * 
     */
    $embeds = $domXpath->evaluate("//embed");
    for ($i = 0; $i < $embeds->length; $i++) {
        $embed = $embeds->item($i);
        $src = $embed->getAttribute('src');

        if (ereg("http://www.youtube.com/v/(.*)&", $src, $regs)) {
            $vid = $regs[1];
            $tmpArray['thumb'] = youtubeThumbnail($vid);
            $tmpArray['full'] = youtubeUrl($vid);
            array_push($domImages, $tmpArray);
        }

    }
        
    return $domImages;
    
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
	$url = ereg_replace("_d.jpg", ".jpg", $url);
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
	$url = ereg_replace("_d.jpg", ".jpg", $url);
    if (preg_match('@(.*/)([^/]+?)(?:_\\w)?\\.@', $url, $regs)) {
		if (ereg("_[t|s].$", $regs[0])) {
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

// finds the path to the php code
function wp_piclens_base_uri() {
    return str_replace(ABSPATH, get_option('siteurl') . '/', dirname(__FILE__));
}

// adds the required stylesheets and javascript to the page head
function wp_piclens_print_head() {
    echo '
    <link rel="stylesheet" href="' . wp_piclens_base_uri() . '/piclens.css" type="text/css" />
    <script type="text/javascript" src="' . wp_piclens_base_uri() . '/javascript.php"></script>
    <script type="text/javascript" src="http://lite.piclens.com/current/piclens.js"></script>
    <style type="text/css">.mbf-item {display: none;}</style>
    <link rel="alternate" type="application/rss+xml" title="WP-Piclens Media RSS Feed" href="' . wp_piclens_base_uri() . '/mrss.php"/>
';
}

function uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
    mt_rand( 0, 0x0fff ) | 0x4000,
    mt_rand( 0, 0x3fff ) | 0x8000,
    mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
}

function widget_piclens_change_status ($status) {
    if ($status == 'true') {
        widget_piclens_activate();
    } else {
        widget_piclens_deactivate();
    }
}

function widget_piclens_activate () {
    global $globalURL, $globalVersion;
    if (class_exists('DOMDocument')) {
        // for cache
        if (!get_option('wp_piclens_feed_cache')) {
            add_option("wp_piclens_feed_cache_age", '', "WordPress PicLens Plugin RSS Feed Cache Age", no);
            add_option("wp_piclens_feed_cache", '', "WordPress PicLens Plugin RSS Feed Cache", no);
        }
        if (get_option('wp_piclens_uuid')) {
            // for stats collection
            $wp_piclens_uuid = get_option('wp_piclens_uuid');
            $updateUrl = $globalURL;
            $data = array('sID' => $wp_piclens_uuid,
                          'action' => 'activate',
                          'product' => 'widget-piclens-slideshow',
                          'version' => $globalVersion);
            $postData = http_build_query($data);
            do_post_request($updateUrl, $postData);
        }
    }
}

function widget_piclens_deactivate () {
    global $globalURL, $globalVersion;
    if (get_option('wp_piclens_uuid')) {
        // for stats collection
        $wp_piclens_uuid = get_option('wp_piclens_uuid');
        $updateUrl = $globalURL;
        $data = array('sID' => $wp_piclens_uuid,
                      'action' => 'deactivate',
                      'product' => 'widget-piclens-slideshow',
                      'version' => $globalVersion);
        $postData = http_build_query($data);
        do_post_request($updateUrl, $postData);
    }
}

function wp_piclens_activate ($action) {
    global $globalURL, $globalVersion;
    if (class_exists('DOMDocument')) {
        if ($action == null) {
            $action = 'activate';
        }
        // generate a uuid if there isn't one already
        if (!get_option('wp_piclens_uuid')) {
            $wp_piclens_uuid = uuid();
            add_option("wp_piclens_uuid", $wp_piclens_uuid, "WordPress PicLens Plugin UUID", no);
        }
        // set the default options if they are not set already
        if (!get_option('wp_piclens_version_installed')) {
            $wp_piclens_append_link = "true";
            $wp_piclens_link_text = 'Start Slide Show with PicLens Lite [piclens-icon]';
            $wp_piclens_link_text = htmlspecialchars("$wp_piclens_link_text", ENT_QUOTES);
            $wp_piclens_version = $globalVersion;

            add_option("wp_piclens_link_text", $wp_piclens_link_text, "Start PicLens link text", no);
            add_option("wp_piclens_append_link", $wp_piclens_append_link, "Auto add PicLens link", no);
            add_option("wp_piclens_version_installed", $wp_piclens_version, "What is the version installed?", no);
        }
        // for stats collection
        $wp_piclens_uuid = get_option('wp_piclens_uuid');
        $updateUrl = $globalURL;
        $data = array('sID' => $wp_piclens_uuid,
                      'action' => $action,
                      'product' => 'wp-piclens',
                      'version' => $globalVersion);
        $postData = http_build_query($data);
        do_post_request($updateUrl, $postData);        
    } else {
        return false;
    }
}

function wp_piclens_deactivate () {
    global $globalURL, $globalVersion;
    if (get_option('wp_piclens_uuid')) {
        // for stats collection
        $wp_piclens_uuid = get_option('wp_piclens_uuid');
        $updateUrl = $globalURL;
        $data = array('sID' => $wp_piclens_uuid,
                      'action' => 'deactivate',
                      'product' => 'wp-piclens',
                      'version' => $globalVersion);
        $postData = http_build_query($data);
        do_post_request($updateUrl, $postData);
    } else {
        wp_piclens_activate('reset');
        wp_piclens_deactivate();
    }
}

function do_post_request($url, $data, $optional_headers = null) {
    $params = array('http' => array(
                    'method' => 'POST',
                    'content' => $data));
    if ($optional_headers !== null) {
        $params['http']['header'] = $optional_headers;
    }
    $ctx = stream_context_create($params);

    $timeout = 1;
    $old = ini_set('default_socket_timeout', $timeout);
    $fp = @fopen($url, 'rb', false, $ctx);
    ini_set('default_socket_timeout', $old);
    stream_set_timeout($fp, $timeout);
    stream_set_blocking($fp, 0);

    if (!$fp) {
//        throw new Exception("Problem with $url, $php_errormsg");
    } else {
        $response = @stream_get_contents($fp);
        if ($response === false) {
//            throw new Exception("Problem reading data from $url, $php_errormsg");
        }
        return $response;
    }
}

function httpReqUrl($url) {
    require_once("http.php");
	$http=new http_class;
	$http->timeout=0;
	$http->data_timeout=0;
	$http->debug=0;
	$http->html_debug=0;
	$http->follow_redirect=1;
	$http->redirection_limit=5;
	$error=$http->GetRequestArguments($url,$arguments);
	flush();
	$error=$http->Open($arguments);
	if ($error=="") {
		$error=$http->SendRequest($arguments);
		if ($error=="") {
			$headers=array();
			$error=$http->ReadReplyHeaders($headers);
			if ($error=="") {
				switch($http->response_status)
				{
					case "301":
					case "302":
					case "303":
					case "307":
					break;
				}
				for (;;) {
					$error=$http->ReadReplyBody($body,1000);
					if ($error!="" || strlen($body)==0) {
						break;
					}
					$return .= $body;
                }
			}
		}
		$http->Close();
	}
	return $return;
}

function domLoadXML ($xmlStr) {
	
    $domDoc = new DOMDocument();
    $domDoc->loadXML("$xmlStr");
    $rootElement = getRootElement($domDoc);
    if ( !isset($rootElement) ) {
        return false;
    } else {
        return $domDoc;
    }

}

function getRootElement ($domDoc) {

	if (!empty($domDoc)) {
        $domElements = $domDoc->getElementsByTagName('*');
        if ( !isset($domElements) ) {
            return false;
        } else {
            $rootElement = $domElements->item(0)->localName;
            return $rootElement;
        }
	} else {
	    return false;
	}

}

function getFeedImages ($feedUrl) {

    // using a rss feed instead of blog images.
    $allImages = array();
    $age = get_option('wp_piclens_feed_cache_age');
    // expire the cache if it's older than an hour. 
    $expire = time() - (1 * 60 * 60);
    // check the freshness of the cache
    if ($age-$expire < 0) {
        $rss = httpReqUrl($feedUrl);
        update_option('wp_piclens_feed_cache_age', time());
        update_option('wp_piclens_feed_cache', $rss);
    } else {
        $rss = get_option('wp_piclens_feed_cache');
    }
    $domObj = domLoadXML($rss);
    $domItems = $domObj->getElementsByTagName('item');
    for ($i = '0'; $i < $domItems->length; $i++) {
        $domItem = $domItems->item($i);
        $itemElems = $domItem->getElementsByTagName('text');
        $linkElems = $domItem->getElementsByTagName('link');
        $link = $linkElems->item(0)->nodeValue;
        $textElems = $domItem->getElementsByTagName('title');
        $text = $textElems->item(0)->nodeValue;
        for ($ii = '0'; $ii < $itemElems->length; $ii++) {
            $feedItemText = $itemElems->item($ii)->nodeValue;
            $tmpArray = DOMParseHTML($feedItemText);
            $tmpArray['0']['guid'] = $link;
            $tmpArray['0']['text'] = $text;
            array_push($allImages, $tmpArray[0]);
        }
    }
    return $allImages;
}

?>
