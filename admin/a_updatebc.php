<?php


include '../db.php';


// Define post fields into simple variables
$bc_day = $_POST['bc_day'];
$bc_week = $_POST['bc_week'];
$iit_bc = $_POST['iit_bc'];


/* Do some error checking on the form posted fields */


//Enter info into the Database.
$edit_bc_sql = mysql_query("UPDATE homepage SET bc_day='$bc_day', bc_week = '$bc_week',
iit_bc = '$iit_bc'") or die (mysql_error());


	$edit_bc_success = 1;
	include 'a_homepage.php';
	


?>
