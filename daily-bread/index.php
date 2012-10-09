<?php
	require_once '../config.php';
	require_once '../header.php';
	$base_dir = '../';
?>
		<section id="main">
<?php

	include $root.'side.php';

?>


<div id='content'>

	<div id='contentb'>
		<img src='<? echo $root;?>images/daily_bread-sbhdr.jpg' />
		<div id='contentc'>

		<!--<h1>UBF Daily Bread</h1>-->

			<?php 
			$dailybread_feed_contents = file_get_contents('http://www.iitubf.org/rssfeeds/rss2html.php?XMLFILE=http://ubf.org/dbrss.php&TEMPLATE=http://www.iitubf.org/rssfeeds/dailybread_template.html'); 

			echo $dailybread_feed_contents;
			?>


			<br />
			Daily Bread posted from <a href='http://www.ubf.org/daily_bread.php'>http://www.ubf.org/daily_bread.php</a>
			<a href='http://ubf.org/dbrss.php' style='padding-left: 10px;'><img src='<? echo $root;?>images/feedicon_28.png' border='0'; /></a>

		</div>


	</div>

</div>

<?
	require_once('../footer.php');
?>