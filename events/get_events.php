<?php
	

include '../db.php';

	$q=$_GET['q'];
	$eid=$_GET['event_id'];
	$page = $_REQUEST['page'];
	$maxResults = 4; // Max Results per page


	function Paginate($numPages,$currentPage,$filter) {
	// Create page links
	
	$s = "<ul class='page-nav'>\n";
	for($p=1;$p<=$numPages;$p++) {
		$class = "";
		
		// Current page?
		if($p == $currentPage) {
			$class = " class='selected'";
		}
		$s .= "<li".$class.">";
		$s .= "<a href='?page=".$p."&q=".$filter."'>".$p."</a></li>\n";
	}
	$s .= "</ul>\n";
	return $s;
}

	if(!isset($page)) {
	$page=1;
}


	switch ($q) {
case "1":
	$filter_clause="where event_type_id = 1";
	break;
case "2":
	$filter_clause="where event_type_id = 2";
	break;
case "3":
	$filter_clause="where event_type_id = 3";
	break;
case "4":
	$filter_clause="where event_type_id = 4";
	break;

case "S109":
	$filter_clause="where month(events.event_date) between 1 and 6 and year(events.event_date) = 2009";
	break;
case "S209":
	$filter_clause="where month(events.event_date) between 7 and 12 and year(events.event_date) = 2009";
	break;

default:
    $filter_clause=" ";
	break;
		}

	if ($eid) {
		$filter_clause="where event_id = ".$eid;
	}

	$sql_event_query = "select event_id, event_name, event_day, event_date, event_time, event_place, event_description, event_banner, events.event_type, posted_date, event_type_id from events left join event_type on events.event_type = event_type.event_type ".$filter_clause." order by event_date desc";

	$sql_events = mysql_query($sql_event_query);
	if (!$sql_events) {
    die('Invalid query: ' . mysql_error());
}

	$num_events = mysql_num_rows($sql_events);

	// If there are more than $maxResults, we need to paginate this...
            $numPages = ceil($num_events / $maxResults);

	if ($num_events == 0 ){
		echo "No Results Returned <br /><br /><br /><br /><br /><br /><br /><br /><br />";
		exit;
	}


 if($numPages > 1) {	
	 
	echo "<i>(There are 4 events per page with the most recent events first)</i>";
	echo "<div id='event_pages'>".Paginate($numPages,$page,$q)."</div><br />";
	if(isset($page)) {
		$page_messages = (($page-1) * $maxResults);
		if ($num_events > 0){
		mysql_data_seek($sql_events, $page_messages);
	}
 }



for ($i=0; $i<$maxResults; $i++){		
		
		$events_text = mysql_fetch_array($sql_events);	

		$event_date = strtotime($events_text['event_date']);
		$today = strtotime(date("Y-m-d"));
	if ($events_text['event_name'] != '') {
	echo "<img id='event_img' src = '../images/events/".$events_text['event_banner']."' />
	<br />
	<b>What: </b>".$events_text['event_name']." ";
	
	if ($event_date > $today){
	echo "<span style='color: red; font-weight: bold; background: yellow;'>Upcoming Event!</span>";
	}

	echo "<br /><b>When: </b>".$events_text['event_day'].", ".date('F j, Y', $event_date)." ".$events_text['event_time']."
	<br /><b>Where: </b>".$events_text['event_place']."
	<br /><b>Type: </b>".$events_text['event_type']."
	<br />
	<br /><b>Description:</b>".$events_text['event_description']."
	<br />
	<br />
	<br />
	<br />";
	}
	}
 if($numPages > 1) {							
                echo "<br /> <br /> <div id='event_pages'>".Paginate($numPages,$page,$q)."</div>";
            }
 }


if($numPages == 1) {							

for ($i=0; $i<$num_events; $i++){		
		
		$events_text = mysql_fetch_array($sql_events);	

		$event_date = strtotime($events_text['event_date']);
		$today = strtotime(date("Y-m-d"));

	echo "<img id='event_img' src = '../images/events/".$events_text['event_banner']."' />
	<br />
	<b>What: </b>".$events_text['event_name']." ";
	
	if ($event_date > $today){
	echo "<span style='color: red; font-weight: bold; background: yellow;'>Upcoming Event!</span>";
	}

	echo "<br /><b>When: </b>".$events_text['event_day'].", ".date('F j, Y', $event_date)." ".$events_text['event_time']."
	<br /><b>Where: </b>".$events_text['event_place']."
	<br /><b>Type: </b>".$events_text['event_type']."
	<br />
	<br /><b>Description:</b>".$events_text['event_description']."
	<br />
	<br />
	<br />
	<br />";
	
	}

 }


?>