<?php

		include '../db.php';

	$sql_xml_event_query = "select event_id, event_name, event_description, posted_date from events order by event_date desc limit 15";


	$sql_xml_events = mysql_query($sql_xml_event_query);
	if (!$sql_xml_events) {
    die('Invalid query: ' . mysql_error());
}

	$num_xml_events = mysql_num_rows($sql_xml_events);

	if($num_xml_events != 0) {

		$file=fopen("eventsfeed.xml","w");

		$_xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\r\n";

		$_xml .="<rss version=\"2.0\"
					xmlns:atom=\"http://www.w3.org/2005/Atom\">\r\n
				<channel>\r\n
				<title>IIT UBF Events</title>\r\n
				<atom:link href=\"http://www.iitubf.org/events/eventsfeed.xml\" rel=\"self\" type=\"application/rss+xml\" />\r\n
				<description>Latest event information from iitubf.org</description>\r\n
				<link>http://www.iitubf.org/events/</link>\r\n";

	for ($i=0; $i<$num_xml_events; $i++){		
		
		$events_xml_text = mysql_fetch_array($sql_xml_events);	

		$posted_date = strtotime($events_xml_text['posted_date']);

		$_xml .="<item>\r\n
				<title>".$events_xml_text['event_name']."</title>\r\n
				<description><![CDATA[".$events_xml_text['event_description']."]]></description>\r\n
				<link>/events/events.html?event_id=".$events_xml_text['event_id']."</link>\r\n
				<pubDate>".date('r', $posted_date)."</pubDate>\r\n
				<guid isPermaLink=\"false\">http://www.iitubf.org/events/events.html?event_id=".$events_xml_text['event_id']."</guid>\r\n
				</item>\r\n";
		}

	$_xml .="</channel>\r\n
			</rss>";

	fwrite($file, $_xml);

	fclose($file);

	echo "xml completed";

	}
	else {echo "no records found";}



?>