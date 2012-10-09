<?php

if (!defined('DB_NAME')) {
    require_once('../../../wp-config.php');
    wp();
}

require_once('plplus-common-include.php');
require_once('plplus-parse.php');

$options = get_option('widget_piclens_options');
$feed = urldecode($options['flickrFeed']);

if ($feed != '') {
    $allImages = getFeedImages($feed);
}
if ($_GET['id']) {
    $allImages = getAllImages($_GET['id']);
} else {
    if (is_array($allImages)) {
        $allImages = array_merge(getAllImages('all'), $allImages);
    } else {
        $allImages = getAllImages('all');
    }
}

// print the head of the PicLens MRSS feed
//header ('content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss">
<!-- generator="WP-PicLens/' . $globalVersion . '" -->
<channel>
';

// plplus: changed wp_title_rss to get_wp_title_rss to prevent echoing
if (function_exists(get_wp_title_rss)) {
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
    <generator>piclens ' . "$globalProduct" . ' ' . "$globalVersion" . '</generator>
    <language>';
echo get_option('rss_language');
echo '</language>
';

// Put items into PicLens MRSS feed
foreach ($allImages as $imgArray) {
    $imgSrc = wp_specialchars($imgArray['thumb'], true);
    $imgSrc = str_replace( " ", "%20", $imgSrc );
    $imgSrcFull = wp_specialchars($imgArray['full'], true);
    $imgSrcFull = str_replace( " ", "%20", $imgSrcFull );
    // plplus: added wp_specialchars() around the attribution text.
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

echo '
</channel>
</rss>
';

?>
