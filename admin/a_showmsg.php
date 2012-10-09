<?php

include '../db.php';


// Define post fields into simple variables
$m_post_id2 = $_POST['m_post_id2'];



/* Let's strip some slashes in case the user entered
any escaped characters. */

$m_post_id2 = stripslashes($m_post_id2);



/* Do some error checking on the form posted fields */


 //Enter info into the Database.

$show_sql = mysql_query("SELECT * FROM messages WHERE message_id='$m_post_id2'") or die (mysql_error());

$showrow = mysql_fetch_array($show_sql);

$m_post_id2 = $showrow['message_id'];
$em_title2 = $showrow['title'];
$em_desc2 = $showrow['message_description'];
$em_psg2 = $showrow['passage'];



	$show_da_news = 1;
	include 'a_msg.php';
	


?>

