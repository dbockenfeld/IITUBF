<?php


include '../db.php';



// Define post fields into simple variables
$m_title2 = $_POST['m_title2'];
$m_desc2 = $_POST['m_desc2'];
$m_psg2 = $_POST['m_psg2'];
$m_date2 = $_POST['m_date2'];
$m_titlef2 = $_POST['m_titlef2'];
$m_psgf2 = $_POST['m_psgf2'];
$m_filename3 = $_FILES['userfile3']['name'];
$m_filename4 = $_FILES['userfile4']['name'];

$m_desc2q = "Questions for ".$m_psg2;

//$edit_get_msg_key_sql2 = mysql_query("select post_id from posts WHERE
//title = '$m_titlef2' AND short_description = '$m_psgf2' AND category_id = 1") or die (mysql_error());

$edit_get_msg_key_sql = mysql_query("select message_id from messages WHERE
title = '$m_titlef2' AND passage = '$m_psgf2'") or die (mysql_error());


$edit_get_msg_key = mysql_fetch_array($edit_get_msg_key_sql);

//$edit_msg_key2 = $edit_get_msg_key['post_id'];

$edit_msg_key = $edit_get_msg_key['message_id'];

/*
$edit_get_ques_key_sql = mysql_query("select post_id from posts WHERE
title = '$m_titlef2' AND short_description = '$m_psgf2' AND category_id = 2") or die (mysql_error());

$edit_get_ques_key = mysql_fetch_array($edit_get_ques_key_sql);

$edit_ques_key = $edit_get_ques_key['post_id'];
*/

//echo $edit_msg_key."<br />".$edit_ques_key;

if ($m_filename3 != NULL) {
$uploaddir3 = '/home/iitubf/iitubf.org/biblestudy/messages/';
$uploadfile3 = $uploaddir3 . $_FILES['userfile3']['name'];


if(move_uploaded_file($_FILES['userfile3']['tmp_name'], $uploadfile3))
	{ echo "<br />Message successfully uploaded<br />"; }

$update_message_file = mysql_query("UPDATE messages SET message_file='$m_filename3' WHERE
message_id = $edit_msg_key") or die (mysql_error());

}

if ($m_filename4 != NULL) {

$uploaddir4 = '/home/iitubf/iitubf.org/biblestudy/questions/';
$uploadfile4 = $uploaddir4 . $_FILES['userfile4']['name'];
if(move_uploaded_file($_FILES['userfile4']['tmp_name'], $uploadfile4))
	{ echo "<br />Questions successfully uploaded<br />"; }

$update_question_file = mysql_query("UPDATE messages SET question_file='$m_filename4' WHERE
message_id = $edit_msg_key") or die (mysql_error());

}


/* Do some error checking on the form posted fields */


//Enter info into the Database.

$edit_msg_sql = mysql_query("UPDATE messages SET title='$m_title2', message_description = '$m_desc2',
passage = '$m_psg2', updated_date = now() WHERE
message_id = $edit_msg_key") or die (mysql_error());


/*
$edit_msg_sql = mysql_query("UPDATE posts SET title='$m_title2', description = '$m_desc2',
short_description = '$m_psg2', filename='$m_filename3' WHERE
post_id = $edit_msg_key") or die (mysql_error());

$edit_ques_sql = mysql_query("UPDATE posts SET title='$m_title2', description = '$m_desc2q',
short_description = '$m_psg2', filename='$m_filename4' WHERE
post_id = $edit_ques_key") or die (mysql_error());
*/

	$edit_msg_success = 1;
	$show_da_msg = 0;
	include 'msg_success.php';
	


?>
