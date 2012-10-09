<?php 
	include '../db.php';

$bcresult = mysql_query("select iit_bc, bc_day, bc_week
from homepage");

$bcrow = mysql_fetch_array($bcresult);



$ptresult = mysql_query("select ws_week, prayer_topics
from homepage");

$ptrow = mysql_fetch_array($ptresult);

echo "<!DOCTYPE html
PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN'
'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>

<head>
<title>iitubf admin</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
</head>

<body>

 <br />

	<p /><b>Current Bible Club Information:</b>

	<br />
	<br />

	<table class='reg'>
	
	<tr>
	<td class='left'> Meeting Day of Week: </td>
	<td class='right'>".$bcrow['bc_day']."</td>
	</tr>

	<tr>
	<td class='left'><br /> Meeting Date: </td>
	<td class='right'><br />".$bcrow['bc_week']."</td>
	</tr>

	<tr>
	<td class='left'><br /> Description: </td>
	<td class='right'><br />".$bcrow['iit_bc']."</td>
	</tr>

	</table>

	<br />
	<br />


	<p /><b>Update Bible Club Information:</b>

	<form enctype='multipart/form-data' name='updatebc' method='post' action='a_updatebc.php'>

	<table class='reg'>
	
	<tr>
	<td class='left'> Meeting Day of Week: </td>
	<td class='right'>
	
	<select name='bc_day' id='bc_day'><option value='SUN'>SUN</option>
	<option value='MONDAY'>MONDAY</option>
	<option value='TUESDAY'>TUESDAY</option>
	<option value='WEDSNESDAY'>WEDSNESDAY</option>
	<option value='THURSDAY' SELECTED >THURSDAY</option>
	<option value='FRIDAY'>FRIDAY</option>
	<option value='SATURDAY'>SATURDAY</option>
	</select>

	</td>
	</tr>

	<tr>
	<td class='left'><br /> Meeting Date (Please use YYYY-MM-DD format): </td>
	<td class='right'><br /> <input name='bc_week' type='text' id='bc_week'/></td>
	</tr>

	<tr>
	<td class='left'><br /> *BRIEF* Description (use \" \' \" <br /> for apostrophe): </td>
	<td class='right'><br /> <textarea name='iit_bc' id='iit_bc' rows = '7' cols = '30' wrap = 'soft'></textarea></td>
	</tr>

	</table>

	<br />
	<br />
	****CLICK UPDATE TO UPDATE, THEN PLEASE CLOSE YOUR BROWSER WHEN YOU ARE FINISHED UPDATING!****
	<br />
	<br />
	<p /><input type='submit' name='Submit' value='Update' />
    <input type='reset' name='Reset' value='Reset' />


	
	</form>


<br />
<hr />
<br />


<p /><b>Current Prayer Topics:</b>

	<br />
	<br />

	<table class='reg'>

	<tr>
	<td class='left'><br /> Prayer Topic Update Date: </td>
	<td class='right'><br />".$ptrow['ws_week']."</td>
	</tr>

	<tr>
	<td class='left'><br /> Prayer Topics: </td>
	<td class='right'><br />".$ptrow['prayer_topics']."</td>
	</tr>

	</table>

	<br />
	<br />


	<p /><b>Update Prayer Topics:</b>

	<form enctype='multipart/form-data' name='updatept' method='post' action='a_updatept.php'>

	<table class='reg'>

	<tr>
	<td class='left'><br /> Update Date (Please use YYYY-MM-DD format): </td>
	<td class='right'><br /> <input name='ws_week' type='text' id='ws_week'/></td>
	</tr>

	<tr>
	<td class='left'><br /> *BRIEF* Prayer Topics (use \" \' \" <br /> for apostrophe, or HTML if you know some): </td>
	<td class='right'><br /> <textarea name='prayer_topics' id='prayer_topics' rows = '7' cols = '30' wrap = 'soft'></textarea></td>
	</tr>

	</table>

	<br />
	<br />
	****CLICK UPDATE TO UPDATE, THEN PLEASE CLOSE YOUR BROWSER WHEN YOU ARE FINISHED UPDATING!****
	<br />
	<br />
	<p /><input type='submit' name='Submit' value='Update' />
    <input type='reset' name='Reset' value='Reset' />


	
	</form>

</body>
</html>";
?>

