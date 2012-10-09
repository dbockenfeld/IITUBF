<?php
/**
 * SELECT model for eBrochure Department
 * 
 * @author Daniel Lee <daniellee@northwestern.edu>
 * @version 1.0
 * @package main
 */
$base_dir = '../../../';
include $base_dir.'db.php';

//require_once('../../config.php');
//require_once('../check_session_view.php');

// connect to the default database
//$dbm = DBManager::getInstance();

// to the url parameter are added 4 parameters as described in colModel
// we shuld get these parameters to construct the needed query
// Since we point in the options of the grid that we will use a GET method we should use the
// appropriate command to obtain the parameters. In our case this is $_REQUEST. If we point that we
// want to use post we should use $_REQUEST. Maybe the better way is to use $_REQUEST, which
// contain booth the GET and POST variables. For more information refer to php documentation
// get the requested page. By default grid sets this to 1.
$page = $_REQUEST['page'];
// get how many rows we want to have into the grid - rowNum parameter in the grid
$limit = $_REQUEST['rows'];
// get index row - i.e. user click to sort. At first time sortname parameter -
// after that the index from colModel
$sidx = $_REQUEST['sidx'];
// sorting order - at first time sortorder
$sord = $_REQUEST['sord'];
// if we not pass at first time index use the first column for the index or what you want
if(!$sidx) $sidx =1;
// connect to the MySQL database server

// calculate the number of rows for the query. We need this to paging the result

$sql  = "SELECT COUNT(*) AS count ";
$sql .= "  FROM messages_dev ";

$result = mysql_query($sql) or die("Couldn t execute query.".mysql_error());
$row = mysql_fetch_array($result);


$count = $row['count'];
// calculation of total pages for the query
if( $count > 0 ) {
              $total_pages = ceil($count/$limit);
} else {
              $total_pages = 0;
}
// if for some reasons the requested page is greater than the total
// set the requested page to total page
if ($page > $total_pages) $page=$total_pages;
// calculate the starting position of the rows
$start = $limit*$page - $limit;
// if for some reasons start position is negative set it to 0
// typical case is that the user type 0 for the requested page
if($start <0) $start = 0;
// the actual query for the grid data

$sql  = "SELECT a.message_id, a.posted_date, a.book, a.passage, a.title, a.message_description, a.message_file, a.question_file";
$sql .= "  FROM messages_dev a ";
$sql .= " ORDER BY $sidx $sord ";
$sql .= " LIMIT $start, $limit ";

$result = mysql_query( $sql ) or die("Couldn t execute query.".mysql_error()); 
$responce->page = $page; 
$responce->total = $total_pages; 
$responce->records = $count; 
$i=0; 
while($row = mysql_fetch_array($result)) { 
	$responce->rows[$i]['id']=$row[id]; $responce->rows[$i]['cell']=array($row[message_id],$row[posted_date],$row[book],$row[passage],$row[title],$row[message_description],$row[message_file],$row[question_file]); $i++; 
} 

/*$i=0;
foreach($result as $row) {
    if ($row['ebr_file_id'] > 0)
    {
        //$url_cv_upload  = '<a href="#" onclick="window.open(\'adm_ebr_download.php?id='. $row['id'].'&category=ADD\',\'download\',\'width=300,height=150,toolbar=0\');return false">Download</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        $url_cv_upload  = '<a href="adm_ebr_download.php?id='. $row['id'].'&category=ADD" target="_new">View ('.round(($row['file_size']/1024),0).'K)</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
        $url_cv_upload .= '<a href="#" onclick="window.open(\'adm_ebr_upload.php?id='. $row['id'].'&category=ADD\',\'upload\',\'width=300,height=150,toolbar=0\');return false">Replace</a>';
    }
    else
        $url_cv_upload = '<a href="#" onclick="window.open(\'adm_ebr_upload.php?id='. $row['id'].'&category=ADD\',\'upload\',\'width=300,height=150,toolbar=0\');return false">Upload</a>';

    $responce->rows[$i]['id']=$row['id'];
    $responce->rows[$i]['cell']=array($row['name'],$row['display'],$url_cv_upload);
    $i++;
}    */    
echo json_encode($responce);
?>