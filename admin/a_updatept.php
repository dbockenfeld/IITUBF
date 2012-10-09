<?php


include '../db.php';


// Define post fields into simple variables
$ws_week = $_POST['ws_week'];
$prayer_topics = $_POST['prayer_topics'];


/* Do some error checking on the form posted fields */


//Enter info into the Database.
$edit_bc_sql = mysql_query("UPDATE homepage SET ws_week = '$ws_week',
prayer_topics = '$prayer_topics'") or die (mysql_error());


	$edit_pt_success = 1;
	include 'a_homepage.php';
	


?>
