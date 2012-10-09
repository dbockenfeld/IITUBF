<?php
	require_once('../config.php');
	require_once('../header.php');
	$base_dir = '../';
?>
<link rel="stylesheet" type="text/css" href="<? echo $root;?>media/gallery.css" media="all" />
<script type='text/javascript' src='../js/selectbiblestudy.js'></script>

		<section id="main">
<?php

	include $root.'side.php';

?>

<?php

$doc_order=$_GET['doc_order'];

switch ($doc_order) {
case "post_date":
	$order_by_clause="order by msgs.post_date desc";
	break;
case "title":
	$order_by_clause="order by msgs.title";
	break;
case "passage":
	$order_by_clause="order by msgs.short_description";
	break;
default:
    $order_by_clause="order by msgs.post_date desc";
	break;
}
?>

<div id='content'>

    <div id='contentb'>
		<img src='<? echo $root;?>images/bible_study-sbhdr.jpg' />
		<div id='contentc'>

 <!--<h1>Bible Study Materials</h1>-->

			<b>Message Manuscripts and Bible Study Questions</b>
			<br />
			<br />Filter Criteria:
			<br />

			Date: <select name='filter_dates' onchange='show_bible(this.value)'>
			<option value='Reset'>Select/Reset</option>
            <option value='Q107'>Jan-March 2007</option>
            <option value='Q207'>April-June 2007</option>
            <option value='Q307'>July-Sept 2007</option>
            <option value='Q407'>Oct-Dec 2007</option>
            <option value='Q108'>Jan-March 2008</option>
            <option value='Q208'>April-June 2008</option>
            <option value='Q308'>July-Sept 2008</option>
            <option value='Q408'>Oct-Dec 2008</option>
            <option value='Q109'>Jan-March 2009</option>
            <option value='Q209'>April-June 2009</option>
            <option value='Q309'>July-Sept 2009</option>
            <option value='Q409'>Oct-Dec 2009</option>
            </select>
            Scripture: <select name='filter_scripture' onchange='show_bible(this.value)'>
            <option value='Reset'>Select/Reset</option>
            <option value='Gen'>Genesis</option>
            <option value='1Sam'>I Samuel</option>
            <option value='Psalm'>Psalms</option>
            <option value='Mark'>Mark</option>
            <option value='Luke'>Luke</option>
            <option value='Acts'>Acts</option>
            <option value='Romans'>Romans</option>
            <option value='1Cor'>I Corinthians</option>
            <option value='Eph'>Ephesians</option>
            <option value='1Thes'>I Thesselonians</option>
            <option value='2Tim'>II Timothy</option>
            </select>
            Title: <select name='filter_title' onchange='show_bible(this.value)'>
            <option value='Reset'>Select/Reset</option>
            <option value='A'>A</option>
            <option value='B'>B</option>
            <option value='C'>C</option>
            <option value='D'>D</option>
            <option value='E'>E</option>
            <option value='F'>F</option>
            <option value='G'>G</option>
            <option value='H'>H</option>
            <option value='I'>I</option>
            <option value='J'>J</option>
            <option value='K'>K</option>
            <option value='L'>L</option>
            <option value='M'>M</option>
            <option value='N'>N</option>
            <option value='O'>O</option>
            <option value='P'>P</option>
            <option value='Q'>Q</option>
            <option value='R'>R</option>
            <option value='S'>S</option>
            <option value='T'>T</option>
            <option value='U'>U</option>
            <option value='V'>V</option>
            <option value='W'>W</option>
            <option value='X'>X</option>
            <option value='Y'>Y</option>
            <option value='Z'>Z</option>
            </select>

			<br />
			<br />
			<div id='biblestudy_frame'>
			<?php

				include 'all_docs.php';

			?>
			</div>


		</div>

	</div>

</div>

<?
	require_once('../footer.php');
?>