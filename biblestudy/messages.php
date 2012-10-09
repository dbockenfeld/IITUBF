<?php
	echo "<h4>Message Manuscripts</h4>
	<p />Messages are posted in order by most recent first.  You can click on the title or image to view the message, or right-click and Save As to download the file.";

	$sql_message = mysql_query("SELECT a.*, b.*  from posts a, category b where a.category_id = 1 and a.category_id = b.category_id order by post_date desc");

	//$sql_message = mysql_query("SELECT a.*, b.*  from posts a, category b where a.category_id = b.category_id order by post_date");


	$num_messages = mysql_num_rows($sql_message);


	for ($i=0; $i<$num_messages; $i++){

		$message_text = mysql_fetch_array($sql_message);

	$message_title = $message_text['title'];
	$message_description = $message_text['description'];
	$message_author = $message_text['author'];
	$message_date = $message_text['post_date'];
	$message_file = $message_text['filename'];
	$message_image = $message_text['category_image_file'];
	$message_category = $message_text['category'];
	$message_category_loc = $message_text['category_loc'];

echo "<br />
<div class='indnt'> </div>

<br />

<div style='float: left; width:30px;'> </div>
<div style='float:left;'>
<a href='"
.$message_category_loc."/"
.$message_file.
"'><img src='../images/"
.$message_image.
"' style='border:0px; height:50px; width:50px;' class='upds' /> </a>
</div>
<div class='indnt'> </div>
<div style='float:left; width:450px; padding-bottom:15px;'>
<a style='color:blue; font-weight:bold; font-size:large; text-decoration:underline;' href='"
.$message_category_loc."/"
.$message_file.
"'>"
.$message_title.
"</a> <br />"
.$message_description.
"<br />
<span style='font-size:x-small; font-weight:bold; color:brown;'>Category: <a style='font-weight:bold; color:brown; '
href='biblestudy.html?doc_select="
.$message_category_loc.
"'>"
.$message_category.
"</a> | Posted "
.date('m-d-Y',strtotime($message_date)).
"</span></div>
<div style='clear:both;'> </div>";

	}



	mysql_close($conn);

?>