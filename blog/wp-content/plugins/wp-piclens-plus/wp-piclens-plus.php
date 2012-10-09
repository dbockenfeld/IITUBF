<?php

/*
Plugin Name: WP PicLens Plus
Plugin URI: http://liferain.com/downloads/wp-piclens-plus/
Description: Modified version of wp-piclens plugin. Creates MediaRSS feeds on both posts and pages (http://sitename/blogname/pagename/feed/mrss/).  Feeds include dynamic content such as NextGen Gallery images inserted by [gallery=x] tags. Set Plugin options in the Admin &raquo; Options &raquo; PicLens Plus Tab.
Version: 1.0.5.10
Author: (wp-piclens-plus: Shack Dougall), (wp-piclens: The Cooliris Team)
Author URI: http://liferain.com/id/ShackDougall/
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

/*
  Modified and extended by: Shack Dougall (http://liferain.com/id/ShackDougall/)
  
  Special thanks to Ronald Heft, Jr. http://cavemonkey50.com/ since I copied
  the feed initialization code from his Podcasting plugin at:
  http://wordpress.org/extend/plugins/podcasting/
  
  Super big thanks to The Cooliris Team.  PicLens rocks!
*/


// check that we meet the minimum requirements

$phpVersion = phpversion();
if ($phpVersion < 5 && ! function_exists('domxml_open_mem')) {
  die("<html><head><title>WP Piclens Plus Error</title></head><body style=\"font-family: Courier New, Fixed, monospace;margin: 5px\"><p><center><b>ERROR</b>: WP Piclens Plus <i>REQUIRES</i> domxml. Please install php-domxml.</center></p></body></html>");
}

if ($phpVersion >= 5) {
  if ($phpVersion < 5.1) {
    die("<html><head><title>WP Piclens Error</title></head><body style=\"font-family: Courier New, Fixed, monospace;margin: 5px\"><p><center><b>ERROR</b>: WP Piclens Plus <i>REQUIRES</i> PHP version 5.1 or greater, your WordPress Blog is using PHP $phpVersion.</center></p></body></html>");
  } elseif (!class_exists('DOMDocument')) {
    die("<html><head><title>WP Piclens Error</title></head><body style=\"font-family: Courier New, Fixed, monospace;margin: 5px\"><p><center><b>ERROR</b>: WP Piclens <i>REQUIRES</i> PHP libxml Functions.<br/>See <a href=http://www.php.net/manual/en/ref.libxml.php>http://www.php.net/manual/en/ref.libxml.php</a></center></p></body></html>");
  }
}

// plplus: added two new actions: init and template_redirect
add_action('init', 'plplus_mrss_init');
add_action('template_redirect', 'plplus_mrss_prevent_feedburner', -10);

add_action('wp_head', 'wp_piclens_print_head');
add_filter('the_content', 'wp_piclens_content');
add_action('admin_menu',  'wp_piclens_add_admin_pages');

register_activation_hook( basename(__FILE__), 'wp_piclens_activate' );
register_deactivation_hook( basename(__FILE__), 'wp_piclens_deactivate' );
    

require_once('plplus-common-include.php');

//*****************************************************************************
//
// FUNCTION: plplus_getRequestFeedURI
//
// Takes the current webpage's request URI and converts this to the URI
// for the corresponding mrss feed.  No dependence on The Loop.
//
// Works well for single posts, but not for multi-post pages.
//
//*****************************************************************************
function plplus_getRequestFeedURI() {
	
	$request_uri = $_SERVER['REQUEST_URI'];
	
	// escape ampersands in the uri
	$request_uri = str_replace( "&", "&amp;", $request_uri );
	
	$web_uri = "http://" . $_SERVER['HTTP_HOST'] . $request_uri;

  return plplus_pageURItoFeedURI( $web_uri );
	
}  // plplus_getRequestFeedURI


//*****************************************************************************
//
// FUNCTION: plplus_getPostFeedURI
//
// Gets the permalink for the current post in The Loop and then converts this
// to a URI for the mrss feed for that post.
//
// Works well for multi-post pages, but fails when executed on page 2-N of an
// ngg gallery page.
//
//*****************************************************************************
function plplus_getPostFeedURI() {

  // if it is a single page or post
  if (is_single() || (is_page() && ! is_category() && ! is_tag()))
    return plplus_getRequestFeedURI();

  // otherwise, for multi-post pages
  
  $postPermLink = get_permalink();
  $postPermLink = str_replace("&", "&amp;", $postPermLink);
  $feedURI = plplus_pageURItoFeedURI( $postPermLink );
  
  return $feedURI;
  
}  // plplus_getPostFeedURI


//*****************************************************************************
//
// FUNCTION: wp_piclens_content
//
// modify the special tag with the actual link
//
//*****************************************************************************
function wp_piclens_content($content) {

//    // change piclens-flickr=url to a photo from the feed and insert PL link
//    $pattern = '/\[piclens-flickr=(http:\/\/api.flickr.com\/services\/feeds\/.*)\]/';
//    $count = preg_match_all($pattern, $content, $matches);
//    if ($count > 0) {
//        $feed = $matches[1][0];
//
//        // fetch the feed url
//        $feedXmlStr = httpReqUrl($feed);
//
//        // find the images in the xml feed
//        $imgPattern = '/<link rel="enclosure" type="image\/jpeg" href="(.*)" \/>/';
//        $imgCount = preg_match_all($imgPattern, $feedXmlStr, $matches);
//        $images = $matches[1];
//        
//        // pick a random photo
//        $randImgKey = array_rand($images, 1);
//        $imgUrl = $images["$randImgKey"];
//        $thumbUrl = contentUrlToThumbnail($imgUrl);
//        $imgHtml = '<a href="' . $imgUrl . '"><img src="' . $thumbUrl . '"></a>';
//        $content = preg_replace($pattern, $imgHtml, $content);
//    }
    
    // replace the [piclens-lite-link] tag with a link to start the piclens lite slideshow
    $wp_piclens_append_link = get_option('wp_piclens_append_link');
    $wp_piclens_link_text = get_option('wp_piclens_link_text');
    $wp_piclens_link_text = htmlspecialchars_decode($wp_piclens_link_text, ENT_QUOTES);
    $the_id = get_the_ID();
    $pattern = '/\[piclens-lite-link\]/';
    
    //plplus: changed the feed uri to be page-specific
    $link = '<a href="javascript:toggleStartStop();PicLensLite.start({feedUrl:\'' . plplus_getPostFeedURI() . '\'});">' . $wp_piclens_link_text . '</a>';

    // count the times we have the $pattern in the post.
    $count = preg_match_all($pattern, $content, $matches);
    if ($count > 0) {
        // replace the tag with our link.
        $content = preg_replace($pattern, $link, $content);
    } else {
        // we don't have the tag in the post, but lets see if we have images.
    	if ($wp_piclens_append_link == 'true') {
            // if we have images and the option is set we add a link to the end of the post.
            $pattern = '/<img /';
            $count = preg_match_all($pattern, $content, $matches);
            if ($count > 0) {
                $content .= $link;
            }
    	}
    }

    // change piclens-icon to the actual image
    $pattern = '/\[piclens-icon\]/';
    $count = preg_match_all($pattern, $content, $matches);
    
    // plplus: properly terminated the <img> tag
    // plplus: added class "no-mrss" to exclude image from feed.
    $img = '<img class="no-mrss" src="' . wp_piclens_base_uri() . '/PicLensButton.png" alt="PicLens" width="16" height="12" border="0" align="top"/>';
    if ($count > 0) {
        $content = preg_replace($pattern, $img, $content);
    }

    return $content;

}  //  wp_piclens_content


//*****************************************************************************
//
// FUNCTION: wp_piclens_add_admin_pages
//
//*****************************************************************************
function wp_piclens_add_admin_pages() {

    if (function_exists('add_options_page')) {
    // plplus: changed title of options page
        add_options_page(__('PicLens Plus'), __('PicLens Plus'), 'manage_options', basename(__FILE__), 'wp_piclens_options_page');
    }
    
}  // wp_piclens_add_admin_pages


//*****************************************************************************
//
// FUNCTION: wp_piclens_options_page
//
//*****************************************************************************
function wp_piclens_options_page() {

    $siteurl = get_option("siteurl");

    if (isset($_POST['option']) ) {
        $wp_piclens_option = attribute_escape($_POST['option']);
    }

    //plugin should be reset
    if ($wp_piclens_option == 'reset') {	

        if ( function_exists('check_admin_referer') ) {
            check_admin_referer($wp_piclens_nonce.'reset');
        }
        //so we delete all options from the DB:
        delete_option("wp_piclens_version_installed");
        delete_option("wp_piclens_feed_cache_age");
        delete_option("wp_piclens_feed_cache");
        delete_option("widget_piclens_options");
        delete_option("widget_piclens_active");
        delete_option("wp_piclens_link_text");
        delete_option("wp_piclens_append_link");
        ?>
        
        <div id="message" class="updated fade"><p><strong><?php _e('Plugin has been reset!') ?></strong></p></div>

		<div class="wrap">
			<h2><?php _e('Now you can...') ?></h2> 
			
				<?php 
				$plugin_file = attribute_escape($_GET['page']); 
				$plugin_file_path = __FILE__;
				$matches = array();
				preg_match( "/wp-content\/plugins\/(.*)/", $plugin_file_path, $matches);
				$plugin_file_and_dir = $matches[1];
				$deactivate_url = "plugins.php?action=deactivate&amp;plugin=".$plugin_file_and_dir;

				if ( function_exists('wp_nonce_url') ){
					$deactivate_url = wp_nonce_url("$deactivate_url", 'deactivate-plugin_' . $plugin_file);
				}
				
				echo '<a href="'.$deactivate_url.'">...';
				_e('deactivate the plugin');
				echo '</a> or <a href="options-general.php?page='.$plugin_file.'">';
				_e('start from scratch...');
				echo '</a><br /><br />'; 
				?>

		</div>
		<?php

    } elseif (!get_option('wp_piclens_version_installed')) {
    	//The plugin has not been installed yet, default parameters will be added to the DB
		wp_piclens_activate('reset');
		$wp_piclens_append_link = get_option("wp_piclens_append_link");
		$wp_piclens_link_text = get_option("wp_piclens_link_text");
		
		?>
		<div id="message" class="updated fade"><p><strong><?php _e('Plugin has been configured!') ?></strong></p></div>

		<?php
		
	} elseif ($wp_piclens_option == 'update') {	// Check if form data has been sent to update options

        if ( function_exists('check_admin_referer') ) {
			check_admin_referer($wp_piclens_nonce.'update');
		}
	
		if ( isset($_POST['wp_piclens_append_link']) ) {
			$wp_piclens_append_link = 'true';
		} else {
			$wp_piclens_append_link = 'false';
		}
		update_option('wp_piclens_append_link', $wp_piclens_append_link, '','');
		
		if ( isset($_POST['wp_piclens_link_text']) ) {
			$wp_piclens_link_text = $_POST['wp_piclens_link_text'];
			$wp_piclens_link_text = attribute_escape($wp_piclens_link_text);
			update_option('wp_piclens_link_text', $wp_piclens_link_text, '','');
		}
		?>

		<div id="message" class="updated fade"><p><strong><?php _e('Options saved.') ?></strong></p></div>

		<?php

    } else {	
        //no variables sent & plugin is installed and should not be reset, so let's get them from DB
        $wp_piclens_append_link = get_option("wp_piclens_append_link");
		$wp_piclens_link_text = get_option("wp_piclens_link_text");
	}	// end if updated == true	
	
	
	//show the main page only if plugin should not be reset
	if ( $wp_piclens_option != 'reset' || !isset($wp_piclens_option) ) {
		?>	

		<div class="wrap"> 
			<h2><?php _e('PicLens options') ?></h2> 
			<form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo( attribute_escape($_GET['page']) ); ?>">
			<p class="submit">
				<input type="hidden" name="option" value="update" />
				<input type="submit" name="Submit" value="<?php _e('Update options') ?> &raquo;" />
			</p>

			<?php 
			if ( function_exists('wp_nonce_field') ) {
				wp_nonce_field($wp_piclens_nonce.'update');
			}
			?>

			<fieldset class="options">
			<legend><?php _e('Link format and appearance'); ?></legend>
			<table width="100%" cellspacing="2" cellpadding="5" class="optiontable editform"> 
				<tr valign="top">
					<th width="33%" scope="row"><?php _e('Start PicLens Lite link text:'); ?></th> 
					<td><input name="wp_piclens_link_text" type="text" id="wp_piclens_link_text" value="<?php echo $wp_piclens_link_text; ?>" size="45" /> </td>
				</tr> 
				<tr valign="top">
					<th width="33%" scope="row"><?php _e('Automatically add PicLens Lite link to the bottom of any post with images?:'); ?></th> 
					<td valign="center"><input name="wp_piclens_append_link" type="checkbox" id="wp_piclens_append_link" <?php if ($wp_piclens_append_link == "true") {echo 'checked';} ?> /></td>
				</tr> 
			</table> 

			<legend><?php _e('Available PicLens Tags'); ?></legend>
			<table>
				<tr><td colspan="2">The PicLens Plugin allows you to insert the following tags in your posts:
				<ul>
				<li>[piclens-lite-link] - inserts a link with the text above to launch PicLens Lite for the current post
				<li>[piclens-icon] - inserts the PicLens icon (16 x 12 pixels)
				</ul>
				</td></tr>
			</table> 
			</fieldset>
						
			<p class="submit">
				<input type="hidden" name="option" value="update" />
				<input type="submit" name="Submit" value="<?php _e('Update options') ?> &raquo;" />
			</p>
			</form> 
		</div>
		
		<div class="wrap"> 
			<h2><?php _e('Reset PicLens plugin') ?></h2> 
			<form name="form3" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?page=<?php echo( attribute_escape($_GET['page']) ); ?>">
			<?php _e('Pressing the reset button does not delete any files. It just removes all settings from the database and asks you if you want to deactivate the plugin or start from scratch.'); ?>
			<p class="submit">
				<?php 
				if ( function_exists('wp_nonce_field') ) {
					wp_nonce_field($wp_simpleviewer_nonce.'reset'); 
				}
				?>
				<input type="hidden" name="option" value="reset" />
				<input type="submit" name="Submit" value="<?php _e('Reset PicLens plugin') ?> &raquo;" />
			</p>
			</form>
		</div>
	<?php
	}	//end if option != reset
	
}	// wp_piclens_options_page


//*****************************************************************************
//
// FUNCTION: wp_piclens_base_uri
//
// finds the path to the php code
//
//*****************************************************************************
function wp_piclens_base_uri() {
    return str_replace(ABSPATH, get_option('siteurl') . '/', dirname(__FILE__));
}


//*****************************************************************************
//
// FUNCTION: wp_piclens_print_head
//
// adds the required stylesheets and javascript to the page head
//
//*****************************************************************************
function wp_piclens_print_head() {
    // plplus: added $globalProduct and $globalVersion to the uri
    global $globalProduct;
    global $globalVersion;
    // plplus: changed the auto-discovery uri
    echo '
    <link rel="stylesheet" href="' . wp_piclens_base_uri() . '/piclens.css" type="text/css" />
    <script type="text/javascript" src="' . wp_piclens_base_uri() . '/javascript.php"></script>
    <script type="text/javascript" src="http://lite.piclens.com/current/piclens.js"></script>
    <style type="text/css">.mbf-item {display: none;}</style>
    ';
    
    while( have_posts() ) : the_post();

      $feedURI = plplus_getPostFeedURI();
      echo '
    <link rel="alternate" type="application/rss+xml" title="' . $globalProduct . '/' . $globalVersion . ' MediaRSS" href="' . $feedURI . '"/>';
    
    endwhile;

    echo "\n\n";
    
}  // wp_piclens_print_head


//*****************************************************************************
//
// FUNCTION: wp_piclens_activate
//
//*****************************************************************************
function wp_piclens_activate ($action) {

    global $globalURL, $globalVersion;
        if ($action == null) {
            $action = 'activate';
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
        
}  // wp_piclens_activate


//*****************************************************************************
//
// FUNCTION: wp_piclens_deactivate
//
//*****************************************************************************
function wp_piclens_deactivate () {
    global $globalURL, $globalVersion;
}

//*****************************************************************************
//
// FUNCTION: plplus_mrss_init
//
//*****************************************************************************
function plplus_mrss_init() {
  global $wp_rewrite;
  
	add_feed('mrss', 'plplus_do_feed_mrss');
	
	// update permalinks so that the new feed urls will work.
	$wp_rewrite->flush_rules();
}

//*****************************************************************************
//
// FUNCTION: plplus_do_feed_mrss
//
//*****************************************************************************
function plplus_do_feed_mrss() {
	load_template( dirname(__FILE__) . '/plplus-mrss.php');
}

//*****************************************************************************
//
// FUNCTION: plplus_mrss_prevent_feedburner
//
// Prevent an mrss feed from being redirected to Feedburner
//
//*****************************************************************************
function plplus_mrss_prevent_feedburner() {
	if ( 'mrss' == get_query_var('feed') )
		remove_action('template_redirect', 'ol_feed_redirect');
}

?>
