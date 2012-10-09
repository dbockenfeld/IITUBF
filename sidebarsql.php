<?php

	$sql_message = mysql_query("SELECT title, passage, message_description, message_file, question_file, posted_date from messages order by posted_date desc limit 0,1");
	$sql_prayer_topics = mysql_query("select prayer_topics, updated_date from prayer_topics");
	$sql_bible_club_meeting = mysql_query("select bible_club_meeting_location, bible_club_meeting_day, bible_club_meeting_time from bible_club_meeting");
	$sql_bible_club_detail = mysql_query("select bible_club_meeting_date, bible_club_meeting_description from bible_club_detail");
	$sql_flash_file = mysql_query("select main_page_flash_file, associated_event from main_page_flash join active_flash_file on main_page_flash_id = active_flash_file");


	$message_text = mysql_fetch_array($sql_message);
	//$question_text = mysql_fetch_array($sql_question);
	$prayer_topic_text = mysql_fetch_array($sql_prayer_topics);
	$bible_club_meeting_text = mysql_fetch_array($sql_bible_club_meeting);
	$bible_club_detail_text = mysql_fetch_array($sql_bible_club_detail);	
	$flash_file_text = mysql_fetch_array($sql_flash_file);

	$prayer_topics = $prayer_topic_text['prayer_topics'];
	$prayer_topics_updated_date = $prayer_topic_text['updated_date'];

	$bc_loc = $bible_club_meeting_text['bible_club_meeting_location'];
	$bc_day = $bible_club_meeting_text['bible_club_meeting_day'];
	$bc_time = $bible_club_meeting_text['bible_club_meeting_time'];
	$bc_week = $bible_club_detail_text['bible_club_meeting_date'];
	$iitbc_announce = $bible_club_detail_text['bible_club_meeting_description'];


	$message_title = $message_text['title'];
	$message_description = $message_text['message_description'];
	$message_passage = $message_text['passage'];
	$message_date = $message_text['posted_date'];
	$message_file = $message_text['message_file'];
	$message_category = "Messages";

	$question_description = "Questions for ".$message_passage;
	$question_file = $message_text['question_file'];
	$question_category = "Questions";

	$flash_file = $flash_file_text['main_page_flash_file'];
	$associated_event = $flash_file_text['associated_event'];

	$ws_info = "Sundays 10am<br />IIT Carr Memorial Chapel";

	$footer_text = "IIT University Bible Fellowship ".date('Y');


?>