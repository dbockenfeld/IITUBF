<?php
/*
Plugin Name: Picasa Web widget
Description: Shows pictures from Picasa Web RSS feeds.
Author: Otto
Version: 1.6
Author URI: http://ottodestruct.com
*/

function widget_picasawebwidget_init()
{
	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// main widget function
	function widget_picasawebwidget($args) {
		require_once(ABSPATH . WPINC . '/rss-functions.php');

		// get my options
		extract($args);
		$options = get_option('widget_picasawebwidget');
		$title = $options['title'];
		$feeds = $options['feeds'];
		$link = $options['link'];
		$showdes = $options['showdes'];
		$delay = $options['delay'];
		$random = $options['random'];
		$shownum = $options['shownum'];
		$maxnum = $options['maxnum'];
		$rotate = $options['rotate'];

		// split the feeds into a list
		$feedlist = preg_split('/\s+/', $feeds, -1, PREG_SPLIT_NO_EMPTY);
		
		$cacheurl = get_settings('siteurl').'/wp-content/plugins/picasawebcache/';
		$cachedir = ABSPATH."wp-content/plugins/picasawebcache/";
		
		// get all the photos from all the feeds
		$count = 0;
		foreach ($feedlist as $feed)
		{
			$feedContent = @fetch_rss($feed);
			$feedItems = $feedContent->items;
			
			// for debugging only
			//echo "<!--".$feed."\n";var_dump($feedItems);echo "-->\n";
			
			// make sure we got a feed back
			if ($feedContent != false)
			
			// get the relevant data out of the feed items
			foreach ($feedItems as $key=>$row)
			{
				$photos[$count]['link'] = $row['link'];
				$photos[$count]['thumbURL'] = $row['photo']['thumbnail'];
				$photos[$count]['fullURL'] = $row['photo']['imgsrc'];
				$photos[$count]['description'] = $row['description'];
				
				// cache the images
				preg_match('{http://.*\.google\.com/.*/([^.]*\.(jpg|png|gif))}i', $photos[$count]['thumbURL'], $picasaWebSlugMatches);
				
				$picasaWebSlug = rawurldecode($picasaWebSlugMatches[1]);
				
				// check if file already exists in cache
				// if not, grab a copy of it
				if (!file_exists($cachedir.$picasaWebSlug)
					|| filesize($cachedir.$picasaWebSlug) == 0)
				{   
					if ( function_exists('curl_init') ) { // check for CURL, if not use fopen
						$curl = curl_init();
						$localimage = fopen($cachedir.$picasaWebSlug, "wb");
						curl_setopt($curl, CURLOPT_URL, $photos[$count]['thumbURL']);
						curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
						curl_setopt($curl, CURLOPT_FILE, $localimage);
						curl_exec($curl);
						curl_close($curl);
					} else {
						$filedata = "";
						$remoteimage = fopen($photos[$count]['thumbURL'], 'rb');
						if ($remoteimage) {
							while(!feof($remoteimage)) {
							$filedata.= fread($remoteimage,1024*8);
							}
						}
						fclose($remoteimage);
						$localimage = fopen($cachedir.$picasaWebSlug, 'wb');
						fwrite($localimage,$filedata);
						fclose($localimage);
					} // end CURL check
				} // end file check
				
				// assume we got the thumbnail, so build the url to it
				$photos[$count]['thumbURL'] = $cacheurl.$picasaWebSlug;
				
				$count++;
			}
		}
		
		// randomize the images (works even for multiple images)
		if ($random) {
			// create a count array
			for ($i = 0; $i<$count;$i++)
			{
				$countArr[$i] = $i;
			}
			// shuffle the count array
			$rands = array_rand($countArr,sizeof($countArr));
			// $rands is now a shuffled index into the photos array
		} else { 
			for ($i = 0; $i<$count;$i++)
			{
				$rands[$i] = $i;
			}
		}
		
		// deal with maxnum == 0
		if ($maxnum == 0) $maxnum = $count;

		// standard stuff
		echo $before_widget;
		$title ? print($before_title . $title . $after_title) : null;
		?>
		<div class="picasawebwidget">
		<?php 
		
		// show the images
		for ($i=0; $i< $shownum; $i++)
		{
			// generate the relevant code to rotate and display the images 
			if ($link)
			{
				echo "<a title=\"".$photos[$rands[$i]]['description']."\" ";
				if ($shownum == 1) echo "id=\"picasaweblink\" ";
				echo "href=\"".$photos[$rands[$i]]['link']."\">\n"; 
			}
			echo "<img src=\"".$photos[$rands[$i]]['thumbURL']."\" ";
			if ($shownum == 1) echo "id=\"picasawebslide\" ";
			echo "class=\"picasawebslide\" alt=\"".$photos[$rands[$i]]['description']."\"/>\n";
			if ($link) echo "</a>\n";
			if ($showdes) 
			{
				echo "<p class=\"picasawebdescription\"";
				if ($shownum == 1) echo " id=\"picasawebdescription\"";
				echo ">".$photos[$rands[$i]]['description']."</p>\n";
			}
		}
		
		// javascript to rotate the images
		if ($shownum == 1 && $rotate) {
		?>
<script type="text/javascript">//<!--
		<?php
		$i=1;
		foreach ($rands as $x)
		{
			echo "var image".$i."=new Image();\n";
			echo "image".$i.".src=\"".$photos[$x]['thumbURL']."\";\n";
			echo "image".$i.".alt=\"".$photos[$x]['description']."\";\n";
			if ($link) echo "var link".$i."=\"".$photos[$x]['link']."\";\n";
			$i++;
			if ($i > $maxnum) break;
		}
		?>
var step=1;
var whichimage=1;
function picasawebslideit() {
	if (!document.images) return;
	document.getElementById('picasawebslide').src=eval("image"+step+".src");
	document.getElementById('picasawebslide').alt=eval("image"+step+".alt");
<?php if ($link) { ?>
	document.getElementById('picasaweblink').href=eval("link"+step);
	document.getElementById('picasaweblink').title=eval("image"+step+".alt");
<?php } ?>
<?php if ($showdes && $shownum == 1) { ?>
	document.getElementById('picasawebdescription').childNodes[0].nodeValue = eval("image"+step+".alt");
<?php } ?>
	whichimage=step;
	if (step<<?php echo $maxnum; ?>) step++; 
	else step=1;
	setTimeout("picasawebslideit()",<?php echo $delay; ?>)
}		

picasawebslideit();
//-->
</script>
		<?php 
		}
		
		// cleanup
		echo "</div>\n";
		echo $after_widget;
	}

	// control panel
	function widget_picasawebwidget_control() {
		$options = $newoptions = get_option('widget_picasawebwidget');
		if ( $_POST["picasawebwidget-submit"] ) {
			$newoptions['title'] = trim(strip_tags(stripslashes($_POST["picasawebwidget-title"])));
			$newoptions['shownum'] = trim(strip_tags(stripslashes($_POST["picasawebwidget-shownum"])));
			$newoptions['maxnum'] = trim(strip_tags(stripslashes($_POST["picasawebwidget-maxnum"])));
			$newoptions['feeds'] = strip_tags(stripslashes($_POST["picasawebwidget-feeds"]));
			$newoptions['link'] = isset($_POST["picasawebwidget-link"]);
			$newoptions['showdes'] = isset($_POST["picasawebwidget-showdes"]);
			$newoptions['rotate'] = isset($_POST["picasawebwidget-rotate"]);
			$newoptions['random'] = isset($_POST["picasawebwidget-random"]);
			$newoptions['delay'] = trim(strip_tags(stripslashes($_POST["picasawebwidget-delay"])));;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_picasawebwidget', $options);
		}
		$title = $options['title'];
		$feeds = $options['feeds'];
		$delay = $options['delay'];
		$shownum = $options['shownum'];
		$maxnum = $options['maxnum'];
		$link = $options['link'] ? 'checked="checked"' : '';
		$showdes = $options['showdes'] ? 'checked="checked"' : '';
		$random = $options['random'] ? 'checked="checked"' : '';
		$rotate = $options['rotate'] ? 'checked="checked"' : '';
		
		if (empty($delay)) $delay ='5000';
		if (empty($shownum)) $shownum ='1';
		if (empty($maxnum)) $maxnum ='0';
		?>
		<p><label for="picasawebwidget-title">Give the widget a title (optional):</label>
		<input style="width: 100%;" id="picasawebwidget-title" name="picasawebwidget-title" type="text" value="<?php echo $title; ?>" /></p>
		<p style="text-align:center;"><label for="picasawebwidget-feeds">Enter the Picasa Web feed URIs here (one per line):<br /></label></p>
		<textarea style="width: 100%; height: 60px;" id="picasawebwidget-feeds" name="picasawebwidget-feeds"><?php echo $feeds; ?></textarea>
		<p><label for="picasawebwidget-delay">Delay time between images (in milliseconds):</label>
		<input style="width: 30%;" id="picasawebwidget-delay" name="picasawebwidget-delay" type="text" value="<?php echo $delay; ?>" /></p>
		<p style='text-align: center; line-height: 30px;'><label for="picasawebwidget-link">Make thumbnails link to picasaweb.google.com photos: <input class="checkbox" type="checkbox" <?php echo $link; ?> id="picasawebwidget-link" name="picasawebwidget-link" /></label></p>
		<p style='text-align: center; line-height: 30px;'><label for="picasawebwidget-showdes">Show description underneath image (when available):<input class="checkbox" type="checkbox" <?php echo $showdes; ?> id="picasawebwidget-showdes" name="picasawebwidget-showdes" /></label></p>
		<p style='text-align: center; line-height: 30px;'><label for="picasawebwidget-random">Show photos in random order: <input class="checkbox" type="checkbox" <?php echo $link; ?> id="picasawebwidget-random" name="picasawebwidget-random" /></label></p>
		<p style='text-align: center; line-height: 30px;'><label for="picasawebwidget-rotate">Rotate photos with javascript: <input class="checkbox" type="checkbox" <?php echo $rotate; ?> id="picasawebwidget-rotate" name="picasawebwidget-rotate" /></label></p>
		<p><label for="picasawebwidget-maxnum">Maximum number of photos to show in rotation (0 for all):</label>
		<input style="width: 30%;" id="picasawebwidget-maxnum" name="picasawebwidget-maxnum" type="text" value="<?php echo $maxnum; ?>" /></p>
		<p><label for="picasawebwidget-shownum">Show how many photos at once (more than one disables rotate):</label>
		<input style="width: 30%;" id="picasawebwidget-shownum" name="picasawebwidget-shownum" type="text" value="<?php echo $shownum; ?>" /></p>		
		<input type="hidden" id="picasawebwidget-submit" name="picasawebwidget-submit" value="1" />
	<?php
	}

	register_sidebar_widget('Picasa Web', 'widget_picasawebwidget');
	register_widget_control('Picasa Web', 'widget_picasawebwidget_control', 600, 480);
}

// Tell Dynamic Sidebar about our new widget and its control
add_action('plugins_loaded', 'widget_picasawebwidget_init');

?>
