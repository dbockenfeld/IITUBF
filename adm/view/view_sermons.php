<?php
require_once('../../db.php');

$page = $_GET['page']; // get the requested page
$limit = $_GET['rows']; // get how many rows we want to have into the grid
$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
$sord = $_GET['sord']; // get the direction
if(!$sidx) $sidx =1;
// connect to the database

$result = mysql_query("SELECT COUNT(*) AS count FROM sermons a");
$row = mysql_fetch_array($result,MYSQL_ASSOC);
$count = $row['count'];

if( $count >0 ) {
	$total_pages = ceil($count/$limit);
} else {
	$total_pages = 0;
}
if ($page > $total_pages) $page=$total_pages;
$start = $limit*$page - $limit; // do not put $limit*($page - 1)
$SQL = "SELECT a.id, a.sermon_date, b.title as series_id, c.name as book_id,a.verses, a.title, a.summary, a.author FROM sermons a LEFT OUTER JOIN series b ON a.series_id = b.id LEFT OUTER JOIN books c ON a.book_id = c.id ORDER BY $sidx $sord LIMIT $start , $limit";
$result = mysql_query( $SQL ) or die("Couldn t execute query.".mysql_error());

$responce->page = $page;
$responce->total = $total_pages;
$responce->records = $count;
$i=0;
while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
    $responce->rows[$i]['id']=$row[id];
    $responce->rows[$i]['cell']=array($row[id],$row[sermon_date],$row[series_id],$row[book_id],$row[verses],$row[title],$row[summary],$row[author]);
    $i++;
}        
echo json_encode($responce);
?>