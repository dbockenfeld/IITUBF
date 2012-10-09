<?php 



	include '../db.php';




$msgdate = date("Y-m-d");

/*
$msgresult = mysql_query("select distinct post_id, title, short_description
from posts
where category_id = 1
order by title");
*/

$msgresult = mysql_query("select distinct message_id, title, passage
from messages
order by title");

$nummsgrow = mysql_num_rows($msgresult);


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

</p>


	<p /><b>Add New Bible Study Row:</b>

	<form enctype='multipart/form-data' name='addmsg' method='post' action='a_addmsg.php'>

	<table class='reg'>
	
	<tr>
	<td class='left'> Title (Do not use <br /> apostrophes): </td>
	<td class='right'><input name='m_title1' type='text' id='m_title1'/></td>
	</tr>

	<tr>
	<td class='left'> *BRIEF* Description (use \" \' \" <br /> for apostrophe): </td>
	<td class='right'><textarea name='m_desc1' id='m_desc1' rows = '7' cols = '30' wrap = 'soft'></textarea></td>
	</tr>


	<tr>
	<td class='left'> Passage <br />(Use Abbreviated Book Names): </td>
	<td class='right'><input name='m_psg1' type='text' id='m_psg1'/></td>
	</tr>

	<tr>
	<td class='left'> Message File: </td>
	<td class='right'><input name='userfile' type='file' /></td>
	</tr>

	<tr>
	<td class='left'> Question File: </td>
	<td class='right'><input name='userfile2' type='file' /></td>
	</tr>

	</table>
	

	<p /><input type='submit' name='Submit' value='Add New' />
    <input type='reset' name='Reset' value='Reset' />
	<input name='m_date1' type='hidden' id='m_date1' value = '$msgdate' />
	
	</form>


<br />
<br />
<br />

<hr />

	<b>Or, Pick a Row to Update:</b>

	<form name='shownews' method='post' action='a_showmsg.php'>

	<table class='reg'>
	

	<tr>

	<td class='left'> Select Bible Study Item: </td>
	<td class='right'>

			<select name='m_post_id2' id='m_post_id2'>";



	for ($i=0; $i<$nummsgrow; $i++){

		$msgrow = mysql_fetch_array($msgresult);

       echo "<option value='".$msgrow['message_id']."'>".$msgrow['title']."  -  (".$msgrow['passage'].")</option>";

	}

echo "			</select>

	</td> 
	</tr> 

	</table>
				<p /><input type='submit' name='Submit' value='Display Record' />

	
	</form>";

	IF ($show_da_news == 1)
{
	
echo "	

<hr />
	
	<p /><b>Edit Bible Study Row:</b>

	<form enctype='multipart/form-data' name='editmsg' method='post' action='a_editmsg.php'>

	
	<table class='reg'>
	
	<tr>
	<td class='left'> Title (Do not use <br /> apostrophes):</td>
	<td class='right'><input name='m_title2' type='text' id='m_title2' value='".$em_title2."'/></td>
	</tr>

	<tr>
	<td class='left'> *BRIEF* Description (use \" \' \" <br /> for apostrophe):  </td>
	<td class='right'><textarea name='m_desc2' id='m_desc2' rows = '7' cols = '30' wrap = 'soft'>".$em_desc2."</textarea></td>
	</tr>


	<tr>
	<td class='left'> Passage <br />(Use Abbreviated Book Names): </td>
	<td class='right'><input name='m_psg2' type='text' id='m_psg2'  value='".$em_psg2."'/></td>
	</tr>

	</table>

	<br />
	<b>NOTE: YOU WILL NEED TO UPLOAD MESSAGE AND/OR QUESTION FILE AGAIN!!!</b>
	<br />
	<br />

	<table>

	<tr>
	<td class='left'> Message File: </td>
	<td class='right'><input name='userfile3' type='file' /></td>
	</tr>

	<tr>
	<td class='left'> Question File: </td>
	<td class='right'><input name='userfile4' type='file' /></td>
	</tr>

	</table>
	

	<p /><input type='submit' name='Submit' value='Edit Record' />
    <input type='reset' name='Reset' value='Reset' />
	<input name='m_titlef2' type='hidden' id='m_title2' value = '".$em_title2."' />
	<input name='m_psgf2' type='hidden' id='m_psgf2' value = '".$em_psg2."' />
	<input name='m_date2' type='hidden' id='m_date2' value = '$msgdate' />
	
	</form>";
	
	}

echo "	


</body>
</html>";
?>

