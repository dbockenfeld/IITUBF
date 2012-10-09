<?php
$dbhost = 'iitubfdb.iitubf.org';
$dbuser = 'iitubf';
$dbpass = 'Ps4lm6620';

$conn = mysql_connect($dbhost, $dbuser, $dbpass) or die ('Error connecting to mysql');

$dbname = 'iitubfdb';
mysql_select_db($dbname);

$bottomlinks=
"<div id='botlinks'>
<a href='/biblestudy/biblestudy.html?doc_select=all&doc_order=post_date'>Bible Study</a> |
<a href='/blog'>Blog</a> |
<a href='/events/events.html?event_select=featured'>Events</a> |
<a href='/media/gallery.php'>Photos</a> |
<a href='/daily_bread/daily_bread.html'>Daily Bread</a> |
<a href='/about_us/about_us.html'>About Us</a> |
<a href='/contact/contact.html'>Contact</a> |
<a href='/resources/resources.html'>Resources</a>
</div>";
?> 
