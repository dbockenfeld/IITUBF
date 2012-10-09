<?php
	echo "<h4>Past events</h4>
	<p />Here is a list of events that have past updated with reports.  If there are pictures, you can click on the event and it will take you to the photo area.";

	$sql_event = mysql_query("SELECT a.*, b.*  from posts a, category b where a.category_id = 3 and a.category_id = b.category_id order by post_date desc");

	//$sql_event = mysql_query("SELECT a.*, b.*  from posts a, category b where a.category_id = b.category_id order by post_date");


	$num_event = mysql_num_rows($sql_event);


	for ($i=0; $i<$num_event; $i++){

		$event_text = mysql_fetch_array($sql_event);

	$event_title = $event_text['title'];
	$event_description = $event_text['description'];
	$event_author = $event_text['author'];
	$event_date = $event_text['post_date'];
	$event_file = $event_text['filename'];
	$event_image = $event_text['category_image_file'];
	$event_category = $event_text['category'];
	$event_category_loc = $event_text['category_loc'];

echo "<br />
<div class='indnt'> </div>

<br />

<div style='float: left; width:30px;'> </div>
<div style='float:left;'>
<a href='"
.$event_category_loc."/"
.$event_file.
"'><img src='../images/"
.$event_image.
"' style='border:0px; height:50px; width:50px;' class='upds' /> </a>
</div>
<div class='indnt'> </div>
<div style='float:left; width:450px; padding-bottom:15px;'>
<a style='color:blue; font-weight:bold; font-size:large; text-decoration:underline;' href='"
.$event_category_loc."/"
.$event_file.
"'>"
.$event_title.
"</a> <br />"
.$event_description.
"<br />
<span style='font-size:x-small; font-weight:bold; color:brown;'>Category: <a style='font-weight:bold; color:brown; '
href='biblestudy.html?doc_select="
.$event_category_loc.
"'>"
.$event_category.
"</a> | Posted "
.date('m-d-Y',strtotime($event_date)).
"</span></div>
<div style='clear:both;'> </div>";

	}



	mysql_close($conn);

?>