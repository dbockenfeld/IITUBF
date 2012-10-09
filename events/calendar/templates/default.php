<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Calendar</title>
	<?php javaScript() ?>
	<link rel="stylesheet" type="text/css" href="css/default.css">
</head>
<body>


<div id='wrap'><div id='evheaderimg'>
<div id='headertop'></div>
<div class='homelink'><a href='http://www.iitubf.org'></a></div></div><div class="indentmenu">
<ul>
<li><a href='/biblestudy/biblestudy.html?doc_select=all'>Bible Study</a></li>
<li><a href='/events/events.html?event_select=featured' class='current'>Events</a></li>
<li><a href='/media/media.html?media_select=photos'>Media</a></li>
<li><a href='http://www.iit.edu'>Daily Bread</a></li>
<li><a href='http://www.iit.edu'>About Us</a></li>
<li><a href='http://www.iit.edu'>Contact</a></li>

<li><a href='http://www.iit.edu'>Resources</a></li>
</ul>
</div>

<div id='submenu'>

<div style='float:left; width:30px;'></div>
<div class='notcurrentpoint'></div>
<div style='float:left; width:120px;' class='notcurrentlink'><a href='../events.html?event_select=featured'>Featured </a></div>
<div class='notcurrentpoint'></div>
<div style='float:left; width:120px;' class='notcurrentlink'
><a href='../events.html?event_select=past'>Past Events</a></div>
<div class='subcurrentpoint'></div>
<div style='float:left; width:120px;' class='subcurrentlink'
><a href='http://localhost/events/calendar/index.php'>Calendar</a></div>

</div>


<div id='content'>

<div style='float:left; width:150px; background-color:transparent; border: 0px;'>
<br /><br />
<p />Sunday Worship Service:
<br />IIT Chapel - Sundays, 10AM

<br /><br /><br />
<p />IIT Bible Club:
<br />MTCC Yellow Room - Wednesdays, 7PM

<br /><br /><br />
<p />Friday Fellowship:
<br />IIT Chapel - Fridays, 7PM

</div>

<div id='articles'>

<br />

<br><br><br>

<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr>
	<td>
		<?php echo $scrollarrows ?>
		<span class="date_header">
		&nbsp;<?php echo $lang['months'][$m-1] ?>&nbsp;<?php echo $y ?></span>
	</td>

	<!-- form tags must be outside of <td> tags -->
	<form name="monthYear">
	<td align="right">
	<?php monthPullDown($m, $lang['months']); yearPullDown($y); ?>
	<input type="button" value="GO" onClick="submitMonthYear()">
	</td>
	</form>

</tr>

<tr>
	<td colspan="2" bgcolor="#000000">
	<?php echo writeCalendar($m, $y); ?></td>
</tr>

<tr>
	<td colspan="2" align="center">
	<?php echo footprint($auth, $m, $y) ?></td>
</tr>
</table>

<br />
<br />
</div>
</div>
<div id='footdt' ></div>
<div id='foot' style='padding-top:4px;'>
<div class='indnt'></div><span style='color:white;'>
Copyright 2007 IIT University Bible Fellowship</span>
</div>


</div>


</body>
</html>
