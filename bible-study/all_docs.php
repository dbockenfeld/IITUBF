<?php

	include '../db.php';

	$q=$_GET['q'];
	$page = $_REQUEST['page'];
	$maxResults = 10; // Max Results per page


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
case "A":
	$filter_clause="where substr(title, 1, 1) = 'A'";
	break;
case "B":
	$filter_clause="where substr(title, 1, 1) = 'B'";
	break;
case "C":
	$filter_clause="where substr(title, 1, 1) = 'C'";
	break;
case "D":
	$filter_clause="where substr(title, 1, 1) = 'D'";
	break;
case "E":
	$filter_clause="where substr(title, 1, 1) = 'E'";
	break;
case "F":
	$filter_clause="where substr(title, 1, 1) = 'F'";
	break;
case "G":
	$filter_clause="where substr(title, 1, 1) = 'G'";
	break;
case "H":
	$filter_clause="where substr(title, 1, 1) = 'H'";
	break;
case "I":
	$filter_clause="where substr(title, 1, 1) = 'I'";
	break;
case "J":
	$filter_clause="where substr(title, 1, 1) = 'J'";
	break;
case "K":
	$filter_clause="where substr(title, 1, 1) = 'K'";
	break;
case "L":
	$filter_clause="where substr(title, 1, 1) = 'L'";
	break;
case "M":
	$filter_clause="where substr(title, 1, 1) = 'M'";
	break;
case "N":
	$filter_clause="where substr(title, 1, 1) = 'N'";
	break;
case "O":
	$filter_clause="where substr(title, 1, 1) = 'O'";
	break;
case "P":
	$filter_clause="where substr(title, 1, 1) = 'P'";
	break;
case "Q":
	$filter_clause="where substr(title, 1, 1) = 'Q'";
	break;
case "R":
	$filter_clause="where substr(title, 1, 1) = 'R'";
	break;
case "S":
	$filter_clause="where substr(title, 1, 1) = 'S'";
	break;
case "T":
	$filter_clause="where substr(title, 1, 1) = 'T'";
	break;
case "U":
	$filter_clause="where substr(title, 1, 1) = 'U'";
	break;
case "V":
	$filter_clause="where substr(title, 1, 1) = 'V'";
	break;
case "W":
	$filter_clause="where substr(title, 1, 1) = 'W'";
	break;
case "X":
	$filter_clause="where substr(title, 1, 1) = 'X'";
	break;
case "Y":
	$filter_clause="where substr(title, 1, 1) = 'Y'";
	break;
case "Z":
	$filter_clause="where substr(title, 1, 1) = 'Z'";
	break;

case "Q107":
	$filter_clause="where month(posted_date) between 1 and 3 and year(posted_date) = 2007";
	break;
case "Q207":
	$filter_clause="where month(posted_date) between 4 and 6 and year(posted_date) = 2007";
	break;
case "Q307":
	$filter_clause="where month(posted_date) between 7 and 9 and year(posted_date) = 2007";
	break;
case "Q407":
	$filter_clause="where month(posted_date) between 10 and 12 and year(posted_date) = 2007";
	break;
case "Q108":
	$filter_clause="where month(posted_date) between 1 and 3 and year(posted_date) = 2008";
	break;
case "Q208":
	$filter_clause="where month(posted_date) between 4 and 6 and year(posted_date) = 2008";
	break;
case "Q308":
	$filter_clause="where month(posted_date) between 7 and 9 and year(posted_date) = 2008";
	break;
case "Q408":
	$filter_clause="where month(posted_date) between 10 and 12 and year(posted_date) = 2008";
	break;
case "Q109":
	$filter_clause="where month(posted_date) between 1 and 3 and year(posted_date) = 2009";
	break;
case "Q209":
	$filter_clause="where month(posted_date) between 4 and 6 and year(posted_date) = 2009";
	break;
case "Q309":
	$filter_clause="where month(posted_date) between 7 and 9 and year(posted_date) = 2009";
	break;
case "Q409":
	$filter_clause="where month(posted_date) between 10 and 12 and year(posted_date) = 2009";
	break;

case "Gen":
	$filter_clause="where passage like ('%Gen%')";
	break;
case "1Sam":
	$filter_clause="where passage like ('%1Sam%')";
	break;
case "Psalm":
	$filter_clause="where passage like ('%Psalm%')";
	break;
case "Mark":
	$filter_clause="where passage like ('%Mark%')";
	break;
case "Luke":
	$filter_clause="where (passage like ('%Luke%') or passage like ('%Lk%'))";
	break;
case "Acts":
	$filter_clause="where passage like ('%Act%')";
	break;
case "Romans":
	$filter_clause="where (passage like ('%Roman%') or passage like ('%Ro%'))";
	break;
case "1Cor":
	$filter_clause="where (passage like ('%1 Cor%') or passage like ('%1Cor%'))";
	break;
case "Eph":
	$filter_clause="where passage like ('%Eph%')";
	break;
case "1Thes":
	$filter_clause="where passage like ('%Thes%')";
	break;
case "2Tim":
	$filter_clause="where (passage like ('%2 Tim%') or passage like ('%2Tim%'))";
	break;

default:
    $filter_clause=" ";
	break;
		}

	$order_by_clause="order by posted_date desc";

		
	$sql_doc_query2 = "select msgs.*,
       ques.filename as q_filename
from   (select a.title,
               a.description,
               a.short_description,
               date_format(a.post_date,'%Y-%m-%d') as post_date,
               a.filename,
               b.category_image_file
        from   posts a,
               category b
        where  a.category_id = 1
               and a.category_id = b.category_id) msgs
       inner join (select a.title,
                          a.description,
                          a.short_description,
                          a.post_date,
                          a.filename
                   from   posts a,
                          category b
                   where  a.category_id = 2
                          and a.category_id = b.category_id) ques
         on msgs.title = ques.title
            and msgs.short_description = ques.short_description ".$filter_clause." ".$order_by_clause;

			$sql_doc_query = "select title, passage, message_description, message_file, question_file, message_author, posted_date from messages ".$filter_clause." ".$order_by_clause;

//echo $sql_doc_query;

	$sql_message = mysql_query($sql_doc_query);
	if (!$sql_message) {
    die('Invalid query: ' . mysql_error());
}

	$num_messages = mysql_num_rows($sql_message);

	//echo $num_messages;

	// If there are more than $maxResults, we need to paginate this...
            $numPages = ceil($num_messages / $maxResults);

	if ($num_messages == 0) {
    echo "<br /><br />No Results Returned for ".$q."<br />";
	}
	else if ($q) {
    echo "Results for ".$q."<br />";
	}


            
            if($numPages > 1) {							
                echo "<div id='biblestudy_pages'>".Paginate($numPages,$page,$q)."</div><br />";
            }

	echo "<br /><i>(Messages are in order from the most recent dates first)</i>";
	

if(isset($page)) {
            $page_messages = (($page-1) * $maxResults);
			if ($num_messages > 0){
			mysql_data_seek($sql_message, $page_messages);
			}
        }

echo "
<br /> <div id='biblestudy_outer'>";

	for ($i=0; $i<$maxResults; $i++){		
		$message_text = mysql_fetch_array($sql_message);	

		
		if($page_messages >= $num_messages)
		{
			continue;
		}
				$page_messages+=1;
		//echo $page_messages;

			echo "
			<div id='biblestudy_color' onmouseover=\"style.backgroundColor='#ddd'\" onmouseout=\"style.backgroundColor='#fff'\">
			<div id='biblestudy_header'><a onclick=\"javascript:pageTracker._trackEvent('PDF','Download','". $message_passage." Sermon'); void(0);\" href='messages/".$message_text['message_file']."'>".$message_text['title']."</a>
			</div>
			<div id='biblestudy_desc'>".$message_text['message_description']."</div>
			<br />
			
			
			<div id='biblestudy_book'>".date('m-d-Y', strtotime($message_text['posted_date']))." | ".$message_text['passage']."
			</div>

			<div id='biblestudy_download'> Download: ";
			
				if (!is_null($message_text['message_file']) && trim($message_text['message_file'])!='') {
					echo "<a  onclick=\"javascript:pageTracker._trackEvent('PDF','Download','". $message_passage." Sermon'); void(0);\" href='messages/".$message_text['message_file']."'>Message</a>";
				}


	if (!is_null($message_text['question_file']) && trim($message_text['question_file'])!='') {

			if (!is_null($message_text['message_file']) && trim($message_text['message_file'])!='') {echo " | ";}

			echo "<a  onclick=\"javascript:pageTracker._trackEvent('PDF','Download','". $message_passage." Questions'); void(0);\" href='questions/".$message_text['question_file']."'>Questions</a>";
				}

			echo "</div>
			</div>
			<br />";
			
		}

echo "	
<div id='biblestudy_header'> </div>
</div>";

            if($numPages > 1) {							
                echo "<br /> <br /> <div id='biblestudy_pages'>".Paginate($numPages,$page,$q)."</div>";
            }

			echo "
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
";



	mysql_close($conn);

?>