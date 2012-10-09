<?php
	$base_dir = "../";
	include_once '../db.php';

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
//--- Worship Service Passage Info ---------------------------------------	
//------------------------------------------------------------------------	
	
	$sunday = date('Y-m-d', strtotime('next Sunday'));

	$query  = 'SELECT date, book, verses, title, summary';
	$query .= '  FROM ws_passages';
	$query .= ' WHERE date = "'.$sunday.'"';
//	$query .= ' ORDER BY date DESC LIMIT 0,1';
	
	$sql = mysql_query($query);
	$weekly_text = mysql_fetch_array($sql);

	$ws_date = $weekly_text['date'];
	$ws_passage = $weekly_text['book'].' '.$weekly_text['verses'];
	$ws_title = $weekly_text['title'];
	$ws_summary = $weekly_text['summary'];

//------------------------------------------------------------------------	
//--- Worship Service Series Info ----------------------------------------	
//------------------------------------------------------------------------	
	
//	$sunday = date('Y-m-d', strtotime('next Sunday'));

	$query  = 'SELECT start_date, end_date, image518';
	$query .= '  FROM ws_series';
	$query .= ' WHERE start_date <= "'.$sunday.'"';
	$query .= '   AND end_date >= "'.$sunday.'"';
//	$query .= ' ORDER BY date DESC LIMIT 0,1';
	
	$sql = mysql_query($query);
	$series = mysql_fetch_array($sql);

	$ws_start_date = $series['start_date'];
	$ws_image = $series['image518'];
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='../iitubf.css' />
	<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		var pageTracker = _gat._getTracker("UA-5732686-1");
		pageTracker._trackPageview();
	</script>

</head>



<body style="background:#FFF;">
	<div id="fb_content">
	    <!--<img src="<? echo $base_dir;?>/images/ws_title.jpg"/>
		<br/>
		<div id="fb_ws_time">
			<p>Sundays at 10am</p>
			<p>IIT's E1 Crawford Auditorium</p>
		</div>-->
		<div id='fb_ws'>
			<p style="font-weight:bold;padding-bottom:0px;">Most Recent Message</p> 
			<p style='font-size:12px; color: white;'>Updated: <?php echo date('F j, Y',strtotime($message_date)); ?></p><br />
			<span style='font-weight:bold;'><?php echo $message_title; ?></span><br />
			<span style='font-size:12px;'><?php echo $message_passage; ?></span>
			<br />
			<p style='line-height:18px;'><?php echo $message_description; ?></p>
			<p style='font-size:13px; text-align:right;width:100%'>
				<a onclick="javascript:pageTracker._trackEvent('PDF','Download','<?php echo $message_passage.' Message'; ?>'); void(0);" style='color: #F0FFFF; font-weight:bold; text-decoration:underline;' href='<?php echo $base_dir;?>biblestudy/messages/
				<?php echo $message_file; ?>' target="_blank">Message</a> | 
				<a onclick="javascript:pageTracker._trackEvent('PDF','Download','<?php echo $message_passage.' Questions'; ?>'); void(0);" style='color: #F0FFFF; font-weight:bold; text-decoration:underline;' href='<?php echo $base_dir;?>biblestudy/questions/
				<?php echo $question_file; ?>' target="_blank">Questions</a>
			</p>
		</div>	


		<div id="fb_next">
			<p style="font-weight:bold;padding-bottom:0px;">Next Message</p> 
<?php 
			if ($ws_date != '') {
				echo ' <p style="font-size:x-small;">'.date('F j, Y',strtotime($ws_date)).'</p><br/>'; 
				echo ' <p style="font-weight:bold;padding-bottom:0px;">'. $ws_title.'</p>';
				echo ' <p>'. $ws_passage.'</p>';
				if ($ws_summary != '')
					echo ' <p>'. $ws_summary.'</p>';
			}
?>
		</div>
		<div id="fb_current">
			<p style="font-weight:bold;padding-bottom:0px;">Current Series</p>
			<img src="<? echo $base_dir.'/images/'.$ws_image;?>" width="502"/>
		</div>
	</div>

</body>
</html>