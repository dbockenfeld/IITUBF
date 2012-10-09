<?php

// throw an error if libXML is not available.
if (!class_exists('DOMDocument')) {
    exit('WP PicLens ERROR: Missing php-xml (libxml) support');
}

if (!defined('DB_NAME')) {
    require_once('../../../wp-config.php');
    wp();
    require_once('piclensFunctions.inc');
}

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

if (function_exists(wp_title_rss)) {
	$rssTitle = wp_title_rss();
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
    $imgSrc = $imgArray['thumb'];
    $imgSrcFull = $imgArray['full'];
    echo '
    <item>
        <title>' . $imgSrc . '</title>
        <link>' . $imgArray['guid'] . '</link>
        <media:thumbnail url="' . $imgSrc . '" />
        <media:content url="' . $imgSrcFull . '" />
        <attribution text="' . $imgArray['text'] . '"/>
    </item>
';
}

echo '
</channel>
</rss>
';

?>
