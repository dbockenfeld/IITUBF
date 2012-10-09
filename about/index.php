<?php
	require_once('../config.php');
	require_once('../header.php');
	$base_dir = '../';
?>
		<section id="main">
<?php

	include $root.'side.php';

?>


<div id='content'>

	<div id='contentb'>
		<img src='<? echo $root;?>images/about-sbhdr.jpg' />
		<div id='contentc' style="height:auto;">

            <!--<h1>About Us</h1>-->
        
            <br />
        
            <div id='sub_bar_right' >
                <a HREF='#' onClick='show_about("Beliefs");return false'>Beliefs</a>
            </div>
        
            <div id='sub_bar_right'>
                <a HREF='#' onClick='show_about("Mission");return false'>Mission</a>
            </div>
        
            <div id='sub_bar_right'>
                <a HREF='#' onClick='show_about("Works");return false'>Works</a>
            </div>
        
            <div id='sub_bar_right'>
                <a HREF='#' onClick='show_about("History");return false'>History</a>
            </div>
        
            <div id='sub_bar'>
                <a HREF='#' onClick='show_about("Staff");return false'>Staff</a>
            </div>
        
            <br />
            <br />
            <br />
        
            <div id="about_text">Select a category above.
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
        
            
            </div>

		</div>

	</div>


</div>

		</section>
		<script type="text/javascript">
	window.onload = show_about("Beliefs");
</script>

<?
	require_once('../footer.php');
?>