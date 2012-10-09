<?php

// All functions that require PHP5.

//*****************************************************************************
//
// FUNCTION: initDOMfromHTML
//
//*****************************************************************************
function initDOMfromHTML( $htmlContent ) {

    $dom = new DOMDocument();
    $dom->loadHTML($htmlContent);
    
    // echo "\n" . $htmlContent . "\n";
    
    return $dom;
    
}  // initDOMfromHTML


//*****************************************************************************
//
// FUNCTION: plplus_parsePrevNextLinks
//
//*****************************************************************************
function plplus_parsePrevNextLinks( $dom ) {

  // if NextGen Gallery is active
  if (function_exists('nggallery_init')) {

    $domXpath = new DOMXPath($dom);

    $ngg_prevs = $domXpath->evaluate("//div[@class='ngg-navigation']/a[@class='prev']");
  
    if ($ngg_prevs->length == 1) {
  
      $ngg_prev = $ngg_prevs->item(0);
      $href = $ngg_prev->getAttribute('href');
      $feed = wp_specialchars($href);
      echo "\n    <atom:link rel='previous' href='$feed' />\n";
    }

    $ngg_nexts = $domXpath->evaluate("//div[@class='ngg-navigation']/a[@class='next']");
  
    if ($ngg_nexts->length == 1) {
  
      $ngg_next = $ngg_nexts->item(0);
      $href = $ngg_next->getAttribute('href');
      $feed = wp_specialchars($href);
      echo "    <atom:link rel='next' href='$feed' />\n";
    }
    
  } // end if NextGen Gallery
  
}  // plplus_parsePrevNextLinks


//*****************************************************************************
//
// FUNCTION: DOMParse
//
// takes a block of html and returns the links and img's in an array.

//*****************************************************************************
function DOMParse($dom) {

    $domImages = array();
    $domXpath = new DOMXPath($dom);
    
    /* this handles the case if there is a thumbnail 
     * image and a link to another (bigger?) image
     */
    $hrefs = $domXpath->evaluate("//a");
    
    // plplus: allow links that have a php script in them
    // plplus: move the regular expression to a variable
    // plplus: escape the . so that it really is a .
    $reg_expr = "\.jpg$|\.png$|\.php\?";
    
    for ($i = 0; $i < $hrefs->length; $i++) {
        $href = $hrefs->item($i);
        $url = $href->getAttribute('href');
        $img = $href->getElementsByTagName('img');
	    if ($img->item(0)) {
                $src = $img->item(0)->getAttribute('src');
                
              // plplus: exclude images with their class set to "no-mrss"
              //         used to exclude PicLens image
              $class = $img->item(0)->getAttribute('class');
              if (! eregi("no-mrss", $class) ) {

                // plplus: move the regular expression to a variable                
                if (eregi($reg_expr, $src) && eregi($reg_expr, $url)) {
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
        if (eregi("\.jpg$|\.png$", $src) && $duplicate == false && !ereg("PicLensButton.png", $src)) {
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

        if (eregi("http://www.youtube.com/v/(.*)&", $src, $regs)) {
            $vid = $regs[1];
            $tmpArray['thumb'] = youtubeThumbnail($vid);
            $tmpArray['full'] = youtubeUrl($vid);
            array_push($domImages, $tmpArray);
        }

    }
        
    return $domImages;
    
}  // DOMParse


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
