<?php
	require_once('config.php');
	require_once('header-home.php');
	
	require_once('db.php');
	
?>
		<section id="main">

			<aside id="featured">
				<div class="slider-wrapper theme-default">

				<div id="slider" class="nivoSlider">
    <?php
		$query  = 'SELECT *';
		$query .= '  FROM home_feature';
		$query .= ' WHERE active = 1 ORDER BY disp_order ASC';

		//echo $query; exit;

		$sql_front = mysql_query($query);
    

    	while ($front = mysql_fetch_array($sql_front)) {
    			if ($front['link']!=''){
    			echo '<a href="'.$front['link'].'">';
                echo '<img src="images/features/'.$front['image'].'" alt="" />';
                echo '</a>';
    			}
    			else {
                echo '<img src="images/features/'.$front['image'].'" alt="" />';
                }
		}

    ?>
<!--
				    <img src="images/features/daily-bread.jpg" alt="" />
				    <img src="images/features/johns-gospel.jpg" alt="" />
				    <img src="images/features/worship.jpg" alt="" />
				    <img src="images/features/2012keyverse.jpg" alt="" />
				    <img src="images/features/redemption-house.jpg" alt="" />
-->
				</div>
				</div>
			</aside>
<?php

	include $root.'side.php';

?>
<div id='content'>
<!--
<div id="rotator">
	<ul>
    <?php
		$query  = 'SELECT *';
		$query .= '  FROM front_page_rotator';
		$query .= ' WHERE active = 1 ORDER BY disp_order ASC';

		$sql_front = mysql_query($query);
    

    	while ($front = mysql_fetch_array($sql_front)) {
        	if ($front['disp_order']==1)
	            echo '<li class="show">';
            else
	            echo '<li class="">';
            if ($front['link'] == '') {
                echo '<img src="'. $baseDir.'images/'.$front['image'].'" />';
            }
            else {
                echo '<a href="'.$front['link'].'">';
                echo '<img src="'. $baseDir.'images/'.$front['image'].'" />';
                echo '</a>';
            }
            echo '</li>';
		}

    ?>
	</ul>
</div>
-->

		<?php
			include $baseDir.'key_verse.php';
        ?>

    <!--
<div id="mission">       
		The purpose of our ministry is to teach the Bible to college students and young people to help them live according to the teachings of the Scriptures and to practice the world mission command of Jesus (Acts 1:8).
		<br />
		<br />
		<span style='font-size: x-small;'>Learn more about us <a href='about_us/about_us.html'>here</a>.</span>
    </div>
    	<div id="db-front" style="padding:0px 0px 20px;">
		<a style="text-decoration:none" href="daily_bread/">
		<img src="<?echo $baseDir;?>images/db-front-hdr2.jpg">
		</a>
		</div>
-->


	<div id='blog-front'>
    	<div id='blog-front_title'>
        	Blog
			<a href='<? echo $root;?>blog/?feed=rss2' style='padding-left: 10px;'><img src="<?echo $root;?>images/feedicon_14.png" border='0'; /></a>
		</div>
        <div id='blog-front_text'>
			<?php 
				$blog_feed_contents = file_get_contents('http://www.iitubf.org/rssfeeds/rss2html.php?XMLFILE=http://iitubf.org/blog/?feed=rss2&TEMPLATE=http://www.iitubf.org/rssfeeds/blog_feed_template.html&MAXITEMS=3'); 

				echo $blog_feed_contents;
			?>
		</div>
        
    </div>
    
    <div id='events-front'>
    	<div id='events-front_title'>
	        Events
			<a href='http://www.iitubf.org/events/eventsfeed.xml' style='padding-left: 10px;'><img src="<?echo $root;?>images/feedicon_14.png" border='0'; /></a>
    	</div>
        <div id='events-front_text'>
			<?php 
				$event_feed_contents = file_get_contents('http://www.iitubf.org/rssfeeds/rss2html.php?XMLFILE=http://www.iitubf.org/events/eventsfeed.xml&TEMPLATE=http://www.iitubf.org/rssfeeds/blog_feed_template.html&MAXITEMS=3'); 

				echo $event_feed_contents;
			?>
        </div>
    </div>
</div>
</div>
		</section>
<?
	require_once('footer.php');
?>