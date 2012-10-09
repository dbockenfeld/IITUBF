<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="keywords" content="ubf,university bible fellowship, IIT, university,bible,fellowship,chicago,RSS, campus,mission,world,evangelical,student,organization" />
<META NAME="description" content="The University Bible Fellowship(UBF) is an international evangelical student organization with emphasis on world mission.">
<title>University Bible Fellowship at IIT</title>
<link rel='stylesheet' type='text/css' href='../iitubf.css' />
<link rel='stylesheet' type='text/css' href='../js/jquery/themes/iitubf/jquery-ui-1.8.5.custom.css' />
<link rel='stylesheet' type='text/css' href='../js/jquery/css/ui.jqgrid.css' />
<link rel='stylesheet' type='text/css' href='../js/jquery/src/css/jquery.searchFilter.css' />
<script type="text/javascript" src="../js/jquery/js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../js/jquery/js/jquery-ui-1.8.5.custom.min.js"></script>
<script type="text/javascript" src="../js/jquery/js/i18n/grid.locale-en.js"></script>
<script type="text/javascript" src="../js/jquery/js/jquery.jqGrid.min.js"></script>
<script type="text/javascript" src="../js/jquery/src/jquery.searchFilter.js"></script>
<script type="text/javascript" src="../js/jquery/src/jqModal.js"></script>
<script type="text/javascript" src="../js/jquery/src/jqDnR.js"></script>
<?php
/**
 * Set path to the www root
 */
$base_dir = '../';
include $base_dir.'db.php';

/**
 * Set path to the includes directory
 */
//$includes_dir = '../includes/';

/**
 * Set page title
 */
//$page_title = 'Administration > Additional Information';

/**
 * Set style sheet
 */
/*$stylesheets = array (
	'universal.css'
);
*/
/**
 * Set style for jqGrid
 */
/*$themes = array(
	'basic/grid.css',
	'jqModal.css'
);
*/
/**
 * Set Java Scripts
 */
/*$javascript = array(
    'jquery.js',
    'jquery.jqGrid.js',
    'js/jqModal.js',
    'js/jqDnR.js'
);
*/
/**
 * Header
 */
//include ($base_dir.'header.php');

?>

<!-- JavaScript start -->
<script language="JavaScript">

$(document).ready(function(){
    jQuery("#jq_messages").jqGrid({
        url:'models/admin/m_messages_view.php',
        datatype: 'json',
        colNames:['ID', 'Date', 'Book', 'Passage', 'Title', 'Message Description', 'Message File', 'Question File'],
        colModel :[
			{name:'message_id', index:'message_id', width:50, hidden:true},
			{name:'posted_date',index:'posted_date', width:62,align:'left',editable:false},
			{name:'book',index:'book', width:100,align:'left',editable:true},
			{name:'passage',index:'passage', width:100,align:'left',editable:true},
            {name:'title',index:'title',width:200,align:'left',editable:true,editoptions:{size:25}},
            {name:'message_description',index:'message_description', width:300,align:'left',sortable:false,editable:true,edittype:"textarea", editoptions:{rows:"5",cols:"50"}},
			{name:'message_file',index:'message_file',width:100,sortable:false,editable:true},
			{name:'question_file',index:'question_file',width:100,sortable:false,editable:true}
            ],
        pager: '#jq_page', 
        rowNum:20,
        rowList:[10,20,100],
        sortname: 'message_id',
        sortorder: 'desc',
        viewrecords: true,
		editurl: 'models/admin/m_messages.update.php',
		height: "100%",
        caption: 'Messages'
    });
	jQuery("#jq_messages").jqGrid('navGrid','#jq_page',
		{search:false},
		{width:500,reloadAfterSubmit:true},
		{width:500,reloadAfterSubmit:true},
		{reloadAfterSubmit:true},
		{}
	); 
});

</script>
</head>

<body>

<div id='wrap'><div id='headerimg'>
<div class='homelink'><a href='http://www.iitubf.org'></a></div>
</div>

<?php

	include 'menu.php';

?>

<div id='submenu'>

</div>


<div id='content'>

<h1>IIT UBF Admin Site - Add/Edit Messages</h1>



<!-- Edit start -->
<table id="jq_messages"></table> 
<div id="jq_page"></div>

</div>
<!-- Content end -->
<?php 
/**
 * Footer
 */
?>
<div id='foot'>
	<span style='color:white;'>
		<?php echo $footer_text; ?>
	</span>
</div>


</div>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-5732686-1");
pageTracker._trackPageview();
</script>

</body>
</html>
