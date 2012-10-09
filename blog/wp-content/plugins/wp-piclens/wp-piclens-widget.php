<?php

/*
Plugin Name: WP PicLens Slideshow Widget
Plugin URI: http://wordpress.piclens.com/
Description: Adds a Dynamic HTML Slideshow Widget that creates an immersive, full-screen slideshow presentation of photos and images in your blog. Add the widget to your sidebar and set display options in the Admin &raquo; Presentation &raquo; Widgets Tab. 
Version: 1.0.5
Author: The Cooliris Team
Author URI: http://www.cooliris.com
*/

/*  Copyright 2007 The Cooliris Team (email : feedback@piclens.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$phpVersion = phpversion();
if (class_exists('DOMDocument') && $phpVersion >= 5.1) {
    require_once('piclensFunctions.inc');

    if( file_exists( ABSPATH . WPINC . '/rss.php') ) {
		require_once(ABSPATH . WPINC . '/rss.php');
	} else {
		require_once(ABSPATH . WPINC . '/rss-functions.php');
	}
    
    add_action('wp_head', 'wp_piclens_print_head');
    add_action('plugins_loaded', 'widget_piclens_init');

    add_action('activate_wp-piclens/wp-piclens-widget.php', 'widget_piclens_activate');
    add_action('deactivate_wp-piclens/wp-piclens-widget.php', 'widget_piclens_deactivate');
    register_activation_hook( basename(__FILE__), 'widget_piclens_activate' );
    register_deactivation_hook( basename(__FILE__), 'widget_piclens_deactivate' );
} elseif ($phpVersion < 5.1) {
    die("<html><head><title>WP Piclens Error</title></head><body style=\"font-family: Courier New, Fixed, monospace;margin: 5px\"><p><center><b>ERROR</b>: WP Piclens <i>REQUIRES</i> PHP version 5.1 or greater, your WordPress Blog is using PHP $phpVersion.</center></p></body></html>");
} elseif (!class_exists('DOMDocument')) {
    die("<html><head><title>WP Piclens Error</title></head><body style=\"font-family: Courier New, Fixed, monospace;margin: 5px\"><p><center><b>ERROR</b>: WP Piclens <i>REQUIRES</i> PHP libxml Functions.<br/>See <a href=http://www.php.net/manual/en/ref.libxml.php>http://www.php.net/manual/en/ref.libxml.php</a></center></p></body></html>");
} else {
    die("<html><head><title>WP Piclens Error</title></head><body style=\"font-family: Courier New, Fixed, monospace;margin: 5px\"><p><center><b>ERROR</b>: WP Piclens is missing one of its requirements, please re-check the requirements for WP-Piclens.</center></p></body></html>");
}

function widget_piclens_init() {

    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') ) {
        return;	
    }
    
    // this is called on each page load
    function widget_piclens($args) {

        $options = get_option('widget_piclens_options');
        $title = $options['slideshowTitle'];
        $slideshowLinkText = $options['slideshowLinkText'];
		
        extract($args);
        $piclenshtml = widgetHTML();
        echo "\n<!-- Start PicLens widget -->\n";
        echo "$before_widget" . "$before_title" . "$title" . "$after_title";
        echo '<ul><li><a style="align: right;" href="javascript:toggleStartStop();PicLensLite.start({feedUrl:\'' . wp_piclens_base_uri() . '/mrss.php\'});">' . $slideshowLinkText . '</a></ul>';
        echo '<div id="rotator">'. $piclenshtml .'</div>';
        echo $after_widget;
        echo "\n<!-- Stop PicLens widget -->\n";

    }

    // this is called in Presentation->Widgets->Configure
    function widget_piclens_control() {
        if (!get_option('widget_piclens_options')) {
            add_option("widget_piclens_options", 0, "Options for the PicLens slideshow widget", no);
            $newoptions['slideshowTitle'] = 'PicLens Slideshow';
            $newoptions['slideshowLinkText'] = 'View in PicLens Lite';
            $newoptions['slideshowMaxNumImg'] = '0';
            $newoptions['slideshowTimer'] = '4000';
            $newoptions['flickrFeed'] = 'http://api.flickr.com/services/feeds/photos_public.gne?id=32489127@N00&lang=en-us&format=rss_200';
            update_option('widget_piclens_options', $newoptions);
        }

        if ( is_active_widget('widget_piclens') ) {
            $widget_piclens_active = 'true';
        } else {
            $widget_piclens_active = 'false';
        }
        
        if (!get_option('widget_piclens_active')) {
            add_option("widget_piclens_active", $widget_piclens_active, "Is the widget active", no);
        } else {
            $originalValue = get_option('widget_piclens_active');
            if ($originalValue != $widget_piclens_active) {
                widget_piclens_change_status($widget_piclens_active);
            }
            update_option('widget_piclens_active', $widget_piclens_active, '','');
        }

        $options = $newoptions = get_option('widget_piclens_options');
        if ( $_POST["piclens-submit"] ) {
            $newoptions['slideshowTitle'] = strip_tags(stripslashes($_POST["slideshowTitle"]));
            $newoptions['slideshowLinkText'] = strip_tags(stripslashes($_POST["slideshowLinkText"]));
            $newoptions['slideshowMaxNumImg'] = strip_tags(stripslashes($_POST["slideshowMaxNumImg"]));
            $newoptions['slideshowTimer'] = strip_tags(stripslashes($_POST["slideshowTimer"]));
            $newoptions['flickrFeed'] = strip_tags(stripslashes($_POST["flickrFeed"]));
        }
        if ( $options != $newoptions ) {
            $options = $newoptions;
            update_option('widget_piclens_options', $options);
        }
        $slideshowTitle = attribute_escape($options['slideshowTitle']);
        $slideshowLinkText = attribute_escape($options['slideshowLinkText']);
        $slideshowMaxNumImg = attribute_escape($options['slideshowMaxNumImg']);
        $slideshowTimer = attribute_escape($options['slideshowTimer']);
        $flickrFeed = attribute_escape($options['flickrFeed']);
        
        echo '<p style="text-align: left;">PicLens Slideshow -- A simple Dynamic HTML slideshow widget by <a href="http://cooliris.com">The Cooliris Team</a></p>';
        echo '<p style="text-align: left;"><label for="piclens_title">';
        _e( '<b>Widget Title</b>: <br>' );
        echo '<input style="text-align: left;" size="30" id="piclens_title" name="slideshowTitle" type="text" value="' . $slideshowTitle . '" /></label></p>';
        
        echo '<p style="text-align: left;"><label for="piclens_linkText">';
        _e( '<b>PicLens Slideshow Link Text</b>: <br>' );
        echo '<input style="text-align: left;" size="30" id="piclens_linkText" name="slideshowLinkText" type="text" value="' . $slideshowLinkText . '" /></label></p>';
        
        echo '<p style="text-align: left;"><label for="numPhotos">';
        _e( '<b>Maximum number of images to show in slideshow</b> (enter 0 for unlimited): ' );
        echo '<input style="text-align: center;" size="3" id="numPhotos" name="slideshowMaxNumImg" type="text" value="' . $slideshowMaxNumImg . '" /></label></p>';
        
        echo '<p style="text-align: left;"><label for="slideshowTimer">';
        _e( '<b>Delay between image transitions</b> (in milliseconds): ' );
        echo '<input style="text-align: center;" size="4" id="slideshowTimer" name="slideshowTimer" type="text" value="' . $slideshowTimer . '" /></label></p>';

        echo '<p style="text-align: left;"><label for="flickrFeed">';
        _e( '<b>Flickr RSS 2.0* Feed URL:</b> (these will show before your blog images): <br>' );
        echo '<input style="width:450px;text-align:left;" id="flickrFeed" name="flickrFeed" type="text" value="' . $flickrFeed . '" /></label><br/>';
        _e( '<i>* Your Latest <img src="' . wp_piclens_base_uri() . '/feed-icon-16x16.png" align="absbottom" border="0"> RSS feed URL can be found at the bottom of your Flickr page, copy the link and paste it into the box above.</i></p>' );
        echo '<input type="hidden" id="piclens-submit" name="piclens-submit" value="1" />';
        
    }

    $class = array('classname' => 'widget_piclens_slideshow');
    register_sidebar_widget('PicLens SlideShow', 'widget_piclens', $class);
    register_widget_control('PicLens SlideShow', 'widget_piclens_control', 500, 400);

}

?>
