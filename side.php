<?php

	include_once 'db.php';

//------------------------------------------------------------------------	
//--- Worship Service Info -----------------------------------------------	
//------------------------------------------------------------------------	
	
	$query  = 'SELECT title, passage, message_description, message_file, question_file, posted_date';
	$query .= '  FROM messages';
	$query .= ' ORDER BY posted_date DESC LIMIT 0,1';
	
	$sql_message = mysql_query($query);
	$message_text = mysql_fetch_array($sql_message);

	$message_title = $message_text['title'];
	$message_description = $message_text['message_description'];
	$message_passage = $message_text['passage'];
	$message_date = $message_text['posted_date'];
	$message_file = $message_text['message_file'];
	$message_category = "Messages";

	$question_description = "Questions for ".$message_passage;
	$question_file = $message_text['question_file'];
	$question_category = "Questions";

//------------------------------------------------------------------------	
//--- Offering Info ------------------------------------------------------	
//------------------------------------------------------------------------	
	
	$query  = 'SELECT *';
	$query .= '  FROM offering_side';
	$query .= ' WHERE active = 1 LIMIT 0,1';

	$sql_offering = mysql_query($query);
	$offering = mysql_fetch_array($sql_offering);
	
//------------------------------------------------------------------------	
//--- Friday Info --------------------------------------------------------	
//------------------------------------------------------------------------	
	
	$today = date('Y-m-d H:i:s');
	$query  = 'SELECT *';
	$query .= '  FROM friday_night';
	$query .= ' WHERE date > "'.$today.'" LIMIT 0,1';

	$sql_friday = mysql_query($query);
	$friday = mysql_fetch_array($sql_friday);

?>




<div id='side'>

	<div id='ws'>
    	<span style='font-weight:bold;'>Most Recent Message</span><br /> <span style='font-size:x-small; color: white;'>Updated: <?php echo date('F j, Y',strtotime($message_date)); ?></span><br /><br />
		<span style='font-weight:bold;'><?php echo $message_title; ?></span><br />
		<?php echo $message_passage; ?>
		<br />
		<p style='font-size:11px;line-height:14px;'><?php echo $message_description; ?></p>
        <p style='font-size:11px; text-align:right;width:100%'>
			<a onclick="javascript:pageTracker._trackEvent('PDF','Download','<?php echo $message_passage.' Sermon'; ?>'); void(0);" style='color: #F0FFFF; font-weight:bold; text-decoration:underline;' href='<?php echo $base_dir;?>biblestudy/messages/
			<?php echo $message_file; ?>' target="_blank">Message</a> | 
			<a onclick="javascript:pageTracker._trackEvent('PDF','Download',<?php echo $message_passage.' Questions'; ?>'); void(0);" style='color: #F0FFFF; font-weight:bold; text-decoration:underline;' href='<?php echo $base_dir;?>biblestudy/questions/
			<?php echo $question_file; ?>' target="_blank">Questions</a>
        </p>
	</div>	
    
  	<!-- <script src="http://widgets.twimg.com/j/2/widget.js"></script> -->
	<!-- <script src="http://twitter.com/javascripts/widgets/widget.js"></script> -->
<?php	echo '<script src="'.$base_dir.'js/widget.js"></script>';?>
    <div id="announce">
<!--
    	<div id="announce_hd">
        </div>
-->
		<a class="twitter-timeline" data-dnt=true href="https://twitter.com/iitubf" data-widget-id="248774763600805888">Tweets by @iitubf</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>






<!--
		<script>
        new TWTR.Widget({
          version: 2,
          type: 'faves',
          rpp: 30,
          interval: 6000,
          /*title: 'Announcements',
          subject: 'IIT UBF',*/
          width: 352,
          height: 200,
          theme: {
            shell: {
              background: '#545454',
              color: '#ffffff'
            },
            tweets: {
              background: '#DDD',
              color: '#333',
              links: '#cc0000'
            }
          },
          features: {
            scrollbar: false,
            loop: true,
            live: true,
            hashtags: true,
            timestamp: true,
            avatars: true,
            behavior: 'default'
          }
        }).render().setUser('iitubf').start();
        </script>
-->
<!--
    	<div id="announce_ft">
        	<p class="follow"><a href="http://www.twitter.com/iitubf" target="_blank">Follow</a></p>
        </div>
-->
    </div>
	<!-- <div id="pt">
    	<div id="pt_hd"></div>
		<script>
        new TWTR.Widget({
          version: 2,
          type: 'search',
          search: '#iitubfprays OR #prayproj',
          interval: 4000,
          title: 'Prayer Topics',
          subject: '#iitubfprayer',
          width: 352,
          height: 150,
          theme: {
            shell: {
              background: '#8ec1da',
              color: '#ffffff'
            },
            tweets: {
              background: '#cdcdbd',
              color: '#333',
              links: '#cc0000'
            }
          },
          features: {
            scrollbar: false,
            loop: true,
            live: true,
            hashtags: true,
            timestamp: true,
            avatars: true,
            toptweets: false,
            behavior: 'default'
          }
        }).render().start();
        </script>
        <div id="pt_ft">
        	<p class="follow"><a href="http://twitter.com/#!/search/%23iitubfprays%20OR%20%23prayproj" target="_blank">Follow</a></p>
        </div>
    </div> -->
	
    <!--<div id='nbc'>
		<span style='font-weight:bold;'>Prayer Topics/Special Announcements</span>
		<br /><span style='font-size:10px;'>Updated: <?php echo date('m-d-Y', strtotime($prayer_topics_updated_date)); ?></span>
		<br />
		<?php echo $prayer_topics; ?>
	</div>-->
	
    <!-- <div id='bc4'>
		<div style='position: relative; top: 90px;text-align:right; width:168px; left: 166px; color: black; font-weight: bold; font:86% Arial,sans-serif'><?php echo $bc_loc." at ".$bc_time.""; ?>
		</div>
        <div class="bctext">
		Next Meeting: <?php echo $bc_day.", ".date('m-d-Y', strtotime($bc_week)); ?><br /><br />
		<?php echo $iitbc_announce; ?>
        </div>
	</div> -->
    <div id='fb'>
<!-- 		<div id="fb_hd"></div> -->
		<iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fiitubf&amp;width=352&amp;colorscheme=light&amp;show_faces=true&amp;stream=true&amp;header=false&amp;height=555" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:352px; height:555px;" allowTransparency="true"></iframe>
	</div>
    
    <?php
/*
	if ($offering['image'] != '') {
	    echo '<div id="giving">';
    	if ($offering['link'] == '') {
			echo '<img src="'. $base_dir.'images/'.$offering['image'].'" />';
		}
		else {
			echo '<a href="'.$offering['link'].'">';
			echo '<img src="'. $base_dir.'images/'.$offering['image'].'" />';
			echo '</a>';
		}
    	echo '</div>';
	}

	if ($friday['image'] != '') {
	    echo '<div id="fn">';
    	if ($friday['link'] == '') {
			echo '<img src="'. $base_dir.'images/'.$friday['image'].'" />';
		}
		else {
			echo '<a href="'.$offering['link'].'">';
			echo '<img src="'. $base_dir.'images/'.$friday['image'].'" />';
			echo '</a>';
		}
    	echo '</div>';
	}
*/


	?>
    

</div>