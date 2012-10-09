<html>
<head>
<link type="text/css" rel="stylesheet" media="all" href="../js/jquery-ui-1.8.16.custom/css/custom-theme/jquery-ui-1.8.16.custom.css"/>
<link type="text/css" rel="stylesheet" media="all" href="../js/jquery.jqGrid-4.3.1/css/ui.jqgrid.css"/>
<script type="text/javascript" src="../js/jquery-ui-1.8.16.custom/js/jquery-1.6.2.min.js"></script>
<!-- /* <script type="text/javascript" src="../js/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script> */ -->
<script type="text/javascript" src="../js/jquery.jqGrid-4.3.1/js/i18n/grid.locale-en.js"></script>
<script type="text/javascript" src="../js/jquery.jqGrid-4.3.1/js/jquery.jqGrid.min.js"></script>


<script>
$(document).ready(function(){
	$("#sermons").jqGrid({
	   	url:'view/view_sermons.php',
	   	height: "auto",
		datatype: "json",
	   	colNames:['ID','Sermon Date','Series','Book', 'Verses', 'Title','Summary','Author'],
	   	colModel:[
	   		{name:'id',index:'id', width:30},
	   		{name:'sermon_date',index:'sermon_date', width:70},
	   		{name:'series_id',index:'series_id', width:90},
	   		{name:'book_id',index:'book_id', width:90},
	   		{name:'verses',index:'verses', width:100},
	   		{name:'title',index:'title', width:200},
	   		{name:'summary',index:'summary', width:200},		
	   		{name:'author',index:'author', width:100},		
	   	],
	   	rowNum:20,
	   	rowList:[20,50,100],
	   	pager: '#sermon_pager',
	   	sortname: 'id',
	    viewrecords: true,
	    sortorder: "desc",
	    caption:"Sermons"
	});
	$("#sermon_pager").jqGrid('navGrid','#sermon_pager',{edit:true,add:true,del:true});
});
</script>

<style>
th, td {
	font-size: 11px;
}
</style>

<?php

?>

</head>
<body>

<table id="sermons"></table>
<div id="sermon_pager"></div>



</body>
</html>