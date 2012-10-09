<?php


include '../db.php';



// Define post fields into simple variables
$m_title1 = $_POST['m_title1'];
$m_desc1 = $_POST['m_desc1'];
$m_psg1 = $_POST['m_psg1'];
$m_date1 = $_POST['m_date1'];
$m_filename1 = $_FILES['userfile']['name'];
$m_filename2 = $_FILES['userfile2']['name'];

$m_desc1q = "Questions for ".$m_psg1;


if ($m_filename1 != NULL) {
$uploaddir = '../biblestudy/messages/';
//$uploaddir = '/home/iitubf/iitubf.org/biblestudy/messages/';
$uploadfile = $uploaddir . $_FILES['userfile']['name'];


if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile))
	{ echo "<br />Message successfully uploaded<br />"; }

}

if ($m_filename2 != NULL) {

$uploaddir2 = '../biblestudy/questions/';
//$uploaddir2 = '/home/iitubf/iitubf.org/biblestudy/questions/';
$uploadfile2 = $uploaddir2 . $_FILES['userfile2']['name'];
if(move_uploaded_file($_FILES['userfile2']['tmp_name'], $uploadfile2))
	{ echo "<br />Questions successfully uploaded<br />"; }


}


/* Do some error checking on the form posted fields */


// Enter info into the Database.

/*
$add_msg_sql_bkup = mysql_query("INSERT INTO posts (category_id, media_id, title, description, 
short_description, post_date, author, filename) 
VALUES (1, 1, '$m_title1', '$m_desc1', '$m_psg1', 
'$m_date1', 'iitubf', '$m_filename1')") or die (mysql_error());

$add_ques_sql_bkup = mysql_query("INSERT INTO posts (category_id, media_id, title, description, 
short_description, post_date, author, filename) 
VALUES (2, 1, '$m_title1', '$m_desc1q', '$m_psg1', 
'$m_date1', 'iitubf', '$m_filename2')") or die (mysql_error());
*/

$add_msg_sql = mysql_query("INSERT INTO messages (title, message_description, 
passage, posted_date, message_author, message_file, question_file, posted_by, updated_by, updated_date) 
VALUES ('$m_title1', '$m_desc1', '$m_psg1', 
'$m_date1', 'iitubf', '$m_filename1', '$m_filename2', 'iitubf', 'iitubf', now())") or die (mysql_error());


	$add_msg_success = 1;
	$show_da_msg = 0;
	include 'msg_success.php';
	


?>
