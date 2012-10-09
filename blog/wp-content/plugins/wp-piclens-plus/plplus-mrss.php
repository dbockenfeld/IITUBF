<?php

/*
  Creator: Shack Dougall (http://liferain.com/id/ShackDougall/)
    
  Super big thanks to The Cooliris Team.  PicLens rocks!
  
*/


if (!defined('DB_NAME')) {
    require_once('../../../wp-config.php');
    wp();
}

require_once('plplus-common-include.php');
require_once('plplus-parse.php');

global $globalVersion;
global $globalProduct;

// print the head of the PicLens MRSS feed
//header ('content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" 
xmlns:media="http://search.yahoo.com/mrss" 
xmlns:atom="http://www.w3.org/2005/Atom">
<!-- generator="' . $globalProduct . '/' . $globalVersion . '" -->
<channel>
';

// plplus: changed wp_title_rss to get_wp_title_rss to prevent echoing
if (function_exists('get_wp_title_rss')) {
	$rssTitle = get_wp_title_rss();
}

echo '    <title>';
bloginfo_rss('name'); 
echo "$rssTitle" . '</title>
    <link>';
bloginfo_rss('url');
echo '</link>
    <description>';
bloginfo_rss('description');
echo '</description>
    <pubDate>';
echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false);
echo '</pubDate>
    <generator>liferain.com ' . "$globalProduct" . ' ' . "$globalVersion" . '</generator>
    <language>';
echo get_option('rss_language');
echo '</language>
';

while( have_posts() ) : the_post();

  $dom = plplug_initDOMwithFilteredContent();
  
  if (is_single() || (is_page() && ! is_category() && ! is_tag() )) {
    plplus_parsePrevNextLinks( $dom );
  }
  
  $postImages = plplus_getPostImages( $dom );
  
// Put items into PicLens MRSS feed
foreach ($postImages as $imgArray) {
    $imgSrc = wp_specialchars($imgArray['thumb'], true);
    $imgSrc = str_replace( " ", "%20", $imgSrc );
    $imgSrcFull = wp_specialchars($imgArray['full'], true);
    $imgSrcFull = str_replace( " ", "%20", $imgSrcFull );
    echo '
    <item>
        <title>' . $imgSrc . '</title>
        <link>' . $imgArray['guid'] . '</link>
        <media:thumbnail url="' . $imgSrc . '" />
        <media:content url="' . $imgSrcFull . '" />
        <attribution text="' . wp_specialchars($imgArray['text'], true) . '"/>
    </item>
';
}

endwhile;

echo '
</channel>
</rss>
';

?>
